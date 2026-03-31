mysqldump: [Warning] Using a password on the command line interface can be insecure.
Warning: A partial dump from a server that has GTIDs will by default include the GTIDs of all transactions, even those that changed suppressed parts of the database. If you don't want to restore GTIDs, pass --set-gtid-purged=OFF. To make a complete dump, pass --all-databases --triggers --routines --events. 
Warning: A dump from a server that has GTIDs enabled will by default include the GTIDs of all transactions, even those that were executed during its extraction and might not be represented in the dumped data. This might result in an inconsistent data dump. 
In order to ensure a consistent backup of the database, pass --single-transaction or --lock-all-tables or --source-data. 
-- MySQL dump 10.13  Distrib 9.6.0, for macos26.3 (arm64)
--
-- Host: localhost    Database: cotizador_backend
-- ------------------------------------------------------
-- Server version	9.6.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '2d29257a-e1fe-11f0-aa20-c68a61463b56:1-14884';

--
-- Table structure for table `acabado_cubre_canto_por_componente`
--

DROP TABLE IF EXISTS `acabado_cubre_canto_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acabado_cubre_canto_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `acabado_cubre_canto_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accpc_comp_acabado_uq` (`componente_id`,`acabado_cubre_canto_id`),
  KEY `accpc_acc_fk` (`acabado_cubre_canto_id`),
  CONSTRAINT `accpc_acc_fk` FOREIGN KEY (`acabado_cubre_canto_id`) REFERENCES `acabado_cubre_cantos` (`id`),
  CONSTRAINT `accpc_comp_fk` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acabado_cubre_canto_por_componente`
--

LOCK TABLES `acabado_cubre_canto_por_componente` WRITE;
/*!40000 ALTER TABLE `acabado_cubre_canto_por_componente` DISABLE KEYS */;
INSERT INTO `acabado_cubre_canto_por_componente` VALUES (1,1,1,2,NULL,NULL),(2,1,2,1,NULL,NULL),(3,2,3,2,NULL,NULL),(4,3,4,1,NULL,NULL);
/*!40000 ALTER TABLE `acabado_cubre_canto_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acabado_cubre_cantos`
--

DROP TABLE IF EXISTS `acabado_cubre_cantos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acabado_cubre_cantos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acabado_cubre_cantos_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acabado_cubre_cantos`
--

LOCK TABLES `acabado_cubre_cantos` WRITE;
/*!40000 ALTER TABLE `acabado_cubre_cantos` DISABLE KEYS */;
INSERT INTO `acabado_cubre_cantos` VALUES (1,'EGGER (ALTO BRILLO) 18 MM',40.00,'2026-03-31 05:38:47','2026-03-31 05:38:47'),(2,'ARAUCO 15 MM',15.00,'2026-03-31 05:38:47','2026-03-31 05:38:47'),(3,'FINSA 15 MM',15.00,NULL,NULL),(4,'KAINDL (MADERA) 18MM',20.00,NULL,NULL),(5,'EGGER (MADERA) 18MM',40.00,NULL,NULL),(6,'EGGER (ULTRA MATE) 18 MM',40.00,NULL,NULL),(7,'REHAU (ULTRA MATE) 19.5mm',40.00,NULL,NULL),(8,'REHAU (ALTO BRILLO) 19mm',40.00,NULL,NULL);
/*!40000 ALTER TABLE `acabado_cubre_cantos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acabado_tablero_por_componente`
--

DROP TABLE IF EXISTS `acabado_tablero_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acabado_tablero_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `acabado_tablero_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `atpc_comp_at_uq` (`componente_id`,`acabado_tablero_id`),
  KEY `atpc_at_fk` (`acabado_tablero_id`),
  CONSTRAINT `atpc_at_fk` FOREIGN KEY (`acabado_tablero_id`) REFERENCES `acabado_tableros` (`id`),
  CONSTRAINT `atpc_comp_fk` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acabado_tablero_por_componente`
--

LOCK TABLES `acabado_tablero_por_componente` WRITE;
/*!40000 ALTER TABLE `acabado_tablero_por_componente` DISABLE KEYS */;
INSERT INTO `acabado_tablero_por_componente` VALUES (1,1,1,2,NULL,NULL),(3,2,3,2,NULL,NULL),(4,3,4,1,NULL,NULL);
/*!40000 ALTER TABLE `acabado_tablero_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acabado_tableros`
--

DROP TABLE IF EXISTS `acabado_tableros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acabado_tableros` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acabado_tableros_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acabado_tableros`
--

LOCK TABLES `acabado_tableros` WRITE;
/*!40000 ALTER TABLE `acabado_tableros` DISABLE KEYS */;
INSERT INTO `acabado_tableros` VALUES (1,'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm',9800.00,'2026-03-31 05:38:47','2026-03-31 05:38:47'),(3,'ARAUCO 15 MM',1200.00,NULL,NULL),(4,'FINSA 15 MM',1300.00,NULL,NULL),(5,'KAINDL (MADERA) 2700mm x 2800mm x 18mm',4100.00,NULL,NULL),(6,'EGGER (MADERA) 2700mm x 2800mm x 18mm',6000.00,NULL,NULL),(7,'EGGER (ULTRA MATE) 2700mm x 2800mm x 18mm',9800.00,NULL,NULL),(8,'REHAU (ULTRA MATE) NOIR 2800mm x 1300mm x 19mm',9900.00,NULL,NULL),(9,'REHAU (ALTO BRILLO) CRYSTAL 2800mm x 1300mm x 19mm',10265.00,NULL,NULL),(10,'REHAU (ULTRA MATE) NOBLE 2800mm x 1300mm x 19mm',6800.00,NULL,NULL),(11,'REHAU (ULTRA MATE) ECO FINO 3070mmx1244mmx19.4mm',5500.00,NULL,NULL),(12,'REHAU (ULTRA MATE) BRILLIANT 2800mm x 1300mm x 19mm',5500.00,NULL,NULL),(13,'REHAU (ALTO BRILLO) BRILLIANT 2800mm x 1300mm x 19mm',5500.00,NULL,NULL),(14,'REHAU (ULTRA MATE) RAUVISO FINO BLANCO 2800mm x 1220mm x 18mm',5500.00,NULL,NULL),(15,'REHAU (ULTRA MATE) RAUVISO FINO NEGRO 2800mm x 1220mm x 18mm',5500.00,NULL,NULL),(16,'REHAU (ALTO BRILLO) RAUVISO FINO COLOR 2800mm x 1220mm x 18mm',5500.00,NULL,NULL),(17,'REHAU (ALTO BRILLO) RAUVISO METALLIC 2800mm x 1220mm x 18mm',0.00,NULL,NULL);
/*!40000 ALTER TABLE `acabado_tableros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accesorios`
--

DROP TABLE IF EXISTS `accesorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accesorios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accesorios_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesorios`
--

LOCK TABLES `accesorios` WRITE;
/*!40000 ALTER TABLE `accesorios` DISABLE KEYS */;
INSERT INTO `accesorios` VALUES (1,'MENSULA REPISA',2.00,'2026-03-31 05:35:07','2026-03-31 05:35:07'),(2,'ZOCLO',450.00,'2026-03-31 05:35:07','2026-03-31 05:35:07'),(3,'CLIPS ZOCLO',2.00,'2026-03-31 05:35:07','2026-03-31 05:35:07'),(4,'PATAS NIVELADORAS',20.00,'2026-03-31 05:35:07','2026-03-31 05:35:07'),(5,'Tornillo 1/2\"',1.50,NULL,NULL),(6,'Bisagra Cazoleta',24.90,NULL,NULL),(7,'Jaladera Aluminio',39.00,NULL,NULL);
/*!40000 ALTER TABLE `accesorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accesorios_por_componente`
--

DROP TABLE IF EXISTS `accesorios_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accesorios_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `accesorio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accesorios_por_componente_componente_id_foreign` (`componente_id`),
  CONSTRAINT `accesorios_por_componente_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesorios_por_componente`
--

LOCK TABLES `accesorios_por_componente` WRITE;
/*!40000 ALTER TABLE `accesorios_por_componente` DISABLE KEYS */;
INSERT INTO `accesorios_por_componente` VALUES (1,1,'MENSULA REPISA',1,NULL,NULL),(2,2,'ZOCLO',1,NULL,NULL),(3,3,'CLIPS ZOCLO',2,NULL,NULL);
/*!40000 ALTER TABLE `accesorios_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cantidad_por_componente`
--

DROP TABLE IF EXISTS `cantidad_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cantidad_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `modulo_id` bigint unsigned NOT NULL,
  `componente_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cantidad_por_componente_modulo_id_foreign` (`modulo_id`),
  KEY `cantidad_por_componente_componente_id_foreign` (`componente_id`),
  CONSTRAINT `cantidad_por_componente_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cantidad_por_componente_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_por_componente`
--

LOCK TABLES `cantidad_por_componente` WRITE;
/*!40000 ALTER TABLE `cantidad_por_componente` DISABLE KEYS */;
INSERT INTO `cantidad_por_componente` VALUES (1,1,1,4,NULL,NULL),(2,1,2,1,NULL,NULL),(3,1,3,1,NULL,NULL),(4,2,4,4,NULL,NULL),(5,2,1,2,NULL,NULL);
/*!40000 ALTER TABLE `cantidad_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cantidad_por_componentes`
--

DROP TABLE IF EXISTS `cantidad_por_componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cantidad_por_componentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cantidad_por_componentes_componente_id_foreign` (`componente_id`),
  CONSTRAINT `cantidad_por_componentes_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_por_componentes`
--

LOCK TABLES `cantidad_por_componentes` WRITE;
/*!40000 ALTER TABLE `cantidad_por_componentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cantidad_por_componentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capacidad_correderas`
--

DROP TABLE IF EXISTS `capacidad_correderas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capacidad_correderas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `capacidad` int NOT NULL COMMENT 'Capacidad en kilogramos',
  `corredera_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `capacidad_correderas_capacidad_corredera_id_unique` (`capacidad`,`corredera_id`),
  KEY `capacidad_correderas_corredera_id_foreign` (`corredera_id`),
  CONSTRAINT `capacidad_correderas_corredera_id_foreign` FOREIGN KEY (`corredera_id`) REFERENCES `correderas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capacidad_correderas`
--

LOCK TABLES `capacidad_correderas` WRITE;
/*!40000 ALTER TABLE `capacidad_correderas` DISABLE KEYS */;
/*!40000 ALTER TABLE `capacidad_correderas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Público en general','publico@cotizador.com','N/A','N/A','N/A','Cliente genérico para ventas públicas','2026-03-31 05:35:07','2026-03-31 05:35:07'),(2,'Triston Boyer','cpouros@example.com','+1 (570) 527-8095','87333 Frami Island Suite 238\nWaelchichester, IL 49694-3654','Lesch and Sons','Error necessitatibus non natus et et.','2026-03-31 05:47:31','2026-03-31 05:47:31'),(3,'Terence D\'Amore','margarete.white@example.com','321-686-0638','259 Lauren Radial\nHagenesland, WA 77418','Lubowitz Inc','Id natus tenetur molestiae voluptatem distinctio soluta.','2026-03-31 05:47:31','2026-03-31 05:47:31'),(4,'Bernhard Kshlerin','noe03@example.org','+1.754.843.7364','29468 Lemke Highway Suite 776\nJaylanport, VA 32693','Schiller PLC','Odit quis natus rerum illo corrupti officiis deleniti.','2026-03-31 05:47:31','2026-03-31 05:47:31'),(5,'Fred Goldner','cruickshank.laila@example.net','956-656-3078','577 Roscoe Radial Apt. 578\nWest Ronfurt, NY 32411','Herman, Breitenberg and Bahringer','Eum quibusdam soluta error quae.','2026-03-31 05:47:31','2026-03-31 05:47:31'),(6,'Bridgette Altenwerth','twila82@example.com','(734) 733-0355','3833 Doyle River Apt. 482\nCharlesmouth, MA 21330','Herzog-Jones','At aspernatur minus officiis occaecati neque qui mollitia fuga.','2026-03-31 05:47:31','2026-03-31 05:47:31');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compases_abatibles`
--

DROP TABLE IF EXISTS `compases_abatibles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compases_abatibles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `compases_abatibles_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compases_abatibles`
--

LOCK TABLES `compases_abatibles` WRITE;
/*!40000 ALTER TABLE `compases_abatibles` DISABLE KEYS */;
INSERT INTO `compases_abatibles` VALUES (1,'AVENTOS HK-XS',3775.80,'2026-03-31 05:45:22','2026-03-31 05:45:22'),(2,'AVENTOS HK-S',1087.50,'2026-03-31 05:45:22','2026-03-31 05:45:22'),(3,'AVENTOS HK-TOP',2271.89,'2026-03-31 05:45:22','2026-03-31 05:45:22'),(4,'AVENTOS HL-TOP',4314.20,'2026-03-31 05:45:22','2026-03-31 05:45:22'),(5,'AVENTOS HF-TOP',3925.30,'2026-03-31 05:45:22','2026-03-31 05:45:22');
/*!40000 ALTER TABLE `compases_abatibles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componentes`
--

DROP TABLE IF EXISTS `componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `componentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accesorios` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `componentes_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componentes`
--

LOCK TABLES `componentes` WRITE;
/*!40000 ALTER TABLE `componentes` DISABLE KEYS */;
INSERT INTO `componentes` VALUES (1,'Silla Lucianica','Silla Lucianica de Roble','COMP_SILLA_LUCIANICA',1299.00,NULL,NULL,NULL),(2,'Mesa Lucianica','Mesa Lucianica de Roble','COMP_MESA_LUCIANICA',2399.00,NULL,NULL,NULL),(3,'Estante Moderno','Estante Moderno de MDF','COMP_ESTANTE_MODERNO',999.00,NULL,NULL,NULL),(4,'Mesa de Centro Purru','Mesa de centro minimalista con estructura metálica y superficie de vidrio templado','COMP_MESA_CENTRO_MINIMALISTA',1799.00,NULL,NULL,NULL),(5,'Silla Lucianica (Copia)','Silla Lucianica de Roble','COMP_SILLA_LUCIANICA_COPIA',0.00,NULL,'2026-03-31 06:39:01','2026-03-31 06:39:01');
/*!40000 ALTER TABLE `componentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componentes_por_cotizacion`
--

DROP TABLE IF EXISTS `componentes_por_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `componentes_por_cotizacion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cotizacion_id` bigint unsigned NOT NULL,
  `componente_id` bigint unsigned NOT NULL,
  `modulo_id` bigint unsigned DEFAULT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `componentes_por_cotizacion_cotizacion_id_foreign` (`cotizacion_id`),
  KEY `componentes_por_cotizacion_componente_id_foreign` (`componente_id`),
  KEY `componentes_por_cotizacion_modulo_id_foreign` (`modulo_id`),
  CONSTRAINT `componentes_por_cotizacion_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`),
  CONSTRAINT `componentes_por_cotizacion_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`),
  CONSTRAINT `componentes_por_cotizacion_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componentes_por_cotizacion`
--

LOCK TABLES `componentes_por_cotizacion` WRITE;
/*!40000 ALTER TABLE `componentes_por_cotizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `componentes_por_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correderas`
--

DROP TABLE IF EXISTS `correderas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `correderas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacidad_carga` int NOT NULL COMMENT 'Capacidad de carga en kilogramos',
  `tipo` enum('PARCIAL','TOTAL','TOTAL_TIP_ON') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo de corredera',
  `incluye_varilla` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si incluye varilla de sincronización',
  `precio_base` decimal(10,2) NOT NULL,
  `precio_con_acoplamiento` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correderas_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correderas`
--

LOCK TABLES `correderas` WRITE;
/*!40000 ALTER TABLE `correderas` DISABLE KEYS */;
INSERT INTO `correderas` VALUES (1,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 350mm 550H3500B',30,'PARCIAL',0,344.40,394.60,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(2,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 400mm 550H4000B',30,'PARCIAL',0,350.20,400.40,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(3,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 450mm 550H4500B',30,'PARCIAL',0,354.90,405.10,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(4,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 500mm 550H5000B',30,'PARCIAL',0,359.90,410.10,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(5,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 550mm 550H5500B',30,'PARCIAL',0,400.40,450.60,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(6,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 270mm 560H2700B',30,'TOTAL',0,662.80,713.00,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(7,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 300mm 560H3000B',30,'TOTAL',0,662.80,713.00,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(8,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 350mm 560H3500B',30,'TOTAL',0,662.80,713.00,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(9,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 400mm 560H4000B',30,'TOTAL',0,671.40,721.60,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(10,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 450mm 560H4500B',30,'TOTAL',0,680.10,730.30,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(11,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 500mm 560H5000B',30,'TOTAL',0,688.80,739.00,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(12,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 550mm 560H5500B',30,'TOTAL',0,721.60,771.80,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(13,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 600mm 560H6000B',30,'TOTAL',0,822.41,872.61,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(14,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 250mm 560H2500T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(15,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 300mm 560H3000T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(16,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 350mm 560H3500T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(17,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 400mm 560H4000T',30,'TOTAL_TIP_ON',1,728.40,906.90,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(18,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 450mm 560H4500T',30,'TOTAL_TIP_ON',1,736.99,915.49,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(19,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 500mm 560H5000T',30,'TOTAL_TIP_ON',1,745.69,924.19,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(20,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 550mm 560H5500T',30,'TOTAL_TIP_ON',1,778.50,957.00,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(21,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 300mm 760H3000S',40,'TOTAL',0,793.90,888.50,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(22,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 350mm 760H3500S',40,'TOTAL',0,793.90,888.50,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(23,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 400mm 760H4000S',40,'TOTAL',0,802.60,897.20,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(24,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 450mm 760H4500S',40,'TOTAL',0,812.30,906.90,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(25,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 500mm 760H5000S',40,'TOTAL',0,821.25,915.85,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(26,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 550mm 760H5500S',40,'TOTAL',0,869.30,963.90,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(27,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 600mm 760H6000S',40,'TOTAL',0,982.10,1076.70,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(28,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 500mm 766H5000S',70,'TOTAL',0,1095.90,1190.50,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(29,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 550mm 766H5500S',70,'TOTAL',0,1149.90,1244.50,'2026-03-31 05:42:59','2026-03-31 05:42:59'),(30,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 650mm 766H6500S',70,'TOTAL',0,1311.00,1405.60,'2026-03-31 05:42:59','2026-03-31 05:42:59');
/*!40000 ALTER TABLE `correderas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion_por_cliente`
--

DROP TABLE IF EXISTS `cotizacion_por_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizacion_por_cliente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cliente_id` bigint unsigned NOT NULL,
  `cotizacion_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cotizacion_por_cliente_cliente_id_cotizacion_id_unique` (`cliente_id`,`cotizacion_id`),
  KEY `cotizacion_por_cliente_cotizacion_id_foreign` (`cotizacion_id`),
  CONSTRAINT `cotizacion_por_cliente_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cotizacion_por_cliente_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion_por_cliente`
--

LOCK TABLES `cotizacion_por_cliente` WRITE;
/*!40000 ALTER TABLE `cotizacion_por_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cotizacion_por_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizaciones`
--

DROP TABLE IF EXISTS `cotizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint unsigned NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('activa','pendiente','completada','rechazada','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activa',
  `created_by_user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cotizaciones_cliente_id_foreign` (`cliente_id`),
  KEY `cotizaciones_created_by_user_id_foreign` (`created_by_user_id`),
  CONSTRAINT `cotizaciones_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cotizaciones_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizaciones`
--

LOCK TABLES `cotizaciones` WRITE;
/*!40000 ALTER TABLE `cotizaciones` DISABLE KEYS */;
INSERT INTO `cotizaciones` VALUES (1,2,'1996-08-23',4182.02,'completada',NULL,'2026-03-31 05:47:31','2026-03-31 05:47:31');
/*!40000 ALTER TABLE `cotizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizaciones_por_usuario`
--

DROP TABLE IF EXISTS `cotizaciones_por_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizaciones_por_usuario` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `cotizacion_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cotizaciones_por_usuario_user_id_cotizacion_id_unique` (`user_id`,`cotizacion_id`),
  KEY `cotizaciones_por_usuario_cotizacion_id_foreign` (`cotizacion_id`),
  CONSTRAINT `cotizaciones_por_usuario_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cotizaciones_por_usuario_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizaciones_por_usuario`
--

LOCK TABLES `cotizaciones_por_usuario` WRITE;
/*!40000 ALTER TABLE `cotizaciones_por_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `cotizaciones_por_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_cotizacions`
--

DROP TABLE IF EXISTS `detalle_cotizacions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_cotizacions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cotizacion_id` bigint unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `modulo_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_cotizacions_cotizacion_id_foreign` (`cotizacion_id`),
  KEY `detalle_cotizacions_modulo_id_foreign` (`modulo_id`),
  CONSTRAINT `detalle_cotizacions_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalle_cotizacions_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_cotizacions`
--

LOCK TABLES `detalle_cotizacions` WRITE;
/*!40000 ALTER TABLE `detalle_cotizacions` DISABLE KEYS */;
INSERT INTO `detalle_cotizacions` VALUES (1,1,'Rem incidunt deserunt est laudantium recusandae aliquam neque.',5,78.28,841.18,'2026-03-31 05:47:31','2026-03-31 05:47:31',4),(2,1,'Sapiente tenetur nam optio delectus tenetur expedita.',6,89.52,147.67,'2026-03-31 05:47:31','2026-03-31 05:47:31',2);
/*!40000 ALTER TABLE `detalle_cotizacions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estructura`
--

DROP TABLE IF EXISTS `estructura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estructura` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estructura`
--

LOCK TABLES `estructura` WRITE;
/*!40000 ALTER TABLE `estructura` DISABLE KEYS */;
INSERT INTO `estructura` VALUES (1,'BCO FROSTY',800.00,NULL,NULL),(3,'ARAUCO LINO CAIRO',1200.00,NULL,NULL);
/*!40000 ALTER TABLE `estructura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estructura_por_componente`
--

DROP TABLE IF EXISTS `estructura_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estructura_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `estructura_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estructura_por_componente_componente_id_estructura_id_unique` (`componente_id`,`estructura_id`),
  KEY `estructura_por_componente_estructura_id_foreign` (`estructura_id`),
  CONSTRAINT `estructura_por_componente_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`),
  CONSTRAINT `estructura_por_componente_estructura_id_foreign` FOREIGN KEY (`estructura_id`) REFERENCES `estructura` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estructura_por_componente`
--

LOCK TABLES `estructura_por_componente` WRITE;
/*!40000 ALTER TABLE `estructura_por_componente` DISABLE KEYS */;
INSERT INTO `estructura_por_componente` VALUES (1,1,1,1,NULL,NULL),(4,3,1,2,NULL,NULL);
/*!40000 ALTER TABLE `estructura_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gola_por_componente`
--

DROP TABLE IF EXISTS `gola_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gola_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `gola_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gpc_comp_gola_uq` (`componente_id`,`gola_id`),
  KEY `gpc_gola_fk` (`gola_id`),
  CONSTRAINT `gpc_comp_fk` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`),
  CONSTRAINT `gpc_gola_fk` FOREIGN KEY (`gola_id`) REFERENCES `table_gola` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gola_por_componente`
--

LOCK TABLES `gola_por_componente` WRITE;
/*!40000 ALTER TABLE `gola_por_componente` DISABLE KEYS */;
INSERT INTO `gola_por_componente` VALUES (1,3,1,2,NULL,NULL),(2,4,1,1,NULL,NULL),(3,2,1,2,NULL,NULL);
/*!40000 ALTER TABLE `gola_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_12_04_204100_create_componentes_table',1),(5,'2025_12_04_204200_create_modulos_table',1),(6,'2025_12_17_205930_create_personal_access_tokens_table',1),(7,'2025_12_19_001705_table_cantidad_por_componente',1),(8,'2025_12_19_001907_table_accesorios_por_componente',1),(9,'2025_12_19_194148_create_clientes_table',1),(10,'2025_12_19_195413_create_cotizaciones_table',1),(11,'2025_12_19_195500_create_cotizacion_por_cliente_table',1),(12,'2025_12_19_204453_create_detalle_cotizacions_table',1),(13,'2025_12_19_213256_add_modulo_id_to_detalle_cotizacions_table',1),(14,'2025_12_19_213602_update_modulo_id_in_detalle_cotizacions',1),(15,'2025_12_19_213611_update_modulo_id_in_detalle_cotizacions',1),(16,'2026_01_14_052427_create_cantidad_por_componentes_table',1),(17,'2026_01_16_003158_add_estado_to_cotizaciones_table',1),(18,'2026_01_16_003809_update_cotizaciones_with_default_estado',1),(19,'2026_01_19_191045_create_componentes_por_cotizacion_table',1),(20,'2026_01_20_004118_add_modulo_id_to_componentes_por_cotizacion',1),(21,'2026_01_21_200023_update_cotizaciones_estado_enum',1),(22,'2026_01_22_005222_update_cotizaciones_estado_to_completada',1),(23,'2026_01_22_221604_make_clientes_email_nullable',1),(24,'2026_01_22_221616_make_clientes_email_nullable',1),(25,'2026_02_03_003215_create_estructura_table',1),(26,'2026_02_03_010744_create_acabado_tableros_table',1),(27,'2026_02_03_014708_create_acabado_cubre_cantos_table',1),(28,'2026_02_17_022755_create_correderas_table',1),(29,'2026_02_17_031825_create_table_compases_abatibles',1),(30,'2026_02_17_040843_create_table_puertas',1),(31,'2026_02_17_043102_create_table_gola',1),(32,'2026_02_22_000002_create_estructura_por_componente_table',1),(33,'2026_02_22_000004_create_acabado_cubre_canto_por_componente_table',1),(34,'2026_02_22_000005_create_acabado_tablero_por_componente_table',1),(35,'2026_02_22_000006_create_puertas_por_componente_table',1),(36,'2026_02_23_000007_create_gola_por_componente_table',1),(37,'2026_02_23_000008_add_precio_final_to_puertas_table',1),(38,'2026_02_23_000009_add_precio_unitario_to_componentes_table',1),(39,'2026_02_23_000010_create_accesorios_table',1),(40,'2026_02_23_000011_add_cantidad_to_accesorios_por_componente_table',1),(41,'2026_02_23_000012_add_rol_to_users_table',1),(42,'2026_03_30_000000_create_cliente_publico_en_general',1),(43,'2026_03_30_000001_create_capacidad_correderas_table',1),(44,'2026_03_30_000002_seed_capacidad_correderas',1),(45,'2026_03_30_000003_remove_costo_unitario_from_tables',1),(46,'2026_03_30_000004_create_cotizaciones_por_usuario_table',1),(47,'2026_03_30_000005_add_created_by_to_cotizaciones_table',1),(48,'2026_03_30_000006_backfill_created_by_user_id_cotizaciones',1),(49,'2026_03_30_000007_backfill_cotizaciones_por_usuario_from_created_by',1),(50,'2026_03_30_000008_seed_acabado_tableros_y_cubre_cantos',2),(51,'2026_03_30_000009_add_costo_unitario_to_acabado_tableros',3),(52,'2026_03_30_000010_add_costo_unitario_to_acabado_cubre_cantos',4),(53,'2026_03_30_000011_add_costo_unitario_to_estructura',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modulos_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'Comedor Lucianico','Comedor de Roble con acabados de alta calidad','COM_LUCIANICO',NULL,NULL),(2,'Centro de Entretenimiento Purru','Comedor de Roble con acabados de alta calidad','CENT_ENT_PURRU',NULL,NULL),(3,'Comedor Moderno','Comedor con diseño moderno y elegante','COM_MODERNO',NULL,NULL),(4,'Comedor Rústico','Comedor con estilo rústico y acogedor','COM_RUSTICO',NULL,NULL);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'api-token','7734d02737e0f655dab3dc5be9a2e8f5714ad91712539abf752c73058890e2c4','[\"*\"]','2026-03-31 06:39:01',NULL,'2026-03-31 05:42:10','2026-03-31 06:39:01');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puertas`
--

DROP TABLE IF EXISTS `puertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puertas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_perfil_aluminio` decimal(10,2) NOT NULL,
  `precio_escuadras` decimal(10,2) NOT NULL,
  `precio_silicon` decimal(10,2) NOT NULL,
  `precio_cristal_m2` decimal(10,2) NOT NULL,
  `precio_final` decimal(10,2) NOT NULL DEFAULT '0.00',
  `alto_maximo` decimal(8,2) NOT NULL DEFAULT '2.40',
  `ancho_maximo` decimal(8,2) NOT NULL DEFAULT '0.60',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `puertas_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puertas`
--

LOCK TABLES `puertas` WRITE;
/*!40000 ALTER TABLE `puertas` DISABLE KEYS */;
INSERT INTO `puertas` VALUES (1,'Puerta Cristal Standard',793.00,50.00,80.00,1400.00,2323.00,2.40,0.60,'2026-03-31 05:45:32','2026-03-31 05:45:32');
/*!40000 ALTER TABLE `puertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puertas_por_componente`
--

DROP TABLE IF EXISTS `puertas_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puertas_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `puerta_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppc_comp_puerta_uq` (`componente_id`,`puerta_id`),
  KEY `ppc_puerta_fk` (`puerta_id`),
  CONSTRAINT `ppc_comp_fk` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`),
  CONSTRAINT `ppc_puerta_fk` FOREIGN KEY (`puerta_id`) REFERENCES `puertas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puertas_por_componente`
--

LOCK TABLES `puertas_por_componente` WRITE;
/*!40000 ALTER TABLE `puertas_por_componente` DISABLE KEYS */;
INSERT INTO `puertas_por_componente` VALUES (1,3,1,2,NULL,NULL),(2,4,1,1,NULL,NULL),(3,2,1,2,NULL,NULL);
/*!40000 ALTER TABLE `puertas_por_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('G8dRcIUJAjUB25RkYw3kRzj2mPO0Zyb0GNerLUeQ',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTTNYNEFHb0RrT2VtOTRKR1NyZUltQ29UQ0xveWplSWpVU0xyZjYySiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvYXV0aC9tZSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1774913771),('ssYcJsEh7AnS2gQZSGkqKfvVutByY6qaQ2rrBBzD',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidExDQ1RQV1BjUkl5ZlRYZnJXVEdQdHl5R2Q4dEQ2VDdUcFk2RGpjRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvY29tcG9uZW50ZXMiO3M6NToicm91dGUiO3M6MTc6ImNvbXBvbmVudGVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1774917541);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_gola`
--

DROP TABLE IF EXISTS `table_gola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_gola` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_gola`
--

LOCK TABLES `table_gola` WRITE;
/*!40000 ALTER TABLE `table_gola` DISABLE KEYS */;
INSERT INTO `table_gola` VALUES (1,'SUPERIOR','Gola superior',701.00,NULL,NULL),(2,'INFERIOR','Gola inferior',795.00,NULL,NULL),(3,'ESCUADRA','Escuadra para gola',30.00,NULL,NULL);
/*!40000 ALTER TABLE `table_gola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','vendedor','desarrollador') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vendedor',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@cotizador.local','admin',NULL,'$2y$12$ehlaq6r/HcDcRssTOBHJ3esEANC7KcxwhYe5fFsS.6TUSxU0ZRNLW',NULL,'2026-03-31 05:41:36','2026-03-31 05:41:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-30 18:39:55
