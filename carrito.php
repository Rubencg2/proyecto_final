<?php
session_start();
include("conexion_bd.php");

if (isset($_POST['id_producto']) && isset($_POST['talla_seleccionada'])) {
    $id       = intval($_POST['id_producto']);
    $talla    = $conn->real_escape_string($_POST['talla_seleccionada']);
    $cantidad = intval($_POST['cantidad']);

    // ── Consultar el stock real de este producto + talla ──────────────────
    $consultaStock = "SELECT pt.stock
                      FROM producto_tallas pt
                      JOIN tallas t ON pt.id_talla = t.id
                      WHERE pt.id_producto = '$id' AND t.talla = '$talla'
                      LIMIT 1";
    $resStock       = $conn->query($consultaStock);
    $filaStock      = $resStock ? $resStock->fetch_assoc() : null;
    $stockDisponible = $filaStock ? (int)$filaStock['stock'] : 0;

    // Sin stock en absoluto → volver al producto con aviso
    if ($stockDisponible <= 0) {
        header("Location: detallesProducto.php?id_producto=$id&error=sin_stock");
        exit();
    }

    if (isset($_SESSION["email"])) {
        // ── USUARIO LOGUEADO ──────────────────────────────────────────────
        $consulta = "SELECT nombre, precio, url_imagen FROM productos WHERE id = $id";
        $datos    = $conn->query($consulta);
        $producto = $datos->fetch_assoc();

        if ($producto) {
            $indice     = $id . "_" . $talla;
            $id_usuario = $_SESSION["id_usuario"];

            // Cantidad que ya tiene en el carrito (BD)
            $consultaComprobar = "SELECT id, cantidad FROM carrito
                                  WHERE id_usuario='$id_usuario'
                                    AND id_producto='$id'
                                    AND talla='$talla'";
            $resCarrito       = $conn->query($consultaComprobar);
            $item             = $resCarrito->fetch_assoc();
            $cantidadEnCarrito = $item ? (int)$item['cantidad'] : 0;

            // ── VALIDACIÓN DE STOCK ───────────────────────────────────────
            $totalSolicitado = $cantidadEnCarrito + $cantidad;
            if ($totalSolicitado > $stockDisponible) {
                // Ajustamos al máximo permitido
                $cantidad = $stockDisponible - $cantidadEnCarrito;
            }

            if ($cantidad <= 0) {
                // Ya tiene el máximo en el carrito
                header("Location: detallesProducto.php?id_producto=$id&error=stock_maximo");
                exit();
            }

            // Actualizar BD
            if ($item) {
                $nueva_cantidad   = $cantidadEnCarrito + $cantidad;
                $consultaActualizar = "UPDATE carrito SET cantidad='$nueva_cantidad' WHERE id='{$item['id']}'";
                $conn->query($consultaActualizar);
            } else {
                $consultaInsertar = "INSERT INTO carrito (id_usuario, id_producto, talla, cantidad)
                                     VALUES ('$id_usuario', '$id', '$talla', '$cantidad')";
                $conn->query($consultaInsertar);
            }

            // Actualizar sesión
            if (isset($_SESSION['carrito'][$indice])) {
                $_SESSION['carrito'][$indice]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$indice] = [
                    "id"       => $id,
                    "nombre"   => $producto['nombre'],
                    "precio"   => $producto['precio'],
                    "talla"    => $talla,
                    "cantidad" => $cantidad,
                    "imagen"   => $producto['url_imagen']
                ];
            }
        }

    } else {
        // ── USUARIO INVITADO ──────────────────────────────────────────────
        $indice = $id . "_" . $talla;

        $cantidadEnCarrito = isset($_SESSION['temp_carrito'][$indice])
            ? (int)$_SESSION['temp_carrito'][$indice]['cantidad']
            : 0;

        // ── VALIDACIÓN DE STOCK ───────────────────────────────────────────
        $totalSolicitado = $cantidadEnCarrito + $cantidad;
        if ($totalSolicitado > $stockDisponible) {
            $cantidad = $stockDisponible - $cantidadEnCarrito;
        }

        if ($cantidad <= 0) {
            header("Location: detallesProducto.php?id_producto=$id&error=stock_maximo");
            exit();
        }

        if (isset($_SESSION['temp_carrito'][$indice])) {
            $_SESSION['temp_carrito'][$indice]['cantidad'] += $cantidad;
        } else {
            $consultaProducto = "SELECT * FROM productos WHERE id='$id'";
            $datos = $conn->query($consultaProducto);
            if ($datos) {
                $fila = $datos->fetch_assoc();
                $_SESSION['temp_carrito'][$indice] = [
                    "id"       => $id,
                    "nombre"   => $fila['nombre'],
                    "precio"   => $fila['precio'],
                    "talla"    => $talla,
                    "cantidad" => $cantidad,
                    "imagen"   => $fila['url_imagen']
                ];
            }
        }
    }

    header("Location: verCarrito.php");
    exit();
}
