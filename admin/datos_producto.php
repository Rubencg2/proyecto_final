<?php
include("../conexion_bd.php");

$id = $_GET["id"];
$consulta = "SELECT id, nombre, descripcion, precio, url_imagen FROM productos WHERE id = $id";
$resultado = $conn->query($consulta);

if($resultado->num_rows > 0){
    $producto = $resultado->fetch_assoc();
    echo json_encode($producto);
} else {
    echo json_encode(null);
}
?>