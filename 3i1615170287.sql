-- MySQL dump 10.13  Distrib 8.0.23, for osx10.15 (x86_64)
--
-- Host: us-cdbr-east-02.cleardb.com    Database: heroku_4bfb6785b61d3a4
-- ------------------------------------------------------
-- Server version	5.5.62-log

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

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','admin@example.com','$2y$10$6w6pHq4TnX9/ZJbgexAWOOGeqbLPN2xYxHfeX1CeVhN8Sp40hpZLu','XmyiI69OiO10tdvnXPDyfuq46gwpTweKHJSgljPp9oBVJdwUwGcpe1QV4CGB',NULL,NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `post_code` varchar(191) DEFAULT NULL,
  `address1` varchar(191) DEFAULT NULL,
  `address2` varchar(191) DEFAULT NULL,
  `address3` varchar(191) DEFAULT NULL,
  `person_firstname` varchar(191) DEFAULT NULL,
  `person_lastname` varchar(191) DEFAULT NULL,
  `firstname_kana` varchar(191) DEFAULT NULL,
  `lastname_kana` varchar(191) DEFAULT NULL,
  `person_mobile` varchar(191) DEFAULT NULL,
  `person_tel` varchar(191) DEFAULT NULL,
  `fax` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `cost` int(11) NOT NULL,
  `payment_limit` int(11) NOT NULL,
  `payment_day` text,
  `payment_remark` text,
  `site` varchar(191) DEFAULT NULL,
  `site_url` varchar(191) DEFAULT NULL,
  `login` varchar(191) DEFAULT NULL,
  `site_id` varchar(191) DEFAULT NULL,
  `site_pass` varchar(191) DEFAULT NULL,
  `agent_remark` text,
  `site_remark` text,
  `deal_remark` text,
  `cxl` int(11) DEFAULT NULL,
  `cxl_url` varchar(191) DEFAULT NULL,
  `cxl_remark` text,
  `last_remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (1,'スペースマーケット','株式ホゲ',NULL,NULL,NULL,NULL,'丸岡','麻衣','マルオカ','マイ',NULL,'0612345678','0612345678',NULL,70,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2021-03-08 11:12:01','2021-03-08 11:12:28');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint(20) unsigned NOT NULL,
  `venue_price` int(11) NOT NULL,
  `equipment_price` int(11) NOT NULL,
  `layout_price` int(11) NOT NULL,
  `others_price` int(11) NOT NULL,
  `master_subtotal` int(11) NOT NULL,
  `master_tax` int(11) NOT NULL,
  `master_total` int(11) NOT NULL,
  `payment_limit` date NOT NULL,
  `bill_company` varchar(191) NOT NULL,
  `bill_person` varchar(191) NOT NULL,
  `bill_created_at` date NOT NULL,
  `bill_remark` text,
  `paid` int(11) NOT NULL,
  `pay_day` date DEFAULT NULL,
  `pay_person` varchar(191) DEFAULT NULL,
  `payment` int(11) DEFAULT NULL,
  `reservation_status` int(11) NOT NULL,
  `double_check_status` int(11) NOT NULL,
  `double_check1_name` varchar(191) DEFAULT NULL,
  `double_check2_name` varchar(191) DEFAULT NULL,
  `approve_send_at` datetime DEFAULT NULL,
  `category` varchar(191) NOT NULL,
  `admin_judge` varchar(191) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_reservation_id_index` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakdowns`
--

DROP TABLE IF EXISTS `breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `breakdowns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) unsigned NOT NULL,
  `unit_item` varchar(191) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `unit_count` varchar(191) NOT NULL,
  `unit_subtotal` int(11) NOT NULL,
  `unit_type` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breakdowns_bill_id_index` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdowns`
--

LOCK TABLES `breakdowns` WRITE;
/*!40000 ALTER TABLE `breakdowns` DISABLE KEYS */;
/*!40000 ALTER TABLE `breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date_venue`
--

DROP TABLE IF EXISTS `date_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `date_venue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `date_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_venue_venue_id_date_id_unique` (`venue_id`,`date_id`),
  KEY `date_venue_venue_id_index` (`venue_id`),
  KEY `date_venue_date_id_index` (`date_id`),
  CONSTRAINT `date_venue_date_id_foreign` FOREIGN KEY (`date_id`) REFERENCES `dates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `date_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date_venue`
--

LOCK TABLES `date_venue` WRITE;
/*!40000 ALTER TABLE `date_venue` DISABLE KEYS */;
/*!40000 ALTER TABLE `date_venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dates`
--

DROP TABLE IF EXISTS `dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `week_day` int(11) NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dates_venue_id_foreign` (`venue_id`),
  CONSTRAINT `dates_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=491 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dates`
--

LOCK TABLES `dates` WRITE;
/*!40000 ALTER TABLE `dates` DISABLE KEYS */;
INSERT INTO `dates` VALUES (1,1,1,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(11,1,2,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(21,1,3,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(31,1,4,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(41,1,5,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(51,1,6,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(61,1,7,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(71,11,1,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(81,11,2,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(91,11,3,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(101,11,4,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(111,11,5,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(121,11,6,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(131,11,7,'08:00:00','23:00:00','2021-03-05 18:52:45','2021-03-05 18:52:45'),(141,21,1,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(151,21,2,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(161,21,3,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(171,21,4,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(181,21,5,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(191,21,6,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(201,21,7,'08:00:00','23:00:00','2021-03-05 18:52:46','2021-03-05 18:52:46'),(211,31,1,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(221,31,2,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(231,31,3,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(241,31,4,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(251,31,5,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(261,31,6,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(271,31,7,'08:00:00','23:00:00','2021-03-05 18:53:18','2021-03-05 18:53:18'),(281,41,1,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(291,41,2,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(301,41,3,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(311,41,4,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(321,41,5,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(331,41,6,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(341,41,7,'08:00:00','23:00:00','2021-03-05 18:57:12','2021-03-05 18:57:12'),(351,51,1,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(361,51,2,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(371,51,3,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(381,51,4,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(391,51,5,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(401,51,6,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(411,51,7,'08:00:00','23:00:00','2021-03-05 20:13:06','2021-03-05 20:13:06'),(421,61,1,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(431,61,2,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(441,61,3,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(451,61,4,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(461,61,5,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(471,61,6,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50'),(481,61,7,'08:00:00','23:00:00','2021-03-08 00:37:50','2021-03-08 00:37:50');
/*!40000 ALTER TABLE `dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endusers`
--

DROP TABLE IF EXISTS `endusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endusers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reservation_id` int(10) unsigned NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `person` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `attr` varchar(191) DEFAULT NULL,
  `charge` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `endusers_reservation_id_index` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endusers`
--

LOCK TABLES `endusers` WRITE;
/*!40000 ALTER TABLE `endusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `endusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_venue`
--

DROP TABLE IF EXISTS `equipment_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_venue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `equipment_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipment_venue_venue_id_equipment_id_unique` (`venue_id`,`equipment_id`),
  KEY `equipment_venue_venue_id_index` (`venue_id`),
  KEY `equipment_venue_equipment_id_index` (`equipment_id`),
  CONSTRAINT `equipment_venue_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `equipment_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_venue`
--

LOCK TABLES `equipment_venue` WRITE;
/*!40000 ALTER TABLE `equipment_venue` DISABLE KEYS */;
INSERT INTO `equipment_venue` VALUES (1,51,41,'2021-03-05 20:13:06','2021-03-05 20:13:06'),(11,61,21,'2021-03-08 00:37:50','2021-03-08 00:37:50'),(21,61,31,'2021-03-08 00:37:50','2021-03-08 00:37:50'),(31,61,41,'2021-03-08 00:37:50','2021-03-08 00:37:50');
/*!40000 ALTER TABLE `equipment_venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipments`
--

DROP TABLE IF EXISTS `equipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(191) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
INSERT INTO `equipments` VALUES (11,'無線マイク',3000,10,'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト',NULL,'2021-03-06 20:16:33'),(21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,10,NULL,NULL,NULL),(31,'【追加】次亜塩素酸水専用・超音波加湿器',500,10,NULL,NULL,NULL),(41,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,10,NULL,NULL,NULL),(51,'ホワイトボード（幅120㎝）',2500,10,NULL,NULL,NULL),(61,'プロジェクター',3000,10,NULL,NULL,NULL),(71,'既存パーテーションの移動',2000,10,NULL,NULL,NULL),(81,'レーザーポインター',1000,10,NULL,NULL,NULL),(91,'iphone(Lightning)⇔VGA変換ケーブル',1000,10,NULL,NULL,NULL),(101,'iphone(Lightning)DVDプレイヤー',2000,10,NULL,NULL,NULL),(111,'CDプレイヤー',1000,10,NULL,NULL,NULL),(131,'卓球台セット',1000,10,NULL,NULL,NULL),(141,'ホワイトボード（追加）',1000,1,'サンワールド・近商・カーニープレイス・日興B2F・キューホーで対応可能','2021-03-06 11:15:01','2021-03-06 11:15:01'),(161,'備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト備品名テスト',0,12,'入力テスト','2021-03-06 11:19:06','2021-03-06 11:19:06'),(171,'DVDプレイヤー',1000,1,'プロジェクターと接続\r\nするための音声端子・映像端子付属','2021-03-06 11:20:33','2021-03-06 11:20:33'),(181,'ホワイトボードスーパー',3000,99,'全会議室利用','2021-03-06 20:14:06','2021-03-06 20:14:06'),(191,'テスト1',1000,1,NULL,'2021-03-07 11:43:21','2021-03-07 11:43:21'),(201,'テスト２',1001,1,NULL,'2021-03-07 11:43:33','2021-03-07 11:43:33'),(211,'テスト３',1003,1,NULL,'2021-03-07 11:43:48','2021-03-07 11:43:48'),(221,'テスト4',1004,0,NULL,'2021-03-07 11:44:07','2021-03-07 11:44:07'),(231,'テスト⑤',1005,999,NULL,'2021-03-07 11:44:46','2021-03-07 11:44:46'),(241,'テスト6',1,1,NULL,'2021-03-07 11:45:39','2021-03-07 11:45:39'),(251,'テスト7',99999,9999,NULL,'2021-03-07 11:46:10','2021-03-07 11:46:10'),(261,'テスト7',999999,999999,NULL,'2021-03-07 11:46:34','2021-03-07 11:46:34'),(271,'テスト8',1008,1,NULL,'2021-03-07 11:46:59','2021-03-07 11:46:59'),(281,'テスト6',0,0,NULL,'2021-03-07 11:47:19','2021-03-07 11:47:19'),(291,'テスト6',0,0,NULL,'2021-03-07 11:47:30','2021-03-07 11:47:30'),(301,'テスト6',0,0,NULL,'2021-03-07 11:47:36','2021-03-07 11:47:36'),(311,'テスト6',0,0,NULL,'2021-03-07 11:47:42','2021-03-07 11:47:42'),(321,'テスト7',0,0,NULL,'2021-03-07 11:56:46','2021-03-07 11:56:46');
/*!40000 ALTER TABLE `equipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frame_prices`
--

DROP TABLE IF EXISTS `frame_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `frame_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `frame` varchar(191) NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `price` int(11) NOT NULL,
  `extend` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_prices_venue_id_index` (`venue_id`),
  CONSTRAINT `frame_prices_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=381 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_prices`
--

LOCK TABLES `frame_prices` WRITE;
/*!40000 ALTER TABLE `frame_prices` DISABLE KEYS */;
INSERT INTO `frame_prices` VALUES (61,11,'午前','10:00:00','12:00:00',17000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(71,11,'午後','13:00:00','17:00:00',36000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(81,11,'夜間','18:00:00','23:00:00',17000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(91,11,'午前＆午後','10:00:00','17:00:00',42000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(101,11,'午後＆夜間','13:00:00','21:00:00',42000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(111,11,'終日','10:00:00','21:00:00',50000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(121,21,'午前','10:00:00','12:00:00',17000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(131,21,'午後','13:00:00','17:00:00',36000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(141,21,'夜間','18:00:00','23:00:00',17000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(151,21,'午前＆午後','10:00:00','17:00:00',42000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(161,21,'午後＆夜間','13:00:00','21:00:00',42000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(171,21,'終日','10:00:00','21:00:00',50000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(321,1,'午前','10:00:00','12:00:00',15000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43'),(331,1,'午後','13:00:00','17:00:00',30000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43'),(341,1,'夜間','18:00:00','23:00:00',15000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43'),(351,1,'午前＆午後','10:00:00','17:00:00',36000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43'),(361,1,'午後＆夜間','13:00:00','21:00:00',36000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43'),(371,1,'終日','10:00:00','21:00:00',42000,5000,'2021-03-05 19:10:43','2021-03-05 19:10:43');
/*!40000 ALTER TABLE `frame_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12961 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (12701,'2014_10_12_000000_create_users_table',1),(12711,'2014_10_12_100000_create_password_resets_table',1),(12721,'2019_08_19_000000_create_failed_jobs_table',1),(12731,'2020_02_01_090636_create_admins_table',1),(12741,'2020_09_18_090242_create_venues_table',1),(12751,'2020_09_20_044412_create_equipments_table',1),(12761,'2020_09_20_065837_create_venue_equipment_table',1),(12771,'2020_09_22_094627_create_services_table',1),(12781,'2020_09_24_064549_create_dates_table',1),(12791,'2020_09_24_072535_create_service_venue_table',1),(12801,'2020_09_24_100404_create_date_venue_table',1),(12811,'2020_09_29_055630_create_frame_prices_table',1),(12821,'2020_10_01_062150_create_time_prices_table',1),(12831,'2020_10_07_145320_create_email_verification_table',1),(12841,'2020_10_08_104339_create_agents_table',1),(12851,'2020_10_12_132928_create_preusers_table',1),(12861,'2020_10_19_163736_create_reservations_table',1),(12871,'2020_12_23_174247_create_bills_table',1),(12881,'2020_12_23_182424_create_breakdowns_table',1),(12891,'2021_02_08_153525_create_endusers_table',1),(12901,'2021_02_15_134342_create_pre_reservations_table',1),(12911,'2021_02_15_134831_create_pre_bills_table',1),(12921,'2021_02_15_135246_create_pre_breakdowns_table',1),(12931,'2021_02_15_140439_create_unknown_users_table',1),(12941,'2021_02_17_163902_create_multiple_reserves_table',1),(12951,'2021_02_23_122139_create_pre_endusers_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiple_reserves`
--

DROP TABLE IF EXISTS `multiple_reserves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multiple_reserves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_reserves`
--

LOCK TABLES `multiple_reserves` WRITE;
/*!40000 ALTER TABLE `multiple_reserves` DISABLE KEYS */;
INSERT INTO `multiple_reserves` VALUES (1,'2021-03-06 16:26:39','2021-03-06 16:26:39'),(11,'2021-03-08 11:14:54','2021-03-08 11:14:54'),(21,'2021-03-08 11:15:57','2021-03-08 11:15:57');
/*!40000 ALTER TABLE `multiple_reserves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_bills`
--

DROP TABLE IF EXISTS `pre_bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pre_bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pre_reservation_id` bigint(20) unsigned NOT NULL,
  `venue_price` int(11) NOT NULL,
  `equipment_price` int(11) NOT NULL,
  `layout_price` int(11) NOT NULL,
  `others_price` int(11) NOT NULL,
  `master_subtotal` int(11) NOT NULL,
  `master_tax` int(11) NOT NULL,
  `master_total` int(11) NOT NULL,
  `reservation_status` int(11) NOT NULL,
  `approve_send_at` datetime DEFAULT NULL,
  `category` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_bills_pre_reservation_id_index` (`pre_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_bills`
--

LOCK TABLES `pre_bills` WRITE;
/*!40000 ALTER TABLE `pre_bills` DISABLE KEYS */;
INSERT INTO `pre_bills` VALUES (11,31,36000,0,0,0,36000,3600,39600,0,NULL,1,'2021-03-08 11:06:11','2021-03-08 11:06:11'),(21,41,30000,0,0,0,30000,3000,33000,0,NULL,1,'2021-03-08 11:10:18','2021-03-08 11:10:18');
/*!40000 ALTER TABLE `pre_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_breakdowns`
--

DROP TABLE IF EXISTS `pre_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pre_breakdowns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pre_bill_id` bigint(20) unsigned NOT NULL,
  `unit_item` varchar(191) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `unit_count` varchar(191) NOT NULL,
  `unit_subtotal` int(11) NOT NULL,
  `unit_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_breakdowns_pre_bill_id_index` (`pre_bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_breakdowns`
--

LOCK TABLES `pre_breakdowns` WRITE;
/*!40000 ALTER TABLE `pre_breakdowns` DISABLE KEYS */;
INSERT INTO `pre_breakdowns` VALUES (21,11,'会場料金',36000,'3.5',36000,1,'2021-03-08 11:06:11','2021-03-08 11:06:11'),(31,21,'会場料金',30000,'3.5',30000,1,'2021-03-08 11:10:18','2021-03-08 11:10:18');
/*!40000 ALTER TABLE `pre_breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_endusers`
--

DROP TABLE IF EXISTS `pre_endusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pre_endusers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pre_reservations_id` int(10) unsigned NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `person` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_endusers_pre_reservations_id_index` (`pre_reservations_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_endusers`
--

LOCK TABLES `pre_endusers` WRITE;
/*!40000 ALTER TABLE `pre_endusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `pre_endusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_reservations`
--

DROP TABLE IF EXISTS `pre_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pre_reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `multiple_reserve_id` bigint(20) unsigned NOT NULL,
  `venue_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `agent_id` bigint(20) unsigned NOT NULL,
  `reserve_date` date NOT NULL,
  `price_system` int(11) DEFAULT NULL,
  `enter_time` time NOT NULL,
  `leave_time` time NOT NULL,
  `board_flag` int(11) DEFAULT NULL,
  `event_start` time DEFAULT NULL,
  `event_finish` time DEFAULT NULL,
  `event_name1` varchar(191) DEFAULT NULL,
  `event_name2` varchar(191) DEFAULT NULL,
  `event_owner` varchar(191) DEFAULT NULL,
  `luggage_count` varchar(191) DEFAULT NULL,
  `luggage_arrive` varchar(191) DEFAULT NULL,
  `luggage_return` varchar(191) DEFAULT NULL,
  `email_flag` int(11) DEFAULT NULL,
  `in_charge` varchar(191) DEFAULT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `discount_condition` text,
  `attention` text,
  `user_details` text,
  `admin_details` text,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_reservations_multiple_reserve_id_index` (`multiple_reserve_id`),
  KEY `pre_reservations_venue_id_index` (`venue_id`),
  KEY `pre_reservations_user_id_index` (`user_id`),
  KEY `pre_reservations_agent_id_index` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_reservations`
--

LOCK TABLES `pre_reservations` WRITE;
/*!40000 ALTER TABLE `pre_reservations` DISABLE KEYS */;
INSERT INTO `pre_reservations` VALUES (31,0,1,1,0,'2021-03-18',1,'15:30:00','19:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'山田太郎','09044906001',NULL,NULL,NULL,NULL,0,'2021-03-08 11:06:10','2021-03-08 11:06:10'),(41,0,1,999,0,'2021-03-24',1,'13:30:00','17:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'山田太郎','09044906001',NULL,NULL,NULL,NULL,0,'2021-03-08 11:10:18','2021-03-08 11:10:18'),(61,11,31,1,0,'2021-03-30',NULL,'12:00:00','13:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:14:54','2021-03-08 11:14:54'),(71,11,1,1,0,'2021-03-30',NULL,'15:30:00','18:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:14:54','2021-03-08 11:14:54'),(81,11,1,1,0,'2021-04-23',NULL,'13:00:00','13:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:14:54','2021-03-08 11:14:54'),(91,21,1,1,0,'2021-03-25',NULL,'13:30:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:15:57','2021-03-08 11:15:57'),(101,21,1,1,0,'2021-04-16',NULL,'10:00:00','18:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:15:57','2021-03-08 11:15:57'),(111,21,1,1,0,'2021-05-12',NULL,'09:00:00','20:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 11:15:57','2021-03-08 11:15:57');
/*!40000 ALTER TABLE `pre_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preusers`
--

DROP TABLE IF EXISTS `preusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preusers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `token` varchar(250) NOT NULL COMMENT '確認トークン',
  `expiration_datetime` datetime NOT NULL COMMENT '有効期限',
  `status` int(11) DEFAULT NULL COMMENT '認証確認',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preusers`
--

LOCK TABLES `preusers` WRITE;
/*!40000 ALTER TABLE `preusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `preusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `agent_id` bigint(20) unsigned NOT NULL,
  `reserve_date` date NOT NULL,
  `price_system` int(11) NOT NULL,
  `enter_time` time NOT NULL,
  `leave_time` time NOT NULL,
  `board_flag` int(11) NOT NULL,
  `event_start` time DEFAULT NULL,
  `event_finish` time DEFAULT NULL,
  `event_name1` varchar(191) DEFAULT NULL,
  `event_name2` varchar(191) DEFAULT NULL,
  `event_owner` varchar(191) DEFAULT NULL,
  `luggage_count` varchar(191) DEFAULT NULL,
  `luggage_arrive` varchar(191) DEFAULT NULL,
  `luggage_return` varchar(191) DEFAULT NULL,
  `email_flag` int(11) NOT NULL,
  `in_charge` varchar(191) NOT NULL,
  `tel` varchar(191) NOT NULL,
  `cost` int(11) NOT NULL,
  `discount_condition` text,
  `attention` text,
  `user_details` text,
  `admin_details` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_venue_id_index` (`venue_id`),
  KEY `reservations_user_id_index` (`user_id`),
  KEY `reservations_agent_id_index` (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_venue`
--

DROP TABLE IF EXISTS `service_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_venue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_venue_venue_id_service_id_unique` (`venue_id`,`service_id`),
  KEY `service_venue_venue_id_index` (`venue_id`),
  KEY `service_venue_service_id_index` (`service_id`),
  CONSTRAINT `service_venue_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_venue`
--

LOCK TABLES `service_venue` WRITE;
/*!40000 ALTER TABLE `service_venue` DISABLE KEYS */;
INSERT INTO `service_venue` VALUES (1,51,21,'2021-03-05 20:13:06','2021-03-05 20:13:06'),(11,61,11,'2021-03-08 00:37:50','2021-03-08 00:37:50'),(21,61,21,'2021-03-08 00:37:50','2021-03-08 00:37:50'),(31,61,31,'2021-03-08 00:37:50','2021-03-08 00:37:50');
/*!40000 ALTER TABLE `service_venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(191) NOT NULL,
  `price` int(11) NOT NULL,
  `remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_item_unique` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'領収書発行',200,NULL,NULL,NULL),(11,'鍵レンタル',500,NULL,NULL,NULL),(21,'プロジェクター設置',2000,NULL,NULL,NULL),(31,'DVDプレイヤー設置',2000,NULL,NULL,NULL),(41,'hhh',3000,NULL,'2021-03-05 20:51:29','2021-03-05 20:51:29'),(71,'印刷代行',500,'基本料金500円税抜+白黒5円/枚、カラー30円/枚','2021-03-07 11:59:39','2021-03-07 11:59:39'),(91,'宿泊手配',10000,NULL,'2021-03-07 12:05:21','2021-03-07 12:05:21');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_prices`
--

DROP TABLE IF EXISTS `time_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` bigint(20) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `extend` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_prices_venue_id_index` (`venue_id`),
  CONSTRAINT `time_prices_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_prices`
--

LOCK TABLES `time_prices` WRITE;
/*!40000 ALTER TABLE `time_prices` DISABLE KEYS */;
INSERT INTO `time_prices` VALUES (1,1,3,32500,5900,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(11,1,4,38400,7100,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(21,1,6,46000,6000,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(31,1,8,52400,5300,'2021-03-05 18:52:46','2021-03-05 18:52:46'),(41,1,12,64000,4500,'2021-03-05 18:52:46','2021-03-05 18:52:46');
/*!40000 ALTER TABLE `time_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unknown_users`
--

DROP TABLE IF EXISTS `unknown_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unknown_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pre_reservation_id` bigint(20) unsigned NOT NULL,
  `unknown_user_company` varchar(191) NOT NULL,
  `unknown_user_name` varchar(191) NOT NULL,
  `unknown_user_email` varchar(191) NOT NULL,
  `unknown_user_mobile` varchar(191) NOT NULL,
  `unknown_user_tel` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unknown_users_pre_reservation_id_index` (`pre_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unknown_users`
--

LOCK TABLES `unknown_users` WRITE;
/*!40000 ALTER TABLE `unknown_users` DISABLE KEYS */;
INSERT INTO `unknown_users` VALUES (1,41,'株式会社テスト','丸岡','maruoka@web-trickster.com','08012345678','0612345678','2021-03-08 11:10:18','2021-03-08 11:10:18');
/*!40000 ALTER TABLE `unknown_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `company` varchar(191) NOT NULL COMMENT '会社名',
  `post_code` varchar(191) NOT NULL,
  `address1` varchar(191) NOT NULL,
  `address2` varchar(191) NOT NULL,
  `address3` varchar(191) NOT NULL,
  `address_remark` varchar(191) DEFAULT NULL COMMENT '住所備考',
  `url` varchar(191) DEFAULT NULL COMMENT '会社URL',
  `attr` int(11) DEFAULT NULL COMMENT '顧客属性',
  `condition` text COMMENT '割引条件',
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `first_name_kana` varchar(191) NOT NULL,
  `last_name_kana` varchar(191) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `fax` varchar(191) DEFAULT NULL,
  `pay_method` int(11) DEFAULT NULL COMMENT '支払方法',
  `pay_limit` int(11) DEFAULT NULL COMMENT '支払い期限',
  `pay_post_code` varchar(191) DEFAULT NULL,
  `pay_address1` varchar(191) DEFAULT NULL,
  `pay_address2` varchar(191) DEFAULT NULL,
  `pay_address3` varchar(191) DEFAULT NULL,
  `pay_remark` varchar(191) DEFAULT NULL COMMENT '請求備考',
  `attention` varchar(191) DEFAULT NULL COMMENT '注意事項',
  `remark` varchar(191) DEFAULT NULL COMMENT '備考',
  `status` int(11) NOT NULL COMMENT '会員なのか、退会したのか？',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ooyama@web-trickster.com','$2y$10$zkTw5HKW1Z9k9vKL.Q9m.ODQVkyDkFWkJmzEJdu48oCbHxWJMsShi','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'大山','紘一郎','オオヤマ','コウイチロウ',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'WvJfvUsj3bsPmKvdEFQTOUoqWqOFOO23azriPpEQMYsN2NoLk3ps6OJrglCl',NULL,NULL),(11,'kudou@web-trickster.com','$2y$10$oCPMYM3MFClVM5A0zwREE.HEBQxFSEV7o2NxQheXETHi2WhSqDN4u','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'工藤','大揮','クドウ','ダイキ',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'DgGl0pGwpU1Z4uh8tlrBmvI5QTZlfdJm7rWiq4lWvDCGhFehKSNv01rp88Sy',NULL,NULL),(999,'sample@sample.com','$2y$10$vHmsyx6lKND.Z.0gsnbjqucqo/zRAtRiGpv8f/Y9hjPPcajBHw7VC','（未登録ユーザー）','（未設定）','（未設定）','（未設定）','（未設定）',NULL,NULL,NULL,NULL,'（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'myRPkDxiq7',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `alliance_flag` int(11) NOT NULL,
  `name_area` varchar(191) NOT NULL,
  `name_bldg` varchar(191) NOT NULL,
  `name_venue` varchar(191) NOT NULL,
  `size1` double(3,1) NOT NULL,
  `size2` double(3,1) NOT NULL,
  `capacity` int(11) NOT NULL,
  `eat_in_flag` int(11) NOT NULL,
  `post_code` varchar(191) NOT NULL,
  `address1` varchar(191) NOT NULL,
  `address2` varchar(191) NOT NULL,
  `address3` varchar(191) NOT NULL,
  `remark` text,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `first_name_kana` varchar(191) DEFAULT NULL,
  `last_name_kana` varchar(191) DEFAULT NULL,
  `person_tel` varchar(191) DEFAULT NULL,
  `person_email` varchar(191) DEFAULT NULL,
  `luggage_flag` int(11) NOT NULL,
  `luggage_post_code` varchar(191) DEFAULT NULL,
  `luggage_address1` varchar(191) DEFAULT NULL,
  `luggage_address2` varchar(191) DEFAULT NULL,
  `luggage_address3` varchar(191) DEFAULT NULL,
  `luggage_name` varchar(191) DEFAULT NULL,
  `luggage_tel` varchar(191) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `mgmt_company` varchar(191) DEFAULT NULL,
  `mgmt_tel` varchar(191) DEFAULT NULL,
  `mgmt_emer_tel` varchar(191) DEFAULT NULL,
  `mgmt_first_name` varchar(191) DEFAULT NULL,
  `mgmt_last_name` varchar(191) DEFAULT NULL,
  `mgmt_person_tel` varchar(191) DEFAULT NULL,
  `mgmt_email` varchar(191) DEFAULT NULL,
  `mgmt_sec_company` varchar(191) DEFAULT NULL,
  `mgmt_sec_tel` varchar(191) DEFAULT NULL,
  `mgmt_remark` varchar(191) DEFAULT NULL,
  `smg_url` varchar(191) NOT NULL,
  `entrance_open_time` varchar(191) DEFAULT NULL,
  `backyard_open_time` varchar(191) DEFAULT NULL,
  `layout` varchar(191) NOT NULL,
  `layout_prepare` int(11) DEFAULT NULL,
  `layout_clean` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,0,'四ツ橋','サンワールドビル','1号室',18.0,50.0,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'紘一郎','大山',NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,'2021-03-05 18:52:45','2021-03-05 20:15:14'),(11,0,'四ツ橋','サンワールドビル','2号室(音響HG)',18.0,50.0,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,'2021-03-05 18:52:45','2021-03-05 18:52:45'),(21,0,'トリックスター','We Work','執務室',18.0,50.0,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,'2021-03-05 18:52:45','2021-03-05 18:52:45'),(31,1,'難波','ニッコウ','3号室',1.0,1.0,1,0,'1','1','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'1','1','1','1','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/nb-nikko/6f/','11',NULL,'0',NULL,NULL,NULL,'2021-03-05 18:53:18','2021-03-05 18:53:18'),(41,0,'難波','ニッコウ','3号室',1.0,1.0,1,0,'1','1','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/nb-nikko/6f/',NULL,NULL,'0',NULL,NULL,NULL,'2021-03-05 18:57:12','2021-03-05 18:57:12'),(51,0,'四ツ橋','近商ビル','6B',20.0,30.0,15,0,'5650821','大阪府','吹田市山田東','1',NULL,'コウイチロウ','オオヤマ','コウイチロウ','オオヤマ',NULL,NULL,0,'5650821','大阪府','吹田市山田東','せ','あああ','09050666483',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/6a-h/',NULL,NULL,'0',NULL,NULL,NULL,'2021-03-05 20:13:06','2021-03-05 20:14:29'),(61,0,'a','a','a',10.0,10.0,90,1,'5500014','大阪府','大阪市西区北堀江','近商ビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-kinsyo/10a/',NULL,NULL,'1',NULL,NULL,NULL,'2021-03-08 00:37:50','2021-03-08 00:37:50');
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-08 11:25:50
