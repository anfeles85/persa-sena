-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.40 - MySQL Community Server - GPL
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


-- Volcando estructura de base de datos para bdpersa
CREATE DATABASE IF NOT EXISTS `bdpersa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bdpersa`;

-- Volcando estructura para tabla bdpersa.apprentice_course
CREATE TABLE IF NOT EXISTS `apprentice_course` (
  `user_id` bigint NOT NULL,
  `course_id` bigint NOT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `FK_apprentice_course_course` (`course_id`),
  CONSTRAINT `FK_apprentice_course_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_apprentice_course_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.apprentice_course: ~5 rows (aproximadamente)
INSERT INTO `apprentice_course` (`user_id`, `course_id`) VALUES
	(3, 1),
	(4, 2),
	(5, 3),
	(1, 4),
	(2, 5);

-- Volcando estructura para tabla bdpersa.career
CREATE TABLE IF NOT EXISTS `career` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.career: ~5 rows (aproximadamente)
INSERT INTO `career` (`id`, `name`, `type`) VALUES
	(1, 'SST', 'TECNICO'),
	(2, 'ADSO', 'TECNOLOGO'),
	(3, 'Gestion Documental', 'TECNICO'),
	(4, 'Enfermeria', 'TECNOLOGO'),
	(5, 'Deportes', 'TECNICO');

-- Volcando estructura para tabla bdpersa.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `shift` varchar(50) NOT NULL,
  `trimester` varchar(50) NOT NULL,
  `year` int NOT NULL,
  `status` varchar(50) NOT NULL,
  `career_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_course_career` (`career_id`),
  CONSTRAINT `FK_course_career` FOREIGN KEY (`career_id`) REFERENCES `career` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.course: ~5 rows (aproximadamente)
INSERT INTO `course` (`id`, `shift`, `trimester`, `year`, `status`, `career_id`) VALUES
	(1, 'DIURNA', 'T1', 2023, 'ACTIVO', 1),
	(2, 'NOCTURNA', 'T2', 2023, 'ACTIVO', 2),
	(3, 'MIXTA', 'T3', 2023, 'INACTIVO', 1),
	(4, 'DIURNA', 'T1', 2024, 'ACTIVO', 3),
	(5, 'NOCTURNA', 'T2', 2024, 'ACTIVO', 2);

-- Volcando estructura para tabla bdpersa.instructor_course
CREATE TABLE IF NOT EXISTS `instructor_course` (
  `instructor_id` bigint NOT NULL,
  `course_id` bigint NOT NULL,
  PRIMARY KEY (`course_id`,`instructor_id`),
  KEY `FK_instructor_course_users` (`instructor_id`),
  CONSTRAINT `FK_instructor_course_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_instructor_course_users` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.instructor_course: ~5 rows (aproximadamente)
INSERT INTO `instructor_course` (`instructor_id`, `course_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5);

-- Volcando estructura para tabla bdpersa.location
CREATE TABLE IF NOT EXISTS `location` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.location: ~4 rows (aproximadamente)
INSERT INTO `location` (`id`, `name`, `address`) VALUES
	(1, 'SAGRADO', ''),
	(2, 'SALESIANO', ''),
	(3, 'BICENTENARIO', ''),
	(4, 'SENA CLEM', '');

-- Volcando estructura para tabla bdpersa.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `permission_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `departure_time` time DEFAULT NULL,
  `reasons` varchar(60) NOT NULL,
  `instructor_id` bigint NOT NULL,
  `guard_id` bigint NOT NULL,
  `status` varchar(50) NOT NULL,
  `location_id` bigint NOT NULL,
  `permission_type_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_permission_users_guard` (`guard_id`),
  KEY `FK_permission_Location` (`location_id`),
  KEY `FK_permission_Permission_Type` (`permission_type_id`),
  KEY `FK_permission_users` (`instructor_id`),
  CONSTRAINT `FK_permission_Location` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_permission_Permission_Type` FOREIGN KEY (`permission_type_id`) REFERENCES `permission_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_permission_users` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_permission_users_guard` FOREIGN KEY (`guard_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.permission: ~5 rows (aproximadamente)
INSERT INTO `permission` (`id`, `permission_date`, `start_time`, `end_time`, `departure_time`, `reasons`, `instructor_id`, `guard_id`, `status`, `location_id`, `permission_type_id`) VALUES
	(1, '2023-10-01', '09:00:00', '10:00:00', '09:15:00', 'CITA MEDICA', 1, 4, 'APROBADO', 1, 1),
	(2, '2023-10-02', '10:00:00', '12:00:00', '10:15:00', 'CALAMIDAD DOMESTICA', 2, 5, 'PENDIENTE', 2, 4),
	(3, '2023-10-03', '11:00:00', '13:00:00', '11:15:00', 'ENTREVISTA ETAPA PRODUCTIVA', 3, 4, 'APROBADO', 3, 1),
	(4, '2023-10-04', '12:00:00', '14:00:00', '12:15:00', 'OTRO', 4, 5, 'DESAPROBADO', 4, 3),
	(5, '2023-10-05', '13:00:00', '14:30:00', '13:15:00', 'CITA MEDICA', 5, 4, 'APROBADO', 1, 1);

-- Volcando estructura para tabla bdpersa.permission_type
CREATE TABLE IF NOT EXISTS `permission_type` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.permission_type: ~4 rows (aproximadamente)
INSERT INTO `permission_type` (`id`, `name`) VALUES
	(1, 'CITA MEDICA'),
	(2, 'CALAMIDAD DOMESTICA'),
	(3, 'ENTREVISTA ETAPA PRODUCTIVA'),
	(4, 'OTRO');

-- Volcando estructura para tabla bdpersa.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.roles: ~4 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`) VALUES
	(1, 'COORDINADOR'),
	(2, 'INSTRUCTOR'),
	(3, 'APRENDIZ'),
	(4, 'GUARDIA');

-- Volcando estructura para tabla bdpersa.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `role_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_roles` (`role_id`),
  CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bdpersa.users: ~5 rows (aproximadamente)
INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `status`, `role_id`) VALUES
	(1, 'Juan Perez', 'juan@email.com', 'pass123', 'ACTIVO', 1),
	(2, 'Ana Gomez', 'anita@email.com', 'pass456', 'ACTIVO', 2),
	(3, 'Carlos Ruiz', 'carlos@email.com', 'pass789', 'INACTIVO', 1),
	(4, 'Maria Lopez', 'maria@email.com', 'pass012', 'ACTIVO', 3),
	(5, 'Luis Martinez', 'luis@email.com', 'pass345', 'ACTIVO', 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
