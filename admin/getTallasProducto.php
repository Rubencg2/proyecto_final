<?php
header('Content-Type: application/json');
include("../conexion_bd.php");

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
    exit;
}

$id_producto = intval($_GET['id']);

// Get product info
$consultaProducto = "SELECT id, nombre, precio, url_imagen FROM productos WHERE id = $id_producto";
$resProducto = $conn->query($consultaProducto);

if ($resProducto->num_rows === 0) {
    echo json_encode(['error' => 'Producto no encontrado']);
    exit;
}

$producto = $resProducto->fetch_assoc();

// Get ALL available sizes, marking which ones the product already has
$consultaTallas = "
    SELECT 
        t.id AS id_talla,
        t.talla,
        pt.stock,
        CASE WHEN pt.id_producto IS NOT NULL THEN 1 ELSE 0 END AS activa
    FROM tallas t
    LEFT JOIN producto_tallas pt ON t.id = pt.id_talla AND pt.id_producto = $id_producto
    ORDER BY 
        CASE 
            WHEN t.talla REGEXP '^[0-9]+$' THEN CAST(t.talla AS UNSIGNED)
            WHEN t.talla = 'XS' THEN 1
            WHEN t.talla = 'S'  THEN 2
            WHEN t.talla = 'M'  THEN 3
            WHEN t.talla = 'L'  THEN 4
            WHEN t.talla = 'XL' THEN 5
            WHEN t.talla = 'XXL' THEN 6
            WHEN t.talla = 'XXXL' THEN 7
            ELSE 99
        END ASC,
        t.talla ASC
";

$resTallas = $conn->query($consultaTallas);
$tallas = [];
while ($fila = $resTallas->fetch_assoc()) {
    $tallas[] = [
        'id_talla' => (int)$fila['id_talla'],
        'talla'    => $fila['talla'],
        'stock'    => $fila['stock'] !== null ? (int)$fila['stock'] : 0,
        'activa'   => (bool)$fila['activa']
    ];
}

echo json_encode([
    'producto' => $producto,
    'tallas'   => $tallas
]);
?>
