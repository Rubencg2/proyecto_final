<?php
header('Content-Type: application/json');
include("../conexion_bd.php");
 
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}
 
$id_pedido = intval($_GET['id']);
 
// Cabecera del pedido + datos del usuario
$consultaCabecera = "
    SELECT 
        p.id,
        p.fecha,
        p.total,
        p.estado,
        u.email,
        u.nombre AS nombre_usuario
    FROM pedidos p
    JOIN usuarios u ON p.id_usuario = u.id
    WHERE p.id = $id_pedido
";
 
$resCabecera = $conn->query($consultaCabecera);
 
if (!$resCabecera) {
    echo json_encode(['error' => 'Error SQL: ' . $conn->error]);
    exit;
}
if ($resCabecera->num_rows === 0) {
    echo json_encode(['error' => 'Pedido no encontrado']);
    exit;
}
 
$pedido = $resCabecera->fetch_assoc();
 
// Líneas del pedido — LEFT JOIN para que aparezcan aunque el producto esté eliminado
$consultaLineas = "
    SELECT
        COALESCE(pr.nombre, '[Producto eliminado]') AS nombre,
        COALESCE(pr.url_imagen, '') AS url_imagen,
        dp.talla,
        dp.cantidad,
        dp.precio_unitario,
        (dp.cantidad * dp.precio_unitario) AS subtotal
    FROM detalle_pedidos dp
    LEFT JOIN productos pr ON pr.id = dp.id_producto
    WHERE dp.id_pedido = $id_pedido
    ORDER BY pr.nombre ASC
";
 
$resLineas = $conn->query($consultaLineas);
 
if (!$resLineas) {
    echo json_encode(['error' => 'Error SQL líneas: ' . $conn->error]);
    exit;
}
 
$lineas = [];
while ($fila = $resLineas->fetch_assoc()) {
    $lineas[] = $fila;
}
 
echo json_encode([
    'pedido' => $pedido,
    'lineas' => $lineas
]);