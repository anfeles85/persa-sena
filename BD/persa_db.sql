-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.41 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para persa_db
CREATE DATABASE IF NOT EXISTS `persa_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `persa_db`;

-- Volcando estructura para tabla persa_db.apprentice_course
CREATE TABLE IF NOT EXISTS `apprentice_course` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apprentice_course_user_id_course_id_unique` (`user_id`,`course_id`),
  KEY `apprentice_course_course_id_foreign` (`course_id`),
  CONSTRAINT `apprentice_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `apprentice_course_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.apprentice_course: ~5 rows (aproximadamente)
INSERT INTO `apprentice_course` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
	(1, 8, 2, NULL, NULL),
	(2, 9, 1, NULL, NULL),
	(3, 10, 3, NULL, NULL),
	(4, 11, 4, NULL, NULL),
	(5, 12, 2, NULL, NULL);

-- Volcando estructura para tabla persa_db.career
CREATE TABLE IF NOT EXISTS `career` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.career: ~5 rows (aproximadamente)
INSERT INTO `career` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
	(1, 'SST', 'TECNICO', NULL, NULL),
	(2, 'ADSO', 'TECNOLOGO', NULL, NULL),
	(3, 'Gestión documental', 'TECNICO', NULL, NULL),
	(4, 'Enfermeria', 'TECNOLOGO', NULL, NULL),
	(5, 'Deporte', 'TECNICO', NULL, NULL);

-- Volcando estructura para tabla persa_db.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `number_group` bigint unsigned NOT NULL COMMENT 'Numero de ficha',
  `shift` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jornada',
  `trimester` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Trimestre académico',
  `year` int NOT NULL COMMENT 'Año',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Estado',
  `career_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_number_group_unique` (`number_group`),
  KEY `course_career_id_foreign` (`career_id`),
  CONSTRAINT `course_career_id_foreign` FOREIGN KEY (`career_id`) REFERENCES `career` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.course: ~4 rows (aproximadamente)
INSERT INTO `course` (`id`, `number_group`, `shift`, `trimester`, `year`, `status`, `career_id`, `created_at`, `updated_at`) VALUES
	(1, 2921889, 'DIURNA', 'T1', 2023, 'ACTIVO', 1, NULL, NULL),
	(2, 2921881, 'NOCTURNA', 'T2', 2023, 'ACTIVO', 2, NULL, NULL),
	(3, 3257211, 'DIURNA', 'T3', 2025, 'ACTIVO', 3, NULL, NULL),
	(4, 4374821, 'DIURNA', 'T4', 2023, 'INACTIVO', 4, NULL, NULL);

-- Volcando estructura para tabla persa_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla persa_db.instructor_course
CREATE TABLE IF NOT EXISTS `instructor_course` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `instructor_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instructor_course_course_id_instructor_id_unique` (`course_id`,`instructor_id`),
  KEY `instructor_course_instructor_id_foreign` (`instructor_id`),
  CONSTRAINT `instructor_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `instructor_course_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.instructor_course: ~5 rows (aproximadamente)
INSERT INTO `instructor_course` (`id`, `instructor_id`, `course_id`, `created_at`, `updated_at`) VALUES
	(1, 3, 2, NULL, NULL),
	(2, 4, 1, NULL, NULL),
	(3, 5, 3, NULL, NULL),
	(4, 6, 4, NULL, NULL),
	(5, 7, 2, NULL, NULL);

-- Volcando estructura para tabla persa_db.location
CREATE TABLE IF NOT EXISTS `location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del lugar',
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Dirección',
  `guard` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Si alli existe un guardia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.location: ~3 rows (aproximadamente)
INSERT INTO `location` (`id`, `name`, `address`, `guard`, `created_at`, `updated_at`) VALUES
	(1, 'SAGRADO', 'Cra 25 # 24-47', 'SI', NULL, NULL),
	(2, 'SALESIANO', 'Cra 26 # 34-40 B', 'NO', NULL, NULL),
	(3, 'BICENTENARIO', 'Cl 28 # 19-38', 'NO', NULL, NULL);

-- Volcando estructura para tabla persa_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.migrations: ~12 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(25, '2014_06_12_150527_create_roles_table', 1),
	(26, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(27, '2019_08_19_000000_create_failed_jobs_table', 1),
	(28, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(29, '2025_06_12_150528_create_users_table', 1),
	(30, '2025_06_12_152712_create_career_table', 1),
	(31, '2025_06_12_152718_create_course_table', 1),
	(32, '2025_06_12_152727_create_location_table', 1),
	(33, '2025_06_12_152732_create_permission_type_table', 1),
	(34, '2025_06_12_152738_create_apprentice_course_table', 1),
	(35, '2025_06_12_152749_create_instructor_course_table', 1),
	(36, '2025_06_26_125522_create_permission_table', 1);

-- Volcando estructura para tabla persa_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla persa_db.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_date` date NOT NULL COMMENT 'Fecha del permiso',
  `start_time` time NOT NULL COMMENT 'Hora de inicio',
  `end_time` time NOT NULL COMMENT 'Hora de fin',
  `departure_time` time DEFAULT NULL COMMENT 'Hora de salida',
  `reasons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Motivo del permiso',
  `instructor_id` bigint unsigned NOT NULL,
  `apprentice_id` bigint unsigned NOT NULL,
  `guard_id` bigint unsigned NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Estado',
  `location_id` bigint unsigned NOT NULL,
  `permission_type_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_instructor_id_foreign` (`instructor_id`),
  KEY `permission_apprentice_id_foreign` (`apprentice_id`),
  KEY `permission_guard_id_foreign` (`guard_id`),
  KEY `permission_location_id_foreign` (`location_id`),
  KEY `permission_permission_type_id_foreign` (`permission_type_id`),
  CONSTRAINT `permission_apprentice_id_foreign` FOREIGN KEY (`apprentice_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_guard_id_foreign` FOREIGN KEY (`guard_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_permission_type_id_foreign` FOREIGN KEY (`permission_type_id`) REFERENCES `permission_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.permission: ~9 rows (aproximadamente)
INSERT INTO `permission` (`id`, `permission_date`, `start_time`, `end_time`, `departure_time`, `reasons`, `instructor_id`, `apprentice_id`, `guard_id`, `status`, `location_id`, `permission_type_id`, `created_at`, `updated_at`) VALUES
	(1, '2023-10-01', '09:00:00', '10:00:00', '09:15:00', 'CITA MEDICA', 1, 1, 4, 'APROBADO', 1, 1, NULL, NULL),
	(2, '2023-10-02', '10:00:00', '12:00:00', '10:15:00', 'CALAMIDAD DOMESTICA', 2, 2, 5, 'PENDIENTE', 2, 4, NULL, NULL),
	(3, '2023-10-03', '11:00:00', '13:00:00', '11:15:00', 'ENTREVISTA ETAPA PRODUCTIVA', 3, 3, 4, 'APROBADO', 3, 1, NULL, NULL),
	(4, '2023-10-04', '12:00:00', '14:00:00', '12:15:00', 'OTRO', 4, 4, 5, 'DESAPROBADO', 2, 3, NULL, NULL),
	(5, '2023-10-05', '13:00:00', '14:30:00', '13:15:00', 'CITA MEDICA', 5, 5, 4, 'APROBADO', 1, 1, NULL, NULL),
	(6, '2025-10-16', '10:00:00', '12:00:00', '13:56:10', 'Examen Medico', 4, 9, 1, 'CANCELADO', 1, 1, '2025-10-16 18:52:36', '2025-10-16 18:57:04'),
	(8, '2025-10-16', '10:05:00', '15:05:00', '15:13:55', 'DEJEMEN SALIR', 5, 10, 1, 'APROBADO', 3, 3, '2025-10-16 20:06:04', '2025-10-16 20:13:55'),
	(10, '2025-10-16', '23:31:00', '11:31:00', '16:33:39', 'Tatiana Valentina', 4, 9, 1, 'APROBADO', 1, 2, '2025-10-16 21:31:29', '2025-10-16 21:33:39'),
	(11, '2025-10-16', '23:31:00', '23:31:00', '16:32:31', 'ccepeda', 4, 9, 14, 'APROBADO', 2, 1, '2025-10-16 21:31:45', '2025-10-16 21:32:31');

-- Volcando estructura para tabla persa_db.permission_type
CREATE TABLE IF NOT EXISTS `permission_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.permission_type: ~4 rows (aproximadamente)
INSERT INTO `permission_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'CITA MEDICA', NULL, NULL),
	(2, 'CALAMIDAD DOMESTICA', NULL, NULL),
	(3, 'ENTREVISTA ETAPA PRODUCTIVA', NULL, NULL),
	(4, 'OTRO', NULL, NULL);

-- Volcando estructura para tabla persa_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla persa_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.roles: ~4 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'COORDINADOR', NULL, NULL),
	(2, 'INSTRUCTOR', NULL, NULL),
	(3, 'APRENDIZ', NULL, NULL),
	(4, 'GUARDA', NULL, NULL);

-- Volcando estructura para tabla persa_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `document` bigint unsigned NOT NULL COMMENT 'cédula',
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre completo',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Correo electrónico',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contraseña',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Estado',
  `role_id` bigint unsigned NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_document_unique` (`document`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla persa_db.users: ~14 rows (aproximadamente)
INSERT INTO `users` (`id`, `document`, `fullname`, `email`, `password`, `status`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 55220224, 'Prof. Jaden Schuppe III', 'bradley.gibson@example.com', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 1, 'jQVQgzxhJt', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(2, 1825838869, 'Fay Leffler III', 'chelsie24@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 1, 'c5Dp5pfLZT', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(3, 484276427, 'Aurore Wisoky', 'whermann@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 2, 'PK362QQvsXvphBiPAMXBUEDzB2E9rS2G2eS9z4R87KIpk3QHAjrdV7EF57dv', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(4, 129102955, 'Flossie Smith', 'hermann.odie@example.net', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 2, 'xysnrGUDjV9qvXDjynlEFYyO7sYkPWRk5AIaLftoxu5QkRrSZTjX0XYnlUDT', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(5, 385273381, 'Vernie Zemlak', 'constance.pouros@example.net', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 2, 'PzYOcSwQ2N', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(6, 1752257630, 'Alexa Marquardt', 'hegmann.marlin@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 2, 'zpYCAHRYWL', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(7, 1555993767, 'Mrs. Mona Padberg DDS', 'mbernier@example.com', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 2, 'sdmzd94Cuk', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(8, 1124945910, 'Dr. Kyler Jacobs DDS', 'cbailey@example.net', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 3, 'qcGG5Fe0Uf', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(9, 1167552646, 'Zechariah Lind', 'bondricka@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 3, 'ImIL7T7YqEvRbNApX7BPTHL6rVwjNoCL1T8JQMPqMWDXHrdTnmaJuMj9Jg5n', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(10, 1040846466, 'Mr. Jean Vandervort Jr.', 'justina46@example.com', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 3, 'vHIDhCzamjEDElgtILGCo6wneNZ7mHGol9JijxAvjMYShwsE8lFqOcxjnLvh', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(11, 1577728579, 'Boris Barrows', 'enoch65@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 3, 'b6bnvD5yX4', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(12, 609810272, 'Helena Hahn', 'doris89@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 3, 'nV8FubLaR3', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(13, 330875886, 'Leonora Mayert', 'myles47@example.org', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'INACTIVO', 4, '4KefFUk0PF', '2025-10-16 18:38:48', '2025-10-16 18:38:48'),
	(14, 2009030491, 'Dr. Silas Green Sr.', 'doris.renner@example.com', '$2y$12$ZJXvl7h.x5GmcJAxrIbrvuyZphJi2ExNFC.eN0DmDJXeJIJu7nc9q', 'ACTIVO', 4, 'RIvvGrEGBL7KCCWqyDddI32M7yChlXeTx115DmoeUQLDck5s7XJetWIT6N8Z', '2025-10-16 18:38:48', '2025-10-16 18:38:48');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
