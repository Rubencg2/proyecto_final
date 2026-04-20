<?php

include("../conexion_bd.php");

$consultaCompletar = "UPDATE pedidos SET estado='completado'";

$completar = $conn->query($consultaCompletar);