<?php
session_start();
include("conexion_bd.php");
if (isset($_GET['id'])) {
    $id_usuario = $_SESSION["id_usuario"];
    $indice = $_GET['id'];
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);

        $partes = explode("_",$indice);
        $id_producto = $partes[0];
        $talla = $partes[1];

        $consultaBorrar = "DELETE FROM carrito WHERE id_usuario='$id_usuario' AND id_producto='$id_producto' AND talla='$talla'";
        $conn->query($consultaBorrar);
    }

    if (isset($_SESSION['temp_carrito'][$indice])) {
        unset($_SESSION['temp_carrito'][$indice]);
    }
}
header("Location: verCarrito.php");
?>