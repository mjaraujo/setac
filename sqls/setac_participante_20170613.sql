--
-- Current Database: `setac`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `setac` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `setac`;

-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: setac
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cidades`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cidades` (
  `cid_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cid_nome` varchar(30) NOT NULL,
  `cid_cep_unico` char(1) NOT NULL DEFAULT 'N',
  `cid_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_id` varchar(2) NOT NULL,
  PRIMARY KEY (`cid_id`),
  KEY `fk_estados_em_cidades` (`est_id`),
  CONSTRAINT `fk_estados_em_cidades` FOREIGN KEY (`est_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enderecos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enderecos` (
  `end_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `end_complemento` varchar(50) DEFAULT NULL,
  `end_numero` varchar(5) NOT NULL DEFAULT 's/n',
  `log_id` bigint(20) NOT NULL,
  `par_id` bigint(20) NOT NULL,
  PRIMARY KEY (`end_id`),
  KEY `fk_logradouros_em_enderecos` (`log_id`),
  KEY `fk_clientes_em_enderecos` (`par_id`),
  CONSTRAINT `fk_logradouros_em_enderecos` FOREIGN KEY (`log_id`) REFERENCES `logradouros` (`log_id`),
  CONSTRAINT `fk_participantes_em_enderecos` FOREIGN KEY (`par_id`) REFERENCES `participantes` (`par_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados` (
  `est_id` varchar(2) NOT NULL,
  `est_nome` varchar(30) NOT NULL,
  `est_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`est_id`),
  UNIQUE KEY `est_id` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logradouros`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logradouros` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_cep` varchar(9) NOT NULL,
  `log_nome` varchar(100) NOT NULL,
  `log_tipo` varchar(30) NOT NULL,
  `log_bairro` varchar(30) NOT NULL,
  `log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid_id` bigint(20) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `fk_cidades_em_logradouros` (`cid_id`),
  CONSTRAINT `fk_cidades_em_logradouros` FOREIGN KEY (`cid_id`) REFERENCES `cidades` (`cid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participantes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participantes` (
  `par_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `par_nome` varchar(100) NOT NULL,
  `par_doctipo` varchar(5) NOT NULL,
  `par_docnumero` varchar(14) NOT NULL,
  `par_email` varchar(30) NOT NULL,
  `par_instituicao` varchar(30) NOT NULL DEFAULT 'profissional',
  `par_foto` blob,
  `par_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`par_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usu_nome` varchar(30) NOT NULL,
  `usu_senha` varchar(255) NOT NULL,
  `usu_status` char(1) NOT NULL DEFAULT 'I',
  `par_id` bigint(20) NOT NULL,
  PRIMARY KEY (`par_id`),
  CONSTRAINT `fk_participantes_em_usuarios` FOREIGN KEY (`par_id`) REFERENCES `participantes` (`par_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-13  7:50:56
