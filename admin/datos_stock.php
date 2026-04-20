<?php
include("../conexion_bd.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $consultaPT = "SELECT p.nombre, p.url_imagen, p.id, p.precio, t.talla, pt.stock, pt.id_talla
                FROM productos p
                JOIN producto_tallas pt ON p.id = pt.id_producto
                JOIN tallas t ON t.id = pt.id_talla
                WHERE p.id = $id";

    $resultado = $conn->query($consultaPT);
    $datos = $resultado->fetch_assoc();
    
    echo json_encode($datos);
}
?>