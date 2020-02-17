-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 07, 2019 lúc 12:55 PM
-- Phiên bản máy phục vụ: 10.3.16-MariaDB
-- Phiên bản PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `demo`
--

CREATE TABLE `demo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `demo`
--

INSERT INTO `demo` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Vũ Công Trường', '2019-10-25 17:00:00', '2019-10-25 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_time` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `title`, `post_time`, `description`, `created_at`, `updated_at`) VALUES
(1, 7, 'sự kiện chịch nhau', '2019-12-06', '4some ,gangbang', '2019-12-06 15:53:25', '2019-12-06 15:53:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `follow_user` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_26_093847_create_demo_table', 1),
(4, '2019_11_07_022835_create_user_tokens', 2),
(17, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(18, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(19, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(20, '2016_06_01_000004_create_oauth_clients_table', 3),
(21, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(22, '2019_11_29_212726_create_user_details', 3),
(24, '2019_12_06_220623_add_fields_to_users', 4),
(26, '2019_12_06_223620_create_experiences', 5),
(28, '2019_12_07_183645_create_follows', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('thanhlong@gmail.com', '23e2380041524d70a1537f4c75ea8f1c', '2019-12-06 03:24:01'),
('thanhlong@gmail.com', 'ae5d60944c7f43f495812753d57bc687', '2019-12-06 03:33:01'),
('vucongtruong1998@gmail.com', '078db269a70743dca6d6e43188f5f578', '2019-12-06 04:02:40'),
('vucongtruong1998@gmail.com', '78488a3de1b54cadaf8b052c28510211', '2019-12-06 04:13:15'),
('thanhlong9704@gmail.com', 'b386d8630f274c0eabdbd829e24e0bc3', '2019-12-07 02:04:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `dob`, `gender`, `address`, `type`, `status`, `created_at`, `updated_at`) VALUES
(4, NULL, NULL, 'vucongtruong98@gmail.com', '', '$2y$10$H7.XMMXqY7UlKcQ7Yt4hJuRveqBPFm3iWxdhvwwEGU1tCkrg4K1ia', NULL, NULL, NULL, 0, NULL, '2019-12-03 07:15:42', '2019-12-03 07:15:42'),
(7, 'Thanh', 'Long', 'thanhlong@gmail.com', 'thanhlong97', '$2y$10$gv5P1r3axzXYp7COb9ypyuMQFTk6gPNu.QhNZI2v76RxPuo1XPTyS', '1998-11-02', 1, 'TPHCM', 1, 1, '2019-12-06 15:33:01', '2019-12-06 15:54:23'),
(10, 'Vũ', 'Trường', 'vucongtruong1998@gmail.com', 'congtruong', '$2y$10$7UQpvH8VSJ5DfOvGJnsq/.6ui.nnsr7VrgMvejnSB9g3GU3nVkJXq', '1998-11-02', 1, 'TPHCM', 1, 1, '2019-12-06 16:13:14', '2019-12-06 16:13:14'),
(11, 'Thanh', 'Long', 'thanhlong9704@gmail.com', 'thanhlong97', '$2y$10$3Dqy.z3EoqUNpgKMymg4MuZoKQ59CvQO.uZmhC/ehr4wr6gpXRQNC', '1998-11-02', 1, 'TPHCM', 1, NULL, '2019-12-07 02:04:31', '2019-12-07 02:04:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `background` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_intro` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `background`, `image`, `image_intro`, `flag`, `description`, `created_at`, `updated_at`) VALUES
(1, 3, 'hurts.png', 'vl.jpg', 'hurts.png', 'ferrari.jpg', 'nothing', '2019-11-29 14:45:30', '2019-12-03 07:02:28'),
(5, 7, 'ace.jpg', 'civic.jpg', 'ferrari.jpg', 'ferrari.jpg', 'nothing !', '2019-12-06 15:33:52', '2019-12-06 15:34:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `access_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `access_token`, `user_id`, `created_at`, `updated_at`) VALUES
(20, 'pgpb-TmItTB5DhObUhMyfYXVV0uif6TcTvS', 3, '2019-12-03 07:05:28', '2019-12-03 07:05:28'),
(22, 'pgpb-7cBD2nkoF1GJGRPRUXbjg5cYjvSggw', 6, '2019-12-06 15:26:50', '2019-12-06 15:26:50'),
(26, 'pgpb-rpd2gtlyj5AJ5TAseq31QxiriyDVrl', 7, '2019-12-06 15:56:18', '2019-12-06 15:56:18');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `demo`
--
ALTER TABLE `demo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
