<?php
include("../conexion_bd.php");
$consultaequipos  = "SELECT equipos.id, equipos.equipo, ligas.liga AS nombre_liga
                        FROM equipos
                        INNER JOIN ligas ON equipos.liga = ligas.id";
$resultado = $conn->query($consultaequipos);

if($resultado->num_rows == 0){
    ?><h2>No hay equipos disponibles</h2><?php
} else {
    $equipos = [];
    while($fila = $resultado->fetch_assoc()){
        $equipos[] = $fila;
    }
    ?>
    <div id="contenedor-tabla-equipos">
        <div class="tabla-header">
            <h1>Equipos</h1>
            <button class="btn-editar" id="crearEquipo">Nuevo Equipo</button>
        </div>
        
        <table class="tabla" id="tablaEquipos">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Liga</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($equipos as $fila){ ?>
                <tr>
                    <td data-label="Equipo"><?=$fila["equipo"]?></td>
                    <td data-label="Liga"><?=$fila["nombre_liga"]?></td>
                    <td data-label="Opciones">
                        <form method='POST' action='./admin/eliminarEquipo.php' style='display:inline;'>
                            <input type='hidden' name='id_equipo' value='<?=$fila["id"]?>'>
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