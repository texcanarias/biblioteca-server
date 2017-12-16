CREATE TABLE IF NOT EXISTS `ftn_reg_tipo_usuario` (
  `Id` int(11)  unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único',
  `Nombre` varchar(50) DEFAULT "" COMMENT 'Nombre del usuario',
  `Descripcion` varchar(255) DEFAULT "" COMMENT 'Descripción corta del tipo de usuario',
  `IdActivo` BOOL DEFAULT true COMMENT 'Indica si este usuario está disponibles para la aplicacion',
  `IdSistema` BOOL DEFAULT false COMMENT 'Si es un usuario de sistema no debe ser borrado.',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tipo de usuarios presentes en el sistema, al menos debe existir un tipo que es el admin y que ocupa el primer puesto en la tabla, no puede ser eliminado.' ;

INSERT INTO ftn_reg_tipo_usuario VALUES("1","root","Super usuario del sistema","1","1");
INSERT INTO ftn_reg_tipo_usuario VALUES("2","admin","Administrador","1","1");
INSERT INTO ftn_reg_tipo_usuario VALUES("3","editor","Editor","1","1");
INSERT INTO ftn_reg_tipo_usuario VALUES("4","auditor","Auditor","1","1");

CREATE TABLE IF NOT EXISTS `ftn_reg_usuario` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único',
  `Usuario` varchar(50) NOT NULL COMMENT 'Nombre de usario',
  `Pass` varchar(50) DEFAULT NULL COMMENT 'Password del usuario',
  `Nombre` varchar(50) DEFAULT NULL COMMENT 'Nombre real del usuario',
  `Apellidos` varchar(70) DEFAULT NULL COMMENT 'Apellidos del usuario',
  `FechaCreacion` datetime DEFAULT NULL COMMENT 'Fecha en la que se dio de alta el usuario en el sistema.',
  `FechaUltimoAcceso` datetime DEFAULT NULL COMMENT 'Fecha en la que se le permitió el acceso por última vez.',
  `FechaAceptacionLOPD` datetime DEFAULT NULL COMMENT 'Fecha en la que se acepto terminos de la LOPD.',
  `EMail` varchar(255) NOT NULL,
  `ImagenPerfil` varchar(255) DEFAULT NULL COMMENT 'Ruta donde está la imagen del perfil.',
  `ftn_reg_tipo_usuario_Id` int(11) unsigned NOT NULL COMMENT 'Tipo de usuario.',
  `IdActivo` BOOL DEFAULT 1 COMMENT 'Si la cuenta está activa (1) o no lo está (0)',
  `IntentosLogin` TINYINT DEFAULT 0 COMMENT 'Cuenta las veces que el usuario intenta entrar en el sistema si llega a 5 la cuenta se bloquea. Si se entra bien una vez este contador se pone a 0.',
  `IdIdioma` CHAR(2) COMMENT 'Idioma a mostrar en el administrador.',
  `ApiKey` char(40),
  PRIMARY KEY (`Id`),
  KEY `FK_usuarios_tipo_usuario` (`ftn_reg_tipo_usuario_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Control de usuarios.'  ;
CREATE INDEX IDX_Usuario ON `ftn_reg_usuario` (`Nombre`);
CREATE INDEX IDX_EMail ON `ftn_reg_usuario` (`EMail`);
CREATE INDEX IDX_ApiKey ON `ftn_reg_usuario` (`ApiKey`);

ALTER TABLE `ftn_reg_usuario` ADD CONSTRAINT `FK_usuarios_tipo_usuario`
 FOREIGN KEY (`ftn_reg_tipo_usuario_Id`) REFERENCES `ftn_reg_tipo_usuario` (`Id`) ON UPDATE CASCADE;

DELIMITER $$
CREATE TRIGGER ftn_reg_usuario_OnInsert BEFORE INSERT ON ftn_reg_usuario
    FOR EACH ROW BEGIN
        SET NEW.ApiKey = md5(NEW.Usuario);
        SET NEW.FechaCreacion = NOW();
    END $$
DELIMITER ;
      

INSERT INTO `ftn_reg_usuario` (`Id`, `Usuario`, `Pass`, `Nombre`, `Apellidos`, `FechaCreacion`, `FechaUltimoAcceso`, `EMail`, `ftn_reg_tipo_usuario_Id`,`IdIdioma`) VALUES
(1, 'adclick', '678aa562c5d6f5b03c1511077ed28de1', 'adclick', '', NOW(), NOW(), 'sistemas@adclick.es', 1, 'es'),
(2, 'admin', '9ae033a9e407ab815fd204566c2cf7af', 'admin', '', NOW(), NOW(), 'sistemas@adclick.es', 2, 'es');