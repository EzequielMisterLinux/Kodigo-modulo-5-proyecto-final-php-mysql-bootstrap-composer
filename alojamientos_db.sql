-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-01-2025 a las 04:34:32
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
-- Base de datos: `alojamientos_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alojamientos`
--

CREATE TABLE `alojamientos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `alojamientos`
--

INSERT INTO `alojamientos` (`id`, `nombre`, `descripcion`, `precio`, `ubicacion`, `imagen_url`, `created_at`) VALUES
(1, 'Casa de Playa', 'Hermosa casa frente al mar', 150.00, 'Playa del Carmen', 'images/casa-playa.jpg', '2025-01-02 21:16:45'),
(4, 'Playa ', 'playa El congo xd', 200.00, 'San miguel', 'https://upload.wikimedia.org/wikipedia/commons/9/96/Barbados_beach.jpg', '2025-01-02 22:03:41'),
(5, 'Playa San salvador el tunco', 'Playa San salvador', 140.00, 'San Salvador', 'https://i0.wp.com/juanlievano.com/wp-content/uploads/2020/12/DSC_0050-1024x683-1.jpg?resize=1024%2C683&ssl=1', '2025-01-03 03:12:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2025-01-02 21:16:45'),
(2, 'ezequielcampos', 'humbertoezequiel.z.c@gmail.com', '$2y$10$SGK3dfnwvXcxWNQon/AQquMkPlm7G7mO6Ihbk7Xj7uNJg.VdPERty', 1, '2025-01-02 21:38:21'),
(3, 'kenia', 'kenia@gmail.com', '$2y$10$fNp1VR6Sgj4LQBNFBBC1FeKP8E5tzeTNOpBaRAThGa9RVW/ckspHW', 0, '2025-01-03 03:28:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_alojamientos`
--

CREATE TABLE `user_alojamientos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alojamiento_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_alojamientos`
--

INSERT INTO `user_alojamientos` (`id`, `user_id`, `alojamiento_id`, `created_at`) VALUES
(4, 2, 4, '2025-01-03 03:09:52'),
(6, 3, 5, '2025-01-03 03:29:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alojamientos`
--
ALTER TABLE `alojamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `user_alojamientos`
--
ALTER TABLE `user_alojamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `alojamiento_id` (`alojamiento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alojamientos`
--
ALTER TABLE `alojamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user_alojamientos`
--
ALTER TABLE `user_alojamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user_alojamientos`
--
ALTER TABLE `user_alojamientos`
  ADD CONSTRAINT `user_alojamientos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_alojamientos_ibfk_2` FOREIGN KEY (`alojamiento_id`) REFERENCES `alojamientos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
