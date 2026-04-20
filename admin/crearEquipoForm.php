<?php
session_start();
include("../conexion_bd.php");
?>
<form action="./admin/crearEquipo.php" method="post" enctype="multipart/form-data">
    <div class="container-formulario">
        <div class="formulario-nuevo-producto">
            <div class="modal__header">
                <span class="modal__title">Crear Nueva Liga</span>
                <p id="mensajes"></p>
                <?php
                $consultaLiga = "SELECT * FROM ligas";
                $datosLiga = $conn->query($consultaLiga);
                ?>
            </div>
            <div class="modal__body">
                <div class="input">
                    <label class="input__label">Nombre</label>
                    <input class="input__field" type="text" name="nombreP"> 
                </div>
                <div class="input">
                    <label for="liga" class="input__label">Liga a la que pertenece</label>
                    <select name="ligaP" id="ligaP" class="input__field">
                    <?php
                    while($filas=$datosLiga->fetch_assoc()){
                        ?><option value="<?=$filas["id"]?>"><?=$filas["liga"]?></option><?php
                    }
                    ?>
                    </select>
                </div>
            <div class="modal__footer">
                <button class="button button--primary" name="btn-subir">Crear Equipo</button>
            </div>
        </div>
    </div>
</form>