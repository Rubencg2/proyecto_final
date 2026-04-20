<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    include("cabecera.php");
    include("conexion_bd.php");

    $id = $_POST["id_producto"];
    $consultaProducto = "SELECT * FROM productos WHERE id=$id";
    $consultaTallas = "SELECT t.talla, pt.stock
                        FROM tallas t
                        JOIN producto_tallas pt ON t.id = pt.id_talla
                        WHERE pt.id_producto = $id AND pt.stock > 0";
    $datos = $conn->query($consultaProducto);
    $datosTallas = $conn->query($consultaTallas);
    $filas = $datos->fetch_assoc();
    
    ?>
    <div class="generalProducto">
        <div class="imgProducto">
            <img src=<?=$filas["url_imagen"]?> class="imgP">
            <?php
            if(isset($_SESSION["email"])){
                // Consulta si ya está en favoritos
                $consultaFavorito = "SELECT * FROM favoritos WHERE id_usuario = '{$_SESSION['id_usuario']}' AND id_producto = $id";
                $resultadoFavorito = $conn->query($consultaFavorito);
                $esFavorito = $resultadoFavorito->num_rows > 0;
                ?>
                <div class="corazon" onclick="gestionarFavorito(<?=$id?>)">
                    <img src="./imagenes/favorito.png" class="favorito" id="corazon-vacio" 
                        style="<?= $esFavorito ? 'display: none;' : '' ?>">
                    <img src="./imagenes/favoritoAñadido.png" class="favoritoAñadido" id="corazon-lleno" 
                        style="<?= $esFavorito ? '' : 'display: none;' ?>">
                </div>
                <?php
            }
            ?>
            
        </div>
        <form action="carrito.php" method="post">
            <div class="infoProducto">
                <div class="ND">
                    <input type="hidden" name="id_producto" value="<?=$id?>">
                    <div class="nombre"><h1><?=$filas["nombre"]?><h1></div>
                    <div class="descripcion"><p><?=$filas["descripcion"]?></p></div>
                </div>
                <div class="precio"><h3 id="precioP"><?=$filas["precio"]?>€<h3></div>
                <div class="cantidad">
                    <label for="cantidad">Cantidad</label>
                    <select name="cantidad" id="cantidad">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="tallas">
                    <h3>Tallas Disponibles</h3>
                    <?php
                    if($datosTallas->num_rows==0){
                        ?>
                        <h5>No hay Stock disponible</h5>
                        <?php
                    } else {
                        while($tallas = $datosTallas->fetch_assoc()){
                            ?>
                            <label class="talla-item">
                                <input type="radio" name="talla_seleccionada" value="<?=$tallas["talla"]?>" required>
                                <span><?=$tallas["talla"]?>(<?=$tallas["stock"]?>)</span>
                            </label>
                            <?php
                        }
                    }
                    ?>  
                </div>
                <?php
                if($datosTallas->num_rows!=0){
                    ?>
                    <button class="btn btn-primary mt-auto" type="submit" name="añadir" id="añadirCarrito">Añadir al Carrito</button>
                    <?php
                }
                ?>
            </div>  
        </form>
    </div>
    <?php include("footer.html");?>
    <script src="./JS/script.js"></script>
</body>
</html>