DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `men_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `men_nome` varchar(50),
  `men_nivel` int(15), 
  `men_posicao` int(15),
  `men_menpai` bigint(20) not null,
  `men_evento` bigint(20) not null,
  `men_sistema` varchar(50),
  PRIMARY KEY (`men_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menus` WRITE;

UNLOCK TABLES;

DROP TABLE IF EXISTS `permissoes`;

CREATE TABLE `permissoes` (
  `men_id` bigint(20) NOT NULL,
  `par_id` bigint(20) NOT NULL,
  PRIMARY KEY (`men_id`), KEY `permissao_usuario` (`par_id`),
  CONSTRAINT `permissao_menus` FOREIGN KEY (`men_id`) REFERENCES `menus` (`men_id`),
  CONSTRAINT `permissao_usuario` FOREIGN KEY (`par_id`) REFERENCES `usuarios` (`par_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permissoes` WRITE;

UNLOCK TABLES;