<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/formularioActualizarC.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    if(isset($_SESSION["email"])){
        include("cabecera.php");
        include("conexion_bd.php");

        ?>
        <div class="container">
            <div class="form_area">
                <p class="title">Cambiar contraseña</p>
                <?php
                        if(isset($_GET["correcto"])){
                            ?><h2 class="mensajeOkey">contraseña actualizada correctamente</h2><?php
                        }
                        if(isset($_GET["errorActual"])){
                            ?><h2 class="mensajeError">La contraseña actual no coincide</h2><?php
                        }
                        if(isset($_GET["error"])){
                            ?><h2 class="mensajeError">No se a podido actualizar la contraseña</h2><?php
                        }

                        if(isset($_GET["noCoincide"])){
                            ?><h2 class="mensajeError">La nueva contraseña no coincide</h2><?php
                        }

                        if(isset($_GET["iguales"])){
                            ?><h2 class="mensajeError">La nueva contraseña NO puede ser igual a la anterior</h2><?php
                        }

                        ?>
                <form action="actualizarContrasena.php" method="post">
                    <div class="form_group">
                        <label class="sub_title" for="actual">Contraseña Actual</label>
                        <input class="form_style" type="password" name="actual" required>
                    </div>
                    <div class="form_group">
                        <label class="sub_title" for="nuevaC">Nueva contraseña</label>
                        <input id="nuevaC" name="nuevaC" class="form_style" type="password" required>
                    </div>
                    <div class="form_group">
                        <label class="sub_title" for="password">Repite nueva contraseña</label>
                        <input id="password" name="nuevaC2" class="form_style" type="password" required>
                    </div>
                    <div>
                        <button class="btn" name="actualizar">Actualizar contraseña</button>
                    </div>
                
            </form></div>
        </div>
        <?php
        include("footer.html");

        if(isset($_POST["actualizar"])){
            $email = $_SESSION["email"];
            $contrasenaActual = $_POST["actual"];
            $consultacontrasena = "SELECT * FROM usuarios WHERE email='$email'";
            $datos = $conn->query($consultacontrasena);
            $fila = $datos->fetch_assoc();
            $contrasena = $fila["contrasena"];

            if(password_verify($contrasenaActual,$contrasena)){
                $nuevacontrasena = $_POST["nuevaC"];
                $nuevacontrasena2 = $_POST["nuevaC2"];
                if(password_verify($nuevacontrasena,$contrasena)){
                    header("Location: actualizarContrasena.php?iguales=1");
                } else {
                    if($nuevacontrasena===$nuevacontrasena2){
                        $nuevacontrasenaHash = password_hash($nuevacontrasena, PASSWORD_DEFAULT);
                        $actualizarcontrasena = "UPDATE usuarios SET contrasena='$nuevacontrasenaHash' WHERE email='$email'";
                        if($conn->query($actualizarcontrasena)){
                                header("Location: actualizarContrasena.php?correcto=1");
                                exit();
                        } else {
                            header("Location: actualizarContrasena.php?error=1");
                            exit();
                        }
                    } else {
                        header("Location: actualizarContrasena.php?noCoincide=1");
                        exit();
                    }
                }
                
            } else {
                header("Location: actualizarContrasena.php?errorActual=1");
                exit();
            }
        }

    } else {
        header("Location: index.php");
        exit();
    }
    ?>
    <script src="./JS/script.js"></script>
</body>
</html>
