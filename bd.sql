-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_glovo
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_cocinas`
--

DROP TABLE IF EXISTS `tbl_cocinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_cocinas` (
  `id_cocina` int NOT NULL AUTO_INCREMENT,
  `cocina_nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_cocina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cocinas`
--

LOCK TABLES `tbl_cocinas` WRITE;
/*!40000 ALTER TABLE `tbl_cocinas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cocinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_platos`
--

DROP TABLE IF EXISTS `tbl_platos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_platos` (
  `id_plato` int NOT NULL AUTO_INCREMENT,
  `plato_precio` int DEFAULT NULL,
  `plato_descripcion` varchar(45) DEFAULT NULL,
  `id_restaurante` int NOT NULL,
  PRIMARY KEY (`id_plato`),
  KEY `fk_tbl_platos_tbl_restaurante1_idx` (`id_restaurante`),
  CONSTRAINT `fk_tbl_platos_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_platos`
--

LOCK TABLES `tbl_platos` WRITE;
/*!40000 ALTER TABLE `tbl_platos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_platos` ENABLE KaEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_restaurante`
--

DROP TABLE IF EXISTS `tbl_restaurante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_restaurante` (
  `id_restaurante` int NOT NULL AUTO_INCREMENT,
  `rest_nom` varchar(45) DEFAULT NULL,
  `rest_desc` varchar(45) DEFAULT NULL,
  `id_usr_gerente` int NOT NULL,
  PRIMARY KEY (`id_restaurante`),
  KEY `fk_tbl_restaurante_tbl_usr1_idx` (`id_usr_gerente`),
  CONSTRAINT `fk_tbl_restaurante_tbl_usr1` FOREIGN KEY (`id_usr_gerente`) REFERENCES `tbl_usr` (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_restaurante`
--

LOCK TABLES `tbl_restaurante` WRITE;
/*!40000 ALTER TABLE `tbl_restaurante` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_restaurante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_restu_cocina`
--

DROP TABLE IF EXISTS `tbl_restu_cocina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_restu_cocina` (
  `id_tip_cocina` int NOT NULL AUTO_INCREMENT,
  `id_restaurante` int NOT NULL,
  `tipo_cocina` int NOT NULL,
  PRIMARY KEY (`id_tip_cocina`),
  KEY `fk_tbl_restu_cocina_tbl_restaurante1_idx` (`id_restaurante`),
  KEY `fk_tbl_restu_cocina_tbl_Cocinas1_idx` (`tipo_cocina`),
  CONSTRAINT `fk_tbl_restu_cocina_tbl_Cocinas1` FOREIGN KEY (`tipo_cocina`) REFERENCES `tbl_cocinas` (`id_cocina`),
  CONSTRAINT `fk_tbl_restu_cocina_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_restu_cocina`
--

LOCK TABLES `tbl_restu_cocina` WRITE;
/*!40000 ALTER TABLE `tbl_restu_cocina` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_restu_cocina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usr`
--

DROP TABLE IF EXISTS `tbl_usr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_usr` (
  `id_usr` int NOT NULL AUTO_INCREMENT,
  `usr_nom` varchar(45) DEFAULT NULL,
  `usr_ape` varchar(45) DEFAULT NULL,
  `usr_email` varchar(45) DEFAULT NULL,
  `usr_pwd` varchar(45) DEFAULT NULL,
  `usr_rol` enum('admin','user','gerente') DEFAULT NULL,
  PRIMARY KEY (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usr`
--

LOCK TABLES `tbl_usr` WRITE;
/*!40000 ALTER TABLE `tbl_usr` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_usr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_valoracion`
--

DROP TABLE IF EXISTS `tbl_valoracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_valoracion` (
  `id_valoracion` int NOT NULL AUTO_INCREMENT,
  `id_rest` int NOT NULL,
  `valoracion` int DEFAULT NULL,
  `comentario` varchar(45) DEFAULT NULL,
  `id_usr` int NOT NULL,
  PRIMARY KEY (`id_valoracion`),
  KEY `fk_tbl_valoracion_tbl_restaurante_idx` (`id_rest`),
  KEY `fk_tbl_valoracion_tbl_usr1_idx` (`id_usr`),
  CONSTRAINT `fk_tbl_valoracion_tbl_restaurante` FOREIGN KEY (`id_rest`) REFERENCES `tbl_restaurante` (`id_restaurante`),
  CONSTRAINT `fk_tbl_valoracion_tbl_usr1` FOREIGN KEY (`id_usr`) REFERENCES `tbl_usr` (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_valoracion`
--

LOCK TABLES `tbl_valoracion` WRITE;
/*!40000 ALTER TABLE `tbl_valoracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_valoracion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-19 18:04:23