<?php 
session_start();
$id_categoria = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camisetas || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    
    <div class="general">
        <?php
        include("cabecera.php");
        ?>
        <aside>
            <h3>Filtros</h3><br>
            <div class="filtros-escritorio">  
            <?php
                include("conexion_bd.php");
                // CONSULTA PARA MOSTRAR LAS LIGAS DISPONIBLES EN LOS FILTROS
                $consultaLigas = "SELECT * FROM ligas";
                $datos = $conn->query($consultaLigas);
                ?>
                    <h4 class="text-ligas">Ligas</h4>
                    <input type="radio" id="todas" name="filtro_liga" value="todas" class="filtro">
                    <label for="todas">Todas las ligas</label><br>
                    <?php
                    while($filas=$datos->fetch_assoc()){
                    ?>
                        <input type="radio" id=<?=$filas["id"]?> name="filtro_liga" value=<?=$filas["id"]?> class="filtro">
                        <label for=<?=$filas["id"]?>><?=$filas["liga"]?></label><br>
                    <?php
                    }
                    ?>
            <br>
            <?php
                //CONSULTA PARA MOSTRAR LOS EQUIPOS DISPONIBLES EN FILTROS 
                $consultaEquipos = "SELECT * FROM equipos";
                $datosEquipos = $conn->query($consultaEquipos);
                ?>
                <h4 class="text-equipos">Equipos</h4>
                <input type="radio" id="todos" name="filtro_equipo" value="todos" class="filtro">
                <label for="todos">Todos los equipos</label><br>
                <?php
                $contadorEquipo = 0;
                while($fila=$datosEquipos->fetch_assoc()){
                    if($contadorEquipo === 5) echo '<div class="equipos-extra" id="equipos-extra">';
                ?>
                    <input type="radio" id=<?=$fila["id"]?> name="filtro_equipo" value=<?=$fila["id"]?> class="filtro">
                    <label for=<?=$fila["id"]?>><?=$fila["equipo"]?></label><br>
                <?php
                    $contadorEquipo++;
                }
                if($contadorEquipo > 5) echo '</div>';
                if($contadorEquipo > 5){
                ?>
                <button type="button" class="btn-ver-mas-equipos" id="btnVerMasEquipos" onclick="toggleEquipos()">
                    <i class="ti ti-chevron-down" id="iconoEquipos"></i> Ver más
                </button>
                <?php } ?>

                <br>
            <?php
                //Filtro de precio
                $consultaPrecio = "SELECT MAX(precio) AS precio FROM productos";
                $dato = $conn->query($consultaPrecio);
                $filaP = $dato->fetch_assoc();


                ?>
                <h4 class="text-equipos">Precio Máximo</h4>
                <div class="range-container">
                    <output id="burbuja" class="burbuja"></output>
                    <input 
                        type="range" 
                        id="rango" 
                        min="0" 
                        max="<?=$filaP['precio']?>" 
                        value="<?=$filaP['precio']?>" 
                        step="1">
                </div>

                <?php
                //CONSULTA PARA MOSTRAR LAS TALLAS
                $consultaTallas = "SELECT * FROM tallas";
                $datosTallas = $conn->query($consultaTallas);
                ?>
                <h4 class="text-ligas">Tallas</h4>
                <input type="radio" id="todos" name="filtro_tallas" value="todos" class="filtro">
                <label for="todos">Todas las tallas</label><br>
                <?php
                while($fila=$datosTallas->fetch_assoc()){
                ?>
                    <input type="radio" id=<?=$fila["id"]?> name="filtro_tallas" value=<?=$fila["id"]?> class="filtro">
                    <label for=<?=$fila["id"]?>><?=$fila["talla"]?></label><br>
                <?php
                }
                ?>

                <br>
            </div>

            



            <!-- FILTROS PARA MODO RESPONSIVO -->

            <!-- FILTROS PARA LIGAS -->
                <div class="filtros-responsivo">
                    <div class="resposivo-ligas">
                        <select name="ligasRR" id="ligasR">
                            <option value="todas">Todas las ligas</option>
                            <?php
                            $datos->data_seek(0);
                            while($filas=$datos->fetch_assoc()){
                                ?>
                                <option value="<?=$filas["id"]?>"><?=$filas["liga"]?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <!-- FILTROS PARA EQUIPOS -->
                    <div class="resposivo-equipos">
                        <select name="equiposR" id="equiposR">
                            <option value="todos">Todos los equipos</option>
                            <?php
                            $datosEquipos->data_seek(0);
                            while($fila=$datosEquipos->fetch_assoc()){
                                ?>
                                <option value="<?=$fila["id"]?>"><?=$fila["equipo"]?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <!-- FILTROS PARA TALLAS -->
                    <div class="resposivo-tallas">
                        <select name="tallasR" id="tallasR">
                            <option value="todos">Todas las tallas</option>
                            <?php
                            $datosTallas->data_seek(0);
                            while($fila=$datosTallas->fetch_assoc()){
                                ?>
                                <option value="<?=$fila["id"]?>"><?=$fila["talla"]?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
        </aside>
        <div class="productos">
            <input type="hidden" id="id_categoria" value="1">
            <div id="contenedorProductos" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3"> 
                <?php
                include("obtenerProductos.php");?>
            </div>
        </div>
        <?php
        include("footer.html");
        ?>
    </div>
    <script src="./JS/script.js"></script>
</body>
</html>