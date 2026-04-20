<?php
include('../conexion_bd.php');

$id_usuario = $_POST["id_usuario"];

$consultaEliminar = "DELETE FROM usuarios WHERE id='$id_usuario'";
$conn->query($consultaEliminar);

header("Location: ../panelControl.php");



