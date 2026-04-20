<?php 
/*session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioVerificacion.css">
    <link rel="stylesheet" href="./CSS/formularioActualizarC.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    ?>
    <div class="general2">
        <?php
        include("cabecera.php");
        ?>
        <div class="productos">
            <?php
            include("conexion_bd.php");

                ?>
                <div class="generalActualizar">
                    <?php if(!isset($_SESSION['temp_codigo']) || !isset($_SESSION['temp_verificar'])){ ?>
                        <div class="recibirCodigo <?php echo isset($_POST['codigo']) ? 'ocultar' : ''; ?>" id="recibirCodigo" >
                            <h3>Verifica tu cuenta</h3>
                            <p>Para proteger la seguridad de tu cuenta, necesitamos verificar tu identidad.</p>
                            <form action="contrasenaOlvidada.php" method="post">
                                <label>Correo Electronico</label>
                                <input type="email" name="email" required>
                                <button class="btn-azul" name="codigo" id="codigo">Recibir codigo por email</button>
                            </form>
                        </div>
                        <?php
                        }
                        ?>
                </div>
                <?php
            
            

            if(isset($_POST["codigo"])){

                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';

                $_SESSION["temp_codigo"] = 1;

                $codigoAleatorio = random_int(10000, 99999);
                $expiracion = date("Y-m-d H:i:s", strtotime('+10 minutes'));
                $email = $_POST["email"];
                $nombre = $_POST["email"];

                $_SESSION["email"] = $email;

                $eliminarVerificacion1 = "DELETE FROM verificaciones WHERE email='$email'";
                $conn->query($eliminarVerificacion1);

                $insertarVerificacion = "INSERT INTO verificaciones (email,codigo,expiracion) VALUES ('$email','$codigoAleatorio','$expiracion')";
                $conn->query($insertarVerificacion);

                // CONFIGURACION DE ENVIAR CORREO
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'noreply.lacasadelfutbol@gmail.com';
                $mail->Password   = 'tkgocjbtekwhfwvh';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                // Destinatarios y contenido
                $mail->setFrom('noreply.lacasadelfutbol@gmail.com', 'La casa del futbol');
                $mail->addAddress($email, $nombre);
                $mail->isHTML(true);
                $mail->Subject = 'Codigo de verificacion';
                $mail->Body    = '¡Hola!<br>

                                    Verifica que eres tu, introduce el siguiente codigo:

                                    <h2>'.$codigoAleatorio.'</h2>

                                    Este código caducará en 10 minutos.<br>

                                    El equipo de La Casa del Futbol';

                if($mail->send()){
                    ?>
                    <div class="centrado" id="seccionVerificar">
                        <div class="card2">
                            <span class="card2__title">Verifica tu codigo</span>
                            <p class="card2__content">Pega aqui el codigo que hemos enviado a tu correo electronico para verificar que eres tu
                            </p>
                            <div class="card2__form">
                                <form action="contrasenaOlvidada.php" method="post">
                                    <input placeholder="Tu código" type="text" name="codigoV">
                                    <button class="sign-up2" name="verificar">Verificar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    echo "Error al enviar el correo: ";
                    exit();
                }

            }

            if(isset($_POST["verificar"])){
                $_SESSION["temp_verificar"] = 1;
                $email = $_SESSION["email"];
                $fechaActual = date("Y-m-d H:i:s");
                $codigo_introducido = trim($_POST['codigoV']);

                $consultaCodigo = "SELECT * FROM verificaciones WHERE email='$email' AND expiracion>'$fechaActual' AND codigo='$codigo_introducido'";
                $datos = $conn->query($consultaCodigo);
                if($datos->num_rows!=0){
                    $_SESSION["verificado"] = true;
                    ?>
                    <div class="container">
                        <div class="form_area">
                        <p class="title">Cambiar contrasena</p>
                        <?php
                            if(isset($_GET["correcto"])){
                                ?><h2 class="mensajeOkey">contrasena actualizada correctamente</h2><?php
                            }
                            if(isset($_GET["iguales"])){
                                ?><h2 class="mensajeError">La nueva contrasena no puede ser igual a la anterior</h2><?php
                            }
                            if(isset($_GET["error"])){
                                ?><h2 class="mensajeError">No se a podido actualizar la contrasena</h2><?php
                            }
                            if(isset($_GET["iguales2"])){
                                ?><h2 class="mensajeError">Las contrasenas no coinciden</h2><?php
                            }
                            ?>
                        <form action="contrasenaOlvidada.php" method="post">   
                            <div class="form_group">
                                <label class="sub_title" for="nuevaC">Nueva contrasena</label>
                                <input id="nuevaC" name="nuevaC" class="form_style" type="password" required>
                            </div>
                            <div class="form_group">
                                <label class="sub_title" for="password">Repite nueva contrasena</label>
                                <input id="password" name="nuevaC2" class="form_style" type="password" required>
                            </div>
                            <div>
                                <button class="btn" name="cambiar">Cambiar contrasena</button>
                            </a></div>
                        
                        </form></div>
                    </a></div>
                    <?php
                } else {
                    echo "codigo incorrecto o expirado";
                }
            }
            if(isset($_POST["cambiar"]) || isset($_SESSION["temp_verificar"])){
                        $email = $_SESSION["email"];
                        $nuevacontrasena = $_POST["nuevaC"];
                        $nuevacontrasena2 = $_POST["nuevaC2"];
                        $consultacontrasena = "SELECT * FROM usuarios WHERE email='$email'";
                        $datosC = $conn->query($consultacontrasena);
                        $fila = $datosC->fetch_assoc();
                        $contrasena = $fila["contrasena"];

                        if(password_verify($nuevacontrasena,$contrasena)){
                            header("Location: contrasenaOlvidada.php?iguales=1");
                            exit();
                        } else {
                            if($nuevacontrasena!==$nuevacontrasena2){
                                header("Location: contrasenaOlvidada.php?iguales2=1");
                                exit();
                            } else{
                                $nuevacontrasenaHash = password_hash($nuevacontrasena, PASSWORD_DEFAULT);
                                $cambiarcontrasena = "UPDATE usuarios SET contrasena='$nuevacontrasenaHash' WHERE email='$email'";
                                if($conn->query($cambiarcontrasena)){
                                    // unset($_SESSION["email"]);
                                    // unset($_SESSION["temp_verificar"]);
                                    // unset($_SESSION["temp_codigo"]);
                                    header("Location: contrasenaOlvidada.php?correcto=1");
                                    exit();
                                } else {
                                    header("Location: contrasenaOlvidada.php?error=1");
                                    exit();
                                }
                            }
                            
                        }
                        unset($_SESSION["email"]);
                        // unset($_SESSION["temp_verificar"]);
                        unset($_SESSION["temp_codigo"]);
                    }
            ?>
            </div>
            <?php
            include("footer.html");
        ?>
        </div>
        <script src="./JS/script.js"></script>
</body>
</html>*/



session_start();
include("conexion_bd.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST["codigo"])){
    $email = $_POST["email"];

    // 1 COMPROBACIÓN DE SI EXISTE EL USUARIO
    $buscarUsuario = "SELECT * FROM usuarios WHERE email='$email'";
    $resultadoBusqueda = $conn->query($buscarUsuario);

    if($resultadoBusqueda->num_rows == 0) {
        // El correo no está registrado
        $error_registro = "El correo electrónico introducido no coincide con ninguna cuenta.";
    } else {
        // El correo SI existe
        $_SESSION["temp_codigo"] = 1;
        $codigoAleatorio = random_int(10000, 99999);
        $expiracion = date("Y-m-d H:i:s", strtotime('+10 minutes'));
        $_SESSION["email"] = $email;

        $eliminarVerificacion1 = "DELETE FROM verificaciones WHERE email='$email'";
        $conn->query($eliminarVerificacion1);

        $insertarVerificacion = "INSERT INTO verificaciones (email,codigo,expiracion) VALUES ('$email','$codigoAleatorio','$expiracion')";
        $conn->query($insertarVerificacion);

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply.lacasadelfutbol@gmail.com';
        $mail->Password   = 'tkgocjbtekwhfwvh'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('noreply.lacasadelfutbol@gmail.com', 'La casa del futbol');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Codigo de verificacion';
        $mail->Body    = '¡Hola!<br>Introduce el siguiente codigo: <h2>'.$codigoAleatorio.'</h2>Este código caducará en 10 minutos.';

        if(!$mail->send()){
            echo "Error al enviar el correo";
            exit();
        }
    }
}

// 2- VERIFICAMOS EL CODIGO
if(isset($_POST["verificar"])){
    $email = $_SESSION["email"];
    $fechaActual = date("Y-m-d H:i:s");
    $codigo_introducido = trim($_POST['codigoV']);

    $consultaCodigo = "SELECT * FROM verificaciones WHERE email='$email' AND expiracion>'$fechaActual' AND codigo='$codigo_introducido'";
    $datos = $conn->query($consultaCodigo);
    
    if($datos->num_rows != 0){
        $_SESSION["temp_verificar"] = 1; 
        unset($_SESSION["temp_codigo"]); 
    } else {
        $error_msg = "Código incorrecto o expirado";
    }
}

// 3- ACTUALIZAMOS CONTRASEÑA
if(isset($_POST["cambiar"])){
    $email = $_SESSION["email"];
    $nuevacontrasena = $_POST["nuevaC"];
    $nuevacontrasena2 = $_POST["nuevaC2"];

    $consultacontrasena = "SELECT * FROM usuarios WHERE email='$email'";
    $datosC = $conn->query($consultacontrasena);
    $fila = $datosC->fetch_assoc();
    $contrasena_actual = $fila["contrasena"];

    if(password_verify($nuevacontrasena, $contrasena_actual)){
        header("Location: contrasenaOlvidada.php?iguales=1");
        exit();
    } elseif($nuevacontrasena !== $nuevacontrasena2){
        header("Location: contrasenaOlvidada.php?iguales2=1");
        exit();
    } else {
        $nuevacontrasenaHash = password_hash($nuevacontrasena, PASSWORD_DEFAULT);
        $cambiarcontrasena = "UPDATE usuarios SET contrasena='$nuevacontrasenaHash' WHERE email='$email'";
        if($conn->query($cambiarcontrasena)){
            session_destroy(); 
            header("Location: contrasenaOlvidada.php?correcto=1");
            exit();
        } else {
            header("Location: contrasenaOlvidada.php?error=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioVerificacion.css">
    <link rel="stylesheet" href="./CSS/formularioActualizarC.css">
</head>
<body>
    <div class="general2">
        <?php include("cabecera.php"); ?>
        <div class="productos">
            <div class="generalActualizar">

                <?php if(!isset($_SESSION['temp_codigo']) && !isset($_SESSION['temp_verificar']) && !isset($_GET['correcto'])){ ?>
                    <div class="recibirCodigo" id="recibirCodigo">
                        <h3>Verifica tu cuenta</h3>
                        <p>Necesitamos verificar tu identidad.</p>
                        
                        <?php if(isset($error_registro)) {
                            ?><p class="mensajeError"><?=$error_registro?></p>
                            <?php
                        }
                            
                        ?>
                        <form action="contrasenaOlvidada.php" method="post">
                            <label>Correo Electronico</label>
                            <input type="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                            <button class="btn-azul" name="codigo">Recibir código por email</button>
                        </form>
                    </div>
                <?php } ?>

                <?php if(isset($_SESSION['temp_codigo'])){ ?>
                    <div class="centrado" id="seccionVerificar">
                        <div class="card2">
                            <span class="card2__title">Verifica tu codigo</span>
                            <p class="card2__content">Introduce el código enviado a tu email</p>
                            <?php if(isset($error_msg)){
                                ?><p class="mensajeError"><?=$error_msg?></p><?php
                            } 
                            ?>
                            <div class="card2__form">
                                <form action="contrasenaOlvidada.php" method="post">
                                    <input placeholder="Tu código" type="text" name="codigoV" required>
                                    <button class="sign-up2" name="verificar">Verificar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($_SESSION['temp_verificar'])){ ?>
                    <div class="container">
                        <div class="form_area">
                            <p class="title">Cambiar contrasena</p>
                            <?php
                                if(isset($_GET["iguales"])) echo "<h2 class='mensajeError'>La nueva contrasena no puede ser igual a la anterior</h2>";
                                if(isset($_GET["iguales2"])) echo "<h2 class='mensajeError'>Las contrasenas no coinciden</h2>";
                                if(isset($_GET["error"])) echo "<h2 class='mensajeError'>No se ha podido actualizar</h2>";
                            ?>
                            <form action="contrasenaOlvidada.php" method="post">   
                                <div class="form_group">
                                    <label class="sub_title">Nueva contrasena</label>
                                    <input name="nuevaC" class="form_style" type="password" required>
                                </div>
                                <div class="form_group">
                                    <label class="sub_title">Repite nueva contrasena</label>
                                    <input name="nuevaC2" class="form_style" type="password" required>
                                </div>
                                <button class="btn" name="cambiar">Cambiar contrasena</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($_GET["correcto"])){ ?>
                    <div class="centrado">
                        <h2 class="mensajeOkey">Contrasena actualizada correctamente</h2>
                        <br>
                        <a href="login.php" class="btn btn-primary">Ir al Login</a>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php include("footer.html"); ?>
    </div>
</body>
</html>