<?php 
session_start();
if (isset($_POST['nombre'])) $_SESSION['temp_nombre'] = $_POST['nombre'];
if (isset($_POST['telefono'])) $_SESSION['temp_telefono'] = $_POST['telefono'];
if (isset($_POST['direccion'])) $_SESSION['temp_direccion'] = $_POST['direccion'];
if (isset($_POST['direccion'])) $_SESSION['temp_provincia'] = $_POST['provincia'];
if (isset($_POST['direccion'])) $_SESSION['temp_municipio'] = $_POST['municipio'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioVerificacion.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include("conexion_bd.php");

    if(isset($_SESSION["email"])){
        ?>
        <div class="general2">
            <div class="productos">
                <div class="generalActualizar">
                    <?php if(!isset($_POST['codigo']) && !isset($_POST['verificar'])){ ?>
                        <div class="recibirCodigo <?php echo isset($_POST['codigo']) ? 'ocultar' : ''; ?>" id="recibirCodigo" >
                            <h3>Verifica tu cuenta</h3>
                            <p>Para proteger la seguridad de tu cuenta, necesitamos verificar tu identidad.</p>
                            <form action="actualizarDatos.php" method="post">
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

                    $codigoAleatorio = random_int(10000, 99999);
                    $expiracion = date("Y-m-d H:i:s", strtotime('+10 minutes'));
                    $email = $_SESSION["email"];
                    $nombre = $_SESSION["nombreUsuario"];

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
                                    <form action="actualizarDatos.php" method="post">
                                        <input placeholder="Tu código" type="text" name="codigoV">
                                        <button class="sign-up2" name="verificar">Verificar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                        echo "Error al enviar el correo: " . $mail->ErrorInfo;
                        exit();
                    }

                }

                if(isset($_POST["verificar"])){
                    $email = $_SESSION["email"];
                    $id = $_SESSION["id_usuario"];
                    $fechaActual = date("Y-m-d H:i:s");
                    $codigo_introducido = trim($_POST['codigoV']);

                    $consultaCodigo = "SELECT * FROM verificaciones WHERE email='$email' AND expiracion>'$fechaActual'";
                    $datos = $conn->query($consultaCodigo);
                    if($datos->num_rows!=0){
                        // Actualizacion de nombre
                        if(isset($_SESSION["temp_nombre"])){
                            $nombreA = $_SESSION["temp_nombre"];
                            $actualizarNombre = "UPDATE usuarios SET nombre='$nombreA' WHERE id='$id'";
                            if($conn->query($actualizarNombre)){
                                ?><h3>Nombre actualizado correctamente</h3><?php
                                unset($_SESSION["temp_nombre"]);
                            } else {
                                ?><h3>Error al cambiar el nombre</h3><?php
                            }
                        }

                        

                        // Actualizacion de telefono
                        if(isset($_SESSION['temp_telefono'])){
                            $telefonoA = $_SESSION['temp_telefono'];
                            $actualizarTelefono = "UPDATE usuarios SET telefono='$telefonoA' WHERE id='$id'";
                            if($conn->query($actualizarTelefono)){
                                ?><h3>Telefono actualizado correctamente</h3><?php
                                unset($_SESSION["temp_telefono"]);
                            } else {
                                ?><h3>Error al cambiar el telefono</h3><?php
                            }
                        }

                        // Actualizacion de direccion
                        if(isset($_SESSION['temp_direccion'])){
                            $direccionA = $_SESSION['temp_direccion'];
                            $actualizarDireccion = "UPDATE usuarios SET direccion='$direccionA' WHERE id='$id'";
                            if($conn->query($actualizarDireccion)){
                                ?><h3>Direccion actualizada correctamente</h3><?php
                                unset($_SESSION["temp_direccion"]);
                            } else {
                                ?><h3>Error al cambiar la direccion</h3><?php
                            }
                        }

                        // Actualizacion de provincia
                        if(isset($_SESSION['temp_provincia'])){
                            $provinciaA = $_SESSION['temp_provincia'];
                            $actualizarProvincia = "UPDATE usuarios SET provincia='$provinciaA' WHERE id='$id'";
                            if($conn->query($actualizarProvincia)){
                                ?><h3>Provincia actualizada correctamente</h3><?php
                                unset($_SESSION["temp_provincia"]);
                            } else {
                                ?><h3>Error al cambiar la provincia</h3><?php
                            }
                        }

                        // Actualizacion de municipio
                        if(isset($_SESSION['temp_municipio'])){
                            $municipioA = $_SESSION['temp_municipio'];
                            $actuualizarMunicipio = "UPDATE usuarios SET municipio='$municipioA' WHERE id='$id'";
                            if($conn->query($actuualizarMunicipio)){
                                ?><h3>Municipio actualizado correctamente</h3><?php
                                unset($_SESSION["temp_municipio"]);
                            } else {
                                ?><h3>Error al cambiar el municipio</h3><?php
                            }
                        }

                        header("Location: paginaUsuario.php");
                    } else {
                        echo "Codigo incorrecto o expirado";
                    }
                }
                
            ?>
            </div>
            <?php
            include("footer.html");
        ?>
        </div>
        <script src="./JS/script.js"></script>
        <?php
    } else {
        header("Location: index.php");
    }
    
    ?>
</body>
</html>