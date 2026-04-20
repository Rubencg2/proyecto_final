<?php
include("../conexion_bd.php");
$consultaLigas = "SELECT * FROM ligas";
$resultado = $conn->query($consultaLigas);

if($resultado->num_rows == 0){
    ?><h2>No hay ligas disponibles</h2><?php
} else {
    $ligas = [];
    while($fila = $resultado->fetch_assoc()){
        $ligas[] = $fila;
    }
    ?>
    <div id="contenedor-tabla-ligas">
        <div class="tabla-header">
            <h1>Ligas</h1>
            <button class="btn-editar" id="crearLiga">Nueva Liga</button>
        </div>
        
        <table class="tabla" id="tablaLigas">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>País</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ligas as $fila){ ?>
                <tr>
                    <td data-label="Liga"><?=$fila["liga"]?></td>
                    <td data-label="Pais"><?=$fila["pais"]?></td>
                    <td>
                        <form method='POST' action='./admin/eliminarLiga.php' style='display:inline;'>
                            <input type='hidden' name='id_liga' value='<?=$fila["id"]?>'>
                            <button type='submit' class="btn-papelera">
                                <img src="./imagenes/papelera.png" alt="papelera" class="img-papelera">
                            </button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>