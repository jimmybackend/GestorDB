-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-05-2024 a las 11:07:41
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `esforzad_store`
--
CREATE DATABASE IF NOT EXISTS `dgairco1_store` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `dgairco1_store`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AccessControl`
--

DROP TABLE IF EXISTS `AccessControl`;
CREATE TABLE IF NOT EXISTS `AccessControl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` enum('Inicio de Sesión','Cierre de Sesión','Cambio de Contraseña','Otro') COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_details` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `AccessControl`
--

INSERT INTO `AccessControl` (`id`, `user_id`, `date_time`, `action`, `ip_address`, `action_details`) VALUES
(1, 1, '2024-04-28 19:45:53', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(2, 1, '2024-04-28 19:53:54', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(3, 1, '2024-04-28 20:33:59', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(4, 1, '2024-04-28 23:11:18', 'Inicio de Sesión', '200.68.172.168', 'Usuario con el rol de Soporte accedió.'),
(5, 1, '2024-04-29 06:22:43', 'Inicio de Sesión', '200.68.137.132', 'Usuario con el rol de Soporte accedió.'),
(6, 1, '2024-04-29 06:25:43', 'Inicio de Sesión', '200.68.137.201', 'Usuario con el rol de Soporte accedió.'),
(7, 1, '2024-04-29 16:17:23', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(8, 1, '2024-04-30 16:11:17', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(9, 1, '2024-04-30 16:17:00', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(10, 1, '2024-04-30 16:28:47', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(11, 1, '2024-04-30 17:21:51', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(12, 1, '2024-04-30 17:27:50', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(13, 1, '2024-04-30 17:36:46', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(14, 1, '2024-04-30 17:43:59', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(15, 1, '2024-04-30 18:17:01', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(16, 1, '2024-04-30 18:45:41', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(17, 1, '2024-04-30 19:03:03', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(18, 1, '2024-04-30 19:07:04', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(19, 1, '2024-04-30 19:07:59', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(20, 1, '2024-04-30 19:18:19', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(21, 1, '2024-04-30 19:18:36', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(22, 1, '2024-04-30 19:30:26', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(23, 1, '2024-04-30 19:34:31', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(24, 1, '2024-04-30 19:34:58', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(25, 1, '2024-04-30 19:46:08', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(26, 1, '2024-04-30 20:19:33', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(27, 1, '2024-04-30 20:47:15', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(28, 1, '2024-04-30 21:18:42', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(29, 1, '2024-05-01 05:22:45', 'Inicio de Sesión', '200.68.136.165', 'Usuario con el rol de Soporte accedió.'),
(30, 1, '2024-05-01 15:41:41', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(31, 1, '2024-05-01 16:00:46', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(32, 1, '2024-05-01 17:29:21', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(33, 1, '2024-05-01 18:08:40', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(34, 1, '2024-05-01 20:10:00', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(35, 1, '2024-05-01 20:19:48', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(36, 1, '2024-05-01 20:44:32', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(37, 1, '2024-05-02 00:14:14', 'Inicio de Sesión', '200.68.137.200', 'Usuario con el rol de Soporte accedió.'),
(38, 1, '2024-05-02 06:35:07', 'Inicio de Sesión', '200.68.137.200', 'Usuario con el rol de Soporte accedió.'),
(39, 1, '2024-05-02 11:42:22', 'Inicio de Sesión', '200.68.137.189', 'Usuario con el rol de Soporte accedió.'),
(40, 1, '2024-05-02 12:11:03', 'Inicio de Sesión', '200.68.137.200', 'Usuario con el rol de Soporte accedió.'),
(41, 1, '2024-05-02 16:47:07', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(42, 1, '2024-05-02 16:50:31', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(43, 1, '2024-05-02 17:16:57', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(44, 1, '2024-05-02 17:18:05', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(45, 1, '2024-05-02 17:30:31', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(46, 1, '2024-05-02 17:34:37', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.'),
(47, 1, '2024-05-02 17:41:39', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(48, 1, '2024-05-02 19:52:09', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(49, 1, '2024-05-03 11:23:23', 'Inicio de Sesión', '200.68.137.209', 'Usuario con el rol de Soporte accedió.'),
(50, 1, '2024-05-03 16:18:24', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(51, 1, '2024-05-04 00:09:50', 'Inicio de Sesión', '200.68.136.139', 'Usuario con el rol de Soporte accedió.'),
(52, 1, '2024-05-04 00:10:16', 'Inicio de Sesión', '200.68.136.139', 'Usuario con el rol de Soporte accedió.'),
(53, 1, '2024-05-04 00:10:37', 'Inicio de Sesión', '200.68.136.139', 'Usuario con el rol de Soporte accedió.'),
(54, 1, '2024-05-04 15:46:50', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(55, 1, '2024-05-04 19:54:28', 'Inicio de Sesión', '187.190.134.33', 'Usuario con el rol de Soporte accedió.'),
(56, 1, '2024-05-04 19:55:33', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(57, 1, '2024-05-04 20:13:43', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(58, 1, '2024-05-05 02:52:02', 'Inicio de Sesión', '200.68.136.67', 'Usuario con el rol de Soporte accedió.'),
(59, 1, '2024-05-05 04:22:38', 'Inicio de Sesión', '200.68.136.67', 'Usuario con el rol de Soporte accedió.'),
(60, 1, '2024-05-05 09:20:53', 'Inicio de Sesión', '200.68.136.92', 'Usuario con el rol de Soporte accedió.'),
(61, 1, '2024-05-05 09:44:27', 'Inicio de Sesión', '200.68.136.129', 'Usuario con el rol de Soporte accedió.'),
(62, 2, '2024-05-05 09:47:49', 'Inicio de Sesión', '200.68.136.92', 'Usuario con el rol de Administración accedió.'),
(63, 2, '2024-05-05 09:48:13', 'Inicio de Sesión', '200.68.136.129', 'Usuario con el rol de Administración accedió.'),
(64, 1, '2024-05-05 09:48:36', 'Inicio de Sesión', '200.68.136.129', 'Usuario con el rol de Soporte accedió.'),
(65, 1, '2024-05-05 15:37:07', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Soporte accedió.'),
(66, 1, '2024-05-05 16:23:37', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(67, 1, '2024-05-05 16:37:54', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(68, 1, '2024-05-06 04:21:48', 'Inicio de Sesión', '200.68.161.241', 'Usuario con el rol de Soporte accedió.'),
(69, 1, '2024-05-06 04:26:48', 'Inicio de Sesión', '200.68.161.241', 'Usuario con el rol de Soporte accedió.'),
(70, 1, '2024-05-06 04:27:12', 'Inicio de Sesión', '200.68.161.241', 'Usuario con el rol de Soporte accedió.'),
(71, 1, '2024-05-06 19:28:37', 'Inicio de Sesión', '148.230.221.15', 'Usuario con el rol de Soporte accedió.'),
(72, 1, '2024-05-07 03:10:01', 'Inicio de Sesión', '200.68.161.253', 'Usuario con el rol de Soporte accedió.'),
(73, 2, '2024-05-10 18:27:59', 'Inicio de Sesión', '187.188.174.120', 'Usuario con el rol de Administración accedió.'),
(74, 1, '2024-05-10 18:28:11', 'Inicio de Sesión', '148.230.221.14', 'Usuario con el rol de Soporte accedió.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Activities`
--

DROP TABLE IF EXISTS `Activities`;
CREATE TABLE IF NOT EXISTS `Activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_event` enum('Cita','Consulta','Evento','Reunión','Clase','Sesión','Importante','Conferencia','Capacitación','Exposición','Tarea','Proyecto','Competencia','Examen','Examen Final','Seminario','Taller','Mensaje','Anuncio','Notificación','Correo','Red Social','Deporte','Viaje','Voluntariado','Feria','Examen Médico','Concierto','Graduación','Vacaciones','Fiesta','Campamento') COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `participants` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Activities`
--

INSERT INTO `Activities` (`id`, `user_id`, `title`, `type_event`, `start_date`, `end_date`, `participants`, `description`) VALUES
(1, 1, 'Reunión de Equipo', 'Reunión', '2023-11-12 07:20:00', '2023-11-12 12:51:00', '1,2', 'se hace una reunion para ver el proyecto'),
(2, 1, 'hoy', 'Cita', '2024-01-02 08:46:00', '2024-01-02 20:22:00', '1', 'test'),
(3, 2, 'Reunión de Equipo', 'Cita', '2024-04-16 09:58:00', '2024-04-16 11:58:00', '1,2,36', 'acuerdo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias`
--

DROP TABLE IF EXISTS `Categorias`;
CREATE TABLE IF NOT EXISTS `Categorias` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Categoria` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Subcategoria` tinyint(1) DEFAULT NULL,
  `Categoria_Padre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tienda_id_` int(11) NOT NULL,
  PRIMARY KEY (`id_`),
  KEY `tienda_id_` (`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Categorias`
--

INSERT INTO `Categorias` (`id_`, `Categoria`, `Subcategoria`, `Categoria_Padre`, `fecha_`, `tienda_id_`) VALUES
(1, 'Licores', 0, NULL, '2024-04-30 18:21:42', 1),
(2, 'Abarrotes', 0, NULL, '2024-04-30 18:21:42', 1),
(3, 'Whisky ', 1, 'Licores', '2024-04-30 18:21:42', 1),
(4, 'Vinos', 1, 'Licores', '2024-04-30 18:21:42', 1),
(5, 'Alimentos Preparados', NULL, NULL, '2024-04-30 18:21:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
CREATE TABLE IF NOT EXISTS `Clientes` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Completo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Direccion` text COLLATE utf8_unicode_ci,
  `Ultimo_pedido` date DEFAULT NULL,
  `Compras_totales` int(11) DEFAULT NULL,
  `Gasto_total` decimal(10,2) DEFAULT NULL,
  `Limite_credito` decimal(10,2) DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `tienda_Id_` (`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`id_`, `Nombre_Completo`, `Telefono`, `Correo`, `Direccion`, `Ultimo_pedido`, `Compras_totales`, `Gasto_total`, `Limite_credito`, `fecha_`, `Estado`, `tienda_id_`) VALUES
(1, 'Francisco ', '9611077442', 'frank@esforzados.com', 'conocida', '2024-04-25', NULL, NULL, 100.00, '2024-04-30 18:29:41', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Compras`
--

DROP TABLE IF EXISTS `Compras`;
CREATE TABLE IF NOT EXISTS `Compras` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Ref_no` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Tipo` enum('Credito','Contado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tipo_de_Pago` enum('Efectivo','Tranferencia','Cheque') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha_de_Pago` datetime NOT NULL,
  `Estado` enum('Pendiente','En proceso','Enviado','Entregado','Cancelado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `proveedore_id_` int(11) NOT NULL,
  `usuario_id_` int(11) DEFAULT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `usuario_id_` (`usuario_id_`,`tienda_id_`),
  KEY `proveedore_id_` (`proveedore_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Compras`
--

INSERT INTO `Compras` (`id_`, `Ref_no`, `Fecha`, `Tipo`, `Tipo_de_Pago`, `Fecha_de_Pago`, `Estado`, `proveedore_id_`, `usuario_id_`, `tienda_id_`) VALUES
(1, 1001, '2024-05-05 18:37:00', 'Contado', 'Efectivo', '2024-05-05 12:37:00', 'Enviado', 1, 1, 1),
(2, 2002, '2024-05-05 18:38:00', 'Contado', 'Efectivo', '2024-05-05 12:38:00', 'Enviado', 2, 1, 1),
(3, 3003, '2024-05-05 18:40:00', 'Credito', 'Tranferencia', '2024-05-07 12:40:00', 'Entregado', 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Compras_Detalles`
--

DROP TABLE IF EXISTS `Compras_Detalles`;
CREATE TABLE IF NOT EXISTS `Compras_Detalles` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad_Compras` int(11) DEFAULT NULL,
  `Precio_Compra` decimal(10,2) DEFAULT NULL,
  `Caducidad_ProductoC` datetime NOT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `producto_id_` int(11) DEFAULT NULL,
  `compra_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `compra_id_` (`compra_id_`,`producto_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Compras_Detalles`
--

INSERT INTO `Compras_Detalles` (`id_`, `Cantidad_Compras`, `Precio_Compra`, `Caducidad_ProductoC`, `fecha_`, `producto_id_`, `compra_id_`) VALUES
(1, 24, 100.00, '2033-01-01 00:00:00', '2024-05-05 18:38:07', 1, 1),
(2, 10, 10.00, '2024-05-07 00:00:00', '2024-05-05 18:39:37', 2, 2),
(3, 50, 18.00, '2024-05-07 00:00:00', '2024-05-05 18:41:04', 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Consultas`
--

DROP TABLE IF EXISTS `Consultas`;
CREATE TABLE IF NOT EXISTS `Consultas` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Instruccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consulta_` text COLLATE utf8_unicode_ci,
  `tabla_` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Consultada en Consulta segun instruciones',
  `categoria_` enum('Agregar','Actualizar','Consulta','Buscar','Borrar') COLLATE utf8_unicode_ci DEFAULT 'Consulta',
  `roles_` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing',
  `indice_` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'tienda_id_',
  PRIMARY KEY (`id_`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Consultas`
--

INSERT INTO `Consultas` (`id_`, `Instruccion`, `consulta_`, `tabla_`, `categoria_`, `roles_`, `indice_`) VALUES
(1, 'Reporte de productos dentro o por encima del margen', 'SELECT p.Producto, pd.Precio, p.Cantidad, p.Margen, pr.Proveedor FROM Productos p JOIN Productos_Detalles pd ON p.id_ = pd.producto_id_\nJOIN Proveedores pr ON p.proveedore_id_ = pr.id_\nWHERE p.Cantidad >= p.Margen', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(2, 'Reporte de productos dentro o por debajo del margen', 'SELECT p.Producto, pd.Precio, p.Cantidad, p.Margen, pr.Proveedor FROM Productos p JOIN Productos_Detalles pd ON p.id_ = pd.producto_id_\r\nJOIN Proveedores pr ON p.proveedore_id_ = pr.id_\r\nWHERE p.Cantidad <= p.Margen', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(3, 'Ventas totales de Hoy', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd \r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE()\r\nGROUP BY DATE(p.Fecha);\r\n', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(4, 'Ventas totales por período de tiempo a un mes antes', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas FROM Pedidos_Detalles pd JOIN Productos p ON pd.producto_id_ = p.id_ WHERE DATE(pd.fecha_) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE();\r\n', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(5, 'Ingresos por categoría de productos', 'SELECT c.Categoria, SUM(pd.Precio * pd.Cantidad_Productos) AS Ingresos FROM Productos_Detalles pd JOIN Productos p ON pd.producto_id_ = p.id_ JOIN Categorias c ON p.categoria_id_ = c.id_ WHERE pd.fecha_ BETWEEN \'fecha_inicio\' AND \'fecha_fin\' GROUP BY c.Categoria', 'Categorias', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(6, 'Inventario actual de productos', 'SELECT Producto, Descripcion, Cantidad FROM Productos ORDER BY Producto', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(7, 'Saldo de proveedores', 'SELECT Prov.Proveedor, SUM(pd.Costo * pd.Cantidad_Productos) AS Saldo FROM Productos_Detalles pd JOIN Proveedores Prov ON pd.proveedore_id_ = Prov.id_ WHERE pd.fecha_ BETWEEN \'fecha_inicio\' AND \'fecha_fin\' GROUP BY Prov.Proveedor', 'Proveedores', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(8, 'Análisis de rentabilidad por producto', 'SELECT p.Producto, SUM(pd.Precio * pd.Cantidad_Productos) AS Ingresos, SUM(pd.Costo * pd.Cantidad_Productos) AS Costos FROM Productos_Detalles pd JOIN Productos p ON pd.producto_id_ = p.id_ WHERE pd.fecha_ BETWEEN \'fecha_inicio\' AND \'fecha_fin\' GROUP BY p.Producto', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(9, 'Productos más vendidos', 'SELECT p.Producto, p.Descripcion, SUM(pd.Cantidad_Pedidos) AS Mas_Vendidos \r\nFROM Pedidos_Detalles pd \r\nJOIN Pedidos pe ON pd.pedido_id_ = pe.id_\r\nJOIN Productos p ON pd.producto_id_ = p.id_ \r\nWHERE DATE(pe.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE() \r\nGROUP BY p.Producto \r\nORDER BY Mas_Vendidos DESC \r\nLIMIT 100;', 'Productos', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(10, 'Ventas totales de la Semana', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana \r\nFROM Pedidos_Detalles pd \r\nJOIN Productos p ON pd.producto_id_ = p.id_ \r\nWHERE DATE(pd.fecha_) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE();', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(11, 'Ventas totales de la quincena', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Quincena FROM Pedidos_Detalles pd JOIN Productos p ON pd.producto_id_ = p.id_ WHERE DATE(pd.fecha_) BETWEEN DATE_SUB(CURDATE(), INTERVAL 15 DAY) AND CURDATE();', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(12, 'Ventas totales de la mañana', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_Matutinas \r\nFROM Pedidos_Detalles pd \r\nJOIN Productos p ON pd.producto_id_ = p.id_ \r\nWHERE HOUR(pd.fecha_) >= 0 AND HOUR(pd.fecha_) < 12 AND DATE(pd.fecha_) = CURDATE();\r\n\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(13, 'Ventas totales de la tarde y noche', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_Vespertinas FROM Pedidos_Detalles pd JOIN Productos p ON pd.producto_id_ = p.id_ WHERE HOUR(pd.fecha_) >= 12 AND HOUR(pd.fecha_) < 24 AND DATE(pd.fecha_) = CURDATE();', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(14, 'Pedidos Pendientes o Ventas Pendientes con Nombre Completo del Cliente', 'SELECT  cl.Nombre_Completo AS Nombre_del_Cliente, p.Ref_no AS Numero_de_Referencia, \r\n       p.Fecha AS Fecha_del_Pedido, \r\n       pd.Cantidad_Pedidos AS Cantidad, \r\n       pd.Precio_Pedido AS Precio_Unitario, \r\n       pd.Cantidad_Pedidos * pd.Precio_Pedido AS Total, \r\n       pr.Producto AS Nombre_del_Producto, \r\n       pr.Descripcion AS Descripcion_del_Producto\r\nFROM Pedidos p\r\nJOIN Pedidos_Detalles pd ON p.id_ = pd.pedido_id_\r\nJOIN Productos pr ON pd.producto_id_ = pr.id_\r\nJOIN Clientes cl ON p.cliente_id_ = cl.id_\r\nWHERE p.Estado = \'Pendiente\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(15, 'Pedidos En proceso o Ventas En proceso', 'SELECT cl.Nombre_Completo AS Nombre_del_Cliente, p.Ref_no AS Numero_de_Referencia, p.Fecha AS Fecha_del_Pedido, pd.Cantidad_Pedidos AS Cantidad, pd.Precio_Pedido AS Precio_Unitario, pd.Cantidad_Pedidos * pd.Precio_Pedido AS Total, pr.Producto AS Nombre_del_Producto, pr.Descripcion AS Descripcion_del_Producto FROM Pedidos p JOIN Pedidos_Detalles pd ON p.id_ = pd.pedido_id_ JOIN Productos pr ON pd.producto_id_ = pr.id_ JOIN Clientes cl ON p.cliente_id_ = cl.id_ WHERE p.Estado = \'En proceso\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(16, 'Pedidos Enviado o Ventas Enviado', 'SELECT cl.Nombre_Completo AS Nombre_del_Cliente, p.Ref_no AS Numero_de_Referencia, p.Fecha AS Fecha_del_Pedido, pd.Cantidad_Pedidos AS Cantidad, pd.Precio_Pedido AS Precio_Unitario, pd.Cantidad_Pedidos * pd.Precio_Pedido AS Total, pr.Producto AS Nombre_del_Producto, pr.Descripcion AS Descripcion_del_Producto FROM Pedidos p JOIN Pedidos_Detalles pd ON p.id_ = pd.pedido_id_ JOIN Productos pr ON pd.producto_id_ = pr.id_ JOIN Clientes cl ON p.cliente_id_ = cl.id_ WHERE p.Estado = \'Enviado\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(17, 'Pedidos Entregado o Ventas Entregado', 'SELECT cl.Nombre_Completo AS Nombre_del_Cliente, p.Ref_no AS Numero_de_Referencia, p.Fecha AS Fecha_del_Pedido, pd.Cantidad_Pedidos AS Cantidad, pd.Precio_Pedido AS Precio_Unitario, pd.Cantidad_Pedidos * pd.Precio_Pedido AS Total, pr.Producto AS Nombre_del_Producto, pr.Descripcion AS Descripcion_del_Producto FROM Pedidos p JOIN Pedidos_Detalles pd ON p.id_ = pd.pedido_id_ JOIN Productos pr ON pd.producto_id_ = pr.id_ JOIN Clientes cl ON p.cliente_id_ = cl.id_ WHERE p.Estado = \'Entregado\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(18, 'Pedidos Cancelado o Ventas Cancelado', 'SELECT cl.Nombre_Completo AS Nombre_del_Cliente, p.Ref_no AS Numero_de_Referencia, p.Fecha AS Fecha_del_Pedido, pd.Cantidad_Pedidos AS Cantidad, pd.Precio_Pedido AS Precio_Unitario, pd.Cantidad_Pedidos * pd.Precio_Pedido AS Total, pr.Producto AS Nombre_del_Producto, pr.Descripcion AS Descripcion_del_Producto FROM Pedidos p JOIN Pedidos_Detalles pd ON p.id_ = pd.pedido_id_ JOIN Productos pr ON pd.producto_id_ = pr.id_ JOIN Clientes cl ON p.cliente_id_ = cl.id_ WHERE p.Estado = \'Cancelado\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(19, 'Ventas totales de Hoy al contado y en efectivo', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Contado\' \r\nAND p.Tipo_de_Pago = \'Efectivo\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(20, 'Ventas totales de Hoy al contado y en Tranferencia', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Contado\' \r\nAND p.Tipo_de_Pago = \'Tranferencia\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(21, 'Ventas totales de Hoy al contado pero en Cheque', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Contado\' \r\nAND p.Tipo_de_Pago = \'Cheque\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(22, 'Ventas totales de Hoy a Credito pero en efectivo', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       p.Fecha_de_Pago AS Fecha_de_Pago,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Credito\' \r\nAND p.Tipo_de_Pago = \'Efectivo\'\r\nGROUP BY DATE(p.Fecha), p.Fecha_de_Pago;\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(23, 'Ventas totales de Hoy a Credito pero en Tranferencia', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       p.Fecha_de_Pago AS Fecha_de_Pago,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Credito\' \r\nAND p.Tipo_de_Pago = \'Tranferencia\'\r\nGROUP BY DATE(p.Fecha), p.Fecha_de_Pago;\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(24, 'Ventas totales de Hoy a Credito pero en Cheque', 'SELECT DATE(p.Fecha) AS Fecha, p.Fecha_de_Pago AS Fecha_de_Pago, SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total FROM Pedidos_Detalles pd JOIN Pedidos p ON pd.pedido_id_ = p.id_ WHERE DATE(p.Fecha) = CURDATE() AND p.Tipo = \'Credito\' AND p.Tipo_de_Pago = \'Cheque\' GROUP BY DATE(p.Fecha), p.Fecha_de_Pago;\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(25, 'Ventas totales de la semana al contado y en efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(26, 'Ventas totales de la quincena al contado y en efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(27, 'Ventas totales del mes al contado y en efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(28, 'Ventas totales de la mañana al contado y en efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_Matutinas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE HOUR(pd.fecha_) >= 0 AND HOUR(pd.fecha_) < 12 AND DATE(pd.fecha_) = CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(29, 'Ventas totales de la tarde noche al contado y en efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_Vespertinas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE HOUR(pd.fecha_) >= 12 AND HOUR(pd.fecha_) < 24 AND DATE(pd.fecha_) = CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';\r\n\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(30, 'Ventas totales de Hoy al contado y en Tranferencia', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Contado\' \r\nAND p.Tipo_de_Pago = \'Tranferencia\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(31, 'Ventas totales de Hoy al contado y en Cheque', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Contado\' \r\nAND p.Tipo_de_Pago = \'Cheque\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(32, 'Ventas totales de Hoy a Credito y en Efectivo', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Credito\' \r\nAND p.Tipo_de_Pago = \'Efectivo\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(33, 'Ventas totales de Hoy a Credito pero en Tranferencia', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Credito\' \r\nAND p.Tipo_de_Pago = \'Tranferencia\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(34, 'Ventas totales de Hoy a Credito pero en Cheque', 'SELECT DATE(p.Fecha) AS Fecha,\r\n       SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) = CURDATE() \r\nAND p.Tipo = \'Credito\' \r\nAND p.Tipo_de_Pago = \'Cheque\'\r\nGROUP BY DATE(p.Fecha);', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(35, 'Ventas totales de la semana al contado y en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(36, 'Ventas totales de la semana al contado y en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Cheque\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(37, 'Ventas totales de la semana a Credito pero en Efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(38, 'Ventas totales de la semana a Credito pero en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(39, 'Ventas totales de la semana a Credito pero en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Cheque\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(40, 'Ventas totales de la quincena al Contado y en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(41, 'Ventas totales de la quincena al Contado y en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Cheque\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(42, 'Ventas totales de la quincena a Credito pero en Efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(43, 'Ventas totales de la quincena a Credito pero en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(44, 'Ventas totales de la quincena a Credito pero en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas_en_la_Semana\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 17 DAY) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Cheque\';', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(45, 'Ventas totales del mes al Contado y en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(46, 'Ventas totales del mes al Contado y en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Contado\'\r\nAND p.Tipo_de_Pago = \'Cheque\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(47, 'Ventas totales del mes  a Credito pero en Efectivo', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Efectivo\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(48, 'Ventas totales del mes  a Credito pero en Tranferencia', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Tranferencia\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_'),
(49, 'Ventas totales del mes  a Credito pero en Cheque', 'SELECT SUM(pd.Precio_Pedido * pd.Cantidad_Pedidos) AS Total_Ventas\r\nFROM Pedidos_Detalles pd\r\nJOIN Pedidos p ON pd.pedido_id_ = p.id_\r\nWHERE DATE(p.Fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()\r\nAND p.Tipo = \'Credito\'\r\nAND p.Tipo_de_Pago = \'Cheque\';\r\n', 'Consultada en Consulta segun instruciones', 'Consulta', 'Developer,Soporte,Administración,Finanzas,Ventas,Marketing', 'tienda_id_');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Email`
--

DROP TABLE IF EXISTS `Email`;
CREATE TABLE IF NOT EXISTS `Email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `has_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_saved` tinyint(1) NOT NULL DEFAULT '0',
  `is_saved_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_draft` tinyint(1) NOT NULL DEFAULT '0',
  `is_draft_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_spam` tinyint(1) NOT NULL DEFAULT '0',
  `is_spam_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_forwarded` tinyint(1) NOT NULL DEFAULT '0',
  `is_forwarded_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_tagged` tinyint(1) NOT NULL DEFAULT '0',
  `is_tagged_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_printed` tinyint(1) NOT NULL DEFAULT '0',
  `is_printed_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_ignored` tinyint(1) NOT NULL DEFAULT '0',
  `is_ignored_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_destroyed` tinyint(1) NOT NULL DEFAULT '0',
  `is_destroyed_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tagged` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_email` enum('Común','Personal','Trabajo','Invitación','Publicidad','Boletín','Promoción','Suscripción','Confirmación','Notificación','Recordatorio','Recuperación','Respuesta','Repuesta Automática','No Deseado') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmailAttachments`
--

DROP TABLE IF EXISTS `EmailAttachments`;
CREATE TABLE IF NOT EXISTS `EmailAttachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileencryptedname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` bigint(20) NOT NULL,
  `is_downloaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_downloaded_date` timestamp NULL DEFAULT NULL,
  `number_downloads` int(11) NOT NULL,
  `is_shared` tinyint(1) NOT NULL DEFAULT '0',
  `is_shared_date` timestamp NULL DEFAULT NULL,
  `number_shared` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmailDetails`
--

DROP TABLE IF EXISTS `EmailDetails`;
CREATE TABLE IF NOT EXISTS `EmailDetails` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmailsRealId` int(11) DEFAULT NULL,
  `Uid` varchar(255) NOT NULL,
  `SendDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Viewed` tinyint(1) DEFAULT '0',
  `ViewedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Responded` tinyint(1) DEFAULT '0',
  `RespondedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Campaign` varchar(255) DEFAULT NULL,
  `ContactMethod` varchar(100) DEFAULT NULL,
  `FormPath` varchar(100) DEFAULT NULL,
  `IpAddress` varchar(20) DEFAULT NULL,
  `Latitude` decimal(9,6) DEFAULT NULL,
  `Longitude` decimal(9,6) DEFAULT NULL,
  `OperatingSystem` varchar(100) DEFAULT NULL,
  `Browser` varchar(255) DEFAULT NULL,
  `Timezone` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Region` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Languages` varchar(100) NOT NULL,
  `Currency` varchar(100) NOT NULL,
  `Postal_code` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmailsRealId` (`EmailsRealId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmailsReal`
--

DROP TABLE IF EXISTS `EmailsReal`;
CREATE TABLE IF NOT EXISTS `EmailsReal` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `Gender` enum('Masculino','Femenino') DEFAULT NULL,
  `EmailType` enum('Entrada','Salida') NOT NULL,
  `Subscription` tinyint(1) DEFAULT '0',
  `SubscriptionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Cancellation` tinyint(1) DEFAULT '0',
  `CancellationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsBusiness` tinyint(1) DEFAULT '0',
  `DomainValid` tinyint(1) DEFAULT '0',
  `EmailValid` tinyint(1) DEFAULT '0',
  `RegistrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Files`
--

DROP TABLE IF EXISTS `Files`;
CREATE TABLE IF NOT EXISTS `Files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `unique_name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_path` varchar(256) NOT NULL,
  `qr_code_url` text NOT NULL,
  `encryption_key` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  `status` enum('Procesando','Error','Completo') NOT NULL DEFAULT 'Procesando',
  `status_upload` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `download_count` int(11) NOT NULL DEFAULT '0',
  `last_downloaded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Files`
--

INSERT INTO `Files` (`id`, `name`, `unique_name`, `size`, `file_type`, `file_path`, `qr_code_url`, `encryption_key`, `active`, `status`, `status_upload`, `user_id`, `created_at`, `download_count`, `last_downloaded_at`) VALUES
(1, 'compressed_4ce69e7cd4fccda40e9af.png', '6631484b8c82f', 964091, 'image/png', 'files/1/', '', '4B34z8y|tSn^jCCP,0|L6VY@!c?;&}kt', 1, 'Completo', 'Binary', 1, '2024-04-30 19:36:43', 0, NULL),
(3, 'usergoogle.jpg', '663155385d2b6', 206222, 'application/octet-stream', 'files/chunking/1/', '', '', 1, 'Completo', 'Chunk', 1, '2024-04-30 20:31:52', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Files_Shared`
--

DROP TABLE IF EXISTS `Files_Shared`;
CREATE TABLE IF NOT EXISTS `Files_Shared` (
  `shared_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `shared_with_user_id` int(11) DEFAULT NULL,
  `shared_with_group` varchar(50) DEFAULT NULL,
  `shared_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access_type` enum('Una Vez','Temporal','Permanente') NOT NULL,
  `expiration_datetime` datetime DEFAULT NULL,
  `download_count` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`shared_id`),
  KEY `file_id` (`file_id`),
  KEY `shared_with_user_id` (`shared_with_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Files_Shared`
--

INSERT INTO `Files_Shared` (`shared_id`, `file_id`, `shared_with_user_id`, `shared_with_group`, `shared_at`, `access_type`, `expiration_datetime`, `download_count`, `active`) VALUES
(1, 1, 1, 'individual', '2024-04-30 20:03:51', 'Permanente', '2024-04-30 14:03:51', 0, 1),
(2, 3, 2, 'individual', '2024-05-05 09:47:17', 'Permanente', '2024-05-05 03:47:17', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Files_Views`
--

DROP TABLE IF EXISTS `Files_Views`;
CREATE TABLE IF NOT EXISTS `Files_Views` (
  `view_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`view_id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Landing`
--

DROP TABLE IF EXISTS `Landing`;
CREATE TABLE IF NOT EXISTS `Landing` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Message` text COLLATE utf8_unicode_ci NOT NULL,
  `Ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateofregistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MessageAttachments`
--

DROP TABLE IF EXISTS `MessageAttachments`;
CREATE TABLE IF NOT EXISTS `MessageAttachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Messages`
--

DROP TABLE IF EXISTS `Messages`;
CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('Mensaje','Anuncio','Notificación','Correo','Red Social') COLLATE utf8_unicode_ci NOT NULL,
  `status_message` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Messages`
--

INSERT INTO `Messages` (`id`, `sender_id`, `receiver_id`, `subject`, `message`, `attachment`, `sent_date`, `read_date`, `is_read`, `type`, `status_message`) VALUES
(1, 1, 1, 'Mensajería interna', 'hola buenos dias', NULL, '2024-05-01 16:20:32', '0000-00-00 00:00:00', 1, 'Mensaje', 0),
(2, 1, 1, 'Mensajería interna', 'que tal como estas', NULL, '2024-05-01 20:22:56', '0000-00-00 00:00:00', 1, 'Mensaje', 0),
(3, 1, 1, 'Bienvenida', 'Hola Mundo', NULL, '2024-05-01 20:23:18', '2024-05-05 04:30:47', 1, 'Notificación', 1),
(4, 1, 2, 'Bienvenida', 'Hola Mundo', NULL, '2024-05-01 20:23:18', '0000-00-00 00:00:00', 0, 'Notificación', 1),
(5, 1, 3, 'Bienvenida', 'Hola Mundo', NULL, '2024-05-01 20:23:18', '0000-00-00 00:00:00', 0, 'Notificación', 1),
(6, 1, 2, 'Mensajería interna', 'Hola bienvenida al sistema de gestión integral de Tiendas en línea ', NULL, '2024-05-03 11:33:20', '0000-00-00 00:00:00', 0, 'Mensaje', 0),
(7, 1, 1, 'Gracias por estar aqui', 'Les agradezco la oportunidad que nos da y tomansu tiempo para probar nuestra plataforma ', NULL, '2024-05-03 11:35:40', '2024-05-05 04:30:47', 1, 'Notificación', 1),
(8, 1, 2, 'Gracias por estar aqui', 'Les agradezco la oportunidad que nos da y tomansu tiempo para probar nuestra plataforma ', NULL, '2024-05-03 11:35:40', '0000-00-00 00:00:00', 0, 'Notificación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedidos`
--

DROP TABLE IF EXISTS `Pedidos`;
CREATE TABLE IF NOT EXISTS `Pedidos` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Ref_no` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Tipo` enum('Credito','Contado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tipo_de_Pago` enum('Efectivo','Tranferencia','Cheque') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fecha_de_Pago` datetime NOT NULL,
  `Estado` enum('Pendiente','En proceso','Enviado','Entregado','Cancelado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente_id_` int(11) DEFAULT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `cliente_id_` (`cliente_id_`,`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Pedidos`
--

INSERT INTO `Pedidos` (`id_`, `Ref_no`, `Fecha`, `Tipo`, `Tipo_de_Pago`, `Fecha_de_Pago`, `Estado`, `cliente_id_`, `tienda_id_`) VALUES
(1, 1, '2024-05-05 18:41:00', 'Contado', 'Efectivo', '2024-05-05 12:41:00', 'Entregado', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedidos_Detalles`
--

DROP TABLE IF EXISTS `Pedidos_Detalles`;
CREATE TABLE IF NOT EXISTS `Pedidos_Detalles` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad_Pedidos` int(11) DEFAULT NULL,
  `Precio_Pedido` decimal(10,2) DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `producto_id_` int(11) DEFAULT NULL,
  `pedido_Detalle_id_` int(11) NOT NULL,
  `pedido_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `producto_id_` (`producto_id_`,`pedido_id_`),
  KEY `pedido_Detalle_id_` (`pedido_Detalle_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Pedidos_Detalles`
--

INSERT INTO `Pedidos_Detalles` (`id_`, `Cantidad_Pedidos`, `Precio_Pedido`, `fecha_`, `producto_id_`, `pedido_Detalle_id_`, `pedido_id_`) VALUES
(1, 1, 150.00, '2024-05-05 18:42:32', 1, 1, 1),
(2, 3, 20.00, '2024-05-05 18:42:41', 2, 2, 1),
(3, 5, 25.00, '2024-05-05 18:42:51', 3, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producciones`
--

DROP TABLE IF EXISTS `Producciones`;
CREATE TABLE IF NOT EXISTS `Producciones` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Ref_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Cantidad` decimal(10,2) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `productor_id_` int(11) NOT NULL,
  `usuario_id_` int(11) DEFAULT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `usuario_id_` (`usuario_id_`,`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Producciones`
--

INSERT INTO `Producciones` (`id_`, `Ref_no`, `Cantidad`, `Fecha`, `productor_id_`, `usuario_id_`, `tienda_id_`) VALUES
(1, '10001', 100.00, '2024-04-30 18:25:57', 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producciones_Detalles`
--

DROP TABLE IF EXISTS `Producciones_Detalles`;
CREATE TABLE IF NOT EXISTS `Producciones_Detalles` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad_Producciones` int(11) DEFAULT NULL,
  `Precio_Produccion` decimal(10,2) DEFAULT NULL,
  `Caducidad_ProductoP` datetime NOT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `producto_id_` int(11) DEFAULT NULL,
  `produccione_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `producione_id_` (`produccione_id_`,`producto_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Producciones_Detalles`
--

INSERT INTO `Producciones_Detalles` (`id_`, `Cantidad_Producciones`, `Precio_Produccion`, `Caducidad_ProductoP`, `fecha_`, `producto_id_`, `produccione_id_`) VALUES
(1, 50, 18.00, '2024-05-07 00:00:00', '2024-05-05 17:56:31', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

DROP TABLE IF EXISTS `Productos`;
CREATE TABLE IF NOT EXISTS `Productos` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Producto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `foto_` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Cantidad` decimal(10,2) DEFAULT NULL,
  `Descuento` decimal(10,2) NOT NULL,
  `Fecha_Descuento` datetime NOT NULL,
  `Min` decimal(10,2) NOT NULL,
  `Margen` decimal(10,2) DEFAULT NULL,
  `Max` decimal(10,2) NOT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `categoria_id_` int(11) DEFAULT NULL,
  `proveedore_id_` int(11) DEFAULT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `Proveedor_id_` (`proveedore_id_`),
  KEY `tienda_id_` (`tienda_id_`,`proveedore_id_`),
  KEY `categoria_id_` (`categoria_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`id_`, `Codigo`, `Producto`, `Descripcion`, `foto_`, `Cantidad`, `Descuento`, `Fecha_Descuento`, `Min`, `Margen`, `Max`, `fecha_`, `Estado`, `categoria_id_`, `proveedore_id_`, `tienda_id_`) VALUES
(1, '1001', 'Vino San Jorge', 'Licor de uva', '', 23.00, 5.00, '2024-04-30 11:22:00', 2.00, 5.00, 10.00, '2024-04-30 18:24:26', 'Activo', 1, 1, 1),
(2, '1002', 'Peras', 'Fruta', '', 7.00, 5.00, '2024-04-27 22:25:00', 3.00, 5.00, 30.00, '2024-04-30 18:24:26', 'Activo', 2, 2, 1),
(3, '1003', 'Tamales', 'tamal de mole dulce', '', 45.00, 1.00, '2024-04-29 14:02:00', 5.00, 10.00, 100.00, '2024-04-30 18:24:26', 'Activo', 5, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos_Detalles`
--

DROP TABLE IF EXISTS `Productos_Detalles`;
CREATE TABLE IF NOT EXISTS `Productos_Detalles` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Costo` decimal(10,2) DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Cantidad_Productos` decimal(10,2) DEFAULT NULL,
  `Caducidad_Producto` datetime NOT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `producto_id_` int(11) DEFAULT NULL,
  `compra_id_` int(11) NOT NULL,
  `compra_Detalle_id_` int(11) NOT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `tienda_id_` (`tienda_id_`,`producto_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Productos_Detalles`
--

INSERT INTO `Productos_Detalles` (`id_`, `Costo`, `Precio`, `Cantidad_Productos`, `Caducidad_Producto`, `fecha_`, `producto_id_`, `compra_id_`, `compra_Detalle_id_`, `tienda_id_`) VALUES
(1, 100.00, 150.00, 24.00, '2033-01-01 00:00:00', '2024-05-05 18:38:07', 1, 1, 1, 1),
(2, 10.00, 20.00, 10.00, '2024-05-07 00:00:00', '2024-05-05 18:39:37', 2, 2, 2, 1),
(3, 18.00, 25.00, 50.00, '2024-05-07 00:00:00', '2024-05-05 18:41:04', 3, 3, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos_Fotos`
--

DROP TABLE IF EXISTS `Productos_Fotos`;
CREATE TABLE IF NOT EXISTS `Productos_Fotos` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `producto_id_` int(11) DEFAULT NULL,
  `usuario_id_` int(11) DEFAULT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `producto_id_` (`producto_id_`),
  KEY `usuario_id_` (`usuario_id_`),
  KEY `tienda_id_` (`tienda_id_`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Proveedores`
--

DROP TABLE IF EXISTS `Proveedores`;
CREATE TABLE IF NOT EXISTS `Proveedores` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Proveedor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Saldo_inicial` decimal(10,2) DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `tienda_id_` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_`),
  KEY `tienda_id_` (`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Proveedores`
--

INSERT INTO `Proveedores` (`id_`, `Proveedor`, `Contacto`, `Telefono`, `Correo`, `Saldo_inicial`, `fecha_`, `Estado`, `tienda_id_`) VALUES
(1, 'Sams Club', 'sams gerente', '96112345', 'sams@samclub.com', 1000.00, '2024-04-30 18:21:11', 'Activo', 1),
(2, 'Wal-Mark', 'Gerente region 1', '9611077442', 'gerenteuno@Wal-Mark.com', 100.00, '2024-04-30 18:21:11', 'Activo', 1),
(3, 'Chedraui', 'gerente', '132465789', 'chedraui@chedraui.mx', 100.00, '2024-04-30 18:21:11', 'Inactivo', 1),
(4, 'Tienda en Linea Nosotros', 'A Velasco', '9611077442', 'jimmybackend@gmail.com', 1000.00, '2024-04-30 18:21:11', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Schools`
--

DROP TABLE IF EXISTS `Schools`;
CREATE TABLE IF NOT EXISTS `Schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foundation_date` date DEFAULT NULL,
  `accreditation_status` enum('Acreditada','No Acreditada','En Proceso de Acreditación') COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_type` enum('Preescolar','Primaria','Secundaria','Preparatoria','Universidad','Posgrado','Doctorado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `curriculum_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `principal_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enrollment_capacity` int(11) DEFAULT NULL,
  `students_enrolled` int(11) DEFAULT NULL,
  `annual_tuition` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `logo_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_status` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Schools`
--

INSERT INTO `Schools` (`id`, `name`, `address`, `city`, `state`, `country`, `postalcode`, `phone`, `website`, `email`, `foundation_date`, `accreditation_status`, `school_type`, `curriculum_type`, `principal_name`, `contact_name`, `contact_phone`, `contact_email`, `enrollment_capacity`, `students_enrolled`, `annual_tuition`, `description`, `logo_path`, `school_status`) VALUES
(1, 'ESCUELA INFANTIL ESFORZADOS PREESCOLAR', 'En linea', 'Tgz', 'Chiapas', 'México ', '29000', '961', 'Ninguno ', 'controlescolar@esforzados.com', '2023-09-25', 'Acreditada', '', 'Ninguno', 'Ninguno ', 'Ninguno ', 'Ninguno ', 'controlescolar@esforzados.com', 100, 20, 50.00, 'Ninguna', '../assets/img/icono.png', 'Activo'),
(2, 'ESCUELA BIBLICA INFANTIL MRVA PRIMARIA', 'MINISTERIO RIOS DE VIDA ABUNDANTE', 'TUXTLA GUTIERREZ', 'CHIAPAS', 'MEXICO', '29000', '961', 'ESFORZADOS', 'info@esforzados.com', '0023-09-25', 'Acreditada', 'Primaria', 'X', 'LADY VILLATORO', 'NINGUNO', '961', 'info@esforzados.com', 0, 20, 50.00, '', '../assets/img/icono.png', 'Activo'),
(3, 'ESCUELA PRIMARIA HOMESCHOOLING MRVA', 'CALZ. EMILIANO ZAPATA No. 93', 'TUXTLA GUTIERREZ', 'CHIAPAS', 'MEXICO', '29000', '961', '961', 'info@esforzados.com', '2020-08-22', 'Acreditada', 'Primaria', '', 'LADY ARGUELLO', 'LADY ARGUELLO', '961 3304975', 'esforzados.com@gmail.com', 10, 2, 0.00, 'Escuela sin fines de Lucro', 'logos/3/65f71377762002.92113187_mrva.png', 'Activo'),
(4, 'ESCUELA SECUNDARIA HOMESCHOOLING MRVA', 'CALZ. EMILIANO ZAPATA No. 93', 'TUXTLA GUTIERREZ', 'CHIAPAS', 'MEXICO', '29000', '9613304975', 'esforzados.com', 'esforzados.com@gmail.com', '2020-08-22', 'Acreditada', 'Secundaria', '', 'LADY ARGUELLO', 'LADY ARGUELLO', '961 3304975', 'esforzados.com@gmail.com', 20, 7, 0.00, 'Escuela sin fines de Lucro', '../assets/img/logo/mrva.png', 'Activo'),
(5, 'CURSOS EN LÍNEA DE BACKEND', 'En línea', 'En línea', 'En línea', 'En línea', 'En línea', 'En línea', 'https://esforzados.com', 'soporte@esforzados.com', '2023-12-11', 'No Acreditada', 'Preparatoria', 'esforzados', 'esforzados', 'esforzados', 'esforzados', 'soporte@esforzados.com', 10, 0, 24000.00, 'Cursos de esforzados', 'https://www.simplilearn.com/ice9/free_resources_article_thumb/How_to_Become_a_Back_End_Developer.jpg', 'Activo'),
(6, 'ESCUELA BACHILLERATO HOMESCHOOLING MRVA', 'CALZ. EMILIANO ZAPATA No. 93', 'TUXTLA GUTIERREZ', 'CHIAPAS', 'MEXICO', '29000', '9613304975', 'esforzados.com', 'esforzados.com@gmail.com', '2020-08-22', 'Acreditada', 'Preparatoria', '', 'LADY ARGUELLO', 'LADY ARGUELLO', '961 3304975', 'esforzados.com@gmail.com', 20, 7, 0.00, 'Escuela sin fines de Lucro', '../assets/img/icono.png', 'Activo'),
(7, 'CURSOS EN LÍNEA', 'En línea', 'En línea', 'En línea', 'En línea', 'En línea', 'En línea', 'https://esforzados.com', 'info@esforzados.com', '2023-12-11', 'No Acreditada', 'Preparatoria', 'esforzados', 'esforzados', 'esforzados', 'esforzados', 'info@esforzados.com', 25, 0, 2500.00, 'Cursos en linea', 'https://img.freepik.com/vector-premium/plantilla-diseno-logotipo-ingles_23-2149553118.jpg', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Smtp_1`
--

DROP TABLE IF EXISTS `Smtp_1`;
CREATE TABLE IF NOT EXISTS `Smtp_1` (
  `IdSmtp` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Email1` varchar(100) NOT NULL,
  `Email2` varchar(100) NOT NULL,
  `Available_to_everyone` int(11) NOT NULL,
  `Hostin` varchar(100) NOT NULL,
  `Host` varchar(100) DEFAULT NULL,
  `Hostout` varchar(100) NOT NULL,
  `Portin` int(11) NOT NULL,
  `Portout` int(11) NOT NULL,
  `SSLin` varchar(10) NOT NULL,
  `SSLout` varchar(10) NOT NULL,
  `User_1` varchar(100) NOT NULL,
  `Password_1` varchar(100) NOT NULL,
  `Max_daily_email` int(11) NOT NULL,
  `Enable_limit` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  PRIMARY KEY (`IdSmtp`),
  KEY `IdUser` (`IdUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Smtp_1`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SupportTickets`
--

DROP TABLE IF EXISTS `SupportTickets`;
CREATE TABLE IF NOT EXISTS `SupportTickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department` enum('Soporte','Administración','Finanzas','Recursos Humanos','Ventas','Marketing','Servicio Social','Otros') COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Abierto','En Progreso','Cerrado') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `SupportTickets`
--

INSERT INTO `SupportTickets` (`id`, `user_id`, `department`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(36, 1, 'Soporte', 'Vistas a crear', 'Crear metodo para genera una vista de una consulta hecha completamente. Crear vista con boton de actualizar Crear vista con botón de eliminar Crear vista con botones de actualizar y eliminar	\r\n\r\n', 'Abierto', '2024-04-30 18:43:16', '2024-04-30 18:51:29'),
(37, 1, 'Soporte', 'Importar ', 'Crear los métodos para Importar  estás acciones que podrá realizar la tabla	\r\n\r\n', 'Abierto', '2024-04-30 18:52:11', '2024-04-30 18:52:11'),
(38, 1, 'Soporte', 'Exportar', 'puede ser a CSV\r\n', 'Cerrado', '2024-04-30 18:52:52', '2024-05-01 05:27:16'),
(39, 1, 'Soporte', 'Imprimir', '	enviarlo a PDF	\r\n\r\n', 'Cerrado', '2024-04-30 18:53:18', '2024-05-01 20:21:41'),
(40, 1, 'Soporte', 'Pedidos', 'ver con detalle de porducto un pedido pero localizadlo por el numero de pedido generarVistaTabla_con_Detalles_Productos', 'Cerrado', '2024-04-30 18:53:43', '2024-05-04 20:01:25'),
(41, 1, 'Soporte', 'cambio el campo usario_id_', 'quiero ver si podemos cambiar el campo usuario_id_ por el user_id', 'Cerrado', '2024-04-30 21:20:06', '2024-05-04 20:00:31'),
(42, 1, 'Soporte', 'index', 'psesion apuntar al la tabla de Users porque esta apuntando a la tabla de Usuarios', 'Cerrado', '2024-04-30 21:20:49', '2024-05-04 20:00:16'),
(43, 1, 'Soporte', 'fileincretitech', 'cambiar el tamañode la forto de la forma en que lo hago con el igcono del esta flataforma en el index para ver sia si no aparecen en grande las imagenes', 'Cerrado', '2024-04-30 21:22:08', '2024-05-01 20:20:18'),
(44, 1, 'Soporte', 'Email interno', 'no funciona el boton de crear correo nuevo', 'Cerrado', '2024-05-01 20:24:01', '2024-05-01 20:30:27'),
(45, 1, 'Soporte', 'calendario', 'no funciona el calendario', 'Abierto', '2024-05-01 20:24:24', '2024-05-01 20:24:24'),
(46, 1, 'Soporte', 'Crear ventas al cliente o pedidos', 'ya que se hizo lo de agregar compras ahora crear la agregacion de pedido o ventas al cliente para que tengalos dos ', 'Cerrado', '2024-05-03 19:00:04', '2024-05-04 19:59:53'),
(47, 1, 'Soporte', 'Productos ', 'Colocar fecha de caducidad cuando el producto lo amerite o tenga caducidad ', 'Cerrado', '2024-05-04 00:16:40', '2024-05-04 19:59:40'),
(48, 1, 'Soporte', 'caducidad', 'comprar necesita colocar la caducidad si la tiene o no ', 'Cerrado', '2024-05-04 18:04:29', '2024-05-04 19:59:29'),
(49, 1, 'Soporte', 'pedidos', 'al eliminar el pedido necesitamos el nombre del proveedor para que lo realice para que no choque con orto codigo del mismo en la misma tienda pero con diferente proveedor', 'Cerrado', '2024-05-04 18:05:22', '2024-05-04 19:59:20'),
(50, 1, 'Soporte', 'PRODUCIONES', 'crear lo mismo que a compras y pedidos pero a produciones solo que este debemos saber que hacer', 'Cerrado', '2024-05-04 20:15:40', '2024-05-05 19:13:50'),
(51, 1, 'Soporte', 'Ver con detalle', 'quie muestre la nota en tabla superior y el detalle en tabla inferior en la misma ventana para poder ser mas comprensible', 'Abierto', '2024-05-05 20:11:37', '2024-05-05 20:11:37'),
(52, 1, 'Soporte', 'Ulices', 'dominio listo:\r\nhttps://dgair.com.mx\r\nhttps://dgair.com.mx/siged_sep_gob_titulos_acuerdo286.php\r\nTE-LPE-621311-090425-004231-24', 'Cerrado', '2024-05-06 19:36:54', '2024-05-07 03:14:21'),
(53, 1, 'Soporte', 'Pelicula', 'dos tipos de cuidado\r\nhttps://www.youtube.com/watch?v=8ZZemsAE1eo\r\npagina para descargar\r\nhttps://ssyoutube.one/es/', 'Cerrado', '2024-05-06 20:03:47', '2024-05-07 03:10:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TicketResponses`
--

DROP TABLE IF EXISTS `TicketResponses`;
CREATE TABLE IF NOT EXISTS `TicketResponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `response_message` text COLLATE utf8_unicode_ci NOT NULL,
  `response_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tiendas`
--

DROP TABLE IF EXISTS `Tiendas`;
CREATE TABLE IF NOT EXISTS `Tiendas` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Tienda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pais` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode_` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone_` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Correo_Contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_` text COLLATE utf8_unicode_ci,
  `logo_path_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Tiendas`
--

INSERT INTO `Tiendas` (`id_`, `Tienda`, `address_`, `city_`, `state_`, `Pais`, `postalcode_`, `Telefono`, `website_`, `Correo`, `Contacto`, `contact_phone_`, `Correo_Contacto`, `description_`, `logo_path_`, `fecha_`, `Estado`) VALUES
(1, 'Tienda en Línea', 'Virtual', 'Virtual', 'Virtual', 'México', 'Virtual', '9611077442', 'Virtual', 'soporte@esforzados.com', 'A Velasco', 'Virtual', 'jimmybackend@egmail.com', 'Virtual', '../assets/img/icono.png', '2024-04-30 18:18:08', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `curp` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Masculino','Femenino','Otro') COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homephone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobilephone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('Alumno','Docente','Administración','Finanzas','Recursos Humanos','Ventas','Marketing','Soporte','Servicio Social','Otros') COLLATE utf8_unicode_ci NOT NULL,
  `registrationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profilepicture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userstatus` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `tienda_id_` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`id`, `firstname`, `lastname`, `curp`, `gender`, `birthdate`, `email`, `password`, `address`, `neighborhood`, `postalcode`, `state`, `country`, `homephone`, `mobilephone`, `role`, `registrationdate`, `profilepicture`, `userstatus`, `tienda_id_`) VALUES
(1, 'A', 'Velasco', 'VIA', 'Masculino', '1977-10-14', 'developers@esforzados.com', '$2y$10$OIIsJh6UaLELKp9jBe0pVuLlWsxgqVyZ05lhNwcS8JddsN9z4NCua', 'Tuxtla Gutierrez Chiapas', 'Centro', '29000', 'Chiapas', 'México', '9614219260', '9614219260', 'Soporte', '2023-09-03 16:25:21', 'userdoc/1/profilepictures/il_fullxfull.4683078828_bzgn.png', 'Activo', 1),
(2, 'Lady ', 'Arguello', 'LADY', 'Femenino', '1982-05-16', 'informacion@esforzados.com', '$2y$10$qhJRIn6ee.rJpQqRAqOlvOfP25kt9qYZzWQRaTjhYoW/llnj1kKni', 'AVE. CUPAPE 911 ENTRE ANDADOR LOS COCOS mza 30 lt15', 'ALBANIA BAJA', '29010', 'Chiapas', 'México', '961', '961', 'Administración', '2023-09-03 16:25:21', 'assets/img/logo/tiendaenlineaicono.png', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserSchools`
--

DROP TABLE IF EXISTS `UserSchools`;
CREATE TABLE IF NOT EXISTS `UserSchools` (
  `UserId` int(11) NOT NULL,
  `SchoolId` int(11) NOT NULL,
  PRIMARY KEY (`UserId`,`SchoolId`),
  KEY `SchoolId` (`SchoolId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `UserSchools`
--

INSERT INTO `UserSchools` (`UserId`, `SchoolId`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Apellidos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `curp_` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `gender_` enum('Masculino','Femenino','Otro') COLLATE utf8_unicode_ci NOT NULL,
  `birthdate_` date DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighborhood_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode_` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobilephone_` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rol` enum('Administración','Finanzas','Recursos Humanos','Ventas','Marketing','Soporte','Developer') COLLATE utf8_unicode_ci NOT NULL,
  `registrationdate_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profilepicture_` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('Activo','Inactivo') COLLATE utf8_unicode_ci NOT NULL,
  `tienda_id_` int(11) NOT NULL,
  PRIMARY KEY (`id_`),
  KEY `tienda_id_` (`tienda_id_`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id_`, `Nombres`, `Apellidos`, `curp_`, `gender_`, `birthdate_`, `Correo`, `pin`, `address_`, `neighborhood_`, `postalcode_`, `state_`, `country_`, `Telefono`, `mobilephone_`, `Rol`, `registrationdate_`, `profilepicture_`, `fecha_`, `Estado`, `tienda_id_`) VALUES
(1, 'A', 'Velasco', 'VIA', 'Masculino', '1977-10-14', 'developer@esforzados.com', '$2y$10$OIIsJh6UaLELKp9jBe0pVuLlWsxgqVyZ05lhNwcS8JddsN9z4NCua', 'Tuxtla Gutierrez Chiapas', 'Centro', '29000', 'Chiapas', 'México', '9611077442', '9614219260', 'Soporte', '2023-09-03 16:25:21', 'assets/img/logo/tiendaenlineaicono.png', '2024-04-30 18:19:08', 'Activo', 1),
(2, 'Lady', 'Villatoro', 'LADY', 'Femenino', '1982-05-16', 'informacion@esforzados.com', '$2y$10$qhJRIn6ee.rJpQqRAqOlvOfP25kt9qYZzWQRaTjhYoW/llnj1kKni', 'AVE. CUPAPE 911 ENTRE ANDADOR LOS COCOS mza 30 lt15', 'ALBANIA BAJA', '29010', 'Chiapas', 'México', '9611077442', '961', 'Administración', '2023-09-03 16:25:21', 'assets/img/logo/tiendaenlineaicono.png', '2024-04-30 18:19:08', 'Activo', 1),
(14, 'Jacobo', 'Arguello', '', 'Masculino', NULL, 'jimmybackend@gmail.com', '12345', NULL, NULL, NULL, NULL, NULL, '9611077442', NULL, 'Developer', '2024-04-25 17:50:51', 'assets/img/logo/tiendaenlineaicono.png', '2024-04-30 18:19:08', 'Activo', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `AccessControl`
--
ALTER TABLE `AccessControl`
  ADD CONSTRAINT `AccessControl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Usuarios` (`id_`);

--
-- Filtros para la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD CONSTRAINT `Clientes_ibfk_1` FOREIGN KEY (`tienda_id_`) REFERENCES `Tiendas` (`id_`);

--
-- Filtros para la tabla `Email`
--
ALTER TABLE `Email`
  ADD CONSTRAINT `Email_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Usuarios` (`id_`),
  ADD CONSTRAINT `Email_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `Usuarios` (`id_`);

--
-- Filtros para la tabla `EmailAttachments`
--
ALTER TABLE `EmailAttachments`
  ADD CONSTRAINT `EmailAttachments_ibfk_1` FOREIGN KEY (`email_id`) REFERENCES `Email` (`id`);

--
-- Filtros para la tabla `EmailDetails`
--
ALTER TABLE `EmailDetails`
  ADD CONSTRAINT `EmailDetails_ibfk_1` FOREIGN KEY (`EmailsRealId`) REFERENCES `EmailsReal` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Files_Shared`
--
ALTER TABLE `Files_Shared`
  ADD CONSTRAINT `Files_Shared_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `Files` (`id`),
  ADD CONSTRAINT `Files_Shared_ibfk_2` FOREIGN KEY (`shared_with_user_id`) REFERENCES `Usuarios` (`id_`);

--
-- Filtros para la tabla `Files_Views`
--
ALTER TABLE `Files_Views`
  ADD CONSTRAINT `Files_Views_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `Files` (`id`),
  ADD CONSTRAINT `Files_Views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Usuarios` (`id_`);

--
-- Filtros para la tabla `MessageAttachments`
--
ALTER TABLE `MessageAttachments`
  ADD CONSTRAINT `MessageAttachments_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `Messages` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Usuarios` (`id_`);

--
-- Filtros para la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `Productos_ibfk_1` FOREIGN KEY (`tienda_id_`) REFERENCES `Tiendas` (`id_`),
  ADD CONSTRAINT `Productos_ibfk_2` FOREIGN KEY (`proveedore_id_`) REFERENCES `Proveedores` (`id_`);

--
-- Filtros para la tabla `Productos_Fotos`
--
ALTER TABLE `Productos_Fotos`
  ADD CONSTRAINT `Productos_Fotos_ibfk_1` FOREIGN KEY (`producto_id_`) REFERENCES `Productos` (`id_`),
  ADD CONSTRAINT `Productos_Fotos_ibfk_2` FOREIGN KEY (`usuario_id_`) REFERENCES `Usuarios` (`id_`),
  ADD CONSTRAINT `Productos_Fotos_ibfk_3` FOREIGN KEY (`tienda_id_`) REFERENCES `Tiendas` (`id_`);

--
-- Filtros para la tabla `Proveedores`
--
ALTER TABLE `Proveedores`
  ADD CONSTRAINT `Proveedores_ibfk_1` FOREIGN KEY (`tienda_id_`) REFERENCES `Tiendas` (`id_`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
