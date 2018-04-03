CREATE TABLE `bib_biblioteca` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL DEFAULT '',
  `autor` varchar(50) DEFAULT '',
  `posicion` char(3) DEFAULT '',
  `leido` bool NOT NULL DEFAULT FALSE,
  `origen` char(3) DEFAULT '',
  PRIMARY KEY (`id` ASC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;