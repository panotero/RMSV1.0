-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: rmsdb
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.24-MariaDB

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
-- Table structure for table `applicant_checklist_items`
--

DROP TABLE IF EXISTS `applicant_checklist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant_checklist_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint(20) unsigned NOT NULL,
  `checklist_item_id` bigint(20) unsigned NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0,
  `done_at` timestamp NULL DEFAULT NULL,
  `done_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_checklist_items_applicant_id_foreign` (`applicant_id`),
  KEY `applicant_checklist_items_checklist_item_id_foreign` (`checklist_item_id`),
  KEY `applicant_checklist_items_done_by_foreign` (`done_by`),
  CONSTRAINT `applicant_checklist_items_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_checklist_items_checklist_item_id_foreign` FOREIGN KEY (`checklist_item_id`) REFERENCES `checklist_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_checklist_items_done_by_foreign` FOREIGN KEY (`done_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_checklist_items`
--

LOCK TABLES `applicant_checklist_items` WRITE;
/*!40000 ALTER TABLE `applicant_checklist_items` DISABLE KEYS */;
INSERT INTO `applicant_checklist_items` VALUES (12,5,7,1,'2026-08-04 11:21:15',1,'2026-08-04 11:20:35','2026-08-04 11:21:15'),(13,5,8,1,'2026-08-04 11:21:20',1,'2026-08-04 11:20:35','2026-08-04 11:21:20'),(23,17,7,1,'2026-08-04 18:29:48',1,'2026-08-04 18:13:44','2026-08-04 18:29:48'),(24,17,8,1,'2026-08-04 18:29:50',1,'2026-08-04 18:13:44','2026-08-04 18:29:50'),(25,17,15,1,'2026-08-04 18:29:49',1,'2026-08-04 18:13:44','2026-08-04 18:29:49'),(26,15,7,1,'2026-08-04 18:34:15',1,'2026-08-04 18:18:06','2026-08-04 18:34:15'),(27,15,8,1,'2026-08-04 18:34:15',1,'2026-08-04 18:18:06','2026-08-04 18:34:15'),(28,15,15,1,'2026-08-04 18:34:14',1,'2026-08-04 18:18:06','2026-08-04 18:34:14'),(33,19,7,1,'2026-08-05 17:23:08',1,'2026-08-04 18:37:22','2026-08-05 17:23:08'),(34,19,8,1,'2026-08-05 17:23:08',1,'2026-08-04 18:37:22','2026-08-05 17:23:08'),(35,19,15,1,'2026-08-05 17:23:09',1,'2026-08-04 18:37:22','2026-08-05 17:23:09'),(36,19,17,0,NULL,NULL,'2026-08-04 18:40:55','2026-08-04 18:40:55'),(37,19,18,0,NULL,NULL,'2026-08-04 18:40:55','2026-08-04 18:40:55'),(38,19,19,0,NULL,NULL,'2026-08-04 18:40:55','2026-08-04 18:40:55'),(39,20,7,1,'2026-08-04 18:42:35',1,'2026-08-04 18:42:22','2026-08-04 18:42:35'),(40,20,8,1,'2026-08-04 18:42:36',1,'2026-08-04 18:42:22','2026-08-04 18:42:36'),(41,20,15,1,'2026-08-04 18:42:35',1,'2026-08-04 18:42:22','2026-08-04 18:42:35'),(42,20,17,1,'2026-08-04 18:42:38',1,'2026-08-04 18:42:22','2026-08-04 18:42:38'),(43,20,18,1,'2026-08-04 18:42:38',1,'2026-08-04 18:42:22','2026-08-04 18:42:38'),(44,20,19,1,'2026-08-04 18:42:39',1,'2026-08-04 18:42:22','2026-08-04 18:42:39');
/*!40000 ALTER TABLE `applicant_checklist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_files`
--

DROP TABLE IF EXISTS `applicant_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint(20) unsigned NOT NULL,
  `field_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_files_applicant_id_foreign` (`applicant_id`),
  CONSTRAINT `applicant_files_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_files`
--

LOCK TABLES `applicant_files` WRITE;
/*!40000 ALTER TABLE `applicant_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_notes`
--

DROP TABLE IF EXISTS `applicant_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint(20) unsigned NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_notes_applicant_id_foreign` (`applicant_id`),
  KEY `applicant_notes_created_by_foreign` (`created_by`),
  CONSTRAINT `applicant_notes_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_notes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_notes`
--

LOCK TABLES `applicant_notes` WRITE;
/*!40000 ALTER TABLE `applicant_notes` DISABLE KEYS */;
INSERT INTO `applicant_notes` VALUES (4,9,'note po',1,'2026-08-04 18:04:59','2026-08-04 18:04:59'),(5,9,'note ule',1,'2026-08-04 18:05:04','2026-08-04 18:05:04'),(6,15,'asdadwsaddw',1,'2026-08-04 18:06:32','2026-08-04 18:06:32'),(7,17,'aweawdad',1,'2026-08-04 18:12:51','2026-08-04 18:12:51'),(8,15,'asdadaawdasdadaw',1,'2026-08-04 18:31:14','2026-08-04 18:31:14'),(9,15,'noshow',1,'2026-08-04 18:31:19','2026-08-04 18:31:19'),(10,19,'test',1,'2026-08-04 18:35:44','2026-08-04 18:35:44'),(11,20,'qweqweqe',1,'2026-08-04 18:41:32','2026-08-04 18:41:32');
/*!40000 ALTER TABLE `applicant_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_orientation_history`
--

DROP TABLE IF EXISTS `applicant_orientation_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant_orientation_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_orientation_id` bigint(20) unsigned NOT NULL,
  `event_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_date` date NOT NULL,
  `changed_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_orientation_history_applicant_orientation_id_foreign` (`applicant_orientation_id`),
  KEY `applicant_orientation_history_changed_by_foreign` (`changed_by`),
  CONSTRAINT `applicant_orientation_history_applicant_orientation_id_foreign` FOREIGN KEY (`applicant_orientation_id`) REFERENCES `applicant_orientations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_orientation_history_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_orientation_history`
--

LOCK TABLES `applicant_orientation_history` WRITE;
/*!40000 ALTER TABLE `applicant_orientation_history` DISABLE KEYS */;
INSERT INTO `applicant_orientation_history` VALUES (6,4,'rescheduled','2026-08-09',1,'2026-08-05 17:32:09','2026-08-05 17:32:09'),(7,5,'rescheduled','2026-08-08',1,'2026-08-05 17:32:23','2026-08-05 17:32:23'),(8,3,'rescheduled','2026-08-08',1,'2026-08-05 17:40:45','2026-08-05 17:40:45'),(9,4,'rescheduled','2026-08-08',1,'2026-08-05 17:40:54','2026-08-05 17:40:54');
/*!40000 ALTER TABLE `applicant_orientation_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_orientations`
--

DROP TABLE IF EXISTS `applicant_orientations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant_orientations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint(20) unsigned NOT NULL,
  `scheduled_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Scheduled',
  `scheduled_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_orientations_applicant_id_unique` (`applicant_id`),
  KEY `applicant_orientations_scheduled_by_foreign` (`scheduled_by`),
  CONSTRAINT `applicant_orientations_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_orientations_scheduled_by_foreign` FOREIGN KEY (`scheduled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_orientations`
--

LOCK TABLES `applicant_orientations` WRITE;
/*!40000 ALTER TABLE `applicant_orientations` DISABLE KEYS */;
INSERT INTO `applicant_orientations` VALUES (3,17,'2026-08-08','Rescheduled',1,'2026-08-04 18:14:29','2026-08-05 17:40:45'),(4,15,'2026-08-08','Rescheduled',1,'2026-08-04 18:34:23','2026-08-05 17:40:54'),(5,19,'2026-08-08','Rescheduled',1,'2026-08-04 18:39:52','2026-08-05 17:32:23');
/*!40000 ALTER TABLE `applicant_orientations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicants`
--

DROP TABLE IF EXISTS `applicants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint(20) unsigned DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `source_id` bigint(20) unsigned DEFAULT NULL,
  `source_detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `assigned_to` bigint(20) unsigned NOT NULL,
  `team_id` bigint(20) unsigned DEFAULT NULL,
  `form_id` bigint(20) unsigned NOT NULL,
  `form_version` int(11) NOT NULL,
  `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`form_data`)),
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `interview_summary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicants_location_id_foreign` (`location_id`),
  KEY `applicants_form_id_foreign` (`form_id`),
  KEY `applicants_team_id_index` (`team_id`),
  KEY `applicants_assigned_to_index` (`assigned_to`),
  KEY `applicants_status_index` (`status`),
  KEY `applicants_role_id_foreign` (`role_id`),
  KEY `applicants_source_id_foreign` (`source_id`),
  CONSTRAINT `applicants_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicants_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `recruitment_forms` (`id`),
  CONSTRAINT `applicants_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `applicants_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `applicants_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `applicants_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicants`
--

LOCK TABLES `applicants` WRITE;
/*!40000 ALTER TABLE `applicants` DISABLE KEYS */;
INSERT INTO `applicants` VALUES (5,'putres',8,NULL,NULL,NULL,'Hired',1,NULL,1,1,'{\"dementia_experience\":\"Yes\",\"hospice_experience\":\"Yes\",\"bedbound\":\"Yes\",\"incontinence_experience\":\"Yes\",\"auto_insurance\":\"Yes\",\"drivers_license\":\"Yes\",\"okay_transport\":\"Yes\",\"okay_with_male_female\":\"Yes\",\"okay_with_smokers\":\"Yes\",\"okay_with_pets\":\"Yes\",\"is_smoker\":\"Yes\",\"cpr_fa_cert\":\"Yes\",\"has_allergies\":\"No\",\"tb_skin_test_current\":\"Yes\",\"catheter_experience\":\"Yes\",\"slide_board_experience\":\"Yes\",\"gait_belt_experience\":\"Yes\",\"hoyer_lift_experience\":\"Yes\",\"pivot_transfer_experience\":\"Yes\",\"referral_source\":\"LinkedIn\",\"has_relative_at_company\":\"Yes\",\"first_application\":\"Yes\",\"couples_care\":\"Yes\",\"expected_salary\":\"18\",\"meal_prep\":\"Yes\",\"covid_vaccinated\":\"Yes\",\"certificates\":[\"Companion\",\"PCA\",\"CNA\",\"HHA\"],\"interested_pca_certification\":\"Yes\",\"earliest_availability_date\":\"2026-08-01\",\"latest_availability_date\":\"2026-08-01\",\"other_notes\":\"tawdasdawdasdawd\"}','2026-08-04 11:21:31','2026-08-04 11:20:01','2026-08-04 11:21:31',NULL,NULL,NULL,NULL),(9,'Verify Flow Test',NULL,NULL,NULL,NULL,'New',1,1,1,1,'[]','2026-08-04 17:50:54','2026-08-04 17:50:54','2026-08-04 17:50:54',NULL,NULL,NULL,NULL),(15,'test',32,27,1,NULL,'Orientation',1,1,1,1,'{\"dementia_experience\":\"Yes\",\"hospice_experience\":\"Yes\",\"bedbound\":\"Yes\",\"incontinence_experience\":\"Yes\",\"auto_insurance\":\"Yes\",\"drivers_license\":\"Yes\",\"okay_transport\":\"Yes\",\"okay_with_male_female\":\"Yes\",\"okay_with_smokers\":\"Yes\",\"okay_with_pets\":\"Yes\",\"is_smoker\":\"Yes\",\"cpr_fa_cert\":\"Yes\",\"has_allergies\":\"No\",\"tb_skin_test_current\":\"Yes\",\"catheter_experience\":\"Yes\",\"slide_board_experience\":\"Yes\",\"gait_belt_experience\":\"Yes\",\"hoyer_lift_experience\":\"Yes\",\"pivot_transfer_experience\":\"Yes\",\"has_relative_at_company\":\"Yes\",\"first_application\":\"Yes\",\"couples_care\":\"Yes\",\"expected_salary\":\"15\",\"meal_prep\":\"Yes\",\"covid_vaccinated\":\"Yes\",\"certificates\":[\"Companion\",\"PCA\",\"CNA\",\"HHA\"],\"interested_pca_certification\":\"Yes\",\"earliest_availability_date\":\"2026-08-01\",\"latest_availability_date\":\"2026-08-08\",\"other_notes\":\"wrqweqeqdwqdwq\"}','2026-08-04 18:34:15','2026-08-04 18:06:32','2026-08-04 18:34:15','123','qwe@email.com','2026-07-26','asdadawdasdadw'),(17,'testtest',32,27,5,'qweqwe','Orientation',1,1,1,1,'{\"dementia_experience\":\"Yes\",\"hospice_experience\":\"Yes\",\"bedbound\":\"Yes\",\"incontinence_experience\":\"Yes\",\"auto_insurance\":\"Yes\",\"drivers_license\":\"Yes\",\"okay_transport\":\"Yes\",\"okay_with_male_female\":\"Yes\",\"okay_with_smokers\":\"Yes\",\"okay_with_pets\":\"Yes\",\"is_smoker\":\"Yes\",\"cpr_fa_cert\":\"Yes\",\"has_allergies\":\"No\",\"tb_skin_test_current\":\"Yes\",\"catheter_experience\":\"Yes\",\"slide_board_experience\":\"Yes\",\"gait_belt_experience\":\"No\",\"hoyer_lift_experience\":\"Yes\",\"pivot_transfer_experience\":\"Yes\",\"has_relative_at_company\":\"Yes\",\"first_application\":\"Yes\",\"couples_care\":\"Yes\",\"expected_salary\":\"123\",\"meal_prep\":\"Yes\",\"covid_vaccinated\":\"Yes\",\"certificates\":[\"Companion\",\"PCA\",\"CNA\",\"HHA\"],\"interested_pca_certification\":\"Yes\",\"earliest_availability_date\":\"2026-08-01\",\"latest_availability_date\":\"2026-08-01\",\"other_notes\":\"qweqeqweqew\"}','2026-08-04 18:29:50','2026-08-04 18:12:51','2026-08-04 18:29:50','123123','qwe@email.com','2026-07-01',NULL),(19,'Madelaine Ann Bengero',32,27,2,'kung sino sino nalang','Orientation',1,1,1,2,'{\"dementia_experience\":\"Yes\",\"hospice_experience\":\"Yes\",\"bedbound\":\"Yes\",\"incontinence_experience\":\"Yes\",\"auto_insurance\":\"Yes\",\"drivers_license\":\"Yes\",\"okay_transport\":\"Yes\",\"okay_with_male_female\":\"Yes\",\"okay_with_smokers\":\"Yes\",\"okay_with_pets\":\"Yes\",\"is_smoker\":\"Yes\",\"cpr_fa_cert\":\"Yes\",\"has_allergies\":\"No\",\"tb_skin_test_current\":\"Yes\",\"catheter_experience\":\"Yes\",\"slide_board_experience\":\"Yes\",\"gait_belt_experience\":\"Yes\",\"hoyer_lift_experience\":\"Yes\",\"pivot_transfer_experience\":\"Yes\",\"has_relative_at_company\":\"Yes\",\"first_application\":\"Yes\",\"couples_care\":\"Yes\",\"expected_salary\":\"15\",\"meal_prep\":\"Yes\",\"covid_vaccinated\":\"Yes\",\"certificates\":[\"PCA\"],\"interested_pca_certification\":\"Yes\",\"earliest_availability_date\":\"2026-08-01\",\"other_notes\":\"anak ng tokwa\",\"employee_name_2\":\"test\"}','2026-08-05 17:23:09','2026-08-04 18:35:44','2026-08-05 17:23:09','123','test@email.com','2026-08-01',NULL),(20,'test1',32,27,1,NULL,'Hired',1,1,1,1,'{\"dementia_experience\":\"Yes\",\"hospice_experience\":\"Yes\",\"bedbound\":\"Yes\",\"incontinence_experience\":\"Yes\",\"auto_insurance\":\"Yes\",\"drivers_license\":\"Yes\",\"okay_transport\":\"Yes\",\"okay_with_male_female\":\"Yes\",\"okay_with_smokers\":\"Yes\",\"okay_with_pets\":\"Yes\",\"is_smoker\":\"Yes\",\"cpr_fa_cert\":\"Yes\",\"has_allergies\":\"No\",\"tb_skin_test_current\":\"Yes\",\"catheter_experience\":\"Yes\",\"slide_board_experience\":\"Yes\",\"gait_belt_experience\":\"Yes\",\"hoyer_lift_experience\":\"Yes\",\"pivot_transfer_experience\":\"Yes\",\"has_relative_at_company\":\"Yes\",\"first_application\":\"Yes\",\"couples_care\":\"Yes\",\"expected_salary\":\"12\",\"meal_prep\":\"Yes\",\"covid_vaccinated\":\"Yes\",\"certificates\":[\"Companion\"],\"interested_pca_certification\":\"Yes\",\"earliest_availability_date\":\"2026-08-08\",\"latest_availability_date\":\"2026-08-15\",\"other_notes\":\"qweqweqqew\"}','2026-08-04 18:42:39','2026-08-04 18:41:32','2026-08-04 18:42:39','123123','test@email.com','2026-08-01',NULL);
/*!40000 ALTER TABLE `applicants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('management_system_cache_f1f70ec40aaa556905d4a030501c0ba4','i:1;',1785955721),('management_system_cache_f1f70ec40aaa556905d4a030501c0ba4:timer','i:1785955721;',1785955721);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `checklist_groups`
--

DROP TABLE IF EXISTS `checklist_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist_groups`
--

LOCK TABLES `checklist_groups` WRITE;
/*!40000 ALTER TABLE `checklist_groups` DISABLE KEYS */;
INSERT INTO `checklist_groups` VALUES (5,'Initial Checklist','Orientation',1,1,'2026-08-04 17:54:55','2026-08-04 17:54:55'),(7,'after orentation checklist','Hired',2,1,'2026-08-04 18:38:54','2026-08-04 18:38:54');
/*!40000 ALTER TABLE `checklist_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklist_items`
--

DROP TABLE IF EXISTS `checklist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checklist_group_id` bigint(20) unsigned DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checklist_items_checklist_group_id_foreign` (`checklist_group_id`),
  CONSTRAINT `checklist_items_checklist_group_id_foreign` FOREIGN KEY (`checklist_group_id`) REFERENCES `checklist_groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist_items`
--

LOCK TABLES `checklist_items` WRITE;
/*!40000 ALTER TABLE `checklist_items` DISABLE KEYS */;
INSERT INTO `checklist_items` VALUES (7,'Docu Sign',5,1,1,'2026-08-04 11:03:20','2026-08-04 17:55:56'),(8,'test',5,2,1,'2026-08-04 11:20:22','2026-08-04 17:56:00'),(15,'Test 1',5,1,1,'2026-08-04 17:55:50','2026-08-04 17:55:50'),(17,'e verify',7,1,1,'2026-08-04 18:39:09','2026-08-04 18:39:09'),(18,'adp',7,2,1,'2026-08-04 18:39:17','2026-08-04 18:39:17'),(19,'drop box',7,3,1,'2026-08-04 18:39:22','2026-08-04 18:39:22');
/*!40000 ALTER TABLE `checklist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"8dc870c0-81b9-40f1-9039-87c330169ae3\",\"displayName\":\"App\\\\Jobs\\\\SendApplicationMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendApplicationMailJob\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\SendApplicationMailJob\\\":2:{s:10:\\\"\\u0000*\\u0000payload\\\";a:4:{s:7:\\\"subject\\\";s:19:\\\"New applicant added\\\";s:5:\\\"title\\\";s:19:\\\"New applicant added\\\";s:7:\\\"message\\\";s:43:\\\"Test Member added applicant Jane Applicant.\\\";s:6:\\\"button\\\";a:2:{s:3:\\\"url\\\";s:40:\\\"http:\\/\\/rms.test\\/page_applicant_view?id=3\\\";s:4:\\\"text\\\";s:14:\\\"View applicant\\\";}}s:9:\\\"\\u0000*\\u0000userId\\\";i:2;}\"}}',0,NULL,1785838605,1785838605),(2,'default','{\"uuid\":\"faec26ad-f03e-41c0-8711-7bab743515fd\",\"displayName\":\"App\\\\Jobs\\\\SendApplicationMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendApplicationMailJob\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\SendApplicationMailJob\\\":2:{s:10:\\\"\\u0000*\\u0000payload\\\";a:4:{s:7:\\\"subject\\\";s:19:\\\"New applicant added\\\";s:5:\\\"title\\\";s:19:\\\"New applicant added\\\";s:7:\\\"message\\\";s:43:\\\"Test Member added applicant Jane Applicant.\\\";s:6:\\\"button\\\";a:2:{s:3:\\\"url\\\";s:40:\\\"http:\\/\\/rms.test\\/page_applicant_view?id=4\\\";s:4:\\\"text\\\";s:14:\\\"View applicant\\\";}}s:9:\\\"\\u0000*\\u0000userId\\\";i:5;}\"}}',0,NULL,1785838643,1785838643);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup_list_items`
--

DROP TABLE IF EXISTS `lookup_list_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookup_list_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lookup_list_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lookup_list_items_lookup_list_id_foreign` (`lookup_list_id`),
  KEY `lookup_list_items_parent_id_foreign` (`parent_id`),
  CONSTRAINT `lookup_list_items_lookup_list_id_foreign` FOREIGN KEY (`lookup_list_id`) REFERENCES `lookup_lists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lookup_list_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `lookup_list_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup_list_items`
--

LOCK TABLES `lookup_list_items` WRITE;
/*!40000 ALTER TABLE `lookup_list_items` DISABLE KEYS */;
INSERT INTO `lookup_list_items` VALUES (1,2,NULL,'LinkedIn',1,1,'2026-08-04 10:00:42','2026-08-04 14:12:47'),(2,2,NULL,'Employee Referral',2,1,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(3,2,NULL,'Job Board',3,1,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(4,2,NULL,'Walk-in',4,1,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(5,2,NULL,'Other',5,1,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(8,1,NULL,'location 1',0,1,'2026-08-04 11:12:23','2026-08-04 16:41:41'),(9,1,NULL,'location 2',1,1,'2026-08-04 11:12:27','2026-08-04 16:41:41'),(20,4,NULL,'New',1,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(21,4,NULL,'In Review',2,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(22,4,NULL,'Interview',3,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(23,4,NULL,'Orientation',5,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(24,4,NULL,'Offer',6,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(25,4,NULL,'Hired',7,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(26,4,NULL,'Rejected',8,1,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(27,5,NULL,'PCA',1,1,'2026-08-04 18:01:05','2026-08-04 18:01:05'),(28,5,NULL,'CNA',2,1,'2026-08-04 18:01:11','2026-08-04 18:01:11'),(29,5,NULL,'HHA',3,1,'2026-08-04 18:01:23','2026-08-04 18:01:23'),(30,5,NULL,'Comapnion Care',4,1,'2026-08-04 18:01:31','2026-08-04 18:01:31'),(31,5,NULL,'Caregiver',5,1,'2026-08-04 18:01:37','2026-08-04 18:01:37'),(32,1,8,'location 1.1',1,1,'2026-08-04 18:06:00','2026-08-04 18:06:00'),(33,1,8,'location 1.2',2,1,'2026-08-04 18:06:00','2026-08-04 18:06:00'),(34,4,NULL,'Passed',4,1,'2026-08-04 18:23:02','2026-08-04 18:23:02');
/*!40000 ALTER TABLE `lookup_list_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup_lists`
--

DROP TABLE IF EXISTS `lookup_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookup_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lookup_lists_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup_lists`
--

LOCK TABLES `lookup_lists` WRITE;
/*!40000 ALTER TABLE `lookup_lists` DISABLE KEYS */;
INSERT INTO `lookup_lists` VALUES (1,'territory','Territory','Location','2026-08-04 10:00:42','2026-08-04 10:00:42'),(2,'source','Referral Source',NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(4,'status','Status',NULL,'2026-08-04 17:25:43','2026-08-04 17:25:43'),(5,'role','Role',NULL,'2026-08-04 17:25:43','2026-08-04 17:25:43');
/*!40000 ALTER TABLE `lookup_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailer_settings`
--

DROP TABLE IF EXISTS `mailer_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailer_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mail_mailer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_encryption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailer_settings`
--

LOCK TABLES `mailer_settings` WRITE;
/*!40000 ALTER TABLE `mailer_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailer_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_10_01_211540_create_nav_menus_table',1),(6,'2025_10_02_163004_create_table_for_settings_role',1),(7,'2025_10_03_180527_add_parentmenu',1),(8,'2025_10_04_144632_create_mailer_settings_table',1),(9,'2025_11_06_035725_insert_order_in_nav_menus',1),(10,'2026_01_24_221131_create_sessions_table',1),(11,'2026_01_24_221645_add_session_id_to_users_table',1),(12,'2026_01_24_223037_create_cache_table',1),(13,'2026_01_26_110424_create_jobs_table',1),(14,'2026_01_26_110425_modify_columns_of_user_table',1),(15,'2026_07_29_010100_create_user_department_table',1),(16,'2026_07_29_010200_create_user_status_table',1),(17,'2026_07_29_010300_add_department_id_to_users_table',1),(18,'2026_07_29_010400_create_teams_table',1),(19,'2026_07_29_010500_add_team_columns_to_users_table',1),(20,'2026_07_29_010600_add_is_system_to_setting_role_table',1),(21,'2026_07_29_010700_create_permissions_table',1),(22,'2026_07_29_010800_create_role_permission_table',1),(23,'2026_07_29_010900_create_nav_icons_table',1),(24,'2026_08_04_000001_create_notifications_table',2),(25,'2026_08_04_000010_create_recruitment_forms_table',3),(26,'2026_08_04_000011_create_lookup_lists_table',3),(27,'2026_08_04_000012_create_lookup_list_items_table',3),(28,'2026_08_04_000013_create_recruitment_form_fields_table',3),(29,'2026_08_04_000014_create_checklist_items_table',3),(30,'2026_08_04_000015_create_applicants_table',3),(31,'2026_08_04_000016_create_applicant_files_table',3),(32,'2026_08_04_000017_create_applicant_checklist_items_table',3),(33,'2026_08_04_000020_add_condition_columns_to_recruitment_form_fields_table',4),(34,'2026_08_04_000021_add_parent_id_to_lookup_list_items_table',5),(35,'2026_08_04_000022_rename_location_lookup_list_to_territory',5),(36,'2026_08_04_000023_add_options_source_list_id_to_recruitment_form_fields_table',6),(37,'2026_08_04_000024_add_child_label_to_lookup_lists_table',7),(38,'2026_08_05_000001_create_checklist_groups_table',8),(39,'2026_08_05_000002_add_checklist_group_id_to_checklist_items_table',8),(40,'2026_08_05_000001_add_intake_fields_to_applicants_table',9),(41,'2026_08_05_000002_create_applicant_notes_table',9),(42,'2026_08_05_000003_create_applicant_orientations_table',9),(43,'2026_08_05_000004_add_source_detail_to_applicants_table',10),(44,'2026_08_05_000005_add_passed_status_lookup_item',11),(45,'2026_08_06_000001_add_status_to_applicant_orientations_table',12),(46,'2026_08_06_000002_create_applicant_orientation_history_table',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nav_icons`
--

DROP TABLE IF EXISTS `nav_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nav_icons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `svg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nav_icons_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav_icons`
--

LOCK TABLES `nav_icons` WRITE;
/*!40000 ALTER TABLE `nav_icons` DISABLE KEYS */;
INSERT INTO `nav_icons` VALUES (1,'home','Home','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(2,'users','Users','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-4.5 0 2.625 2.625 0 014.5 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(3,'user','User','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(4,'bell','Bell','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(5,'magnifying-glass','Search','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m21 21-5.2-5.2m0 0A7.5 7.5 0 1 0 5.3 5.3a7.5 7.5 0 0 0 10.5 10.5Z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(6,'x-mark','Close (X)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(7,'check-circle','Check Circle','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(8,'document-text','Document','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(9,'sparkles','Sparkles','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.456-2.456L14.25 6l1.035-.259a3.375 3.375 0 002.456-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(10,'cube','Box / Cube','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(11,'envelope','Envelope','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(12,'bars-3','Menu (3 lines)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(13,'cog-6-tooth','Settings (gear)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28zM15 12a3 3 0 11-6 0 3 3 0 016 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(14,'chevron-down','Chevron Down','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 8.25l-7.5 7.5-7.5-7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(15,'chevron-up','Chevron Up','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4.5 15.75l7.5-7.5 7.5 7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(16,'chevron-left','Chevron Left','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15.75 19.5L8.25 12l7.5-7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(17,'chevron-right','Chevron Right','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M8.25 4.5l7.5 7.5-7.5 7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(18,'plus','Plus','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 4.5v15m7.5-7.5h-15\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(19,'minus','Minus','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M5 12h14\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(20,'arrow-path','Refresh','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(21,'arrow-up-tray','Upload','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(22,'arrow-down-tray','Download','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(23,'trash','Trash','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(24,'pencil','Edit (pencil)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(25,'eye','Eye','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .638C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(26,'eye-slash','Eye Slash','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.98 8.223A10.477 10.477 0 001.934 12c1.832 4.068 5.728 7 10.066 7 1.676 0 3.285-.37 4.712-1.034M6.228 6.228A10.45 10.45 0 0112 5c4.38 0 8.293 2.953 10.07 7.063a10.522 10.522 0 01-4.517 4.92M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.878 9.878\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(27,'clock','Clock','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(28,'calendar','Calendar','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(29,'truck','Truck','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(30,'archive-box','Archive Box','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(31,'banknotes','Finance (banknotes)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(32,'building-office','Building / Office','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(33,'globe-alt','Globe','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(34,'shield-check','Shield Check','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(35,'exclamation-triangle','Warning Triangle','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(36,'information-circle','Info Circle','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(37,'flag','Flag','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(38,'star','Star','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(39,'heart','Heart','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(40,'tag','Tag','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6 6h.008v.008H6V6z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(41,'folder-open','Folder','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 015.25 3.75h4.5c.55 0 1.02.398 1.11.94l.213 1.28c.089.542.559.94 1.11.94h4.567a2.25 2.25 0 012.25 2.25v.616\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(42,'briefcase','Briefcase','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18a48.424 48.424 0 01-6.378.42c-2.162 0-4.291-.143-6.378-.42-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(43,'map-pin','Map Pin','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 10.5a3 3 0 11-6 0 3 3 0 016 0z\" /><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(44,'link','Link','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(45,'paper-airplane','Send (paper airplane)','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(46,'printer','Printer','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(47,'square','Square','<rect x=\"3.75\" y=\"3.75\" width=\"16.5\" height=\"16.5\" rx=\"2\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(48,'circle','Circle','<circle cx=\"12\" cy=\"12\" r=\"8.25\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(49,'squares-2x2','Grid','<rect x=\"3.75\" y=\"3.75\" width=\"7.5\" height=\"7.5\" rx=\"1.25\" /><rect x=\"12.75\" y=\"3.75\" width=\"7.5\" height=\"7.5\" rx=\"1.25\" /><rect x=\"3.75\" y=\"12.75\" width=\"7.5\" height=\"7.5\" rx=\"1.25\" /><rect x=\"12.75\" y=\"12.75\" width=\"7.5\" height=\"7.5\" rx=\"1.25\" />','2026-08-04 04:40:52','2026-08-04 04:40:52'),(50,'list-bullet','List','<circle cx=\"4.5\" cy=\"6\" r=\"1\" fill=\"currentColor\" stroke=\"none\" /><circle cx=\"4.5\" cy=\"12\" r=\"1\" fill=\"currentColor\" stroke=\"none\" /><circle cx=\"4.5\" cy=\"18\" r=\"1\" fill=\"currentColor\" stroke=\"none\" /><line x1=\"8.25\" y1=\"6\" x2=\"20.25\" y2=\"6\" stroke-linecap=\"round\" /><line x1=\"8.25\" y1=\"12\" x2=\"20.25\" y2=\"12\" stroke-linecap=\"round\" /><line x1=\"8.25\" y1=\"18\" x2=\"20.25\" y2=\"18\" stroke-linecap=\"round\" />','2026-08-04 04:40:52','2026-08-04 04:40:52');
/*!40000 ALTER TABLE `nav_icons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nav_menus`
--

DROP TABLE IF EXISTS `nav_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nav_menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowed_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`allowed_roles`)),
  `parent_menu` int(11) NOT NULL DEFAULT 0,
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav_menus`
--

LOCK TABLES `nav_menus` WRITE;
/*!40000 ALTER TABLE `nav_menus` DISABLE KEYS */;
INSERT INTO `nav_menus` VALUES (1,'Dashboard','home','/page_dashboard','[\"1\"]',0,0,'2026-08-04 04:40:52','2026-08-04 17:25:47'),(2,'Users','users','/page_usermanagement','[\"1\"]',0,2,'2026-08-04 04:40:52','2026-08-04 17:25:47'),(3,'Team Management','briefcase','/page_team_management','[\"1\"]',0,3,'2026-08-04 04:40:52','2026-08-04 17:25:47'),(4,'Developer Option','shield-check','#','[\"1\"]',0,5,'2026-08-04 04:40:52','2026-08-04 17:25:47'),(5,'Mailer','envelope','/page_mailer','[\"1\"]',4,1,'2026-08-04 04:40:52','2026-08-04 04:40:52'),(6,'Menus','bars-3','/page_menus','[\"1\"]',4,2,'2026-08-04 04:40:52','2026-08-04 04:40:52'),(7,'Notification Test','bell','/page_notification_test','[\"1\"]',4,3,'2026-08-04 04:58:36','2026-08-04 04:58:36'),(8,'Recruitment','user','#','[\"1\",\"2\",\"3\",\"4\"]',0,1,'2026-08-04 10:04:53','2026-08-04 17:25:47'),(9,'App Settings','cog-6-tooth','/page_app_settings','[\"2\",\"4\",\"1\"]',0,4,'2026-08-04 10:04:53','2026-08-04 18:31:56'),(10,'Applicants','list-bullet','/page_applicants','[\"1\",\"2\",\"3\",\"4\"]',8,1,'2026-08-04 10:04:53','2026-08-04 10:04:53'),(12,'Orientation Schedule','calendar','/page_orientation_schedule','[\"1\",\"2\",\"3\",\"4\"]',8,2,'2026-08-04 17:25:47','2026-08-04 17:25:47');
/*!40000 ALTER TABLE `nav_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifiable_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `from_user_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  KEY `notifications_from_user_id_foreign` (`from_user_id`),
  KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `notifications_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'test.manual',NULL,NULL,1,1,'test','test','test','test',NULL,1,'2026-08-04 05:01:01','2026-08-04 05:08:18'),(2,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:58','2026-08-04 05:08:18'),(3,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:58','2026-08-04 05:08:18'),(4,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:58','2026-08-04 05:08:18'),(5,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:58','2026-08-04 05:08:18'),(6,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:59','2026-08-04 05:08:18'),(7,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:59','2026-08-04 05:08:18'),(8,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:03:59','2026-08-04 05:08:18'),(9,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:00','2026-08-04 05:08:18'),(10,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:00','2026-08-04 05:08:18'),(11,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:00','2026-08-04 05:08:18'),(12,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:00','2026-08-04 05:08:18'),(13,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:01','2026-08-04 05:08:18'),(14,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:01','2026-08-04 05:08:18'),(15,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:01','2026-08-04 05:08:18'),(16,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:01','2026-08-04 05:08:18'),(17,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:02','2026-08-04 05:08:18'),(18,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:02','2026-08-04 05:08:18'),(19,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:02','2026-08-04 05:08:18'),(20,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:02','2026-08-04 05:08:18'),(21,'test.manual',NULL,NULL,1,1,'test','test',NULL,NULL,NULL,1,'2026-08-04 05:04:03','2026-08-04 05:08:18');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'roles.manage','Manage roles & permissions','Roles','2026-08-04 04:40:52','2026-08-04 04:40:52');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
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
-- Table structure for table `recruitment_form_fields`
--

DROP TABLE IF EXISTS `recruitment_form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recruitment_form_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) unsigned NOT NULL,
  `field_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `options_source_list_id` bigint(20) unsigned DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `file_rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`file_rules`)),
  `help_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_field_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recruitment_form_fields_form_id_field_key_unique` (`form_id`,`field_key`),
  KEY `recruitment_form_fields_options_source_list_id_foreign` (`options_source_list_id`),
  CONSTRAINT `recruitment_form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `recruitment_forms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recruitment_form_fields_options_source_list_id_foreign` FOREIGN KEY (`options_source_list_id`) REFERENCES `lookup_lists` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recruitment_form_fields`
--

LOCK TABLES `recruitment_form_fields` WRITE;
/*!40000 ALTER TABLE `recruitment_form_fields` DISABLE KEYS */;
INSERT INTO `recruitment_form_fields` VALUES (1,1,'dementia_experience','Dementia Experience','select','[\"Yes\",\"No\"]',NULL,1,1,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(2,1,'hospice_experience','Hospice Experience','select','[\"Yes\",\"No\"]',NULL,1,2,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(3,1,'bedbound','Bedbound','select','[\"Yes\",\"No\"]',NULL,1,3,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(4,1,'incontinence_experience','Incontinence Experience','select','[\"Yes\",\"No\"]',NULL,1,4,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(5,1,'auto_insurance','Auto Insurance','select','[\"Yes\",\"No\"]',NULL,1,5,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(6,1,'auto_insurance_note','Auto Insurance Note','text',NULL,NULL,0,6,1,NULL,'If No — e.g. beneficiary on an existing policy','auto_insurance','No','2026-08-04 10:00:42','2026-08-04 10:47:47'),(7,1,'drivers_license','Driver\'s License','select','[\"Yes\",\"No\"]',NULL,1,7,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(8,1,'okay_transport','Okay with Transport','select','[\"Yes\",\"No\"]',NULL,1,8,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(9,1,'okay_with_male_female','Okay with Male/Female Clients','select','[\"Yes\",\"No\"]',NULL,1,9,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(10,1,'okay_with_smokers','Okay with Smokers','select','[\"Yes\",\"No\"]',NULL,1,10,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(11,1,'okay_with_pets','Okay with Pets','select','[\"Yes\",\"No\"]',NULL,1,11,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(12,1,'is_smoker','Are You a Smoker?','select','[\"Yes\",\"No\"]',NULL,1,12,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(13,1,'cpr_fa_cert','CPR & First Aid Certified?','select','[\"Yes\",\"No\"]',NULL,1,13,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(14,1,'has_allergies','Any Allergies?','select','[\"Yes\",\"No\"]',NULL,1,14,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(15,1,'allergies_detail','Allergy Details','text',NULL,NULL,0,15,1,NULL,'List allergies if yes','has_allergies','Yes','2026-08-04 10:00:42','2026-08-04 10:47:47'),(16,1,'tb_skin_test_current','Current TB Skin Test?','select','[\"Yes\",\"No\"]',NULL,1,16,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(17,1,'catheter_experience','Catheter Client Experience?','select','[\"Yes\",\"No\"]',NULL,1,17,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(18,1,'slide_board_experience','Slide Board Experience','select','[\"Yes\",\"No\"]',NULL,1,18,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(19,1,'gait_belt_experience','Gait Belt Experience','select','[\"Yes\",\"No\"]',NULL,1,19,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(20,1,'hoyer_lift_experience','Hoyer Lift Experience','select','[\"Yes\",\"No\"]',NULL,1,20,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(21,1,'pivot_transfer_experience','Pivot Transfer Experience','select','[\"Yes\",\"No\"]',NULL,1,21,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(22,1,'referral_source','How Did You Hear About This Opening?','select',NULL,2,1,22,0,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 17:25:43'),(23,1,'has_relative_at_company','Do you have a relative at Comfort Keepers?','select','[\"Yes\",\"No\"]',NULL,1,23,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 18:46:36'),(24,1,'first_application','Is This Your First Application?','select','[\"Yes\",\"No\"]',NULL,1,24,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(25,1,'couples_care','Couples Care','select','[\"Yes\",\"No\"]',NULL,1,25,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(26,1,'expected_salary','Expected Salary','text',NULL,NULL,1,26,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(27,1,'meal_prep','Meal Prep','select','[\"Yes\",\"No\"]',NULL,1,27,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(28,1,'covid_vaccinated','COVID Vaccinated','select','[\"Yes\",\"No\"]',NULL,1,28,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(29,1,'certificates','Certificates Held','checkbox','[\"Companion\",\"PCA\",\"CNA\",\"HHA\"]',NULL,0,29,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(30,1,'interested_pca_certification','Interested in Getting PCA Certified?','select','[\"Yes\",\"No\"]',NULL,1,30,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(31,1,'earliest_availability_date','Availability Notes','text',NULL,NULL,1,31,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 18:45:22'),(32,1,'latest_availability_date','Latest Availability Date','date',NULL,NULL,1,32,0,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 18:45:07'),(33,1,'other_notes','Other Notes','textarea',NULL,NULL,0,33,1,NULL,NULL,NULL,NULL,'2026-08-04 10:00:42','2026-08-04 10:00:42'),(36,1,'need_sex','need sex?','select','[\"Yes\",\"No\"]',NULL,0,34,0,NULL,'sex later?',NULL,NULL,'2026-08-04 11:09:39','2026-08-04 11:10:05'),(37,1,'employee_name','Employee Name','text',NULL,NULL,0,35,1,NULL,NULL,'referral_source','Employee Referral','2026-08-04 11:17:39','2026-08-04 11:17:39'),(39,1,'employee_name_2','Employee Name','text',NULL,NULL,0,36,1,NULL,NULL,'has_relative_at_company','Yes','2026-08-04 18:46:57','2026-08-04 18:47:34');
/*!40000 ALTER TABLE `recruitment_form_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recruitment_forms`
--

DROP TABLE IF EXISTS `recruitment_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recruitment_forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recruitment_forms`
--

LOCK TABLES `recruitment_forms` WRITE;
/*!40000 ALTER TABLE `recruitment_forms` DISABLE KEYS */;
INSERT INTO `recruitment_forms` VALUES (1,'Caregiver Application',2,1,'2026-08-04 10:00:42','2026-08-04 18:44:58');
/*!40000 ALTER TABLE `recruitment_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permission_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `role_permission_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `setting_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` VALUES (1,1,1);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('4rgXf38pGtjXoL2LpopYNsY7OdmhuKq2p7w9l61o',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.28.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic1NzR1RXbXNVZ1BTTXFEOHUxcGpVV2I1VXpMN3ZVbTQzUms1QXVPbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9ybXMudGVzdC8/aGVyZD1wcmV2aWV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785905050),('hIAtWSEGp8Rq9XwMwTph8X2GH6nCggX4zGHtScTz',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.28.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibENtSlpnTzNsRDQybjVseGN0bDBzbldUdFlzeW41WGpnTWZOQ1psRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9ybXMudGVzdC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785905050),('S1CqofMnduuICoxwk12kDXAqRLJRmce49apLyJon',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWRVUzVKMXRBM3Nsc200dGlZTVBuTjNVbWI4MUNOekd4OXJBN0M5SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9ybXMudGVzdC9hcGkvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1785955661),('tjmcvJhXuuH3gy2tuUV6uTLK2mEYEIpHBw9ciEod',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.28.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicEhUR3JKOUJiTFp5eGpvQ05BNGhLYjZHRktPM2h6VjlZVDd2SHNwZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9ybXMudGVzdC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785837129),('TRiGkludvshiUTpqvKCaem7gb7MdKtOe5XQzlcW1',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOWxyQWR0VGFLU1FaV29FcktrRTNLQ040SGNISm1kdjRjSGN2NzZ0NCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovL3Jtcy50ZXN0L2FwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vcm1zLnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785941506),('ZtjGwJMWpyfuDJutEkGalLUdTG07b2IoCGcELQ3u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.28.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnFySWg3TVlUWHFvblRTQmtMN2dTbTYxNTNWSHZocTZhTTRRUWJldCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9ybXMudGVzdC8/aGVyZD1wcmV2aWV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785837127);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_role`
--

DROP TABLE IF EXISTS `setting_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_role`
--

LOCK TABLES `setting_role` WRITE;
/*!40000 ALTER TABLE `setting_role` DISABLE KEYS */;
INSERT INTO `setting_role` VALUES (1,'superadmin',1),(2,'admin',1),(3,'user',1),(4,'developer',1);
/*!40000 ALTER TABLE `setting_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_parent_id_foreign` (`parent_id`),
  CONSTRAINT `teams_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Off-Shore PH','Philippine Off Shore Team',NULL,1,'2026-08-04 09:58:17','2026-08-04 09:58:17');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_department`
--

DROP TABLE IF EXISTS `user_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_department`
--

LOCK TABLES `user_department` WRITE;
/*!40000 ALTER TABLE `user_department` DISABLE KEYS */;
INSERT INTO `user_department` VALUES (1,'Sales Department','2026-08-04 04:40:52','2026-08-04 04:40:52'),(2,'Operations Department','2026-08-04 04:40:52','2026-08-04 04:40:52');
/*!40000 ALTER TABLE `user_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'Active','2026-08-04 04:40:52','2026-08-04 04:40:52'),(2,'Inactive','2026-08-04 04:40:52','2026-08-04 04:40:52'),(3,'Suspended','2026-08-04 04:40:52','2026-08-04 04:40:52'),(4,'Pending','2026-08-04 04:40:52','2026-08-04 04:40:52');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `team_id` bigint(20) unsigned DEFAULT NULL,
  `is_team_leader` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_team_id_foreign` (`team_id`),
  CONSTRAINT `users_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Developer','superadmin@email.com',NULL,'$2y$12$LPVqU0kZ/qN1aYkAKmA42O1lrIoqSBvrBg8SegV6.gmqUYiEFlC3K',NULL,'1',0,NULL,NULL,'2026-08-04 04:40:52','2026-08-04 11:26:52',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'rmsdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-06  2:47:57
