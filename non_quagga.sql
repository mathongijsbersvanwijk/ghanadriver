-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: ghanadriver
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `dvla_applications`
--

DROP TABLE IF EXISTS `dvla_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvla_applications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dvla_center` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_option` enum('CASH','MTN_MOMO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dvla_applications_user_id_foreign` (`user_id`),
  CONSTRAINT `dvla_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvla_applications`
--

LOCK TABLES `dvla_applications` WRITE;
/*!40000 ALTER TABLE `dvla_applications` DISABLE KEYS */;
INSERT INTO `dvla_applications` VALUES (1,1,'German Schmitt DDS','B','Koforidua','Standard','MTN_MOMO','I like\"!\' \'You might just as well. The twelve jurors were writing down \'stupid things!\' on their hands and feet at the Cat\'s head began fading away the time. Alice had got burnt, and eaten up by a.','2020-05-03 07:52:05','2020-05-03 07:52:05'),(2,1,'asd','B','Aburi','Premium','MTN_MOMO',NULL,'2020-05-03 07:53:15','2020-05-03 07:53:15'),(3,1,'New Driving License','B','Takoradi','Prestige','MTN_MOMO',NULL,'2020-05-03 11:03:32','2020-05-03 11:03:32');
/*!40000 ALTER TABLE `dvla_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtn_momo_tokens`
--

DROP TABLE IF EXISTS `mtn_momo_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtn_momo_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` text COLLATE utf8mb4_unicode_ci,
  `token_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bearer',
  `product` enum('collection','disbursement','remittance') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtn_momo_tokens`
--

LOCK TABLES `mtn_momo_tokens` WRITE;
/*!40000 ALTER TABLE `mtn_momo_tokens` DISABLE KEYS */;
INSERT INTO `mtn_momo_tokens` VALUES (1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6IjYwOTQwYTRjLTk3YjUtNGM2Ni04ZmUzLTY3MGVlMTFmMzQ2MSIsImV4cGlyZXMiOiIyMDIwLTA1LTAzVDEwOjUzOjE1Ljk5NCIsInNlc3Npb25JZCI6IjhhYzE5YmQxLTExNWYtNDk3MC1iMWYwLTM3NzNjNmJhNGNkMyJ9.XNB1toAaT96cXHGC1QpxKs64O5gYn4Z6WZzlbU7hEC9qPPioL8x8KspeQwPQAnS3MtRVOKvbJVb5uZPmiVVhgt-zyCYgjTu2AEgIJa2i7COzIEjD6mquPPEDY0lzzqDRkk5wLy2gcnMM_kVCH1OKoB5k_JwPwEKEAbqDVISR20J-qe0_YhbZ0MPD9UUu9qwbTVTBsfXZhKHm_LQ1w1JYfavXOhpepJIYu6cgiWni8rH_Qu9EhnxuDkNMSBsX-pND27-23cdWHLnKrwlsNO-RgfWrQiQU_0NTiapwD72OtPAMMrmQbp_T95Ww0Cn56MMmLIr4zhPZ75zVyANkU2hr3w',NULL,'Bearer','collection','2020-05-03 07:53:16','2020-05-03 07:53:16','2020-05-03 08:53:16',NULL),(2,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6IjYwOTQwYTRjLTk3YjUtNGM2Ni04ZmUzLTY3MGVlMTFmMzQ2MSIsImV4cGlyZXMiOiIyMDIwLTA1LTAzVDE0OjAzOjMzLjMyNiIsInNlc3Npb25JZCI6ImM2YzczZTg3LTU1NjItNDNmNi1iYmE2LWZkYTg2NDUxYzBlMiJ9.N2-lzippponguNvVUnBn6DWei0YLn0U4J6flbRYj23GkRDJDrpx-aQ6up8FmG4wvXaT0tLqRVs5RuJm-2bdTLXoitQIHqglbRBHLkn-QrcpYQ12dbkPhUQIyoyXM8_n2bBA8UxwW_iJxIYdUHyITdzMAoSfPVmXVbdqyEQE6ZyKfJuVFAnq2BecIujLbA3YPkECxRWBt227lMjoHCn_kIiFw6orhYzgRzjsLg7bd_7QHTERvyBn4jCG6l1XlZdSgz9Vs0omtG_-DP63eHhgdil3FUGJkMUp4S1nf9BtDYRbZE8CRhqUVTVxSu18bXoYVLVR2k6LMwaiT3zOvUXLlCA',NULL,'Bearer','collection','2020-05-03 11:03:33','2020-05-03 11:03:33','2020-05-03 12:03:33',NULL);
/*!40000 ALTER TABLE `mtn_momo_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dvla_application_id` bigint(20) unsigned NOT NULL,
  `momo_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PENDING','FAILED','SUCCESSFUL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EUR',
  `payer_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payee_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_dvla_application_id_foreign` (`dvla_application_id`),
  CONSTRAINT `payments_dvla_application_id_foreign` FOREIGN KEY (`dvla_application_id`) REFERENCES `dvla_applications` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,2,'dc8ecb09-150b-45a2-a2f8-e4c9b79d503d','907482498','SUCCESSFUL',NULL,100.00,'EUR','Payment requested from client ','Payment for DVLA registration','2020-05-03 07:53:15','2020-05-03 07:53:16'),(2,3,'4fc0284a-34af-4347-88f1-3184b5959c0d','2032027711','SUCCESSFUL',NULL,10.00,'EUR','Payment requested from client ','Payment for DVLA registration','2020-05-03 11:03:32','2020-05-03 11:03:33'),(3,3,'916ac951-d909-4716-af88-a231f2de66dd','1278287494','SUCCESSFUL',NULL,10.00,'EUR','Payment requested from client ','Payment for DVLA registration','2020-05-03 11:05:12','2020-05-03 11:05:13'),(4,3,'5248f262-6459-4e87-99c5-1edc7da09b83','532763256','SUCCESSFUL',NULL,10.00,'EUR','Payment requested from client ','Payment for DVLA registration','2020-05-03 11:06:56','2020-05-03 11:06:56');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ADMIN'),(2,'MEMBER');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,2,'Dr. Demond O\'Kon','sierra.brown@example.org','2020-05-03 07:52:05','$2y$10$BFzsynE/t9KWscMfu3YuKeZ7qclHhS/m1duPxoauGkKGuUJBAVpNy','+3006742234154','JQgxhDvupdNI8stOD3OGHxVSOhnsbiG8bprdHad0RF7QNoxgJjEWA5J60d8M','2020-05-03 07:52:05','2020-05-03 07:52:05'),(2,2,'mathon','mathon@xs4all.nl',NULL,'$2y$10$TaUkRZdjEksqDaTOyfed4.YBpsj23Mb/nJZ4Yd4ZZ3XJDEPvsd1y2','0123412345','MndS7wFNIXxzqvnPGwtBH3kEAVBmTgWAgRKP05FAvP3CmYOMqc7KmCxpBx6y','2020-05-05 06:12:42','2020-05-05 06:12:42');
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

-- Dump completed on 2020-05-05 10:21:59
