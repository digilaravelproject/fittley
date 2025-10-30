-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2025 at 06:36 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u945294333_new_ott`
--

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3B82F6',
  `criteria` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`criteria`)),
  `type` enum('post_count','like_count','friend_count','comment_count','streak_days','group_member','first_action','achievement','milestone','participation','special') NOT NULL DEFAULT 'achievement',
  `points` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `slug`, `description`, `image_path`, `icon`, `color`, `criteria`, `type`, `points`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'First Step', 'first-step', 'Awarded on first login', '/images/badge1.png', 'star', '#3BB2F6', '{\"min_actions\":1}', 'achievement', 10, 1, 0, NULL, '2025-09-27 06:36:32'),
(3, 'Polution', 'polution', 'Polution', 'badges/icons/bVbDkoIeMKOlYieMecoq88nu3R46hHQZeZ2Q8hb5.jpg', 'badges/icons/bVbDkoIeMKOlYieMecoq88nu3R46hHQZeZ2Q8hb5.jpg', '#4caeac', '{\"posts_count\":100,\"likes_received\":499,\"fitlive_sessions_attended\":10,\"groups_joined\":5}', 'achievement', 100, 1, 0, '2025-09-27 06:56:09', '2025-09-27 06:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('fitlley_cache_otp_7wikindia@gmail.com', 'i:700960;', 1760465791),
('fitlley_cache_otp_darshankondekar01+1@gmail.com', 'i:847341;', 1760503970),
('fitlley_cache_otp_darshankondekar01+4@gmail.com', 'i:802396;', 1760504424),
('fitlley_cache_otp_demo1@gmail.com', 'i:431785;', 1760467117),
('fitlley_cache_otp_info.webdeveloper2020@gmail.com', 'i:805070;', 1760501811),
('fitlley_cache_otp_mahalevips@gmail.com', 'i:439251;', 1760502800),
('fitlley_cache_otp_shaikhzaid@mail.tsqtt.edu.vn', 'i:590263;', 1760468742),
('fitlley_cache_password_reset_64e68a4886d4e3d3bf1afe057a49b3946545307759e1a0ee5576ca12bc86cb2c', 's:19:\"digizaid5@gmail.com\";', 1760452655),
('fitlley_cache_password_reset_9fdbc410353f870ba27ed52bc17773644d2dcb71cc72ad43596ab4c2f25eff40', 's:19:\"digizaid5@gmail.com\";', 1760452600),
('fitlley_cache_pwreset:152.58.47.99:digizaid5@gmail.com', 'i:3;', 1760455600),
('fitlley_cache_pwreset:152.58.47.99:digizaid5@gmail.com:timer', 'i:1760455600;', 1760455600),
('laravel_cache_pwreset:2409:40c2:12a8:29f7:80c6:57db:a371:7b03:darshankondekar01+1@gmail.com', 'i:1;', 1761806313),
('laravel_cache_pwreset:2409:40c2:12a8:29f7:80c6:57db:a371:7b03:darshankondekar01+1@gmail.com:timer', 'i:1761806313;', 1761806313);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `chat_mode` enum('during','after','off') NOT NULL DEFAULT 'during',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `slug`, `type`, `chat_mode`, `sort_order`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(19, 'Daily Live Classes', NULL, NULL, 'daily-live-classes', NULL, 'after', 0, 1, NULL, '2025-09-24 18:58:32', '2025-09-26 09:02:45'),
(20, 'FitExpert Live', NULL, NULL, 'fitexpert-live', NULL, 'during', 1, 1, NULL, '2025-09-24 19:08:50', '2025-09-24 19:09:12'),
(21, 'Fit Daily Live', NULL, NULL, 'fit-daily-live', NULL, 'after', 2, 1, NULL, '2025-09-26 09:03:04', '2025-09-26 09:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `commission_payouts`
--

CREATE TABLE `commission_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `influencer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `payout_id` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `requested_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `external_transaction_id` varchar(255) DEFAULT NULL,
  `payout_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payout_metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission_tiers`
--

CREATE TABLE `commission_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `min_visits` int(11) DEFAULT NULL,
  `min_conversions` int(11) DEFAULT NULL,
  `min_revenue` decimal(12,2) DEFAULT NULL,
  `min_active_days` int(11) DEFAULT NULL,
  `commission_percentage` decimal(5,2) NOT NULL,
  `bonus_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `has_priority_support` tinyint(1) NOT NULL DEFAULT 0,
  `can_create_custom_links` tinyint(1) NOT NULL DEFAULT 0,
  `max_custom_links` int(11) DEFAULT NULL,
  `gets_analytics_access` tinyint(1) NOT NULL DEFAULT 0,
  `maintain_visits_per_month` int(11) DEFAULT NULL,
  `maintain_conversions_per_month` int(11) DEFAULT NULL,
  `maintain_revenue_per_month` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `color_code` varchar(7) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission_tiers`
--

INSERT INTO `commission_tiers` (`id`, `name`, `description`, `min_visits`, `min_conversions`, `min_revenue`, `min_active_days`, `commission_percentage`, `bonus_percentage`, `has_priority_support`, `can_create_custom_links`, `max_custom_links`, `gets_analytics_access`, `maintain_visits_per_month`, `maintain_conversions_per_month`, `maintain_revenue_per_month`, `is_active`, `sort_order`, `color_code`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 'Entry-level tier for new influencers. Perfect for getting started with the affiliate program.', 0, 0, 0.00, 0, 8.00, 0.00, 0, 0, NULL, 0, NULL, NULL, NULL, 1, 1, '#CD7F32', 'fas fa-medal', '2025-07-01 19:55:23', '2025-07-01 19:55:23'),
(2, 'Silver', 'Growing influencer tier with increased commission rates and basic analytics access.', 100, 5, 250.00, 14, 12.00, 2.00, 0, 1, 3, 1, 25, 2, 100.00, 1, 2, '#C0C0C0', 'fas fa-award', '2025-07-01 19:55:23', '2025-07-01 19:55:23'),
(3, 'Gold', 'Experienced influencer tier with higher commissions, priority support, and advanced features.', 500, 25, 1500.00, 30, 16.00, 4.00, 1, 1, 10, 1, 100, 8, 500.00, 1, 3, '#FFD700', 'fas fa-trophy', '2025-07-01 19:55:23', '2025-07-01 19:55:23'),
(4, 'Platinum', 'Elite influencer tier with maximum commissions and all premium features unlocked.', 2000, 100, 5000.00, 90, 20.00, 5.00, 1, 1, NULL, 1, 200, 15, 1000.00, 1, 4, '#E5E4E2', 'fas fa-crown', '2025-07-01 19:55:23', '2025-07-01 19:55:23'),
(5, 'Diamond', 'Exclusive VIP tier for top-performing influencers with the highest commissions and exclusive benefits.', 5000, 250, 15000.00, 180, 25.00, 10.00, 1, 1, NULL, 1, 400, 25, 2000.00, 1, 5, '#B9F2FF', 'fas fa-gem', '2025-07-01 19:55:23', '2025-07-01 19:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `community_categories`
--

CREATE TABLE `community_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3B82F6',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `community_categories`
--

INSERT INTO `community_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `is_active`, `order`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'demo 1', 'demo-1', 'asdasd', 'fas fa-folder', '#f7a31a', 1, 0, 0, '2025-08-16 18:49:07', '2025-08-16 18:49:07'),
(2, '535353', '535353', '53535353', 'fas fa-folder', '#f7a31a', 1, 0, 0, '2025-09-17 13:24:27', '2025-09-17 13:24:27'),
(3, 'Training2', 'training2', 'Training Description', 'fas fa-apple-alt', '#b8563d', 1, 0, 0, '2025-09-27 09:59:18', '2025-09-27 10:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `community_groups`
--

CREATE TABLE `community_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rules` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `community_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `max_members` int(11) DEFAULT 1000,
  `members_count` int(11) DEFAULT 0,
  `join_type` enum('open','approval_required','invite_only') DEFAULT 'open',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `community_groups`
--

INSERT INTO `community_groups` (`id`, `name`, `slug`, `description`, `rules`, `tags`, `cover_image`, `community_category_id`, `admin_user_id`, `max_members`, `members_count`, `join_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'gdgdgd', 'gdgdgd', 'gdgdgddg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/Mv0OLNBCyVrCmmvUvCaAauSzxQogLTYzKCWSt3gn.png', 1, 13, 1000, 1, 'open', 1, '2025-09-09 13:31:54', '2025-09-17 05:22:33'),
(3, 'New group1', 'new-group1', 'New group1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/ANMqfWd8QliPw83myl2xp8d5w9274Aw2VDRX0kvv.png', 1, 18, 1000, 0, 'open', 1, '2025-09-10 06:59:42', '2025-09-10 07:07:36'),
(4, 'Speritual group', 'speritual-group', 'Speritual group', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/ELSOZ0ykkL42lGBcSF6PgqYWpahSJObFM6jpCNqJ.png', 1, 3, 1000, -1, 'approval_required', 1, '2025-09-12 09:30:02', '2025-09-26 14:01:48'),
(5, 'Educational Group', 'educational-group', 'Educational Group', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/0RuhUKGgmuiUSKGX30oj70BdkXHhnz9WWglsXjBj.png', 1, 3, 1000, 1, 'open', 1, '2025-09-12 09:57:48', '2025-09-29 15:57:33'),
(6, 'Normal Group', 'normal-group', 'Normal Group', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/nKweMVf7dzCczSMnhbVRQZMAPrXbh9As1ObSZu9o.png', 1, 20, 1000, -2, 'open', 1, '2025-09-12 09:58:53', '2025-09-12 12:39:58'),
(8, 'Polution Group', 'polution-group', 'Polution Group', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently123', '#polution, #cleancity, #cleanness', '/community/app/public/groups/llqzLd6qqaFuW75PPLExTkxe0KlxDHSNTOIPMl79.jpg', 1, 7, 1000, 0, 'open', 1, '2025-09-27 09:42:10', '2025-09-27 09:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `community_category_id` bigint(20) UNSIGNED NOT NULL,
  `community_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `is_achievement` tinyint(1) NOT NULL DEFAULT 0,
  `is_challenge` tinyint(1) NOT NULL DEFAULT 0,
  `visibility` enum('public','friends','group') NOT NULL DEFAULT 'public',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_flagged` tinyint(1) NOT NULL DEFAULT 0,
  `flagged_at` timestamp NULL DEFAULT NULL,
  `flag_reason` text DEFAULT NULL,
  `flagged_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `community_category_id`, `community_group_id`, `content`, `images`, `likes_count`, `comments_count`, `shares_count`, `is_achievement`, `is_challenge`, `visibility`, `is_active`, `is_flagged`, `flagged_at`, `flag_reason`, `flagged_by`, `is_featured`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13, 1, NULL, 'This is my first community post!', '\"\\/storage\\/app\\/public\\/community\\/posts\\/gldin2c8vpXY1aE2nu9qCSDv4h1zDJwWmeJjnpCp.jpg\"', 1, 7, 1, 0, 0, 'public', 1, 1, NULL, NULL, NULL, 0, 1, '2025-08-17 08:46:03', '2025-09-16 12:29:46', NULL),
(2, 14, 1, NULL, 'This is my first community post!', '\"\\/storage\\/app\\/public\\/community\\/posts\\/gldin2c8vpXY1aE2nu9qCSDv4h1zDJwWmeJjnpCp.jpg\"', 0, 0, 0, 0, 0, 'public', 1, 1, NULL, NULL, NULL, 0, 1, '2025-08-17 08:54:51', '2025-08-17 08:54:51', NULL),
(3, 14, 1, NULL, 'This is my first community post!', '\"\\/storage\\/app\\/public\\/community\\/posts\\/gldin2c8vpXY1aE2nu9qCSDv4h1zDJwWmeJjnpCp.jpg\"', 0, 0, 0, 0, 0, 'public', 1, 1, NULL, NULL, NULL, 0, 1, '2025-08-17 10:44:21', '2025-08-17 10:44:21', NULL),
(4, 8, 1, NULL, 'This is my first community post!', '\"\\/storage\\/app\\/public\\/community\\/posts\\/gldin2c8vpXY1aE2nu9qCSDv4h1zDJwWmeJjnpCp.jpg\"', 1, 1, 0, 0, 0, 'public', 1, 1, NULL, NULL, NULL, 0, 1, '2025-08-18 06:43:51', '2025-09-26 14:26:34', NULL),
(5, 10, 1, NULL, 'It\'s a workout related post', '\"\\/storage\\/app\\/public\\/community\\/posts\\/gldin2c8vpXY1aE2nu9qCSDv4h1zDJwWmeJjnpCp.jpg\"', 1, 1, 0, 0, 0, 'public', 1, 0, NULL, NULL, NULL, 0, 0, '2025-09-27 10:18:02', '2025-09-29 15:50:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `phone_number`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'darshan kondekar', '8977676767', 'abc', '2025-09-16 13:39:31', '2025-09-16 13:39:31');

-- --------------------------------------------------------

--
-- Table structure for table `content_ratings`
--

CREATE TABLE `content_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ratable_type` varchar(255) NOT NULL,
  `ratable_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `helpful_votes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`helpful_votes`)),
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_reviews`
--

CREATE TABLE `content_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_one_id` bigint(20) UNSIGNED NOT NULL,
  `user_two_id` bigint(20) UNSIGNED NOT NULL,
  `message_count` int(11) NOT NULL DEFAULT 0,
  `message_limit` int(11) NOT NULL DEFAULT 5,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_one_id`, `user_two_id`, `message_count`, `message_limit`, `is_accepted`, `accepted_at`, `last_message_at`, `created_at`, `updated_at`) VALUES
(1, 3, 25, 1, 5, 1, '2025-09-16 11:29:53', '2025-09-25 08:24:13', NULL, '2025-09-25 08:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direct_messages`
--

CREATE TABLE `direct_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `content` text DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `is_deleted_by_sender` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted_by_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `message_type` enum('text','image','file','audio') NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `direct_messages`
--

INSERT INTO `direct_messages` (`id`, `sender_id`, `receiver_id`, `message`, `content`, `attachments`, `is_read`, `read_at`, `is_deleted_by_sender`, `is_deleted_by_receiver`, `message_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 25, 'Hello there!', NULL, NULL, 0, NULL, 0, 0, 'text', '2025-09-18 05:46:03', '2025-09-18 05:46:03', NULL),
(2, 3, 25, 'Hello there!', 'Hello there!', NULL, 0, NULL, 0, 0, 'text', '2025-09-18 05:52:19', '2025-09-18 05:52:19', NULL),
(3, 3, 25, 'Hello indresh!', 'Hello indresh!', NULL, 0, NULL, 0, 0, 'text', '2025-09-18 05:56:42', '2025-09-18 05:56:42', NULL),
(4, 3, 25, 'Hello indresh!', 'Hello indresh!', NULL, 0, NULL, 0, 0, 'text', '2025-09-24 06:26:44', '2025-09-24 06:26:44', NULL),
(5, 3, 25, 'abc', 'abc', NULL, 0, NULL, 0, 0, 'text', '2025-09-25 07:59:53', '2025-09-25 07:59:53', NULL),
(6, 3, 25, 'abc', 'abc', NULL, 0, NULL, 0, 0, 'text', '2025-09-25 07:59:58', '2025-09-25 07:59:58', NULL),
(7, 3, 25, 'abc', 'abc', NULL, 0, NULL, 0, 0, 'text', '2025-09-25 08:20:55', '2025-09-25 08:20:55', NULL),
(8, 3, 25, 'abc', 'abc', NULL, 0, NULL, 0, 0, 'text', '2025-09-25 08:21:31', '2025-09-25 08:21:31', NULL),
(9, 3, 25, 'abc', 'abc', NULL, 0, NULL, 0, 0, 'text', '2025-09-25 08:24:13', '2025-09-25 08:24:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('percentage','fixed_amount') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `minimum_amount` decimal(10,2) DEFAULT NULL,
  `maximum_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_limit_per_user` int(11) NOT NULL DEFAULT 1,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `applicable_plans` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_plans`)),
  `first_time_only` tinyint(1) NOT NULL DEFAULT 0,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fg_categories`
--

CREATE TABLE `fg_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fg_categories`
--

INSERT INTO `fg_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'FitTrain', 'fittrain', 'FitTrain', 1, 1, '2025-07-03 18:47:04', '2025-09-24 19:55:46', NULL),
(2, 'FitCare', 'fitcare', 'Fitcare', 2, 1, '2025-09-17 13:05:57', '2025-09-24 19:56:11', NULL),
(3, 'FitFuel', 'fitfuel', 'FitFuel', 3, 1, '2025-09-24 19:56:37', '2025-09-24 19:56:37', NULL),
(4, 'Fitwell', 'fitwell', 'Fitwell', 4, 1, '2025-09-24 19:56:57', '2025-09-24 19:56:57', NULL),
(5, 'FitCast Live', 'fitcast-live', 'FitCast', 5, 1, '2025-09-24 19:57:18', '2025-09-30 21:56:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fg_series`
--

CREATE TABLE `fg_series` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fg_category_id` bigint(20) UNSIGNED NOT NULL,
  `fg_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `language` varchar(50) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `release_date` date NOT NULL,
  `total_episodes` int(11) NOT NULL DEFAULT 0,
  `feedback` decimal(3,2) DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `trailer_type` enum('youtube','s3','upload') DEFAULT NULL,
  `likes_count` varchar(11) DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `trailer_url` varchar(255) DEFAULT NULL,
  `trailer_file_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fg_series`
--

INSERT INTO `fg_series` (`id`, `fg_category_id`, `fg_sub_category_id`, `title`, `slug`, `description`, `language`, `cost`, `release_date`, `total_episodes`, `feedback`, `banner_image_path`, `trailer_type`, `likes_count`, `views_count`, `comments_count`, `shares_count`, `trailer_url`, `trailer_file_path`, `is_published`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Beginner\'s Complete Fitness Journey', 'beginners-complete-fitness-journey', 'A comprehensive 12-week program designed for fitness beginners to build strength, endurance, and healthy habits.', 'English', 199.00, '2024-01-01', 12, 4.80, 'fitnews/thumbnails/AIAauOwTuu7apjO4hrcB5o1Ci3nvEPC9a6DvNO9v.png', 'youtube', NULL, 0, 0, 0, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:38', '2025-09-24 20:08:47', '2025-09-24 20:08:47'),
(2, 1, 1, 'Advanced Strength Training Mastery', 'advanced-strength-training-mastery', 'Take your strength training to the next level with advanced techniques and progressive overload principles.', 'English', 299.00, '2024-02-15', 10, 4.90, 'fitnews/thumbnails/AIAauOwTuu7apjO4hrcB5o1Ci3nvEPC9a6DvNO9v.png', 'youtube', NULL, 0, 0, 0, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:38', '2025-09-24 20:03:51', '2025-09-24 20:03:51'),
(4, 1, NULL, 'FitAthlete (Polyometric series/athlete-specific training)', 'athlete-specific', 'High-intensity interval training program designed to maximize fat loss and improve cardiovascular health.', 'english', 249.00, '2024-04-10', 6, 4.60, 'fitguide/banners/fXQyFlNPIbWAH1mTJ9y0GtoCdxVfJ6NTeqBCgiZj.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:39', '2025-09-26 05:39:16', NULL),
(5, 1, 1, 'Functional Movement Fundamentals', 'functional-movement-fundamentals', 'Learn essential movement patterns that translate to better performance in daily activities and sports.', 'English', 179.00, '2024-05-05', 9, 4.80, 'fitnews/thumbnails/AIAauOwTuu7apjO4hrcB5o1Ci3nvEPC9a6DvNO9v.png', 'youtube', NULL, 0, 0, 0, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:39', '2025-09-24 20:08:43', '2025-09-24 20:08:43'),
(6, 1, NULL, 'Powerlifting', 'powerlifting', 'Discover the transformative power of yoga through guided sessions focusing on flexibility and mental well-being.', 'english', 149.00, '2024-03-01', 8, 4.70, 'fitguide/banners/roCVsJTGj0A4P9TNbxDgmkvlllyQ3y900WuWQvNj.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:39', '2025-09-26 05:39:16', NULL),
(7, 1, NULL, 'Crossfit', 'crossfit', 'Develop mental resilience and focus through mindfulness practices specifically designed for athletes.', 'english', 129.00, '2024-07-15', 5, 4.50, 'fitguide/banners/Z0ROkJrIpQToutt1G3CVAEKG6Px2vve56PxlomBV.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:40', '2025-09-26 05:39:16', NULL),
(8, 1, NULL, 'Fit train', 'fit-train', 'Essential strategies for recovery, injury prevention, and maintaining long-term fitness health.', 'english', 169.00, '2024-08-01', 6, 4.70, 'fitguide/banners/F2aN5xBLVIgGB55jyf6Uv8LZAkHH0byTDy704OwO.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, 0, '2025-08-26 20:06:40', '2025-09-26 05:39:16', NULL),
(9, 1, NULL, 'Calisthenics', 'calisthenics', 'Complete guide to understanding nutrition science and creating sustainable meal plans for your fitness goals.', 'english', 199.00, '2024-06-01', 7, 4.90, 'fitguide/banners/VIkG4C4XKYA6xxpkBRfFf8pkykIuqnG9BnEa1ICj.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-08-26 20:06:40', '2025-09-26 05:39:16', NULL),
(10, 1, NULL, 'Bodybuilding', 'bodybuilding', 'It\'s a testing fitguide series', 'english', 0.25, '2025-09-25', 1, 2.20, 'fitguide/banners/EZ9f2bVlX1AsIkPxO8eMprBxKrOREsQPL52AZfTR.jpg', 'youtube', NULL, 0, 0, 5, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 10:00:21', '2025-09-30 09:10:55', NULL),
(11, 2, NULL, 'FitCare', 'fitcare', 'FitCare', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/45IqBrOsGiVe9J6qyUxvYXbkhGIPs7JPFUznPRYq.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, 0, '2025-09-24 20:11:21', '2025-09-26 05:39:16', NULL),
(12, 2, NULL, 'Injury prevention', 'injury-prevention', 'Injury prevention', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/C9pLULJyoXgC4AAsM8GnP0aNhYaVkXMGUVfF0Osr.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:13:02', '2025-09-26 05:39:16', NULL),
(13, 2, NULL, 'Recovery', 'recovery', 'Recovery', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/Oj5MCkRpqmoEc4IknpwwDcmMyQ6iMNRrYlIjpmVr.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:14:33', '2025-09-26 05:39:16', NULL),
(14, 2, NULL, 'Rehabilitation', 'rehabilitation', 'Rehabilitation', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/saIwGFpTYAhSKjOb14S87vuXKneAtmgRcKcV3WAy.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:15:46', '2025-09-26 05:39:16', NULL),
(15, 3, NULL, 'Fitfuel', 'fitfuel', 'Fitfuel', 'english', 0.00, '2025-09-25', 0, 0.50, 'fitguide/banners/SoBfheV3t1NwhBWtW3P2pILbGMEmEJOlG7NAZ6LL.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, 0, '2025-09-24 20:17:02', '2025-09-26 05:39:16', NULL),
(16, 3, NULL, 'NutriGuide', 'nutriguide', 'NutriGuide', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/QmahSVjI13mZsckno1wQfzVtds4JUGSTvNNEndvm.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:21:34', '2025-09-26 05:39:16', NULL),
(17, 3, NULL, 'FitBeauty', 'hair-skin-health', 'FitBeauty', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/5zo9inA6PYZLTuBo44loezHO5oo058pvdyNdUZMh.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:19:47', '2025-09-26 05:39:16', NULL),
(18, 3, NULL, 'FitGut', 'gut-health', 'Gut health', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/ZYE9RfqJkGrN1NFCui9YXOjZTIyH1aoDAdEUZeIG.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:18:42', '2025-09-26 05:39:16', NULL),
(19, 3, NULL, 'FitKitchen', 'fitkitchen', 'FitKitchen', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/hvdbzmvjMjKuQed1NasbxP4ayKj8GS2D10K4PJut.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:20:26', '2025-09-26 05:39:16', NULL),
(20, 4, NULL, 'Fitwell', 'fitwell', 'Fitwell', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/SGIKDR54bpnJO6OIt1WqoKug2ZNfq4HIwlu2oAC2.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, 0, '2025-09-24 20:23:37', '2025-09-26 05:39:16', NULL),
(21, 4, NULL, 'Thyroid', 'thyroid', 'Thyroid', 'english', 0.00, '2025-10-04', 0, NULL, 'fitguide/banners/dtbF3fSWOgS6CxdpL8P8gdyRJTYaBomkUVJj0sb2.jpg', NULL, NULL, 0, 0, 0, NULL, NULL, 1, 1, '2025-10-03 17:07:42', '2025-10-03 17:08:05', NULL),
(22, 4, NULL, 'PCOD/PCOS management', 'pcod', 'PCOD', 'english', 0.00, '2025-10-03', 0, NULL, 'fitguide/banners/FpDFAJHAsMlKK2Nyb9WkFNBtHXPXFo6MxlLyoyYj.jpg', NULL, NULL, 0, 0, 0, NULL, NULL, 1, 1, '2025-10-03 17:09:22', '2025-10-03 17:09:22', NULL),
(23, 4, NULL, 'Blood Pressure', 'hypertension', 'Hypertension', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/CLZXcxExIKE9GH4XEKYwiDp4CktltzibYgJSVLLq.jpg', 'youtube', NULL, 0, 0, 2, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:24:10', '2025-09-26 05:39:16', NULL),
(24, 4, NULL, 'Diabetes', 'diabetes', 'Diabetes', 'english', 0.00, '2025-09-25', 0, NULL, 'fitguide/banners/whrmtukKf0lNGJXDfgZKaEe7ziy6YW5eyUWg4LEF.jpg', 'youtube', NULL, 0, 0, 9, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 20:23:01', '2025-09-30 13:52:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fg_series_episodes`
--

CREATE TABLE `fg_series_episodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fg_series_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `episode_number` int(11) NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `video_type` enum('youtube','s3','upload') NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_file_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fg_series_episodes`
--

INSERT INTO `fg_series_episodes` (`id`, `fg_series_id`, `title`, `slug`, `description`, `episode_number`, `duration_minutes`, `video_type`, `video_url`, `video_file_path`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Week 1: Foundation Building', 'week-1-foundation-building', 'Episode 1 of Beginner\'s Complete Fitness Journey: Week 1: Foundation Building', 1, 23, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(2, 1, 'Week 2: Basic Strength Training', 'week-2-basic-strength-training', 'Episode 2 of Beginner\'s Complete Fitness Journey: Week 2: Basic Strength Training', 2, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(3, 1, 'Week 3: Cardio Introduction', 'week-3-cardio-introduction', 'Episode 3 of Beginner\'s Complete Fitness Journey: Week 3: Cardio Introduction', 3, 58, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(4, 1, 'Week 4: Flexibility Focus', 'week-4-flexibility-focus', 'Episode 4 of Beginner\'s Complete Fitness Journey: Week 4: Flexibility Focus', 4, 24, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(5, 1, 'Week 5: Compound Movements', 'week-5-compound-movements', 'Episode 5 of Beginner\'s Complete Fitness Journey: Week 5: Compound Movements', 5, 45, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(6, 1, 'Week 6: Endurance Building', 'week-6-endurance-building', 'Episode 6 of Beginner\'s Complete Fitness Journey: Week 6: Endurance Building', 6, 28, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(7, 1, 'Week 7: Core Strengthening', 'week-7-core-strengthening', 'Episode 7 of Beginner\'s Complete Fitness Journey: Week 7: Core Strengthening', 7, 55, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(8, 1, 'Week 8: Balance and Coordination', 'week-8-balance-and-coordination', 'Episode 8 of Beginner\'s Complete Fitness Journey: Week 8: Balance and Coordination', 8, 38, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(9, 1, 'Week 9: Progressive Overload', 'week-9-progressive-overload', 'Episode 9 of Beginner\'s Complete Fitness Journey: Week 9: Progressive Overload', 9, 39, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(10, 1, 'Week 10: Advanced Techniques', 'week-10-advanced-techniques', 'Episode 10 of Beginner\'s Complete Fitness Journey: Week 10: Advanced Techniques', 10, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(11, 1, 'Week 11: Goal Setting', 'week-11-goal-setting', 'Episode 11 of Beginner\'s Complete Fitness Journey: Week 11: Goal Setting', 11, 37, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(12, 1, 'Week 12: Maintenance and Beyond', 'week-12-maintenance-and-beyond', 'Episode 12 of Beginner\'s Complete Fitness Journey: Week 12: Maintenance and Beyond', 12, 32, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(13, 2, 'Progressive Overload Principles', 'progressive-overload-principles', 'Episode 1 of Advanced Strength Training Mastery: Progressive Overload Principles', 1, 30, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(14, 2, 'Periodization Strategies', 'periodization-strategies', 'Episode 2 of Advanced Strength Training Mastery: Periodization Strategies', 2, 41, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(15, 2, 'Advanced Compound Movements', 'advanced-compound-movements', 'Episode 3 of Advanced Strength Training Mastery: Advanced Compound Movements', 3, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(16, 2, 'Accessory Exercise Selection', 'accessory-exercise-selection', 'Episode 4 of Advanced Strength Training Mastery: Accessory Exercise Selection', 4, 25, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(17, 2, 'Recovery and Deload Weeks', 'recovery-and-deload-weeks', 'Episode 5 of Advanced Strength Training Mastery: Recovery and Deload Weeks', 5, 37, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(18, 2, 'Competition Preparation', 'competition-preparation', 'Episode 6 of Advanced Strength Training Mastery: Competition Preparation', 6, 53, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(19, 2, 'Plateau Breaking Techniques', 'plateau-breaking-techniques', 'Episode 7 of Advanced Strength Training Mastery: Plateau Breaking Techniques', 7, 48, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(20, 2, 'Advanced Programming', 'advanced-programming', 'Episode 8 of Advanced Strength Training Mastery: Advanced Programming', 8, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(21, 2, 'Injury Prevention Strategies', 'injury-prevention-strategies', 'Episode 9 of Advanced Strength Training Mastery: Injury Prevention Strategies', 9, 27, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(22, 2, 'Peak Performance Protocols', 'peak-performance-protocols', 'Episode 10 of Advanced Strength Training Mastery: Peak Performance Protocols', 10, 39, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(23, 6, 'Foundation Poses and Breathing', 'foundation-poses-and-breathing', 'Episode 1 of Yoga for Flexibility and Peace: Foundation Poses and Breathing', 1, 20, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(24, 6, 'Sun Salutation Sequences', 'sun-salutation-sequences', 'Episode 2 of Yoga for Flexibility and Peace: Sun Salutation Sequences', 2, 55, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(25, 6, 'Hip Opening Flow', 'hip-opening-flow', 'Episode 3 of Yoga for Flexibility and Peace: Hip Opening Flow', 3, 33, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:06:39', NULL),
(26, 6, 'Backbend Progression', 'backbend-progression', 'Episode 4 of Yoga for Flexibility and Peace: Backbend Progression', 4, 37, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(27, 6, 'Arm Balance Fundamentals', 'arm-balance-fundamentals', 'Episode 5 of Yoga for Flexibility and Peace: Arm Balance Fundamentals', 5, 55, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(28, 6, 'Restorative Yoga Practice', 'restorative-yoga-practice', 'Episode 6 of Yoga for Flexibility and Peace: Restorative Yoga Practice', 6, 35, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(29, 6, 'Meditation and Mindfulness', 'meditation-and-mindfulness', 'Episode 7 of Yoga for Flexibility and Peace: Meditation and Mindfulness', 7, 22, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(30, 6, 'Advanced Flow Sequences', 'advanced-flow-sequences', 'Episode 8 of Yoga for Flexibility and Peace: Advanced Flow Sequences', 8, 58, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(31, 4, 'Episode 1: HIIT Transformation Challenge', 'episode-1-hiit-transformation-challenge', 'Episode 1 of HIIT Transformation Challenge: Episode 1: HIIT Transformation Challenge', 1, 41, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(32, 4, 'Episode 2: HIIT Transformation Challenge', 'episode-2-hiit-transformation-challenge', 'Episode 2 of HIIT Transformation Challenge: Episode 2: HIIT Transformation Challenge', 2, 59, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(33, 4, 'Episode 3: HIIT Transformation Challenge', 'episode-3-hiit-transformation-challenge', 'Episode 3 of HIIT Transformation Challenge: Episode 3: HIIT Transformation Challenge', 3, 25, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(34, 4, 'Episode 4: HIIT Transformation Challenge', 'episode-4-hiit-transformation-challenge', 'Episode 4 of HIIT Transformation Challenge: Episode 4: HIIT Transformation Challenge', 4, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(35, 4, 'Episode 5: HIIT Transformation Challenge', 'episode-5-hiit-transformation-challenge', 'Episode 5 of HIIT Transformation Challenge: Episode 5: HIIT Transformation Challenge', 5, 58, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(36, 4, 'Episode 6: HIIT Transformation Challenge', 'episode-6-hiit-transformation-challenge', 'Episode 6 of HIIT Transformation Challenge: Episode 6: HIIT Transformation Challenge', 6, 25, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(37, 5, 'Episode 1: Functional Movement Fundamentals', 'episode-1-functional-movement-fundamentals', 'Episode 1 of Functional Movement Fundamentals: Episode 1: Functional Movement Fundamentals', 1, 52, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(38, 5, 'Episode 2: Functional Movement Fundamentals', 'episode-2-functional-movement-fundamentals', 'Episode 2 of Functional Movement Fundamentals: Episode 2: Functional Movement Fundamentals', 2, 21, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(39, 5, 'Episode 3: Functional Movement Fundamentals', 'episode-3-functional-movement-fundamentals', 'Episode 3 of Functional Movement Fundamentals: Episode 3: Functional Movement Fundamentals', 3, 26, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(40, 5, 'Episode 4: Functional Movement Fundamentals', 'episode-4-functional-movement-fundamentals', 'Episode 4 of Functional Movement Fundamentals: Episode 4: Functional Movement Fundamentals', 4, 53, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(41, 5, 'Episode 5: Functional Movement Fundamentals', 'episode-5-functional-movement-fundamentals', 'Episode 5 of Functional Movement Fundamentals: Episode 5: Functional Movement Fundamentals', 5, 30, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(42, 5, 'Episode 6: Functional Movement Fundamentals', 'episode-6-functional-movement-fundamentals', 'Episode 6 of Functional Movement Fundamentals: Episode 6: Functional Movement Fundamentals', 6, 30, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(43, 5, 'Episode 7: Functional Movement Fundamentals', 'episode-7-functional-movement-fundamentals', 'Episode 7 of Functional Movement Fundamentals: Episode 7: Functional Movement Fundamentals', 7, 58, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(44, 5, 'Episode 8: Functional Movement Fundamentals', 'episode-8-functional-movement-fundamentals', 'Episode 8 of Functional Movement Fundamentals: Episode 8: Functional Movement Fundamentals', 8, 41, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(45, 5, 'Episode 9: Functional Movement Fundamentals', 'episode-9-functional-movement-fundamentals', 'Episode 9 of Functional Movement Fundamentals: Episode 9: Functional Movement Fundamentals', 9, 28, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(46, 9, 'Episode 1: Nutrition and Meal Planning Mastery', 'episode-1-nutrition-and-meal-planning-mastery', 'Episode 1 of Nutrition and Meal Planning Mastery: Episode 1: Nutrition and Meal Planning Mastery', 1, 51, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(47, 9, 'Episode 2: Nutrition and Meal Planning Mastery', 'episode-2-nutrition-and-meal-planning-mastery', 'Episode 2 of Nutrition and Meal Planning Mastery: Episode 2: Nutrition and Meal Planning Mastery', 2, 56, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(48, 9, 'Episode 3: Nutrition and Meal Planning Mastery', 'episode-3-nutrition-and-meal-planning-mastery', 'Episode 3 of Nutrition and Meal Planning Mastery: Episode 3: Nutrition and Meal Planning Mastery', 3, 39, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(49, 9, 'Episode 4: Nutrition and Meal Planning Mastery', 'episode-4-nutrition-and-meal-planning-mastery', 'Episode 4 of Nutrition and Meal Planning Mastery: Episode 4: Nutrition and Meal Planning Mastery', 4, 60, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(50, 9, 'Episode 5: Nutrition and Meal Planning Mastery', 'episode-5-nutrition-and-meal-planning-mastery', 'Episode 5 of Nutrition and Meal Planning Mastery: Episode 5: Nutrition and Meal Planning Mastery', 5, 30, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(51, 9, 'Episode 6: Nutrition and Meal Planning Mastery', 'episode-6-nutrition-and-meal-planning-mastery', 'Episode 6 of Nutrition and Meal Planning Mastery: Episode 6: Nutrition and Meal Planning Mastery', 6, 21, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(52, 9, 'Episode 7: Nutrition and Meal Planning Mastery', 'episode-7-nutrition-and-meal-planning-mastery', 'Episode 7 of Nutrition and Meal Planning Mastery: Episode 7: Nutrition and Meal Planning Mastery', 7, 25, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(53, 7, 'Episode 1: Mindfulness and Meditation for Athletes', 'episode-1-mindfulness-and-meditation-for-athletes', 'Episode 1 of Mindfulness and Meditation for Athletes: Episode 1: Mindfulness and Meditation for Athletes', 1, 31, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(54, 7, 'Episode 2: Mindfulness and Meditation for Athletes', 'episode-2-mindfulness-and-meditation-for-athletes', 'Episode 2 of Mindfulness and Meditation for Athletes: Episode 2: Mindfulness and Meditation for Athletes', 2, 36, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(55, 7, 'Episode 3: Mindfulness and Meditation for Athletes', 'episode-3-mindfulness-and-meditation-for-athletes', 'Episode 3 of Mindfulness and Meditation for Athletes: Episode 3: Mindfulness and Meditation for Athletes', 3, 34, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(56, 7, 'Episode 4: Mindfulness and Meditation for Athletes', 'episode-4-mindfulness-and-meditation-for-athletes', 'Episode 4 of Mindfulness and Meditation for Athletes: Episode 4: Mindfulness and Meditation for Athletes', 4, 54, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(57, 7, 'Episode 5: Mindfulness and Meditation for Athletes', 'episode-5-mindfulness-and-meditation-for-athletes', 'Episode 5 of Mindfulness and Meditation for Athletes: Episode 5: Mindfulness and Meditation for Athletes', 5, 25, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(58, 8, 'Episode 1: Recovery and Injury Prevention', 'episode-1-recovery-and-injury-prevention', 'Episode 1 of Recovery and Injury Prevention: Episode 1: Recovery and Injury Prevention', 1, 55, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(59, 8, 'Episode 2: Recovery and Injury Prevention', 'episode-2-recovery-and-injury-prevention', 'Episode 2 of Recovery and Injury Prevention: Episode 2: Recovery and Injury Prevention', 2, 27, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(60, 8, 'Episode 3: Recovery and Injury Prevention', 'episode-3-recovery-and-injury-prevention', 'Episode 3 of Recovery and Injury Prevention: Episode 3: Recovery and Injury Prevention', 3, 43, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(61, 8, 'Episode 4: Recovery and Injury Prevention', 'episode-4-recovery-and-injury-prevention', 'Episode 4 of Recovery and Injury Prevention: Episode 4: Recovery and Injury Prevention', 4, 55, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(62, 8, 'Episode 5: Recovery and Injury Prevention', 'episode-5-recovery-and-injury-prevention', 'Episode 5 of Recovery and Injury Prevention: Episode 5: Recovery and Injury Prevention', 5, 39, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(63, 8, 'Episode 6: Recovery and Injury Prevention', 'episode-6-recovery-and-injury-prevention', 'Episode 6 of Recovery and Injury Prevention: Episode 6: Recovery and Injury Prevention', 6, 45, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:06', NULL),
(64, 10, 'Testing fitguide episode1', 'testing-fitguide-episode1', 'It\'s a testing fitguide episode1', 1, 15, 'upload', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', 'fitguide/episodes/I9Dim1lpluHubaUFmHvsstxKtGeWoizGqLXZsenA.mp4', 1, '2025-09-24 10:00:21', '2025-09-24 10:00:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fg_singles`
--

CREATE TABLE `fg_singles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fg_category_id` bigint(20) UNSIGNED NOT NULL,
  `fg_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `language` varchar(50) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `release_date` date NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `feedback` decimal(3,2) DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `trailer_type` enum('youtube','s3','upload') DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `trailer_file_path` varchar(255) DEFAULT NULL,
  `video_type` enum('youtube','s3','upload') NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_file_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fg_singles`
--

INSERT INTO `fg_singles` (`id`, `fg_category_id`, `fg_sub_category_id`, `title`, `slug`, `description`, `language`, `cost`, `release_date`, `duration_minutes`, `feedback`, `banner_image_path`, `trailer_type`, `trailer_url`, `trailer_file_path`, `video_type`, `video_url`, `video_file_path`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 5, NULL, 'Podcast on Health', 'podcast-on-health', 'Podcast on Health.jpg', 'english', 0.00, '2025-10-03', 2, NULL, 'fitguide/banners/9h2iYli6BFxkUY5ISlCRJhNXHn4Vd8kvV2xHcoV3.jpg', NULL, NULL, NULL, 'youtube', 'https://www.youtube.com/watch?v=7Nwn2nLBqEU&t=4s', NULL, 1, '2025-10-03 17:13:21', '2025-10-03 17:13:21', NULL),
(9, 5, NULL, 'Podcast on Hair& Skin', 'podcast-on-hair-skin', 'Podcast on Hair& Skin', 'english', 0.00, '2025-10-03', 1, NULL, 'fitguide/banners/l2aMM9RazrBtv7UxxPOwtjgiTU6mWMxPPMBVCdBS.jpg', NULL, NULL, NULL, 'youtube', 'https://www.youtube.com/watch?v=7Nwn2nLBqEU&t=4s', NULL, 1, '2025-10-03 17:11:54', '2025-10-03 17:11:54', NULL),
(10, 5, NULL, 'Fitness talks', 'fitness-talks', 'Fitness talks', 'english', 0.00, '2025-10-03', 3, NULL, 'fitguide/banners/SnLWlo8POBtyVRhBeleXq1Aa4FdKw7DlofxHRL1d.jpg', NULL, NULL, NULL, 'youtube', 'https://www.youtube.com/watch?v=7Nwn2nLBqEU&t=4s', NULL, 1, '2025-10-03 17:14:34', '2025-10-03 17:14:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fg_sub_categories`
--

CREATE TABLE `fg_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fg_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fg_sub_categories`
--

INSERT INTO `fg_sub_categories` (`id`, `fg_category_id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Bodybuilding', 'bodybuilding', 'Bodybuilding', 1, 1, '2025-07-03 18:47:33', '2025-09-24 20:28:22', '2025-09-24 20:28:22'),
(2, 2, 'ettetetete', 'ettetetete', 'ttetete', 3, 1, '2025-09-17 13:07:42', '2025-09-24 20:28:33', '2025-09-24 20:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `fitarena_events`
--

CREATE TABLE `fitarena_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `max_participants` varchar(255) DEFAULT NULL,
  `sponsors` varchar(255) DEFAULT NULL,
  `prizes` varchar(255) DEFAULT NULL,
  `rules` varchar(255) DEFAULT NULL,
  `status` enum('draft','upcoming','live','ended') NOT NULL DEFAULT 'upcoming',
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `dvr_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `dvr_hours` int(11) NOT NULL DEFAULT 24,
  `organizers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`organizers`)),
  `schedule_overview` text DEFAULT NULL,
  `expected_viewers` int(11) NOT NULL DEFAULT 0,
  `peak_viewers` int(11) NOT NULL DEFAULT 0,
  `views_count` int(11) DEFAULT 0,
  `likes_count` int(11) DEFAULT 0,
  `comments_count` int(11) DEFAULT 0,
  `shares_count` int(11) DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitarena_events`
--

INSERT INTO `fitarena_events` (`id`, `title`, `description`, `slug`, `start_date`, `end_date`, `banner_image`, `logo`, `location`, `event_type`, `max_participants`, `sponsors`, `prizes`, `rules`, `status`, `visibility`, `dvr_enabled`, `dvr_hours`, `organizers`, `schedule_overview`, `expected_viewers`, `peak_viewers`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `is_featured`, `created_at`, `updated_at`, `instructor_id`) VALUES
(10, 'Mr Olympia', 'Mr Olympia test', 'mr-olympia', '2025-09-29 08:18:00', '2025-09-30 20:18:00', '/storage/app/public/fitarena/banners/HuDggDg9gcyFPbOyV2Yu3JmMmhxAogIxc6rrSmDD.jpg', NULL, 'Online', 'competition', '50', 'test', 'test', 'test', 'live', 'public', 1, 24, NULL, NULL, 50, 0, 0, 3, 0, 5, 1, '2025-09-24 19:19:08', '2025-09-26 07:15:00', NULL),
(11, 'Crossfit games', 'Crossfit games', 'crossfit-games', '2025-09-24 21:19:00', '2025-09-26 21:19:00', '/storage/app/public/fitarena/banners/fRU74RSRmVnyOehpgZfB5mH9zVKqrk5LaVJRcfKR.jpg', NULL, 'Online', 'competition', '5', 'Crossfit games', 'Crossfit games', 'Crossfit games', 'live', 'public', 1, 24, NULL, NULL, 5, 0, 0, 3, 0, 1, 1, '2025-09-24 21:20:57', '2025-09-26 06:16:01', NULL),
(12, 'World Strongest Man', 'World Strongest Man', 'World Strongest Man', '2025-09-30 15:45:00', '2025-09-30 16:45:00', '/storage/app/public/fitarena/banners/wx5K5CWUewxKIdYiKtuPd7XrTREBKBIzvgDV6W3k.jpg', NULL, 'Online', 'competition', '32', 'NA', 'NA', 'NA', 'upcoming', 'public', 1, 24, NULL, NULL, 32, 0, 0, 0, 0, 0, 1, '2025-09-30 15:40:17', '2025-09-30 15:40:17', 25),
(13, 'Powerlifting championship', 'Powerlifting championship', 'powerlifting-championship', '2025-10-04 17:01:00', '2025-10-10 17:00:00', '/storage/app/public/fitarena/banners/hoE1Rem7fCqoroe8rn986ioWACd7DEVvp3ELJpcT.jpg', NULL, 'Online', 'competition', '10', 'test', 'test', 'test', 'upcoming', 'public', 1, 24, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, '2025-10-03 17:01:23', '2025-10-03 17:01:23', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fitarena_participants`
--

CREATE TABLE `fitarena_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fitarena_session_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `left_at` timestamp NULL DEFAULT NULL,
  `duration_seconds` int(11) NOT NULL DEFAULT 0,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fitarena_sessions`
--

CREATE TABLE `fitarena_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `speakers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`speakers`)),
  `scheduled_start` datetime NOT NULL,
  `scheduled_end` datetime NOT NULL,
  `actual_start` datetime DEFAULT NULL,
  `actual_end` datetime DEFAULT NULL,
  `status` enum('scheduled','live','ended','cancelled') NOT NULL DEFAULT 'scheduled',
  `session_type` varchar(255) NOT NULL DEFAULT 'presentation',
  `recording_url` varchar(255) DEFAULT NULL,
  `recording_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `recording_status` varchar(255) NOT NULL DEFAULT 'pending',
  `recording_duration` int(11) DEFAULT NULL,
  `recording_file_size` bigint(20) DEFAULT NULL,
  `viewer_count` int(11) NOT NULL DEFAULT 0,
  `peak_viewers` int(11) NOT NULL DEFAULT 0,
  `materials_url` text DEFAULT NULL,
  `replay_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitarena_sessions`
--

INSERT INTO `fitarena_sessions` (`id`, `event_id`, `stage_id`, `category_id`, `sub_category_id`, `title`, `description`, `speakers`, `scheduled_start`, `scheduled_end`, `actual_start`, `actual_end`, `status`, `session_type`, `recording_url`, `recording_enabled`, `recording_status`, `recording_duration`, `recording_file_size`, `viewer_count`, `peak_viewers`, `materials_url`, `replay_available`, `created_at`, `updated_at`) VALUES
(9, 10, 12, NULL, NULL, 'Mr Olympia - Live Session', 'Mr Olympia test', '[]', '2025-09-29 00:00:00', '2025-09-30 00:00:00', '2025-10-30 10:28:49', '2025-10-30 10:29:21', 'ended', 'live_session', '/storage/app/public/fitarena/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-09-24 19:19:08', '2025-10-30 10:29:21'),
(10, 11, 13, NULL, NULL, 'Crossfit games - Live Session', 'Crossfit games', '[]', '2025-09-24 00:00:00', '2025-09-26 00:00:00', NULL, NULL, 'scheduled', 'live_session', '/storage/app/public/fitarena/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-09-24 21:20:57', '2025-09-24 21:20:57'),
(11, 12, 14, NULL, NULL, 'Check FitArena - Live Session', 'FitArena Testing', '[{\"name\":\"Instructor User\",\"role\":\"Instructor\",\"user_id\":25}]', '2025-09-30 00:00:00', '2025-09-30 00:00:00', '2025-09-30 15:45:34', '2025-09-30 16:07:47', 'ended', 'live_session', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-09-30 15:40:17', '2025-09-30 16:07:47'),
(12, 13, 15, NULL, NULL, 'Powerlifting championship - Live Session', 'Powerlifting championship', '[{\"name\":\"Instructor User\",\"role\":\"Instructor\",\"user_id\":2}]', '2025-10-04 00:00:00', '2025-10-10 00:00:00', NULL, NULL, 'scheduled', 'live_session', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-10-03 17:01:23', '2025-10-03 17:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `fitarena_stages`
--

CREATE TABLE `fitarena_stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color_code` varchar(7) NOT NULL DEFAULT '#d4ab00',
  `capacity` int(11) DEFAULT NULL,
  `livekit_room` varchar(255) DEFAULT NULL,
  `stream_key` varchar(255) DEFAULT NULL,
  `rtmp_url` varchar(255) DEFAULT NULL,
  `hls_url` varchar(255) DEFAULT NULL,
  `status` enum('scheduled','live','ended','break') NOT NULL DEFAULT 'scheduled',
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitarena_stages`
--

INSERT INTO `fitarena_stages` (`id`, `event_id`, `name`, `description`, `color_code`, `capacity`, `livekit_room`, `stream_key`, `rtmp_url`, `hls_url`, `status`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(12, 10, 'Main Stage', 'Main stage for Mr Olympia', '#d4ab00', NULL, 'fitarena.YGXrfK1PA5', 'stage_bctuwf10AdpTvDkG', NULL, NULL, 'scheduled', 1, 1, '2025-09-24 19:19:08', '2025-09-24 19:19:08'),
(13, 11, 'Main Stage', 'Main stage for Crossfit games', '#d4ab00', NULL, 'fitarena.qShm5ioyhL', 'stage_Kq1RkPFlHy5i4ING', NULL, NULL, 'scheduled', 1, 1, '2025-09-24 21:20:57', '2025-09-24 21:20:57'),
(14, 12, 'Main Stage', 'Main stage for Check FitArena', '#d4ab00', NULL, 'fitarena.N2aewLXKhh', 'stage_50MXMxsYMKmga6IG', NULL, NULL, 'scheduled', 1, 1, '2025-09-30 15:40:17', '2025-09-30 15:40:17'),
(15, 13, 'Main Stage', 'Main stage for Powerlifting championship', '#d4ab00', NULL, 'fitarena.b1Ev7AKMQj', 'stage_ZZZvuSMwHWjNhL7F', NULL, NULL, 'scheduled', 1, 1, '2025-10-03 17:01:23', '2025-10-03 17:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `fitlive_chat_messages`
--

CREATE TABLE `fitlive_chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fitlive_session_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `is_instructor` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitlive_chat_messages`
--

INSERT INTO `fitlive_chat_messages` (`id`, `fitlive_session_id`, `user_id`, `body`, `is_instructor`, `sent_at`, `created_at`, `updated_at`) VALUES
(8, 32, 3, 'Hello from Postman!', 0, '2025-09-25 12:29:32', NULL, NULL),
(9, 2364, 3, 'jhhjhj', 0, '2025-10-15 14:49:04', NULL, NULL),
(10, 2363, 3, 'Hello sir', 0, '2025-10-15 14:54:01', NULL, NULL),
(11, 2363, 3, 'Reverb testing success', 0, '2025-10-15 14:54:29', NULL, NULL),
(12, 2362, 3, 'Hello expert', 0, '2025-10-15 14:56:25', NULL, NULL),
(13, 2364, 3, 'hfh', 0, '2025-10-16 10:26:37', NULL, NULL),
(14, 2970, 3, 'hi', 0, '2025-10-30 10:10:55', NULL, NULL),
(15, 205, 3, 'Hello Kris', 0, '2025-10-30 10:25:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fitlive_sessions`
--

CREATE TABLE `fitlive_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `status` enum('scheduled','live','ended') NOT NULL DEFAULT 'scheduled',
  `chat_mode` enum('during','after','off') NOT NULL DEFAULT 'during',
  `session_type` enum('daily','one_time') NOT NULL DEFAULT 'one_time',
  `livekit_room` varchar(255) DEFAULT NULL,
  `hls_url` varchar(255) DEFAULT NULL,
  `mp4_path` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `viewer_peak` int(11) NOT NULL DEFAULT 0,
  `views_count` int(11) DEFAULT 0,
  `likes_count` int(11) DEFAULT 0,
  `comments_count` int(11) DEFAULT 0,
  `shares_count` int(11) DEFAULT 0,
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `recording_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `recording_id` varchar(255) DEFAULT NULL,
  `recording_url` varchar(255) DEFAULT NULL,
  `recording_status` varchar(255) DEFAULT NULL,
  `recording_duration` int(11) DEFAULT NULL,
  `recording_file_size` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitlive_sessions`
--

INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(32, 20, NULL, 2, 'Checking chat', 'Want to Checking chat', '2025-09-25 18:57:00', '2025-09-25 12:28:22', '2025-09-25 12:31:32', 'ended', 'during', 'one_time', 'fitlive.3kkdRwtENc', NULL, NULL, 'fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 3, 0, 2, 'public', 0, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-25 12:28:12', '2025-09-26 06:56:14'),
(33, 20, NULL, 2, 'New sess22', 'New sess', '2025-09-25 23:04:00', '2025-10-03 17:35:24', '2025-10-03 17:36:29', 'ended', 'during', 'one_time', 'fitlive.kLbSnh9wG6', NULL, NULL, 'fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 3, 0, 2, 'public', 0, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-25 14:34:34', '2025-10-03 17:36:29'),
(34, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-09-26 05:00:00', NULL, NULL, 'live', 'during', 'daily', 'fitlive.3NREkiEk17', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(35, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-09-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.33Jf6pbRkJ', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(36, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-09-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9yQlSQwh1T', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(37, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-09-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6yzpviTRud', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(38, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-09-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xBimQ5pTcE', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(39, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-09-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bv2Ts4hscY', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(40, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-09-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oBy8b2Nz0J', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(41, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-09-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.z48JrxnqYw', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(42, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jp4wkulfMp', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(43, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TDGjWukLcA', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(44, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mF5sLFXQun', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(45, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.AHkrUfp5rY', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(46, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2cxhtMPzri', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(47, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mnu02ZHgMg', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(48, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pvWsp0djfc', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(49, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.k9uLbhgwrG', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(50, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4WJczws93C', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(51, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DH4Ml8I2Rg', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(52, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-09-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GC2yQNRch3', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(53, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-09-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7J1JijCCbp', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(54, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-09-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.M6jyzuFzSn', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(55, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-09-26 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SqTPLkzI7Z', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(56, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-09-26 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aut9bwNkW3', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(57, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-09-26 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DKi5Ygobmj', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(58, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-09-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aB15MRNfPm', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(59, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-09-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YAbRBRzn6H', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(60, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-09-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.njOCUbFVe3', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(61, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-09-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZppVawD9k3', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:13:29', '2025-09-26 09:13:29'),
(62, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-09-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5mRzDZL7nV', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(63, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-09-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6Ve1UEhBjG', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(64, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-09-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mXo0RK7qNL', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(65, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-09-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WkfXgswMFP', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(66, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-09-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.K2B6Gq3BCY', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(67, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-09-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dmXH6JgnY0', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(68, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-09-26 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.j6cyxLqh0H', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(69, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-09-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tZQ3LiHtAg', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(70, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-09-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hjq1bH59p6', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(71, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-09-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4hqd1i694j', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(72, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-09-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DOnI3a00Jx', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(73, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-09-26 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.heauAhOF2x', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(74, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-09-26 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0bOi6GtOBB', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(75, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-09-26 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8YfRCSvSKg', NULL, NULL, '/storage/app/public/fitlive/banners/sLeITZcnFiWQ21hKV1NYeYIVTsWbFVsdGZluzxjt.jpg', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-26 09:15:48', '2025-09-26 09:15:48'),
(76, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-09-27 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RWNGvOBzQh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(77, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-09-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RN5GezJ52U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(78, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-09-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vGZ5tsE18y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(79, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-09-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZFOX8EjhKH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(80, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-09-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KUHpiT0djc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(81, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-09-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.L9xnrzoOyP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(82, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-09-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2d6S0dJ3kj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(83, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-09-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aWbtRnPuqM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(84, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KXrrsGEt9o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(85, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YX7MDImDbE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(86, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.G1and1QZT9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(87, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.abM1RQEngK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(88, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.atK5wLEj4K', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(89, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eMFjQoElOG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(90, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.40BYvT1Y5e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(91, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.C19btpJPnI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(92, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.44n5i5WXpO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(93, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lcby5kp3a6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(94, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-09-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6zwn6Eyk2h', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(95, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-09-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4CsauROX7F', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(96, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-09-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Hm9CgnQpfo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(97, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-09-27 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.P5FBMmy6LH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(98, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-09-27 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.llIqSre77x', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(99, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-09-27 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iEXGq3u9Vu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(100, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-09-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8vjsMN2ESg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(101, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-09-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oVRFTgDmEf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(102, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-09-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VqRHOtIql4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(103, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-09-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rMgby24avl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(104, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-09-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jEZ6qjZcS8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(105, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-09-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.z4M2j2IGLK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(106, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-09-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jLAuIindTb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(107, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-09-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ELhpIJDmow', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(108, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-09-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gYORVOCj9U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(109, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-09-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HBr8ehDQmz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(110, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-09-27 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.u12iQCim8B', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(111, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-09-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iffBt37ZSx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(112, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-09-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VBYuPBW6Tl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(113, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-09-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.m10IE3GkiW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(114, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-09-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jYFqA7u0cE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(115, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-09-27 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.45925WT3Ap', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(116, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-09-27 21:00:00', NULL, '2025-09-27 16:00:00', 'scheduled', 'during', 'daily', 'fitlive.p1nw9Yzzjn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(117, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-09-27 21:30:00', NULL, '2025-09-27 16:00:00', 'scheduled', 'during', 'daily', 'fitlive.gXJDTpVwFt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, '/fitlive/recordings/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, NULL, '2025-09-27 10:57:34', '2025-09-27 10:57:34'),
(118, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-09-29 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.I4gvb6KPsg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(119, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-09-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UgPvuqpTS9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(120, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-09-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PByaRPYFas', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(121, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-09-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.s5oUtrb8XR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(122, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-09-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LCcBFFty7q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(123, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-09-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OPyQyCJT0L', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(124, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-09-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9ECkzn72va', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(125, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-09-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.umjM9mKu9i', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(126, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lvnn414jUw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(127, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jA8HugYzYF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(128, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.boDHuB6g6V', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(129, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kXMa6wD2P8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(130, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LIIrZzxmQn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(131, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Tfm5k4Qj1v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(132, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lWHJE4FgJ9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(133, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Qw58fbw39d', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(134, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SIWvZ0JFwm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(135, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PXORuQ6COZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(136, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-09-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.V1IDRvmb2Y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(137, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-09-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.h9KisHVd7V', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(138, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-09-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dzfNKhMuiV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(139, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-09-29 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Kv47739Iu0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(140, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-09-29 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nFE4kHQMJj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(141, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-09-29 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cVcUXGLoHP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(142, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-09-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kobDTu8pLD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(143, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-09-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WBDzWk3B9l', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(144, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-09-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.z8Zx6qKWgP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(145, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-09-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NKu5eDt9YU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(146, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-09-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ikb3PzKkLw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(147, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-09-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.N5dyUEy9Bk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(148, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-09-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.82bF8bOwNg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(149, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-09-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1FvVff9qvo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(150, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-09-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WvaWjlDZ31', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(151, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-09-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SjMJY4L0mo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(152, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-09-29 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.koxKwcJbJz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(153, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-09-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9N9CcDslTO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(154, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-09-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2JjAnCycnb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(155, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-09-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7xTgBd9Por', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(156, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-09-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2VpystvfmJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(157, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-09-29 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hrImdWbUfW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(158, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-09-29 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rMsD7y8vtC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(159, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-09-29 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2T6m4qBM0z', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-29 06:05:20', '2025-09-29 06:05:20'),
(160, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-09-30 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.us4zObG06a', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(161, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-09-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kNR7XV3ojn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(162, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-09-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nzy4VCC8V1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(163, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-09-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VRss89bDGr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(164, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-09-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xm937qcgLl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(165, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-09-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.AARYCx3ihj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(166, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-09-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.19uEMXhT5e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(167, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-09-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.T5aj3yMivF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(168, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8uWWWE6g2z', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(169, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pcsVXPTXUy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:34', '2025-09-30 05:36:34'),
(170, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 08:00:00', '2025-09-30 14:24:51', '2025-09-30 16:07:57', 'ended', 'during', 'daily', 'fitlive.0zjbW3sEgj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 16:07:57'),
(171, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.O2TWESyTRh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(172, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wSQeuI57kD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(173, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eVN4KkbueF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(174, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JmysnmvAIZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(175, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Jft7lqDenV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(176, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tMcKdtkzzQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(177, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-09-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sXLwELxRwX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(178, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-09-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6zzvaswlTV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(179, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-09-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o0zwGwytDd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(180, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-09-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HmHhG8xLbA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(181, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-09-30 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6nmShOulD3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(182, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-09-30 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OVvERM7Mlg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(183, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-09-30 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8bnb0wfq4I', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(184, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-09-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ySTyA95TFt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(185, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-09-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.buhyBrWb0N', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(186, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-09-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ahFNmeDWuR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(187, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-09-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LAKC9ToARR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(188, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-09-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RYkGNYNZKu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(189, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-09-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lcbLsB0GgT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(190, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-09-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hsQRXq1ktZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(191, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-09-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VYqS2mxN7A', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(192, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-09-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GWEPuYKMqZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(193, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-09-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3IQzADypI1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(194, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-09-30 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.M5XDB8puNr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(195, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-09-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.t50XRQdAhm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(196, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-09-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.n5dqlTJtMi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(197, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-09-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7ZA1FCNhoU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(198, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-09-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lUVxopiBEJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(199, 21, 6, 1, 'Daily Meditation Session111', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-09-30 17:50:00', '2025-09-30 12:16:21', '2025-09-30 12:17:49', 'ended', 'during', 'daily', 'fitlive.Zir7CLs6Jd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 12:17:49'),
(200, 21, 6, 1, 'Daily Meditation Session222', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-09-30 17:12:00', '2025-09-30 12:18:19', '2025-09-30 12:22:37', 'ended', 'during', 'daily', 'fitlive.9VX7YKGbUT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 12:22:37'),
(201, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-01 04:10:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oI5soLJQc8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-30 05:36:35', '2025-09-30 05:36:35'),
(202, 21, 6, 23, 'Meditation live', 'Meditation live', '2025-10-01 03:52:00', '2025-09-30 12:32:32', '2025-09-30 12:32:41', 'ended', 'during', 'one_time', 'fitlive.bKKdNWp29L', NULL, NULL, 'fitlive/banners/uicjoW76mjBBCx6ndbj6qfShFMUKCOuVEGlFkMGG.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-30 12:28:24', '2025-09-30 12:33:56'),
(203, 21, 6, 25, 'New Meditation testing', 'New Meditation testing', '2025-10-01 04:30:00', '2025-09-30 12:36:34', '2025-09-30 13:47:37', 'ended', 'during', 'one_time', 'fitlive.wbpN40IWT5', NULL, NULL, 'fitlive/banners/yf9ciltQ8Jbeulf13z2Idw9gM5HWprBaTdSNh9jJ.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-30 12:35:29', '2025-09-30 13:47:37'),
(204, 20, NULL, 2, '4 times Olympia - Jeremy buendia', '4 times Olympia - Jeremy buendia', '2025-10-03 22:30:00', NULL, NULL, 'scheduled', 'during', 'one_time', 'fitlive.2JXHn77vaE', NULL, NULL, 'fitlive/banners/oicT1LkCRVc2lQtFT7CWdoxLpihOcMJWGwC286fJ.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-10-03 16:38:14', '2025-10-03 16:38:14'),
(205, 20, 21, 25, 'Transform with Kris', 'Transform with Kris', '2025-10-04 00:30:00', '2025-10-30 10:24:51', '2025-10-30 10:27:46', 'ended', 'during', 'one_time', 'fitlive.XggeJ0Tfoz', NULL, NULL, 'fitlive/banners/gskg1tKZiPTs7KCi4dvbuaeE6RTo7Mn6zrCUpgHN.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-10-03 16:42:18', '2025-10-30 10:27:46'),
(206, 20, 21, 2, 'How to Stay fit being a Mom - Yanita', 'How to Stay fit being a Mom - Yanita', '2025-10-04 21:30:00', NULL, NULL, 'scheduled', 'during', 'one_time', 'fitlive.7fAjrJSMB5', NULL, NULL, 'fitlive/banners/EkSupnE52OTdzaB7gvTzb6Mi42ataNFPG1467rZb.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-10-03 16:41:05', '2025-10-03 16:41:05'),
(207, 20, 21, 2, 'Build with Hanny', 'Build with Hanny', '2025-10-03 23:30:00', NULL, '2025-10-15 11:16:25', 'ended', 'during', 'one_time', 'fitlive.ofBjpPLp0s', NULL, NULL, 'fitlive/banners/LmtxHabZOlKdqK43jZnIHLXcRQlu9wp4fJTVUggd.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-10-03 16:40:05', '2025-10-15 11:16:25'),
(208, 20, 21, 2, '4 times Olympia - Jeremy buendia', 'times Olympia - Jeremy buendia', '2025-10-03 23:40:00', NULL, '2025-10-15 11:13:19', 'ended', 'during', 'one_time', 'fitlive.Vtsoh4g7qH', NULL, NULL, 'fitlive/banners/JcB4XytxnuOzGWRFUwxK0g9XLRrkT0LKWsRtuBq8.jpg', 0, 0, 0, 0, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-10-03 18:04:40', '2025-10-15 11:13:19'),
(293, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-06 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8g9FgyJS3w', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(294, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-06 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WtFNHTYZxK', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(295, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-06 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.y3zdVMQUFn', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(296, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-06 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6hbzRE1r1T', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(297, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-06 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zKrYLlRJSA', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(298, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-06 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HtRbU1X16F', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(299, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-06 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.drSrmo9CyQ', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(300, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-06 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.j6Mok9IwM9', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(301, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZRoovljLzb', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(302, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Kxfom9rt3o', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(303, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gtQzzkXgGX', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(304, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2Rf7HwEpVm', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(305, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NcZT23qERC', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(306, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wutoTnLRJm', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(307, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gScNu0n8tm', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(308, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YZcYsj8r3C', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(309, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.M7rHaybJhw', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(310, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-06 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gcxjUj1mjU', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(311, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-06 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.p7oSJUN5BG', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(312, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-06 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Odnbnd6JzU', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(313, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-06 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1VRxUSMzdN', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(314, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-06 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PXHhXJ2vIQ', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(315, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-06 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qgIKCiORvE', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(316, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-06 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jhmFeA1SPD', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(317, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-06 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.V2NyGk38Cb', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(318, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-06 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.itPV4E5YHv', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(319, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-06 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IgAkQisCyL', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(320, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-06 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WvYHuxpPkl', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(321, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-06 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OW65DBaBPV', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(322, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-06 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Rungw4Y4AZ', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(323, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-06 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XhbTKN1XyD', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:46', '2025-10-06 11:14:46'),
(324, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-06 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2ZqCo1mu2c', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(325, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-06 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oXdZnk9Uo4', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(326, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-06 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4Z72LNdasX', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(327, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-06 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7hgq4jBJqc', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(328, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-06 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YFU4d0yXM9', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(329, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-06 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FqTcKXP0Vo', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(330, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-06 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.u9zREeepVt', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(331, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-06 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xoNMzPxxDk', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(332, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-06 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HZfJgnZDrA', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(333, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-06 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WLXzfB9RS4', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(334, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-06 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kagQ2WIoTO', NULL, NULL, NULL, 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-06 11:14:47', '2025-10-06 11:14:47'),
(335, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-07 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DaeSOFJgCj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(336, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-07 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fTzVp55J8m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(337, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-07 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lQmfsAtGas', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(338, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-07 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3xE2tRSA9e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(339, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-07 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UW44tGkNN9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(340, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-07 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kcK1ZFg5Jx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(341, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-07 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.y5ZKYUEHIU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(342, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-07 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MGnTqMaqoa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(343, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Ghv3Ib1faj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(344, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EhtINMDiux', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(345, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PBrYVR7mc3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(346, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uCicDxbXA7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(347, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GJi9HpPqz8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(348, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UE57HaHzla', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(349, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0H9lfcjyTz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(350, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MlHG0v9If5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(351, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PoWI28b6eU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(352, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-07 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UdFnScAZYy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(353, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-07 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lu47Eb2TSq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(354, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-07 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vGgsNZEGLD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(355, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-07 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IPy8NWMbGI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(356, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-07 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b17f9eWyVq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(357, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-07 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.W7NszYTfLk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(358, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-07 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YF92i7h9mm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(359, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-07 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4NhUSUZrqp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(360, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-07 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hgLaLHIol9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(361, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-07 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vn5T12fsQM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(362, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-07 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pwVLgBO7wf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(363, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-07 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kANcBwwSwB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(364, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-07 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fewq4wmqc7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(365, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-07 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8DKnFlu6br', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(366, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-07 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gAEkd7x7e1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(367, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-07 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6Akqq2oSxo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(368, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-07 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4janneRYjD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(369, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-07 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1x9sxOvjhT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(370, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-07 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8LNjeVKX3T', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(371, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-07 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2MPdZcPlnS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(372, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-07 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.t9NwJRRfSZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(373, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-07 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dSNalAR85o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(374, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-07 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.amjd0dLWVt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(375, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-07 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZR8PDugK3x', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(376, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-07 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Sf9TPaDqqW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-07 16:15:02', '2025-10-07 16:15:02'),
(377, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-08 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.z10VIHbnuS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(378, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-08 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5i0tyG2jAC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(379, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-08 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kZgdlClDn5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(380, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-08 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CHkwUI9URE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(381, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-08 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MlkrYL23ae', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(382, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-08 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eGxqit6yHW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(383, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-08 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gsYZEDJ4Tb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(384, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-08 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HoNQfeN7Ji', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(385, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pxSztj8JQ5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(386, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zZMMVDROHB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(387, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wDvnmHavuL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(388, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YGm9PmL8CF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(389, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vOL0rNQcFG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(390, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Vwyh6FDDTe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(391, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mpDPveTaQJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(392, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yRJBEIABML', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(393, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NGSMR6RMQ9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(394, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-08 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OmsG2X3LLz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(395, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-08 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2qojlv1PAC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(396, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-08 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.233TYSSAtL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(397, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-08 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BT19eu6LQa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(398, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-08 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hlCFNm9GZ9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(399, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-08 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Fayd3rXVHL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(400, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-08 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0hjt0NkJeB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(401, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-08 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b6wbRzXftA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(402, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-08 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZVaIBKtn1v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(403, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-08 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EbnsxUxgKo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(404, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-08 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.L1r2sPAbwd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(405, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-08 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.THQK2EwSDE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(406, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-08 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8RyoxqJ9Ig', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(407, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-08 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mVwLDnCpp5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(408, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-08 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b1vvbrCF4S', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(409, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-08 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.C1iAIA0Kvm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(410, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-08 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OIbaOFCSKI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(411, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-08 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nH29QUwlPq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(412, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-08 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hh6QwDQ2ji', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(413, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-08 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4Q3a49HBrz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(414, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-08 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nzTPBgAOjQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(415, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-08 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qMLnWexijD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(416, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-08 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.abhIVIvjLb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(417, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-08 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yDhopcvT58', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(418, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-08 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2jYpfcuDXq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-08 12:03:02', '2025-10-08 12:03:02'),
(2072, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-09 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.A6cwVJNxCJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2073, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-09 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BFmthCfalT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2074, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-09 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1satv5IlA5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2075, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-09 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.STJYDzJwjA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2076, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-09 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Fk5uYLx4ZO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2077, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-09 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NaMRWDC2sq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2078, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-09 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.twYHo9bLyJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2079, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-09 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RtW0RaDJyw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2080, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LJbFS24uiR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2081, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IZVR28CCIx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2082, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lc1uPDY4Az', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2083, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XkuUwDwiDg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2084, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kxOdUIjbfo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2085, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.N1LNFvSRZ1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2086, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0wifjfOwwJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2087, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RLI7yzkeyB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2088, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TlbPORHPZF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2089, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-09 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.AglrsTHNjr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2090, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-09 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tbG2pDlCiZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2091, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-09 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iiKg0XWpRX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2092, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-09 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BYp5yyubZH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2093, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-09 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BcKkhXFCKo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2094, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-09 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eiBQ4TuqaS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2095, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-09 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WYbSNY59oA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:03', '2025-10-09 14:18:03'),
(2096, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-09 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.k1Ur8QsO1s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2097, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-09 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.t03HB2UF75', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2098, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-09 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gY3h9uARaB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2099, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-09 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cb2f6JEB3h', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2100, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-09 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.B1q8Tyit5u', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2101, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-09 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bsUuzTkDjl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2102, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-09 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZJt9v7J5Jq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2103, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-09 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fvnXyvL0MB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2104, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-09 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.g62pgnpnEV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2105, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-09 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.foY3nED5LT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2106, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-09 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LgszueRDMY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2107, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-09 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NCqdvVCB0Y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2108, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-09 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qQaTmVvycR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2109, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-09 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OU6aaGb9ft', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2110, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-09 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.C74ctmFF7J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2111, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-09 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.C6YRKtfUsm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2112, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-09 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qZcxDte1Ap', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2113, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-09 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mMiSf37ZEL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-09 14:18:04', '2025-10-09 14:18:04'),
(2114, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-10 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kVzK2F400s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2115, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-10 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.A2rPZSxzgg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2116, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-10 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QI7JIgSbPL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2117, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-10 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pjwEXxlglZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2118, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-10 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.E7xeXd8Ped', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2119, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-10 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.g6nzNeXyNw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2120, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-10 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Br24IoGI5G', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2121, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-10 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qtiiabebYc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2122, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LcPEJM9QfZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2123, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HWYpxIHFQg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2124, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zJRMqf2703', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2125, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OkLpH6QvJW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2126, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5dtJB012uW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2127, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZN2QYcBfi8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2128, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.m2vfY5Ug2O', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2129, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XTLvxTnpiv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2130, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.n8TGWihbF8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2131, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-10 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Nz8lPPBsIQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2132, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-10 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZYRllnpNk5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2133, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-10 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4xHfYP92A2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2134, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-10 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.y3BObiwy0p', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2135, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-10 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BWbmDsMFFk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2136, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-10 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UVi56L4nmV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2137, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-10 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qN0pVRNfd3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2138, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-10 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gCvFyRDFz2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2139, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-10 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HugaJVXXJe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2140, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-10 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.N4jT9Ashx8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2141, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-10 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.m60MqBsMOv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2142, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-10 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LYi08jLHMq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2143, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-10 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5zZqN9i1r6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2144, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-10 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UKOpTqfAbD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2145, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-10 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ibzpQDxxo0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2146, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-10 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5G2YLmXP3V', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2147, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-10 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qBNfO0HYgM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2148, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-10 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HwtTA20d8D', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2149, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-10 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1hRQmKtT0H', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2150, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-10 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9GK5LUKTBY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2151, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-10 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.86VxtWfI7F', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2152, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-10 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.d6Mv8VdW2m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2153, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-10 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gxe0HJYceN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2154, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-10 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qN8aquO3Dh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2155, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-10 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zSlhyvoe5l', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-10 01:30:03', '2025-10-10 01:30:03'),
(2156, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-11 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0cD2G1UOHN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2157, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-11 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LcSrqYkLA2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2158, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-11 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.db96giVLAj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2159, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-11 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tmdUfM7oSr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2160, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-11 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EfCmIurEPO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2161, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-11 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bBTPNN2pb5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2162, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-11 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dX4sHU0Nay', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2163, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-11 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oIYopDX7zl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2164, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LFYgHWfgIs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2165, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NWQZyBXKmg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2166, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ePRQniJHOZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2167, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OmdCVB9nET', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2168, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QN2v4N8JUh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2169, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.W3Ni6xiTyg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2170, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Yq4Mt7fRvu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2171, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eEHpzSEWjN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2172, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rj51FlWA3m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2173, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-11 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3h15XyllSo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2174, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-11 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WmNzWC20Kj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2175, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-11 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kA58tOd5tB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2176, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-11 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0a5lU9KVjM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2177, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-11 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zdCBmduK1s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2178, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-11 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9XESEp2X6Y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2179, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-11 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qWojx0aTMZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2180, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-11 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mBaDKbPdfV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2181, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-11 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xq4DIILWjB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2182, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-11 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oOsjusSgWl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2183, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-11 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1SU4VeeEo8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2184, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-11 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9qegVtMGcx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2185, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-11 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lU5tnO99d2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2186, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-11 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.c4Otu5QWyL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2187, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-11 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4lcr1q5djv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2188, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-11 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.znRtZpmRxw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2189, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-11 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rshhAzylzK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2190, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-11 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nl87G5E68R', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2191, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-11 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TpaAOMi4XG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2192, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-11 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hgegS3EGNs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2193, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-11 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JMHyWvt3V5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2194, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-11 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ezNkS5jwKy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2195, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-11 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zdudhnJ25k', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2196, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-11 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LH66hMR28q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2197, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-11 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6ZjHKowsgm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:30:02', '2025-10-11 01:30:02'),
(2198, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-12 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HIbmG0lGMk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2199, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-12 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9N0EUXzFlp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2200, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-12 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aablqGp0LY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2201, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-12 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LMhfPocZJA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2202, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-12 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.x7NN4NqMz0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2203, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-12 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bIFLIGwBdf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2204, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-12 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7VBOurYmEj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2205, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-12 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GDQDgxLT4r', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2206, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o0k8uE3Hv8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2207, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lYC0IW44X6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2208, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.E6ucJY0wfq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2209, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.a1m6HXq5NZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2210, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vtk8145FM8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2211, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZwyiD2vvmI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2212, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nOTzxSxOzt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2213, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1CTXpISLDF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2214, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wGa6YzVlu4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2215, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-12 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eoZEOtkWiD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2216, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-12 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WmSyHm6IQg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2217, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-12 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.01t57zZOnI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2218, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-12 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TN5ApaAjgu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2219, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-12 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.i77sTqhKVy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2220, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-12 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mlbTaiLnOD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2221, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-12 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mzRSci3StU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2222, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-12 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KUmqr9ZrV9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2223, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-12 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dyjPbl9J0r', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2224, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-12 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eXdpycV6g3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2225, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-12 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.A4f31bqfmq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2226, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-12 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.T4MXgoC2vY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2227, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-12 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oep6S73BKH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2228, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-12 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.k7IssRwFYu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2229, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-12 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZeoN5u4Vjh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2230, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-12 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jCQLZCDBHE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2231, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-12 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b3ecUNQhwR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2232, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-12 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ucYMkr4rNK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2233, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-12 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cPia4B8DQR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2234, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-12 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Rm6cm1635W', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2235, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-12 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.knWNX43UEp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2236, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-12 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7NFTyR9qhE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2237, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-12 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3GKJZpWONT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2238, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-12 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o2z1gRKBS8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2239, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-12 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.87MZRcMQmj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(2240, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-13 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mLPamGOlmT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2241, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-13 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yVkgbYuehY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2242, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-13 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5jSFBThbFo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2243, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-13 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7fjM9DGLwe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2244, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-13 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6SJ2kasB18', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2245, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-13 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Pb4o2wxwOk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2246, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-13 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Nso5AuIrq0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2247, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-13 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1WFr21NO2x', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2248, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SwVNO800Ns', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2249, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2Zc9oWl3wS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2250, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.B6CXGgigrd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2251, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EACKZWb4Dj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2252, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NcF5ea6vzR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2253, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.66y4nEWVhQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2254, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mk3yTDHDzA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2255, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LeaFIVcPoL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2256, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QmqxUloFsE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2257, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-13 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6tzAQ2OFYn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2258, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-13 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PiENTSE90F', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2259, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-13 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4S9OtQ6SEM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2260, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-13 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iWMTETK0YE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2261, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-13 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UsNxQeuUvy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2262, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-13 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4w2QtceBnV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2263, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-13 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jK4GXm3hh0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2264, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-13 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.blyvsdw0MD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2265, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-13 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ECk7rltXUE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2266, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-13 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QfXboPdSJ8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2267, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-13 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.igMqEzOPGI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2268, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-13 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5zGO3eVsBA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2269, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-13 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ziLXiMzH9L', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2270, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-13 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qeZoal1ztO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2271, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-13 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kqOBtidPtn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2272, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-13 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.stonW5Yy0U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2273, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-13 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XUfn8K9Tdz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2274, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-13 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HZscwvZCna', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2275, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-13 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cZ0ql2xKf7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2276, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-13 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.W05LcRrG6b', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2277, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-13 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7u5Ym7h4jq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2278, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-13 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yP5kZVr5ii', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2279, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-13 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.I3imRPDHVH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2280, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-13 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PCMBZruoiV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2281, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-13 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CCfMB6eUXx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(2282, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-14 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8lNY3ihkEA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2283, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-14 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dpQzguAMs6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2284, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-14 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FqGV9ssjyR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2285, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-14 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.I4RNPn8L7Y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2286, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-14 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7PoMybHP4e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2287, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-14 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Kx8MhsciEf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2288, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-14 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8puX91NxvG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2289, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-14 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7rZKpBRuOG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2290, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VRrFOG4lOv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2291, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gXuZcAlvzy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2292, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.h3XJHlj6Wr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2293, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LU72d6pfAD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2294, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5jUJBEhEqp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2295, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uY4uoq64XN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2296, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IhluJrnFgs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2297, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lMS0vI7K5N', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2298, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UfJBCbeb4f', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2299, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-14 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.x3TlPKja5c', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2300, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-14 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Oes9gT2Jb7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2301, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-14 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UEv54OJ3jO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:02', '2025-10-14 01:30:02'),
(2302, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-14 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OpNziEUlKi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2303, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-14 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rnJ9Yjr8gJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2304, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-14 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pjS8R2BTGS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2305, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-14 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XIiZUDVJA4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2306, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-14 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Zkzveh5uo0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2307, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-14 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PvkG30VoOL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2308, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-14 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aOLgZxK1HQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2309, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-14 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JyriUra9Ez', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2310, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-14 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5uZ0ljjm2B', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2311, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-14 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KwDgdrAMZp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2312, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-14 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vLarQrj6oj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2313, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-14 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xNtjPB3z3q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2314, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-14 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bq4H8ExMO1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2315, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-14 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VcDCJDzBRH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2316, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-14 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7AU9Amavz7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2317, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-14 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oFMi8rC94V', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2318, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-14 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Inwza75p3p', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2319, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-14 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PeB3koOwxj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2320, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-14 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UeWdT6wBqD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2321, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-14 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eYV9cYM6RR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2322, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-14 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dW64BgklOV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2323, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-14 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HhaPwC236R', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(2324, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-15 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tgePHlJdIZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2325, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-15 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Uzj6kv7ceF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2326, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-15 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o5Vj3gga5s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2327, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-15 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DsT2duKzqX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2328, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-15 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tVPM2n7Dci', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2329, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-15 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4QBEliKVGm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2330, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-15 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5Dr3P6d6UF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2331, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-15 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dMO051EkNe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2332, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.omjxGSxm0m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2333, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gkXEgjxcNJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2334, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xnwYkCmOqP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2335, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9J53vc3Y35', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2336, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2lqTLnjvww', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2337, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WpHYZiOi4v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2338, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8Z9P78Nibm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2339, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.u8fD6Nycbs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2340, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cdZm4ShoiW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2341, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-15 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HLyToeAPbq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2342, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-15 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ieCRusucYO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2343, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-15 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SEyNPRla8r', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2344, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-15 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.w7m9eB6IFc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2345, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-15 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7r13rEizTY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2346, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-15 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZjFdVFj5Hw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2347, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-15 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8dtsNDPLs1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2348, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-15 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WlmiWdl7n6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2349, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-15 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SwHAF25oFc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2350, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-15 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MF3WqX0BF5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2351, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-15 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6Z0MZfREjM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2352, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-15 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lXniUMADru', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2353, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-15 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9yrs6IVinG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2354, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-15 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qWHEFbnF56', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2355, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-15 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8QVLDIsKRP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2356, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-15 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3cN8m50ZgI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2357, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-15 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Iay5aFVkjh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2358, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-15 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.erHbpSgxxn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2359, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-15 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.m2lt8b5H3o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2360, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-15 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KGwgZJNxLO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2361, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-15 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.P9SoD8sz4r', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(2362, 21, 6, 1, 'Daily Meditation Session444', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-15 14:55:00', '2025-10-15 14:56:12', '2025-10-15 14:56:40', 'ended', 'during', 'daily', 'fitlive.A09WYKAfVB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 14:56:40'),
(2363, 21, 6, 1, 'Daily Meditation Session333', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-15 14:53:00', '2025-10-15 14:50:10', '2025-10-15 14:55:27', 'ended', 'during', 'daily', 'fitlive.naxGhNiVQL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 14:55:27'),
(2364, 21, 6, 1, 'Daily Meditation Session222', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-15 14:31:00', '2025-10-15 14:27:45', NULL, 'live', 'during', 'daily', 'fitlive.094wRpoPPP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 14:27:45'),
(2365, 21, 6, 1, 'Daily Meditation Session111', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-15 12:24:00', '2025-10-15 12:22:06', NULL, 'live', 'during', 'daily', 'fitlive.xnqYnzj11E', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 01:30:04', '2025-10-15 12:22:06'),
(2366, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-15 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JtsetALqks', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 13:30:03', '2025-10-15 13:30:03'),
(2367, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-15 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.S4AQ8BK2ez', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 15:30:03', '2025-10-15 15:30:03'),
(2368, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-15 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.88HN1RUfuO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 15:30:03', '2025-10-15 15:30:03'),
(2369, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-15 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wQWmn330oU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-15 15:30:03', '2025-10-15 15:30:03'),
(2370, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-16 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LsGiIaCHfk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2371, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-16 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sp2Q5skkGO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2372, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-16 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6886aviql5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2373, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-16 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.w1dAilCEZq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2374, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-16 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9TNNmstTDQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2375, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-16 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YV2Pbs1HRz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2376, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-16 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TSFqOSO1JJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2377, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-16 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.U82KlOvqte', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2378, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iajeKzdoSX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2379, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kCUQ4UkrtY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2380, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0J7hvMChC2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2381, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lwvRSkSwds', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2382, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.h1RCkaH1XO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2383, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.d5WNGWH09M', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2384, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xJbXs8cwYt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2385, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zoj8kGJaUz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2386, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bacpYnhj9J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2387, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-16 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xu4CI3OQhU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2388, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-16 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.05zeMcqDu3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2389, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-16 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.liKeAdIAUy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2390, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-16 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vLYkEhlRal', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2391, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-16 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.U8mrCPxQ27', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2392, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-16 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QhRbTEDn3v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2393, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-16 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8RkhneBbJL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2394, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-16 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XHUSUYluK1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2395, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-16 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NJmj0xntxd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2396, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-16 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EihpYhSYmK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2397, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-16 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gw7vmiT20p', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2398, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-16 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9dN7rOs9FW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2399, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-16 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Xd9J3EMH3v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2400, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-16 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vDEGVbYE2w', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2401, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-16 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qahM4tp9lA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2402, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-16 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WXSMBq914U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2403, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-16 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qvoPtgO91e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2404, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-16 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FRjvjnp9XD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2405, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-16 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sOSQxUShSG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2406, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-16 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GPPkWM730J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2407, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-16 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.doSjDlvysU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2408, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-16 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.l0dRBSw3vV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2409, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-16 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2i0nnOjOb9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2410, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-16 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dIBeHg1c7v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2411, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-16 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.AfB5hZw2Vu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-16 01:30:03', '2025-10-16 01:30:03'),
(2412, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-17 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.T86bg8OfeT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2413, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-17 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ompkViDgX3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2414, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-17 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.g0q31coYns', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2415, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-17 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1B7BBKkjpQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2416, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-17 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zmPKxG4NgE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2417, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-17 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pfqZOiWWvI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2418, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-17 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.siynFjA5kT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2419, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-17 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7DYQ9g4e8A', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2420, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tbjIQ9Sktr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2421, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.06R4S0NKQQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2422, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OqM6CnZ5KV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2423, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.54XxF8p6Y1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2424, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FB7hy0kz3K', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2425, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WArtYGOnJE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2426, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SzPDotTKfy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2427, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ork2GT5Me0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2428, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zC5AgMgSuN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2429, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-17 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.u2tKwoYwc9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2430, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-17 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Xy2ph4iJS7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2431, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-17 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wVuE6JZ08b', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2432, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-17 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.avwJghIwC5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2433, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-17 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KIWdvdq2wD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2434, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-17 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UGAqlyHK0H', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2435, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-17 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o6I7suBJ6R', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2436, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-17 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NclR4t1puP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2437, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-17 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.23YHvR3Ge6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2438, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-17 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RrFZ8RSkQG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2439, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-17 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CghLYLOT9X', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2440, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-17 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ITBpILGOHw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2441, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-17 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MKMaLyoWCI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2442, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-17 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kWlOmRofQD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2443, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-17 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MxQl7zOAyK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2444, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-17 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nQPq37eZYT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2445, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-17 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2dMNt3Ri8K', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2446, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-17 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.d0S1kdL3FL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2447, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-17 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GUmR6uZ33R', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2448, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-17 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fH1A4Dhxtw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2449, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-17 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KptKYu932M', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2450, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-17 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2trySq2nnD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2451, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-17 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Sw3nyAejPE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2452, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-17 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eVfaN8aPdH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2453, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-17 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EtJe5HAjm4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-17 01:30:03', '2025-10-17 01:30:03'),
(2454, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-18 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rzVgh4LgJt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2455, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-18 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HPaQ62FJiM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2456, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-18 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SIBJ4WFI84', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2457, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-18 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jfTbBCxPOZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2458, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-18 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.93dtSODsnw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2459, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-18 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.45FNJUbf82', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2460, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-18 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zpaq17IIVg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2461, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-18 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cuMcQTngQI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2462, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kBZaflFa4h', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2463, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5qB0ddWeFl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2464, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Kcr0GDPuQ1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2465, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OzJBGCLyjw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2466, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9MCHk6gSgk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2467, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CMCYCEg22V', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2468, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LVmEr8QsRm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2469, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NMN8wfC39G', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2470, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.97rEXXrzy4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2471, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-18 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IxTyyTQYax', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2472, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-18 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.REB71rSm1w', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2473, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-18 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9jP5sGOOVt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2474, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-18 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VgVstOOAIS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2475, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-18 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ykRRbIct2C', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2476, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-18 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bEOnVAgw9J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2477, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-18 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wlugUr7bbM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2478, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-18 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MYHM8Nlzv4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2479, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-18 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.klZMaMmlTy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2480, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-18 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rN4IWClHLn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2481, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-18 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FKbe560DPu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2482, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-18 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5F2ZSw9vPR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2483, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-18 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ne3idkG78j', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2484, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-18 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bWKRnK2oVT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2485, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-18 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NhLRM8Aj5X', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2486, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-18 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sfxOBKFkI0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2487, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-18 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Kv06Z96Ypf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2488, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-18 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LP0yS6ZhVv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2489, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-18 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hRokUB3Qk0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2490, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-18 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aIx3x7FVJb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2491, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-18 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XwQSdZPfPg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2492, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-18 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vHA1DJboli', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2493, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-18 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SgQTlfcq06', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2494, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-18 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EZVc2zwdOZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2495, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-18 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bEoajuoGOj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(2496, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-19 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YssF1unUcU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2497, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-19 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wDJby5mRte', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2498, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-19 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pAmf21h3W3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2499, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-19 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.l1YMM4PC7p', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2500, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-19 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xRPMso7E2w', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2501, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-19 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.20UVQzdBtw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2502, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-19 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pKG2PGdfWS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2503, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-19 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FJLgV7NEjo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2504, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cxnUqA2FAc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2505, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WvbThaaOM9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2506, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JFNthonm3f', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2507, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GhzwTSTkNL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2508, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uctssm2kWY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2509, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FClHAF2nsD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2510, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UQ2oqSMxjd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2511, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ajUAmlUSP6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2512, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.s5H335Lf7m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2513, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-19 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.T9XCj6G7ld', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2514, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-19 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ExN7gAZp8o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2515, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-19 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HoFZmHptdq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2516, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-19 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PQpTzL1ODg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2517, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-19 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wjTEnIfd08', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2518, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-19 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eHXyq7HZgN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2519, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-19 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.B2DOTPbU8o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2520, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-19 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8fmsEYaCOS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2521, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-19 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HSmkAckexX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2522, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-19 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tlxWfdWC1v', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2523, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-19 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eyXxYd6tt3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2524, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-19 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VHHgtGmGOh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2525, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-19 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0ZCof9Po3n', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2526, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-19 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1D5166iU4H', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2527, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-19 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SnjuGlP1RN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2528, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-19 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CLtZKf7u3P', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2529, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-19 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tGJyzCqEvi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2530, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-19 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jTe62fVgZz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2531, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-19 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NgVF1ANTmV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2532, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-19 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lCFG0Y7jyw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2533, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-19 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Ofu22mb7Hn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2534, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-19 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.n8eXfWyypJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2535, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-19 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8Zelsp4oTB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2536, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-19 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.i9COcAXKdL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2537, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-19 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.E1kcFRak5k', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(2538, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-20 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0LSo4LyKIq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2539, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-20 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.h0hjW01efo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2540, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-20 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VbwbBn4L3N', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2541, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-20 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.D9D6m8oq4U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2542, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-20 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QuJlXzZl64', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2543, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-20 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JX1EmC5KlS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2544, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-20 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KRongWjUco', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2545, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-20 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.10Fhf0PnUw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2546, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KRpRrRVuVe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2547, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0YOMJkkCEW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2548, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NZ1okWYQma', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2549, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HctG3dkXGi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2550, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SaFeVtB49q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2551, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QbLS1pMfko', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2552, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PA0ITMdYs3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2553, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Zysbx1Gvja', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2554, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jVdEktgAi4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2555, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-20 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gYtdqgYIHn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2556, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-20 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oMFNS19ozI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2557, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-20 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0djY9ZiBqr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2558, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-20 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GRNY1sXXb8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2559, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-20 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FGoFHZ5Wgv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2560, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-20 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MOMFsZo80z', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2561, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-20 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5abjnLpnh2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2562, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-20 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Ui52ndWsyI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2563, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-20 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.O9qcMgTVBe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2564, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-20 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VlRrPNwbB2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2565, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-20 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.x67xEYITAq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2566, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-20 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fkun5PCjIq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2567, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-20 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.z7n5miYYsW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2568, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-20 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Efzgddnt4Q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2569, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-20 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CGYeb2LE8z', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2570, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-20 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Sn6NE8sObs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2571, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-20 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LoH3THX82Z', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2572, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-20 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OZ24Fh2zMG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2573, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-20 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5VEgWgvts4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2574, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-20 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GlLptFkFOO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2575, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-20 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4xF2g2CUUv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2576, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-20 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RdSqKjIFpl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2577, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-20 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vU5oPNNYCl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2578, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-20 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.T7dueGYoSE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2579, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-20 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XhrfVi7sp0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-20 01:30:03', '2025-10-20 01:30:03'),
(2580, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-21 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nocVhKYdLk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2581, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-21 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NTCMx7Qh7t', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2582, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-21 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qgMtIvWcMs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2583, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-21 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oSiGHMJKlx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2584, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-21 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YMiHg3fOVK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2585, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-21 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.c9AJMbp8DO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2586, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-21 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kjlpU6bX22', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2587, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-21 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.80zQcJBkRe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2588, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.c84diG6CPC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2589, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.moklW50pNo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2590, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7DjsmBE222', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2591, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CUKqhJgpvX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2592, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.D65bm7dq8j', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2593, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jSGNe95XaY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2594, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3tk1byqXAo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2595, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dNmlQFbQwq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2596, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TKKtaTHjtc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2597, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-21 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yyvzUkg7oq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2598, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-21 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vajkpig6WX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2599, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-21 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jxrDYW1AGj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2600, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-21 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aNd0dealSA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2601, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-21 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fUW34NqzeM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2602, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-21 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wsXvWJDaLA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2603, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-21 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Mwx1ksN5eT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2604, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-21 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VSb7yYWfOa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2605, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-21 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uBYs2KwffR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2606, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-21 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4Yp9w8hk89', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2607, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-21 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gjNRBjAydl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2608, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-21 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MxnFRLsabw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2609, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-21 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.stijFKwpFK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2610, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-21 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.791OQpBJtu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2611, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-21 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XJbDj9ozq7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2612, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-21 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.nDEG7goVWo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2613, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-21 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QZC20tbro4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2614, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-21 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1PhLZS27vS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2615, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-21 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aT8DJm4LVF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2616, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-21 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.h8tWds4BwD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2617, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-21 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3bHz0LYhep', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2618, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-21 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BLiUVVQKRn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2619, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-21 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HP2Ux6cBxT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2620, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-21 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SRGpygdjoT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2621, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-21 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sOGZkelilN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-21 01:30:02', '2025-10-21 01:30:02'),
(2622, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-22 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.y0gK7tVfs2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2623, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-22 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0pRAiKnVJN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2624, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-22 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LMwzFJpFEe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2625, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-22 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OvYSI7Oa6J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2626, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-22 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.snoDnJt9ix', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2627, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-22 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YP3kYi3DAn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2628, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-22 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kKjT7bVe80', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2629, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-22 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MzjrbgqfTA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2630, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gwo9UVLZhj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2631, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1frNcFVYjD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2632, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lxQtb6CIL3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2633, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R8aJromQx4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2634, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4XAOE3unZU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2635, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yXrmphRFhn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2636, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Mlug3nq7g9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2637, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jJlEW3azJl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2638, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dwKx6bvkjJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2639, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-22 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5CS6cndzXx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2640, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-22 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PfohEMvGE0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2641, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-22 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TfSLhbQcev', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2642, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-22 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lUWsJVHmlp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2643, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-22 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DmGfeuW4Jc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2644, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-22 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7fAADX7KgY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2645, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-22 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tQs7NWmloz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2646, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-22 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.c3Qf4bVAuP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2647, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-22 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IdC3m1nHEB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2648, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-22 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ixTz16ZQPw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2649, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-22 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.AJ2hXC5OjI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2650, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-22 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BgQI0Cc3AJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2651, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-22 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.x3CTwkQdqC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2652, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-22 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zWq7XgtvGS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2653, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-22 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kRl6hq2un8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2654, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-22 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b5flJCyPnR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2655, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-22 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.flkaI9Y22P', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2656, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-22 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dzm5MD952x', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2657, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-22 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CvYxJBFbH9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2658, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-22 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R1EFUKjuzJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2659, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-22 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ujw5qsOmdm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2660, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-22 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FJndmdH9M7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2661, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-22 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uOwRuZs4is', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2662, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-22 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MhwPgl0bt9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2663, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-22 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GDxD5t6Lkb', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(2664, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-23 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iYu28mEWlQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2665, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-23 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bD9bnEWu4d', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2666, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-23 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.24IFwiqvsh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2667, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-23 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sCVbHjGNSY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2668, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-23 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cuWZmz0Tlj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2669, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-23 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2fiKhMPlY9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2670, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-23 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.e3LNavLkz5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2671, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-23 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.azaG9UNvFP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2672, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PYORyoToZY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2673, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RWQ9PLUb19', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2674, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tOc4MfyovV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2675, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0Vo27W6nJt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2676, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dijpFL3PYY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2677, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wG8k7VDw4p', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2678, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DteAjepOk3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2679, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CgMUTJhFtM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2680, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lvcam3la6a', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2681, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-23 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o2G28czsIK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2682, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-23 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OYFZTgtwwl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2683, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-23 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kNqWGA9iug', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2684, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-23 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mlPxE4ovDo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2685, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-23 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Yg7webtCg5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2686, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-23 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wXsXZVwq52', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2687, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-23 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iNBjL6KRJI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2688, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-23 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YqNLlquAHS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2689, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-23 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NWLGUZJ2wk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2690, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-23 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iBkpuXflAy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2691, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-23 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tsj24qia9O', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2692, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-23 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VhUCx86chk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2693, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-23 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2zN6154JRL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2694, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-23 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.whfI112TnK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2695, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-23 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZMQiB9fadg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2696, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-23 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Th2zKEyMnI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2697, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-23 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rTcdSlptET', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2698, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-23 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.g26eN3oLG6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2699, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-23 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TOUjnokVmZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2700, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-23 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DCYhlVvt0w', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2701, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-23 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eK0PdcAfmQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2702, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-23 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4ePWn6nVuH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2703, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-23 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lerrc5gQ3s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2704, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-23 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.15zPixiLtF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2705, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-23 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.H4bcWmcsAA', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(2706, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-24 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UAmHGissHW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2707, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-24 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HgBQz09Kom', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2708, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-24 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CPp3Gkp97j', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2709, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-24 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lmJYt9DXF9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2710, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-24 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.F1VTBumh1Y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2711, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-24 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tFN7Hsbj2H', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2712, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-24 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7VBMlUAQX5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2713, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-24 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.t58ybmbaw8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2714, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TK4c0rg3aU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2715, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dminb8yyDI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2716, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.F1q9C4f0cg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2717, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lnGnppXe9H', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2718, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MzpsHIOOWo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2719, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iHomZJd7Wd', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2720, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BP8bL6VGDf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2721, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gpsLXaBfjj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2722, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yc2h8jGg9q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2723, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-24 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.v38Q6o3FKv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2724, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-24 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iJJoUJMVc9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2725, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-24 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hdVDb3ibWo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2726, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-24 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.38o1np1bBz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2727, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-24 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VD6VuCnMVD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2728, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-24 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UbXAurD8br', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2729, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-24 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6RLezbhRL6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2730, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-24 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Fn7ptTQh5y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2731, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-24 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.25AKbnnxpE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2732, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-24 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.sSWp3LOTTE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2733, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-24 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fum3OobDuF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2734, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-24 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.v37mSWLQeM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2735, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-24 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YoFqZyrtWx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2736, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-24 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bPeoTYSwm3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2737, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-24 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vJ7njmGTjB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2738, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-24 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UKDcDkxEa4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2739, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-24 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.imvfJkaK7U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2740, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-24 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.gaG6ZgYrQ9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2741, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-24 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.klE4NuPQCY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2742, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-24 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RJpxk8L2zT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2743, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-24 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5pxAm7u3G6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2744, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-24 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R6fd9aMTmk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2745, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-24 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.J1nlwfTeJR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2746, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-24 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UcDvbzNNiL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2747, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-24 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bWluacJ1VU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-24 01:30:03', '2025-10-24 01:30:03'),
(2748, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-25 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yDdGEhw27x', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2749, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-25 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.w8LeTgZsak', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2750, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-25 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lMz2hgSkkR', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2751, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-25 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mGlQRzSAWz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2752, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-25 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.F6HgpwKGzj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2753, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-25 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zhh6wl6gmF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2754, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-25 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xGZouRNjCH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2755, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-25 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XuuO4GITBh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2756, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VWlLF4LgVm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2757, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.RQ6Wt8UNKZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2758, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8Zdwy0uZgD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2759, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9Kvb5pBHSM', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2760, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.b2a6CGpDiD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2761, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3IP9WjlJU7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2762, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.IkuzcaCZIW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2763, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hId3QBfm7Q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2764, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iV34WesWcT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2765, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-25 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cjUUhBwQHr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2766, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-25 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OVcftgwS9g', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2767, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-25 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PZuUSsTZGJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2768, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-25 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Llby8DOhjL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2769, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-25 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dve3yowgYu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2770, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-25 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FZGvArTFAc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2771, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-25 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oNgTijShj0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2772, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-25 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7KSGKttZ6N', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2773, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-25 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rUpJxXBzDJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2774, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-25 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.X6fJTMsWY8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2775, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-25 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pYxINvLm5K', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2776, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-25 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ubPvuZKCC1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2777, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-25 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.U3M0uwVK1E', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2778, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-25 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CHjkaWiPuf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2779, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-25 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6swP0oOOo7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2780, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-25 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5OnGru6m64', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2781, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-25 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ht3wYWAbfm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2782, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-25 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.GNMj817TZu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2783, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-25 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Au6zlVAvMg', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2784, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-25 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.njKkSOiqBu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2785, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-25 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Q3cFOJwzpa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2786, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-25 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NfK3v6EZXt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2787, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-25 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MlgiXcnEtm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2788, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-25 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kJAifrkFPm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2789, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-25 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hBc6OAlHmm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(2790, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-26 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FtDWqPFPvk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2791, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vDlnLlGV7q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2792, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2ZT2Q8cc8A', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2793, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YZi0mOIpGm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2794, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DS4gM2EGyD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2795, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3SYEuaR8bY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2796, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VrNkSgRy0T', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2797, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cHfr4dksTV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2798, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eJSMaTrZfa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2799, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FfJv2LrezU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2800, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.B8yE8OwPLL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2801, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZQL8iSsokx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2802, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YIexVMkzVt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2803, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Ak4ABcC6QU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2804, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jHMyz9AaFk', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2805, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.D4HxMewgR5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2806, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FkFyANNOXj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2807, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zS0p7YBcfc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2808, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Y12C0cDV7m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2809, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.vbJdalbrQL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2810, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.d5gjjklelJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2811, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-26 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tsyOgED4iq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2812, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-26 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8Cau9jI8nB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2813, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-26 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kHMw2QDkDs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2814, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-26 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R7bLozTSw5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2815, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wKEwZBOmBE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2816, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.B3W90mRGUh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2817, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.su69vLSDv9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2818, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HpnFW4PiIK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2819, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NGJWerYPWK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2820, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ArU8F2EsCL', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2821, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-26 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.EidvHYE331', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2822, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-26 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.09v4BMjbfu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2823, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HAmOyTUGMK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2824, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-26 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qF36GedK49', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2825, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-26 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yjvraIrZEo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2826, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-26 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.bMvpvGChun', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2827, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-26 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3K6YKlQoO5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2828, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-26 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MpG13JHexl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2829, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-26 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LuiVuoOBE7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2830, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-26 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xdP54HvgLa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2831, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-26 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dhV54pYlCQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-26 01:30:02', '2025-10-26 01:30:02'),
(2832, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-27 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CiYL68UjdS', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2833, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ts3MY6ygj0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2834, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Q5QSeaeAL7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2835, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.wc7CWnMJbI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2836, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VCx5pX2jFi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2837, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XyrdNDMCH7', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2838, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.u040zeoXRp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2839, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cNOdDrQ058', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2840, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zmT4tAsTfx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2841, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dwxTyYoTpW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2842, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DfBUj8mZDU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2843, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.qhIPQCiAZZ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2844, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uFgeWbjqP1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2845, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NNiQdpOqh1', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2846, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uzMl7knr9y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2847, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.yu7x66Rb9O', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2848, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1oAQ6DyMQf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2849, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eiWv7Z9voG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2850, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JWFgiNJBRV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2851, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QWiP6pxkUE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2852, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BLdC6eFDQf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2853, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-27 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.uQzqTZncKl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2854, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-27 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pQrBJpXY9q', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2855, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-27 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VzCpQxwVes', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2856, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-27 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1fNRZuWSgN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2857, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5FJqpNKFY2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2858, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Niox1cNZv2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2859, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Zj9lwtZJ5N', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2860, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JVpCK5vkBE', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2861, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zdSIRAUWh2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2862, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6OYPQ1kf47', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2863, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-27 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JUxWzn2IO6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2864, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-27 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zojSJAsGmf', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2865, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NDzfwpApVN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2866, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-27 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tPY8PEPEoK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2867, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-27 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Hrb2Th4Nhc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2868, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-27 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JkH8VFGVnC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2869, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-27 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KZV4hw0xuV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2870, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-27 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.FPKDSu1dhP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2871, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-27 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1cc2zD0Ssi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2872, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-27 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.iLb5vRZV8e', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2873, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-27 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YdYssSZF7y', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-27 01:30:03', '2025-10-27 01:30:03'),
(2874, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-28 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.L5jD5Q9xEP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2875, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-28 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.9dtOQogRsa', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2876, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ANUmc2zbvP', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2877, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-28 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TgwXmETpjr', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2878, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-28 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7xFMdjpqJj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2879, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-28 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5T1TxYFzwv', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2880, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-28 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Y2WKmTmkHz', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2881, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-28 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Sf63vPi7iB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2882, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.56CVeq7I4U', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2883, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tW6MDGaxVW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2884, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R68dceIsnN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2885, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xkR3pCEmsy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2886, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Oo3lL6uVYF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2887, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NHGMx2IFWh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2888, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KGCrdiXo8O', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2889, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PXmyQTMNJO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2890, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5HVdSCJ9r5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2891, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-28 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lc4V7DD3ir', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2892, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-28 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.OxxiKsUKF4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2893, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.e3b4JVAXbe', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2894, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-28 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HWucSjkje9', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2895, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-28 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QuZWGBx9VB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2896, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-28 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MuPfYr3O9A', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2897, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-28 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.dirlXFXxdD', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2898, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-28 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.WQ0fzHtuH0', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2899, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-28 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DWWfI3NA2m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2900, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-28 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.aj312vcicw', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2901, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-28 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VSKtnQKtwH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2902, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-28 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.U7zrsZ9Cfl', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2903, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eyVS5qQ15B', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2904, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-28 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LJvng0XvSW', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2905, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-28 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QpbOEfrlhm', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2906, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-28 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BC3kNE2diQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2907, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-28 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CUeJDIVZtB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2908, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-28 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.rYMmvYvCZy', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2909, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-28 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.fG7z01VyLH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2910, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.pr0VSf9maC', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2911, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-28 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.zWC93qK4mV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2912, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-28 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eh3qU8lrBn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2913, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-28 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.El8KMGO1de', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2914, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-28 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.PVAyl2kvoH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2915, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-28 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8PHnO5fnrG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(2916, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-29 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KaD9NUMujs', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2917, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YV5vvfxAAi', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2918, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.CnbZbeAP9P', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2919, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.NvUl1yPF04', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2920, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.48sEnQbEh4', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2921, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Qihjuj3ISo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2922, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2VZMfmWmHI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2923, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.3N8wOquTdq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2924, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tr8did2q2o', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2925, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ZtEI3xDbQI', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03');
INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `session_type`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(2926, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6pEsJILtpT', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2927, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UE3Qtkr9L6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2928, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.QFcU5Z7YZ5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2929, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XNcn92T2ph', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2930, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R6P6E6paEO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2931, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.25DkQu44GN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2932, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Q1ZSGkaa26', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2933, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DwXOpI09r5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2934, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tTcjkbhB9R', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2935, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.i4bivGkVS2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2936, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.DPygCwe2hq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2937, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-29 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.w7dKLSNDKU', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2938, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-29 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.N1uEvvCH5j', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2939, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-29 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.SnX58R38nJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2940, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-29 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.YMYfZZ52nK', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2941, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.eHVmMfqQNN', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2942, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.lG8rXpgihH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2943, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0OhRm0gTP8', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2944, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.U3pOgoogUc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2945, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.o1PXYadaYO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2946, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.whw5q3JKXQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2947, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-29 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.d7OPzem9MG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2948, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-29 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7OVO5QKOXV', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2949, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.hbS5UTVanB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2950, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-29 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Lf2FKAVCxo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2951, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-29 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MMOJIhXgE6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2952, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-29 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.tsj2VYDbcH', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2953, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-29 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2nfHkZMo4n', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2954, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-29 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.kMQimiszbF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2955, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-29 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VYLwvDoUmB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2956, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-29 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KMtFnwJbgh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2957, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-29 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.16ty6farL3', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-29 01:30:03', '2025-10-29 01:30:03'),
(2958, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 05:00. Join us for an energizing Yoga workout!', '2025-10-30 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.BuOUREnpby', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2959, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 06:00. Join us for an energizing Yoga workout!', '2025-10-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4Aa2WdbrBJ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2960, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 07:00. Join us for an energizing Yoga workout!', '2025-10-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.VJU2X6wEDO', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2961, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 08:00. Join us for an energizing Yoga workout!', '2025-10-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Y7yTpVNufx', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2962, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 17:00. Join us for an energizing Yoga workout!', '2025-10-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.15nhWUUswu', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2963, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 18:00. Join us for an energizing Yoga workout!', '2025-10-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.UbWVBejiGB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2964, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 19:00. Join us for an energizing Yoga workout!', '2025-10-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.t0GiarC79r', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2965, 21, 18, 1, 'Daily Yoga Session', 'Daily Yoga session from 20:00. Join us for an energizing Yoga workout!', '2025-10-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.8evtM6CCbc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2966, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 06:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.99YkEEyND5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2967, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 07:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.5ocncy7T1J', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2968, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 08:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JjoHGMqaOj', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2969, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 09:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.6mzMQYvxjG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2970, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 10:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 10:00:00', '2025-10-30 10:10:35', '2025-10-30 10:11:26', 'ended', 'during', 'daily', 'fitlive.3VLDujmaax', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 10:11:26'),
(2971, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 16:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.jVe8STUA8s', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2972, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 17:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.XDv32mLi9C', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2973, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 18:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.oGXGP0z5dc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2974, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 19:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.ghLmo913hc', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2975, 21, 19, 1, 'Daily Strength &  conditioning Session', 'Daily Strength &  conditioning session from 20:00. Join us for an energizing Strength &  conditioning workout!', '2025-10-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.716EDW0R7m', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2976, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 06:00. Join us for an energizing HIIT workout!', '2025-10-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0ERTA6XxTn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2977, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 07:00. Join us for an energizing HIIT workout!', '2025-10-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.JuqGHaIqxt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2978, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 08:00. Join us for an energizing HIIT workout!', '2025-10-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.1QLNifhYd5', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2979, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 09:00. Join us for an energizing HIIT workout!', '2025-10-30 09:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.7dRYXUWXYn', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2980, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 10:00. Join us for an energizing HIIT workout!', '2025-10-30 10:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.R2skAV0V4h', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2981, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 16:00. Join us for an energizing HIIT workout!', '2025-10-30 16:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.4SzhCjAIqt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2982, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 17:00. Join us for an energizing HIIT workout!', '2025-10-30 17:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.HSL591Svyh', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2983, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 18:00. Join us for an energizing HIIT workout!', '2025-10-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xRISirC7CB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2984, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 19:00. Join us for an energizing HIIT workout!', '2025-10-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cSVXC35DiQ', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2985, 21, 20, 1, 'Daily HIIT Session', 'Daily HIIT session from 20:00. Join us for an energizing HIIT workout!', '2025-10-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.LjRz3Vm1Zt', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2986, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 06:00. Join us for an energizing Zumba workout!', '2025-10-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.mKcIaJZfpo', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2987, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 07:00. Join us for an energizing Zumba workout!', '2025-10-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.KKRcmUBM9A', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2988, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 08:00. Join us for an energizing Zumba workout!', '2025-10-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.2Y4ObGDHbF', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2989, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 18:00. Join us for an energizing Zumba workout!', '2025-10-30 18:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cGVsx3FiRq', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2990, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 19:00. Join us for an energizing Zumba workout!', '2025-10-30 19:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TK5GPJUfsG', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2991, 21, 7, 1, 'Daily Zumba Session', 'Daily Zumba session from 20:00. Join us for an energizing Zumba workout!', '2025-10-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.cRML99TLli', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2992, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 05:00. Join us for an energizing Meditation workout!', '2025-10-30 05:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.Ys23tCMaH6', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2993, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 06:00. Join us for an energizing Meditation workout!', '2025-10-30 06:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.acd4Ywi2hY', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2994, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 07:00. Join us for an energizing Meditation workout!', '2025-10-30 07:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.TfgbvITyfX', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2995, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 08:00. Join us for an energizing Meditation workout!', '2025-10-30 08:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.I5LJIsNsl2', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2996, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:00. Join us for an energizing Meditation workout!', '2025-10-30 20:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.xoYCH1zCck', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2997, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 20:30. Join us for an energizing Meditation workout!', '2025-10-30 20:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.M3MgRxTjEB', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2998, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:00. Join us for an energizing Meditation workout!', '2025-10-30 21:00:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.0ec0MKpBqp', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03'),
(2999, 21, 6, 1, 'Daily Meditation Session', 'Daily Meditation session from 21:30. Join us for an energizing Meditation workout!', '2025-10-30 21:30:00', NULL, NULL, 'scheduled', 'during', 'daily', 'fitlive.MECd7W24ID', NULL, NULL, '/storage/app/public/default-profile1.png', 0, 0, 0, 0, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:30:03', '2025-10-30 01:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `fittalk_sessions`
--

CREATE TABLE `fittalk_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `session_description` text DEFAULT NULL,
  `session_type` enum('chat','voice_call','video_call') NOT NULL DEFAULT 'chat',
  `status` enum('in_progress','scheduled','active','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `chat_rate_per_minute` decimal(8,2) NOT NULL DEFAULT 0.00,
  `call_rate_per_minute` decimal(8,2) NOT NULL DEFAULT 0.00,
  `free_minutes` int(11) NOT NULL DEFAULT 5,
  `duration_minutes` int(11) NOT NULL DEFAULT 0,
  `total_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `agora_channel` varchar(255) DEFAULT NULL,
  `recording_url` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_intent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fittalk_sessions`
--

INSERT INTO `fittalk_sessions` (`id`, `instructor_id`, `user_id`, `session_title`, `session_description`, `session_type`, `status`, `chat_rate_per_minute`, `call_rate_per_minute`, `free_minutes`, `duration_minutes`, `total_amount`, `scheduled_at`, `started_at`, `ended_at`, `agora_channel`, `recording_url`, `payment_status`, `payment_intent_id`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'new session', 'new session', 'voice_call', 'in_progress', 0.00, 1.00, 5, 0, 0.00, '2025-09-18 06:34:53', '2025-09-19 05:15:24', NULL, 'NA', NULL, 'pending', NULL, NULL, '2025-09-19 05:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `fit_casts`
--

CREATE TABLE `fit_casts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_casts`
--

INSERT INTO `fit_casts` (`id`, `title`, `description`, `thumbnail`, `video_url`, `duration`, `category_id`, `instructor_id`, `is_active`, `is_featured`, `views_count`, `likes_count`, `shares_count`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '10-Minute Morning Energy Boost', 'Quick morning routine to energize your day with dynamic movements and stretches.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 10, NULL, 22, 1, 1, 1785, 192, 4, '2025-08-16 20:07:06', '2025-08-26 20:07:06', '2025-09-30 13:57:42', NULL),
(2, 'Full Body HIIT Workout', 'Intense 20-minute high-intensity interval training session for maximum calorie burn.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 20, NULL, 4, 1, 0, 6801, 276, 1, '2025-08-18 20:07:06', '2025-08-26 20:07:06', '2025-09-29 23:22:32', NULL),
(3, 'Beginner Yoga Flow', 'Gentle 15-minute yoga sequence perfect for beginners to improve flexibility.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 15, NULL, 5, 1, 1, 3660, 175, 0, '2025-08-22 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(4, 'Core Strength Challenge', 'Targeted core workout to build abdominal strength and stability in just 12 minutes.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 12, NULL, 4, 1, 0, 2015, 443, 0, '2025-08-14 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(5, 'Upper Body Strength Training', 'Build upper body strength with this comprehensive 25-minute workout routine.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 25, NULL, 23, 1, 1, 5367, 414, 0, '2025-08-22 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(6, 'Cardio Dance Party', 'Fun and energetic dance workout that will get your heart pumping and spirits high.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 18, NULL, 6, 1, 0, 3991, 650, 0, '2025-08-01 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(7, 'Lower Body Power Workout', 'Strengthen your legs and glutes with this intense lower body training session.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 22, NULL, 2, 1, 1, 2417, 291, 0, '2025-08-11 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(8, 'Flexibility and Mobility', 'Improve your range of motion and reduce muscle tension with these mobility exercises.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 14, NULL, 2, 1, 0, 1347, 180, 0, '2025-08-04 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(9, 'Pilates Core Fusion', 'Combine Pilates principles with core strengthening for a balanced workout.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 16, NULL, 5, 1, 1, 2558, 349, 0, '2025-07-31 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(10, 'Functional Movement Training', 'Learn movement patterns that translate to better performance in daily activities.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 19, NULL, 2, 1, 0, 2370, 275, 0, '2025-08-25 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(11, 'Meditation and Mindfulness', 'Guided meditation session to reduce stress and improve mental clarity.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 12, NULL, 4, 1, 1, 2979, 633, 0, '2025-08-16 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(12, 'Recovery and Stretching', 'Essential recovery routine to help your muscles heal and prevent injury.', '/fitnews/thumbnails/Idptq1h5GosBxzCn97Z7C4vJfNhjlDIoGoG1uUDr.jpg', '/storage/app/public//fitnews/recording/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 13, NULL, 4, 1, 0, 1991, 196, 0, '2025-08-10 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fit_docs`
--

CREATE TABLE `fit_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('single','series') NOT NULL,
  `description` text NOT NULL,
  `language` varchar(50) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `release_date` date NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `total_episodes` int(11) DEFAULT NULL,
  `feedback` decimal(3,2) DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `trailer_type` enum('youtube','s3','upload') DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `trailer_file_path` varchar(255) DEFAULT NULL,
  `video_type` enum('youtube','s3','upload') DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_file_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_docs`
--

INSERT INTO `fit_docs` (`id`, `title`, `slug`, `type`, `description`, `language`, `cost`, `release_date`, `duration_minutes`, `total_episodes`, `feedback`, `banner_image_path`, `trailer_type`, `trailer_url`, `trailer_file_path`, `video_type`, `video_url`, `video_file_path`, `is_published`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test Single Video', 'test-single-video', 'single', 'This is a test single video', 'english', 0.00, '2025-06-25', 45, NULL, NULL, NULL, NULL, NULL, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-06-25 18:07:27', '2025-09-24 19:37:16', '2025-09-24 19:37:16'),
(2, 'Test Series', 'test-series', 'series', 'This is a test series', 'english', 9.99, '2025-06-25', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 18:07:37', '2025-09-24 19:38:27', '2025-09-24 19:38:27'),
(3, 'Test', 'test', 'single', 'Test', 'English', 0.00, '2024-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 18:18:49', '2025-09-24 19:37:19', '2025-09-24 19:37:19'),
(4, 'asda', 'asda', 'single', 'adas', 'english', 0.00, '2025-06-26', 12, NULL, NULL, '/storage/app/public/fitdoc/banners/rxfFVW6Fz4QzmZOEI7oXryRy1ibJPP5OnkxflvMQ.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-06-25 19:42:44', '2025-09-24 19:37:22', '2025-09-24 19:37:22'),
(5, 'qweqw', 'qweqw', 'series', 'qweqwe', 'english', 0.00, '2025-06-26', NULL, 12, NULL, '/storage/app/public/fitdoc/banners/SpEKmbiKGDzMCmcLGlnshj2AXP7siWc4sljUi0EY.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-06-25 19:43:20', '2025-09-24 19:38:24', '2025-09-24 19:38:24'),
(6, 'asdasda', 'asdasda', 'series', 'sasdasda', 'english', 0.00, '2025-06-26', NULL, 1, NULL, '/storage/app/public/fitdoc/banners/pvA2qC5hgpnxpeITRH0bLwd9INUO4laZjBBP2gzy.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-06-25 20:00:53', '2025-09-24 19:38:21', '2025-09-24 19:38:21'),
(7, 'demo1', 'demo1', 'single', 'asdad', 'english', 0.00, '2025-07-04', 12, NULL, NULL, '/storage/app/public/fitdoc/banners/yuQKx2gQRz2z5fUPJ8HlCnXgWKeSsuglSC0UkkJN.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-07-03 18:31:37', '2025-09-24 19:37:27', '2025-09-24 19:37:27'),
(8, 'demo2', 'demo2', 'single', 'asdasd', 'english', 0.00, '2025-07-04', 12, NULL, NULL, '/storage/app/public/fitdoc/banners/SZEMII0tHTJ1WZN1tz7OxjjVXRd2gNnmwlA97qXS.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-07-03 18:32:51', '2025-09-24 19:37:31', '2025-09-24 19:37:31'),
(9, 'demo series', 'demo-series', 'series', 'asdasd', 'english', 0.00, '2025-07-04', NULL, 0, NULL, '/storage/app/public/fitdoc/banners/YCPeZD5CxYwKBjlrSyj7Lr1azArCMWW37z3UDzFv.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-07-03 18:53:13', '2025-09-24 19:38:18', '2025-09-24 19:38:18'),
(10, 'asd', 'asd', 'series', 'asd', 'english', 0.00, '2025-08-17', NULL, 1, NULL, '/storage/app/public/fitdoc/banners/asgQpGyP01mSST63AV5nFpEMZM5Zj13l5qf6nSFp.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, 1, '2025-08-16 18:45:03', '2025-09-24 19:38:14', '2025-09-24 19:38:14'),
(11, 'asdas', 'asdas', 'single', 'dadsd', 'spanish', 0.00, '2025-09-05', 12, NULL, NULL, '/storage/app/public/fitdoc/banners/QcFnSO4ER0STjvAJFqLrcolkxO4YH6fXvpArcJvo.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-04 14:50:20', '2025-09-24 19:37:35', '2025-09-24 19:37:35'),
(12, '3554', '355', 'series', 'gdgfsgg', 'spanish', 0.04, '2025-09-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2025-09-17 13:10:58', '2025-09-24 19:38:10', '2025-09-24 19:38:10'),
(13, 'check vdo link', 'check-vdo-link', 'single', 'check vdo link', 'english', 0.03, '2025-09-18', 14, NULL, NULL, 'fitdoc/banners/7y5yhK0rFcZcvGboXTb8hMnI4ip6QSY2m8uEaoWt.jpg', 'upload', NULL, 'fitdoc/trailers/je1iXiJr3OpHqnAJrcUScSKkb0QXFPyT2vgNb76t.mp4', 'upload', NULL, 'fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', 1, 1, '2025-09-18 12:12:31', '2025-09-24 19:37:09', '2025-09-24 19:37:09'),
(14, 'Testing fitdoc single vdo', 'testing-fitdoc-single-vdo', 'single', 'It\'s a testing fitdoc single vdo', 'english', 0.19, '2025-09-25', 23, NULL, NULL, 'fitdoc/banners/wPneMzt1CnHQk8LHzePQNbGvRiNZewKpuh0e7cRj.png', NULL, NULL, NULL, 'upload', NULL, 'fitdoc/videos/baQVPlS3gEbTuW60X2iDcBmBLfxddESpT1lZuRbs.mp4', 1, 1, '2025-09-24 10:05:09', '2025-09-24 19:37:38', '2025-09-24 19:37:38'),
(15, 'Testing fitdoc series vdo', 'testing-fitdoc-series-vdo', 'series', 'It\'s a testing fitdoc series vdo', 'german', 0.42, '2025-09-25', NULL, 11, NULL, '/storage/app/public/fitdoc/banners/u64Tw0i3LgO8t6m4uMCxLlnAZPJKBeDgrM16mvKq.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, NULL, '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 10:08:47', '2025-09-24 19:38:06', '2025-09-24 19:38:06'),
(16, 'Fat Sick & nearly dead', 'fat-sick-nearly-dead', 'single', 'Fat Sick & nearly dead', 'english', 0.00, '2025-09-25', 20, NULL, NULL, '/storage/app/public/fitdoc/banners/cmJCJNGssFwZLWzLSq2oE41O5aUtXFJF9gYzeD9J.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 19:46:12', '2025-09-24 19:46:12', NULL),
(17, 'Generation Iron', 'generation-iron', 'single', 'Generation Iron', 'english', 0.00, '2025-09-25', 20, NULL, NULL, '/storage/app/public/fitdoc/banners/b52s5G6oAfxKHWg1PG7FKubXk02wc9RUeRmNcZ5N.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 19:43:36', '2025-09-24 19:43:36', NULL),
(18, 'Fittest on Earth: A Decade of Fitness', 'fittest-on-earth', 'single', 'test', 'english', 0.00, '2025-09-25', 20, NULL, NULL, '/storage/app/public/fitdoc/banners/9PwSrCeEKrs6koXpV2anaCJJ4hD4go1ZzlzDTGMa.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 19:44:21', '2025-09-24 19:44:21', NULL),
(19, 'The game changers', 'the-game-changers', 'single', 'demo test', 'english', 0.00, '2025-09-25', 20, NULL, NULL, '/storage/app/public/fitdoc/banners/W8I8uRF0v768O2irIV74nikFncrOXoP166AOhrVa.png', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 19:42:14', '2025-09-24 19:42:14', NULL),
(20, 'Pumping Iron', 'pumping-iron', 'single', 'demo', 'english', 0.00, '2025-09-24', 20, NULL, NULL, '/storage/app/public/fitdoc/banners/pc54R2LkYvEfOIdE9n21lprWyTFTuDYhtg2P2Az0.jpg', 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, 1, '2025-09-24 19:40:51', '2025-09-24 19:40:51', NULL),
(23, 'test items 1233', 'test-items-1233', 'series', 'test', 'english', 100.00, '2025-10-10', NULL, 0, NULL, 'fitdoc/banners/e7eUZCveatRfisaRjQGwVQ1bfBInFHyr6kVvEER4.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-10-10 21:36:58', '2025-10-10 22:14:12', '2025-10-10 22:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `fit_doc_episodes`
--

CREATE TABLE `fit_doc_episodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fit_doc_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `episode_number` int(11) NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `video_type` enum('youtube','s3','upload') NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_file_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_doc_episodes`
--

INSERT INTO `fit_doc_episodes` (`id`, `fit_doc_id`, `title`, `slug`, `description`, `episode_number`, `duration_minutes`, `video_type`, `video_url`, `video_file_path`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 'qweq', 'qweq', 'eqweq', 1, 12, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-06-25 20:03:52', '2025-06-25 20:03:52', NULL),
(2, 6, 'sadasd', 'sadasd', 'asdasd', 2, 12, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 1, '2025-06-25 20:13:29', '2025-06-25 20:13:29', NULL),
(3, 9, 'asdasd', 'asdasd', 'asdasd', 1, 12, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, '2025-07-03 18:53:43', '2025-07-03 18:53:43', NULL),
(4, 10, 'ep1', 'ep1', 'asdasd', 1, 12, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, '2025-08-16 18:45:34', '2025-08-16 18:45:34', NULL),
(5, 10, 'ep2', 'ep2', 'asdasd', 2, 21, 'youtube', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', NULL, 0, '2025-08-16 18:46:16', '2025-08-16 18:46:16', NULL),
(6, 23, 'bfndn', 'bfndn', 'dfndfn', 1, 10, 'youtube', 'http://abcr.come', NULL, 1, '2025-10-10 21:41:04', '2025-10-10 21:41:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fit_flix_shorts`
--

CREATE TABLE `fit_flix_shorts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sequence_order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `video_format` varchar(255) DEFAULT NULL,
  `video_width` int(11) DEFAULT NULL,
  `video_height` int(11) DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_flix_shorts`
--

INSERT INTO `fit_flix_shorts` (`id`, `sequence_order`, `title`, `slug`, `description`, `category_id`, `uploaded_by`, `video_path`, `thumbnail_path`, `duration`, `file_size`, `video_format`, `video_width`, `video_height`, `views_count`, `likes_count`, `shares_count`, `is_published`, `is_active`, `is_featured`, `published_at`, `meta_title`, `meta_description`, `meta_keywords`, `tags`, `created_at`, `updated_at`) VALUES
(14, 0, 'Calm your mind #yoga #yogapractice #stressrelief', 'calm-your-mind-yoga-yogapractice-stressrelief', NULL, 3, 10, 'community/fitflix-shorts/videos/8JFCXXuFtsfU3JnnQ2p3LYo6JzZdjbHKLWKrlvnk.mp4', NULL, 60, 1028277, 'mp4', 1080, 1920, 0, 0, 0, 1, 1, 1, '2025-10-15 15:46:26', NULL, NULL, NULL, NULL, '2025-10-15 15:46:26', '2025-10-15 15:46:26'),
(15, 0, 'demo', 'demo', NULL, 3, 10, 'community/fitflix-shorts/videos/7DySqfcKylWU58spEGq8XlfuACOxewIhclAbg2z1.mp4', NULL, 60, 428743, 'mp4', 1080, 1920, 0, 0, 0, 1, 1, 1, '2025-10-15 15:49:59', NULL, NULL, NULL, NULL, '2025-10-15 15:49:59', '2025-10-30 11:10:07'),
(16, 0, 'Best Homemade Ice Cream', 'best-homemade-ice-cream', NULL, 3, 10, 'community/fitflix-shorts/videos/zqRsw5DFBUnT6n7rHKNgBeNFFi9o0l6Ba4rp83Gk.mp4', NULL, 60, 8859952, 'mp4', 1080, 1920, 1, 1, 0, 1, 1, 1, '2025-10-15 15:52:14', NULL, NULL, NULL, NULL, '2025-10-15 15:52:14', '2025-10-30 11:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `fit_flix_shorts_categories`
--

CREATE TABLE `fit_flix_shorts_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#f7a31a',
  `banner_image_path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_flix_shorts_categories`
--

INSERT INTO `fit_flix_shorts_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `banner_image_path`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'demo 1', 'demo-1', 'asdasd', 'fas fa-mobile-alt', '#f7a31a', 'community/fitflix-shorts/categories/banners/3SsQAXtySpKII7XKQAxX1mVmAfCcEqRwfPRVNYvR.jpg', 0, 1, '2025-07-21 18:45:55', '2025-07-21 18:45:55'),
(2, 'weewr', 'weewr', 'wtwtwt', 'fas fa-mobile-alt', '#f7a31a', NULL, 2, 1, '2025-09-17 13:21:51', '2025-09-17 13:21:51'),
(3, 'Fiteness', 'fiteness', 'Fiteness', 'fas fa-mobile-alt', '#f7a31a', NULL, 1, 1, '2025-09-24 21:11:40', '2025-09-24 21:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `fit_insights`
--

CREATE TABLE `fit_insights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `reading_time` int(11) NOT NULL DEFAULT 0,
  `meta_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_insights`
--

INSERT INTO `fit_insights` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `category_id`, `author_id`, `is_published`, `published_at`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `reading_time`, `meta_data`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '10 Essential Tips for a Healthy Lifestyle', '10-essential-tips-for-a-healthy-lifestyle', 'Discover the fundamental principles of maintaining a healthy and balanced lifestyle.', 'Living a healthy lifestyle is more than just eating right and exercising. It encompasses a holistic approach to wellness that includes mental health, proper sleep, stress management, and building meaningful relationships. In this comprehensive guide, we will explore ten essential tips that can transform your daily routine and help you achieve optimal health and wellness.', NULL, NULL, 1, 1, '2025-08-01 09:38:49', 269, 20, 31, 19, 5, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(2, 'The Science Behind Effective Workouts', 'the-science-behind-effective-workouts', 'Understanding the physiological principles that make workouts truly effective.', 'Exercise science has evolved significantly over the past decades, providing us with valuable insights into how our bodies respond to different types of physical activity. This article delves into the scientific principles behind effective workouts, including the role of progressive overload, the importance of recovery, and how to optimize your training for maximum results.', NULL, NULL, 1, 1, '2025-08-13 09:38:49', 900, 18, 13, 2, 8, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(3, 'Nutrition Myths Debunked: What Really Works', 'nutrition-myths-debunked-what-really-works', 'Separating fact from fiction in the world of nutrition and diet advice.', 'The nutrition industry is filled with conflicting advice and misleading claims. From fad diets to miracle supplements, it can be challenging to distinguish between evidence-based recommendations and marketing hype. This article examines common nutrition myths and provides science-backed insights into what truly works for optimal health and performance.', NULL, NULL, 1, 1, '2025-07-28 09:38:49', 880, 56, 32, 9, 6, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(4, 'Mental Health and Physical Fitness: The Connection', 'mental-health-and-physical-fitness-the-connection', 'Exploring the powerful relationship between mental well-being and physical activity.', 'The connection between mental health and physical fitness is profound and well-documented. Regular exercise has been shown to reduce symptoms of depression and anxiety, improve cognitive function, and enhance overall quality of life. This article explores the mechanisms behind this connection and provides practical strategies for using physical activity to support mental wellness.', NULL, NULL, 1, 1, '2025-08-05 09:38:49', 238, 100, 26, 10, 7, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(5, 'Building Sustainable Fitness Habits', 'building-sustainable-fitness-habits', 'Learn how to create lasting fitness routines that stick for the long term.', 'Creating sustainable fitness habits is one of the biggest challenges people face when trying to improve their health. Many start with enthusiasm but struggle to maintain consistency over time. This guide provides evidence-based strategies for building fitness habits that last, including goal setting, habit stacking, and overcoming common obstacles.', NULL, NULL, 1, 1, '2025-07-29 09:38:49', 609, 60, 36, 16, 4, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(6, 'The Science Behind Progressive Overload', 'the-science-behind-progressive-overload', 'Understanding how progressive overload drives muscle growth and strength gains.', 'Progressive overload is the fundamental principle that drives all fitness adaptations. This comprehensive guide explores the science behind why gradually increasing training demands leads to improved performance, muscle growth, and strength gains. We\'ll cover practical applications, common mistakes, and how to implement progressive overload in your training routine.', NULL, NULL, 23, 1, '2025-08-19 20:07:06', 1002, 156, 0, 94, 8, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(7, '10 Common Nutrition Myths Debunked', '10-common-nutrition-myths-debunked', 'Separating fact from fiction in the world of fitness nutrition.', 'The fitness industry is filled with nutrition myths that can derail your progress. From the myth that eating fat makes you fat to the belief that you need to eat every 2 hours to boost metabolism, we\'ll examine the science behind these claims and provide evidence-based recommendations for optimal nutrition.', NULL, NULL, 6, 1, '2025-08-18 20:07:06', 776, 337, 0, 97, 12, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(8, 'Building Mental Resilience Through Fitness', 'building-mental-resilience-through-fitness', 'How physical training can strengthen your mental fortitude.', 'Physical fitness and mental resilience are deeply interconnected. This article explores how challenging workouts, goal setting, and overcoming physical barriers translate to improved mental toughness in all areas of life. Learn practical strategies to build both physical and mental strength simultaneously.', NULL, NULL, 4, 1, '2025-08-23 20:07:06', 2736, 155, 0, 20, 10, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(9, 'The Ultimate Guide to Recovery and Sleep', 'the-ultimate-guide-to-recovery-and-sleep', 'Maximizing your gains through proper recovery protocols.', 'Recovery is where the magic happens. While training provides the stimulus for adaptation, it\'s during recovery that your body actually gets stronger. This comprehensive guide covers sleep optimization, active recovery techniques, nutrition for recovery, and how to structure your training to maximize adaptation.', NULL, NULL, 6, 1, '2025-08-15 20:07:06', 3524, 299, 0, 82, 15, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(10, 'Functional Movement Patterns for Daily Life', 'functional-movement-patterns-for-daily-life', 'Training movements that translate to real-world activities.', 'Functional fitness focuses on training movement patterns that directly translate to daily activities and sports performance. Learn about the seven fundamental movement patterns, how to assess your movement quality, and exercises to improve functional strength and mobility.', NULL, NULL, 6, 1, '2025-08-24 20:07:06', 2637, 397, 0, 76, 9, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(11, 'Understanding Your Metabolism: Facts vs Fiction', 'understanding-your-metabolism-facts-vs-fiction', 'The truth about metabolic rate and weight management.', 'Metabolism is one of the most misunderstood aspects of fitness and weight management. This article breaks down the components of metabolic rate, factors that influence it, and evidence-based strategies for optimizing your metabolism for your goals.', NULL, NULL, 2, 1, '2025-08-16 20:07:06', 2731, 351, 0, 75, 11, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(12, 'The Psychology of Habit Formation in Fitness', 'the-psychology-of-habit-formation-in-fitness', 'How to build lasting fitness habits that stick.', 'Creating lasting change requires understanding the psychology of habit formation. This article explores the habit loop, how to design your environment for success, and practical strategies for building sustainable fitness habits that become second nature.', NULL, NULL, 22, 1, '2025-08-09 20:07:06', 1653, 397, 0, 23, 7, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(13, 'Injury Prevention: A Proactive Approach', 'injury-prevention-a-proactive-approach', 'Strategies to stay healthy and injury-free in your fitness journey.', 'Prevention is always better than cure when it comes to injuries. This comprehensive guide covers movement screening, proper warm-up protocols, load management, and recovery strategies to keep you training consistently and injury-free.', NULL, NULL, 4, 1, '2025-08-13 20:07:06', 4654, 497, 0, 90, 13, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(14, 'The Role of Hydration in Athletic Performance', 'the-role-of-hydration-in-athletic-performance', 'How proper hydration impacts your training and recovery.', 'Hydration plays a crucial role in athletic performance, yet it\'s often overlooked. Learn about fluid balance, electrolyte needs, hydration strategies for different training conditions, and how to optimize your hydration for peak performance.', NULL, NULL, 23, 1, '2025-08-13 20:07:06', 1952, 223, 0, 22, 6, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(15, 'Strength Training for Beginners: A Complete Guide', 'strength-training-for-beginners-a-complete-guide', 'Everything you need to know to start your strength training journey.', 'Starting a strength training program can be intimidating, but it doesn\'t have to be. This beginner-friendly guide covers basic principles, essential exercises, program design, safety considerations, and how to progress systematically.', NULL, NULL, 6, 1, '2025-08-18 20:07:06', 1611, 414, 0, 36, 14, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(16, 'The Mind-Muscle Connection: Science and Application', 'the-mind-muscle-connection-science-and-application', 'How focusing on muscle activation can improve your training.', 'The mind-muscle connection is more than just a bodybuilding concept. Research shows that focusing on the target muscle during exercise can improve activation and potentially enhance training outcomes. Learn how to develop and apply this skill.', NULL, NULL, 5, 1, '2025-08-03 20:07:06', 2676, 439, 0, 95, 8, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(17, 'Periodization: Planning Your Training for Success', 'periodization-planning-your-training-for-success', 'How to structure your training for optimal long-term progress.', 'Periodization is the systematic planning of athletic training. This article covers different periodization models, how to plan training phases, and how to adjust your program based on your goals and life circumstances.', NULL, NULL, 2, 1, '2025-08-09 20:07:06', 1268, 313, 0, 84, 12, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(18, 'Flexibility vs Mobility: Understanding the Difference', 'flexibility-vs-mobility-understanding-the-difference', 'Why both flexibility and mobility matter for optimal movement.', 'Flexibility and mobility are often used interchangeably, but they\'re different qualities that both contribute to optimal movement. Learn the distinctions, how to assess each, and targeted strategies for improvement.', NULL, NULL, 22, 1, '2025-08-21 20:07:06', 3419, 469, 0, 99, 9, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(19, 'The Science of Muscle Protein Synthesis', 'the-science-of-muscle-protein-synthesis', 'Understanding how your body builds muscle at the cellular level.', 'Muscle protein synthesis is the process by which your body builds new muscle tissue. This deep dive explores the mechanisms involved, factors that influence the process, and practical applications for optimizing muscle growth.', NULL, NULL, 4, 1, '2025-08-09 20:07:06', 3503, 431, 0, 46, 11, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(20, 'Creating a Sustainable Fitness Lifestyle', 'creating-a-sustainable-fitness-lifestyle', 'Building a fitness routine that fits your life long-term.', 'Sustainability is the key to long-term fitness success. This article provides practical strategies for creating a fitness routine that adapts to your changing life circumstances while maintaining consistency and progress toward your goals.', NULL, NULL, 4, 1, '2025-08-24 20:07:06', 1586, 186, 0, 15, 10, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fit_news`
--

CREATE TABLE `fit_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('draft','scheduled','live','ended') NOT NULL DEFAULT 'draft',
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `channel_name` varchar(255) DEFAULT NULL,
  `streaming_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`streaming_config`)),
  `viewer_count` int(11) NOT NULL DEFAULT 0,
  `recording_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `recording_url` varchar(255) DEFAULT NULL,
  `recording_id` varchar(255) DEFAULT NULL,
  `recording_status` varchar(255) DEFAULT NULL,
  `recording_duration` int(11) DEFAULT NULL,
  `recording_file_size` bigint(20) DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_news`
--

INSERT INTO `fit_news` (`id`, `title`, `description`, `thumbnail`, `status`, `is_published`, `published_at`, `scheduled_at`, `started_at`, `ended_at`, `channel_name`, `streaming_config`, `viewer_count`, `recording_enabled`, `recording_url`, `recording_id`, `recording_status`, `recording_duration`, `recording_file_size`, `views_count`, `likes_count`, `comments_count`, `shares_count`, `created_by`, `created_at`, `updated_at`) VALUES
(30, 'Fit News Oct 06, 2025 at 09:00 AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/fzfe1lQi6cANmAk32eotQjrX1hssrqfmpoWJQz0T.jpg', 'scheduled', 0, NULL, '2025-10-06 09:00:00', NULL, NULL, 'fitnews_20251006_090000_XXDFR2', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-06 10:36:39', '2025-10-06 10:36:39'),
(31, 'Fit News Oct 06, 2025 at 06:00 PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-06 18:00:00', NULL, NULL, 'fitnews_20251006_180000_hcEe7z', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-06 10:36:39', '2025-10-06 10:36:39'),
(32, 'Fit News Oct 07, 2025 at 09:00 AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-07 09:00:00', NULL, NULL, 'fitnews_20251007_090000_OPYOzV', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-07 16:15:03', '2025-10-07 16:15:03'),
(33, 'Fit News Oct 07, 2025 at 06:00 PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-07 18:00:00', NULL, NULL, 'fitnews_20251007_180000_tRniFE', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-07 16:15:03', '2025-10-07 16:15:03'),
(34, 'Fitness Industry Growth in 2025: What\'s Next?', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/fzfe1lQi6cANmAk32eotQjrX1hssrqfmpoWJQz0T.jpg', 'scheduled', 0, NULL, '2025-10-08 09:00:00', NULL, NULL, 'fitnews_20251008_090000_teFA8d', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-08 12:03:03', '2025-10-08 13:16:08'),
(35, 'Experts Weigh In on Post-Workouts', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-08 18:00:00', NULL, NULL, 'fitnews_20251008_180000_qiKE9k', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-08 12:03:03', '2025-10-08 13:26:13'),
(38, 'Fit News Oct 09, 2025 at 09:00 AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/fzfe1lQi6cANmAk32eotQjrX1hssrqfmpoWJQz0T.jpg', 'scheduled', 0, NULL, '2025-10-09 09:00:00', NULL, NULL, 'fitnews_20251009_090000_ccggpS', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-09 14:08:03', '2025-10-09 14:08:03'),
(39, 'Fit News Oct 09, 2025 at 06:00 PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-09 18:00:00', NULL, NULL, 'fitnews_20251009_180000_Je6S7z', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-09 14:08:03', '2025-10-09 14:08:03'),
(40, 'Fitness Industry Growth in 2025: What\'s Next?', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-10 09:00:00', NULL, NULL, 'fitnews_20251010_090000_tyHFvL', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-10 01:30:04', '2025-10-10 01:30:04'),
(41, 'Experts Weigh In on Post-Workouts', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-10 18:00:00', NULL, NULL, 'fitnews_20251010_180000_nb8RJG', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-10 01:30:04', '2025-10-10 01:30:04'),
(42, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-11 09:00:00', NULL, NULL, 'fitnews_20251011_090000_ViMLZm', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-11 01:30:03', '2025-10-11 01:30:03'),
(43, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-11 18:00:00', NULL, NULL, 'fitnews_20251011_180000_TQUR0V', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-11 01:30:03', '2025-10-11 01:30:03'),
(44, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-12 09:00:00', NULL, NULL, 'fitnews_20251012_090000_J9PVCF', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(45, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-12 18:00:00', NULL, NULL, 'fitnews_20251012_180000_F70qpn', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-12 01:30:03', '2025-10-12 01:30:03'),
(46, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-13 09:00:00', NULL, NULL, 'fitnews_20251013_090000_0t1yOr', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(47, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-13 18:00:00', NULL, NULL, 'fitnews_20251013_180000_gUXQx9', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-13 01:30:03', '2025-10-13 01:30:03'),
(48, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-14 09:00:00', NULL, NULL, 'fitnews_20251014_090000_eRnjMc', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(49, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-14 18:00:00', NULL, NULL, 'fitnews_20251014_180000_A3m5S7', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-14 01:30:03', '2025-10-14 01:30:03'),
(50, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-15 09:00:00', NULL, NULL, 'fitnews_20251015_090000_ViXjGN', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(51, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-15 18:00:00', NULL, NULL, 'fitnews_20251015_180000_6jLNXH', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-15 01:30:04', '2025-10-15 01:30:04'),
(52, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-16 09:00:00', NULL, NULL, 'fitnews_20251016_090000_svgJq5', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-16 01:30:04', '2025-10-16 01:30:04'),
(53, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-16 18:00:00', NULL, NULL, 'fitnews_20251016_180000_5v5JSs', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-16 01:30:04', '2025-10-16 01:30:04'),
(54, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-17 09:00:00', NULL, NULL, 'fitnews_20251017_090000_8XWbj4', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-17 01:30:04', '2025-10-17 01:30:04'),
(55, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-17 18:00:00', NULL, NULL, 'fitnews_20251017_180000_ebbnyy', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-17 01:30:04', '2025-10-17 01:30:04'),
(56, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-18 09:00:00', NULL, NULL, 'fitnews_20251018_090000_EkfFbw', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(57, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-18 18:00:00', NULL, NULL, 'fitnews_20251018_180000_uRsvOS', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-18 01:30:03', '2025-10-18 01:30:03'),
(58, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-19 09:00:00', NULL, NULL, 'fitnews_20251019_090000_8ypJnD', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(59, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-19 18:00:00', NULL, NULL, 'fitnews_20251019_180000_t2Kx6W', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-19 01:30:04', '2025-10-19 01:30:04'),
(60, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-20 09:00:00', NULL, NULL, 'fitnews_20251020_090000_f3O1ln', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-20 01:30:04', '2025-10-20 01:30:04'),
(61, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-20 18:00:00', NULL, NULL, 'fitnews_20251020_180000_JIhrOy', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-20 01:30:04', '2025-10-20 01:30:04'),
(62, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-21 09:00:00', NULL, NULL, 'fitnews_20251021_090000_7ufInx', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-21 01:30:03', '2025-10-21 01:30:03'),
(63, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-21 18:00:00', NULL, NULL, 'fitnews_20251021_180000_k1EF4A', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-21 01:30:03', '2025-10-21 01:30:03'),
(64, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-22 09:00:00', NULL, NULL, 'fitnews_20251022_090000_uHo4IV', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(65, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-22 18:00:00', NULL, NULL, 'fitnews_20251022_180000_k4cxIu', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-22 01:30:03', '2025-10-22 01:30:03'),
(66, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-23 09:00:00', NULL, NULL, 'fitnews_20251023_090000_6EHcPv', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(67, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-23 18:00:00', NULL, NULL, 'fitnews_20251023_180000_eoFOQK', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-23 01:30:03', '2025-10-23 01:30:03'),
(68, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-24 09:00:00', NULL, NULL, 'fitnews_20251024_090000_8HrG1i', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-24 01:30:04', '2025-10-24 01:30:04'),
(69, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-24 18:00:00', NULL, NULL, 'fitnews_20251024_180000_NwQvVP', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-24 01:30:04', '2025-10-24 01:30:04'),
(70, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-25 09:00:00', NULL, NULL, 'fitnews_20251025_090000_vwpfxQ', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(71, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-25 18:00:00', NULL, NULL, 'fitnews_20251025_180000_Axjkyp', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-25 01:30:03', '2025-10-25 01:30:03'),
(72, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-26 09:00:00', NULL, NULL, 'fitnews_20251026_090000_BXDLzg', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-26 01:30:03', '2025-10-26 01:30:03'),
(73, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-26 18:00:00', NULL, NULL, 'fitnews_20251026_180000_LgA8dh', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-26 01:30:03', '2025-10-26 01:30:03'),
(74, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-27 09:00:00', NULL, NULL, 'fitnews_20251027_090000_Awlpng', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-27 01:30:04', '2025-10-27 01:30:04'),
(75, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-27 18:00:00', NULL, NULL, 'fitnews_20251027_180000_zyPRzs', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-27 01:30:04', '2025-10-27 01:30:04'),
(76, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-28 09:00:00', NULL, NULL, 'fitnews_20251028_090000_MrEyJn', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(77, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-28 18:00:00', NULL, NULL, 'fitnews_20251028_180000_4ytlWe', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-28 01:30:03', '2025-10-28 01:30:03'),
(78, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'scheduled', 0, NULL, '2025-10-29 09:00:00', NULL, NULL, 'fitnews_20251029_090000_GRAk7N', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-29 01:30:04', '2025-10-29 01:30:04'),
(79, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-29 18:00:00', NULL, NULL, 'fitnews_20251029_180000_Mu4J5l', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-29 01:30:04', '2025-10-29 01:30:04'),
(80, 'Live at 9AM', 'Your daily Fit News bulletin scheduled at 09:00 AM.', 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg', 'ended', 0, NULL, '2025-10-30 09:00:00', '2025-10-30 10:32:19', '2025-10-30 10:32:45', 'fitlive_80', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_80\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IAB5Hvbzbce6+PRZs0shYmL6DUrO2gdTc6dUsY7kogOKclM7iKjhJV2hIgBLMwEA1kIEaQQAAQDWQgRpAwDWQgRpAgDWQgRpBADWQgRp\",\"uid\":10,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1761886934,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-30 01:30:03', '2025-10-30 10:32:45'),
(81, 'Live at 6PM', 'Your daily Fit News bulletin scheduled at 06:00 PM.', 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg', 'scheduled', 0, NULL, '2025-10-30 18:00:00', NULL, NULL, 'fitnews_20251030_180000_uFJjdG', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-10-30 01:30:03', '2025-10-30 01:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `fi_blogs`
--

CREATE TABLE `fi_blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fi_category_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image_path` varchar(255) DEFAULT NULL,
  `featured_image_alt` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `social_image_path` text DEFAULT NULL,
  `social_title` text DEFAULT NULL,
  `social_description` text DEFAULT NULL,
  `status` enum('draft','published','scheduled','archived') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `reading_time` decimal(5,2) DEFAULT NULL,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fi_blogs`
--

INSERT INTO `fi_blogs` (`id`, `fi_category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `featured_image_path`, `featured_image_alt`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `social_image_path`, `social_title`, `social_description`, `status`, `published_at`, `scheduled_at`, `views_count`, `likes_count`, `shares_count`, `reading_time`, `allow_comments`, `is_featured`, `is_trending`, `sort_order`, `tags`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 10, 'Lorem Ipsum', 'l', 'dfdffd', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', 'fitinsight/blogs/featured/6guAcJCqOZdRD2Ebf3s5FejLOys6Ifc7mLYotmzE.png', NULL, 'redf', 'dfdffd', NULL, NULL, NULL, 'redf', 'dfdffd', 'draft', '2025-09-18 03:12:50', NULL, 2, 0, 12, 1.00, 1, 1, 1, 0, NULL, '2025-09-06 09:26:39', '2025-10-03 18:16:40', NULL),
(2, 2, 10, '10 habits of HEALTHY WOMEN', '10-habits-of-healthy-women', 'Test Blog Api Checking', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</span></p>', 'fitinsight/blogs/featured/8rWZnU453WG7kEHZwiZKOr6WCUHLx85PNOXAX0me.jpg', 'new fitsights', 'Test Blog Api', 'Test Blog Api Checking', NULL, NULL, NULL, 'Test Blog Api', 'Test Blog Api Checking', 'published', '2025-09-18 03:26:18', NULL, 30, 3, 16, 1.00, 1, 1, 1, 0, '[\"new_fitsights\"]', '2025-09-18 03:18:27', '2025-10-30 12:02:25', NULL),
(3, 2, 10, '12 Tips for better fitness And health', '12-tips-for-better-fitness-and-health', 'Yesy Once', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</span></p>', 'fitinsight/blogs/featured/JbxpzE3LSBpdXKouTSkx5bNBV2Z04Ds4jwmIKmVj.jpg', 'Yesy Once', 'Yesy Once', 'Yesy Once', NULL, NULL, NULL, 'Yesy Once', 'Yesy Once', 'published', '2025-09-18 03:26:18', NULL, 13, 2, 15, 1.00, 1, 1, 1, 0, '[\"Yesy Once\"]', '2025-09-18 03:26:18', '2025-10-10 12:58:27', NULL),
(4, 2, 10, 'Fit Strong & Healthy', 'fit-strong-healthy', 'It\'s a testing fitsight content', '<p class=\"ql-align-justify\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><br></p>', 'fitinsight/blogs/featured/vAKNkhkVRT5F3p1nZnUBcMDyoqUg180ChbZEwzrE.jpg', 'It\'s a testing fitsight content', 'Testing fitsight content', 'It\'s a testing fitsight content', NULL, NULL, NULL, 'Testing fitsight content', 'It\'s a testing fitsight content', 'published', '2025-09-24 10:13:06', NULL, 32, 2, 12, 1.00, 1, 1, 1, 0, '[\"#workout\",\"#exercise\"]', '2025-09-24 10:13:06', '2025-10-16 10:38:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fi_categories`
--

CREATE TABLE `fi_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#f7a31a',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fi_categories`
--

INSERT INTO `fi_categories` (`id`, `name`, `slug`, `description`, `banner_image_path`, `icon`, `color`, `sort_order`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'asd1', 'aasd4', 'ads', 'fitinsight/categories/banners/LLsvNKQtpgvX26SQXi14BWvK7rBuhGTHvkRcEkg2.png', 'fas fa-folder', '#f7a31a', 0, 0, 'asd', 'asd', 'asd', '2025-06-26 07:54:51', '2025-09-09 07:09:57', NULL),
(2, 'trtr5', 'r', 'trtr', NULL, 'fas fa-folder', '#f7a31a', 0, 1, 'ytrt', 'rtrtr', NULL, '2025-09-17 13:12:03', '2025-09-17 13:12:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','declined','blocked') NOT NULL DEFAULT 'pending',
  `accepted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`id`, `user_id`, `friend_id`, `status`, `accepted_at`, `created_at`, `updated_at`) VALUES
(1, 8, 2, 'pending', NULL, '2025-08-11 14:42:58', '2025-08-11 14:42:58'),
(2, 14, 2, 'pending', NULL, '2025-08-17 10:45:36', '2025-08-17 10:45:36'),
(3, 3, 8, 'pending', NULL, '2025-09-27 08:58:23', '2025-09-27 08:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `max_members` int(11) DEFAULT NULL,
  `member_count` int(11) NOT NULL DEFAULT 0,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `community_group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('member','moderator','admin') NOT NULL DEFAULT 'member',
  `status` enum('pending','approved','declined','banned') NOT NULL DEFAULT 'approved',
  `joined_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `community_group_id`, `user_id`, `role`, `status`, `joined_at`, `created_at`, `updated_at`) VALUES
(5, NULL, 1, 3, 'member', 'approved', '2025-09-17 05:22:33', '2025-09-17 05:22:33', '2025-09-17 05:22:33'),
(6, 4, 4, 3, 'member', 'approved', '2025-09-26 14:01:48', '2025-09-26 14:01:48', '2025-09-26 14:01:48'),
(8, 8, 8, 7, 'admin', 'approved', NULL, '2025-09-27 09:42:29', '2025-09-27 09:42:29'),
(9, NULL, 5, 3, 'member', 'approved', '2025-09-29 15:57:33', '2025-09-29 15:57:33', '2025-09-29 15:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `group_messages`
--

CREATE TABLE `group_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `message_type` enum('text','image','video','audio','file') NOT NULL DEFAULT 'text',
  `media_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `reply_to_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_message_reads`
--

CREATE TABLE `group_message_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homepage_heroes`
--

CREATE TABLE `homepage_heroes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `youtube_video_id` varchar(255) DEFAULT NULL,
  `play_button_text` varchar(255) NOT NULL DEFAULT 'PLAY NOW',
  `play_button_link` varchar(255) DEFAULT NULL,
  `trailer_button_text` varchar(255) NOT NULL DEFAULT 'WATCH TRAILER',
  `trailer_button_link` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `homepage_heroes`
--

INSERT INTO `homepage_heroes` (`id`, `title`, `description`, `youtube_video_id`, `play_button_text`, `play_button_link`, `trailer_button_text`, `trailer_button_link`, `category`, `duration`, `year`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 'ABS Workout - testing - Core Strengthening', 'An abs workout is designed to strengthen and tone the muscles in the abdominal region, including the upper, lower, and side muscles that form the core.', '7Nwn2nLBqEU', 'PLAY NOW', 'https://fittelly.com/fitlive/18', 'WATCH TRAILER', 'https://fittelly.com/fitlive/18', 'Yoga', '20 min', 2018, 1, 1, '2025-06-26 07:47:47', '2025-10-30 11:52:59');

-- --------------------------------------------------------

--
-- Table structure for table `influencer_links`
--

CREATE TABLE `influencer_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `influencer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `link_code` varchar(50) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `target_url` varchar(255) NOT NULL DEFAULT '/subscription',
  `clicks_count` int(11) NOT NULL DEFAULT 0,
  `conversions_count` int(11) NOT NULL DEFAULT 0,
  `conversion_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `tracking_params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tracking_params`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `influencer_link_visits`
--

CREATE TABLE `influencer_link_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `influencer_link_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `referrer_url` varchar(500) DEFAULT NULL,
  `utm_parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`utm_parameters`)),
  `country` varchar(2) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `is_converted` tinyint(1) NOT NULL DEFAULT 0,
  `converted_at` timestamp NULL DEFAULT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `conversion_value` decimal(10,2) DEFAULT NULL,
  `page_views` int(11) NOT NULL DEFAULT 1,
  `time_on_site` int(11) DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `influencer_profiles`
--

CREATE TABLE `influencer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `application_status` varchar(255) NOT NULL DEFAULT 'draft',
  `bio` text DEFAULT NULL,
  `social_instagram` varchar(255) DEFAULT NULL,
  `social_youtube` varchar(255) DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_tiktok` varchar(255) DEFAULT NULL,
  `followers_count` int(11) NOT NULL DEFAULT 0,
  `niche` varchar(255) DEFAULT NULL,
  `previous_work` text DEFAULT NULL,
  `total_commission_earned` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_commission_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `pending_commission` decimal(12,2) NOT NULL DEFAULT 0.00,
  `commission_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`commission_settings`)),
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `influencer_profiles`
--

INSERT INTO `influencer_profiles` (`id`, `user_id`, `status`, `application_status`, `bio`, `social_instagram`, `social_youtube`, `social_facebook`, `social_twitter`, `social_tiktok`, `followers_count`, `niche`, `previous_work`, `total_commission_earned`, `total_commission_paid`, `pending_commission`, `commission_settings`, `approved_at`, `approved_by`, `rejection_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 7, 'approved', 'draft', 'asdasd', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.00, 0.00, 0.00, NULL, '2025-07-01 19:36:35', 1, NULL, '2025-07-01 19:36:35', '2025-07-01 19:36:35', NULL),
(2, 2, 'approved', 'draft', 'asdasd', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.00, 0.00, 0.00, NULL, '2025-07-02 19:27:57', 1, NULL, '2025-07-02 19:27:57', '2025-07-02 19:27:57', NULL),
(3, 20, 'approved', 'approved', 'Fitness enthusiast with 5+ years of experience in strength training and CrossFit. Helping people achieve their fitness goals through proper form and motivation.', '/storage/app/public/fitdoc/videos/h2MNaRO2XDehDBcFzpG8Yn7mkA3Nt1zlS3kElgnC.mp4', 'https://youtube.com/c/AlexJohnsonFitness', 'https://facebook.com/alexjohnsonfit', NULL, NULL, 25000, 'strength_training,crossfit,muscle_building', 'Personal trainer at Gold\'s Gym, Fitness influencer on Instagram', 5000.00, 3000.00, 2000.00, '{\"rate\":10,\"payment_method\":\"bank_transfer\",\"minimum_payout\":1000}', '2025-07-27 17:53:53', 10, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:53', NULL),
(4, 21, 'approved', 'approved', 'Certified yoga instructor and wellness coach. Specializing in mindful movement, flexibility, and holistic health approaches.', 'https://instagram.com/sarahwilson_yoga', 'https://youtube.com/c/SarahWilsonYoga', NULL, NULL, 'https://tiktok.com/@sarahwilsonyoga', 18000, 'yoga,pilates,flexibility,wellness', 'Certified yoga instructor (RYT-500), Wellness coach, Studio owner', 3500.00, 2500.00, 1000.00, '{\"rate\":12,\"payment_method\":\"upi\",\"minimum_payout\":500}', '2025-07-12 17:53:53', 10, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `influencer_sales`
--

CREATE TABLE `influencer_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `influencer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `influencer_link_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_subscription_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `commission_status` varchar(255) NOT NULL DEFAULT 'pending',
  `sale_date` timestamp NULL DEFAULT NULL,
  `sale_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sale_metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"8963dc18-a314-492a-9c00-6e850adbdd78\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1750876503,\"delay\":null}', 0, NULL, 1750876503, 1750876503),
(2, 'default', '{\"uuid\":\"d66c91f3-f7a1-4d91-9f05-23160f1a2876\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1750931054,\"delay\":null}', 0, NULL, 1750931054, 1750931054),
(3, 'default', '{\"uuid\":\"d26dd370-3e0b-4059-9402-5f00116468cf\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1750931054,\"delay\":null}', 0, NULL, 1750931054, 1750931054),
(4, 'default', '{\"uuid\":\"5d00c937-6f9d-4f48-8021-a39d2f1a9953\",\"displayName\":\"App\\\\Events\\\\LiveSessionUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\LiveSessionUpdated\\\":3:{s:9:\\\"sessionId\\\";i:1;s:6:\\\"status\\\";s:7:\\\"started\\\";s:4:\\\"data\\\";a:3:{s:10:\\\"session_id\\\";i:1;s:6:\\\"status\\\";s:7:\\\"started\\\";s:7:\\\"message\\\";s:30:\\\"Local test live session update\\\";}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1753212972,\"delay\":null}', 0, NULL, 1753212973, 1753212973),
(5, 'default', '{\"uuid\":\"fdc5b277-3820-4132-a566-12a055e2117d\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":4:{s:7:\\\"message\\\";s:23:\\\"Local test chat message\\\";s:6:\\\"userId\\\";i:1;s:8:\\\"userName\\\";s:15:\\\"Local Test User\\\";s:9:\\\"sessionId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1753212973,\"delay\":null}', 0, NULL, 1753212973, 1753212973),
(6, 'default', '{\"uuid\":\"94b97fa0-3845-46be-a856-9c4d57003a4a\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1756997563,\"delay\":null}', 0, NULL, 1756997563, 1756997563),
(7, 'default', '{\"uuid\":\"4f77cca4-6ded-48e6-bdb2-63e3ce6780b2\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1756997621,\"delay\":null}', 0, NULL, 1756997621, 1756997621),
(8, 'default', '{\"uuid\":\"57d7549c-192f-40c1-b4fe-ef56b4473d5a\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757927466,\"delay\":null}', 0, NULL, 1757927466, 1757927466),
(9, 'default', '{\"uuid\":\"25fe81a2-a74b-4195-be3f-95730d6fc6c5\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757927495,\"delay\":null}', 0, NULL, 1757927495, 1757927495),
(10, 'default', '{\"uuid\":\"2dd9902a-90a9-4421-b2f7-dfccb9a651c8\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757927609,\"delay\":null}', 0, NULL, 1757927609, 1757927609),
(11, 'default', '{\"uuid\":\"26556199-201e-4775-94a9-9a951828dddf\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757927647,\"delay\":null}', 0, NULL, 1757927647, 1757927647),
(12, 'default', '{\"uuid\":\"90ca45bb-19f1-46b2-878b-190f95c4d66d\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757927665,\"delay\":null}', 0, NULL, 1757927665, 1757927665),
(13, 'default', '{\"uuid\":\"44ccf62f-cea8-4972-93b9-85eb7690d9d2\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931233,\"delay\":null}', 0, NULL, 1757931233, 1757931233),
(14, 'default', '{\"uuid\":\"3c3d4188-58e6-4dc4-9f32-a7354ea2c4ab\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931318,\"delay\":null}', 0, NULL, 1757931318, 1757931318),
(15, 'default', '{\"uuid\":\"e67e1ed6-5219-4b78-90e6-06c97f5af33c\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931542,\"delay\":null}', 0, NULL, 1757931542, 1757931542),
(16, 'default', '{\"uuid\":\"638f97c3-5466-49d9-9152-e45968d60739\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931558,\"delay\":null}', 0, NULL, 1757931558, 1757931558),
(17, 'default', '{\"uuid\":\"1a75e82d-e3f4-4aee-845d-692da03cca76\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931568,\"delay\":null}', 0, NULL, 1757931568, 1757931568),
(18, 'default', '{\"uuid\":\"34fb951f-dd8d-4f4a-b8f3-a63b593a8bfa\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931572,\"delay\":null}', 0, NULL, 1757931572, 1757931572),
(19, 'default', '{\"uuid\":\"30ae15ac-a9e8-4f12-a36b-bbb2d4c389e3\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931578,\"delay\":null}', 0, NULL, 1757931578, 1757931578),
(20, 'default', '{\"uuid\":\"bb8bbffa-8638-4344-a532-d2595b68d2f9\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757931584,\"delay\":null}', 0, NULL, 1757931584, 1757931584),
(21, 'default', '{\"uuid\":\"5f329293-f072-4f5a-8b8b-982154923de4\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757932214,\"delay\":null}', 0, NULL, 1757932214, 1757932214),
(22, 'default', '{\"uuid\":\"5c6967a6-28e8-4c80-9d5b-0c6f1e9a9562\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1757932252,\"delay\":null}', 0, NULL, 1757932252, 1757932252),
(23, 'default', '{\"uuid\":\"3f1907ab-e54e-4e09-966f-a11bda264fb8\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758000156,\"delay\":null}', 0, NULL, 1758000156, 1758000156),
(24, 'default', '{\"uuid\":\"53e53114-ffd2-41b3-9f4b-2eb6ee04df81\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758089751,\"delay\":null}', 0, NULL, 1758089751, 1758089751),
(25, 'default', '{\"uuid\":\"8b076ca9-12a0-4f31-91c6-bf5e348f7a02\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758112209,\"delay\":null}', 0, NULL, 1758112209, 1758112209),
(26, 'default', '{\"uuid\":\"f0e57747-e04f-4068-be05-5cdd77bccdf4\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758112219,\"delay\":null}', 0, NULL, 1758112219, 1758112219),
(27, 'default', '{\"uuid\":\"939eb6a9-8d6c-4bfa-b785-483df91989ea\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758695331,\"delay\":null}', 0, NULL, 1758695331, 1758695331),
(28, 'default', '{\"uuid\":\"b7297e0d-62d5-4916-8686-87600a58e338\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758696858,\"delay\":null}', 0, NULL, 1758696858, 1758696858),
(29, 'default', '{\"uuid\":\"088fe01a-bc62-40ae-bcf0-0c17eb07ea95\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758706270,\"delay\":null}', 0, NULL, 1758706270, 1758706270),
(30, 'default', '{\"uuid\":\"6e7a96c0-d2f7-4b4f-9e9b-704858f53eb3\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758706290,\"delay\":null}', 0, NULL, 1758706290, 1758706290),
(31, 'default', '{\"uuid\":\"8a18f3ca-76ff-4bd2-a5df-35911fa61187\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758803156,\"delay\":null}', 0, NULL, 1758803156, 1758803156),
(32, 'default', '{\"uuid\":\"8156e3f2-725e-49ef-9aad-68df839d4322\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758803302,\"delay\":null}', 0, NULL, 1758803302, 1758803302),
(33, 'default', '{\"uuid\":\"d90c659e-5216-438b-a75c-af86270a65bc\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758803372,\"delay\":null}', 0, NULL, 1758803372, 1758803372),
(34, 'default', '{\"uuid\":\"8fc31d37-1494-4d5f-bf8c-b8b2caa4b593\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1758803492,\"delay\":null}', 0, NULL, 1758803492, 1758803492),
(35, 'default', '{\"uuid\":\"64882fbb-eb8f-49b7-af8d-9e194ab49642\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:118;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759149227,\"delay\":null}', 0, NULL, 1759149227, 1759149227),
(36, 'default', '{\"uuid\":\"7ec30b9b-4ec8-4173-a555-ad1f435b59b6\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:118;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759149252,\"delay\":null}', 0, NULL, 1759149252, 1759149252),
(37, 'default', '{\"uuid\":\"4c0cfbe7-b1c4-42b7-adc0-5d787264aba6\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:199;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759214781,\"delay\":null}', 0, NULL, 1759214781, 1759214781),
(38, 'default', '{\"uuid\":\"8ccde21c-8794-479d-a276-a9828c9900bb\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:199;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759214869,\"delay\":null}', 0, NULL, 1759214869, 1759214869),
(39, 'default', '{\"uuid\":\"44a5bcf0-8f61-4066-9a42-cca3f6a2c753\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:200;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759214899,\"delay\":null}', 0, NULL, 1759214899, 1759214899),
(40, 'default', '{\"uuid\":\"04596217-04b4-4310-a7dc-c7fec1a33d6b\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:200;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759215157,\"delay\":null}', 0, NULL, 1759215157, 1759215157);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(41, 'default', '{\"uuid\":\"c33ced60-ab62-4604-b5ba-cd4cd4b9fd73\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:202;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759215752,\"delay\":null}', 0, NULL, 1759215752, 1759215752),
(42, 'default', '{\"uuid\":\"86fd1cb4-1df4-47ca-9722-86a25b263520\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:202;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759215761,\"delay\":null}', 0, NULL, 1759215761, 1759215761),
(43, 'default', '{\"uuid\":\"96dc1f65-3e97-40c8-b1e6-944fd8af778f\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:203;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759215994,\"delay\":null}', 0, NULL, 1759215994, 1759215994),
(44, 'default', '{\"uuid\":\"e3aaabfb-2007-4968-abbf-33ba73004d5d\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:203;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759220257,\"delay\":null}', 0, NULL, 1759220257, 1759220257),
(45, 'default', '{\"uuid\":\"aa372758-4bbd-4611-a989-6da4c9585318\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:170;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759222491,\"delay\":null}', 0, NULL, 1759222491, 1759222491),
(46, 'default', '{\"uuid\":\"e7602d03-f80c-4e8e-9d66-b1bc8927bb70\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:170;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759228677,\"delay\":null}', 0, NULL, 1759228677, 1759228677),
(47, 'default', '{\"uuid\":\"a950fd21-4400-4a1b-ad50-6dd138033845\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759493124,\"delay\":null}', 0, NULL, 1759493124, 1759493124),
(48, 'default', '{\"uuid\":\"7bc6012e-32f8-4a1d-82ef-d6899b8fea82\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759493189,\"delay\":null}', 0, NULL, 1759493189, 1759493189),
(49, 'default', '{\"uuid\":\"7870a4c0-360d-4725-81a6-9c2ab0a5c733\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2113;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760016199,\"delay\":null}', 0, NULL, 1760016199, 1760016199),
(50, 'default', '{\"uuid\":\"79b4b1c4-2c93-4f6e-ad98-1d8e52ceb3c2\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2113;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760016295,\"delay\":null}', 0, NULL, 1760016295, 1760016295),
(51, 'default', '{\"uuid\":\"f5d8efb1-2cfa-4a06-b31a-6599e1f96011\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2113;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760016513,\"delay\":null}', 0, NULL, 1760016513, 1760016513),
(52, 'default', '{\"uuid\":\"fcc9ad7c-5ffc-4c09-b616-748f66b6e93f\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2113;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760016723,\"delay\":null}', 0, NULL, 1760016723, 1760016723),
(53, 'default', '{\"uuid\":\"c81b3d6f-6c4a-4e17-bc8a-fe4a212ecfca\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760443187,\"delay\":null}', 0, NULL, 1760443187, 1760443187),
(54, 'default', '{\"uuid\":\"25b38b42-e5d5-4d88-b27d-81f87b7a56d7\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760446638,\"delay\":null}', 0, NULL, 1760446638, 1760446638),
(55, 'default', '{\"uuid\":\"34402f81-26a6-4af2-bc3c-e23936592495\",\"displayName\":\"App\\\\Mail\\\\PasswordResetMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\PasswordResetMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"token\\\";s:64:\\\"9fdbc410353f870ba27ed52bc17773644d2dcb71cc72ad43596ab4c2f25eff40\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"digizaid5@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1760452000,\"delay\":null}', 0, NULL, 1760452000, 1760452000),
(56, 'default', '{\"uuid\":\"ac84ce25-abc9-4600-b2db-cda5ad0d9ccc\",\"displayName\":\"App\\\\Mail\\\\PasswordResetMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\PasswordResetMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"token\\\";s:64:\\\"64e68a4886d4e3d3bf1afe057a49b3946545307759e1a0ee5576ca12bc86cb2c\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"digizaid5@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1760452055,\"delay\":null}', 0, NULL, 1760452055, 1760452055),
(57, 'default', '{\"uuid\":\"0e14e0ae-d6a2-4d68-8d23-69e4d6f53016\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760456488,\"delay\":null}', 0, NULL, 1760456488, 1760456488),
(58, 'default', '{\"uuid\":\"6ded1b53-e676-4700-8c43-801df92ce055\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760458558,\"delay\":null}', 0, NULL, 1760458558, 1760458558),
(59, 'default', '{\"uuid\":\"9912c513-0cce-4a43-94fb-3368503ea6d1\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760461995,\"delay\":null}', 0, NULL, 1760461995, 1760461995),
(60, 'default', '{\"uuid\":\"46fdb291-68f9-461e-8c80-9bb01f35f01a\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760463245,\"delay\":null}', 0, NULL, 1760463245, 1760463245),
(61, 'default', '{\"uuid\":\"4d3f73f9-d65e-4692-810b-d3cadb3dfe94\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760503594,\"delay\":null}', 0, NULL, 1760503594, 1760503594),
(62, 'default', '{\"uuid\":\"658df4c8-f4d5-4242-b021-4dcc77a7b215\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760504258,\"delay\":null}', 0, NULL, 1760504258, 1760504258),
(63, 'default', '{\"uuid\":\"25044772-ca21-49d3-bd73-2b821bcf1f8e\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:208;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760506999,\"delay\":null}', 0, NULL, 1760506999, 1760506999),
(64, 'default', '{\"uuid\":\"50b0b8d9-c116-48ee-b2be-9467a9bdbdd5\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:207;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760507185,\"delay\":null}', 0, NULL, 1760507185, 1760507185),
(65, 'default', '{\"uuid\":\"b86f529a-a32a-4758-b59a-2b4a98ca289a\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760508220,\"delay\":null}', 0, NULL, 1760508220, 1760508220),
(66, 'default', '{\"uuid\":\"ce504cdb-53ce-42db-9759-1ad5b18527bc\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2365;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760511126,\"delay\":null}', 0, NULL, 1760511126, 1760511126),
(67, 'default', '{\"uuid\":\"20ee3052-a3f2-47df-bfe5-39b7bf515416\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2364;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760518665,\"delay\":null}', 0, NULL, 1760518665, 1760518665),
(68, 'default', '{\"uuid\":\"3fb0f093-143b-4cd5-88e5-276c1667da5c\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760519944,\"delay\":null}', 0, NULL, 1760519944, 1760519944),
(69, 'default', '{\"uuid\":\"15474d5b-fda1-4d5b-b006-03a84bc873a3\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2363;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520010,\"delay\":null}', 0, NULL, 1760520010, 1760520010),
(70, 'default', '{\"uuid\":\"3d97a9a7-6679-4c2e-ac93-44fe449c6b81\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520241,\"delay\":null}', 0, NULL, 1760520241, 1760520241),
(71, 'default', '{\"uuid\":\"4aa5e3fc-5fe0-4e5a-b257-709f45f7c209\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520269,\"delay\":null}', 0, NULL, 1760520269, 1760520269),
(72, 'default', '{\"uuid\":\"aa53a51a-8066-4e62-b1f8-f1f74b986578\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2363;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520327,\"delay\":null}', 0, NULL, 1760520327, 1760520327),
(73, 'default', '{\"uuid\":\"279ca3c1-1ec9-4695-8521-f762b2de2105\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2362;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520372,\"delay\":null}', 0, NULL, 1760520372, 1760520372),
(74, 'default', '{\"uuid\":\"7709f493-9101-49f2-8bc8-309968206ae0\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520385,\"delay\":null}', 0, NULL, 1760520385, 1760520385),
(75, 'default', '{\"uuid\":\"7032a334-20bb-4f05-b669-91014db53222\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2362;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760520400,\"delay\":null}', 0, NULL, 1760520400, 1760520400),
(76, 'default', '{\"uuid\":\"84beae02-3221-4e18-bcfa-590af8f62573\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760590597,\"delay\":null}', 0, NULL, 1760590597, 1760590597),
(77, 'default', '{\"uuid\":\"85ac734d-89ef-450b-9634-9b605c47d39a\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2970;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761799235,\"delay\":null}', 0, NULL, 1761799235, 1761799235),
(78, 'default', '{\"uuid\":\"bd6ad693-2b8d-4220-9347-707b53d02ead\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761799255,\"delay\":null}', 0, NULL, 1761799255, 1761799255);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(79, 'default', '{\"uuid\":\"6f4b8ead-0ec5-4f31-9579-6b8ecd970865\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:2970;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761799286,\"delay\":null}', 0, NULL, 1761799286, 1761799286),
(80, 'default', '{\"uuid\":\"aa1e405f-f6f5-4199-bd90-5819101c0e09\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:205;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761800091,\"delay\":null}', 0, NULL, 1761800091, 1761800091),
(81, 'default', '{\"uuid\":\"1dd02c4b-4ce9-4bfe-8a08-ad34efbcc678\",\"displayName\":\"App\\\\Events\\\\FitLiveChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:33:\\\"App\\\\Events\\\\FitLiveChatMessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\FitLiveChatMessage\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761800113,\"delay\":null}', 0, NULL, 1761800113, 1761800113),
(82, 'default', '{\"uuid\":\"738dd073-b21e-4573-821d-dd22455190d7\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:205;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761800266,\"delay\":null}', 0, NULL, 1761800266, 1761800266),
(83, 'default', '{\"uuid\":\"994b592c-06be-45f4-82fa-acbeb8a50ede\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761802361,\"delay\":null}', 0, NULL, 1761802361, 1761802361),
(84, 'default', '{\"uuid\":\"5064e294-e3b8-4d28-a6c8-b03126ef963d\",\"displayName\":\"App\\\\Listeners\\\\SendWelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:30:\\\"App\\\\Listeners\\\\SendWelcomeEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:33:\\\"Illuminate\\\\Auth\\\\Events\\\\Registered\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761802762,\"delay\":null}', 0, NULL, 1761802762, 1761802762);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_18_112941_create_personal_access_tokens_table', 1),
(5, '2025_06_18_113648_create_permission_tables', 1),
(6, '2025_06_20_183002_create_categories_table', 1),
(7, '2025_06_20_183009_create_sub_categories_table', 1),
(8, '2025_06_20_183224_create_fitlive_sessions_table', 1),
(9, '2025_06_20_183229_create_fitlive_chat_messages_table', 1),
(10, '2025_06_21_032957_create_fit_news_table', 1),
(11, '2025_06_21_164338_add_streaming_fields_to_fitlive_sessions_table', 1),
(12, '2025_06_23_221655_add_bio_avatar_to_users_table', 1),
(13, '2025_06_23_232708_add_is_instructor_to_fitlive_chat_messages_table', 1),
(14, '2025_06_24_134118_add_recording_fields_to_fitlive_sessions_table', 1),
(15, '2025_06_24_134137_add_recording_fields_to_fit_news_table', 1),
(16, '2025_06_24_194205_create_fg_categories_table', 1),
(17, '2025_06_24_194206_create_fg_sub_categories_table', 1),
(18, '2025_06_24_194208_create_fg_singles_table', 1),
(19, '2025_06_24_194210_create_fg_series_table', 1),
(20, '2025_06_24_194228_create_fg_series_episodes_table', 1),
(21, '2025_06_24_205645_make_fg_sub_category_id_nullable_in_fg_series_table', 1),
(22, '2025_06_24_205738_make_fg_sub_category_id_nullable_in_fg_singles_table', 1),
(23, '2025_06_25_000153_create_fi_categories_table', 1),
(24, '2025_06_25_000157_create_fi_blogs_table', 1),
(25, '2025_06_25_173530_create_fit_docs_table', 1),
(26, '2025_06_25_173533_create_fit_doc_episodes_table', 1),
(29, '2024_01_20_000001_create_fitflix_shorts_categories_table', 2),
(30, '2024_01_20_000002_create_fitflix_shorts_table', 2),
(31, '2025_06_26_022551_create_homepage_heroes_table', 3),
(32, '2025_01_15_000001_create_subscription_plans_table', 4),
(33, '2025_01_15_000002_create_user_subscriptions_table', 5),
(34, '2025_01_15_000003_create_referral_codes_table', 5),
(35, '2025_01_15_000004_create_referral_usage_table', 5),
(36, '2025_01_15_000005_create_influencer_profiles_table', 5),
(37, '2025_01_15_000006_create_influencer_links_table', 5),
(38, '2025_01_15_000007_create_influencer_sales_table', 5),
(39, '2025_01_15_000008_create_commission_payouts_table', 5),
(40, '2025_01_15_000009_add_subscription_fields_to_users_table', 5),
(41, '2025_07_01_195545_create_customer_columns', 6),
(42, '2025_07_01_195546_create_subscriptions_table', 6),
(43, '2025_07_01_195547_create_subscription_items_table', 6),
(44, '2025_07_01_235022_create_referral_usages_table', 7),
(45, '2025_07_02_011948_create_influencer_link_visits_table', 8),
(46, '2025_07_02_011951_create_commission_tiers_table', 8),
(47, '2025_07_02_011954_add_tracking_fields_to_users_table', 8),
(48, '2025_07_15_000001_create_community_categories_table', 9),
(49, '2025_07_15_000002_create_community_posts_table', 10),
(50, '2025_07_15_000003_create_post_likes_table', 10),
(51, '2025_07_15_000004_create_post_comments_table', 10),
(52, '2025_07_15_000005_create_friendships_table', 10),
(53, '2025_07_15_000006_create_user_profiles_table', 10),
(54, '2025_07_15_000007_create_community_groups_table', 10),
(55, '2025_07_15_000008_create_group_members_table', 10),
(56, '2025_07_15_000009_create_badges_table', 10),
(57, '2025_07_15_000010_create_user_badges_table', 10),
(58, '2025_07_15_000011_create_direct_messages_table', 10),
(59, '2025_07_15_000012_create_fittalk_sessions_table', 10),
(60, '2025_07_15_000013_create_conversations_table', 10),
(61, '2025_07_15_000014_add_foreign_key_constraints', 10),
(62, '2025_07_03_185000_make_youtube_video_id_nullable', 11),
(63, '2025_07_03_185402_make_youtube_video_id_nullable_in_homepage_heroes_table', 11),
(64, '2025_07_03_185409_make_youtube_video_id_nullable', 11),
(65, '2025_07_04_000003_add_deleted_at_to_community_posts_table', 12),
(66, '2025_07_04_000010_add_duration_months_to_subscription_plans_table', 13),
(67, '2025_07_04_000011_add_is_available_for_fittalk_to_users_table', 13),
(68, '2025_07_04_190714_add_duration_months_to_subscription_plans_table', 13),
(69, '2025_07_04_200000_create_fitarena_events_table', 14),
(70, '2025_07_04_200001_create_fitarena_stages_table', 14),
(71, '2025_07_04_200002_create_fitarena_sessions_table', 14),
(72, '2025_07_22_010558_add_two_factor_columns_to_users_table', 15),
(73, '2025_07_22_013220_create_user_login_activities_table', 16),
(74, '2025_07_22_013409_create_user_watchlist_table', 17),
(75, '2025_07_22_013510_create_user_watch_progress_table', 17),
(76, '2025_07_22_013659_create_content_ratings_table', 18),
(77, '2025_07_22_013813_create_content_reviews_table', 18),
(78, '2025_07_22_014144_create_discount_coupons_table', 18),
(79, '2025_07_22_014439_create_coupon_usages_table', 18),
(80, '2025_07_24_005803_add_deleted_at_to_direct_messages_table', 19),
(81, '2025_07_24_010053_add_is_flagged_to_community_posts_table', 19),
(82, '2025_08_11_220651_add_type_column_to_categories_table', 20),
(83, '2025_08_11_000001_add_is_active_to_fg_series_table', 21),
(84, '2025_08_11_000002_add_is_active_to_categories_table', 21),
(85, '2025_08_11_000003_add_is_active_to_fit_flix_shorts_table', 21),
(86, '2025_08_11_000004_add_deleted_at_to_post_comments_table', 21),
(87, '2025_08_11_000005_create_fit_casts_table', 22),
(88, '2025_08_11_000006_create_payment_transactions_table', 22),
(89, '2025_08_11_000007_create_groups_table', 22),
(90, '2025_08_11_000008_add_referral_code_to_users_table', 22),
(91, '2025_01_01_000001_add_is_published_to_fit_news_table', 23),
(92, '2025_01_01_000002_add_tags_to_fit_flix_shorts_table', 23),
(93, '2025_01_01_000003_modify_post_likes_table_for_polymorphic', 24),
(94, '2025_01_01_000004_add_group_id_to_group_members_table', 25),
(95, '2025_08_17_021428_add_referral_code_to_users_table', 25),
(96, '2025_01_01_000004_modify_post_comments_table_for_polymorphic', 26),
(97, '2025_01_01_000005_fix_post_likes_table_structure', 27),
(98, '2025_01_01_000007_add_is_active_to_fit_docs_table', 27),
(99, '2025_08_18_150555_create_fit_insights_table', 28),
(100, '2025_08_18_170322_create_group_messages_table', 29),
(102, '2025_08_18_170539_create_group_message_reads_table', 30),
(103, '2025_08_27_020810_add_sequence_order_to_fit_flix_shorts_table', 31),
(104, '2025_08_28_001951_add_order_column_to_community_categories_table', 31),
(105, '2025_01_15_000001_add_description_and_image_to_categories_table', 32),
(106, '2025_01_15_000002_add_specializations_and_hourly_rate_to_user_profiles', 32),
(107, '2025_09_16_182556_create_contact_us_table', 33),
(109, '2025_09_16_182435_create_static_pages_table', 34),
(110, '2025_09_17_102101_create_user_follows_table', 35),
(111, '2025_09_26_173441_create_fitarena_participants_table', 36);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29),
(3, 'App\\Models\\User', 30),
(3, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 32),
(3, 'App\\Models\\User', 33),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 35),
(3, 'App\\Models\\User', 36),
(3, 'App\\Models\\User', 37),
(3, 'App\\Models\\User', 38),
(3, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 40),
(3, 'App\\Models\\User', 41);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('digizaid5@gmail.com', '$2y$12$r6.2d4L.Eb1/wP2wiEA.3.GR5Ww4a6RqW.kTHd7uYsuoH1JBGz.3.', '2025-10-14 19:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `status` enum('pending','processing','completed','failed','cancelled','refunded','partially_refunded') NOT NULL DEFAULT 'pending',
  `gateway_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_response`)),
  `gateway_transaction_id` varchar(255) DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_transactions`
--

INSERT INTO `payment_transactions` (`id`, `user_id`, `subscription_id`, `transaction_id`, `payment_method`, `payment_gateway`, `amount`, `currency`, `status`, `gateway_response`, `gateway_transaction_id`, `processed_at`, `failed_at`, `refunded_at`, `refund_amount`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 27, NULL, 'pay_RSvyAFI22gKEMo', 'razorpay', 'razorpay', 399.00, 'INR', 'completed', '\"{\\\"razorpay_payment_id\\\":\\\"pay_RSvyAFI22gKEMo\\\",\\\"razorpay_order_id\\\":\\\"order_RSvx6JTNEdA3QR\\\",\\\"razorpay_signature\\\":\\\"84c10f488c664633446d8818b7358e2ae9b05bc54265f4a10d5d416d24e270b9\\\",\\\"plan_id\\\":\\\"21\\\",\\\"referral_code\\\":null}\"', 'order_RSvx6JTNEdA3QR', '2025-10-13 16:33:48', NULL, NULL, NULL, NULL, '2025-10-13 16:33:48', '2025-10-13 16:33:48', NULL),
(2, 30, NULL, 'pay_RSy70kOvF6rzSX', 'razorpay', 'razorpay', 1399.00, 'INR', 'completed', '\"{\\\"razorpay_payment_id\\\":\\\"pay_RSy70kOvF6rzSX\\\",\\\"razorpay_order_id\\\":\\\"order_RSy6XggiyW5Owg\\\",\\\"razorpay_signature\\\":\\\"32afd51e6622e17a2526c7b7e3fa277a6af91991c118ebfdadf0906fb3a42e50\\\",\\\"plan_id\\\":\\\"24\\\",\\\"referral_code\\\":null}\"', 'order_RSy6XggiyW5Owg', '2025-10-13 18:39:35', NULL, NULL, NULL, NULL, '2025-10-13 18:39:35', '2025-10-13 18:39:35', NULL),
(3, 30, NULL, 'pay_RTIAGBtlGwXhkO', 'razorpay', 'razorpay', 499.00, 'INR', 'completed', '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTIAGBtlGwXhkO\\\",\\\"razorpay_order_id\\\":\\\"order_RTI8cGwIEkxCP9\\\",\\\"razorpay_signature\\\":\\\"c6ee6e89a92064c63a32a10b3a015fa1fd865ec2b087720fb3965c1a20443598\\\",\\\"plan_id\\\":\\\"23\\\",\\\"referral_code\\\":null}\"', 'order_RTI8cGwIEkxCP9', '2025-10-14 14:16:33', NULL, NULL, NULL, NULL, '2025-10-14 14:16:33', '2025-10-14 14:16:33', NULL),
(4, 30, NULL, 'pay_RTIBpPI8LwPQio', 'razorpay', 'razorpay', 1399.00, 'INR', 'completed', '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTIBpPI8LwPQio\\\",\\\"razorpay_order_id\\\":\\\"order_RTIBARiRJTHLpW\\\",\\\"razorpay_signature\\\":\\\"9ad6061ba7400ee7eede11fb21abf83078c68cb34fd1d370b61b5cb46b32d080\\\",\\\"plan_id\\\":\\\"24\\\",\\\"referral_code\\\":null}\"', 'order_RTIBARiRJTHLpW', '2025-10-14 14:18:00', NULL, NULL, NULL, NULL, '2025-10-14 14:18:00', '2025-10-14 14:18:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view users', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(2, 'create users', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(3, 'edit users', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(4, 'delete users', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(5, 'view roles', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(6, 'create roles', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(7, 'edit roles', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(8, 'delete roles', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(9, 'view permissions', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(10, 'create permissions', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(11, 'edit permissions', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(12, 'delete permissions', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(13, 'view dashboard', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(14, 'manage courses', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(15, 'view courses', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(16, 'create courses', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(17, 'edit courses', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(18, 'delete courses', 'web', '2025-06-25 17:57:46', '2025-06-25 17:57:46'),
(19, 'manage content', 'web', '2025-06-25 17:57:47', '2025-06-25 17:57:47'),
(20, 'view reports', 'web', '2025-06-25 17:57:47', '2025-06-25 17:57:47'),
(21, 'manage-fitlive', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(22, 'create-sessions', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(23, 'edit-sessions', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(24, 'delete-sessions', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(25, 'start-sessions', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(26, 'end-sessions', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(27, 'manage-categories', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48'),
(28, 'view-analytics', 'web', '2025-06-25 17:57:48', '2025-06-25 17:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 8, 'auth-token', 'b9cf8050f5a6ddad87da018875cee651c30b14b98b9202b30f44ed69da0b0d42', '[\"*\"]', NULL, NULL, '2025-07-02 14:52:59', '2025-07-02 14:52:59'),
(2, 'App\\Models\\User', 8, 'auth-token', '49c9ad2a3320b0c1ab2f7c74dd50c7b1d7bedf2575bc69068b8eb4b202125f1a', '[\"*\"]', NULL, NULL, '2025-07-02 14:53:19', '2025-07-02 14:53:19'),
(3, 'App\\Models\\User', 8, 'auth-token', '1fa7b236ec3bb34acedb249b8dc4aa279e4df4e540f6319e730840a6d1cecdf4', '[\"*\"]', NULL, NULL, '2025-07-02 14:56:36', '2025-07-02 14:56:36'),
(4, 'App\\Models\\User', 9, 'auth-token', 'b34ecf038aeaeeda29f973c87274cef027425f5b0271b283b39c09fa13e48727', '[\"*\"]', NULL, NULL, '2025-07-02 19:01:06', '2025-07-02 19:01:06'),
(5, 'App\\Models\\User', 9, 'auth-token', '0b4032fb5e5e723b4eb9c7042d8864bfa0102c437606142a5f63c52e2b0b4210', '[\"*\"]', NULL, NULL, '2025-07-02 19:01:14', '2025-07-02 19:01:14'),
(6, 'App\\Models\\User', 9, 'auth-token', '40faf4e7ca36540c3845ac5bd7a2ba2c1db467d425b615f17329474732a552f7', '[\"*\"]', '2025-07-04 10:49:55', NULL, '2025-07-04 10:49:53', '2025-07-04 10:49:55'),
(7, 'App\\Models\\User', 10, 'auth-token', 'ef023c347c77057a54737bfffacd1a438c9e0222ade97662ce66219ff0ae7ce4', '[\"*\"]', '2025-07-22 19:36:10', NULL, '2025-07-22 19:36:06', '2025-07-22 19:36:10'),
(8, 'App\\Models\\User', 11, 'auth-token', '9992da9921375a30b6d861a85d97d796162db34b43054c0324e2074927fb77c6', '[\"*\"]', NULL, NULL, '2025-08-05 14:19:42', '2025-08-05 14:19:42'),
(9, 'App\\Models\\User', 11, 'auth-token', '4ec5bb56bb2c7038992561bb807208d0a6940e2db7ee504345f59957dd9c0093', '[\"*\"]', '2025-08-05 14:25:35', NULL, '2025-08-05 14:20:23', '2025-08-05 14:25:35'),
(10, 'App\\Models\\User', 11, 'auth-token', 'b060e1248b72c6327773277a1548aadb34facdc12eab95ee6e8790fd9d23586f', '[\"*\"]', NULL, NULL, '2025-08-05 14:23:16', '2025-08-05 14:23:16'),
(11, 'App\\Models\\User', 12, 'auth-token', 'cdc18f9e695caacff100413f8c89ef1316249dc97a45af4da573dc7fd842619d', '[\"*\"]', NULL, NULL, '2025-08-08 20:04:29', '2025-08-08 20:04:29'),
(12, 'App\\Models\\User', 12, 'auth-token', '1550e75838e1c67418ee2c389dc2e34c4a81b340e2973e4e5987153f0bd8c732', '[\"*\"]', '2025-08-08 20:04:50', NULL, '2025-08-08 20:04:36', '2025-08-08 20:04:50'),
(13, 'App\\Models\\User', 8, 'auth-token', '43a9ae60f5fcde867f9c48ff57ee64f18eb2091cb3517c474c1235359a340fe5', '[\"*\"]', NULL, NULL, '2025-08-11 14:35:49', '2025-08-11 14:35:49'),
(14, 'App\\Models\\User', 8, 'auth-token', '3721f0e610f07fc4d31eae93e7f8e8171e7db80f07a2e57956f20b894d1cbb2c', '[\"*\"]', '2025-08-11 14:50:49', NULL, '2025-08-11 14:36:47', '2025-08-11 14:50:49'),
(15, 'App\\Models\\User', 8, 'auth-token', '69182cd31dd8e1a0053586c751166e8f6bc7273808c3faa94e743a358f50208a', '[\"*\"]', '2025-08-11 15:54:18', NULL, '2025-08-11 15:53:15', '2025-08-11 15:54:18'),
(16, 'App\\Models\\User', 8, 'auth-token', 'fee4bbe76d5b17782ae83acaf3383f0986875c8f6701d5fee41365a0bec6a721', '[\"*\"]', '2025-08-11 16:09:16', NULL, '2025-08-11 16:06:02', '2025-08-11 16:09:16'),
(17, 'App\\Models\\User', 8, 'auth-token', 'a2e363cca051c70c52de9050ab0e994a40f7677edb24a7ee38b31252a8a3f91c', '[\"*\"]', NULL, NULL, '2025-08-11 16:17:23', '2025-08-11 16:17:23'),
(18, 'App\\Models\\User', 8, 'auth-token', '77ddc2f5fe36bf3127c103c4ad934aefeb60bb36dff49d4545dc7a17fef88cb0', '[\"*\"]', '2025-08-11 16:32:14', NULL, '2025-08-11 16:26:54', '2025-08-11 16:32:14'),
(19, 'App\\Models\\User', 8, 'auth-token', 'bc801d6b0d0f1943f2abf3df6ea3c489ee35658a21e78a743995071bdf613cb3', '[\"*\"]', '2025-08-12 15:15:19', NULL, '2025-08-11 17:09:13', '2025-08-12 15:15:19'),
(20, 'App\\Models\\User', 8, 'auth-token', '7b587c138142e6cd3029dab2b012212c0077cde17633c701f02191f599f584c4', '[\"*\"]', NULL, NULL, '2025-08-11 17:10:14', '2025-08-11 17:10:14'),
(21, 'App\\Models\\User', 8, 'auth-token', 'f95777b0c01886aef03c71ddeba1033daef0078d6463d046410103d3559db836', '[\"*\"]', NULL, NULL, '2025-08-11 17:32:36', '2025-08-11 17:32:36'),
(22, 'App\\Models\\User', 8, 'auth-token', '694dc11720119a4f48b5fbbb08d88cc9959a9ec0e58428fa17c54f82c3e096a4', '[\"*\"]', NULL, NULL, '2025-08-16 19:06:56', '2025-08-16 19:06:56'),
(23, 'App\\Models\\User', 8, 'auth-token', '0031ea1f1c2c3fb7235eea4b5e93d00fb2df106bc2dff2b9aedebe498fd0a786', '[\"*\"]', NULL, NULL, '2025-08-16 19:07:58', '2025-08-16 19:07:58'),
(24, 'App\\Models\\User', 8, 'auth-token', '685e563f0132062b9b432213adfd44bb10d3475a789898d8e9240655c0e0a97e', '[\"*\"]', NULL, NULL, '2025-08-16 19:08:19', '2025-08-16 19:08:19'),
(25, 'App\\Models\\User', 8, 'auth-token', '919f3e7bb519c094bd495b52980b8b7a54eb454845a3e724a27deba872e64c4a', '[\"*\"]', NULL, NULL, '2025-08-16 20:03:47', '2025-08-16 20:03:47'),
(26, 'App\\Models\\User', 8, 'auth-token', '5c35239088b61f4fc0e5430bd1d4647712b62c5c2787ef0494a4a9dc396be277', '[\"*\"]', NULL, NULL, '2025-08-16 20:04:38', '2025-08-16 20:04:38'),
(27, 'App\\Models\\User', 8, 'auth-token', '6ef92b64fd8e888a12d4eee88efd98487cf4e29a7d2494934ce642161ce573c2', '[\"*\"]', NULL, NULL, '2025-08-16 20:20:35', '2025-08-16 20:20:35'),
(28, 'App\\Models\\User', 8, 'auth-token', 'fbfdcd770bf0feb94b23036db613fb60e3953b005322a660e5178a1b65e2d34f', '[\"*\"]', NULL, NULL, '2025-08-16 20:22:04', '2025-08-16 20:22:04'),
(29, 'App\\Models\\User', 8, 'auth-token', '52171fff935a5843b87b660f475660f21eb4c5f94835b737921deb7dc4fd041d', '[\"*\"]', NULL, NULL, '2025-08-16 20:23:26', '2025-08-16 20:23:26'),
(30, 'App\\Models\\User', 8, 'auth-token', '6fa54a60682ddabf2b44a793112f90f08f8f6cbf4b5565fce4bc1d6191443335', '[\"*\"]', NULL, NULL, '2025-08-16 20:46:58', '2025-08-16 20:46:58'),
(31, 'App\\Models\\User', 8, 'auth-token', '5985567ae920b862641e929a219501ab973537105dd64caffd8dedebc5566770', '[\"*\"]', NULL, NULL, '2025-08-16 20:47:14', '2025-08-16 20:47:14'),
(32, 'App\\Models\\User', 8, 'auth-token', '57615e169cee0abdb89ceed11993a635e3247acfac0c13368a77b89a6552d02d', '[\"*\"]', NULL, NULL, '2025-08-17 08:04:39', '2025-08-17 08:04:39'),
(33, 'App\\Models\\User', 8, 'auth-token', '5aabb2c1f455c3ba49b223e953cbb66518e6ca66d6baedd956ad3f2dc59ec4ed', '[\"*\"]', NULL, NULL, '2025-08-17 08:06:52', '2025-08-17 08:06:52'),
(34, 'App\\Models\\User', 8, 'auth-token', '1c570c7ba4fb153a7e03e57f0295ec9fab5d0b1cfc9969241e2185786a48c0eb', '[\"*\"]', NULL, NULL, '2025-08-17 08:13:26', '2025-08-17 08:13:26'),
(35, 'App\\Models\\User', 8, 'auth-token', '22fd9f4459a6343a377e5364e85ec08d3f838e17d7348fe5bc6ce6673563dbef', '[\"*\"]', NULL, NULL, '2025-08-17 08:15:21', '2025-08-17 08:15:21'),
(36, 'App\\Models\\User', 8, 'auth-token', '215774042bd529b75fb19361dcf4417e7f22086d60663c69992ee1e938f04d3d', '[\"*\"]', NULL, NULL, '2025-08-17 08:43:48', '2025-08-17 08:43:48'),
(37, 'App\\Models\\User', 8, 'auth-token', '81171e53f885aee9da82e909a5c843c11b959d39c2c53dac3240d1b14986b92d', '[\"*\"]', NULL, NULL, '2025-08-17 08:44:07', '2025-08-17 08:44:07'),
(39, 'App\\Models\\User', 8, 'auth-token', 'ace3c9e1768fdcb1bc9aeccaf26089d74b73588b85b3d95095c5c4bc7f55556a', '[\"*\"]', NULL, NULL, '2025-08-17 08:45:40', '2025-08-17 08:45:40'),
(40, 'App\\Models\\User', 8, 'auth-token', '65ea8f0feaba113938f704b81d39cb225c46d29d83ece4533c9510a6f6a4212b', '[\"*\"]', NULL, NULL, '2025-08-17 08:52:08', '2025-08-17 08:52:08'),
(41, 'App\\Models\\User', 14, 'auth-token', '4703ca9062c80f0ad8f6491dcb58676bdef7936e9609c046d48cd6b360d66303', '[\"*\"]', '2025-08-17 13:12:20', NULL, '2025-08-17 08:54:24', '2025-08-17 13:12:20'),
(42, 'App\\Models\\User', 8, 'auth-token', '5f8a355e64031bf69fca01eb3111e709fa88850d55af27ffffbd1f65e0d7fe6b', '[\"*\"]', NULL, NULL, '2025-08-17 10:23:26', '2025-08-17 10:23:26'),
(43, 'App\\Models\\User', 8, 'auth-token', '2dde047aaae1212586d7e11083ca13afef178bcaf2c703ffa22aa7fa94125b0b', '[\"*\"]', NULL, NULL, '2025-08-17 10:23:54', '2025-08-17 10:23:54'),
(44, 'App\\Models\\User', 14, 'auth-token', '0da135502178e4527b99e55d36fca0253bfc229c0e8c4f0bdd2dbd460a144835', '[\"*\"]', NULL, NULL, '2025-08-17 10:24:39', '2025-08-17 10:24:39'),
(45, 'App\\Models\\User', 14, 'auth-token', '7ecba91c77bcd200cfa064e0fc9bfbdede7bf9bf4b941c48f86c6c9a77700281', '[\"*\"]', NULL, NULL, '2025-08-17 10:27:47', '2025-08-17 10:27:47'),
(46, 'App\\Models\\User', 14, 'auth-token', '62e65f25aba31515fa387d5477beec1653caebf11fd27eeaacbffe989a146733', '[\"*\"]', NULL, NULL, '2025-08-17 10:30:40', '2025-08-17 10:30:40'),
(47, 'App\\Models\\User', 15, 'auth-token', '78ecb259b7c897787c8b074d266bb84d831b46d542f45ea2f6d3b91d1f30c83c', '[\"*\"]', NULL, NULL, '2025-08-17 10:32:59', '2025-08-17 10:32:59'),
(48, 'App\\Models\\User', 15, 'auth-token', '4e0e8b66ac99c535f802d6536ebf4b3c3195e199deaca73b29cbf5f251394257', '[\"*\"]', NULL, NULL, '2025-08-17 13:18:25', '2025-08-17 13:18:25'),
(49, 'App\\Models\\User', 8, 'auth-token', '8d3538df1089a47c755bd1e4b2738120e71db036504462a718643de413cc7226', '[\"*\"]', '2025-08-26 17:56:52', NULL, '2025-08-17 13:55:49', '2025-08-26 17:56:52'),
(50, 'App\\Models\\User', 8, 'auth-token', '3fdc04f3cae467e8816869a546a32f27a2cdc6080b6f2a3d1bfb3ca3281dedbf', '[\"*\"]', NULL, NULL, '2025-08-18 06:43:35', '2025-08-18 06:43:35'),
(51, 'App\\Models\\User', 12, 'test-token', '6c7380a6a9e571b9df14118b2a9973ba63fa8a20076566d56aa3d08bbd4199ed', '[\"*\"]', '2025-08-18 11:35:12', NULL, '2025-08-18 11:35:11', '2025-08-18 11:35:12'),
(52, 'App\\Models\\User', 12, 'test-token', '78e2e098418c6d4ebfca77ee03cfced0e00213b7fa24533167282305750f22dc', '[\"*\"]', '2025-08-18 11:37:38', NULL, '2025-08-18 11:37:36', '2025-08-18 11:37:38'),
(53, 'App\\Models\\User', 12, 'test-token', 'c05dc6e18d629e594f29cca3f18f6a9b8c42d26141df36162ab0dcf98c791d2f', '[\"*\"]', '2025-08-18 11:39:48', NULL, '2025-08-18 11:39:47', '2025-08-18 11:39:48'),
(56, 'App\\Models\\User', 17, 'test-token', '8a315948e16e44329bde16cdabf557c392a97fbf62b04f8b316f1bda017f4b52', '[\"*\"]', '2025-08-18 13:11:07', NULL, '2025-08-18 13:11:06', '2025-08-18 13:11:07'),
(57, 'App\\Models\\User', 17, 'test-token', '5e008e0c47e2af461a24137c75df022d5c08c14d45d897a34feae227a3e50b70', '[\"*\"]', '2025-08-18 13:11:28', NULL, '2025-08-18 13:11:27', '2025-08-18 13:11:28'),
(58, 'App\\Models\\User', 8, 'auth-token', 'ec737e40506906dfabe35442c3be4219c59cf111ed876c16a76413796fe11e7b', '[\"*\"]', NULL, NULL, '2025-08-18 17:55:50', '2025-08-18 17:55:50'),
(59, 'App\\Models\\User', 8, 'auth-token', 'd3982d8d25479a44bc4763a2da89bd3de7f6a419f1ccbdf794ea5b4e11c3ab5b', '[\"*\"]', NULL, NULL, '2025-08-26 17:06:48', '2025-08-26 17:06:48'),
(60, 'App\\Models\\User', 19, 'auth-token', 'd8b1707d91f81a4ab1975e6ce21749cc11b08ca7785837a9832c15b6e8d86f1a', '[\"*\"]', '2025-08-26 20:35:26', NULL, '2025-08-26 19:21:30', '2025-08-26 20:35:26'),
(61, 'App\\Models\\User', 20, 'auth-token', '4fc604372de5d0fd05cf20495ee78835ba0b172cb312fd912d5deb586f8f416c', '[\"*\"]', '2025-09-03 10:55:03', NULL, '2025-08-26 20:35:04', '2025-09-03 10:55:03'),
(62, 'App\\Models\\User', 20, 'auth-token', '0455855dbd765f23b7b7933b4d69c8f4ae918681aa5ab6a90974b54151c24c6b', '[\"*\"]', NULL, NULL, '2025-08-29 14:04:36', '2025-08-29 14:04:36'),
(63, 'App\\Models\\User', 20, 'auth-token', 'bbf8020dcc78e09c055e688a7937b2f199724bfe9c595a3fa65c32fa6a06ed04', '[\"*\"]', NULL, NULL, '2025-08-29 14:21:47', '2025-08-29 14:21:47'),
(64, 'App\\Models\\User', 8, 'auth-token', '419c98fa5beb7f5d53bd4779716a19454e5885e497a16c0205baaddcfa0fbc39', '[\"*\"]', NULL, NULL, '2025-09-03 10:46:33', '2025-09-03 10:46:33'),
(65, 'App\\Models\\User', 8, 'auth-token', '8ee119b04250159622c431925769c58fed70ab95d57fbb5b23d2eaca63ae67d8', '[\"*\"]', '2025-09-03 11:03:53', NULL, '2025-09-03 11:03:32', '2025-09-03 11:03:53'),
(66, 'App\\Models\\User', 8, 'auth-token', 'af033b091d9e86fbc6bdffc66ce0d0df3e287f92897adcd2ec3eb4379d4ab88c', '[\"*\"]', '2025-09-03 13:18:09', NULL, '2025-09-03 11:24:13', '2025-09-03 13:18:09'),
(67, 'App\\Models\\User', 3, 'auth-token', 'e5d27936b216118552669cb0b7a210a67d7479d8cb6cfb261a36703e913dc9ae', '[\"*\"]', '2025-10-30 10:05:31', NULL, '2025-09-05 06:25:10', '2025-10-30 10:05:31'),
(68, 'App\\Models\\User', 3, 'auth-token', 'ba497af8eff8d57eac1977e057df4bb9dce45ab067e9594f9374e1c077748021', '[\"*\"]', '2025-09-30 14:10:46', NULL, '2025-09-10 10:07:30', '2025-09-30 14:10:46'),
(69, 'App\\Models\\User', 3, 'auth-token', 'ee75d22f7fe0577617874fad78b2058c84032d6bad5f20595051dfaba6ba8b28', '[\"*\"]', '2025-09-12 12:39:58', NULL, '2025-09-11 06:38:55', '2025-09-12 12:39:58'),
(70, 'App\\Models\\User', 3, 'auth-token', 'd573a54e93aa0edb77932a7365cf2a8ad2a76d711d895dfdada8fcdc98ff29c7', '[\"*\"]', '2025-09-15 05:04:47', NULL, '2025-09-15 05:04:08', '2025-09-15 05:04:47'),
(71, 'App\\Models\\User', 3, 'auth-token', 'eeefef9625a87e1b492e776bf0b8c34e4bb83797387b52f6bd2abb45a1c0e093', '[\"*\"]', '2025-09-17 06:18:23', NULL, '2025-09-15 05:53:19', '2025-09-17 06:18:23'),
(72, 'App\\Models\\User', 3, 'auth-token', '226399919f2b0fd0d47b3454bfbd1648885cebdb6c3328fd4b4f5b4630aa3aeb', '[\"*\"]', '2025-09-19 05:15:24', NULL, '2025-09-18 02:36:26', '2025-09-19 05:15:24'),
(73, 'App\\Models\\User', 3, 'auth-token', 'cf2ff15749c06d6f15b1ef93feb06b9c1aff7c8951f3f44d2228b76aa11d2eb4', '[\"*\"]', '2025-09-30 14:08:17', NULL, '2025-09-18 02:42:45', '2025-09-30 14:08:17'),
(74, 'App\\Models\\User', 3, 'auth-token', '8b70019f7167b913984475548d5a8ee68c61a50449c97a0c7bad0b8ccbe32e4d', '[\"*\"]', NULL, NULL, '2025-09-23 06:26:11', '2025-09-23 06:26:11'),
(75, 'App\\Models\\User', 3, 'auth-token', '727280f4eb150173924c03d0a8038e6afcc36f407ec0d943abc9d6e0f90ae124', '[\"*\"]', '2025-09-24 09:24:21', NULL, '2025-09-24 05:18:04', '2025-09-24 09:24:21'),
(76, 'App\\Models\\User', 3, 'auth-token', 'd31408bb2fb7af69621ca93f47bdf0af5c92e6f2081effe5473e4d92e13d3ee8', '[\"*\"]', '2025-09-25 11:06:53', NULL, '2025-09-24 16:25:47', '2025-09-25 11:06:53'),
(77, 'App\\Models\\User', 3, 'auth-token', '29f5bcb3cf1926c0615144b468ac06b0a17d8633748dc4d6665794876066219b', '[\"*\"]', '2025-09-25 11:52:14', NULL, '2025-09-24 16:33:35', '2025-09-25 11:52:14'),
(78, 'App\\Models\\User', 15, 'auth-token', 'c88e6d94edc1277a1347799b6304f2adb6c2d6eca1b9e1390b95d07e45ab6a6e', '[\"*\"]', '2025-09-25 08:20:15', NULL, '2025-09-25 00:18:24', '2025-09-25 08:20:15'),
(79, 'App\\Models\\User', 15, 'auth-token', 'b87d755ed8413d0ac9cf09ac057af51bfddd2dbf62832999827039f7a7378690', '[\"*\"]', '2025-09-25 11:52:28', NULL, '2025-09-25 08:20:36', '2025-09-25 11:52:28'),
(80, 'App\\Models\\User', 3, 'auth-token', '3327725da22134857436d5ddf7f6329c7eef0e4232e5915d7d2cce89e481ea0d', '[\"*\"]', '2025-09-25 11:34:42', NULL, '2025-09-25 10:22:31', '2025-09-25 11:34:42'),
(81, 'App\\Models\\User', 3, 'auth-token', 'c921597c005c40e3b07d1d57b400e85848989ae98df0d4541df397946feefe90', '[\"*\"]', '2025-10-01 01:02:59', NULL, '2025-09-25 10:39:42', '2025-10-01 01:02:59'),
(82, 'App\\Models\\User', 3, 'auth-token', '4314efe3f9cfded17d0ca525d87bb93fa80a73a0812baf468d949d89c5b7f072', '[\"*\"]', '2025-09-26 14:26:50', NULL, '2025-09-26 12:19:04', '2025-09-26 14:26:50'),
(83, 'App\\Models\\User', 3, 'auth-token', 'a3ae8362a38b85216eb7963fdc067c3865cd2a98d96cfd0f09a3f0148df9ba25', '[\"*\"]', '2025-09-27 12:57:26', NULL, '2025-09-27 08:42:20', '2025-09-27 12:57:26'),
(84, 'App\\Models\\User', 3, 'auth-token', '00bfdb14684c910d444264dd5385fce81deef11032df3e78f12e8c4f36a9c685', '[\"*\"]', '2025-09-29 05:45:48', NULL, '2025-09-29 05:42:49', '2025-09-29 05:45:48'),
(85, 'App\\Models\\User', 15, 'auth-token', '3706d9292de75375c35751cec6c82a88ebd2ab6c213cba51a4eb5d285db6d610', '[\"*\"]', '2025-09-29 11:55:25', NULL, '2025-09-29 11:35:28', '2025-09-29 11:55:25'),
(86, 'App\\Models\\User', 3, 'auth-token', 'c691fab7fbff144ef77e8c225696faefb0d99c5ae3c61487b7c89d8a89a73d05', '[\"*\"]', '2025-09-30 16:23:02', NULL, '2025-09-29 11:41:44', '2025-09-30 16:23:02'),
(87, 'App\\Models\\User', 15, 'auth-token', 'c41e541865d43b50d9ea2700bb1631c9a40ce71e2c66fa71946ba21600668354', '[\"*\"]', '2025-09-29 12:15:20', NULL, '2025-09-29 11:59:28', '2025-09-29 12:15:20'),
(88, 'App\\Models\\User', 15, 'auth-token', '84661a8ced173f4080bb4ac2ef3bd03a5bc4880c634679f0c391732c463e778f', '[\"*\"]', '2025-09-30 14:05:18', NULL, '2025-09-29 23:10:59', '2025-09-30 14:05:18'),
(89, 'App\\Models\\User', 15, 'auth-token', '20de0c436231a621962c302267fed39bf8699281e45f87cea8e433f4b2170e81', '[\"*\"]', '2025-10-01 01:07:59', NULL, '2025-09-30 08:43:20', '2025-10-01 01:07:59'),
(90, 'App\\Models\\User', 3, 'auth-token', '1a1b0b1c29e187019ce01bcded4ba60be6eb76fa5a0660b90f3ae2766f0f634b', '[\"*\"]', '2025-10-30 10:07:29', NULL, '2025-10-30 10:05:09', '2025-10-30 10:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_type` varchar(255) NOT NULL DEFAULT 'AppModelsCommunityPost',
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `user_id`, `post_type`, `post_id`, `parent_id`, `content`, `likes_count`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 14, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-08-17 10:44:26', '2025-08-17 10:44:26', NULL),
(2, 14, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-08-17 10:45:13', '2025-08-17 10:45:13', NULL),
(3, 8, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-08-18 06:44:05', '2025-08-18 06:44:05', NULL),
(4, 8, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-08-18 06:44:37', '2025-08-18 06:44:37', NULL),
(5, 8, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing your experience.', 0, 1, '2025-09-03 11:25:05', '2025-09-03 11:25:05', NULL),
(6, 8, 'fit_flix_video', 1, NULL, 'Great workout video! Really helped me with my form.', 0, 1, '2025-09-03 11:28:20', '2025-09-03 11:28:20', NULL),
(7, 8, 'fit_flix_video', 1, NULL, 'Great workout video! Really helped me with my form.', 0, 1, '2025-09-03 11:28:43', '2025-09-03 11:28:43', NULL),
(8, 8, 'fit_flix_video', 1, NULL, 'Great workout video! Really helped me with my form.', 0, 1, '2025-09-03 13:17:48', '2025-09-03 13:17:48', NULL),
(9, 3, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-09-15 06:52:00', '2025-09-15 06:52:00', NULL),
(10, 3, 'fit_series_video', 1, NULL, 'Great video!', 0, 1, '2025-09-16 09:48:25', '2025-09-16 09:48:25', NULL),
(11, 3, 'App\\Models\\CommunityPost', 1, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-09-16 12:29:18', '2025-09-16 12:29:18', NULL),
(12, 3, 'fit_series_video', 10, NULL, 'Great video!', 0, 1, '2025-09-26 07:26:18', '2025-09-26 07:26:18', NULL),
(13, 3, 'fit_series_video', 10, NULL, 'Hi, i am darshan', 0, 1, '2025-09-26 07:26:51', '2025-09-26 07:26:51', NULL),
(14, 3, 'fit_series_video', 10, NULL, 'Hi, i am indresh', 0, 1, '2025-09-26 07:27:37', '2025-09-26 07:27:37', NULL),
(15, 3, 'fit_series_video', 3, NULL, 'Hi, i am indresh', 0, 1, '2025-09-26 07:30:57', '2025-09-26 07:30:57', NULL),
(16, 3, 'fit_series_video', 3, NULL, 'Hi, i am darshan', 0, 1, '2025-09-26 07:34:16', '2025-09-26 07:34:16', NULL),
(17, 3, 'fit_insight_video', 3, NULL, 'Hi, i am darshan', 0, 1, '2025-09-26 07:34:35', '2025-09-26 07:34:35', NULL),
(18, 3, 'fit_insight_video', 3, NULL, 'Hi, i am indresh', 0, 1, '2025-09-26 07:34:42', '2025-09-26 07:34:42', NULL),
(19, 3, 'fit_insight_video', 3, NULL, 'Hi, i am saurabh', 0, 1, '2025-09-26 07:43:03', '2025-09-26 07:43:03', NULL),
(20, 3, 'App\\Models\\CommunityPost', 4, NULL, 'Great post! Thanks for sharing.', 0, 1, '2025-09-26 14:26:34', '2025-09-26 14:26:34', NULL),
(21, 3, 'App\\Models\\CommunityPost', 5, NULL, 'Comment from indresh', 0, 1, '2025-09-29 15:50:05', '2025-09-29 15:50:05', NULL),
(22, 15, 'fit_insight_video', 4, NULL, 'fgg', 0, 1, '2025-09-29 23:13:21', '2025-09-29 23:13:21', NULL),
(23, 15, 'fit_insight_video', 4, NULL, 'xcvh', 0, 1, '2025-09-29 23:13:25', '2025-09-29 23:13:25', NULL),
(24, 15, 'fit_flix_video', 1, NULL, 'dfgh', 0, 1, '2025-09-30 11:47:32', '2025-09-30 11:47:32', NULL),
(25, 15, 'fit_flix_video', 1, NULL, 'xvh', 0, 1, '2025-09-30 11:47:35', '2025-09-30 11:47:35', NULL),
(26, 15, 'fit_insight_video', 3, NULL, 'hiii', 0, 1, '2025-09-30 13:59:12', '2025-09-30 13:59:12', NULL),
(27, 15, 'fit_insight_video', 3, NULL, 'hello this is test comment...', 0, 1, '2025-09-30 13:59:22', '2025-09-30 13:59:22', NULL),
(28, 10, 'fit_insight_video', 2, NULL, 'Hshsh', 0, 1, '2025-10-10 22:17:38', '2025-10-10 22:17:38', NULL),
(29, 3, 'fit_insight_video', 4, NULL, 'Nope!', 0, 1, '2025-10-14 14:22:27', '2025-10-14 14:22:27', NULL),
(30, 38, 'fit_insight_video', 2, NULL, 'Nice blog!', 0, 1, '2025-10-15 10:37:50', '2025-10-15 10:37:50', NULL),
(31, 30, 'fit_insight_video', 2, NULL, 'hjkjk', 0, 1, '2025-10-15 11:23:10', '2025-10-15 11:23:10', NULL),
(32, 3, 'fit_insight_video', 2, NULL, 'Nice blog', 0, 1, '2025-10-30 10:33:21', '2025-10-30 10:33:21', NULL),
(33, 3, 'fit_insight_video', 2, NULL, 'ertyg', 0, 1, '2025-10-30 12:02:35', '2025-10-30 12:02:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_type` varchar(255) NOT NULL DEFAULT 'AppModelsCommunityPost',
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `user_id`, `post_type`, `post_id`, `created_at`, `updated_at`) VALUES
(2, 8, 'App\\Models\\CommunityPost', 1, '2025-08-18 18:13:03', '2025-08-18 18:13:03'),
(3, 19, 'fit_flix_video', 1, '2025-08-26 20:33:13', '2025-08-26 20:33:13'),
(5, 8, 'fit_flix_video', 1, '2025-09-03 13:17:43', '2025-09-03 13:17:43'),
(14, 3, 'abc', 1, '2025-09-16 09:55:10', '2025-09-16 09:55:10'),
(47, 18, 'fit_flix_video', 1, '2025-09-18 13:45:44', '2025-09-18 13:45:44'),
(61, 3, 'fit_guide_video', 24, '2025-09-26 06:37:59', '2025-09-26 06:37:59'),
(64, 3, 'fit_news_video', 1, '2025-09-26 06:46:48', '2025-09-26 06:46:48'),
(68, 10, 'fit_flix_video', 3, '2025-09-26 10:14:43', '2025-09-26 10:14:43'),
(77, 3, 'App\\Models\\CommunityPost', 4, '2025-09-26 14:24:14', '2025-09-26 14:24:14'),
(78, 3, 'fit_cast_video', 1, '2025-09-29 05:43:47', '2025-09-29 05:43:47'),
(81, 3, 'App\\Models\\CommunityPost', 5, '2025-09-29 15:48:56', '2025-09-29 15:48:56'),
(86, 15, 'fit_live_video', 10, '2025-09-30 09:10:55', '2025-09-30 09:10:55'),
(91, 15, 'fit_flix_video', 1, '2025-09-30 11:47:21', '2025-09-30 11:47:21'),
(93, 15, 'fit_cast_video', 1, '2025-09-30 13:57:42', '2025-09-30 13:57:42'),
(94, 10, 'fit_flix_video', 6, '2025-10-03 18:36:13', '2025-10-03 18:36:13'),
(95, 3, 'fit_flix_video', 9, '2025-10-09 18:14:20', '2025-10-09 18:14:20'),
(96, 3, 'fit_flix_video', 6, '2025-10-14 14:23:40', '2025-10-14 14:23:40'),
(98, 40, 'fit_flix_video', 16, '2025-10-30 11:16:16', '2025-10-30 11:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `referral_codes`
--

CREATE TABLE `referral_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `max_usage` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral_codes`
--

INSERT INTO `referral_codes` (`id`, `user_id`, `code`, `usage_count`, `max_usage`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 6, 'LOXEI1IF', 0, NULL, 1, NULL, '2025-07-01 20:05:06', '2025-07-01 20:05:06'),
(2, 1, 'ADM1', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(3, 2, 'INS2', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(4, 3, 'REG3', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(5, 4, 'SAR4', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(6, 5, 'MAR5', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(7, 7, 'RUS7', 0, NULL, 1, NULL, '2025-07-01 20:23:31', '2025-07-01 20:23:31'),
(8, 8, 'JOH8', 0, NULL, 1, NULL, '2025-07-02 14:52:59', '2025-07-02 14:52:59'),
(9, 9, 'TES9', 0, NULL, 1, NULL, '2025-07-02 19:00:56', '2025-07-02 19:00:56'),
(10, 10, 'ADM10', 0, NULL, 1, NULL, '2025-07-22 16:34:33', '2025-07-22 16:34:33'),
(11, 11, 'JOH11', 0, NULL, 1, NULL, '2025-08-05 14:19:41', '2025-08-05 14:19:41'),
(12, 12, 'TES12', 0, NULL, 1, NULL, '2025-08-08 20:04:29', '2025-08-08 20:04:29'),
(13, 13, 'JOH13', 0, NULL, 1, NULL, '2025-08-17 08:45:08', '2025-08-17 08:45:08'),
(14, 14, 'JOH14', 0, NULL, 1, NULL, '2025-08-17 08:54:24', '2025-08-17 08:54:24'),
(15, 15, 'JOH15', 0, NULL, 1, NULL, '2025-08-17 10:32:59', '2025-08-17 10:32:59'),
(16, 16, 'TES16', 0, NULL, 1, NULL, '2025-08-18 12:59:24', '2025-08-18 12:59:24'),
(17, 17, 'FIT17', 0, NULL, 1, NULL, '2025-08-18 13:11:06', '2025-08-18 13:11:06'),
(18, 19, 'JAN19', 0, NULL, 1, NULL, '2025-08-26 19:21:31', '2025-08-26 19:21:31'),
(19, 20, 'ALE20', 0, NULL, 1, NULL, '2025-08-26 20:35:04', '2025-08-26 20:35:04'),
(20, 22, 'MIK22', 0, NULL, 1, NULL, '2025-09-03 09:32:41', '2025-09-03 09:32:41'),
(21, 23, 'LIS23', 0, NULL, 1, NULL, '2025-09-03 09:32:41', '2025-09-03 09:32:41'),
(22, 10, 'QUH2WJ0Y', 0, NULL, 1, '2025-12-11 18:30:00', '2025-09-04 15:06:12', '2025-09-04 15:06:12'),
(23, 25, 'INS25', 0, NULL, 1, NULL, '2025-09-10 11:40:42', '2025-09-10 11:40:42'),
(24, 26, 'DAR26', 0, NULL, 1, NULL, '2025-09-17 11:53:48', '2025-09-17 11:53:48'),
(25, 27, 'TES27', 0, NULL, 1, NULL, '2025-10-12 13:52:29', '2025-10-12 13:52:29'),
(26, 28, 'LOP28', 0, NULL, 1, NULL, '2025-10-12 23:24:39', '2025-10-12 23:24:39'),
(27, 29, 'SAU29', 0, NULL, 1, NULL, '2025-10-13 12:39:21', '2025-10-13 12:39:21'),
(28, 30, 'ZAI30', 0, NULL, 1, NULL, '2025-10-13 18:24:19', '2025-10-13 18:24:19'),
(29, 31, 'SHA31', 0, NULL, 1, NULL, '2025-10-14 17:29:47', '2025-10-14 17:29:47'),
(30, 32, 'ZAI32', 0, NULL, 1, NULL, '2025-10-14 18:27:18', '2025-10-14 18:27:18'),
(31, 33, 'HUN33', 0, NULL, 1, NULL, '2025-10-14 21:11:26', '2025-10-14 21:11:26'),
(32, 34, 'RAM34', 0, NULL, 1, NULL, '2025-10-14 21:45:56', '2025-10-14 21:45:56'),
(34, 36, 'DEV36', 0, NULL, 1, NULL, '2025-10-14 23:04:03', '2025-10-14 23:04:03'),
(35, 37, 'TES37', 0, NULL, 1, NULL, '2025-10-15 10:16:32', '2025-10-15 10:16:32'),
(36, 38, 'DAR38', 0, NULL, 1, NULL, '2025-10-15 10:27:35', '2025-10-15 10:27:35'),
(37, 39, 'ZAI39', 0, NULL, 1, NULL, '2025-10-15 11:33:38', '2025-10-15 11:33:38'),
(38, 40, 'DAR40', 0, NULL, 1, NULL, '2025-10-30 11:02:39', '2025-10-30 11:02:39'),
(39, 41, 'RUP41', 0, NULL, 1, NULL, '2025-10-30 11:09:20', '2025-10-30 11:09:20');

-- --------------------------------------------------------

--
-- Table structure for table `referral_usage`
--

CREATE TABLE `referral_usage` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referral_code_id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED NOT NULL,
  `referred_user_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referral_usages`
--

CREATE TABLE `referral_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referral_code_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-06-25 17:57:47', '2025-06-25 17:57:47'),
(2, 'instructor', 'web', '2025-06-25 17:57:47', '2025-06-25 17:57:47'),
(3, 'user', 'web', '2025-06-25 17:57:47', '2025-06-25 17:57:47'),
(4, 'influencer', 'web', '2025-08-26 17:48:12', '2025-08-26 17:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(22, 2),
(23, 2),
(25, 2),
(26, 2),
(15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3E4TsYoGsB7wuu1ngXQHT2QMvUknjqxFN4X888XO', NULL, '66.249.66.164', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUxOZGxEUlRobEx0dEVaTWNqeTE4UmNrTm1FTGRWQzJ4ZWx0UmRWMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vZml0dGVsbHkuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760518602),
('ao5yIazjuhn1Es7TsXatOXpDgt3e91oOrhwLbtA3', NULL, '222.79.103.59', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWhhQnZBWmRrQUJ6SFJSZlNEUTFXTkptVmYyOFBwMnZpTWVaTXJNSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vd3d3LmZpdHRlbGx5LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760511704),
('F3EQok5Or5OzFunxqGorAk8wHznhSXx1MVVvIiaN', NULL, '103.190.190.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieDYyY2hiZ2xiTEV4WG5aMVBEMjVJN1FUUUdaS2VQMjE1TDlYZnY5SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vZml0dGVsbHkuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760517070),
('geC6y0PbsDZO3v96KWnI5NoZPrvXVkoud994PGdE', NULL, '103.81.193.140', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFB1cDB3bG93V200ZUNKMUVCZU5yc3JZbUNOZVJQckd5dnhyYXpoZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vZml0dGVsbHkuY29tIjt9fQ==', 1760514508),
('Krmx3nu6cxKlmI8Jb4yRyJr6Eo3SPooHaTf7ZYbR', 10, '2409:40c2:3152:d4f3:a0cc:a7f5:12c3:dfcb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibDNDczhJSDdiNjJYdXdSblI2UFg3cUhpVUhpSFl3QWZvamJrVVM2eCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU1OiJodHRwczovL2ZpdHRlbGx5LmNvbS9hZG1pbi9maXRsaXZlL3Nlc3Npb25zLzIzNjQvc3RyZWFtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1760518671),
('UGZKDAuzxbeEVjOj8Jwhhl6jaxI3nlx8Bmprnand', 3, '2409:40c2:3152:d4f3:a0cc:a7f5:12c3:dfcb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1N4eXZ3NDJBQ2VBcXZJRFFCWEp5ZGVsbEtZVGxjRXVpN2Fwc3NSaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vZml0dGVsbHkuY29tL2ZpdGxpdmUvc2Vzc2lvbi8yMzY0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1760519575);

-- --------------------------------------------------------

--
-- Table structure for table `static_page`
--

CREATE TABLE `static_page` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_page`
--

INSERT INTO `static_page` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'privacy_policy', 'privacy_policy', NULL, NULL),
(2, 'term_condition', 'term_condition', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_status` varchar(255) NOT NULL,
  `stripe_price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_product` varchar(255) NOT NULL,
  `stripe_price` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `billing_cycle` enum('monthly','quarterly','yearly') NOT NULL DEFAULT 'monthly',
  `billing_cycle_count` int(11) NOT NULL DEFAULT 1,
  `duration_months` int(11) NOT NULL DEFAULT 1,
  `trial_days` int(11) NOT NULL DEFAULT 0,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `restrictions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`restrictions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `slug`, `description`, `price`, `billing_cycle`, `billing_cycle_count`, `duration_months`, `trial_days`, `is_popular`, `is_active`, `sort_order`, `features`, `restrictions`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Basic Monthly', 'basic-monthly', 'Access to all basic fitness content including FitLive sessions and FitNews.', 29.99, 'monthly', 1, 1, 7, 0, 1, 1, '{\"access_fitlive\":true,\"access_fitnews\":true,\"access_fitinsight\":true,\"access_fitguide\":false,\"access_fitdoc\":false,\"max_devices\":2,\"offline_downloads\":false,\"priority_support\":false}', '{\"concurrent_streams\":1,\"download_limit\":0}', '2025-07-01 14:17:59', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(2, 'Premium Monthly', 'premium-monthly', 'Complete access to all fitness content including exclusive FitGuide workouts and FitDoc documentaries.', 49.99, 'monthly', 1, 1, 14, 1, 1, 2, '{\"access_fitlive\":true,\"access_fitnews\":true,\"access_fitinsight\":true,\"access_fitguide\":true,\"access_fitdoc\":true,\"max_devices\":5,\"offline_downloads\":true,\"priority_support\":true}', '{\"concurrent_streams\":3,\"download_limit\":10}', '2025-07-01 14:17:59', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(3, 'Premium Annual', 'premium-annual', 'Complete access to all fitness content with 2 months free. Best value for committed fitness enthusiasts.', 499.99, 'yearly', 1, 1, 14, 0, 1, 3, '{\"access_fitlive\":true,\"access_fitnews\":true,\"access_fitinsight\":true,\"access_fitguide\":true,\"access_fitdoc\":true,\"max_devices\":5,\"offline_downloads\":true,\"priority_support\":true}', '{\"concurrent_streams\":3,\"download_limit\":10}', '2025-07-01 14:17:59', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(4, 'Student Plan', 'student-plan', 'Discounted access for students with verification. Access to basic content.', 19.99, 'monthly', 1, 1, 7, 0, 1, 4, '{\"access_fitlive\":true,\"access_fitnews\":true,\"access_fitinsight\":true,\"access_fitguide\":false,\"access_fitdoc\":false,\"max_devices\":1,\"offline_downloads\":false,\"priority_support\":false}', '{\"concurrent_streams\":1,\"download_limit\":0,\"requires_student_verification\":true}', '2025-07-01 14:17:59', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(5, 'asdasd', 'asdasd', 'aasdasd', 123.00, 'monthly', 1, 1, 0, 1, 1, 0, '[\"asdasd\",\"asdasd\"]', NULL, '2025-07-01 18:08:28', '2025-07-01 18:11:42', '2025-07-01 18:11:42'),
(7, 'asda', 'asda', 'asdasd', 123.00, 'quarterly', 3, 1, 12, 0, 1, 2, '[\"asdasd\",\"asdasd\",\"asd\"]', NULL, '2025-07-01 18:09:19', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(8, 'asdasdasda', 'asdasdasda', 'asdasd', 123.00, 'monthly', 1, 1, 12, 1, 1, 0, '[\"sadsda\",\"asdasd\"]', NULL, '2025-07-01 18:36:28', '2025-07-02 15:57:31', '2025-07-02 15:57:31'),
(14, 'adsqq2', 'ads', 'asdasd', 121.00, 'monthly', 1, 1, 12, 0, 0, 1, '[\"asdasd\"]', NULL, '2025-07-02 19:19:47', '2025-10-13 17:49:48', NULL),
(17, 'Basic Plan (Seeder)', 'basic-monthly-seeder', 'Basic fitness plan', 299.00, 'monthly', 1, 1, 7, 0, 0, 1, '[\"Basic features\"]', '{\"max_devices\":2}', '2025-08-26 17:51:28', '2025-10-13 17:49:56', NULL),
(18, 'Premium Plan (Seeder)', 'premium-monthly-seeder', 'Premium fitness plan', 599.00, 'monthly', 1, 1, 14, 1, 0, 2, '[\"Premium features\"]', '{\"max_devices\":5}', '2025-08-26 17:51:28', '2025-10-13 17:50:25', NULL),
(21, 'Advanced Plan', 'advanced-plan', 'This is a advance plan', 399.00, 'monthly', 1, 1, 30, 1, 0, 6, '[\"asdasd\",\"asdasd\",\"asd\"]', NULL, '2025-09-27 13:22:41', '2025-10-13 17:49:59', NULL),
(22, 'Basic', 'feature', NULL, 199.00, 'monthly', 1, 1, 0, 0, 1, 1, '[\"12 Live Classes \\/ Month\",\"Replay Access (24 hrs)\",\"Fitron Rewards: Limited\",\"FitInsights (Blogs & Tips)\",\"FitSeries: Teasers Only\",\"FitExpert Live: Not Available\",\"FitArena: Not Available\",\"Community Access\",\"Talk to Expert: 25\\/min\",\"1 Device Access\",\"Email Support\",\"VIP Giveaways: X\"]', NULL, '2025-10-13 18:10:31', '2025-10-14 13:18:52', NULL),
(23, 'Standard', 'basic', NULL, 499.00, 'quarterly', 1, 1, 0, 0, 1, 2, '[\"18 Live Classes / Month (54/quarter)\", \"Replay Access (48 hrs)\", \"Fitron Rewards: Standard\", \"FitInsights (Blogs & Tips)\", \"FitSeries: Limited Access\", \"FitExpert Live: Watch Only\", \"FitArena: Selected Events\", \"Community Access\", \"Talk to Expert: ₹25/min\", \"1 Device Access\", \"Email Support\", \"VIP Giveaways: X\"]', NULL, '2025-10-13 18:16:52', '2025-10-14 13:19:20', NULL),
(24, 'Premium', 'standard', NULL, 1399.00, 'yearly', 1, 1, 0, 1, 1, 3, '[\"30 Live Classes / Month (360/year)\", \"Replay Access (30 days)\", \"Fitron Rewards: Enhanced\", \"FitInsights (Blogs & Tips)\", \"FitSeries: Full Access\", \"FitExpert Live: Live Q&A\", \"FitArena: Full Access\", \"Community Access\", \"Talk to Expert: ₹15/min\", \"1 Device Access\", \"Standard Support\", \"VIP Giveaways: Random\"]', NULL, '2025-10-13 18:19:17', '2025-10-14 13:19:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `banner_image` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `banner_image`, `sort_order`, `created_at`, `updated_at`) VALUES
(6, 21, 'Meditation', 'meditation', 'fitlive/banners/Meditation.jpg', 5, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(7, 21, 'Zumba', 'zumba', 'fitlive/banners/Zumba.jpg', 4, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(18, 21, 'Yoga', 'yoga', 'fitlive/banners/Yoga.jpg', 3, '2025-09-26 09:10:45', '2025-09-26 09:10:45'),
(19, 21, 'Strength &  conditioning', 'strength-conditioning', 'fitlive/banners/Strength & Conditioning.jpg', 1, '2025-09-26 09:12:22', '2025-09-26 09:12:22'),
(20, 21, 'HIIT', 'hiit', 'fitlive/banners/HIIT.jpg', 2, '2025-09-26 09:12:42', '2025-09-26 09:12:42'),
(21, 20, 'Fit expert Live', 'fit-expert-live', 'fitlive/banners/Yoga.jpg', 0, '2025-09-29 18:21:47', '2025-09-29 18:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `referral_code` varchar(20) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_available_for_fittalk` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(500) DEFAULT NULL,
  `preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferences`)),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `subscription_required` tinyint(1) NOT NULL DEFAULT 1,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `subscription_status` varchar(255) NOT NULL DEFAULT 'inactive',
  `remember_token` varchar(100) DEFAULT NULL,
  `google2fa_secret` varchar(255) DEFAULT NULL,
  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `recovery_codes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recovery_codes`)),
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `pm_type` varchar(255) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `referral_source` varchar(255) DEFAULT NULL,
  `referred_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referral_code_id` bigint(20) UNSIGNED DEFAULT NULL,
  `influencer_link_id` bigint(20) UNSIGNED DEFAULT NULL,
  `signup_session_id` varchar(255) DEFAULT NULL,
  `signup_ip` varchar(45) DEFAULT NULL,
  `average_rating` varchar(255) DEFAULT NULL,
  `signup_user_agent` varchar(500) DEFAULT NULL,
  `signup_utm_params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`signup_utm_params`)),
  `first_touch_source` varchar(255) DEFAULT NULL,
  `last_touch_source` varchar(255) DEFAULT NULL,
  `first_visit_at` timestamp NULL DEFAULT NULL,
  `visits_before_signup` int(11) NOT NULL DEFAULT 0,
  `referral_bonus_earned` decimal(10,2) NOT NULL DEFAULT 0.00,
  `referral_bonus_given` decimal(10,2) NOT NULL DEFAULT 0.00,
  `current_commission_tier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tier_achieved_at` timestamp NULL DEFAULT NULL,
  `lifetime_commission_earned` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_referrals_made` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `referral_code`, `phone`, `date_of_birth`, `gender`, `bio`, `is_available_for_fittalk`, `avatar`, `preferences`, `email_verified_at`, `password`, `subscription_required`, `subscription_ends_at`, `subscription_status`, `remember_token`, `google2fa_secret`, `google2fa_enabled`, `recovery_codes`, `two_factor_confirmed_at`, `created_at`, `updated_at`, `deleted_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `referral_source`, `referred_by_user_id`, `referral_code_id`, `influencer_link_id`, `signup_session_id`, `signup_ip`, `average_rating`, `signup_user_agent`, `signup_utm_params`, `first_touch_source`, `last_touch_source`, `first_visit_at`, `visits_before_signup`, `referral_bonus_earned`, `referral_bonus_given`, `current_commission_tier_id`, `tier_achieved_at`, `lifetime_commission_earned`, `total_referrals_made`) VALUES
(1, 'Admin User', 'admin@fitlley.com', NULL, NULL, NULL, NULL, NULL, 1, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:47', '$2y$12$w.Ke8M9CLNfM/5GgF5e99eH3rQ3Sm/1udNwkxOeg6aO.MaEMfBSfi', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '2025-06-25 17:57:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(2, 'Instructor User', 'instructor@fitlley.com', NULL, NULL, NULL, NULL, NULL, 1, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:47', '$2y$12$UoAb19xuRf.TIkGcHyOw7ONeanS19pSvZQQsiJeZj/U0tAe1VeynW', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '2025-06-25 17:57:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(3, 'Regular User', 'user@fitlley.com', NULL, '+918975845684', NULL, NULL, NULL, 1, '/storage/app/public/default-profile1.png', '[\"strength_training\",\"cardio\",\"functional_fitness\"]', '2025-06-25 17:57:48', '$2y$12$RhYNSxQxKsXvNwOmR4VQ8e9zIzt90LMXJJQBi.v7IykOCG3TYZe/a', 1, '2025-09-17 18:30:00', 'active', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:48', '2025-07-02 20:19:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(4, 'Sarah Johnson', 'sarah@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:49', '$2y$12$Z8/TzajUBIIxq/gvgflOquMD5k..n5uordmLxpRBbcczqgDpIwdw.', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(5, 'Maria Santos', 'maria@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:49', '$2y$12$vrxd/qyHhQ6ebrahoJqrX.O8STgiqvefj.I362Ot3KIwFXZAsppdi', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(6, 'Mike Chen', 'mike@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:49', '$2y$12$7W.bXwfwKc/Cnq0cT9sBJOc3NiXG0RWcXRW5pL24RkQN.J21GaMiy', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(7, 'Rushab Shirke', 'shirkerushab6@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$ZH6JWgfGEtsg4mDWOGVPkOtMmH2h1m6PfyMZAhbZe2wjXj0A8Bdt2', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-01 16:00:11', '2025-07-01 16:00:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(8, 'John Doe', 'john@example.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$bzCh5k6d5OSFVICjvZfmEORUFQ72T924wJODA/HwNGjvGk5lrOwDS', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-02 14:52:59', '2025-10-01 00:53:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(9, 'Test User', 'test@fittelly.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, '2025-07-02 19:02:01', '$2y$12$9.CQn3Lu/7KuwhIDaRdn7u3ejUqZMGBrw4JKIScsdGhR17eXZphi6', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-02 19:00:56', '2025-07-02 19:02:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(10, 'Admin User', 'admin@fittelly.com', NULL, '+91-9876543214', '1980-01-01', 'male', NULL, 0, '/storage/app/public/default-profile1.png', '[\"all\"]', '2025-08-26 17:53:53', '$2y$12$RhYNSxQxKsXvNwOmR4VQ8e9zIzt90LMXJJQBi.v7IykOCG3TYZe/a', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-22 16:34:32', '2025-08-26 17:53:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(11, 'John Doe', 'abc@example.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$/xYl7hNsXf/I2U73Hec9vOvt9Q2vg8xN376ZnBg8gNDhwNo8HgkNu', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-05 14:19:40', '2025-08-05 14:19:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(12, 'Test User', 'test@example.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$ZIKWTwZVbTyI1rugzFlkCe2ooaL7AaIq2DSRc6FMrRDrNIJu4185a', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-08 20:04:28', '2025-08-08 20:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(13, 'John Doe', 'john1@example.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$UVQs8pGZgxw7Oh2QLsmmIeH0Ho/Xl0GbPFrGula9sqBAZwy/azb82', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 08:45:08', '2025-08-17 08:45:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(14, 'John Doe', 'john2@example.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$nZTkEfIYXDkYBGyKd6zjR.YdZ4Hae.EVKqvljggfMwalamVh74Vva', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 08:54:24', '2025-08-17 08:54:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(15, 'John Doe', 'john3@example.com', NULL, '+1234567890', NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$gfnBzS3SAdirdKITfdLrKuWWeZ0lBeygkM.pY8P2cuTCgF1vET2Xa', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 10:32:58', '2025-08-17 10:32:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(16, 'Test User', 'test@myplans.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$qScKwelgjFhAUmnonSt0Ve1O7oC/v3BgqEuLWxPsq.8yOb5sxx3La', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-18 12:59:23', '2025-08-18 12:59:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(17, 'FitLive Test User', 'test@fitlive.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$IMWbjOpDohXEyUxB6pApi.mzWa2fwHejlFCJfPu11ht6B2mwziQ7m', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-18 13:11:06', '2025-08-18 13:11:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(18, 'John Doe', 'basic.user@fittelly.com', NULL, '+91-9876543210', '1990-05-15', 'male', NULL, 0, '/storage/app/public/default-profile1.png', '[\"yoga\",\"cardio\"]', '2025-08-26 17:53:50', '$2y$12$RhYNSxQxKsXvNwOmR4VQ8e9zIzt90LMXJJQBi.v7IykOCG3TYZe/a', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:52', '2025-08-26 17:53:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(19, 'Jane Smith', 'premium.user@fittelly.com', NULL, '+91-9876543211', '1985-08-22', 'female', NULL, 0, '/storage/app/public/default-profile1.png', '[\"pilates\",\"strength_training\"]', '2025-08-26 17:53:50', '$2y$12$ph0pL3ZtK0pcORnVL9MteOIdGX6JaWJui79XX6vHRPnrRu9ULQpJC', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:53', '2025-08-26 17:53:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(20, 'Alex Johnson', 'influencer1@fittelly.com', NULL, '+91-9876543212', '1992-03-10', 'male', NULL, 0, '/storage/app/public/default-profile1.png', '[\"weightlifting\",\"crossfit\"]', '2025-08-26 17:53:51', '$2y$12$I3asE3L2BHV6S4h93vJC2eh9ck1DUw3VuT1i3ixW8AYsi/KSnfr8i', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(21, 'Sarah Wilson', 'influencer2@fittelly.com', NULL, '+91-9876543213', '1988-11-05', 'female', NULL, 0, '/storage/app/public/default-profile1.png', '[\"yoga\",\"pilates\"]', '2025-08-26 17:53:52', '$2y$12$KSIEcKrl5nrg.ob/XRgQZ.dBLQXHX2cyxqNaYzGBe6RZQ0O2hdJQO', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(22, 'Mike Rodriguez', 'instructor1@fittelly.com', NULL, '+91-9876543215', '1985-07-12', 'male', NULL, 0, '/storage/app/public/default-profile1.png', '[\"strength_training\",\"cardio\",\"functional_fitness\"]', '2025-08-26 17:53:54', '$2y$12$unVUcyw9xlGqmwHcDov/cOR/2Hsaikj8eTgTKs7sYCy2X0KvAPV3W', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:55', '2025-08-26 17:53:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(23, 'Lisa Chen', 'instructor2@fittelly.com', NULL, '+91-9876543216', '1990-02-28', 'female', NULL, 0, '/storage/app/public/default-profile1.png', '[\"yoga\",\"pilates\",\"meditation\",\"nutrition\"]', '2025-08-26 17:53:54', '$2y$12$7H1qRWIX2/0em/CaOt6AQOjFP9vLmWP0KtA6DIVThPI/Ks1NLXL5.', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:55', '2025-08-26 17:53:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(25, 'Instructor User', 'instructor1@fitlley.com', NULL, NULL, NULL, NULL, NULL, 1, '/storage/app/public/default-profile1.png', NULL, '2025-06-25 17:57:47', '$2y$12$UoAb19xuRf.TIkGcHyOw7ONeanS19pSvZQQsiJeZj/U0tAe1VeynW', 1, NULL, 'active', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '2025-06-25 17:57:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(26, 'darshan kondekar', 'darshankondekar01@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '/storage/app/public/default-profile1.png', NULL, NULL, '$2y$12$y7OEHsaVjhwGDvR49sxb9ubyqou9J2oJVWrF.ANIRW5vLaVo8yKvi', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-09-17 11:53:47', '2025-09-17 11:53:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(27, 'Test', 'test@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$UpcXRmd56cc4.U8pank./eLf5XwI.T5q./RuIEPFmF7umUu.nAmQS', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-12 13:52:29', '2025-10-13 14:22:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(28, 'Lopoloifhidwjdwfefee fjedwjdwj ijwhfwdj wfiefwjdwd hwidjwidhwfhwidjiwj hjfhefjhwifhewfiwejj hfiwhfqwjhfqwiefgwiej fittelly.com', 'nomin.momin+347l9@mail.ru', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$W7tRqUEYkOTt/kpJ/NB.l.vzesTkzlL310E/1rUrklC2MLiR3Y7s6', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-12 23:24:38', '2025-10-12 23:24:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(29, 'saurabh sawant', 'sawantsaurabh025@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, '{\"email_notifications\":\"1\",\"push_notifications\":\"1\",\"privacy_profile\":\"public\"}', NULL, '$2y$12$.o4MhYRX9vW8rS3pZ.GiPOWmN7sZmwKNZR/uQpLjr306ZRlBgl.be', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-13 12:39:21', '2025-10-14 12:39:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(30, 'Zaid Shaikh', 'zaid@gmail.com', NULL, '1234567890', '2002-12-12', 'male', NULL, 0, 'profile-pictures/WvcAFLM0EzKcA2VDcKOCPZsjZCeCjI1C2t8oF0y2.png', '{\"email_notifications\":\"1\",\"privacy_profile\":\"public\"}', NULL, '$2y$12$LmdGP.esFLPO9rCEX8x6s.M3SeILCVdQCNL8DCnH/XjE0IdfXIvL6', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-13 18:24:19', '2025-10-14 14:42:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(31, 'Deleted User', 'deleted_31@fittelly.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$xPwMXga4T1L1/fjAP4udceRg5NTZ9aID5CEYG8tcAF1lK9A8gRb2S', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-14 17:29:47', '2025-10-14 18:17:12', '2025-10-14 18:17:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(32, 'Zaid Shaikh', 'digizaid5@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$mN5cFORhVuKOEtJ/US4TBe6dhwipFpGkn.BUVR3woKwAgYwKND4fy', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-14 18:27:18', '2025-10-14 19:27:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(33, 'Hunter', 'hunter@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$598jdJchux2gePoqJDx7.uZGt2epCkwEbhbxSV8iSAuLC2lsvqLva', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-14 21:11:26', '2025-10-14 21:11:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(34, 'Ram', 'ram@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$t7MRP027vwX0yizD6jyn6.TD91RU16gH3NvnIXQMzD6t0gpjWKLGG', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-14 21:45:56', '2025-10-14 21:45:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(36, 'develoepr 298888', 'gucozigu@denipl.net', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-14 23:04:03', '$2y$12$7dMa4VvN3LuQqhE.datiU.M4APaChLkNTPACB26uxGT5R7fM0Ce4u', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-14 23:04:03', '2025-10-14 23:04:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(37, 'Testingg', 'zugalopo@forexzig.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-15 10:16:32', '$2y$12$W28zXggY629M7eKlEt.mK.xNjvrkAEQLwU0uprGXLGyL01jwVu8oa', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-15 10:16:32', '2025-10-15 10:16:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(38, 'darshan kondekar', 'darshankondekar01+5@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-15 10:27:35', '$2y$12$iLNwrN7okKHi5OBzO.44rumvmb1zytqEEqB5KalPj.oQbHc7B/T.S', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-15 10:27:35', '2025-10-15 10:27:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(39, 'Zaid Shiakh', 'shaikhzaid468@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-15 11:33:38', '$2y$12$pWHrkHl/LDy8NrIcaeoHdeOnKXdLYd8Z3skyW0zd56SFikyc3K0Pa', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-15 11:33:38', '2025-10-15 11:33:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(40, 'darshan kondekar', 'darshankondekar01+1@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-30 11:02:39', '$2y$12$VrvtOqbm3WlB/EzOBJBEYOOVyJtoTUmMiVlL8RJ4yV.njOU0BLOCa', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-30 11:02:39', '2025-10-30 11:09:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(41, 'Rupesh Testing', 'thedigiemperor@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-10-30 11:09:20', '$2y$12$CVhYnSg7i5tKxE6mjdG/Gewfg0.Izu1cAlfXFtNzQ/owbQjk9pSEe', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-10-30 11:09:20', '2025-10-30 11:09:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE `user_badges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `badge_id` bigint(20) UNSIGNED NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `achievement_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`achievement_data`)),
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_badges`
--

INSERT INTO `user_badges` (`id`, `user_id`, `badge_id`, `earned_at`, `achievement_data`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 2, 2, '2025-09-16 11:03:53', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_follows`
--

INSERT INTO `user_follows` (`id`, `follower_id`, `following_id`, `created_at`, `updated_at`) VALUES
(5, 3, 14, '2025-09-27 08:53:36', '2025-09-27 08:53:36'),
(6, 3, 8, '2025-09-27 08:55:33', '2025-09-27 08:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_activities`
--

CREATE TABLE `user_login_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_successful` tinyint(1) NOT NULL DEFAULT 1,
  `failure_reason` varchar(255) DEFAULT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `logout_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `body_fat_percentage` decimal(5,2) DEFAULT NULL,
  `chest_measurement` decimal(5,2) DEFAULT NULL,
  `waist_measurement` decimal(5,2) DEFAULT NULL,
  `hips_measurement` decimal(5,2) DEFAULT NULL,
  `arms_measurement` decimal(5,2) DEFAULT NULL,
  `thighs_measurement` decimal(5,2) DEFAULT NULL,
  `interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interests`)),
  `fitness_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fitness_goals`)),
  `specializations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specializations`)),
  `hourly_rate` decimal(8,2) DEFAULT NULL,
  `years_experience` int(11) DEFAULT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education`)),
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`)),
  `activity_level` enum('sedentary','lightly_active','moderately_active','very_active','extremely_active') DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `show_body_stats` tinyint(1) NOT NULL DEFAULT 0,
  `show_goals` tinyint(1) NOT NULL DEFAULT 1,
  `show_interests` tinyint(1) NOT NULL DEFAULT 1,
  `profile_visibility` enum('public','friends','private') NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `height`, `weight`, `body_fat_percentage`, `chest_measurement`, `waist_measurement`, `hips_measurement`, `arms_measurement`, `thighs_measurement`, `interests`, `fitness_goals`, `specializations`, `hourly_rate`, `years_experience`, `languages`, `education`, `certifications`, `activity_level`, `bio`, `location`, `date_of_birth`, `show_body_stats`, `show_goals`, `show_interests`, `profile_visibility`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-08-08 20:04:43', '2025-08-08 20:04:43'),
(2, 8, 175.00, 70.00, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"weight_loss\",\"muscle_gain\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Fitness enthusiast and health coach', NULL, NULL, 1, 1, 1, 'public', '2025-08-11 14:43:18', '2025-08-11 14:43:28'),
(3, 14, 175.00, 70.00, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"weight_loss\",\"muscle_gain\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Fitness enthusiast and health coach', NULL, NULL, 1, 1, 1, 'public', '2025-08-17 10:45:47', '2025-08-17 10:45:51'),
(4, 3, 175.00, 75.00, NULL, 63.00, 23.00, 46.00, 42.00, 36.00, '\"[\\\"h\\\",\\\",\\\",\\\"n\\\"]\"', '[\"weight_loss\",\"muscle_gain\"]', '[\"Computer\"]', 768.00, 4, '[\"Marathi\", \"English\", \"Hindi\"]', '[\"MCA\"]', '[\"AWS\"]', 'very_active', 'Fitness enthusiast and health coach', NULL, NULL, 1, 1, 1, 'public', '2025-09-15 06:53:39', '2025-10-30 11:57:51'),
(5, 30, 175.00, 10.50, 10.00, 0.00, 0.00, 0.00, 10.00, 10.00, '\"[\\\"hjkjk\\\"]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-10-14 12:27:50', '2025-10-14 14:43:33'),
(6, 29, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '\"[\\\"Bodybuilding\\\"]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-10-14 12:38:24', '2025-10-14 12:38:50'),
(7, 38, NULL, 65.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-10-15 10:42:06', '2025-10-15 10:42:11'),
(8, 39, 10.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '\"[\\\"Hi\\\"]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-10-15 11:34:10', '2025-10-15 11:34:34'),
(9, 40, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 'public', '2025-10-30 11:16:44', '2025-10-30 11:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_plan_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_subscription_id` varchar(255) DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `subscription_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`subscription_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`id`, `user_id`, `subscription_plan_id`, `status`, `amount_paid`, `payment_method`, `transaction_id`, `gateway_subscription_id`, `started_at`, `ends_at`, `trial_ends_at`, `cancelled_at`, `subscription_data`, `created_at`, `updated_at`) VALUES
(1, 3, 14, 'active', 10.00, 'admin-manual', 'MANUAL_1751487558', NULL, '2025-07-02 18:30:00', '2025-10-31 18:30:00', NULL, NULL, NULL, '2025-07-02 20:19:18', '2025-07-02 20:19:18'),
(2, 18, 17, 'active', 299.00, 'credit_card', 'TXN_BASIC_1756230772', NULL, '2025-08-26 17:52:52', '2025-09-26 17:52:52', '2025-09-02 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(3, 19, 18, 'active', 599.00, 'upi', 'TXN_PREMIUM_1756230772', NULL, '2025-08-26 17:52:52', '2025-09-26 17:52:52', '2025-09-09 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(4, 20, 18, 'active', 599.00, 'net_banking', 'TXN_PRO_1756230772', NULL, '2025-08-26 17:52:52', '2025-11-26 17:52:52', '2025-09-09 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(5, 21, 18, 'active', 599.00, 'credit_card', 'TXN_ANNUAL_1756230772', NULL, '2025-08-26 17:52:52', '2026-08-26 17:52:52', '2025-09-25 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(6, 18, 14, 'active', 121.00, 'credit_card', 'TXN_BASIC_1756230833', NULL, '2025-08-26 17:53:53', '2025-09-26 17:53:53', '2025-09-02 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(7, 19, 17, 'active', 299.00, 'upi', 'TXN_PREMIUM_1756230833', NULL, '2025-08-26 17:53:53', '2025-09-26 17:53:53', '2025-09-09 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(8, 20, 17, 'active', 299.00, 'net_banking', 'TXN_PRO_1756230833', NULL, '2025-08-26 17:53:53', '2025-11-26 17:53:53', '2025-09-09 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(9, 21, 17, 'active', 299.00, 'credit_card', 'TXN_ANNUAL_1756230833', NULL, '2025-08-26 17:53:53', '2026-08-26 17:53:53', '2025-09-25 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(14, 30, 23, 'active', 499.00, 'razorpay', 'pay_RTImCBQNTUeBDO', 'order_RTIlhQCJXQiNPC', '2025-10-14 14:52:25', '2025-11-14 14:52:25', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTImCBQNTUeBDO\\\",\\\"razorpay_order_id\\\":\\\"order_RTIlhQCJXQiNPC\\\",\\\"razorpay_signature\\\":\\\"70b64dd76d4b23c6d65a211a4d39873445f5e8c452c2f68ac65ab123e0c04aa0\\\",\\\"plan_id\\\":\\\"23\\\",\\\"referral_code\\\":null}\"', '2025-10-14 14:52:25', '2025-10-14 14:52:25'),
(15, 31, 22, 'expired', 199.00, 'razorpay', 'pay_RTLXml35hHvTJe', 'order_RTLX5TGidactro', '2025-10-14 17:34:54', '2025-10-14 18:05:03', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTLXml35hHvTJe\\\",\\\"razorpay_order_id\\\":\\\"order_RTLX5TGidactro\\\",\\\"razorpay_signature\\\":\\\"25c57569880a719de0d932ce3e2b3ed18f1b1fdcc3334632b03a548727c2bfb1\\\",\\\"plan_id\\\":\\\"22\\\",\\\"referral_code\\\":null}\"', '2025-10-14 17:34:54', '2025-10-14 18:05:03'),
(16, 31, 23, 'active', 499.00, 'razorpay', 'pay_RTM3WAbBL2LeIv', 'order_RTM2lu2BPMhNOB', '2025-10-14 18:05:05', '2025-11-14 18:05:05', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTM3WAbBL2LeIv\\\",\\\"razorpay_order_id\\\":\\\"order_RTM2lu2BPMhNOB\\\",\\\"razorpay_signature\\\":\\\"f94733a8f2d8761897313b1ad1a1906aabe7d5284106643653c31fadc751df2e\\\",\\\"plan_id\\\":\\\"23\\\",\\\"referral_code\\\":null}\"', '2025-10-14 18:05:05', '2025-10-14 18:05:05'),
(17, 38, 22, 'active', 199.00, 'razorpay', 'pay_RTcvYVa8KVGp2p', 'order_RTcuX2rQNiKGQT', '2025-10-15 10:35:26', '2025-11-15 10:35:26', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTcvYVa8KVGp2p\\\",\\\"razorpay_order_id\\\":\\\"order_RTcuX2rQNiKGQT\\\",\\\"razorpay_signature\\\":\\\"42dfdbbd25623c9605e085f237c4a19d083ea44baa7ddf8d61c6f0c9e9ca6b6e\\\",\\\"plan_id\\\":\\\"22\\\",\\\"referral_code\\\":null}\"', '2025-10-15 10:35:26', '2025-10-15 10:35:26'),
(18, 39, 22, 'active', 199.00, 'razorpay', 'pay_RTdyKRrBCj9mXV', 'order_RTdxOqvBU0aqC7', '2025-10-15 11:36:49', '2025-11-15 11:36:49', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RTdyKRrBCj9mXV\\\",\\\"razorpay_order_id\\\":\\\"order_RTdxOqvBU0aqC7\\\",\\\"razorpay_signature\\\":\\\"916f9815719d6b0ae67f3bf9d2d613734434ccd788ffcebd361f08e32d2d4fef\\\",\\\"plan_id\\\":\\\"22\\\",\\\"referral_code\\\":null}\"', '2025-10-15 11:36:49', '2025-10-15 11:36:49'),
(19, 40, 22, 'active', 199.00, 'razorpay', 'pay_RZZU2iSmbU0M82', 'order_RZZSG7zOmriU1a', '2025-10-30 11:07:39', '2025-11-30 11:07:39', NULL, NULL, '\"{\\\"razorpay_payment_id\\\":\\\"pay_RZZU2iSmbU0M82\\\",\\\"razorpay_order_id\\\":\\\"order_RZZSG7zOmriU1a\\\",\\\"razorpay_signature\\\":\\\"b1eef3f491bfe86fa710ccf4957ae18f30f42ae2275ec44dababfca74dc29500\\\",\\\"plan_id\\\":\\\"22\\\",\\\"referral_code\\\":null}\"', '2025-10-30 11:07:39', '2025-10-30 11:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_watchlist`
--

CREATE TABLE `user_watchlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `watchable_type` varchar(255) NOT NULL,
  `watchable_id` bigint(20) UNSIGNED NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_watch_progress`
--

CREATE TABLE `user_watch_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `watchable_type` varchar(255) NOT NULL,
  `watchable_id` bigint(20) UNSIGNED NOT NULL,
  `progress_seconds` int(11) NOT NULL DEFAULT 0,
  `duration_seconds` int(11) NOT NULL DEFAULT 0,
  `progress_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `last_watched_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `badges_slug_unique` (`slug`),
  ADD KEY `badges_is_active_type_index` (`is_active`,`type`),
  ADD KEY `badges_sort_order_index` (`sort_order`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_sort_order_name_index` (`sort_order`,`name`),
  ADD KEY `categories_is_active_index` (`is_active`);

--
-- Indexes for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commission_payouts_payout_id_unique` (`payout_id`),
  ADD KEY `commission_payouts_approved_by_foreign` (`approved_by`),
  ADD KEY `commission_payouts_processed_by_foreign` (`processed_by`),
  ADD KEY `commission_payouts_influencer_profile_id_status_index` (`influencer_profile_id`,`status`),
  ADD KEY `commission_payouts_status_requested_at_index` (`status`,`requested_at`),
  ADD KEY `commission_payouts_payout_id_index` (`payout_id`);

--
-- Indexes for table `commission_tiers`
--
ALTER TABLE `commission_tiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commission_tiers_is_active_sort_order_index` (`is_active`,`sort_order`),
  ADD KEY `commission_tiers_sort_order_index` (`sort_order`);

--
-- Indexes for table `community_categories`
--
ALTER TABLE `community_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `community_categories_slug_unique` (`slug`),
  ADD KEY `community_categories_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Indexes for table `community_groups`
--
ALTER TABLE `community_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `community_groups_slug_unique` (`slug`),
  ADD KEY `community_groups_community_category_id_is_active_index` (`community_category_id`,`is_active`),
  ADD KEY `community_groups_admin_user_id_index` (`admin_user_id`);

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_posts_community_category_id_created_at_index` (`community_category_id`,`created_at`),
  ADD KEY `community_posts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `community_posts_community_group_id_created_at_index` (`community_group_id`,`created_at`),
  ADD KEY `community_posts_is_active_created_at_index` (`is_active`,`created_at`),
  ADD KEY `community_posts_is_flagged_created_at_index` (`is_flagged`,`created_at`),
  ADD KEY `community_posts_is_featured_created_at_index` (`is_featured`,`created_at`),
  ADD KEY `community_posts_is_published_created_at_index` (`is_published`,`created_at`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_ratings`
--
ALTER TABLE `content_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_ratings_user_id_ratable_type_ratable_id_unique` (`user_id`,`ratable_type`,`ratable_id`),
  ADD KEY `content_ratings_ratable_type_ratable_id_index` (`ratable_type`,`ratable_id`),
  ADD KEY `content_ratings_ratable_type_ratable_id_rating_index` (`ratable_type`,`ratable_id`,`rating`),
  ADD KEY `content_ratings_rating_index` (`rating`),
  ADD KEY `content_ratings_is_featured_index` (`is_featured`);

--
-- Indexes for table `content_reviews`
--
ALTER TABLE `content_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_user_one_id_user_two_id_unique` (`user_one_id`,`user_two_id`),
  ADD KEY `conversations_user_one_id_last_message_at_index` (`user_one_id`,`last_message_at`),
  ADD KEY `conversations_user_two_id_last_message_at_index` (`user_two_id`,`last_message_at`),
  ADD KEY `conversations_is_accepted_last_message_at_index` (`is_accepted`,`last_message_at`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_subscription_id_foreign` (`subscription_id`),
  ADD KEY `coupon_usages_coupon_id_user_id_index` (`coupon_id`,`user_id`),
  ADD KEY `coupon_usages_used_at_index` (`used_at`);

--
-- Indexes for table `direct_messages`
--
ALTER TABLE `direct_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direct_messages_sender_id_created_at_index` (`sender_id`,`created_at`),
  ADD KEY `direct_messages_receiver_id_created_at_index` (`receiver_id`,`created_at`),
  ADD KEY `direct_messages_sender_id_receiver_id_created_at_index` (`sender_id`,`receiver_id`,`created_at`),
  ADD KEY `direct_messages_is_read_receiver_id_index` (`is_read`,`receiver_id`);

--
-- Indexes for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_coupons_code_unique` (`code`),
  ADD KEY `discount_coupons_created_by_foreign` (`created_by`),
  ADD KEY `discount_coupons_code_is_active_index` (`code`,`is_active`),
  ADD KEY `discount_coupons_expires_at_index` (`expires_at`),
  ADD KEY `discount_coupons_is_active_index` (`is_active`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fg_categories`
--
ALTER TABLE `fg_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fg_categories_slug_unique` (`slug`),
  ADD KEY `fg_categories_slug_index` (`slug`),
  ADD KEY `fg_categories_is_active_index` (`is_active`),
  ADD KEY `fg_categories_sort_order_index` (`sort_order`);

--
-- Indexes for table `fg_series`
--
ALTER TABLE `fg_series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fg_series_slug_unique` (`slug`),
  ADD KEY `fg_series_slug_index` (`slug`),
  ADD KEY `fg_series_is_published_index` (`is_published`),
  ADD KEY `fg_series_fg_category_id_index` (`fg_category_id`),
  ADD KEY `fg_series_fg_sub_category_id_index` (`fg_sub_category_id`),
  ADD KEY `fg_series_release_date_index` (`release_date`),
  ADD KEY `fg_series_is_active_index` (`is_active`);

--
-- Indexes for table `fg_series_episodes`
--
ALTER TABLE `fg_series_episodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fg_series_episodes_fg_series_id_episode_number_unique` (`fg_series_id`,`episode_number`),
  ADD KEY `fg_series_episodes_fg_series_id_episode_number_index` (`fg_series_id`,`episode_number`),
  ADD KEY `fg_series_episodes_is_published_index` (`is_published`),
  ADD KEY `fg_series_episodes_slug_index` (`slug`);

--
-- Indexes for table `fg_singles`
--
ALTER TABLE `fg_singles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fg_singles_slug_unique` (`slug`),
  ADD KEY `fg_singles_slug_index` (`slug`),
  ADD KEY `fg_singles_is_published_index` (`is_published`),
  ADD KEY `fg_singles_fg_category_id_index` (`fg_category_id`),
  ADD KEY `fg_singles_fg_sub_category_id_index` (`fg_sub_category_id`),
  ADD KEY `fg_singles_release_date_index` (`release_date`);

--
-- Indexes for table `fg_sub_categories`
--
ALTER TABLE `fg_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fg_sub_categories_slug_unique` (`slug`),
  ADD KEY `fg_sub_categories_slug_index` (`slug`),
  ADD KEY `fg_sub_categories_is_active_index` (`is_active`),
  ADD KEY `fg_sub_categories_sort_order_index` (`sort_order`),
  ADD KEY `fg_sub_categories_fg_category_id_index` (`fg_category_id`);

--
-- Indexes for table `fitarena_events`
--
ALTER TABLE `fitarena_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fitarena_events_slug_unique` (`slug`),
  ADD KEY `fitarena_events_status_visibility_start_date_index` (`status`,`visibility`,`start_date`),
  ADD KEY `fitarena_events_start_date_end_date_index` (`start_date`,`end_date`),
  ADD KEY `fk_instructor` (`instructor_id`);

--
-- Indexes for table `fitarena_participants`
--
ALTER TABLE `fitarena_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fitarena_participants_user_id_fitarena_session_id_unique` (`user_id`,`fitarena_session_id`),
  ADD KEY `fitarena_participants_user_id_joined_at_index` (`user_id`,`joined_at`),
  ADD KEY `fitarena_participants_fitarena_session_id_joined_at_index` (`fitarena_session_id`,`joined_at`);

--
-- Indexes for table `fitarena_sessions`
--
ALTER TABLE `fitarena_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fitarena_sessions_stage_id_foreign` (`stage_id`),
  ADD KEY `fitarena_sessions_category_id_foreign` (`category_id`),
  ADD KEY `fitarena_sessions_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `fitarena_sessions_event_id_stage_id_scheduled_start_index` (`event_id`,`stage_id`,`scheduled_start`),
  ADD KEY `fitarena_sessions_status_scheduled_start_index` (`status`,`scheduled_start`),
  ADD KEY `fitarena_sessions_event_id_status_index` (`event_id`,`status`);

--
-- Indexes for table `fitarena_stages`
--
ALTER TABLE `fitarena_stages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fitarena_stages_livekit_room_unique` (`livekit_room`),
  ADD KEY `fitarena_stages_event_id_status_index` (`event_id`,`status`),
  ADD KEY `fitarena_stages_event_id_sort_order_index` (`event_id`,`sort_order`);

--
-- Indexes for table `fitlive_chat_messages`
--
ALTER TABLE `fitlive_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fitlive_chat_messages_fitlive_session_id_sent_at_index` (`fitlive_session_id`,`sent_at`),
  ADD KEY `fitlive_chat_messages_user_id_sent_at_index` (`user_id`,`sent_at`);

--
-- Indexes for table `fitlive_sessions`
--
ALTER TABLE `fitlive_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fitlive_sessions_livekit_room_unique` (`livekit_room`),
  ADD KEY `fitlive_sessions_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `fitlive_sessions_status_visibility_scheduled_at_index` (`status`,`visibility`,`scheduled_at`),
  ADD KEY `fitlive_sessions_category_id_status_index` (`category_id`,`status`),
  ADD KEY `fitlive_sessions_instructor_id_status_index` (`instructor_id`,`status`);

--
-- Indexes for table `fittalk_sessions`
--
ALTER TABLE `fittalk_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fittalk_sessions_instructor_id_status_index` (`instructor_id`,`status`),
  ADD KEY `fittalk_sessions_user_id_status_index` (`user_id`,`status`),
  ADD KEY `fittalk_sessions_status_scheduled_at_index` (`status`,`scheduled_at`);

--
-- Indexes for table `fit_casts`
--
ALTER TABLE `fit_casts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fit_casts_instructor_id_foreign` (`instructor_id`),
  ADD KEY `fit_casts_is_active_published_at_index` (`is_active`,`published_at`),
  ADD KEY `fit_casts_is_featured_index` (`is_featured`),
  ADD KEY `fit_casts_category_id_index` (`category_id`);

--
-- Indexes for table `fit_docs`
--
ALTER TABLE `fit_docs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fit_docs_slug_unique` (`slug`),
  ADD KEY `fit_docs_slug_index` (`slug`),
  ADD KEY `fit_docs_type_index` (`type`),
  ADD KEY `fit_docs_is_published_index` (`is_published`),
  ADD KEY `fit_docs_release_date_index` (`release_date`),
  ADD KEY `fit_docs_is_active_index` (`is_active`);

--
-- Indexes for table `fit_doc_episodes`
--
ALTER TABLE `fit_doc_episodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fit_doc_episodes_fit_doc_id_episode_number_unique` (`fit_doc_id`,`episode_number`),
  ADD KEY `fit_doc_episodes_fit_doc_id_episode_number_index` (`fit_doc_id`,`episode_number`),
  ADD KEY `fit_doc_episodes_is_published_index` (`is_published`),
  ADD KEY `fit_doc_episodes_slug_index` (`slug`);

--
-- Indexes for table `fit_flix_shorts`
--
ALTER TABLE `fit_flix_shorts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fit_flix_shorts_slug_unique` (`slug`),
  ADD KEY `fit_flix_shorts_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `fit_flix_shorts_is_published_published_at_index` (`is_published`,`published_at`),
  ADD KEY `fit_flix_shorts_category_id_is_published_index` (`category_id`,`is_published`),
  ADD KEY `fit_flix_shorts_is_featured_is_published_index` (`is_featured`,`is_published`),
  ADD KEY `fit_flix_shorts_views_count_index` (`views_count`),
  ADD KEY `fit_flix_shorts_slug_index` (`slug`),
  ADD KEY `fit_flix_shorts_is_active_index` (`is_active`),
  ADD KEY `fit_flix_shorts_tags_index` (`tags`(768));

--
-- Indexes for table `fit_flix_shorts_categories`
--
ALTER TABLE `fit_flix_shorts_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fit_flix_shorts_categories_slug_unique` (`slug`),
  ADD KEY `fit_flix_shorts_categories_is_active_sort_order_index` (`is_active`,`sort_order`),
  ADD KEY `fit_flix_shorts_categories_slug_index` (`slug`);

--
-- Indexes for table `fit_insights`
--
ALTER TABLE `fit_insights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fit_insights_slug_unique` (`slug`),
  ADD KEY `fit_insights_is_published_published_at_index` (`is_published`,`published_at`),
  ADD KEY `fit_insights_category_id_index` (`category_id`),
  ADD KEY `fit_insights_author_id_index` (`author_id`),
  ADD KEY `fit_insights_slug_index` (`slug`);

--
-- Indexes for table `fit_news`
--
ALTER TABLE `fit_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fit_news_created_by_foreign` (`created_by`),
  ADD KEY `fit_news_is_published_published_at_index` (`is_published`,`published_at`);

--
-- Indexes for table `fi_blogs`
--
ALTER TABLE `fi_blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fi_blogs_slug_unique` (`slug`),
  ADD KEY `fi_blogs_fi_category_id_status_published_at_index` (`fi_category_id`,`status`,`published_at`),
  ADD KEY `fi_blogs_status_is_featured_published_at_index` (`status`,`is_featured`,`published_at`),
  ADD KEY `fi_blogs_status_is_trending_published_at_index` (`status`,`is_trending`,`published_at`),
  ADD KEY `fi_blogs_slug_index` (`slug`),
  ADD KEY `fi_blogs_published_at_index` (`published_at`),
  ADD KEY `fi_blogs_author_id_index` (`author_id`);

--
-- Indexes for table `fi_categories`
--
ALTER TABLE `fi_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fi_categories_slug_unique` (`slug`),
  ADD KEY `fi_categories_is_active_sort_order_index` (`is_active`,`sort_order`),
  ADD KEY `fi_categories_slug_index` (`slug`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friendships_user_id_friend_id_unique` (`user_id`,`friend_id`),
  ADD KEY `friendships_user_id_status_index` (`user_id`,`status`),
  ADD KEY `friendships_friend_id_status_index` (`friend_id`,`status`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_is_active_index` (`is_active`),
  ADD KEY `groups_is_private_index` (`is_private`),
  ADD KEY `groups_creator_id_index` (`creator_id`),
  ADD KEY `groups_category_id_index` (`category_id`),
  ADD KEY `groups_last_activity_at_index` (`last_activity_at`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_members_community_group_id_user_id_unique` (`community_group_id`,`user_id`),
  ADD KEY `group_members_community_group_id_status_index` (`community_group_id`,`status`),
  ADD KEY `group_members_user_id_status_index` (`user_id`,`status`),
  ADD KEY `group_members_group_id_index` (`group_id`);

--
-- Indexes for table `group_messages`
--
ALTER TABLE `group_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_messages_reply_to_id_foreign` (`reply_to_id`),
  ADD KEY `group_messages_group_id_created_at_index` (`group_id`,`created_at`),
  ADD KEY `group_messages_sender_id_created_at_index` (`sender_id`,`created_at`),
  ADD KEY `group_messages_is_read_index` (`is_read`);

--
-- Indexes for table `group_message_reads`
--
ALTER TABLE `group_message_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_message_reads_message_id_user_id_unique` (`message_id`,`user_id`),
  ADD KEY `group_message_reads_user_id_read_at_index` (`user_id`,`read_at`),
  ADD KEY `group_message_reads_message_id_read_at_index` (`message_id`,`read_at`);

--
-- Indexes for table `homepage_heroes`
--
ALTER TABLE `homepage_heroes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homepage_heroes_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Indexes for table `influencer_links`
--
ALTER TABLE `influencer_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `influencer_links_link_code_unique` (`link_code`),
  ADD KEY `influencer_links_link_code_is_active_index` (`link_code`,`is_active`),
  ADD KEY `influencer_links_influencer_profile_id_is_active_index` (`influencer_profile_id`,`is_active`);

--
-- Indexes for table `influencer_link_visits`
--
ALTER TABLE `influencer_link_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `influencer_link_visits_user_id_foreign` (`user_id`),
  ADD KEY `influencer_link_visits_subscription_id_foreign` (`subscription_id`),
  ADD KEY `influencer_link_visits_influencer_link_id_created_at_index` (`influencer_link_id`,`created_at`),
  ADD KEY `influencer_link_visits_session_id_ip_address_index` (`session_id`,`ip_address`),
  ADD KEY `influencer_link_visits_is_converted_converted_at_index` (`is_converted`,`converted_at`),
  ADD KEY `influencer_link_visits_created_at_index` (`created_at`),
  ADD KEY `influencer_link_visits_session_id_index` (`session_id`);

--
-- Indexes for table `influencer_profiles`
--
ALTER TABLE `influencer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `influencer_profiles_approved_by_foreign` (`approved_by`),
  ADD KEY `influencer_profiles_user_id_status_index` (`user_id`,`status`),
  ADD KEY `influencer_profiles_status_application_status_index` (`status`,`application_status`);

--
-- Indexes for table `influencer_sales`
--
ALTER TABLE `influencer_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `influencer_sales_influencer_link_id_foreign` (`influencer_link_id`),
  ADD KEY `influencer_sales_user_subscription_id_foreign` (`user_subscription_id`),
  ADD KEY `influencer_sales_influencer_profile_id_status_index` (`influencer_profile_id`,`status`),
  ADD KEY `influencer_sales_influencer_profile_id_commission_status_index` (`influencer_profile_id`,`commission_status`),
  ADD KEY `influencer_sales_sale_date_status_index` (`sale_date`,`status`),
  ADD KEY `influencer_sales_customer_id_index` (`customer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_transactions_transaction_id_unique` (`transaction_id`),
  ADD KEY `payment_transactions_user_id_status_index` (`user_id`,`status`),
  ADD KEY `payment_transactions_subscription_id_index` (`subscription_id`),
  ADD KEY `payment_transactions_status_index` (`status`),
  ADD KEY `payment_transactions_payment_gateway_index` (`payment_gateway`),
  ADD KEY `payment_transactions_created_at_index` (`created_at`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_community_post_id_created_at_index` (`created_at`),
  ADD KEY `post_comments_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `post_comments_parent_id_created_at_index` (`parent_id`,`created_at`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_post_like` (`user_id`,`post_type`,`post_id`),
  ADD KEY `post_likes_post_type_post_id_index` (`post_type`,`post_id`),
  ADD KEY `post_likes_user_id_post_type_post_id_index` (`user_id`,`post_type`,`post_id`);

--
-- Indexes for table `referral_codes`
--
ALTER TABLE `referral_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_codes_code_unique` (`code`),
  ADD KEY `referral_codes_code_is_active_index` (`code`,`is_active`),
  ADD KEY `referral_codes_user_id_is_active_index` (`user_id`,`is_active`);

--
-- Indexes for table `referral_usage`
--
ALTER TABLE `referral_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referral_usage_subscription_id_foreign` (`subscription_id`),
  ADD KEY `referral_usage_referrer_id_status_index` (`referrer_id`,`status`),
  ADD KEY `referral_usage_referred_user_id_status_index` (`referred_user_id`,`status`),
  ADD KEY `referral_usage_referral_code_id_index` (`referral_code_id`);

--
-- Indexes for table `referral_usages`
--
ALTER TABLE `referral_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referral_usages_user_id_foreign` (`user_id`),
  ADD KEY `referral_usages_referral_code_id_user_id_index` (`referral_code_id`,`user_id`),
  ADD KEY `referral_usages_used_at_index` (`used_at`),
  ADD KEY `referral_usages_subscription_id_index` (`subscription_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `static_page`
--
ALTER TABLE `static_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_plans_slug_unique` (`slug`),
  ADD KEY `subscription_plans_is_active_sort_order_index` (`is_active`,`sort_order`),
  ADD KEY `subscription_plans_slug_index` (`slug`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_category_id_slug_unique` (`category_id`,`slug`),
  ADD KEY `sub_categories_category_id_sort_order_name_index` (`category_id`,`sort_order`,`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_referral_code_unique` (`referral_code`),
  ADD KEY `users_stripe_id_index` (`stripe_id`),
  ADD KEY `users_referral_code_id_foreign` (`referral_code_id`),
  ADD KEY `users_influencer_link_id_foreign` (`influencer_link_id`),
  ADD KEY `users_referral_source_created_at_index` (`referral_source`,`created_at`),
  ADD KEY `users_referred_by_user_id_created_at_index` (`referred_by_user_id`,`created_at`),
  ADD KEY `users_current_commission_tier_id_index` (`current_commission_tier_id`),
  ADD KEY `users_signup_session_id_index` (`signup_session_id`);

--
-- Indexes for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_badges_user_id_badge_id_unique` (`user_id`,`badge_id`),
  ADD KEY `user_badges_user_id_earned_at_index` (`user_id`,`earned_at`),
  ADD KEY `user_badges_badge_id_earned_at_index` (`badge_id`,`earned_at`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_follows_follower_id_following_id_unique` (`follower_id`,`following_id`),
  ADD KEY `user_follows_follower_id_following_id_index` (`follower_id`,`following_id`),
  ADD KEY `user_follows_following_id_foreign` (`following_id`);

--
-- Indexes for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_activities_user_id_login_at_index` (`user_id`,`login_at`),
  ADD KEY `user_login_activities_ip_address_index` (`ip_address`),
  ADD KEY `user_login_activities_is_successful_index` (`is_successful`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_index` (`user_id`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_subscriptions_subscription_plan_id_foreign` (`subscription_plan_id`),
  ADD KEY `user_subscriptions_user_id_status_index` (`user_id`,`status`),
  ADD KEY `user_subscriptions_status_ends_at_index` (`status`,`ends_at`),
  ADD KEY `user_subscriptions_gateway_subscription_id_index` (`gateway_subscription_id`);

--
-- Indexes for table `user_watchlist`
--
ALTER TABLE `user_watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_watchlist_user_id_watchable_type_watchable_id_unique` (`user_id`,`watchable_type`,`watchable_id`),
  ADD KEY `user_watchlist_watchable_type_watchable_id_index` (`watchable_type`,`watchable_id`),
  ADD KEY `user_watchlist_user_id_added_at_index` (`user_id`,`added_at`);

--
-- Indexes for table `user_watch_progress`
--
ALTER TABLE `user_watch_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_watch_progress_user_id_watchable_type_watchable_id_unique` (`user_id`,`watchable_type`,`watchable_id`),
  ADD KEY `user_watch_progress_watchable_type_watchable_id_index` (`watchable_type`,`watchable_id`),
  ADD KEY `user_watch_progress_user_id_last_watched_at_index` (`user_id`,`last_watched_at`),
  ADD KEY `user_watch_progress_user_id_completed_index` (`user_id`,`completed`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission_tiers`
--
ALTER TABLE `commission_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `community_categories`
--
ALTER TABLE `community_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `community_groups`
--
ALTER TABLE `community_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content_ratings`
--
ALTER TABLE `content_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_reviews`
--
ALTER TABLE `content_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_messages`
--
ALTER TABLE `direct_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fg_categories`
--
ALTER TABLE `fg_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fg_series`
--
ALTER TABLE `fg_series`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `fg_series_episodes`
--
ALTER TABLE `fg_series_episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `fg_singles`
--
ALTER TABLE `fg_singles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fg_sub_categories`
--
ALTER TABLE `fg_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fitarena_events`
--
ALTER TABLE `fitarena_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fitarena_participants`
--
ALTER TABLE `fitarena_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fitarena_sessions`
--
ALTER TABLE `fitarena_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fitarena_stages`
--
ALTER TABLE `fitarena_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fitlive_chat_messages`
--
ALTER TABLE `fitlive_chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fitlive_sessions`
--
ALTER TABLE `fitlive_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3000;

--
-- AUTO_INCREMENT for table `fittalk_sessions`
--
ALTER TABLE `fittalk_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fit_casts`
--
ALTER TABLE `fit_casts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fit_docs`
--
ALTER TABLE `fit_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `fit_doc_episodes`
--
ALTER TABLE `fit_doc_episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fit_flix_shorts`
--
ALTER TABLE `fit_flix_shorts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fit_flix_shorts_categories`
--
ALTER TABLE `fit_flix_shorts_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fit_insights`
--
ALTER TABLE `fit_insights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fit_news`
--
ALTER TABLE `fit_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `fi_blogs`
--
ALTER TABLE `fi_blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fi_categories`
--
ALTER TABLE `fi_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_messages`
--
ALTER TABLE `group_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message_reads`
--
ALTER TABLE `group_message_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homepage_heroes`
--
ALTER TABLE `homepage_heroes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `influencer_links`
--
ALTER TABLE `influencer_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `influencer_link_visits`
--
ALTER TABLE `influencer_link_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `influencer_profiles`
--
ALTER TABLE `influencer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `influencer_sales`
--
ALTER TABLE `influencer_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `referral_codes`
--
ALTER TABLE `referral_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `referral_usage`
--
ALTER TABLE `referral_usage`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referral_usages`
--
ALTER TABLE `referral_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `static_page`
--
ALTER TABLE `static_page`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_watchlist`
--
ALTER TABLE `user_watchlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_watch_progress`
--
ALTER TABLE `user_watch_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  ADD CONSTRAINT `commission_payouts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `commission_payouts_influencer_profile_id_foreign` FOREIGN KEY (`influencer_profile_id`) REFERENCES `influencer_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commission_payouts_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `community_groups`
--
ALTER TABLE `community_groups`
  ADD CONSTRAINT `community_groups_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_groups_community_category_id_foreign` FOREIGN KEY (`community_category_id`) REFERENCES `community_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_community_category_id_foreign` FOREIGN KEY (`community_category_id`) REFERENCES `community_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_posts_community_group_id_foreign` FOREIGN KEY (`community_group_id`) REFERENCES `community_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `content_ratings`
--
ALTER TABLE `content_ratings`
  ADD CONSTRAINT `content_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_user_one_id_foreign` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_two_id_foreign` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `discount_coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `direct_messages`
--
ALTER TABLE `direct_messages`
  ADD CONSTRAINT `direct_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `direct_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD CONSTRAINT `discount_coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fg_series`
--
ALTER TABLE `fg_series`
  ADD CONSTRAINT `fg_series_fg_category_id_foreign` FOREIGN KEY (`fg_category_id`) REFERENCES `fg_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fg_series_fg_sub_category_id_foreign` FOREIGN KEY (`fg_sub_category_id`) REFERENCES `fg_sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fg_series_episodes`
--
ALTER TABLE `fg_series_episodes`
  ADD CONSTRAINT `fg_series_episodes_ibfk_1` FOREIGN KEY (`fg_series_id`) REFERENCES `fg_series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fg_singles`
--
ALTER TABLE `fg_singles`
  ADD CONSTRAINT `fg_singles_fg_category_id_foreign` FOREIGN KEY (`fg_category_id`) REFERENCES `fg_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fg_singles_fg_sub_category_id_foreign` FOREIGN KEY (`fg_sub_category_id`) REFERENCES `fg_sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fg_sub_categories`
--
ALTER TABLE `fg_sub_categories`
  ADD CONSTRAINT `fg_sub_categories_fg_category_id_foreign` FOREIGN KEY (`fg_category_id`) REFERENCES `fg_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fitarena_events`
--
ALTER TABLE `fitarena_events`
  ADD CONSTRAINT `fk_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fitarena_participants`
--
ALTER TABLE `fitarena_participants`
  ADD CONSTRAINT `fitarena_participants_fitarena_session_id_foreign` FOREIGN KEY (`fitarena_session_id`) REFERENCES `fitarena_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitarena_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fitarena_sessions`
--
ALTER TABLE `fitarena_sessions`
  ADD CONSTRAINT `fitarena_sessions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fitarena_sessions_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `fitarena_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitarena_sessions_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `fitarena_stages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitarena_sessions_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fitarena_stages`
--
ALTER TABLE `fitarena_stages`
  ADD CONSTRAINT `fitarena_stages_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `fitarena_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fitlive_chat_messages`
--
ALTER TABLE `fitlive_chat_messages`
  ADD CONSTRAINT `fitlive_chat_messages_fitlive_session_id_foreign` FOREIGN KEY (`fitlive_session_id`) REFERENCES `fitlive_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitlive_chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fitlive_sessions`
--
ALTER TABLE `fitlive_sessions`
  ADD CONSTRAINT `fitlive_sessions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitlive_sessions_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fitlive_sessions_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fittalk_sessions`
--
ALTER TABLE `fittalk_sessions`
  ADD CONSTRAINT `fittalk_sessions_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fittalk_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fit_casts`
--
ALTER TABLE `fit_casts`
  ADD CONSTRAINT `fit_casts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fit_casts_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fit_doc_episodes`
--
ALTER TABLE `fit_doc_episodes`
  ADD CONSTRAINT `fit_doc_episodes_fit_doc_id_foreign` FOREIGN KEY (`fit_doc_id`) REFERENCES `fit_docs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fit_flix_shorts`
--
ALTER TABLE `fit_flix_shorts`
  ADD CONSTRAINT `fit_flix_shorts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `fit_flix_shorts_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fit_flix_shorts_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fit_insights`
--
ALTER TABLE `fit_insights`
  ADD CONSTRAINT `fit_insights_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fit_insights_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fit_news`
--
ALTER TABLE `fit_news`
  ADD CONSTRAINT `fit_news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fi_blogs`
--
ALTER TABLE `fi_blogs`
  ADD CONSTRAINT `fi_blogs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fi_blogs_fi_category_id_foreign` FOREIGN KEY (`fi_category_id`) REFERENCES `fi_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friendships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `community_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `groups_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_community_group_id_foreign` FOREIGN KEY (`community_group_id`) REFERENCES `community_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_messages`
--
ALTER TABLE `group_messages`
  ADD CONSTRAINT `group_messages_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_messages_reply_to_id_foreign` FOREIGN KEY (`reply_to_id`) REFERENCES `group_messages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `group_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_message_reads`
--
ALTER TABLE `group_message_reads`
  ADD CONSTRAINT `group_message_reads_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `group_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_message_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `influencer_links`
--
ALTER TABLE `influencer_links`
  ADD CONSTRAINT `influencer_links_influencer_profile_id_foreign` FOREIGN KEY (`influencer_profile_id`) REFERENCES `influencer_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `influencer_link_visits`
--
ALTER TABLE `influencer_link_visits`
  ADD CONSTRAINT `influencer_link_visits_influencer_link_id_foreign` FOREIGN KEY (`influencer_link_id`) REFERENCES `influencer_links` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `influencer_link_visits_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `influencer_link_visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `influencer_profiles`
--
ALTER TABLE `influencer_profiles`
  ADD CONSTRAINT `influencer_profiles_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `influencer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `influencer_sales`
--
ALTER TABLE `influencer_sales`
  ADD CONSTRAINT `influencer_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `influencer_sales_influencer_link_id_foreign` FOREIGN KEY (`influencer_link_id`) REFERENCES `influencer_links` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `influencer_sales_influencer_profile_id_foreign` FOREIGN KEY (`influencer_profile_id`) REFERENCES `influencer_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `influencer_sales_user_subscription_id_foreign` FOREIGN KEY (`user_subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payment_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referral_codes`
--
ALTER TABLE `referral_codes`
  ADD CONSTRAINT `referral_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referral_usage`
--
ALTER TABLE `referral_usage`
  ADD CONSTRAINT `referral_usage_referral_code_id_foreign` FOREIGN KEY (`referral_code_id`) REFERENCES `referral_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referral_usage_referred_user_id_foreign` FOREIGN KEY (`referred_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referral_usage_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referral_usage_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referral_usages`
--
ALTER TABLE `referral_usages`
  ADD CONSTRAINT `referral_usages_referral_code_id_foreign` FOREIGN KEY (`referral_code_id`) REFERENCES `referral_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referral_usages_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `referral_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_current_commission_tier_id_foreign` FOREIGN KEY (`current_commission_tier_id`) REFERENCES `commission_tiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_influencer_link_id_foreign` FOREIGN KEY (`influencer_link_id`) REFERENCES `influencer_links` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_referral_code_id_foreign` FOREIGN KEY (`referral_code_id`) REFERENCES `referral_codes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_referred_by_user_id_foreign` FOREIGN KEY (`referred_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_badges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  ADD CONSTRAINT `user_login_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_watchlist`
--
ALTER TABLE `user_watchlist`
  ADD CONSTRAINT `user_watchlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_watch_progress`
--
ALTER TABLE `user_watch_progress`
  ADD CONSTRAINT `user_watch_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
