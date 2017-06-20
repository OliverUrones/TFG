-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-06-2017 a las 19:52:32
-- Versión del servidor: 5.6.30-1
-- Versión de PHP: 7.0.19-1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repositorio`
--
DROP DATABASE IF EXISTS `repositorio`;
CREATE DATABASE IF NOT EXISTS `repositorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `repositorio`;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`archivo_id`, `usuario_id`, `categoria_id`, `nombre`, `enlace_descarga`, `ambito`, `etiquetas`) VALUES
(1, 1, 1, 'Archivo de prueba', 'Archivo de prueba-15-06-2017-14-47-43.pdf', 1, 'Archivo, prueba');

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `nombre`, `categoria_padre`) VALUES
(1, 'InformÃƒÂ¡tica', NULL),
(2, 'Lengua', NULL),
(3, 'MatemÃƒÂ¡ticas', NULL),
(4, 'InglÃƒÂ©s', 5),
(5, 'Idiomas', NULL),
(6, 'FrancÃƒÂ©s', 5);

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `rol_id`, `email`, `password`, `nombre`, `apellidos`, `token`, `validez_token`, `fecha_creacion`, `estado`) VALUES
(1, 1, 'admin@admin.es', '$2y$10$bAME5DpZcDmCyQyz3SLjluv.Hd/WoPkEZV7ep7PuMQdx4hptTJOMe', 'Administrador', 'Admin', 't594280838a88e', 1497531099, '2017-06-14 23:06:52', 1);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
