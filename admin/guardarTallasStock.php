<?php
header('Content-Type: application/json');
include("../conexion_bd.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id_producto']) || !isset($input['tallas'])) {
    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}

$id_producto = intval($input['id_producto']);
$tallas      = $input['tallas']; // array of { id_talla, stock, activa }

$errores = [];
$exitos  = 0;

foreach ($tallas as $t) {
    $id_talla = intval($t['id_talla']);
    $stock    = max(0, intval($t['stock']));
    $activa   = (bool)$t['activa'];

    // Check if the record exists
    $checkQ = "SELECT id_producto FROM producto_tallas 
               WHERE id_producto = $id_producto AND id_talla = $id_talla";
    $check  = $conn->query($checkQ);
    $existe = $check->num_rows > 0;

    if ($activa) {
        if ($existe) {
            // UPDATE
            $q = "UPDATE producto_tallas SET stock = $stock 
                  WHERE id_producto = $id_producto AND id_talla = $id_talla";
        } else {
            // INSERT
            $q = "INSERT INTO producto_tallas (id_producto, id_talla, stock) 
                  VALUES ($id_producto, $id_talla, $stock)";
        }
    } else {
        if ($existe) {
            // DELETE
            $q = "DELETE FROM producto_tallas 
                  WHERE id_producto = $id_producto AND id_talla = $id_talla";
        } else {
            // Nothing to do
            $exitos++;
            continue;
        }
    }

    if ($conn->query($q)) {
        $exitos++;
    } else {
        $errores[] = "Talla ID $id_talla: " . $conn->error;
    }
}

if (empty($errores)) {
    echo json_encode(['ok' => true, 'mensaje' => "✅ Cambios guardados correctamente ($exitos tallas actualizadas)"]);
} else {
    echo json_encode(['ok' => false, 'error' => implode('; ', $errores)]);
}
?>
