<?php
session_start();
include("../conexion_bd.php");


$id_usuario = $_SESSION["id_usuario"];

$consultaPedidos = "SELECT 
                        p.id AS id_pedido,
                        p.fecha,
                        p.estado,
                        (p.total + 5.99) AS total,
                        pr.nombre,
                        pr.url_imagen,
                        dp.talla,
                        dp.cantidad,
                        dp.precio_unitario
                    FROM pedidos p
                    JOIN detalle_pedidos dp ON dp.id_pedido = p.id
                    JOIN productos pr ON pr.id = dp.id_producto
                    WHERE p.id_usuario = '$id_usuario'
                    ORDER BY p.fecha DESC";

$datos = $conn->query($consultaPedidos);
?>
<div class="totalPedidos">
    <h2>Mis Pedidos</h2>
    <?php
    if($datos->num_rows===0){
    ?><p>No has realizado ningun pedido</p> <?php
} else{
    $pedidos = [];
    while ($fila = $datos->fetch_assoc()) {
        $id = $fila["id_pedido"];
        if (!isset($pedidos[$id])) {
            $pedidos[$id] = [
                "id_pedido"  => $fila["id_pedido"],
                "fecha"      => $fila["fecha"],
                "estado"     => $fila["estado"],
                "total"      => $fila["total"],
                "productos"  => []
            ];
        }
        $pedidos[$id]["productos"][] = $fila;
    } 
    ?>
    <div class="contenedorPedidos">
    <?php
    foreach ($pedidos as $pedido) { ?>
        <div class="pedidoUnitario">
            <div class="pedido">
                <div class="datos">
                    <p class="negrita">Pedido: <?= $pedido["id_pedido"] ?></p>
                    <p><?= $pedido["fecha"] ?></p>
                </div>
                <p class="negrita">Estado: <?= $pedido["estado"] ?></p>

                <div class="productoPedido">
                    <?php foreach ($pedido["productos"] as $res) { ?>
                        <div class="contenedorProducto">
                            <div class="imgDetalles">
                                <img src="<?= $res["url_imagen"] ?>" alt="<?= $res["nombre"] ?>">
                                <div class="detalles">
                                    <p><?= $res["nombre"] ?></p>
                                    <p><?= $res["talla"] ?></p>
                                </div>
                            </div>
                            <div class="precio">
                                <p>x<?= $res["cantidad"] ?></p>
                                <p class="negrita"><?= $res["precio_unitario"] ?>€</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="total">
                    <h3>Total <p>(+5,99€ Gastos de Envio)</p>:</h3>
                    <h3><?= $pedido["total"] ?>€</h3>
                </div>
            </div>
        </div>
        <?php
        }?>
    </div>
<?php    
}
?>
</div>
