-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: projetcv
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiants`
--

LOCK TABLES `etudiants` WRITE;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` VALUES (1,'Doe','Johny','$2y$10$oqOiSxunCisxxSg6uAN63O5ltqM0ZW7biAEqGsxLxYgEdzy466TEq','doe@gmail.com',NULL,NULL),(2,'Tang','Denis','$2y$10$6tkjMXmE9YukOUuuLxPWiuQSXfAHfc9Or8bYb0Oj93dMNMrbI7PQK','tang@yahoo.com',NULL,NULL),(4,'Bondou','Collette','$2y$10$EK4Ij1zvMcHQlav9iOvZ4OOKixRu5zaWb8m9QneiOVh9bybDfnACW','collette@gmail.com',NULL,NULL),(5,'Didi','Angelo','$2y$10$uO4NNQN7yRE006SJGCwtqu.aOaOOoEmRNhv3qlWmm3blZisrbU23a','didi@yahoo.fr',NULL,NULL),(6,'Dupond','Celine','$2y$10$ahv6bow2hyo/ag82tJzf8eMXK7gCGADeJpOQ/THEig/4dPtqdQpHi','dupond@outlook.uk',NULL,NULL),(7,'Déniché','Laurent','$2y$10$qm4ZY8proo303frfx7g8G.buMPfwLWmGxWbRqM2/S1c9FejSabQpq','deniche@yahoo.fr',NULL,NULL),(8,'Daouda','kanté','$2y$10$4fyPlIyLxMgguLI8/WDLz.4Mp/vOW4LS4OjM0NjyKS8sUBLMnJtSm','kante@live.com',NULL,NULL),(9,'Dibango','Manu','$2y$10$eCrKc5XfgiyTYLrndQgY2.dGFPEbC1nEm3eTwhat3LziUk6yVW4rm','diango@livtv.com',NULL,NULL),(10,'Drogba','Didier','$2y$10$wDd1EK1shUrbr4qDYfrvW.kCq3Yv3atqCgC/XeGIglvEkJwoSTvPS','didier@yahoo.fr',NULL,NULL),(11,'Neymar','Junior','$2y$10$bjHWpCSeLvhAdowG8SiC/.aCn2CPw81pw9cZljWJETyxfnPQcC8KK','junior@gmail.com',NULL,NULL),(12,'Toti','André','$2y$10$Wsn82n6ObLqkVBpK6HPdJu1hmoEXctwkTA6Ghv8b3Xbf6VdGqO9Ta','toti@outlook.uk',NULL,NULL),(13,'Aléanzo','Rodrigo','$2y$10$FKCeVm.qaiyd8B96I47QY.aXTFymrsFX0ncrkYcvMCaEMNsYURdpW','rodrigo@hotmail.fr',NULL,NULL),(14,'Emma','Lefebvre','$2y$10$JEeevCHaKOXZTxAZivyn8uD90cLwoOWIidy72hjq3jLWeEm6V32T6','emma@gmail.com',NULL,NULL),(15,'Lucas','Martin','$2y$10$Lj37TrHXjBSWddims.VLuOyHB3.S7OFzAg6yXxps7zbO6q7oB8Y8W','martin@hotmail.com',NULL,NULL),(16,'Chloé','Dupont','$2y$10$K6zaPfuZt.2M8Wgnpn6TruxASDAMTQ/jxv4SWEvjRqEfLpVkDd37e','dupont@gmail.com',NULL,NULL),(17,'Hugo','Bernard','$2y$10$R9gWuBP5aN0Ly2tC5q/R6Oy/Yd8.emft1JIpJGeFk9zyQdA4eEMPi','bernard86@gmail.com',NULL,NULL),(18,'Alice','Petit','$2y$10$R4I.PG2ITP6GFWeI5hIUIeTle5VDaziOtAcQS51jOUUn0LLdUwlZ.','petit@gmail.com',NULL,NULL),(19,'Nathan','Durand','$2y$10$iidDwcdHEQguTIeQJiS8ee5pVOaMdRpaY.k0F9ZDJTTcTWpcI8GLW','durand-fr@hotmail.com',NULL,NULL),(20,'Léa','Leroy','$2y$10$EVW7SZ7dTJlTp7igPWV.jOxHP.El/pcLLeMMk.qEoh.26uQY/vPpi','leroy@gmail.com',NULL,NULL),(21,'Gabriel','Moreau','$2y$10$QnK6UrCUYd7V.9iUWdcpte/Qkf1VgA4NaTUerr3Du52HHsIE2Aw5S','moreau125@gmail.com',NULL,NULL),(22,'Zoé','Simon','$2y$10$EsBXvJcTtE.qC2IuzE1.4.i0Oiu9choZSQFpk2M.duseCavgOOgQC','simon-zoe@outlook.uk',NULL,NULL),(23,'Louis','Laurent','$2y$10$5Cl1zVcm/ne/CZwPAEmiIeDVWTK9jKWAJtwuaqF.xpabMkO.gFLYu','louislau@gmail.com',NULL,NULL),(24,'Mercier','Juliette','$2y$10$UX3mYj1WxlrB/01jVjexAOm6Z5lm1P6ytrxUeu8AntcHA7aiTtS7a','juliette25@gmail.com',NULL,NULL),(25,'Jules','David','$2y$10$jJI23Ngn4Hvi5PkBnFmEe.iEc6u0GMFVUK/0p5YLGz7PeGE1nL1wy','davidjules@gmail.com',NULL,NULL),(26,'Leboss','Paterne','$2y$10$TQ8mBCLBHGegG/QKnVE0YOqFrmaV4HK/dlp/tC/TfX9RNn6gJ8iv.','paterne81@hotmail.fr','22e243458dead7e528ea87e63f5a40d10957fe33585affccfd5ad23b5cfe60bf105e270414041f9aa85df8e021c9cb2bf89e',NULL);
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-13  9:44:52
