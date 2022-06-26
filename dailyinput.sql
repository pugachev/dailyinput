-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 6 月 26 日 07:06
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `dailyinput`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `dailycalorie`
--

CREATE TABLE `dailycalorie` (
  `id` int(3) UNSIGNED NOT NULL,
  `tgtdate` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '対象日',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(3) NOT NULL DEFAULT 0,
  `calorie` int(4) DEFAULT NULL,
  `picdata` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delflag` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `dailycalorie`
--

INSERT INTO `dailycalorie` (`id`, `tgtdate`, `category`, `item`, `quantity`, `calorie`, `picdata`, `delflag`, `created_at`, `updated_at`) VALUES
(1, '', 'foods', '1002', 2, 1000, '', 0, '2022-06-05 13:16:46', '2022-06-05 13:16:46'),
(2, '', 'foods', '1002', 1, 1000, '', 0, '2022-06-05 13:17:16', '2022-06-05 13:17:16'),
(3, '2022-06-26', 'foods', '1014', 1, 170, NULL, 0, '2022-06-26 02:25:24', '2022-06-26 02:25:24');

-- --------------------------------------------------------

--
-- テーブルの構造 `dailyspending`
--

CREATE TABLE `dailyspending` (
  `id` int(3) UNSIGNED NOT NULL,
  `tgtdate` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '対象日',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(3) NOT NULL DEFAULT 0,
  `price` int(4) DEFAULT NULL,
  `delflag` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `dailyspending`
--

INSERT INTO `dailyspending` (`id`, `tgtdate`, `category`, `item`, `quantity`, `price`, `delflag`, `created_at`, `updated_at`) VALUES
(8, '2022-06-19', 'publiccharge', '4004', 1, 5000, 0, '2022-06-19 12:00:28', '2022-06-19 14:26:24'),
(9, '2022-06-19', 'foods', '1003', 3, 333, NULL, '2022-06-19 12:00:42', '2022-06-19 12:00:42'),
(15, '2022-06-20', 'eatingout', '6002', 1, 500, 0, '2022-06-19 15:08:35', '2022-06-19 15:08:35'),
(16, '2022-06-20', 'necessities', '1010', 1, 333, 0, '2022-06-19 15:08:55', '2022-06-19 15:08:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item` int(3) NOT NULL,
  `itemname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `item`, `itemname`) VALUES
(2, 1001, 'カレー'),
(3, 1002, 'ラーメン'),
(4, 1003, 'うどん'),
(5, 1004, '蕎麦'),
(6, 1005, '中華そば'),
(7, 1006, 'チキン'),
(8, 1007, 'コロッケ'),
(9, 1008, '野菜'),
(10, 1009, 'お肉'),
(11, 1010, 'ハンバーグ'),
(12, 1011, 'アルコール'),
(13, 1012, 'お菓子'),
(14, 2001, 'トイレ用品'),
(15, 2002, 'お風呂用品'),
(16, 2003, '台所用品'),
(17, 2004, '洗濯用品'),
(18, 2005, '掃除用品'),
(19, 3001, 'PC用品'),
(20, 3002, 'Kindle本'),
(21, 3003, 'サプリメント'),
(22, 3004, 'アロマオ用品'),
(23, 3005, '仏具用品'),
(24, 4001, '水道代'),
(25, 4002, 'ガス代'),
(26, 4003, '光熱費'),
(27, 4004, 'NHK'),
(28, 5001, '歯医者'),
(29, 5002, '内科'),
(30, 5003, '外科'),
(31, 5004, '検査'),
(32, 6001, '中華'),
(33, 6002, 'ファストーフード'),
(34, 6003, '洋食'),
(35, 6004, '和食'),
(36, 1014, 'パン');

-- --------------------------------------------------------

--
-- テーブルの構造 `settings`
--

CREATE TABLE `settings` (
  `id` int(3) UNSIGNED NOT NULL,
  `tgtdate` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '対象日付',
  `maxcalorie` int(4) DEFAULT 0,
  `maxspending` int(5) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `settings`
--

INSERT INTO `settings` (`id`, `tgtdate`, `maxcalorie`, `maxspending`, `created_at`, `updated_at`) VALUES
(38, '2022-06-19', 1610, 1600, '2022-06-19 09:03:49', '2022-06-19 09:18:30');

-- --------------------------------------------------------

--
-- テーブルの構造 `stock`
--

CREATE TABLE `stock` (
  `id` int(3) UNSIGNED NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item` int(5) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `delflag` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `stock`
--

INSERT INTO `stock` (`id`, `category`, `item`, `quantity`, `delflag`, `created_at`, `updated_at`) VALUES
(4, 'foods', 1002, 23, NULL, '2022-06-05 13:12:01', '2022-06-19 00:04:30'),
(5, 'foods', 1001, 2, NULL, '2022-06-18 23:58:17', '2022-06-18 23:58:17'),
(6, 'foods', 1005, 5, NULL, '2022-06-19 02:58:49', '2022-06-19 02:58:49'),
(7, 'foods', 1007, 1, NULL, '2022-06-19 02:59:11', '2022-06-19 02:59:11');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `dailycalorie`
--
ALTER TABLE `dailycalorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- テーブルのインデックス `dailyspending`
--
ALTER TABLE `dailyspending`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- テーブルのインデックス `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `dailycalorie`
--
ALTER TABLE `dailycalorie`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `dailyspending`
--
ALTER TABLE `dailyspending`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- テーブルの AUTO_INCREMENT `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- テーブルの AUTO_INCREMENT `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
