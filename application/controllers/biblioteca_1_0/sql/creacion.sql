CREATE TABLE IF NOT EXISTS `bib_biblioteca` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL DEFAULT '',
  `autor` varchar(50) DEFAULT NULL,
  `leido` bool NOT NULL DEFAULT 'FALSE'
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
