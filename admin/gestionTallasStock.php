<?php
include("../conexion_bd.php");

$consulta = "
    SELECT 
        p.id,
        p.nombre,
        p.url_imagen,
        p.precio,
        p.estado,
        COUNT(pt.id_talla) AS num_tallas,
        COALESCE(SUM(pt.stock), 0) AS stock_total
    FROM productos p
    LEFT JOIN producto_tallas pt ON p.id = pt.id_producto
    GROUP BY p.id, p.nombre, p.url_imagen, p.precio, p.estado
    ORDER BY p.nombre ASC
";

$productos = $conn->query($consulta);
?>

<div id="contenedor-gestion-tallas">
    <div class="tabla-header">
        <h1>Gestión de Tallas y Stock</h1>
    </div>

    <?php if ($productos->num_rows === 0): ?>
        <h2>No hay productos disponibles</h2>
    <?php else: ?>
    <table class="tabla" id="tablaTallas">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Tallas</th>
                <th>Stock Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $productos->fetch_assoc()): ?>
            <tr>
                <td data-label="Imagen">
                    <img src="<?= $fila['url_imagen'] ?>"
                         alt="<?= htmlspecialchars($fila['nombre']) ?>"
                         class="img-producto"
                         style="width:60px;height:auto;border-radius:6px;">
                </td>
                <td data-label="Nombre"><?= htmlspecialchars($fila['nombre']) ?></td>
                <td data-label="Precio"><?= number_format($fila['precio'], 2) ?>€</td>
                <td data-label="Tallas">
                    <span class="badge-tallas"><?= $fila['num_tallas'] ?> talla<?= $fila['num_tallas'] != 1 ? 's' : '' ?></span>
                </td>
                <td data-label="Stock Total">
                    <?php
                    $stock = (int)$fila['stock_total'];
                    $clase = $stock <= 0 ? 'stock-agotado' : ($stock <= 10 ? 'stock-bajo' : 'stock-ok');
                    ?>
                    <span class="badge-stock <?= $clase ?>"><?= $stock ?> uds.</span>
                </td>
                <td data-label="Opciones">
                    <button class="btn-gestionar-tallas btn-editar"
                            data-id="<?= $fila['id'] ?>"
                            data-nombre="<?= htmlspecialchars($fila['nombre']) ?>">
                        Gestionar Tallas
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<!-- MODAL DE GESTIÓN DE TALLAS -->
<div id="modalTallas" class="modal" style="display:none;">
    <div class="modal-content modal-tallas-content" id="modal-tallas-content">
        <span class="close" id="cerrarModalTallas">✕</span>

        <div id="modal-tallas-header">
            <img id="tallas-img-producto" src="" alt="" style="width:70px;height:auto;border-radius:8px;">
            <div>
                <h3 id="tallas-nombre-producto">Producto</h3>
                <p id="tallas-precio-producto" style="color:#666;"></p>
            </div>
        </div>

        <div id="tallas-loading" style="text-align:center;padding:20px;display:none;">
            <p>Cargando tallas...</p>
        </div>

        <form id="formGestionTallas">
            <input type="hidden" id="tallas-id-producto" name="id_producto" value="">

            <div id="tallas-grid-container">
                <p style="color:#888;text-align:center;">Selecciona un producto</p>
            </div>

            <div id="tallas-acciones">
                <p class="tallas-leyenda">
                    ✅ Tallas activas · Edita el stock. &nbsp;
                    ➕ Tallas sin asignar · Actívalas y define el stock.
                </p>
                <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:16px;">
                    <button type="button" class="btn-cancelar-tallas" id="btnCancelarTallas">Cancelar</button>
                    <button type="submit" class="btn-guardar" id="btnGuardarTallas">💾 Guardar Cambios</button>
                </div>
            </div>
        </form>

        <div id="tallas-feedback" style="display:none;text-align:center;padding:12px;border-radius:8px;margin-top:10px;"></div>
    </div>
</div>
