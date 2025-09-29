-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 05:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_ott`
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
  `image_path` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3B82F6',
  `criteria` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`criteria`)),
  `type` enum('achievement','milestone','participation','special') NOT NULL DEFAULT 'achievement',
  `points` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Fitness Classes', NULL, NULL, 'fitness-classes', NULL, 'during', 1, 1, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(2, 'Yoga & Meditation', NULL, NULL, 'yoga-meditation', NULL, 'after', 2, 1, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(3, 'Dance Workouts', NULL, NULL, 'dance-workouts', NULL, 'during', 3, 1, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(4, 'Nutrition Talks', NULL, NULL, 'nutrition-talks', NULL, 'during', 4, 1, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(5, 'asdasd', NULL, NULL, 'asdasd', NULL, 'during', 0, 1, NULL, '2025-06-25 18:31:12', '2025-06-25 18:31:12'),
(6, 'dasddas', NULL, NULL, 'dasddas', NULL, 'during', 0, 1, NULL, '2025-08-16 18:40:05', '2025-08-16 18:40:05'),
(7, 'dasddasasda', NULL, NULL, 'dasddasdas', NULL, 'during', 0, 1, NULL, '2025-08-16 18:40:14', '2025-08-16 18:40:14'),
(8, 'Health & Wellness', NULL, NULL, 'health-wellness', 'insight', 'during', 1, 1, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49'),
(9, 'Daily Live', NULL, NULL, 'daily-live', NULL, 'during', 0, 1, NULL, '2025-08-22 12:10:03', '2025-08-22 12:10:03'),
(10, 'asd', NULL, NULL, 'asd', NULL, 'during', 0, 1, NULL, '2025-08-27 14:13:49', '2025-08-27 14:13:49'),
(11, 'Fitness', NULL, NULL, 'fitness', NULL, 'during', 1, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(12, 'Yoga', NULL, NULL, 'yoga', NULL, 'during', 2, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(13, 'HIIT', NULL, NULL, 'hiit', NULL, 'during', 3, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(14, 'Cardio', NULL, NULL, 'cardio', NULL, 'during', 4, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(15, 'Strength Training', NULL, NULL, 'strength-training', NULL, 'during', 5, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(16, 'Nutrition', NULL, NULL, 'nutrition', NULL, 'during', 6, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(17, 'Mental Health', NULL, NULL, 'mental-health', NULL, 'during', 7, 1, NULL, '2025-09-03 13:14:04', '2025-09-03 13:14:04');

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
(1, 'demo 1', 'demo-1', 'asdasd', 'fas fa-folder', '#f7a31a', 1, 0, 0, '2025-08-16 18:49:07', '2025-08-16 18:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `community_groups`
--

CREATE TABLE `community_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `community_category_id` bigint(20) UNSIGNED NOT NULL,
  `admin_user_id` bigint(20) UNSIGNED NOT NULL,
  `max_members` int(11) NOT NULL DEFAULT 1000,
  `members_count` int(11) NOT NULL DEFAULT 0,
  `join_type` enum('open','approval_required','invite_only') NOT NULL DEFAULT 'open',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 13, 1, NULL, 'This is my first community post!', '[]', 1, 5, 0, 0, 0, 'public', 1, 0, NULL, NULL, NULL, 0, 1, '2025-08-17 08:46:03', '2025-09-03 11:25:05', NULL),
(2, 14, 1, NULL, 'This is my first community post!', '[]', 0, 0, 0, 0, 0, 'public', 1, 0, NULL, NULL, NULL, 0, 1, '2025-08-17 08:54:51', '2025-08-17 08:54:51', NULL),
(3, 14, 1, NULL, 'This is my first community post!', '[]', 0, 0, 0, 0, 0, 'public', 1, 0, NULL, NULL, NULL, 0, 1, '2025-08-17 10:44:21', '2025-08-17 10:44:21', NULL),
(4, 8, 1, NULL, 'This is my first community post!', '[]', 0, 0, 0, 0, 0, 'public', 1, 0, NULL, NULL, NULL, 0, 1, '2025-08-18 06:43:51', '2025-08-18 06:43:51', NULL);

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
(1, 'demo 1', 'demo-1', 'asdasd', 0, 1, '2025-07-03 18:47:04', '2025-07-03 18:47:07', NULL);

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

INSERT INTO `fg_series` (`id`, `fg_category_id`, `fg_sub_category_id`, `title`, `slug`, `description`, `language`, `cost`, `release_date`, `total_episodes`, `feedback`, `banner_image_path`, `trailer_type`, `trailer_url`, `trailer_file_path`, `is_published`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Beginner\'s Complete Fitness Journey', 'beginners-complete-fitness-journey', 'A comprehensive 12-week program designed for fitness beginners to build strength, endurance, and healthy habits.', 'English', 199.00, '2024-01-01', 12, 4.80, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:38', '2025-08-26 20:06:38', NULL),
(2, 1, 1, 'Advanced Strength Training Mastery', 'advanced-strength-training-mastery', 'Take your strength training to the next level with advanced techniques and progressive overload principles.', 'English', 299.00, '2024-02-15', 10, 4.90, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:38', '2025-08-26 20:06:39', NULL),
(3, 1, 1, 'Yoga for Flexibility and Peace', 'yoga-for-flexibility-and-peace', 'Discover the transformative power of yoga through guided sessions focusing on flexibility and mental well-being.', 'English', 149.00, '2024-03-01', 8, 4.70, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:39', '2025-08-26 20:06:39', NULL),
(4, 1, 1, 'HIIT Transformation Challenge', 'hiit-transformation-challenge', 'High-intensity interval training program designed to maximize fat loss and improve cardiovascular health.', 'English', 249.00, '2024-04-10', 6, 4.60, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:39', '2025-08-26 20:06:39', NULL),
(5, 1, 1, 'Functional Movement Fundamentals', 'functional-movement-fundamentals', 'Learn essential movement patterns that translate to better performance in daily activities and sports.', 'English', 179.00, '2024-05-05', 9, 4.80, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:39', '2025-08-26 20:06:40', NULL),
(6, 1, 1, 'Nutrition and Meal Planning Mastery', 'nutrition-and-meal-planning-mastery', 'Complete guide to understanding nutrition science and creating sustainable meal plans for your fitness goals.', 'English', 199.00, '2024-06-01', 7, 4.90, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:40', '2025-09-04 14:56:32', NULL),
(7, 1, 1, 'Mindfulness and Meditation for Athletes', 'mindfulness-and-meditation-for-athletes', 'Develop mental resilience and focus through mindfulness practices specifically designed for athletes.', 'English', 129.00, '2024-07-15', 5, 4.50, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:40', '2025-08-26 20:06:40', NULL),
(8, 1, 1, 'Recovery and Injury Prevention', 'recovery-and-injury-prevention', 'Essential strategies for recovery, injury prevention, and maintaining long-term fitness health.', 'English', 169.00, '2024-08-01', 6, 4.70, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-08-26 20:06:40', '2025-08-26 20:06:40', NULL);

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
(1, 1, 'Week 1: Foundation Building', 'week-1-foundation-building', 'Episode 1 of Beginner\'s Complete Fitness Journey: Week 1: Foundation Building', 1, 23, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(2, 1, 'Week 2: Basic Strength Training', 'week-2-basic-strength-training', 'Episode 2 of Beginner\'s Complete Fitness Journey: Week 2: Basic Strength Training', 2, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(3, 1, 'Week 3: Cardio Introduction', 'week-3-cardio-introduction', 'Episode 3 of Beginner\'s Complete Fitness Journey: Week 3: Cardio Introduction', 3, 58, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(4, 1, 'Week 4: Flexibility Focus', 'week-4-flexibility-focus', 'Episode 4 of Beginner\'s Complete Fitness Journey: Week 4: Flexibility Focus', 4, 24, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(5, 1, 'Week 5: Compound Movements', 'week-5-compound-movements', 'Episode 5 of Beginner\'s Complete Fitness Journey: Week 5: Compound Movements', 5, 45, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(6, 1, 'Week 6: Endurance Building', 'week-6-endurance-building', 'Episode 6 of Beginner\'s Complete Fitness Journey: Week 6: Endurance Building', 6, 28, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(7, 1, 'Week 7: Core Strengthening', 'week-7-core-strengthening', 'Episode 7 of Beginner\'s Complete Fitness Journey: Week 7: Core Strengthening', 7, 55, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(8, 1, 'Week 8: Balance and Coordination', 'week-8-balance-and-coordination', 'Episode 8 of Beginner\'s Complete Fitness Journey: Week 8: Balance and Coordination', 8, 38, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(9, 1, 'Week 9: Progressive Overload', 'week-9-progressive-overload', 'Episode 9 of Beginner\'s Complete Fitness Journey: Week 9: Progressive Overload', 9, 39, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(10, 1, 'Week 10: Advanced Techniques', 'week-10-advanced-techniques', 'Episode 10 of Beginner\'s Complete Fitness Journey: Week 10: Advanced Techniques', 10, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(11, 1, 'Week 11: Goal Setting', 'week-11-goal-setting', 'Episode 11 of Beginner\'s Complete Fitness Journey: Week 11: Goal Setting', 11, 37, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(12, 1, 'Week 12: Maintenance and Beyond', 'week-12-maintenance-and-beyond', 'Episode 12 of Beginner\'s Complete Fitness Journey: Week 12: Maintenance and Beyond', 12, 32, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(13, 2, 'Progressive Overload Principles', 'progressive-overload-principles', 'Episode 1 of Advanced Strength Training Mastery: Progressive Overload Principles', 1, 30, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:38', '2025-08-26 20:07:05', NULL),
(14, 2, 'Periodization Strategies', 'periodization-strategies', 'Episode 2 of Advanced Strength Training Mastery: Periodization Strategies', 2, 41, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(15, 2, 'Advanced Compound Movements', 'advanced-compound-movements', 'Episode 3 of Advanced Strength Training Mastery: Advanced Compound Movements', 3, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(16, 2, 'Accessory Exercise Selection', 'accessory-exercise-selection', 'Episode 4 of Advanced Strength Training Mastery: Accessory Exercise Selection', 4, 25, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(17, 2, 'Recovery and Deload Weeks', 'recovery-and-deload-weeks', 'Episode 5 of Advanced Strength Training Mastery: Recovery and Deload Weeks', 5, 37, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(18, 2, 'Competition Preparation', 'competition-preparation', 'Episode 6 of Advanced Strength Training Mastery: Competition Preparation', 6, 53, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(19, 2, 'Plateau Breaking Techniques', 'plateau-breaking-techniques', 'Episode 7 of Advanced Strength Training Mastery: Plateau Breaking Techniques', 7, 48, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(20, 2, 'Advanced Programming', 'advanced-programming', 'Episode 8 of Advanced Strength Training Mastery: Advanced Programming', 8, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(21, 2, 'Injury Prevention Strategies', 'injury-prevention-strategies', 'Episode 9 of Advanced Strength Training Mastery: Injury Prevention Strategies', 9, 27, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(22, 2, 'Peak Performance Protocols', 'peak-performance-protocols', 'Episode 10 of Advanced Strength Training Mastery: Peak Performance Protocols', 10, 39, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(23, 3, 'Foundation Poses and Breathing', 'foundation-poses-and-breathing', 'Episode 1 of Yoga for Flexibility and Peace: Foundation Poses and Breathing', 1, 20, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(24, 3, 'Sun Salutation Sequences', 'sun-salutation-sequences', 'Episode 2 of Yoga for Flexibility and Peace: Sun Salutation Sequences', 2, 55, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(25, 3, 'Hip Opening Flow', 'hip-opening-flow', 'Episode 3 of Yoga for Flexibility and Peace: Hip Opening Flow', 3, 33, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:06:39', NULL),
(26, 3, 'Backbend Progression', 'backbend-progression', 'Episode 4 of Yoga for Flexibility and Peace: Backbend Progression', 4, 37, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(27, 3, 'Arm Balance Fundamentals', 'arm-balance-fundamentals', 'Episode 5 of Yoga for Flexibility and Peace: Arm Balance Fundamentals', 5, 55, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(28, 3, 'Restorative Yoga Practice', 'restorative-yoga-practice', 'Episode 6 of Yoga for Flexibility and Peace: Restorative Yoga Practice', 6, 35, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(29, 3, 'Meditation and Mindfulness', 'meditation-and-mindfulness', 'Episode 7 of Yoga for Flexibility and Peace: Meditation and Mindfulness', 7, 22, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(30, 3, 'Advanced Flow Sequences', 'advanced-flow-sequences', 'Episode 8 of Yoga for Flexibility and Peace: Advanced Flow Sequences', 8, 58, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(31, 4, 'Episode 1: HIIT Transformation Challenge', 'episode-1-hiit-transformation-challenge', 'Episode 1 of HIIT Transformation Challenge: Episode 1: HIIT Transformation Challenge', 1, 41, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(32, 4, 'Episode 2: HIIT Transformation Challenge', 'episode-2-hiit-transformation-challenge', 'Episode 2 of HIIT Transformation Challenge: Episode 2: HIIT Transformation Challenge', 2, 59, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(33, 4, 'Episode 3: HIIT Transformation Challenge', 'episode-3-hiit-transformation-challenge', 'Episode 3 of HIIT Transformation Challenge: Episode 3: HIIT Transformation Challenge', 3, 25, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(34, 4, 'Episode 4: HIIT Transformation Challenge', 'episode-4-hiit-transformation-challenge', 'Episode 4 of HIIT Transformation Challenge: Episode 4: HIIT Transformation Challenge', 4, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(35, 4, 'Episode 5: HIIT Transformation Challenge', 'episode-5-hiit-transformation-challenge', 'Episode 5 of HIIT Transformation Challenge: Episode 5: HIIT Transformation Challenge', 5, 58, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(36, 4, 'Episode 6: HIIT Transformation Challenge', 'episode-6-hiit-transformation-challenge', 'Episode 6 of HIIT Transformation Challenge: Episode 6: HIIT Transformation Challenge', 6, 25, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(37, 5, 'Episode 1: Functional Movement Fundamentals', 'episode-1-functional-movement-fundamentals', 'Episode 1 of Functional Movement Fundamentals: Episode 1: Functional Movement Fundamentals', 1, 52, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(38, 5, 'Episode 2: Functional Movement Fundamentals', 'episode-2-functional-movement-fundamentals', 'Episode 2 of Functional Movement Fundamentals: Episode 2: Functional Movement Fundamentals', 2, 21, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:39', '2025-08-26 20:07:05', NULL),
(39, 5, 'Episode 3: Functional Movement Fundamentals', 'episode-3-functional-movement-fundamentals', 'Episode 3 of Functional Movement Fundamentals: Episode 3: Functional Movement Fundamentals', 3, 26, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(40, 5, 'Episode 4: Functional Movement Fundamentals', 'episode-4-functional-movement-fundamentals', 'Episode 4 of Functional Movement Fundamentals: Episode 4: Functional Movement Fundamentals', 4, 53, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(41, 5, 'Episode 5: Functional Movement Fundamentals', 'episode-5-functional-movement-fundamentals', 'Episode 5 of Functional Movement Fundamentals: Episode 5: Functional Movement Fundamentals', 5, 30, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(42, 5, 'Episode 6: Functional Movement Fundamentals', 'episode-6-functional-movement-fundamentals', 'Episode 6 of Functional Movement Fundamentals: Episode 6: Functional Movement Fundamentals', 6, 30, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(43, 5, 'Episode 7: Functional Movement Fundamentals', 'episode-7-functional-movement-fundamentals', 'Episode 7 of Functional Movement Fundamentals: Episode 7: Functional Movement Fundamentals', 7, 58, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(44, 5, 'Episode 8: Functional Movement Fundamentals', 'episode-8-functional-movement-fundamentals', 'Episode 8 of Functional Movement Fundamentals: Episode 8: Functional Movement Fundamentals', 8, 41, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(45, 5, 'Episode 9: Functional Movement Fundamentals', 'episode-9-functional-movement-fundamentals', 'Episode 9 of Functional Movement Fundamentals: Episode 9: Functional Movement Fundamentals', 9, 28, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(46, 6, 'Episode 1: Nutrition and Meal Planning Mastery', 'episode-1-nutrition-and-meal-planning-mastery', 'Episode 1 of Nutrition and Meal Planning Mastery: Episode 1: Nutrition and Meal Planning Mastery', 1, 51, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(47, 6, 'Episode 2: Nutrition and Meal Planning Mastery', 'episode-2-nutrition-and-meal-planning-mastery', 'Episode 2 of Nutrition and Meal Planning Mastery: Episode 2: Nutrition and Meal Planning Mastery', 2, 56, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(48, 6, 'Episode 3: Nutrition and Meal Planning Mastery', 'episode-3-nutrition-and-meal-planning-mastery', 'Episode 3 of Nutrition and Meal Planning Mastery: Episode 3: Nutrition and Meal Planning Mastery', 3, 39, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(49, 6, 'Episode 4: Nutrition and Meal Planning Mastery', 'episode-4-nutrition-and-meal-planning-mastery', 'Episode 4 of Nutrition and Meal Planning Mastery: Episode 4: Nutrition and Meal Planning Mastery', 4, 60, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(50, 6, 'Episode 5: Nutrition and Meal Planning Mastery', 'episode-5-nutrition-and-meal-planning-mastery', 'Episode 5 of Nutrition and Meal Planning Mastery: Episode 5: Nutrition and Meal Planning Mastery', 5, 30, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(51, 6, 'Episode 6: Nutrition and Meal Planning Mastery', 'episode-6-nutrition-and-meal-planning-mastery', 'Episode 6 of Nutrition and Meal Planning Mastery: Episode 6: Nutrition and Meal Planning Mastery', 6, 21, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(52, 6, 'Episode 7: Nutrition and Meal Planning Mastery', 'episode-7-nutrition-and-meal-planning-mastery', 'Episode 7 of Nutrition and Meal Planning Mastery: Episode 7: Nutrition and Meal Planning Mastery', 7, 25, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(53, 7, 'Episode 1: Mindfulness and Meditation for Athletes', 'episode-1-mindfulness-and-meditation-for-athletes', 'Episode 1 of Mindfulness and Meditation for Athletes: Episode 1: Mindfulness and Meditation for Athletes', 1, 31, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(54, 7, 'Episode 2: Mindfulness and Meditation for Athletes', 'episode-2-mindfulness-and-meditation-for-athletes', 'Episode 2 of Mindfulness and Meditation for Athletes: Episode 2: Mindfulness and Meditation for Athletes', 2, 36, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(55, 7, 'Episode 3: Mindfulness and Meditation for Athletes', 'episode-3-mindfulness-and-meditation-for-athletes', 'Episode 3 of Mindfulness and Meditation for Athletes: Episode 3: Mindfulness and Meditation for Athletes', 3, 34, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(56, 7, 'Episode 4: Mindfulness and Meditation for Athletes', 'episode-4-mindfulness-and-meditation-for-athletes', 'Episode 4 of Mindfulness and Meditation for Athletes: Episode 4: Mindfulness and Meditation for Athletes', 4, 54, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(57, 7, 'Episode 5: Mindfulness and Meditation for Athletes', 'episode-5-mindfulness-and-meditation-for-athletes', 'Episode 5 of Mindfulness and Meditation for Athletes: Episode 5: Mindfulness and Meditation for Athletes', 5, 25, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(58, 8, 'Episode 1: Recovery and Injury Prevention', 'episode-1-recovery-and-injury-prevention', 'Episode 1 of Recovery and Injury Prevention: Episode 1: Recovery and Injury Prevention', 1, 55, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(59, 8, 'Episode 2: Recovery and Injury Prevention', 'episode-2-recovery-and-injury-prevention', 'Episode 2 of Recovery and Injury Prevention: Episode 2: Recovery and Injury Prevention', 2, 27, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(60, 8, 'Episode 3: Recovery and Injury Prevention', 'episode-3-recovery-and-injury-prevention', 'Episode 3 of Recovery and Injury Prevention: Episode 3: Recovery and Injury Prevention', 3, 43, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(61, 8, 'Episode 4: Recovery and Injury Prevention', 'episode-4-recovery-and-injury-prevention', 'Episode 4 of Recovery and Injury Prevention: Episode 4: Recovery and Injury Prevention', 4, 55, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(62, 8, 'Episode 5: Recovery and Injury Prevention', 'episode-5-recovery-and-injury-prevention', 'Episode 5 of Recovery and Injury Prevention: Episode 5: Recovery and Injury Prevention', 5, 39, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:05', NULL),
(63, 8, 'Episode 6: Recovery and Injury Prevention', 'episode-6-recovery-and-injury-prevention', 'Episode 6 of Recovery and Injury Prevention: Episode 6: Recovery and Injury Prevention', 6, 45, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, '2025-08-26 20:06:40', '2025-08-26 20:07:06', NULL);

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
(1, 1, 1, 'asdasd', 'asdasd', 'asdasd', 'english', 0.00, '2025-07-04', 21, NULL, 'fitguide/banners/6k9c0PCgQXvwtUYeRQWZ60tm8ImPksT3QvXrn4k3.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, 'youtube', 'https://www.youtube.com/shorts/fFDs6nMY8QU', NULL, 1, '2025-07-03 18:48:16', '2025-07-03 18:48:19', NULL),
(2, 1, NULL, 'asdasd', 'asdasdas', 'asdadsadas', 'english', 0.00, '2025-08-19', 21, 5.00, NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, '2025-08-16 18:43:27', '2025-08-16 18:43:27', NULL),
(3, 1, 1, 'asdasd', 'asdasdasas', 'asdadsadas', 'english', 0.00, '2025-08-19', 21, 5.00, NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, '2025-08-16 18:44:07', '2025-08-16 18:44:07', NULL);

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
(1, 1, 'demo 1 sc', 'demo-1-sc', NULL, 0, 1, '2025-07-03 18:47:33', '2025-07-03 18:47:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fitarena_events`
--

CREATE TABLE `fitarena_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `status` enum('upcoming','live','ended') NOT NULL DEFAULT 'upcoming',
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `dvr_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `dvr_hours` int(11) NOT NULL DEFAULT 24,
  `organizers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`organizers`)),
  `schedule_overview` text DEFAULT NULL,
  `expected_viewers` int(11) NOT NULL DEFAULT 0,
  `peak_viewers` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fitarena_events`
--

INSERT INTO `fitarena_events` (`id`, `title`, `description`, `slug`, `start_date`, `end_date`, `banner_image`, `logo`, `location`, `status`, `visibility`, `dvr_enabled`, `dvr_hours`, `organizers`, `schedule_overview`, `expected_viewers`, `peak_viewers`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Global Fitness Expo 2025', 'The world\'s largest fitness and wellness expo featuring top experts, innovative equipment, and breakthrough fitness methodologies.', 'global-fitness-expo-2025', '2025-08-07', '2025-08-10', NULL, NULL, 'Las Vegas Convention Center, Nevada, USA', 'upcoming', 'public', 1, 48, '[{\"name\":\"FitExpo International\",\"role\":\"Main Organizer\"},{\"name\":\"Wellness World\",\"role\":\"Co-Organizer\"}]', NULL, 50000, 0, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(2, 'Yoga Masters Summit', 'A transformative 2-day summit bringing together the world\'s most renowned yoga masters and wellness experts.', 'yoga-masters-summit', '2025-07-23', '2025-07-24', NULL, NULL, 'Rishikesh, India (Virtual)', 'upcoming', 'public', 1, 72, '[{\"name\":\"International Yoga Alliance\",\"role\":\"Organizer\"}]', NULL, 25000, 0, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(3, 'CrossFit Games Qualifier', 'Regional CrossFit competition featuring the best athletes competing for a spot in the CrossFit Games.', 'crossfit-games-qualifier', '2025-07-03', '2025-07-10', NULL, NULL, 'Madison, Wisconsin, USA', 'live', 'public', 1, 24, '[{\"name\":\"CrossFit Inc.\",\"role\":\"Organizer\"}]', NULL, 75000, 45000, 0, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(4, 'Summer Fitness Challenge 2024', 'A 7-day intensive fitness challenge featuring top trainers from around the world.', 'summer-fitness-challenge-2024', '2025-09-05', '2025-09-12', 'https://picsum.photos/800/400?random=1', NULL, 'Virtual - Global', 'upcoming', 'public', 1, 24, '[{\"name\":\"FitArena Team\",\"role\":\"Event Host\"},{\"name\":\"Mike Fitness Pro\",\"role\":\"Lead Trainer\"}]', NULL, 5000, 0, 1, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(5, 'Live Yoga Marathon', '24-hour continuous yoga sessions with different instructors.', 'live-yoga-marathon', '2025-09-02', '2025-09-04', 'https://picsum.photos/800/400?random=2', NULL, 'Virtual - Worldwide', 'live', 'public', 1, 24, '[{\"name\":\"Zen Masters\",\"role\":\"Yoga Collective\"}]', NULL, 3000, 2500, 1, '2025-09-03 13:14:04', '2025-09-03 13:14:04'),
(6, 'HIIT Championship', 'High-intensity interval training competition with cash prizes.', 'hiit-championship', '2025-09-10', '2025-09-11', 'https://picsum.photos/800/400?random=3', NULL, 'Virtual Arena', 'upcoming', 'public', 1, 24, '[{\"name\":\"HIIT Masters\",\"role\":\"Competition Organizer\"}]', NULL, 8000, 0, 0, '2025-09-03 13:14:04', '2025-09-03 13:14:04');

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
(1, 1, 1, NULL, NULL, 'Opening Keynote: The Future of Fitness', 'Industry leaders discuss emerging trends and technologies shaping the future of fitness.', '[{\"name\":\"Dr. Sarah Johnson\",\"title\":\"Fitness Technology Expert\",\"bio\":\"Leading researcher in fitness technology and biomechanics\"},{\"name\":\"Mark Thompson\",\"title\":\"CEO, FitTech Global\",\"bio\":\"20+ years experience in fitness industry innovation\"}]', '2025-08-07 09:00:00', '2025-08-07 10:30:00', NULL, NULL, 'scheduled', 'keynote', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(2, 1, 1, NULL, NULL, 'Panel: Sustainable Fitness Business Models', 'Expert panel discussing sustainable and profitable fitness business strategies.', '[{\"name\":\"Lisa Chen\",\"title\":\"Gym Chain Owner\"},{\"name\":\"David Rodriguez\",\"title\":\"Fitness Consultant\"},{\"name\":\"Emma Wilson\",\"title\":\"Digital Fitness Entrepreneur\"}]', '2025-08-07 11:00:00', '2025-08-07 12:30:00', NULL, NULL, 'scheduled', 'panel', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(3, 1, 2, NULL, NULL, 'AI in Personal Training', 'Exploring how artificial intelligence is revolutionizing personal training.', '[{\"name\":\"Dr. Alex Kim\",\"title\":\"AI Researcher\",\"bio\":\"Specialist in AI applications for health and fitness\"}]', '2025-08-07 10:00:00', '2025-08-07 11:00:00', NULL, NULL, 'scheduled', 'presentation', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(4, 2, 5, NULL, NULL, 'Sunrise Hatha Yoga Flow', 'Traditional Hatha yoga practice led by master yogis from India.', '[{\"name\":\"Guru Ravindra\",\"title\":\"Yoga Master\",\"bio\":\"40+ years of yoga practice and teaching\"}]', '2025-07-23 06:00:00', '2025-07-23 07:30:00', NULL, NULL, 'scheduled', 'workshop', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(5, 3, 7, 1, NULL, 'Event 1: Sprint Ladder', 'Athletes compete in a high-intensity sprint ladder challenge.', '[{\"name\":\"Competition Judges\",\"title\":\"Official Judges\"}]', '2025-07-03 09:00:00', '2025-07-03 11:00:00', NULL, NULL, 'live', 'competition', NULL, 1, 'pending', NULL, NULL, 0, 0, NULL, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01');

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
(1, 1, 'Main Stage', 'Primary stage featuring keynote speakers and major presentations', '#d4ab00', 10000, 'fitarena.1UT8Dzfmcy', 'stage_jVVYI0BiYeaW0m75', NULL, NULL, 'scheduled', 1, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(2, 1, 'Innovation Hub', 'Showcasing the latest fitness technology and equipment', '#ff6b35', 5000, 'fitarena.nkmJmjzehQ', 'stage_qsBrbp82s07eI0TU', NULL, NULL, 'scheduled', 0, 2, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(3, 1, 'Wellness Workshop', 'Interactive workshops and hands-on training sessions', '#4ecdc4', 3000, 'fitarena.iWV74cAFcz', 'stage_i86mbfRTlpxsoV07', NULL, NULL, 'scheduled', 0, 3, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(4, 1, 'Nutrition Corner', 'Expert talks on nutrition, diet, and healthy eating', '#95e1d3', 2000, 'fitarena.u99RxGhBWn', 'stage_2X5J7FCW7EzPdzas', NULL, NULL, 'scheduled', 0, 4, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(5, 2, 'Serenity Stage', 'Main stage for yoga sessions and master classes', '#8b5a3c', 8000, 'fitarena.zMSU1NwCE4', 'stage_Lj4Sh7okVyFCu3T2', NULL, NULL, 'scheduled', 1, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(6, 2, 'Meditation Garden', 'Peaceful space for meditation and mindfulness sessions', '#6ab04c', 3000, 'fitarena.4zOIEU8W3Z', 'stage_4lNDTp7pSSoD0t8l', NULL, NULL, 'scheduled', 0, 2, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(7, 3, 'Arena Floor', 'Main competition floor with live CrossFit events', '#e74c3c', 15000, 'fitarena.y9hvXI5zN3', 'stage_1v6auBueohTXh5jr', NULL, NULL, 'live', 1, 1, '2025-07-07 18:32:01', '2025-07-07 18:32:01'),
(8, 3, 'Training Zone', 'Warm-up and training area coverage', '#3498db', 5000, 'fitarena.8xzY0kIOuL', 'stage_ISZE1NCputi7BaaA', NULL, NULL, 'live', 0, 2, '2025-07-07 18:32:01', '2025-07-07 18:32:01');

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
(1, 4, 2, 'asdasd', 1, '2025-06-25 18:35:03', NULL, NULL),
(2, 5, 2, 'asdas', 1, '2025-06-26 09:44:12', NULL, NULL),
(3, 5, 2, 'asdas', 1, '2025-06-26 09:44:14', NULL, NULL);

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
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `status` enum('scheduled','live','ended') NOT NULL DEFAULT 'scheduled',
  `chat_mode` enum('during','after','off') NOT NULL DEFAULT 'during',
  `livekit_room` varchar(255) DEFAULT NULL,
  `hls_url` varchar(255) DEFAULT NULL,
  `mp4_path` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `viewer_peak` int(11) NOT NULL DEFAULT 0,
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

INSERT INTO `fitlive_sessions` (`id`, `category_id`, `sub_category_id`, `instructor_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `status`, `chat_mode`, `livekit_room`, `hls_url`, `mp4_path`, `banner_image`, `viewer_peak`, `visibility`, `recording_enabled`, `recording_id`, `recording_url`, `recording_status`, `recording_duration`, `recording_file_size`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 'Morning HIIT Blast', 'Start your day with an energizing 30-minute HIIT workout', '2025-06-26 02:30:00', NULL, NULL, 'scheduled', 'during', 'fitlive.morning-hiit-1750874269', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(2, 2, 4, 5, 'Evening Relaxation Yoga', 'Gentle yoga flow to help you unwind and relax', '2025-06-27 13:30:00', NULL, NULL, 'scheduled', 'after', 'fitlive.evening-yoga-1750874269', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(3, 1, 1, 6, 'Lunch Break HIIT', 'Quick and effective 20-minute HIIT session', '2025-06-28 07:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.lunch-hiit-1750874269', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(4, 5, NULL, 2, 'asd', 'asd', '2025-06-25 18:35:00', '2025-06-25 18:33:11', '2025-06-25 18:39:50', 'ended', 'during', 'fitlive.5GeaTToxRY', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-25 18:32:06', '2025-06-25 18:39:50'),
(5, 5, 11, 2, 'adasdasdads', 'asdsdasd', '2025-06-27 09:41:00', '2025-06-26 09:44:09', '2025-06-26 09:50:56', 'ended', 'during', 'fitlive.0dndTjoik3', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-26 09:41:12', '2025-06-26 09:50:56'),
(6, 7, 12, 6, 'asdasdas', 'dasdasd', '2025-08-17 19:46:00', NULL, NULL, 'scheduled', 'during', 'fitlive.SJcFaqO35J', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-08-16 18:41:24', '2025-08-16 18:41:24'),
(7, 7, 11, 2, 'Morning Yoga Flow', 'Start your day with energizing yoga poses and breathing exercises.', '2024-08-30 00:30:00', NULL, NULL, 'scheduled', 'during', 'fitlive.CZTHonw0VR', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(8, 8, 11, 22, 'HIIT Cardio Blast', 'High-intensity interval training to boost your metabolism.', '2024-08-30 02:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.A6ATT20QR3', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(9, 4, 9, 5, 'Strength Training Fundamentals', 'Learn proper form and technique for basic strength exercises.', '2024-08-30 03:30:00', NULL, NULL, 'scheduled', 'during', 'fitlive.6ZqIcJciXy', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(10, 7, 2, 23, 'Pilates Core Power', 'Strengthen your core with targeted Pilates movements.', '2024-08-30 05:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.PedmvDu3c5', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(11, 7, 8, 4, 'Functional Movement Patterns', 'Master everyday movements for better daily life performance.', '2024-08-30 06:30:00', NULL, NULL, 'scheduled', 'during', 'fitlive.IKlJ6M3GY5', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(12, 4, 5, 23, 'Lunch Break Stretch', 'Quick stretching session perfect for your lunch break.', '2024-08-30 07:30:00', NULL, NULL, 'scheduled', 'during', 'fitlive.3LwmDehq7r', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(13, 6, 8, 5, 'CrossFit WOD', 'Workout of the Day featuring varied functional movements.', '2024-08-30 09:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.3prGiur5Yf', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(14, 6, 1, 6, 'Mindful Meditation', 'Guided meditation session for mental clarity and relaxation.', '2024-08-30 10:30:00', NULL, NULL, 'scheduled', '', 'fitlive.yJmKCZR0kn', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(15, 3, 9, 23, 'Dance Fitness Party', 'Fun dance workout combining cardio with popular music.', '2024-08-30 12:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.LgCwVMJLny', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(16, 1, 2, 4, 'Olympic Weightlifting', 'Learn the technical lifts: snatch and clean & jerk.', '2024-08-30 13:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.YWP6ah55O5', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(17, 8, 10, 6, 'Evening Yoga Restore', 'Gentle restorative yoga to unwind after a long day.', '2024-08-30 14:15:00', NULL, NULL, 'scheduled', 'during', 'fitlive.ZI1xunC8cJ', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(18, 7, 3, 5, 'Bodyweight Bootcamp', 'No equipment needed - full body workout using bodyweight.', '2024-08-30 15:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.RSwp1GzLAq', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(19, 3, 8, 2, 'Flexibility & Mobility', 'Improve your range of motion and joint health.', '2024-08-30 15:45:00', NULL, NULL, 'scheduled', 'during', 'fitlive.RhHGZnJ0uc', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:04'),
(20, 8, 4, 23, 'Late Night Calm Flow', 'Gentle movements to prepare your body for sleep.', '2024-08-30 16:30:00', NULL, NULL, 'scheduled', '', 'fitlive.alO4Uq6yEU', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:05'),
(21, 5, 1, 5, 'Nutrition Q&A Session', 'Interactive session about nutrition and healthy eating habits.', '2024-08-30 10:00:00', NULL, NULL, 'scheduled', 'during', 'fitlive.IPxj2xl4Vu', NULL, NULL, NULL, 0, 'public', 1, NULL, NULL, NULL, NULL, NULL, '2025-08-26 20:06:22', '2025-08-26 20:07:05'),
(22, 11, NULL, 1, 'Expert Nutrition Masterclass', 'Advanced nutrition strategies with certified nutritionist.', '2025-09-03 15:14:34', NULL, NULL, 'scheduled', 'during', 'fitlive.yQi4ShonaZ', NULL, NULL, 'https://picsum.photos/600/300?random=4', 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-03 13:14:34', '2025-09-03 13:14:34'),
(23, 11, NULL, 1, 'Advanced Strength Training Techniques', 'Professional strength training methods for advanced athletes.', '2025-09-04 13:14:34', NULL, NULL, 'scheduled', 'during', 'fitlive.WlXVkwGiXN', NULL, NULL, 'https://picsum.photos/600/300?random=5', 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-03 13:14:34', '2025-09-03 13:14:34'),
(24, 12, NULL, 1, 'Beginner Yoga Flow Guide', 'Complete beginner guide to yoga flow sequences.', '2025-08-27 13:14:34', '2025-08-27 13:14:34', '2025-08-27 14:14:34', 'ended', 'during', 'fitlive.JrVTyHfBvo', NULL, '/storage/recordings/yoga-guide-1.mp4', 'https://picsum.photos/600/300?random=6', 0, 'public', 1, NULL, 'https://example.com/recordings/yoga-guide-1.mp4', NULL, NULL, NULL, '2025-09-03 13:14:34', '2025-09-03 13:14:34'),
(25, 12, NULL, 1, 'Core Strength Building Guide', 'Step-by-step guide to building core strength.', '2025-08-29 13:14:34', '2025-08-29 13:14:34', '2025-08-29 13:59:34', 'ended', 'during', 'fitlive.7lUFvgux3W', NULL, '/storage/recordings/core-guide-1.mp4', 'https://picsum.photos/600/300?random=7', 0, 'public', 1, NULL, 'https://example.com/recordings/core-guide-1.mp4', NULL, NULL, NULL, '2025-09-03 13:14:34', '2025-09-03 13:14:34'),
(26, 12, NULL, 1, 'Flexibility and Mobility Guide', 'Comprehensive guide to improving flexibility and mobility.', '2025-08-31 13:14:34', '2025-08-31 13:14:34', '2025-08-31 14:04:34', 'ended', 'during', 'fitlive.34vCpEI1CS', NULL, '/storage/recordings/flexibility-guide-1.mp4', 'https://picsum.photos/600/300?random=8', 0, 'public', 1, NULL, 'https://example.com/recordings/flexibility-guide-1.mp4', NULL, NULL, NULL, '2025-09-03 13:14:34', '2025-09-03 13:14:34'),
(27, 5, NULL, 2, 'asdasdasd', 'asdasd', '2025-12-12 04:42:00', '2025-09-04 14:52:43', '2025-09-04 14:53:41', 'ended', 'during', 'fitlive.al3qU60DkE', NULL, NULL, NULL, 0, 'public', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-04 14:52:37', '2025-09-04 14:53:41');

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
  `status` enum('scheduled','active','completed','cancelled') NOT NULL DEFAULT 'scheduled',
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
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_casts`
--

INSERT INTO `fit_casts` (`id`, `title`, `description`, `thumbnail`, `video_url`, `duration`, `category_id`, `instructor_id`, `is_active`, `is_featured`, `views_count`, `likes_count`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '10-Minute Morning Energy Boost', 'Quick morning routine to energize your day with dynamic movements and stretches.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 10, 5, 22, 1, 1, 1785, 190, '2025-08-16 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(2, 'Full Body HIIT Workout', 'Intense 20-minute high-intensity interval training session for maximum calorie burn.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 20, 3, 4, 1, 0, 6801, 276, '2025-08-18 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(3, 'Beginner Yoga Flow', 'Gentle 15-minute yoga sequence perfect for beginners to improve flexibility.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 15, 7, 5, 1, 1, 3660, 175, '2025-08-22 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(4, 'Core Strength Challenge', 'Targeted core workout to build abdominal strength and stability in just 12 minutes.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 12, 9, 4, 1, 0, 2015, 443, '2025-08-14 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(5, 'Upper Body Strength Training', 'Build upper body strength with this comprehensive 25-minute workout routine.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 25, 3, 23, 1, 1, 5367, 414, '2025-08-22 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(6, 'Cardio Dance Party', 'Fun and energetic dance workout that will get your heart pumping and spirits high.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 18, 5, 6, 1, 0, 3991, 650, '2025-08-01 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(7, 'Lower Body Power Workout', 'Strengthen your legs and glutes with this intense lower body training session.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 22, 4, 2, 1, 1, 2417, 291, '2025-08-11 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(8, 'Flexibility and Mobility', 'Improve your range of motion and reduce muscle tension with these mobility exercises.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 14, 8, 2, 1, 0, 1347, 180, '2025-08-04 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(9, 'Pilates Core Fusion', 'Combine Pilates principles with core strengthening for a balanced workout.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 16, 7, 5, 1, 1, 2558, 349, '2025-07-31 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(10, 'Functional Movement Training', 'Learn movement patterns that translate to better performance in daily activities.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 19, 6, 2, 1, 0, 2370, 275, '2025-08-25 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(11, 'Meditation and Mindfulness', 'Guided meditation session to reduce stress and improve mental clarity.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 12, 9, 4, 1, 1, 2979, 633, '2025-08-16 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(12, 'Recovery and Stretching', 'Essential recovery routine to help your muscles heal and prevent injury.', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 13, 7, 4, 1, 0, 1991, 196, '2025-08-10 20:07:06', '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL);

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
(1, 'Test Single Video', 'test-single-video', 'single', 'This is a test single video', 'english', 0.00, '2025-06-25', 45, NULL, NULL, NULL, NULL, NULL, NULL, 'youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 1, 1, '2025-06-25 18:07:27', '2025-06-25 18:07:27', NULL),
(2, 'Test Series', 'test-series', 'series', 'This is a test series', 'english', 9.99, '2025-06-25', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 18:07:37', '2025-07-03 18:52:28', NULL),
(3, 'Test', 'test', 'single', 'Test', 'English', 0.00, '2024-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 18:18:49', '2025-07-03 18:32:07', NULL),
(4, 'asda', 'asda', 'single', 'adas', 'english', 0.00, '2025-06-26', 12, NULL, NULL, 'fitdoc/banners/rxfFVW6Fz4QzmZOEI7oXryRy1ibJPP5OnkxflvMQ.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, 1, '2025-06-25 19:42:44', '2025-06-25 19:42:50', NULL),
(5, 'qweqw', 'qweqw', 'series', 'qweqwe', 'english', 0.00, '2025-06-26', NULL, 12, NULL, 'fitdoc/banners/SpEKmbiKGDzMCmcLGlnshj2AXP7siWc4sljUi0EY.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 19:43:20', '2025-07-03 18:52:26', NULL),
(6, 'asdasda', 'asdasda', 'series', 'sasdasda', 'english', 0.00, '2025-06-26', NULL, 1, NULL, 'fitdoc/banners/pvA2qC5hgpnxpeITRH0bLwd9INUO4laZjBBP2gzy.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, NULL, NULL, NULL, 1, 1, '2025-06-25 20:00:53', '2025-07-03 18:52:27', NULL),
(7, 'demo1', 'demo1', 'single', 'asdad', 'english', 0.00, '2025-07-04', 12, NULL, NULL, 'fitdoc/banners/yuQKx2gQRz2z5fUPJ8HlCnXgWKeSsuglSC0UkkJN.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, 1, '2025-07-03 18:31:37', '2025-07-03 18:31:37', NULL),
(8, 'demo2', 'demo2', 'single', 'asdasd', 'english', 0.00, '2025-07-04', 12, NULL, NULL, 'fitdoc/banners/SZEMII0tHTJ1WZN1tz7OxjjVXRd2gNnmwlA97qXS.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, 1, '2025-07-03 18:32:51', '2025-07-03 18:32:51', NULL),
(9, 'demo series', 'demo-series', 'series', 'asdasd', 'english', 0.00, '2025-07-04', NULL, 0, NULL, 'fitdoc/banners/YCPeZD5CxYwKBjlrSyj7Lr1azArCMWW37z3UDzFv.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, NULL, NULL, NULL, 1, 1, '2025-07-03 18:53:13', '2025-07-03 18:53:43', NULL),
(10, 'asd', 'asd', 'series', 'asd', 'english', 0.00, '2025-08-17', NULL, 1, NULL, 'fitdoc/banners/asgQpGyP01mSST63AV5nFpEMZM5Zj13l5qf6nSFp.jpg', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, NULL, NULL, NULL, 0, 1, '2025-08-16 18:45:03', '2025-08-16 18:46:16', NULL),
(11, 'asdas', 'asdas', 'single', 'dadsd', 'spanish', 0.00, '2025-09-05', 12, NULL, NULL, 'fitdoc/banners/QcFnSO4ER0STjvAJFqLrcolkxO4YH6fXvpArcJvo.png', 'youtube', 'https://youtu.be/r6tZXSHVlO4', NULL, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 1, 1, '2025-09-04 14:50:20', '2025-09-04 14:50:20', NULL);

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
(1, 6, 'qweq', 'qweq', 'eqweq', 1, 12, 'youtube', 'https://www.youtube.com/watch?v=2D-rr4gv3fk', NULL, 1, '2025-06-25 20:03:52', '2025-06-25 20:03:52', NULL),
(2, 6, 'sadasd', 'sadasd', 'asdasd', 2, 12, 'youtube', 'https://www.youtube.com/watch?v=2D-rr4gv3fk', NULL, 1, '2025-06-25 20:13:29', '2025-06-25 20:13:29', NULL),
(3, 9, 'asdasd', 'asdasd', 'asdasd', 1, 12, 'youtube', 'https://www.youtube.com/shorts/fFDs6nMY8QU', NULL, 0, '2025-07-03 18:53:43', '2025-07-03 18:53:43', NULL),
(4, 10, 'ep1', 'ep1', 'asdasd', 1, 12, 'youtube', 'https://www.youtube.com/watch?v=2D-rr4gv3fk', NULL, 0, '2025-08-16 18:45:34', '2025-08-16 18:45:34', NULL),
(5, 10, 'ep2', 'ep2', 'asdasd', 2, 21, 'youtube', 'https://youtu.be/uNFGn3BUygg?si=wSdN2WaSp17XL4ac', NULL, 0, '2025-08-16 18:46:16', '2025-08-16 18:46:16', NULL);

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
(1, 0, 'sedefgsdf', 'sedefgsdf', 'sdfsdfsdf', 1, 1, 'community/fitflix-shorts/videos/NN694hpyZcaivCPF2AzZTu24af93dMESZWVtcCgc.mp4', 'community/fitflix-shorts/thumbnails/zyFMpsZx4QkjbOtG0USYEmzQdovCApfR9ZrJXjwY.jpg', 60, 1130057, 'mp4', 1080, 1920, 5, 2, 1, 1, 1, 1, '2025-07-22 00:17:13', NULL, NULL, NULL, NULL, '2025-07-21 18:47:13', '2025-09-03 13:18:09');

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
(1, 'demo 1', 'demo-1', 'asdasd', 'fas fa-mobile-alt', '#f7a31a', 'community/fitflix-shorts/categories/banners/3SsQAXtySpKII7XKQAxX1mVmAfCcEqRwfPRVNYvR.jpg', 0, 1, '2025-07-21 18:45:55', '2025-07-21 18:45:55');

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
(1, '10 Essential Tips for a Healthy Lifestyle', '10-essential-tips-for-a-healthy-lifestyle', 'Discover the fundamental principles of maintaining a healthy and balanced lifestyle.', 'Living a healthy lifestyle is more than just eating right and exercising. It encompasses a holistic approach to wellness that includes mental health, proper sleep, stress management, and building meaningful relationships. In this comprehensive guide, we will explore ten essential tips that can transform your daily routine and help you achieve optimal health and wellness.', NULL, 8, 1, 1, '2025-08-01 09:38:49', 269, 20, 31, 19, 5, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(2, 'The Science Behind Effective Workouts', 'the-science-behind-effective-workouts', 'Understanding the physiological principles that make workouts truly effective.', 'Exercise science has evolved significantly over the past decades, providing us with valuable insights into how our bodies respond to different types of physical activity. This article delves into the scientific principles behind effective workouts, including the role of progressive overload, the importance of recovery, and how to optimize your training for maximum results.', NULL, 8, 1, 1, '2025-08-13 09:38:49', 900, 18, 13, 2, 8, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(3, 'Nutrition Myths Debunked: What Really Works', 'nutrition-myths-debunked-what-really-works', 'Separating fact from fiction in the world of nutrition and diet advice.', 'The nutrition industry is filled with conflicting advice and misleading claims. From fad diets to miracle supplements, it can be challenging to distinguish between evidence-based recommendations and marketing hype. This article examines common nutrition myths and provides science-backed insights into what truly works for optimal health and performance.', NULL, 8, 1, 1, '2025-07-28 09:38:49', 880, 56, 32, 9, 6, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(4, 'Mental Health and Physical Fitness: The Connection', 'mental-health-and-physical-fitness-the-connection', 'Exploring the powerful relationship between mental well-being and physical activity.', 'The connection between mental health and physical fitness is profound and well-documented. Regular exercise has been shown to reduce symptoms of depression and anxiety, improve cognitive function, and enhance overall quality of life. This article explores the mechanisms behind this connection and provides practical strategies for using physical activity to support mental wellness.', NULL, 8, 1, 1, '2025-08-05 09:38:49', 238, 100, 26, 10, 7, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(5, 'Building Sustainable Fitness Habits', 'building-sustainable-fitness-habits', 'Learn how to create lasting fitness routines that stick for the long term.', 'Creating sustainable fitness habits is one of the biggest challenges people face when trying to improve their health. Many start with enthusiasm but struggle to maintain consistency over time. This guide provides evidence-based strategies for building fitness habits that last, including goal setting, habit stacking, and overcoming common obstacles.', NULL, 8, 1, 1, '2025-07-29 09:38:49', 609, 60, 36, 16, 4, NULL, '2025-08-18 09:38:49', '2025-08-18 09:38:49', NULL),
(6, 'The Science Behind Progressive Overload', 'the-science-behind-progressive-overload', 'Understanding how progressive overload drives muscle growth and strength gains.', 'Progressive overload is the fundamental principle that drives all fitness adaptations. This comprehensive guide explores the science behind why gradually increasing training demands leads to improved performance, muscle growth, and strength gains. We\'ll cover practical applications, common mistakes, and how to implement progressive overload in your training routine.', NULL, 3, 23, 1, '2025-08-19 20:07:06', 1002, 156, 0, 94, 8, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(7, '10 Common Nutrition Myths Debunked', '10-common-nutrition-myths-debunked', 'Separating fact from fiction in the world of fitness nutrition.', 'The fitness industry is filled with nutrition myths that can derail your progress. From the myth that eating fat makes you fat to the belief that you need to eat every 2 hours to boost metabolism, we\'ll examine the science behind these claims and provide evidence-based recommendations for optimal nutrition.', NULL, 3, 6, 1, '2025-08-18 20:07:06', 776, 337, 0, 97, 12, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(8, 'Building Mental Resilience Through Fitness', 'building-mental-resilience-through-fitness', 'How physical training can strengthen your mental fortitude.', 'Physical fitness and mental resilience are deeply interconnected. This article explores how challenging workouts, goal setting, and overcoming physical barriers translate to improved mental toughness in all areas of life. Learn practical strategies to build both physical and mental strength simultaneously.', NULL, 6, 4, 1, '2025-08-23 20:07:06', 2736, 155, 0, 20, 10, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(9, 'The Ultimate Guide to Recovery and Sleep', 'the-ultimate-guide-to-recovery-and-sleep', 'Maximizing your gains through proper recovery protocols.', 'Recovery is where the magic happens. While training provides the stimulus for adaptation, it\'s during recovery that your body actually gets stronger. This comprehensive guide covers sleep optimization, active recovery techniques, nutrition for recovery, and how to structure your training to maximize adaptation.', NULL, 7, 6, 1, '2025-08-15 20:07:06', 3524, 299, 0, 82, 15, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(10, 'Functional Movement Patterns for Daily Life', 'functional-movement-patterns-for-daily-life', 'Training movements that translate to real-world activities.', 'Functional fitness focuses on training movement patterns that directly translate to daily activities and sports performance. Learn about the seven fundamental movement patterns, how to assess your movement quality, and exercises to improve functional strength and mobility.', NULL, 1, 6, 1, '2025-08-24 20:07:06', 2637, 397, 0, 76, 9, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(11, 'Understanding Your Metabolism: Facts vs Fiction', 'understanding-your-metabolism-facts-vs-fiction', 'The truth about metabolic rate and weight management.', 'Metabolism is one of the most misunderstood aspects of fitness and weight management. This article breaks down the components of metabolic rate, factors that influence it, and evidence-based strategies for optimizing your metabolism for your goals.', NULL, 3, 2, 1, '2025-08-16 20:07:06', 2731, 351, 0, 75, 11, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(12, 'The Psychology of Habit Formation in Fitness', 'the-psychology-of-habit-formation-in-fitness', 'How to build lasting fitness habits that stick.', 'Creating lasting change requires understanding the psychology of habit formation. This article explores the habit loop, how to design your environment for success, and practical strategies for building sustainable fitness habits that become second nature.', NULL, 8, 22, 1, '2025-08-09 20:07:06', 1653, 397, 0, 23, 7, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(13, 'Injury Prevention: A Proactive Approach', 'injury-prevention-a-proactive-approach', 'Strategies to stay healthy and injury-free in your fitness journey.', 'Prevention is always better than cure when it comes to injuries. This comprehensive guide covers movement screening, proper warm-up protocols, load management, and recovery strategies to keep you training consistently and injury-free.', NULL, 1, 4, 1, '2025-08-13 20:07:06', 4654, 497, 0, 90, 13, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(14, 'The Role of Hydration in Athletic Performance', 'the-role-of-hydration-in-athletic-performance', 'How proper hydration impacts your training and recovery.', 'Hydration plays a crucial role in athletic performance, yet it\'s often overlooked. Learn about fluid balance, electrolyte needs, hydration strategies for different training conditions, and how to optimize your hydration for peak performance.', NULL, 2, 23, 1, '2025-08-13 20:07:06', 1952, 223, 0, 22, 6, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(15, 'Strength Training for Beginners: A Complete Guide', 'strength-training-for-beginners-a-complete-guide', 'Everything you need to know to start your strength training journey.', 'Starting a strength training program can be intimidating, but it doesn\'t have to be. This beginner-friendly guide covers basic principles, essential exercises, program design, safety considerations, and how to progress systematically.', NULL, 8, 6, 1, '2025-08-18 20:07:06', 1611, 414, 0, 36, 14, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(16, 'The Mind-Muscle Connection: Science and Application', 'the-mind-muscle-connection-science-and-application', 'How focusing on muscle activation can improve your training.', 'The mind-muscle connection is more than just a bodybuilding concept. Research shows that focusing on the target muscle during exercise can improve activation and potentially enhance training outcomes. Learn how to develop and apply this skill.', NULL, 2, 5, 1, '2025-08-03 20:07:06', 2676, 439, 0, 95, 8, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(17, 'Periodization: Planning Your Training for Success', 'periodization-planning-your-training-for-success', 'How to structure your training for optimal long-term progress.', 'Periodization is the systematic planning of athletic training. This article covers different periodization models, how to plan training phases, and how to adjust your program based on your goals and life circumstances.', NULL, 1, 2, 1, '2025-08-09 20:07:06', 1268, 313, 0, 84, 12, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(18, 'Flexibility vs Mobility: Understanding the Difference', 'flexibility-vs-mobility-understanding-the-difference', 'Why both flexibility and mobility matter for optimal movement.', 'Flexibility and mobility are often used interchangeably, but they\'re different qualities that both contribute to optimal movement. Learn the distinctions, how to assess each, and targeted strategies for improvement.', NULL, 6, 22, 1, '2025-08-21 20:07:06', 3419, 469, 0, 99, 9, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(19, 'The Science of Muscle Protein Synthesis', 'the-science-of-muscle-protein-synthesis', 'Understanding how your body builds muscle at the cellular level.', 'Muscle protein synthesis is the process by which your body builds new muscle tissue. This deep dive explores the mechanisms involved, factors that influence the process, and practical applications for optimizing muscle growth.', NULL, 5, 4, 1, '2025-08-09 20:07:06', 3503, 431, 0, 46, 11, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL),
(20, 'Creating a Sustainable Fitness Lifestyle', 'creating-a-sustainable-fitness-lifestyle', 'Building a fitness routine that fits your life long-term.', 'Sustainability is the key to long-term fitness success. This article provides practical strategies for creating a fitness routine that adapts to your changing life circumstances while maintaining consistency and progress toward your goals.', NULL, 7, 4, 1, '2025-08-24 20:07:06', 1586, 186, 0, 15, 10, NULL, '2025-08-26 20:07:06', '2025-08-26 20:07:06', NULL);

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
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fit_news`
--

INSERT INTO `fit_news` (`id`, `title`, `description`, `thumbnail`, `status`, `is_published`, `published_at`, `scheduled_at`, `started_at`, `ended_at`, `channel_name`, `streaming_config`, `viewer_count`, `recording_enabled`, `recording_url`, `recording_id`, `recording_status`, `recording_duration`, `recording_file_size`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'asdasd', 'asdasda', 'fitnews/thumbnails/AIAauOwTuu7apjO4hrcB5o1Ci3nvEPC9a6DvNO9v.png', 'ended', 0, NULL, NULL, '2025-06-25 23:55:34', '2025-06-25 23:57:14', 'fitlive_1', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_1\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IAAmZ3o8LApA2JiWmgsHgG20l0kzYj09q8cqlQXhXoXoFR\\/OUpm379yDIgAwKwAAnZBdaAQAAQCdkF1oAwCdkF1oAgCdkF1oBACdkF1o\",\"uid\":1,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1750962333,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 1, 'C:\\Users\\shree\\Desktop\\Development\\OTT V2\\backend\\storage\\recordings/rec_1750875934_fitlive_1.mp4', 'rec_1750875934_fitlive_1', 'completed', 3007, 253439772, 1, '2025-06-25 17:58:31', '2025-06-25 18:27:14'),
(2, 'asdasd', 'asdasd', 'fitnews/thumbnails/FBYtqfr3MHvZfzw2X4YhIMf1lqxVkGaTZuMSqrFD.png', 'ended', 0, NULL, '2025-06-26 23:54:00', '2025-06-26 00:37:11', '2025-06-26 00:58:24', 'fitlive_2', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_2\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IAB7f\\/\\/8MKQUKPJC2dvAwFBDW7\\/q4hREPb0ISVnZbibYsqWfWwC379yDIgDuTAEAXJpdaAQAAQBcml1oAwBcml1oAgBcml1oBABcml1o\",\"uid\":1,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1750964828,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 1, 'C:\\Users\\shree\\Desktop\\Development\\OTT V2\\backend\\storage\\recordings/rec_1750878431_fitlive_2.mp4', 'rec_1750878431_fitlive_2', 'completed', 677, 410039925, 1, '2025-06-25 18:24:55', '2025-06-25 19:28:24'),
(3, 'dfdfg', 'dfgdfgfd', 'fitnews/thumbnails/czWNMugpNuO7trhqEQ9qvNCNW08b1nYsvTTkSEO7.png', 'ended', 0, NULL, NULL, '2025-06-26 14:08:46', '2025-06-26 14:09:53', 'fitlive_3', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_3\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IABXkmSC\\/NkC8wiTaWO0eyQiPqk88qYtXF7AhpgVdqpAAzOvXHe379yDIgDOEAAAlFheaAQAAQCUWF5oAwCUWF5oAgCUWF5oBACUWF5o\",\"uid\":1,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1751013524,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 1, 'C:\\Users\\shree\\Desktop\\Development\\OTT V2\\backend\\storage\\recordings/rec_1750927126_fitlive_3.mp4', 'rec_1750927126_fitlive_3', 'completed', 752, 400353368, 1, '2025-06-26 08:37:53', '2025-06-26 08:39:53'),
(4, 'dsdgdddf', 'cv', 'fitnews/thumbnails/HFpRurCkZjJiN8Ri8kJTdrTDcGuuLFPesjXZkB8j.png', 'ended', 0, NULL, NULL, '2025-07-03 02:03:18', '2025-07-03 02:03:57', 'fitlive_4', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_4\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IABzOvk+AB0Wj64sIFFe5JpPfZbIVv8mGCQ4H7CK+51VUpA6OOm379yDIgDvLQAAa9ZmaAQAAQBr1mZoAwBr1mZoAgBr1mZoBABr1mZo\",\"uid\":1,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1751570027,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 1, 'C:\\Users\\shree\\Desktop\\Development\\OTT V2\\backend\\storage\\recordings/rec_1751488398_fitlive_4.mp4', 'rec_1751488398_fitlive_4', 'completed', 1197, 148333717, 1, '2025-06-26 08:41:15', '2025-07-02 20:33:57'),
(5, 'asdas', 'asdasd', 'fitnews/thumbnails/g3Czj8EVBZYbDqDPWZKF9aFDBFwHH2OhBAF3z7XR.png', 'ended', 0, NULL, NULL, '2025-07-03 02:09:27', '2025-07-03 02:09:30', 'fitlive_5', '{\"app_id\":\"e2c18ff7a5184d5c8b82bcd797d97282\",\"channel\":\"fitlive_5\",\"token\":\"006e2c18ff7a5184d5c8b82bcd797d97282IABCZth+Rd1IDjJWmWqK2ghPdn+DicK+N4enwRCbw55qrgYKP56379yDIgBskAAAUepmaAQAAQBR6mZoAwBR6mZoAgBR6mZoBABR6mZo\",\"uid\":1,\"role\":\"publisher\",\"configured\":true,\"expires_at\":1751575121,\"video_profile\":\"720p_6\",\"audio_profile\":\"speech_standard\"}', 0, 1, 'C:\\Users\\shree\\Desktop\\Development\\OTT V2\\backend\\storage\\recordings/rec_1751488767_fitlive_5.mp4', 'rec_1751488767_fitlive_5', 'completed', 1776, 183298343, 1, '2025-07-02 20:34:50', '2025-07-02 20:39:30'),
(6, 'demo1', 'asdsd', 'fitnews/thumbnails/cBITGSnP4JG2EEUYIBo6aP2ZVMRvTOcUKWzuknuh.jpg', 'scheduled', 0, NULL, '2025-08-18 06:12:00', NULL, NULL, 'fitnews_6_1755369730', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-16 18:42:10', '2025-08-16 18:42:10'),
(7, 'Revolutionary Study Shows HIIT Benefits for Heart Health', 'New research reveals that high-intensity interval training can improve cardiovascular health more effectively than traditional cardio exercises.', NULL, 'ended', 0, NULL, NULL, '2025-08-19 01:37:06', '2025-08-21 01:37:06', NULL, NULL, 3037, 1, NULL, NULL, 'completed', 1692, 194815709, 5, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(8, 'Olympic Athletes Share Their Training Secrets', 'Exclusive interviews with Olympic gold medalists revealing their training methodologies and mental preparation techniques.', NULL, 'ended', 0, NULL, NULL, '2025-08-19 01:37:06', '2025-08-20 01:37:06', NULL, NULL, 2737, 1, NULL, NULL, 'completed', 624, 109953193, 4, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(9, 'Breaking: New Fitness Technology Trends for 2024', 'Discover the latest fitness technology innovations that are revolutionizing how we approach health and wellness.', NULL, 'ended', 0, NULL, NULL, '2025-08-25 01:37:06', '2025-08-20 01:37:06', NULL, NULL, 1879, 1, NULL, NULL, 'completed', 1288, 144087681, 23, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(10, 'Nutrition Science: Plant-Based Diets for Athletes', 'Latest research on how plant-based nutrition can enhance athletic performance and recovery.', NULL, 'ended', 0, NULL, NULL, '2025-08-17 01:37:06', '2025-08-20 01:37:06', NULL, NULL, 4128, 1, NULL, NULL, 'completed', 453, 164786699, 5, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(11, 'Mental Health and Fitness: The Connection Explained', 'Exploring the powerful relationship between physical exercise and mental well-being backed by scientific research.', NULL, 'ended', 0, NULL, NULL, '2025-08-17 01:37:06', '2025-08-18 01:37:06', NULL, NULL, 947, 1, NULL, NULL, 'completed', 1238, 181343590, 23, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(12, 'Injury Prevention: Expert Tips from Sports Medicine', 'Leading sports medicine doctors share essential strategies for preventing common fitness-related injuries.', NULL, 'ended', 0, NULL, NULL, '2025-08-07 01:37:06', '2025-08-20 01:37:06', NULL, NULL, 1329, 1, NULL, NULL, 'completed', 370, 127058725, 2, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(13, 'Fitness Industry Report: 2024 Trends and Predictions', 'Comprehensive analysis of current fitness industry trends and what to expect in the coming year.', NULL, 'ended', 0, NULL, NULL, '2025-08-25 01:37:06', '2025-08-24 01:37:06', NULL, NULL, 3704, 1, NULL, NULL, 'completed', 995, 168544216, 6, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(14, 'Recovery Science: Sleep and Athletic Performance', 'New findings on how sleep quality directly impacts athletic performance and muscle recovery.', NULL, 'ended', 0, NULL, NULL, '2025-08-16 01:37:06', '2025-08-13 01:37:06', NULL, NULL, 3261, 1, NULL, NULL, 'completed', 629, 134406158, 4, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(15, 'Functional Fitness: Training for Real Life', 'Why functional movement patterns are becoming the foundation of modern fitness programming.', NULL, 'ended', 0, NULL, NULL, '2025-08-16 01:37:06', '2025-08-20 01:37:06', NULL, NULL, 1457, 1, NULL, NULL, 'completed', 516, 146027910, 4, '2025-08-26 20:07:06', '2025-08-26 20:07:06'),
(16, 'Hydration and Performance: What Athletes Need to Know', 'Essential hydration strategies for optimal performance and recovery in different training conditions.', NULL, 'ended', 0, NULL, NULL, '2025-08-23 01:37:06', '2025-08-25 01:37:06', NULL, NULL, 2599, 1, NULL, NULL, 'completed', 384, 86201383, 23, '2025-08-26 20:07:06', '2025-08-26 20:07:06');

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
(1, 'asd', 'aasd', 'ads', 'fitinsight/categories/banners/zqzvdq4PjnT1lOIV1AXgWJZoLoViiQ1vqcEP8uQf.png', 'fas fa-folder', '#f7a31a', 0, 1, 'asd', 'asd', 'asd', '2025-06-26 07:54:51', '2025-06-26 07:54:51', NULL);

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
(2, 14, 2, 'pending', NULL, '2025-08-17 10:45:36', '2025-08-17 10:45:36');

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
(1, 'ABS Workout - Core Strengthening', 'An abs workout is designed to strengthen and tone the muscles in the abdominal region, including the upper, lower, and side muscles that form the core.', 'Sc7LUjbKBHw', 'PLAY NOW', 'https://www.youtube.com/watch?v=Sc7LUjbKBHw', 'WATCH TRAILER', 'https://www.youtube.com/watch?v=Sc7LUjbKBHw', 'ABS', '20 min', 2018, 1, 1, '2025-06-26 07:47:47', '2025-08-27 19:44:33'),
(2, 'HIIT Training - High Intensity', 'High-Intensity Interval Training (HIIT) is a fitness technique that alternates short bursts of intense exercise with brief recovery periods.', 'jNQXAC9IVRw', 'START WORKOUT', '#', 'PREVIEW', '#', 'HIIT', '30 min', 2023, 0, 2, '2025-06-26 07:47:47', '2025-06-26 07:47:47');

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
(3, 20, 'approved', 'approved', 'Fitness enthusiast with 5+ years of experience in strength training and CrossFit. Helping people achieve their fitness goals through proper form and motivation.', 'https://instagram.com/alexjohnson_fit', 'https://youtube.com/c/AlexJohnsonFitness', 'https://facebook.com/alexjohnsonfit', NULL, NULL, 25000, 'strength_training,crossfit,muscle_building', 'Personal trainer at Gold\'s Gym, Fitness influencer on Instagram', 5000.00, 3000.00, 2000.00, '{\"rate\":10,\"payment_method\":\"bank_transfer\",\"minimum_payout\":1000}', '2025-07-27 17:53:53', 10, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:53', NULL),
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
(7, 'default', '{\"uuid\":\"4f77cca4-6ded-48e6-bdb2-63e3ce6780b2\",\"displayName\":\"App\\\\Events\\\\FitLiveSessionStatusUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:38:\\\"App\\\\Events\\\\FitLiveSessionStatusUpdated\\\":1:{s:7:\\\"session\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:25:\\\"App\\\\Models\\\\FitLiveSession\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1756997621,\"delay\":null}', 0, NULL, 1756997621, 1756997621);

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
(106, '2025_01_15_000002_add_specializations_and_hourly_rate_to_user_profiles', 32);

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
(1, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(66, 'App\\Models\\User', 8, 'auth-token', 'af033b091d9e86fbc6bdffc66ce0d0df3e287f92897adcd2ec3eb4379d4ab88c', '[\"*\"]', '2025-09-03 13:18:09', NULL, '2025-09-03 11:24:13', '2025-09-03 13:18:09');

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
(8, 8, 'fit_flix_video', 1, NULL, 'Great workout video! Really helped me with my form.', 0, 1, '2025-09-03 13:17:48', '2025-09-03 13:17:48', NULL);

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
(5, 8, 'fit_flix_video', 1, '2025-09-03 13:17:43', '2025-09-03 13:17:43');

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
(22, 10, 'QUH2WJ0Y', 0, NULL, 1, '2025-12-11 18:30:00', '2025-09-04 15:06:12', '2025-09-04 15:06:12');

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
(15, 3),
(21, 1),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(28, 1);

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
('04JhxZ5Fg3LJE2FEe6gZuORvkUbgRgoZ20ES7GU1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaDJyNGFmZFJ1S0hxMEFyRnR3ZDF1QlhmanBxbDNHa3I1OGE4SUdSbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1OToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2luZmx1ZW5jZXJzL2FuYWx5dGljcy9kYXNoYm9hcmQiO31zOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJHcuS2U4TTlDTE5mTS81R2dGNWU5OWVIM3JRM1NtLzF1ZE53a3hPZWc2YU8uTWFFTWZCU2ZpIjt9', 1756998415);

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
(14, 'ads', 'ads', 'asdasd', 121.00, 'monthly', 1, 1, 12, 0, 1, 1, '[\"asdasd\"]', NULL, '2025-07-02 19:19:47', '2025-07-02 19:19:47', NULL),
(17, 'Basic Plan (Seeder)', 'basic-monthly-seeder', 'Basic fitness plan', 299.00, 'monthly', 1, 1, 7, 0, 1, 1, '[\"Basic features\"]', '{\"max_devices\":2}', '2025-08-26 17:51:28', '2025-08-26 17:51:28', NULL),
(18, 'Premium Plan (Seeder)', 'premium-monthly-seeder', 'Premium fitness plan', 599.00, 'monthly', 1, 1, 14, 1, 1, 2, '[\"Premium features\"]', '{\"max_devices\":5}', '2025-08-26 17:51:28', '2025-08-26 17:51:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'HIIT Training', 'hiit-training', 1, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(2, 1, 'Strength Training', 'strength-training', 2, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(3, 1, 'Cardio Workouts', 'cardio-workouts', 3, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(4, 2, 'Beginner Yoga', 'beginner-yoga', 1, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(5, 2, 'Advanced Yoga', 'advanced-yoga', 2, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(6, 2, 'Meditation', 'meditation', 3, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(7, 3, 'Zumba', 'zumba', 1, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(8, 3, 'Hip Hop Dance', 'hip-hop-dance', 2, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(9, 4, 'Meal Planning', 'meal-planning', 1, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(10, 4, 'Weight Management', 'weight-management', 2, '2025-06-25 17:57:49', '2025-06-25 17:57:49'),
(11, 5, 'asdasd', 'asdasd', 0, '2025-06-25 18:31:23', '2025-06-25 18:31:23'),
(12, 7, 'demo 1', 'demo-1', 0, '2025-08-16 18:40:36', '2025-08-16 18:40:36');

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

INSERT INTO `users` (`id`, `name`, `email`, `referral_code`, `phone`, `date_of_birth`, `gender`, `bio`, `is_available_for_fittalk`, `avatar`, `preferences`, `email_verified_at`, `password`, `subscription_required`, `subscription_ends_at`, `subscription_status`, `remember_token`, `google2fa_secret`, `google2fa_enabled`, `recovery_codes`, `two_factor_confirmed_at`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `referral_source`, `referred_by_user_id`, `referral_code_id`, `influencer_link_id`, `signup_session_id`, `signup_ip`, `signup_user_agent`, `signup_utm_params`, `first_touch_source`, `last_touch_source`, `first_visit_at`, `visits_before_signup`, `referral_bonus_earned`, `referral_bonus_given`, `current_commission_tier_id`, `tier_achieved_at`, `lifetime_commission_earned`, `total_referrals_made`) VALUES
(1, 'Admin User', 'admin@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '$2y$12$w.Ke8M9CLNfM/5GgF5e99eH3rQ3Sm/1udNwkxOeg6aO.MaEMfBSfi', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '2025-06-25 17:57:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(2, 'Instructor User', 'instructor@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '$2y$12$UoAb19xuRf.TIkGcHyOw7ONeanS19pSvZQQsiJeZj/U0tAe1VeynW', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:47', '2025-06-25 17:57:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(3, 'Regular User', 'user@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:48', '$2y$12$ZOWh.abbudrUzrGtNC47XeI5WEDHGWEpZ4LHJM3N9sCAU2fYaAL8y', 1, '2025-09-17 18:30:00', 'active', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:48', '2025-07-02 20:19:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(4, 'Sarah Johnson', 'sarah@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '$2y$12$Z8/TzajUBIIxq/gvgflOquMD5k..n5uordmLxpRBbcczqgDpIwdw.', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(5, 'Maria Santos', 'maria@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '$2y$12$vrxd/qyHhQ6ebrahoJqrX.O8STgiqvefj.I362Ot3KIwFXZAsppdi', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(6, 'Mike Chen', 'mike@fitlley.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '$2y$12$7W.bXwfwKc/Cnq0cT9sBJOc3NiXG0RWcXRW5pL24RkQN.J21GaMiy', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-06-25 17:57:49', '2025-06-25 17:57:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(7, 'Rushab Shirke', 'shirkerushab6@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$ZH6JWgfGEtsg4mDWOGVPkOtMmH2h1m6PfyMZAhbZe2wjXj0A8Bdt2', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-01 16:00:11', '2025-07-01 16:00:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(8, 'John Doe', 'john@example.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$Lex5odzk4eTjs6Q6iHMh6OhAaV2WbYnleBK9/fnPBehKNSQZ2gUeC', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-02 14:52:59', '2025-07-02 14:52:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(9, 'Test User', 'test@fittelly.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-07-02 19:02:01', '$2y$12$9.CQn3Lu/7KuwhIDaRdn7u3ejUqZMGBrw4JKIScsdGhR17eXZphi6', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-02 19:00:56', '2025-07-02 19:02:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(10, 'Admin User', 'admin@fittelly.com', NULL, '+91-9876543214', '1980-01-01', 'male', NULL, 0, NULL, '[\"all\"]', '2025-08-26 17:53:53', '$2y$12$huKKzXFp0ac0MR8uTVYfSOHMN01.G6yS8egsRqqVdgvBVHKCgtJ/i', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-07-22 16:34:32', '2025-08-26 17:53:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(11, 'John Doe', 'abc@example.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$/xYl7hNsXf/I2U73Hec9vOvt9Q2vg8xN376ZnBg8gNDhwNo8HgkNu', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-05 14:19:40', '2025-08-05 14:19:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(12, 'Test User', 'test@example.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$ZIKWTwZVbTyI1rugzFlkCe2ooaL7AaIq2DSRc6FMrRDrNIJu4185a', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-08 20:04:28', '2025-08-08 20:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(13, 'John Doe', 'john1@example.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$UVQs8pGZgxw7Oh2QLsmmIeH0Ho/Xl0GbPFrGula9sqBAZwy/azb82', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 08:45:08', '2025-08-17 08:45:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(14, 'John Doe', 'john2@example.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$nZTkEfIYXDkYBGyKd6zjR.YdZ4Hae.EVKqvljggfMwalamVh74Vva', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 08:54:24', '2025-08-17 08:54:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(15, 'John Doe', 'john3@example.com', NULL, '+1234567890', NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$gfnBzS3SAdirdKITfdLrKuWWeZ0lBeygkM.pY8P2cuTCgF1vET2Xa', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-17 10:32:58', '2025-08-17 10:32:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(16, 'Test User', 'test@myplans.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$qScKwelgjFhAUmnonSt0Ve1O7oC/v3BgqEuLWxPsq.8yOb5sxx3La', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-18 12:59:23', '2025-08-18 12:59:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(17, 'FitLive Test User', 'test@fitlive.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$IMWbjOpDohXEyUxB6pApi.mzWa2fwHejlFCJfPu11ht6B2mwziQ7m', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-18 13:11:06', '2025-08-18 13:11:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(18, 'John Doe', 'basic.user@fittelly.com', NULL, '+91-9876543210', '1990-05-15', 'male', NULL, 0, NULL, '[\"yoga\",\"cardio\"]', '2025-08-26 17:53:50', '$2y$12$OkidkUub6aFlvz12kW/XveQLCsY6fo.2D0jc9Y3.O4ntMF3jhIxLO', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:52', '2025-08-26 17:53:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(19, 'Jane Smith', 'premium.user@fittelly.com', NULL, '+91-9876543211', '1985-08-22', 'female', NULL, 0, NULL, '[\"pilates\",\"strength_training\"]', '2025-08-26 17:53:50', '$2y$12$ph0pL3ZtK0pcORnVL9MteOIdGX6JaWJui79XX6vHRPnrRu9ULQpJC', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:53', '2025-08-26 17:53:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(20, 'Alex Johnson', 'influencer1@fittelly.com', NULL, '+91-9876543212', '1992-03-10', 'male', NULL, 0, NULL, '[\"weightlifting\",\"crossfit\"]', '2025-08-26 17:53:51', '$2y$12$I3asE3L2BHV6S4h93vJC2eh9ck1DUw3VuT1i3ixW8AYsi/KSnfr8i', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(21, 'Sarah Wilson', 'influencer2@fittelly.com', NULL, '+91-9876543213', '1988-11-05', 'female', NULL, 0, NULL, '[\"yoga\",\"pilates\"]', '2025-08-26 17:53:52', '$2y$12$KSIEcKrl5nrg.ob/XRgQZ.dBLQXHX2cyxqNaYzGBe6RZQ0O2hdJQO', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:54', '2025-08-26 17:53:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(22, 'Mike Rodriguez', 'instructor1@fittelly.com', NULL, '+91-9876543215', '1985-07-12', 'male', NULL, 0, NULL, '[\"strength_training\",\"cardio\",\"functional_fitness\"]', '2025-08-26 17:53:54', '$2y$12$unVUcyw9xlGqmwHcDov/cOR/2Hsaikj8eTgTKs7sYCy2X0KvAPV3W', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:55', '2025-08-26 17:53:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0),
(23, 'Lisa Chen', 'instructor2@fittelly.com', NULL, '+91-9876543216', '1990-02-28', 'female', NULL, 0, NULL, '[\"yoga\",\"pilates\",\"meditation\",\"nutrition\"]', '2025-08-26 17:53:54', '$2y$12$7H1qRWIX2/0em/CaOt6AQOjFP9vLmWP0KtA6DIVThPI/Ks1NLXL5.', 1, NULL, 'inactive', NULL, NULL, 0, NULL, NULL, '2025-08-26 17:49:55', '2025-08-26 17:53:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, NULL, NULL, 0.00, 0);

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
(3, 14, 175.00, 70.00, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"weight_loss\",\"muscle_gain\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Fitness enthusiast and health coach', NULL, NULL, 1, 1, 1, 'public', '2025-08-17 10:45:47', '2025-08-17 10:45:51');

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
(1, 3, 14, 'active', 10.00, 'admin-manual', 'MANUAL_1751487558', NULL, '2025-07-02 18:30:00', '2025-09-17 18:30:00', NULL, NULL, NULL, '2025-07-02 20:19:18', '2025-07-02 20:19:18'),
(2, 18, 17, 'active', 299.00, 'credit_card', 'TXN_BASIC_1756230772', NULL, '2025-08-26 17:52:52', '2025-09-26 17:52:52', '2025-09-02 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(3, 19, 18, 'active', 599.00, 'upi', 'TXN_PREMIUM_1756230772', NULL, '2025-08-26 17:52:52', '2025-09-26 17:52:52', '2025-09-09 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(4, 20, 18, 'active', 599.00, 'net_banking', 'TXN_PRO_1756230772', NULL, '2025-08-26 17:52:52', '2025-11-26 17:52:52', '2025-09-09 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(5, 21, 18, 'active', 599.00, 'credit_card', 'TXN_ANNUAL_1756230772', NULL, '2025-08-26 17:52:52', '2026-08-26 17:52:52', '2025-09-25 17:52:52', NULL, NULL, '2025-08-26 17:51:28', '2025-08-26 17:52:52'),
(6, 18, 14, 'active', 121.00, 'credit_card', 'TXN_BASIC_1756230833', NULL, '2025-08-26 17:53:53', '2025-09-26 17:53:53', '2025-09-02 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(7, 19, 17, 'active', 299.00, 'upi', 'TXN_PREMIUM_1756230833', NULL, '2025-08-26 17:53:53', '2025-09-26 17:53:53', '2025-09-09 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(8, 20, 17, 'active', 299.00, 'net_banking', 'TXN_PRO_1756230833', NULL, '2025-08-26 17:53:53', '2025-11-26 17:53:53', '2025-09-09 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53'),
(9, 21, 17, 'active', 299.00, 'credit_card', 'TXN_ANNUAL_1756230833', NULL, '2025-08-26 17:53:53', '2026-08-26 17:53:53', '2025-09-25 17:53:53', NULL, NULL, '2025-08-26 17:53:53', '2025-08-26 17:53:53');

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
  ADD KEY `fitarena_events_start_date_end_date_index` (`start_date`,`end_date`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `community_groups`
--
ALTER TABLE `community_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_messages`
--
ALTER TABLE `direct_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fg_series`
--
ALTER TABLE `fg_series`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fg_series_episodes`
--
ALTER TABLE `fg_series_episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `fg_singles`
--
ALTER TABLE `fg_singles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fg_sub_categories`
--
ALTER TABLE `fg_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fitarena_events`
--
ALTER TABLE `fitarena_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fitarena_sessions`
--
ALTER TABLE `fitarena_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fitarena_stages`
--
ALTER TABLE `fitarena_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fitlive_chat_messages`
--
ALTER TABLE `fitlive_chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fitlive_sessions`
--
ALTER TABLE `fitlive_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `fittalk_sessions`
--
ALTER TABLE `fittalk_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fit_casts`
--
ALTER TABLE `fit_casts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fit_docs`
--
ALTER TABLE `fit_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fit_doc_episodes`
--
ALTER TABLE `fit_doc_episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fit_flix_shorts`
--
ALTER TABLE `fit_flix_shorts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fit_flix_shorts_categories`
--
ALTER TABLE `fit_flix_shorts_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fit_insights`
--
ALTER TABLE `fit_insights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fit_news`
--
ALTER TABLE `fit_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fi_blogs`
--
ALTER TABLE `fi_blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fi_categories`
--
ALTER TABLE `fi_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `referral_codes`
--
ALTER TABLE `referral_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_activities`
--
ALTER TABLE `user_login_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `fg_series_episodes_fg_series_id_foreign` FOREIGN KEY (`fg_series_id`) REFERENCES `fg_series` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

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
