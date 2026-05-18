<?php
session_start();
include("conexion_bd.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["registrar"])) {

    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $contrasena = $_POST["contrasena"];
    $confirmarC = $_POST["confirmarC"];

    // Verificar contraseñas
    if ($contrasena !== $confirmarC) {
        header("Location: registro.php?error_contrasena=1");
        exit();
    }

    // Verificar contraseña segura
    if (!preg_match('/^(?=.*[0-9]).{8,}$/', $contrasena)) {
        header("Location: registro.php?error_pass=1");
        exit();
    }

    // Verificar email repetido
    $consultaUsuarios = "SELECT * FROM usuarios WHERE email='$email'";
    $datos = $conn->query($consultaUsuarios);

    if ($datos->num_rows != 0) {
        header("Location: registro.php?error3=1");
        exit();
    }

    // Guardar datos en sesión
    $_SESSION['tmp_registro'] = [
        'nombre' => $nombre,
        'email' => $email,
        'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
    ];

    // Crear código
    $codigoAleatorio = random_int(10000, 99999);
    $expiracion = date("Y-m-d H:i:s", strtotime('+10 minutes'));

    // Eliminar códigos anteriores
    $eliminarVerificacion = "DELETE FROM verificaciones WHERE email='$email'";
    $conn->query($eliminarVerificacion);

    // Insertar nuevo código
    $insertarVerificacion = "INSERT INTO verificaciones (email,codigo,expiracion)
                             VALUES ('$email','$codigoAleatorio','$expiracion')";

    $conn->query($insertarVerificacion);

    // Enviar correo
    $mail = new PHPMailer(true);

    try {

        // CONFIGURACION DE ENVIAR CORREO
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

        $mail->send();

        header("Location: verificar.php");
        exit();

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="generalSesion">
        <div class="izquierda">
            <img src="./imagenes/imgsession.png" class="imgSesion">
        </div>
        <div class="derecha">
            <div class="form-container">
                <p class="title">Registrarse</p>
                
                <form class="form" method="post">
                    <div class="input-group">
                        <label for="nombre">Nombre y Apellidos</label>
                        <input type="text" name="nombre" id="nombre" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="contrasena">Contraseña</label>

                        <div class="contenedorPass">
                            <input type="password" name="contrasena" id="contrasena" oninput="validarHintPass(this.value)">
                            <i class="bi bi-eye ojo" onclick="mostrarPass('contrasena', this)"></i>
                        </div>
                        <div class="hint-contrasena" id="hintContrasena">
                            <span id="hint-longitud" class="no-cumple">
                                <i class="bi bi-circle" id="icon-longitud"></i> Mínimo 8 caracteres
                            </span>
                            <span id="hint-numero" class="no-cumple">
                                <i class="bi bi-circle" id="icon-numero"></i> Al menos 1 número
                            </span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="confirmarC">Confirmar contraseña</label>

                        <div class="contenedorPass">
                            <input type="password" name="confirmarC" id="confirmarC">
                            <i class="bi bi-eye ojo" onclick="mostrarPass('confirmarC', this)"></i>
                        </div>
                    </div>
                    <?php if(isset($_GET['error_contrasena'])){
                        ?>
                        <p class="mensajeError" id="mensajeError">Las contraseñas no coinciden</p>
                        <?php
                    }

                    if(isset($_GET['error_pass'])){
                        ?>
                        <p class="mensajeError">La contraseña debe tener mínimo 8 caracteres y un número</p>
                        <?php
                    }

                    if(isset($_GET['error3'])){
                        ?>
                        <p class="mensajeError" id="mensajeError">El email introducido ya existe Inicie Sesion</p>
                        <?php
                    }
                    ?><br>
                    <button class="sign" name="registrar">Registrarse</button>
                </form>
                <p class="signup">Ya tienes cuenta?
                    <a rel="noopener noreferrer" href="./login.php" class="">Iniciar Sesion</a>
                </p>
            </div>
        </div>
    </div>
    <script src="./JS/script.js"></script>

</body>
</html>