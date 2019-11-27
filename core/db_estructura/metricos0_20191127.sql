-- MySQL dump 10.16  Distrib 10.1.28-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: metricos0
-- ------------------------------------------------------
-- Server version	10.1.28-MariaDB

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
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descorta` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `areadescorta` (`descorta`),
  UNIQUE KEY `areadescripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `indicadores`
--

DROP TABLE IF EXISTS `indicadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicadores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `indicador` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `usuarios` varchar(300) NOT NULL DEFAULT '',
  `digfraccion` int(11) NOT NULL DEFAULT '0',
  `unidades_id` int(10) unsigned NOT NULL,
  `areas_id` int(10) unsigned NOT NULL,
  `graficar` varchar(50) NOT NULL DEFAULT 'Ultimo valor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `indicador` (`indicador`),
  KEY `indicadores_ibfk_1` (`unidades_id`),
  KEY `areas_ibfk_1` (`areas_id`),
  CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`areas_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`unidades_id`) REFERENCES `unidades` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `marco_det`
--

DROP TABLE IF EXISTS `marco_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marco_det` (
  `ren` int(10) unsigned NOT NULL DEFAULT '1',
  `marco_enc_id` int(10) unsigned NOT NULL,
  `ind1` int(11) NOT NULL DEFAULT '0',
  `ind2` int(11) NOT NULL DEFAULT '0',
  `ind3` int(11) NOT NULL DEFAULT '0',
  `ind4` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`marco_enc_id`,`ren`),
  CONSTRAINT `marco_det_ibfk_1` FOREIGN KEY (`marco_enc_id`) REFERENCES `marco_enc` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `marco_enc`
--

DROP TABLE IF EXISTS `marco_enc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marco_enc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comentario` varchar(100) NOT NULL,
  `tablero` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regind_det`
--

DROP TABLE IF EXISTS `regind_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regind_det` (
  `ren` int(10) unsigned NOT NULL DEFAULT '1',
  `regind_enc_id` int(10) unsigned NOT NULL,
  `mes` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `meta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `minimo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `excelente` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` varchar(100) NOT NULL,
  PRIMARY KEY (`regind_enc_id`,`ren`),
  UNIQUE KEY `indmes` (`regind_enc_id`,`mes`),
  CONSTRAINT `regind_det_ibfk_1` FOREIGN KEY (`regind_enc_id`) REFERENCES `regind_enc` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regind_enc`
--

DROP TABLE IF EXISTS `regind_enc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regind_enc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `indicadores_id` int(10) unsigned NOT NULL,
  `anio` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `indanio` (`indicadores_id`,`anio`),
  CONSTRAINT `regind_enc_ibfk_1` FOREIGN KEY (`indicadores_id`) REFERENCES `indicadores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descorta` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unidescorta` (`descorta`),
  UNIQUE KEY `unidescripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-27 12:25:24
