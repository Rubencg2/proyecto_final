<?php
session_start();

// Seguridad: solo admins
if (!isset($_SESSION["email"]) || $_SESSION["rol_usuario"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

include("../conexion_bd.php");

$nombre      = $_POST['nombreP'];
$descripcion = $_POST['descripcionP'];
$precio      = $_POST['precioP'];
$id_equipo   = $_POST['equipoP'];
$categoria   = $_POST['categoriaP'];
$id_liga     = $_POST['ligaP'];
$etiquetas   = $_POST['etiquetas'];

// ✅ Ruta absoluta basada en la raíz del proyecto, no en /admin/
$raiz_proyecto  = dirname(__DIR__); // sube un nivel desde /admin/
$ruta_imagenes  = $raiz_proyecto . "/imagenes/productos/";
$nombre_archivo = basename($_FILES["archivo_subida"]["name"]);
$ruta_completa  = $ruta_imagenes . $nombre_archivo;

// URL relativa para guardar en BD (sin ruta del servidor)
$url_bd = "./imagenes/productos/" . $nombre_archivo;

// Verificar que el directorio existe, si no, crearlo
if (!is_dir($ruta_imagenes)) {
    mkdir($ruta_imagenes, 0755, true);
}

// Validar que la imagen no exista ya
if (file_exists($ruta_completa)) {
    echo "La imagen ya existe";
    exit();
}

// Insertar en BD con parámetros preparados (más seguro)
$sql = "INSERT INTO productos (nombre, descripcion, precio, etiquetas, url_imagen, id_liga, id_equipo, id_categoria) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsssis", $nombre, $descripcion, $precio, $etiquetas, $url_bd, $id_liga, $id_equipo, $categoria);

if ($stmt->execute()) {
    // ✅ Mover imagen usando ruta absoluta
    if (move_uploaded_file($_FILES["archivo_subida"]["tmp_name"], $ruta_completa)) {
        header("Location: ../panelControl.php");
        exit();
    } else {
        echo "Error al mover la imagen. Verifica permisos del directorio.";
    }
} else {
    echo "Error en la base de datos: " . $conn->error;
}

$stmt->close();
$conn->close();