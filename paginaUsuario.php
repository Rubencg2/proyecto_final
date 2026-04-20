<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilosUsuario.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    if(isset($_SESSION["email"])){
        ?>
    <div class="general">
        <?php
        include("cabecera.php");
        include("conexion_bd.php");
        ?>
        <div class="perfil">
            <div class="infousuario">
                <?php
                    $id_usuario = $_SESSION["id_usuario"];
                    $consultaDatos = "SELECT * FROM usuarios WHERE id='$id_usuario'";
                    $datos = $conn->query($consultaDatos);
                    $fila = $datos->fetch_assoc();
                    $foto = "";
                    $mensaje = "";
                    if($fila["foto_perfil"]==="" || $fila["foto_perfil"]===NULL){
                        $foto = "./imagenes/foto_perfil.png";
                        $mensaje = "Establecer foto";
                    } else {
                        $foto = $fila["foto_perfil"];
                        $mensaje = "Actualizar foto";
                    }
                ?>
                <div class="barra-azul">
                    <div class="area-foto">
                        <form action="./panelUsuario/subirImagenPerfil.php" method="POST" enctype="multipart/form-data" id="form-foto">
                            <div class="profile-container-circular">
                                <img src="<?=$foto?>" alt="Foto" class="profile-pic" id="foto-preview">
                                
                                <label for="upload-photo" class="update-overlay">
                                    <span><?=$mensaje?></span>
                                </label>
                                
                                <input type="file" name="fotoPerfil" id="upload-photo" accept="image/*" onchange="document.getElementById('form-foto').submit()">
                            </div>
                        </form>
                    </div>

                    <div class="area-usuario-datos">
                        <h1 class="user-name"><?=$fila["nombre"]?></h1>
                    </div>
                </div>

            </div>



            <div class="informacion">
                <div class="opciones" id="menuOpciones">
                    <p class="opcion" id="perfil"><img src="./imagenes/sesion.png" class="img-opciones"> Mi perfil</p>
                    <p class="opcion" id="pedidos"><img src="./imagenes/mispedidos.png" class="img-opciones"> Mis pedidos</p>
                    <p class="opcion" id="datos"><img src="./imagenes/ubicacion.png" class="img-opciones"> Mis Datos</p>
                    <p class="opcion" id="favoritos"><img src="./imagenes/favorito.png" class="img-opciones"> Favoritos</p>
                    <a href="./cerrarSesion.php" class="opcion"><img src="./imagenes/cerrarSesion.png" class="img-opciones"> Cerrar Sesion</a>
                </div>


                <div class="contenido" id="contenido">
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
                                        <h3>Total <p>(+5,99€ Gastos de Envio)</p>:</h3>
                                        <h3><?=$cabecera["total"]?>€</h3>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
        <?php include("footer.html");?>
    </div> 
    <script src="./JS/scriptPerfil.js"></script>
    <?php
    
    } else {
        header("Location: index.php");
    }
    ?>
</body>
</html>
    