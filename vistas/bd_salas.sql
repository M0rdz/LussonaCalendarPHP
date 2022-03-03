-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2021 a las 08:06:33
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `programacion_salas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assembly_hall`
--

CREATE TABLE `assembly_hall` (
  `id` int(30) NOT NULL,
  `room_name` varchar(250) NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `assembly_hall`
--

INSERT INTO `assembly_hall` (`id`, `room_name`, `location`, `description`, `status`, `date_created`, `date_updated`) VALUES
(1, 'Room 101', 'Ground Floor, Right Corner', 'Conference Room that can occupy 30 attendees', 1, '2021-08-06 09:26:17', NULL),
(2, 'Room 102', 'Ground Floor, Left corner ', 'Conference Room that can occupy 30 attendees', 1, '2021-08-06 09:31:14', '2021-08-06 09:31:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL,
  `assembly_hall_id` int(30) NOT NULL,
  `reserved_by` text NOT NULL,
  `schedule_remarks` text NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `assembly_hall_id`, `reserved_by`, `schedule_remarks`, `datetime_start`, `datetime_end`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 'John Smith', 'Sample Schedule Only', '2021-08-07 10:00:00', '2021-08-07 15:00:00', 0, '2021-08-06 10:45:24', NULL),
(4, 2, 'John Smith', 'Sample Long Sched', '2021-08-10 08:00:00', '2021-08-12 17:00:00', 0, '2021-08-06 11:21:23', '2021-08-06 11:58:34'),
(5, 1, 'Adriana Florez', 'Se aparta sala para reunión de compra de aplicación de sistema.', '2021-09-20 08:29:00', '2021-09-20 10:00:00', 0, '2021-09-19 21:47:51', NULL),
(6, 1, 'prueba', 'prueba', '2021-11-20 21:44:00', '2021-11-27 21:45:00', 0, '2021-11-20 21:45:11', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Hector', 'Olivos', 'Lussona', '4b67deeb9aba04a5b54632ad19934f26', 'uploads/1632106140_avatar.gif', NULL, 1, '2021-01-20 14:02:37', '2021-09-19 21:49:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `assembly_hall`
--
ALTER TABLE `assembly_hall`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `assembly_hall`
--
ALTER TABLE `assembly_hall`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
