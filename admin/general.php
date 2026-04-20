<?php
session_start();
include("../conexion_bd.php");
?>

<h1 class="titulo">Panel de Administración</h1>
<?php
$dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
$fechaActual = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n')-1] . " de " . date('Y');
?>
<div class="saludo"><h2>Bienvenido, <?=$_SESSION["nombreUsuario"]?></h2><p>Hoy es, <?=$fechaActual?></p></div>
<div class="dashboard">
    <div class="card">
        <div class="card-icon">📦</div>
        <div class="card-info">
            <?php
                $consultaPendientes = "SELECT * FROM pedidos WHERE estado='pendiente'";
                $datos= $conn->query($consultaPendientes);
            ?>
            <span class="card-title">Pedidos Pendientes</span>
            <span class="card-value"><?=$datos->num_rows?></span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">💰</div>
        <div class="card-info">
            <?php
            $hoy = date('Y-m-d');
            $consultaVentas = "SELECT total FROM pedidos WHERE fecha='$hoy'";
            $datosV = $conn->query($consultaVentas);
            $generado = 0;
            while($fila = $datosV->fetch_assoc()){
                $generado += $fila["total"];
            }
            ?>
            <span class="card-title">Ventas Hoy</span>
            <span class="card-value"><?=$generado?>€</span>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">👥</div>
        <div class="card-info">
            <?php
            $consultaUsuarios = "SELECT * FROM usuarios WHERE fecha_registro='$fechaActual'";
            $datosU = $conn->query($consultaUsuarios);
            ?>
            <span class="card-title">Nuevos Clientes</span>
            <span class="card-value"><?=$datosU->num_rows?></span>
        </div>
    </div>

    <div class="card alert">
        <div class="card-icon">⚠️</div>
        <div class="card-info">
            <?php
            $consultaProductos = "SELECT * FROM producto_tallas WHERE stock<='10'";
            $datosP = $conn->query($consultaProductos);
            ?>
            <span class="card-title">Stock Crítico</span>
            <span class="card-value"><?=$datosP->num_rows?></span>
        </div>
    </div>
</div>

<div class="botones">
    <button class="btn-principal" id="subirProducto">[+] Añadir Producto</button>
    <button class="btn-principal" id="gestionarStock">[📦]Gestionar Stock</button>
</div>
<script src="./JS/script.js"></script>