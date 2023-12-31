-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-08-2023 a las 22:46:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chatland`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id_chats` int(11) NOT NULL,
  `ultima_actividad` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`id_chats`, `ultima_actividad`) VALUES
(9, '2023-08-13 15:03:38'),
(11, '2023-08-13 15:08:54'),
(15, '2023-08-15 16:38:08'),
(18, '2023-08-25 23:42:52'),
(19, '2023-08-27 17:46:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats_de_usuarios`
--

CREATE TABLE `chats_de_usuarios` (
  `fk_chats` int(11) NOT NULL,
  `fk_usuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `chats_de_usuarios`
--

INSERT INTO `chats_de_usuarios` (`fk_chats`, `fk_usuarios`) VALUES
(9, 2),
(9, 3),
(11, 2),
(11, 4),
(15, 3),
(15, 4),
(18, 2),
(18, 5),
(19, 4),
(19, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id_fotos` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fk_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id_fotos`, `nombre`, `fk_usuario`) VALUES
(19, '20230827221011_BobEsponga.webp', 5),
(20, '20230827221057_mafalda.jfif', 4),
(21, '20230827221126_tom.jpg', 3),
(22, '20230827221301_Abraham_anime.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensajes` int(11) NOT NULL,
  `contenido` varchar(1200) NOT NULL,
  `tiempo_de_envio` datetime NOT NULL,
  `fk_usuarios` int(11) NOT NULL,
  `fk_chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_mensajes`, `contenido`, `tiempo_de_envio`, `fk_usuarios`, `fk_chat`) VALUES
(1, 'hola mundo', '2023-08-15 19:30:43', 4, 11),
(2, 'hola abraham', '2023-08-15 19:32:46', 4, 11),
(3, 'Hola juan', '2023-08-15 19:38:39', 4, 15),
(4, 'hola pepe todo bien?\r\n', '2023-08-15 19:59:12', 2, 11),
(5, 'Hola, como estas?\r\n', '2023-08-22 20:01:30', 3, 9),
(6, 'muy bien y vos?\r\n', '2023-08-22 20:01:48', 2, 9),
(7, 'excelente.\r\n', '2023-08-22 20:07:11', 3, 9),
(8, 'mensaje genérico', '2023-08-22 20:07:28', 2, 9),
(9, 'mensaje generico', '2023-08-22 20:07:34', 2, 9),
(10, 'mensaje genérico', '2023-08-22 20:07:52', 3, 9),
(11, 'hola facu\r\n', '2023-08-25 23:43:17', 2, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ultima_conexion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `username`, `password`, `email`, `ultima_conexion`) VALUES
(2, '@abraham', '$2y$10$xJQWQ5bz1AtFIUp0v03cnud1y72hfpcxRH4tbdIKI1TOAeSWdg2.S', 'abraham@prueba.com', '2023-08-12 19:38:36'),
(3, '@juan', '$2y$10$cF0R9sJcQucSMeghB9EZIO2XWZl6t3t8gOUqdNBqiEGzlEHpC/KEi', 'juan@prueba.com', '2023-08-13 11:16:45'),
(4, '@pepe grillo', '$2y$10$cJN8jizKVfpsR7N8LXwxveJufwk0H93ovsQBmbjmJpnBQbX.mehau', 'pepe@prueba.com', '2023-08-13 15:08:26'),
(5, '@facu', '$2y$10$w3JS65seqtLR5LsTRRB3r.F7flDpVgFDvO2WWZq3CQUm8O7N3IpbO', 'facu@prueba.com', '2023-08-25 23:42:41');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id_chats`);

--
-- Indices de la tabla `chats_de_usuarios`
--
ALTER TABLE `chats_de_usuarios`
  ADD PRIMARY KEY (`fk_chats`,`fk_usuarios`),
  ADD KEY `fk_chats_has_usuarios_usuarios1_idx` (`fk_usuarios`),
  ADD KEY `fk_chats_has_usuarios_chats1_idx` (`fk_chats`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id_fotos`),
  ADD KEY `fk_fotos_usuarios1_idx` (`fk_usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensajes`),
  ADD KEY `fk_mensajes_usuarios1_idx` (`fk_usuarios`),
  ADD KEY `fk_mensajes_chats1_idx` (`fk_chat`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `id_chats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id_fotos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensajes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chats_de_usuarios`
--
ALTER TABLE `chats_de_usuarios`
  ADD CONSTRAINT `fk_chats_has_usuarios_chats1` FOREIGN KEY (`fk_chats`) REFERENCES `chats` (`id_chats`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_chats_has_usuarios_usuarios1` FOREIGN KEY (`fk_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_fotos_usuarios1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `fk_mensajes_chats1` FOREIGN KEY (`fk_chat`) REFERENCES `chats` (`id_chats`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mensajes_usuarios1` FOREIGN KEY (`fk_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
