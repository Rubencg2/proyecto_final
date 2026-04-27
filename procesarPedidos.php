<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilosCarritoCompra.css">
    <link rel="stylesheet" href="./CSS/estilosProcesarPedidos.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    include("cabecera.php");
    include("conexion_bd.php");

    $esLogueado = isset($_SESSION["email"]);

    // Usar el carrito correcto según el tipo de usuario
    $carrito = $esLogueado
        ? ($_SESSION["carrito"] ?? [])
        : ($_SESSION["temp_carrito"] ?? []);

    // Redirigir si el carrito está vacío
    if (empty($carrito)) {
        header("Location: ./verCarrito.php");
        exit();
    }
    ?>

    <div class="procesarPedido">
        <div class="div1">
            <div class="div2">

                <!-- 1. DATOS DE ENVÍO -->
                <div class="direccion">
                    <h2>1. Datos de envío</h2>

                    <?php if ($esLogueado): ?>
                        <?php
                        $id_usuario      = $_SESSION["id_usuario"];
                        $consultaUsuario = "SELECT * FROM usuarios WHERE id='$id_usuario'";
                        $datos = $conn->query($consultaUsuario);
                        $fila  = $datos->fetch_assoc();
                        if (empty($fila["direccion"]) || empty($fila["provincia"]) || empty($fila["municipio"])): ?>
                            <p>No hay datos o están incompletos</p>
                            <a href="./paginaUsuario.php">Establecer dirección</a>
                        <?php else: ?>
                            <p><?= $fila["direccion"] ?></p>
                            <p><?= $fila["provincia"] ?></p>
                            <p><?= $fila["municipio"] ?></p>
                            <a href="./paginaUsuario.php" style="font-size:.85rem">Cambiar dirección</a>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- FORMULARIO INVITADO -->
                        <p class="texto-invitado">
                            Completa tus datos para continuar sin registrarte.
                            ¿Ya tienes cuenta? <a href="./login.php">Inicia sesión</a>
                        </p>

                        <?php if (isset($_GET["error"])): ?>
                            <p style="color:#c0392b;font-weight:bold;margin-bottom:8px;">
                                Por favor, completa todos los campos obligatorios (*).
                            </p>
                        <?php endif; ?>

                        <div class="form-invitado">
                            <div class="campo">
                                <label for="nombre">Nombre completo *</label>
                                <input type="text" id="nombre" placeholder="Juan García" required>
                            </div>
                            <div class="campo">
                                <label for="email_inv">Email *</label>
                                <input type="email" id="email_inv" placeholder="tu@email.com" required>
                            </div>
                            <div class="campo">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" placeholder="600 000 000">
                            </div>
                            <div class="campo">
                                <label for="direccion">Dirección *</label>
                                <input type="text" id="direccion" placeholder="Calle Mayor, 12, 2ºA" required>
                            </div>
                            <div class="campo-fila">
                                <div class="campo">
                                    <label for="provincia">Provincia *</label>
                                    <input type="text" id="provincia" placeholder="Madrid" required>
                                </div>
                                <div class="campo">
                                    <label for="municipio">Municipio *</label>
                                    <input type="text" id="municipio" placeholder="Alcobendas" required>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 2. MÉTODO DE PAGO -->
                <div class="tarjetaCredito">
                    <h2>2. Metodo de pago</h2>
                    <div class="payment-method selected">
                        <div class="card-info">
                            <img src="./imagenes/visa.png" alt="Visa" class="card-logo">
                            <span>**** 1234</span>
                        </div>
                        <div class="tick-container">
                            <span class="tick-icon">✔</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badges informativos -->
            <div class="div3">
                <div class="info">
                    <img src="./imagenes/camion.png" alt="camion">
                    <p>Envios gratis en pedidos superiores a 100€</p>
                </div>
                <div class="info">
                    <img src="./imagenes/flecha-izquierda2.png" alt="devolucion">
                    <p>Devoluciones fáciles en 30 días</p>
                </div>
                <div class="info">
                    <img src="./imagenes/seguro.png" alt="pago seguro">
                    <p>PAGO SEGURO</p>
                </div>
            </div>
        </div>

        <!-- 3. RESUMEN DEL PEDIDO -->
        <div class="resumenPedido">
            <div class="texto">
                <h2>3. Resumen del Pedido</h2>
            </div>

            <div class="pedido">
                <?php
                $total = 0;
                foreach ($carrito as $item) {
                    $subtotalItem = $item['precio'] * $item['cantidad'];
                    $total += $subtotalItem;
                ?>
                    <div class="producto">
                        <div class="imagen">
                            <img src="<?=$item['imagen'] ?>">
                        </div>
                        <div class="detalles">
                            <h5><?= $item['nombre'] ?></h5>
                            <div class="talla">
                                <p>Talla: <b><?=$item['talla'] ?></b></p>
                                <p><?= $item['precio'] ?>€</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php $envio = ($total >= 100) ? 0 : 5.99; ?>
                <div class="precio">
                    <div class="subtotal">
                        <p>Subtotal:</p>
                        <p><?= number_format($total, 2, ',', '.') ?>€</p>
                    </div>
                    <div class="envio">
                        <p>Envío:</p>
                        <p><?= $envio > 0 ? '5,99€' : '¡GRATIS!' ?></p>
                    </div>
                    <div class="total">
                        <p>Total a pagar:</p>
                        <p><?= number_format($total + $envio, 2, ',', '.') ?>€</p>
                    </div>

                    <div class="boton">
                        <form action="./completarPedido.php" method="post" id="formPedido">
                            <?php if (!$esLogueado): ?>
                                <!-- Datos del invitado: se rellenan por JS antes de enviar -->
                                <input type="hidden" name="nombre"    id="h_nombre">
                                <input type="hidden" name="email"     id="h_email">
                                <input type="hidden" name="telefono"  id="h_telefono">
                                <input type="hidden" name="direccion" id="h_direccion">
                                <input type="hidden" name="provincia" id="h_provincia">
                                <input type="hidden" name="municipio" id="h_municipio">
                            <?php endif; ?>
                            <button type="submit" class="btn">Pagar ahora y completar pedido</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.html"); ?>

    <?php if (!$esLogueado): ?>
    <script>
    document.getElementById('formPedido').addEventListener('submit', function(e) {
        const requeridos = [
            { id: 'nombre',    hidden: 'h_nombre'    },
            { id: 'email_inv', hidden: 'h_email'     },
            { id: 'direccion', hidden: 'h_direccion' },
            { id: 'provincia', hidden: 'h_provincia' },
            { id: 'municipio', hidden: 'h_municipio' },
        ];

        let valido = true;

        requeridos.forEach(function(campo) {
            const el = document.getElementById(campo.id);
            if (!el || el.value.trim() === '') {
                valido = false;
                el.style.borderColor = '#e74c3c';
            } else {
                el.style.borderColor = '';
            }
        });

        // Validar formato email
        const emailEl = document.getElementById('email_inv');
        if (emailEl && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
            valido = false;
            emailEl.style.borderColor = '#e74c3c';
        }

        if (!valido) {
            e.preventDefault();
            let alerta = document.getElementById('alerta-form');
            if (!alerta) {
                alerta = document.createElement('p');
                alerta.id = 'alerta-form';
                alerta.style.cssText = 'color:#e74c3c;font-weight:bold;margin-top:8px;text-align:center';
                document.getElementById('formPedido').prepend(alerta);
            }
            alerta.textContent = 'Completa todos los campos obligatorios (*)';
            return;
        }

        // Copiar datos al form oculto antes de enviar
        document.getElementById('h_nombre').value    = document.getElementById('nombre').value.trim();
        document.getElementById('h_email').value     = document.getElementById('email_inv').value.trim();
        document.getElementById('h_telefono').value  = (document.getElementById('telefono').value || '').trim();
        document.getElementById('h_direccion').value = document.getElementById('direccion').value.trim();
        document.getElementById('h_provincia').value = document.getElementById('provincia').value.trim();
        document.getElementById('h_municipio').value = document.getElementById('municipio').value.trim();
    });
    </script>
    <?php endif; ?>

    <script src="./JS/script.js"></script>
</body>
</html>
