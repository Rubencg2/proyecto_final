<header>
<a href="./index.php">
    <div class="logo">
        <img src="./imagenes/logo-movil.png" class="img-logo-movil">
        <img src="./imagenes/logo-escritorio.png" class="img-logo-escritorio">
    </div>
</a>




<div class="iconos">
    <div class="hamburguesa">
        <img src="./imagenes/hamburguesaB.png" alt="menu" class="img-hamburguesa">
        <img src="./imagenes/xB.png" alt="cerrar" class="img-cerrar">
    </div>
    <div class="iconos-menu">
        <?php
        if(isset($_SESSION["email"]) && $_SESSION["rol_usuario"]==="admin"){
            ?>
            <a class="btn-azul-oscuro" id="subir" href="./panelControl.php">Panel de Control</a>
            <?php
        }
        ?>
        <img src="./imagenes/lupa.png" class="img-cab" id="busqueda" style="cursor:pointer;">

        <?php
        if(!isset($_SESSION["email"])){
            ?><a href="./login.php"><img src="./imagenes/sesionB.png" class="img-cab"></a><?php
        } else {
            ?><a href="./paginaUsuario.php"><img src="./imagenes/sesionB.png" class="img-cab"></a><?php
        }
        ?>
        
        <a href="./verCarrito.php"><img src="./imagenes/carrito.png" class="img-cab"></a>
    </div>
</div>
<!-- BARRA DE BUSQUEDA -->
    <form action="buscar.php" method="post" class="barra-desplegable" id="buscador-formulario">
        <input type="search" name="buscar" placeholder="Busca tu producto" class="busqueda">
        <input type="submit" value="Buscar" class="btn-buscar-submit">
    </form>
</header>



<!-- MENU DE NAVEGACION-->
<nav class="nav">
    <ul>
        <li class="logo-index">
            <a href="./index.php">
                <img src="./imagenes/logo-movil.png" class="img-logo-escritorio ocultar" id="logo-Movil">
            </a>
        </li>
        <li><a href="./index.php">Inicio</a></li>
        <li><a href="./camisetas.php">Camisetas</a></li>
        <li><a href="./chandals.php">Chandals</a></li>
        <li><a href="./retros.php">Camisetas Retro</a></li>
        <li><a href="./selecciones.php">Selecciones</a></li>
        <?php
        if(isset($_SESSION["email"]) && $_SESSION["rol_usuario"]==="admin"){
            ?>
            <li><a class="panel-Responsivo" href="./panelControl.php">Panel de control</a></li>
            <?php
        }?>

        <?php
        if(!isset($_SESSION["email"])){
            ?><li><a href="./login.php"><img src="./imagenes/sesionB.png" class="img-cab ocultar" id="img-login"></a></li><?php
        } else {
            ?><li><a href="./paginaUsuario.php"><img src="./imagenes/sesionB.png" class="img-cab ocultar" id="img-pagUsu"></a></li><?php
        }
        ?>
        
        <li><a href="./verCarrito.php"><img src="./imagenes/carrito.png" class="img-cab ocultar" id="img-carrito"></a></li>

        <?php
        if(!isset($_SESSION["email"])){
            ?><li class="login-Responsivo"><a href="./login.php">Iniciar Sesion</a></li><?php
        } else {
            ?><li class="login-Responsivo"><a href="./paginaUsuario.php">Mi perfil</a></li><?php
        }
        ?>
        <li class="carrito-Responsivo"><a href="./verCarrito.php">Carrito</a></li>
    </ul>
</nav>