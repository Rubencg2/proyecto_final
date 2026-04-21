<?php
include("../conexion_bd.php");

$id = $_GET["id"];

$consultaDeshabilitar = "UPDATE productos SET estado='inactivo' WHERE id='$id'";

$conn->query($consultaDeshabilitar);

header("Location: ./panelControl.php");
