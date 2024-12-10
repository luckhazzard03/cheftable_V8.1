-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2024 a las 20:46:10
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
-- Base de datos: `chef_table7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres`
--

CREATE TABLE `cierres` (
  `idCierre` int(10) UNSIGNED NOT NULL,
  `Fecha` date NOT NULL,
  `Total_Dia` decimal(10,0) NOT NULL,
  `Total_Semana` decimal(10,0) NOT NULL,
  `Total_Mes` decimal(10,0) NOT NULL,
  `idUsuario_fk` int(10) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `Comanda_id` int(11) UNSIGNED NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Total_platos` int(10) UNSIGNED NOT NULL,
  `Precio_Total` decimal(10,2) UNSIGNED NOT NULL,
  `Tipo_Menu` varchar(45) NOT NULL,
  `Adicionales` decimal(10,2) UNSIGNED DEFAULT NULL,
  `idUsuario_fk` int(11) UNSIGNED NOT NULL,
  `idMesa_fk` int(11) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`Comanda_id`, `Fecha`, `Hora`, `Total_platos`, `Precio_Total`, `Tipo_Menu`, `Adicionales`, `idUsuario_fk`, `idMesa_fk`, `create_at`, `update_at`) VALUES
(2, '2024-12-03', '11:42:00', 3, 40000.00, 'Corriente', 4000.00, 3, 1, '2024-12-03 21:42:20', '2024-12-03 21:42:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda_menu`
--

CREATE TABLE `comanda_menu` (
  `Comanda_menu_id` int(11) UNSIGNED NOT NULL,
  `Cantidad_Menu` int(10) UNSIGNED NOT NULL,
  `Precio` decimal(10,2) UNSIGNED NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Comanda_fk` int(11) UNSIGNED DEFAULT NULL,
  `Menu_fk` int(11) UNSIGNED DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `idInventario` int(11) UNSIGNED NOT NULL,
  `Producto` varchar(30) NOT NULL,
  `Cantidad` int(200) NOT NULL,
  `Cantidad_Minima` int(200) NOT NULL,
  `idUsuario_fk` int(11) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menudiarios`
--

CREATE TABLE `menudiarios` (
  `idDiario` int(11) UNSIGNED NOT NULL,
  `Dia` varchar(45) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `Menu_id_fk` int(11) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `Menu_id` int(11) UNSIGNED NOT NULL,
  `Tipo_Menu` varchar(45) NOT NULL,
  `Precio_Menu` decimal(10,2) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`Menu_id`, `Tipo_Menu`, `Precio_Menu`, `create_at`, `update_at`) VALUES
(1, 'Corriente', 12000.00, NULL, '0000-00-00 00:00:00'),
(2, 'Ejecutivo', 18000.00, NULL, '0000-00-00 00:00:00'),
(3, 'Especial', 30000.00, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `idMesa` int(11) UNSIGNED NOT NULL,
  `No_Orden` int(11) NOT NULL,
  `Estado` varchar(45) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `No_Orden`, `Estado`, `Capacidad`, `create_at`, `update_at`) VALUES
(1, 0, 'Disponible', 4, NULL, '0000-00-00 00:00:00'),
(2, 0, 'Disponible', 5, NULL, '0000-00-00 00:00:00'),
(3, 0, 'Disponible', 6, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-06-20-032956', 'App\\Database\\Migrations\\AddRoles', 'default', 'App', 1733243493, 1),
(2, '2024-06-20-033056', 'App\\Database\\Migrations\\AddUsuario', 'default', 'App', 1733243493, 1),
(3, '2024-06-20-033149', 'App\\Database\\Migrations\\AddMesa', 'default', 'App', 1733243493, 1),
(4, '2024-06-20-033244', 'App\\Database\\Migrations\\AddComanda', 'default', 'App', 1733243493, 1),
(5, '2024-06-20-033331', 'App\\Database\\Migrations\\AddCierre', 'default', 'App', 1733243493, 1),
(6, '2024-06-20-033415', 'App\\Database\\Migrations\\AddMenus', 'default', 'App', 1733243493, 1),
(7, '2024-06-20-033459', 'App\\Database\\Migrations\\AddComandaMenu', 'default', 'App', 1733243493, 1),
(8, '2024-06-20-033548', 'App\\Database\\Migrations\\AddInventario', 'default', 'App', 1733243493, 1),
(9, '2024-06-20-033640', 'App\\Database\\Migrations\\AddProveedor', 'default', 'App', 1733243493, 1),
(10, '2024-06-20-033732', 'App\\Database\\Migrations\\AddMenuDiario', 'default', 'App', 1733243493, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) UNSIGNED NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Tipo` varchar(45) NOT NULL,
  `idUsuario_fk` int(11) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) UNSIGNED NOT NULL,
  `Rol` varchar(45) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `Rol`, `Descripcion`, `create_at`, `update_at`) VALUES
(1, 'Admin', 'Gestiona todo', '2024-12-03 16:33:17', NULL),
(2, 'Cheft', 'Gestiona Cocina', '2024-12-03 16:33:17', NULL),
(3, 'Mesero', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL),
(4, 'Mesero2', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL),
(5, 'Mesero3', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL),
(6, 'Mesero4', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL),
(7, 'Mesero5', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL),
(8, 'Mesero6', 'Gestiona Comandas y mesas', '2024-12-03 16:33:17', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) UNSIGNED NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `idRoles_fk` int(11) UNSIGNED NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Password`, `Email`, `Telefono`, `idRoles_fk`, `create_at`, `update_at`) VALUES
(1, 'Angel', '$2y$10$lb17Qz0i5ebT0grKRklsrOxh.0x.gVijreG6KvY27u9Mtdtt9gyzi', 'a@gmail.com', '457485', 1, '2024-12-03 16:33:43', NULL),
(2, 'Julian alcides', '$2y$10$qWPIA8QLNz6kekhVatkIIesoN0oVJHjWZJvl7EBgapE9kK46R8ELa', 'j@gmail.com', '3002288475', 2, NULL, '0000-00-00 00:00:00'),
(3, 'Juan k', '$2y$10$iD/VGZtPFyeJ1zpk3UHx2.wrg133r.9pK/1mT/k34kM982MaN2TPW', 'Ju@gmail.com', '3002254546', 3, NULL, '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cierres`
--
ALTER TABLE `cierres`
  ADD PRIMARY KEY (`idCierre`),
  ADD KEY `fk_Cierre_Usuario1` (`idUsuario_fk`);

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`Comanda_id`),
  ADD KEY `comandas_idUsuario_fk_foreign` (`idUsuario_fk`),
  ADD KEY `comandas_idMesa_fk_foreign` (`idMesa_fk`);

--
-- Indices de la tabla `comanda_menu`
--
ALTER TABLE `comanda_menu`
  ADD PRIMARY KEY (`Comanda_menu_id`),
  ADD KEY `comanda_menu_Comanda_fk_foreign` (`Comanda_fk`),
  ADD KEY `comanda_menu_Menu_fk_foreign` (`Menu_fk`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `inventarios_idUsuario_fk_foreign` (`idUsuario_fk`);

--
-- Indices de la tabla `menudiarios`
--
ALTER TABLE `menudiarios`
  ADD PRIMARY KEY (`idDiario`),
  ADD KEY `menudiarios_Menu_id_fk_foreign` (`Menu_id_fk`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`Menu_id`),
  ADD UNIQUE KEY `Tipo_Menu` (`Tipo_Menu`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`),
  ADD KEY `proveedores_idUsuario_fk_foreign` (`idUsuario_fk`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `usuarios_idRoles_fk_foreign` (`idRoles_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cierres`
--
ALTER TABLE `cierres`
  MODIFY `idCierre` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comandas`
--
ALTER TABLE `comandas`
  MODIFY `Comanda_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comanda_menu`
--
ALTER TABLE `comanda_menu`
  MODIFY `Comanda_menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `idInventario` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menudiarios`
--
ALTER TABLE `menudiarios`
  MODIFY `idDiario` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `Menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `idMesa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cierres`
--
ALTER TABLE `cierres`
  ADD CONSTRAINT `fk_Cierre_Usuario1` FOREIGN KEY (`idUsuario_fk`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `comandas_idMesa_fk_foreign` FOREIGN KEY (`idMesa_fk`) REFERENCES `mesas` (`idMesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comandas_idUsuario_fk_foreign` FOREIGN KEY (`idUsuario_fk`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comanda_menu`
--
ALTER TABLE `comanda_menu`
  ADD CONSTRAINT `comanda_menu_Comanda_fk_foreign` FOREIGN KEY (`Comanda_fk`) REFERENCES `comandas` (`Comanda_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comanda_menu_Menu_fk_foreign` FOREIGN KEY (`Menu_fk`) REFERENCES `menus` (`Menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_idUsuario_fk_foreign` FOREIGN KEY (`idUsuario_fk`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menudiarios`
--
ALTER TABLE `menudiarios`
  ADD CONSTRAINT `menudiarios_Menu_id_fk_foreign` FOREIGN KEY (`Menu_id_fk`) REFERENCES `menus` (`Menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_idUsuario_fk_foreign` FOREIGN KEY (`idUsuario_fk`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_idRoles_fk_foreign` FOREIGN KEY (`idRoles_fk`) REFERENCES `roles` (`idRoles`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
