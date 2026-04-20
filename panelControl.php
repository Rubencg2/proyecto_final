<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/estilosPanel.css">
    <link rel="stylesheet" href="./CSS/formularioSubirP.css">
</head>
<body>
    <?php
    if(isset($_SESSION["email"]) && $_SESSION["rol_usuario"]==="admin"){
        include("./conexion_bd.php");
        ?>
        <button class="btn-abrir-menu" id="btn-abrir-menu">☰</button>
        <div class="overlay-menu" id="overlay-menu"></div>
        
        <div class="general-panel">
            <aside class="menu" id="menuPanel">
                <div class="logo">
                    <a href="index.php"><img src="./imagenes/logo-movil.png" alt="logo" class="img-logo" id="img-logo"></a>
                    <img src="./imagenes/flecha-izquierda.png" alt="flecha" class="flecha-iz" id="flecha-iz">
                    <img src="./imagenes/flecha-derecha.png" alt="flecha" class="flecha-der" id="flecha-der">
                </div>
                <div class="general">
                    <a class="analiticas" id="btn-general">Panel General</a>
                </div>
                <div class="general-gestion">
                    <div class="gestion">
                        <button class="btn-gestion" id="btn-gestion">Gestión</button>
                    </div>
                    <ul class="lista-gestion" id="lista-gestion">
                        <li id="usuarios">Usuarios</li>
                        <li id="productos">Productos</li>
                        <li id="ligas">Ligas</li>
                        <li id="equipos">Equipos</li>
                        <li id="pedidos">Pedidos</li>
                    </ul>
                </div> 
                <div class="general-analiticas">
                    <a class="analiticas" id="btn-analiticas">Analíticas</a>
                </div>
            </aside>


            <section class="informacion" id="informacion">
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
            </section>
        </div>
        <?php
    } else {
        header("Location: index.php");
    }
    ?> 
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="./JS/scriptPanel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>