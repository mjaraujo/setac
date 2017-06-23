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

    DROP TABLE IF EXISTS `permissoes` ;

    create table `permissoes` (
      `men_id` BIGINT(20) NOT NULL COMMENT '',
      `par_id` BIGINT(20) NOT NULL COMMENT '',
      INDEX `permissao_usuario` (`par_id` ASC)  COMMENT '',
      INDEX `fk_men_id_idx` (`men_id` ASC)  COMMENT '',
      CONSTRAINT `fk_men_id`
        FOREIGN KEY (`men_id`)
        REFERENCES `menus` (`men_id`),
      CONSTRAINT `fk_par_id`
        FOREIGN KEY (`par_id`)
        REFERENCES `usuarios` (`par_id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8