-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: teste5
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Current Database: `teste5`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `teste5` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `teste5`;

--
-- Table structure for table `indexes`
--

DROP TABLE IF EXISTS `indexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indexes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spread_target_standard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trading_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_definition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indexes`
--

LOCK TABLES `indexes` WRITE;
/*!40000 ALTER TABLE `indexes` DISABLE KEYS */;
INSERT INTO `indexes` VALUES (1,'AUS200','Instrument which price is based on quotations of the contract for index reflecting 200 largest Australian stocks quoted on the Australian regulated market.','5','12:05 am - 6:30 am and 7:15 am - 09:00 pm CET; 2:05 am - 8:30 am and 9:15 am - 23:00 pm CEST\"\"\"\"','indices'),(2,'AUT20','Instrument which price is based on quotations of the contract for index reflecting 20 largest Austrian stocks quoted on the Austrian regulated market.','28','9:10 am  - 5:00 pm','indices'),(3,'BRAComp','Instrument which price is based on quotations of the contract for index reflecting largest Brazilian stocks quoted on the Brazilian regulated market.','125','12:05 pm - 8:55 pm CET; 2:05 pm - 10:55 pm CEST','indices'),(4,'CHNComp','Instrument which price is based on quotations of the contract for index reflecting largest Chinese stocks quoted on the Chinese regulated market.','20','2:20 am - 5:00 am and 6:35 am - 9:15 am CET; 3:20 am - 6:00 am and 7:35 am - 10:15 am CEST','indices'),(5,'CZKCASH','Instrument which price is based on quotations of cash index reflecting largest Czech stocks quoted on the Czech organized market.','3','9:20 am - 4:00 pm','indices'),(6,'DE30','Instrument which price is based on quotations of the contract for index reflecting 30 largest German stocks quoted on the German regulated market.','1','1:15 am - 10:00 pm','indices'),(7,'DE30.cash','Instrument which price is based on quotations of the index reflecting 30 largest German stocks quoted on organized market.','1','12:00 am - 10:00 pm','indices'),(8,'EU50','Instrument which price is based on quotations of the contract for index reflecting 50 largest European stocks quoted on the European regulated market.','2.2','1:15 am - 10:00 pm','indices'),(9,'EU50.cash','Instrument which price is based on quotations of the index reflecting 50 largest European stocks quoted on organized market.','2.2','12:00 am - 10:15 pm, 10:30 pm - 11:00 pm','indices'),(10,'FRA40','Instrument which price is based on quotations of the contract for index reflecting 40 largest French stocks quoted on the French regulated market.','1.2','8:00 am - 10:00 pm','indices');
/*!40000 ALTER TABLE `indexes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_stamp` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'','creation of new user','2019-04-18 11:49:02','User  with IP: 127.0.0.1 create user: admin3'),(2,'','modify of new user','2019-04-18 11:55:40','User  with IP: 127.0.0.1 try modify invalid user:  !!User not found'),(3,'','modify of new user','2019-04-18 12:44:27','User  with IP: 127.0.0.1 try modify invalid user:  !!User expired'),(4,'','modify of new user','2019-04-18 12:45:56','User  with IP: 127.0.0.1 try modify invalid user: admin3 !!User expired'),(5,'','login','2019-04-18 14:06:10','User admin2 with IP: 127.0.0.1 has been logged in '),(6,'','login','2019-04-18 14:06:28','User admin2 with IP: 127.0.0.1 fail login! Wrong credentials '),(7,'','login','2019-04-18 14:19:51','User admin2 with IP: 127.0.0.1 has been logged in '),(8,'','login','2019-04-18 14:20:05','User admin2 with IP: 127.0.0.1 has been logged in '),(9,'','login','2019-04-18 14:33:17','User admin2 with IP: 127.0.0.1 has been logged in '),(10,'','login','2019-04-18 14:45:48','User admin2 with IP: 127.0.0.1 has been logged in '),(11,'','login','2019-04-18 14:46:08','User admin2 with IP: 127.0.0.1 has been logged in '),(12,'','login','2019-04-18 14:46:31','User admin2 with IP: 127.0.0.1 has been logged in '),(13,'','login','2019-04-18 14:48:50','User admin2 with IP: 127.0.0.1 has been logged in '),(14,'','login','2019-04-18 15:12:52','User admin2 with IP: 127.0.0.1 has been logged in '),(15,'','login','2019-04-18 15:16:44','User admin2 with IP: 127.0.0.1 has been logged in '),(16,'','login','2019-04-18 15:17:31','User admin2 with IP: 127.0.0.1 has been logged in '),(17,'','login','2019-04-18 15:18:28','User admin2 with IP: 127.0.0.1 has been logged in '),(18,'','login','2019-04-18 15:18:46','User admin2 with IP: 127.0.0.1 has been logged in '),(19,'','login','2019-04-18 15:18:54','User admin2 with IP: 127.0.0.1 has been logged in '),(20,'','login','2019-04-18 15:21:23','User admin2 with IP: 127.0.0.1 has been logged in '),(21,'','login','2019-04-18 15:22:15','User admin2 with IP: 127.0.0.1 has been logged in '),(22,'','login','2019-04-18 15:22:28','User admin2 with IP: 127.0.0.1 has been logged in '),(23,'','login','2019-04-18 15:22:39','User admin2 with IP: 127.0.0.1 has been logged in '),(24,'','login','2019-04-18 15:23:53','User admin2 with IP: 127.0.0.1 has been logged in '),(25,'','login','2019-04-18 15:42:56','User admin2 with IP: 127.0.0.1 has been logged in '),(26,'','login','2019-04-18 15:43:09','User admin2 with IP: 127.0.0.1 has been logged in ');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authorized` tinyint(4) NOT NULL,
  `temp_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','facexperiencia@gmail.com','admin','$2y$10$d4wT1bq10x5psGbvqiZdcOVa6/s.j/DcaQB4WLtv4bprNJ0wrlC4O','2019-04-18 09:34:29','2019-04-18 09:34:29',0,NULL),(2,'admin2','facexperiencia@gmail.com','admin2','$2y$10$KRwMY18kE3OseIu.wm5R6.3/aYyOZ1Ij3fJifSWrL6QZq3SIZogaO','2019-04-18 15:43:09','2019-04-18 10:29:50',1,'c84258e9c39059a89ab77d846ddab909'),(3,'admin3','facexperiencia@gmail.com','admin3','$2y$10$0hCnXYArN9MOg8TX/TRE/.DYGyXd7jNi/9OdDhACJta1PLF5ByLXu','2019-04-18 11:48:59','2019-04-18 11:48:59',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-18 16:02:09
