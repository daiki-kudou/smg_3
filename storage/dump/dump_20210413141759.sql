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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (4,'管理者','admin@example.com','$2y$10$FS9cJD0vDYTUcHTilM8JNuRR52Hwk6Gd4StreSle01aL8W8clKw2.','OFo8Pb0JItEtdewh62JdmFH2eWr0u4ZxCE4O550OUjsXamzubzI7cXs7xBc7',NULL,NULL),(14,'中務真梨子','nakamu@nakamu.com','$2y$10$kQsSyhc9QE670fFvEedtZeYeyu/2j5KwDMAiJiJyMl8Ckw2vBtXdC','Zhv3nrzPqXKOTo3i89wPzbElKoIs3T58bYHWxTC6xVJZKv2is39UJeRBAsp0',NULL,NULL),(24,'堺谷カツ美','sakaitani@sakaitani.com','$2y$10$PcSo0wsKPBs87FRALzdio.fKZicTS/7zZw.Lszh4E97bE41Ds2XT2','CyYUBGBaRo',NULL,NULL),(34,'薄雲一','usugumo@usugumo.com','$2y$10$nTXeyG2jYj5xH9HiD5BZMe0EM0gQ0GkK9p7cX/ROpTN2YMjvaxomy','CIJPHYEivT',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=634 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (221,'haruka56','株式会社 青山','1767144','石田市','津田町','野村町山岸3-7-9','涼平','鈴木','千代','原田','0560-00-2746','03302-4-9276','0650-018-133','akira67@yahoo.co.jp',80,1,NULL,'特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','2021-03-14 15:36:43','2021-03-16 11:34:45'),(261,'lkiriyama','有限会社 三宅','6513005','高橋市','佐藤町','青山町田辺5-1-5','春香','笹田','康弘','木村','0503-66-9974','0410-540-422','0000-928-395','tsubasa28@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:43','2021-03-14 15:36:43'),(271,'saito.chiyo','株式会社 近藤','6849614','江古田市','小林町','小林町杉山3-7-6','直子','渡辺','洋介','西之園','036-974-5064','0684-15-1888','090-3426-5734','xkobayashi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(281,'atsushi72','有限会社 若松','4852300','宇野市','喜嶋町','青田町杉山10-1-8','裕樹','佐藤','淳','宇野','06-9240-6326','0360-054-547','0570-308-202','dkobayashi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(291,'shota.sato','有限会社 山口','4213395','浜田市','笹田町','桐山町藤本8-6-4','直樹','吉田','裕太','小泉','090-9980-3588','08941-0-1661','0441-25-1802','chiyo05@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(301,'yuki34','株式会社 渚','3061240','松本市','鈴木町','吉田町山岸6-9-2','稔','加藤','香織','斉藤','080-2395-0448','07-3596-3429','08-3153-7542','naoto69@tanabe.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(311,'ifujimoto','株式会社 江古田','8586376','渚市','田中町','桐山町三宅10-5-9','あすか','井上','智也','伊藤','02-4347-1340','090-6947-3640','03973-5-2048','yamaguchi.kumiko@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(321,'skudo','株式会社 野村','1236426','青田市','青田町','青山町大垣8-3-7','美加子','大垣','くみ子','江古田','090-2919-9393','080-8317-4971','080-0071-2413','kimura.atsushi@sasaki.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(331,'fsasaki','有限会社 近藤','3212600','大垣市','佐々木町','渚町三宅2-1-9','零','中村','康弘','笹田','0420-359-228','04933-8-2019','0516-18-3936','atsushi18@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(341,'yuki.tanaka','株式会社 喜嶋','6846176','三宅市','井上町','大垣町工藤3-9-2','稔','佐々木','さゆり','宇野','080-6386-0418','0960-743-768','00-1872-8498','nsato@yoshida.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(351,'hideki80','株式会社 井高','6464475','加納市','近藤町','若松町高橋3-6-2','聡太郎','工藤','結衣','近藤','03280-0-9214','01-0777-1142','080-2794-7519','yasuhiro.wakamatsu@hamada.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(361,'shota.yamagishi','株式会社 桐山','7397584','宮沢市','青山町','小林町高橋2-3-9','七夏','近藤','七夏','松本','0240-812-019','080-1331-4929','090-8402-4315','sasaki.kenichi@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(371,'takuma.kijima','有限会社 宮沢','7441881','工藤市','山本町','田辺町桐山2-8-6','七夏','工藤','美加子','青山','031-918-8279','090-2269-1589','0790-262-416','taichi82@wakamatsu.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(381,'yamaguchi.momoko','株式会社 高橋','4241812','中村市','田中町','加藤町宮沢1-8-6','直人','杉山','英樹','中島','01727-6-1754','07724-0-7787','03-6272-6852','hideki.sato@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(401,'naoto.kiriyama','有限会社 津田','4494908','佐藤市','小泉町','中島町宮沢5-9-7','康弘','宇野','拓真','江古田','015-651-3100','090-8049-7895','07-6396-1985','hirokawa.mitsuru@miyazawa.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(411,'rhirokawa','株式会社 井上','4907031','吉田市','中村町','佐藤町田中5-8-6','あすか','廣川','あすか','石田','0871-60-6112','02-1974-5464','0830-575-762','tomoya24@uno.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(421,'btanaka','株式会社 青山','3566582','渡辺市','桐山町','坂本町桐山7-1-2','知実','加藤','太一','原田','090-1779-1432','03072-0-4227','06-4740-6970','satomi27@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(431,'kyosuke.kato','有限会社 杉山','6946134','伊藤市','野村町','桐山町佐藤5-5-1','太郎','吉本','知実','坂本','056-113-6300','01-4453-4443','080-2321-6757','kazuya.kondo@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(441,'hirokawa.haruka','有限会社 廣川','7405096','木村市','村山町','桐山町山本10-10-8','治','藤本','篤司','近藤','07222-9-3072','09-1024-5761','0370-829-973','ynakatsugawa@yoshida.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(451,'miki.nakamura','株式会社 加納','8285675','田中市','三宅町','高橋町加藤1-6-2','あすか','松本','舞','江古田','02662-7-3278','040-777-7650','090-3883-4533','atakahashi@yamagishi.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(461,'hanako.matsumoto','有限会社 江古田','6707692','斉藤市','渚町','加藤町江古田8-7-3','陽子','高橋','千代','小泉','0211-29-4749','0050-130-952','090-0390-9445','miki94@miyake.info',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(471,'unishinosono','有限会社 鈴木','4911832','三宅市','田中町','井高町高橋5-10-7','結衣','松本','桃子','浜田','0580-066-012','0760-246-137','0747-33-6995','naoko96@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-03-14 15:36:44'),(551,'HAKO　ROOM','ｓ','5500011','大阪府','大阪市西区阿波座1','梅田ビル','堺堺谷','sa','sasa','s','06','066666','666','sakaitani@cocrework.jp',80,1,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ',NULL,NULL,NULL,NULL,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ','ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ',NULL,1,NULL,NULL,'ああああ\r\n\r\n改行\r\n\r\n\r\n改行\r\n\r\n\r\nあああああああ','2021-03-15 14:30:13','2021-03-15 14:30:13'),(554,'Instabase','株式会社Rebase',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,30,1,NULL,NULL,'Instabase（インスタベース）','https://www.instabase.jp/','https://www.instabase.jp/partners/sign_in','kkkkk','mmmmmm',NULL,NULL,NULL,1,NULL,NULL,'管理画面上のメッセージ機能を使ってやり取りするので、電話番号などはなし','2021-04-12 00:57:10','2021-04-12 00:58:35'),(564,'スペイシー（サービス名称）','株式会社スペイシー','5500014','大阪府','大阪市西区北堀江','サンワールドビル11Fサンワールドビル11Fサンワールドビル11Fサンワールドビル11Fサンワールドビル11Fサンワールドビル11F','中務','真梨子','ナカム','マリコ','0665566462','0665498765','0665479856','nakamu@s-mg.co.jp',75,2,NULL,'決済条件備考\r\n\r\n売上が5万円以上の場合は、当月末締め/翌月末払い。\r\n売上が4万9999円以下の場合は、5万円以上になるまで繰り越される。\r\n振り込み手数料が売上金額によって違う。','スペイシー（サイト情報）','https://www.spacee.jp/','https://www.spacee.jp/provider_users/sign_in','kaigi@s-mg.co.jp','kaigi@s-mg.co.jp',NULL,'サイト情報テストテストテストテスト\r\n\r\nサイト情報テストテスト\r\n\r\nサイト情報テストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\nサイト情報テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト','取引条件の取引詳細テストテストテストテスト\r\n\r\n取引条件の取引詳細テストテスト\r\n\r\n取引条件の取引詳細テストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n取引条件の取引詳細テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト',2,'https://www.spacee.jp/how_it_works/user','取引条件の備考テストテストテストテスト\r\n\r\n取引条件の備考テストテスト\r\n\r\n取引条件の備考テストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\n取引条件の備考テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト','基本情報テストテストテストテスト\r\n\r\n基本情報テストテスト\r\n\r\n基本情報テストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\n基本情報テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト','2021-04-12 19:35:05','2021-04-12 19:43:34'),(574,'日本会議室',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,70,1,NULL,NULL,NULL,'https://www.nipponkaigishitsu.com/','https://www.nipponkaigishitsu.com/',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2021-04-12 19:36:15','2021-04-12 20:15:31'),(584,'会議室コンシェルジュ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,70,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2021-04-12 19:36:36','2021-04-12 19:36:36'),(594,'スペースマーケット',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,70,1,NULL,NULL,NULL,'https://www.spacemarket.com/','https://osaka-conference.com/',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2021-04-12 19:36:55','2021-04-12 20:05:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=1814 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dates`
--

LOCK TABLES `dates` WRITE;
/*!40000 ALTER TABLE `dates` DISABLE KEYS */;
INSERT INTO `dates` VALUES (1,1,1,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(11,1,2,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-17 11:00:10'),(21,1,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(31,1,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(41,1,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(51,1,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(61,1,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(71,11,1,'10:30:00','22:30:00','2021-03-14 15:36:44','2021-03-15 00:45:25'),(81,11,2,'13:00:00','23:00:00','2021-03-14 15:36:44','2021-04-12 19:49:04'),(91,11,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(101,11,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(111,11,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(121,11,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(131,11,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(141,21,1,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(151,21,2,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(161,21,3,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-04-09 13:49:49'),(171,21,4,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(181,21,5,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(191,21,6,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(201,21,7,'08:00:00','23:00:00','2021-03-14 15:36:44','2021-03-14 15:36:44'),(211,31,1,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(221,31,2,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(231,31,3,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(241,31,4,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(251,31,5,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(261,31,6,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(271,31,7,'08:00:00','23:00:00','2021-03-14 18:27:25','2021-03-14 18:27:25'),(281,41,1,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-04-12 00:37:49'),(291,41,2,'16:30:00','23:00:00','2021-03-14 20:52:49','2021-04-12 19:51:18'),(301,41,3,'11:30:00','23:00:00','2021-03-14 20:52:49','2021-04-12 19:49:40'),(311,41,4,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(321,41,5,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(331,41,6,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(341,41,7,'08:00:00','23:00:00','2021-03-14 20:52:49','2021-03-14 20:52:49'),(351,51,1,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(361,51,2,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(371,51,3,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(381,51,4,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(391,51,5,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(401,51,6,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(411,51,7,'08:00:00','23:00:00','2021-03-14 21:22:04','2021-03-14 21:22:04'),(421,61,1,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(431,61,2,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(441,61,3,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(451,61,4,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(461,61,5,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(471,61,6,'08:00:00','23:00:00','2021-03-14 21:26:59','2021-03-14 21:26:59'),(481,61,7,'08:00:00','21:00:00','2021-03-14 21:26:59','2021-04-09 13:50:40'),(491,71,1,'08:00:00','23:00:00','2021-03-14 21:31:26','2021-03-14 21:31:26'),(501,71,2,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(511,71,3,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(521,71,4,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(531,71,5,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(541,71,6,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(551,71,7,'08:00:00','23:00:00','2021-03-14 21:31:27','2021-03-14 21:31:27'),(561,81,1,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-04-12 19:47:11'),(571,81,2,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-04-12 19:47:15'),(581,81,3,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(591,81,4,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(601,81,5,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(611,81,6,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(621,81,7,'08:00:00','23:00:00','2021-03-15 09:40:50','2021-03-15 09:40:50'),(631,91,1,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(641,91,2,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(651,91,3,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(661,91,4,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(671,91,5,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(681,91,6,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(691,91,7,'08:00:00','23:00:00','2021-03-15 09:42:56','2021-03-15 09:42:56'),(701,101,1,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(711,101,2,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(721,101,3,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(731,101,4,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(741,101,5,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(751,101,6,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(761,101,7,'08:00:00','23:00:00','2021-03-15 10:33:59','2021-03-15 10:33:59'),(771,111,1,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(781,111,2,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(791,111,3,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(801,111,4,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(811,111,5,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(821,111,6,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(831,111,7,'08:00:00','23:00:00','2021-03-15 16:08:09','2021-03-15 16:08:09'),(841,121,1,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(851,121,2,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(861,121,3,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(871,121,4,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(881,121,5,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(891,121,6,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(901,121,7,'08:00:00','23:00:00','2021-03-15 16:11:09','2021-03-15 16:11:09'),(904,124,1,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(914,124,2,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(924,124,3,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(934,124,4,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(944,124,5,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(954,124,6,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(964,124,7,'08:00:00','23:00:00','2021-04-09 13:15:49','2021-04-09 13:15:49'),(974,134,1,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(984,134,2,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(994,134,3,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(1004,134,4,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(1014,134,5,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(1024,134,6,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(1034,134,7,'08:00:00','23:00:00','2021-04-09 17:44:51','2021-04-09 17:44:51'),(1044,144,1,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1054,144,2,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1064,144,3,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1074,144,4,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1084,144,5,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1094,144,6,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1104,144,7,'08:00:00','23:00:00','2021-04-09 18:44:26','2021-04-09 18:44:26'),(1114,154,1,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1124,154,2,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1134,154,3,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1144,154,4,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1154,154,5,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1164,154,6,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1174,154,7,'08:00:00','23:00:00','2021-04-10 07:54:20','2021-04-10 07:54:20'),(1184,164,1,'08:00:00','23:00:00','2021-04-10 14:06:49','2021-04-10 14:11:07'),(1194,164,2,'08:00:00','23:00:00','2021-04-10 14:06:49','2021-04-10 14:06:49'),(1204,164,3,'08:00:00','23:00:00','2021-04-10 14:06:49','2021-04-10 14:06:49'),(1214,164,4,'08:00:00','23:00:00','2021-04-10 14:06:49','2021-04-10 14:06:49'),(1224,164,5,'08:00:00','23:00:00','2021-04-10 14:06:49','2021-04-10 14:06:49'),(1234,164,6,'10:00:00','21:30:00','2021-04-10 14:06:49','2021-04-10 14:12:15'),(1244,164,7,'10:00:00','21:30:00','2021-04-10 14:06:49','2021-04-10 14:12:31'),(1254,174,1,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:29:16'),(1264,174,2,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1274,174,3,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1284,174,4,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1294,174,5,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1304,174,6,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1314,174,7,'08:00:00','23:00:00','2021-04-12 00:20:59','2021-04-12 00:20:59'),(1324,184,1,'23:00:00','23:00:00','2021-04-12 00:43:39','2021-04-12 00:46:13'),(1334,184,2,'23:00:00','23:00:00','2021-04-12 00:43:39','2021-04-12 00:46:19'),(1344,184,3,'23:00:00','23:00:00','2021-04-12 00:43:39','2021-04-12 00:46:27'),(1354,184,4,'23:00:00','23:00:00','2021-04-12 00:43:39','2021-04-12 00:46:33'),(1364,184,5,'23:00:00','23:00:00','2021-04-12 00:43:40','2021-04-12 00:46:39'),(1374,184,6,'23:00:00','23:00:00','2021-04-12 00:43:40','2021-04-12 00:46:45'),(1384,184,7,'23:00:00','23:00:00','2021-04-12 00:43:40','2021-04-12 00:46:51'),(1394,194,1,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1404,194,2,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1414,194,3,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1424,194,4,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1434,194,5,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1444,194,6,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1454,194,7,'08:00:00','23:00:00','2021-04-12 17:36:13','2021-04-12 17:36:13'),(1464,204,1,'08:00:00','23:00:00','2021-04-12 18:15:34','2021-04-12 18:15:34'),(1474,204,2,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1484,204,3,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1494,204,4,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1504,204,5,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1514,204,6,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1524,204,7,'08:00:00','23:00:00','2021-04-12 18:15:35','2021-04-12 18:15:35'),(1534,214,1,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1544,214,2,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1554,214,3,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1564,214,4,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1574,214,5,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1584,214,6,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1594,214,7,'08:00:00','23:00:00','2021-04-12 18:25:52','2021-04-12 18:25:52'),(1604,224,1,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1614,224,2,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1624,224,3,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1634,224,4,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1644,224,5,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1654,224,6,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1664,224,7,'08:00:00','23:00:00','2021-04-12 19:01:29','2021-04-12 19:01:29'),(1674,234,1,'08:00:00','23:00:00','2021-04-12 19:31:49','2021-04-12 19:31:49'),(1684,234,2,'08:00:00','23:00:00','2021-04-12 19:31:49','2021-04-12 19:31:49'),(1694,234,3,'08:00:00','23:00:00','2021-04-12 19:31:49','2021-04-12 19:31:49'),(1704,234,4,'08:00:00','23:00:00','2021-04-12 19:31:50','2021-04-12 19:31:50'),(1714,234,5,'08:00:00','23:00:00','2021-04-12 19:31:50','2021-04-12 19:31:50'),(1724,234,6,'08:00:00','23:00:00','2021-04-12 19:31:50','2021-04-12 19:31:50'),(1734,234,7,'08:00:00','23:00:00','2021-04-12 19:31:50','2021-04-12 19:31:50'),(1744,244,1,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1754,244,2,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1764,244,3,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1774,244,4,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1784,244,5,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1794,244,6,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01'),(1804,244,7,'08:00:00','23:00:00','2021-04-12 20:32:01','2021-04-12 20:32:01');
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
  `mobile` varchar(191) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=754 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_venue`
--

LOCK TABLES `equipment_venue` WRITE;
/*!40000 ALTER TABLE `equipment_venue` DISABLE KEYS */;
INSERT INTO `equipment_venue` VALUES (1,1,21,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(11,1,31,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(21,1,41,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(31,1,61,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(61,1,101,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(71,1,121,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(91,1,151,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(101,1,181,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(111,31,21,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(121,31,41,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(131,31,61,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(141,51,21,'2021-03-14 21:22:04','2021-03-14 21:22:04'),(151,51,41,'2021-03-14 21:22:04','2021-03-14 21:22:04'),(161,61,1,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(171,81,1,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(181,81,31,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(191,91,1,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(201,91,31,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(211,101,1,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(221,111,21,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(231,111,31,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(241,121,11,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(251,121,41,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(261,121,51,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(264,124,1,'2021-04-09 13:15:48','2021-04-09 13:15:48'),(274,124,21,'2021-04-09 13:15:48','2021-04-09 13:15:48'),(294,124,121,'2021-04-09 13:15:48','2021-04-09 13:15:48'),(304,134,21,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(314,134,31,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(324,134,41,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(334,134,61,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(364,134,91,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(374,134,101,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(384,134,111,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(394,144,21,'2021-04-09 18:44:26','2021-04-09 18:44:26'),(404,144,51,'2021-04-09 18:44:26','2021-04-09 18:44:26'),(424,154,21,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(434,154,51,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(444,154,91,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(454,154,121,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(474,164,1,'2021-04-10 14:06:49','2021-04-10 14:06:49'),(484,164,11,'2021-04-10 14:06:49','2021-04-10 14:06:49'),(494,164,21,'2021-04-10 14:06:49','2021-04-10 14:06:49'),(504,174,1,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(514,174,11,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(524,174,21,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(534,174,41,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(544,174,61,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(564,174,91,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(574,174,111,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(584,174,121,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(594,184,21,'2021-04-12 00:43:39','2021-04-12 00:43:39'),(604,184,31,'2021-04-12 00:43:39','2021-04-12 00:43:39'),(624,194,31,'2021-04-12 17:36:13','2021-04-12 17:36:13'),(634,194,41,'2021-04-12 17:36:13','2021-04-12 17:36:13'),(644,224,1,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(654,224,11,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(664,224,21,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(674,224,51,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(684,224,61,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(694,224,121,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(704,224,364,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(714,234,1,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(724,234,21,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(734,234,41,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(744,244,61,'2021-04-12 20:32:01','2021-04-12 20:32:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=444 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
INSERT INTO `equipments` VALUES (1,'有線マイク',3000,10,NULL,'2021-03-14 15:36:43',NULL),(11,'無線マイク',3000,10,NULL,'2021-03-14 15:36:43',NULL),(21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(31,'【追加】次亜塩素酸水専用・超音波加湿器',500,10,NULL,'2021-03-14 15:36:43',NULL),(41,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(51,'ホワイトボード（幅120㎝）',2500,10,NULL,'2021-03-14 15:36:43',NULL),(61,'プロジェクター',3000,10,NULL,'2021-03-14 15:36:43',NULL),(91,'iphone(Lightning)⇔VGA変換ケーブル',1000,10,NULL,'2021-03-14 15:36:43',NULL),(101,'iphone(Lightning)DVDプレイヤー',2000,10,NULL,'2021-03-14 15:36:43',NULL),(111,'CDプレイヤー',1000,10,NULL,'2021-03-14 15:36:43',NULL),(121,'持ち運びパーテーション',1000,10,NULL,'2021-03-14 15:36:43',NULL),(151,'あ',1,99,'サンワールド1号室','2021-03-14 17:40:21','2021-03-14 17:41:21'),(181,'ｓ',123,9977,NULL,'2021-03-14 17:41:33','2021-03-14 17:41:33'),(221,'123',1,12,NULL,'2021-03-14 20:20:27','2021-04-06 19:07:51'),(241,'b半角',1,1,NULL,'2021-03-14 20:22:47','2021-03-14 20:23:20'),(251,'ｂ全角',5,1,'あい','2021-03-14 20:23:09','2021-04-06 20:06:16'),(304,'ファイル',50,1,NULL,'2021-04-09 13:21:05','2021-04-09 13:21:05'),(314,'HDMI⇔HDMIケーブル',1000,1,'長さ5ｍ','2021-04-10 08:13:02','2021-04-10 08:13:02'),(364,'ノートパソコン',10000,1,'電源アダプター、マウス付属\r\n\r\n改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト\r\n改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト','2021-04-12 00:48:32','2021-04-12 01:04:05'),(394,'テスト1',1000,1,NULL,'2021-04-12 01:21:11','2021-04-12 01:21:11'),(404,'テスト2',1000,1,NULL,'2021-04-12 01:21:24','2021-04-12 01:21:24'),(434,'て',2,1000000000,NULL,'2021-04-12 18:19:11','2021-04-12 18:19:11');
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
) ENGINE=InnoDB AUTO_INCREMENT=954 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_prices`
--

LOCK TABLES `frame_prices` WRITE;
/*!40000 ALTER TABLE `frame_prices` DISABLE KEYS */;
INSERT INTO `frame_prices` VALUES (271,31,'午前','08:00:00','12:00:00',10000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(281,31,'午前＆午後','10:00:00','17:00:00',15000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(291,31,'午後','13:00:00','17:00:00',30000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(301,31,'夜間','18:00:00','21:00:00',10000,5000,'2021-03-14 18:40:36','2021-03-14 18:40:36'),(311,41,'午前','08:00:00','12:00:00',10000,500,'2021-03-14 22:48:30','2021-03-14 22:48:30'),(531,101,'午前','10:00:00','12:00:00',15000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(541,101,'午後','13:00:00','17:00:00',10000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(551,101,'午前＆午後','10:00:00','17:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(561,101,'夜間','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(571,101,'午前＆午後','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(581,101,'午後＆夜間','18:00:00','23:00:00',20000,1000,'2021-03-15 10:38:42','2021-03-15 10:38:42'),(591,1,'午前','10:00:00','12:00:00',15000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(601,1,'午前','10:00:00','12:00:00',30000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(611,1,'夜間','18:00:00','23:00:00',15000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(621,1,'午前＆午後','10:00:00','17:00:00',36000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(631,1,'午後＆夜間','13:00:00','21:00:00',36000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(641,1,'終日','10:00:00','21:00:00',42000,5000,'2021-03-15 17:29:12','2021-03-15 17:29:12'),(664,124,'午前','08:00:00','12:00:00',13000,5000,'2021-04-09 14:05:44','2021-04-09 14:05:44'),(674,124,'tesuto','12:00:00','16:00:00',5000,5000,'2021-04-09 14:05:44','2021-04-09 14:05:44'),(744,134,'午前','10:00:00','12:00:00',12000,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(754,134,'午後','13:00:00','17:00:00',22000,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(764,134,'夜間','18:00:00','23:00:00',12000,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(774,134,'午前＆午後','10:00:00','17:00:00',25000,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(784,134,'午後＆夜間','13:00:00','21:00:00',25000,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(794,134,'終日','10:00:00','21:00:00',27500,3000,'2021-04-10 08:03:07','2021-04-10 08:03:07'),(804,144,'午前','10:00:00','12:00:00',5000,2000,'2021-04-10 08:05:43','2021-04-10 08:05:43'),(814,144,'夜間','18:00:00','20:00:00',8000,2000,'2021-04-10 08:05:43','2021-04-10 08:05:43'),(824,144,'終日','08:00:00','23:00:00',11000,2000,'2021-04-10 08:05:43','2021-04-10 08:05:43'),(834,174,'午前','08:00:00','12:00:00',15000,5000,'2021-04-12 00:23:13','2021-04-12 00:23:13'),(844,174,'午後','13:00:00','17:00:00',30000,5000,'2021-04-12 00:23:13','2021-04-12 00:23:13'),(854,174,'夜間','18:00:00','21:00:00',15000,5000,'2021-04-12 00:23:13','2021-04-12 00:23:13'),(864,184,'午前','10:00:00','12:00:00',12000,2000,'2021-04-12 00:44:40','2021-04-12 00:44:40'),(874,184,'午後','13:00:00','17:00:00',22000,2000,'2021-04-12 00:44:40','2021-04-12 00:44:40'),(884,184,'夜間','18:00:00','21:00:00',12000,2000,'2021-04-12 00:44:40','2021-04-12 00:44:40'),(894,11,'午前','08:00:00','12:00:00',15000,5000,'2021-04-12 19:50:00','2021-04-12 19:50:00'),(904,11,'午後','12:00:00','17:00:00',25000,5000,'2021-04-12 19:50:00','2021-04-12 19:50:00'),(914,11,'夜間','18:00:00','23:00:00',15000,5000,'2021-04-12 19:50:00','2021-04-12 19:50:00'),(924,21,'午前','10:00:00','12:00:00',50000,3000,'2021-04-12 19:54:47','2021-04-12 19:54:47'),(934,21,'午後','13:00:00','17:00:00',120000,3000,'2021-04-12 19:54:47','2021-04-12 19:54:47'),(944,21,'終日','08:00:00','23:00:00',3500000,3000,'2021-04-12 19:54:47','2021-04-12 19:54:47');
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
) ENGINE=InnoDB AUTO_INCREMENT=3325 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (2994,'2014_10_12_000000_create_users_table',1),(3004,'2014_10_12_100000_create_password_resets_table',1),(3014,'2019_08_19_000000_create_failed_jobs_table',1),(3024,'2020_02_01_090636_create_admins_table',1),(3034,'2020_09_18_090242_create_venues_table',1),(3044,'2020_09_20_044412_create_equipments_table',1),(3054,'2020_09_20_065837_create_venue_equipment_table',1),(3064,'2020_09_22_094627_create_services_table',1),(3074,'2020_09_24_064549_create_dates_table',1),(3084,'2020_09_24_072535_create_service_venue_table',1),(3094,'2020_09_24_100404_create_date_venue_table',1),(3104,'2020_09_29_055630_create_frame_prices_table',1),(3114,'2020_10_01_062150_create_time_prices_table',1),(3124,'2020_10_07_145320_create_email_verification_table',1),(3134,'2020_10_08_104339_create_agents_table',1),(3144,'2020_10_12_132928_create_preusers_table',1),(3154,'2020_10_19_163736_create_reservations_table',1),(3164,'2020_12_23_174247_create_bills_table',1),(3174,'2020_12_23_182424_create_breakdowns_table',1),(3184,'2021_02_08_153525_create_endusers_table',1),(3194,'2021_02_15_134342_create_pre_reservations_table',1),(3204,'2021_02_15_134831_create_pre_bills_table',1),(3214,'2021_02_15_135246_create_pre_breakdowns_table',1),(3224,'2021_02_15_140439_create_unknown_users_table',1),(3234,'2021_02_17_163902_create_multiple_reserves_table',1),(3244,'2021_02_23_122139_create_pre_endusers_table',1),(3254,'2021_03_07_164513_create_cxls_table',1),(3264,'2021_03_07_164951_create_cxl_breakdowns_table',1),(3274,'2021_03_11_170012_add_charge_to_pre_endusers_table',1),(3284,'2021_03_15_204950_change_unknown_users_table',1),(3294,'2021_03_17_133710_change_venues_table',1),(3304,'2021_03_17_135039_change_venues_size_table',1),(3314,'2021_03_24_190628_change_venues_capacity_table',1),(3324,'2021_03_25_115926_add_mobile_to_endusers_table',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_reserves`
--

LOCK TABLES `multiple_reserves` WRITE;
/*!40000 ALTER TABLE `multiple_reserves` DISABLE KEYS */;
INSERT INTO `multiple_reserves` VALUES (4,'2021-04-08 10:56:02','2021-04-08 10:56:02');
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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_bills`
--

LOCK TABLES `pre_bills` WRITE;
/*!40000 ALTER TABLE `pre_bills` DISABLE KEYS */;
INSERT INTO `pre_bills` VALUES (4,14,122221,0,0,0,122221,12222,134443,0,NULL,1,'2021-04-08 10:22:52','2021-04-08 10:22:52'),(114,54,67000,0,0,0,67000,6700,73700,0,NULL,1,'2021-04-08 11:09:16','2021-04-08 11:09:16'),(124,24,61000,0,0,0,61000,6100,67100,0,NULL,1,'2021-04-08 11:09:24','2021-04-08 11:09:24'),(134,64,42000,65824,0,0,107824,10782,118606,0,NULL,1,'2021-04-13 11:44:00','2021-04-13 11:44:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=724 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_breakdowns`
--

LOCK TABLES `pre_breakdowns` WRITE;
/*!40000 ALTER TABLE `pre_breakdowns` DISABLE KEYS */;
INSERT INTO `pre_breakdowns` VALUES (4,4,'1',11111,'11',122221,1,'2021-04-08 10:22:52','2021-04-08 10:22:52'),(574,114,'会場料金',54500,'11',54500,1,'2021-04-08 11:09:16','2021-04-08 11:09:16'),(584,114,'延長料金',12500,'2.5',12500,1,'2021-04-08 11:09:16','2021-04-08 11:09:16'),(594,124,'会場料金',48500,'7',48500,1,'2021-04-08 11:09:24','2021-04-08 11:09:24'),(604,124,'延長料金',12500,'2.5',12500,1,'2021-04-08 11:09:24','2021-04-08 11:09:24'),(614,134,'会場料金',42000,'10.5',42000,1,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(624,134,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,'4',4000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(634,134,'【追加】次亜塩素酸水専用・超音波加湿器',500,'4',2000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(644,134,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,'9',9000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(654,134,'プロジェクター',3000,'9',27000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(664,134,'iphone(Lightning)DVDプレイヤー',2000,'8',16000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(674,134,'持ち運びパーテーション',1000,'7',7000,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(684,134,'あ',1,'1',1,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(694,134,'ｓ',123,'1',123,2,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(704,134,'領収書発行',200,'1',200,3,'2021-04-13 11:44:00','2021-04-13 11:44:00'),(714,134,'鍵レンタル',500,'1',500,3,'2021-04-13 11:44:00','2021-04-13 11:44:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_reservations`
--

LOCK TABLES `pre_reservations` WRITE;
/*!40000 ALTER TABLE `pre_reservations` DISABLE KEYS */;
INSERT INTO `pre_reservations` VALUES (14,0,1,4,0,'2021-04-28',1,'04:30:00','18:30:00',0,'04:30:00','04:30:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１１','0192001091011',NULL,NULL,NULL,NULL,0,0,NULL,0,'2021-04-08 10:22:52','2021-04-08 10:22:52'),(24,4,1,4,0,'2021-04-15',1,'08:30:00','18:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'あああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',0,0,NULL,NULL,'2021-04-08 10:56:02','2021-04-08 11:09:24'),(34,4,41,4,0,'2021-04-23',NULL,'08:30:00','21:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-04-08 10:56:02','2021-04-08 10:56:02'),(44,4,81,4,0,'2021-04-29',NULL,'09:00:00','21:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-04-08 10:56:02','2021-04-08 10:56:02'),(54,4,1,4,0,'2021-04-23',1,'08:30:00','22:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-04-08 11:01:20','2021-04-08 11:05:35'),(64,0,1,4,0,'2021-04-14',1,'10:00:00','20:30:00',1,'10:00:00','10:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'受付 工藤','07010652028',NULL,NULL,NULL,NULL,0,0,NULL,0,'2021-04-13 11:44:00','2021-04-13 11:44:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_venue`
--

LOCK TABLES `service_venue` WRITE;
/*!40000 ALTER TABLE `service_venue` DISABLE KEYS */;
INSERT INTO `service_venue` VALUES (1,1,1,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(11,1,11,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(21,1,21,'2021-03-14 18:08:43','2021-03-14 18:08:43'),(31,31,1,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(41,31,21,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(51,31,31,'2021-03-14 18:27:25','2021-03-14 18:27:25'),(61,61,1,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(71,81,1,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(81,81,21,'2021-03-15 09:40:50','2021-03-15 09:40:50'),(91,91,1,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(101,101,11,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(111,111,21,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(121,111,51,'2021-03-15 16:08:09','2021-03-15 16:08:09'),(131,121,21,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(141,121,31,'2021-03-15 16:11:09','2021-03-15 16:11:09'),(144,124,21,'2021-04-09 13:15:49','2021-04-09 13:15:49'),(154,124,51,'2021-04-09 13:15:49','2021-04-09 13:15:49'),(164,134,11,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(174,134,21,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(184,134,31,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(194,134,51,'2021-04-09 17:44:51','2021-04-09 17:44:51'),(204,144,1,'2021-04-09 18:44:26','2021-04-09 18:44:26'),(214,144,31,'2021-04-09 18:44:26','2021-04-09 18:44:26'),(224,144,51,'2021-04-09 18:44:26','2021-04-09 18:44:26'),(234,154,1,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(244,154,31,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(254,154,51,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(264,164,11,'2021-04-10 14:06:49','2021-04-10 14:06:49'),(274,164,31,'2021-04-10 14:06:49','2021-04-10 14:06:49'),(284,174,1,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(294,174,11,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(304,174,21,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(314,174,31,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(324,174,51,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(334,174,54,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(354,184,21,'2021-04-12 00:43:39','2021-04-12 00:43:39'),(364,184,51,'2021-04-12 00:43:39','2021-04-12 00:43:39'),(374,184,54,'2021-04-12 00:43:39','2021-04-12 00:43:39'),(384,194,21,'2021-04-12 17:36:13','2021-04-12 17:36:13'),(394,194,51,'2021-04-12 17:36:13','2021-04-12 17:36:13'),(404,224,1,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(414,224,11,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(424,224,31,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(434,224,84,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(444,234,11,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(454,234,21,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(464,234,31,'2021-04-12 19:31:49','2021-04-12 19:31:49'),(474,244,1,'2021-04-12 20:32:01','2021-04-12 20:32:01'),(484,244,54,'2021-04-12 20:32:01','2021-04-12 20:32:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'領収書発行',200,'ああああああああああああああああああああああああああああああああああああああああああああああああああ','2021-03-14 15:36:43','2021-03-14 19:19:44'),(11,'鍵レンタル',500,NULL,'2021-03-14 15:36:43',NULL),(21,'プロジェクター設置',2000,NULL,'2021-03-14 15:36:43',NULL),(31,'DVDプレイヤー設置',2000,NULL,'2021-03-14 15:36:43',NULL),(51,'８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８８',88888,'８','2021-03-14 23:23:31','2021-03-14 23:23:31'),(54,'荷物預かり',500,'事前荷物の預かりのみ500円要\r\n事後荷物の預かりのみの場合は料金不要。','2021-04-10 08:20:42','2021-04-10 08:20:42'),(84,'領収書',200,'改行テスト改行テスト改行テスト\r\n改行テスト\r\n\r\n改行テスト改行テスト改行テスト\r\n改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト','2021-04-12 00:47:26','2021-04-12 01:04:30'),(104,'て',1000000000,NULL,'2021-04-12 18:24:28','2021-04-12 18:24:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_prices`
--

LOCK TABLES `time_prices` WRITE;
/*!40000 ALTER TABLE `time_prices` DISABLE KEYS */;
INSERT INTO `time_prices` VALUES (61,41,2,1000,1000,'2021-03-14 22:47:32','2021-03-14 22:47:32'),(64,124,1,5000,5000,'2021-04-09 13:55:51','2021-04-09 13:55:51'),(74,144,3,12000,4000,'2021-04-10 08:08:53','2021-04-10 08:08:53'),(84,144,5,19000,3500,'2021-04-10 08:08:53','2021-04-10 08:08:53'),(94,144,8,25000,3000,'2021-04-10 08:08:53','2021-04-10 08:08:53'),(104,164,3,12000,4000,'2021-04-10 14:14:28','2021-04-10 14:14:28'),(114,174,3,32500,5900,'2021-04-12 00:28:29','2021-04-12 00:28:29'),(124,174,4,38400,7100,'2021-04-12 00:28:29','2021-04-12 00:28:29'),(164,184,2,15000,7000,'2021-04-12 00:45:31','2021-04-12 00:45:31'),(174,184,5,22000,6000,'2021-04-12 00:45:31','2021-04-12 00:45:31'),(184,184,8,32000,5000,'2021-04-12 00:45:31','2021-04-12 00:45:31'),(194,184,10,39000,4500,'2021-04-12 00:45:31','2021-04-12 00:45:31'),(204,21,2,13,50,'2021-04-12 19:56:57','2021-04-12 19:56:57'),(214,21,5,500,50,'2021-04-12 19:56:57','2021-04-12 19:56:57');
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
  `unknown_user_company` varchar(191) DEFAULT NULL,
  `unknown_user_name` varchar(191) DEFAULT NULL,
  `unknown_user_email` varchar(191) DEFAULT NULL,
  `unknown_user_mobile` varchar(191) DEFAULT NULL,
  `unknown_user_tel` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unknown_users_pre_reservation_id_index` (`pre_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unknown_users`
--

LOCK TABLES `unknown_users` WRITE;
/*!40000 ALTER TABLE `unknown_users` DISABLE KEYS */;
INSERT INTO `unknown_users` VALUES (64,24,'株式会社トリックスター',NULL,'あさ','あさ','あっさ','2021-04-08 10:59:53','2021-04-08 10:59:53'),(74,34,'株式会社トリックスター',NULL,'あさ','あさ','あっさ','2021-04-08 10:59:53','2021-04-08 10:59:53'),(84,44,'株式会社トリックスター',NULL,'あさ','あさ','あっさ','2021-04-08 10:59:53','2021-04-08 10:59:53'),(94,54,NULL,NULL,NULL,NULL,NULL,'2021-04-08 11:01:20','2021-04-08 11:01:20');
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
) ENGINE=InnoDB AUTO_INCREMENT=1495 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'ooyama@web-trickster.com','$2y$10$SrFe8oG29MSHYNdv78HoKecQtqHjfdGOMdjt/blPoov6HQeIEedUq','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'大山','紘一郎','オオヤマ','コウイチロウ','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'HLEkVcBNOF',NULL,NULL),(14,'kudou@web-trickster.com','$2y$10$pHkE.hewc01zY8rd8AUhXevHjRC8SKt5tmp8P0N.NgaSVRZA4zP5O','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'工藤','大揮','クドウ','ダイキ','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'KlFV60AWXO',NULL,NULL),(999,'sample@sample.com','$2y$10$6g5z0DydM1ly2MJmz6VLGOG97b7K7sBKvryIoKe1Q8mlDpLey1f4y','（未登録ユーザー）','（未設定）','（未設定）','（未設定）','（未設定）',NULL,NULL,NULL,NULL,'（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'i7f8lCccKZ',NULL,NULL),(1004,'sasaki.ryohei@example.net','$2y$10$5r2BNEwRq9xt.DDM6z0YB.Qc5Ef7Z20DovtJKC.PwP0oemWqIUzLa','株式会社 山岸','8021315','津田市','山本町','松本町中島3-5-3',NULL,NULL,NULL,NULL,'田辺','裕樹','ダミーのため一致しません','ダミーのため一致しません','0800-422-465','090-8610-3086',NULL,2,1,'1577939','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータどうでのときの本のあかり元気にしかし出。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1014,'kana79@example.com','$2y$10$DDCL15psO2d30wEkC.bSl.mlXrcqFzTSoaBugoi0ObT7EvxXrd8nG','株式会社 近藤','9369083','斉藤市','宇野町','若松町杉山5-5-8',NULL,NULL,NULL,NULL,'小泉','香織','ダミーのため一致しません','ダミーのため一致しません','090-6872-2625','05740-6-8027',NULL,1,3,'7705927','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータして来るわけもなくそうだんだろうか」が。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1024,'suzuki.naoto@example.net','$2y$10$aqQAJ.yBgT6aorEjf2JQgeWhTt2O2aHKgpwYeSDBGsPVjUb1uGLNy','有限会社 中村','9882856','田辺市','加藤町','江古田町加藤2-5-9',NULL,NULL,NULL,NULL,'中津川','美加子','ダミーのため一致しません','ダミーのため一致しません','080-2036-1687','080-6489-3361',NULL,0,2,'6862537','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータも水素すいめいのだ」カムパネルラ、こん。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1034,'kudo.satomi@example.org','$2y$10$Z1D8iuF3hloR0Mh6Q/86DeO1q7b6ryhsFKXW7FYY/IeIXSigl10R6','有限会社 山口','1497922','津田市','津田町','松本町山岸6-2-1',NULL,NULL,NULL,NULL,'江古田','千代','ダミーのため一致しません','ダミーのため一致しません','00-1528-9892','0810-812-523',NULL,2,4,'1888756','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいわよ。僕ぼくがいるの見えるらしく、み。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1044,'qyoshimoto@example.net','$2y$10$Dy3sQOggXkGnmW9EBpC9POyvJEf8N/LR/.FCuODNqTSzZoolwlJES','有限会社 木村','3108418','工藤市','伊藤町','青田町井上5-7-7',NULL,NULL,NULL,NULL,'原田','拓真','ダミーのため一致しません','ダミーのため一致しません','01-4609-3637','090-4572-4320',NULL,3,4,'2597881','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータる汽車もうすってたふくろの火だなんだん。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1054,'taichi33@example.net','$2y$10$B0BnVuUrFxpDDGb737pdke70qoQryean.h88BApcoEaByNcGHnjdy','有限会社 浜田','9207226','原田市','大垣町','佐々木町井高9-8-9',NULL,NULL,NULL,NULL,'中村','真綾','ダミーのため一致しません','ダミーのため一致しません','01044-9-3980','080-8056-3554',NULL,2,3,'7632887','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータひどい高原じゃないね。なんでした。それ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1064,'ryosuke73@example.net','$2y$10$u4x5pQcD33G555Fp5Z5MDOHRPlkNUxBuO7334v.Z8mqtnOP9dFvHa','株式会社 近藤','7425380','山田市','佐藤町','近藤町田辺9-8-7',NULL,NULL,NULL,NULL,'原田','亮介','ダミーのため一致しません','ダミーのため一致しません','02-3340-8004','080-6428-3867',NULL,3,1,'5326286','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータまかにお母さんがのお母さんやりません。。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1074,'momoko20@example.org','$2y$10$3xRn/NhQ5qskNXZ7GqgE6elhhsv4KE6cKYuz4nhKk.Xk3C0gfO1LW','株式会社 山本','5864225','鈴木市','中村町','喜嶋町中島8-2-5',NULL,NULL,NULL,NULL,'村山','くみ子','ダミーのため一致しません','ダミーのため一致しません','09-0297-0094','080-1801-0147',NULL,3,2,'2073289','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータごうがくのかたまっすぐ横手よこへ播まけ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1084,'pnomura@example.com','$2y$10$h4lqc9y0WOBE67PKyBeCKeyDV9iraPe3MvThvEDorIGO2VFekUZIi','株式会社 吉田','3578609','伊藤市','山岸町','中津川町青山4-3-10',NULL,NULL,NULL,NULL,'三宅','淳','ダミーのため一致しません','ダミーのため一致しません','0390-176-687','02407-4-7025',NULL,3,3,'7385684','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータつました。女の子がそっちをお持もって口。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1094,'yui.harada@example.com','$2y$10$cxUoKN3Ogy.VZSpvXkjbaOQu5u2PdIV1.Zjh55mPcTHRbajbzc/Mi','有限会社 中津川','1415726','宮沢市','青山町','江古田町津田4-6-3',NULL,NULL,NULL,NULL,'小林','翼','ダミーのため一致しません','ダミーのため一致しません','05772-0-6678','090-6893-0944',NULL,3,3,'4155879','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータないかいさつの大きいて、すぐに銀ぎんが。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1104,'hiroshi.ito@example.org','$2y$10$5ZVnYDU5Cem69IA03aunyOybOFAZgLN7jVkzVX8i.P8.A8NpiNn8.','株式会社 青山','3913315','杉山市','中村町','江古田町井上7-7-4',NULL,NULL,NULL,NULL,'山岸','七夏','ダミーのため一致しません','ダミーのため一致しません','0355-28-2025','02-4870-6124',NULL,0,3,'6766200','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータがあがったりの眼めの中を見あげて鷺さぎ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1114,'idaka.jun@example.com','$2y$10$CibNp03skmsrKjBeYxkV1eHySOQypoql8drHteQEJhK8UAhJ.vTw2','有限会社 藤本','7773981','伊藤市','鈴木町','佐々木町佐々木9-5-2',NULL,NULL,NULL,NULL,'坂本','桃子','ダミーのため一致しません','ダミーのため一致しません','05296-2-5746','0240-138-570',NULL,3,4,'2852917','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ同じような青じろいろのところの外から、。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1124,'xhirokawa@example.com','$2y$10$XHTxb3viR5rRkiPh1gDjpO3izZxchfOyJeQpG6VrYuM5MvqN3iBke','有限会社 加納','8717306','藤本市','山本町','山本町松本9-6-8',NULL,NULL,NULL,NULL,'山岸','治','ダミーのため一致しません','ダミーのため一致しません','0119-74-1967','0176-58-9675',NULL,0,2,'7561340','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータたちまでも、みんな不完全ふかくひょうめ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1134,'unakamura@example.com','$2y$10$.qRJ8AFSNvIoc3tpj5aKA.8wWG6qpU6LP/qBLcw5Ct7PvE2J8ThC6','株式会社 津田','5255666','田辺市','加納町','藤本町斉藤4-2-9',NULL,NULL,NULL,NULL,'桐山','康弘','ダミーのため一致しません','ダミーのため一致しません','02762-8-0252','090-7581-0475',NULL,1,2,'4243637','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ眼鏡きんがとうに窓まどから出て来るので。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1144,'takahashi.taro@example.org','$2y$10$ZdtUvkz24ifBkt0s.sbAmu84j41pXp0ml06DHpUVyeJ82XjdGF8wS','株式会社 田辺','4252541','小林市','井高町','山本町浜田10-6-3',NULL,NULL,NULL,NULL,'浜田','美加子','ダミーのため一致しません','ダミーのため一致しません','08660-6-8903','090-3447-4166',NULL,0,2,'6573375','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータこまれて、まわり、すすきの姉あねはなが。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1154,'ito.momoko@example.org','$2y$10$0ZG7CRg5CUX9BpA2b.NKROeWm6cC3OZdAy58l5DeA1U2zqgVDlWFu','株式会社 桐山','1469210','工藤市','江古田町','杉山町宇野5-6-7',NULL,NULL,NULL,NULL,'渚','裕太','ダミーのため一致しません','ダミーのため一致しません','08156-6-5836','090-9030-1268',NULL,1,4,'8801233','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ指さした。まっ白な蝋ろうとうおじぎをた。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1164,'kana.kobayashi@example.net','$2y$10$h2MTJILs2QTm0YBw7t95T.hlu7NVD59P3eoq0aC94TNwNb7IqNDOm','株式会社 伊藤','7924495','宮沢市','青田町','山口町井高6-10-8',NULL,NULL,NULL,NULL,'佐藤','直人','ダミーのため一致しません','ダミーのため一致しません','080-7158-8553','05-3156-2280',NULL,3,3,'4561535','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータそうな、あの見えるよ」青年のうしろには。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1174,'yasuhiro.kanou@example.com','$2y$10$DoR6Gw7FzGirUeUVnmSkPeswGCT0rBZ6EbO8DfiaKt8ngCNRH.Qcy','有限会社 田中','2461795','宇野市','若松町','渡辺町田辺1-1-1',NULL,NULL,NULL,NULL,'田中','学','ダミーのため一致しません','ダミーのため一致しません','0950-075-484','042-909-8886',NULL,0,3,'4073626','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータつばかり汽車のなかっているか、そのきい。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1184,'luno@example.org','$2y$10$ujWlsHuuUeqiDzoDtF.Zf.nqYonF9jqYWXITq.173qujantWFpP4y','有限会社 山口','7741407','近藤市','石田町','山田町松本4-3-7',NULL,NULL,NULL,NULL,'中村','洋介','ダミーのため一致しません','ダミーのため一致しません','0870-085-860','090-2669-8680',NULL,1,2,'9342279','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータてももってなんです。しかたを高く星あか。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1194,'watanabe.kenichi@example.net','$2y$10$nHpU0RB/8Pb2Mk42PEzxp.JnKjuMStMMmjsU.0naX99JM3YL.lm0K','有限会社 西之園','4508211','西之園市','吉本町','斉藤町小泉10-10-5',NULL,NULL,NULL,NULL,'浜田','千代','ダミーのため一致しません','ダミーのため一致しません','00748-4-1120','083-517-2244',NULL,2,1,'3965962','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ礼しつに分けて、手をあけました。けれど。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1204,'ekoda.atsushi@example.org','$2y$10$jLrj2G6uicbCWrm3ut7fkOE0rBTw3lCf2p9Zr0DNs951pZc1Gq76O','株式会社 小泉','6961320','青田市','津田町','山田町山本8-8-7',NULL,NULL,NULL,NULL,'加納','真綾','ダミーのため一致しません','ダミーのため一致しません','08-6066-6817','064-925-1753',NULL,1,2,'9386168','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータきまたくさんが、まもない。いいろな形を。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1214,'unishinosono@example.com','$2y$10$VxZM0GZnIdFtnPmcNhRy1.HCSJGTSvlEDvYgIPv1UyLDiMVF7cKh.','有限会社 笹田','9159759','佐々木市','青田町','中島町笹田1-5-8',NULL,NULL,NULL,NULL,'中村','学','ダミーのため一致しません','ダミーのため一致しません','080-0768-2949','0540-64-9658',NULL,3,2,'3344799','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ悪口わるくなった壁かべると、もう帰って。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1224,'kyosuke52@example.org','$2y$10$Z41iQNdSNg2WByWy6tbvL.ItaI16lWDrcjUV55vvI/CU5XNprv8KK','株式会社 小泉','4103174','吉本市','中島町','斉藤町加藤3-5-8',NULL,NULL,NULL,NULL,'山田','里佳','ダミーのため一致しません','ダミーのため一致しません','080-4559-6351','0250-831-260',NULL,3,4,'8191685','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ嘩けん命めいめい勢いきものを見ます。ど。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1234,'nito@example.com','$2y$10$srIVhAWd8jWffKoi/x/rkOKVXoiZr6lLEU7SQqjnAGy6UJ5fCTTVm','有限会社 山岸','8918165','松本市','坂本町','村山町三宅4-3-6',NULL,NULL,NULL,NULL,'斉藤','裕美子','ダミーのため一致しません','ダミーのため一致しません','080-3915-1503','097-233-0750',NULL,1,1,'5472805','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータあるんだのところが先生が言いえずきれい。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1244,'mikako68@example.org','$2y$10$5jG6OseCMnJy6EHfqYHGU.i4b7aR.v6ieQOniWmiHy6S.kcCMhLve','株式会社 木村','3158466','伊藤市','渚町','野村町石田5-3-8',NULL,NULL,NULL,NULL,'井高','美加子','ダミーのため一致しません','ダミーのため一致しません','080-7187-5256','05-0138-2226',NULL,2,1,'2858143','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいをさがしらの碍子が言いいます。赤ひげ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1254,'hkanou@example.org','$2y$10$5nQGo0XAoCSExwH7Qs1QIuw25IWz6emCSmIRqTtToLk0ipRlde5y2','有限会社 廣川','4563750','宇野市','小林町','山口町伊藤4-3-10',NULL,NULL,NULL,NULL,'佐藤','太一','ダミーのため一致しません','ダミーのため一致しません','06743-4-5766','080-0193-2244',NULL,2,1,'4472344','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータら、手をして思わずかにあてて、天の川の。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1264,'fujimoto.yuta@example.net','$2y$10$Ep.hILW4ESrRghKhuUG9DOjjQhwOOGPP0Fiu6WxJbDgZg7bbWFr2u','有限会社 小泉','6564409','青山市','桐山町','吉本町浜田9-9-5',NULL,NULL,NULL,NULL,'笹田','直人','ダミーのため一致しません','ダミーのため一致しません','03-4232-1279','090-0319-0937',NULL,0,1,'5315459','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータででもなく声をあげて不動ふどうで銀河ぎ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1274,'naoko.fujimoto@example.net','$2y$10$A1nYJy0sms.ooenY8eHzuORJGl1tsfTOmyrIhwiEy6yEGe74Q6eeq','株式会社 加納','7193021','工藤市','松本町','大垣町石田8-3-4',NULL,NULL,NULL,NULL,'加藤','裕太','ダミーのため一致しません','ダミーのため一致しません','090-7935-2083','080-1685-0675',NULL,0,3,'4308518','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータをまげたカトリック辺へんなのついて二人。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1284,'isasada@example.org','$2y$10$A68CFhVFCNEoS9ulbbM8mOaZKOxsFfDW.THomuPYsFV6Jd9hqQTda','株式会社 井上','2982020','田中市','宮沢町','吉本町若松5-2-8',NULL,NULL,NULL,NULL,'工藤','学','ダミーのため一致しません','ダミーのため一致しません','072-878-7062','0410-69-6255',NULL,1,2,'6229300','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータこさえないか。わたしますと、もらい戸口。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1294,'uuno@example.net','$2y$10$gplYtzJVEgSivspI0k0mO.wf2U3T9Ppad9t7yUI5wrlrKWIpn7d.G','有限会社 田中','4169070','杉山市','津田町','吉本町井高10-3-4',NULL,NULL,NULL,NULL,'江古田','英樹','ダミーのため一致しません','ダミーのため一致しません','09-3267-8807','080-0092-7192',NULL,1,3,'2003167','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータむこうらしらべてに赤い眼めを大きなり風。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1304,'sishida@example.org','$2y$10$lSnnPiFPWox.Xx3ssHxccuTX8WwNkU.N752cCImspHLZlV33IGv.m','有限会社 浜田','9356019','高橋市','山口町','工藤町山岸2-1-2',NULL,NULL,NULL,NULL,'斉藤','晃','ダミーのため一致しません','ダミーのため一致しません','0834-43-4709','0430-216-656',NULL,0,2,'5656909','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータなくなり、丘おかしまっ黒にかほんも、み。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1314,'sakamoto.yosuke@example.net','$2y$10$AeCybkLgiO/TxPuX/IWyi.EpHIgs2L7MAXGaeBz8AhhzO2sxghlIm','有限会社 若松','6927540','伊藤市','村山町','坂本町斉藤2-4-3',NULL,NULL,NULL,NULL,'伊藤','桃子','ダミーのため一致しません','ダミーのため一致しません','07199-8-3214','080-6272-4477',NULL,0,2,'3783382','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ年はなして、またき、男の子が顔を出して。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1324,'wsuzuki@example.com','$2y$10$/h6qUMXlGDomkHolm4Q/heFyTq0y3FTgx0TUAv2SI5XarXN5j.Q8S','有限会社 青田','2177632','桐山市','浜田町','工藤町田中2-9-9',NULL,NULL,NULL,NULL,'青山','さゆり','ダミーのため一致しません','ダミーのため一致しません','090-9661-3429','05-1171-6299',NULL,3,2,'8019266','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ人ふたりつがぽかったあやしいけない。で。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1334,'tnishinosono@example.com','$2y$10$zycG0jZVN0Zs3k3FhmeXDu5Us2xx4q6G38gBuSMIJvvuUAgSr34AK','有限会社 田中','4635749','若松市','江古田町','大垣町大垣9-3-8',NULL,NULL,NULL,NULL,'田辺','美加子','ダミーのため一致しません','ダミーのため一致しません','0970-108-312','02-3217-8011',NULL,3,3,'6895957','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ今夜はみんな新しいよく言いいました。向。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1344,'iyamaguchi@example.net','$2y$10$QWf98W632rVyYm5NrClXReRds28JS2rmuT5Sbsbu8wCxhMUbrG8F.','有限会社 小泉','5549309','西之園市','山田町','高橋町井上2-4-9',NULL,NULL,NULL,NULL,'佐々木','翔太','ダミーのため一致しません','ダミーのため一致しません','0950-954-369','0858-44-5543',NULL,0,1,'1199097','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんとうにきのある。けれどもジョバンニは。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1354,'kaori.murayama@example.com','$2y$10$rr6FRrbcl5434xpkcCFtZ.xy7w.9XycllwW3N3et0Iuuz8D1m.Psa','株式会社 田中','4752562','斉藤市','松本町','中村町松本4-5-8',NULL,NULL,NULL,NULL,'宮沢','拓真','ダミーのため一致しません','ダミーのため一致しません','07-5011-8531','0939-37-8488',NULL,2,1,'9305197','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいただうごくへ行って見ているばかりは、。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1364,'yoshida.kazuya@example.org','$2y$10$bUTnOMYCeAYjSUP2vYGYS.K8dCRbuOCdFjlhocQ82qdqsASQ3Dh6q','有限会社 若松','7907524','佐藤市','佐々木町','渡辺町坂本1-1-6',NULL,NULL,NULL,NULL,'吉田','裕太','ダミーのため一致しません','ダミーのため一致しません','0240-804-575','01-8465-9248',NULL,2,3,'5801641','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ人はわれました。カムパネルラのようには。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1374,'yumiko.matsumoto@example.com','$2y$10$kyJRxCbgAMAwz7jpju/ep.TT9tDiit1C6pY5dOHB1lME/F9xhIx/e','有限会社 田辺','1649649','吉田市','山本町','江古田町吉本1-2-2',NULL,NULL,NULL,NULL,'加納','裕美子','ダミーのため一致しません','ダミーのため一致しません','08-4125-9630','090-1664-0594',NULL,2,3,'8836095','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいかがやかに、ちょうどさそりは、北の大。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1384,'fujimoto.manabu@example.com','$2y$10$oEhwcFFaaGg2hATN69F9L.sRi9McQyA7Aob1siH6QIwHvfTJXdBrm','有限会社 井上','8705890','大垣市','村山町','工藤町若松10-9-4',NULL,NULL,NULL,NULL,'伊藤','春香','ダミーのため一致しません','ダミーのため一致しません','0200-49-9931','011-472-4644',NULL,3,1,'6573832','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータどいいました。向むこうねえ」「きみんな。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1394,'ishida.yasuhiro@example.net','$2y$10$iifbuNktofwJ3ImrQeKoTeIivzWuOP.OzrfA06QMn812NBpOSNfgC','有限会社 笹田','6482637','桐山市','宮沢町','井高町小泉9-1-9',NULL,NULL,NULL,NULL,'渚','知実','ダミーのため一致しません','ダミーのため一致しません','090-7915-1403','090-7674-9400',NULL,2,4,'6133718','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの河原から一羽わの中に落おったら、セロ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1404,'takuma.tanaka@example.org','$2y$10$ZZLrXuBVK5qIdd8ySdu7OOsJLSTj1Z5egqJ33CsEV9S4Wft.3x.DO','有限会社 佐藤','7309453','渚市','斉藤町','加納町廣川6-7-10',NULL,NULL,NULL,NULL,'小泉','桃子','ダミーのため一致しません','ダミーのため一致しません','06258-9-9916','090-2922-3083',NULL,2,1,'2612337','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータまえはあぶなくて、わあわたりとその声や。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1414,'maoyama@example.com','$2y$10$N/vtnxo/s5a44Wd6GRkr..zz1/DFa.IFwBIVdTeEg5m2KUXM1Wzb.','株式会社 宇野','6998563','井高市','吉田町','鈴木町山口2-10-7',NULL,NULL,NULL,NULL,'坂本','零','ダミーのため一致しません','ダミーのため一致しません','06-5210-6468','042-554-9730',NULL,0,1,'6688794','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータにぎってたようにききょう、ツィンクロス。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1424,'psuzuki@example.org','$2y$10$1RZ8nYQGxqedtc/Gs7.qFOQiD4FxbhqzPoZqQEnOlq.WztFEkudO.','有限会社 原田','2271877','山本市','小林町','宇野町野村5-4-7',NULL,NULL,NULL,NULL,'佐藤','千代','ダミーのため一致しません','ダミーのため一致しません','07-9665-7743','09459-3-2103',NULL,3,2,'6474630','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータでも、さっきのうちのあかりを一本のプラ。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1434,'yui.takahashi@example.com','$2y$10$j5m7avyrvz8lTNFqImlMFuTzB/oZciFMWoY5P9ksIxGQtDImRABwC','株式会社 野村','1728320','山岸市','高橋町','吉本町伊藤5-6-10',NULL,NULL,NULL,NULL,'大垣','直子','ダミーのため一致しません','ダミーのため一致しません','080-1273-2488','06-9655-2193',NULL,2,2,'7933409','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータったように見えますと、もう一つの三角標。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1444,'tanabe.hideki@example.org','$2y$10$KIZV68mzCNqKtI4U/G4p0e8QwzG7mJFMdupJltJZITIPZF9g6n1N.','株式会社 井上','1426373','宇野市','藤本町','三宅町中島1-6-6',NULL,NULL,NULL,NULL,'三宅','直人','ダミーのため一致しません','ダミーのため一致しません','0769-83-8131','013-997-2072',NULL,2,4,'6875688','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータカムパネルラも知って立って、ぼく岸きし。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1454,'miki14@example.com','$2y$10$wTCFyz.KyydyX4MihcREdeac47TWL69MQkXDmF06VQZRdyjZQVngm','株式会社 石田','8828803','佐々木市','加藤町','津田町加納5-5-9',NULL,NULL,NULL,NULL,'浜田','篤司','ダミーのため一致しません','ダミーのため一致しません','090-5395-3070','00313-6-5909',NULL,2,3,'7222594','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータたるよ。だから次つぎの頁ページいっしの。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1464,'asuka.tsuda@example.net','$2y$10$fX6fDkPuUTIs2P5boF7dou7Yyh.uT0qFBluSq77/7soZrwstphx9G','有限会社 渚','6931892','山岸市','加納町','高橋町田中9-3-6',NULL,NULL,NULL,NULL,'加藤','桃子','ダミーのため一致しません','ダミーのため一致しません','0330-394-961','080-0250-4850',NULL,2,2,'4553249','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぼりの火が七つ組み合わせてかくひっぱな。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1474,'tyamamoto@example.com','$2y$10$rf3iGdP86X1uahkJNN8IDOpsvTgo70oz.rMoIynWIMvmUjrff06sS','株式会社 井上','7332853','高橋市','吉田町','木村町佐藤7-3-1',NULL,NULL,NULL,NULL,'佐藤','京助','ダミーのため一致しません','ダミーのため一致しません','090-1806-7189','0180-203-392',NULL,2,1,'9632641','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータりの形は見ていたとみを立てて走ったよう。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1484,'rei60@example.net','$2y$10$DZ4/vTte9CFKc1dOLQcDYecdp1yW.2GatMyvgyWNEGhD5132ezpZW','有限会社 吉本','2459950','中島市','坂本町','田辺町田中2-5-6',NULL,NULL,NULL,NULL,'小泉','直人','ダミーのため一致しません','ダミーのため一致しません','053-244-1190','090-8746-9731',NULL,2,2,'7234927','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータもつめたいとさっきりして、さっと光って。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45'),(1494,'yui11@example.org','$2y$10$7VkCaZ4w2rz5QPJJDwnMIuwEBCjkgg1mrwQr.wDhfTcK6AURQG31W','有限会社 山田','9322722','佐藤市','加納町','吉田町中島7-5-9',NULL,NULL,NULL,NULL,'山田','真綾','ダミーのため一致しません','ダミーのため一致しません','0600-950-374','080-8745-8414',NULL,2,3,'5327078','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータりになりいろも少しおまた言いって博士は。',NULL,NULL,1,1,NULL,'2021-04-06 17:48:45','2021-04-06 17:48:45');
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
  `size1` varchar(191) NOT NULL,
  `size2` varchar(191) NOT NULL,
  `capacity` text NOT NULL,
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
  `smg_url` varchar(191) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,0,'四ツ橋（消さないで！料金、営業時間変えないで！）','サンワールドビル','1号室','18','50','20',1,'5555555','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'6666666','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-04-06 19:06:40'),(11,0,'四ツ橋','サンワールドビル','2号室(音響HG)','18','50','20',1,'1111111','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2222222','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-04-06 19:06:26'),(21,0,'トリックスター','We Work','執務室','18','50','20',1,'0650024','北海道','札幌市東区北二十四条東','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'0650024','北海道','札幌市東区北二十四条東','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-14 15:36:44','2021-04-06 19:06:10'),(31,0,'四ツ橋','テストビル','テスト号室（削除しないでください）','100','300','999',1,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル11階','テストです','中務','真梨子','ナカム','マリコ','0665384329','nakamu@s-mg.co.jp',0,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル11階','SMG貸し会議室','0000000000',NULL,'株式会社ビル管理','0611112222','0699998888','テスト','テスト',NULL,'test@s-mg.co.jp','0600007777',NULL,'テストです','https://osaka-conference.com/rental/yb-sunworld/recreation/','5：45～21：30','7：00～21：00','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 18:27:25','2021-04-06 19:05:47'),(41,0,'梅田','梅田','101','33','20','20',0,'5580013','大阪府','大阪市住吉区我孫子東101','梅田',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/recreation/#tab-1',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 20:52:49','2021-03-14 20:52:49'),(51,1,'大阪','我孫子','1（消さないで触らないで！）','999','999','30',1,'5500014','大阪府','大阪市西区北堀江','我孫子ビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/recreation/#tab-3',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:22:04','2021-04-06 19:05:33'),(61,1,'あ','ああ','あ','999','999','30',0,'5500014','大阪府','大阪市西区北堀江1','あ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:26:59','2021-03-14 21:26:59'),(71,0,'大国町（消さないでください！）','ZEPPホール','1F','30','999','30',0,'5500014','大阪府','大阪市西区北堀江1','ZEPPホール','2/1堺谷\r\nああああああああああああああああああああああああああああああああああああああああああああ\r\n\r\nあああああああああああああああああああああああああああああああああああああああああああ\r\n\r\nああああああああああああああああああああああああああ\r\n\r\nhttps://osaka-conference.com/rental/\r\n\r\n\r\n\r\n\r\n1/31　\r\nああああああああああああああああああああああああああああああああ\r\n\r\n\r\nああああああああああああああああああああああああああああああ',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 21:31:26','2021-03-14 21:32:10'),(81,0,'長居','長居駅前ビル','106号室','200','220','220',1,'5500014','大阪府','大阪市西区北堀江','長居駅前ビル','ああああああ\r\n改行\r\nあああああああああああ\r\n改行\r\n改行\r\nああああああああああ',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 09:40:50','2021-04-06 17:57:42'),(91,0,'西田辺','りくろおじさんビル','5F','20','20','20',0,'5500014','大阪府','大阪市西区北堀江1','りくろおじさんビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 09:42:56','2021-03-15 09:42:56'),(101,0,'昭和町','（消さないで料金、時間も含め編集しないで！）昭和町スクエアビル','202','20','20','20',0,'5500014','大阪府','大阪市西区北堀江1','昭和町スクエアビル',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 10:33:59','2021-03-15 10:33:59'),(111,0,'中務テスト','サンワールドビル','あ','100','100','100',0,'5500014','大阪府','北堀江1丁目6-2','サンワールドビル11階',NULL,'中務','真梨子','ナカム','マリコ',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-kinsyo/10a/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 16:08:08','2021-03-15 16:08:08'),(121,0,'山田太郎のテスト会場','あああ','あああ','100','100','100',1,'5500000','大阪府','大阪市西','サンワールドビル11階',NULL,'山田','太郎','ヤマダ','タロウ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ザイマックス','0612304567','09011112222','管理','太郎',NULL,'kanri@zaimx.com','0120789654',NULL,'テストテストテストテスト','https://osaka-conference.com/rental/yb-kinsyo/10a/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-15 16:11:09','2021-04-06 17:57:13'),(124,0,'四ツ橋','サンワールドビル','3号室','100','330','40～150',1,'5500014','大阪府','大阪市西区北堀江1-6-2','四ツ橋サンワールドビル3階',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'9：00～21:00','7：00～23：00','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-04-09 13:15:48','2021-04-09 13:15:48'),(134,1,'新大阪','キューホー江坂ビル','2F','23','76','スクール形式10～33名',0,'5640063','大阪府','吹田市江坂町2-1-43','キューホー江坂ビル2F','・1F管理人室ポスト　10を左へ5回、5を右へ20回\r\n・案内板・申込書は郵送で共有する\r\n・荷物受け取り、鍵貸出不可の会場','中務','真梨子','ナカム','マリコ','09011112222','nakamu@s-mg.co.jp',0,NULL,NULL,NULL,NULL,NULL,NULL,60,'管理会社〇〇××','0612345678','0506667777','管理','ひろし','09012345678','h.kanri@marumaru.com','警備会社▲▲■','069876543','テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\nテストテストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\nテストテストテストテストテストテスト','https://osaka-conference.com/rental/so-kyuho/2f/','7：00～20：00','内側からは常時開放\r\n外側からは常時セキュリティカード要','0',NULL,NULL,'株式会社SMG','0665384329','0665384315','テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\nテストテストテストテストテストテストテストテストテストテストテストテストテストテスト\r\n\r\nテストテストテストテストテストテスト',NULL,'2021-04-09 17:44:51','2021-04-09 17:45:52'),(144,0,'四ツ橋','テスト','101号室AAAAAAAAA','50','40','20名テストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト',1,'5500001','大阪府','大阪市西区土佐堀','ありません',NULL,NULL,NULL,'テスト','テスト',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/so-kyuho/2f/#tab-1',NULL,NULL,'0',NULL,NULL,NULL,'01286',NULL,NULL,NULL,'2021-04-09 18:44:26','2021-04-10 07:56:29'),(154,0,'四ツ橋','近商ビル','10B','15.5','51.2','スクール形式10～38名',1,'5500014','大阪府','大阪市西区北堀江1-1-24','近商ビル10階','裏口の暗証番号0000\r\n管理人の連絡先000-0000-0000\r\n蛍光灯ごみはそのまま出せる','中務','真梨子','ナカム','マリコ','08011114444','nakamu@s-mg.co.jp',0,'5500014','大阪府','大阪市西区北堀江1-1-24','近商ビル6A','SMG貸し会議室','06-6556-6462\r\n（配達時に必ずご連絡下さい）',NULL,'株式会社オクウチサービス','0666667777','0666667777','奥内','部長','09045678910','okuchi@okuchi.com','警備会社●●××','0689456321','固定電話0666667777で\r\n24時間対応が可能','https://osaka-conference.com/rental/yb-kinsyo/10b/','6：45～21：30（21：30以降になるとシャッターが閉まり、ビル外から入ってこられなくなります。）','6：00～22：00（22：00以降になるとシャッターが閉まり、ビル外から入ってこられなくなります。）\r\n（日祝は終日締め切りのため開きません）','1',NULL,NULL,'株式会社SMG','0665566462','0665384315','土日が担当者不在。\r\n連絡は携帯へ転送がかかっているが、折り返し対応に時間がかかる場合がある。',NULL,'2021-04-10 07:54:20','2021-04-10 07:54:20'),(164,1,'四ツ橋','サンワールド','４号室','60','220','スクール形式\r\n40～120名',1,'5500014','大阪府','大阪市西区北堀江','1-6-2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,'アクセア','00000000000',NULL,NULL,NULL,'2021-04-10 14:06:49','2021-04-10 14:08:55'),(174,0,'四ツ橋','サンワールドビル','2号室','31.19','103.1','20～60',1,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル６階',NULL,'日野','夏希','ヒノ','ナツキ',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,'株式会社SMG','0665384329',NULL,NULL,NULL,'2021-04-12 00:20:59','2021-04-12 00:20:59'),(184,0,'testtesttesttesttes','日興ビル','6F','999.51','999.89','35名スクール形式\r\n改行テスト',0,'5500023','大阪府','大阪市西区千代崎','日興ビル6F','改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト','中務','真梨子','ナカム','マリコ','090654789231','nakamu@s-mg.co.jp',0,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル11F','株式会社SMG（アクセア貸し会議室宛）','改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト\r\n改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト',NULL,'株式会社ザイマックス関西','01206549876','09012345697','矢持','泰助','07011116666','t.yamochi@zaimax.com','株式会社DK','0632165498','改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト\r\n改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト',NULL,'改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト','改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト','1',5000,5000,'株式会社SMG','0665566462','0665384315','改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト改行テスト改行テスト\r\n\r\n改行テスト改行テスト改行テスト\r\n改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト改行テスト',NULL,'2021-04-12 00:43:39','2021-04-12 17:30:01'),(194,0,'四ツ橋','サンワールドビル','ｓｓｓ','10','20','20',0,'5500014','大阪府','大阪市西区北堀江','サンワールドビル',NULL,NULL,NULL,'ナカム','マリコ',NULL,'nakamu@s-mg.co.jp',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0665566431123','0665566431123','矢持','泰助','05014448975212','yamochi@zz.co.jp','株式会社戦略総研＆パートナーズ','0665569872',NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL,'06','0120',NULL,NULL,'2021-04-12 17:36:12','2021-04-12 17:36:12'),(204,0,'天六','マロニエホール','7F','300.00','100','1050',0,'5500011','大阪府','大阪市西区阿波座','マロニエホール7F',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/t6-maronie/hall/',NULL,NULL,'1',0,0,NULL,NULL,NULL,NULL,NULL,'2021-04-12 18:15:34','2021-04-12 19:43:15'),(214,1,'本町','センタービル000','２号室','20','50','24',0,'5420012','大阪府','大阪市中央区谷町','本町センタービルB1F',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'8：00～20：00（日曜祝日は締め切り）','終日締め切り（内側からは常時出ていける）','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-04-12 18:25:52','2021-04-12 19:43:00'),(224,0,'四ツ橋','サンワールドビル','1号室','50.55','250.05','120',1,'5500014','大阪府','大阪市西区北堀江','サンワールドビル',NULL,'薄雲','一','ウスグモ','イチ','07054650744','usugumo@s-mg.co.jp',0,'550','おおさか','おおさかし','さんわーるど','kabu さんわーるど','06-6538-4329',NULL,'チョウエイ','066666666','055555555','うすぐも','iti','07054650744','usugumo@biz-strategy.com','ディーケー','00',NULL,NULL,NULL,NULL,'1',NULL,NULL,'株式会社3ワールド','0665384329','0665384315',NULL,NULL,'2021-04-12 19:01:29','2021-04-12 19:01:29'),(234,1,'本町000','センタービル','1号室','15.00','45.01','50',0,'5500014','大阪府','5500014','22222',NULL,'000','000','カタ','カナ','0000','00000@555',1,NULL,NULL,NULL,NULL,NULL,NULL,60,'株式会社サンワールドコミュニケーションズ','0665566149','000','タルタル','タル','0','usugumo@biz-strategy.com','000','0000',NULL,NULL,NULL,NULL,'0',NULL,NULL,'ｔｒｔｒｔｒ','000','000',NULL,NULL,'2021-04-12 19:31:49','2021-04-12 19:42:41'),(244,1,'本町','センタービル','1号室','21','69.4','10～36',1,'5410053','大阪府','大阪市中央区本町2-6-10','本町センタービルB1F',NULL,'伊藤',NULL,'イトウ',NULL,NULL,'pm146203@tbs-net.co.jp',0,'5410053','大阪府','大阪市中央区本町2-6-10','本町センタービルB1F','管理室','06-6120-2162',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'平日：8：00～19：30\r\n日・祝日：締め切り','平日：8：00～20：00\r\n日・祝日：締め切り','0',NULL,NULL,'株式会社東京ビジネスサービス','0661202162',NULL,NULL,NULL,'2021-04-12 20:32:01','2021-04-12 20:32:01');
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

-- Dump completed on 2021-04-13 14:19:08
