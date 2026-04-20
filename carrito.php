<?php
session_start();
include("conexion_bd.php");


if (isset($_POST['id_producto']) && isset($_POST['talla_seleccionada'])) {
    $id = $_POST['id_producto'];
    $talla = $_POST['talla_seleccionada'];
    $cantidad = $_POST['cantidad'];
    if(isset($_SESSION["email"])){

        // Consultamos la base de datos para asegurar que los datos son reales
        $consulta = "SELECT nombre, precio, url_imagen FROM productos WHERE id = $id";
        $datos = $conn->query($consulta);

        $producto = $datos->fetch_assoc();

        if($producto){

            $indice = $id . "_" . $talla;

            // Comprobamos si ya existe carrito
            $id_usuario = $_SESSION["id_usuario"];
            $consultaComprobar = "SELECT id, cantidad FROM carrito WHERE id_usuario='$id_usuario' AND id_producto='$id' AND talla='$talla'";
            $datos = $conn->query($consultaComprobar);
            $item = $datos->fetch_assoc();
            if ($item) {
                // Si ya existe este producto con esta talla, sumamos la cantidad
                $id_item = $item["id"];
                $nueva_cantidad = $item['cantidad'] + $cantidad;
                $consultaActualizar = "UPDATE carrito SET cantidad='$nueva_cantidad' WHERE id='$id_item'";
                $conn->query($consultaActualizar);
            } else {
                // Si es nuevo, lo añadimos
                $consultaInsertar = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ('$id_usuario', '$id', '$cantidad')";
                $conn->query($consultaInsertar);
            }

            // Si ya existe este producto con esta talla, sumamos la cantidad
            if (isset($_SESSION['carrito'][$indice])) {
                $_SESSION['carrito'][$indice]['cantidad'] += $cantidad;
            } else {
                // Si es nuevo, lo añadimos
                $_SESSION['carrito'][$indice] = array(
                    "id" => $id,
                    "nombre" => $producto['nombre'],
                    "precio" => $producto['precio'],
                    "talla" => $talla,
                    "cantidad" => $cantidad,
                    "imagen" => $producto['url_imagen']
                );
            }
        }
        } else {
            $indice = $id . "_" . $talla;
            if (isset($_SESSION['temp_carrito'][$indice])) { 
                $_SESSION['temp_carrito'][$indice]['cantidad'] += $cantidad;
            } else {
                $consultaProducto = "SELECT * FROM productos WHERE id='$id'";
                $datos = $conn->query($consultaProducto);
                if($datos){
                    $fila = $datos->fetch_assoc();
                    $_SESSION['temp_carrito'][$indice] = array(
                        "id" => $id,
                        "nombre" => $fila['nombre'],
                        "precio" => $fila['precio'],
                        "talla" => $talla,
                        "cantidad" => $cantidad,
                        "imagen" => $fila['url_imagen']
                    );
                }
            }
            header("Location: verCarrito.php");
            exit();
        }
        header("Location: verCarrito.php");
        exit();
    }
    

    




