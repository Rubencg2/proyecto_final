<?php
session_start();
include("../conexion_bd.php");

$nombre = $_POST["nombreP"];
$pais = $_POST["pais"];

$consultaLiga = "INSERT INTO ligas (liga ,pais) VALUES ('$nombre', '$pais')";
$conn->query($consultaLiga);

header("Location: ../panelControl.php");