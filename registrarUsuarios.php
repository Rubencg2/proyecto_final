<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioVerificacion.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
    include("conexion_bd.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    if (isset($_POST["email"])) {
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $contrasena = $_POST["contrasena"];
        $confirmarC = $_POST["confirmarC"];

        if ($contrasena !== $confirmarC) {
            header("Location: registro.php?error_contrasena=1");
            exit();
        }

        $_SESSION['tmp_registro'] = [
            'nombre' => $nombre,
            'email' => $email,
            'contrasena' => password_hash($contrasena,PASSWORD_DEFAULT),
        ];

        $consultaUsuarios = "SELECT * FROM usuarios WHERE email='$email'";
        $datos = $conn->query($consultaUsuarios);

        if($datos->num_rows!=0){
            header("Location: registro.php?error3=1");
            exit();
        }
        
        $codigoAleatorio = random_int(10000, 99999);
        $expiracion = date("Y-m-d H:i:s", strtotime('+10 minutes'));

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

                            Gracias por registrarte en La Casa del Futbol. Para terminar de configurar tu cuenta, solo necesitas ingresar este código:

                            <h2>'.$codigoAleatorio.'</h2>

                            Introduce este código en la aplicación para completar el proceso. Este código caducará en 10 minutos.<br>

                            El equipo de La Casa del Futbol';

        if(!$mail->send()){
            echo "Error al enviar el correo: " . $mail->ErrorInfo;
            exit();
        }
    }
        include("cabecera.php");
        ?>
        <div class="centrado">
            <div class="card2">
                <span class="card2__title">Verifica tu codigo</span>
                <p class="card2__content">Pega aqui el codigo que hemos enviado a tu correo electronico para completar el registro
                </p>
                <div class="card2__form">
                    <form action="registrarUsuarios.php" method="post">
                        <input placeholder="Tu código" type="text" name="codigo">
                        <button class="sign-up2" name="verificar">Verificar</button>
                    </form>
                </div>
            </div>
        </div>





    <?php
    if(isset($_POST["verificar"])){
        $codigo_introducido = trim($_POST['codigo']);
        $emailS = $_SESSION['tmp_registro']['email'];
        $fechaActual = date("Y-m-d H:i:s");

        $consultaVerificacion = "SELECT * FROM verificaciones WHERE email='$emailS' AND codigo='$codigo_introducido' AND expiracion>'$fechaActual'";
        $usuarioVerificacion = $conn->query($consultaVerificacion);

        if($usuarioVerificacion->num_rows!=0){
            $u = $_SESSION["tmp_registro"];
            $nombreT = $u["nombre"];
            $emailT = $u["email"];
            $contrasenaHashT = $u["contrasena"];
            $fecha = date("Y-m-d");

            $consultaRegistro = "INSERT INTO usuarios (nombre,email,contrasena,fecha_registro) VALUES ('$nombreT','$emailT','$contrasenaHashT','$fecha')";
            $eliminarVerificacion = "DELETE FROM verificaciones WHERE email='$emailT'";
            $conn->query($eliminarVerificacion);

            if($conn->query($consultaRegistro)){
                unset($_SESSION['tmp_registro']);
                header("Location: login.php?correcto=1");
                exit();
            }  

            $usuarioV =$usuarioVerificacion->fetch_assoc();
            if($fechaActual<$usuarioV["expiracion"]){
                $eliminarVerificacionI = "DELETE FROM verificaciones WHERE email='$emailT'";
                $conn->query($eliminarVerificacionI);
            }
        } else {
            echo "Codigo invalido o expirado";
        }
    }
        
        
     

$conn->close();
?>
<script src="./JS/script.js"></script>
</body>
</html>