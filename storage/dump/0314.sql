-- MySQL dump 10.13  Distrib 5.5.62, for Linux (x86_64)
--
-- Host: localhost    Database: heroku_4bfb6785b61d3a4
-- ------------------------------------------------------
-- Server version	5.5.62-log

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
INSERT INTO `admins` VALUES (1,'admin','admin@example.com','$2y$10$6mrQyt6dzzhsIDxhR/36wOksEcLvSKsHm1w6vCpvoXTsaqI3bV1cC','ga21y8gksg',NULL,NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=502 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (11,'yasuhiro21','株式会社 山本','2323893','山田市','桐山町','杉山町笹田5-7-5','舞','井上','直人','廣川','0310-010-347','0974-55-1857','0145-10-3248','jtsuda@hotmail.co.jp',80,1,NULL,'特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-12 14:08:48'),(21,'rnomura','有限会社 近藤','8497899','田中市','中津川町','喜嶋町斉藤2-1-2','七夏','斉藤','晃','原田','03-6669-3003','090-7561-8374','090-8946-4745','tomoya.ogaki@kanou.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(31,'wyamaguchi','有限会社 坂本','6485445','鈴木市','津田町','山田町野村3-9-7','太一','杉山','春香','渡辺','02-7122-9046','0760-89-2307','090-0530-1732','yuki46@tsuda.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(41,'miyake.atsushi','株式会社 高橋','2353955','高橋市','中村町','田辺町鈴木5-1-10','英樹','大垣','陽子','吉本','0860-844-435','0480-774-309','031-878-6866','yosuke.yamagishi@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(51,'hirokawa.ryosuke','株式会社 山口','8849299','大垣市','宇野町','中島町田辺4-5-1','千代','山岸','舞','喜嶋','09533-6-0426','0837-28-0188','05209-9-3009','kenichi.sasaki@nomura.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(61,'manabu92','株式会社 井上','9932997','桐山市','喜嶋町','渡辺町村山6-6-4','桃子','三宅','美加子','中村','080-8835-1814','090-7436-7405','0117-22-2508','vaota@kiriyama.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(71,'fujimoto.kana','株式会社 木村','5688166','加納市','杉山町','田辺町田中8-10-1','さゆり','佐々木','あすか','青田','080-5979-9470','05706-9-9372','080-9552-7700','osamu32@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(81,'yumiko.nomura','株式会社 高橋','1691340','西之園市','高橋町','吉本町高橋9-10-2','裕太','若松','裕樹','宮沢','0160-188-875','0146-79-0719','0524-67-9613','nishinosono.naoko@yoshimoto.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(91,'fkiriyama','株式会社 井上','2403502','中村市','井高町','三宅町笹田8-8-4','洋介','若松','淳','佐藤','0291-43-0707','090-0538-9302','00525-7-2342','minoru.aota@kimura.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(101,'kaori.kiriyama','株式会社 木村','6442861','杉山市','小林町','青田町津田4-1-9','幹','加納','舞','杉山','080-6686-4703','080-2013-2505','080-2196-7080','yuki71@nakajima.jp',30,1,NULL,'特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-12 14:09:32'),(111,'wakamatsu.taro','株式会社 宇野','2514663','青田市','渚町','吉田町吉田6-10-9','健一','山田','春香','加納','07988-2-7258','0926-07-7820','04-8694-4592','murayama.yuta@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(121,'miki.saito','株式会社 山岸','9569205','山岸市','喜嶋町','小林町井上3-2-1','香織','中津川','裕樹','若松','09-2570-4651','0383-70-9140','09-2687-7141','akemi39@sugiyama.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(131,'nanami.nishinosono','株式会社 江古田','9378403','近藤市','桐山町','原田町大垣7-5-4','舞','加藤','幹','坂本','01361-7-1139','0860-047-181','090-6923-0009','uuno@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(141,'hanako.tanaka','株式会社 山田','6673429','工藤市','津田町','吉田町中津川5-9-3','舞','石田','知実','小林','0880-31-1187','04171-7-6124','080-0988-7190','mitsuru70@tsuda.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(151,'kiriyama.kazuya','有限会社 坂本','6491219','津田市','津田町','吉本町三宅8-6-2','治','坂本','太郎','廣川','079-342-1901','0650-450-710','090-9963-0213','mai.ogaki@uno.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(161,'koizumi.soutaro','有限会社 村山','6571687','加藤市','津田町','山本町喜嶋9-3-1','真綾','坂本','篤司','浜田','0210-78-1368','090-8306-5668','07-7986-2526','hanako65@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(171,'koizumi.kana','株式会社 小泉','6531613','近藤市','若松町','木村町坂本7-5-6','翼','田中','舞','石田','01798-9-8424','05-5513-6709','080-2364-7218','kondo.akemi@kondo.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(181,'nyoshimoto','株式会社 中津川','1645467','田中市','中島町','中村町中津川2-2-9','くみ子','山本','淳','中津川','096-598-5697','090-9259-6837','031-369-5127','saito.nanami@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(191,'wakamatsu.nanami','株式会社 加藤','7232454','山口市','加納町','若松町近藤5-5-4','充','宮沢','康弘','杉山','090-1203-7984','06448-6-1222','0563-77-7417','nomura.yosuke@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(201,'kyosuke.fujimoto','株式会社 村山','7943961','津田市','吉田町','松本町松本5-7-5','香織','若松','陽子','廣川','090-5386-8449','0690-141-203','090-4001-9118','chiyo.matsumoto@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(211,'dogaki','株式会社 原田','6055001','中島市','加納町','木村町笹田3-8-5','充','伊藤','知実','原田','04886-0-4831','090-6875-4968','0220-847-370','aota.taichi@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(221,'kanou.kyosuke','有限会社 山本','2935498','山田市','山田町','松本町若松8-9-6','真綾','佐々木','京助','村山','080-8975-9229','0390-364-384','06-2978-2227','tomoya.kimura@matsumoto.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(231,'yui38','有限会社 野村','9278013','加藤市','若松町','山口町加納7-3-7','舞','山田','翼','伊藤','0560-588-052','01129-0-3573','080-5695-5269','tomoya.sasada@nakatsugawa.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(241,'cyamada','有限会社 斉藤','6509568','廣川市','宮沢町','村山町山田5-7-9','花子','山口','花子','山本','090-0370-5454','09140-2-6436','0540-835-924','takuma42@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(251,'hamada.kaori','有限会社 佐藤','1791420','木村市','井上町','佐藤町青山6-8-5','英樹','渡辺','香織','近藤','096-464-6165','013-611-2379','080-4591-4269','asuka.yamaguchi@sasaki.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(261,'kudo.ryosuke','株式会社 津田','9258648','佐藤市','江古田町','青山町喜嶋7-7-5','智也','石田','くみ子','青山','02011-0-4414','09971-1-4996','010-650-6869','taichi.sasaki@nakatsugawa.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(271,'tanabe.taro','有限会社 斉藤','1443293','山本市','渡辺町','渚町田辺9-5-1','春香','杉山','学','井高','095-207-5461','090-7699-5135','080-0602-1833','nagisa.tsubasa@aota.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(281,'rei.kimura','株式会社 浜田','7781096','若松市','坂本町','田中町青山6-4-6','千代','青田','充','大垣','080-1758-1793','090-1690-2140','090-7795-8555','yui22@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(291,'cfujimoto','有限会社 浜田','9027600','小泉市','中島町','原田町井高9-4-6','舞','桐山','舞','小林','090-0970-7858','090-519-7947','0580-546-973','ryosuke72@nagisa.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(301,'bsuzuki','有限会社 吉田','5193703','松本市','佐藤町','宇野町山岸6-4-6','聡太郎','笹田','学','山口','00826-7-7012','080-9761-8622','080-1868-2005','hamada.momoko@sasaki.info',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(311,'yuta.idaka','有限会社 井上','9893386','喜嶋市','鈴木町','田中町吉田10-7-6','明美','田辺','結衣','村山','043-569-4524','090-3599-0706','0890-304-865','kato.yuki@kudo.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(321,'cwatanabe','有限会社 渡辺','4357639','伊藤市','田中町','笹田町佐々木2-8-8','加奈','井上','聡太郎','松本','090-9521-4402','090-2948-2681','025-201-4060','naoki01@aota.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(331,'sugiyama.ryosuke','有限会社 宇野','9734012','山田市','藤本町','佐々木町鈴木8-7-1','晃','井上','篤司','加納','02402-5-7291','05-3977-2013','080-7924-2400','wakamatsu.sayuri@yoshimoto.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(341,'kogaki','株式会社 井上','7115892','加納市','中津川町','佐藤町青田10-8-3','太一','藤本','治','西之園','018-090-0901','0372-56-6071','0539-03-5076','akira55@nishinosono.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(351,'okiriyama','有限会社 笹田','2291419','小林市','廣川町','廣川町渡辺10-2-7','充','西之園','さゆり','宮沢','0350-751-674','080-9076-1418','08-0715-2829','wuno@kondo.biz',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(361,'manabu22','株式会社 石田','2172619','山岸市','宇野町','佐々木町山田5-9-3','翔太','田辺','香織','石田','080-1069-8032','0958-75-3349','0840-024-363','zekoda@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(371,'kyosuke07','有限会社 青田','6189333','伊藤市','渡辺町','喜嶋町吉田5-10-9','康弘','石田','舞','大垣','0862-53-5444','0320-359-940','080-6308-0818','hideki12@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(381,'ltanaka','有限会社 田中','2203128','西之園市','小泉町','木村町青田4-1-2','春香','小泉','翔太','松本','080-0294-4817','0026-27-2630','05517-5-1901','asuka55@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(391,'kyosuke89','有限会社 江古田','9551473','野村市','渡辺町','斉藤町鈴木10-7-10','里佳','青田','花子','加藤','090-6534-7158','02-0439-4672','08-3690-9431','chiyo.kimura@gmail.com',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(401,'nakajima.hideki','株式会社 渚','5376629','渡辺市','浜田町','加納町工藤1-8-9','陽子','大垣','真綾','田中','0500-302-507','06753-2-3659','080-0831-1579','iaota@sasaki.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(411,'uyamagishi','有限会社 村山','9265875','佐藤市','廣川町','加藤町高橋10-2-5','学','吉本','翔太','中津川','005-293-0356','00-7559-1323','016-498-2620','bekoda@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(421,'naoko.fujimoto','株式会社 伊藤','4678312','吉田市','井上町','若松町喜嶋9-6-9','学','田中','花子','石田','080-2474-6413','0239-64-6641','037-956-0311','miki.sasada@tanabe.org',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(431,'nakatsugawa.ryosuke','株式会社 青田','3455131','笹田市','大垣町','山本町佐藤4-2-6','春香','笹田','学','浜田','0160-437-982','080-7904-3477','04-2839-4375','pkato@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(441,'quno','株式会社 渚','7851164','工藤市','大垣町','三宅町廣川10-8-6','翔太','近藤','香織','田辺','090-7043-0116','05731-6-3827','0960-073-285','muno@hotmail.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(451,'haruka13','有限会社 宮沢','6757061','渚市','近藤町','中津川町佐藤2-9-1','晃','野村','幹','工藤','09-0299-6828','02873-5-9570','0951-73-6108','tanabe.minoru@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(461,'miki92','有限会社 伊藤','2799363','村山市','若松町','山口町高橋6-5-9','結衣','中村','淳','吉本','090-4405-2531','090-9695-7802','0100-950-277','lsato@ogaki.net',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(471,'nomura.naoki','株式会社 田辺','5966311','杉山市','吉田町','喜嶋町石田9-6-4','あすか','三宅','加奈','中津川','0268-79-6255','0640-840-330','090-1857-2080','kaori.uno@yoshida.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(481,'koizumi.akira','株式会社 石田','5391828','伊藤市','木村町','小泉町井高1-3-6','和也','小泉','幹','青田','090-7473-7699','080-9895-2637','092-619-2941','shuhei.kiriyama@mail.goo.ne.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(491,'satomi.harada','株式会社 廣川','6116703','青田市','吉本町','西之園町石田4-1-8','晃','鈴木','真綾','大垣','038-740-7472','04-8612-7662','086-871-4994','manabu.miyazawa@yahoo.co.jp',80,1,'１０月２日','特になし',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(501,'アクセア',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,30,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2021-03-12 13:49:23','2021-03-12 13:49:23');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (1,1,32500,8200,0,0,40700,4070,44770,'2021-03-16','アムウェイ','大山紘一郎','2021-03-12',NULL,0,NULL,NULL,NULL,1,0,NULL,NULL,NULL,'1','1',NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08');
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakdowns`
--

DROP TABLE IF EXISTS `breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdowns`
--

LOCK TABLES `breakdowns` WRITE;
/*!40000 ALTER TABLE `breakdowns` DISABLE KEYS */;
INSERT INTO `breakdowns` VALUES (1,1,'会場料金',32500,'2.5',32500,1,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(11,1,'有線マイク',3000,'1',3000,2,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(21,1,'無線マイク',3000,'1',3000,2,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(31,1,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,'1',1000,2,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(41,1,'【追加】次亜塩素酸水専用・超音波加湿器',500,'1',500,2,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(51,1,'領収書発行',200,'1',200,3,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08'),(61,1,'鍵レンタル',500,'1',500,3,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08');
/*!40000 ALTER TABLE `breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxl_breakdowns`
--

DROP TABLE IF EXISTS `cxl_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dates`
--

LOCK TABLES `dates` WRITE;
/*!40000 ALTER TABLE `dates` DISABLE KEYS */;
INSERT INTO `dates` VALUES (1,1,1,'06:00:00','22:00:00','2021-03-11 22:29:08','2021-03-12 13:08:42'),(11,1,2,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(21,1,3,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-12 13:06:17'),(31,1,4,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(41,1,5,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(51,1,6,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(61,1,7,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(71,11,1,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(81,11,2,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(91,11,3,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(101,11,4,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(111,11,5,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(121,11,6,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(131,11,7,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(141,21,1,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(151,21,2,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(161,21,3,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(171,21,4,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(181,21,5,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(191,21,6,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(201,21,7,'08:00:00','23:00:00','2021-03-11 22:29:08','2021-03-11 22:29:08'),(211,31,1,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(221,31,2,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(231,31,3,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(241,31,4,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(251,31,5,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(261,31,6,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(271,31,7,'08:00:00','23:00:00','2021-03-12 13:46:11','2021-03-12 13:46:11'),(281,41,1,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(291,41,2,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(301,41,3,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(311,41,4,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(321,41,5,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(331,41,6,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56'),(341,41,7,'08:00:00','23:00:00','2021-03-12 14:20:56','2021-03-12 14:20:56');
/*!40000 ALTER TABLE `dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endusers`
--

DROP TABLE IF EXISTS `endusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_venue`
--

LOCK TABLES `equipment_venue` WRITE;
/*!40000 ALTER TABLE `equipment_venue` DISABLE KEYS */;
INSERT INTO `equipment_venue` VALUES (1,11,1,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(11,11,11,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(21,11,21,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(31,11,31,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(41,11,41,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(51,11,51,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(61,11,61,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(71,11,71,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(81,1,1,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(91,1,11,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(101,1,21,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(111,1,31,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(121,1,41,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(151,1,71,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(161,1,81,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(171,1,121,'2021-03-12 11:43:19','2021-03-12 11:43:19'),(181,31,21,'2021-03-12 13:46:11','2021-03-12 13:46:11'),(191,31,31,'2021-03-12 13:46:11','2021-03-12 13:46:11'),(201,41,121,'2021-03-12 14:20:55','2021-03-12 14:20:55'),(211,41,131,'2021-03-12 14:20:55','2021-03-12 14:20:55');
/*!40000 ALTER TABLE `equipment_venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipments`
--

DROP TABLE IF EXISTS `equipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(191) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
INSERT INTO `equipments` VALUES (1,'有線マイク',3000,10,NULL,'2021-03-11 22:29:07',NULL),(11,'無線マイク',3000,10,NULL,'2021-03-11 22:29:07',NULL),(21,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,10,NULL,'2021-03-11 22:29:07',NULL),(31,'【追加】次亜塩素酸水専用・超音波加湿器',500,10,NULL,'2021-03-11 22:29:07',NULL),(41,'赤外線温度計（非接触型体温計）＋スプレーボトル',1000,10,NULL,'2021-03-11 22:29:07',NULL),(51,'ホワイトボード（幅120㎝）',2500,10,NULL,'2021-03-11 22:29:07',NULL),(61,'プロジェクター',3000,10,NULL,'2021-03-11 22:29:07',NULL),(71,'既存パーテーションの移動',2000,10,NULL,'2021-03-11 22:29:07',NULL),(81,'レーザーポインター',1000,10,NULL,'2021-03-11 22:29:07',NULL),(91,'iphone(Lightning)⇔VGA変換ケーブル',1000,10,NULL,'2021-03-11 22:29:07',NULL),(101,'iphone(Lightning)DVDプレイヤー',2000,10,NULL,'2021-03-11 22:29:07',NULL),(111,'CDプレイヤー',1000,10,NULL,'2021-03-11 22:29:07',NULL),(121,'持ち運びパーテーション',1000,10,NULL,'2021-03-11 22:29:07',NULL),(131,'卓球台セット',1000,10,NULL,'2021-03-11 22:29:07',NULL),(151,'**',-10,-9,'テスト','2021-03-12 10:08:42','2021-03-12 10:08:42');
/*!40000 ALTER TABLE `equipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_prices`
--

LOCK TABLES `frame_prices` WRITE;
/*!40000 ALTER TABLE `frame_prices` DISABLE KEYS */;
INSERT INTO `frame_prices` VALUES (121,21,'午前','10:00:00','12:00:00',17000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(131,21,'午後','13:00:00','17:00:00',36000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(141,21,'夜間','18:00:00','23:00:00',17000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(151,21,'午前＆午後','10:00:00','17:00:00',42000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(161,21,'午後＆夜間','13:00:00','21:00:00',42000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(171,21,'終日','10:00:00','21:00:00',50000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(271,11,'午前','10:00:00','12:00:00',17000,6000,'2021-03-12 13:41:36','2021-03-12 13:41:36');
/*!40000 ALTER TABLE `frame_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2702 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (2281,'2014_10_12_000000_create_users_table',1),(2291,'2014_10_12_100000_create_password_resets_table',1),(2301,'2019_08_19_000000_create_failed_jobs_table',1),(2311,'2020_02_01_090636_create_admins_table',1),(2321,'2020_09_18_090242_create_venues_table',1),(2331,'2020_09_20_044412_create_equipments_table',1),(2341,'2020_09_20_065837_create_venue_equipment_table',1),(2351,'2020_09_22_094627_create_services_table',1),(2361,'2020_09_24_064549_create_dates_table',1),(2371,'2020_09_24_072535_create_service_venue_table',1),(2381,'2020_09_24_100404_create_date_venue_table',1),(2391,'2020_09_29_055630_create_frame_prices_table',1),(2401,'2020_10_01_062150_create_time_prices_table',1),(2411,'2020_10_07_145320_create_email_verification_table',1),(2421,'2020_10_08_104339_create_agents_table',1),(2571,'2020_10_12_132928_create_preusers_table',2),(2581,'2020_10_19_163736_create_reservations_table',2),(2591,'2020_12_23_174247_create_bills_table',2),(2601,'2020_12_23_182424_create_breakdowns_table',2),(2611,'2021_02_08_153525_create_endusers_table',2),(2621,'2021_02_15_134342_create_pre_reservations_table',2),(2631,'2021_02_15_134831_create_pre_bills_table',2),(2641,'2021_02_15_135246_create_pre_breakdowns_table',2),(2651,'2021_02_15_140439_create_unknown_users_table',2),(2661,'2021_02_17_163902_create_multiple_reserves_table',2),(2671,'2021_02_23_122139_create_pre_endusers_table',2),(2681,'2021_03_07_164513_create_cxls_table',2),(2691,'2021_03_07_164951_create_cxl_breakdowns_table',2),(2701,'2021_03_11_170012_add_charge_to_pre_endusers_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiple_reserves`
--

DROP TABLE IF EXISTS `multiple_reserves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multiple_reserves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_reserves`
--

LOCK TABLES `multiple_reserves` WRITE;
/*!40000 ALTER TABLE `multiple_reserves` DISABLE KEYS */;
INSERT INTO `multiple_reserves` VALUES (1,'2021-03-12 18:49:22','2021-03-12 18:49:22'),(11,'2021-03-12 18:49:39','2021-03-12 18:49:39'),(21,'2021-03-12 18:51:31','2021-03-12 18:51:31'),(31,'2021-03-12 18:56:05','2021-03-12 18:56:05'),(41,'2021-03-12 19:23:29','2021-03-12 19:23:29'),(51,'2021-03-12 19:44:31','2021-03-12 19:44:31'),(61,'2021-03-14 09:00:11','2021-03-14 09:00:11'),(71,'2021-03-14 09:20:29','2021-03-14 09:20:29');
/*!40000 ALTER TABLE `multiple_reserves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_bills`
--

LOCK TABLES `pre_bills` WRITE;
/*!40000 ALTER TABLE `pre_bills` DISABLE KEYS */;
INSERT INTO `pre_bills` VALUES (31,41,0,0,0,0,2000,200,2200,0,NULL,1,'2021-03-12 18:51:12','2021-03-12 18:51:12'),(51,61,0,0,5000,0,5200,520,5720,0,NULL,1,'2021-03-12 18:51:53','2021-03-12 18:51:53'),(61,51,0,0,5000,0,5200,520,5720,0,NULL,1,'2021-03-12 18:52:04','2021-03-12 18:52:04'),(91,71,0,12500,0,0,12500,1250,13750,0,NULL,1,'2021-03-12 18:57:02','2021-03-12 18:57:02'),(101,81,0,2500,0,0,2500,250,2750,0,NULL,1,'2021-03-12 18:58:30','2021-03-12 18:58:30'),(111,91,32500,33000,0,0,65500,6550,72050,0,NULL,1,'2021-03-12 19:10:18','2021-03-12 19:10:18'),(121,101,200000,6700,5000,0,211700,21170,232870,0,NULL,1,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(131,111,46000,10000,0,0,56000,5600,61600,0,NULL,1,'2021-03-12 19:25:43','2021-03-12 19:25:43'),(141,131,0,0,13000,0,23000,2300,25300,0,NULL,1,'2021-03-12 19:42:00','2021-03-12 19:42:00'),(161,181,52400,7500,0,0,59900,5990,65890,0,NULL,1,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(181,191,52400,7000,13000,0,72400,7240,79640,0,NULL,1,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(221,211,0,0,0,0,3000,300,3300,0,NULL,1,'2021-03-14 08:52:03','2021-03-14 08:52:03'),(231,221,0,0,0,0,4000,400,4400,0,NULL,1,'2021-03-14 08:54:26','2021-03-14 08:54:26'),(241,231,0,0,0,0,12000,1200,13200,0,NULL,1,'2021-03-14 09:01:13','2021-03-14 09:01:13'),(261,241,0,0,0,0,10000,1000,11000,0,NULL,1,'2021-03-14 09:03:35','2021-03-14 09:03:35'),(271,251,0,0,5000,0,11000,1100,12100,0,NULL,1,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(281,141,0,0,0,0,10000,1000,11000,0,NULL,1,'2021-03-14 09:30:38','2021-03-14 09:30:38'),(291,281,0,0,0,0,10000,1000,11000,0,NULL,1,'2021-03-14 09:30:38','2021-03-14 09:30:38'),(321,1,0,6200,0,0,6200,620,6820,0,NULL,1,'2021-03-14 09:33:19','2021-03-14 09:33:19'),(331,11,0,6200,0,0,6200,620,6820,0,NULL,1,'2021-03-14 09:33:19','2021-03-14 09:33:19');
/*!40000 ALTER TABLE `pre_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_breakdowns`
--

DROP TABLE IF EXISTS `pre_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=1152 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_breakdowns`
--

LOCK TABLES `pre_breakdowns` WRITE;
/*!40000 ALTER TABLE `pre_breakdowns` DISABLE KEYS */;
INSERT INTO `pre_breakdowns` VALUES (41,31,'会場料金',0,'3h',0,1,'2021-03-12 18:51:12','2021-03-12 18:51:12'),(51,31,'有線マイク',0,'1',0,2,'2021-03-12 18:51:12','2021-03-12 18:51:12'),(91,51,'会場料金',0,'4',0,1,'2021-03-12 18:51:53','2021-03-12 18:51:53'),(101,51,'有線マイク',0,'1',0,2,'2021-03-12 18:51:53','2021-03-12 18:51:53'),(111,51,'レイアウト準備料金',5000,'1',5000,4,'2021-03-12 18:51:53','2021-03-12 18:51:53'),(121,61,'会場料金',0,'7.5',0,1,'2021-03-12 18:52:04','2021-03-12 18:52:04'),(131,61,'有線マイク',0,'9',0,2,'2021-03-12 18:52:04','2021-03-12 18:52:04'),(141,61,'レイアウト準備料金',5000,'1',5000,4,'2021-03-12 18:52:04','2021-03-12 18:52:04'),(251,91,'有線マイク',3000,'3',9000,2,'2021-03-12 18:57:02','2021-03-12 18:57:02'),(261,91,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,'3',3000,2,'2021-03-12 18:57:02','2021-03-12 18:57:02'),(271,91,'鍵レンタル',500,'1',500,3,'2021-03-12 18:57:02','2021-03-12 18:57:02'),(281,101,'鍵レンタル',500,'1',500,3,'2021-03-12 18:58:30','2021-03-12 18:58:30'),(291,101,'プロジェクター設置',2000,'1',2000,3,'2021-03-12 18:58:30','2021-03-12 18:58:30'),(301,111,'会場料金',29550,'3',29550,1,'2021-03-12 19:10:18','2021-03-12 19:10:18'),(311,111,'延長料金',2950,'0.5',2950,1,'2021-03-12 19:10:18','2021-03-12 19:10:18'),(321,111,'有線マイク',3000,'11',33000,2,'2021-03-12 19:10:18','2021-03-12 19:10:18'),(331,121,'深夜使用',200000,'1',200000,1,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(341,121,'無線マイク',3000,'2',6000,2,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(351,121,'領収書発行',200,'1',200,3,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(361,121,'鍵レンタル',500,'1',500,3,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(371,121,'レイアウト準備料金',5000,'1',5000,4,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(381,131,'会場料金',46000,'6',46000,1,'2021-03-12 19:25:43','2021-03-12 19:25:43'),(391,131,'有線マイク',3000,'2',6000,2,'2021-03-12 19:25:43','2021-03-12 19:25:43'),(401,131,'既存パーテーションの移動',2000,'1',2000,2,'2021-03-12 19:25:43','2021-03-12 19:25:43'),(411,131,'プロジェクター設置',2000,'1',2000,3,'2021-03-12 19:25:43','2021-03-12 19:25:43'),(421,141,'会場料金',0,'5h',0,1,'2021-03-12 19:42:00','2021-03-12 19:42:00'),(431,141,'レイアウト準備料金',5000,'1',5000,4,'2021-03-12 19:42:00','2021-03-12 19:42:00'),(441,141,'レイアウト準備料金',8000,'1',8000,4,'2021-03-12 19:42:00','2021-03-12 19:42:00'),(501,161,'会場料金',44450,'8',44450,1,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(511,161,'延長料金',7950,'1.5',7950,1,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(521,161,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',1000,'1',1000,2,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(531,161,'既存パーテーションの移動',2000,'2',4000,2,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(541,161,'鍵レンタル',500,'1',500,3,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(551,161,'プロジェクター設置',2000,'1',2000,3,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(621,181,'会場料金',47100,'8',47100,1,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(631,181,'延長料金',5300,'1',5300,1,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(641,181,'有線マイク',3000,'1',3000,2,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(651,181,'無線マイク',3000,'1',3000,2,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(661,181,'【追加】次亜塩素酸水専用・超音波加湿器',500,'1',500,2,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(671,181,'鍵レンタル',500,'1',500,3,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(681,181,'レイアウト準備料金',5000,'1',5000,4,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(691,181,'レイアウト片付料金',8000,'1',8000,4,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(911,221,'会場料金',0,'5.5h',0,1,'2021-03-14 08:52:03','2021-03-14 08:52:03'),(921,221,'次亜塩素酸水専用・超音波加湿器＋スプレーボトル',0,'3',0,2,'2021-03-14 08:52:03','2021-03-14 08:52:03'),(931,231,'会場料金',0,'4h',0,1,'2021-03-14 08:54:26','2021-03-14 08:54:26'),(941,231,'無線マイク',0,'5',0,2,'2021-03-14 08:54:26','2021-03-14 08:54:26'),(951,241,'会場料金',0,'5',0,1,'2021-03-14 09:01:13','2021-03-14 09:01:13'),(961,241,'領収書発行',0,'1',0,3,'2021-03-14 09:01:13','2021-03-14 09:01:13'),(991,261,'会場料金',0,'5',0,1,'2021-03-14 09:03:35','2021-03-14 09:03:35'),(1001,261,'有線マイク',0,'6',0,2,'2021-03-14 09:03:35','2021-03-14 09:03:35'),(1011,261,'領収書発行',0,'1',0,3,'2021-03-14 09:03:35','2021-03-14 09:03:35'),(1021,271,'会場料金',0,'6h',0,1,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(1031,271,'有線マイク',0,'3',0,2,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(1041,271,'プロジェクター設置',0,'1',0,3,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(1051,271,'レイアウト準備料金',5000,'1',5000,4,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(1061,281,'会場料金',0,'7',0,1,'2021-03-14 09:30:38','2021-03-14 09:30:38'),(1071,291,'会場料金',0,'9',0,1,'2021-03-14 09:30:38','2021-03-14 09:30:38'),(1121,321,'無線マイク',3000,'2',6000,2,'2021-03-14 09:33:19','2021-03-14 09:33:19'),(1131,321,'領収書発行',200,'1',200,3,'2021-03-14 09:33:19','2021-03-14 09:33:19'),(1141,331,'無線マイク',3000,'2',6000,2,'2021-03-14 09:33:19','2021-03-14 09:33:19'),(1151,331,'領収書発行',200,'1',200,3,'2021-03-14 09:33:19','2021-03-14 09:33:19');
/*!40000 ALTER TABLE `pre_breakdowns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_endusers`
--

DROP TABLE IF EXISTS `pre_endusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_endusers`
--

LOCK TABLES `pre_endusers` WRITE;
/*!40000 ALTER TABLE `pre_endusers` DISABLE KEYS */;
INSERT INTO `pre_endusers` VALUES (1,41,NULL,NULL,NULL,NULL,NULL,NULL,0,'2021-03-12 18:51:12','2021-03-12 18:51:12',10000),(11,51,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-12 18:51:52','2021-03-12 18:52:04',1000),(21,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-12 18:51:53','2021-03-12 18:51:53',1000),(31,131,'アイウエオ','さささ',NULL,NULL,NULL,NULL,0,'2021-03-12 19:42:00','2021-03-12 19:42:00',50000),(41,141,'ユニクロ','柳生',NULL,NULL,NULL,NULL,0,'2021-03-12 19:44:31','2021-03-14 09:30:38',50000),(51,151,'ユニクロ','柳生',NULL,NULL,NULL,NULL,0,'2021-03-12 19:44:31','2021-03-12 19:44:31',0),(61,161,'ユニクロ','柳生',NULL,NULL,NULL,NULL,0,'2021-03-12 19:44:31','2021-03-12 19:44:31',0),(71,171,'ユニクロ','柳生',NULL,NULL,NULL,NULL,0,'2021-03-12 19:44:31','2021-03-12 19:44:31',0),(81,211,NULL,NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 08:52:03','2021-03-14 08:52:03',15000),(91,221,'ando',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 08:54:26','2021-03-14 08:54:26',20000),(101,231,'fff',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 09:00:11','2021-03-14 09:01:13',60000),(111,241,'fff',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 09:00:11','2021-03-14 09:03:35',50000),(121,251,'アイウエオ',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 09:12:26','2021-03-14 09:12:26',30000),(131,261,'００９',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 09:20:29','2021-03-14 09:20:29',0),(141,271,'００９',NULL,NULL,NULL,NULL,NULL,0,'2021-03-14 09:20:29','2021-03-14 09:20:29',0),(151,281,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-14 09:30:38','2021-03-14 09:30:38',50000);
/*!40000 ALTER TABLE `pre_endusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_reservations`
--

DROP TABLE IF EXISTS `pre_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_reservations`
--

LOCK TABLES `pre_reservations` WRITE;
/*!40000 ALTER TABLE `pre_reservations` DISABLE KEYS */;
INSERT INTO `pre_reservations` VALUES (1,1,1,11,0,'2021-03-03',1,'00:30:00','04:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 18:49:22','2021-03-14 09:32:25'),(11,1,1,11,0,'2021-03-24',1,'01:00:00','10:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 18:49:22','2021-03-14 09:32:25'),(21,11,1,0,31,'2021-03-04',NULL,'00:30:00','05:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 18:49:39','2021-03-12 18:49:39'),(31,11,1,0,31,'2021-03-23',NULL,'01:30:00','06:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 18:49:39','2021-03-12 18:49:39'),(41,0,1,0,21,'2021-03-03',1,'01:30:00','04:30:00',0,'01:30:00','01:30:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'','','',NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 18:51:12','2021-03-12 18:51:12'),(51,21,1,0,31,'2021-03-04',1,'00:00:00','07:30:00',0,'00:00:00','07:30:00',NULL,NULL,NULL,NULL,'1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 18:51:31','2021-03-12 18:52:03'),(61,21,1,0,31,'2021-03-15',1,'01:00:00','05:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 18:51:31','2021-03-12 18:51:53'),(71,31,1,11,0,'2021-03-17',NULL,'08:30:00','14:00:00',0,'08:30:00','14:00:00',NULL,NULL,NULL,NULL,'1970-01-01 00:00:00',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 18:56:05','2021-03-12 18:57:02'),(81,31,1,11,0,'2021-03-24',NULL,'08:30:00','14:00:00',0,'08:30:00','14:00:00',NULL,NULL,NULL,NULL,'1970-01-01 00:00:00',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 18:56:05','2021-03-12 18:58:30'),(91,0,1,1511,0,'2021-03-19',2,'08:30:00','12:00:00',0,'08:30:00','08:30:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'瀬戸','09010001111',NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 19:10:18','2021-03-12 19:10:18'),(101,0,1,1111,0,'2021-03-18',1,'05:00:00','14:00:00',1,'08:30:00','11:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'近藤','09011223344',NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 19:22:36','2021-03-12 19:22:36'),(111,41,1,1091,0,'2021-03-22',2,'11:00:00','17:00:00',0,'07:30:00','11:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,'2021-03-12 19:23:29','2021-03-12 19:25:43'),(121,41,11,1091,0,'2021-03-22',NULL,'11:00:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 19:23:29','2021-03-12 19:23:29'),(131,0,21,0,241,'2021-03-25',1,'13:00:00','18:00:00',1,'14:00:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'','','',NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 19:42:00','2021-03-12 19:42:00'),(141,51,1,0,41,'2021-03-16',1,'10:00:00','17:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-12 19:44:31','2021-03-14 09:30:38'),(151,51,11,0,41,'2021-03-16',NULL,'10:00:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 19:44:31','2021-03-12 19:44:31'),(161,51,21,0,41,'2021-03-16',NULL,'10:00:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 19:44:31','2021-03-12 19:44:31'),(171,51,31,0,41,'2021-03-16',NULL,'10:00:00','17:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-12 19:44:31','2021-03-12 19:44:31'),(181,0,1,1,0,'2021-04-17',2,'09:00:00','18:30:00',0,'09:00:00','12:00:00',NULL,NULL,NULL,NULL,'2021-03-27 00:00:00','1',0,'大山紘一郎','08012345678',NULL,NULL,NULL,NULL,0,1,NULL,NULL,'2021-03-12 20:46:01','2021-03-12 20:46:01'),(191,0,1,1,0,'2021-04-08',2,'08:30:00','17:30:00',0,'08:30:00','08:30:00',NULL,NULL,NULL,NULL,NULL,NULL,1,'大山紘一郎','08012345678',NULL,NULL,NULL,NULL,0,1,NULL,NULL,'2021-03-13 19:11:28','2021-03-13 19:11:28'),(201,1,21,11,0,'2021-04-10',NULL,'09:00:00','19:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-13 19:31:03','2021-03-13 19:31:03'),(211,0,1,0,51,'2021-03-31',1,'09:00:00','14:30:00',0,'09:00:00','09:00:00',NULL,NULL,NULL,'3','2021-03-30 00:00:00',NULL,0,'','','','test',NULL,NULL,0,0,NULL,NULL,'2021-03-14 08:52:03','2021-03-14 08:52:03'),(221,0,1,0,51,'2021-03-25',1,'09:00:00','13:00:00',0,'09:00:00','09:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'','','','test',NULL,NULL,0,0,NULL,NULL,'2021-03-14 08:54:26','2021-03-14 08:54:26'),(231,61,1,0,41,'2021-03-23',2,'09:00:00','14:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-14 09:00:11','2021-03-14 09:01:13'),(241,61,11,0,41,'2021-03-23',NULL,'09:00:00','14:00:00',0,'09:00:00','14:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-14 09:00:11','2021-03-14 09:03:13'),(251,0,1,0,51,'2021-03-17',1,'09:00:00','15:00:00',0,'09:00:00','09:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'','','','テスト',NULL,NULL,0,0,NULL,NULL,'2021-03-14 09:12:26','2021-03-14 09:12:26'),(261,71,1,0,121,'2021-03-24',NULL,'10:00:00','14:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 09:20:29','2021-03-14 09:20:29'),(271,71,1,0,121,'2021-03-25',NULL,'10:00:00','14:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,'2021-03-14 09:20:29','2021-03-14 09:20:29'),(281,51,1,0,41,'2021-03-15',1,'09:00:00','18:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,'2021-03-14 09:29:47','2021-03-14 09:30:38');
/*!40000 ALTER TABLE `pre_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preusers`
--

DROP TABLE IF EXISTS `preusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,1,0,'2021-03-19',2,'16:30:00','19:00:00',0,'00:00:00','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,0,'山田太郎','09044906001',0,NULL,NULL,NULL,NULL,NULL,'2021-03-12 19:23:08','2021-03-12 19:23:08');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_venue`
--

DROP TABLE IF EXISTS `service_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_venue`
--

LOCK TABLES `service_venue` WRITE;
/*!40000 ALTER TABLE `service_venue` DISABLE KEYS */;
INSERT INTO `service_venue` VALUES (1,11,1,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(11,11,11,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(21,11,21,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(31,11,31,'2021-03-11 22:37:18','2021-03-11 22:37:18'),(41,1,1,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(51,1,11,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(61,1,21,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(71,1,31,'2021-03-11 22:37:28','2021-03-11 22:37:28'),(81,31,11,'2021-03-12 13:46:11','2021-03-12 13:46:11'),(91,31,21,'2021-03-12 13:46:11','2021-03-12 13:46:11'),(101,41,11,'2021-03-12 14:20:55','2021-03-12 14:20:55');
/*!40000 ALTER TABLE `service_venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(191) NOT NULL,
  `price` int(11) NOT NULL,
  `remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_item_unique` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'領収書発行',200,NULL,'2021-03-11 22:29:07',NULL),(11,'鍵レンタル',500,NULL,'2021-03-11 22:29:07',NULL),(21,'プロジェクター設置',2000,NULL,'2021-03-11 22:29:07',NULL),(31,'DVDプレイヤー設置',2000,NULL,'2021-03-11 22:29:07',NULL);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_prices`
--

DROP TABLE IF EXISTS `time_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_prices`
--

LOCK TABLES `time_prices` WRITE;
/*!40000 ALTER TABLE `time_prices` DISABLE KEYS */;
INSERT INTO `time_prices` VALUES (1,1,3,32500,5900,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(11,1,4,38400,7100,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(21,1,6,46000,6000,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(31,1,8,52400,5300,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(41,1,12,64000,4500,'2021-03-11 22:29:09','2021-03-11 22:29:09');
/*!40000 ALTER TABLE `time_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unknown_users`
--

DROP TABLE IF EXISTS `unknown_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=1562 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (11,'kudou@web-trickster.com','$2y$10$No03Gts5Sbarv.iGXiGdmusw8Nco6OPXpKZuF6e5kWKuT/zuq1uqK','トリックスター','test','test','test','test',NULL,NULL,NULL,NULL,'工藤','大揮','クドウ','ダイキ','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'zpxr24NmeS',NULL,NULL),(999,'sample@sample.com','$2y$10$8uNu5KDq.KATLBNGYceMzuu0FDSAPM0VWLGLElc26WiWKfOdD5ddG','（未登録ユーザー）','（未設定）','（未設定）','（未設定）','（未設定）',NULL,NULL,NULL,NULL,'（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','（未登録ユーザー）','122345678',NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'fCj2UkYWqP',NULL,NULL),(1001,'yasuhiro97@example.org','$2y$10$/JR0o1PykDWx12mTbbpcHeKlUSKx36o54YjPfVBTeKm7ktWR4YUJq','有限会社 渚','3792454','西之園市','浜田町','山本町井上2-1-6',NULL,NULL,NULL,NULL,'斉藤','英樹','ダミーのため一致しません','ダミーのため一致しません','080-9668-5391','0597-34-3472',NULL,1,3,'5466005','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータらの野原にただきに、もうだいかんしゅが。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1011,'momoko.hirokawa@example.org','$2y$10$TfUFEvM3SrSR2985onDcrOORg5Jhc4Ov7BSWUxvkx2.mVrfl6uXau','株式会社 加藤','4177979','原田市','田中町','佐々木町青田8-9-4',NULL,NULL,NULL,NULL,'石田','治','ダミーのため一致しません','ダミーのため一致しません','00613-5-8446','0439-69-9787',NULL,3,1,'3223490','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータともはっきらきました。たいの高原で待ま。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1021,'yamagishi.momoko@example.com','$2y$10$.2E5.JZVwRjW/L14.dlC/uTHxMEL0fmPSPMwwtYhD7fneA8J0vo.O','株式会社 山本','2528719','桐山市','小林町','藤本町村山4-7-5',NULL,NULL,NULL,NULL,'三宅','智也','ダミーのため一致しません','ダミーのため一致しません','02-6584-2445','090-7166-4400',NULL,2,1,'5307396','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ二尺も孔あなたたたんで来ました。そして。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1031,'ysato@example.net','$2y$10$6CqrDezkPKLrxN18QIj3surOPlWRpxbmy2xz9OrW2Yij.GHRsFZBK','有限会社 木村','7862369','坂本市','鈴木町','江古田町渡辺3-7-7',NULL,NULL,NULL,NULL,'笹田','陽一','ダミーのため一致しません','ダミーのため一致しません','090-303-6112','073-478-5962',NULL,2,1,'8757392','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータひじょうはみんなにがら、いつかカムパネ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1041,'momoko.uno@example.net','$2y$10$KO0hBp7SiseP0eutzXNK0uRtSk5giJHqbWvTjOtCfaR9Be8j/uk9W','有限会社 吉田','4049991','山田市','高橋町','喜嶋町坂本3-3-9',NULL,NULL,NULL,NULL,'村山','翼','ダミーのため一致しません','ダミーのため一致しません','0182-65-9027','080-4240-8997',NULL,3,3,'2285233','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータどに開いて向むけてあるい実みを、実じつ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1051,'ryohei57@example.org','$2y$10$2uA3Hy4/b6v/bc8cTIV0/OeFFNP8sUAJl0t5KnG0gYcAUBtCmQH2a','株式会社 中村','5643064','村山市','三宅町','中津川町三宅8-4-10',NULL,NULL,NULL,NULL,'若松','稔','ダミーのため一致しません','ダミーのため一致しません','00-2245-0163','090-3023-6564',NULL,0,4,'5156642','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータョバンニも全まったり、三十疋ぴきばかり。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1061,'ryohei03@example.com','$2y$10$xTJB.hkA1O.wSKkbSXtKN.I2vsbUiyjjrWddopZJrNuo4TJk1Hgwm','株式会社 野村','3397003','宮沢市','加藤町','伊藤町青山3-4-10',NULL,NULL,NULL,NULL,'西之園','太一','ダミーのため一致しません','ダミーのため一致しません','05005-0-6008','080-8196-6077',NULL,3,2,'8985931','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータから、大人おとなりました。それをよって。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1071,'akira43@example.org','$2y$10$EcgiwKKl1.vU/VIa91PAw.RBCwbqCOJr0oIoBOjHMWBkCcvw8i3TS','有限会社 宮沢','6582572','高橋市','江古田町','田中町佐藤5-6-10',NULL,NULL,NULL,NULL,'原田','康弘','ダミーのため一致しません','ダミーのため一致しません','090-8478-4171','03-6745-0261',NULL,1,2,'9824038','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータゅうになって行きます。カムパネルラはも。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1081,'hanako.nagisa@example.org','$2y$10$VbzT4AMtQJkIEAEDYdTSee.ZskLjz5Ffxo0gZmgxOc3YYXrbk4hEi','株式会社 中島','2425168','三宅市','大垣町','中村町宇野7-6-5',NULL,NULL,NULL,NULL,'江古田','翼','ダミーのため一致しません','ダミーのため一致しません','080-9568-9781','080-1458-8385',NULL,2,3,'6557031','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ「ジョバンニとすきがなおりて遊あそうで。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1091,'rika76@example.net','$2y$10$yI6V6cY/O6DS2CkUDQccG.8JzYfzFMq7oDQeYoiMKxvbTQ04wGOdu','株式会社 津田','1099525','斉藤市','野村町','宮沢町吉本4-7-6',NULL,NULL,NULL,NULL,'近藤','聡太郎','ダミーのため一致しません','ダミーのため一致しません','080-3403-9177','0044-07-5546',NULL,1,1,'7655754','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータまって、みんなに永久えいきででも燃もえ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1101,'tsubasa61@example.com','$2y$10$4tXKn.s7RvhJ82mhXm8t3ewqmy40PYWFbpaZbSTPoFjAkxCORuXOy','株式会社 加納','8183734','西之園市','山本町','中津川町津田6-4-3',NULL,NULL,NULL,NULL,'三宅','翼','ダミーのため一致しません','ダミーのため一致しません','09-7083-8983','090-0930-5766',NULL,3,4,'3549400','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータはしばらく、もう半分はんをした。八鳥を。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1111,'wakamatsu.manabu@example.net','$2y$10$gRMZVM7T2B2BhTt/JubX.ON5zD.awCfkND3yiyY6j2Fi/kSjKJ9DC','有限会社 中村','7909316','青山市','渡辺町','井上町宮沢9-8-9',NULL,NULL,NULL,NULL,'近藤','翼','ダミーのため一致しません','ダミーのため一致しません','06631-8-2974','0694-63-5022',NULL,0,3,'3225361','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータんがやく弓ゆみに似にていました。それが。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1121,'hiroshi27@example.net','$2y$10$W4yQolj1jXYVtS8LFZdK0OX.Kq5.LI5GkKuaQEdJAH07s8wIm58IK','株式会社 江古田','1126873','山岸市','井上町','山本町山岸7-6-1',NULL,NULL,NULL,NULL,'野村','太一','ダミーのため一致しません','ダミーのため一致しません','07132-4-0189','0740-764-452',NULL,2,2,'6919987','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータついているようなくそれをたべられてるね。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1131,'nsugiyama@example.com','$2y$10$yXBFAiRUAvSUNYL8DyvnK.cI/WHVmRaw7FgdDpdVw4AuT4h0RhTpi','有限会社 近藤','7881375','山本市','吉田町','井上町小林8-1-5',NULL,NULL,NULL,NULL,'江古田','智也','ダミーのため一致しません','ダミーのため一致しません','080-7477-3407','0420-263-287',NULL,1,1,'6963170','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ本の牛乳瓶ぎゅうや黄玉トパーズや、こっ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1141,'taro13@example.com','$2y$10$6aXRGaxyGq.cxQDkwU3vgeLdxkvohbOtT5/FRNq73.7FiYQs13/YW','有限会社 宮沢','8074653','若松市','渚町','村山町村山5-10-4',NULL,NULL,NULL,NULL,'近藤','翼','ダミーのため一致しません','ダミーのため一致しません','090-3150-3733','0201-99-7844',NULL,0,2,'8098150','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータた通り越こすりながら、もうその日と時間。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1151,'sasada.jun@example.net','$2y$10$vc.PEA.hGya/z19kAejytOVOBV9hD4q6UX01nDVOs2nZVorG8M9Ii','有限会社 大垣','9227300','江古田市','井高町','山田町小林4-6-3',NULL,NULL,NULL,NULL,'斉藤','太一','ダミーのため一致しません','ダミーのため一致しません','090-8648-8171','083-507-1308',NULL,3,3,'9224819','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ文ちゅうの席せきのあかりがいつはすなご。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1161,'yuta22@example.org','$2y$10$8C1lMK3kxV254dZpyEjV7Op0MhjpgOJT.FoU0f87Cwz5HxkeTaztC','有限会社 小林','2303223','井上市','三宅町','江古田町原田1-4-2',NULL,NULL,NULL,NULL,'松本','浩','ダミーのため一致しません','ダミーのため一致しません','080-3564-9542','006-234-7964',NULL,0,3,'6494509','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータも空すいしゃるんだ。六銀河ぎんやり白く。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1171,'miki31@example.org','$2y$10$g/eoFSbaYK21qZSq.wggp.05RGrVFX257LmlcEmpJEr9OPWPoZwGK','株式会社 加藤','6661685','高橋市','若松町','浜田町鈴木1-4-7',NULL,NULL,NULL,NULL,'宇野','学','ダミーのため一致しません','ダミーのため一致しません','05-3069-9820','080-5279-0177',NULL,3,2,'2551444','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの中を通って口笛くちぶえを吹ふいてしま。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1181,'kondo.shota@example.org','$2y$10$hjcXoW8DmZOCtT4.VZoNqOgA4zneMH/OHvSuZMXopNosKE4C5W2gu','株式会社 宮沢','7855318','渚市','若松町','青山町江古田6-10-5',NULL,NULL,NULL,NULL,'西之園','七夏','ダミーのため一致しません','ダミーのため一致しません','02-6677-4477','06-6472-5642',NULL,1,4,'7676230','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータさぎの第だいの第二時だいだろうど四方に。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1191,'naoko71@example.com','$2y$10$T10TwHuOTld5DpnHaOs2GufQEapItyisDSzm4AdqfkXsB/x0z.NQC','有限会社 宇野','4787505','伊藤市','小泉町','村山町若松4-7-10',NULL,NULL,NULL,NULL,'村山','拓真','ダミーのため一致しません','ダミーのため一致しません','0397-07-9615','0556-07-1011',NULL,0,2,'2549417','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータそんなことは、いました声がしらの球たま。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1201,'hiroshi16@example.net','$2y$10$99yaPmXKzNwP2xUNHVYfAeX9jo5YJEnDnlCk86DXElzx8ETyOM88u','株式会社 木村','1807181','宇野市','杉山町','吉田町加藤4-5-7',NULL,NULL,NULL,NULL,'宮沢','千代','ダミーのため一致しません','ダミーのため一致しません','080-8345-0708','0799-79-9808',NULL,2,4,'5666854','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータちもくさんが二つにつけていた地理ちりの。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1211,'rnishinosono@example.net','$2y$10$AGIuWYOYM72pQIdlwXDMOOQhwzMXBHEeVM5.ABYgEm2fU2KWsF3A.','有限会社 中島','9664021','田中市','三宅町','木村町山口10-2-4',NULL,NULL,NULL,NULL,'伊藤','香織','ダミーのため一致しません','ダミーのため一致しません','08-3103-4324','090-2728-2603',NULL,1,4,'5025151','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータの星座せいのでしたように、眼めをこすっ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1221,'tanaka.yosuke@example.net','$2y$10$jBWZBoraEbTfCdd6.k5z8OL6QPnB95lZRcNykDVjJqLcWSmViG3Yy','株式会社 浜田','8315261','青田市','宇野町','三宅町原田8-3-7',NULL,NULL,NULL,NULL,'野村','零','ダミーのため一致しません','ダミーのため一致しません','090-9155-2774','090-2034-1956',NULL,3,1,'3705604','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータびんの格子こう言いな桔梗ききました。「。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1231,'kenichi.hirokawa@example.net','$2y$10$5tVy4vAsaeoK8aEB8LOgqOWjpDfZPcqgloqWuvvnhSMtH5iUlPdXu','有限会社 坂本','2086791','石田市','青田町','喜嶋町山本6-7-5',NULL,NULL,NULL,NULL,'田辺','和也','ダミーのため一致しません','ダミーのため一致しません','09-9216-1218','090-1255-8727',NULL,0,1,'9984170','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータれどもほんもあてを顔にあてて灰はいいで。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1241,'yui14@example.net','$2y$10$6VNkIRaoAAFeJWYXlRk6e.xa2pWDVZ7wMKLfWIyHlBhr.x2L6KaV6','有限会社 青山','2754588','伊藤市','青山町','青山町加藤5-1-8',NULL,NULL,NULL,NULL,'若松','桃子','ダミーのため一致しません','ダミーのため一致しません','030-926-4947','08279-8-4520',NULL,3,1,'3557627','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータがざわ言いいかたくさんはぼくはたくして。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1251,'tanabe.naoki@example.com','$2y$10$RcFz8vNE5Ab4vI0uK/ZbFey5YBb8psUjsf5I3Jxjr3eeR188oSXF2','株式会社 山口','8668316','小泉市','吉田町','江古田町大垣7-7-2',NULL,NULL,NULL,NULL,'田辺','春香','ダミーのため一致しません','ダミーのため一致しません','0350-827-225','090-4900-1380',NULL,1,3,'6428502','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータてしまいな皮かわどこでばかりやき、野原。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1261,'ekoda.tsubasa@example.net','$2y$10$j831cctc0Rzj688w8zDzH.O0mdwlDgevdAlMpCVWH4ipCoVK05slG','株式会社 中島','1298059','吉本市','伊藤町','青田町田辺9-4-2',NULL,NULL,NULL,NULL,'宮沢','裕美子','ダミーのため一致しません','ダミーのため一致しません','080-1338-4736','0719-77-1989',NULL,3,4,'3772101','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぐちになりいろいろなふうにぼんをまっす。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1271,'suzuki.tomoya@example.com','$2y$10$BvBa00x1eSpUGBOzani2hOTgXRPI05vTb0AJaVfUSB5.PBh24Advq','有限会社 田辺','4539200','大垣市','若松町','田中町青田5-7-9',NULL,NULL,NULL,NULL,'中村','晃','ダミーのため一致しません','ダミーのため一致しません','0740-803-370','09-6795-6708',NULL,1,3,'2546461','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ車が通るのです。「厭いや、まるでたくさ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1281,'yumiko.takahashi@example.com','$2y$10$7c.tuuMVgMDKagf1mUU8Z.1Wx4I3p6uc98ysHwOBsLIydT0/LROOK','有限会社 中津川','7535117','渡辺市','井上町','山口町斉藤1-5-3',NULL,NULL,NULL,NULL,'井上','花子','ダミーのため一致しません','ダミーのため一致しません','090-9872-8390','027-375-8212',NULL,2,3,'1542202','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータときは川がして、ちぢれ葉はで飾かざり、。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1291,'ikimura@example.net','$2y$10$gEE.33UK3ojbZVG3dXHySuS5T3eAuBRl3Rd71Aaqklh4QrQUEtWnq','有限会社 松本','5641799','松本市','渚町','吉田町笹田10-5-7',NULL,NULL,NULL,NULL,'松本','加奈','ダミーのため一致しません','ダミーのため一致しません','093-521-2281','0551-10-4838',NULL,3,2,'3526605','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータいいえ、まじっと前のくるコルク抜ぬきの。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1301,'naoki99@example.org','$2y$10$A3/2rIuIJhe22MJSFUZ5eOsMAxtZlPFiGsldhjFq3OsHuNuV0yRki','有限会社 廣川','4438604','中村市','桐山町','山岸町高橋5-5-2',NULL,NULL,NULL,NULL,'廣川','七夏','ダミーのため一致しません','ダミーのため一致しません','073-851-2630','03-5559-3704',NULL,3,2,'6752008','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータつるはずはどこからなもん通りだの今だっ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1311,'gmatsumoto@example.com','$2y$10$z6HS5rHJTCTScKBHqOSkLutOIyRP3ZVnj1p92V2qn6S9s4IBMnSUq','株式会社 鈴木','7477532','工藤市','江古田町','宇野町中村4-3-2',NULL,NULL,NULL,NULL,'松本','拓真','ダミーのため一致しません','ダミーのため一致しません','01-5340-7265','025-059-9750',NULL,0,2,'5411126','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータおさえなかにがら通って見ていまはもう信。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1321,'wharada@example.net','$2y$10$y73jsle7DRRlqPviHo0URur/0oJ.8dx9UaWRFSjdpP2RixJfSdyVi','株式会社 井上','1463133','大垣市','石田町','加納町浜田3-7-3',NULL,NULL,NULL,NULL,'小泉','あすか','ダミーのため一致しません','ダミーのため一致しません','0613-16-9422','071-507-6292',NULL,0,1,'7558872','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータなんかねえ」「いえずに博士はかるような。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1331,'qidaka@example.net','$2y$10$XxGZa6VobtFS0EGctLaQVOgKd1p9oTdiuafwLL2pizwInm8XrFxZS','有限会社 藤本','5807468','吉本市','伊藤町','坂本町斉藤3-4-8',NULL,NULL,NULL,NULL,'中村','裕太','ダミーのため一致しません','ダミーのため一致しません','0560-212-923','0040-894-366',NULL,2,3,'8922296','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータながら、ごらんだわ」姉あねもハンケチで。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1341,'hiroshi52@example.net','$2y$10$izW.SupCMoi4nK16ShjZRuZ6UOPrRrcopuztIAwRvnPY30DJ8.CVu','有限会社 小林','8328194','山本市','山口町','田中町村山9-3-10',NULL,NULL,NULL,NULL,'山本','学','ダミーのため一致しません','ダミーのため一致しません','06346-7-3334','0678-18-8217',NULL,0,2,'6764629','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータきな橋はしの方に不思議ふしぎな声がきぐ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1351,'haruka86@example.com','$2y$10$HZnBEkLYK64QSt4kSeZmse6srPRKYd3zektkoid4222vXU99jnFTy','有限会社 小林','5967270','斉藤市','田中町','桐山町木村7-3-2',NULL,NULL,NULL,NULL,'桐山','太一','ダミーのため一致しません','ダミーのため一致しません','080-8446-3266','082-458-8726',NULL,2,3,'1862152','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータろいろなんにぶったくさりの明るくなりま。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1361,'ykijima@example.com','$2y$10$ED.GixH6j9yvF1MYSjaIWO2MxP6ENKjZ2k42BUb6nX7dSR/O.Pk4O','株式会社 伊藤','3889793','江古田市','田辺町','小林町村山10-5-6',NULL,NULL,NULL,NULL,'小泉','和也','ダミーのため一致しません','ダミーのため一致しません','048-179-9156','02-4111-4175',NULL,3,1,'7226449','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ障こしこのごろに浮うかご承知しょう、こ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1371,'kanou.atsushi@example.org','$2y$10$wVhyx1BZ5XMsSBtrTWhQ5OrAoCMf30xA.GM6M24fyIHJLzfiFGdKe','株式会社 青田','6769339','桐山市','渚町','藤本町大垣1-10-8',NULL,NULL,NULL,NULL,'宇野','聡太郎','ダミーのため一致しません','ダミーのため一致しません','0763-56-8553','044-315-1352',NULL,1,1,'1021659','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータて、そのとき汽車石炭袋せきのどくその銀。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1381,'asuka.ogaki@example.com','$2y$10$fUPboZGb7jlDi.eLS3mZfOIV.PUj/diygyWFqkfbvpqBI22HRY5/6','有限会社 坂本','4946105','三宅市','山口町','田中町渡辺8-8-4',NULL,NULL,NULL,NULL,'松本','篤司','ダミーのため一致しません','ダミーのため一致しません','0022-53-0069','06-5446-0898',NULL,0,3,'8665823','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータい点々てんきょうへめぐったとき先生は中。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1391,'manabu92@example.com','$2y$10$zVwDDozGu8Xxj6/0x.gEruU0dRvBy35MBjtOOT7b38IjxEVJ/C5Jm','有限会社 村山','7406183','佐々木市','渡辺町','小泉町宮沢8-6-1',NULL,NULL,NULL,NULL,'石田','翼','ダミーのため一致しません','ダミーのため一致しません','0413-73-1805','021-391-0644',NULL,2,3,'8429281','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータさむさとは、そうにゅうじかのようかと訊。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1401,'rmatsumoto@example.com','$2y$10$logGh2WFtopAwzpzkIaaYe69we035tgKNp5SuG0GJiuyfRW0ujLcy','有限会社 井上','4264802','吉田市','西之園町','山本町宇野7-1-10',NULL,NULL,NULL,NULL,'小林','裕太','ダミーのため一致しません','ダミーのため一致しません','0728-42-1037','0356-64-7787',NULL,2,2,'4159034','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータびやかさん。りんどんなほんとうと思った。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1411,'momoko28@example.net','$2y$10$ZPansjph2u7m3CRpnX9cxOJsS2Rk35PIobNrS5YJJ/OMy6bu2q0Ba','株式会社 山岸','1898653','藤本市','工藤町','加藤町鈴木6-7-2',NULL,NULL,NULL,NULL,'加藤','幹','ダミーのため一致しません','ダミーのため一致しません','0724-33-5034','06612-9-9023',NULL,1,3,'4943314','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータぁ、べられていた席せきにいるのを見てい。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1421,'soutaro.aoyama@example.com','$2y$10$57EZX/vp.Yyv6N7jWWr4RuH0/pXFoLTx19W0zpN3g.UkniEfnXVoC','有限会社 井上','1007578','田辺市','吉田町','山岸町佐藤9-6-8',NULL,NULL,NULL,NULL,'伊藤','花子','ダミーのため一致しません','ダミーのため一致しません','090-0418-2648','01-4734-2231',NULL,1,1,'3502798','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータっとその黒い星がたが、急きゅうに風にひ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1431,'ryohei.ishida@example.com','$2y$10$TIYIaTF33uEFVIpohNDEfOzOADxymMna6z/IQlmU9wATUNDvsVTLO','株式会社 石田','6442641','笹田市','山田町','山田町田中6-10-5',NULL,NULL,NULL,NULL,'石田','篤司','ダミーのため一致しません','ダミーのため一致しません','013-626-5971','090-3912-2294',NULL,2,2,'1988018','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータった小さかなかったりしが書いて、息いき。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:06','2021-03-11 22:29:06'),(1441,'aharada@example.com','$2y$10$Wm5xfldKclXEuSwUt8dQCuRahdmtSKEalDBTRbsS2GZ.OPV7cwNbG','株式会社 高橋','6396707','津田市','松本町','渚町山口4-6-5',NULL,NULL,NULL,NULL,'中津川','学','ダミーのため一致しません','ダミーのため一致しません','0798-53-6066','062-971-7361',NULL,3,3,'3241902','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ二ばかりのあかりひっくらないのでした。。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1451,'minoru55@example.com','$2y$10$2Y8Pf5gPm/IqJOaXEZj6EurK8cOyLfVZBKtg3/8xkly7740AuG6fW','株式会社 木村','1761111','藤本市','斉藤町','青山町田辺1-9-10',NULL,NULL,NULL,NULL,'杉山','幹','ダミーのため一致しません','ダミーのため一致しません','090-8119-3466','090-1847-1691',NULL,0,3,'4408802','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータようにしずかに近づいているのでした。九。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1461,'msato@example.net','$2y$10$ZAThirmGuKiK27DBqfOPX.KGy0qJPpHF83QmZtWdQxqnC1rl.wNgO','有限会社 杉山','6072699','山田市','吉田町','藤本町村山4-5-3',NULL,NULL,NULL,NULL,'高橋','拓真','ダミーのため一致しません','ダミーのため一致しません','02628-0-4917','023-273-8846',NULL,2,2,'9791570','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータじさんに、尋たずねました。四ケンタウル。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1471,'atsushi11@example.net','$2y$10$iRAeLPK92QbbduOps21KteJ7VOAx74STdyYkbpJuEFmOV7uTVS2qK','株式会社 山口','8273719','井上市','宮沢町','田辺町山岸8-5-2',NULL,NULL,NULL,NULL,'中島','花子','ダミーのため一致しません','ダミーのため一致しません','0430-27-7473','080-0493-0865',NULL,2,3,'1776914','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータかわらっしゃたべてにかかったのでしませ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1481,'cmiyake@example.org','$2y$10$5JCCnsRDR9lWKpBHGmFZkeZYcuL5MPPI4cMUnTq4UMMhTU33xj.yS','有限会社 近藤','2397008','宇野市','田中町','野村町廣川10-9-2',NULL,NULL,NULL,NULL,'渚','幹','ダミーのため一致しません','ダミーのため一致しません','0285-54-6606','05-6312-3857',NULL,0,2,'9424733','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータ走って、あらゆらぎ、そのとなって叫さけ。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1491,'yoshida.akemi@example.com','$2y$10$QmTMvswEHTJGCNy3jjId0.oCYee8WleO2QkR0VCMcXkXw0A6ODBf.','株式会社 坂本','2143467','中島市','杉山町','中島町笹田6-5-4',NULL,NULL,NULL,NULL,'青田','健一','ダミーのため一致しません','ダミーのため一致しません','0310-82-7357','06550-0-7325',NULL,2,3,'9659107','ダミーデータ','ダミーデータ','ダミーデータ','ダミーデータレオの観測所かったわ」青年に言いいまし。',NULL,NULL,1,1,NULL,'2021-03-11 22:29:07','2021-03-11 22:29:07'),(1511,'nakatani@web-trickster.com','$2y$10$oVrAu.1Xe81zakMi5PPCROReu0Il76a1To1FmrDlEuK4LIc/c7Lxy','ABC株式会社','5510001','大阪府','大阪市大正区三軒家西','1-1-1',NULL,NULL,1,'平日% 土日% 3週間前%','瀬戸','カトリーヌ','セト','カトリーヌ','09011111111',NULL,NULL,1,2,NULL,NULL,NULL,NULL,NULL,'テスト',NULL,1,1,NULL,'2021-03-12 14:10:53','2021-03-12 14:10:53'),(1521,'aaa@email.com','$2y$10$J1WnATACJlgqDLp9bsAPTO7vWhMYQ4umW2F5wNxyxAqHFDU0b89bS','アムウェイ',NULL,NULL,NULL,NULL,NULL,NULL,1,'平日% 土日% 3週間前%','山本','光三郎','ヤマモト','コウザブロウ','09090909009','0611111111',NULL,3,4,'5152623','三重県','津市白山町上ノ村','1',NULL,NULL,'test',1,1,NULL,'2021-03-12 14:15:12','2021-03-12 14:16:34'),(1561,'yamada@gmail.com','$2y$10$WFFxcoGhevYOKmxan.s0lOF80F2UTXdo3e/vIR2Fn5jU7fV9nzSaO','株式会社テスト',NULL,NULL,NULL,NULL,NULL,NULL,1,'平日% 土日% 3週間前%','山田','太郎','ヤマダ','タロウ','08012345678','0612345678',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,'2021-03-12 19:49:36','2021-03-12 19:49:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,0,'四ツ橋','サンワールドビル','1号室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(11,1,'四ツ橋','サンワールドビル','2号室(音響HG)',18,50,20,0,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'0',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:37:18'),(21,0,'トリックスター','We Work','執務室',18,50,20,1,'test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'test','test','test','test','test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/',NULL,NULL,'1',5000,8000,NULL,NULL,NULL,NULL,NULL,'2021-03-11 22:29:08','2021-03-11 22:29:08'),(31,0,'四ツ橋テスト','テストビル','１号室',200,200,100,0,'5500014','大阪府','大阪市西区北堀江1-6-2','サンワールドビル',NULL,'中務','真梨子','ナカム','マリコ','0665566462','nakamu@s-mg.co.jp',0,'5500014','大阪府','大阪市西区北堀江',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/yb-sunworld/recreation/','5：45～21：30','5：45～22：00','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-12 13:46:11','2021-03-12 13:46:11'),(41,0,'0','0','0',0,0,0,0,'000','0','00','00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://osaka-conference.com/rental/t6-maronie/hall/',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-12 14:20:55','2021-03-12 14:20:55');
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'heroku_4bfb6785b61d3a4'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-14  4:00:20
