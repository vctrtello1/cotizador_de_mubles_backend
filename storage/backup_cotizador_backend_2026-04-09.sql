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

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '2d29257a-e1fe-11f0-aa20-c68a61463b56:1-17365';

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
INSERT INTO `acabado_cubre_cantos` VALUES (1,'EGGER (ALTO BRILLO) 18 MM',40.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(2,'ARAUCO 15 MM',15.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(3,'FINSA 15 MM',15.00,NULL,NULL),(4,'KAINDL (MADERA) 18MM',20.00,NULL,NULL),(5,'EGGER (MADERA) 18MM',40.00,NULL,NULL),(6,'EGGER (ULTRA MATE) 18 MM',40.00,NULL,NULL),(7,'REHAU (ULTRA MATE) 19.5mm',40.00,NULL,NULL),(8,'REHAU (ALTO BRILLO) 19mm',40.00,NULL,NULL);
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
INSERT INTO `acabado_tablero_por_componente` VALUES (1,1,1,2,NULL,NULL),(2,1,2,1,NULL,NULL),(3,2,3,2,NULL,NULL),(4,3,4,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acabado_tableros`
--

LOCK TABLES `acabado_tableros` WRITE;
/*!40000 ALTER TABLE `acabado_tableros` DISABLE KEYS */;
INSERT INTO `acabado_tableros` VALUES (1,'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm',9800.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(2,'NINGUNO',0.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(3,'ARAUCO 15 MM',1200.00,NULL,NULL),(4,'FINSA 15 MM',1300.00,NULL,NULL),(5,'KAINDL (MADERA) 2700mm x 2800mm x 18mm',4100.00,NULL,NULL),(6,'EGGER (MADERA) 2700mm x 2800mm x 18mm',6000.00,NULL,NULL),(7,'EGGER (ULTRA MATE) 2700mm x 2800mm x 18mm',9800.00,NULL,NULL),(8,'REHAU (ULTRA MATE) NOIR 2800mm x 1300mm x 19mm',9900.00,NULL,NULL),(9,'REHAU (ALTO BRILLO) CRYSTAL 2800mm x 1300mm x 19mm',10265.00,NULL,NULL),(10,'REHAU (ULTRA MATE) NOBLE 2800mm x 1300mm x 19mm',6800.00,NULL,NULL),(11,'REHAU (ULTRA MATE) ECO FINO 3070mmx1244mmx19.4mm',5500.00,NULL,NULL),(12,'REHAU (ULTRA MATE) BRILLIANT 2800mm x 1300mm x 19mm',5500.00,NULL,NULL),(13,'REHAU (ALTO BRILLO) BRILLIANT 2800mm x 1300mm x 19mm',5500.00,NULL,NULL),(14,'REHAU (ULTRA MATE) RAUVISO FINO BLANCO 2800mm x 1220mm x 18mm',5500.00,NULL,NULL),(15,'REHAU (ULTRA MATE) RAUVISO FINO NEGRO 2800mm x 1220mm x 18mm',5500.00,NULL,NULL),(16,'REHAU (ALTO BRILLO) RAUVISO FINO COLOR 2800mm x 1220mm x 18mm',5500.00,NULL,NULL);
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
INSERT INTO `accesorios` VALUES (1,'MENSULA REPISA',2.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(2,'ZOCLO',450.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(3,'CLIPS ZOCLO',2.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(4,'PATAS NIVELADORAS',20.00,'2026-04-08 06:38:21','2026-04-08 06:38:21'),(5,'Tornillo 1/2\"',1.50,NULL,NULL),(6,'Bisagra Cazoleta',24.90,NULL,NULL),(7,'Jaladera Aluminio',39.00,NULL,NULL);
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
-- Table structure for table `apagadores`
--

DROP TABLE IF EXISTS `apagadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apagadores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidades_por_metro` int NOT NULL DEFAULT '2',
  `porcentaje_utilizacion` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apagadores_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apagadores`
--

LOCK TABLES `apagadores` WRITE;
/*!40000 ALTER TABLE `apagadores` DISABLE KEYS */;
INSERT INTO `apagadores` VALUES (1,'APAGADOR',210.00,2,7.63,'2026-04-08 21:02:34','2026-04-08 21:02:34'),(2,'APAGADOR TOUCH',250.00,2,8.50,NULL,NULL),(3,'APAGADOR DIMMER',280.00,1,9.25,NULL,NULL);
/*!40000 ALTER TABLE `apagadores` ENABLE KEYS */;
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
INSERT INTO `cache` VALUES ('laravel-cache-boost.roster.scan','a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:9:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.41.1\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:1:\"*\";s:10:\"\0*\0package\";E:40:\"Laravel\\Roster\\Enums\\Packages:NIGHTWATCH\";s:14:\"\0*\0packageName\";s:18:\"laravel/nightwatch\";s:10:\"\0*\0version\";s:6:\"1.26.0\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.8\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:5:\"0.3.8\";s:6:\"\0*\0dev\";b:0;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^4.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:SANCTUM\";s:14:\"\0*\0packageName\";s:15:\"laravel/sanctum\";s:10:\"\0*\0version\";s:5:\"4.2.1\";s:6:\"\0*\0dev\";b:0;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.4\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.3.4\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.26.0\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.50.0\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:7:\"^11.5.3\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.45\";s:6:\"\0*\0dev\";b:1;}i:8;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"4.1.17\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1775667576;}',1775753976);
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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capacidad_correderas`
--

LOCK TABLES `capacidad_correderas` WRITE;
/*!40000 ALTER TABLE `capacidad_correderas` DISABLE KEYS */;
INSERT INTO `capacidad_correderas` VALUES (1,30,1,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(2,40,1,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,70,1,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,30,2,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,40,2,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(6,70,2,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(7,30,3,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(8,40,3,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(9,70,3,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(10,30,4,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(11,40,4,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(12,70,4,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(13,30,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(14,40,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(15,70,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(16,30,6,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(17,40,6,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(18,70,6,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(19,30,7,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(20,40,7,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(21,70,7,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(22,30,8,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(23,40,8,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(24,70,8,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(25,30,9,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(26,40,9,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(27,70,9,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(28,30,10,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(29,40,10,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(30,70,10,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(31,30,11,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(32,40,11,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(33,70,11,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(34,30,12,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(35,40,12,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(36,70,12,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(37,30,13,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(38,40,13,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(39,70,13,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(40,30,14,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(41,40,14,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(42,70,14,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(43,30,15,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(44,40,15,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(45,70,15,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(46,30,16,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(47,40,16,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(48,70,16,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(49,30,17,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(50,40,17,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(51,70,17,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(52,30,18,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(53,40,18,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(54,70,18,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(55,30,19,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(56,40,19,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(57,70,19,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(58,30,20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(59,40,20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(60,70,20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(61,30,21,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(62,40,21,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(63,70,21,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(64,30,22,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(65,40,22,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(66,70,22,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(67,30,23,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(68,40,23,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(69,70,23,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(70,30,24,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(71,40,24,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(72,70,24,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(73,30,25,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(74,40,25,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(75,70,25,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(76,30,26,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(77,40,26,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(78,70,26,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(79,30,27,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(80,40,27,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(81,70,27,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(82,30,28,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(83,40,28,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(84,70,28,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(85,30,29,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(86,40,29,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(87,70,29,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(88,30,30,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(89,40,30,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(90,70,30,'2026-04-08 06:38:22','2026-04-08 06:38:22');
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
INSERT INTO `clientes` VALUES (1,'Público en general','publico@cotizador.com','N/A','N/A','N/A','Cliente genérico para ventas públicas','2026-04-08 06:38:21','2026-04-08 06:38:21'),(2,'Sven Murray','bartoletti.sandra@example.net','850.843.5964','382 Shanahan Fall Suite 266\nNew Josue, MS 51300-4053','Lind, Green and Glover','Fugit doloremque natus veniam quis non qui non.','2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,'Gina Schoen II','tjohns@example.net','(534) 329-2075','69202 Zane Landing\nCreminmouth, AK 53140','Ferry-Fahey','Qui eius qui sit maxime.','2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,'Jared Zemlak V','mraz.theron@example.com','715-318-3412','5091 Sipes Mews Apt. 089\nCarrollside, NH 17245-3050','Schroeder, Reynolds and Stiedemann','Dicta aut nobis nobis quas et porro iusto.','2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,'Prof. Floy Homenick PhD','maybelle64@example.org','+1-386-633-7677','9429 Donnelly Grove\nPort Alec, WA 19536','Greenholt-Shields','Dignissimos ut numquam excepturi omnis quis fugit cum qui.','2026-04-08 06:38:22','2026-04-08 06:38:22'),(6,'Ms. Magdalen Simonis PhD','reed.feil@example.org','+1-351-815-1937','2917 Al Fields\nRustyburgh, CA 84243-3672','Rau, Mosciski and Ruecker','Qui qui doloremque vel.','2026-04-08 06:38:22','2026-04-08 06:38:22');
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
INSERT INTO `compases_abatibles` VALUES (1,'AVENTOS HK-XS',3775.80,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(2,'AVENTOS HK-S',1087.50,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,'AVENTOS HK-TOP',2271.89,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,'AVENTOS HL-TOP',4314.20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,'AVENTOS HF-TOP',3925.30,'2026-04-08 06:38:22','2026-04-08 06:38:22');
/*!40000 ALTER TABLE `compases_abatibles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compases_abatibles_por_componente`
--

DROP TABLE IF EXISTS `compases_abatibles_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compases_abatibles_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `compas_abatible_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compases_abatibles_por_componente_componente_id_foreign` (`componente_id`),
  KEY `compases_abatibles_por_componente_compas_abatible_id_foreign` (`compas_abatible_id`),
  CONSTRAINT `compases_abatibles_por_componente_compas_abatible_id_foreign` FOREIGN KEY (`compas_abatible_id`) REFERENCES `compases_abatibles` (`id`),
  CONSTRAINT `compases_abatibles_por_componente_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compases_abatibles_por_componente`
--

LOCK TABLES `compases_abatibles_por_componente` WRITE;
/*!40000 ALTER TABLE `compases_abatibles_por_componente` DISABLE KEYS */;
/*!40000 ALTER TABLE `compases_abatibles_por_componente` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componentes`
--

LOCK TABLES `componentes` WRITE;
/*!40000 ALTER TABLE `componentes` DISABLE KEYS */;
INSERT INTO `componentes` VALUES (1,'Silla Lucianica','Silla Lucianica de Roble','COMP_SILLA_LUCIANICA',1299.00,NULL,NULL,NULL),(2,'Mesa Lucianica','Mesa Lucianica de Roble','COMP_MESA_LUCIANICA',2399.00,NULL,NULL,NULL),(3,'Estante Moderno','Estante Moderno de MDF','COMP_ESTANTE_MODERNO',999.00,NULL,NULL,NULL),(4,'Mesa de Centro Purru','Mesa de centro minimalista con estructura metálica y superficie de vidrio templado','COMP_MESA_CENTRO_MINIMALISTA',1799.00,NULL,NULL,NULL);
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
INSERT INTO `componentes_por_cotizacion` VALUES (4,1,1,1,4,'2026-04-08 22:29:30','2026-04-08 22:29:30'),(5,1,2,1,2,'2026-04-08 22:29:30','2026-04-08 22:29:37'),(6,1,3,1,1,'2026-04-08 22:29:30','2026-04-08 22:29:30');
/*!40000 ALTER TABLE `componentes_por_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conectores`
--

DROP TABLE IF EXISTS `conectores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conectores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidades_por_metro` int NOT NULL DEFAULT '2',
  `porcentaje_utilizacion` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conectores_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conectores`
--

LOCK TABLES `conectores` WRITE;
/*!40000 ALTER TABLE `conectores` DISABLE KEYS */;
INSERT INTO `conectores` VALUES (1,'CONECTORES',60.00,2,7.63,'2026-04-08 20:37:43','2026-04-08 20:37:43'),(2,'CONECTORES MINIFIX',45.00,2,5.50,NULL,NULL),(3,'CONECTORES EXCÉNTRICOS',75.00,3,8.75,NULL,NULL);
/*!40000 ALTER TABLE `conectores` ENABLE KEYS */;
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
INSERT INTO `correderas` VALUES (1,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 350mm 550H3500B',30,'PARCIAL',0,344.40,394.60,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(2,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 400mm 550H4000B',30,'PARCIAL',0,350.20,400.40,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 450mm 550H4500B',30,'PARCIAL',0,354.90,405.10,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 500mm 550H5000B',30,'PARCIAL',0,359.90,410.10,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 550mm 550H5500B',30,'PARCIAL',0,400.40,450.60,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(6,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 270mm 560H2700B',30,'TOTAL',0,662.80,713.00,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(7,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 300mm 560H3000B',30,'TOTAL',0,662.80,713.00,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(8,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 350mm 560H3500B',30,'TOTAL',0,662.80,713.00,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(9,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 400mm 560H4000B',30,'TOTAL',0,671.40,721.60,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(10,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 450mm 560H4500B',30,'TOTAL',0,680.10,730.30,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(11,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 500mm 560H5000B',30,'TOTAL',0,688.80,739.00,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(12,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 550mm 560H5500B',30,'TOTAL',0,721.60,771.80,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(13,'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 600mm 560H6000B',30,'TOTAL',0,822.41,872.61,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(14,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 250mm 560H2500T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(15,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 300mm 560H3000T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(16,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 350mm 560H3500T',30,'TOTAL_TIP_ON',1,719.70,898.20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(17,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 400mm 560H4000T',30,'TOTAL_TIP_ON',1,728.40,906.90,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(18,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 450mm 560H4500T',30,'TOTAL_TIP_ON',1,736.99,915.49,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(19,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 500mm 560H5000T',30,'TOTAL_TIP_ON',1,745.69,924.19,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(20,'CORREDERA TANDEM TOTAL TIP-ON 30kgs 550mm 560H5500T',30,'TOTAL_TIP_ON',1,778.50,957.00,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(21,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 300mm 760H3000S',40,'TOTAL',0,793.90,888.50,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(22,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 350mm 760H3500S',40,'TOTAL',0,793.90,888.50,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(23,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 400mm 760H4000S',40,'TOTAL',0,802.60,897.20,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(24,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 450mm 760H4500S',40,'TOTAL',0,812.30,906.90,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(25,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 500mm 760H5000S',40,'TOTAL',0,821.25,915.85,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(26,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 550mm 760H5500S',40,'TOTAL',0,869.30,963.90,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(27,'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 600mm 760H6000S',40,'TOTAL',0,982.10,1076.70,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(28,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 500mm 766H5000S',70,'TOTAL',0,1095.90,1190.50,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(29,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 550mm 766H5500S',70,'TOTAL',0,1149.90,1244.50,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(30,'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 650mm 766H6500S',70,'TOTAL',0,1311.00,1405.60,'2026-04-08 06:38:22','2026-04-08 06:38:22');
/*!40000 ALTER TABLE `correderas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correderas_por_componente`
--

DROP TABLE IF EXISTS `correderas_por_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `correderas_por_componente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `componente_id` bigint unsigned NOT NULL,
  `corredera_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `correderas_por_componente_componente_id_foreign` (`componente_id`),
  KEY `correderas_por_componente_corredera_id_foreign` (`corredera_id`),
  CONSTRAINT `correderas_por_componente_componente_id_foreign` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`),
  CONSTRAINT `correderas_por_componente_corredera_id_foreign` FOREIGN KEY (`corredera_id`) REFERENCES `correderas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correderas_por_componente`
--

LOCK TABLES `correderas_por_componente` WRITE;
/*!40000 ALTER TABLE `correderas_por_componente` DISABLE KEYS */;
/*!40000 ALTER TABLE `correderas_por_componente` ENABLE KEYS */;
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
INSERT INTO `cotizaciones` VALUES (1,2,'1988-01-28',613.86,'activa',NULL,'2026-04-08 06:38:22','2026-04-08 06:38:22');
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_cotizacions`
--

LOCK TABLES `detalle_cotizacions` WRITE;
/*!40000 ALTER TABLE `detalle_cotizacions` DISABLE KEYS */;
INSERT INTO `detalle_cotizacions` VALUES (1,1,'Eveniet et accusantium numquam voluptatem ipsum qui modi.',10,75.68,305.93,'2026-04-08 06:38:22','2026-04-08 06:38:22',3),(2,1,'Quaerat accusamus qui porro quis deleniti hic.',5,63.63,79.35,'2026-04-08 06:38:22','2026-04-08 06:38:22',4),(3,1,'Et sunt mollitia ut quia itaque.',9,66.63,898.31,'2026-04-08 06:38:22','2026-04-08 06:38:22',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estructura`
--

LOCK TABLES `estructura` WRITE;
/*!40000 ALTER TABLE `estructura` DISABLE KEYS */;
INSERT INTO `estructura` VALUES (1,'BCO FROSTY',800.00,NULL,NULL),(2,'ARAUCO LINO CAIRO',1200.00,NULL,NULL);
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
INSERT INTO `estructura_por_componente` VALUES (1,1,1,1,NULL,NULL),(2,1,2,2,NULL,NULL),(3,2,2,1,NULL,NULL),(4,3,1,2,NULL,NULL);
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
-- Table structure for table `fuentes_de_alimentacion`
--

DROP TABLE IF EXISTS `fuentes_de_alimentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fuentes_de_alimentacion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidades_por_metro` int NOT NULL DEFAULT '50',
  `porcentaje_utilizacion` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fuentes_de_alimentacion_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fuentes_de_alimentacion`
--

LOCK TABLES `fuentes_de_alimentacion` WRITE;
/*!40000 ALTER TABLE `fuentes_de_alimentacion` DISABLE KEYS */;
INSERT INTO `fuentes_de_alimentacion` VALUES (1,'F. ALIMENTACION',800.00,50,2.14,'2026-04-08 20:49:54','2026-04-08 20:49:54'),(2,'F. ALIMENTACION 12V',650.00,40,3.50,NULL,NULL),(3,'F. ALIMENTACION 24V',900.00,60,4.75,NULL,NULL);
/*!40000 ALTER TABLE `fuentes_de_alimentacion` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_12_04_204100_create_componentes_table',1),(5,'2025_12_04_204200_create_modulos_table',1),(6,'2025_12_17_205930_create_personal_access_tokens_table',1),(7,'2025_12_19_001705_table_cantidad_por_componente',1),(8,'2025_12_19_001907_table_accesorios_por_componente',1),(9,'2025_12_19_194148_create_clientes_table',1),(10,'2025_12_19_195413_create_cotizaciones_table',1),(11,'2025_12_19_195500_create_cotizacion_por_cliente_table',1),(12,'2025_12_19_204453_create_detalle_cotizacions_table',1),(13,'2025_12_19_213256_add_modulo_id_to_detalle_cotizacions_table',1),(14,'2025_12_19_213602_update_modulo_id_in_detalle_cotizacions',1),(15,'2025_12_19_213611_update_modulo_id_in_detalle_cotizacions',1),(16,'2026_01_14_052427_create_cantidad_por_componentes_table',1),(17,'2026_01_16_003158_add_estado_to_cotizaciones_table',1),(18,'2026_01_16_003809_update_cotizaciones_with_default_estado',1),(19,'2026_01_19_191045_create_componentes_por_cotizacion_table',1),(20,'2026_01_20_004118_add_modulo_id_to_componentes_por_cotizacion',1),(21,'2026_01_21_200023_update_cotizaciones_estado_enum',1),(22,'2026_01_22_005222_update_cotizaciones_estado_to_completada',1),(23,'2026_01_22_221604_make_clientes_email_nullable',1),(24,'2026_01_22_221616_make_clientes_email_nullable',1),(25,'2026_02_03_003215_create_estructura_table',1),(26,'2026_02_03_010744_create_acabado_tableros_table',1),(27,'2026_02_03_014708_create_acabado_cubre_cantos_table',1),(28,'2026_02_17_022755_create_correderas_table',1),(29,'2026_02_17_031825_create_table_compases_abatibles',1),(30,'2026_02_17_040843_create_table_puertas',1),(31,'2026_02_17_043102_create_table_gola',1),(32,'2026_02_22_000002_create_estructura_por_componente_table',1),(33,'2026_02_22_000004_create_acabado_cubre_canto_por_componente_table',1),(34,'2026_02_22_000005_create_acabado_tablero_por_componente_table',1),(35,'2026_02_22_000006_create_puertas_por_componente_table',1),(36,'2026_02_23_000007_create_gola_por_componente_table',1),(37,'2026_02_23_000008_add_precio_final_to_puertas_table',1),(38,'2026_02_23_000009_add_precio_unitario_to_componentes_table',1),(39,'2026_02_23_000010_create_accesorios_table',1),(40,'2026_02_23_000011_add_cantidad_to_accesorios_por_componente_table',1),(41,'2026_02_23_000012_add_rol_to_users_table',1),(42,'2026_03_30_000000_create_cliente_publico_en_general',1),(43,'2026_03_30_000001_create_capacidad_correderas_table',1),(44,'2026_03_30_000002_seed_capacidad_correderas',1),(45,'2026_03_30_000003_remove_costo_unitario_from_tables',1),(46,'2026_03_30_000004_create_cotizaciones_por_usuario_table',1),(47,'2026_03_30_000005_add_created_by_to_cotizaciones_table',1),(48,'2026_03_30_000006_backfill_created_by_user_id_cotizaciones',1),(49,'2026_03_30_000007_backfill_cotizaciones_por_usuario_from_created_by',1),(50,'2026_03_30_000008_seed_acabado_tableros_y_cubre_cantos',1),(51,'2026_03_30_000009_add_costo_unitario_to_acabado_tableros',1),(52,'2026_03_30_000010_add_costo_unitario_to_acabado_cubre_cantos',1),(53,'2026_03_30_000011_add_costo_unitario_to_estructura',1),(54,'2026_03_30_000012_create_correderas_y_compases_por_componente_tables',1),(55,'2026_04_08_002106_create_tira_leds_table',1),(57,'2026_04_08_142925_create_conectores_table',2),(58,'2026_04_08_144755_create_fuentes_de_alimentacion_table',3),(59,'2026_04_08_145412_create_perfil_aluminios_table',4),(60,'2026_04_08_150024_create_apagadores_table',5),(61,'2026_04_08_151146_create_whats_por_metro_table',6);
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
-- Table structure for table `perfil_aluminios`
--

DROP TABLE IF EXISTS `perfil_aluminios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfil_aluminios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `porcentaje_utilizacion` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perfil_aluminios_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_aluminios`
--

LOCK TABLES `perfil_aluminios` WRITE;
/*!40000 ALTER TABLE `perfil_aluminios` DISABLE KEYS */;
INSERT INTO `perfil_aluminios` VALUES (1,'PERFIL ALUMINIO EMPOTRADO',150.00,5.00,'2026-04-08 20:56:20','2026-04-08 20:56:20'),(2,'PERFIL ALUMINIO SUPERFICIE',120.00,4.50,NULL,NULL),(3,'PERFIL ALUMINIO ESQUINERO',180.00,6.00,NULL,NULL);
/*!40000 ALTER TABLE `perfil_aluminios` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',2,'api-token','bdbbfd03080e45c5c3a9b06531d11e45e2e5c422630b7bc595aff539b7077575','[\"*\"]','2026-04-08 06:45:18',NULL,'2026-04-08 06:40:48','2026-04-08 06:45:18'),(2,'App\\Models\\User',2,'api-token','45a6f2e473cb90f6e2a59ca4929ac26f668202f2cb769add9330f15d1d847f67','[\"*\"]',NULL,NULL,'2026-04-08 07:06:00','2026-04-08 07:06:00'),(3,'App\\Models\\User',2,'api-token','1878c3783e986789d9871959876cb4e95d2b9433ea9b915f30ebe2419db656ee','[\"*\"]',NULL,NULL,'2026-04-08 07:07:30','2026-04-08 07:07:30'),(4,'App\\Models\\User',2,'api-token','b662bfe3f474f800a5072583dcb61c0e89bf9ad796f3a3442bbc8453d5f0f8f0','[\"*\"]',NULL,NULL,'2026-04-08 07:09:15','2026-04-08 07:09:15'),(5,'App\\Models\\User',2,'api-token','6a804881ebe895bb9ccbdd960978f46beb7807d3b0454265de506b75bdf299e1','[\"*\"]',NULL,NULL,'2026-04-08 07:09:16','2026-04-08 07:09:16'),(6,'App\\Models\\User',2,'api-token','62f568e1797dbf5b39790108d9c2ed9ccb5afc142e47ff10f9a3583327f9b19e','[\"*\"]','2026-04-08 07:10:47',NULL,'2026-04-08 07:10:43','2026-04-08 07:10:47'),(7,'App\\Models\\User',2,'api-token','005f9c5d52bced1564e43a6d2056876d5e2d003fdcbfd88e99ce84672a69207e','[\"*\"]',NULL,NULL,'2026-04-08 07:10:56','2026-04-08 07:10:56'),(8,'App\\Models\\User',2,'api-token','9afd93a11603b5fffe19b102b44d556d62a511ab403f40a127f467ea73ac2509','[\"*\"]',NULL,NULL,'2026-04-08 07:11:22','2026-04-08 07:11:22'),(9,'App\\Models\\User',2,'api-token','a6c843287d32962f81692b2f2c6872da9c2f3deee130f86cff782f000207e0f0','[\"*\"]',NULL,NULL,'2026-04-08 07:12:33','2026-04-08 07:12:33'),(10,'App\\Models\\User',2,'api-token','6247a3111cf7cbd90f72f31e8f5394b6d7969a11fb437823d79f6587bbd261fd','[\"*\"]',NULL,NULL,'2026-04-08 07:12:34','2026-04-08 07:12:34'),(11,'App\\Models\\User',2,'api-token','3cc510432ee720ed6da09dbf98498c47c1531a90bb474b363bd9fc7c2f4d1086','[\"*\"]',NULL,NULL,'2026-04-08 07:12:35','2026-04-08 07:12:35'),(12,'App\\Models\\User',2,'api-token','270437f419f52cda65ab606e3fb384e74a719006839f46b7db33a3c42a00b312','[\"*\"]',NULL,NULL,'2026-04-08 07:12:36','2026-04-08 07:12:36'),(13,'App\\Models\\User',2,'api-token','b56d88ff7c7126d0ef19cc7b76075c898825ac1e77611b3dfa3b2e507e8cb043','[\"*\"]',NULL,NULL,'2026-04-08 07:13:38','2026-04-08 07:13:38'),(14,'App\\Models\\User',2,'api-token','9541ec68d2fa1b979ac958ae4fee17bd6a38aafb5144c05c33c3605b04e4a69d','[\"*\"]','2026-04-08 08:19:30',NULL,'2026-04-08 08:19:24','2026-04-08 08:19:30'),(15,'App\\Models\\User',2,'api-token','f3938a8e74e2d9c9dcfbd641c55b82349a179aae80858615895a3c388004c01c','[\"*\"]',NULL,NULL,'2026-04-08 10:09:41','2026-04-08 10:09:41'),(16,'App\\Models\\User',2,'api-token','f1a7cf655548ddfaaa9fc535ddd75f83e4aac0a87d22ee6218b57e84c1be5c89','[\"*\"]','2026-04-08 10:10:42',NULL,'2026-04-08 10:10:04','2026-04-08 10:10:42'),(17,'App\\Models\\User',2,'api-token','17972708004134dade0f0c4b903ae70b31313694fd4e6a4bb32bbe6e31b0f7de','[\"*\"]',NULL,NULL,'2026-04-08 10:11:05','2026-04-08 10:11:05'),(18,'App\\Models\\User',2,'api-token','cbfd662c7788bcd28d8889562aa2d7f6b81f86d9000e27f880a1affa490d9f9f','[\"*\"]',NULL,NULL,'2026-04-08 10:11:38','2026-04-08 10:11:38'),(19,'App\\Models\\User',2,'api-token','c5cfe5a7af3789edb9becb1f2cc1dd1bf65132d5633620e24a9c9753c7c88d90','[\"*\"]',NULL,NULL,'2026-04-08 10:11:42','2026-04-08 10:11:42'),(20,'App\\Models\\User',2,'api-token','4877f34efd5cb97f63a63e24dfdad3dcb464f3e8d5029eb480228fe61e05b616','[\"*\"]','2026-04-08 10:12:21',NULL,'2026-04-08 10:11:43','2026-04-08 10:12:21'),(21,'App\\Models\\User',5,'api-token','09469add24c7961557e84601452094f1f369b5786927655f864ae01789aa2ba3','[\"*\"]','2026-04-08 10:17:30',NULL,'2026-04-08 10:13:37','2026-04-08 10:17:30'),(22,'App\\Models\\User',2,'api-token','fcd9f6413ef2e6537648bd38b9d9bf91a17a6c54e29e40fa61469db6b3f88f6e','[\"*\"]','2026-04-08 10:18:25',NULL,'2026-04-08 10:17:48','2026-04-08 10:18:25'),(23,'App\\Models\\User',2,'api-token','b45e2dfa6d3222ef166f72d68f14e82720d1ea58f960b9f0ea3739ac6e43e2b7','[\"*\"]',NULL,NULL,'2026-04-08 10:20:29','2026-04-08 10:20:29'),(24,'App\\Models\\User',2,'api-token','93c5157c8382ec4bbb12404053887845d1ba2e4f7bff4a687690151affbfec86','[\"*\"]',NULL,NULL,'2026-04-08 10:20:58','2026-04-08 10:20:58'),(25,'App\\Models\\User',2,'api-token','3e52053a30bf55824d0ff358df5f9b1405ac84b02200386a608cb4d05cf877a4','[\"*\"]',NULL,NULL,'2026-04-08 10:21:01','2026-04-08 10:21:01'),(26,'App\\Models\\User',2,'api-token','163d12fc2b11f574890089595a2a654a766235e0cad2523f8f152ad9d9724203','[\"*\"]','2026-04-08 10:21:34',NULL,'2026-04-08 10:21:03','2026-04-08 10:21:34'),(27,'App\\Models\\User',2,'api-token','9dca7e6df3984e37a2b03e192249bf3e2164a0b178b5e8fde55208a980b38570','[\"*\"]','2026-04-08 10:36:33',NULL,'2026-04-08 10:23:29','2026-04-08 10:36:33'),(28,'App\\Models\\User',2,'api-token','696917e37154a9cdfc66c7cd91147609a1a399b56a5acbb4e7368c7d09a6911b','[\"*\"]','2026-04-09 07:10:58',NULL,'2026-04-08 10:28:12','2026-04-09 07:10:58'),(29,'App\\Models\\User',2,'api-token','c4ff5c62f1c4194decaa794f83ab576a67f278ea02fed22c8b01cae5a424e216','[\"*\"]',NULL,NULL,'2026-04-08 20:38:56','2026-04-08 20:38:56'),(30,'App\\Models\\User',2,'api-token','480ddc1b57ebea2d5a9466ab0f1e13ade64e1083ccf8dc7b6a5ae3b0e37e41e8','[\"*\"]','2026-04-08 22:03:40',NULL,'2026-04-08 21:41:33','2026-04-08 22:03:40'),(31,'App\\Models\\User',2,'api-token','7c2ff1917cbb05686692b51c61c5ff02231da37a0af9594adcac3889d4abcf25','[\"*\"]',NULL,NULL,'2026-04-09 05:19:59','2026-04-09 05:19:59'),(32,'App\\Models\\User',2,'api-token','bea3d2d0ea5fc7a8ee527e9f7881b3991b5b50222183bb38330031fc69408f11','[\"*\"]','2026-04-10 10:06:15',NULL,'2026-04-10 10:06:08','2026-04-10 10:06:15');
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
INSERT INTO `puertas` VALUES (1,'Puerta Cristal Standard',793.00,50.00,80.00,1400.00,2323.00,2.40,0.60,'2026-04-08 06:38:22','2026-04-08 06:38:22');
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
INSERT INTO `sessions` VALUES ('bbeSbzmiwScN7DTEiJLk1AHh4wDqE4QS1G6tejxi',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFZISHBQdmxOZThXZnFjZnh4SEZtWWIzTHZSSHk4TFVkN2xtbFNrVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvY29tcG9uZW50ZXMtcG9yLWNvdGl6YWNpb24iO3M6NToicm91dGUiO3M6MzI6ImNvbXBvbmVudGVzLXBvci1jb3RpemFjaW9uLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775697058),('cPOqyIRvBL8Pz2T90Z4BR4vp1RgSdEQSeDxWMgQu',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3VDcFlickFVSWx0M2Z2ZndJZ0MzMWRwVFBWWEhGQU1mQnFIbk5CWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvY29tcG9uZW50ZXMtcG9yLWNvdGl6YWNpb24iO3M6NToicm91dGUiO3M6MzI6ImNvbXBvbmVudGVzLXBvci1jb3RpemFjaW9uLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775676141),('RBv2vvd0IdeHmlxtTJ6FdAyluxnZDnfZ2fhJKkT5',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0VUR0NxMEdCamRqSHVud0pWMEl3MFJocnFzdnpUOWgwUTdDMDBHciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvYWNhYmFkby10YWJsZXJvcyI7czo1OiJyb3V0ZSI7czoyMjoiYWNhYmFkby10YWJsZXJvcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1775793975);
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
-- Table structure for table `tira_leds`
--

DROP TABLE IF EXISTS `tira_leds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tira_leds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio_unitario` decimal(10,2) NOT NULL,
  `unidades_por_metro` int DEFAULT NULL,
  `porcentaje_utilizacion` decimal(5,3) DEFAULT NULL,
  `cantidad_compra` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tira_leds_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tira_leds`
--

LOCK TABLES `tira_leds` WRITE;
/*!40000 ALTER TABLE `tira_leds` DISABLE KEYS */;
INSERT INTO `tira_leds` VALUES (1,'Tira LED RGBW','TIRA_LED_261','Voluptatem non molestiae porro modi dolor quis.',30.00,6,3.408,5,'2026-04-08 06:38:22','2026-04-08 10:36:33'),(2,'Tira LED Cálida 5m','TIRA_LED_495','Dolores laboriosam quis accusamus et asperiores animi.',80.14,3,2.757,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,'Tira LED Blanca 15m','TIRA_LED_120','Ea est quibusdam nihil est qui.',88.05,3,3.849,4,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,'Tira LED RGB 15m','TIRA_LED_156','Et quos quibusdam error nesciunt iusto.',61.49,5,4.372,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,'Tira LED Cálida 15m','TIRA_LED_175','Accusamus ab suscipit ea sit.',94.94,4,4.942,5,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(6,'Tira LED','TIRA_LED_001','Tira LED para componentes de muebles',600.00,5,3.052,4,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(7,'Tira LED RGB 5m','TIRA_LED_RGB_5M','Tira LED RGB de 5 metros con control remoto',25.99,3,2.500,2,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(8,'Tira LED RGBW 10m','TIRA_LED_RGBW_10M','Tira LED RGBW de 10 metros con control remoto',45.99,4,3.500,3,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(9,'Tira LED Blanca Cálida 5m','TIRA_LED_CAL_5M','Tira LED blanca cálida de 5 metros',15.99,5,2.000,1,'2026-04-08 06:38:22','2026-04-08 06:38:22');
/*!40000 ALTER TABLE `tira_leds` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','desarrollador','2026-04-08 06:38:21','$2y$12$zxez/CNUsPxWhtV1QACm/.nt8bnV3uvZ/HWJwgyfckDg96Qz52xtK','LjFKEWg1YZ','2026-04-08 06:38:22','2026-04-08 06:38:22'),(2,'Administrador','admin@cotizador.local','admin',NULL,'$2y$12$etzAN0Ls5KhOgV7WXiBosuwhvCC7V20zuZIIjJluKpDVhqySDxsDa',NULL,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(3,'Vendedor','vendedor@cotizador.local','vendedor',NULL,'$2y$12$Xf/ZfI71AJnaEygvspiqVu5wP9eF0YmxvORo2oAlJluc9y.x7kbZW',NULL,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(4,'Desarrollador','dev@cotizador.local','desarrollador',NULL,'$2y$12$Z0F024q/6X5HD/cIZ6/kvOvhuF5TmVbCP9gxm8wOYuS.RCZmnRxDS',NULL,'2026-04-08 06:38:22','2026-04-08 06:38:22'),(5,'Admin','admin@example.com','vendedor',NULL,'$2y$12$g7V5tfdjIZt63Jhs6W4fzu7MZFbHBlBeV22yHFx2pd1LWv4.rHU/O',NULL,'2026-04-08 10:13:36','2026-04-08 10:13:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whats_por_metro`
--

DROP TABLE IF EXISTS `whats_por_metro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whats_por_metro` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidades_por_metro` int NOT NULL DEFAULT '7',
  `porcentaje_utilizacion` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `whats_por_metro_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whats_por_metro`
--

LOCK TABLES `whats_por_metro` WRITE;
/*!40000 ALTER TABLE `whats_por_metro` DISABLE KEYS */;
INSERT INTO `whats_por_metro` VALUES (1,'W X METRO',107.00,7,5.00,'2026-04-08 21:14:12','2026-04-08 21:14:12'),(2,'WATTS LED 5W',95.00,5,4.50,NULL,NULL),(3,'WATTS LED 10W',125.00,10,6.00,NULL,NULL);
/*!40000 ALTER TABLE `whats_por_metro` ENABLE KEYS */;
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

-- Dump completed on 2026-04-09 22:08:11
