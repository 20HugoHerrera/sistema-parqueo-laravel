-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2025 a las 12:11:12
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
-- Base de datos: `sistema-parqueo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('sistema-parqueo-cache-crit@gmail.com|127.0.0.1', 'i:5;', 1761228044),
('sistema-parqueo-cache-crit@gmail.com|127.0.0.1:timer', 'i:1761228044;', 1761228044),
('sistema-parqueo-cache-hugoherrera123@gmail.com|127.0.0.1', 'i:1;', 1761688483),
('sistema-parqueo-cache-hugoherrera123@gmail.com|127.0.0.1:timer', 'i:1761688483;', 1761688483);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehiculo_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `espacio_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hora_entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','finalizado') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `vehiculo_id`, `usuario_id`, `espacio_id`, `hora_entrada`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 1, '2025-10-22 08:37:31', 'activo', '2025-10-22 08:37:31', '2025-10-22 08:37:31'),
(2, 1, 5, 2, '2025-10-22 08:37:44', 'finalizado', '2025-10-22 08:37:44', '2025-10-22 09:16:38'),
(3, 4, 11, 2, '2025-10-23 09:24:13', 'activo', '2025-10-23 09:24:13', '2025-10-23 09:24:13'),
(4, 3, 11, 3, '2025-10-23 09:24:45', 'finalizado', '2025-10-23 09:24:45', '2025-10-23 23:07:00'),
(5, 7, 11, 4, '2025-10-23 20:03:02', 'finalizado', '2025-10-23 20:03:02', '2025-10-23 20:03:21'),
(6, 8, 11, 5, '2025-10-23 20:06:49', 'finalizado', '2025-10-23 20:06:49', '2025-10-23 20:06:55'),
(7, 1, 11, 6, '2025-10-23 20:56:51', 'activo', '2025-10-23 20:56:51', '2025-10-23 20:56:51'),
(8, 10, 5, 8, '2025-10-23 23:03:54', 'finalizado', '2025-10-23 23:03:54', '2025-10-23 23:04:03'),
(9, 11, 5, 4, '2025-10-23 23:06:39', 'activo', '2025-10-23 23:06:39', '2025-10-23 23:06:39'),
(11, 13, 5, 3, '2025-10-27 20:14:54', 'activo', '2025-10-27 20:14:54', '2025-10-27 20:14:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacios`
--

CREATE TABLE `espacios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `espacios`
--

INSERT INTO `espacios` (`id`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Espacio 1', '1', 1, '2025-10-22 08:37:07', '2025-10-23 06:50:05'),
(2, 'Espacio 2', '2', 1, '2025-10-22 08:37:20', '2025-10-22 08:37:20'),
(3, 'Espacio 3', '3', 1, '2025-10-23 09:12:50', '2025-10-23 09:12:50'),
(4, 'Espacio 4', '4', 1, '2025-10-23 09:19:13', '2025-10-23 09:19:13'),
(5, 'Espacio 5', '5', 1, '2025-10-23 09:19:24', '2025-10-23 09:19:24'),
(6, 'Espacio 6', '6', 1, '2025-10-23 09:19:35', '2025-10-23 09:19:35'),
(7, 'Espacio 7', '7', 1, '2025-10-23 09:19:52', '2025-10-23 09:19:52'),
(8, 'Espacio 8', '8', 1, '2025-10-23 09:20:09', '2025-10-23 09:20:09'),
(9, 'Espacio 9', '9', 1, '2025-10-23 09:20:17', '2025-10-23 09:20:17'),
(10, 'Espacio 10', '10', 1, '2025-10-23 20:53:41', '2025-10-23 20:53:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_25_135000_create_espacios_table', 1),
(5, '2025_09_25_135423_create_vehiculos_table', 1),
(6, '2025_09_25_135636_create_entradas_table', 1),
(7, '2025_09_25_135655_create_salidas_table', 1),
(8, '2025_09_25_135730_create_usuarios_table', 1),
(9, '2025_09_25_135731_create_roles_table', 1),
(10, '2025_09_25_135831_create_usuario-roles_table', 1),
(11, '2025_10_07_165317_drop_usuario_id_from_vehiculos_table', 2),
(13, '2025_10_20_144500_create_roles_table', 1),
(14, '2025_10_22_003750_add_propietario_to_vehiculos_table', 3),
(15, '2025_10_22_011337_update_vehiculos_table_add_propietario_drop_usuario_id', 4),
(16, '2025_10_20_144450_create_permission_tables', 5),
(17, '2025_10_23_010149_add_avatar_to_users_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('hugoherreraherrera123@gmail.com', '$2y$12$gmJgu.6XpC1NEk7frAnQWuKslzQM/v..QKR7hNMP3S.wf82uIgc3O', '2025-10-23 08:30:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-10-22 02:30:15', '2025-10-22 02:30:15'),
(2, 'usuario', 'web', '2025-10-22 02:30:15', '2025-10-22 02:30:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehiculo_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `hora_salida` timestamp NOT NULL DEFAULT current_timestamp(),
  `tiempo_estadia` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id`, `vehiculo_id`, `usuario_id`, `hora_salida`, `tiempo_estadia`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-10-22 09:16:38', 39, '2025-10-22 09:16:38', '2025-10-22 09:16:38'),
(2, 7, 11, '2025-10-23 20:03:21', 0, '2025-10-23 20:03:21', '2025-10-23 20:03:21'),
(3, 8, 11, '2025-10-23 20:06:55', 0, '2025-10-23 20:06:55', '2025-10-23 20:06:55'),
(4, 10, 5, '2025-10-23 23:04:03', 0, '2025-10-23 23:04:03', '2025-10-23 23:04:03'),
(5, 3, 5, '2025-10-23 23:07:00', 822, '2025-10-23 23:07:00', '2025-10-23 23:07:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Hugo Alfredo Herrera', 'hugoherreraherrera123@gmail.com', 'AkOIIQFy7WnkFNnaUQJBi5LfvXGbNJAUTBCA4fIs.jpg', NULL, '$2y$12$XVptrDkcxh9fjl0L1bXTduSAjTWBO09LCGf/FaZfbEzN8hbKISIsG', 'MZXweMfJ47A5F1oUodsAGcJHKbEhTkDMjRYIUCAI2eIi2zFzp79dOUHxEg7u', '2025-10-22 06:25:17', '2025-10-27 20:12:47'),
(10, 'Yeimy Hernandez', 'yeimy.hernandez123@gmail.com', 'iF7f1m8QYmlPppYSWt2p9BwpWLAm87FIduLH29iR.jpg', NULL, '$2y$12$2fqfKbmU94/j6f/LsXlLj.r1sx9HR7kyKeZAgNNuYT4XMs0uHVWi6', 'xuPM3pFc3QF8r6PHUWrX1fz715iz1m8Jgrkz4MeR8eZbUoPwvCNDh8GwFE73', '2025-10-22 08:32:36', '2025-10-23 08:43:28'),
(11, 'Cristopher Alexander Escobar', 'cristopher.alexander123@gmail.com', 'i0KIjcUk2HHe9ZcQUVth0ZBr20Ywf1pqMKwvlEv4.png', NULL, '$2y$12$snzkR6GVLi.NLGFluAJzPetiL3YP59rsda3Htkt16Xj5K2vJWWj3e', NULL, '2025-10-23 08:45:00', '2025-10-23 08:47:20'),
(12, 'Lindsay Hernandez', 'Lindsay.Hernandez123@gmail.com', NULL, NULL, '$2y$12$OV3BsVUrbp2QZK88jbZEEOfcbPlEhBzq3/QkDLqcwEM8u8/hT7YoG', NULL, '2025-10-23 08:45:25', '2025-10-23 08:45:25'),
(13, 'Veronica Lissbeth Rodas', 'veronica.rodas123@gmail.com', 'OjYv53zlycoKaWsyJSq2vWRrXr4tbDDWLWhr7ip1.jpg', NULL, '$2y$12$HezkGPGfbAXbrT6EY2yWR.ybM/FrG7BuI7sVjqhNqBBgUjZKxeHza', 'M9ObFrJVftUCqHpxo5bXk6jAA1avLdgGvKIyygV1x7vZmJMjcD94kNon18M7', '2025-10-23 08:46:30', '2025-10-27 20:17:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_roles`
--

CREATE TABLE `usuario_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_roles`
--

INSERT INTO `usuario_roles` (`id`, `user_id`, `rol_id`, `created_at`, `updated_at`) VALUES
(3, 5, 1, NULL, NULL),
(8, 10, 2, NULL, NULL),
(9, 11, 1, NULL, NULL),
(10, 12, 1, NULL, NULL),
(11, 13, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `placa` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `propietario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `tipo`, `user_id`, `created_at`, `updated_at`, `propietario`) VALUES
(1, 'P425-ABC', 'Honda civic', 5, '2025-10-22 07:37:31', '2025-10-23 09:22:50', 'Cristopher Perez'),
(2, 'P123-ABC', 'Toyota Hilux', 5, '2025-10-22 08:36:47', '2025-10-23 09:22:46', 'Juan Perez'),
(3, 'P773-ABC', 'Tipo sedan', 11, '2025-10-23 09:22:34', '2025-10-23 09:22:34', 'Oscar Hernandez'),
(4, 'P103-ABC', 'Nissan Centra', 11, '2025-10-23 09:23:41', '2025-10-23 09:23:41', 'Edgar Sanchez'),
(5, '00005555', 'hilux', 11, '2025-10-23 20:00:42', '2025-10-23 20:00:42', 'Gerson'),
(6, '0002222', 'hilux', 11, '2025-10-23 20:01:47', '2025-10-23 20:01:47', 'juan'),
(7, 'P10P 12EF', 'HILUX', 11, '2025-10-23 20:02:24', '2025-10-23 20:02:24', 'GERSON'),
(8, 'GTP13ED', 'NISSAN', 11, '2025-10-23 20:06:32', '2025-10-23 20:06:32', 'STEVEN'),
(9, 'FER444', 'Honda civic', 5, '2025-10-23 22:46:38', '2025-10-23 22:46:38', 'FRANCISCO'),
(10, 'FGH367', 'Toyota Hilux', 5, '2025-10-23 23:03:20', '2025-10-23 23:03:20', 'SARAI'),
(11, 'P123355', 'Toyota Hilux 23', 5, '2025-10-23 23:06:21', '2025-10-23 23:06:21', 'Karla'),
(13, 'P-124585', 'Tipo sedan', 5, '2025-10-27 20:13:39', '2025-10-27 20:13:59', 'Hugo Herrera'),
(14, 'P-124587', 'Tipo sedan', 5, '2025-10-27 20:23:29', '2025-10-27 20:23:29', 'Hugo Herrera');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entradas_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `entradas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `entradas_espacio_id_foreign` (`espacio_id`);

--
-- Indices de la tabla `espacios`
--
ALTER TABLE `espacios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `espacios_nombre_unique` (`nombre`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salidas_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `salidas_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuario_roles`
--
ALTER TABLE `usuario_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_roles_user_id_foreign` (`user_id`),
  ADD KEY `usuario_roles_rol_id_foreign` (`rol_id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehiculos_placa_unique` (`placa`),
  ADD KEY `vehiculos_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `espacios`
--
ALTER TABLE `espacios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario_roles`
--
ALTER TABLE `usuario_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_espacio_id_foreign` FOREIGN KEY (`espacio_id`) REFERENCES `espacios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `entradas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entradas_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salidas_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_roles`
--
ALTER TABLE `usuario_roles`
  ADD CONSTRAINT `usuario_roles_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
