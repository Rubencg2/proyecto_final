<?php 
session_start();
if (isset($_POST['nombre'])) $_SESSION['temp_nombre'] = $_POST['nombre'];
if (isset($_POST['telefono'])) $_SESSION['temp_telefono'] = $_POST['telefono'];
if (isset($_POST['direccion'])) $_SESSION['temp_direccion'] = $_POST['direccion'];
if (isset($_POST['provincia'])) $_SESSION['temp_provincia'] = $_POST['provincia'];
if (isset($_POST['municipio'])) $_SESSION['temp_municipio'] = $_POST['municipio'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/estilos.css">
    <link rel="stylesheet" href="../CSS/formularioVerificacion.css">
    <script src="../JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include("../conexion_bd.php");

    if(isset($_SESSION["email"])){
        ?>
        <div class="general2">
            <div class="productos">
                <?php
                    $email = $_SESSION["email"];
                    $id = $_SESSION["id_usuario"];

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
                            if($telefonoA==="" || $telefonoA === NULL){

                            } else{
                                $actualizarTelefono = "UPDATE usuarios SET telefono='$telefonoA' WHERE id='$id'";
                                if($conn->query($actualizarTelefono)){
                                    ?><h3>Telefono actualizado correctamente</h3><?php
                                    unset($_SESSION["temp_telefono"]);
                                } else {
                                    ?><h3>Error al cambiar el telefono</h3><?php
                                }
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

                        header("Location: ../paginaUsuario.php");
                
            ?>
            </div>
            <?php
            include("../footer.html");
        ?>
        </div>
        <script src="./JS/script.js"></script>
        <?php
    } else {
        header("Location: ../index.php");
    }
    
    ?>
</body>
</html>