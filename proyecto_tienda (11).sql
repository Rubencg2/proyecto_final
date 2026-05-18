-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2026 a las 19:44:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_tienda`
--
CREATE DATABASE IF NOT EXISTS `proyecto_tienda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `proyecto_tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` bigint(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `talla` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `id_usuario`, `id_producto`, `cantidad`, `talla`) VALUES
(8, 12, 1, 2, 'M'),
(9, 12, 13, 2, 'M'),
(10, 13, 1, 20, 'XL'),
(11, 13, 13, 1, 'M'),
(13, 14, 1, 1, 'M'),
(14, 14, 13, 2, 'M'),
(16, 14, 1, 1, 'L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'camiseta'),
(3, 'Camisetas retro'),
(2, 'chandal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` bigint(20) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` bigint(11) NOT NULL,
  `cantidad` bigint(20) NOT NULL,
  `talla` varchar(4) NOT NULL,
  `precio_unitario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `id_pedido`, `id_producto`, `cantidad`, `talla`, `precio_unitario`) VALUES
(1, 1, 13, 1, '', 80),
(2, 1, 3, 2, '', 40),
(3, 2, 1, 1, '0', 51),
(4, 3, 1, 1, 'M', 51),
(5, 4, 1, 2, '0', 51),
(6, 5, 1, 2, '0', 51),
(7, 6, 1, 1, 'M', 51),
(8, 7, 1, 1, 'L', 51),
(9, 8, 1, 1, '0', 51),
(10, 9, 1, 3, '0', 51),
(11, 10, 13, 1, 'M', 31),
(12, 16, 1, 1, 'M', 51),
(13, 17, 1, 1, 'M', 51),
(14, 18, 1, 1, 'M', 51),
(15, 19, 13, 1, 'M', 31),
(16, 20, 13, 1, 'M', 31),
(17, 21, 1, 1, 'M', 51),
(18, 22, 7, 1, 'S', 50),
(19, 23, 2, 1, 'M', 40),
(20, 23, 13, 1, 'M', 31),
(21, 24, 1, 1, 'M', 51),
(22, 24, 7, 1, 'S', 50),
(23, 24, 2, 1, 'M', 40),
(24, 24, 13, 1, 'M', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint(20) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `liga` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `equipo`, `liga`) VALUES
(1, 'Barcelona', 1),
(2, 'Manchester city', 2),
(3, 'Real Madrid', 1),
(4, 'Atletico de Madrid', 1),
(9, 'Real Betis', 1),
(10, 'Celta de Vigo', 1),
(11, 'Osasuna', 1),
(12, 'Oviedo', 1),
(13, 'Villarreal', 1),
(14, 'Elche', 1),
(15, 'Arsenal', 2),
(16, 'Aston Villa', 2),
(17, 'Chelsea', 2),
(18, 'Manchester United', 2),
(19, 'TottenHam', 2),
(20, 'Newcastle', 2),
(21, 'Atalanta', 4),
(22, 'Como', 4),
(23, 'Inter Milan', 4),
(24, 'Juventus', 4),
(25, 'Napoli', 4),
(26, 'Lazio', 4),
(27, 'Bayern Munich', 3),
(28, 'Boca Juniors', 5),
(29, 'Borussia Dortmund', 3),
(30, 'Celtic', 5),
(31, 'Milan', 4),
(32, 'Ajax', 5),
(33, 'Santos', 5),
(34, 'PSG', 6),
(35, 'Liverpool', 2),
(36, 'Roma', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `id_usuario`, `id_producto`) VALUES
(8, 13, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ligas`
--

CREATE TABLE `ligas` (
  `id` bigint(20) NOT NULL,
  `liga` varchar(100) NOT NULL,
  `pais` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ligas`
--

INSERT INTO `ligas` (`id`, `liga`, `pais`) VALUES
(1, 'LaLiga', 'España'),
(2, 'Premier League', 'Inglaterra'),
(3, 'Bundesliga', 'Alemania'),
(4, 'Serie A', 'Italia'),
(5, 'Resto del Mundo', 'España'),
(6, 'Ligue 1', 'Francia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `fecha`, `total`, `estado`) VALUES
(1, 2, '2026-03-20', 80.00, 'completado'),
(2, 12, '2026-04-24', 56.99, 'completado'),
(3, 12, '2026-04-24', 56.99, 'pendiente'),
(4, 12, '2026-04-25', 102.00, 'pendiente'),
(5, 12, '2026-04-27', 102.00, 'pendiente'),
(6, 12, '2026-04-27', 56.99, 'pendiente'),
(7, 12, '2026-04-27', 56.99, 'pendiente'),
(8, 12, '2026-04-27', 56.99, 'pendiente'),
(9, 12, '2026-04-27', 153.00, 'pendiente'),
(10, 12, '2026-04-27', 36.98, 'pendiente'),
(11, NULL, '2026-04-30', 2805.00, 'pendiente'),
(12, 13, '2026-04-30', 1938.00, 'pendiente'),
(13, 13, '2026-04-30', 1020.00, 'pendiente'),
(14, 2, '2026-04-30', 56.99, 'pendiente'),
(15, 2, '2026-05-05', 56.99, 'pendiente'),
(16, 2, '2026-05-05', 56.99, 'pendiente'),
(17, 14, '2026-05-11', 56.99, 'pendiente'),
(18, 14, '2026-05-12', 56.99, 'pendiente'),
(19, 14, '2026-05-12', 36.98, 'pendiente'),
(20, 14, '2026-05-12', 36.98, 'pendiente'),
(21, 2, '2026-05-13', 56.99, 'pendiente'),
(22, 2, '2026-05-14', 100.99, 'pendiente'),
(23, 2, '2026-05-14', 76.98, 'pendiente'),
(24, 2, '2026-05-17', 171.98, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'activo',
  `url_imagen` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `precio` double NOT NULL,
  `etiquetas` text NOT NULL,
  `id_liga` bigint(20) NOT NULL,
  `id_equipo` bigint(20) NOT NULL,
  `id_categoria` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `estado`, `url_imagen`, `nombre`, `descripcion`, `precio`, `etiquetas`, `id_liga`, `id_equipo`, `id_categoria`) VALUES
(1, 'activo', './imagenes/productos/barsaLocal25_26.jpeg', 'FC Barcelona Camiseta Local 25/26', 'Camiseta FC Barcelona de local de la temporada 25/26', 30.99, 'barsa barcelona barca ', 1, 1, 1),
(2, 'activo', './imagenes/productos/barsaVisitante25_26.jpg', 'FC Barcelona visitante 25/26', 'Camiseta visitante', 40, 'barsa barcelona barca', 1, 1, 1),
(3, 'activo', './imagenes/productos/chandalCity25_26.webp', 'Chandal Manchester City 25/26', 'Chandal Manchester City de la temporada 25/26', 49.99, 'city manchester', 2, 2, 2),
(6, 'activo', 'imagenes/productos/atletiLocal.jpeg', 'Atletico de Madrid Local 25/26', 'Camiseta Atletico de Madrid temporada 2025/26 Local', 31, 'atleti atletico madrid', 1, 4, 1),
(7, 'activo', 'imagenes/productos/chandalBarsa25_26.webp', 'FC Barcelona 25/26 Entrenamiento', 'Chandal FC Barcelona temporada 2025/26 de entrenamiento', 49.99, 'barsa barcelona barca', 1, 1, 2),
(13, 'activo', './imagenes/productos/retroBarcelona.jpeg', 'Camiseta Retro FC Barcelona 2008/09 Local ', 'Camiseta Retro FC Barcelona 2008/09 Local ', 30.99, '', 1, 1, 3),
(14, 'activo', './imagenes/productos/716cb42e-scaled.jpeg', 'Camiseta Betis 25-26 Local', 'Camiseta Real Betis Temporada 25-26 Local', 30.99, 'Real Betis Local 25-26', 1, 9, 1),
(15, 'activo', './imagenes/productos/10993cea-scaled.jpeg', 'Camiseta Retro Fc Barcelona 10-11 Visitante', 'Camiseta Retro Fc Barcelona temporada 2010/2011 Visitante', 39.99, 'barcelona retro 2010 2011 visitante', 1, 1, 3),
(16, 'activo', './imagenes/productos/cc836f55-scaled.jpg', 'Camiseta Retro Fc Barcelona 08-09 Visitante', 'Camiseta Retro Fc Barcelona temporada 2008/2009 Visitante', 39.99, 'barcelona retro 2008 2009 visitante', 1, 1, 3),
(17, 'activo', './imagenes/productos/1500ef8d-scaled.jpeg', 'Camiseta Retro Manchester City 2011-2012 Local', 'Camiseta Retro Manchester City temporada 2011/2012 Local', 39.99, 'manchester city retro 2011 2012 local', 2, 2, 3),
(18, 'activo', './imagenes/productos/manchester-city-i-2526-hombre-3401194_1200x.jpg', 'Camiseta Manchester City 2025/2026 Local', 'Camiseta Manchester City temporada 2025/2026 Local', 30.99, 'Camiseta Manchester City 2025/2026 Local', 2, 2, 1),
(19, 'activo', './imagenes/productos/img_5114-scaled.jpg', 'Camiseta Real Madrid 2025/26 Local', 'Camiseta Real Madrid temporada 2025/26 Local', 30.99, 'Camiseta Real Madrid 2025/26 Local', 1, 3, 1),
(20, 'activo', './imagenes/productos/madrid-25-26-training-suit-kid-size3.jpg', 'Chandal Real Madrid 2025/26', 'Chandal Real Madrid temporada 2025/2026 sudadera blanca y pantalon Azul', 49.99, 'Chandal Real Madrid 2025/26', 1, 3, 2),
(21, 'activo', './imagenes/productos/920a1a8f.jpg', 'Chandal Atletico de Madrid 2024/25', 'Chandal Atletico de Madrid temporada 2024/2025 sudadera azul y pantalon gris', 49.99, 'Chandal Atletico de Madrid 2024/25', 1, 4, 2),
(22, 'activo', './imagenes/productos/e34929a5-d321-42a9-88a0-cb4d20a95074.jpg', 'Chandal Real Betis 2025/2026', 'Chandal Real Betis temporada 2025/2026 sudadera negra y pantalón negro', 49.99, 'Chandal Real Betis 2025/2026', 1, 9, 2),
(23, 'activo', './imagenes/productos/63d44411-scaled.jpeg', 'Camiseta Celta de Vigo 2025/2026 Local', 'Camiseta Celta de Vigo temporada 2025/2026 Local', 30.99, 'Camiseta Celta de Vigo 2025/2026 Local', 1, 10, 1),
(24, 'activo', './imagenes/productos/images.2jpg.jpg', 'Camiseta Celta de Vigo 2025/2026 Visitante', 'Camiseta Celta de Vigo temporada 2025/2026 Visitante', 30.99, 'Camiseta Celta de Vigo 2025/2026 Visitante', 1, 10, 1),
(25, 'activo', './imagenes/productos/fec47a63-scaled.jpg', 'Camiseta Osasuna 2025/2026 Local', 'Camiseta Osasuna temporada 2025/2026 Local', 30.99, 'Camiseta Osasuna 2025/2026 Local', 1, 11, 1),
(26, 'activo', './imagenes/productos/842b7d1d-scaled.jpg', 'Camiseta Osasuna 2025/2026 Visitante', 'Camiseta Osasuna temporada 2025/2026 Visitante', 30.99, 'Camiseta Osasuna 2025/2026 Visitante', 1, 11, 1),
(27, 'activo', './imagenes/productos/670ddf1f-scaled.jpg', 'Camiseta Osasuna Retro 95/97', 'Camiseta Osasuna Retro 95/97', 30.99, 'Camiseta Osasuna Retro 95/97', 1, 11, 1),
(28, 'activo', './imagenes/productos/2e872b1b-scaled.jpg', 'Camiseta Real Oviedo 2025/2026 Local', 'Camiseta Real Oviedo temporada 2025/2026 Local', 30.97, 'Camiseta Real Oviedo 2025/2026 Local', 1, 12, 1),
(29, 'activo', './imagenes/productos/images3.jpg', 'Camiseta Real Oviedo x Melendi', 'Camiseta Real Oviedo colaboración con Melendi', 30.99, 'Camiseta Real Oviedo colaboración con Melendi', 1, 12, 1),
(30, 'activo', './imagenes/productos/bb865680-scaled.jpg', 'Camiseta Villarreal 2025/26 Local', 'Camiseta Villarreal temporada 2025/26 Local', 30.98, 'Camiseta Villarreal 2025/26 Local', 1, 13, 1),
(31, 'activo', './imagenes/productos/ab37dde9-scaled.jpg', 'Camiseta Elche 2025/2026 Local', 'Camiseta Elche temporada 2025/2026 Local', 30.99, 'Camiseta Elche 2025/2026 Local', 1, 14, 1),
(32, 'activo', './imagenes/productos/img_5694-2-scaled.jpg', 'Camiseta Arsenal 2025/26 Local', 'Camiseta Arsenal temporada 2025/26 Local', 30.99, 'Camiseta Arsenal 2025/26 Local', 2, 15, 1),
(33, 'activo', './imagenes/productos/arsenal-25-26-white-with-red-black-training-suit-kid-size-2.jpg', 'Chandal Arsenal 2025/2026 ', 'Chandal Arsenal temporada 2025/2026 entrenamiento sudadera blanca y roja y pantalón negro', 49.99, 'Chandal Arsenal temporada 2025/2026 entrenamiento sudadera blanca y roja y pantalón negro', 2, 15, 2),
(34, 'activo', './imagenes/productos/img_5683-scaled.jpg', 'Camiseta Aston Villa 2025/2026 Local', 'Camiseta Aston Villa temporada 2025/2026 Local', 30.99, 'Camiseta Aston Villa 2025/2026 Local', 2, 16, 1),
(35, 'activo', './imagenes/productos/img_5692-scaled.jpg', 'Camiseta Chelsea 2025/26 Local', 'Camiseta Chelsea temporada 2025/26 Local', 30.99, 'Camiseta Chelsea 2025/26 Local', 2, 17, 1),
(36, 'activo', './imagenes/productos/148d1607.jpg', 'Chandal Chelsea 2025/2026 Black', 'Chandal Chelsea 2025/2026 Black', 49.99, 'Chandal Chelsea 2025/2026 Black', 2, 17, 2),
(37, 'activo', './imagenes/productos/img_5703-scaled.jpeg', 'Camiseta Manchester United 2025/2026 Local', 'Camiseta Manchester United temporada 2025/2026 Local', 30.99, 'Camiseta Manchester United 2025/2026 Local', 2, 18, 1),
(38, 'activo', './imagenes/productos/images4.jpg', 'Camiseta Manchester United 2025/2026 Visitante', 'Camiseta Manchester United temporada 2025/2026 Visitante', 30.99, 'Camiseta Manchester United 2025/2026 Visitante', 2, 18, 1),
(39, 'activo', './imagenes/productos/img_6010-scaled.jpg', 'Camiseta Tottenham 2025/2026 local', 'Camiseta Tottenham temporada 2025/2026 local', 30.99, 'Camiseta Tottenham 2025/2026 local', 2, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tallas`
--

CREATE TABLE `producto_tallas` (
  `id` bigint(20) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `id_talla` bigint(20) NOT NULL,
  `stock` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_tallas`
--

INSERT INTO `producto_tallas` (`id`, `id_producto`, `id_talla`, `stock`) VALUES
(1, 1, 1, 3),
(2, 2, 1, 48),
(3, 1, 3, 49),
(4, 1, 4, 20),
(5, 6, 1, 99),
(6, 7, 2, 28),
(12, 13, 1, 45),
(13, 6, 2, 100),
(14, 3, 2, 30),
(15, 32, 2, 50),
(16, 32, 1, 50),
(17, 32, 3, 50),
(18, 32, 4, 50),
(19, 34, 2, 50),
(20, 34, 1, 50),
(21, 34, 3, 25),
(22, 14, 2, 50),
(23, 14, 1, 100),
(24, 14, 3, 50),
(25, 14, 4, 20),
(26, 23, 1, 50),
(27, 23, 3, 50),
(28, 24, 1, 50),
(29, 35, 2, 50),
(30, 35, 1, 100),
(31, 35, 3, 50),
(32, 35, 4, 19),
(33, 31, 2, 20),
(34, 31, 1, 21),
(35, 18, 2, 50),
(36, 18, 1, 50),
(37, 18, 3, 50),
(38, 18, 4, 50),
(39, 37, 2, 25),
(40, 37, 1, 50),
(41, 37, 3, 50),
(42, 37, 4, 20),
(43, 38, 1, 20),
(44, 38, 3, 25),
(45, 38, 4, 25),
(46, 25, 2, 25),
(47, 25, 1, 25),
(48, 25, 3, 25),
(49, 26, 2, 20),
(50, 26, 1, 25),
(51, 27, 1, 50),
(52, 19, 2, 50),
(53, 19, 1, 100),
(54, 19, 3, 50),
(55, 19, 4, 25),
(56, 28, 2, 25),
(57, 28, 1, 25),
(58, 29, 2, 10),
(59, 29, 1, 10),
(60, 29, 3, 10),
(61, 29, 4, 8),
(62, 16, 2, 50),
(63, 16, 1, 50),
(64, 16, 3, 50),
(65, 15, 2, 25),
(66, 15, 1, 25),
(67, 15, 3, 25),
(68, 17, 2, 25),
(69, 17, 1, 25),
(70, 17, 3, 25),
(71, 17, 4, 25),
(72, 39, 2, 25),
(73, 39, 1, 30),
(74, 39, 3, 30),
(75, 30, 3, 50),
(76, 30, 4, 50),
(77, 33, 2, 25),
(78, 33, 1, 25),
(79, 21, 2, 25),
(80, 21, 1, 25),
(81, 21, 3, 25),
(82, 36, 2, 25),
(83, 36, 1, 25),
(84, 36, 3, 25),
(85, 22, 1, 25),
(86, 22, 3, 25),
(87, 20, 2, 20),
(88, 20, 1, 25),
(89, 20, 3, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` bigint(20) NOT NULL,
  `talla` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `talla`) VALUES
(3, 'L'),
(1, 'M'),
(2, 'S'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `foto_perfil` varchar(100) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `direccion` text DEFAULT NULL,
  `provincia` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `telefono` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol`, `foto_perfil`, `nombre`, `email`, `contrasena`, `fecha_registro`, `direccion`, `provincia`, `municipio`, `telefono`) VALUES
(2, 'admin', './imagenes/usuarios/retroBarcelona.jpeg', 'pepe', 'pepe@gmail.com', '$2y$10$vapLQRMthDNpgLJsAZyhyucfHDxC/exPKakfjorKX9JavgyDgll.S', '2026-03-23', NULL, '', '', NULL),
(12, '', '', 'Ruben Carretero', 'rubencarreterogarcia8@gmail.com', '$2y$10$TwPWqlcTVD6KuPcRNAQtf.kaq1afSLyWRzxY4R0U77roAhxIb6KC2', '2026-04-22', NULL, '', '', NULL),
(13, '', './imagenes/usuarios/2.png', 'Juan', 'juanpruebas.san08@gmail.com', '$2y$10$SqsXweXrFwNXokCCDsHANOupATtvV5VwoPV9T1Ev1UxPhnUM0VVAq', '2026-04-30', NULL, '', '', NULL),
(16, '', '', 'Ruben Carretero', 'rubencarreterogarcia88@gmail.com', '$2y$10$YTz6JVymiSpbPSJtDs9gzuSsNI5Fz6xL00zJLtU3f1uOEsXgt1qqa', '2026-05-14', NULL, '', '', NULL),
(17, '', '', 'Ruben Carretero', 'rubencarreterogarcia@gmail.com', '$2y$10$3jAJ25WG2GN4/1.vEVDJ/ePEsf42BGNV/0ZzDkb9sMTKJTVU6mEbS', '2026-05-14', NULL, '', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificaciones`
--

CREATE TABLE `verificaciones` (
  `id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigo` int(11) NOT NULL,
  `expiracion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `verificaciones`
--

INSERT INTO `verificaciones` (`id`, `email`, `codigo`, `expiracion`) VALUES
(19, 'pepe4@gmial.com', 35332, '2026-02-24 19:01:11'),
(31, '', 55942, '2026-03-01 21:06:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_talla` (`talla`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `precio_unitario` (`precio_unitario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipo` (`equipo`),
  ADD KEY `liga` (`liga`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `ligas`
--
ALTER TABLE `ligas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restriccion_categoria` (`id_categoria`),
  ADD KEY `restriccion_equipos` (`id_equipo`),
  ADD KEY `restriccion_liga` (`id_liga`);

--
-- Indices de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restriccion_productos` (`id_producto`),
  ADD KEY `restriccion_tallas` (`id_talla`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `talla` (`talla`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `verificaciones`
--
ALTER TABLE `verificaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ligas`
--
ALTER TABLE `ligas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `verificaciones`
--
ALTER TABLE `verificaciones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`liga`) REFERENCES `ligas` (`id`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `restriccion_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `restriccion_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `restriccion_liga` FOREIGN KEY (`id_liga`) REFERENCES `ligas` (`id`);

--
-- Filtros para la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD CONSTRAINT `restriccion_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `restriccion_tallas` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
