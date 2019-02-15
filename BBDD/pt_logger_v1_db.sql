-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-02-2019 a las 17:29:19
-- Versión del servidor: 5.5.62-0+deb8u1
-- Versión de PHP: 5.6.39-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pt_logger_v1_db`
--
CREATE DATABASE IF NOT EXISTS `pt_logger_v1_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pt_logger_v1_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `device_id` varchar(50) NOT NULL,
  `device_token` varchar(75) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `device_name` varchar(254) DEFAULT NULL,
  `device_firmware` varchar(25) DEFAULT NULL,
  `device_last_ip` varchar(25) DEFAULT NULL,
  `device_last_connection` datetime DEFAULT NULL,
  `device_info` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logged_values`
--

DROP TABLE IF EXISTS `logged_values`;
CREATE TABLE IF NOT EXISTS `logged_values` (
`value_id` int(11) NOT NULL,
  `device_id` varchar(50) NOT NULL,
  `value_type` tinyint(4) NOT NULL,
  `value_data` double NOT NULL,
  `value_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31036 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` smallint(6) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_info` varchar(254) DEFAULT NULL,
  `user_signup_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `value_types`
--

DROP TABLE IF EXISTS `value_types`;
CREATE TABLE IF NOT EXISTS `value_types` (
`type_id` tinyint(4) NOT NULL,
  `type_name` varchar(254) NOT NULL,
  `type_unit` varchar(25) NOT NULL,
  `type_info` varchar(254) DEFAULT NULL,
  `variable_name` varchar(254) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
 ADD PRIMARY KEY (`device_id`), ADD UNIQUE KEY `device_id` (`device_id`), ADD UNIQUE KEY `device_token` (`device_token`), ADD KEY `devices_users_fk` (`user_id`);

--
-- Indices de la tabla `logged_values`
--
ALTER TABLE `logged_values`
 ADD PRIMARY KEY (`value_id`), ADD UNIQUE KEY `value_id` (`value_id`), ADD KEY `logged_values_value_types_fk` (`value_type`), ADD KEY `logged_values_device_id_fk` (`device_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_id` (`user_id`), ADD UNIQUE KEY `user_password` (`user_password`), ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indices de la tabla `value_types`
--
ALTER TABLE `value_types`
 ADD PRIMARY KEY (`type_id`), ADD UNIQUE KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logged_values`
--
ALTER TABLE `logged_values`
MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31036;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `user_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `value_types`
--
ALTER TABLE `value_types`
MODIFY `type_id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `devices`
--
ALTER TABLE `devices`
ADD CONSTRAINT `devices_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `logged_values`
--
ALTER TABLE `logged_values`
ADD CONSTRAINT `logged_values_device_id_fk` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`),
ADD CONSTRAINT `logged_values_value_types_fk` FOREIGN KEY (`value_type`) REFERENCES `value_types` (`type_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
