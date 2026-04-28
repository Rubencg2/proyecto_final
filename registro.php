<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/estilos.css">
    <script src="./JS/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="generalSesion">
        <div class="izquierda">
            <img src="./imagenes/imgsession.png" class="imgSesion">
        </div>
        <div class="derecha">
            <div class="form-container">
                <p class="title">Registrarse</p>
                
                <form class="form" action="registrarUsuarios.php" method="post">
                    <div class="input-group">
                        <label for="nombre">Nombre y Apellidos</label>
                        <input type="text" name="nombre" id="nombre" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="contrasena">Contraseña</label>

                        <div class="contenedorPass">
                            <input type="password" name="contrasena" id="contrasena">
                            <i class="bi bi-eye ojo" onclick="mostrarPass('contrasena', this)"></i>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="confirmarC">Confirmar contraseña</label>

                        <div class="contenedorPass">
                            <input type="password" name="confirmarC" id="confirmarC">
                            <i class="bi bi-eye ojo" onclick="mostrarPass('confirmarC', this)"></i>
                        </div>
                    </div>
                    <?php if(isset($_GET['error_contrasena'])){
                        ?>
                        <p class="mensajeError" id="mensajeError">Las contraseñas no coinciden</p>
                        <?php
                    }

                    if(isset($_GET['error_pass'])){
                        ?>
                        <p class="mensajeError">La contraseña debe tener mínimo 8 caracteres y un número</p>
                        <?php
                    }

                    if(isset($_GET['error3'])){
                        ?>
                        <p class="mensajeError" id="mensajeError">El email introducido ya existe Inicie Sesion</p>
                        <?php
                    }
                    ?><br>
                    <button class="sign">Registrarse</button>
                </form>
                <p class="signup">Ya tienes cuenta?
                    <a rel="noopener noreferrer" href="./login.php" class="">Iniciar Sesion</a>
                </p>
            </div>
        </div>
    </div>
    <script src="./JS/script.js"></script>
</body>
</html>