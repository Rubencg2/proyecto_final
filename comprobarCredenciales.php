<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
    <script src="./JS/script.js"></script>
</head>
<body>
<?php
    include("conexion_bd.php");
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    $consulta = "SELECT * FROM usuarios WHERE email='$email'";
    $datos = $conn->query($consulta);


    if($datos->num_rows!==0){
        $fila = $datos->fetch_assoc();
        $contrasenaBD = $fila["contrasena"];
        if(password_verify($contrasena,$contrasenaBD)){
            $_SESSION["email"] = $email;
            $_SESSION["nombreUsuario"] = $fila["nombre"];
            $id_usuario = $fila["id"];
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["rol_usuario"] = $fila["rol"];

            // Sacamos el carrito del usuario para usarlo en la pagina de carrito
            $id_usuario = $_SESSION['id_usuario'];
            $consultaCarrito = "SELECT c.cantidad, c.talla, p.id, p.nombre, p.precio, p.url_imagen 
                                    FROM carrito c JOIN productos p ON c.id_producto = p.id 
                                    WHERE c.id_usuario = '$id_usuario'";
            $resultado = $conn->query($consultaCarrito);

            $_SESSION['carrito'] = array();

            while($fila = $resultado->fetch_assoc()){
                $indice = $fila['id'] . "_" . $fila['talla'];
                $_SESSION['carrito'][$indice] = [
                    "id" => $fila['id'],
                    "nombre" => $fila['nombre'],
                    "precio" => $fila['precio'],
                    "talla" => $fila['talla'],
                    "cantidad" => $fila['cantidad'],
                    "imagen" => $fila['url_imagen']
                ];
            }

            header("Location: index.php");
        } else {
            ?>
            <script>mostrarMensajeError()</script>
            <?php
            header("Location: login.php?error=1");
        }
    } else {
        header("Location: login.php?error=1");
    }

    $conn->close();