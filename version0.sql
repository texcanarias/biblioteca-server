-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ftn_reg_tipo_usuario`
--

DROP TABLE IF EXISTS `ftn_reg_tipo_usuario`;
CREATE TABLE IF NOT EXISTS `ftn_reg_tipo_usuario` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único',
  `Nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'Nombre del usuario',
  `Descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'Descripción corta del tipo de usuario',
  `IdActivo` tinyint(1) DEFAULT '1' COMMENT 'Indica si este usuario está disponibles para la aplicacion',
  `IdSistema` tinyint(1) DEFAULT '0' COMMENT 'Si es un usuario de sistema no debe ser borrado.',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tipo de usuarios presentes en el sistema, al menos debe existir un tipo que es el admin y que ocupa el primer puesto en la tabla, no puede ser eliminado.' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ftn_reg_tipo_usuario`
--

INSERT INTO `ftn_reg_tipo_usuario` (`Id`, `Nombre`, `Descripcion`, `IdActivo`, `IdSistema`) VALUES
(1, 'root', 'Super usuario del sistema', 1, 1),
(2, 'admin', 'Administrador', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ftn_reg_usuario`
--

DROP TABLE IF EXISTS `ftn_reg_usuario`;
CREATE TABLE IF NOT EXISTS `ftn_reg_usuario` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único',
  `Usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de usario',
  `Pass` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Password del usuario',
  `Nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre real del usuario',
  `Apellidos` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Apellidos del usuario',
  `FechaCreacion` datetime DEFAULT NULL COMMENT 'Fecha en la que se dio de alta el usuario en el sistema.',
  `FechaUltimoAcceso` datetime DEFAULT NULL COMMENT 'Fecha en la que se le permitió el acceso por última vez.',
  `FechaAceptacionLOPD` datetime DEFAULT NULL COMMENT 'Fecha en la que se acepto terminos de la LOPD.',
  `EMail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ImagenPerfil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Ruta donde está la imagen del perfil.',
  `ftn_reg_tipo_usuario_Id` int(11) unsigned NOT NULL COMMENT 'Tipo de usuario.',
  `IdActivo` tinyint(1) DEFAULT '1' COMMENT 'Si la cuenta está activa (1) o no lo está (0)',
  `IntentosLogin` tinyint(4) DEFAULT '0' COMMENT 'Cuenta las veces que el usuario intenta entrar en el sistema si llega a 5 la cuenta se bloquea. Si se entra bien una vez este contador se pone a 0.',
  `IdIdioma` char(2) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Idioma a mostrar en el administrador.',
  `ApiKey` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_usuarios_tipo_usuario` (`ftn_reg_tipo_usuario_Id`),
  KEY `IDX_Usuario` (`Nombre`),
  KEY `IDX_EMail` (`EMail`),
  KEY `IDX_ApiKey` (`ApiKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Control de usuarios.' AUTO_INCREMENT=142 ;

--
-- Volcado de datos para la tabla `ftn_reg_usuario`
--

INSERT INTO `ftn_reg_usuario` (`Id`, `Usuario`, `Pass`, `Nombre`, `Apellidos`, `FechaCreacion`, `FechaUltimoAcceso`, `FechaAceptacionLOPD`, `EMail`, `ImagenPerfil`, `ftn_reg_tipo_usuario_Id`, `IdActivo`, `IntentosLogin`, `IdIdioma`, `ApiKey`) VALUES
(1, 'adclick', '267cf9dedc9ab615965f27b18b82da66', 'adclick', '', '2017-05-18 12:56:57', '2017-05-18 12:56:57', NULL, 'sistemas@adclick.es', NULL, 1, 1, 1, 'es', '267cf9dedc9ab615965f27b18b82da66'),
(2, 'admin', '267cf9dedc9ab615965f27b18b82da66', 'administrador general NEW', '', '2017-05-18 12:56:57', '2017-05-18 12:56:57', NULL, 'antonio.tex@gmail.com', NULL, 2, 1, 1, 'es', '9eb4e4137035b974f7bb7d0cd4a7fdc9');


-- Filtros para la tabla `ftn_reg_usuario`
--
ALTER TABLE `ftn_reg_usuario`
  ADD CONSTRAINT `FK_usuario_tipo_usuario` FOREIGN KEY (`ftn_reg_tipo_usuario_Id`) REFERENCES `ftn_reg_tipo_usuario` (`Id`) ON UPDATE CASCADE;
