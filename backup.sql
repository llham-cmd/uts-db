-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: eventtiket_db3263
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Seminar IT','seminar-it','2026-05-25 20:11:45','2026-05-25 20:11:45'),(2,'Entertainment','entertainment','2026-05-25 20:11:45','2026-05-25 20:11:45'),(3,'Workshop','workshop','2026-05-25 20:11:45','2026-05-25 20:11:45');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `organizer_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `stock` int NOT NULL,
  `poster_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_category_id_foreign` (`category_id`),
  KEY `events_organizer_id_foreign` (`organizer_id`),
  CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `events_organizer_id_foreign` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,1,NULL,'Festival Batik Nusantara','Pameran dan lomba batik dari seluruh penjuru nusantara yang mempertemukan pengrajin dan pecinta budaya.','2026-07-28 04:47:37','Alun-Alun Yogyakarta',25000,200,'posters/Eck6QdPUQqQQXdsPvWpoDGG06ZW1XCsf0IrjtwmB.jpg','2026-05-25 20:11:45','2026-07-29 21:47:45'),(2,2,NULL,'Jazz Night 2026','Nikmati malam yang indah dengan alunan musik jazz yang merdu bersama musisi ternama.','2026-09-23 19:00:00','Amikom Kampus 2',50000,100,'posters/bpQ97aaLoTJ4YWk2iL7DvNYIfaWmj6HLQaQApKKM.jpg','2026-05-25 20:11:45','2026-07-14 00:56:14'),(3,1,NULL,'Seminar Teknologi AI 2026','Seminar nasional membahas perkembangan kecerdasan buatan dan dampaknya bagi dunia industri.','2026-08-01 08:00:00','Cinema',75000,150,'posters/5E2KZMp1UEqEqADaRMqSbuSpB7ms3aCjBYih1R8d.jpg','2026-05-25 20:11:45','2026-06-19 00:18:10'),(4,2,NULL,'Valorant Champions Tour Pacific','Nobar Tim IndonesiaTurnamen Valorant Champions tour Pacific','2026-08-10 10:00:00','Cinema',0,300,'posters/Ao1k97abx8rZiC99OnmP1runcJX1aBBLw2eFlcCb.jpg','2026-05-25 20:11:45','2026-06-19 00:19:43'),(5,3,NULL,'UI/UX Masterclass','Workshop intensif desain UI/UX bersama praktisi industri, dari wireframe hingga prototype interaktif.','2026-08-20 08:00:00','Lab Komputer G.2.4.1',35000,58,'posters/zFVaw34BHGLaIGXjQoJPD9brKsQvTqSqJiaHyfwb.jpg','2026-05-25 20:11:45','2026-07-15 05:52:43'),(6,3,NULL,'Workshop Digital Marketing','Belajar strategi pemasaran digital bersama praktisi berpengalaman untuk mengembangkan bisnis Anda.','2026-09-23 08:30:00','Lab Komputer G.2.4.2',100000,80,'posters/BbiSkon16Tetp6c4v09000srAzU65tIz1DABwTsS.jpg','2026-05-25 20:11:45','2026-07-14 00:55:57'),(11,2,NULL,'Nobar Timnas Indonesia','stok tiket terbatas','2026-09-23 18:30:00','Didepan Gedung 7',0,298,'posters/ebE40XwNlQwtWRitMJFn6W7kpA5V8jNTS5R3TsXI.jpg','2026-07-28 04:32:47','2026-07-29 20:38:11'),(13,2,3,'NOBAR INDONESI VS ARAB SAUDI',NULL,'2026-07-29 05:11:00','Depan Gedung 7',0,294,'posters/g5hKTwo0Ge4tpfvoiNo6pkoSOHUNEV2OBh4tj6W5.jpg','2026-07-29 21:28:51','2026-07-29 22:33:53'),(14,2,3,'nobar timnas indo vs uzbek',NULL,'2026-07-28 12:03:00','Depan Gedung 7',0,249,'posters/MN0QSNo1dZ3BZw03J83viGSK8TAjgujOL427PxOK.jpg','2026-07-29 22:51:39','2026-07-29 22:56:46'),(15,2,3,'nobar timnas indo vs china',NULL,'2026-07-30 12:52:00','Depan Gedung 7',0,199,'posters/B90BXJRzeZOxuqfbWYfc5AsGyYsMyHxE35BNNeIg.jpg','2026-07-29 22:52:35','2026-07-30 01:34:16'),(16,2,3,'nobar timnas indo vs jepang',NULL,'2026-07-30 18:58:00','Depan Gedung 7',0,400,'posters/ipBJgDQBwKxhF6gm04YKxvdiJfonrd3VKDJyeFMq.jpg','2026-07-29 22:53:10','2026-07-29 22:53:10');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jabatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan`
--

LOCK TABLES `jabatan` WRITE;
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (1,'manager','Admin Amikom',NULL,'2026-07-15 18:01:17','2026-07-15 18:01:17'),(2,'ceo','Admin Amikom',NULL,'2026-07-15 18:07:12','2026-07-15 18:07:12');
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_28_075004_create_categories_table',1),(5,'2026_04_28_075053_create_events_table',1),(6,'2026_04_28_075439_create_transaction_table',1),(7,'2026_05_26_043146_create_partners_table',2),(8,'2026_07_16_003033_create_jabatan_table',3),(9,'2026_07_16_003135_create_pengurus_table',3),(10,'2026_07_28_092538_create_organizers_table',4),(11,'2026_07_28_092615_add_organizer_id_to_events_table',4),(12,'2026_07_29_133501_add_google_fields_to_users_table',5),(13,'2026_07_30_035828_create_reviews_table',6),(14,'2026_07_30_065455_add_checkin_fields_to_transactions_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizers`
--

DROP TABLE IF EXISTS `organizers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizers_user_id_unique` (`user_id`),
  UNIQUE KEY `organizers_slug_unique` (`slug`),
  CONSTRAINT `organizers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizers`
--

LOCK TABLES `organizers` WRITE;
/*!40000 ALTER TABLE `organizers` DISABLE KEYS */;
INSERT INTO `organizers` VALUES (1,1,'Test','test',NULL,NULL,1,'2026-07-28 02:32:26','2026-07-28 03:58:16'),(2,5,'blubca','blubca-xpEc3',NULL,NULL,1,'2026-07-28 03:22:36','2026-07-28 03:23:23'),(3,6,'hh','hh-9QpMS',NULL,NULL,1,'2026-07-28 04:12:53','2026-07-28 04:13:47');
/*!40000 ALTER TABLE `organizers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'AMIKOM','https://img.favpng.com/5/22/0/university-of-amikom-yogyakarta-yogyakarta-state-university-logo-png-favpng-5GHfGHkU6UBe6pghA2Z9HZ6xq.jpg','2026-05-25 21:58:44','2026-05-25 22:00:18'),(2,'Bank Central Asia','https://i.pinimg.com/736x/45/fd/74/45fd7472cebbfe3d4a4217aac009aad6.jpg','2026-05-25 22:00:05','2026-06-03 18:08:09'),(3,'BRI','https://e7.pngegg.com/pngimages/965/702/png-clipart-logo-bank-rakyat-indonesia-graphics-brand-product-design-blue-cdr-thumbnail.png','2026-05-25 22:01:51','2026-05-25 22:01:51');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengurus`
--

DROP TABLE IF EXISTS `pengurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengurus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jabatan_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` decimal(15,2) NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengurus_jabatan_id_foreign` (`jabatan_id`),
  CONSTRAINT `pengurus_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengurus`
--

LOCK TABLES `pengurus` WRITE;
/*!40000 ALTER TABLE `pengurus` DISABLE KEYS */;
INSERT INTO `pengurus` VALUES (2,1,'mahli','sddhjscbdihcusjd',20000000.00,'Admin Amikom','Admin Amikom','2026-07-15 18:06:18','2026-07-15 18:06:57');
/*!40000 ALTER TABLE `pengurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_event_id_user_id_unique` (`event_id`,`user_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,13,7,1,'top','2026-07-29 22:25:59','2026-07-29 22:25:59'),(2,13,9,1,'gokil','2026-07-29 22:30:25','2026-07-29 22:30:25'),(3,13,8,1,'hiya','2026-07-29 22:34:12','2026-07-29 22:34:12'),(4,14,8,5,'jos','2026-07-29 22:56:55','2026-07-29 22:56:55');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('IX9u4fVSvSArKg17QeazVCM9wJeP5OqE0LyoNmx1',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJTMFJMNzVXZEg4U3p5U2NKd0g4NUFzQUNreDZTSlM1U3V6QldaRnBOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6N30=',1785400491),('w8G9d6norhsWv1szX1vCAoLmGQ5gZZIU2KDcDmMo',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJGQ2NDeWRuZXJ0d1FnRjlSSU9FUEU0ajVHVm9Hb3VDblFEMVpKVXhtIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvY2hlY2tpbiIsInJvdXRlIjoiYWRtaW4uY2hlY2tpbi5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1785400595);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `is_checked_in` tinyint(1) NOT NULL DEFAULT '0',
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_in_by` bigint unsigned DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_order_id_unique` (`order_id`),
  UNIQUE KEY `transactions_ticket_code_unique` (`ticket_code`),
  KEY `transactions_event_id_foreign` (`event_id`),
  KEY `transactions_checked_in_by_foreign` (`checked_in_by`),
  CONSTRAINT `transactions_checked_in_by_foreign` FOREIGN KEY (`checked_in_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,'TRX-1781934988-HsbMT','a0adcabd-c37f-4eca-9052-0ee490af9b03','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 22:56:28','2026-07-30 00:06:45'),(2,1,'TRX-1781935449-Y5QWS','d36de89d-3a71-4325-b77e-ea7f0cf0301f','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:04:09','2026-07-30 00:06:45'),(3,1,'TRX-1781935581-vIojC','265e7381-36cf-4f3e-83e1-dccae1cfbfa7','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:06:21','2026-07-30 00:06:45'),(4,1,'TRX-1781935866-SexHd','a0a8bc95-9cb8-4132-9e71-931eecaa5f61','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:11:06','2026-07-30 00:06:45'),(5,1,'TRX-1781935967-NhyLU','b538ad47-34f3-4f44-834f-026eaed1dad5','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:12:47','2026-07-30 00:06:45'),(6,1,'TRX-1781936247-t172L','e18a3795-66df-40c1-90ad-428cbd9003d3','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:17:27','2026-07-30 00:06:45'),(7,1,'TRX-1781936445-nscH3','0fb20f01-a041-48f1-b17c-2d1815efdb75','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:20:45','2026-07-30 00:06:45'),(8,1,'TRX-1781936538-HzKXK','f5644bd9-a951-4235-926d-6b60bb87b429','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:22:18','2026-07-30 00:06:45'),(9,1,'TRX-1781936605-6YKch','b8e49ed5-d287-45ea-9b3a-def341c7dc4a','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:23:25','2026-07-30 00:06:45'),(10,1,'TRX-1781936656-1B1lN','af4fa06f-86b6-4cd9-99b1-f6f9ad5d7aa0','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:24:16','2026-07-30 00:06:45'),(11,1,'TRX-1781936876-8zHJc','627394c0-d9f0-4c54-a4ef-871cd62c4a0c','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:27:56','2026-07-30 00:06:45'),(12,1,'TRX-1781937128-dxpRj','b1416ebb-59a0-48ce-8b14-fbd6d35a235c','m nur illham','illham@gmail.com','083569462713',30000,'Pending',0,NULL,NULL,NULL,'2026-06-19 23:32:08','2026-07-30 00:06:45'),(13,1,'TRX-1781938952-BSIGF','16ee26c4-ea68-41a9-8956-08384c7bcb66','m nur illham','illham@gmail.com','083569462713',30000,'success',0,NULL,NULL,NULL,'2026-06-20 00:02:32','2026-07-30 00:06:45'),(14,1,'TRX-1781939580-oA1Qb','7197a4a7-0213-47d9-8e1d-36383502a353','tukiyem','tukiyem@gmail.com','083569462714',30000,'success',0,NULL,NULL,NULL,'2026-06-20 00:13:00','2026-07-30 00:06:45'),(15,4,'TRX-1784017244-D88Cs','3eb3f613-7c0c-4f24-bace-4a728472866a','nuur','nur@gmail.com','032165498777',5000,'pending',0,NULL,NULL,'b3e2fdcc-97bb-4c65-a1ff-f2cda7ef2aec','2026-07-14 01:20:44','2026-07-30 00:06:45'),(16,4,'TRX-1784017293-AWOvX','50cefe43-81ad-41ed-8dcf-b7cfbd371356','nuur','nur@gmail.com','032165498777',5000,'pending',0,NULL,NULL,'1868fe54-2177-4a1c-aa63-296852d40698','2026-07-14 01:21:33','2026-07-30 00:06:45'),(17,3,'TRX-1784017866-tik57','d47d32c4-86de-4635-8cbc-84d43128faec','nuur','nur@gmail.com','032165498777',80000,'success',0,NULL,NULL,'b49a300f-7121-40fb-8f30-35858ff5157f','2026-07-14 01:31:06','2026-07-30 00:06:45'),(18,3,'TRX-1784018022-CJxvC','87d6018f-fce1-476f-a430-40c215544e4c','nuur','nur@gmail.com','032165498777',80000,'settlement',0,NULL,NULL,'08f260c9-4b22-4b47-913a-4db62de91c7f','2026-07-14 01:33:42','2026-07-30 00:06:45'),(19,3,'TRX-1784018190-YxLDf','f23f3d2d-5226-4de2-8d04-300ade190f0d','nuur','nur@gmail.com','032165498777',80000,'success',0,NULL,NULL,'0ae6ba1f-109d-4836-9bc9-855b42594db7','2026-07-14 01:36:30','2026-07-30 00:06:45'),(20,6,'TRX-1784022587-UgWLF','378d2368-fa0f-4916-b651-ae19b0b635e6','sumarti','sumarti@gmail.com','087589645321',105000,'pending',0,NULL,NULL,'950ec69a-10ad-4e61-aed5-27bad675b84f','2026-07-14 02:49:47','2026-07-30 00:06:45'),(21,2,'TRX-1784022669-Nhmt0','19632e9b-ea1d-4192-9d87-bdd49728d30c','numain','numain@gmail.com','0213654987412',55000,'failed',0,NULL,NULL,'31cbe20e-2e91-40fb-baee-0b28bd72d1a3','2026-07-14 02:51:09','2026-07-30 00:06:45'),(22,5,'TRX-1784022734-En5Ac','279eaa16-a53a-4fba-a666-ba024269b307','kuiyan','kuiyan@gmail.com','032165498741',40000,'pending',0,NULL,NULL,'a3dccab8-e9a7-4597-8ad6-3242002681f7','2026-07-14 02:52:14','2026-07-30 00:06:45'),(23,6,'TRX-1784022940-oMnat','0017e152-a070-4013-99c4-95f5d1a43440','illham','illham@gmail.com','087589645321',105000,'success',0,NULL,NULL,'4029f396-10d1-4333-90c7-18504ecc4903','2026-07-14 02:55:40','2026-07-30 00:06:45'),(24,6,'TRX-1784023297-Qrtgh','d9e8db59-3812-40df-a609-21624fb93e96','illham','illham@gmail.com','087589645321',105000,'success',0,NULL,NULL,'4b4594ea-b712-4dae-bf84-0662f75e8376','2026-07-14 03:01:37','2026-07-30 00:06:45'),(25,5,'TRX-1784119056-Q0hdn','61067afd-d005-4170-931e-6a8da7ea0efe','forseken','forseken@gmail.com','087321654987',40000,'success',0,NULL,NULL,'6b2aeb76-4a37-4f80-a678-b72a088e3c8b','2026-07-15 05:37:36','2026-07-30 00:06:45'),(26,5,'TRX-1784119886-raQlR','e2f28f3b-ce51-408a-aa05-2a66597b4044','kaco','kaco@gmail.com','086987654321',40000,'success',0,NULL,NULL,'79c00e39-e025-467e-ba8b-dd1ef5f9dd2d','2026-07-15 05:51:26','2026-07-30 00:06:45'),(27,11,'TRX-1785381940-ZBjjp','24196499-8186-4834-a542-09967183ef9d','illham','illham@gmail.com','083569462713',5000,'pending',0,NULL,NULL,NULL,'2026-07-29 20:25:40','2026-07-30 00:06:45'),(28,11,'TRX-1785382132-RdqtR','0e40aafd-ea94-4ccd-887d-1233d95d21be','illham','illham@gmail.com','083569462713',5000,'success',0,NULL,NULL,'52a5733a-a07c-429e-aa0f-de3f9d0b0f56','2026-07-29 20:28:52','2026-07-30 00:06:45'),(29,11,'TRX-1785382690-OgbYd','4dc791b8-845b-416c-ac27-6b9a2933890b','iam','iam@gmail.com','083569462714',0,'success',0,NULL,NULL,NULL,'2026-07-29 20:38:11','2026-07-30 00:06:45'),(30,13,'TRX-1785385792-RFKYN','299d6a89-8655-4e39-8489-b109aa59f39e','iam','iam@gmail.com','083569462714',0,'success',0,NULL,NULL,NULL,'2026-07-29 21:29:52','2026-07-30 00:06:45'),(31,13,'TRX-1785387398-g4Urt','70a86950-b143-40b0-91b0-fb7b95792ea2','illham','muhammadnurillham@students.amikom.ac.id','083569462713',0,'success',0,NULL,NULL,NULL,'2026-07-29 21:56:38','2026-07-30 00:06:45'),(32,13,'TRX-1785388037-Cb6qo','5abe12df-e872-4232-b9db-ebf0ca0aaf81','3263_MUHAMMAD NUR ILLHAM','muhammadnurillham@students.amikom.ac.id','032165498777',0,'success',0,NULL,NULL,NULL,'2026-07-29 22:07:17','2026-07-30 00:06:45'),(33,13,'TRX-1785389383-nFyTT','9baac33f-fcd9-40e6-8ba6-3aedb5645c8d','iam','muhammadnurillham14@gmail.com','083569462714',0,'success',0,NULL,NULL,NULL,'2026-07-29 22:29:43','2026-07-30 00:06:45'),(34,13,'TRX-1785389476-CTrKS','f3c2542c-98c1-41bc-953a-704787c0002b','nur','muhammadnurillham14@gmail.com','0321654987',0,'success',0,NULL,NULL,NULL,'2026-07-29 22:31:16','2026-07-30 00:06:45'),(35,13,'TRX-1785389596-R5gtX','53cd3cb5-c313-4f52-bc80-bb26b0c5c6f4','yaho yaya','yahoyaya395@gmail.com','032154455251',0,'success',0,NULL,NULL,NULL,'2026-07-29 22:33:16','2026-07-30 00:06:45'),(36,14,'TRX-1785390894-h8jcj','bc86ca61-4502-4ccd-aeac-9ea92401fcf0','oki','yahoyaya395@gmail.com','032165498777',0,'success',0,NULL,NULL,NULL,'2026-07-29 22:54:54','2026-07-30 00:06:45'),(37,15,'TRX-1785400456-TBp0B','5fb8e547-c765-4cfe-9d9c-026ddeaf30f0','yaaaaa','muhammadnurillham@students.amikom.ac.id','083569462714',0,'success',1,'2026-07-30 01:36:35',1,NULL,'2026-07-30 01:34:16','2026-07-30 01:36:35');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Amikom','admin@amikom.ac.id',NULL,NULL,NULL,'$2y$12$grxRHtzOdomyBECSfLBkMuHbmyYtUtv90I.AxdlrUblMvcsCX3oL6','admin',NULL,'2026-05-25 20:11:44','2026-05-25 20:11:44'),(2,'illham','illham@gmail.com',NULL,NULL,NULL,'$2y$12$f6sqHjCNBtr8Up9pgY0GF.efPbBke9Eqhvpb6wEVdKxezEhMNIXWS','user',NULL,'2026-05-25 20:11:44','2026-05-25 20:11:44'),(3,'nur','nur@gmail.com',NULL,NULL,NULL,'$2y$12$D.7gGdKK7sbi3ED1VLsQG..31vGkrJH6Gm2lS84QrLC8dr7l9KNeG','user',NULL,'2026-05-25 20:11:45','2026-05-25 20:11:45'),(4,'muhammad','muhammad@gmail.com',NULL,NULL,NULL,'$2y$12$EGgYhNANNVNThfNn0/eEFOxJ9mZ7ao9b.YK9G5a1ZXseuPvWcdRpO','user',NULL,'2026-05-25 20:11:45','2026-05-25 20:11:45'),(5,'BLUBCA','blubca@gmail.com',NULL,NULL,NULL,'$2y$12$po3I9NfxwjBjPYHjcR1ENODhHCKdvlc/Doj3KakayIpmIINu5mFoa','organizer',NULL,'2026-07-28 03:22:36','2026-07-28 03:22:36'),(6,'hh','hh@gmail.com',NULL,NULL,NULL,'$2y$12$3vqJU2IxWmVO0QDBgSSwR.F096xSldWGPToJ5zV9GS3dOcBu7gQVq','organizer',NULL,'2026-07-28 04:12:53','2026-07-28 04:12:53'),(7,'3263_MUHAMMAD NUR ILLHAM','muhammadnurillham@students.amikom.ac.id','105436227832459620374','https://lh3.googleusercontent.com/a/ACg8ocKS9yCBrXEhTB1CZkknCcwB3O1_0hiRL_2vdwaHWupeFJwFEw=s96-c',NULL,'$2y$12$Z5j4mKo2itGZN/X4Nsz0B.WbAAjjfN14OjkrFmBL9mUGkkE.iI.ce','user','VZGQ9ZXK7CnDmPlR9d20GTDWE5ADQE06odx1YNWjZ2r5tUt98QZf1LeMHjd1','2026-07-29 20:22:59','2026-07-29 20:22:59'),(8,'illham','yahoyaya395@gmail.com','108888788176051643331','https://lh3.googleusercontent.com/a/ACg8ocI8BvoIXtk4M26N_GVdoDTwrF8fCj9iQKTIi1uJlthXXTGUcQ=s96-c',NULL,'$2y$12$Pd4J2ai0Txuj3pKE6xET1OATH9o.wljChyHKy80zEbo5H8rUqDfh2','user','31gcIElKhQqMQg9rfDogYVd2sE2fQrsrDPPtiWAc283ONQ93t34JLAKj0yrs','2026-07-29 20:24:51','2026-07-29 22:32:08'),(9,'iam','muhammadnurillham14@gmail.com',NULL,NULL,NULL,'$2y$12$Nm81VOFZGfMft0jAHFvPGedB3pSpGwqYLFtY89pA.MZMEkJ6cEgP2','user',NULL,'2026-07-29 22:27:59','2026-07-29 22:27:59');
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

-- Dump completed on 2026-07-30 15:57:08
