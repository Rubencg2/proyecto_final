<?php
session_start();
include("../conexion_bd.php");
$id_usuario = $_SESSION["id_usuario"];
?>
<h1>Panel de Usuario</h1>
<div class="paneles">
    <div class="ultimosFavoritos">
        <?php
        $consultaFavoritos = "SELECT p.id, p.nombre, p.url_imagen, p.precio
                        FROM favoritos f
                        JOIN productos p ON f.id_producto = p.id
                        WHERE f.id_usuario = '$id_usuario'
                        ORDER BY f.id DESC
                        LIMIT 3";

        $resultFavoritos = $conn->query($consultaFavoritos);
        if($resultFavoritos->num_rows===0){
            ?><p class="negrita rem2">No tienes favoritos</p> <?php
        } else {
            ?>
            <h2>Tus favoritos</h2>
            <div class="favoritos">
                <?php
                while($fav = $resultFavoritos->fetch_assoc()){
                    ?>
                    <div class="producto-favorito">
                        <img src="<?=$fav["url_imagen"]?>">
                        <p><?=$fav["nombre"]?></p>
                        <p>Precio: <?=$fav["precio"]?>€</p>
                    </div>
                    <?php
                }
                ?>
            </div>
                <?php
            
        }
        ?>
    </div>


    <div class="ultimoPedido">
        <?php
        $consultaPedido = "SELECT 
                        p.id AS id_pedido,
                        p.fecha,
                        p.estado,
                        (p.total + 5.99) AS total,
                        pr.nombre,
                        pr.url_imagen,
                        dp.talla,
                        dp.cantidad,
                        dp.precio_unitario,
                        (dp.cantidad * dp.precio_unitario) AS subtotal

                    FROM pedidos p
                    JOIN detalle_pedidos dp ON dp.id_pedido = p.id
                    JOIN productos pr ON pr.id = dp.id_producto

                    WHERE p.id_usuario = '$id_usuario'
                    AND p.id = (
                        SELECT MAX(id)
                        FROM pedidos
                        WHERE id_usuario = '$id_usuario'
                    );";

        $datos = $conn->query($consultaPedido);

        if($datos->num_rows===0){
            ?><p>No has realizado ningun pedido</p> <?php
        } else{
            $filas = $datos->fetch_all(MYSQLI_ASSOC);
            $cabecera = $filas[0]; 
            ?>
            <div class="pedido">
                <h2>Ultimo Pedido</h2>
                <div class="datos">
                    <p class="negrita">Pedido: <?=$cabecera["id_pedido"]?></p>
                    <p><?=$cabecera["fecha"]?></p>
                </div>
                <p class="negrita">Estado: <?=$cabecera["estado"]?></p>

                <div class="productoPedido">
                    <?php foreach($filas as $res){ ?>
                    <div class="contenedorProducto">
                        <div class="imgDetalles">
                            <img src="<?=$res["url_imagen"]?>" alt="<?=$res["nombre"]?>">
                            <div class="detalles">
                                <p><?=$res["nombre"]?></p>
                                <p><?=$res["talla"]?></p>
                            </div>
                        </div>
                        
                        <div class="precio">
                            <p>x<?=$res["cantidad"]?></p>
                            <p class="negrita"><?=$res["precio_unitario"]?>€</p>
                        </div>
                    </div> 
                    <?php } ?>
                </div>

                <div class="total">
                    <h3>Total:</h3>
                    <h3><?=$cabecera["total"]?>€</h3>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>