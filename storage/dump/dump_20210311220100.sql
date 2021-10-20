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
INSERT INTO `admins` VALUES (1,'admin','admin@example.com','$2y$10$AQZbIXZsd7MekWnGAclfyufyEN2M1gztqKwUzyZVc/nFp.Ssp1ToO','rz2t4S6Grh',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (1,'xishida','株式会社 笹田','2253696','大垣市','田辺町','木村町坂本3-6-3','舞','中村','稔','山口','04656-0-0456','0838-43-7794','06045-1-8739','mai91@sakamoto.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(11,'momoko.uno','有限会社 中津川','6512326','江古田市','吉本町','佐々木町青山4-7-1','零','村山','美加子','小林','01-4861-6603','080-1494-4374','0460-477-282','yasuhiro.idaka@yamada.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(21,'ryosuke40','有限会社 桐山','4835831','井上市','木村町','山口町渚1-5-7','千代','渡辺','くみ子','山岸','0410-060-399','04-1497-8287','00943-5-7097','manabu32@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(31,'jun26','有限会社 石田','1793151','吉本市','吉田町','宮沢町松本6-4-4','零','近藤','幹','藤本','080-8083-6077','090-0626-1181','03-9419-8005','jkiriyama@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(41,'yuki.fujimoto','有限会社 田辺','7242212','西之園市','田辺町','田辺町原田10-2-6','春香','工藤','裕太','井上','03715-8-7065','090-0685-7056','0330-087-881','lyamada@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(51,'hiroshi13','株式会社 工藤','7271823','加納市','吉田町','野村町津田2-4-4','花子','宮沢','治','鈴木','04-2461-2027','080-1790-0741','04-2272-8619','uno.mai@hirokawa.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(61,'cnomura','株式会社 杉山','6431142','坂本市','佐藤町','吉本町中島7-1-9','あすか','山口','太一','西之園','090-5500-2918','019-673-1821','0541-25-3585','oidaka@watanabe.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(71,'vyamada','株式会社 田中','6546597','笹田市','石田町','中津川町三宅3-1-2','知実','中島','明美','吉田','00-0962-6494','080-9959-4813','050-103-4831','laota@sasaki.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(81,'kudo.takuma','株式会社 中津川','5667149','中津川市','石田町','斉藤町青田5-2-3','稔','浜田','直子','青田','080-8686-6586','03-9735-1059','00-5649-9756','snakamura@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(91,'naoto37','有限会社 田中','6539197','村山市','西之園町','若松町藤本10-5-5','さゆり','松本','裕樹','田中','090-7744-8366','071-434-3232','090-7974-4093','vsato@miyake.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(101,'lkoizumi','有限会社 伊藤','1095225','高橋市','廣川町','藤本町吉田7-4-7','明美','浜田','洋介','近藤','049-259-5870','090-3696-4270','038-039-5038','sasaki.rika@tanaka.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(111,'sasaki.yosuke','有限会社 吉田','2176468','青山市','笹田町','木村町津田4-2-3','英樹','佐藤','修平','廣川','00173-9-7474','057-337-8862','03045-8-6822','tkijima@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(121,'rsasada','株式会社 吉本','6476976','山岸市','木村町','小泉町吉本2-9-7','裕樹','中島','春香','浜田','0960-431-916','0350-836-975','090-7727-3481','ssasada@miyazawa.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(131,'tomoya.kiriyama','株式会社 井上','9722269','藤本市','伊藤町','大垣町青山4-2-5','幹','中島','修平','木村','080-7899-5357','002-255-9970','080-3579-8097','ekoda.tomoya@yamada.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(141,'wnakatsugawa','株式会社 山口','8561334','原田市','田辺町','田中町津田4-3-7','翼','山本','充','青山','0902-29-8082','09566-5-1876','09-5237-8382','uno.yumiko@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(151,'lekoda','有限会社 笹田','2617948','加納市','若松町','江古田町木村9-1-8','里佳','浜田','稔','工藤','008-778-1397','009-491-6286','0008-22-4722','qyamamoto@ekoda.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(161,'osamu.yamaguchi','有限会社 木村','3485877','斉藤市','山本町','渡辺町西之園5-8-8','結衣','加藤','千代','伊藤','00911-4-3268','0435-41-8747','090-5550-2557','miki97@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(171,'fsakamoto','有限会社 中村','7251691','井上市','廣川町','井高町中津川2-3-8','幹','大垣','香織','井高','090-2753-7691','090-4382-7788','0861-03-8874','znakatsugawa@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(181,'soutaro09','株式会社 中島','6321827','田辺市','山口町','加納町井高5-8-9','さゆり','伊藤','桃子','桐山','05-6931-3613','047-272-1145','090-2620-5466','shuhei60@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(191,'nagisa.akira','株式会社 山本','3847142','原田市','中津川町','山本町佐藤6-8-4','加奈','原田','加奈','山口','0570-320-158','0510-110-182','080-9373-3981','hideki.yoshimoto@kijima.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(201,'ogaki.chiyo','有限会社 小林','6651213','中島市','松本町','笹田町津田6-7-5','結衣','木村','さゆり','加納','02-6072-1861','086-756-1716','0581-48-5963','yamagishi.yumiko@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(211,'tuno','有限会社 坂本','6235993','井上市','中村町','山岸町藤本8-2-4','直子','渚','里佳','加藤','090-3048-5531','041-184-7870','080-6720-6690','yumiko84@koizumi.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(221,'nakamura.rika','株式会社 鈴木','8649488','渡辺市','石田町','加納町田中2-4-3','智也','田辺','涼平','渚','080-0260-6986','0100-647-030','0580-41-5264','nakamura.shota@kudo.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(231,'soutaro.hirokawa','有限会社 木村','9533097','中津川市','中津川町','吉田町中島6-6-3','直子','桐山','英樹','井上','01-6312-8328','00629-8-0382','090-3661-3074','hiroshi99@yamagishi.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(241,'mkudo','有限会社 野村','8545795','吉田市','吉本町','高橋町笹田1-1-5','加奈','高橋','明美','近藤','080-3456-4511','0500-718-082','038-108-7909','iwakamatsu@ekoda.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(251,'mai.yamagishi','有限会社 山口','2527789','若松市','杉山町','中村町山岸10-4-1','京助','江古田','陽一','西之園','090-5766-0617','020-139-8609','090-5522-6975','satomi.sakamoto@sakamoto.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(261,'asuka22','有限会社 野村','6866851','原田市','斉藤町','田中町中村2-8-10','香織','中島','直子','喜嶋','06296-1-3162','061-488-8400','080-9334-5530','shuhei94@yamagishi.info',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(271,'hamada.hideki','有限会社 大垣','9991605','高橋市','浜田町','井高町鈴木8-1-4','英樹','坂本','千代','田中','090-4985-1449','0680-079-546','013-619-1040','chirokawa@miyazawa.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(281,'dyoshimoto','株式会社 山口','4253249','佐々木市','井上町','高橋町宮沢5-8-6','千代','吉田','陽子','原田','0140-906-268','090-2700-8078','09842-9-8180','tnishinosono@tanaka.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(291,'hkiriyama','株式会社 宇野','7016752','野村市','田辺町','大垣町田辺10-5-5','京助','青田','治','浜田','090-2417-9934','076-545-7083','0860-568-040','soutaro.kobayashi@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(301,'yuta.nakamura','株式会社 小泉','8176959','中村市','杉山町','中島町中津川9-6-6','明美','中村','修平','松本','061-187-9210','0460-906-371','080-6088-8019','mikako.murayama@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(311,'byoshida','有限会社 佐々木','1315338','加納市','江古田町','藤本町斉藤1-6-4','直人','工藤','美加子','原田','090-7730-4847','015-861-9371','060-877-7800','tsubasa96@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(321,'taro89','有限会社 津田','2792394','山口市','木村町','津田町藤本5-4-9','幹','若松','加奈','近藤','002-022-3090','0485-08-4822','080-3584-0857','sasaki.hiroshi@kudo.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(331,'gsaito','株式会社 喜嶋','5078358','吉本市','野村町','大垣町若松9-2-9','太一','廣川','千代','近藤','00895-6-2925','090-8626-6846','080-2470-1958','rika.kiriyama@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(341,'xmiyake','株式会社 小林','4615636','木村市','津田町','山本町加納4-5-2','康弘','鈴木','篤司','小泉','080-4729-8046','0030-570-862','0290-183-787','akemi.sakamoto@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(351,'osamu53','株式会社 桐山','3933577','青山市','坂本町','中島町吉田6-5-1','香織','工藤','陽子','喜嶋','090-8321-8851','0587-58-4185','08-7752-6966','zsuzuki@ishida.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(361,'satomi29','有限会社 中村','2101607','若松市','山口町','木村町石田1-1-7','香織','西之園','真綾','田辺','0032-47-8611','080-882-1777','044-918-3112','uno.naoto@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(371,'uyamagishi','有限会社 田中','5345964','宇野市','中島町','西之園町西之園4-9-7','和也','中村','千代','木村','00406-1-1707','049-773-2144','034-804-4616','akira18@kanou.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(381,'naoto.nakajima','株式会社 宮沢','7356490','大垣市','青山町','村山町廣川10-2-1','智也','青山','舞','山本','0445-91-8066','00662-6-4354','0190-525-033','osamu53@kudo.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(391,'yosuke51','株式会社 中島','6863762','山口市','宮沢町','野村町松本4-4-10','あすか','桐山','英樹','加納','090-2755-4633','0060-775-284','03-6844-5250','dwakamatsu@yamada.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(401,'satomi25','有限会社 佐藤','2565634','小泉市','大垣町','杉山町石田5-3-1','直人','伊藤','英樹','中津川','025-427-7846','0678-26-3774','090-4951-4066','kyosuke26@takahashi.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(411,'naoki.yamaguchi','株式会社 宮沢','9871117','三宅市','浜田町','山本町青山2-2-7','治','吉本','七夏','斉藤','090-4397-4256','080-4826-7347','0390-129-309','yoshida.soutaro@idaka.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(421,'ryohei.wakamatsu','株式会社 宇野','8297015','吉田市','藤本町','青田町中津川6-2-5','篤司','伊藤','和也','伊藤','080-6216-6775','080-7297-6560','0431-88-5994','idaka.manabu@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(431,'naoki20','株式会社 井上','3831165','吉本市','青山町','坂本町山口7-7-8','篤司','藤本','幹','渡辺','080-0317-2939','09818-2-6630','080-5671-0259','yosuke.tanabe@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(441,'kimura.kazuya','有限会社 山田','9358103','田辺市','大垣町','山岸町中津川10-3-6','太郎','井上','和也','野村','0740-294-396','05-4378-7026','080-6999-0351','yoshida.akemi@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(451,'pito','株式会社 木村','9032418','桐山市','小林町','井上町中津川7-5-10','裕太','廣川','舞','加藤','06309-4-3050','0500-82-5696','047-106-8548','takahashi.manabu@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(461,'akemi23','株式会社 加藤','2827344','坂本市','杉山町','佐藤町渡辺10-3-1','さゆり','山田','美加子','村山','051-544-3899','09571-2-6560','06-9906-0809','soutaro.hirokawa@sasaki.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(471,'shota.kimura','有限会社 青山','9144406','村山市','廣川町','加藤町高橋1-9-3','真綾','石田','陽一','藤本','0750-817-776','080-9253-9496','090-0511-9122','tomoya13@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(481,'thirokawa','株式会社 小泉','5228893','喜嶋市','井高町','笹田町中村2-10-8','翔太','藤本','七夏','村山','080-7848-3551','08-6575-9552','080-3081-0024','kenichi.matsumoto@aota.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(491,'nakamura.rei','株式会社 石田','4459233','石田市','津田町','青山町西之園6-8-7','里佳','西之園','洋介','青山','03-4057-6172','0960-660-502','090-4841-2912','yoko.tanaka@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 19:14:29','2021-03-11 19:14:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dates`
--

LOCK TABLES `dates` WRITE;
/*!40000 ALTER TABLE `dates` DISABLE KEYS */;
INSERT INTO `dates` VALUES (1,1,1,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(11,1,2,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(21,1,3,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(31,1,4,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(41,1,5,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(51,1,6,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(61,1,7,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(71,11,1,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(81,11,2,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(91,11,3,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(101,11,4,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(111,11,5,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(121,11,6,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(131,11,7,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(141,21,1,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(151,21,2,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(161,21,3,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(171,21,4,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(181,21,5,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(191,21,6,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29'),(201,21,7,'08:00:00','23:00:00','2021-03-11 19:14:29','2021-03-11 19:14:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_venue`
--

LOCK TABLES `equipment_venue` WRITE;
/*!40000 ALTER TABLE `equipment_venue` DISABLE KEYS */;
INSERT INTO `equipment_venue` VALUES (1,1,1,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(11,1,11,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(21,1,21,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(31,1,31,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(41,1,41,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(51,1,51,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(61,1,61,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(71,1,71,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(81,11,1,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(91,11,11,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(101,11,21,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(111,11,31,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(121,11,41,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(131,11,51,'2021-03-11 19:18:15','2021-03-11 19:18:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
INSERT INTO `equipments` VALUES (1,'有線マイク',3000,10,NULL,'2021-03-11 19:14:28',NULL),(11,'無線マイク',3000,10,NULL,'2021-03-11 19:14:28',NULL),(21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,10,NULL,'2021-03-11 19:14:28',NULL),(31,'【追加】次亜塩素酸水専用・超音波加湿器',500,10,NULL,'2021-03-11 19:14:28',NULL),(41,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,10,NULL,'2021-03-11 19:14:28',NULL),(51,'ホワイトボード（幅120㎝）',2500,10,NULL,'2021-03-11 19:14:28',NULL),(61,'プロジェクター',3000,10,NULL,'2021-03-11 19:14:28',NULL),(71,'既存パーテーションの移動',2000,10,NULL,'2021-03-11 19:14:28',NULL),(81,'レーザーポインター',1000,10,NULL,'2021-03-11 19:14:28',NULL),(91,'iphone(Lightning)⇔VGA変換ケーブル',1000,10,NULL,'2021-03-11 19:14:28',NULL),(101,'iphone(Lightning)DVDプレイヤー',2000,10,NULL,'2021-03-11 19:14:28',NULL),(111,'CDプレイヤー',1000,10,NULL,'2021-03-11 19:14:28',NULL),(121,'持ち運びパーテーション',1000,10,NULL,'2021-03-11 19:14:28',NULL),(131,'卓球台セット',1000,10,NULL,'2021-03-11 19:14:28',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_prices`
--

LOCK TABLES `frame_prices` WRITE;
/*!40000 ALTER TABLE `frame_prices` DISABLE KEYS */;
INSERT INTO `frame_prices` VALUES (1,1,'午前','10:00:00','12:00:00',15000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(11,1,'午後','13:00:00','17:00:00',30000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(21,1,'夜間','18:00:00','23:00:00',15000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(31,1,'午前＆午後','10:00:00','17:00:00',36000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(41,1,'午後＆夜間','13:00:00','21:00:00',36000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(51,1,'終日','10:00:00','21:00:00',42000,5000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(61,11,'午前','10:00:00','12:00:00',17000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(71,11,'午後','13:00:00','17:00:00',36000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(81,11,'夜間','18:00:00','23:00:00',17000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(91,11,'午前＆午後','10:00:00','17:00:00',42000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(101,11,'午後＆夜間','13:00:00','21:00:00',42000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(111,11,'終日','10:00:00','21:00:00',50000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(121,21,'午前','10:00:00','12:00:00',17000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(131,21,'午後','13:00:00','17:00:00',36000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(141,21,'夜間','18:00:00','23:00:00',17000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(151,21,'午前＆午後','10:00:00','17:00:00',42000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(161,21,'午後＆夜間','13:00:00','21:00:00',42000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(171,21,'終日','10:00:00','21:00:00',50000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=1411 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1121,'2014_10_12_000000_create_users_table',1),(1131,'2014_10_12_100000_create_password_resets_table',1),(1141,'2019_08_19_000000_create_failed_jobs_table',1),(1151,'2020_02_01_090636_create_admins_table',1),(1161,'2020_09_18_090242_create_venues_table',1),(1171,'2020_09_20_044412_create_equipments_table',1),(1181,'2020_09_20_065837_create_venue_equipment_table',1),(1191,'2020_09_22_094627_create_services_table',1),(1201,'2020_09_24_064549_create_dates_table',1),(1211,'2020_09_24_072535_create_service_venue_table',1),(1221,'2020_09_24_100404_create_date_venue_table',1),(1231,'2020_09_29_055630_create_frame_prices_table',1),(1241,'2020_10_01_062150_create_time_prices_table',1),(1251,'2020_10_07_145320_create_email_verification_table',1),(1261,'2020_10_08_104339_create_agents_table',1),(1271,'2020_10_12_132928_create_preusers_table',1),(1281,'2020_10_19_163736_create_reservations_table',1),(1291,'2020_12_23_174247_create_bills_table',1),(1301,'2020_12_23_182424_create_breakdowns_table',1),(1311,'2021_02_08_153525_create_endusers_table',1),(1321,'2021_02_15_134342_create_pre_reservations_table',1),(1331,'2021_02_15_134831_create_pre_bills_table',1),(1341,'2021_02_15_135246_create_pre_breakdowns_table',1),(1351,'2021_02_15_140439_create_unknown_users_table',1),(1361,'2021_02_17_163902_create_multiple_reserves_table',1),(1371,'2021_02_23_122139_create_pre_endusers_table',1),(1381,'2021_03_07_164513_create_cxls_table',1),(1391,'2021_03_07_164951_create_cxl_breakdowns_table',1),(1401,'2021_03_11_170012_add_charge_to_pre_endusers_table',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_reserves`
--

LOCK TABLES `multiple_reserves` WRITE;
/*!40000 ALTER TABLE `multiple_reserves` DISABLE KEYS */;
INSERT INTO `multiple_reserves` VALUES (1,'2021-03-11 19:20:30','2021-03-11 19:20:30'),(11,'2021-03-11 19:36:37','2021-03-11 19:36:37'),(21,'2021-03-11 20:10:43','2021-03-11 20:10:43'),(31,'2021-03-11 20:28:31','2021-03-11 20:28:31'),(41,'2021-03-11 20:36:50','2021-03-11 20:36:50'),(51,'2021-03-11 21:11:44','2021-03-11 21:11:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_bills`
--

LOCK TABLES `pre_bills` WRITE;
/*!40000 ALTER TABLE `pre_bills` DISABLE KEYS */;
INSERT INTO `pre_bills` VALUES (1,1,35000,17700,0,0,52700,5270,57970,0,NULL,1,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(21,21,0,0,5000,0,21000,2100,23100,0,NULL,1,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(31,41,0,0,5000,0,21000,2100,23100,0,NULL,1,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(41,51,0,0,5000,0,21000,2100,23100,0,NULL,1,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(51,61,0,0,5000,0,21000,2100,23100,0,NULL,1,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(61,81,0,0,5000,0,21000,2100,23100,0,NULL,1,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(151,141,0,0,13000,0,30000,3000,33000,0,NULL,1,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(161,161,0,0,13000,0,30000,3000,33000,0,NULL,1,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(171,121,0,0,8000,0,25000,2500,27500,0,NULL,1,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(191,131,0,0,13000,0,24000,2400,26400,0,NULL,1,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(211,221,0,0,0,0,15000,1500,16500,0,NULL,1,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(221,231,0,0,0,0,15000,1500,16500,0,NULL,1,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(231,211,0,0,0,0,9000,900,9900,0,NULL,1,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(261,91,0,0,5000,0,22000,2200,24200,0,NULL,1,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(291,151,0,0,5000,0,18000,1800,19800,0,NULL,1,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(301,101,0,0,13000,0,30000,3000,33000,0,NULL,1,'2021-03-11 21:07:09','2021-03-11 21:07:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=2611 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_breakdowns`
--

LOCK TABLES `pre_breakdowns` WRITE;
/*!40000 ALTER TABLE `pre_breakdowns` DISABLE KEYS */;
INSERT INTO `pre_breakdowns` VALUES (1,1,'会場料金',30000,'2.5',30000,1,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(11,1,'延長料金',5000,'1',5000,1,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(21,1,'有線マイク',3000,'1',3000,2,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(31,1,'無線マイク',3000,'1',3000,2,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(41,1,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,'11',11000,2,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(51,1,'領収書発行',200,'1',200,3,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(61,1,'鍵レンタル',500,'1',500,3,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(151,21,'会場料金',0,'4.5',0,1,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(161,21,'有線マイク',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(171,21,'無線マイク',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(181,21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(191,21,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(201,21,'領収書発行',0,'1',0,3,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(211,21,'鍵レンタル',0,'1',0,3,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(221,21,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(231,31,'会場料金',0,'7',0,1,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(241,31,'有線マイク',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(251,31,'無線マイク',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(261,31,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(271,31,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(281,31,'領収書発行',0,'1',0,3,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(291,31,'鍵レンタル',0,'1',0,3,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(301,31,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 19:26:27','2021-03-11 19:26:27'),(311,41,'会場料金',0,'7',0,1,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(321,41,'有線マイク',0,'1',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(331,41,'無線マイク',0,'1',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(341,41,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'11',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(351,41,'領収書発行',0,'1',0,3,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(361,41,'鍵レンタル',0,'1',0,3,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(371,41,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(381,51,'会場料金',0,'3',0,1,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(391,51,'有線マイク',0,'1',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(401,51,'無線マイク',0,'1',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(411,51,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'11',0,2,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(421,51,'領収書発行',0,'1',0,3,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(431,51,'鍵レンタル',0,'1',0,3,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(441,51,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 19:38:05','2021-03-11 19:38:05'),(451,61,'会場料金',0,'5',0,1,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(461,61,'有線マイク',0,'1',0,2,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(471,61,'無線マイク',0,'1',0,2,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(481,61,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'11',0,2,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(491,61,'領収書発行',0,'1',0,3,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(501,61,'鍵レンタル',0,'1',0,3,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(511,61,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 19:38:06','2021-03-11 19:38:06'),(1281,151,'会場料金',0,'0',0,1,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1291,151,'有線マイク',0,'1',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1301,151,'無線マイク',0,'1',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1311,151,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'11',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1321,151,'領収書発行',0,'1',0,3,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1331,151,'鍵レンタル',0,'1',0,3,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1341,151,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1351,151,'レイアウト片付料金',8000,'1',8000,4,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1361,161,'会場料金',0,'5',0,1,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1371,161,'有線マイク',0,'1',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1381,161,'無線マイク',0,'1',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1391,161,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'11',0,2,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1401,161,'領収書発行',0,'1',0,3,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1411,161,'鍵レンタル',0,'1',0,3,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1421,161,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1431,161,'レイアウト片付料金',8000,'1',8000,4,'2021-03-11 20:29:41','2021-03-11 20:29:41'),(1441,171,'会場料金',0,'3.5',0,1,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1451,171,'有線マイク',0,'1',0,2,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1461,171,'無線マイク',0,'1',0,2,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1471,171,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'5',0,2,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1481,171,'領収書発行',0,'1',0,3,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1491,171,'鍵レンタル',0,'1',0,3,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1501,171,'レイアウト片付料金',8000,'1',8000,4,'2021-03-11 20:29:55','2021-03-11 20:29:55'),(1591,191,'会場料金',0,'1.5',0,1,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1601,191,'有線マイク',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1611,191,'無線マイク',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1621,191,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1631,191,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1641,191,'赤外線温度計（非接触型体温計）＋スプレーボトル',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1651,191,'ホワイトボード（幅120㎝）',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1661,191,'プロジェクター',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1671,191,'既存パーテーションの移動',0,'1',0,2,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1681,191,'領収書発行',0,'1',0,3,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1691,191,'鍵レンタル',0,'1',0,3,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1701,191,'プロジェクター設置',0,'1',0,3,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1711,191,'DVDプレイヤー設置',0,'1',0,3,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1721,191,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1731,191,'レイアウト片付料金',8000,'1',8000,4,'2021-03-11 20:32:19','2021-03-11 20:32:19'),(1801,211,'会場料金',0,'4.5',0,1,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1811,211,'有線マイク',0,'1',0,2,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1821,211,'無線マイク',0,'1',0,2,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1831,211,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1841,211,'領収書発行',0,'1',0,3,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1851,211,'鍵レンタル',0,'1',0,3,'2021-03-11 20:39:00','2021-03-11 20:39:00'),(1861,221,'会場料金',0,'3.5',0,1,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1871,221,'有線マイク',0,'1',0,2,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1881,221,'無線マイク',0,'1',0,2,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1891,221,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1901,221,'領収書発行',0,'1',0,3,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1911,221,'鍵レンタル',0,'1',0,3,'2021-03-11 20:39:01','2021-03-11 20:39:01'),(1921,231,'会場料金',0,'9',0,1,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(1931,231,'有線マイク',0,'1',0,2,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(1941,231,'無線マイク',0,'1',0,2,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(1951,231,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(1961,231,'領収書発行',0,'1',0,3,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(1971,231,'鍵レンタル',0,'1',0,3,'2021-03-11 20:40:22','2021-03-11 20:40:22'),(2141,261,'会場料金',0,'7.5',0,1,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2151,261,'有線マイク',0,'1',0,2,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2161,261,'無線マイク',0,'1',0,2,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2171,261,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2181,261,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2191,261,'領収書発行',0,'1',0,3,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2201,261,'鍵レンタル',0,'1',0,3,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2211,261,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 20:48:56','2021-03-11 20:48:56'),(2381,291,'会場料金',0,'2.5',0,1,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2391,291,'有線マイク',0,'1',0,2,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2401,291,'無線マイク',0,'1',0,2,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2411,291,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2421,291,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2431,291,'領収書発行',0,'1',0,3,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2441,291,'鍵レンタル',0,'1',0,3,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2451,291,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 20:58:15','2021-03-11 20:58:15'),(2461,301,'会場料金',0,'5',0,1,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2471,301,'有線マイク',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2481,301,'無線マイク',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2491,301,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2501,301,'【追加】次亜塩素酸水専用・超音波加湿器',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2511,301,'赤外線温度計（非接触型体温計）＋スプレーボトル',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2521,301,'ホワイトボード（幅120㎝）',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2531,301,'プロジェクター',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2541,301,'既存パーテーションの移動',0,'1',0,2,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2551,301,'領収書発行',0,'1',0,3,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2561,301,'鍵レンタル',0,'1',0,3,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2571,301,'プロジェクター設置',0,'1',0,3,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2581,301,'DVDプレイヤー設置',0,'1',0,3,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2591,301,'レイアウト準備料金',5000,'1',5000,4,'2021-03-11 21:07:09','2021-03-11 21:07:09'),(2601,301,'レイアウト片付料金',8000,'1',8000,4,'2021-03-11 21:07:09','2021-03-11 21:07:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_endusers`
--

LOCK TABLES `pre_endusers` WRITE;
/*!40000 ALTER TABLE `pre_endusers` DISABLE KEYS */;
INSERT INTO `pre_endusers` VALUES (1,11,'株式会社takram','山田太郎','maruoka@web-trickster.com','08012345678','0612345678','大阪市東成区玉津',3,'2021-03-11 19:20:30','2021-03-11 19:26:27',80000),(11,21,'株式会社takram','山田太郎','maruoka@web-trickster.com','08012345678','0612345678','大阪市東成区玉津',3,'2021-03-11 19:20:30','2021-03-11 19:26:27',80000),(21,31,'株式会社takram','山田太郎','maruoka@web-trickster.com','08012345678','0612345678','大阪市東成区玉津',3,'2021-03-11 19:20:30','2021-03-11 19:20:30',0),(31,41,'株式会社takram','山田太郎','maruoka@web-trickster.com','08012345678','0612345678','大阪市東成区玉津',3,'2021-03-11 19:20:30','2021-03-11 19:26:27',80000),(41,51,'株式会社baige','山田花子','yamada@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 19:36:37','2021-03-11 19:38:05',80000),(51,61,'株式会社baige','山田花子','yamada@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 19:36:37','2021-03-11 19:38:05',80000),(61,71,'株式会社baige','山田花子','yamada@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 19:36:37','2021-03-11 19:36:37',0),(71,81,'株式会社baige','山田花子','yamada@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 19:36:37','2021-03-11 19:38:05',80000),(81,91,'株式会社つばさ','山田次郎','yamada@gmail.com','08012345678','0612345678','大阪市',0,'2021-03-11 20:10:44','2021-03-11 20:47:18',85000),(91,101,'株式会社つばさ','山田次郎','yamada@gmail.com','08012345678','0612345678','大阪市',0,'2021-03-11 20:10:44','2021-03-11 21:07:09',85000),(101,111,'株式会社つばさ','山田次郎','yamada@gmail.com','08012345678','0612345678','大阪市',0,'2021-03-11 20:10:44','2021-03-11 20:10:44',0),(111,121,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:29:40',85000),(121,131,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:29:41',85000),(131,141,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:29:41',85000),(141,151,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:58:15',65000),(151,161,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:29:41',85000),(161,171,'株式会社キメル','山田桃子','momoko@gmail.com','08012345678','0612345678','大阪市',2,'2021-03-11 20:28:31','2021-03-11 20:28:31',0),(171,211,'株式会社トリックスター','竈門丹次郎','kamadon@gmial.com','08012345678','0612345678','世界',4,'2021-03-11 20:36:50','2021-03-11 20:39:00',75000),(181,221,'株式会社トリックスター','竈門丹次郎','kamadon@gmial.com','08012345678','0612345678','世界',4,'2021-03-11 20:36:50','2021-03-11 20:39:00',75000),(191,231,'株式会社トリックスター','竈門丹次郎','kamadon@gmial.com','08012345678','0612345678','世界',4,'2021-03-11 20:36:50','2021-03-11 20:39:00',75000);
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
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_reservations`
--

LOCK TABLES `pre_reservations` WRITE;
/*!40000 ALTER TABLE `pre_reservations` DISABLE KEYS */;
INSERT INTO `pre_reservations` VALUES (1,0,1,11,0,'2021-05-14',1,'12:00:00','14:30:00',0,'12:00:00','12:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'山田太郎','09044906001',NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 19:19:26','2021-03-11 19:19:26'),(21,1,1,0,1,'2021-05-21',1,'13:30:00','18:00:00',1,'15:00:00','16:30:00','デザイン経営','ホゲホゲ','株式会社テスト','1',NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,NULL,'2021-03-11 19:20:30','2021-03-11 19:26:27'),(31,1,11,0,1,'2021-05-21',NULL,'14:00:00','18:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 19:20:30','2021-03-11 19:20:30'),(41,1,1,0,1,'2021-05-24',1,'13:30:00','20:30:00',1,'15:00:00','16:30:00','デザイン経営','ホゲホゲ','株式会社テスト','1',NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,NULL,'2021-03-11 19:20:30','2021-03-11 19:26:27'),(51,11,1,0,21,'2021-05-14',1,'11:30:00','18:30:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 19:36:37','2021-03-11 19:38:05'),(61,11,1,0,21,'2021-05-21',1,'11:00:00','14:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 19:36:37','2021-03-11 19:38:05'),(71,11,11,0,21,'2021-05-28',NULL,'11:00:00','11:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 19:36:37','2021-03-11 19:36:37'),(81,11,1,0,21,'2021-05-27',1,'14:00:00','19:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 19:36:37','2021-03-11 19:38:05'),(91,21,1,0,1,'2021-04-23',1,'13:30:00','21:00:00',1,'13:30:00','21:00:00','アウトドアコース','キャンピングカー','モンベル','1','1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:10:44','2021-03-11 20:48:55'),(101,21,1,0,1,'2021-04-30',1,'12:00:00','17:00:00',1,'12:00:00','17:00:00',NULL,NULL,NULL,'1','1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:10:44','2021-03-11 20:49:22'),(111,21,11,0,1,'2021-04-23',NULL,'15:30:00','21:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:10:44','2021-03-11 20:10:44'),(121,31,1,0,31,'2021-07-16',1,'14:00:00','17:30:00',0,'14:00:00','17:30:00',NULL,NULL,NULL,'1','1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:29:55'),(131,31,1,0,31,'2021-07-23',1,'15:00:00','13:30:00',0,'15:00:00','13:30:00','アウトドア講習会','キャンプの組み立て方','スノーピーク','1','1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:32:19'),(141,31,1,0,31,'2021-07-22',1,'17:00:00','17:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:29:41'),(151,31,11,0,31,'2021-07-22',1,'15:00:00','17:30:00',0,'15:00:00','17:30:00','デザイン経営','ホゲホゲ','株式会社テスト',NULL,'1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:58:15'),(161,31,1,0,31,'2021-07-09',1,'15:00:00','20:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:29:41'),(171,31,21,0,31,'2021-07-22',NULL,'15:30:00','20:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:28:31','2021-03-11 20:28:31'),(181,31,21,0,31,'2021-05-13',NULL,'13:30:00','20:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:34:08','2021-03-11 20:34:08'),(191,31,21,0,31,'2021-05-20',NULL,'14:30:00','20:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:34:08','2021-03-11 20:34:08'),(201,31,21,0,31,'2021-05-28',NULL,'18:30:00','21:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:34:08','2021-03-11 20:34:08'),(211,41,11,0,1,'2021-06-18',1,'11:00:00','20:00:00',0,'11:00:00','20:00:00',NULL,NULL,NULL,NULL,'1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:36:50','2021-03-11 20:40:22'),(221,41,11,0,1,'2021-06-11',1,'15:30:00','20:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:36:50','2021-03-11 20:39:00'),(231,41,11,0,1,'2021-06-22',1,'17:30:00','21:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 20:36:50','2021-03-11 20:39:00'),(241,51,1,1,0,'2021-05-21',NULL,'15:30:00','21:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 21:11:44','2021-03-11 21:11:44'),(251,51,1,1,0,'2021-05-28',NULL,'14:30:00','19:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-11 21:11:44','2021-03-11 21:11:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_venue`
--

LOCK TABLES `service_venue` WRITE;
/*!40000 ALTER TABLE `service_venue` DISABLE KEYS */;
INSERT INTO `service_venue` VALUES (1,1,1,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(11,1,11,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(21,1,21,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(31,1,31,'2021-03-11 19:17:50','2021-03-11 19:17:50'),(41,11,1,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(51,11,11,'2021-03-11 19:18:15','2021-03-11 19:18:15'),(61,11,21,'2021-03-11 19:18:15','2021-03-11 19:18:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'領収書発行',200,NULL,'2021-03-11 19:14:28',NULL),(11,'鍵レンタル',500,NULL,'2021-03-11 19:14:28',NULL),(21,'プロジェクター設置',2000,NULL,'2021-03-11 19:14:28',NULL),(31,'DVDプレイヤー設置',2000,NULL,'2021-03-11 19:14:28',NULL);
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
INSERT INTO `time_prices` VALUES (1,1,3,32500,5900,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(11,1,4,38400,7100,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(21,1,6,46000,6000,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(31,1,8,52400,5300,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(41,1,12,64000,4500,'2021-03-11 19:14:29','2021-03-11 19:14:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=1531 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ooyama@web-trickster.com','$2y$10$gxIo643Wi6UOew08cgMkVOXmHTgBl1BikYL1iIyYnQN0dul5r9sqS','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'大山','紘一郎','オオヤマ','コウイチロウ',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'8pcePsR4i0',NULL,NULL),(11,'kudou@web-trickster.com','$2y$10$daXabV5SY1W5QNtx9yJjNuA/fv0b37hpcbcCaYwI6dNiK16ZiVO1C','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'工藤','大揮','クドウ','ダイキ',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'8dpGDF0BXW',NULL,NULL),(999,'sample@sample.com','$2y$10$Pr0Eg1v44hMWNYZFZEpnRORPGOIoUugawPVBCo3EDbwh1WT3ZYTb6','（未登録ユーザー）','（未設定）','（未設定）','（未設定）','（未設定）',NULL,NULL,NULL,NULL,'（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'CkDrddO3KP',NULL,NULL),(1001,'momoko98@example.org','$2y$10$02H/p0IpK2p0P54GmMZN8eBYCAa8x47Aa.foFeaZSCRNCPNdvEzkC','株式会社 工藤','9314724','石田市','原田町','山本町井高10-9-7',NULL,NULL,NULL,NULL,'笹田','太郎','ダミーのため一致しません','ダミーのため一致しません','06-7453-2746','090-625-9887',NULL,2,3,'3306166','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータとりは、「ですかに動きだけどこのような。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1011,'kondo.kana@example.com','$2y$10$2Wo7aTD3hstL9Ty3Dop62ewLzBNzQVmCVOp.gHVX7lZc8IXeAfIyK','有限会社 工藤','1337980','中津川市','原田町','中島町三宅9-3-2',NULL,NULL,NULL,NULL,'藤本','里佳','ダミーのため一致しません','ダミーのため一致しません','07-1323-5542','05-9499-0343',NULL,3,4,'4466705','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータゃりの手首てくすからおいて立ってあった。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1021,'ito.akira@example.com','$2y$10$Ce9TwSofFHnn5FksnmFsQ.5VKBQ8BQZcWXhkdhPaE4YYmvoFbwGPe','有限会社 山口','1462728','三宅市','青山町','山田町山岸8-9-1',NULL,NULL,NULL,NULL,'笹田','健一','ダミーのため一致しません','ダミーのため一致しません','0466-42-8959','0616-76-9423',NULL,1,2,'6929567','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータあかり、やはりがはねあててしまっ黒な頁。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1031,'ryosuke20@example.net','$2y$10$KLjPa45MfV6ua6Jtu2jU8OGBYAtPZFgvOyu9Cc309WbkzgkT9ZyWu','有限会社 佐藤','6487820','津田市','工藤町','桐山町浜田4-5-5',NULL,NULL,NULL,NULL,'村山','陽子','ダミーのため一致しません','ダミーのため一致しません','090-3819-9183','075-708-0751',NULL,2,2,'5494962','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはじめはまったね。この人はしらのいると。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1041,'hirokawa.mai@example.net','$2y$10$pIViAmBceSpYxOSNi5MpYezdQmHWam5hQnZgjwBx9.UnZK.AucTNS','株式会社 山田','9656599','小泉市','佐々木町','小泉町山岸3-5-7',NULL,NULL,NULL,NULL,'田中','幹','ダミーのため一致しません','ダミーのため一致しません','0720-476-528','090-8089-5657',NULL,0,1,'2916008','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータたいとこへ行くよ。しっぽうだろう」ジョ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1051,'nanami43@example.net','$2y$10$3PRI5IEu3.5LJco0HH4snOoONHgAsypfXxy/JBatuB.t3Vy9IiQl2','株式会社 小林','2918048','山田市','山本町','桐山町村山1-6-7',NULL,NULL,NULL,NULL,'渡辺','真綾','ダミーのため一致しません','ダミーのため一致しません','09392-0-2746','025-018-3804',NULL,0,1,'8901844','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの授業じゅうになってあると、こった。ま。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1061,'hiroshi57@example.com','$2y$10$Gu0aQ9w.HFy90jJImrqoH.lkAu/gKXwwQmzmw0pekf7RjU/c4YjKS','株式会社 田辺','7062085','山口市','三宅町','井上町笹田4-9-10',NULL,NULL,NULL,NULL,'井高','七夏','ダミーのため一致しません','ダミーのため一致しません','01-3686-8862','090-9088-8011',NULL,0,1,'9868398','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータりを水銀すい緑みどり、時々、やはげしい。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1071,'osamu.watanabe@example.com','$2y$10$y8hLNeCaMlbRdcs7gas69.jz2vr8KjRVye9vuIijhFMlxqygseNla','株式会社 田中','5546205','廣川市','井上町','西之園町大垣7-2-9',NULL,NULL,NULL,NULL,'吉田','裕太','ダミーのため一致しません','ダミーのため一致しません','0960-657-879','044-947-5541',NULL,3,3,'1016001','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータカムパネルラは、鳥捕とりは、どうか」が。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1081,'rei.koizumi@example.org','$2y$10$HXwT9e/Cucjs/VU71JOk8OQ91pwcQpgEzSoFl1GWO4C2lKs5gL3kK','有限会社 江古田','9679420','伊藤市','江古田町','坂本町山口2-5-4',NULL,NULL,NULL,NULL,'工藤','裕美子','ダミーのため一致しません','ダミーのため一致しません','069-315-8513','0809-85-4037',NULL,0,4,'2927121','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータがります」ジョバンニはそっちに祈いのを。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1091,'ishida.shota@example.org','$2y$10$wmmFcxggGCPeCh2sZCxY3eJsG31ywPeHQuiwcEvivMBFJQPmcn8dS','有限会社 渡辺','1517821','佐々木市','加藤町','松本町井上8-8-3',NULL,NULL,NULL,NULL,'桐山','康弘','ダミーのため一致しません','ダミーのため一致しません','0610-990-208','0671-09-6047',NULL,3,2,'6472399','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ果りんごをして外をならもうこんなになっ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1101,'yamamoto.yoko@example.org','$2y$10$eLKQQfKFDYEV0trDxhqsU.vadswv5ZS2h3EN4tAGDE9ofU9sgp8Xq','株式会社 山本','7819220','青山市','野村町','井上町加納3-7-4',NULL,NULL,NULL,NULL,'松本','浩','ダミーのため一致しません','ダミーのため一致しません','042-386-8398','0780-623-977',NULL,2,3,'1746219','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータつ組み合わせましたために！「さあ、その。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1111,'ito.satomi@example.com','$2y$10$C9UVCmbl8jGW9PKb03nA/uCYFCP9JuvldlYcchvyuOpx.YjO67EvC','株式会社 斉藤','9484578','藤本市','木村町','斉藤町津田10-2-2',NULL,NULL,NULL,NULL,'藤本','里佳','ダミーのため一致しません','ダミーのため一致しません','01-9898-2266','09-8352-4504',NULL,1,4,'6024436','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいちのために、ぴたったいのです。まって。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1121,'hiroshi.hirokawa@example.org','$2y$10$aFkXW2OnvUzoYHuCR0/piu9whCUw752I/TRCv3//YzyHXFXO2k0.G','有限会社 中島','2355751','笹田市','渡辺町','小泉町井高3-3-10',NULL,NULL,NULL,NULL,'坂本','裕美子','ダミーのため一致しません','ダミーのため一致しません','00068-3-3638','090-8964-7936',NULL,3,2,'2343162','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ所かったのだ。けれどもりの字を印刷いん。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1131,'miyake.asuka@example.net','$2y$10$jxOZxJ9l8znnptnEetrgLuP95PxtpCE/ib4Fb9bMWTLBI2r/pKXpK','有限会社 中津川','4173406','木村市','廣川町','西之園町藤本4-3-5',NULL,NULL,NULL,NULL,'宮沢','里佳','ダミーのため一致しません','ダミーのため一致しません','07048-1-4104','097-131-9110',NULL,0,2,'1092860','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータめをそろえておいものがたいことは、黄い。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1141,'kazuya46@example.org','$2y$10$YrQXmbN/r6rfecb.sNKcn.wHoU1Xo/yq7mLk5lImJVXSTDza9TSte','株式会社 山本','1291991','若松市','井高町','笹田町山本4-1-1',NULL,NULL,NULL,NULL,'津田','拓真','ダミーのため一致しません','ダミーのため一致しません','080-9109-6648','0680-901-347',NULL,0,4,'9133570','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータたちはこんな」ジョバンニは走りだした。。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1151,'kondo.maaya@example.net','$2y$10$kT/cByMk5.i9I4mWbGYRiOyr7qkucsz7l4eN92RkYrmkZ/C/5d7r2','有限会社 工藤','8813047','西之園市','原田町','宮沢町山田3-10-10',NULL,NULL,NULL,NULL,'若松','治','ダミーのため一致しません','ダミーのため一致しません','09-6685-8965','090-8171-4457',NULL,2,4,'1008239','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんです」ジョバンニやカムパネルラのうし。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1161,'manabu82@example.net','$2y$10$lqGOFCPSQgqzeAXI.AA8HuNCo8QInJaoMkyEqhoToPmK7kx0AE3h.','有限会社 青田','5626463','津田市','杉山町','宮沢町吉本1-5-5',NULL,NULL,NULL,NULL,'笹田','翔太','ダミーのため一致しません','ダミーのため一致しません','03644-8-0182','090-8101-4667',NULL,2,4,'7412957','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ薄うすって、急いそがしてたふくろうどさ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1171,'yui.nakatsugawa@example.com','$2y$10$5VaI2mrGq9mXMoARGBa30O8QuObtTULQAxe.inw9PXwIDPqK2PTqC','株式会社 井高','6754239','山田市','井高町','坂本町加藤6-6-1',NULL,NULL,NULL,NULL,'藤本','明美','ダミーのため一致しません','ダミーのため一致しません','059-694-3255','090-6997-6625',NULL,0,1,'2519750','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータとの切符きっぷ持もちょうどさそりはこん。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1181,'nomura.yui@example.net','$2y$10$loh2wDqNC2c/MA5SzKLRwu74u3Lm/RhjjwS2Y4zqprK.Pn9KbGCeO','有限会社 西之園','7206589','山口市','加藤町','田辺町高橋8-2-6',NULL,NULL,NULL,NULL,'山本','千代','ダミーのため一致しません','ダミーのため一致しません','090-9443-8971','080-2036-5106',NULL,3,2,'5948716','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ三次空間じくうかんしつにつか蠍さそりっ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1191,'cekoda@example.net','$2y$10$a7tqwSbMXdJZ6rWDwPhRMevy2dotePhiAT6mRVUUgzpXXwcBUcCMG','有限会社 斉藤','2433758','大垣市','若松町','村山町青山3-1-7',NULL,NULL,NULL,NULL,'青山','智也','ダミーのため一致しません','ダミーのため一致しません','080-8683-7268','0550-512-069',NULL,3,4,'5077490','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータをつからだっていしょうめるかったでしょ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1201,'saito.takuma@example.net','$2y$10$ix0Tv5LvFrVyYs8wXzLyz.XVSnWiLGLgrmBHjcGWBc3WJrXqTHT5y','株式会社 近藤','8854832','渚市','青山町','原田町杉山9-3-10',NULL,NULL,NULL,NULL,'大垣','太一','ダミーのため一致しません','ダミーのため一致しません','048-639-3353','040-719-1644',NULL,3,1,'4218990','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ叫さけび声もはっきの入口の中はしばっと。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1211,'mikako.miyake@example.net','$2y$10$MJEkU5lQyeoDb7VvylSeFepyfrJmGytfz5z9Yc3y5FMRQGvPegjhi','株式会社 笹田','1683452','喜嶋市','渡辺町','石田町田中1-7-8',NULL,NULL,NULL,NULL,'田中','幹','ダミーのため一致しません','ダミーのため一致しません','05-4253-2904','01002-2-1921',NULL,3,4,'8422464','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータもってどしどし学校へ寄贈きぞうしろふく。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1221,'hiroshi.fujimoto@example.com','$2y$10$RK95sVcmx42Tyov7GFvxMu2S/AMXqNMRhvjykGvU8iC2ryUkFQp76','有限会社 吉田','3953381','浜田市','宮沢町','青山町渚9-10-1',NULL,NULL,NULL,NULL,'吉田','真綾','ダミーのため一致しません','ダミーのため一致しません','008-102-6194','080-2039-2624',NULL,3,1,'6207425','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータさきいでなしずかにゆるいたむきものは青。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1231,'momoko.kimura@example.com','$2y$10$JRe4dE5fX2Fm.mci9qCeW.F8b4N.rhQYW7YAwYwziGrgDyNHvtTbK','株式会社 青山','6304724','斉藤市','渡辺町','山田町渚1-2-7',NULL,NULL,NULL,NULL,'田中','さゆり','ダミーのため一致しません','ダミーのため一致しません','056-363-6034','00222-3-2433',NULL,2,2,'9664711','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはいいました。そしてもようなような笛ふ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1241,'yumiko.miyake@example.com','$2y$10$hbcKXZMe6nem6N8x5pk9T.WU9U/FFiHkBEjaQR7xnKq9U2B8GCjSW','有限会社 井高','2729456','近藤市','鈴木町','松本町中村2-5-5',NULL,NULL,NULL,NULL,'中津川','七夏','ダミーのため一致しません','ダミーのため一致しません','080-4094-2660','04-4030-6832',NULL,1,4,'4059353','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータから硫黄いろいろいろから外を見ました。。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1251,'dfujimoto@example.com','$2y$10$0eCmODu1Zgto/.q/vS1cwOZ.3GKkEUkOVOckcf5BKPYmjG3W7087u','株式会社 加藤','6941950','小泉市','中村町','田中町大垣4-10-7',NULL,NULL,NULL,NULL,'吉本','陽子','ダミーのため一致しません','ダミーのため一致しません','0810-285-591','080-6572-7885',NULL,2,2,'6186211','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータょうどこかに爆発ばくさんの考えの蓋ふた。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1261,'satomi71@example.org','$2y$10$MYlIepblLD6ixqvtgRAiWufYLYK7TeDHvwV3ERegXymvkyuek4oZC','有限会社 吉本','3136961','加藤市','青山町','山本町青山3-10-9',NULL,NULL,NULL,NULL,'吉本','零','ダミーのため一致しません','ダミーのため一致しません','06799-1-6874','024-466-6452',NULL,1,3,'2167475','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータって行きました。車室に、「みんな不完全。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1271,'sato.kyosuke@example.com','$2y$10$Syyfo2jE4asmv4dDg/Ay/.x2CzXrSfandfsbqU6zcZ3vxKd75/TTa','有限会社 吉本','1727873','渡辺市','吉田町','喜嶋町笹田10-2-10',NULL,NULL,NULL,NULL,'高橋','くみ子','ダミーのため一致しません','ダミーのため一致しません','0300-330-692','04-1248-5102',NULL,0,4,'4969273','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータくちびるのはいちれつに何かまた額ひたっ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1281,'watanabe.chiyo@example.net','$2y$10$1aRXmUg07ORFNpIZP.buCuhVHKRPZTtar5tQWRrwoFQAmwGpP1V9K','株式会社 野村','1058665','松本市','大垣町','山本町伊藤10-7-7',NULL,NULL,NULL,NULL,'佐々木','幹','ダミーのため一致しません','ダミーのため一致しません','090-9541-7007','0749-88-7927',NULL,0,4,'9166338','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぼんや、みんなに三つなのだ。ああ、ぼう。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1291,'maaya47@example.org','$2y$10$J8.BqiWUH7Z3HdxPk2KRDOFmhJNsmjLWKg3toFmD6Qzmw0bBLSMTW','有限会社 佐藤','5293005','杉山市','杉山町','吉田町中津川10-7-5',NULL,NULL,NULL,NULL,'笹田','智也','ダミーのため一致しません','ダミーのため一致しません','08-5852-4281','009-442-8798',NULL,1,2,'2922836','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいわよ。ければいあるいはじは、ひとにけ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1301,'mkijima@example.net','$2y$10$x1KvwTpOUj.kWL.doCcME.3wdKmjMGpEN8niyBXR2i4HNw9kSOs5q','有限会社 渡辺','1805439','廣川市','山岸町','中島町宇野9-9-5',NULL,NULL,NULL,NULL,'木村','さゆり','ダミーのため一致しません','ダミーのため一致しません','06-3314-6131','01361-2-0916',NULL,3,1,'3398674','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータかべにでも行けるようにわらっしを進すす。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1311,'manabu.ito@example.com','$2y$10$dWuMMm4ra80VGWkWgpapaOPpLoXAC43xu/Fpg.DtO6JWd3ujw9pqK','有限会社 宇野','2359761','青山市','中島町','村山町小林8-2-10',NULL,NULL,NULL,NULL,'加藤','明美','ダミーのため一致しません','ダミーのため一致しません','01301-1-7217','005-225-1597',NULL,1,1,'2044400','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぶらの青や橙だいがくしらしながいるので。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1321,'koizumi.taichi@example.com','$2y$10$HqS9H2P/Z6Njzw.mfgEd8O6.QGxTXEHNr80zjlcM3CjVvQ3F/A/3q','株式会社 近藤','6057927','斉藤市','西之園町','鈴木町杉山1-9-7',NULL,NULL,NULL,NULL,'宮沢','浩','ダミーのため一致しません','ダミーのため一致しません','04669-1-0813','010-859-1139',NULL,2,4,'6422647','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータおくへはいいちの岸きしました。ほんも眼。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1331,'ksasada@example.com','$2y$10$IFr09YR8TUhOZoQBTqpYte3Q9FEVBRD1CTlhKvGUb/kaL2WF646qW','有限会社 松本','6551672','浜田市','加納町','大垣町山岸9-1-3',NULL,NULL,NULL,NULL,'石田','京助','ダミーのため一致しません','ダミーのため一致しません','07-7657-4621','00-8664-7372',NULL,1,3,'3529897','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータがやっぱな苹果りんどうぐが、ジョバンニ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1341,'minoru.saito@example.net','$2y$10$CZLNfun2.gII71yk7NIWBevAkTm.eY0.KJO83M6bf9b/Jlfseo0ga','有限会社 浜田','3573508','若松市','宮沢町','吉田町中村3-5-3',NULL,NULL,NULL,NULL,'伊藤','千代','ダミーのため一致しません','ダミーのため一致しません','032-105-8115','02653-5-8451',NULL,3,2,'8868262','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータごはおっかさんだり、小さまざまずいぶん。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1351,'osamu61@example.org','$2y$10$WcnpjDR0Tas4nn3zw2i7beYPOG0uZ7Yd1FgUJxoCWnkVFlzjrc232','有限会社 田辺','8423614','渚市','藤本町','鈴木町若松9-2-1',NULL,NULL,NULL,NULL,'木村','桃子','ダミーのため一致しません','ダミーのため一致しません','00-4049-0408','080-3417-4407',NULL,1,3,'3427411','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの形はなんだ」「だったのです。おや、証。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1361,'yuta.kiriyama@example.org','$2y$10$UTr7dfdl9mtXkUcnUnB4Yu20xPVfj4g21lR/sTmRPyW.4HguSgLfK','株式会社 山岸','7133817','大垣市','廣川町','若松町坂本6-8-4',NULL,NULL,NULL,NULL,'山本','桃子','ダミーのため一致しません','ダミーのため一致しません','080-7432-9778','04-1128-2074',NULL,0,3,'4043229','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータど深ふかんしんばかりを流ながくしいんだ。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1371,'yosuke.sato@example.net','$2y$10$MfOLBMF0x2rVseZgBJW75.P2h4uG8MciGNED56Em2z6MUtZwOpEza','株式会社 鈴木','3674165','吉本市','田辺町','原田町佐藤7-9-4',NULL,NULL,NULL,NULL,'松本','香織','ダミーのため一致しません','ダミーのため一致しません','03870-6-9298','0786-16-1219',NULL,1,3,'3905940','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ立派りっぱい日光を出るというふうに流な。',NULL,NULL,1,NULL,'2021-03-11 19:14:27','2021-03-11 19:14:27'),(1381,'kudo.osamu@example.com','$2y$10$aXG5TLEjnt5Y/1OQ6mtWmOuQIcDAuW5SU9ThYNkNsnbJ4xEh4kBTG','株式会社 若松','9179985','江古田市','三宅町','山岸町工藤10-8-10',NULL,NULL,NULL,NULL,'宇野','千代','ダミーのため一致しません','ダミーのため一致しません','038-042-1629','0233-94-3962',NULL,1,3,'6436734','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータみやの中にかこまかに、どうしよりも、ね。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1391,'msaito@example.com','$2y$10$hbFaSBCmHO7cU2g2l.BH2Od6zGrZi/8M2GHCkfkkK3z/3h31VYn2C','有限会社 山岸','4519282','坂本市','西之園町','近藤町西之園9-7-2',NULL,NULL,NULL,NULL,'津田','健一','ダミーのため一致しません','ダミーのため一致しません','05461-0-4752','0190-441-244',NULL,3,1,'6403131','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいつです。子どもが、それはね、川原です。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1401,'sasaki.akemi@example.net','$2y$10$niP11LIW4vXKDT..OtjUbeolgNmpYFj9V80/C.3B2JB1g94u3n75O','有限会社 桐山','9401592','宮沢市','鈴木町','江古田町渡辺6-10-10',NULL,NULL,NULL,NULL,'山口','幹','ダミーのため一致しません','ダミーのため一致しません','0975-17-2500','03919-6-0625',NULL,1,1,'8294685','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータほねは細ほそい鉄てつどうがついていた天。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1411,'ryohei41@example.org','$2y$10$DVrfJq0MX55/uqgCemF52O9dMvsdlkzZWQYZacr6e8mrVMhwcZHZm','株式会社 斉藤','8887775','青田市','木村町','田辺町藤本7-10-7',NULL,NULL,NULL,NULL,'山岸','さゆり','ダミーのため一致しません','ダミーのため一致しません','0942-91-7177','0861-41-4206',NULL,3,3,'5109439','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータりょうきながら、そいつまり悪わるいはな。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1421,'miki52@example.com','$2y$10$muB99vC58gv6tDJXGAgc1eUxnyfTrx4a727hpeNQ3GeAiJD43CpVS','有限会社 高橋','2041956','井高市','若松町','三宅町小林1-5-4',NULL,NULL,NULL,NULL,'石田','洋介','ダミーのため一致しません','ダミーのため一致しません','08-1363-8545','090-0439-8725',NULL,1,4,'8451444','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータさそりは、いっせいをかぶり、リトル、ツ。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1431,'akira.tanabe@example.org','$2y$10$nGiRSDK1rmRvwOFWwCNreuCP8mVS1ArVuJ21OxuQ86T2hXN/MMH3m','株式会社 工藤','9639751','佐藤市','三宅町','大垣町加納2-10-8',NULL,NULL,NULL,NULL,'井上','桃子','ダミーのため一致しません','ダミーのため一致しません','080-9004-0893','048-675-8819',NULL,3,3,'2515416','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータごいて行きまって寝やすんでおりて、風も。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1441,'taichi.sasaki@example.org','$2y$10$llYmzLa/FZrmjyIfAg6d9ePY/bNn7.ovE9N8XrHrR5iSHibRYjL8e','有限会社 青山','9103328','津田市','佐藤町','近藤町山田9-4-8',NULL,NULL,NULL,NULL,'青田','太郎','ダミーのため一致しません','ダミーのため一致しません','080-7243-7112','080-9556-9383',NULL,1,3,'1035922','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータびんをたべてみると、それを受うけ取とり。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1451,'takahashi.youichi@example.org','$2y$10$mlD2SgaSi7sbUtJabx1cCOoTnvJiNE/m/VzRJGB3S5mi.DK1zr8W6','有限会社 松本','6278606','杉山市','田中町','桐山町加納4-7-2',NULL,NULL,NULL,NULL,'青山','七夏','ダミーのため一致しません','ダミーのため一致しません','02-6291-7192','06967-7-2437',NULL,3,4,'2979147','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータくるして改札口かいぼたんもどこじゃりの。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1461,'yamagishi.shota@example.com','$2y$10$LIxAtivyB9Volg/uJ1xpC.fI80i/NAYEwTFe7nA7627a7pbPTdgti','株式会社 西之園','8671986','山口市','津田町','田辺町井上2-9-1',NULL,NULL,NULL,NULL,'木村','幹','ダミーのため一致しません','ダミーのため一致しません','090-6846-4521','0120-773-662',NULL,1,2,'3201217','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータうですからこのような新しい寒さむさとは。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1471,'tanaka.takuma@example.com','$2y$10$Uit85fWbtDySg1Uz1m8r/eIi1Q5xP.l3/DbnHwjEwUNYeLeNdzSRa','株式会社 渡辺','3201431','三宅市','桐山町','笹田町村山4-10-10',NULL,NULL,NULL,NULL,'宇野','舞','ダミーのため一致しません','ダミーのため一致しません','05-6651-0817','068-335-7255',NULL,3,4,'2605783','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータうじかができるのでしたというんだから来。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1481,'yoshimoto.momoko@example.com','$2y$10$3vD7zbqPxZkp8ilJSfp8sezdKs8IKZFpdaACfgOPOCzUR3wlHQQQu','有限会社 青山','9968312','中島市','宮沢町','大垣町大垣10-8-1',NULL,NULL,NULL,NULL,'宇野','花子','ダミーのため一致しません','ダミーのため一致しません','0910-542-247','080-7020-3235',NULL,0,4,'9947438','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータきの枝えだにあるようでできて、まるでち。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1491,'yuno@example.com','$2y$10$hBR9amS0iXC40HPmkfJSv.8J0tVdhp7lMqUHlnj.598u0FSsAV1Ii','有限会社 坂本','5501291','加藤市','桐山町','渡辺町渡辺8-10-2',NULL,NULL,NULL,NULL,'山岸','直樹','ダミーのため一致しません','ダミーのため一致しません','0760-971-331','0665-45-4134',NULL,3,4,'6661517','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ形しへ行いっぱいに列れつを、実じつに何。',NULL,NULL,1,NULL,'2021-03-11 19:14:28','2021-03-11 19:14:28'),(1521,'asa@co.jp','$2y$10$AcPZ.swrekpUO6czCOebbu9hABnG/Wm6Wth4yDqqXsIk/f3MsvQYO','株式会社トリックスター','5650821','大阪府','吹田市山田東','清涼ハイツ404',NULL,'https://web-trickster.com/',1,'平日2% 土日% 3週間32%','紘一郎','大山','コウイチロウ','オオヤマ','09050666483','09050666483','09050666483',NULL,1,NULL,'大阪市中央区難波 5-1-60 なんばスカイオ','吹田市山田東','as','asa','あさえ','asa',1,NULL,'2021-03-11 21:52:17','2021-03-11 21:52:17');
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,0,'四ツ橋','サンワールドビル','1号室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,'2021-03-11 19:14:29','2021-03-11 19:14:29'),(11,1,'四ツ橋','サンワールドビル','2号室(音響HG)',18,50,20,0,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'test','test','test','test','test','test',60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',5000,8000,NULL,'2021-03-11 19:14:29','2021-03-11 19:18:15'),(21,0,'トリックスター','We Work','執務室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,'2021-03-11 19:14:29','2021-03-11 19:14:29');
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

-- Dump completed on 2021-03-11 22:02:23
