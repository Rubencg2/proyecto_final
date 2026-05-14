<?php
session_start();
include("conexion_bd.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar sesión
if (!isset($_SESSION['tmp_registro'])) {
    die("La sesión ha expirado.");
}

if (isset($_POST["verificar"])) {

    $codigo_introducido = trim($_POST['codigo']);

    $nombre = $_SESSION['tmp_registro']['nombre'];
    $email = $_SESSION['tmp_registro']['email'];
    $contrasenaHash = $_SESSION['tmp_registro']['contrasena'];

    $fechaActual = date("Y-m-d H:i:s");

    // Buscar código
    $consultaVerificacion = "SELECT * FROM verificaciones
                             WHERE email='$email'
                             AND codigo='$codigo_introducido'
                             AND expiracion > '$fechaActual'";

    $resultado = $conn->query($consultaVerificacion);

    if ($resultado->num_rows != 0) {

        $fechaRegistro = date("Y-m-d");

        // Registrar usuario
        $consultaRegistro = "INSERT INTO usuarios
                            (nombre,email,contrasena,fecha_registro)
                            VALUES
                            ('$nombre','$email','$contrasenaHash','$fechaRegistro')";

        if ($conn->query($consultaRegistro)) {

            // Eliminar código usado
            $eliminarVerificacion = "DELETE FROM verificaciones WHERE email='$email'";
            $conn->query($eliminarVerificacion);

            // Eliminar sesión temporal
            unset($_SESSION['tmp_registro']);

            header("Location: login.php?correcto=1");
            exit();

        } else {
            echo "Error al registrar usuario.";
        }

    } else {
        echo "Código inválido o expirado.";
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
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioVerificacion.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    include("cabecera.php");
    ?>

    <div class="centrado">
        <div class="card2">
            <span class="card2__title">Verifica tu codigo</span>
            <p class="card2__content">Pega aqui el codigo que hemos enviado a tu correo electronico para completar el registro
            </p>
            <div class="card2__form">
                <form action="verificar.php" method="post">
                    <input placeholder="Tu código" type="text" name="codigo">
                    <button class="sign-up2" name="verificar">Verificar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="./JS/script.js"></script>
</body>
</html>