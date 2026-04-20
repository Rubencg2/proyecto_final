<?php
session_start();
include("../conexion_bd.php");
$nombre = $_POST["nombreP"];
$liga = $_POST["ligaP"];

$consultaEquipo = "INSERT INTO equipos (equipo, liga) VALUES ('$nombre','$liga')";
$conn->query($consultaEquipo);

header("Location: ../panelControl.php"); 