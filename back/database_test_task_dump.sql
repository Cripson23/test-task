-- MySQL dump 10.13  Distrib 8.3.0, for Linux (x86_64)
--
-- Host: localhost    Database: test_task
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Temporary view structure for view `customer_orders`
--

DROP TABLE IF EXISTS `customer_orders`;
/*!50001 DROP VIEW IF EXISTS `customer_orders`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `customer_orders` AS SELECT 
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `order_date`,
 1 AS `item_name`,
 1 AS `quantity`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (151,'John','Doe','john.doe@example.com'),(152,'Jane','Doe','jane.doe@example.com'),(153,'Jim','Beam','jim.beam@example.com'),(154,'Jack','Daniels','jack.daniels@example.com'),(155,'Johnny','Walker','johnny.walker@example.com'),(156,'Jenna','Jameson','jenna.jameson@example.com'),(157,'Jessica','Alba','jessica.alba@example.com'),(158,'Jennifer','Lawrence','jennifer.lawrence@example.com'),(159,'Julia','Roberts','julia.roberts@example.com'),(160,'Jake','Gyllenhaal','jake.gyllenhaal@example.com'),(161,'Jodie','Foster','jodie.foster@example.com'),(162,'Joseph','Gordon-Levitt','joseph.levitt@example.com'),(163,'Jared','Leto','jared.leto@example.com'),(164,'Jeremy','Renner','jeremy.renner@example.com'),(165,'Jessica','Biel','jessica.biel@example.com');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`admin`@`%`*/ /*!50003 TRIGGER `AfterCustomerAdded` AFTER INSERT ON `customers` FOR EACH ROW BEGIN
    INSERT INTO orders (customer_id, item_id, order_date, quantity) VALUES (NEW.id, 1, CURDATE(), 1); -- Добавление демонстрационного заказа
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary view structure for view `item_sales`
--

DROP TABLE IF EXISTS `item_sales`;
/*!50001 DROP VIEW IF EXISTS `item_sales`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `item_sales` AS SELECT 
 1 AS `item_name`,
 1 AS `total_sold`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Laptop',1200.00),(2,'Smartphone',800.00),(3,'Tablet',450.00),(4,'Desktop Computer',1500.00),(5,'Smartwatch',350.00),(6,'Headphones',150.00),(7,'External Hard Drive',120.00),(8,'Keyboard',100.00),(9,'Mouse',50.00),(10,'Webcam',80.00),(11,'Monitor',300.00),(12,'Speakers',200.00),(13,'Printer',250.00),(14,'Router',130.00),(15,'Software License',199.99);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1712942790),('m240410_111407_create_products_table',1712942791);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (36,151,1,'2024-04-12',1),(37,152,1,'2024-04-12',1),(38,153,1,'2024-04-12',1),(39,154,1,'2024-04-12',1),(40,155,1,'2024-04-12',1),(41,156,1,'2024-04-12',1),(42,157,1,'2024-04-12',1),(43,158,1,'2024-04-12',1),(44,159,1,'2024-04-12',1),(45,160,1,'2024-04-12',1),(46,161,1,'2024-04-12',1),(47,162,1,'2024-04-12',1),(48,163,1,'2024-04-12',1),(49,164,1,'2024-04-12',1),(50,165,1,'2024-04-12',1),(51,1,5,'2023-04-01',2),(52,1,1,'2023-04-02',1),(53,2,2,'2023-04-03',1),(54,3,3,'2023-04-04',1),(55,4,4,'2023-04-05',1),(56,5,5,'2023-04-06',1),(57,6,6,'2023-04-07',1),(58,7,7,'2023-04-08',1),(59,8,8,'2023-04-09',1),(60,9,9,'2023-04-10',1),(61,10,10,'2023-04-11',1),(62,11,11,'2023-04-12',1),(63,12,12,'2023-04-13',1),(64,13,13,'2023-04-14',1),(65,14,14,'2023-04-15',1),(66,15,15,'2023-04-16',1),(67,1,6,'2023-04-17',3),(68,2,7,'2023-04-18',2),(69,3,8,'2023-04-19',2),(70,4,9,'2023-04-20',2),(71,5,10,'2023-04-21',2),(72,6,11,'2023-04-22',2),(73,7,12,'2023-04-23',2),(74,8,13,'2023-04-24',2),(75,9,14,'2023-04-25',2),(76,10,15,'2023-04-26',2),(77,11,1,'2023-04-27',2),(78,12,2,'2023-04-28',2),(79,13,3,'2023-04-29',2),(80,14,4,'2023-04-30',2);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`admin`@`%`*/ /*!50003 TRIGGER `AfterOrderUpdated` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF OLD.quantity <> NEW.quantity THEN
        INSERT INTO audit_log (description) VALUES (CONCAT('Order ', NEW.order_id, ' quantity changed from ', OLD.quantity, ' to ', NEW.quantity));
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`admin`@`%`*/ /*!50003 TRIGGER `BeforeOrderDeleted` BEFORE DELETE ON `orders` FOR EACH ROW BEGIN
    INSERT INTO audit_log (description) VALUES (CONCAT('Order ', OLD.order_id, ' was deleted.'));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `subtitle` varchar(64) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Nike Air Max 270','Comfort and Style',150.00,'The Nike Air Max 270 mixes comfort and style for a premium wearing experience.','/img/products/nike_air_max_270.png',1712945508,1712945508),(2,'Adidas Ultraboost 21','Running Revolution',180.00,'Experience incredible energy return with the Adidas Ultraboost 21.','/img/products/adidas_ultraboost_21.png',1712945508,1712945508),(3,'New Balance 574','Classic Comfort',80.00,'The New Balance 574 offers an iconic style and unparalleled comfort.','/img/products/new_balance_574.png',1712945508,1712945508),(4,'Asics Gel-Kayano 27','Stable and Cushioned',160.00,'Asics Gel-Kayano 27 provides stability and cushion for long distance running.','/img/products/asics_gel_kayano_27.png',1712945508,1712945508),(5,'Puma RS-X3','Bold and Colorful',110.00,'Puma RS-X3 combines bold colors and chunky design for a standout look.','/img/products/puma_rs_x3.png',1712945508,1712945508),(6,'Reebok Nano X','Versatile Training',130.00,'The Reebok Nano X is versatile enough for all types of training, from lifting to running.','/img/products/reebok_nano_x.png',1712945508,1712945508),(7,'Under Armour HOVR Phantom 2','Innovative Comfort',140.00,'Under Armour HOVR Phantom 2 offers innovative comfort with HOVR technology.','/img/products/under_armour_hovr_phantom_2.png',1712945508,1712945508),(8,'Nike ZoomX Vaporfly Next%','Breaking Records',250.00,'Nike ZoomX Vaporfly Next% is designed to break records, offering unparalleled speed and efficiency.','/img/products/nike_zoomx_vaporfly_next.png',1712945508,1712945508),(9,'Adidas NMD R1','Urban Exploration',140.00,'Adidas NMD R1 blends heritage style with modern comfort for urban exploration.','/img/products/adidas_nmd_r1.png',1712945508,1712945508),(10,'New Balance Fresh Foam 1080v11','Plush Ride',150.00,'New Balance Fresh Foam 1080v11 provides a plush ride with superior cushioning.','/img/products/new_balance_fresh_foam_1080v11.png',1712945508,1712945508),(11,'Asics Gel-Nimbus 23','Long Distance Comfort',150.00,'Asics Gel-Nimbus 23 is designed for long-distance comfort with advanced cushioning.','/img/products/asics_gel_nimbus_23.png',1712945508,1712945508),(12,'Puma Future Rider','Retro Future',90.00,'Puma Future Rider offers a retro future look with comfortable cushioning.','/img/products/puma_future_rider.png',1712945508,1712945508),(13,'Reebok Classic Leather','Timeless Style',75.00,'Reebok Classic Leather is all about timeless style and comfort.','/img/products/reebok_classic_leather.png',1712945508,1712945508),(14,'Under Armour Curry 8','Precision on Court',160.00,'Under Armour Curry 8 delivers precision and control on the basketball court.','/img/products/under_armour_curry_8.png',1712945508,1712945508),(15,'Nike Air Force 1','Iconic Style',90.00,'The Nike Air Force 1 offers iconic style with classic comfort and durability.','/img/products/nike_air_force_1.png',1712945508,1712945508);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `recent_orders`
--

DROP TABLE IF EXISTS `recent_orders`;
/*!50001 DROP VIEW IF EXISTS `recent_orders`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `recent_orders` AS SELECT 
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `order_date`,
 1 AS `item_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'test_task'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `ArchiveOldOrders` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`admin`@`%`*/ /*!50106 EVENT `ArchiveOldOrders` ON SCHEDULE EVERY 1 MONTH STARTS '2024-04-12 17:32:30' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
        INSERT INTO orders_archive SELECT * FROM orders WHERE order_date < CURDATE() - INTERVAL 1 YEAR;
        DELETE FROM orders WHERE order_date < CURDATE() - INTERVAL 1 YEAR;
    END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `CheckItemStock` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`admin`@`%`*/ /*!50106 EVENT `CheckItemStock` ON SCHEDULE EVERY 1 DAY STARTS '2024-04-13 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
        CALL CheckStock(); -- Процедура, которая проверяет и обновляет запасы товаров
    END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `UpdateItemPrices` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`admin`@`%`*/ /*!50106 EVENT `UpdateItemPrices` ON SCHEDULE EVERY 1 WEEK STARTS '2024-04-19 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
        UPDATE items SET price = price * 1.05 WHERE price < 100;
    END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'test_task'
--
/*!50003 DROP PROCEDURE IF EXISTS `AddCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`admin`@`%` PROCEDURE `AddCustomer`(IN fname VARCHAR(100), IN lname VARCHAR(100), IN email VARCHAR(100))
BEGIN
    INSERT INTO customers (first_name, last_name, email) VALUES (fname, lname, email);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `PlaceOrder` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`admin`@`%` PROCEDURE `PlaceOrder`(IN cust_id INT, IN item_id INT, IN qty INT)
BEGIN
    INSERT INTO orders (customer_id, item_id, order_date, quantity) VALUES (cust_id, item_id, CURDATE(), qty);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `UpdateItemPrice` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`admin`@`%` PROCEDURE `UpdateItemPrice`(IN item_id INT, IN new_price DECIMAL(10,2))
BEGIN
    UPDATE items SET price = new_price WHERE item_id = item_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `customer_orders`
--

/*!50001 DROP VIEW IF EXISTS `customer_orders`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `customer_orders` AS select `customers`.`first_name` AS `first_name`,`customers`.`last_name` AS `last_name`,`orders`.`order_date` AS `order_date`,`items`.`item_name` AS `item_name`,`orders`.`quantity` AS `quantity` from ((`customers` join `orders` on((`customers`.`id` = `orders`.`customer_id`))) join `items` on((`orders`.`item_id` = `items`.`item_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `item_sales`
--

/*!50001 DROP VIEW IF EXISTS `item_sales`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `item_sales` AS select `items`.`item_name` AS `item_name`,sum(`orders`.`quantity`) AS `total_sold` from (`orders` join `items` on((`orders`.`item_id` = `items`.`item_id`))) group by `items`.`item_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `recent_orders`
--

/*!50001 DROP VIEW IF EXISTS `recent_orders`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `recent_orders` AS select `customers`.`first_name` AS `first_name`,`customers`.`last_name` AS `last_name`,`orders`.`order_date` AS `order_date`,`items`.`item_name` AS `item_name` from ((`customers` join `orders` on((`customers`.`id` = `orders`.`customer_id`))) join `items` on((`orders`.`item_id` = `items`.`item_id`))) where (`orders`.`order_date` > (curdate() - interval 30 day)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-12 18:31:37
