<?php
session_start();
include("../conexion_bd.php");

 
$ruta_imagenes = "../imagenes/usuarios/";
 
// Comprobar que se recibió el archivo sin errores
if (!isset($_FILES["fotoPerfil"]) || $_FILES["fotoPerfil"]["error"] !== UPLOAD_ERR_OK) {
    header("Location: ../paginaUsuario.php");
    exit;
}
 
$nombre_archivo = basename($_FILES["fotoPerfil"]["name"]);
$ruta_completa = $ruta_imagenes . $nombre_archivo;
 
// Mover el archivo del temporal al directorio destino
if (move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], $ruta_completa)) {
    $id_usuario = $_SESSION["id_usuario"];
    $ruta_bd = "./imagenes/usuarios/" . $nombre_archivo;
    $subirImagen = "UPDATE usuarios SET foto_perfil='$ruta_bd' WHERE id='$id_usuario'";
    $conn->query($subirImagen);
}
 
header("Location: ../paginaUsuario.php");
exit;