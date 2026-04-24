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
    <link rel="stylesheet" href="./CSS/estilosProcesarPedidos.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    include("cabecera.php");
    include("conexion_bd.php");
    if(isset($_SESSION["email"])){
        ?>
        <div class="procesarPedido">
            <div class="div1">
                <div class="div2">
                    <div class="direccion">
                        <h2>1. Datos de envío</h2>
                        <?php
                        $id_usuario = $_SESSION["id_usuario"];
                        $consultaUsuario = "SELECT * FROM usuarios WHERE id='$id_usuario'";
                        $datos = $conn->query($consultaUsuario);
                        $fila = $datos->fetch_assoc();
                        if($fila["direccion"]==="" || $fila["provincia"]=== "" || $fila["municipio"] === ""){
                            ?><p>No hay datos o estan incompletos</p>
                            <a href="./paginaUsuario.php">Establecer</a>
                            <?php
                        }
                        $datos->data_seek(0);
                        while($fila = $datos->fetch_assoc()){
                            ?>
                            <p><?=$fila["direccion"]?></p>   
                            <p><?=$fila["provincia"]?></p>   
                            <p><?=$fila["municipio"]?></p>   
                        <?php
                        }
                        ?>
                    </div>


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
            


            <!--RESUMEN DEL PEDIDO -->
            <div class="resumenPedido">
                <div class="texto">
                    <h2>3. Resumen del Pedido</h2>
                </div>
                
                <div class="pedido">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $indice => $item){
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>
                        <div class="producto">
                            <div class="imagen">
                                <img src="<?=$item["imagen"]?>">
                            </div>
                            <div class="detalles">
                                <h5><?=$item["nombre"]?></h5>
                                <div class="talla">
                                    <p>Talla: <b><?=$item["talla"]?></b></p>
                                    <p><?=$item['precio']?>€</p>
                                </div>
                                
                            </div>
                        </div>
                        <?php
                    }   
                    ?>   
                    <div class="precio">
                        <div class="subtotal">
                            <p>Subtotal: </p>
                            <p><?=$subtotal?>€</p>
                        </div>
                        <div class="envio">
                            <p>Envio: </p>
                            <?php
                            if($total<100){
                                ?><p>5.99€</p><?php
                            } else {
                                ?><p>¡GRATIS!</p><?php
                            }
                            ?>
                            
                        </div>

                        <div class="total">
                            <p>Total a pagar: </p>
                            <p><?=$total + 5.99?>€</p>
                        </div>

                        <div class="boton">
                            <form action="./completarPedido.php" method="post">
                                <button class="btn">Pagar ahora y completar pedido</button>
                            </form>
                        </div>     
                    </div>     
                </div>
                
                
            </div>
        </div>
        <?php
        include("footer.html");
    } else {

    }

    ?>
    <script src="./JS/script.js"></script>
</body>
</html>
