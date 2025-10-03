-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 11:28 AM
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
-- Database: `dashboardsweb`
--

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
-- Table structure for table `menu_master`
--

CREATE TABLE `menu_master` (
  `id` int(10) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `active` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`id`, `website_id`, `title`, `link`, `active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Home', 'home', 'Y', '2025-09-19 06:49:41', '2025-09-19 07:29:25'),
(2, 2, 'Halaman', 'page', 'Y', '2025-09-19 07:34:04', '2025-09-19 07:34:04'),
(3, 2, 'Tentang', 'about', 'Y', '2025-09-19 07:34:23', '2025-09-19 07:34:23'),
(5, 1, 'Home 5', 'home5', 'Y', '2025-09-19 06:49:41', '2025-09-19 07:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub`
--

CREATE TABLE `menu_sub` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_master_id` int(10) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `active` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_sub`
--

INSERT INTO `menu_sub` (`id`, `menu_master_id`, `website_id`, `title`, `link`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Sejarahku', 'sejarahku', 'Y', '2025-09-19 11:21:27', '2025-09-19 11:21:38'),
(2, 1, 2, 'Ceritaku', 'ceritaku', 'Y', '2025-09-19 11:22:00', '2025-09-19 11:22:00');

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
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `website_id` varchar(10) DEFAULT NULL,
  `judul` varchar(50) NOT NULL,
  `judul_en` varchar(50) DEFAULT NULL,
  `isi` text NOT NULL,
  `isi_en` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `user_id`, `website_id`, `judul`, `judul_en`, `isi`, `isi_en`, `tanggal`, `image`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 'Tes', 'Tes Inggris', '<p><b>bold</b>, <i>italic</i>, <u>underline</u>, <u><i><b>campur</b></i></u></p><p><u><i><b>enter</b></i></u></p>', '<p><span style=\"font-weight: 700;\">bold</span>,&nbsp;<i>italic</i>,&nbsp;<u>underline</u>,&nbsp;<u><i><span style=\"font-weight: 700;\">campur</span></i></u></p><p><u><i><span style=\"font-weight: 700;\">enter inggris</span></i></u></p>', '2025-09-12', 'news_images/6tZ3aXhBUMP4CSKyd8JDHB0VMPG33qEZXXiOWnT0.jpg', NULL, '2025-09-11 20:48:54', '2025-09-18 02:42:03'),
(2, 1, '2', 'Tes2', 'Tes Inggris2', '<p><b>bold</b>, <i>italic</i>, <u>underline</u>, <u><i><b>campur</b></i></u></p><p><u><i><b>enter</b></i></u></p>', '<p><span style=\"font-weight: 700;\">bold</span>,&nbsp;<i>italic</i>,&nbsp;<u>underline</u>,&nbsp;<u><i><span style=\"font-weight: 700;\">campur</span></i></u></p><p><u><i><span style=\"font-weight: 700;\">enter inggris</span></i></u></p>', '2025-09-12', 'news_images/6tZ3aXhBUMP4CSKyd8JDHB0VMPG33qEZXXiOWnT0.jpg', NULL, '2025-09-11 20:48:54', '2025-09-18 02:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED DEFAULT NULL,
  `menu_master_id` int(10) UNSIGNED DEFAULT NULL,
  `menu_sub_id` int(10) UNSIGNED DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `content_en` text DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `website_id` varchar(10) DEFAULT NULL,
  `nama_produk` varchar(20) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `keterangan_produk` text DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ukuran_produk_kg` varchar(20) DEFAULT NULL,
  `ukuran_produk_kg_pcs` varchar(20) DEFAULT NULL,
  `ukuran_produk_g` varchar(20) DEFAULT NULL,
  `ukuran_produk_g_pcs` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `active` varchar(10) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `website_id`, `nama_produk`, `product_name`, `keterangan_produk`, `product_description`, `image`, `ukuran_produk_kg`, `ukuran_produk_kg_pcs`, `ukuran_produk_g`, `ukuran_produk_g_pcs`, `tanggal`, `active`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, '1', 'Tameng', 'shield', 'shield 1', 'waoooow', 'products/7f51f77de7d6ec1d106821d48ab23b3b.jpg', '12', '122', '5002', '122', '2025-09-10', 'Y', 1, '2025-09-09 04:12:29', '2025-10-03 09:01:32'),
(5, 1, '2', 'Helm', 'helm', 'helm 1', 'waoooow cooll', 'products/6e816acb5fad585e5d405315c2eec6.png', '12', '122', '5002', '122', '2025-09-10', 'Y', 1, '2025-09-09 04:12:29', '2025-10-03 09:03:29');

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
('w3LuKmwVJzVwB1Hu5YkKsZDaE1vVd5ATxkPDN9eO', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiNnpXMWNtdTcwY1FURzZWQUtUMndSb3kycnNKMmFMSEJqV3IzRVhwbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdWJtZW51Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE5OiJzZWxlY3RlZF93ZWJzaXRlX2lkIjtpOjE7czoyMzoic2VsZWN0ZWRfd2Vic2l0ZV9kb21haW4iO3M6MjQ6Imh0dHBzOi8vd3d3Lm1hcnZlbC5jby5pZCI7czoyMToic2VsZWN0ZWRfd2Vic2l0ZV9uYW1lIjtzOjI1OiJNYXJ2ZWwgQ2luZW1hdGljIFVuaXZlcnNlIjtzOjIyOiJzZWxlY3RlZF93ZWJzaXRlX2ltYWdlIjtzOjU5OiJ3ZWJzaXRlX2ltYWdlc1xTVGwySGNNVWZuQzltQTlFd1dCMmVWeUVockFuSXRRWXdBV0JtVEFaLmpwZyI7fQ==', 1759483590);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `website_id` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `image` varchar(225) NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `user_id`, `website_id`, `title`, `image`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 'Tesarak', 'slides_images/XxcvtYgrRoRGS41o0iMtO4lsCHVT3xhpubJKnpDy.jpg', 1, '2025-09-18 03:55:29', '2025-09-18 04:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'superadmin', NULL, '$2y$12$klnWp4Ad/goivf5rzyAdQ.aL09afXMYKcTHqGVPWhb30MdiNx4umW', NULL, '2025-09-03 04:46:05', '2025-09-03 00:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `website_id` varchar(10) DEFAULT NULL,
  `judul` varchar(20) NOT NULL,
  `link_video` varchar(255) NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `user_id`, `website_id`, `judul`, `link_video`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 'tes kasian', 'videos/QaWQ08oUCA2bRfLaRHcc1S2scZTt3lXXoK5RnUok.mp4', 1, '2025-09-17 10:13:29', '2025-09-18 02:31:28'),
(2, 1, '2', 'tes kasian2', 'videos/QaWQ08oUCA2bRfLaRHcc1S2scZTt3lXXoK5RnUok.mp4', 1, '2025-09-17 10:13:29', '2025-09-17 10:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `image` varchar(225) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `user_id`, `nama`, `domain`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marvel Cinematic Universe', 'https://www.marvel.co.id', 'website_images\\STl2HcMUfnC9mA9EwWB2eVyEhrAnItQYwAWBmTAZ.jpg', '2025-09-12 08:20:16', '2025-10-03 04:13:12'),
(2, 1, 'DC Comic', 'https://www.dc.co.id', 'website_images\\WxS7g420M2kwGV7QIB5fjZaGv2pjfSSNXx0cfSrc.png', '2025-09-12 08:20:16', '2025-10-03 04:12:38');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `menu_master`
--
ALTER TABLE `menu_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_master_menu_website` (`website_id`);

--
-- Indexes for table `menu_sub`
--
ALTER TABLE `menu_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_menu_master` (`menu_master_id`),
  ADD KEY `fk_sub_menu_website` (`website_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_news_user` (`user_id`),
  ADD KEY `fk_news_updated_by` (`updated_by`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pages_master` (`menu_master_id`),
  ADD KEY `fk_pages_sub` (`menu_sub_id`),
  ADD KEY `fk_pages_website` (`website_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_slides_user` (`user_id`),
  ADD KEY `fk_slides_updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_video_user` (`user_id`),
  ADD KEY `fk_video_updatedby` (`updated_by`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_website_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_master`
--
ALTER TABLE `menu_master`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_sub`
--
ALTER TABLE `menu_sub`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_master`
--
ALTER TABLE `menu_master`
  ADD CONSTRAINT `fk_master_menu_website` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_sub`
--
ALTER TABLE `menu_sub`
  ADD CONSTRAINT `fk_sub_menu_master` FOREIGN KEY (`menu_master_id`) REFERENCES `menu_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sub_menu_website` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_news_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `fk_pages_master` FOREIGN KEY (`menu_master_id`) REFERENCES `menu_master` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pages_sub` FOREIGN KEY (`menu_sub_id`) REFERENCES `menu_sub` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pages_website` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `slides`
--
ALTER TABLE `slides`
  ADD CONSTRAINT `fk_slides_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_slides_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `fk_video_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_video_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `website`
--
ALTER TABLE `website`
  ADD CONSTRAINT `fk_website_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
