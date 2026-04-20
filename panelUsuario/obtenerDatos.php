<?php
session_start();
include("../conexion_bd.php");

$id_usuario = $_SESSION["id_usuario"];

$consultaDatos = "SELECT * FROM usuarios WHERE id='$id_usuario'";

$datos = $conn->query($consultaDatos);

$fila = $datos->fetch_assoc();

?>
<h1>Perfil de Usuario</h1>
<div class="generalDatos">
    <div class="datosimg">
        <div class="img">
            <img src="<?=$fila["foto_perfil"]?>">
        </div>
        <p class="negrita"><?=$fila["nombre"]?></p>
        <p><?=$fila["email"]?></p>
    </div>


    <div class="datosTotal">
        <h2>Mis Datos Personales</h2>
        <h4>Información de contacto</h4>
        <form action="./panelUsuario/actualizarDatos.php" method="post">
            <div class="datosPersonales">
                <p>Nombre Completo</p>
                <input type="text" name="nombre" value="<?=$fila["nombre"]?>">
            </div>

            <div class="datosPersonales">
                <p>Correo Electrónico</p>
                <input type="text" value="<?=$fila["email"]?>" readonly>
            </div>

            <div class="datosPersonales">
                <p>Dirección</p>
                <input type="text" name="direccion" value="<?=$fila["direccion"]?>">
            </div>

            <div class="datosPersonales">
                <p>Provincia</p>
                <input type="text" name="provincia" value="<?=$fila["provincia"]?>">
            </div>

            <div class="datosPersonales">
                <p>Municipio</p>
                <input type="text" name="municipio" value="<?=$fila["municipio"]?>">
            </div>

            <div class="datosPersonales">
                <p>Teléfono</p>
                <input type="number" name="telefono" min="600000000" max="999999999" value="<?=$fila["telefono"]?>">
            </div>

            <h4>Detalles de cuenta</h4>
            <div class="detallesCuenta">
                <div class="fechaRegistro">
                    <p>Fecha de Registro</p>
                    <p><?=$fila["fecha_registro"]?></p>
                </div>
                <div class="estadoCuenta">
                    <p>Estado</p>
                    <p class="activo">Activo</p>
                </div>
                
            </div>

            <div class="actualizar">
                <button type="submit" class="btn">Actualizar Datos</button>
            </div>
        </form>
    </div>  
</div>