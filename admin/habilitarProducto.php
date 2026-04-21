<?php
include("../conexion_bd.php");

$id = $_GET["id"];

$consultaHabilitar = "UPDATE productos SET estado='activo' WHERE id='$id'";

$conn->query($consultaHabilitar);

header("Location: ./panelControl.php");