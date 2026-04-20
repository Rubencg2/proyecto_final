<?php
/*session_start();
include("conexion_bd.php");

$response = ['status' => 'error'];

if (isset($_GET['id']) && isset($_GET['accion'])) {
    $indice = $_GET['id'];
    $accion = $_GET['accion'];

    if (isset($_SESSION['carrito'][$indice])) {
        $id_usuario = $_SESSION['id_usuario'];
        // Sumamos o restamos la cantidad
        if ($accion === 'sumar' && $_SESSION['carrito'][$indice]['cantidad'] < 20) {
            $_SESSION['carrito'][$indice]['cantidad'] += 1;
        } elseif ($accion === 'restar' && $_SESSION['carrito'][$indice]['cantidad'] > 1) {
            $_SESSION['carrito'][$indice]['cantidad'] -= 1;
        }

        $item = $_SESSION['carrito'][$indice];
        $nueva_qty = $item['cantidad'];
        $precio = $item['precio'];
        $subtotal_item = $nueva_qty * $precio;

        // Actualizamos la base de datos
        $partes = explode("_", $indice);
        $id_prod = $partes[0];
        $talla = $partes[1];
        $conn->query("UPDATE carrito SET cantidad = '$nueva_qty' WHERE id_usuario = '$id_usuario' AND id_producto = '$id_prod' AND talla = '$talla'");

        //Calculamos el nuevo total de la cesta
        $total_cesta = 0;
        foreach ($_SESSION['carrito'] as $prod) {
            $total_cesta += ($prod['precio'] * $prod['cantidad']);
        }

        //comprobar stock
        $consultaTalla = "SELECT id FROM tallas WHERE talla='$talla'";
        $datos = $conn->query($consultaTalla);
        $tallaRes = $datos->fetch_assoc();
        $id_talla = $tallaRes["id"];

        $consultaStock = "SELECT stock FROM producto_tallas WHERE id_producto='$id_prod' AND id_talla='$id_talla'";
        $res = $conn->query($consultaStock);
        $stock = $res->fetch_assoc();

        if($nueva_qty>$stock["stock"]){
            $hayStock = 0;
        } else {
            $hayStock = 1;
        }

        $response = [
            'status' => 'success',
            'hayStock' => $hayStock,
            'nuevaCantidad' => $nueva_qty,
            'subtotalItem' => number_format($subtotal_item, 2),
            'totalCesta' => number_format($total_cesta, 2),
            'totalConEnvio' => number_format($total_cesta + 5.99, 2)
        ];
    }

    if (isset($_SESSION['temp_carrito'][$indice])) {
        // Sumamos o restamos la cantidad
        if ($accion === 'sumar' && $_SESSION['temp_carrito'][$indice]['cantidad'] < 20) {
            $_SESSION['temp_carrito'][$indice]['cantidad'] += 1;
        } elseif ($accion === 'restar' && $_SESSION['temp_carrito'][$indice]['cantidad'] > 1) {
            $_SESSION['temp_carrito'][$indice]['cantidad'] -= 1;
        }

        $item = $_SESSION['temp_carrito'][$indice];
        $nueva_qty = $item['cantidad'];
        $precio = $item['precio'];
        $subtotal_item = $nueva_qty * $precio;

        $total_cesta = 0;
        foreach ($_SESSION['temp_carrito'] as $prod) {
            $total_cesta += ($prod['precio'] * $prod['cantidad']);
        }

        //comprobar stock
        $consultaTalla = "SELECT id FROM tallas WHERE talla='$talla'";
        $datos = $conn->query($consultaTalla);
        $tallaRes = $datos->fetch_assoc();
        $id_talla = $tallaRes["id"];

        $consultaStock = "SELECT stock FROM producto_tallas WHERE id_producto='$id_prod' AND id_talla='$id_talla'";
        $res = $conn->query($consultaStock);
        $stock = $res->fetch_assoc();

        if($nueva_qty>$stock["stock"]){
            $hayStock = 0;
        } else {
            $hayStock = 1;
        }

        $response = [
            'status' => 'success',
            'hayStock' => $hayStock,
            'nuevaCantidad' => $nueva_qty,
            'subtotalItem' => number_format($subtotal_item, 2) . "€",
            'totalCesta' => number_format($total_cesta, 2) . "€",
            'totalConEnvio' => number_format($total_cesta + 5.99, 2) . "€"
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();*/

session_start();
include("conexion_bd.php");

$response = ['status' => 'error'];

// 1. Validamos solo lo esencial para que el script corra
if (isset($_GET['id']) && isset($_GET['accion'])) {
    $indice = $_GET['id'];
    $accion = $_GET['accion'];
    
    // Extraemos ID de producto y talla (sirve para ambos casos)
    $partes = explode("_", $indice);
    $id_prod = $partes[0];
    $talla_nombre = $partes[1];

    // DETERMINAR QUÉ CARRITO USAR
    // Si existe email/id_usuario usamos 'carrito', si no 'temp_carrito'
    $nombre_sesion_carrito = (isset($_SESSION['id_usuario'])) ? 'carrito' : 'temp_carrito';

    if (isset($_SESSION[$nombre_sesion_carrito][$indice])) {
        
        // 2. Lógica de sumar/restar
        if ($accion === 'sumar' && $_SESSION[$nombre_sesion_carrito][$indice]['cantidad'] < 20) {
            $_SESSION[$nombre_sesion_carrito][$indice]['cantidad'] += 1;
        } elseif ($accion === 'restar' && $_SESSION[$nombre_sesion_carrito][$indice]['cantidad'] > 1) {
            $_SESSION[$nombre_sesion_carrito][$indice]['cantidad'] -= 1;
        }

        $item = $_SESSION[$nombre_sesion_carrito][$indice];
        $nueva_qty = $item['cantidad'];
        $precio = $item['precio'];
        $subtotal_item = $nueva_qty * $precio;

        // 3. Si está logueado, actualizamos su DB
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $conn->query("UPDATE carrito SET cantidad = '$nueva_qty' WHERE id_usuario = '$id_usuario' AND id_producto = '$id_prod' AND talla = '$talla_nombre'");
        }

        // 4. Calculamos total
        $total_cesta = 0;
        foreach ($_SESSION[$nombre_sesion_carrito] as $prod) {
            $total_cesta += ($prod['precio'] * $prod['cantidad']);
        }

        // 5. Comprobar stock (Común para ambos)
        $consultaTalla = "SELECT id FROM tallas WHERE talla='$talla_nombre'";
        $datos = $conn->query($consultaTalla);
        $tallaRes = $datos->fetch_assoc();
        $id_talla = $tallaRes["id"];

        $consultaStock = "SELECT stock FROM producto_tallas WHERE id_producto='$id_prod' AND id_talla='$id_talla'";
        $res = $conn->query($consultaStock);
        $stock = $res->fetch_assoc();

        $hayStock = ($nueva_qty <= $stock["stock"]) ? 1 : 0;

        $response = [
            'status' => 'success',
            'hayStock' => $hayStock,
            'nuevaCantidad' => $nueva_qty,
            'subtotalItem' => number_format($subtotal_item, 2) . "€",
            'totalCesta' => number_format($total_cesta, 2),
            'totalConEnvio' => number_format($total_cesta + 5.99, 2) . "€",
            'totalSinEnvio' => number_format($total_cesta, 2) . "€"
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();