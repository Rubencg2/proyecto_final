<?php

include("../conexion_bd.php");

$id_pedido = $_POST["id_pedido"];
$consultaCompletar = "UPDATE pedidos SET estado='completado' WHERE id = $id_pedido";

$completar = $conn->query($consultaCompletar);