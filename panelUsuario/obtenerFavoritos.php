<?php
session_start();
include("../conexion_bd.php");

$id_usuario = $_SESSION["id_usuario"];
$consultaFavoritos = "SELECT p.id, p.nombre, p.url_imagen, p.precio, p.descripcion
                        FROM favoritos f
                        JOIN productos p ON f.id_producto = p.id
                        WHERE f.id_usuario = '$id_usuario'";

$datos = $conn->query($consultaFavoritos);

?>
<h1>Mi Lista de Favoritos</h1>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-5 mb-5">
    <?php
    while($filasP=$datos->fetch_assoc()){
        ?>
        <div class="col"> <form action="detallesProducto.php" method="post" class="h-100">
            <div class="card h-100 w-100">
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
    ?>
</div>