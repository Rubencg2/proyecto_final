<?php
include("../conexion_bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $desc = $_POST['descripcion'];
    $precio = $_POST['precio'];
    /*
    $stock = $_POST['stock'];
    $talla = $_POST['talla'];*/
    $url_imagen = $_POST["url_imagen_actual"];

    if(isset($_FILES["nueva_imagen"]) && $_FILES["nueva_imagen"]["error"] === UPLOAD_ERR_OK){
 
    $nombreArchivo  = basename($_FILES["nueva_imagen"]["name"]);
 
    $destino     = "../imagenes/productos/" . $nombreArchivo;

    if(move_uploaded_file($_FILES["nueva_imagen"]["tmp_name"], $destino)){
        $url_imagen = "./imagenes/productos/" . $nombreArchivo;
    }
    
}

    $consultaProducto = "UPDATE productos 
                     SET nombre = '$nombre', descripcion = '$desc', precio = '$precio',  url_imagen = '$url_imagen'
                     WHERE id = '$id'";

    /*$consultaStock = "UPDATE producto_tallas 
                    SET stock = '$stock' 
                    WHERE id_producto = '$id' AND id_talla = '$talla'";*/

    $actualizar = $conn->query($consultaProducto);
    //$actualizar2 = $conn->query($consultaStock);

    header("Location: ../panelControl.php");

}