-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 22:15:59
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
-- Base de datos: `todo_camisetas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisetas`
--

CREATE TABLE `camisetas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `club` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `codigo_producto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camisetas`
--

INSERT INTO `camisetas` (`id`, `titulo`, `club`, `pais`, `tipo`, `color`, `precio`, `precio_oferta`, `detalles`, `codigo_producto`) VALUES
(1, 'Camiseta Local 2025 – Chile (Actualizada)', 'Selección Chilena', 'Chile', 'Local', 'Rojo Intenso', 45500.00, 40500.00, 'Actualización 2025', 'SCL2025L2'),
(2, 'Camiseta Visita 2025 – Real Madrid', 'Real Madrid', 'España', 'Visita', 'Blanco y Dorado', 48000.00, NULL, 'Con tecnología AeroDry', 'RM2025V');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camiseta_tallas`
--

CREATE TABLE `camiseta_tallas` (
  `id` int(11) NOT NULL,
  `camiseta_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camiseta_tallas`
--

INSERT INTO `camiseta_tallas` (`id`, `camiseta_id`, `talla_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 2),
(6, 2, 3),
(7, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(100) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `categoria` enum('Regular','Preferencial') DEFAULT 'Regular',
  `contacto_nombre` varchar(100) DEFAULT NULL,
  `contacto_correo` varchar(100) DEFAULT NULL,
  `porcentaje_descuento` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre_comercial`, `rut`, `direccion`, `categoria`, `contacto_nombre`, `contacto_correo`, `porcentaje_descuento`) VALUES
(1, '90minutos Actualizado', '76.123.456-7', 'Providencia, Santiago', 'Preferencial', 'Carlos Pérez', 'cperez@90minactual.cl', 12.50),
(2, 'tdeportes', '77.654.321-9', 'Concepción, Biobío', 'Regular', 'Ana Gómez', 'agomez@tdeportes.cl', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `nombre`) VALUES
(3, 'L'),
(2, 'M'),
(1, 'S'),
(4, 'XL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camiseta_id` (`camiseta_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  ADD CONSTRAINT `camiseta_tallas_ibfk_1` FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `camiseta_tallas_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
