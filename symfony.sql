-- --------------------------------------------------------
-- Host:                         ts.dreamfire.fr
-- Server version:               10.5.12-MariaDB-0+deb11u1 - Debian 11
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table symfony.command
CREATE TABLE IF NOT EXISTS `command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `delivered` tinyint(1) NOT NULL,
  `retrait_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8ECAEAD4A76ED395` (`user_id`),
  KEY `IDX_8ECAEAD4B83297E7` (`reservation_id`),
  KEY `IDX_8ECAEAD47EF8457A` (`retrait_id`),
  CONSTRAINT `FK_8ECAEAD4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8ECAEAD4B83297E7` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.command: ~16 rows (approximately)
/*!40000 ALTER TABLE `command` DISABLE KEYS */;
REPLACE INTO `command` (`id`, `user_id`, `reservation_id`, `delivered`, `retrait_id`) VALUES
	(3, 1, 4, 0, 4),
	(4, 1, 8, 0, 5),
	(5, 1, 4, 0, 5),
	(6, 1, 4, 0, 5),
	(7, 1, 4, 0, 3),
	(8, 1, 8, 0, 3),
	(9, 1, 4, 0, 4),
	(10, 1, 7, 0, 5),
	(11, 1, 7, 0, 5),
	(12, 1, 7, 0, 5),
	(13, 1, 5, 0, 4),
	(14, 1, 3, 0, 3),
	(15, 1, 3, 0, 5),
	(16, 1, 7, 0, 4),
	(17, 1, 4, 0, 3),
	(18, 3, 4, 0, 4);
/*!40000 ALTER TABLE `command` ENABLE KEYS */;

-- Dumping structure for table symfony.command_product
CREATE TABLE IF NOT EXISTS `command_product` (
  `command_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`command_id`,`product_id`),
  KEY `IDX_3C20574E33E1689A` (`command_id`),
  KEY `IDX_3C20574E4584665A` (`product_id`),
  CONSTRAINT `FK_3C20574E33E1689A` FOREIGN KEY (`command_id`) REFERENCES `command` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3C20574E4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.command_product: ~27 rows (approximately)
/*!40000 ALTER TABLE `command_product` DISABLE KEYS */;
REPLACE INTO `command_product` (`command_id`, `product_id`) VALUES
	(3, 1),
	(3, 2),
	(3, 3),
	(4, 1),
	(4, 3),
	(5, 5),
	(5, 6),
	(6, 3),
	(7, 1),
	(8, 1),
	(9, 3),
	(9, 9),
	(10, 3),
	(10, 5),
	(10, 9),
	(11, 2),
	(11, 3),
	(12, 3),
	(13, 4),
	(13, 9),
	(14, 3),
	(15, 6),
	(16, 2),
	(16, 3),
	(17, 5),
	(17, 6),
	(18, 3);
/*!40000 ALTER TABLE `command_product` ENABLE KEYS */;

-- Dumping structure for table symfony.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony.doctrine_migration_versions: ~5 rows (approximately)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
REPLACE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20211022073259', '2021-10-22 17:02:45', 228),
	('DoctrineMigrations\\Version20211022083610', '2021-10-22 17:02:48', 284),
	('DoctrineMigrations\\Version20211022122323', '2021-10-22 17:02:49', 938),
	('DoctrineMigrations\\Version20211022130430', '2021-10-22 17:02:52', 1028),
	('DoctrineMigrations\\Version20211022143437', '2021-10-22 17:02:55', 108);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Dumping structure for table symfony.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `picture_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD4D16C4DD` (`shop_id`),
  CONSTRAINT `FK_D34A04AD4D16C4DD` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony.product: ~10 rows (approximately)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
REPLACE INTO `product` (`id`, `shop_id`, `name`, `price`, `quantity`, `picture_url`) VALUES
	(1, 3, 'Quad', 500000, 0, 'http://img.xooimage.com/files87/0/b/f/p250712_20.25-01--36a241d.jpg'),
	(2, 4, 'Raptor 750z', 650, 23, 'https://cloud.leparking-moto.fr/2021/08/30/17/32/yamaha-yfm-2020-yamaha-raptor-700r-no-vat-only-300-miles-one-owner-from-new-petrol-manual-in-pontyc-bleu_156461187.jpg'),
	(3, 3, 'Baguette', 100, 92, 'https://static.fnac-static.com/multimedia/Images/FR/NR/73/be/7e/8306291/1540-1/tsp20210820031756/Baguette-magique-de-Harry-Potter-The-Noble-Collection-40-cm.jpg'),
	(4, 5, 'Glock-17', 60000, 3, 'http://lh6.ggpht.com/lr6lgkPbicOIRfG8Bh-GUmGF-db41VwmC3JqgQLxdwIXS8kf9vVjgnPKMzW6SzAFBN_6On4mBeS5hd-REDzH1AfQggo'),
	(5, 5, 'AK-74N', 240000, 1, 'https://preview.free3d.com/img/2018/01/2202344442067682394/aopqxuu4-900.jpg'),
	(6, 5, 'FAMAS', 270000, 7, 'https://cdn.radiofrance.fr/s3/cruiser-production/2017/06/1914ac1f-909f-46d3-8d55-5943fea1b84c/870x489_maxstockworld356259.jpg'),
	(7, 5, 'RPK-16', 400000, 8, 'https://i.imgur.com/vmx59Gd.png'),
	(8, 5, 'RPG-18', 700000, 1, 'https://upload.wikimedia.org/wikipedia/en/thumb/9/92/RPG-18-cutaway.JPG/1200px-RPG-18-cutaway.JPG'),
	(9, 5, 'Croissant', 80, 47, 'https://assets.afcdn.com/recipe/20131024/24713_w1024h576c1cx2747cy1872.jpg'),
	(10, 6, 'Pain au chocolat', 100, 100, 'https://one.nbstatic.fr/uploaded/20200925/7161507/thumbs/450h300f_00001_Replique-FUSIL-A-BILLES-FAMAS-F1-Airsoft-avec-chargeur-et-housse--BATTERIE-HS-.jpg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table symfony.reservation
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.reservation: ~7 rows (approximately)
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
REPLACE INTO `reservation` (`id`, `start_date`, `end_date`, `day`) VALUES
	(3, '08h00', '03h00', 'Lundi'),
	(4, '08h00', '03h00', 'Mardi'),
	(5, '08h00', '03h00', 'Mercredi'),
	(6, '08h00', '03h00', 'Jeudi'),
	(7, '08h00', '03h00', 'Vendredi'),
	(8, '08h00', '03h00', 'Samedi'),
	(9, '08h00', '03h00', 'Dimanche');
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;

-- Dumping structure for table symfony.reservation_shop
CREATE TABLE IF NOT EXISTS `reservation_shop` (
  `reservation_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`,`shop_id`),
  KEY `IDX_BA5381CAB83297E7` (`reservation_id`),
  KEY `IDX_BA5381CA4D16C4DD` (`shop_id`),
  CONSTRAINT `FK_BA5381CA4D16C4DD` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BA5381CAB83297E7` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.reservation_shop: ~7 rows (approximately)
/*!40000 ALTER TABLE `reservation_shop` DISABLE KEYS */;
REPLACE INTO `reservation_shop` (`reservation_id`, `shop_id`) VALUES
	(3, 4),
	(4, 4),
	(5, 4),
	(6, 4),
	(7, 4),
	(8, 4),
	(9, 4);
/*!40000 ALTER TABLE `reservation_shop` ENABLE KEYS */;

-- Dumping structure for table symfony.shop
CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `picture_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony.shop: ~3 rows (approximately)
/*!40000 ALTER TABLE `shop` DISABLE KEYS */;
REPLACE INTO `shop` (`id`, `name`, `longitude`, `latitude`, `picture_url`) VALUES
	(3, 'La boulangerie de Karim', 5.233, 46.209, 'https://imgresizer.eurosport.com/unsafe/1200x0/filters:format(jpeg):focal(1367x572:1369x570)/origin-imgresizer.eurosport.com/2019/11/16/2718153-56185090-2560-1440.jpg'),
	(4, 'MacDounalds', 5.22, 46.204, 'https://i.pinimg.com/originals/e0/6a/97/e06a97480a0e2327976087ec9772cbec.jpg'),
	(5, 'Chez Jawad', 5.229, 46.202, 'https://www.espacemanager.com/sites/default/files/field/image/naif.png'),
	(6, 'Chez Rachid', 5.2203734195042, 46.203657338671, 'https://i.pinimg.com/originals/e0/6a/97/e06a97480a0e2327976087ec9772cbec.jpg');
/*!40000 ALTER TABLE `shop` ENABLE KEYS */;

-- Dumping structure for table symfony.shop_user
CREATE TABLE IF NOT EXISTS `shop_user` (
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`shop_id`,`user_id`),
  KEY `IDX_4C6130324D16C4DD` (`shop_id`),
  KEY `IDX_4C613032A76ED395` (`user_id`),
  CONSTRAINT `FK_4C6130324D16C4DD` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4C613032A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.shop_user: ~3 rows (approximately)
/*!40000 ALTER TABLE `shop_user` DISABLE KEYS */;
REPLACE INTO `shop_user` (`shop_id`, `user_id`) VALUES
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1);
/*!40000 ALTER TABLE `shop_user` ENABLE KEYS */;

-- Dumping structure for table symfony.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony.user: ~3 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`) VALUES
	(1, 'theo.escolano@etu.univ-lyon1.fr', '["ROLE_ADMIN"]', '$2y$13$VuORIPsDNADGoags6QZtguxNZI8azBdU9441pwt4CTwN86eBVeF5O', 1),
	(2, 'fdsfsdqfsdfsdfsqd@yopmail.com', '[]', '$2y$13$sDhzSw3gDSymSpFd.a4S5.Glls8DIGuEo..8zTFGG4MNjd2r9uSAO', 0),
	(3, 'escolano725@gmail.com', '[]', '$2y$13$QS2sq2thlWZLuomD9ZqlAelBCwiDnsunB6vtmBRwBZXu0GEf2B2jK', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table symfony.user_product
CREATE TABLE IF NOT EXISTS `user_product` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `IDX_8B471AA7A76ED395` (`user_id`),
  KEY `IDX_8B471AA74584665A` (`product_id`),
  CONSTRAINT `FK_8B471AA74584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8B471AA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table symfony.user_product: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_product` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
