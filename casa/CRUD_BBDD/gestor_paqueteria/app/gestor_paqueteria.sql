-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 12:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestor_paqueteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `telefono`, `direccion`, `ciudad`, `cp`, `creado_en`) VALUES
(1, 'Carmen López', '600111222', 'Calle Mayor 15', 'Cehegín', '30430', '2025-11-16 09:04:20'),
(2, 'José Antonio Mazón', '644277527', 'Avenida de la Libertad 21', 'Murcia', '30007', '2025-11-16 09:04:20'),
(3, 'Ana García', '611333444', 'Calle Sol 8', 'Caravaca de la Cruz', '30400', '2025-11-16 09:04:20'),
(4, 'Luis Martínez', '622555666', 'Plaza España 3', 'Bullas', '30180', '2025-11-16 09:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','en_reparto','entregado','incidencia') NOT NULL DEFAULT 'pendiente',
  `notas` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paquetes`
--

INSERT INTO `paquetes` (`id`, `id_cliente`, `descripcion`, `fecha_creacion`, `estado`, `notas`, `creado_en`) VALUES
(1, 1, 'Paquete pequeño - documentación', '2025-11-13 10:04:20', 'entregado', 'Entregado sin incidencias.', '2025-11-16 09:04:20'),
(2, 1, 'Caja mediana - ropa', '2025-11-15 10:04:20', 'en_reparto', 'Cliente pide entrega por la tarde.', '2025-11-16 09:04:20'),
(3, 2, 'Paquete grande - componentes PC', '2025-11-14 10:04:20', 'pendiente', 'Esperando salida del almacén.', '2025-11-16 09:04:20'),
(4, 2, 'Sobre acolchado - libro', '2025-11-11 10:04:20', 'entregado', 'Dejado en portería.', '2025-11-16 09:04:20'),
(5, 3, 'Caja mediana - menaje cocina', '2025-11-12 10:04:20', 'incidencia', 'Dirección incompleta, pendiente de contactar.', '2025-11-16 09:04:20'),
(6, 4, 'Paquete pequeño - accesorios móvil', '2025-11-15 10:04:20', 'pendiente', NULL, '2025-11-16 09:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` enum('admin','operario') NOT NULL DEFAULT 'operario',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password_hash`, `rol`, `creado_en`) VALUES
(1, 'Admin General', 'admin@paqueteria.test', 'ADMIN_PASSWORD_EJEMPLO', 'admin', '2025-11-16 09:04:20'),
(2, 'Operario Juan', 'juan@paqueteria.test', 'OPERARIO_PASSWORD_EJEMPLO', 'operario', '2025-11-16 09:04:20'),
(3, 'mazon', 'mazon@kk.com', '$2y$10$gBPpiU94uPF8LTYei7So1e92.25bEP6/CCZW0JblJipMCgHjTafZa', 'operario', '2025-11-16 18:44:47'),
(4, 'carmen', 'carmen@kk.com', '$2y$10$L9ZHfzEAkFq5JaKxXa5vQ.2ORE5lezQrQvtfkDwT790YtUj9fgOO6', 'operario', '2025-11-16 20:18:52'),
(5, 'mario', 'mario@kk.com', '$2y$10$6pWeV0Rry/57Gcmz/TIdGuYNZ0aYVYpZ2ZFqQxFZWvi3sE7yw2Bq.', 'operario', '2025-11-19 11:14:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_paquetes_estado` (`estado`),
  ADD KEY `idx_paquetes_id_cliente` (`id_cliente`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `fk_paquetes_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
