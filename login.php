<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion || La casa del futbol</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
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
                <p class="title">Iniciar Sesion</p>
                <?php if(isset($_GET['error'])){
                    ?>
                    <p class="mensajeError" id="mensajeError">Email o contraseña incorrectos</p>
                    <?php
                }
                if(isset($_GET['correcto'])){
                    ?>
                    <p class="mensajeOk" id="mensajeOk">Usuario Registrado correctamente</p>
                    <?php
                }
                ?>
                
                <form class="form" action="comprobarCredenciales.php" method="post">
                    <div class="input-group">
                        <label for="username">Email</label>
                        <input type="email" name="email" id="email" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="contrasena" id="contrasena" placeholder="">
                        <div class="forgot">
                            <a rel="noopener noreferrer" href="./contrasenaOlvidada.php">Has olvidado tu contraseña?</a>
                        </div>
                    </div>
                    <button class="sign">Iniciar Sesion</button>
                </form>
                <p class="signup">No tienes cuenta
                    <a rel="noopener noreferrer" href="./registro.php" class="">Registrarse</a>
                </p>
            </div>
        </div>
    </div>
    <script src="./JS/script.js"></script>
</body>
</html>