-- MySQL dump 10.13  Distrib 8.0.23, for osx10.15 (x86_64)
--
-- Host: us-cdbr-east-02.cleardb.com    Database: heroku_4bfb6785b61d3a4
-- ------------------------------------------------------
-- Server version	5.6.50-log

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','admin@example.com','$2y$10$uDUwwCpHP.8kefSAzc21Wev4gxBrEZG0mucofDZ6zsdn3UUO5RACu','FKw9OSD9qVXrFrf4Mm3Fzq0n89Mn7TFDyuB8glpS7p1YPjhJ1vPE3gMWgM9J',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=552 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (221,'haruka56','株式会社 青山','1767144','石田市','津田町','野村町山岸3-7-9','涼平','鈴木','千代','原田','0560-00-2746','03302-4-9276','0650-018-133','akira67@yahoo.co.jp',80,1,NULL,'特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','2021-03-14 15:36:43','2021-03-16 11:34:45'),(261,'lkiriyama','有限会社 三宅','6513005','高橋市','佐藤町','青山町田辺5-1-5','春香','笹田','康弘','木村','0503-66-9974','0410-540-422','0000-928-395','tsubasa28@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(271,'saito.chiyo','株式会社 近藤','6849614','江古田市','小林町','小林町杉山3-7-6','直子','渡辺','洋介','西之園','036-974-5064','0684-15-1888','090-3426-5734','xkobayashi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(281,'atsushi72','有限会社 若松','4852300','宇野市','喜嶋町','青田町杉山10-1-8','裕樹','佐藤','淳','宇野','06-9240-6326','0360-054-547','0570-308-202','dkobayashi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(291,'shota.sato','有限会社 山口','4213395','浜田市','笹田町','桐山町藤本8-6-4','直樹','吉田','裕太','小泉','090-9980-3588','08941-0-1661','0441-25-1802','chiyo05@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(301,'yuki34','株式会社 渚','3061240','松本市','鈴木町','吉田町山岸6-9-2','稔','加藤','香織','斉藤','080-2395-0448','07-3596-3429','08-3153-7542','naoto69@tanabe.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(311,'ifujimoto','株式会社 江古田','8586376','渚市','田中町','桐山町三宅10-5-9','あすか','井上','智也','伊藤','02-4347-1340','090-6947-3640','03973-5-2048','yamaguchi.kumiko@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(321,'skudo','株式会社 野村','1236426','青田市','青田町','青山町大垣8-3-7','美加子','大垣','くみ子','江古田','090-2919-9393','080-8317-4971','080-0071-2413','kimura.atsushi@sasaki.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(331,'fsasaki','有限会社 近藤','3212600','大垣市','佐々木町','渚町三宅2-1-9','零','中村','康弘','笹田','0420-359-228','04933-8-2019','0516-18-3936','atsushi18@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(341,'yuki.tanaka','株式会社 喜嶋','6846176','三宅市','井上町','大垣町工藤3-9-2','稔','佐々木','さゆり','宇野','080-6386-0418','0960-743-768','00-1872-8498','nsato@yoshida.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(351,'hideki80','株式会社 井高','6464475','加納市','近藤町','若松町高橋3-6-2','聡太郎','工藤','結衣','近藤','03280-0-9214','01-0777-1142','080-2794-7519','yasuhiro.wakamatsu@hamada.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(361,'shota.yamagishi','株式会社 桐山','7397584','宮沢市','青山町','小林町高橋2-3-9','七夏','近藤','七夏','松本','0240-812-019','080-1331-4929','090-8402-4315','sasaki.kenichi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(371,'takuma.kijima','有限会社 宮沢','7441881','工藤市','山本町','田辺町桐山2-8-6','七夏','工藤','美加子','青山','031-918-8279','090-2269-1589','0790-262-416','taichi82@wakamatsu.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(381,'yamaguchi.momoko','株式会社 高橋','4241812','中村市','田中町','加藤町宮沢1-8-6','直人','杉山','英樹','中島','01727-6-1754','07724-0-7787','03-6272-6852','hideki.sato@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(391,'naoko39','有限会社 宮沢','9223583','渚市','斉藤町','工藤町工藤7-10-3','桃子','中島','充','小林','07038-7-4077','090-7881-7392','080-5496-0209','akemi52@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(401,'naoto.kiriyama','有限会社 津田','4494908','佐藤市','小泉町','中島町宮沢5-9-7','康弘','宇野','拓真','江古田','015-651-3100','090-8049-7895','07-6396-1985','hirokawa.mitsuru@miyazawa.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(411,'rhirokawa','株式会社 井上','4907031','吉田市','中村町','佐藤町田中5-8-6','あすか','廣川','あすか','石田','0871-60-6112','02-1974-5464','0830-575-762','tomoya24@uno.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(421,'btanaka','株式会社 青山','3566582','渡辺市','桐山町','坂本町桐山7-1-2','知実','加藤','太一','原田','090-1779-1432','03072-0-4227','06-4740-6970','satomi27@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(431,'kyosuke.kato','有限会社 杉山','6946134','伊藤市','野村町','桐山町佐藤5-5-1','太郎','吉本','知実','坂本','056-113-6300','01-4453-4443','080-2321-6757','kazuya.kondo@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(441,'hirokawa.haruka','有限会社 廣川','7405096','木村市','村山町','桐山町山本10-10-8','治','藤本','篤司','近藤','07222-9-3072','09-1024-5761','0370-829-973','ynakatsugawa@yoshida.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(451,'miki.nakamura','株式会社 加納','8285675','田中市','三宅町','高橋町加藤1-6-2','あすか','松本','舞','江古田','02662-7-3278','040-777-7650','090-3883-4533','atakahashi@yamagishi.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(461,'hanako.matsumoto','有限会社 江古田','6707692','斉藤市','渚町','加藤町江古田8-7-3','陽子','高橋','千代','小泉','0211-29-4749','0050-130-952','090-0390-9445','miki94@miyake.info',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(471,'unishinosono','有限会社 鈴木','4911832','三宅市','田中町','井高町高橋5-10-7','結衣','松本','桃子','浜田','0580-066-012','0760-246-137','0747-33-6995','naoko96@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(551,'HAKO　ROOM','ｓ','5500011','大阪府','大阪市西区阿波座1','梅田ビル','堺堺谷','sa','sasa','s','06','066666','666','sakaitani@cocrework.jp',80,1,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ',NULL,NULL,NULL,NULL,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ','ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ',NULL,1,NULL,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ','2021-03-15 14:30:13','2021-03-15 14:30:13');
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
-- Table structure for table `cxl_breakdowns`
--

DROP TABLE IF EXISTS `cxl_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cxl_breakdowns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cxls_id` bigint(20) unsigned NOT NULL,
  `unit_item` varchar(191) NOT NULL,
  `unit_count` int(11) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `unit_subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cxl_breakdowns_cxls_id_index` (`cxls_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxl_breakdowns`
--

LOCK TABLES `cxl_breakdowns` WRITE;
/*!40000 ALTER TABLE `cxl_breakdowns` DISABLE KEYS */;
/*!40000 ALTER TABLE `cxl_breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxls`
--

DROP TABLE IF EXISTS `cxls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cxls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) unsigned NOT NULL,
  `master_subtotal` int(11) NOT NULL,
  `master_tax` int(11) NOT NULL,
  `master_total` int(11) NOT NULL,
  `payment_limit` date NOT NULL,
  `bill_company` varchar(191) NOT NULL,
  `bill_person` varchar(191) NOT NULL,
  `bill_created_at` date NOT NULL,
  `bill_remark` varchar(191) DEFAULT NULL,
  `paid` int(11) DEFAULT NULL,
  `pay_day` date DEFAULT NULL,
  `pay_person` varchar(191) DEFAULT NULL,
  `payment` varchar(191) DEFAULT NULL,
  `cxl_status` int(11) NOT NULL,
  `double_check_status` int(11) DEFAULT NULL,
  `double_check1_name` varchar(191) DEFAULT NULL,
  `double_check2_name` varchar(191) DEFAULT NULL,
  `approve_send_at` datetime DEFAULT NULL,
  `category` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cxls_bill_id_index` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxls`
--

LOCK TABLES `cxls` WRITE;
/*!40000 ALTER TABLE `cxls` DISABLE KEYS */;
/*!40000 ALTER TABLE `cxls` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=902 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dates`
--

LOCK TABLES `dates` WRITE;
/*!40000 ALTER TABLE `dates` DISABLE KEYS */;
INSERT INTO `dates` VALUES (1,1,1,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(11,1,2,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-17 11:00:10'),(21,1,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(31,1,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(41,1,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(51,1,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(61,1,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(71,11,1,'10:30:00','22:30:00','2021-03-14 15:36:44','2021-03-15 00:45:25'),(81,11,2,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(91,11,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(101,11,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(111,11,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(121,11,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(131,11,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(141,21,1,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(151,21,2,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(161,21,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(171,21,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(181,21,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(191,21,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(201,21,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(211,31,1,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(221,31,2,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(231,31,3,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(241,31,4,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(251,31,5,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(261,31,6,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(271,31,7,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(281,41,1,'01:00:00','23:30:00','2021-03-14 20:52:49','2021-03-14 22:54:48'),(291,41,2,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(301,41,3,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(311,41,4,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(321,41,5,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(331,41,6,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(341,41,7,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(351,51,1,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(361,51,2,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(371,51,3,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(381,51,4,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(391,51,5,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(401,51,6,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(411,51,7,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(421,61,1,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(431,61,2,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(441,61,3,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(451,61,4,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(461,61,5,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(471,61,6,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(481,61,7,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(491,71,1,'08:00:00','23:00:00','2021-03-14 21:31:26','2021-03-14 21:31:26'),(501,71,2,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(511,71,3,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(521,71,4,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(531,71,5,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(541,71,6,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(551,71,7,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(561,81,1,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(571,81,2,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(581,81,3,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(591,81,4,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(601,81,5,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(611,81,6,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(621,81,7,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(631,91,1,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(641,91,2,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(651,91,3,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(661,91,4,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(671,91,5,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(681,91,6,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(691,91,7,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(701,101,1,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(711,101,2,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(721,101,3,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(731,101,4,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(741,101,5,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(751,101,6,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(761,101,7,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(771,111,1,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(781,111,2,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(791,111,3,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(801,111,4,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(811,111,5,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(821,111,6,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(831,111,7,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(841,121,1,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(851,121,2,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(861,121,3,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(871,121,4,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(881,121,5,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(891,121,6,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(901,121,7,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_venue`
--

LOCK TABLES `equipment_venue` WRITE;
/*!40000 ALTER TABLE `equipment_venue` DISABLE KEYS */;
INSERT INTO `equipment_venue` VALUES (1,1,21,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(11,1,31,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(21,1,41,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(31,1,61,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(41,1,71,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(51,1,81,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(61,1,101,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(71,1,121,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(81,1,141,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(91,1,151,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(101,1,181,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(111,31,21,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(121,31,41,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(131,31,61,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(141,51,21,'2021-03-14 21:22:04','2021-03-14 21:22:04'),(151,51,41,'2021-03-14 21:22:04','2021-03-14 21:22:04'),(161,61,1,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(171,81,1,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(181,81,31,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(191,91,1,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(201,91,31,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(211,101,1,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(221,111,21,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(231,111,31,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(241,121,11,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(251,121,41,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(261,121,51,'2021-03-15 16:11:09','2021-03-15 16:11:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
INSERT INTO `equipments` VALUES (1,'有線マイク',3000,10,NULL,'2021-03-14 15:36:43',NULL),(11,'無線マイク',3000,10,NULL,'2021-03-14 15:36:43',NULL),(21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(31,'【追加】次亜塩素酸水専用・超音波加湿器',500,10,NULL,'2021-03-14 15:36:43',NULL),(41,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(51,'ホワイトボード（幅120㎝）',2500,10,NULL,'2021-03-14 15:36:43',NULL),(61,'プロジェクター',3000,10,NULL,'2021-03-14 15:36:43',NULL),(71,'既存パーテーションの移動',2000,10,NULL,'2021-03-14 15:36:43',NULL),(81,'レーザーポインター',1000,10,NULL,'2021-03-14 15:36:43',NULL),(91,'iphone(Lightning)⇔VGA変換ケーブル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(101,'iphone(Lightning)DVDプレイヤー',2000,10,NULL,'2021-03-14 15:36:43',NULL),(111,'CDプレイヤー',1000,10,NULL,'2021-03-14 15:36:43',NULL),(121,'持ち運びパーテーション',1000,10,NULL,'2021-03-14 15:36:43',NULL),(141,'あああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',0,0,'ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ','2021-03-14 17:31:31','2021-03-14 17:40:08'),(151,'あ',1,99,'サンワールド1号室','2021-03-14 17:40:21','2021-03-14 17:41:21'),(161,'ああ',-4,-4,NULL,'2021-03-14 17:40:35','2021-03-14 17:40:35'),(171,'あ',-4,1,NULL,'2021-03-14 17:40:53','2021-03-14 17:40:53'),(181,'ｓ',123,9977,NULL,'2021-03-14 17:41:33','2021-03-14 17:41:33'),(191,'？/*?*_㈱',100,1,NULL,'2021-03-14 17:42:29','2021-03-14 17:42:29'),(201,'あ',3,2,'あああ\r\nああああああ\r\n1234475\r\n\r\n1347','2021-03-14 17:53:13','2021-03-14 17:53:13'),(211,'あああ',20,99,'ああああああああああああああああああああ\r\n\r\nあああああああああああ','2021-03-14 18:01:34','2021-03-14 18:01:34'),(221,'123',-1,12,NULL,'2021-03-14 20:20:27','2021-03-14 20:20:27'),(231,'８８',1000,1,NULL,'2021-03-14 20:22:12','2021-03-14 20:22:12'),(241,'b半角',1,1,NULL,'2021-03-14 20:22:47','2021-03-14 20:23:20'),(251,'ｂ全角',5,1,NULL,'2021-03-14 20:23:09','2021-03-14 20:23:09'),(291,'★',1000,100,NULL,'2021-03-15 09:41:25','2021-03-15 09:41:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=642 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_prices`
--

LOCK TABLES `frame_prices` WRITE;
/*!40000 ALTER TABLE `frame_prices` DISABLE KEYS */;
INSERT INTO `frame_prices` VALUES (271,31,'午前','08:00:00','12:00:00',10000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(281,31,'午前＆午後','10:00:00','17:00:00',15000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(291,31,'午後','13:00:00','17:00:00',30000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(301,31,'夜間','18:00:00','21:00:00',10000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(311,41,'午前','08:00:00','12:00:00',10000,500,'2021-03-14 22:48:30','2021-03-14 22:48:30'),(531,101,'午前','10:00:00','12:00:00',15000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(541,101,'午後','13:00:00','17:00:00',10000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(551,101,'午前＆午後','10:00:00','17:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(561,101,'夜間','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(571,101,'午前＆午後','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(581,101,'午後＆夜間','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(591,1,'午前','10:00:00','12:00:00',15000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(601,1,'午前','10:00:00','12:00:00',30000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(611,1,'夜間','18:00:00','23:00:00',15000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(621,1,'午前＆午後','10:00:00','17:00:00',36000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(631,1,'午後＆夜間','13:00:00','21:00:00',36000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(641,1,'終日','10:00:00','21:00:00',42000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12');
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
) ENGINE=InnoDB AUTO_INCREMENT=2992 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (2711,'2014_10_12_000000_create_users_table',1),(2721,'2014_10_12_100000_create_password_resets_table',1),(2731,'2019_08_19_000000_create_failed_jobs_table',1),(2741,'2020_02_01_090636_create_admins_table',1),(2751,'2020_09_18_090242_create_venues_table',1),(2761,'2020_09_20_044412_create_equipments_table',1),(2771,'2020_09_20_065837_create_venue_equipment_table',1),(2781,'2020_09_22_094627_create_services_table',1),(2791,'2020_09_24_064549_create_dates_table',1),(2801,'2020_09_24_072535_create_service_venue_table',1),(2811,'2020_09_24_100404_create_date_venue_table',1),(2821,'2020_09_29_055630_create_frame_prices_table',1),(2831,'2020_10_01_062150_create_time_prices_table',1),(2841,'2020_10_07_145320_create_email_verification_table',1),(2851,'2020_10_08_104339_create_agents_table',1),(2861,'2020_10_12_132928_create_preusers_table',1),(2871,'2020_10_19_163736_create_reservations_table',1),(2881,'2020_12_23_174247_create_bills_table',1),(2891,'2020_12_23_182424_create_breakdowns_table',1),(2901,'2021_02_08_153525_create_endusers_table',1),(2911,'2021_02_15_134342_create_pre_reservations_table',1),(2921,'2021_02_15_134831_create_pre_bills_table',1),(2931,'2021_02_15_135246_create_pre_breakdowns_table',1),(2941,'2021_02_15_140439_create_unknown_users_table',1),(2951,'2021_02_17_163902_create_multiple_reserves_table',1),(2961,'2021_02_23_122139_create_pre_endusers_table',1),(2971,'2021_03_07_164513_create_cxls_table',1),(2981,'2021_03_07_164951_create_cxl_breakdowns_table',1),(2991,'2021_03_11_170012_add_charge_to_pre_endusers_table',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_reserves`
--

LOCK TABLES `multiple_reserves` WRITE;
/*!40000 ALTER TABLE `multiple_reserves` DISABLE KEYS */;
INSERT INTO `multiple_reserves` VALUES (1,'2021-03-14 18:34:41','2021-03-14 18:34:41'),(11,'2021-03-14 19:03:18','2021-03-14 19:03:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_bills`
--

LOCK TABLES `pre_bills` WRITE;
/*!40000 ALTER TABLE `pre_bills` DISABLE KEYS */;
INSERT INTO `pre_bills` VALUES (1,1,42000,7701,0,0,49701,4970,54671,0,NULL,1,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(11,31,54500,0,0,0,54500,5450,59950,0,NULL,1,'2021-03-14 18:37:08','2021-03-14 18:37:08'),(21,41,0,0,0,0,40000,4000,44000,0,NULL,1,'2021-03-14 19:01:32','2021-03-14 19:01:32'),(31,11,0,0,13000,0,13000,1300,14300,0,NULL,1,'2021-03-14 19:04:58','2021-03-14 19:04:58'),(41,71,1,0,0,0,1,0,1,0,NULL,1,'2021-03-15 12:31:59','2021-03-15 12:31:59');
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
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_breakdowns`
--

LOCK TABLES `pre_breakdowns` WRITE;
/*!40000 ALTER TABLE `pre_breakdowns` DISABLE KEYS */;
INSERT INTO `pre_breakdowns` VALUES (1,1,'会場料金',42000,'9.5',42000,1,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(11,1,'プロジェクター',3000,'1',3000,2,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(21,1,'iphone(Lightning)DVDプレイヤー',2000,'1',2000,2,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(31,1,'あ',1,'1',1,2,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(41,1,'領収書発行',200,'1',200,3,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(51,1,'鍵レンタル',500,'1',500,3,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(61,1,'プロジェクター設置',2000,'1',2000,3,'2021-03-14 18:12:35','2021-03-14 18:12:35'),(71,11,'会場料金',42000,'13.5',42000,1,'2021-03-14 18:37:08','2021-03-14 18:37:08'),(81,11,'延長料金',12500,'2.5',12500,1,'2021-03-14 18:37:08','2021-03-14 18:37:08'),(91,21,'会場料金',0,'13.5h',0,1,'2021-03-14 19:01:32','2021-03-14 19:01:32'),(101,31,'レイアウト準備料金',5000,'1',5000,4,'2021-03-14 19:04:58','2021-03-14 19:04:58'),(111,31,'レイアウト片付料金',8000,'1',8000,4,'2021-03-14 19:04:58','2021-03-14 19:04:58'),(121,41,'1',1,'1',1,1,'2021-03-15 12:31:59','2021-03-15 12:31:59');
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
  `pre_reservation_id` int(10) unsigned NOT NULL,
  `company` varchar(191) DEFAULT NULL,
  `person` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `attr` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `charge` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_endusers_pre_reservation_id_index` (`pre_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_endusers`
--

LOCK TABLES `pre_endusers` WRITE;
/*!40000 ALTER TABLE `pre_endusers` DISABLE KEYS */;
INSERT INTO `pre_endusers` VALUES (1,41,'株式会社トリックスター',NULL,NULL,NULL,'09050666483','大阪市中央区難波 5-1-60 なんばスカイオ27階　WeWork',0,'2021-03-14 19:01:32','2021-03-14 19:01:32',200000);
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
  `status` int(11) NOT NULL,
  `eat_in` int(11) DEFAULT NULL,
  `eat_in_prepare` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pre_reservations_multiple_reserve_id_index` (`multiple_reserve_id`),
  KEY `pre_reservations_venue_id_index` (`venue_id`),
  KEY `pre_reservations_user_id_index` (`user_id`),
  KEY `pre_reservations_agent_id_index` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_reservations`
--

LOCK TABLES `pre_reservations` WRITE;
/*!40000 ALTER TABLE `pre_reservations` DISABLE KEYS */;
INSERT INTO `pre_reservations` VALUES (1,0,1,1,0,'2021-04-08',1,'10:00:00','19:30:00',0,'10:00:00','17:30:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'大山紘一郎','09050666483',NULL,NULL,NULL,NULL,1,1,1,NULL,'2021-03-14 18:12:35','2021-03-14 18:14:17'),(11,1,21,1,0,'2021-04-09',NULL,'09:30:00','18:30:00',0,'09:30:00','18:30:00',NULL,NULL,NULL,NULL,'1970-01-01 00:00:00',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 18:34:41','2021-03-14 19:04:58'),(21,1,31,1,0,'2021-04-23',NULL,'10:30:00','18:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 18:34:41','2021-03-14 18:34:41'),(31,0,1,1,0,'2021-04-16',1,'08:00:00','21:30:00',0,'08:00:00','08:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'大山紘一郎','09283321123',NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-14 18:37:08','2021-03-14 18:37:08'),(41,0,1,0,1,'2021-04-16',1,'07:30:00','21:00:00',0,'07:30:00','07:30:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'','','',NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-14 19:01:32','2021-03-14 19:01:32'),(51,11,1,0,21,'2021-04-22',NULL,'08:30:00','19:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 19:03:18','2021-03-14 19:03:18'),(61,11,1,0,21,'2021-04-23',NULL,'13:00:00','19:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 19:03:18','2021-03-14 19:03:18'),(71,0,1,11,0,'2021-03-11',1,'00:00:00','03:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'1111111','11111111111111111',NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-15 12:31:59','2021-03-15 12:31:59');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preusers`
--

LOCK TABLES `preusers` WRITE;
/*!40000 ALTER TABLE `preusers` DISABLE KEYS */;
INSERT INTO `preusers` VALUES (1,'nakamu@s-mg.co.jp','RW7hEAm2lobtrdrSB7Ps0ujWVbrdbwqRW0Dmr15Bhi7riXYT9xYx5f62dsthUMlwFvsuh7wWxWn6Eme9CKvm0bR5ldAKK7COU0mtxMQqRa4wznBFkc3zg9IMEoQXJapOZDxq2DfAbyprzU9FdwD9jkFtvLiCmb6UNNNqekJ7wUWpufORP9VoPCAISAmeAyeeZYI6tySPOawAPk0uZpe2bbmISj03nLhRmweZlBPsPW3b2TIzQROMXgDrdE','2021-03-25 17:47:43',NULL,'2021-03-25 16:47:43','2021-03-25 16:47:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_venue`
--

LOCK TABLES `service_venue` WRITE;
/*!40000 ALTER TABLE `service_venue` DISABLE KEYS */;
INSERT INTO `service_venue` VALUES (1,1,1,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(11,1,11,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(21,1,21,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(31,31,1,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(41,31,21,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(51,31,31,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(61,61,1,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(71,81,1,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(81,81,21,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(91,91,1,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(101,101,11,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(111,111,21,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(121,111,51,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(131,121,21,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(141,121,31,'2021-03-15 16:11:09','2021-03-15 16:11:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'領収書発行',200,'ああああああああああああああああああああああああああああああああああああああああああああああああああ','2021-03-14 15:36:43','2021-03-14 19:19:44'),(11,'鍵レンタル',500,NULL,'2021-03-14 15:36:43',NULL),(21,'プロジェクター設置',2000,NULL,'2021-03-14 15:36:43',NULL),(31,'DVDプレイヤー設置',2000,NULL,'2021-03-14 15:36:43',NULL),(51,'８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８',88888,'８','2021-03-14 23:23:31','2021-03-14 23:23:31');
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_prices`
--

LOCK TABLES `time_prices` WRITE;
/*!40000 ALTER TABLE `time_prices` DISABLE KEYS */;
INSERT INTO `time_prices` VALUES (31,31,3,10000,5000,'2021-03-14 18:35:08','2021-03-14 18:35:08'),(41,31,4,9000,4500,'2021-03-14 18:35:08','2021-03-14 18:35:08'),(51,31,6,8000,4000,'2021-03-14 18:35:08','2021-03-14 18:35:08'),(61,41,2,1000,1000,'2021-03-14 22:47:32','2021-03-14 22:47:32');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unknown_users`
--

LOCK TABLES `unknown_users` WRITE;
/*!40000 ALTER TABLE `unknown_users` DISABLE KEYS */;
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
  `post_code` varchar(191) DEFAULT NULL,
  `address1` varchar(191) DEFAULT NULL,
  `address2` varchar(191) DEFAULT NULL,
  `address3` varchar(191) DEFAULT NULL,
  `address_remark` varchar(191) DEFAULT NULL COMMENT '住所備考',
  `url` varchar(191) DEFAULT NULL COMMENT '会社URL',
  `attr` int(11) DEFAULT NULL COMMENT '顧客属性',
  `condition` text COMMENT '割引条件',
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `first_name_kana` varchar(191) NOT NULL,
  `last_name_kana` varchar(191) NOT NULL,
  `mobile` varchar(191) NOT NULL,
  `tel` varchar(191) DEFAULT NULL,
  `fax` varchar(191) DEFAULT NULL,
  `pay_method` int(11) NOT NULL COMMENT '支払方法',
  `pay_limit` int(11) NOT NULL COMMENT '支払い期限',
  `pay_post_code` varchar(191) DEFAULT NULL,
  `pay_address1` varchar(191) DEFAULT NULL,
  `pay_address2` varchar(191) DEFAULT NULL,
  `pay_address3` varchar(191) DEFAULT NULL,
  `pay_remark` varchar(191) DEFAULT NULL COMMENT '請求備考',
  `attention` varchar(191) DEFAULT NULL COMMENT '注意事項',
  `remark` varchar(191) DEFAULT NULL COMMENT '備考',
  `status` int(11) NOT NULL COMMENT '会員なのか、退会したのか？',
  `admin_or_user` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1512 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ooyama@web-trickster.com','$2y$10$LwwZ7H9sEjy2wyQkf0ZvdexQlEG3LsMI5tcGWeppBtWfcsKyONCv6','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'大山','紘一郎','オオヤマ','コウイチロウ','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'fU491uWeOi',NULL,NULL),(11,'kudou@web-trickster.com','$2y$10$3VuiWGSdg1D4F7/fWzFvK.r1fCxqAOEdJIg3B66ZdDvOw4P.R.r2e','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'工藤','大揮','クドウ','ダイキ','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'0ToJLeWOwD',NULL,NULL),(999,'sample@sample.com','$2y$10$J3m8W.LRyV//Scl488z6veiq4B4Ema7fehTi9UkuP//yU0J80w3AS','（未登録ユーザー）','（未設定）','（未設定）','（未設定）','（未設定）',NULL,NULL,NULL,NULL,'（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'w8FvTmJ1LC',NULL,NULL),(1001,'chiyo.ekoda@example.com','$2y$10$UBuLRvJYBV9gjgFHixKYS.FHXRyeIcwSwZrDV5.d1lXyQSMHjnquG','株式会社 小林','6816604','山岸市','木村町','加納町藤本6-10-8',NULL,NULL,NULL,NULL,'工藤','幹','ダミーのため一致しません','ダミーのため一致しません','080-8238-0811','090-1442-6912',NULL,0,2,'9297807','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんちゅうで橋はしいんです。ごらんとしよ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1011,'kumiko.kato@example.net','$2y$10$4e4QfJaHxQYlGKbxRGYcUupOlsy4VJo.XEScULLRO7JLf22HpI/tu','有限会社 喜嶋','5492871','山本市','藤本町','西之園町田辺9-8-9',NULL,NULL,NULL,NULL,'加藤','稔','ダミーのため一致しません','ダミーのため一致しません','027-474-0671','0899-95-6748',NULL,2,4,'8162446','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータおおきなた方はなぜそんな苹果りんの灯あ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1021,'minoru.sato@example.com','$2y$10$JVoIM5LkUhGiTAbgFHYKOON3ZGTkolUdaoFyp.OFkaB2rCnx1SGBi','株式会社 山岸','5582660','加納市','坂本町','高橋町藤本2-4-7',NULL,NULL,NULL,NULL,'山本','幹','ダミーのため一致しません','ダミーのため一致しません','08-8093-4835','090-0555-2221',NULL,2,1,'4027421','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータむねいったり、あの黒い松まつりながれま。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1031,'funo@example.net','$2y$10$gFKMw1PJcMmy2PuIlaoxxO5oWpKUz/IOjH4sIwKg7kL3t1G/qHIX6','株式会社 山田','5008322','坂本市','杉山町','近藤町中島8-9-6',NULL,NULL,NULL,NULL,'山田','浩','ダミーのため一致しません','ダミーのため一致しません','0800-57-4012','03324-6-7948',NULL,1,3,'4227008','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータそこからもう渦うずんずんずる人「これは。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1041,'ekoda.yoko@example.com','$2y$10$Z4S/g7.2K9jbV7Xz2egDL.WTUSyUM45c4ZXqkuXK..hlUzTQwOooG','株式会社 青山','3392992','斉藤市','若松町','喜嶋町原田4-8-3',NULL,NULL,NULL,NULL,'吉田','幹','ダミーのため一致しません','ダミーのため一致しません','0510-747-622','0056-21-6389',NULL,0,2,'6723921','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータひらにひらべてみんなは乗のり出されて青。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1051,'wtsuda@example.org','$2y$10$xjlFvUZsbJInNf/poxj5d.K3Rd582OqDeeg5BtTNRCCP9DIEbitpO','有限会社 藤本','4205365','杉山市','桐山町','藤本町山岸10-8-2',NULL,NULL,NULL,NULL,'木村','里佳','ダミーのため一致しません','ダミーのため一致しません','0053-63-2715','090-7030-7527',NULL,1,4,'8615103','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはの下の方を見ているから今晩こんな聞き。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1061,'momoko.yamagishi@example.com','$2y$10$3qT0ZdNzFST92ES7HsXj3uyjrHK2mq5mHhnahTIOIKu3S9.HzyMae','有限会社 藤本','6383142','宮沢市','中津川町','青田町加藤4-7-3',NULL,NULL,NULL,NULL,'笹田','七夏','ダミーのため一致しません','ダミーのため一致しません','09-6762-1320','090-2180-8571',NULL,2,4,'4625868','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータばんうしているのです。ごくような気がし。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1071,'yosuke31@example.net','$2y$10$SQGNp7zq/mEraVZfHNvRYeOTSsnF4nGr1w9cEWdoJxG9Z7ZT8iGhS','有限会社 大垣','1115585','宇野市','山岸町','伊藤町杉山9-4-6',NULL,NULL,NULL,NULL,'喜嶋','晃','ダミーのため一致しません','ダミーのため一致しません','0460-657-071','080-6942-8411',NULL,3,4,'1609044','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータれぁ、砂すなへつくしはいったわっていて。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1081,'nyamaguchi@example.com','$2y$10$JZ8gTK6dW2ymEzhY0O5e4OSV79/IhEcuQCIIoYRANm6N7H6L8ntky','有限会社 喜嶋','2275102','渡辺市','加藤町','加納町津田2-1-4',NULL,NULL,NULL,NULL,'津田','和也','ダミーのため一致しません','ダミーのため一致しません','00848-7-4424','090-7439-6178',NULL,2,4,'4862740','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータしていました。「鳥がただおじぎを押おさ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1091,'naoki.hirokawa@example.com','$2y$10$xGIQ14zxyP39Dr2na19JKO1WnVBBsHrVACVs7AvWZ6xaLoDv3EE6y','有限会社 井高','3759165','斉藤市','田中町','渚町青田7-9-3',NULL,NULL,NULL,NULL,'小林','桃子','ダミーのため一致しません','ダミーのため一致しません','080-8690-7838','080-3744-9635',NULL,3,4,'4978408','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータや、まもないうんどうしてやすむ中での間。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1101,'kaori52@example.org','$2y$10$T9TtIsWTGwO0nse7MEYelOSnSuFwhPAwQA5.cEG5dyU/klq4smO1m','株式会社 田中','5594560','桐山市','加納町','小林町若松9-8-10',NULL,NULL,NULL,NULL,'大垣','香織','ダミーのため一致しません','ダミーのため一致しません','01-3111-8708','0537-19-3194',NULL,1,2,'1156354','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータども遅おくにあたるのです。カムパネルラ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1111,'takuma29@example.org','$2y$10$Le3OSZAqM8LrGOLdTSBYD.4zxcdlOD3wz2VW8nZ.B/AtAM6J5J3Wu','有限会社 加藤','8817205','佐々木市','佐藤町','吉本町佐藤3-1-8',NULL,NULL,NULL,NULL,'松本','聡太郎','ダミーのため一致しません','ダミーのため一致しません','0580-520-393','080-6795-3232',NULL,2,2,'8841317','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータンタウルの村だよ。お父さんか百ぺんに丘。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1121,'yasuhiro31@example.org','$2y$10$hf9HZmwqzjXbLya5ynNHeOLn.xYurtldVyrB/GoL64HrxI.vTsln2','有限会社 津田','9921784','鈴木市','村山町','青田町山口5-9-2',NULL,NULL,NULL,NULL,'山本','さゆり','ダミーのため一致しません','ダミーのため一致しません','0716-28-0023','080-9076-1491',NULL,1,3,'6242045','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータて来たらしいた旗はたしはあの河原から彗。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1131,'kazuya11@example.net','$2y$10$eECy5qJSI9enNW2sBbHykuhapItP7iT8qMXivGDaDmnQaszPUG8h6','有限会社 山本','9028996','田辺市','中村町','高橋町原田6-8-2',NULL,NULL,NULL,NULL,'加納','零','ダミーのため一致しません','ダミーのため一致しません','0278-84-9027','080-5195-6216',NULL,1,3,'8757300','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの方から顔を出ましたら、つめたくさんか。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1141,'takuma55@example.com','$2y$10$jhWITuWDg3m6MtV.hE7YDOzsvvSgnsePyXjaxSfUYF.XKISjst1SK','有限会社 中津川','5673844','高橋市','三宅町','吉田町津田5-1-8',NULL,NULL,NULL,NULL,'青田','太一','ダミーのため一致しません','ダミーのため一致しません','080-4310-9516','090-9133-3838',NULL,2,3,'2708852','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータく赤くしに入れて、ぎんがの水を、一足さ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1151,'nanami.nakajima@example.com','$2y$10$pvavOTWccbBJZfDi1KCg.uo9t7/V63vL5chzupNgf1nRV1sjx3a7W','株式会社 若松','2526676','高橋市','加藤町','青山町廣川1-3-6',NULL,NULL,NULL,NULL,'笹田','翼','ダミーのため一致しません','ダミーのため一致しません','0520-154-129','09-7594-9046',NULL,3,1,'9216581','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータょうが、青宝玉サファイアモンド会社の前。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1161,'kaoyama@example.org','$2y$10$WaHfBqz4DbOqp1OiXsTArOoYEKar8hazmA0e575PM/LsNL7WV8xS6','有限会社 中島','3448828','若松市','山口町','野村町井高9-5-4',NULL,NULL,NULL,NULL,'大垣','裕美子','ダミーのため一致しません','ダミーのため一致しません','046-029-6573','0221-58-3932',NULL,3,1,'9908755','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータわるがわの鶴つるをもって見ます」青年が。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1171,'yuki.hirokawa@example.com','$2y$10$HAI7Jcr7rve9ep.xshBeheHdw/tely/xFikIvbO9ylG92plhesimO','有限会社 吉田','4091011','杉山市','山岸町','中島町三宅8-1-2',NULL,NULL,NULL,NULL,'津田','香織','ダミーのため一致しません','ダミーのため一致しません','07-8027-2081','0499-82-3578',NULL,2,1,'1482696','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータムパネルラが地図をどころな国語で一度ど。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1181,'hsakamoto@example.net','$2y$10$ajwJC9wG.bzH5yjsaaxZIeORh9So3jv5cUKHz1jBGR64hphHBk27O','株式会社 西之園','1427411','藤本市','斉藤町','三宅町宇野8-8-8',NULL,NULL,NULL,NULL,'高橋','真綾','ダミーのため一致しません','ダミーのため一致しません','0250-164-522','0020-027-995',NULL,0,2,'7581514','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはなれませんです。私どもいているときれ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1191,'ekoda.kana@example.org','$2y$10$zxXh3lKUsuSxjo416UJgTOPcWjdEOo9K4sAtpqVUOdfQM2jJOYIPO','有限会社 江古田','8867303','大垣市','渡辺町','吉田町高橋7-2-8',NULL,NULL,NULL,NULL,'松本','晃','ダミーのため一致しません','ダミーのため一致しません','080-1099-9074','090-3097-8180',NULL,1,2,'8069434','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ何があちここは小さな星はみな、乳ちちを。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1201,'shota82@example.net','$2y$10$6iCK21gxoAFqtvzNIvbgEuauCiD5vERwFDR/dojAMbfC6.IXfPIx.','株式会社 伊藤','5649495','中島市','石田町','桐山町青田3-5-9',NULL,NULL,NULL,NULL,'宮沢','亮介','ダミーのため一致しません','ダミーのため一致しません','090-3877-6328','00-7907-5003',NULL,3,4,'6002331','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ気は澄すみます。七北十字のときれいなん。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1211,'mitsuru42@example.org','$2y$10$72oyS3XU0u2wFGiAjVNK.uigMVVQf6DoleKcPIxaVpkORzzlk2rGK','有限会社 近藤','7743508','高橋市','廣川町','山田町浜田8-1-4',NULL,NULL,NULL,NULL,'加納','涼平','ダミーのため一致しません','ダミーのため一致しません','0740-415-872','021-785-8618',NULL,3,1,'9871659','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ勢いきをしてうごきだしていましたといつ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1221,'nanami.kanou@example.com','$2y$10$AlmJ0oU6RVpDOzTAfqAXWerf1b6Ama0TiNKKos5GFegwSQymGEkpS','有限会社 山田','4403565','石田市','青山町','喜嶋町青山8-4-2',NULL,NULL,NULL,NULL,'渚','舞','ダミーのため一致しません','ダミーのため一致しません','059-631-7168','090-5360-9240',NULL,1,4,'9497129','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータゆびわを見るときにわらっと姉弟きょうほ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1231,'kudo.akira@example.com','$2y$10$hwqUqhzY/V7uhlHA3GbpWeC4cmikYbk3ouN9hz4bKaLTH9CWkl4q.','株式会社 中島','8487960','加納市','小林町','喜嶋町渡辺6-3-2',NULL,NULL,NULL,NULL,'渚','里佳','ダミーのため一致しません','ダミーのため一致しません','080-8444-3800','0110-123-873',NULL,0,4,'7352685','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんだん横よこのひばの植うえんきり六十度。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1241,'dnomura@example.net','$2y$10$jmPgbMzFAojYbhvAGcZrSe18bClnC7sMLscXVrd75p7ojA6OqBBha','有限会社 野村','2159595','中村市','江古田町','廣川町工藤1-8-1',NULL,NULL,NULL,NULL,'三宅','千代','ダミーのため一致しません','ダミーのため一致しません','090-2401-8782','0136-57-4015',NULL,0,4,'8771118','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータとおいているかぐあいさんがやく弓ゆみの。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1251,'harada.chiyo@example.com','$2y$10$O9qGB8W/mBlni4lKgw3/gO1Zwg438tfAMRBtYQVwbdBXJfXcN9htW','有限会社 木村','7215108','藤本市','中津川町','渡辺町山本6-7-7',NULL,NULL,NULL,NULL,'加藤','千代','ダミーのため一致しません','ダミーのため一致しません','090-4309-6579','0230-106-989',NULL,3,2,'2203610','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータがら、もとかわいらしい燐光りんどはずう。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1261,'yui.yamamoto@example.com','$2y$10$Xdlon4rm53baLj9EwgpJf.Sdxhp45wiWX0HRJc82rdA713a03hpL.','有限会社 桐山','6284654','山田市','村山町','小泉町藤本1-1-8',NULL,NULL,NULL,NULL,'松本','聡太郎','ダミーのため一致しません','ダミーのため一致しません','04276-1-2481','0964-85-2855',NULL,2,1,'1799022','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいが鉄砲丸てっぽうだい」黒服くろふくだ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1271,'satomi.kato@example.org','$2y$10$UnPLx72goC1B.07AGAHXH.Jf/hqqyhkiY6vN5xiVDjbqcoZOKX5lO','株式会社 田辺','9597632','青田市','山本町','佐々木町小林3-3-1',NULL,NULL,NULL,NULL,'宇野','智也','ダミーのため一致しません','ダミーのため一致しません','049-214-8770','05899-8-3489',NULL,1,2,'2707352','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ二百年ころもちが過ぎ、ジョバンニは川が。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1281,'takuma.sato@example.org','$2y$10$MSj27MVkd46kr9XL8ZTyhudb1gGySUkkjeTCdGtxr05cV6BujXBDa','株式会社 山田','5547520','工藤市','原田町','小林町青山8-9-4',NULL,NULL,NULL,NULL,'喜嶋','直子','ダミーのため一致しません','ダミーのため一致しません','0460-492-863','09406-6-1398',NULL,3,3,'9655379','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはその中で決心けっしゃばやくくり網棚あ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1291,'ykudo@example.org','$2y$10$i7TzdUyTzswYuZ1ItlcEKOdswZDAu1ZxqYGBDvhzwcAsaeHuE5hMC','有限会社 青山','2668039','井上市','佐々木町','石田町渡辺3-7-9',NULL,NULL,NULL,NULL,'石田','太郎','ダミーのため一致しません','ダミーのため一致しません','080-5984-5272','09-2362-6923',NULL,1,4,'2165599','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータちにくりお父さんかくれんなことなります。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1301,'tomoya23@example.org','$2y$10$UJA6H2axoDRmsC6MSwGjFegHnpknSllPM.5mJqdaJj1EbBHDjn61y','有限会社 工藤','6163566','佐々木市','佐々木町','小泉町山口4-2-2',NULL,NULL,NULL,NULL,'田辺','千代','ダミーのため一致しません','ダミーのため一致しません','02-8414-2142','0170-200-457',NULL,2,2,'6508818','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータあるいは電いな汽車はほんとうの数珠じゅ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1311,'akemi54@example.net','$2y$10$DCiNNAZLku9tARvVovy04Os/3KFTW3M2ZoqYS8O/K18WNx8/pqjvm','有限会社 桐山','3426399','鈴木市','渚町','中津川町青山3-10-8',NULL,NULL,NULL,NULL,'石田','淳','ダミーのため一致しません','ダミーのため一致しません','080-0707-6994','04-1003-3472',NULL,2,1,'1139205','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぎしの大きなものが書いて、まるではいき。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1321,'duno@example.org','$2y$10$vXURM2tDt3qg6nk983kGNuFOKBE.YWUj2DkHi5R.lWMZeXnjpnJYq','有限会社 宮沢','2157571','佐々木市','小林町','西之園町吉本8-4-4',NULL,NULL,NULL,NULL,'渚','陽一','ダミーのため一致しません','ダミーのため一致しません','07-2068-6811','05712-3-5058',NULL,0,2,'9792220','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ日教室でもかけているようにそむく罪つみ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1331,'kazuya.sakamoto@example.org','$2y$10$vun90RaJzv8vm56zLc9x5uaotfE9jrvJnEYbhvFWqQGPvQkGZP00C','有限会社 田中','8159123','江古田市','小泉町','喜嶋町西之園3-1-8',NULL,NULL,NULL,NULL,'津田','裕樹','ダミーのため一致しません','ダミーのため一致しません','07-0863-8617','071-883-1591',NULL,1,3,'4579212','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータした。その手首てくるっと柄がら訊ききょ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1341,'yumiko.aota@example.org','$2y$10$JKfSOvaAC25fg7zJB7ARyOa/SmcurBmanEMD91E2RKCFxcJMww8CC','有限会社 村山','1492102','佐々木市','喜嶋町','三宅町西之園4-2-5',NULL,NULL,NULL,NULL,'渚','充','ダミーのため一致しません','ダミーのため一致しません','000-851-2598','02175-2-3036',NULL,0,4,'9839813','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータまざまに召めされ、ジョバンニはどこから。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1351,'murayama.hiroshi@example.net','$2y$10$t.RgLEPn.o6vznY5QR9Nju6o/l1R06PJUWF5Y0KRosQHG7eJOzfdK','株式会社 井高','9635708','中島市','伊藤町','小林町中村9-6-7',NULL,NULL,NULL,NULL,'宇野','英樹','ダミーのため一致しません','ダミーのため一致しません','06534-6-7591','039-723-5434',NULL,3,1,'7115035','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータおっかているのが見えました。そらの水が。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1361,'ymiyazawa@example.org','$2y$10$xFx9L9esxYxfDFW.m6PvMejDEKsJHMPWUgKyCBv3jB7etRw28WTwS','株式会社 斉藤','4031720','三宅市','青山町','工藤町坂本1-7-4',NULL,NULL,NULL,NULL,'若松','裕美子','ダミーのため一致しません','ダミーのため一致しません','0310-075-552','087-527-3550',NULL,3,2,'4058243','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータのった帽子ぼうしように立ちあがり、三度。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1371,'uhamada@example.com','$2y$10$641TuKgvYhZ.nAeobpeuqeLOj7lYsFj8sxTF410Tsnws1O.7WNivm','株式会社 伊藤','6695071','井高市','中村町','佐藤町青田8-8-5',NULL,NULL,NULL,NULL,'大垣','さゆり','ダミーのため一致しません','ダミーのため一致しません','07-5086-0846','090-8142-7214',NULL,0,4,'5479008','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータわるくるみの実みだよ。ひやかなかったの。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1381,'ekondo@example.net','$2y$10$3PwovXPdE7YnJMAUYDG/B.9s6e7LlJXJw6scx3HCZRlY2Qacb1QAG','有限会社 高橋','2315002','田辺市','渚町','佐々木町高橋6-8-6',NULL,NULL,NULL,NULL,'西之園','晃','ダミーのため一致しません','ダミーのため一致しません','0230-115-864','08-8243-2241',NULL,0,1,'4428415','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータわくなそんなたくしから四十五分たちはす。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1391,'naoko44@example.org','$2y$10$qJRpzYfIi6dUksuItJ/dqu9IztNve14hNCS8zKKv4afyG3R66A0Ci','有限会社 吉田','1059310','田辺市','村山町','渚町杉山6-10-4',NULL,NULL,NULL,NULL,'山本','香織','ダミーのため一致しません','ダミーのため一致しません','048-426-8370','01-3743-7384',NULL,3,3,'1719116','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータづめのような声がして叫さけびました。「。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1401,'mikako.kiriyama@example.org','$2y$10$TBcgsuB4/mWT3Aq8h.Z7auB3TTg3g5Ir5AXNUzOm9BZTB8hHHJBAm','株式会社 井上','3115022','加納市','工藤町','井高町桐山6-4-3',NULL,NULL,NULL,NULL,'江古田','篤司','ダミーのため一致しません','ダミーのため一致しません','090-0257-1885','019-152-2135',NULL,3,4,'3053926','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータまっすぐそこへ来て、がら、ぼんやり言い。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1411,'hideki61@example.org','$2y$10$8.XiJH6n5RaRCwXjmCMLDuWMM0fZd/7rrR0lo35kRxJJMIsYyzw3q','有限会社 佐藤','8826183','中島市','小泉町','江古田町加納2-1-7',NULL,NULL,NULL,NULL,'喜嶋','陽一','ダミーのため一致しません','ダミーのため一致しません','09505-2-0630','0590-843-981',NULL,2,3,'8557688','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータを通っているのが一つのお母さんこうとし。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1421,'akemi34@example.net','$2y$10$h8Bi3f.W1z216UHhY28ppuLj9vZuFK2l.l2T3xBnLa1bJq4lKoLu2','株式会社 江古田','3432604','青田市','山本町','吉田町中津川2-1-3',NULL,NULL,NULL,NULL,'青田','拓真','ダミーのため一致しません','ダミーのため一致しません','03-0725-7639','08130-3-7631',NULL,0,4,'7431927','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ二人ふたりラムプシェードをかぶとむしが。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1431,'yui11@example.com','$2y$10$oPIEfWGSt0JYtZPTPT4MY.VENoZ0YNC09LuV9XDCovG5FdKD3i6BW','株式会社 松本','7999627','村山市','近藤町','吉本町田中4-4-1',NULL,NULL,NULL,NULL,'松本','里佳','ダミーのため一致しません','ダミーのため一致しません','04-0664-8136','0314-60-4264',NULL,1,3,'1594025','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータそとをした。ほんとうに急いそぎまぎしち。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1441,'atsushi89@example.com','$2y$10$vS.z7ioYFmxwuWxEq3sZSuqu9oNpFtkcuIq8Hsn2iaHiIrI61o32q','株式会社 高橋','3491578','村山市','桐山町','山口町山田10-7-3',NULL,NULL,NULL,NULL,'鈴木','涼平','ダミーのため一致しません','ダミーのため一致しません','090-7599-1274','0680-916-825',NULL,2,1,'2151128','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ方を見ると、ぼくはどうしをたてていまし。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1451,'maaya.sato@example.net','$2y$10$ncrAjN1mstEAoCYKOuhF4.PQOeNPiJ.C6B3sDuLAbuzqcRyW6uB9e','有限会社 渚','5229475','坂本市','野村町','木村町田中2-6-8',NULL,NULL,NULL,NULL,'宇野','翼','ダミーのため一致しません','ダミーのため一致しません','08063-2-8405','09509-2-8234',NULL,0,4,'5953625','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータものが見えました。「ぼくはどこまるで遠。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:42','2021-03-14 15:36:42'),(1461,'mikako49@example.org','$2y$10$HPmoi06ewS5qRepjKX.jeuO2QlUxEPBSWHrkdTbzBwEdLU3u.sb7.','有限会社 江古田','4428901','坂本市','石田町','喜嶋町杉山9-2-8',NULL,NULL,NULL,NULL,'中津川','七夏','ダミーのため一致しません','ダミーのため一致しません','0797-94-6043','068-055-6835',NULL,0,1,'3747598','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータずや、うつってきました。「さあもう一つ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(1471,'osamu82@example.org','$2y$10$oRh52VhFwzlpOCwSGOpj6eaZWs/CZADDLQFf9kTm3o3RJnzzemoBm','株式会社 若松','3922434','井高市','坂本町','小林町工藤8-8-3',NULL,NULL,NULL,NULL,'松本','零','ダミーのため一致しません','ダミーのため一致しません','080-5333-2698','05628-8-0948',NULL,3,4,'7699156','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんぱいしゃるし、みんなほんとうを着きて。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(1481,'eito@example.net','$2y$10$WsZVVkQDwUY7zJaTZ01/yehtWjmg7De3TWxtVGkAwXv.7MPWP/L7e','株式会社 渚','4359328','工藤市','村山町','斉藤町伊藤5-3-2',NULL,NULL,NULL,NULL,'野村','康弘','ダミーのため一致しません','ダミーのため一致しません','080-4921-9613','0369-98-2899',NULL,0,4,'9067280','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいになるように見えました。ジョバンニさ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(1491,'kidaka@example.org','$2y$10$PmMZEQSt51/m0PHq6ozE5.G6QfAsOY84TMTaqFMrGNuXX7CiUPY0.','株式会社 江古田','6235806','村山市','桐山町','若松町三宅3-4-9',NULL,NULL,NULL,NULL,'中津川','くみ子','ダミーのため一致しません','ダミーのため一致しません','0950-32-7370','00-6205-6952',NULL,1,3,'2981962','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータらいました。「ハレルヤ、ハレルヤ、ハレ。',NULL,NULL,1,1,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(1511,'admin@admin.admin','$2y$10$b/6RwYwVDhUMnXRwAtMHr.ODrHObM6I.MjZkfY6JWGN7h4KbOyBKa','株式会社トリックスター','5420076','大阪府','大阪市中央区難波',NULL,NULL,NULL,1,'平日% 土日% 3週間前%','大山','紘一郎','オオヤマ','コウイチロウ','09050666483',NULL,NULL,1,1,'5650821','吹田市山田東1-34-1','吹田市山田東',NULL,NULL,NULL,NULL,1,1,NULL,'2021-03-14 17:59:46','2021-03-14 17:59:46');
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
  `size1` int(11) NOT NULL,
  `size2` int(11) NOT NULL,
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
  `reserver_company` varchar(191) DEFAULT NULL,
  `reserver_tel` varchar(191) DEFAULT NULL,
  `reserver_fax` varchar(191) DEFAULT NULL,
  `reserver_remark` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,0,'四ツ橋（消さないで！料金、営業時間変えないで！）','サンワールドビル','1号室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 22:59:48'),(11,0,'四ツ橋','サンワールドビル','2号室(音響HG)',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(21,0,'トリックスター','We Work','執務室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(31,0,'四ツ橋','テストビル','テスト号室（削除しないでください）',100,300,999,1,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル11階','テストです','中務','真梨子','ナカム','マリコ','0665384329','nakamu@s-mg.co.jp',0,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル11階','SMG貸し会議室','0000000000',NULL,'株式会社ビル管理','0611112222','0699998888','テスト','テスト',NULL,'test@s-mg.co.jp','0600007777',NULL,'テストです','https://osaka-conference.com/rental/yb-sunworld/recreation/','5：45～21：30','7：00～21：00','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(41,0,'梅田','梅田','101',33,20,20,0,'5580013','大阪府','大阪市住吉区我孫子東101','梅田',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/recreation/#tab-1',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 20:52:49','2021-03-14 20:52:49'),(51,1,'大阪','我孫子','1（消さないで触らないで！）',999,999,30,1,'5500014','大阪府','大阪市西区北堀江','我孫子ビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/recreation/#tab-3',NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:22:04','2021-03-14 22:26:13'),(61,1,'あ','ああ','あ',999,999,30,0,'5500014','大阪府','大阪市西区北堀江1','あ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(71,0,'大国町（消さないでください！）','ZEPPホール','1F',30,999,30,0,'5500014','大阪府','大阪市西区北堀江1','ZEPPホール','2/1堺谷\r\nああああああああああああああああああああああああああああああああああああああああああああ\r\n\r\nあああああああああああああああああああああああああああああああああああああああああああ\r\n\r\nああああああああああああああああああああああああああ\r\n\r\nhttps://osaka-conference.com/rental/\r\n\r\n\r\n\r\n\r\n1/31　\r\nああああああああああああああああああああああああああああああああ\r\n\r\n\r\nああああああああああああああああああああああああああああああ',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:31:26','2021-03-14 21:32:10'),(81,0,'長居','長居駅前ビル','106号室',200,220,220,1,'5500014','大阪府','大阪市西区北堀江','長居駅前ビル','ああああああ\r\n改行\r\nあああああああああああ\r\n改行\r\n改行\r\nああああああああああ',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(91,0,'西田辺','りくろおじさんビル','5F',20,20,20,0,'5500014','大阪府','大阪市西区北堀江1','りくろおじさんビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(101,0,'昭和町','（消さないで料金、時間も含め編集しないで！）昭和町スクエアビル','202',20,20,20,0,'5500014','大阪府','大阪市西区北堀江1','昭和町スクエアビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(111,0,'中務テスト','サンワールドビル','あ',100,100,100,0,'5500014','大阪府','北堀江1丁目6-2','サンワールドビル11階',NULL,'中務','真梨子','ナカム','マリコ',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-kinsyo/10a/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 16:08:08','2021-03-15 16:08:08'),(121,0,'山田太郎のテスト会場','あああ','あああ',100,100,100,1,'5500000','大阪府','大阪市西','サンワールドビル11階',NULL,'山田','太郎','ヤマダ','タロウ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ザイマックス','0612304567','09011112222','管理','太郎',NULL,'kanri@zaimx.com','0120789654',NULL,'テストテストテストテスト','https://osaka-conference.com/rental/yb-kinsyo/10a/',NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 16:11:09','2021-03-15 17:14:22');
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

-- Dump completed on 2021-04-06 13:53:09
