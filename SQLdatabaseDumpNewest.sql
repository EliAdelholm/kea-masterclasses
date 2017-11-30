-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: kea_masterclasses
-- ------------------------------------------------------
-- Server version	5.5.41-log

use kea_masterclasses;

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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` char(1) DEFAULT NULL,
  KEY `fk_users_events_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_events_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `password` varchar(45) NOT NULL,
  `notification` tinyint(4) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'A','A',1,'assets/img/userimage-5a1bf0ed5cc39.png',NULL,0),(2,'A','A',0,'assets/img/userimage-5a1bf0fb4ae17.png',NULL,0),(3,'B','F',1,'assets/img/userimage-5a1c0402690aa.jpg',NULL,1),(4,'','',0,'assets/img/userimage-5a1d2d0e1ccbc.',NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_emails`
--

DROP TABLE IF EXISTS `users_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_emails` (
  `email` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `fk_users_email_users` (`user_id`),
  CONSTRAINT `fk_users_email_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_emails`
--

LOCK TABLES `users_emails` WRITE;
/*!40000 ALTER TABLE `users_emails` DISABLE KEYS */;
INSERT INTO `users_emails` VALUES ('A',1),('A',2),('F',3),('',4);
/*!40000 ALTER TABLE `users_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_interests`
--

DROP TABLE IF EXISTS `users_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_interests` (
  `users_id` int(11) NOT NULL,
  `interests` varchar(45) NOT NULL,
  KEY `fk_users_interests_users1_idx` (`users_id`),
  CONSTRAINT `fk_users_interests_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_interests`
--

LOCK TABLES `users_interests` WRITE;
/*!40000 ALTER TABLE `users_interests` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_phones`
--

DROP TABLE IF EXISTS `users_phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_phones` (
  `users_id` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  KEY `fk_users_phone_users1` (`users_id`),
  CONSTRAINT `fk_users_phone_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_phones`
--

LOCK TABLES `users_phones` WRITE;
/*!40000 ALTER TABLE `users_phones` DISABLE KEYS */;
INSERT INTO `users_phones` VALUES (1,'2424151'),(2,'2424151'),(3,'G');
/*!40000 ALTER TABLE `users_phones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-28 11:08:07
