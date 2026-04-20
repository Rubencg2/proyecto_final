<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilosCarritoCompra.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    include("cabecera.php");
    include("conexion_bd.php");
    if(isset($_SESSION["email"])){
        ?>
        <div class="general-carrito">
        <div class="carrito-lista">
            <h2>Tu Cesta</h2>

            <?php
            $total = 0;
            if(!isset($_SESSION["carrito"]) || count($_SESSION["carrito"])===0){
                ?>
                <div>Tu carrito está vacío. <a href="index.php">Ir a la tienda</a></div>
                <?php
            } else { 
                
                foreach ($_SESSION['carrito'] as $indice => $item){
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img src="<?=$item["imagen"]?>">
                        </div>
                        <div class="cart-item-details">
                            <h4><?=$item["nombre"]?></h4>
                            <p>Talla: <b><?=$item["talla"]?></b></p>
                            <p class="precio"><?=$item['precio']?>€</p>
                            <p class="error" id="error"></p>
                        </div>
                        <div class="cart-item-actions text-center">
                            <div class="qty-selector mb-2">
                                <button class="btn-qty" data-id="<?=$indice?>" data-accion="restar">-</button>
        
                                <input type="text" id="cant-<?=$indice?>" value="<?=$item["cantidad"]?>" readonly>
                                
                                <button class="btn-qty" data-id="<?=$indice?>" data-accion="sumar">+</button>
                            </div>
                            <a href="eliminarItem.php?id=<?=$indice?>"><small>Eliminar</small></a>
                        </div>
                    </div>
                    <?php
                }   
            }
            ?>        
        </div>

        <?php
        if(!isset($_SESSION["carrito"]) || count($_SESSION["carrito"])===0){
            
        } else {
            ?>
            <div class="carrito-resumen">
                <div class="resumen-card">
                    <h3>Resumen</h3>
                    <div class="resumen-fila">
                        <span>Total</span>
                        <span id="resumen-total"><?=$total?>€</span>
                    </div>

                    <div class="resumen-fila" id="envio" style="display: <?= ($total < 100) ? 'flex' : 'none' ?>;">
                        <span>Envío</span>
                        <span style="color: #00ffcc;">5,99€</span>
                    </div>
                    
                    <span>Con pedidos superiores a 100€ envío gratis</span>

                    <div class="resumen-fila total-fila">
                        <span>Total</span>
                        <?php
                        $totalFinal = ($total < 100) ? ($total + 5.99) : $total;
                        ?>
                        <span id="resumen-final"><?= number_format($totalFinal, 2) ?>€</span>
                    </div>
                    
                    <button class="btn-pagar" id="btn-procesar">PROCESAR PEDIDO</button>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <?php 
    } else {
        ?>
        <div class="general-carrito">
        <div class="carrito-lista">
            <h2>Tu Cesta</h2>

            <?php
            $total = 0;
            if(!isset($_SESSION["temp_carrito"]) || count($_SESSION["temp_carrito"])===0){
                ?>
                <div>Tu carrito está vacío. <a href="index.php">Ir a la tienda</a></div>
                <?php
            } else { 
                
                foreach ($_SESSION['temp_carrito'] as $indice => $item){
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                    $id_producto = $item["id"];
                    $talla = $item["talla"];

                    $consultaTalla = "SELECT id FROM tallas WHERE talla='$talla'";
                    $datos = $conn->query($consultaTalla);
                    $talla = $datos->fetch_assoc();
                    $id_talla = $talla["id"];

                    $consultaStock = "SELECT stock FROM producto_tallas WHERE id_producto='$id_producto' AND id_talla='$id_talla'";
                    $res = $conn->query($consultaStock);
                    $stock = $res->fetch_assoc();

                    if($stock["stock"]<$item["cantidad"]){
                        $hayStock = false;
                    } else{
                        $hayStock = true;
                    }
                ?>
                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img src="<?=$item["imagen"]?>">
                        </div>
                        <div class="cart-item-details">
                            <h4><?=$item["nombre"]?></h4>
                            <p>Talla: <b><?=$item["talla"]?></b></p>
                            <p class="precio" id="subtotal-<?=$indice?>"><?=$subtotal?>€</p>
                            <p class="error" id="error"></p>
                        </div>
                        <div class="cart-item-actions text-center">
                            <div class="qty-selector mb-2">
                                <button class="btn-qty" data-id="<?=$indice?>" data-accion="restar">-</button>
        
                                <input type="text" id="cant-<?=$indice?>" value="<?=$item["cantidad"]?>" readonly>
                                
                                <button class="btn-qty" data-id="<?=$indice?>" data-accion="sumar">+</button>
                            </div>
                            <a href="eliminarItem.php?id=<?=$indice?>"><small>Eliminar</small></a>
                        </div>
                    </div>
                    <?php
                }   
            }
            ?>        
        </div>

        <?php
        if(!isset($_SESSION["temp_carrito"]) || count($_SESSION["temp_carrito"])===0){
            
        } else {
            ?>
            <div class="carrito-resumen">
                <div class="resumen-card">
                    <h3>Resumen</h3>
                    <div class="resumen-fila">
                        <span>Total</span>
                        <span id="resumen-total"><?=$total?>€</span>
                    </div>

                    <div class="resumen-fila" id="envio" style="display: <?= ($total < 100) ? 'flex' : 'none' ?>;">
                        <span>Envío</span>
                        <span style="color: #00ffcc;">5,99€</span>
                    </div>

                    <span>Con pedidos superiores a 100€ envío gratis</span>

                <div class="resumen-fila total-fila">
                    <span>Total</span>
                    <?php
                    $totalFinal = ($total < 100) ? ($total + 5.99) : $total;
                    ?>
                    <span id="resumen-final"><?= number_format($totalFinal, 2) ?>€</span>

                    <button class="btn-pagar" id="btn-procesar">PROCESAR PEDIDO</button>

                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <?php
    }
    
    ?>
    <script src="./JS/script.js"></script>
</body>
</html>