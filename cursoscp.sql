-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-01-2025 a las 19:00:25
-- Versión del servidor: 8.0.40-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursoscp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `abierto` tinyint(1) DEFAULT NULL,
  `numeroplazas` int DEFAULT NULL,
  `plazoinscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombre`, `abierto`, `numeroplazas`, `plazoinscripcion`) VALUES
(100001, 'Curso de Matemáticas Avanzadas', 1, 5, '2025-01-31'),
(100002, 'Introducción a la Física', 1, 4, '2025-02-15'),
(100003, 'Taller de Inglés para Profesores', 1, 3, '2024-12-01'),
(100014, 'Curso de Lengua', 1, 1, '2025-02-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitantes`
--

CREATE TABLE `solicitantes` (
  `dni` varchar(9) NOT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `codigocentro` varchar(8) DEFAULT NULL,
  `coordinadortc` tinyint(1) DEFAULT NULL,
  `grupotc` tinyint(1) DEFAULT NULL,
  `nombregrupo` varchar(5) DEFAULT NULL,
  `pbilin` tinyint(1) DEFAULT NULL,
  `cargo` tinyint(1) DEFAULT NULL,
  `nombrecargo` varchar(15) DEFAULT NULL,
  `situacion` enum('activo','inactivo') DEFAULT NULL,
  `fechanac` varchar(50) DEFAULT NULL,
  `especialidad` varchar(50) DEFAULT NULL,
  `puntos` int DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitantes`
--

INSERT INTO `solicitantes` (`dni`, `apellidos`, `nombre`, `telefono`, `correo`, `codigocentro`, `coordinadortc`, `grupotc`, `nombregrupo`, `pbilin`, `cargo`, `nombrecargo`, `situacion`, `fechanac`, `especialidad`, `puntos`, `password`, `admin`) VALUES
('11223344C', 'Hernández Ruiz', 'Carlos', '680555333', 'carlos.hernandez@example.com', 'CT003', 1, 1, 'G3', 1, 1, 'Coordinador', 'inactivo', '1975-08-10', 'Inglés', 13, '12345', 1),
('11223344D', 'Garcia Martin', 'Alonso', '670692147', 'alonso@gmail.com', 'CT003', 0, 0, 'G3', 0, 0, 'Coordenador', 'activo', '2004-10-30', 'Lengua', 1, '12345', 0),
('11223344E', 'Gonzalez Trujillo', 'Miguel', '690764721', 'miguel@gmail.com', 'CT003', 1, 1, 'G3', 1, 1, 'Coordenador', 'activo', '2000-11-09', 'Lengua', 13, '12345', 0),
('11223344F', 'Rojo Palacios', 'Adrian', '649762217', 'adrian@gmail.com', 'CT001', 0, 1, 'G1', 0, 1, 'Coordenador', 'activo', '1975-03-28', 'Lengua', 6, '12345', 0),
('12345678A', 'García López', 'Juan', '600123456', 'juan.garcia@example.com', 'CT001', 1, 0, 'G1', 0, 1, 'Profesor', 'activo', '1980-05-15', 'Matemáticas', 10, '12345', 0),
('87654321B', 'Martínez Sánchez', 'Laura', '650987654', 'laura.martinez@example.com', 'CT002', 0, 1, 'G2', 1, 0, NULL, 'activo', '1990-03-22', 'Ciencias', 9, '12345', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `dni` varchar(9) NOT NULL,
  `codigocurso` int NOT NULL,
  `fechasolicitud` date DEFAULT NULL,
  `admitido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`dni`, `codigocurso`, `fechasolicitud`, `admitido`) VALUES
('11223344F', 100003, '2025-01-14', 0),
('11223344F', 100014, '2025-01-14', 0),
('87654321B', 100014, '2025-01-14', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `solicitantes`
--
ALTER TABLE `solicitantes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`dni`,`codigocurso`),
  ADD KEY `codigocurso` (`codigocurso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `codigo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100018;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `solicitantes` (`dni`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`codigocurso`) REFERENCES `cursos` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
