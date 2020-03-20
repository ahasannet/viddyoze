-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table viddyoze.discount: ~1 rows (approximately)
DELETE FROM `discount`;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` (`id`, `name`, `product_id`, `quantity`, `percent`, `amount`, `created`, `updated`) VALUES
	(1, 'buy one red widget, get the second half price', 1, 2, 50, 0, '2020-03-20 10:53:22', '2020-03-20 10:53:22');
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;

-- Dumping data for table viddyoze.migration_versions: ~0 rows (approximately)
DELETE FROM `migration_versions`;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;

-- Dumping data for table viddyoze.orders: ~0 rows (approximately)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping data for table viddyoze.order_item: ~0 rows (approximately)
DELETE FROM `order_item`;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;

-- Dumping data for table viddyoze.product: ~3 rows (approximately)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `code`, `price`, `stock`, `created`, `updated`) VALUES
	(1, 'Red Widget', 'R01', 32.95, 100, '2020-03-20 10:46:18', '2020-03-20 10:46:18'),
	(2, 'Green Widget', 'G01', 24.95, 100, '2020-03-20 10:47:02', '2020-03-20 10:47:02'),
	(3, 'Blue Widget', 'B01', 7.95, 100, '2020-03-20 10:48:12', '2020-03-20 10:48:12');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping data for table viddyoze.shipment: ~3 rows (approximately)
DELETE FROM `shipment`;
/*!40000 ALTER TABLE `shipment` DISABLE KEYS */;
INSERT INTO `shipment` (`id`, `name`, `order_amount`, `cost`, `created`, `updated`) VALUES
	(1, 'Full', 0, 4.95, '2020-03-20 10:51:31', '2020-03-20 10:51:31'),
	(2, 'Discount', 50, 2.95, '2020-03-20 10:52:03', '2020-03-20 10:52:03'),
	(3, 'Free', 90, 0, '2020-03-20 10:52:23', '2020-03-20 10:52:23');
/*!40000 ALTER TABLE `shipment` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
