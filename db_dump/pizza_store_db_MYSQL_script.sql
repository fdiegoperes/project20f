/* Hello, professor. */
/* We created this document to explain the step-by-step to create the database, user, and tables for the project. */
/* Please, copy and paste the whole script.*/

/* Creating the database */
create database pizza_store default character set utf8;

/* Creating user and granting the permissions */
create user 'user1'@'localhost'IDENTIFIED BY'Windows123!';
GRANT ALL PRIVILEGES on pizza_store.*TO'user1'@'localhost';

/* Verify the databases */
show databases;

/* Changing to pizza_store database */
use pizza_store;

--
-- Table structure for table `tblCustomers`
--

DROP TABLE IF EXISTS `tblCustomers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblCustomers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `nameCustomer` varchar(40) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `phone` varchar(24) DEFAULT NULL,
  `deliveryDetails` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_uk` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblCustomers`
--

LOCK TABLES `tblCustomers` WRITE;
/*!40000 ALTER TABLE `tblCustomers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblCustomers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblOrders`
--

DROP TABLE IF EXISTS `tblOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblOrders` (
  `orderId` smallint NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `orderDate` date DEFAULT NULL,
  PRIMARY KEY (`orderId`),
  KEY `orders_email_fk` (`email`),
  CONSTRAINT `orders_email_fk` FOREIGN KEY (`email`) REFERENCES `tblCustomers` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblOrders`
--

LOCK TABLES `tblOrders` WRITE;
/*!40000 ALTER TABLE `tblOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblOrders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPizza`
--

DROP TABLE IF EXISTS `tblPizza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblPizza` (
  `pizzaId` smallint NOT NULL AUTO_INCREMENT,
  `dough` varchar(100) DEFAULT NULL,
  `cheese` varchar(100) DEFAULT NULL,
  `sauce` varchar(100) DEFAULT NULL,
  `toppings` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pizzaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPizza`
--

LOCK TABLES `tblPizza` WRITE;
/*!40000 ALTER TABLE `tblPizza` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblPizza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPizzaOrders`
--

DROP TABLE IF EXISTS `tblPizzaOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblPizzaOrders` (
  `pizzaOrderId` smallint NOT NULL AUTO_INCREMENT,
  `orderId` smallint NOT NULL DEFAULT (0),
  `pizzaId` smallint NOT NULL DEFAULT (0),
  PRIMARY KEY (`pizzaOrderId`),
  KEY `pizzaOrder_orders_fk` (`orderId`),
  KEY `pizzaOrder_pizza_fk` (`pizzaId`),
  CONSTRAINT `pizzaOrder_orders_fk` FOREIGN KEY (`orderId`) REFERENCES `tblOrders` (`orderId`),
  CONSTRAINT `pizzaOrder_pizza_fk` FOREIGN KEY (`pizzaId`) REFERENCES `tblPizza` (`pizzaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPizzaOrders`
--

LOCK TABLES `tblPizzaOrders` WRITE;
/*!40000 ALTER TABLE `tblPizzaOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblPizzaOrders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-12 13:03:54
