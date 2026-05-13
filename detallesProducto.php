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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
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
                <?php
                // Mensaje de error si se llega desde carrito.php con exceso de stock
                if (isset($_GET['error'])):
                    $msgError = match($_GET['error']) {
                        'stock_maximo' => 'Ya tienes el máximo de stock disponible en el carrito.',
                        'sin_stock'    => 'No hay stock disponible para este producto.',
                        default        => ''
                    };
                    if ($msgError): ?>
                        <div class="alert alert-warning py-2 mt-2" role="alert">
                            <?= $msgError ?>
                        </div>
                    <?php endif;
                endif;
                ?>

                <div class="cantidad">
                    <label for="cantidad">Cantidad</label>
                    <select name="cantidad" id="cantidad">
                        <option value="1">1</option>
                    </select>
                    <small id="aviso-stock" style="color:#c0392b;display:none;font-size:.8rem;"></small>
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
                                <input type="radio" name="talla_seleccionada"
                                       value="<?=$tallas["talla"]?>"
                                       data-stock="<?=$tallas["stock"]?>" required>
                                <span><?=$tallas["talla"]?></span>
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

                <script>
                // Actualiza el select de cantidad según el stock de la talla elegida
                document.querySelectorAll('input[name="talla_seleccionada"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        const stock   = parseInt(this.dataset.stock) || 1;
                        const select  = document.getElementById('cantidad');
                        const aviso   = document.getElementById('aviso-stock');
                        select.innerHTML = '';
                        for (let i = 1; i <= stock; i++) {
                            const opt = document.createElement('option');
                            opt.value = i;
                            opt.textContent = i;
                            select.appendChild(opt);
                        }
                        aviso.textContent = 'Stock disponible: ' + stock;
                        aviso.style.display = 'block';
                    });
                });
                </script>
            </div>  
        </form>
    </div>
    <?php include("footer.html");?>
    <script src="./JS/script.js"></script>
</body>
</html>