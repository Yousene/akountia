-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2023 at 09:48 PM
-- Server version: 5.7.29
-- PHP Version: 7.3.31-1~deb10u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quicky`
--

-- --------------------------------------------------------

--
-- Table structure for table `apparences`
--

CREATE TABLE IF NOT EXISTS `apparences` (
  `id` bigint(20) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_home` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_sidebar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_sidebar_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur_menu_actif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` bigint(20) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonctionnalites`
--

CREATE TABLE IF NOT EXISTS `fonctionnalites` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `deleted` bigint(20) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fonctionnalites_ressources`
--

CREATE TABLE IF NOT EXISTS `fonctionnalites_ressources` (
  `fonctionnalite_id` int(11) DEFAULT NULL,
  `ressource_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fonctionnalites_routes`
--

CREATE TABLE IF NOT EXISTS `fonctionnalites_routes` (
  `fonctionnalite_id` int(11) DEFAULT NULL,
  `route` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint(20) unsigned NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_menu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ressource` int(11) DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci,
  `deleted` bigint(20) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `titre`, `page`, `parent_menu`, `ordre`, `ressource`, `statut`, `icon`, `roles`, `desc`, `deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Tableaux de bord', 'admin', NULL, '1', NULL, '1', 'pie_chart', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:21:10', '2022-09-06 21:37:04'),
(2, 'SÃ©curitÃ©', NULL, NULL, '5', NULL, '1', 'verified_user', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:22:07', '2022-09-10 20:37:10'),
(3, 'Utilisateurs', 'user_list', '2', '2', NULL, '1', 'people', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:27:56', '2022-09-06 21:55:24'),
(4, 'RÃ´les', 'role_list', '2', '2', NULL, '1', 'check_box', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:28:51', '2022-09-06 21:28:51'),
(5, 'ParamÃ©trage', NULL, NULL, '6', NULL, '1', 'settings', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2022-09-06 21:55:02', '2023-01-21 20:28:31'),
(26, 'Gestion du menu', 'menu_list', '5', '1', NULL, '1', 'dehaze', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2023-01-21 20:28:12', '2023-01-21 20:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_08_12_201319_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL,
  `villes_depart` varchar(500) DEFAULT NULL,
  `tauxtva` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `villes_depart`, `tauxtva`, `created_at`, `updated_at`) VALUES
(1, '2,38', '20', NULL, '2022-07-11 23:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `ressources`
--

CREATE TABLE IF NOT EXISTS `ressources` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` longtext,
  `deleted` bigint(20) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `label` varchar(250) DEFAULT NULL,
  `desc` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `label`, `desc`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Administrateur', NULL, '2022-02-26 07:51:58', NULL, '2022-02-26 07:51:58', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles_droits`
--

CREATE TABLE IF NOT EXISTS `roles_droits` (
  `role_id` int(11) NOT NULL,
  `droit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles_fonctionnalites`
--

CREATE TABLE IF NOT EXISTS `roles_fonctionnalites` (
  `role_id` int(11) NOT NULL,
  `fonctionnalite_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL,
  `role` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `client` int(11) DEFAULT NULL,
  `employe` int(11) DEFAULT NULL,
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
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `activated_by` int(11) DEFAULT NULL,
  `validated` int(11) DEFAULT '0',
  `validated_at` timestamp NULL DEFAULT NULL,
  `validated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (role`, `type`, `client`, `employe`, `login`, `password`, `name`, `first_name`, `email`, `email_verified_at`, `remember_token`, `confirmation_token`, `photo`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`, `activated_at`, `activated_by`, `validated`, `validated_at`, `validated_by`) VALUES
(1, 1, NULL, 2, 'admin', '$2y$10$KkQo3KLNpYgXUUvvOHkHWORh0jXMqqbi34d6sFZRxtGoN5Kn2WjgO', 'Admin', 'Admin', '', NULL, NULL, NULL, 'profil.jpg', '2022-02-01 12:56:49', NULL, '2023-01-21 20:21:19', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(1, 1, NULL, NULL, 'test', '$2y$10$pWKAqAOWwqm5lO8xCMgFmu9e//iWJQB.Y//yHJIAydh4FIfzwNJUq', 'test', 'test', NULL, NULL, NULL, NULL, NULL, '2023-01-21 20:23:57', NULL, '2023-01-21 20:25:52', NULL, 1, '2023-01-21 20:25:52', 1, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_droits`
--

CREATE TABLE IF NOT EXISTS `users_droits` (
  `user_id` int(11) DEFAULT NULL,
  `droit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_droits`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apparences`
--
ALTER TABLE `apparences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fonctionnalites`
--
ALTER TABLE `fonctionnalites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apparences`
--
ALTER TABLE `apparences`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fonctionnalites`
--
ALTER TABLE `fonctionnalites`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ressources`
--
ALTER TABLE `ressources`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
