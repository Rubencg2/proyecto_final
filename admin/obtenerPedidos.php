<?php
include("../conexion_bd.php");
$consultapedidos = "SELECT p.fecha, p.total, p.estado, u.email FROM pedidos p INNER JOIN usuarios u ON p.id_usuario = u.id";
$pedidos_res = $conn->query($consultapedidos);

if($pedidos_res->num_rows == 0){
    ?><h2>No hay pedidos pendientes</h2><?php
} else {
    $pedidos = [];
    while($fila = $pedidos_res->fetch_assoc()){
        $pedidos[] = $fila;
    }
    ?>
    
    <div id="contenedor-tabla-pedidos">
        <div class="tabla-header">
            <h1>Pedidos</h1>
        </div>

        <table class="tabla display nowrap responsive" id="tablaPedidos" style="width:100%">
            <thead>
                <tr>
                    <th>Usuario (Email)</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pedidos as $fila){ ?>
                <tr>
                    <td data-label="Usuario (Email)"><?=$fila["email"]?></td>
                    <td data-label="Fecha"><?=$fila["fecha"]?></td>
                    <td data-label="Total"><?=$fila["total"]?>€</td>
                    <td data-label="Estado"><?=$fila["estado"]?></td>
                    <td data-label="Opciones">
                    <?php if($fila["estado"]!=='completado'){
                       ?><button class="btn-editar" id="btn-completar">Completar</button><?php
                    }
                    ?> 
                    </td>   
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>