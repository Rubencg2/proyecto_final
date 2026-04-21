<?php
include("../conexion_bd.php");
$consultaProductos = "SELECT * FROM productos";
$productos = $conn->query($consultaProductos);

if($productos->num_rows == 0){
    ?><h2>No hay productos disponibles</h2><?php
} else {
    $filas = [];
    while($fila = $productos->fetch_assoc()){
        $filas[] = $fila;
    }
    ?>

<div id="contenedor-tabla-productos">

    <div class="tabla-header">
        <h1>Productos</h1>
        <button class="btn-editar" id="agregarProducto">Añadir Producto</button>
    </div>

    <table class="tabla" id="tablaProductos">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($filas as $fila){ ?>
            <tr>
                <td data-label="Imagen">
                    <img src="<?=$fila["url_imagen"]?>"
                        alt="<?=$fila["nombre"]?>"
                        class="img-producto"
                        data-id="<?=$fila["id"]?>"
                        style="cursor:pointer;">
                </td>
                <td data-label="Nombre"><?=$fila["nombre"]?></td>
                <td data-label="Descripción"><?=$fila["descripcion"]?></td>
                <td data-label="Precio"><?=$fila["precio"]?>€</td>
                <td data-label="Opciones">
                    <button class='btn-editar' data-id="<?=$fila["id"]?>">Editar</button>
                    <?php
                    if($fila["estado"]==="activo"){
                        ?><button class='btn-editar' data-idD="<?=$fila["id"]?>">Deshabilitar</button><?php
                    } else{
                        ?><button class='btn-editar' data-idH="<?=$fila["id"]?>">Habilitar</button><?php
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="modalEdicion" class="modal">
    <div class="modal-content" id="modal-content">
        <span class="close">X</span>
        <form id="formEditar" action="./admin/actualizar_producto.php" method="post" enctype="multipart/form-data">
            <h3>Editar Producto</h3>

            <input type="hidden" id="edit-id" name="id" value="">

            <label>Imagen actual</label>
            <div style="margin-bottom: 14px;">
                <img id="preview-imagen-actual"
                    src=""
                    alt="Imagen actual">
            </div>


            <label>Cambiar imagen</label>
            <input type="file" id="edit-imagen" name="nueva_imagen" value="">

            <input type="hidden" id="edit-url-imagen-actual" name="url_imagen_actual">


            <label>Nombre del Producto</label>
            <input type="text" id="edit-nombre" name="nombre" value="">

            <label>Descripción Corta</label>
            <textarea id="edit-descripcion" name="descripcion" value=""></textarea>

            <label>Precio (€)</label>
            <input type="number" step="0.01" id="edit-precio" name="precio" value="">

            <button type="submit" class="btn-guardar">Actualizar Información</button>
        </form>
    </div>
</div>

<?php } ?>
