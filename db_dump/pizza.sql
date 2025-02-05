-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: pizza_store_db
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

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
  `city` varchar(20) DEFAULT NULL,
  `province` varchar(20) DEFAULT NULL,
  `postalCode` varchar(15) DEFAULT NULL,
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
  `orderId` smallint NOT NULL,
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
  `pizzaId` smallint NOT NULL,
  `dough` varchar(20) DEFAULT NULL,
  `cheese` varchar(20) DEFAULT NULL,
  `sauce` varchar(20) DEFAULT NULL,
  `toppings` varchar(20) DEFAULT NULL,
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
  `pizzaOrderId` smallint NOT NULL,
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

-- Dump completed on 2020-11-23 18:54:20
