<?php
session_start();
include("../conexion_bd.php");
$nombre = $_POST['nombreP'];
$descripcion = $_POST['descripcionP'];
$precio = $_POST['precioP'];
$stock = $_POST['stockP'];
$id_equipo = $_POST['equipoP'];
$categoria = $_POST['categoriaP'];
$id_liga = $_POST['ligaP'];
$id_talla = $_POST['tallaP'];
$etiquetas = $_POST['etiquetas'];

//Configuración de imagen
$ruta_imagenes = "./imagenes/productos/";

$nombre_archivo = basename($_FILES["archivo_subida"]["name"]);
$ruta_completa = $ruta_imagenes . $nombre_archivo;
$uploadOk = 1;

// 3. Validaciones de imagen
if (file_exists($ruta_completa)) {
    echo "La imagen ya existe";
    exit();
}


// 5. Insertar Producto
$sql = "INSERT INTO productos (nombre, descripcion, precio, etiquetas, url_imagen,id_liga, id_equipo, id_categoria) 
        VALUES ('$nombre', '$descripcion', '$precio', '$etiquetas', '$ruta_completa','$id_liga', '$id_equipo', '$categoria')";

if ($conn->query($sql) === TRUE) {
    $id_producto = $conn->insert_id;

    // 6. Insertar Talla y Stock
    $insertarTalla = "INSERT INTO producto_tallas (id_producto, id_talla, stock) 
                    VALUES ('$id_producto', '$id_talla', '$stock')";
    $conn->query($insertarTalla);

    // 7. Mover imagen al servidor
    if (move_uploaded_file($_FILES["archivo_subida"]["tmp_name"], ".".$ruta_completa)) {
        header("Location: ../panelControl.php");
    } else {
        echo "Ha habido algun error al subir el producto";
    }
} else {
    // Error en la base de datos
    echo "Ha habido algun error al subir el producto";
}

$conn->close();

