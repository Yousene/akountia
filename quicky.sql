-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for automanage
DROP DATABASE IF EXISTS `automanage`;
CREATE DATABASE IF NOT EXISTS `automanage` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `automanage`;

-- Dumping structure for table automanage.apparences
CREATE TABLE IF NOT EXISTS `apparences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_home` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_sidebar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_sidebar_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_menu_actif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table automanage.apparences: ~0 rows (approximately)

-- Dumping structure for table automanage.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `facture_id` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table automanage.employees: ~0 rows (approximately)

-- Dumping structure for table automanage.factures
CREATE TABLE IF NOT EXISTS `factures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table automanage.factures: ~0 rows (approximately)

-- Dumping structure for table automanage.fonctionnalites
CREATE TABLE IF NOT EXISTS `fonctionnalites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.fonctionnalites: ~0 rows (approximately)

-- Dumping structure for table automanage.fonctionnalites_ressources
CREATE TABLE IF NOT EXISTS `fonctionnalites_ressources` (
  `fonctionnalite_id` int DEFAULT NULL,
  `ressource_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.fonctionnalites_ressources: ~0 rows (approximately)

-- Dumping structure for table automanage.fonctionnalites_routes
CREATE TABLE IF NOT EXISTS `fonctionnalites_routes` (
  `fonctionnalite_id` int DEFAULT NULL,
  `route` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.fonctionnalites_routes: ~0 rows (approximately)

-- Dumping structure for table automanage.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.jobs: ~13 rows (approximately)
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(41, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:22:\\"gotawsil2020@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"3990baba-4d07-4644-a6d7-dee31bbb282a\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1660905765, 1660905765),
	(42, 'default', '{"displayName":"App\\\\Notifications\\\\forgetPassword","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:20:\\"adwdahmani@gmail.com\\";}}s:12:\\"notification\\";O:32:\\"App\\\\Notifications\\\\forgetPassword\\":10:{s:8:\\"\\u0000*\\u0000token\\";s:64:\\"jBMDH6vDRduQi56SZPbiP3399vpbocDL2rUHtZRwCSMhjLlKhiJyNaPD2yBXTMnQ\\";s:2:\\"id\\";s:36:\\"c7e123fb-2535-4bcb-8dbd-bac2dd47831d\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1661173826, 1661173826),
	(43, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:22:\\"gotawsil2020@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"5691c09d-702d-43e6-8736-7398742718ba\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662238647, 1662238647),
	(44, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:20:\\"adwdahmani@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"2621411b-8deb-41cc-8503-c25ac2a0374c\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662238647, 1662238647),
	(45, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:24:\\"mahmoud.oudada@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"0156e0e8-25d1-4833-a725-57c4482491a5\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662238647, 1662238647),
	(46, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:22:\\"gotawsil2020@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"cd924868-8136-48fd-b253-04b8361c5208\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662240224, 1662240224),
	(47, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:20:\\"adwdahmani@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"1954003e-386f-49da-9ab0-757e9081e1f4\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662240224, 1662240224),
	(48, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:24:\\"mahmoud.oudada@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"e14f0780-38ea-4382-b694-8873e6f7eced\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662240224, 1662240224),
	(49, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:22:\\"gotawsil2020@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"65a9fa42-1ac6-4499-8295-7abf64648a53\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662241005, 1662241005),
	(50, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:20:\\"adwdahmani@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"4b13de3e-1af8-4c72-a96d-ff63fb03327e\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662241005, 1662241005),
	(51, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:24:\\"mahmoud.oudada@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"7bd3f843-db08-49d0-88da-deddeb521028\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662241005, 1662241005),
	(52, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:20:\\"adwdahmani@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"7a03b7e6-ef66-45b2-b0ad-0a70a7cbaa6b\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662241291, 1662241291),
	(53, 'default', '{"displayName":"App\\\\Notifications\\\\remboursementEmail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:44:\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\":1:{s:6:\\"routes\\";a:1:{s:4:\\"mail\\";s:24:\\"mahmoud.oudada@gmail.com\\";}}s:12:\\"notification\\";O:36:\\"App\\\\Notifications\\\\remboursementEmail\\":9:{s:2:\\"id\\";s:36:\\"34063e62-f2a4-42d3-947c-4d181d3195f8\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1662241291, 1662241291);

-- Dumping structure for table automanage.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ressource` int DEFAULT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table automanage.menus: ~6 rows (approximately)
INSERT INTO `menus` (`id`, `titre`, `page`, `parent_menu`, `ordre`, `ressource`, `statut`, `icon`, `roles`, `desc`, `deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Tableaux de bord', 'admin', NULL, '1', NULL, '1', 'pie_chart', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:21:10', '2022-09-06 21:37:04'),
	(2, 'Sécurité', NULL, NULL, '5', NULL, '1', 'verified_user', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:22:07', '2022-09-10 20:37:10'),
	(3, 'Utilisateurs', 'user_list', '2', '2', NULL, '1', 'people', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:27:56', '2022-09-06 21:55:24'),
	(4, 'Rôles', 'role_list', '2', '2', NULL, '1', 'check_box', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:28:51', '2022-09-06 21:28:51'),
	(5, 'Paramétrage', NULL, NULL, '6', NULL, '1', 'settings', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:55:02', '2023-01-21 20:28:31'),
	(26, 'Gestion du menu', 'menu_list', '5', '1', NULL, '1', 'dehaze', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2023-01-21 20:28:12', '2023-01-21 20:28:12');

-- Dumping structure for table automanage.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2021_08_12_201319_create_jobs_table', 2),
	(29, '2023_07_18_144142_quickyproject_table', 3),
	(30, '2023_07_21_203113_facture_table', 3),
	(31, '2023_07_22_150021_employee_table', 3);

-- Dumping structure for table automanage.parameters
CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `villes_depart` varchar(500) DEFAULT NULL,
  `tauxtva` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.parameters: ~0 rows (approximately)
INSERT INTO `parameters` (`id`, `villes_depart`, `tauxtva`, `created_at`, `updated_at`) VALUES
	(1, '2,38', '20', NULL, '2022-07-11 23:19:01');

-- Dumping structure for table automanage.quickyprojects
CREATE TABLE IF NOT EXISTS `quickyprojects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id_project` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table automanage.quickyprojects: ~0 rows (approximately)
INSERT INTO `quickyprojects` (`id`, `name`, `id_project`, `deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'User', 'User', 0, NULL, NULL, NULL, NULL, '2023-07-23 00:56:38', '2023-07-23 00:56:38'),
	(2, 'Role', 'Role', 0, NULL, NULL, NULL, NULL, '2023-07-23 00:56:52', '2023-07-23 00:56:52'),
	(3, 'Menu', 'Menu', 0, NULL, NULL, NULL, NULL, '2023-07-23 00:57:12', '2023-07-23 00:57:12'),
	(4, 'Apparence', 'Apparence', 0, NULL, NULL, NULL, NULL, '2023-07-23 00:59:35', '2023-07-23 00:59:35'),
	(5, 'Ressource', 'Ressource', 0, NULL, NULL, NULL, NULL, '2023-07-23 00:59:58', '2023-07-23 00:59:58'),
	(6, 'Fonctionnalite', 'Fonctionnalite', 0, NULL, NULL, NULL, NULL, '2023-07-23 01:00:15', '2023-07-23 01:00:15'),
	(7, 'Quickyproject', 'Quickyproject', 0, NULL, NULL, NULL, NULL, '2023-07-23 01:00:33', '2023-07-23 01:00:33');

-- Dumping structure for table automanage.ressources
CREATE TABLE IF NOT EXISTS `ressources` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `desc` longtext,
  `deleted` bigint NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.ressources: ~0 rows (approximately)

-- Dumping structure for table automanage.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(250) DEFAULT NULL,
  `desc` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.roles: ~0 rows (approximately)
INSERT INTO `roles` (`id`, `label`, `desc`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(1, 'Administrateur', NULL, '2022-02-26 07:51:58', NULL, '2022-02-26 07:51:58', NULL, 0, NULL, NULL);

-- Dumping structure for table automanage.roles_droits
CREATE TABLE IF NOT EXISTS `roles_droits` (
  `role_id` int NOT NULL,
  `droit_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.roles_droits: ~0 rows (approximately)

-- Dumping structure for table automanage.roles_fonctionnalites
CREATE TABLE IF NOT EXISTS `roles_fonctionnalites` (
  `role_id` int NOT NULL,
  `fonctionnalite_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.roles_fonctionnalites: ~0 rows (approximately)

-- Dumping structure for table automanage.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` int DEFAULT NULL,
  `type` int NOT NULL DEFAULT '1',
  `client` int DEFAULT NULL,
  `employe` int DEFAULT NULL,
  `login` varchar(250) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `confirmation_token` varchar(500) DEFAULT NULL,
  `token` varchar(500) GENERATED ALWAYS AS (md5(`password`)) VIRTUAL,
  `photo` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `activated_by` int DEFAULT NULL,
  `validated` int DEFAULT '0',
  `validated_at` timestamp NULL DEFAULT NULL,
  `validated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `role`, `type`, `client`, `employe`, `login`, `password`, `name`, `first_name`, `email`, `email_verified_at`, `remember_token`, `confirmation_token`, `photo`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`, `activated_at`, `activated_by`, `validated`, `validated_at`, `validated_by`) VALUES
	(3, 1, 1, NULL, 2, 'admin', '$2y$10$KkQo3KLNpYgXUUvvOHkHWORh0jXMqqbi34d6sFZRxtGoN5Kn2WjgO', 'Admin', 'Admin', '', NULL, NULL, NULL, 'profil.jpg', '2022-02-01 11:56:49', NULL, '2023-01-21 19:21:19', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, NULL),
	(4, 1, 1, NULL, NULL, 'test', '$2y$10$pWKAqAOWwqm5lO8xCMgFmu9e//iWJQB.Y//yHJIAydh4FIfzwNJUq', 'test', 'test', NULL, NULL, NULL, NULL, NULL, '2023-01-21 19:23:57', NULL, '2023-01-21 19:25:52', NULL, 1, '2023-01-21 19:25:52', 1, NULL, NULL, 1, NULL, NULL);

-- Dumping structure for table automanage.users_droits
CREATE TABLE IF NOT EXISTS `users_droits` (
  `user_id` int DEFAULT NULL,
  `droit_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table automanage.users_droits: ~333 rows (approximately)
INSERT INTO `users_droits` (`user_id`, `droit_id`) VALUES
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 4),
	(10, 5),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 13),
	(10, 14),
	(10, 15),
	(10, 16),
	(10, 17),
	(10, 18),
	(10, 19),
	(10, 20),
	(10, 21),
	(10, 22),
	(10, 23),
	(10, 24),
	(10, 25),
	(10, 26),
	(10, 27),
	(10, 28),
	(10, 29),
	(10, 30),
	(10, 31),
	(10, 32),
	(10, 33),
	(10, 34),
	(10, 35),
	(10, 36),
	(10, 37),
	(10, 38),
	(10, 39),
	(10, 40),
	(10, 41),
	(10, 42),
	(10, 43),
	(10, 44),
	(10, 45),
	(10, 46),
	(10, 47),
	(10, 48),
	(10, 49),
	(10, 50),
	(10, 51),
	(10, 52),
	(10, 53),
	(10, 54),
	(10, 55),
	(10, 56),
	(10, 57),
	(10, 58),
	(10, 59),
	(10, 60),
	(10, 61),
	(10, 62),
	(10, 63),
	(10, 64),
	(10, 65),
	(10, 66),
	(10, 67),
	(10, 68),
	(10, 69),
	(10, 70),
	(13, 2),
	(13, 3),
	(13, 6),
	(13, 7),
	(13, 8),
	(13, 9),
	(13, 10),
	(13, 11),
	(13, 12),
	(13, 13),
	(13, 14),
	(13, 15),
	(13, 16),
	(13, 37),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 4),
	(10, 5),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 13),
	(10, 14),
	(10, 15),
	(10, 16),
	(10, 17),
	(10, 18),
	(10, 19),
	(10, 20),
	(10, 21),
	(10, 22),
	(10, 23),
	(10, 24),
	(10, 25),
	(10, 26),
	(10, 27),
	(10, 28),
	(10, 29),
	(10, 30),
	(10, 31),
	(10, 32),
	(10, 33),
	(10, 34),
	(10, 35),
	(10, 36),
	(10, 37),
	(10, 38),
	(10, 39),
	(10, 40),
	(10, 41),
	(10, 42),
	(10, 43),
	(10, 44),
	(10, 45),
	(10, 46),
	(10, 47),
	(10, 48),
	(10, 49),
	(10, 50),
	(10, 51),
	(10, 52),
	(10, 53),
	(10, 54),
	(10, 55),
	(10, 56),
	(10, 57),
	(10, 58),
	(10, 59),
	(10, 60),
	(10, 61),
	(10, 62),
	(10, 63),
	(10, 64),
	(10, 65),
	(10, 66),
	(10, 67),
	(10, 68),
	(10, 69),
	(10, 70),
	(13, 2),
	(13, 3),
	(13, 6),
	(13, 7),
	(13, 8),
	(13, 9),
	(13, 10),
	(13, 11),
	(13, 12),
	(13, 13),
	(13, 14),
	(13, 15),
	(13, 16),
	(13, 37),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 4),
	(10, 5),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11),
	(10, 12),
	(10, 13),
	(10, 14),
	(10, 15),
	(10, 16),
	(10, 17),
	(10, 18),
	(10, 19),
	(10, 20),
	(10, 21),
	(10, 22),
	(10, 23),
	(10, 24),
	(10, 25),
	(10, 26),
	(10, 27),
	(10, 28),
	(10, 29),
	(10, 30),
	(10, 31),
	(10, 32),
	(10, 33),
	(10, 34),
	(10, 35),
	(10, 36),
	(10, 37),
	(10, 38),
	(10, 39),
	(10, 40),
	(10, 41),
	(10, 42),
	(10, 43),
	(10, 44),
	(10, 45),
	(10, 46),
	(10, 47),
	(10, 48),
	(10, 49),
	(10, 50),
	(10, 51),
	(10, 52),
	(10, 53),
	(10, 54),
	(10, 55),
	(10, 56),
	(10, 57),
	(10, 58),
	(10, 59),
	(10, 60),
	(10, 61),
	(10, 62),
	(10, 63),
	(10, 64),
	(10, 65),
	(10, 66),
	(10, 67),
	(10, 68),
	(10, 69),
	(10, 70),
	(13, 2),
	(13, 3),
	(13, 6),
	(13, 7),
	(13, 8),
	(13, 9),
	(13, 10),
	(13, 11),
	(13, 12),
	(13, 13),
	(13, 14),
	(13, 15),
	(13, 16),
	(13, 37);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
