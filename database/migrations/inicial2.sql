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

-- Volcando datos para la tabla crmscool_jesadi.paises: ~34 rows (aproximadamente)
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `marcado`) VALUES
	(0, 'Selecciona Opción', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(1, 'Argentina', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+54'),
	(2, 'Bahamas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(3, 'Barbados', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(4, 'Belice', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(5, 'Bolivia', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(6, 'Brasil', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+55'),
	(7, 'Canada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(8, 'Chile', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+56'),
	(9, 'Colombia', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+57'),
	(10, 'Costa Rica', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(11, 'Cuba', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(12, 'Dominica', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(13, 'Ecuador', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+593'),
	(14, 'El Salvador', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(15, 'Estados Unidos', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(16, 'Granada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(17, 'Guatemala', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(18, 'Guyana', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(19, 'Haiti', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(20, 'Honduras', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(21, 'Jamaica', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(22, 'México', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+52'),
	(23, 'Nicaragua', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(24, 'Panamá', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(25, 'Paraguay', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(26, 'Perú', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '+51'),
	(27, 'República Dominicana', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(28, 'San Cristóbal y Nieves', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(29, 'Santa Lucía', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(30, 'Surinam', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(31, 'Trinidad y Tobago', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(32, 'Uruguay', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, ''),
	(33, 'Venezuela', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Volcando datos para la tabla crmscool_jesadi.params: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `params` DISABLE KEYS */;
INSERT INTO `params` (`id`, `llave`, `valor`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'correo_electronico', 'activo', NULL, NULL, NULL),
	(2, 'sms', 'activo', NULL, NULL, NULL),
	(3, 'msj_text', '¡Felicidades por dar el primer paso hacia tu futuro!, gracias por escoger a Grupo Educativo Jesadi.\r\nPara dudas y aclaraciones comunícate al 55 8482 0027 y con gusto te atenderemos.\r\nGrupo Educativo Jesadi, “Hacemos de tu pasión, una profesión”', NULL, NULL, NULL),
	(4, 'calificacion_aprobatoria', '7', NULL, NULL, NULL),
	(5, 'st_cliente_final', '4', NULL, NULL, NULL),
	(6, 'st_seguimiento_final', '2', NULL, NULL, NULL),
	(7, 'num_twilio', '+13093196909', NULL, NULL, NULL),
	(8, 'token_app_cel', '52dc8ASmda1523.-2*', NULL, NULL, NULL),
	(9, 'iva', '0.16', NULL, NULL, NULL);
/*!40000 ALTER TABLE `params` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
