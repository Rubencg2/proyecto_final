<?php
session_start();

include("../conexion_bd.php");

$consultaPT = "SELECT p.nombre, p.url_imagen, p.id, p.precio, t.talla, pt.stock 
                FROM productos p
                JOIN producto_tallas pt ON p.id = pt.id_producto
                JOIN tallas t ON t.id = pt.id_talla";

$productos = $conn->query($consultaPT);

if($productos->num_rows==0){
    ?><h2>No hay productos disponibles</h2><?php
} else {
    ?>
        <div id="contenedor-tabla-productos">
        <h1 class="titleStock">Productos</h1>
        <table class="tabla" id="tablaStock">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Talla</th>
                    <th>Stock</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $productos->fetch_assoc()){ ?>
                <tr>
                    <td>
                        <img src="<?=$fila["url_imagen"]?>" 
                            alt="<?=$fila["nombre"]?>" 
                            class="img-producto" 
                            data-id="<?=$fila["id"]?>" 
                            style="cursor:pointer;">
                    </td>
                    <td><?=$fila["nombre"]?></td>
                    <td><?=$fila["precio"]?> €</td>
                    <td><?=$fila["talla"]?></td>
                    <td><?=$fila["stock"]?> Uds.</td>
                    <td>
                        <button class="btn-stock" data-id="<?=$fila["id"]?>">Editar</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
}
?>


<div id="modalEdicion" class="modal">
    <div class="modal-content" id="modal-content">
        <span class="close">X</span>
        <form id="formEditar" action="./admin/actualizarGestionStock.php" method="post">
            <h3>Editar Producto</h3>
            
            <input type="hidden" id="edit-id" name="id" value="">

            <label>Nombre del Producto</label>
            <input type="text" id="edit-nombre" name="nombre" value="">


            <label>Precio (€)</label>
            <input type="number" step="0.01" id="edit-precio" name="precio" value="">

            <input type="hidden" id="edit-talla" name="id_talla" value="">

            <label>Stock</label>
            <input type="number" step="0" id="edit-stock" name="stock" value="">

            <button type="submit" class="btn-guardar">Actualizar Información</button>
        </form>
    </div>
</div>

<script>
    document.getElementById("modalEdicion").style.display = "none";
</script>
