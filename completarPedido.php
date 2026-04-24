<?php
session_start();
include("conexion_bd.php");

// Redirigir si no hay sesión o carrito vacío
if (!isset($_SESSION["email"]) || empty($_SESSION["carrito"])) {
    header("Location: ./index.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$carrito    = $_SESSION["carrito"];

// ── Calcular total ────────────────────────────────────────────────────────────
$subtotal = 0;
foreach ($carrito as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$envio = ($subtotal >= 100) ? 0 : 5.99;
$total = $subtotal + $envio;


$fecha  = date("Y-m-d");
$estado = "pendiente";

$consultaPedido ="INSERT INTO pedidos (id_usuario, fecha, total, estado)
                    VALUES ($id_usuario, $fecha, $total, $estado)";


$pedidoOk  = false;
$id_pedido = null;

if ($pedidos = $conn->query($consultaPedido)) {
    $id_pedido = $conn->insert_id;
    $pedidoOk  = true;

    

    foreach ($carrito as $item) {
        $id_producto     = $item['id'];
        $cantidad        = $item['cantidad'];
        $talla           = substr((string)$item['talla'], 0, 4);
        $precio_unitario = round($item['precio']);

        $consultaLinea ="INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, talla, precio_unitario)
                    VALUES ($id_pedido, $id_producto, $cantidad, $talla, $precio_unitario)";

        $Linea = conn-query($consultaLinea);
    }

    // ── Vaciar carrito de sesión ──────────────────────────────────────────────
    unset($_SESSION["carrito"]);
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

        <?php if ($pedidoOk){ ?>

        <!-- ── ÉXITO ──────────────────────────────────────────────────────── -->
        <div class="confirmacion-card">

            <!-- Check animado SVG -->
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

            <!-- Resumen de artículos -->
            <div class="resumen-articulos">
                <h3>Resumen de tu compra</h3>

                <div class="lista-articulos">
                    <?php foreach ($carrito as $item){
                        $subtotalItem = $item['precio'] * $item['cantidad'];
                    ?>
                    <div class="articulo">
                        <div class="articulo-img">
                            <img src="<?= $item['imagen'] ?>"
                                 alt="<?= $item['nombre'] ?>">
                        </div>
                        <div class="articulo-info">
                            <p class="articulo-nombre"><?=$item['nombre'] ?></p>
                            <p class="articulo-talla">Talla: <b><?=$item['talla'] ?></b></p>
                            <p class="articulo-cantidad">Cantidad: <?=$item['cantidad'] ?></p>
                        </div>
                        <div class="articulo-precio">
                            <?= number_format($subtotalItem, 2, ',', '.') ?>€
                        </div>
                    </div>
                    <?php }; ?>
                </div>

                <!-- Totales -->
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
                <a href="./paginaUsuario.php" class="btn-secundario">Ver mis pedidos</a>
            </div>
        </div>

        <?php} else { ?>

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

        <?php}; ?>

    </main>

    <?php include("footer.html"); ?>
    <script src="./JS/script.js"></script>
</body>
</html>
