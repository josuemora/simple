-- MySQL dump 10.16  Distrib 10.1.28-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: simple_almacen
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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `paterno` varchar(100) NOT NULL,
  `materno` varchar(100) NOT NULL,
  `grupos_id` int(10) unsigned NOT NULL,
  `sexo` char(1) NOT NULL DEFAULT 'm',
  `usalentes` char(1) NOT NULL DEFAULT 'n',
  `enfermedad` char(1) NOT NULL DEFAULT 'n',
  `capacidaddiferente` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `nombre` (`nombre`),
  KEY `paterno` (`paterno`),
  KEY `materno` (`materno`),
  KEY `grupos_id` (`grupos_id`),
  CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`grupos_id`) REFERENCES `grupos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (6,'pedroa','7','juan',12,'m','n','s','s'),(7,'juan','perez','solis sdds',6,'m','s','n','s'),(8,'josue','94','sdf',14,'f','s','s','s'),(9,'mario','perez','rubio',11,'m','s','n','n'),(10,'rafael','gonzalez','nuñez',1,'m','n','n','n'),(11,'jksdhfaskjf','jkshdf','jkfsdh',6,'f','n','s','n'),(12,'asdfas','asdfasdf','asdsf',11,'m','s','s','s'),(13,'askfkfkqqqqq','94','sdf',11,'m','n','n','n'),(14,'sdjkfhsa','kehfhsd','uiusief',7,'m','n','n','n'),(15,'skljfaf','lkjsfl','lkjsdfal',5,'m','n','n','n'),(16,'jkjkaskjdfh','kjhsakjfh','kjhafs',1,'m','n','n','n'),(17,'dfasdfasf','asdfasdf','asdfadsf',5,'f','n','n','n'),(18,'fsgasg','ADFASD','DGASDFDS',1,'m','n','n','n'),(19,'DSFD','SFF','SDFDS',5,'m','n','n','n'),(20,'nuevo','registro','registro',4,'m','n','n','n'),(21,'qqqqqqqqqqqqq','qqqq','qqqq',4,'m','n','n','n'),(22,'qqqqqqqqwwwwwww adsjfasdfads kaskfkasdfa  asdfas','wwwwww','xxxxxxxxxxxa',4,'m','n','n','n'),(27,'uno','uno','uno',5,'f','n','n','s'),(28,'dos','dos','dos',4,'m','n','n','n'),(29,'tres','tres','tres',4,'m','n','n','n'),(30,'dczac','kljsdasdf','sdñfklsadf',6,'m','n','n','n'),(31,'sdfsadf','sdfadfasdfdasdf','safadsf',6,'m','s','n','n'),(34,'asdfsadf','sadf','adfd',1,'m','n','n','n'),(35,'kjakds','askjasdfk','wwwwwwlkasd',4,'m','n','n','n'),(36,'sdhf','asdjf','asdfj',11,'m','n','n','n'),(37,'asdf','adsf','sdfjjsdf',5,'f','s','s','s'),(38,'asdfsd','asdfs','sadfasdf',4,'m','n','n','n'),(39,'sadfadsfn','sdfafasd','asdf',5,'m','n','n','n'),(40,'sadfjasfafa sfsgf','llloro','as,d,f,dfg',5,'f','s','s','n'),(41,'','','',4,'m','n','n','n'),(42,'','','',4,'m','n','n','n'),(43,'asdfasdf','asdfasd','asdfas',4,'m','n','n','n'),(44,'sadfasdf','asdfasd','asdfasdf',4,'m','n','n','n'),(48,'dfasdf','sdfdas','dsf',5,'m','n','n','n'),(49,'sfasdf','sdfaf','asdfaf',5,'m','n','n','n'),(50,'sadfda','sadsaf','asdf',1,'m','n','n','n'),(51,'','','',4,'m','n','n','n'),(52,'asffasf','asfasf','asdfasf',5,'m','n','n','n'),(53,'','','',1,'m','n','n','n'),(54,'sfasf','dfasdf','asdfas',1,'m','n','n','n'),(55,'sdfasdf','sadff','asfadsf',1,'m','n','n','n'),(56,'asfa','dfsfdsf','asdfasdf',7,'m','n','n','n'),(57,'sdfasdf','adsf','sadf',1,'m','n','n','n'),(59,'','','',7,'m','n','n','n'),(60,'','','',5,'m','n','n','n'),(61,'','','',5,'m','n','n','n'),(62,'','','',5,'m','n','n','n'),(63,'dasfas','asdfas','asf',7,'m','n','n','n'),(64,'sdfas','asdf','asdf',6,'f','n','n','n'),(65,'asdhfj','asdfjk','adsfl',4,'m','n','n','n'),(66,'sdfa','asdfj','asdfjas',4,'m','n','n','n'),(67,'asdfd','asdf','asdf',1,'m','n','n','n'),(68,'asdf','sadf','asdf',1,'f','n','n','n'),(69,'dsfasf','asdf','asdfd',5,'m','n','n','n'),(70,'dsafas','sadfasdf','sadf',5,'f','n','n','n'),(71,'safdff','asdf','fgklll',5,'m','s','s','n'),(72,'qqqq','ooo','ppp',1,'m','n','n','n'),(73,'kfadsk','dslfl','asddfs',5,'m','n','n','n'),(75,'sdfasdf','asdfasdf','asdfdas',1,'m','n','n','n'),(76,'sadfdasdf','asdfasdfasdfasdfasdfas','asdfsasdfasf',5,'f','n','s','n'),(79,'pedro','morales','treviño',5,'m','s','s','s'),(80,'','','',1,'m','n','n','n'),(81,'','','',1,'m','n','n','n'),(82,'adsfas','fasdf','sadsf',10,'m','s','s','s'),(83,'adsfas','fasdf','sadsf',7,'m','s','s','s'),(84,'dsfjasf','asdfñlasdf','asdfñlasdf',11,'m','s','s','n'),(85,'q','q','q',1,'m','s','s','s'),(86,'w','w','w',11,'m','n','n','s'),(87,'w','w','w',8,'m','s','n','n'),(88,'','','',10,'m','n','n','n'),(89,'','','',6,'m','n','n','n'),(90,'sdfasd','ads','f',1,'m','n','n','n'),(91,'','','',1,'m','s','n','n'),(92,'','','',1,'m','n','n','n'),(93,'','','',11,'m','n','n','n'),(94,'sdf','asdf','asdf',11,'m','n','n','s'),(95,'asdf','df','sdafs',6,'m','s','s','s'),(96,'a','a','a',11,'m','s','n','n'),(97,'b','b','b',5,'f','s','n','n'),(98,'cc','c','c',5,'m','s','n','n'),(99,'d','d','d',5,'f','s','n','n'),(100,'e','e','e',5,'m','n','s','n'),(101,'f','f','f',7,'m','n','n','n'),(102,'g','g','g',7,'f','n','n','n'),(103,'h','h','h',7,'m','s','n','n'),(104,'i','i','i',7,'m','s','n','n'),(105,'j','j','j',7,'m','s','s','s'),(106,'k','k','k',1,'m','s','s','s'),(107,'l','l','ñ',1,'m','n','n','n'),(108,'z','z','z',11,'m','n','n','s'),(112,'plantillas','unox','1',1,'m','s','s','n'),(113,'con','plantilla','nueva',1,'m','s','s','s'),(114,'','','',8,'m','s','s','s'),(115,'','','',14,'m','n','n','n');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clasificaciones`
--

DROP TABLE IF EXISTS `clasificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clasificaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clasificacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clasfifica` (`clasificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clasificaciones`
--

LOCK TABLES `clasificaciones` WRITE;
/*!40000 ALTER TABLE `clasificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `clasificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grado` int(11) NOT NULL,
  `salon` varchar(10) NOT NULL,
  `turno` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grado_salon_turno` (`grado`,`salon`,`turno`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (7,1,'2','Vespertino'),(4,1,'B','Matutino'),(16,1,'sdf','Matutino'),(6,1,'ww','Vespertino'),(1,2,'A','Matutino'),(13,2,'xc','Nocturno'),(15,3,'dsd','Vespertino'),(14,3,'sfg','Vespertino'),(5,4,'Z','Vespertino'),(8,7,'mejor','Nocturno'),(12,8,'nuevo1','Nocturno'),(10,9,'nuevoW','Vespertino'),(11,10,'computo','Nocturno');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `clave` varchar(50) NOT NULL DEFAULT '',
  `botones` varchar(1000) NOT NULL DEFAULT '',
  `tema` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (8,'Administrador','c4ca4238a0b923820dcc509a6f75849b','alumnos-acceso,grupos-acceso,alumnos-agregar,alumnos-cambiar,alumnos-eliminar,grupos-agregar,grupos-cambiar,grupos-eliminar','basico'),(9,'josue','c81e728d9d4c2f636f067f89cc14862c','alumnos-acceso,alumnos-agregar,alumnos-cambiar,grupos-acceso,grupos-agregar,grupos-cambiar','sunny'),(10,'pedro','b6d767d2f8ed5d21a44b0e5886680cb9','alumnos-acceso,grupos-acceso,alumnos-agregar,alumnos-cambiar,alumnos-eliminar,grupos-agregar,grupos-cambiar,grupos-eliminar',''),(11,'mario','6512bd43d9caa6e02c990b0a82652dca','alumnos-acceso,grupos-acceso,alumnos-cambiar,alumnos-eliminar,alumnos-agregar,grupos-cambiar,grupos-eliminar,grupos-agregar','sunny');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-18 16:36:12
