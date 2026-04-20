<?php
if(!isset($conn)){
    include("conexion_bd.php");
}

$where = " WHERE 1=1";
if(isset($_POST["filtro_liga"]) && $_POST["filtro_liga"]!= "todas"){
    $id_liga = $_POST["filtro_liga"];
    $where .= " AND id_liga=$id_liga";
}

if(isset($_POST["filtro_equipo"]) && $_POST["filtro_equipo"] != "todos"){
    $id_equipo = $_POST["filtro_equipo"];
    $where .= " AND id_equipo=$id_equipo";
}

if(isset($_POST["filtro_tallas"]) && $_POST["filtro_tallas"] != "todos"){
    $id_talla = $_POST["filtro_tallas"];
    $where .= " AND id IN (
        SELECT id_producto FROM producto_tallas 
        WHERE id_talla = '$id_talla' AND stock > 0
    )";
}

if(isset($_POST["rango"])){
    $precio_max = $_POST["rango"];
    $where .= " AND precio<='$precio_max'";
}

//Filtros para responsivo
if(isset($_POST["filtroR-ligas"]) && $_POST["filtroR-ligas"]!= "todas"){
    $id_ligaR = $_POST["filtroR-ligas"];
    $where .= " AND id_liga=$id_ligaR";
}

if(isset($_POST["filtroR-equipos"]) && $_POST["filtroR-equipos"] != "todos"){
    $id_equipoR = $_POST["filtroR-equipos"];
    $where .= " AND id_equipo=$id_equipoR";
}

if(isset($id_categoria) && !empty($id_categoria)){
    $where .= " AND id_categoria = '$id_categoria'"; 
}
else if(isset($_POST["id_categoria"]) && !empty($_POST["id_categoria"])){
    $where .= " AND id_categoria = '" . $_POST["id_categoria"] . "'";
}

$consultaProductos = "SELECT * FROM productos" . $where;
$productos = $conn->query($consultaProductos);
if($productos->num_rows==0){
    ?><h2>No hay productos disponibles</h2><?php
} else {
    while($filasP=$productos->fetch_assoc()){
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
}
                