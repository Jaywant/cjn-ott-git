-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 05, 2024 at 03:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dt_live_clean`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_avatar`
--

CREATE TABLE `tbl_avatar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(11) NOT NULL,
  `is_home_screen` int(11) NOT NULL DEFAULT 1 COMMENT '1- home screen, 2- other screen',
  `type_id` int(11) NOT NULL COMMENT 'FK = Type Table',
  `video_type` int(11) NOT NULL DEFAULT 1 COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `subvideo_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show',
  `video_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `id` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL DEFAULT 1 COMMENT '0-No, 1- Yes',
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL DEFAULT 1 COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show',
  `video_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cast`
--

CREATE TABLE `tbl_cast` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `personal_info` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_channel`
--

CREATE TABLE `tbl_channel` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `portrait_img` varchar(255) NOT NULL,
  `landscape_img` varchar(255) NOT NULL,
  `is_title` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- show',
  `video_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL DEFAULT 0,
  `comment` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount_type` int(11) NOT NULL COMMENT '1- Price, 2- Percentage',
  `price` varchar(255) NOT NULL,
  `is_use` int(11) NOT NULL COMMENT '0- All, 1- One',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_sync`
--

CREATE TABLE `tbl_device_sync` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `device_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Android, 2- IOS, 3- Web, 4- TV',
  `device_token` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_watching`
--

CREATE TABLE `tbl_device_watching` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_download`
--

CREATE TABLE `tbl_download` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show',
  `video_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_setting`
--

CREATE TABLE `tbl_general_setting` (
  `id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `tbl_general_setting`
--

INSERT INTO `tbl_general_setting` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', '', '2022-08-03 12:38:42', '2024-05-30 06:39:12'),
(2, 'host_email', 'support@divinetechs.com', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(3, 'app_version', '1.0', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(4, 'author', 'DivineTechs', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(5, 'email', 'support@divinetechs.com', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(6, 'contact', '917984859403', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(7, 'app_desripation', 'DivineTechs, a top web & mobile app development company offering innovative solutions for diverse industry verticals. We have creative and dedicated group of developers who are mastered in Apps Developments and Web Development with a nice in delivering quality solutions to customers across the globe.', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(11, 'app_logo', '', '2022-08-03 12:38:42', '2024-06-10 05:00:24'),
(12, 'website', 'https://www.divinetechs.com/', '2022-08-03 12:38:42', '2024-01-23 06:10:23'),
(13, 'currency', 'USD', '2022-08-03 12:38:42', '2024-05-28 05:02:40'),
(14, 'currency_code', '$', '2022-08-03 12:38:42', '2024-05-28 05:02:40'),
(25, 'banner_ad', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:07'),
(26, 'banner_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(27, 'interstital_ad', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:07'),
(28, 'interstital_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(29, 'interstital_adclick', '', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(30, 'reward_ad', '0', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(31, 'reward_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(32, 'reward_adclick', '', '2022-08-03 12:38:42', '2024-01-23 06:31:10'),
(33, 'ios_banner_ad', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:19'),
(34, 'ios_banner_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(35, 'ios_interstital_ad', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:19'),
(36, 'ios_interstital_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(37, 'ios_interstital_adclick', '', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(38, 'ios_reward_ad', '0', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(39, 'ios_reward_adid', '', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(40, 'ios_reward_adclick', '', '2022-08-03 12:38:42', '2024-01-23 06:31:38'),
(41, 'fb_native_status', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:29'),
(42, 'fb_native_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(43, 'fb_banner_status', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:29'),
(44, 'fb_banner_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(45, 'fb_interstiatial_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(46, 'fb_interstiatial_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(47, 'fb_rewardvideo_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(48, 'fb_rewardvideo_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(49, 'fb_native_full_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(50, 'fb_native_full_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:01'),
(51, 'fb_ios_native_status', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:42'),
(52, 'fb_ios_native_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(53, 'fb_ios_banner_status', '0', '2022-08-03 12:38:42', '2024-02-21 05:20:42'),
(54, 'fb_ios_banner_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(55, 'fb_ios_interstiatial_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(56, 'fb_ios_interstiatial_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(57, 'fb_ios_rewardvideo_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(58, 'fb_ios_rewardvideo_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(59, 'fb_ios_native_full_status', '0', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(60, 'fb_ios_native_full_id', '', '2022-08-03 12:38:42', '2024-01-23 06:37:17'),
(61, 'onesignal_apid', '', '2022-08-03 12:38:42', '2024-05-27 09:52:32'),
(62, 'onesignal_rest_key', '', '2022-08-03 12:38:42', '2024-05-27 09:52:32'),
(74, 'tmdb_status', '0', '2024-01-19 10:08:45', '2024-06-10 05:00:43'),
(75, 'tmdb_api_key', '', '2024-01-19 10:08:45', '2024-06-10 05:00:39'),
(76, 'auto_play_trailer', '1', '2024-02-09 11:00:00', '2024-05-06 07:09:45'),
(77, 'parent_control_status', '1', '2024-02-21 13:55:15', '2024-06-10 05:02:18'),
(78, 'multiple_device_sync', '0', '2024-02-22 10:46:31', '2024-05-14 10:59:35'),
(79, 'no_of_device_sync', '0', '2024-02-22 10:46:54', '2024-05-14 10:59:35'),
(80, 'subscription_status', '1', '2024-04-18 04:42:18', '2024-05-06 07:09:45'),
(81, 'active_tv_status', '0', '2024-05-06 05:46:52', '2024-05-06 07:05:34'),
(82, 'watchlist_status', '1', '2024-05-06 05:46:52', '2024-05-06 07:09:45'),
(83, 'download_status', '1', '2024-05-06 05:47:30', '2024-05-06 07:09:45'),
(84, 'continue_watching_status', '1', '2024-05-06 05:47:30', '2024-05-06 07:09:45'),
(85, 'coupon_status', '0', '2024-05-06 05:47:56', '2024-05-06 07:05:34'),
(86, 'rent_status', '1', '2024-05-06 05:47:56', '2024-05-06 07:09:45'),
(87, 'on_boarding_screen_status', '0', '2024-05-06 12:58:32', '2024-05-08 04:43:38'),
(88, 'vapid_key', '', '2024-08-08 11:47:25', '2024-08-08 11:47:25'),
(89, 'page_background_color', '', '2024-08-28 03:52:36', '2024-08-28 03:52:36'),
(90, 'page_title_color', '', '2024-08-28 03:52:36', '2024-08-28 03:52:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_section`
--

CREATE TABLE `tbl_home_section` (
  `id` int(11) NOT NULL,
  `is_home_screen` int(11) NOT NULL COMMENT '1- home screen, 2- other screen	',
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Channel List, 6- Upcoming Content, 7- Channel Content, 8- Continue Watching, 9- Kids Content',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show',
  `type_id` int(11) NOT NULL COMMENT 'FK = Type Table',
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `screen_layout` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL DEFAULT 0,
  `order_by_upload` int(11) NOT NULL DEFAULT 0 COMMENT '1- ASC, 2- DESC',
  `order_by_like` int(11) NOT NULL DEFAULT 0 COMMENT '1- ASC, 2- DESC',
  `order_by_view` int(11) NOT NULL DEFAULT 0 COMMENT '1- ASC, 2- DESC',
  `premium_video` int(11) NOT NULL DEFAULT 0 COMMENT '0- No, 1- Yes',
  `rent_video` int(11) NOT NULL DEFAULT 0 COMMENT '0- No, 1- Yes',
  `no_of_content` int(11) NOT NULL DEFAULT 0 COMMENT '0- All',
  `view_all` int(11) NOT NULL DEFAULT 0 COMMENT '0- No, 1- Yes',
  `sortable` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_like`
--

CREATE TABLE `tbl_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show\r\n',
  `video_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_onboarding_screen`
--

CREATE TABLE `tbl_onboarding_screen` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(11,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `watch_on_laptop_tv` int(11) NOT NULL,
  `ads_free_content` int(11) NOT NULL,
  `no_of_device_sync` int(11) NOT NULL,
  `android_product_package` varchar(255) NOT NULL,
  `ios_product_package` varchar(255) NOT NULL,
  `web_product_package` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package_detail`
--

CREATE TABLE `tbl_package_detail` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_key` text NOT NULL,
  `package_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_subtitle` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `page_name`, `title`, `description`, `page_subtitle`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 'About Us', '', 'About Us', '', 1, '2022-09-26 04:31:44', '2024-06-10 05:00:03'),
(2, 'privacy-policy', 'Privacy Policy', '', 'Privacy Policy', '', 1, '2022-09-26 04:31:44', '2024-06-10 05:00:04'),
(3, 'terms-and-conditions', 'Terms & Conditions', '', 'Terms & Conditions', '', 1, '2022-09-26 04:31:44', '2024-06-10 05:00:05'),
(4, 'refund-policy', 'Refund Policy', '', 'Refund Policy', '', 1, '2023-01-21 10:21:24', '2024-06-10 05:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_panel_setting`
--

CREATE TABLE `tbl_panel_setting` (
  `id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_panel_setting`
--

INSERT INTO `tbl_panel_setting` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'login_page_img', '', '2024-05-30 04:42:43', '2024-06-10 04:59:34'),
(2, 'profile_no_img', '', '2024-05-30 06:01:05', '2024-06-10 04:59:36'),
(3, 'normal_no_img', '', '2024-05-30 06:02:55', '2024-06-10 04:59:37'),
(4, 'portrait_no_img', '', '2024-05-30 06:02:55', '2024-06-10 04:59:38'),
(5, 'landscape_no_img', '', '2024-05-30 06:02:55', '2024-06-10 04:59:39'),
(6, 'primary_color', '#4e45b8', '2024-05-30 04:48:12', '2024-05-31 06:07:24'),
(7, 'asset_color', '#f9faff', '2024-05-30 04:48:12', '2024-05-31 06:07:24'),
(8, 'background_color', '#ffffff', '2024-05-30 04:49:38', '2024-05-31 06:04:57'),
(9, 'shadow_color', '#000000', '2024-05-30 04:49:38', '2024-05-31 06:07:24'),
(10, 'breadcrumb_color', '#e9ecef', '2024-05-30 04:50:21', '2024-05-31 06:07:24'),
(11, 'success_status_color', '#e3000b', '2024-05-30 04:51:45', '2024-05-31 06:07:24'),
(12, 'error_status_color', '#058f00', '2024-05-30 04:51:45', '2024-05-31 06:07:24'),
(13, 'dark_text_color', '#000000', '2024-05-30 04:52:50', '2024-05-31 06:07:24'),
(14, 'light_text_color', '#ffffff', '2024-05-30 04:52:50', '2024-05-31 06:04:57'),
(15, 'counter_card_1_bg', '#fef3f1', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(16, 'counter_card_2_bg', '#ffe5ef', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(17, 'counter_card_3_bg', '#edffef', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(18, 'counter_card_4_bg', '#f4f2ff', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(19, 'counter_card_5_bg', '#ecfbff', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(20, 'counter_card_6_bg', '#dfab91', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(21, 'counter_card_7_bg', '#f068a7', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(22, 'counter_card_8_bg', '#83cf78', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(23, 'counter_card_9_bg', '#c9b7f1', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(24, 'counter_card_10_bg', '#3acef3', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(25, 'counter_card_1_text', '#a98471', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(26, 'counter_card_2_text', '#c0698b', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(27, 'counter_card_3_text', '#6cb373', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(28, 'counter_card_4_text', '#736aa6', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(29, 'counter_card_5_text', '#6db3c6', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(30, 'counter_card_6_text', '#692705', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(31, 'counter_card_7_text', '#b41d64', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(32, 'counter_card_8_text', '#245c1c', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(33, 'counter_card_9_text', '#530899', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(34, 'counter_card_10_text', '#18677a', '2024-05-30 04:44:04', '2024-05-31 06:07:24'),
(35, 'chart_color_1', '#ff6384', '2024-05-30 05:59:21', '2024-05-31 06:07:24'),
(36, 'chart_color_2', '#4bc0c0', '2024-05-30 05:59:21', '2024-05-31 06:07:24'),
(37, 'chart_color_3', '#ffcd56', '2024-05-30 05:59:29', '2024-05-31 06:07:24'),
(38, 'chart_color_4', '#b04645', '2024-05-30 05:59:29', '2024-05-31 06:07:24'),
(39, 'chart_color_5', '#35b03b', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(40, 'chart_color_6', '#36a2eb', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(41, 'chart_color_7', '#e007f0', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(42, 'chart_color_8', '#9966ff', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(43, 'chart_color_9', '#ff9f40', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(44, 'chart_color_10', '#e04714', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(45, 'chart_color_11', '#a19135', '2024-05-30 06:00:06', '2024-05-31 06:07:24'),
(46, 'chart_color_12', '#e876d3', '2024-05-30 06:00:06', '2024-05-31 06:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_option`
--

CREATE TABLE `tbl_payment_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `visibility` varchar(255) NOT NULL,
  `is_live` varchar(255) NOT NULL,
  `key_1` varchar(255) NOT NULL,
  `key_2` varchar(255) NOT NULL,
  `key_3` varchar(255) NOT NULL,
  `key_4` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `tbl_payment_option`
--

INSERT INTO `tbl_payment_option` (`id`, `name`, `visibility`, `is_live`, `key_1`, `key_2`, `key_3`, `key_4`, `created_at`, `updated_at`) VALUES
(1, 'inapppurchage', '0', '0', '', '', '', '', '2022-07-29 06:26:54', '2024-05-27 14:19:22'),
(2, 'paypal', '0', '0', '', '', '', '', '2022-07-29 06:26:54', '2024-05-27 14:19:20'),
(3, 'razorpay', '0', '0', '', '', '', '', '2022-07-29 06:27:09', '2024-05-27 14:19:19'),
(4, 'flutterwave', '0', '0', '', '', '', '', '2022-07-29 06:27:09', '2024-05-27 14:19:18'),
(5, 'payumoney', '0', '0', '', '', '', '', '2022-07-29 06:27:17', '2024-05-27 14:19:23'),
(6, 'paytm', '0', '0', '', '', '', '', '2022-07-29 06:27:17', '2024-05-27 14:19:16'),
(7, 'stripe', '0', '0', '', '', '', '', '2023-05-06 06:36:30', '2024-05-27 14:19:16'),
(8, 'cash', '0', '0', '', '', '', '', '2023-06-27 07:26:08', '2024-05-27 14:19:15'),
(9, 'paystack', '0', '0', '', '', '', '', '2023-09-11 11:52:42', '2024-05-27 14:19:13'),
(10, 'instamojo', '0', '0', '', '', '', '', '2023-09-11 11:52:59', '2024-05-27 14:19:25'),
(11, 'phonepe', '0', '0', '', '', '', '', '2024-02-09 11:13:03', '2024-05-27 14:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_producer`
--

CREATE TABLE `tbl_producer` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_read_notification`
--

CREATE TABLE `tbl_read_notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rent_price_list`
--

CREATE TABLE `tbl_rent_price_list` (
  `id` int(11) NOT NULL,
  `price` double(11,2) NOT NULL,
  `android_product_package` varchar(255) NOT NULL,
  `ios_product_package` varchar(255) NOT NULL,
  `web_price_id` varchar(255) NOT NULL COMMENT 'Stripe Only	',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rent_transction`
--

CREATE TABLE `tbl_rent_transction` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'FK = Coupon Table',
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show\r\n',
  `video_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expiry_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_season`
--

CREATE TABLE `tbl_season` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_setting`
--

CREATE TABLE `tbl_smtp_setting` (
  `id` int(11) NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_smtp_setting`
--

INSERT INTO `tbl_smtp_setting` (`id`, `protocol`, `host`, `port`, `user`, `pass`, `from_name`, `from_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'smtp123', 'smtp.gmail.com', '587', 'admin@admin.com', 'admin', 'DTLive-Divinetechs', 'admin@admin.com', 0, '2022-08-03 10:14:04', '2024-02-02 12:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_link`
--

CREATE TABLE `tbl_social_link` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_profile`
--

CREATE TABLE `tbl_sub_profile` (
  `id` int(11) NOT NULL,
  `parent_user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL COMMENT 'FK = Coupon Table',
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tv_login`
--

CREATE TABLE `tbl_tv_login` (
  `id` int(11) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `unique_code` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tv_show`
--

CREATE TABLE `tbl_tv_show` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0 COMMENT 'FK = Type Table',
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `channel_id` int(11) NOT NULL,
  `producer_id` int(11) NOT NULL DEFAULT 0,
  `category_id` text NOT NULL,
  `language_id` text NOT NULL,
  `cast_id` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `landscape` varchar(255) NOT NULL,
  `trailer_type` varchar(255) NOT NULL COMMENT 'server_video, external, youtube',
  `trailer_url` text NOT NULL,
  `description` text NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `is_title` int(11) NOT NULL DEFAULT 0,
  `is_like` int(11) NOT NULL DEFAULT 0,
  `is_comment` int(11) NOT NULL DEFAULT 0,
  `total_like` int(11) NOT NULL DEFAULT 0,
  `total_view` int(11) NOT NULL DEFAULT 0,
  `is_rent` int(11) NOT NULL COMMENT '0- No, 1- Yes',
  `price` int(11) NOT NULL DEFAULT 0,
  `rent_day` int(11) NOT NULL DEFAULT 0 COMMENT '1 to 30 Day',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tv_show_video`
--

CREATE TABLE `tbl_tv_show_video` (
  `id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `landscape` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video_upload_type` varchar(255) NOT NULL COMMENT 'server_video, external, youtube\r\n',
  `video_320` varchar(255) NOT NULL,
  `video_480` varchar(255) NOT NULL,
  `video_720` varchar(255) NOT NULL,
  `video_1080` varchar(255) NOT NULL,
  `video_extension` varchar(255) NOT NULL,
  `video_duration` int(11) NOT NULL DEFAULT 0,
  `subtitle_type` varchar(255) NOT NULL COMMENT 'server_video, external',
  `subtitle_lang_1` varchar(255) NOT NULL,
  `subtitle_1` varchar(255) NOT NULL,
  `subtitle_lang_2` varchar(255) NOT NULL,
  `subtitle_2` varchar(255) NOT NULL,
  `subtitle_lang_3` varchar(255) NOT NULL,
  `subtitle_3` varchar(255) NOT NULL,
  `is_premium` int(11) NOT NULL DEFAULT 0,
  `is_title` int(11) NOT NULL DEFAULT 0,
  `is_download` int(11) NOT NULL DEFAULT 0 COMMENT '\r\n',
  `is_like` int(11) NOT NULL DEFAULT 0,
  `total_view` int(11) NOT NULL DEFAULT 0,
  `total_like` int(11) NOT NULL DEFAULT 0,
  `sortable` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type`
--

CREATE TABLE `tbl_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `image_type` int(11) NOT NULL COMMENT '	1- File Upload, 2- Avatar	',
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '1- OTP, 2- Google, 3- Apple, 4- Normal	',
  `parent_control_status` int(11) NOT NULL DEFAULT 0,
  `parent_control_password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL COMMENT 'FK = Type Table',
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `channel_id` int(11) NOT NULL,
  `producer_id` int(11) NOT NULL DEFAULT 0,
  `category_id` text NOT NULL,
  `language_id` text NOT NULL,
  `cast_id` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `landscape` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video_upload_type` varchar(255) NOT NULL COMMENT 'server_video, external, youtube',
  `video_320` varchar(255) NOT NULL,
  `video_480` varchar(255) NOT NULL,
  `video_720` varchar(255) NOT NULL,
  `video_1080` varchar(255) NOT NULL,
  `video_extension` varchar(255) NOT NULL,
  `video_duration` int(11) NOT NULL DEFAULT 0,
  `trailer_type` varchar(255) NOT NULL COMMENT 'server_video, external, youtube',
  `trailer_url` varchar(255) NOT NULL,
  `subtitle_type` varchar(255) NOT NULL COMMENT 'server_video, external',
  `subtitle_lang_1` varchar(255) NOT NULL,
  `subtitle_1` varchar(255) NOT NULL,
  `subtitle_lang_2` varchar(255) NOT NULL,
  `subtitle_2` varchar(255) NOT NULL,
  `subtitle_lang_3` varchar(255) NOT NULL,
  `subtitle_3` varchar(255) NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `is_premium` int(11) NOT NULL DEFAULT 0,
  `is_title` int(11) NOT NULL DEFAULT 0,
  `is_download` int(11) NOT NULL DEFAULT 0,
  `is_like` int(11) NOT NULL DEFAULT 0,
  `is_comment` int(11) NOT NULL DEFAULT 0,
  `total_like` int(11) NOT NULL DEFAULT 0,
  `total_view` int(11) NOT NULL DEFAULT 0,
  `is_rent` int(11) NOT NULL COMMENT '0- No, 1- Yes\r\n',
  `price` int(11) NOT NULL DEFAULT 0,
  `rent_day` int(11) NOT NULL DEFAULT 0 COMMENT '1 to 30 Day\r\n',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_watch`
--

CREATE TABLE `tbl_video_watch` (
  `id` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL DEFAULT 1 COMMENT '	0-No, 1- Yes',
  `user_id` int(11) NOT NULL,
  `video_type` int(11) NOT NULL COMMENT '1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids	',
  `sub_video_type` int(11) NOT NULL DEFAULT 0 COMMENT '1- Video, 2- Show\r\n',
  `video_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL DEFAULT 0,
  `stop_time` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_avatar`
--
ALTER TABLE `tbl_avatar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cast`
--
ALTER TABLE `tbl_cast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_channel`
--
ALTER TABLE `tbl_channel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_device_sync`
--
ALTER TABLE `tbl_device_sync`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_device_watching`
--
ALTER TABLE `tbl_device_watching`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_download`
--
ALTER TABLE `tbl_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home_section`
--
ALTER TABLE `tbl_home_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_like`
--
ALTER TABLE `tbl_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_onboarding_screen`
--
ALTER TABLE `tbl_onboarding_screen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_package`
--
ALTER TABLE `tbl_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_package_detail`
--
ALTER TABLE `tbl_package_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_panel_setting`
--
ALTER TABLE `tbl_panel_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_option`
--
ALTER TABLE `tbl_payment_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_producer`
--
ALTER TABLE `tbl_producer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_read_notification`
--
ALTER TABLE `tbl_read_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rent_price_list`
--
ALTER TABLE `tbl_rent_price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rent_transction`
--
ALTER TABLE `tbl_rent_transction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_season`
--
ALTER TABLE `tbl_season`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_setting`
--
ALTER TABLE `tbl_smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social_link`
--
ALTER TABLE `tbl_social_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_profile`
--
ALTER TABLE `tbl_sub_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tv_login`
--
ALTER TABLE `tbl_tv_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tv_show`
--
ALTER TABLE `tbl_tv_show`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tv_show_video`
--
ALTER TABLE `tbl_tv_show_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_type`
--
ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video_watch`
--
ALTER TABLE `tbl_video_watch`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_avatar`
--
ALTER TABLE `tbl_avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cast`
--
ALTER TABLE `tbl_cast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_channel`
--
ALTER TABLE `tbl_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_device_sync`
--
ALTER TABLE `tbl_device_sync`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_device_watching`
--
ALTER TABLE `tbl_device_watching`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_download`
--
ALTER TABLE `tbl_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_home_section`
--
ALTER TABLE `tbl_home_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_like`
--
ALTER TABLE `tbl_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_onboarding_screen`
--
ALTER TABLE `tbl_onboarding_screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_package`
--
ALTER TABLE `tbl_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_package_detail`
--
ALTER TABLE `tbl_package_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_panel_setting`
--
ALTER TABLE `tbl_panel_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_payment_option`
--
ALTER TABLE `tbl_payment_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_producer`
--
ALTER TABLE `tbl_producer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_read_notification`
--
ALTER TABLE `tbl_read_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rent_price_list`
--
ALTER TABLE `tbl_rent_price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rent_transction`
--
ALTER TABLE `tbl_rent_transction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_season`
--
ALTER TABLE `tbl_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_smtp_setting`
--
ALTER TABLE `tbl_smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_social_link`
--
ALTER TABLE `tbl_social_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sub_profile`
--
ALTER TABLE `tbl_sub_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tv_login`
--
ALTER TABLE `tbl_tv_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tv_show`
--
ALTER TABLE `tbl_tv_show`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tv_show_video`
--
ALTER TABLE `tbl_tv_show_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_type`
--
ALTER TABLE `tbl_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_video_watch`
--
ALTER TABLE `tbl_video_watch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
