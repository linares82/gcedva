-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando datos para la tabla crmscool_jesadi.estados: ~33 rows (aproximadamente)
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id`, `name`, `usu_alta_id`, `usu_mod_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(0, 'Seleccionar opción', 1, 1, NULL, NULL, NULL),
	(1, 'Aguascalientes', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(2, 'Baja California', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(3, 'Baja California Sur', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(4, 'Campeche', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(5, 'Coahuila de Zaragoza', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(6, 'Colima', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(7, 'Chiapas', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(8, 'Chihuahua', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(9, 'Ciudad de México', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(10, 'Durango', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(11, 'Guanajuato', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(12, 'Guerrero', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(13, 'Hidalgo', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(14, 'Jalisco', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(15, 'México', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(16, 'Michoacán de Ocampo', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(17, 'Morelos', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(18, 'Nayarit', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(19, 'Nuevo León', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(20, 'Oaxaca', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(21, 'Puebla', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(22, 'Querétaro', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(23, 'Quintana Roo', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(24, 'San Luis Potosí', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(25, 'Sinaloa', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(26, 'Sonora', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(27, 'Tabasco', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(28, 'Tamaulipas', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(29, 'Tlaxcala', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(30, 'Veracruz de Ignacio de la Llave', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(31, 'Yucatán', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(32, 'Zacatecas', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
