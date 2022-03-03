-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-02-2022 a las 00:30:29
-- Versión del servidor: 8.0.28
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fepsoft_m3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int NOT NULL,
  `idcategoria` int NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stock` int NOT NULL,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `imagen`, `condicion`) VALUES
(2, 10, '382974987234', 'Impresora Multi', 11, 'Multifuncional', '1522726906.jpg', 1),
(3, 10, '32432423423', 'Impresora', 45, 'IMpresora', '1522726914.jpg', 1),
(4, 9, '', 'carros', 302, 'carros', '', 1),
(5, 10, '', 'TEST', 10, 'TEST', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assembly_hall`
--

CREATE TABLE `assembly_hall` (
  `id` int NOT NULL,
  `room_name` varchar(250) NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Volcado de datos para la tabla `assembly_hall`
--

INSERT INTO `assembly_hall` (`id`, `room_name`, `location`, `description`, `status`, `date_created`, `date_updated`) VALUES
(1, 'Room 101', 'Ground Floor, Right Corner', 'Conference Room that can occupy 30 attendees', 1, '2021-08-06 09:26:17', NULL),
(2, 'Room 102', 'Ground Floor, Left corner ', 'Conference Room that can occupy 30 attendees', 1, '2021-08-06 09:31:14', '2021-08-06 09:31:46'),
(3, 'Sala 1', 'here', 'P1 - S1', 1, '2022-01-08 08:33:58', NULL),
(4, 'TEST', 'ALMA MATER', '12M', 1, '2022-02-02 16:58:15', NULL),
(5, 'Room 101', 'Ground Floor, Right Corner', 'Conference Room that can occupy 30 attendees', 1, '2022-02-02 17:59:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Audio y video', 'Todos los accesorios para equipos de sonido', 1),
(2, 'Software', 'Programas de computadora', 1),
(9, 'Dispositivos Electronicos', 'Todos los dispositivos Electronicos', 1),
(10, 'Muebles de oficina', 'Todos los muebles de oficina', 1),
(11, 'Impresoras y Fax', 'Todas las impresoras', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int NOT NULL,
  `idingreso` int NOT NULL,
  `idarticulo` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(1, 3, 2, 10, 500.00, 600.00),
(2, 3, 3, 10, 20.00, 50.00),
(3, 4, 2, 5, 500.00, 600.00),
(4, 4, 3, 5, 20.00, 5.00),
(5, 5, 2, 10, 1000.00, 2000.00),
(6, 6, 2, 2, 100.00, 120.00),
(7, 6, 3, 3, 10.00, 10.00),
(8, 7, 4, 300, 20000.00, 22000.00),
(9, 8, 4, 10, 20000.00, 22000.00),
(10, 9, 2, 1, 200.00, 1.00);

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN UPDATE articulo SET stock = stock + NEW.cantidad WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int NOT NULL,
  `idventa` int NOT NULL,
  `idarticulo` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`) VALUES
(1, 1, 2, 3, 120.00, 0.00),
(2, 1, 3, 3, 10.00, 0.00),
(3, 2, 2, 2, 120.00, 0.00),
(4, 3, 4, 5, 22000.00, 0.00),
(5, 4, 4, 2, 22000.00, 0.00),
(6, 5, 4, 1, 22000.00, 1000.00);

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
UPDATE articulo SET stock = stock - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int NOT NULL,
  `idproveedor` int NOT NULL,
  `idusuario` int NOT NULL,
  `tipo_comprobante` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `serie_comprobante` varchar(7) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_comprobante` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(3, 1, 1, 'Factura', '001', '0001', '2018-04-16 00:00:00', 16.00, 5200.00, 'Aceptado'),
(4, 2, 1, 'Factura', '002', '0002', '2018-04-17 00:00:00', 16.00, 2600.00, 'Aceptado'),
(5, 1, 1, 'Factura', '004', '0004', '2018-04-16 00:00:00', 16.00, 10000.00, 'Aceptado'),
(6, 2, 1, 'Boleta', '0009', '00912', '2018-04-17 00:00:00', 0.00, 230.00, 'Anulado'),
(7, 2, 1, 'Factura', '18', '18', '2021-08-17 00:00:00', 16.00, 6000000.00, 'Aceptado'),
(8, 2, 1, 'Ticket', '1', '1', '2021-08-18 00:00:00', 0.00, 200000.00, 'Aceptado'),
(9, 2, 1, 'Boleta', '', '', '2021-10-05 00:00:00', 0.00, 200.00, 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Consultas Compras'),
(7, 'Consulta Ventas'),
(8, 'Reservas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int NOT NULL,
  `tipo_persona` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`) VALUES
(1, 'Proveedor', 'Benjamin', 'RUC', '7263128', 'Chicago Fire', '9872637318', 'correo@gmail.com'),
(2, 'Proveedor', 'Leon S.A', 'DNI', '26157', 'Conocido', '376782368', 'leon@gmail.com'),
(3, 'Proveedor', 'AAAA', 'DNI', '16237', 'con', '78263836', 'b@gail.com'),
(4, 'Cliente', 'EEEEE', 'DNI', '20918', 'Conocido', '19827', 'ajhd@gmail.com'),
(5, 'Cliente', 'Publico General', 'DNI', '1297317', 'Conocido', '34023808', 'p@gmail.com'),
(6, 'Proveedor', 'Prueba5', 'CEDULA', '63', '63', '63', '63@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int NOT NULL,
  `assembly_hall_id` int NOT NULL,
  `reserved_by` text NOT NULL,
  `schedule_remarks` text NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `costo` decimal(8,2) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Volcado de datos para la tabla `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `assembly_hall_id`, `reserved_by`, `schedule_remarks`, `datetime_start`, `datetime_end`, `periodo`, `costo`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 'John Smith', 'Sample Schedule Only', '2021-08-07 10:00:00', '2021-08-07 15:00:00', '', 0.00, 0, '2021-08-06 10:45:24', NULL),
(4, 2, 'John Smith', 'Sample Long Sched', '2021-08-10 08:00:00', '2021-08-12 17:00:00', '', 0.00, 0, '2021-08-06 11:21:23', '2021-08-06 11:58:34'),
(5, 1, 'Adriana Florez', 'Se aparta sala para reunión de compra de aplicación de sistema.', '2021-09-20 08:29:00', '2021-09-20 10:00:00', '', 0.00, 0, '2021-09-19 21:47:51', NULL),
(6, 1, 'prueba', 'prueba', '2021-11-20 21:44:00', '2021-11-27 21:45:00', '', 0.00, 0, '2021-11-20 21:45:11', NULL),
(7, 16, 'Jose', 'Reserva Jose Sala 1', '2021-12-18 10:49:00', '2021-12-25 10:49:00', 'Semana', 1200.00, 1, '2021-12-17 10:50:08', NULL),
(8, 16, 'Marta', 'Reserva Marta', '2021-12-17 10:53:00', '2021-12-17 10:53:00', 'Dia', 200.00, 1, '2021-12-17 10:54:16', NULL),
(9, 16, 'Roberto', 'Reserva Roberto', '2021-12-16 10:55:00', '2021-12-17 10:55:00', 'Dia', 499.00, 1, '2021-12-17 10:55:49', NULL),
(10, 16, 'maria', 'Reserva Maria 31', '2021-12-31 10:58:00', '2022-01-01 10:58:00', 'Dia', 350.00, 1, '2021-12-17 10:58:47', NULL),
(11, 15, 'pedro', 'Reserva dia, pedro', '2021-12-17 10:59:00', '2021-12-18 10:59:00', 'Dia', 300.00, 1, '2021-12-17 10:59:54', NULL),
(12, 1, 'Sofia', 'Reserva Sofia', '2021-12-28 16:26:00', '2021-12-29 16:26:00', 'Dia', 100.00, 1, '2021-12-18 16:26:38', '2022-02-05 01:21:04'),
(13, 3, 'ana', 'Reserva ana', '2021-12-26 06:28:00', '2021-12-26 22:28:00', 'Dia', 50.00, 1, '2021-12-18 16:29:11', '2022-01-09 22:16:38'),
(14, 1, 'pedro', 'reserva pedro', '2021-12-17 16:29:00', '2021-12-11 16:29:00', 'Dia', 110.00, 1, '2021-12-18 16:30:06', NULL),
(15, 16, 'Noel', 'reserva noel', '2021-12-10 16:41:00', '2021-12-11 16:41:00', 'Dia', 100.00, 1, '2021-12-18 16:41:24', NULL),
(16, 2, 'Reserva room 102', '24 hrs room 102', '2022-01-09 20:23:00', '2022-01-10 20:23:00', 'Dia', 100.00, 1, '2022-01-08 08:46:04', '2022-01-09 22:12:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_info`
--

CREATE TABLE `system_info` (
  `id` int NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Volcado de datos para la tabla `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Sistema de Reserva de Salas en PHP y MySQL'),
(6, 'short_name', 'SRS'),
(11, 'logo', 'uploads/1632105900_sistema reservas php y mysql.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1628211420_1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `num_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `login` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(64) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Admin', 'DNI', '63238', 'Conocido', '27386126', 'admin@gmail.com', '', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1523752615.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int NOT NULL,
  `idusuario` int NOT NULL,
  `idpermiso` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(82, 1, 1),
(83, 1, 2),
(84, 1, 3),
(85, 1, 4),
(86, 1, 5),
(87, 1, 6),
(88, 1, 7),
(89, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int NOT NULL,
  `idcliente` int NOT NULL,
  `idusuario` int NOT NULL,
  `tipo_comprobante` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `serie_comprobante` varchar(7) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_comprobante` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `estado`) VALUES
(1, 5, 1, 'Factura', '0001', '0001', '2018-04-17 00:00:00', 18.00, 390.00, 'Aceptado'),
(2, 4, 1, 'Boleta', '123', '1234', '2018-04-17 00:00:00', 0.00, 240.00, 'Aceptado'),
(3, 5, 1, 'Factura', '12', '12', '2021-08-17 00:00:00', 18.00, 110000.00, 'Aceptado'),
(4, 5, 1, 'Ticket', '18', '18', '2021-08-19 00:00:00', 20.00, 44000.00, 'Aceptado'),
(5, 5, 1, 'Boleta', 'R6u32', '267', '2021-10-17 00:00:00', 0.00, 22000.00, 'Aceptado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `assembly_hall`
--
ALTER TABLE `assembly_hall`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona_idx` (`idcliente`),
  ADD KEY `fk_venta_usuario_idx` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `assembly_hall`
--
ALTER TABLE `assembly_hall`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`);

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `fk_detalle_ingreso_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`),
  ADD CONSTRAINT `fk_detalle_ingreso_ingreso` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`),
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `fk_ingreso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`),
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_persona` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
