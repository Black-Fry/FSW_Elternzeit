-- MySQL dump 10.13  Distrib 5.6.45, for Linux (x86_64)
--
-- Host: database-5006311188.webspace-host.com    Database: dbs5269035
-- ------------------------------------------------------
-- Server version	5.7.36-log

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
-- Table structure for table `Tab_Einsaetze`
--

DROP TABLE IF EXISTS `Tab_Einsaetze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tab_Einsaetze` (
  `EinsatzID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `FamID` tinyint(4) NOT NULL COMMENT 'Fremdschluessel aus Tab_Familien',
  `ZweckID` tinyint(4) DEFAULT NULL COMMENT 'Fremdschluessel aus Tab_Einsatzzwecke',
  `EinsatzDate` date DEFAULT NULL,
  `EinsatzLength` decimal(3,1) DEFAULT '0.0',
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'AutoUpdateOnChange',
  `Kommentar` char(200) DEFAULT NULL COMMENT 'MaxLength200Chars',
  PRIMARY KEY (`EinsatzID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tab_Einsaetze`
--

LOCK TABLES `Tab_Einsaetze` WRITE;
/*!40000 ALTER TABLE `Tab_Einsaetze` DISABLE KEYS */;
INSERT INTO `Tab_Einsaetze` VALUES (1,1,1,'2021-12-07',1.5,'2022-01-23 18:39:40','nix besonderes'),(2,1,1,'2021-12-15',0.5,'2022-01-23 16:36:14','putzen'),(3,2,3,'2021-11-08',2.0,'2022-01-23 16:38:39',NULL),(4,2,3,'2021-11-09',0.5,'2022-01-23 16:38:39',NULL),(5,3,2,'2022-01-21',21.0,'2022-02-01 18:33:01','echt lange'),(6,4,8,'2022-01-14',2.5,'2022-01-23 18:39:20','FSW Elternzeit: Webrecherche Konzeption, Gedanken sammeln'),(7,4,8,'2022-01-15',2.0,'2022-01-23 18:39:26','FSW Elternzeit: Konzeption, Gedanken sammeln'),(8,4,8,'2022-01-17',1.0,'2022-01-23 18:41:13','FSW Elternzeit: DB-Design & Umsetzung'),(9,4,8,'2022-01-19',1.0,'2022-01-23 18:41:02','FSW-Elternzeit: Mockup (User-, Admin-View)'),(10,4,8,'2022-01-23',4.0,'2022-01-23 19:55:28','FSW Elternzeit: php-Klassen-Design, Beginn Implementierung funktionale Views (Admin-View)'),(11,4,8,'2022-01-24',1.0,'2022-01-25 19:37:02','FSW Elternzeit: admin View V1 weitestgehend abgeschlossen (Ansicht MySQL-Felder in HTML-Tabelle)'),(12,4,8,'2022-01-25',1.0,'2022-01-25 19:55:42','FSW Elternzeit: admin View - Funktion \"neue Zeile\" abgeschlossen (MySQL new Row & Page refresh)'),(13,4,8,'2022-01-27',1.0,'2022-01-27 17:57:00','FSW Elternzeit: admin-View (Namenssuche, glowin Input-Fields)'),(14,4,8,'2022-02-01',1.0,'2022-02-01 18:34:14','FSW-Elternzeit, Admin-View: Column \"Pensum Erfuellt\"'),(15,4,8,'2022-01-28',1.0,'2022-02-01 18:36:16','FSW-Elternzeit: bgQueries.php zum Aufruf im Hintergrund durch JS implementiert (aktualisiert DB im Hintergrund beim Fire eines Input-onChange()-Events)'),(16,8,4,'2022-02-01',20.0,'2022-02-01 18:38:32','check whether +/- Null wird auch als \"Pensum erfüllt\" angezeigt'),(17,4,8,'2022-02-02',1.0,'2022-02-02 19:37:59','FSW Elternzeit, JS Ajax-/JSON-background Query: handover data in the background from js to db_access/bgQuery.php'),(18,4,8,'2022-02-05',1.5,'2022-02-06 12:39:35','FSW Elternzeit: HTML-Klassen reorganisiert (abstract), Feature \'Zeilen löschen\' im Admin-View integriert (finde alle markierten Inputs, sortiere h >0 aus)'),(19,4,8,'2022-02-06',1.0,'2022-02-06 13:28:49','FSW Elternzeit, adminView: Button \'lösche Zeile/n\' abgeschlossen');
/*!40000 ALTER TABLE `Tab_Einsaetze` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tab_Einsatzzwecke`
--

DROP TABLE IF EXISTS `Tab_Einsatzzwecke`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tab_Einsatzzwecke` (
  `ZweckID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ZweckNam` char(120) DEFAULT NULL,
  PRIMARY KEY (`ZweckID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tab_Einsatzzwecke`
--

LOCK TABLES `Tab_Einsatzzwecke` WRITE;
/*!40000 ALTER TABLE `Tab_Einsatzzwecke` DISABLE KEYS */;
INSERT INTO `Tab_Einsatzzwecke` VALUES (1,'AG Haus & Garten'),(2,'AG Hauswirtschaft'),(3,'AG Material'),(4,'AG Öffentlichkeitsarbeit'),(5,'AK IT/Technik'),(6,'AK Veranstaltungen'),(7,'AK Gesunde Ernährung'),(8,'Andere Unterstützung');
/*!40000 ALTER TABLE `Tab_Einsatzzwecke` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tab_Familien`
--

DROP TABLE IF EXISTS `Tab_Familien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tab_Familien` (
  `FamID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `FamNam` char(80) DEFAULT NULL,
  `CryptURL` char(64) DEFAULT NULL COMMENT 'Teil des Sharelinks. Wird im PHP erzeugt',
  `Single` tinyint(1) NOT NULL DEFAULT '0',
  `FamMailOne` char(100) DEFAULT NULL,
  `FamMailTwo` char(100) DEFAULT NULL,
  PRIMARY KEY (`FamID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tab_Familien`
--

LOCK TABLES `Tab_Familien` WRITE;
/*!40000 ALTER TABLE `Tab_Familien` DISABLE KEYS */;
INSERT INTO `Tab_Familien` VALUES (1,'Müller','wWxtSfuWTsKnPTeC',0,'mueller@muell.org',NULL),(2,'Meier','EErW6uxW82YhV8PF',1,'frau_meier@gmail.com','herr_meier@gmail.com'),(3,'Lehmann','mgbk68EUHzJjMkEn',1,'lehmann1@web.de','lehmann2@web.de'),(4,'Burwitz, Röder','qpC9fu9VhP4DWE8j',0,'elisabeth.burwitz@gmail.com','mi@ossoelmi.berlin'),(8,'Däubler-Gmehlin','CYi6jPc8gknlXHfw',1,'mail@mail.de','');
/*!40000 ALTER TABLE `Tab_Familien` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-06 15:40:15
