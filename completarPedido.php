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
 
} else {
    $stmt ="INSERT INTO pedidos (id_usuario, fecha, total, estado) VALUES ('$id_usuario', '$fecha', '$total', '$estado')";
    
}
 
if ($conn->query($stmt)) {
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
 
        // ── Insertar línea de detalle ─────────────────────────────────────────
        $consultaLinea = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, talla, precio_unitario)
             VALUES ('$id_pedido', '$id_producto', '$cantidad', '$talla', '$precio_unitario')";
        $conn->query($consultaLinea);
    }
 
    // ── Vaciar el carrito correcto ────────────────────────────────────────────
    if ($esInvitado) {
        unset($_SESSION["temp_carrito"]);
    } else {
        unset($_SESSION["carrito"]);
        // Limpiar también la tabla carrito en BD para que no reaparezcan
        // los artículos al volver a iniciar sesión
        $conn->query("DELETE FROM carrito WHERE id_usuario = '$id_usuario'");
    }
}
 
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
 
$mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply.lacasadelfutbol@gmail.com';
        $mail->Password   = 'tkgocjbtekwhfwvh'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
 
        $mail->setFrom('noreply.lacasadelfutbol@gmail.com', 'La casa del futbol');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmacion de Pedido';
        // ── Filas de artículos ────────────────────────────────────────────────────────
    $filasArticulos = '';
    foreach ($carrito as $item) {
        $subtotalItem   = number_format($item['precio'] * $item['cantidad'], 2, ',', '.');
        $precioUnitario = number_format($item['precio'], 2, ',', '.');
        $filasArticulos .= "
        <tr>
            <td style='padding:12px 8px;border-bottom:1px solid #f0f0f0;'>
                <strong style='color:#1a1a1a;font-size:14px;'>{$item['nombre']}</strong><br>
                <span style='color:#888;font-size:12px;'>Talla: {$item['talla']} &nbsp;·&nbsp; Cantidad: {$item['cantidad']}</span>
            </td>
            <td style='padding:12px 8px;border-bottom:1px solid #f0f0f0;text-align:right;color:#1a1a1a;font-size:14px;'>
                {$subtotalItem}&nbsp;€
            </td>
        </tr>";
    }
 
    // ── Fila de envío ─────────────────────────────────────────────────────────────
    $filaEnvio = $envio == 0
        ? "<tr><td style='padding:8px;color:#555;font-size:13px;'>Envío</td><td style='padding:8px;text-align:right;color:#27ae60;font-size:13px;font-weight:600;'>¡GRATIS!</td></tr>"
        : "<tr><td style='padding:8px;color:#555;font-size:13px;'>Envío</td><td style='padding:8px;text-align:right;color:#555;font-size:13px;'>" . number_format($envio, 2, ',', '.') . "&nbsp;€</td></tr>";
 
    // ── Bloque de dirección (solo invitados) ──────────────────────────────────────
    $bloqueInvitado = '';
    if ($esInvitado) {
        $bloqueInvitado = "
        <div style='background:#f8f9fa;border-radius:8px;padding:20px;margin:24px 0;'>
            <p style='margin:0 0 10px;font-size:13px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;'>Dirección de entrega</p>
            <p style='margin:0;font-size:14px;color:#1a1a1a;line-height:1.7;'>
                <strong>{$nombre}</strong><br>
                {$direccion}<br>
                {$municipio}, {$provincia}" .
                (!empty($telefono) ? "<br>{$telefono}" : "") .
            "</p>
        </div>";
    }
 
    // ── Nombre de saludo ─────────────────────────────────────────────────────────
    $saludo = $esInvitado ? $nombre : explode("@", $email)[0];
 
    $numeroPedido    = str_pad($id_pedido, 6, "0", STR_PAD_LEFT);
    $subtotalFormato = number_format($subtotal, 2, ',', '.');
    $totalFormato    = number_format($total,    2, ',', '.');
    $fechaFormato    = date("d/m/Y", strtotime($fecha));
 
    // ── Cuerpo del email ──────────────────────────────────────────────────────────
    $mail->Body = "
    <!DOCTYPE html>
    <html lang='es'>
    <head><meta charset='UTF-8'></head>
    <body style='margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;'>
 
    <table width='100%' cellpadding='0' cellspacing='0' style='background:#f4f4f4;padding:32px 0;'>
    <tr><td align='center'>
    <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px;width:100%;'>
 
        <!-- CABECERA -->
        <tr>
            <td style='background:#1a1a2e;border-radius:10px 10px 0 0;padding:32px 40px;text-align:center;'>
                <h1 style='margin:0;color:#ffffff;font-size:24px;letter-spacing:1px;'>
                    ⚽ La Casa del Fútbol
                </h1>
            </td>
        </tr>
 
        <!-- CUERPO PRINCIPAL -->
        <tr>
            <td style='background:#ffffff;padding:40px;'>
 
                <!-- Icono de confirmación -->
                <div style='text-align:center;margin-bottom:28px;'>
                    <div style='display:inline-block;background:#e8f8f0;border-radius:50%;width:64px;height:64px;line-height:64px;font-size:32px;'>✅</div>
                </div>
 
                <h2 style='margin:0 0 8px;text-align:center;font-size:22px;color:#1a1a2e;'>
                    ¡Pedido confirmado!
                </h2>
                <p style='margin:0 0 28px;text-align:center;font-size:15px;color:#666;'>
                    Hola, <strong>{$saludo}</strong>. Hemos recibido tu pedido correctamente y ya está siendo procesado.
                </p>
 
                <!-- Número y fecha de pedido -->
                <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom:28px;'>
                    <tr>
                        <td style='background:#f8f9fa;border-radius:8px;padding:16px 20px;'>
                            <table width='100%'>
                                <tr>
                                    <td style='font-size:13px;color:#888;'>Nº de pedido</td>
                                    <td style='font-size:13px;color:#888;text-align:right;'>Fecha</td>
                                </tr>
                                <tr>
                                    <td style='font-size:18px;font-weight:700;color:#1a1a2e;'>#{$numeroPedido}</td>
                                    <td style='font-size:14px;color:#444;text-align:right;'>{$fechaFormato}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
 
                <!-- Dirección (solo invitados) -->
                {$bloqueInvitado}
 
                <!-- Artículos del pedido -->
                <p style='margin:0 0 12px;font-size:13px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;'>
                    Resumen del pedido
                </p>
                <table width='100%' cellpadding='0' cellspacing='0' style='border:1px solid #f0f0f0;border-radius:8px;overflow:hidden;margin-bottom:20px;'>
                    {$filasArticulos}
                </table>
 
                <!-- Totales -->
                <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom:28px;'>
                    <tr>
                        <td style='padding:8px;color:#555;font-size:13px;'>Subtotal</td>
                        <td style='padding:8px;text-align:right;color:#555;font-size:13px;'>{$subtotalFormato}&nbsp;€</td>
                    </tr>
                    {$filaEnvio}
                    <tr>
                        <td style='padding:14px 8px 4px;font-size:16px;font-weight:700;color:#1a1a2e;border-top:2px solid #1a1a2e;'>Total pagado</td>
                        <td style='padding:14px 8px 4px;text-align:right;font-size:16px;font-weight:700;color:#1a1a2e;border-top:2px solid #1a1a2e;'>{$totalFormato}&nbsp;€</td>
                    </tr>
                </table>
 
                <!-- CTA -->
                <div style='text-align:center;'>
                    <a href='https://tudominio.com/index.php'
                    style='display:inline-block;background:#1a1a2e;color:#ffffff;text-decoration:none;font-size:14px;font-weight:700;padding:14px 36px;border-radius:6px;letter-spacing:.5px;'>
                        Seguir comprando
                    </a>
                </div>
 
            </td>
        </tr>
 
        <!-- PIE -->
        <tr>
            <td style='background:#f8f9fa;border-radius:0 0 10px 10px;padding:24px 40px;text-align:center;'>
                <p style='margin:0 0 6px;font-size:12px;color:#aaa;'>
                    ¿Tienes alguna duda? Escríbenos a
                    <a href='mailto:noreply.lacasadelfutbol@gmail.com' style='color:#1a1a2e;text-decoration:none;font-weight:600;'>
                        noreply.lacasadelfutbol@gmail.com
                    </a>
                </p>
                <p style='margin:0;font-size:11px;color:#ccc;'>
                    © <?= date('Y') ?> La Casa del Fútbol · Todos los derechos reservados
                </p>
            </td>
        </tr>
 
    </table>
    </td></tr>
    </table>
 
    </body>
    </html>";
 
    $mail->AltBody = "Pedido #{$numeroPedido} confirmado. Total: {$totalFormato} €. Gracias por tu compra en La Casa del Fútbol.";
 
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
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
 
            <!-- Notificación por email -->
            <div class="info-entrega">
                <div class="info-item">
                    <img src="./imagenes/camion.png" alt="envío">
                    <p>Se enviará confirmación a <b><?= htmlspecialchars($email) ?></b></p>
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
 
        <?php
        $mail->send();
        else: ?>
 
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