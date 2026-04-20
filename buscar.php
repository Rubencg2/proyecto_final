<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="./CSS/estilosBuscar.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body> 
    <div class="general">
        <?php
        include("cabecera.php");
        include("conexion_bd.php");
        $busqueda = $_POST["buscar"];
        $consultaProductos = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%' OR etiquetas LIKE '%$busqueda%'";
        $productos = $conn->query($consultaProductos);
        ?>
        <div class="mensajeBusqueda">
            <h3>Productos encontrados:<?=$productos->num_rows?></h3>
        </div>
        <div class="productos">
            <div class="row row-cols-1 row-cols-md-3 g-4"> 
                <?php
                if($productos->num_rows==0){
                    ?><h2>No hay productos disponibles</h2><?php
                } else {
                    while($filasP=$productos->fetch_assoc()){
                    ?>
                    <div class="col"> <form action="detallesProducto.php" method="post" class="h-100">
                            <div class="card h-100" style="width: 18rem;">
                                <img src="<?=$filasP["url_imagen"]?>" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column">
                                    <input type="hidden" name="id_producto" value="<?=$filasP["id"]?>">
                                    <h5 class="card-title"><?=$filasP["nombre"]?></h5>
                                    <p class="card-text"><?=$filasP["descripcion"]?></p>
                                    <div class="mt-auto">
                                        <h5 class="card-text"><?=$filasP["precio"]?>€</h5>
                                        <button class="btn btn-primary w-100" type="submit" name="verDetalles">Ver detalles</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
        include("footer.html");
        ?>
    </div>
    <?php
    ?>
    <script src="./JS/script.js"></script>
</body>
</html>