<?php
include("../conexion_bd.php");

$consultaUsuarios = "SELECT * FROM usuarios";
$datos = $conn->query($consultaUsuarios);
$usuarios = [];

while($fila = $datos->fetch_assoc()){
    $usuarios[] = $fila;
}
?>

<div id="contenedor-tabla-usuarios">
    <div class="tabla-header">
        <h1>Usuarios</h1>
    </div>

    <table class="tabla" id="tablaUsuarios">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Provincia</th>
                <th>Municipio</th>
                <th>Teléfono</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $fila){ ?>
            <tr>
                <td data-label="Nombre"><?=$fila["nombre"]?></td>
                <td data-label="Email"><?=$fila["email"]?></td>
                <td data-label="Direccion"><?php
                    if($fila["direccion"]=== "" || $fila["direccion"]=== NULL){
                        echo "Sin Completar";
                    } else {
                        echo $fila["direccion"];
                    }?>
                </td>
                        
                <td data-label="Provincia"><?php
                    if($fila["provincia"]=== "" || $fila["provincia"]=== NULL){
                        echo "Sin Completar";
                    } else {
                        echo $fila["provincia"];
                    }?>
                </td>

                <td data-label="Municipio"><?php
                    if($fila["municipio"]=== "" || $fila["municipio"]=== NULL){
                        echo "Sin Completar";
                    } else {
                        echo $fila["municipio"];
                    }?>
                </td>

                <td data-label="Telefono"><?php
                    if($fila["telefono"]=== "" || $fila["telefono"]=== NULL){
                        echo "Sin Completar";
                    } else {
                        echo $fila["telefono"];
                    }?>
                </td>

                <td data-label="Opciones">
                    <form method='POST' action='./admin/eliminarUsuario.php' style='display:inline;'>
                        <input type='hidden' name='id_usuario' value='<?=$fila["id"]?>'>
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