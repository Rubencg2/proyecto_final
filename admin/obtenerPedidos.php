<?php
include("../conexion_bd.php");
$consultapedidos = "SELECT p.id, p.fecha, p.total, p.estado,
                           COALESCE(u.email, '(Invitado)') AS email,
                           COALESCE(u.nombre, 'Invitado') AS nombre_usuario
                    FROM pedidos p
                    LEFT JOIN usuarios u ON p.id_usuario = u.id
                    ORDER BY p.fecha DESC, p.id DESC";
$pedidos_res = $conn->query($consultapedidos);

if ($pedidos_res->num_rows == 0) {
    echo '<h2>No hay pedidos</h2>';
} else {
    $pedidos = [];
    while ($fila = $pedidos_res->fetch_assoc()) {
        $pedidos[] = $fila;
    }
?>
<div id="contenedor-tabla-pedidos">
    <div class="tabla-header">
        <h1>Pedidos</h1>
    </div>
    <table class="tabla display nowrap responsive" id="tablaPedidos" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario (Email)</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $fila): ?>
            <tr>
                <td data-label="#"><?= $fila['id'] ?></td>
                <td data-label="Usuario"><?= htmlspecialchars($fila['email']) ?></td>
                <td data-label="Fecha"><?= $fila['fecha'] ?></td>
                <td data-label="Total"><?= number_format($fila['total'], 2) ?>€</td>
                <td data-label="Estado">
                    <span class="badge-estado badge-estado--<?= $fila['estado'] ?>">
                        <?= ucfirst($fila['estado']) ?>
                    </span>
                </td>
                <td data-label="Opciones" class="td-opciones-pedido">
                    <button class="btn-ver-pedido btn-editar" data-id="<?= $fila['id'] ?>">
                        🔍 Ver detalles
                    </button>
                    <?php if ($fila['estado'] !== 'completado'): ?>
                    <button class="btn-completar btn" data-id="<?= $fila['id'] ?>">
                        ✅ Completar
                    </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php $total = array_sum(array_column($pedidos, 'total')); ?>
    <p class="totalFiltrado">Total: <strong id="total-pedidos"><?= number_format($total, 2) ?>€</strong></p>
</div>

<!-- MODAL DETALLE PEDIDO -->
<div id="modalDetallePedido" style="display:none;">
    <div id="modal-detalle-content">
        <button class="btn-cerrar-detalle" id="cerrarDetallePedido">✕</button>

        <div id="detalle-header">
            <div>
                <h2 id="detalle-titulo">Pedido #<span id="detalle-id"></span></h2>
                <p id="detalle-fecha" style="color:#888;margin-top:4px;"></p>
            </div>
            <span id="detalle-estado-badge" class="badge-estado"></span>
        </div>

        <div id="detalle-usuario-info">
            <span style="font-size:1.6rem;">👤</span>
            <div>
                <p id="detalle-nombre-usuario" style="font-weight:600;"></p>
                <p id="detalle-email-usuario" style="color:#888;font-size:0.9rem;"></p>
            </div>
        </div>

        <div id="detalle-lineas-loading" style="display:none;text-align:center;padding:20px;">
            <p>Cargando productos...</p>
        </div>

        <div id="detalle-lineas-container"></div>

        <div id="detalle-resumen">
            <div class="detalle-resumen-fila">
                <span>Subtotal productos</span>
                <span id="detalle-subtotal"></span>
            </div>
            <div class="detalle-resumen-fila">
                <span>Gastos de envío</span>
                <span>5,99 €</span>
            </div>
            <div class="detalle-resumen-fila detalle-resumen-total">
                <span>Total</span>
                <span id="detalle-total"></span>
            </div>
        </div>

        <div id="detalle-acciones">
            <button class="btn-cancelar-tallas" id="btnCerrarDetalle2">Cerrar</button>
            <button class="btn-completar-detalle btn" id="btnCompletarDesdeDetalle" style="display:none;">
                ✅ Marcar como Completado
            </button>
        </div>
    </div>
</div>
<?php } ?>
