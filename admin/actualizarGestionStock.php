<?php
include("../conexion_bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $talla = $_POST['talla'];



    $consultaProducto = "UPDATE productos 
                     SET nombre = '$nombre', descripcion = '$desc', precio = '$precio'
                     WHERE id = '$id'";

    $consultaStock = "UPDATE producto_tallas 
                    SET stock = '$stock' 
                    WHERE id_producto = '$id' AND id_talla = '$talla'";

    $actualizar = $conn->query($consultaProducto);
    $actualizar2 = $conn->query($consultaStock);

    header("Location: ../panelControl.php");

}