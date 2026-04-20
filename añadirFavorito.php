<?php
session_start();
include("conexion_bd.php");

if (!isset($_SESSION['email'])) {
    echo "error_login";
    exit;
}

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $id_usuario = $_SESSION['id_usuario']; 

    $check = $conn->query("SELECT * FROM favoritos WHERE id_usuario = $id_usuario AND id_producto = $id_producto");

    if ($check->num_rows > 0) {
        $conn->query("DELETE FROM favoritos WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        echo "eliminado";
    } else {
        $conn->query("INSERT INTO favoritos (id_usuario, id_producto) VALUES ($id_usuario, $id_producto)");
        echo "añadido";
    }
}
?>