<?php
session_start();
include("../conexion_bd.php");
?>
<form action="./admin/subirProducto.php" method="post" enctype="multipart/form-data">
    <div class="container-formulario">
        <div class="formulario-nuevo-producto">
            <div class="modal__header">
                <span class="modal__title">Subir Nuevo Producto</span>
                <p id="mensajes"></p>
            </div>
            <?php
            $consulta = "SELECT * FROM categoria";
            $datos = $conn->query($consulta);
            $consultaLiga = "SELECT * FROM ligas";
            $datosLiga = $conn->query($consultaLiga);
            $consultaTalla = "SELECT * FROM tallas";
            $datosTalla = $conn->query($consultaTalla);
            $consultaEquipos = "SELECT * FROM equipos";
            $datosEquipo = $conn->query($consultaEquipos);
            ?>
            <div class="modal__body">
                <div class="input">
                    <label class="input__label">Nombre</label>
                    <input class="input__field" type="text" name="nombreP"> 
                </div>
                <div class="input">
                    <label class="input__label">Descripcion</label>
                    <textarea class="input__field input__field--textarea" name="descripcionP"></textarea>
                </div>
                <div class="input">
                    <label class="input__label">Precio</label>
                    <input class="input__field" type="number" step="0.01" min="0" name="precioP"> 
                </div>
                <div class="input">
                    <label class="input__label">Stock</label>
                    <input class="input__field" type="number" name="stockP"> 
                </div>
                <div class="input">
                    <label for="equipoP" class="input__label">Equipo</label>
                    <select name="equipoP" id="equipoP" class="input__field">
                    <?php
                    while($filaE=$datosEquipo->fetch_assoc()){
                        ?><option value="<?=$filaE["id"]?>"><?=$filaE["equipo"]?></option><?php
                    }
                    ?>
                    </select>
                </div>

                <div class="input">
                    <label for="liga" class="input__label">Liga</label>
                    <select name="ligaP" id="ligaP" class="input__field">
                    <?php
                    while($filas=$datosLiga->fetch_assoc()){
                        ?><option value="<?=$filas["id"]?>"><?=$filas["liga"]?></option><?php
                    }
                    ?>
                    </select>
                </div>

                <div class="input">
                    <label class="input__label">Imagen del producto</label>
                    <input class="input__field" type="file" name="archivo_subida" id="archivo_subida">
                </div>

                <div class="input">
                    <label for="categoria" class="input__label">Categoria</label>
                    <select name="categoriaP" id="categoriaP" class="input__field">
                    <?php
                    while($fila=$datos->fetch_assoc()){
                        ?><option value="<?=$fila["id"]?>"><?=$fila["nombre"]?></option><?php
                    }
                    ?>
                    </select>
                </div>
                <div class="input">
                    <label for="tallaP" class="input__label">Talla</label>
                    <select name="tallaP" id="tallaP" class="input__field">
                    <?php
                    while($filaT=$datosTalla->fetch_assoc()){
                        ?><option value="<?=$filaT["id"]?>"><?=$filaT["talla"]?></option><?php
                    }
                    ?>
                    </select>
                </div>
                <div class="input">
                    <label class="input_label">Etiquetas para Buscar</label>
                    <textarea name="etiquetas"></textarea>
                </div>
            </div>
            <div class="modal__footer">
                <button class="button button--primary" name="btn-subir">Subir Producto</button>
            </div>
        </div>
    </div>
</form>