CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `codigo` varchar(10) DEFAULT NULL,
  `Direccion` varchar(75) NOT NULL DEFAULT '',
  `Ciudad` varchar(30) NOT NULL DEFAULT '',
  `Provincia` varchar(30) NOT NULL DEFAULT '',
  `Estado` varchar(10) NOT NULL DEFAULT '',
  `CP` varchar(5) NOT NULL DEFAULT '',
  `PersonaContacto` varchar(40) NOT NULL DEFAULT '',
  `Telefono` varchar(100) NOT NULL DEFAULT '',
  `Movil` varchar(20) NOT NULL DEFAULT '',
  `Fax` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `URL` varchar(100) NOT NULL DEFAULT '',
  `Comentarios` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
