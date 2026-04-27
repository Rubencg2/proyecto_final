<?php
session_start();
include("conexion_bd.php");

$esInvitado = !isset($_SESSION["email"]);

// ── Carrito correcto según tipo de usuario ────────────────────────────────────
$carrito = $esInvitado
    ? ($_SESSION["temp_carrito"] ?? [])
    : ($_SESSION["carrito"]      ?? []);

// Redirigir si el carrito está vacío
if (empty($carrito)) {
    header("Location: ./index.php");
    exit();
}

// ── Datos del invitado (vienen por POST desde procesarPedidos.php) ────────────
if ($esInvitado) {
    $nombre    = trim($_POST["nombre"]    ?? "");
    $email     = trim($_POST["email"]     ?? "");
    $telefono  = trim($_POST["telefono"]  ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $provincia = trim($_POST["provincia"] ?? "");
    $municipio = trim($_POST["municipio"] ?? "");

    // Si faltan datos obligatorios, devolver al formulario
    if (empty($nombre) || empty($email) || empty($direccion) || empty($provincia) || empty($municipio)) {
        header("Location: ./procesarPedidos.php?error=datos_incompletos");
        exit();
    }
} else {
    $email = $_SESSION["email"];
    $id_usuario = (int) $_SESSION["id_usuario"];
}

// ── Calcular total ────────────────────────────────────────────────────────────
$subtotal = 0;
foreach ($carrito as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$envio = ($subtotal >= 100) ? 0 : 5.99;
$total = $subtotal + $envio;

$fecha  = date("Y-m-d");
$estado = "pendiente";

// ── Insertar pedido ───────────────────────────────────────────────────────────
$pedidoOk  = false;
$id_pedido = null;

if ($esInvitado) {
    // id_usuario = NULL para invitados (la columna admite NULL en la BD)
    $stmt ="INSERT INTO pedidos (id_usuario, fecha, total, estado) VALUES (NULL, '$fecha', '$total', '$estado')";
    $conn->query($stmt);
} else {
    $stmt ="INSERT INTO pedidos (id_usuario, fecha, total, estado) VALUES ('$id_usuario', '$fecha', '$total', '$estado')";
    $conn->query($stmt);
}

if ($stmt->execute()) {
    $id_pedido = $conn->insert_id;
    $pedidoOk  = true;

    

    foreach ($carrito as $item) {
        $id_producto     = $item['id'];
        $cantidad        = $item['cantidad'];
        $talla           = $item['talla'];
        $precio_unitario = round($item['precio']);


        // ── Actualizar stock ──────────────────────────────────────────────────
        $conn->query(
            "UPDATE producto_tallas pt
             JOIN tallas t ON pt.id_talla = t.id
             SET pt.stock = pt.stock - $cantidad
             WHERE pt.id_producto = $id_producto
               AND t.talla = '$talla'
               AND pt.stock >= $cantidad"
        );
    }

    // ── Insertar líneas de detalle ────────────────────────────────────────────
    $consultaLinea ="INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, talla, precio_unitario)
         VALUES ('$id_pedido', '$id_producto', '$cantidad', '$talla', '$precio_unitario')";

    $conn->query($consultaLinea);

    // ── Vaciar el carrito correcto ────────────────────────────────────────────
    if ($esInvitado) {
        unset($_SESSION["temp_carrito"]);
    } else {
        unset($_SESSION["carrito"]);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido confirmado || La casa del fútbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/estilosConfirmacion.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("cabecera.php"); ?>

    <main class="confirmacion-wrapper">

        <?php if ($pedidoOk): ?>

        <!-- ── ÉXITO ──────────────────────────────────────────────────────── -->
        <div class="confirmacion-card">

            <div class="icono-exito">
                <svg viewBox="0 0 52 52" class="checkmark">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path   class="checkmark__check"   fill="none" d="M14 27 l7 7 17-17"/>
                </svg>
            </div>

            <h1 class="titulo">¡Pedido realizado!</h1>
            <p class="subtitulo">
                Gracias por tu compra. Hemos recibido tu pedido correctamente
                y está siendo procesado.
            </p>

            <!-- Número de pedido -->
            <div class="numero-pedido">
                <span class="etiqueta">Nº de pedido</span>
                <span class="valor">#<?= str_pad($id_pedido, 6, "0", STR_PAD_LEFT) ?></span>
            </div>

            <!-- Datos de entrega del invitado -->
            <?php if ($esInvitado): ?>
            <div class="info-entrega">
                <div class="info-item">
                    <img src="./imagenes/ubicacion.png" alt="dirección">
                    <div>
                        <p><b><?= $nombre ?></b></p>
                        <p><?= $direccion ?></p>
                        <p><?= $municipio ?>, <?= $provincia?></p>
                        <?php if (!empty($telefono)): ?>
                            <p><?= $telefono ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Resumen de artículos -->
            <div class="resumen-articulos">
                <h3>Resumen de tu compra</h3>
                <div class="lista-articulos">
                    <?php foreach ($carrito as $item):
                        $subtotalItem = $item['precio'] * $item['cantidad'];
                    ?>
                    <div class="articulo">
                        <div class="articulo-img">
                            <img src="<?= $item['imagen'] ?>"
                                 alt="<?= $item['nombre'] ?>">
                        </div>
                        <div class="articulo-info">
                            <p class="articulo-nombre"><?=$item['nombre']?></p>
                            <p class="articulo-talla">Talla: <b><?=$item['talla'] ?></b></p>
                            <p class="articulo-cantidad">Cantidad: <?= $item['cantidad'] ?></p>
                        </div>
                        <div class="articulo-precio">
                            <?= number_format($subtotalItem, 2, ',', '.') ?>€
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="totales">
                    <div class="fila-total">
                        <span>Subtotal</span>
                        <span><?= number_format($subtotal, 2, ',', '.') ?>€</span>
                    </div>
                    <div class="fila-total">
                        <span>Envío</span>
                        <span><?= $envio == 0 ? '¡GRATIS!' : number_format($envio, 2, ',', '.') . '€' ?></span>
                    </div>
                    <div class="fila-total fila-gran-total">
                        <span>Total pagado</span>
                        <span><?= number_format($total, 2, ',', '.') ?>€</span>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="acciones">
                <a href="./index.php" class="btn-primario">Seguir comprando</a>
                <?php if (!$esInvitado): ?>
                    <a href="./paginaUsuario.php" class="btn-secundario">Ver mis pedidos</a>
                <?php else: ?>
                    <a href="./registro.php" class="btn-secundario">Crear una cuenta</a>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>

        <!-- ── ERROR ──────────────────────────────────────────────────────── -->
        <div class="confirmacion-card error-card">
            <div class="icono-error">✕</div>
            <h1 class="titulo">Algo salió mal</h1>
            <p class="subtitulo">
                No hemos podido procesar tu pedido. Por favor, inténtalo de nuevo
                o contacta con nosotros si el problema persiste.
            </p>
            <div class="acciones">
                <a href="./verCarrito.php" class="btn-primario">Volver al carrito</a>
            </div>
        </div>

        <?php endif; ?>

    </main>

    <?php include("footer.html"); ?>
    <script src="./JS/script.js"></script>
</body>
</html>
