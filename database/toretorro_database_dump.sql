-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: toretorro
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
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
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hostnames` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hostnames`)),
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domains_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

LOCK TABLES `domains` WRITE;
/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` VALUES (1,'global','Torre Tórò International (Nigeria & Global)','[\"torretoro.com\",\"www.torretoro.com\",\"localhost\",\"127.0.0.1\"]','NGN','+234 813 600 1221','hello@torretoro.com','16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA','Commercial Interior Design & Architecture Firm | Torre Tórò','At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish.','{\"instagram\":\"https:\\/\\/www.instagram.com\\/torretorong\\/\",\"facebook\":\"https:\\/\\/facebook.com\\/torretorong\",\"twitter\":\"https:\\/\\/x.com\\/torretorong\",\"linkedin\":\"https:\\/\\/linkedin.com\\/company\\/torretoro\",\"youtube\":\"https:\\/\\/youtube.com\\/@torretoro\"}',1,1,'2026-10-23 15:22:51','2026-10-27 10:26:11'),(2,'uk','Torre Tórò UK','[\"torretoro.co.uk\",\"www.torretoro.co.uk\",\"uk.torretoro.com\",\"uk.localhost\"]','GBP','+2348136001221','uk@torretoro.co.uk','Flat 21, Aschcroft Square, King Street, London, United Kingdom, W6 OYH',NULL,NULL,'{\"instagram\":\"https:\\/\\/www.instagram.com\\/torretorouk\\/\",\"facebook\":null,\"twitter\":\"https:\\/\\/x.com\\/torretorouk\",\"linkedin\":\"https:\\/\\/linkedin.com\\/company\\/torretoro-uk\",\"youtube\":null}',0,1,'2026-10-23 15:22:51','2026-10-27 12:17:16');
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'general_contact',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `service_requested` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `preferred_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inquiries_domain_id_foreign` (`domain_id`),
  CONSTRAINT `inquiries_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
INSERT INTO `inquiries` VALUES (1,1,'expert_appointment','Alexander Vance','alex@example.com','+2348012345678',NULL,'Commercial Interiors','Requesting an architectural consultation for our new office headquarters.',NULL,'new','2026-10-23 15:36:17','2026-10-23 15:36:17'),(2,1,'general_contact','David Barnett','davidbarnett527@gmail.com','0923000141',NULL,NULL,'Address: 820132091\ncareeer',NULL,'new','2026-10-24 00:43:38','2026-10-24 00:43:38'),(3,1,'consultation','Agent Tester','tester@torretoro.com','+234 813 600 1221',NULL,NULL,'Testing automated inquiry endpoint',NULL,'new','2026-10-27 12:50:51','2026-10-27 12:50:51');
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `order` int(11) NOT NULL DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (49,1,NULL,'Home','/','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(50,1,NULL,'Services','/services','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(51,1,50,'Commercial Architecture','/services/architectural-design','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(52,1,50,'Commercial Interiors','/services/interior-design','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(53,1,50,'Construction Consultancy','/services/building-construction','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(54,1,50,'Procurement Services','/services/consultancy-and-procurement','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(55,1,50,'Real Estate','/services/real-estate','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(56,1,NULL,'Portfolio','/portfolio','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(57,1,NULL,'News','/news','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(58,1,NULL,'About Us','/about-us','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(59,1,NULL,'Contact Us','/contact-us','_self',6,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(60,2,NULL,'About Company','/about-us','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(61,2,NULL,'Our Services','/services','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(62,2,NULL,'Our Projects','/portfolio','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(63,2,NULL,'Pricing','/contact-us','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(64,2,NULL,'Contacts','/contact-us','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(65,3,NULL,'Careers','/contact-us?subject=careers','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(66,3,NULL,'Our Process','/about-us#our-process','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(67,3,NULL,'FAQs','/about-us#faqs','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(68,3,NULL,'Clients Testimonials','/#testimonials','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(69,3,NULL,'Our Blog','/news','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(70,4,NULL,'Support','/contact-us','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(71,4,NULL,'Partners','/about-us#partners','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(72,4,NULL,'Careers','/contact-us?subject=careers','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(73,5,NULL,'Home','/','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(74,5,NULL,'Services','/services','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(75,5,74,'Commercial Architecture','/services/architectural-design','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(76,5,74,'Commercial Interiors','/services/interior-design','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(77,5,74,'Construction Consultancy','/services/building-construction','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(78,5,74,'Procurement Services','/services/consultancy-and-procurement','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(79,5,74,'Real Estate','/services/real-estate','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(80,5,NULL,'Portfolio','/portfolio','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(81,5,NULL,'News','/news','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(82,5,NULL,'About Us','/about-us','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(83,5,NULL,'Contact Us','/contact-us','_self',6,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(84,6,NULL,'About Company','/about-us','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(85,6,NULL,'Our Services','/services','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(86,6,NULL,'Our Projects','/portfolio','_self',3,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(87,6,NULL,'Pricing','/contact-us','_self',4,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(88,6,NULL,'Contacts','/contact-us','_self',5,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(89,7,NULL,'Careers','/contact-us?subject=careers','_self',1,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(90,7,NULL,'Our Process','/about-us#our-process','_self',2,NULL,'2026-10-23 15:24:41','2026-10-23 15:24:41'),(91,7,NULL,'FAQs','/about-us#faqs','_self',3,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(92,7,NULL,'Clients Testimonials','/#testimonials','_self',4,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(93,7,NULL,'Our Blog','/news','_self',5,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(94,8,NULL,'Support','/contact-us','_self',1,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(95,8,NULL,'Partners','/about-us#partners','_self',2,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(96,8,NULL,'Careers','/contact-us?subject=careers','_self',3,NULL,'2026-10-23 15:24:42','2026-10-23 15:24:42');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_domain_id_location_unique` (`domain_id`,`location`),
  CONSTRAINT `menus_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,'Main Navigation (Header)','header','2026-10-23 15:22:51','2026-10-23 15:22:51'),(2,1,'Footer Quick Links','footer_quick_links','2026-10-23 15:22:51','2026-10-23 15:22:51'),(3,1,'Footer Client Support','footer_client_support','2026-10-23 15:22:51','2026-10-23 15:22:51'),(4,1,'Top Bar Navigation','top_bar','2026-10-23 15:22:51','2026-10-23 15:22:51'),(5,2,'Main Navigation (Header)','header','2026-10-23 15:22:51','2026-10-23 15:22:51'),(6,2,'Footer Quick Links','footer_quick_links','2026-10-23 15:22:51','2026-10-23 15:22:51'),(7,2,'Footer Client Support','footer_client_support','2026-10-23 15:22:51','2026-10-23 15:22:51'),(8,2,'Top Bar Navigation','top_bar','2026-10-23 15:22:51','2026-10-23 15:22:51');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_23_160053_create_personal_access_tokens_table',2),(5,'2026_10_23_170001_create_domains_table',3),(6,'2026_10_23_170002_create_settings_table',3),(7,'2026_10_23_170003_create_menus_and_menu_items_table',3),(8,'2026_10_23_170004_create_pages_table',3),(9,'2026_10_23_170005_create_services_table',3),(10,'2026_10_23_170006_create_projects_table',3),(11,'2026_10_23_170007_create_posts_table',3),(12,'2026_10_23_170008_create_testimonials_table',3),(13,'2026_10_23_170009_create_inquiries_table',3),(14,'2026_10_24_021207_add_role_and_permissions_to_users_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `hero_badge` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sections`)),
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_domain_id_slug_unique` (`domain_id`,`slug`),
  CONSTRAINT `pages_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,1,'Home','home',NULL,'COMMERCIAL INTERIOR DESIGN & ARCHITECTURE','Designing Spaces that Inspire Success','At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.','/storage/uploads/hero/hero-bg.jpg',NULL,'{\"hero\":{\"badge\":\"COMMERCIAL INTERIOR DESIGN & ARCHITECTURE\",\"title\":\"Designing Spaces that Inspire Success\",\"subtitle\":\"At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.\",\"cta_text\":\"LET\'S CREATE YOUR PERFECT SPACE  \\u2192\",\"cta_url\":\"\\/contact-us\",\"image\":\"\\/storage\\/uploads\\/hero\\/hero-bg.jpg\",\"video_url\":\"\\/storage\\/uploads\\/branding\\/corporate-logo.mp4\"},\"stats\":{\"counter_1_number\":\"14\",\"counter_1_label\":\"Completed Projects\",\"counter_2_number\":\"7+\",\"counter_2_label\":\"Years of Experience\",\"headline\":\"We Govern and Manage Place and Privacy policies\"},\"expertise\":[{\"title\":\"Interior Design\",\"desc\":\"We create functional, stylish spaces that inspire employees and impress clients.\",\"icon\":\"cube\"},{\"title\":\"Project Management\",\"desc\":\"Our project management team ensures smooth execution\",\"icon\":\"building\"},{\"title\":\"Procurement & Fit-out\",\"desc\":\"We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.\",\"icon\":\"truck\"}],\"about\":{\"badge\":\"ABOUT US\",\"heading\":\"With our expertise we guarentee success\",\"paragraph_1\":\"We are a leading interior design firm dedicated to crafting commercial spaces that inspire, innovate, and elevate the way people work.\",\"paragraph_2\":\"With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.\",\"paragraph_3\":\"Whether you are reimagining your corporate office, retail environment, or hospitality space, our tailored approach ensures that your vision comes to life.\",\"cta_text\":\"LEARN MORE  \\u2192\",\"cta_url\":\"\\/about-us\",\"image_1\":\"\\/storage\\/uploads\\/about\\/about-page.png\",\"image_2\":\"\\/storage\\/uploads\\/about\\/about-story.png\",\"video_url\":\"\\/storage\\/uploads\\/branding\\/corporate-logo.mp4\"},\"pillars\":{\"badge\":\"OUR PROCESS\",\"heading\":\"Architectural Rigor From Vision to Delivery\",\"cards\":[{\"title\":\"Research & Analysis\",\"desc\":\"Understanding Context, Culture, and Client Needs\",\"image\":\"\\/storage\\/uploads\\/about\\/brainstorming.png\"},{\"title\":\"Industry Development\",\"desc\":\"Design Innovation, Strategy, and Technical Planning\",\"image\":\"\\/storage\\/uploads\\/services\\/commercial-architecture.jpg\"},{\"title\":\"Production Launch\",\"desc\":\"Execution, Oversight, and Final Delivery\",\"image\":\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-1.jpg\"}]},\"projects_section\":{\"badge\":\"OUR WORKS\",\"heading\":\"Our Special Projects\",\"subheading\":\"A curated selection of our commercial interior design and turnkey architectural completions.\",\"cta_text\":\"SEE OUR FULL PORTFOLIO  \\u2192\",\"cta_url\":\"\\/portfolio\"},\"review\":{\"badge\":\"TESTIMONIALS\",\"heading\":\"What Our Clients Say\",\"subheading\":\"Hear directly from corporate executives and facility directors whose workspaces we have transformed.\",\"quote\":\"As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.\",\"client_name\":\"Mrs Jacobo\",\"client_role\":\"Office Interior Design in Abuja, Nigeria.\",\"client_company\":\"Jacobo Corporate Offices\",\"client_avatar\":\"\\/storage\\/uploads\\/team\\/adeboye-damilola.png\",\"rating\":5},\"map\":{\"badge\":\"VISIT OUR STUDIOS\",\"heading\":\"Global Footprint & Project Hubs\",\"office_title\":\"Torre Toro Architecture Headquarters\",\"address\":\"16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA\",\"phone_1\":\"+234 813 600 1221\",\"phone_2\":\"+234 011 336 54\",\"call_us_today\":\"+234 813 600 1221\",\"email_1\":\"hello@torretoro.com\",\"email_2\":\"dami@torretoro.com\",\"working_hours\":\"Monday - Friday: 8:00 AM - 6:00 PM\",\"embed_url\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng\",\"directions_url\":\"https:\\/\\/maps.google.com\\/?q=16a+Da+Silva+Street+Lekki+Phase+1%2C+Lekki+Lagos%2C+NIGERIA\"},\"bottom_video\":{\"heading\":\"Experience Architecture in Motion\",\"subheading\":\"Take a dynamic tour through our completed commercial headquarters and signature fit-outs.\",\"poster_image\":\"\\/storage\\/uploads\\/video\\/video-bg.jpg\",\"video_url\":\"https:\\/\\/www.youtube.com\\/shorts\\/MsmQgPAfDdk\",\"cta_text\":\"LET\'S CREATE YOUR PERFECT SPACE  \\u2192\",\"cta_url\":\"\\/contact-us\"}}','Commercial Interior Design & Architecture Firm | Torre Tórò','At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish.',1,'2026-10-23 15:24:42','2026-10-27 12:07:10'),(2,1,'About Us','about-us',NULL,'ABOUT US','CRAFTING EXPERIENCES','Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.','/storage/uploads/about/about-page.png','<h3>Our Philosophy</h3><p>At Torre Tórò, every design decision is backed by human behavior, workflow analytics, and environmental sustainability. From Fortune 500 headquarters to visionary commercial retail spaces, we deliver end-to-end design, construction, and procurement excellence.</p><h3>Why Choose Us</h3><p>We combine rigorous technical discipline with unyielding aesthetic standards, managing projects from initial spatial modeling through to turnkey fit-out and facility handover.</p>','{\"hero\":{\"badge\":\"ABOUT US\",\"title\":\"CRAFTING EXPERIENCES\",\"subtitle\":\"Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.\",\"image\":\"\\/storage\\/uploads\\/about\\/about-page.png\"},\"story\":{\"badge\":\"OUR STORY\",\"heading\":\"Architectural Passion and Purpose\",\"paragraph_1\":\"Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect. Founded by architects and interior design specialists, we believe design is more than aesthetics; it is a catalyst for corporate productivity.\",\"paragraph_2\":\"With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.\",\"image\":\"\\/storage\\/uploads\\/about\\/about-story.png\"},\"vision_mission\":{\"vision\":\"To be a global leader in commercial architecture and workplace design, inspiring businesses to achieve their full potential.\",\"mission\":\"To create innovative, high-performance work environments through human-centric design, architectural precision, and seamless project delivery.\",\"values\":[\"Creativity\",\"Collaboration\",\"Excellence\",\"Integrity\",\"Innovation\"]},\"team\":{\"badge\":\"LEADERSHIP\",\"heading\":\"Meet the Team\",\"members\":[{\"name\":\"Adeboye Damilola\",\"role\":\"MD\\/CEO\",\"bio\":\"15+ years experience in commercial interior design, turnkey architecture, and workplace masterplanning.\",\"image\":\"\\/storage\\/uploads\\/team\\/adeboye-damilola.png\"},{\"name\":\"Kater Titus\",\"role\":\"Chief Technology Officer (CTO)\",\"bio\":\"Directing digital twin integrations, smart building automation, and architectural technology systems.\",\"image\":\"\\/storage\\/uploads\\/team\\/kater-titus.jpg\"},{\"name\":\"Olamide Roberts\",\"role\":\"Media & Brand Director\",\"bio\":\"Overseeing visual identity, brand communications, and experiential design narratives.\",\"image\":\"\\/storage\\/uploads\\/team\\/olamide-roberts.jpg\"},{\"name\":\"Samuel Oludara\",\"role\":\"Project Lead & Spatial Architect\",\"bio\":\"Leading site engineering, BIM modeling, and architectural coordination across commercial developments.\",\"image\":\"\\/storage\\/uploads\\/team\\/oludara-samuel.jpg\"},{\"name\":\"Idris Salau\",\"role\":\"Construction & Site Manager\",\"bio\":\"Spearheading on-site fit-out execution, contractor oversight, and structural quality compliance.\",\"image\":\"\\/storage\\/uploads\\/team\\/idris-salau.jpg\"}]}}','About Torre Tórò | Crafting Experiences & Workplace Architecture','Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.',1,'2026-10-23 15:24:42','2026-10-24 01:18:34'),(3,1,'Contact Us','contact-us',NULL,'GET IN TOUCH','Contact Us','Let\'s discuss how we can transform your commercial workspace.','/storage/uploads/about/contact-header.png','<p>Contact our project team directly or visit our office to review your architectural brief and commercial fit-out specifications.</p>','{\"hero\":{\"badge\":\"GET IN TOUCH\",\"title\":\"Contact Us\",\"subtitle\":\"Let\'s discuss how we can transform your commercial workspace.\",\"image\":\"\\/storage\\/uploads\\/about\\/contact-header.png\"},\"form_info\":{\"button_text\":\"APPOINTMENT \\u2192\",\"address\":\"16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA\",\"phone_1\":\"+234 813 600 1221\",\"phone_2\":\"+234 011 336 54\",\"email_1\":\"hello@torretoro.com\",\"email_2\":\"dami@torretoro.com\",\"working_hours\":\"Monday - Friday: 8:00 AM - 6:00 PM\"}}','Contact Torre Tórò | Request an Appointment','Get in touch with Torre Tórò for office interior design, project management, and turnkey construction appointments.',1,'2026-10-23 15:24:42','2026-10-27 10:26:14'),(4,2,'Home','home',NULL,'COMMERCIAL INTERIOR DESIGN & ARCHITECTURE','Designing Spaces that Inspire Success','At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.','/storage/uploads/hero/hero-bg.jpg',NULL,'{\"hero\":{\"badge\":\"COMMERCIAL INTERIOR DESIGN & ARCHITECTURE\",\"title\":\"Designing Spaces that Inspire Success\",\"subtitle\":\"At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.\",\"cta_text\":\"LET\'S CREATE YOUR PERFECT SPACE  \\u2192\",\"cta_url\":\"\\/contact-us\",\"image\":\"\\/storage\\/uploads\\/hero\\/hero-bg.jpg\",\"video_url\":\"\\/storage\\/uploads\\/branding\\/corporate-logo.mp4\"},\"stats\":{\"counter_1_number\":\"14\",\"counter_1_label\":\"Completed Projects\",\"counter_2_number\":\"7+\",\"counter_2_label\":\"Years of Experience\",\"headline\":\"We Govern and Manage Place and Privacy policies\"},\"expertise\":[{\"title\":\"Interior Design\",\"desc\":\"We create functional, stylish spaces that inspire employees and impress clients.\",\"icon\":\"cube\"},{\"title\":\"Project Management\",\"desc\":\"Our project management team ensures smooth execution\",\"icon\":\"building\"},{\"title\":\"Procurement & Fit-out\",\"desc\":\"We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.\",\"icon\":\"truck\"}],\"about\":{\"badge\":\"ABOUT US\",\"tag\":\"Crafting Experiences\",\"heading\":\"With our expertise we guarentee success\",\"paragraph_1\":\"We are a leading interior design firm dedicated to crafting commercial spaces that inspire, innovate, and elevate the way people work.\",\"paragraph_2\":\"With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.\",\"paragraph_3\":\"Whether you are reimagining your corporate office, retail environment, or hospitality space, our tailored approach ensures that your vision comes to life.\",\"cta_text\":\"LEARN MORE  \\u2192\",\"cta_url\":\"\\/about-us\",\"image_1\":\"\\/storage\\/uploads\\/about\\/about-page.png\",\"image_2\":\"\\/storage\\/uploads\\/about\\/about-story.png\",\"video_url\":\"\\/storage\\/uploads\\/branding\\/corporate-logo.mp4\"},\"pillars\":{\"badge\":\"OUR PROCESS\",\"heading\":\"Architectural Rigor From Vision to Delivery\",\"cards\":[{\"title\":\"Research & Analysis\",\"desc\":\"Understanding Context, Culture, and Client Needs\",\"image\":\"\\/storage\\/uploads\\/about\\/brainstorming.png\"},{\"title\":\"Industry Development\",\"desc\":\"Design Innovation, Strategy, and Technical Planning\",\"image\":\"\\/storage\\/uploads\\/services\\/commercial-architecture.jpg\"},{\"title\":\"Production Launch\",\"desc\":\"Execution, Oversight, and Final Delivery\",\"image\":\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-1.jpg\"}]},\"projects_section\":{\"badge\":\"OUR WORKS\",\"heading\":\"Our Special Projects\",\"subheading\":\"A curated selection of our commercial interior design and turnkey architectural completions.\",\"cta_text\":\"SEE OUR FULL PORTFOLIO  \\u2192\",\"cta_url\":\"\\/portfolio\"},\"review\":{\"badge\":\"TESTIMONIALS\",\"heading\":\"What Our Clients Say\",\"subheading\":\"Hear directly from corporate executives and facility directors whose workspaces we have transformed.\",\"quote\":\"As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.\",\"client_name\":\"Mrs Jacobo\",\"client_role\":\"Office Interior Design in Abuja, Nigeria.\",\"client_company\":\"Jacobo Corporate Offices\",\"client_avatar\":\"\\/storage\\/uploads\\/team\\/adeboye-damilola.png\",\"rating\":5},\"map\":{\"badge\":\"VISIT OUR STUDIOS\",\"heading\":\"Global Footprint & Project Hubs\",\"office_title\":\"Torre Toro London Design Studio\",\"address\":\"45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom\",\"phone_1\":\"+44 20 7946 0991\",\"phone_2\":\"+44 20 7946 0912\",\"call_us_today\":\"+44 20 7946 0991\",\"email_1\":\"uk@torretoro.com\",\"email_2\":\"london@torretoro.com\",\"working_hours\":\"Monday - Friday: 8:00 AM - 6:00 PM\",\"map_image\":\"\\/storage\\/uploads\\/maps\\/map-location.png\",\"embed_url\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng\",\"directions_url\":\"https:\\/\\/maps.google.com\\/?q=45+Berkeley+Square%2C+Mayfair%2C+London+W1J+5AS%2C+United+Kingdom\"},\"bottom_video\":{\"heading\":\"Experience Architecture in Motion\",\"subheading\":\"Take a dynamic tour through our completed commercial headquarters and signature fit-outs.\",\"poster_image\":\"\\/storage\\/uploads\\/video\\/video-bg.jpg\",\"video_cover\":\"\\/storage\\/uploads\\/video\\/video-cover.png\",\"video_url\":\"\\/storage\\/uploads\\/branding\\/corporate-logo.mp4\",\"cta_text\":\"LET\'S CREATE YOUR PERFECT SPACE  \\u2192\",\"cta_url\":\"\\/contact-us\"}}','Commercial Workspace Architecture & Interior Design UK | Torre Tórò','Torre Tórò UK delivers bespoke workplace consultancy, commercial fit-outs, and architectural excellence for modern workspaces across the United Kingdom.',1,'2026-10-23 15:24:42','2026-10-24 01:18:35'),(5,2,'About Us','about-us',NULL,'ABOUT US','CRAFTING EXPERIENCES','Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.','/storage/uploads/about/about-page.png','<h3>Our Philosophy</h3><p>At Torre Tórò, every design decision is backed by human behavior, workflow analytics, and environmental sustainability. From Fortune 500 headquarters to visionary commercial retail spaces, we deliver end-to-end design, construction, and procurement excellence.</p><h3>Why Choose Us</h3><p>We combine rigorous technical discipline with unyielding aesthetic standards, managing projects from initial spatial modeling through to turnkey fit-out and facility handover.</p>','{\"hero\":{\"badge\":\"ABOUT US\",\"title\":\"CRAFTING EXPERIENCES\",\"subtitle\":\"Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.\",\"image\":\"\\/storage\\/uploads\\/about\\/about-page.png\"},\"story\":{\"badge\":\"OUR STORY\",\"heading\":\"Architectural Passion and Purpose\",\"paragraph_1\":\"Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect. Founded by architects and interior design specialists, we believe design is more than aesthetics; it is a catalyst for corporate productivity.\",\"paragraph_2\":\"With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.\",\"image\":\"\\/storage\\/uploads\\/about\\/about-story.png\"},\"vision_mission\":{\"vision\":\"To be a global leader in commercial architecture and workplace design, inspiring businesses to achieve their full potential.\",\"mission\":\"To create innovative, high-performance work environments through human-centric design, architectural precision, and seamless project delivery.\",\"values\":[\"Creativity\",\"Collaboration\",\"Excellence\",\"Integrity\",\"Innovation\"]},\"team\":{\"badge\":\"LEADERSHIP\",\"heading\":\"Meet the Team\",\"members\":[{\"name\":\"Adeboye Damilola\",\"role\":\"MD\\/CEO\",\"bio\":\"15+ years experience in commercial interior design, turnkey architecture, and workplace masterplanning.\",\"image\":\"\\/storage\\/uploads\\/team\\/adeboye-damilola.png\"},{\"name\":\"Kater Titus\",\"role\":\"Chief Technology Officer (CTO)\",\"bio\":\"Directing digital twin integrations, smart building automation, and architectural technology systems.\",\"image\":\"\\/storage\\/uploads\\/team\\/kater-titus.jpg\"},{\"name\":\"Olamide Roberts\",\"role\":\"Media & Brand Director\",\"bio\":\"Overseeing visual identity, brand communications, and experiential design narratives.\",\"image\":\"\\/storage\\/uploads\\/team\\/olamide-roberts.jpg\"},{\"name\":\"Samuel Oludara\",\"role\":\"Project Lead & Spatial Architect\",\"bio\":\"Leading site engineering, BIM modeling, and architectural coordination across commercial developments.\",\"image\":\"\\/storage\\/uploads\\/team\\/oludara-samuel.jpg\"},{\"name\":\"Idris Salau\",\"role\":\"Construction & Site Manager\",\"bio\":\"Spearheading on-site fit-out execution, contractor oversight, and structural quality compliance.\",\"image\":\"\\/storage\\/uploads\\/team\\/idris-salau.jpg\"}]}}','About Torre Tórò | Crafting Experiences & Workplace Architecture','Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.',1,'2026-10-23 15:24:42','2026-10-24 01:18:35'),(6,2,'Contact Us','contact-us',NULL,'GET IN TOUCH','Contact Us','Let\'s discuss how we can transform your commercial workspace.','/storage/uploads/about/contact-header.png','<p>Contact our project team directly or visit our office to review your architectural brief and commercial fit-out specifications.</p>','{\"hero\":{\"badge\":\"GET IN TOUCH\",\"title\":\"Contact Us\",\"subtitle\":\"Let\'s discuss how we can transform your commercial workspace.\",\"image\":\"\\/storage\\/uploads\\/about\\/contact-header.png\"},\"form_info\":{\"button_text\":\"APPOINTMENT \\u2192\",\"address\":\"45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom\",\"phone_1\":\"+44 20 7946 0991\",\"phone_2\":\"+44 20 7946 0912\",\"email_1\":\"uk@torretoro.com\",\"email_2\":\"london@torretoro.com\",\"working_hours\":\"Monday - Friday: 8:00 AM - 6:00 PM\"}}','Contact Torre Tórò | Request an Appointment','Get in touch with Torre Tórò for office interior design, project management, and turnkey construction appointments.',1,'2026-10-23 15:24:42','2026-10-24 01:18:35'),(7,1,'Services','services',NULL,'WHAT WE DO','DESIGNING FOR IMPACT','Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.','/storage/uploads/services/services-bg.jpg',NULL,'{\"hero\":{\"badge\":\"WHAT WE DO\",\"title\":\"DESIGNING FOR IMPACT\",\"subtitle\":\"Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.\",\"image\":\"\\/storage\\/uploads\\/services\\/services-bg.jpg\"}}','Our Services | Torre Tórò Commercial Architecture & Fit-Out','Explore Torre Tórò commercial interior design, project management, construction consultancy, and procurement services.',1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(8,1,'Portfolio','portfolio',NULL,'OUR WORKS','Spaces That Speak for Themselves','Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.','/storage/uploads/projects/portfolio-header.png',NULL,'{\"hero\":{\"badge\":\"OUR WORKS\",\"title\":\"Spaces That Speak for Themselves\",\"subtitle\":\"Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.\",\"image\":\"\\/storage\\/uploads\\/projects\\/portfolio-header.png\"}}','Portfolio & Case Studies | Torre Tórò Commercial Projects','Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.',1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(9,2,'Services','services',NULL,'WHAT WE DO','DESIGNING FOR IMPACT','Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.','/storage/uploads/services/services-bg.jpg',NULL,'{\"hero\":{\"badge\":\"WHAT WE DO\",\"title\":\"DESIGNING FOR IMPACT\",\"subtitle\":\"Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.\",\"image\":\"\\/storage\\/uploads\\/services\\/services-bg.jpg\"}}','Our Services | Torre Tórò Commercial Architecture & Fit-Out','Explore Torre Tórò commercial interior design, project management, construction consultancy, and procurement services.',1,'2026-10-24 01:18:35','2026-10-24 01:18:35'),(10,2,'Portfolio','portfolio',NULL,'OUR WORKS','Spaces That Speak for Themselves','Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.','/storage/uploads/projects/portfolio-header.png',NULL,'{\"hero\":{\"badge\":\"OUR WORKS\",\"title\":\"Spaces That Speak for Themselves\",\"subtitle\":\"Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.\",\"image\":\"\\/storage\\/uploads\\/projects\\/portfolio-header.png\"}}','Portfolio & Case Studies | Torre Tórò Commercial Projects','Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.',1,'2026-10-24 01:18:35','2026-10-24 01:18:35');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
INSERT INTO `post_categories` VALUES (1,'Workplace Insights','workplace-insights','2026-10-23 15:22:51','2026-10-23 15:22:51'),(2,'Interior Design','interior-design','2026-10-23 15:22:51','2026-10-23 15:22:51'),(3,'Case Studies','case-studies','2026-10-23 15:22:51','2026-10-23 15:22:51');
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) NOT NULL DEFAULT 'Torre Tórò',
  `read_time` varchar(255) NOT NULL DEFAULT '5 min read',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_domain_id_slug_unique` (`domain_id`,`slug`),
  KEY `posts_category_id_foreign` (`category_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `posts_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,'How Commercial Interiors Design Boosts Workplace Productivity','how-commercial-interiors-design-boost-workplace-productivity','Discover how thoughtful spatial layout, acoustic comfort, and natural illumination directly impact team focus and organizational performance.','<p>Discover how thoughtful spatial layout, acoustic comfort, and natural illumination directly impact team focus and organizational performance.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/about/brainstorming.png','Torre Tórò Editorial Team','4 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14'),(2,1,2,'Design for Everyone: Rethinking Accessibility in Modern Workspaces','design-for-everyone-rethinking-accessibility-in-modern-workspaces','Universal design principles and ADA compliance in executive boardrooms, open desks, and communal breakout hubs.','<p>Universal design principles and ADA compliance in executive boardrooms, open desks, and communal breakout hubs.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/services/commercial-interiors.jpg','Torre Tórò Editorial Team','5 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14'),(3,1,3,'Here\'s Why Sanlam Insurance Chose Torre Tórò for Their Headquarters','heres-why-sanlam-insurance-chose-us','Inside the 16-week transformation of Sanlam Insurance Victoria Island office: from architectural conception to turnkey move-in.','<p>Inside the 16-week transformation of Sanlam Insurance Victoria Island office: from architectural conception to turnkey move-in.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/projects/sanlam-insurance-1.jpg','Torre Tórò Editorial Team','6 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14'),(4,2,1,'How Commercial Interiors Design Boosts Workplace Productivity','how-commercial-interiors-design-boost-workplace-productivity','Discover how thoughtful spatial layout, acoustic comfort, and natural illumination directly impact team focus and organizational performance.','<p>Discover how thoughtful spatial layout, acoustic comfort, and natural illumination directly impact team focus and organizational performance.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/about/brainstorming.png','Torre Tórò Editorial Team','4 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14'),(5,2,2,'Design for Everyone: Rethinking Accessibility in Modern Workspaces','design-for-everyone-rethinking-accessibility-in-modern-workspaces','Universal design principles and ADA compliance in executive boardrooms, open desks, and communal breakout hubs.','<p>Universal design principles and ADA compliance in executive boardrooms, open desks, and communal breakout hubs.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/services/commercial-interiors.jpg','Torre Tórò Editorial Team','5 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14'),(6,2,3,'Here\'s Why Sanlam Insurance Chose Torre Tórò for Their Headquarters','heres-why-sanlam-insurance-chose-us','Inside the 16-week transformation of Sanlam Insurance Victoria Island office: from architectural conception to turnkey move-in.','<p>Inside the 16-week transformation of Sanlam Insurance Victoria Island office: from architectural conception to turnkey move-in.</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>','/storage/uploads/projects/sanlam-insurance-1.jpg','Torre Tórò Editorial Team','6 min read','2026-10-27 10:26:14',1,'2026-10-23 15:31:27','2026-10-27 10:26:14');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_categories`
--

DROP TABLE IF EXISTS `project_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_categories`
--

LOCK TABLES `project_categories` WRITE;
/*!40000 ALTER TABLE `project_categories` DISABLE KEYS */;
INSERT INTO `project_categories` VALUES (1,'Commercial Architecture','commercial-architecture','2026-10-23 15:22:51','2026-10-23 15:22:51'),(2,'Commercial Interiors','commercial-interiors','2026-10-23 15:22:51','2026-10-23 15:22:51'),(3,'Construction Consultancy','construction-consultancy','2026-10-23 15:22:51','2026-10-23 15:22:51'),(4,'Procurement & Fit-Out','procurement-services','2026-10-23 15:22:51','2026-10-23 15:22:51'),(5,'Procurement & Fit-Out','procurement-fit-out','2026-10-24 01:17:20','2026-10-24 01:17:20');
/*!40000 ALTER TABLE `project_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `services_rendered` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `stats` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stats`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_domain_id_slug_unique` (`domain_id`,`slug`),
  KEY `projects_category_id_foreign` (`category_id`),
  CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `projects_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,1,2,'ShoeLab Office','shoelab-office','ShoeLab HQ','Lekki Phase 1, Lagos','2023','Commercial Interior Architecture & Workspace Optimization','Architectural transformation project by Torre Tórò.','<p class=\"\">A Space Reborn with the Spirit of Renewal</p>\r\n\r\n\r\n\r\n<p class=\"\">ShoeLab built its reputation on the art of restoration, bringing worn shoes back to life through care, precision, and craft. When they invited TorreToro to handle their <em>office design</em>, the goal was to create a space that expressed this same philosophy of revival and excellence.</p>\r\n\r\n\r\n\r\n<p class=\"\">We imagined an environment that feels fresh, alive, and full of motion. Natural light flows across open <em>workspace design</em> zones, encouraging creativity and connection. Warm wood tones meet clean, modern lines, creating harmony between craftsmanship and innovation. Every corner was designed to echo ShoeLab’s attention to detail and its belief that care can transform the ordinary into something extraordinary.</p>\r\n\r\n\r\n\r\n<p class=\"\">The completed space feels like a breath of new energy. It reflects the essence of the brand, a place where creativity is nurtured, collaboration feels natural, and every day begins with a sense of renewal.</p>\r\n\r\n\r\n\r\n<p class=\"\"></p>','/storage/uploads/library/TorreToro_at_21.32.13_7697106c.jpg',NULL,NULL,'{\"area\":\"4,200 sq ft\",\"timeline\":\"8 weeks\",\"capacity\":\"Creative Studios & Retail Display\"}',1,1,'2026-10-23 15:31:27','2026-10-27 11:13:46'),(2,1,1,'GT Bank Headquarters Gym Renovation','gt-bank-headquarters-gym-renovation','Guaranty Trust Bank (GTBank)','Lagos Island, Nigeria','2023','Architectural Renovation & Wellness Center Fit-Out','Architectural transformation project by Torre Tórò.','\n<p class=\"\">Redefining Corporate Wellness</p>\n\n\n\n<p class=\"\">At GTBank’s headquarters, wellness became the canvas for a new kind of corporate energy. The vision was to create a space where balance met elegance, where movement and stillness could coexist. Every detail was designed to inspire renewal, from the first stretch in the morning light to the quiet reflection that ends the day.</p>\n\n\n\n<p class=\"\">The gym’s <em>interior design </em>draws its calm from clean lines, soft lighting, and natural materials that infuse the space with warmth. Energy flows gently from dynamic training areas into serene recovery zones, mirroring the rhythm of a well-lived day. Every corner feels intentional, every surface invites focus and ease.</p>\n\n\n\n<p class=\"\">We wanted the experience to feel restorative, like a deep breath in the middle of a busy day. Light pours in softly, wood tones ground the senses, and the open layout encourages both connection and solitude. The result is a gym that feels alive, a place where wellness is woven into the very structure of work life.</p>\n\n\n\n<p class=\"\">This is more than a fitness facility; it is a sanctuary of strength and calm, a daily reminder that clarity and creativity thrive in spaces designed for renewal.</p>\n\n\n\n<p class=\"\"></p>\n',NULL,NULL,NULL,'{\"area\":\"8,500 sq ft\",\"timeline\":\"12 weeks\",\"features\":\"Rubberized flooring, HVAC integration\"}',1,2,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(3,1,2,'Sanlam Insurance V.I. Lagos','sanlam-insurance','Sanlam Insurance Group','Victoria Island, Lagos, Nigeria','2024','Commercial Interior Design & Turnkey Fit-Out','Where Heritage Meets Modern Vision — A state-of-the-art corporate boardroom, executive offices, and collaborative workstations.','<p>Completed on June 19, 2024, Sanlam Insurance entrusted Torre Tórò to revamp their Victoria Island headquarters into a cutting-edge, biophilic work environment. Featuring acoustic wall panels, executive board suites, and bespoke lighting.</p>','/storage/uploads/projects/sanlam-insurance-1.jpg','/storage/uploads/projects/sanlam-insurance-1.jpg','[\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-1.jpg\",\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-2.jpg\"]','{\"area\":\"15,000 sq ft\",\"timeline\":\"16 weeks\",\"capacity\":\"250 workstations\"}',1,1,'2026-10-23 15:31:27','2026-10-24 01:18:34'),(4,2,2,'ShoeLab Office','shoelab-office','ShoeLab HQ','Lekki Phase 1, Lagos','2023','Commercial Interior Architecture & Workspace Optimization','Architectural transformation project by Torre Tórò.','\n<p class=\"\">A Space Reborn with the Spirit of Renewal</p>\n\n\n\n<p class=\"\">ShoeLab built its reputation on the art of restoration, bringing worn shoes back to life through care, precision, and craft. When they invited TorreToro to handle their <em>office design</em>, the goal was to create a space that expressed this same philosophy of revival and excellence.</p>\n\n\n\n<p class=\"\">We imagined an environment that feels fresh, alive, and full of motion. Natural light flows across open <em>workspace design</em> zones, encouraging creativity and connection. Warm wood tones meet clean, modern lines, creating harmony between craftsmanship and innovation. Every corner was designed to echo ShoeLab’s attention to detail and its belief that care can transform the ordinary into something extraordinary.</p>\n\n\n\n<p class=\"\">The completed space feels like a breath of new energy. It reflects the essence of the brand, a place where creativity is nurtured, collaboration feels natural, and every day begins with a sense of renewal.</p>\n\n\n\n<p class=\"\"></p>\n',NULL,NULL,NULL,'{\"area\":\"4,200 sq ft\",\"timeline\":\"8 weeks\",\"capacity\":\"Creative Studios & Retail Display\"}',1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(5,2,1,'GT Bank Headquarters Gym Renovation','gt-bank-headquarters-gym-renovation','Guaranty Trust Bank (GTBank)','Lagos Island, Nigeria','2023','Architectural Renovation & Wellness Center Fit-Out','Architectural transformation project by Torre Tórò.','\n<p class=\"\">Redefining Corporate Wellness</p>\n\n\n\n<p class=\"\">At GTBank’s headquarters, wellness became the canvas for a new kind of corporate energy. The vision was to create a space where balance met elegance, where movement and stillness could coexist. Every detail was designed to inspire renewal, from the first stretch in the morning light to the quiet reflection that ends the day.</p>\n\n\n\n<p class=\"\">The gym’s <em>interior design </em>draws its calm from clean lines, soft lighting, and natural materials that infuse the space with warmth. Energy flows gently from dynamic training areas into serene recovery zones, mirroring the rhythm of a well-lived day. Every corner feels intentional, every surface invites focus and ease.</p>\n\n\n\n<p class=\"\">We wanted the experience to feel restorative, like a deep breath in the middle of a busy day. Light pours in softly, wood tones ground the senses, and the open layout encourages both connection and solitude. The result is a gym that feels alive, a place where wellness is woven into the very structure of work life.</p>\n\n\n\n<p class=\"\">This is more than a fitness facility; it is a sanctuary of strength and calm, a daily reminder that clarity and creativity thrive in spaces designed for renewal.</p>\n\n\n\n<p class=\"\"></p>\n',NULL,NULL,NULL,'{\"area\":\"8,500 sq ft\",\"timeline\":\"12 weeks\",\"features\":\"Rubberized flooring, HVAC integration\"}',1,2,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(6,2,2,'Sanlam Insurance V.I. Lagos','sanlam-insurance','Sanlam Insurance Group','Victoria Island, Lagos, UK & Global','2024','Commercial Interior Design & Turnkey Fit-Out','Where Heritage Meets Modern Vision — A state-of-the-art corporate boardroom, executive offices, and collaborative workstations.','<p>Completed on June 19, 2024, Sanlam Insurance entrusted Torre Tórò to revamp their Victoria Island headquarters into a cutting-edge, biophilic work environment. Featuring acoustic wall panels, executive board suites, and bespoke lighting.</p>','/storage/uploads/projects/sanlam-insurance-1.jpg','/storage/uploads/projects/sanlam-insurance-1.jpg','[\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-1.jpg\",\"\\/storage\\/uploads\\/projects\\/sanlam-insurance-2.jpg\"]','{\"area\":\"15,000 sq ft\",\"timeline\":\"16 weeks\",\"capacity\":\"250 workstations\"}',1,1,'2026-10-23 15:31:27','2026-10-24 01:18:34'),(7,1,2,'ShoeLab HQ Lekki','shoelab-hq','ShoeLab','Lekki Phase 1, Lagos, Nigeria','2023','Commercial Interior Architecture & Workspace Optimization','An innovative blend of retail showroom and open-plan creative design studios for a high-growth luxury brand.','<p>ShoeLab HQ required an adaptable, minimalist aesthetic incorporating raw concrete finishes, curated spotlighting, and seamless retail flow.</p>','/storage/uploads/projects/shoelab-1.jpg','/storage/uploads/projects/shoelab-1.jpg','[\"\\/storage\\/uploads\\/projects\\/shoelab-1.jpg\",\"\\/storage\\/uploads\\/projects\\/shoelab-2.jpg\"]','{\"area\":\"4,200 sq ft\",\"timeline\":\"8 weeks\",\"capacity\":\"Creative Studios & Retail Display\"}',1,2,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(8,1,1,'GTBank Headquarters Gym','gtbank-headquarters-gym','Guaranty Trust Bank (GTBank)','Lagos Island, Lagos, Nigeria','2023','Architectural Renovation & Corporate Wellness Fit-Out','Turnkey renovation of the GTBank corporate gym, featuring specialized shock-absorbent flooring, advanced ventilation, and energizing spatial architecture.','<p>Delivered within an active banking headquarters, this wellness center combines acoustic isolation with premium fitness equipment layout.</p>','/storage/uploads/projects/gtbank-gym-1.jpg','/storage/uploads/projects/gtbank-gym-1.jpg','[\"\\/storage\\/uploads\\/projects\\/gtbank-gym-1.jpg\",\"\\/storage\\/uploads\\/projects\\/gtbank-gym-2.jpg\"]','{\"area\":\"8,500 sq ft\",\"timeline\":\"12 weeks\",\"features\":\"Rubberized flooring, HVAC integration\"}',1,3,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(9,2,2,'ShoeLab HQ Lekki','shoelab-hq','ShoeLab','Lekki Phase 1, Lagos, UK & Global','2023','Commercial Interior Architecture & Workspace Optimization','An innovative blend of retail showroom and open-plan creative design studios for a high-growth luxury brand.','<p>ShoeLab HQ required an adaptable, minimalist aesthetic incorporating raw concrete finishes, curated spotlighting, and seamless retail flow.</p>','/storage/uploads/projects/shoelab-1.jpg','/storage/uploads/projects/shoelab-1.jpg','[\"\\/storage\\/uploads\\/projects\\/shoelab-1.jpg\",\"\\/storage\\/uploads\\/projects\\/shoelab-2.jpg\"]','{\"area\":\"4,200 sq ft\",\"timeline\":\"8 weeks\",\"capacity\":\"Creative Studios & Retail Display\"}',1,2,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(10,2,1,'GTBank Headquarters Gym','gtbank-headquarters-gym','Guaranty Trust Bank (GTBank)','Lagos Island, Lagos, UK & Global','2023','Architectural Renovation & Corporate Wellness Fit-Out','Turnkey renovation of the GTBank corporate gym, featuring specialized shock-absorbent flooring, advanced ventilation, and energizing spatial architecture.','<p>Delivered within an active banking headquarters, this wellness center combines acoustic isolation with premium fitness equipment layout.</p>','/storage/uploads/projects/gtbank-gym-1.jpg','/storage/uploads/projects/gtbank-gym-1.jpg','[\"\\/storage\\/uploads\\/projects\\/gtbank-gym-1.jpg\",\"\\/storage\\/uploads\\/projects\\/gtbank-gym-2.jpg\"]','{\"area\":\"8,500 sq ft\",\"timeline\":\"12 weeks\",\"features\":\"Rubberized flooring, HVAC integration\"}',1,3,'2026-10-24 01:18:34','2026-10-24 01:18:34');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_domain_id_slug_unique` (`domain_id`,`slug`),
  CONSTRAINT `services_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,1,'Procurement Services','consultancy-and-procurement','Strategic Vendor Sourcing, Furnishings & Site Logistics','Consultancy and procurement At Torre Tórò, we offer professional consultancy and procurement services to guide you through the practical and regulatory side of building in Nigeria. Our building consultancy includes planning advice, site feasibility, permit support, vendor sourcing, and technical oversight. We also manage the procurement of quality interior finishes and furnishings; handling logistics, vendor [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1527\" class=\"elementor elementor-1527\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-ca3d46b e-flex e-con-boxed e-con e-parent\" data-id=\"ca3d46b\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-f55667b elementor-widget elementor-widget-heading\" data-id=\"f55667b\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Consultancy and procurement</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-7f02815 e-flex e-con-boxed e-con e-parent\" data-id=\"7f02815\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-cac353e e-con-full e-flex e-con e-child\" data-id=\"cac353e\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-a475ee2 elementor-widget elementor-widget-image\" data-id=\"a475ee2\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG-20240526-WA0028-qoq2v0iyjxv14qb38927zv4ef3vkcvhp998z179zuo.jpg\" title=\"IMG-20240526-WA0028\" alt=\"industral working desk procurement\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-d37c8f7 e-con-full e-flex e-con e-child\" data-id=\"d37c8f7\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-27f652a elementor-widget elementor-widget-text-editor\" data-id=\"27f652a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, we offer professional consultancy and procurement services to guide you through the practical and regulatory side of <a href=\"https://torretoro.com/building-construction/\">building in Nigeria</a>.</span></p><p><span style=\"font-weight: 400;\">Our building consultancy includes planning advice, site feasibility, permit support, vendor sourcing, and technical oversight.</span></p><p><span style=\"font-weight: 400;\"> We also manage the procurement of quality interior finishes and furnishings; handling logistics, vendor relations and installation on your behalf.</span></p><p><span style=\"font-weight: 400;\">Whether you’re a private homeowner or a <a href=\"https://torretoro.com/real-estate/\">real estate developer</a>, our consultancy services give you peace of mind and control throughout your build journey.</span></p><p><span style=\"font-weight: 400;\">Need expert guidance? Request a <a href=\"https://torretoro.com/contact-us/\">free consultation</a> now!</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0cf345f e-con-full e-flex e-con e-child\" data-id=\"0cf345f\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-1dfc346 elementor-widget elementor-widget-image\" data-id=\"1dfc346\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG-20240526-WA0033-rapdtveiyaatskblrc9cqf7qwf46joas5sm9b2e0zm.webp\" title=\"IMG-20240526-WA0033\" alt=\"IMG-20240526-WA0033\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0cceec3 e-con-full e-flex e-con e-child\" data-id=\"0cceec3\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-fc4d5dd elementor-widget elementor-widget-image\" data-id=\"fc4d5dd\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG_6819-scaled-rape0k17jvfv1ycaes4qx478q26eyd1sq41yuh8id4.webp\" title=\"IMG_6819\" alt=\"IMG_6819\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','truck',NULL,NULL,NULL,'[\"High-End Furniture & Fixture Direct Sourcing\",\"Import Logistics, Clearance, and Warehousing\",\"Custom Joinery and Millwork Fabrication\",\"Warranty Management & Post-Installation Support\"]',4,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(2,1,'Construction Consultancy','building-construction','Turnkey Building Construction & Engineering Project Management','Building Construction &#038; Project Management​ At Torre Tórò, we understand that even the best architectural design plan requires careful execution. We offer building construction and project management services that turn plans into solid, well-built realities. Our turnkey construction team manages your project with attention to cost, timeline, safety, and finish. From land sourcing and preparing [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1134\" class=\"elementor elementor-1134\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-5bdbe17 e-flex e-con-boxed e-con e-parent\" data-id=\"5bdbe17\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-c27dd68 elementor-widget elementor-widget-heading\" data-id=\"c27dd68\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Building Construction &amp; Project Management​</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f2fa1f0 e-flex e-con-boxed e-con e-parent\" data-id=\"f2fa1f0\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-5760902 e-con-full e-flex e-con e-child\" data-id=\"5760902\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-748e2da elementor-widget elementor-widget-image\" data-id=\"748e2da\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG_2931-2-scaled-rapeaz2tarpo1zcim1bm0yn60hqt5psiz476qycwqc.webp\" title=\"IMG_2931 (2)\" alt=\"onsite building construction project by Torre Tórò,\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-5db5eef e-con-full e-flex e-con e-child\" data-id=\"5db5eef\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-cee42dc elementor-widget elementor-widget-text-editor\" data-id=\"cee42dc\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, we understand that even the best <a href=\"https://torretoro.com/architectural-design/\" target=\"_blank\" rel=\"noopener\">architectural design plan</a> requires careful execution. We offer building construction and project management services that turn plans into solid, well-built realities.</span></p>\n<p><span style=\"font-weight: 400;\">Our turnkey construction team manages your project with attention to cost, timeline, safety, and finish. </span></p>\n<p><span style=\"font-weight: 400;\">From land sourcing and preparing planning applications to overseeing build and <a href=\"https://torretoro.com/interior-design/\" target=\"_blank\" rel=\"noopener\">interior design,</a> our building construction company in Lagos oversees every aspect of the process, ensuring accountability, quality, and alignment with your original intent.</span></p>\n<p><span style=\"font-weight: 400;\">We work with trusted contractors, engineers, and craftsmen to maintain consistency and control across every phase of your project. </span>Our commitment to thoughtful project delivery was recently recognised in <a class=\"\" href=\"https://www.thisdaylive.com/2025/04/18/adeboye-torretoro-strives-to-deliver-sustainable-projects-quality-clients-satisfaction/\" rel=\"noopener\" data-start=\"1083\" data-end=\"1095\">ThisDay</a>.</p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-51921d8 e-con-full e-flex e-con e-child\" data-id=\"51921d8\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-82c0283 elementor-widget elementor-widget-image\" data-id=\"82c0283\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/Torre-Toro-Construction-project-rapdgk0u4s2lbfnxil1mes6nxwqzi1fobvwmjy4t4y.webp\" title=\"Torre Toro Construction project\" alt=\"Construction site worker on a green safety vest\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-dc12d41 e-con-full e-flex e-con e-child\" data-id=\"dc12d41\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-291188e elementor-widget elementor-widget-image\" data-id=\"291188e\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/Torre-Toro-Site-Workers-e1751966200852-rapdgdfysxt7rdnp9k24vpjxj7noobxaa7rmvl5tyw.webp\" title=\"Torre Toro Site Workers\" alt=\"Site workers in Lagos, Nigeria, facilitating a turnkey construction project\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','hammer',NULL,NULL,NULL,'[\"Full Construction Supervision & Quality Control\",\"Timeline, Budget, and Material Cost Auditing\",\"Structural Integrity and Engineering Assurance\",\"Health, Safety, and Environmental Compliance\"]',3,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(3,1,'Commercial Architecture','architectural-design','Architectural Design Services & Workspace Planning','Architectural Design Services in Nigeria At Torre Tórò, our architectural design services in Nigeria goes beyond the scope of what is regular. Architecture has gone beyond just buildings; it is about shaping how people live, work, and feel. As a top architectural firm in Lagos, Nigeria, we design spaces that blend creativity with precision, whether for [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1130\" class=\"elementor elementor-1130\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-d39f0ef e-flex e-con-boxed e-con e-parent\" data-id=\"d39f0ef\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-0ecf860 elementor-widget elementor-widget-heading\" data-id=\"0ecf860\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Architectural Design Services in Nigeria</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-c5aa4a8 e-flex e-con-boxed e-con e-parent\" data-id=\"c5aa4a8\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-50133c3 e-con-full e-flex e-con e-child\" data-id=\"50133c3\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-075c192 elementor-widget elementor-widget-image\" data-id=\"075c192\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/417457976_18213975760282309_8264558768991633262_n-Copy-rapdy8dknm9qo9ut0j1o86e84gjotf7ik1u8jx912s.webp\" title=\"417457976_18213975760282309_8264558768991633262_n &#8211; Copy\" alt=\"one storey plan architectural design in Nigeria\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-55a7460 e-con-full e-flex e-con e-child\" data-id=\"55a7460\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-fbbee15 elementor-widget elementor-widget-text-editor\" data-id=\"fbbee15\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, our architectural design services in Nigeria goes beyond the scope of what is regular.</span></p><p><span style=\"font-weight: 400;\">Architecture has gone beyond just buildings; it is about shaping how people live, work, and feel. As a top </span><span style=\"font-weight: 400;\">architectural firm in Lagos, Nigeria, we</span><span style=\"font-weight: 400;\"> design spaces that blend creativity with precision, whether for private residences, commercial developments, or institutional projects.</span></p><p><span style=\"font-weight: 400;\">Our approach is rooted in a deep understanding of both traditional Nigerian architecture and contemporary global standards. We <a href=\"https://torretoro.com/interior-design/\">design structures</a> that are functional, culturally grounded, and visually timeless. </span></p><p><span style=\"font-weight: 400;\">Whether you require a </span><span style=\"font-weight: 400;\">house plan in Nigeria</span><span style=\"font-weight: 400;\">, modern family home or a community-focused development, our team of architects in Nigeria offers thoughtful, climate-conscious, and context-aware solutions.</span></p><p><span style=\"font-weight: 400;\">Ready to design something extraordinary? <a href=\"https://torretoro.com/contact-us/\">Book a consultation</a>.</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f13daab e-con-full e-flex e-con e-child\" data-id=\"f13daab\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-2c26d24 elementor-widget elementor-widget-image\" data-id=\"2c26d24\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/05-qmpcxj80xuwdcbxacav7v91puibio5vfle3r2616z8.jpg\" title=\"05.jpg\" alt=\"outdoor greenery, natural surrounding house plan\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-709d575 e-con-full e-flex e-con e-child\" data-id=\"709d575\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-8d0fc9a elementor-widget elementor-widget-image\" data-id=\"8d0fc9a\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img fetchpriority=\"high\" decoding=\"async\" width=\"800\" height=\"539\" src=\"https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-1024x690.webp\" class=\"attachment-large size-large wp-image-242\" alt=\"three bedroom nigerian house plan architectural service\" srcset=\"https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-1024x690.webp 1024w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-300x202.webp 300w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-768x518.webp 768w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n.webp 1080w\" sizes=\"(max-width: 800px) 100vw, 800px\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','building',NULL,NULL,NULL,'[\"Comprehensive 3D Modelling & Architectural Renderings\",\"Space Planning and Workspace Optimization\",\"Regulatory Compliance, Building Permits & Approvals\",\"Sustainable & Biophilic Architecture\"]',1,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(4,1,'Interior Design','interior-design','Functional, Stylish Spaces that Inspire Employees and Impress Clients','We create functional, stylish spaces that inspire employees and impress clients across diverse sectors.','<p>We create functional, stylish spaces that inspire employees and impress clients across diverse sectors.</p><p>Functional, Stylish Spaces that Inspire Employees and Impress Clients. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','brush','/storage/uploads/services/commercial-architecture.jpg','/storage/uploads/services/commercial-architecture.jpg',NULL,'[\"Comprehensive 3D BIM Modelling & Virtual Walkthroughs\",\"Space Planning and Workspace Optimization\",\"Sustainable & Biophilic Material Specification\",\"Color Psychology & Environmental Graphic Integration\"]',5,1,1,'2026-10-23 15:31:27','2026-10-24 01:18:34'),(5,1,'Real Estate Advisory','real-estate','Smart Property Investment, Development Feasibility & Planning','Real Estate Our real estate services combine design expertise with market knowledge to help you acquire, develop, and complete smart property investments. We work with developers, homeowners, and investors to deliver real estate projects that are not just beautifully designed but also financially viable.  Our tentacles extend beyond Nigeria and Africa. We also offer real [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"423\" class=\"elementor elementor-423\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-2e17410 e-flex e-con-boxed e-con e-parent\" data-id=\"2e17410\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-9b9ef07 elementor-widget elementor-widget-heading\" data-id=\"9b9ef07\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Real Estate</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0f5e3ac e-flex e-con-boxed e-con e-parent\" data-id=\"0f5e3ac\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-7d03950 e-con-full e-flex e-con e-child\" data-id=\"7d03950\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-5b9b345 elementor-widget elementor-widget-image\" data-id=\"5b9b345\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/418830588_18214327231282309_7938273413192697691_n-rapdwic84jwte0cx2s8anm1sx11gped8bis6vnt0hg.webp\" title=\"418830588_18214327231282309_7938273413192697691_n\" alt=\"spacious luxury corridor in Lagos suburb\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f6b1fda e-con-full e-flex e-con e-child\" data-id=\"f6b1fda\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-3b44db2 elementor-widget elementor-widget-text-editor\" data-id=\"3b44db2\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">Our real estate services combine <a href=\"https://torretoro.com/architectural-design/\">design expertise</a> with market knowledge to help you acquire, develop, and complete smart property investments.</span></p><p><span style=\"font-weight: 400;\">We work with developers, homeowners, and investors to deliver real estate projects that are not just beautifully designed but also financially viable. </span></p><p><span style=\"font-weight: 400;\">Our tentacles extend beyond Nigeria and Africa. We also offer real estate consultancy services in the UK, USA, Canada, and other locations of your choosing.</span></p><p><span style=\"font-weight: 400;\">Whether you&#8217;re looking to purchase your first home, <a href=\"https://torretoro.com/building-construction/\">develop an estate</a>, or invest in rental property, our client-centric approach ensures quality, style, and long-term value.</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-b6becef e-con-full e-flex e-con e-child\" data-id=\"b6becef\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-c285c29 elementor-widget elementor-widget-image\" data-id=\"c285c29\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/417457976_18213975760282309_8264558768991633262_n-rapdxsebffnu62msw17e4fmw07t8m9uip6h3akkz2a.webp\" title=\"417457976_18213975760282309_8264558768991633262_n\" alt=\"white minimalist city mansion real estate project\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-581d005 e-con-full e-flex e-con e-child\" data-id=\"581d005\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-0b8bef2 elementor-widget elementor-widget-image\" data-id=\"0b8bef2\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/03-qmpcxhcck6tuqrqg2vx7kz3sp4f7dcv36hckawrh88.jpg\" title=\"03.jpg\" alt=\"modern two storey building real estate home\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','home',NULL,NULL,NULL,'[\"Site Feasibility & Market Valuation\",\"Yield Optimization for Commercial Real Estate\",\"Land Acquisition Due Diligence\",\"Portfolio Asset Repositioning\"]',5,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(6,2,'Procurement Services','consultancy-and-procurement','Strategic Vendor Sourcing, Furnishings & Site Logistics','Consultancy and procurement At Torre Tórò, we offer professional consultancy and procurement services to guide you through the practical and regulatory side of building in Nigeria. Our building consultancy includes planning advice, site feasibility, permit support, vendor sourcing, and technical oversight. We also manage the procurement of quality interior finishes and furnishings; handling logistics, vendor [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1527\" class=\"elementor elementor-1527\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-ca3d46b e-flex e-con-boxed e-con e-parent\" data-id=\"ca3d46b\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-f55667b elementor-widget elementor-widget-heading\" data-id=\"f55667b\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Consultancy and procurement</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-7f02815 e-flex e-con-boxed e-con e-parent\" data-id=\"7f02815\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-cac353e e-con-full e-flex e-con e-child\" data-id=\"cac353e\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-a475ee2 elementor-widget elementor-widget-image\" data-id=\"a475ee2\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG-20240526-WA0028-qoq2v0iyjxv14qb38927zv4ef3vkcvhp998z179zuo.jpg\" title=\"IMG-20240526-WA0028\" alt=\"industral working desk procurement\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-d37c8f7 e-con-full e-flex e-con e-child\" data-id=\"d37c8f7\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-27f652a elementor-widget elementor-widget-text-editor\" data-id=\"27f652a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, we offer professional consultancy and procurement services to guide you through the practical and regulatory side of <a href=\"https://torretoro.com/building-construction/\">building in Nigeria</a>.</span></p><p><span style=\"font-weight: 400;\">Our building consultancy includes planning advice, site feasibility, permit support, vendor sourcing, and technical oversight.</span></p><p><span style=\"font-weight: 400;\"> We also manage the procurement of quality interior finishes and furnishings; handling logistics, vendor relations and installation on your behalf.</span></p><p><span style=\"font-weight: 400;\">Whether you’re a private homeowner or a <a href=\"https://torretoro.com/real-estate/\">real estate developer</a>, our consultancy services give you peace of mind and control throughout your build journey.</span></p><p><span style=\"font-weight: 400;\">Need expert guidance? Request a <a href=\"https://torretoro.com/contact-us/\">free consultation</a> now!</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0cf345f e-con-full e-flex e-con e-child\" data-id=\"0cf345f\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-1dfc346 elementor-widget elementor-widget-image\" data-id=\"1dfc346\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG-20240526-WA0033-rapdtveiyaatskblrc9cqf7qwf46joas5sm9b2e0zm.webp\" title=\"IMG-20240526-WA0033\" alt=\"IMG-20240526-WA0033\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0cceec3 e-con-full e-flex e-con e-child\" data-id=\"0cceec3\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-fc4d5dd elementor-widget elementor-widget-image\" data-id=\"fc4d5dd\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG_6819-scaled-rape0k17jvfv1ycaes4qx478q26eyd1sq41yuh8id4.webp\" title=\"IMG_6819\" alt=\"IMG_6819\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','truck',NULL,NULL,NULL,'[\"High-End Furniture & Fixture Direct Sourcing\",\"Import Logistics, Clearance, and Warehousing\",\"Custom Joinery and Millwork Fabrication\",\"Warranty Management & Post-Installation Support\"]',4,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(7,2,'Construction Consultancy','building-construction','Turnkey Building Construction & Engineering Project Management','Building Construction &#038; Project Management​ At Torre Tórò, we understand that even the best architectural design plan requires careful execution. We offer building construction and project management services that turn plans into solid, well-built realities. Our turnkey construction team manages your project with attention to cost, timeline, safety, and finish. From land sourcing and preparing [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1134\" class=\"elementor elementor-1134\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-5bdbe17 e-flex e-con-boxed e-con e-parent\" data-id=\"5bdbe17\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-c27dd68 elementor-widget elementor-widget-heading\" data-id=\"c27dd68\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Building Construction &amp; Project Management​</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f2fa1f0 e-flex e-con-boxed e-con e-parent\" data-id=\"f2fa1f0\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-5760902 e-con-full e-flex e-con e-child\" data-id=\"5760902\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-748e2da elementor-widget elementor-widget-image\" data-id=\"748e2da\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/IMG_2931-2-scaled-rapeaz2tarpo1zcim1bm0yn60hqt5psiz476qycwqc.webp\" title=\"IMG_2931 (2)\" alt=\"onsite building construction project by Torre Tórò,\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-5db5eef e-con-full e-flex e-con e-child\" data-id=\"5db5eef\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-cee42dc elementor-widget elementor-widget-text-editor\" data-id=\"cee42dc\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, we understand that even the best <a href=\"https://torretoro.com/architectural-design/\" target=\"_blank\" rel=\"noopener\">architectural design plan</a> requires careful execution. We offer building construction and project management services that turn plans into solid, well-built realities.</span></p>\n<p><span style=\"font-weight: 400;\">Our turnkey construction team manages your project with attention to cost, timeline, safety, and finish. </span></p>\n<p><span style=\"font-weight: 400;\">From land sourcing and preparing planning applications to overseeing build and <a href=\"https://torretoro.com/interior-design/\" target=\"_blank\" rel=\"noopener\">interior design,</a> our building construction company in Lagos oversees every aspect of the process, ensuring accountability, quality, and alignment with your original intent.</span></p>\n<p><span style=\"font-weight: 400;\">We work with trusted contractors, engineers, and craftsmen to maintain consistency and control across every phase of your project. </span>Our commitment to thoughtful project delivery was recently recognised in <a class=\"\" href=\"https://www.thisdaylive.com/2025/04/18/adeboye-torretoro-strives-to-deliver-sustainable-projects-quality-clients-satisfaction/\" rel=\"noopener\" data-start=\"1083\" data-end=\"1095\">ThisDay</a>.</p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-51921d8 e-con-full e-flex e-con e-child\" data-id=\"51921d8\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-82c0283 elementor-widget elementor-widget-image\" data-id=\"82c0283\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/Torre-Toro-Construction-project-rapdgk0u4s2lbfnxil1mes6nxwqzi1fobvwmjy4t4y.webp\" title=\"Torre Toro Construction project\" alt=\"Construction site worker on a green safety vest\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-dc12d41 e-con-full e-flex e-con e-child\" data-id=\"dc12d41\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-291188e elementor-widget elementor-widget-image\" data-id=\"291188e\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/Torre-Toro-Site-Workers-e1751966200852-rapdgdfysxt7rdnp9k24vpjxj7noobxaa7rmvl5tyw.webp\" title=\"Torre Toro Site Workers\" alt=\"Site workers in Lagos, Nigeria, facilitating a turnkey construction project\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','hammer',NULL,NULL,NULL,'[\"Full Construction Supervision & Quality Control\",\"Timeline, Budget, and Material Cost Auditing\",\"Structural Integrity and Engineering Assurance\",\"Health, Safety, and Environmental Compliance\"]',3,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(8,2,'Commercial Architecture','architectural-design','Architectural Design Services & Workspace Planning','Architectural Design Services in Nigeria At Torre Tórò, our architectural design services in Nigeria goes beyond the scope of what is regular. Architecture has gone beyond just buildings; it is about shaping how people live, work, and feel. As a top architectural firm in Lagos, Nigeria, we design spaces that blend creativity with precision, whether for [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"1130\" class=\"elementor elementor-1130\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-d39f0ef e-flex e-con-boxed e-con e-parent\" data-id=\"d39f0ef\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-0ecf860 elementor-widget elementor-widget-heading\" data-id=\"0ecf860\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Architectural Design Services in Nigeria</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-c5aa4a8 e-flex e-con-boxed e-con e-parent\" data-id=\"c5aa4a8\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-50133c3 e-con-full e-flex e-con e-child\" data-id=\"50133c3\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-075c192 elementor-widget elementor-widget-image\" data-id=\"075c192\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/417457976_18213975760282309_8264558768991633262_n-Copy-rapdy8dknm9qo9ut0j1o86e84gjotf7ik1u8jx912s.webp\" title=\"417457976_18213975760282309_8264558768991633262_n &#8211; Copy\" alt=\"one storey plan architectural design in Nigeria\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-55a7460 e-con-full e-flex e-con e-child\" data-id=\"55a7460\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-fbbee15 elementor-widget elementor-widget-text-editor\" data-id=\"fbbee15\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">At Torre Tórò, our architectural design services in Nigeria goes beyond the scope of what is regular.</span></p><p><span style=\"font-weight: 400;\">Architecture has gone beyond just buildings; it is about shaping how people live, work, and feel. As a top </span><span style=\"font-weight: 400;\">architectural firm in Lagos, Nigeria, we</span><span style=\"font-weight: 400;\"> design spaces that blend creativity with precision, whether for private residences, commercial developments, or institutional projects.</span></p><p><span style=\"font-weight: 400;\">Our approach is rooted in a deep understanding of both traditional Nigerian architecture and contemporary global standards. We <a href=\"https://torretoro.com/interior-design/\">design structures</a> that are functional, culturally grounded, and visually timeless. </span></p><p><span style=\"font-weight: 400;\">Whether you require a </span><span style=\"font-weight: 400;\">house plan in Nigeria</span><span style=\"font-weight: 400;\">, modern family home or a community-focused development, our team of architects in Nigeria offers thoughtful, climate-conscious, and context-aware solutions.</span></p><p><span style=\"font-weight: 400;\">Ready to design something extraordinary? <a href=\"https://torretoro.com/contact-us/\">Book a consultation</a>.</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f13daab e-con-full e-flex e-con e-child\" data-id=\"f13daab\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-2c26d24 elementor-widget elementor-widget-image\" data-id=\"2c26d24\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/05-qmpcxj80xuwdcbxacav7v91puibio5vfle3r2616z8.jpg\" title=\"05.jpg\" alt=\"outdoor greenery, natural surrounding house plan\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-709d575 e-con-full e-flex e-con e-child\" data-id=\"709d575\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-8d0fc9a elementor-widget elementor-widget-image\" data-id=\"8d0fc9a\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img fetchpriority=\"high\" decoding=\"async\" width=\"800\" height=\"539\" src=\"https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-1024x690.webp\" class=\"attachment-large size-large wp-image-242\" alt=\"three bedroom nigerian house plan architectural service\" srcset=\"https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-1024x690.webp 1024w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-300x202.webp 300w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n-768x518.webp 768w, https://torretoro.com/wp-content/uploads/2024/05/417496734_18213975769282309_736400891174266221_n.webp 1080w\" sizes=\"(max-width: 800px) 100vw, 800px\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','building',NULL,NULL,NULL,'[\"Comprehensive 3D Modelling & Architectural Renderings\",\"Space Planning and Workspace Optimization\",\"Regulatory Compliance, Building Permits & Approvals\",\"Sustainable & Biophilic Architecture\"]',1,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(9,2,'Interior Design','interior-design','Functional, Stylish Spaces that Inspire Employees and Impress Clients','We create functional, stylish spaces that inspire employees and impress clients across diverse sectors.','<p>We create functional, stylish spaces that inspire employees and impress clients across diverse sectors.</p><p>Functional, Stylish Spaces that Inspire Employees and Impress Clients. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','brush','/storage/uploads/services/commercial-architecture.jpg','/storage/uploads/services/commercial-architecture.jpg',NULL,'[\"Comprehensive 3D BIM Modelling & Virtual Walkthroughs\",\"Space Planning and Workspace Optimization\",\"Sustainable & Biophilic Material Specification\",\"Color Psychology & Environmental Graphic Integration\"]',5,1,1,'2026-10-23 15:31:27','2026-10-24 01:18:34'),(10,2,'Real Estate Advisory','real-estate','Smart Property Investment, Development Feasibility & Planning','Real Estate Our real estate services combine design expertise with market knowledge to help you acquire, develop, and complete smart property investments. We work with developers, homeowners, and investors to deliver real estate projects that are not just beautifully designed but also financially viable.  Our tentacles extend beyond Nigeria and Africa. We also offer real [&hellip;]','		<div data-elementor-type=\"wp-page\" data-elementor-id=\"423\" class=\"elementor elementor-423\" data-elementor-post-type=\"page\">\n				<div class=\"elementor-element elementor-element-2e17410 e-flex e-con-boxed e-con e-parent\" data-id=\"2e17410\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n				<div class=\"elementor-element elementor-element-9b9ef07 elementor-widget elementor-widget-heading\" data-id=\"9b9ef07\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\n				<div class=\"elementor-widget-container\">\n					<h1 class=\"elementor-heading-title elementor-size-default\">Real Estate</h1>				</div>\n				</div>\n					</div>\n				</div>\n		<div class=\"elementor-element elementor-element-0f5e3ac e-flex e-con-boxed e-con e-parent\" data-id=\"0f5e3ac\" data-element_type=\"container\">\n					<div class=\"e-con-inner\">\n		<div class=\"elementor-element elementor-element-7d03950 e-con-full e-flex e-con e-child\" data-id=\"7d03950\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-5b9b345 elementor-widget elementor-widget-image\" data-id=\"5b9b345\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/418830588_18214327231282309_7938273413192697691_n-rapdwic84jwte0cx2s8anm1sx11gped8bis6vnt0hg.webp\" title=\"418830588_18214327231282309_7938273413192697691_n\" alt=\"spacious luxury corridor in Lagos suburb\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-f6b1fda e-con-full e-flex e-con e-child\" data-id=\"f6b1fda\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-3b44db2 elementor-widget elementor-widget-text-editor\" data-id=\"3b44db2\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\n				<div class=\"elementor-widget-container\">\n									<p><span style=\"font-weight: 400;\">Our real estate services combine <a href=\"https://torretoro.com/architectural-design/\">design expertise</a> with market knowledge to help you acquire, develop, and complete smart property investments.</span></p><p><span style=\"font-weight: 400;\">We work with developers, homeowners, and investors to deliver real estate projects that are not just beautifully designed but also financially viable. </span></p><p><span style=\"font-weight: 400;\">Our tentacles extend beyond Nigeria and Africa. We also offer real estate consultancy services in the UK, USA, Canada, and other locations of your choosing.</span></p><p><span style=\"font-weight: 400;\">Whether you&#8217;re looking to purchase your first home, <a href=\"https://torretoro.com/building-construction/\">develop an estate</a>, or invest in rental property, our client-centric approach ensures quality, style, and long-term value.</span></p>								</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-b6becef e-con-full e-flex e-con e-child\" data-id=\"b6becef\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-c285c29 elementor-widget elementor-widget-image\" data-id=\"c285c29\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/417457976_18213975760282309_8264558768991633262_n-rapdxsebffnu62msw17e4fmw07t8m9uip6h3akkz2a.webp\" title=\"417457976_18213975760282309_8264558768991633262_n\" alt=\"white minimalist city mansion real estate project\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n		<div class=\"elementor-element elementor-element-581d005 e-con-full e-flex e-con e-child\" data-id=\"581d005\" data-element_type=\"container\">\n				<div class=\"elementor-element elementor-element-0b8bef2 elementor-widget elementor-widget-image\" data-id=\"0b8bef2\" data-element_type=\"widget\" data-widget_type=\"image.default\">\n				<div class=\"elementor-widget-container\">\n															<img decoding=\"async\" src=\"https://torretoro.com/wp-content/uploads/elementor/thumbs/03-qmpcxhcck6tuqrqg2vx7kz3sp4f7dcv36hckawrh88.jpg\" title=\"03.jpg\" alt=\"modern two storey building real estate home\" loading=\"lazy\" />															</div>\n				</div>\n				</div>\n					</div>\n				</div>\n				</div>\n		','home',NULL,NULL,NULL,'[\"Site Feasibility & Market Valuation\",\"Yield Optimization for Commercial Real Estate\",\"Land Acquisition Due Diligence\",\"Portfolio Asset Repositioning\"]',5,1,1,'2026-10-23 15:31:27','2026-10-23 15:31:27'),(11,1,'Commercial Interiors','commercial-interiors','Tailored Commercial Interiors Grounded in Workflow & Well-being','Human-centric commercial interiors that elevate workforce productivity and reflect corporate brand identity.','<p>Human-centric commercial interiors that elevate workforce productivity and reflect corporate brand identity.</p><p>Tailored Commercial Interiors Grounded in Workflow & Well-being. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','cube','/storage/uploads/services/commercial-interiors.jpg','/storage/uploads/services/commercial-interiors.jpg',NULL,'[\"Acoustic Planning & Privacy Management\",\"Ergonomic Workstation Layouts & Executive Suites\",\"Brand Identity & Custom Color Harmony\",\"Lighting Concept Design & Visual Comfort\"]',1,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(12,1,'Project Management','project-management','End-to-End Turnkey Execution and Oversight','Our project management team ensures smooth execution, rigorous quality control, and on-time delivery.','<p>Our project management team ensures smooth execution, rigorous quality control, and on-time delivery.</p><p>End-to-End Turnkey Execution and Oversight. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','building','/storage/uploads/services/construction-consultancy.jpg','/storage/uploads/services/construction-consultancy.jpg',NULL,'[\"Master Construction Scheduling & Critical Path Control\",\"Vendor Management & Cost Auditing\",\"Quality Assurance and Site Supervision\",\"Smooth Occupancy & Post-Handover Support\"]',2,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(13,1,'Construction Consultancy','construction-consultancy','Turnkey Engineering & Structural Design Advisory','Engineering expertise, structural safety assessments, and compliance audits for corporate fit-outs.','<p>Engineering expertise, structural safety assessments, and compliance audits for corporate fit-outs.</p><p>Turnkey Engineering & Structural Design Advisory. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','hammer','/storage/uploads/services/construction-consultancy.jpg','/storage/uploads/services/construction-consultancy.jpg',NULL,'[\"Structural Integrity and Engineering Assurance\",\"Timeline, Budget, and Material Cost Auditing\",\"Health, Safety, and Environmental Compliance\",\"Regulatory Approvals & Statutory Building Permits\"]',3,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(14,1,'Procurement & Fit-out','procurement-fit-out','Strategic Materials Procurement and Commercial Grade Fit-outs','We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.','<p>We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.</p><p>Strategic Materials Procurement and Commercial Grade Fit-outs. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','truck','/storage/uploads/services/procurement-services.jpg','/storage/uploads/services/procurement-services.jpg',NULL,'[\"Direct International Furniture & Fixture Sourcing\",\"Custom Joinery and Architectural Millwork\",\"Logistics, Customs Clearance, and White-Glove Installation\",\"Comprehensive Manufacturer Warranty Administration\"]',4,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(15,2,'Commercial Interiors','commercial-interiors','Tailored Commercial Interiors Grounded in Workflow & Well-being','Human-centric commercial interiors that elevate workforce productivity and reflect corporate brand identity.','<p>Human-centric commercial interiors that elevate workforce productivity and reflect corporate brand identity.</p><p>Tailored Commercial Interiors Grounded in Workflow & Well-being. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','cube','/storage/uploads/services/commercial-interiors.jpg','/storage/uploads/services/commercial-interiors.jpg',NULL,'[\"Acoustic Planning & Privacy Management\",\"Ergonomic Workstation Layouts & Executive Suites\",\"Brand Identity & Custom Color Harmony\",\"Lighting Concept Design & Visual Comfort\"]',1,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(16,2,'Project Management','project-management','End-to-End Turnkey Execution and Oversight','Our project management team ensures smooth execution, rigorous quality control, and on-time delivery.','<p>Our project management team ensures smooth execution, rigorous quality control, and on-time delivery.</p><p>End-to-End Turnkey Execution and Oversight. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','building','/storage/uploads/services/construction-consultancy.jpg','/storage/uploads/services/construction-consultancy.jpg',NULL,'[\"Master Construction Scheduling & Critical Path Control\",\"Vendor Management & Cost Auditing\",\"Quality Assurance and Site Supervision\",\"Smooth Occupancy & Post-Handover Support\"]',2,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(17,2,'Construction Consultancy','construction-consultancy','Turnkey Engineering & Structural Design Advisory','Engineering expertise, structural safety assessments, and compliance audits for corporate fit-outs.','<p>Engineering expertise, structural safety assessments, and compliance audits for corporate fit-outs.</p><p>Turnkey Engineering & Structural Design Advisory. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','hammer','/storage/uploads/services/construction-consultancy.jpg','/storage/uploads/services/construction-consultancy.jpg',NULL,'[\"Structural Integrity and Engineering Assurance\",\"Timeline, Budget, and Material Cost Auditing\",\"Health, Safety, and Environmental Compliance\",\"Regulatory Approvals & Statutory Building Permits\"]',3,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(18,2,'Procurement & Fit-out','procurement-fit-out','Strategic Materials Procurement and Commercial Grade Fit-outs','We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.','<p>We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.</p><p>Strategic Materials Procurement and Commercial Grade Fit-outs. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>','truck','/storage/uploads/services/procurement-services.jpg','/storage/uploads/services/procurement-services.jpg',NULL,'[\"Direct International Furniture & Fixture Sourcing\",\"Custom Joinery and Architectural Millwork\",\"Logistics, Customs Clearance, and White-Glove Installation\",\"Comprehensive Manufacturer Warranty Administration\"]',4,1,1,'2026-10-24 01:18:34','2026-10-24 01:18:34');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_domain_id_key_unique` (`domain_id`,`key`),
  CONSTRAINT `settings_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,1,'general','site_name','Torre Tórò','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(2,1,'general','tagline','Designing Spaces that Inspire Success','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(3,1,'header','header_cta_label','Call Us Today','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(4,1,'header','header_phone','+234 813 600 1221','string','2026-10-23 15:22:51','2026-10-27 10:26:13'),(5,1,'footer','copyright_text','Torre Toro Projects © All rights reserved Copyrights 2025','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(6,1,'stats','experience_years','7+','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(7,1,'stats','projects_count','14','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(8,1,'stats','stats_headline','We Govern and Manage Place and Privacy policies','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(9,1,'contact','office_address','16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(10,1,'contact','contact_email','hello@torretoro.com','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(11,1,'contact','contact_phone','+234 813 600 1221','string','2026-10-23 15:22:51','2026-10-27 10:26:13'),(12,2,'general','site_name','Torre Tórò','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(13,2,'general','tagline','Designing Spaces that Inspire Success','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(14,2,'header','header_cta_label','Call Us Today','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(15,2,'header','header_phone','+2348136001221','string','2026-10-23 15:22:51','2026-10-27 12:17:16'),(16,2,'footer','copyright_text','Torre Toro Projects © All rights reserved Copyrights 2025','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(17,2,'stats','experience_years','7+','string','2026-10-23 15:22:51','2026-10-24 01:17:19'),(18,2,'stats','projects_count','14','string','2026-10-23 15:22:51','2026-10-24 01:17:20'),(19,2,'stats','stats_headline','We Govern and Manage Place and Privacy policies','string','2026-10-23 15:22:51','2026-10-23 15:22:51'),(20,2,'contact','office_address','Flat 21, Aschcroft Square, King Street, London, United Kingdom, W6 OYH','string','2026-10-23 15:22:51','2026-10-27 12:17:16'),(21,2,'contact','contact_email','uk@torretoro.co.uk','string','2026-10-23 15:22:51','2026-10-27 12:17:16'),(22,2,'contact','contact_phone','+2348136001221','string','2026-10-23 15:22:51','2026-10-27 12:17:16'),(23,1,'contact','google_maps_embed','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.28822368425!2d3.3768466!3d6.4851214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8c1995a5d8e7%3A0x6b245c38db4fefb3!2s366%20Murtala%20Muhammed%20Way%2C%20Yaba%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng','string','2026-10-23 18:03:08','2026-10-23 18:03:08'),(24,1,'contact','google_maps_directions','https://maps.google.com/?cid=13929622342407962470&g_mp=CiVnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLkdldFBsYWNlEAMYASAF','string','2026-10-23 18:03:08','2026-10-23 18:03:48'),(25,1,'branding','site_logo','/storage/uploads/branding/logo.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(26,1,'branding','site_logo_white','/storage/uploads/branding/logo-white.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(27,1,'branding','site_symbol','/storage/uploads/branding/logo-symbol.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(28,1,'branding','site_symbol_white','/storage/uploads/branding/logo-symbol-white.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(29,1,'branding','site_favicon','/storage/uploads/branding/favicon.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(30,1,'branding','site_video','/storage/uploads/branding/corporate-logo.mp4','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(31,1,'contact','contact_email_secondary','dami@torretoro.com','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(32,1,'contact','contact_phone_secondary','+234 011 336 54','string','2026-10-24 01:17:19','2026-10-27 10:26:13'),(33,2,'branding','site_logo','/storage/uploads/branding/logo.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(34,2,'branding','site_logo_white','/storage/uploads/branding/logo-white.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(35,2,'branding','site_symbol','/storage/uploads/branding/logo-symbol.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(36,2,'branding','site_symbol_white','/storage/uploads/branding/logo-symbol-white.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(37,2,'branding','site_favicon','/storage/uploads/branding/favicon.png','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(38,2,'branding','site_video','/storage/uploads/branding/corporate-logo.mp4','string','2026-10-24 01:17:19','2026-10-24 01:17:19'),(39,2,'contact','contact_email_secondary','help@torretoro.co.uk','string','2026-10-24 01:17:20','2026-10-27 12:17:16'),(40,2,'contact','contact_phone_secondary','+238136001221','string','2026-10-24 01:17:20','2026-10-27 12:17:16'),(41,1,'contact','secondary_email','dami@torretoro.com','string','2026-10-27 10:26:13','2026-10-27 10:26:13'),(42,1,'contact','secondary_phone','+234 011 336 54','string','2026-10-27 10:26:13','2026-10-27 10:26:13'),(43,1,'contact','office_hours','Monday - Friday: 8:00 AM - 6:00 PM','string','2026-10-27 10:26:13','2026-10-27 10:26:13'),(44,2,'contact','secondary_email','help@torretoro.co.uk','string','2026-10-27 10:26:13','2026-10-27 12:17:16'),(45,2,'contact','secondary_phone','+238136001221','string','2026-10-27 10:26:13','2026-10-27 12:17:16'),(46,2,'contact','office_hours','Monday - Friday: 8:00 AM - 6:00 PM','string','2026-10-27 10:26:13','2026-10-27 10:26:13'),(47,2,'contact','google_maps_embed','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2484.1214734488626!2d-0.2318179230360523!3d51.4926383117812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48760fb5fc037da7%3A0x6547d58926a5cedd!2sAshcroft%20Square!5e0!3m2!1sen!2sng!4v1793106910874!5m2!1sen!2sng','string','2026-10-27 12:17:16','2026-10-27 12:17:16'),(48,2,'contact','google_maps_directions','https://www.google.com/maps/place/Ashcroft+Square','string','2026-10-27 12:17:16','2026-10-27 12:26:47');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_role` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `quote` text NOT NULL,
  `avatar_image` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_domain_id_foreign` (`domain_id`),
  CONSTRAINT `testimonials_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,1,'Sanlam Project Director','Head of Facilities & Infrastructure','Sanlam Insurance Group','Torre Tórò delivered a transformative workspace that exceeded our expectations. The attention to acoustic detail, ergonomic flow, and turnkey delivery was impeccable.',NULL,5,1,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(2,1,'GTBank Facilities Lead','Infrastructure Project Manager','GTBank Headquarters','Their construction consultancy and interior architecture team executed our headquarters wellness center seamlessly within an active building environment.',NULL,5,1,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(3,2,'Sanlam Project Director','Head of Facilities & Infrastructure','Sanlam Insurance Group','Torre Tórò delivered a transformative workspace that exceeded our expectations. The attention to acoustic detail, ergonomic flow, and turnkey delivery was impeccable.',NULL,5,1,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(4,2,'GTBank Facilities Lead','Infrastructure Project Manager','GTBank Headquarters','Their construction consultancy and interior architecture team executed our headquarters wellness center seamlessly within an active building environment.',NULL,5,1,'2026-10-23 15:24:42','2026-10-23 15:24:42'),(5,1,'Mrs Jacobo','Client','Office Interior Design in Abuja, Nigeria.','As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.','/storage/uploads/team/adeboye-damilola.png',5,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(6,1,'Sanlam Facilities Director','Head of Infrastructure','Sanlam Insurance Group','Torre Tórò delivered a transformative workspace that exceeded our expectations. The attention to acoustic detail, ergonomic flow, and turnkey delivery was impeccable.','/storage/uploads/team/oludara-samuel.jpg',5,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(7,2,'Mrs Jacobo','Client','Office Interior Design in Abuja, Nigeria.','As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.','/storage/uploads/team/adeboye-damilola.png',5,1,'2026-10-24 01:18:34','2026-10-24 01:18:34'),(8,2,'Sanlam Facilities Director','Head of Infrastructure','Sanlam Insurance Group','Torre Tórò delivered a transformative workspace that exceeded our expectations. The attention to acoustic detail, ergonomic flow, and turnkey delivery was impeccable.','/storage/uploads/team/oludara-samuel.jpg',5,1,'2026-10-24 01:18:34','2026-10-24 01:18:34');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'editor',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Torre Tórò Admin','admin@torretoro.com','super_admin',NULL,NULL,1,NULL,'$2y$12$nTmWLaledZwrJq0BHhor3uQ4us7DvpF9QUrIhXUsl8nS4bnF4OI1y',NULL,'2026-10-23 16:00:00','2026-10-24 01:15:45');
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

-- Dump completed on 2026-10-27 17:50:19
