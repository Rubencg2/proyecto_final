<?php
session_start();
include("../conexion_bd.php");
?>
<form action="./admin/crearLiga.php" method="post" enctype="multipart/form-data">
    <div class="container-formulario">
        <div class="formulario-nuevo-producto">
            <div class="modal__header">
                <span class="modal__title">Crear Nueva Liga</span>
                <p id="mensajes"></p>
            </div>
            <div class="modal__body">
                <div class="input">
                    <label class="input__label">Nombre</label>
                    <input class="input__field" type="text" name="nombreP"> 
                </div>

                <div class="input">
                    <label for="liga" class="input__label">Pais</label>
                    <select name="pais" id="pais" class="input__field">
                    <?php
                    $paises = [
                                "Argentina",
                                "Brasil",
                                "Uruguay",
                                "Colombia",
                                "Chile",
                                "Perú",
                                "Ecuador",
                                "Paraguay",
                                "México",
                                "Estados Unidos",
                                "Canadá",
                                
                                "España",
                                "Francia",
                                "Alemania",
                                "Italia",
                                "Inglaterra",
                                "Portugal",
                                "Países Bajos",
                                "Bélgica",
                                "Croacia",
                                "Serbia",
                                "Suiza",
                                "Suecia",
                                "Dinamarca",
                                "Noruega",
                                "Polonia",
                                "Ucrania",
                                "Rusia",
                                
                                "Turquía",
                                "Grecia",
                                "Escocia",
                                "Gales",
                                "Irlanda",
                                
                                "Marruecos",
                                "Argelia",
                                "Túnez",
                                "Egipto",
                                "Nigeria",
                                "Camerún",
                                "Senegal",
                                "Ghana",
                                "Sudáfrica",
                                
                                "Arabia Saudita",
                                "Emiratos Árabes Unidos",
                                "Catar",
                                "Irán",
                                "Japón",
                                "Corea del Sur",
                                "China",
                                "Australia"
                    ];

                    foreach ($paises as $pais){
                        ?><option value="<?=$pais?>"><?=$pais?></option><?php
                    }

                    ?>
                    </select>
                </div>
            <div class="modal__footer">
                <button class="button button--primary" name="btn-subir">Crear Liga</button>
            </div>
        </div>
    </div>
</form>