-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hew_07`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_buy_product`
--

CREATE TABLE `buyer_buy_product` (
  `id` int(9) NOT NULL,
  `product_id` int(9) DEFAULT NULL,
  `user_id` int(9) DEFAULT NULL,
  `quantity` int(5) DEFAULT NULL,
  `buy_price` int(10) DEFAULT NULL,
  `buy_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_list`
--

CREATE TABLE `buyer_list` (
  `id` int(8) NOT NULL,
  `f_name` varchar(10) DEFAULT NULL,
  `l_name` varchar(10) DEFAULT NULL,
  `postal_code` int(7) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_login`
--

CREATE TABLE `buyer_login` (
  `id` int(8) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `pass` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_pay`
--

CREATE TABLE `buyer_pay` (
  `id` int(9) NOT NULL,
  `trade_id` int(9) DEFAULT NULL,
  `method` varchar(20) DEFAULT NULL,
  `credit_id` int(9) DEFAULT NULL,
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_plofile`
--

CREATE TABLE `buyer_plofile` (
  `id` int(11) NOT NULL,
  `n_name` varchar(20) NOT NULL,
  `introduction` varchar(500) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `buyer_plofile`
--

INSERT INTO `buyer_plofile` (`id`, `n_name`, `introduction`, `user_id`) VALUES
(1, 'アヴリルラヴィーン', 'hello', 'hirao0817'),
(2, 'ビヨンセ', 'shall we dance', 'biyonse1111');

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_question`
--

CREATE TABLE `buyer_question` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `type` int(2) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `post_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `buyer_question`
--

INSERT INTO `buyer_question` (`id`, `user_id`, `type`, `msg`, `post_time`) VALUES
(1, '0', 0, 'aaa', '2020-02-24 15:23:16'),
(2, '0', 0, 'aaa', '2020-02-24 15:24:30'),
(3, '0', 0, 'aaa', '2020-02-24 15:26:37');

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_status`
--

CREATE TABLE `buyer_status` (
  `buyer_id` varchar(20) NOT NULL,
  `exp` int(11) NOT NULL DEFAULT '0',
  `exp_leave` int(11) NOT NULL DEFAULT '100',
  `lv` int(3) NOT NULL DEFAULT '1',
  `score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buyer_trade`
--

CREATE TABLE `buyer_trade` (
  `id` int(9) NOT NULL,
  `buy_id` int(9) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `creditcard_list`
--

CREATE TABLE `creditcard_list` (
  `id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `financial_code` varchar(20) DEFAULT NULL,
  `branch_code` int(10) DEFAULT NULL,
  `number` int(20) DEFAULT NULL,
  `expriation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorite_list`
--

CREATE TABLE `favorite_list` (
  `id` int(9) NOT NULL,
  `user_id` int(9) DEFAULT NULL,
  `shop_id` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `news_list`
--

CREATE TABLE `news_list` (
  `id` int(9) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `detail` text,
  `news_type` int(1) DEFAULT NULL,
  `send_to` int(9) DEFAULT NULL,
  `paste_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `news_type`
--

CREATE TABLE `news_type` (
  `id` int(9) NOT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_list`
--

CREATE TABLE `shop_list` (
  `id` varchar(20) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `postal_code` int(7) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `tel` int(10) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `detail` text,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shop_list`
--

INSERT INTO `shop_list` (`id`, `name`, `postal_code`, `address1`, `address2`, `tel`, `mail`, `detail`, `registration_date`, `delete_time`) VALUES
('heiwado', '平和堂', 1238989, '大阪府大阪市梅田', NULL, 902338383, 'jifsjdkk@gmal.com', NULL, '2020-02-15 20:09:14', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_login`
--

CREATE TABLE `shop_login` (
  `id` int(9) NOT NULL,
  `shop_id` varchar(20) DEFAULT NULL,
  `pass` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shop_login`
--

INSERT INTO `shop_login` (`id`, `shop_id`, `pass`) VALUES
(1, 'heiwado', 'heiwado');

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_plofile`
--

CREATE TABLE `shop_plofile` (
  `id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `introduction` varchar(500) NOT NULL,
  `shop_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shop_plofile`
--

INSERT INTO `shop_plofile` (`id`, `s_name`, `introduction`, `shop_id`) VALUES
(1, '平和堂 ', '安いよ', 'heiwado');

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_product`
--

CREATE TABLE `shop_product` (
  `id` int(11) NOT NULL,
  `shop_product_id` varchar(40) NOT NULL,
  `shop_id` varchar(20) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `maker_id` varchar(15) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `maker_name` varchar(50) NOT NULL,
  `code_class` int(1) NOT NULL,
  `file_name` varchar(50) NOT NULL DEFAULT 'no.png',
  `price` int(11) NOT NULL,
  `del_flg` int(1) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shop_product`
--

INSERT INTO `shop_product` (`id`, `shop_product_id`, `shop_id`, `product_id`, `maker_id`, `product_name`, `maker_name`, `code_class`, `file_name`, `price`, `del_flg`, `create_at`) VALUES
(3, 'biyonse_9999999999993', 'biyonse', '2147483647', '9999999', 'イチゴ', '明治', 0, '0', 222, 0, '2020-03-01 04:27:50'),
(4, 'biyonse_9999999999993', 'biyonse', '2147483647', '9999999', 'イチゴ', '明治', 0, '0', 222, 0, '2020-03-01 04:29:51'),
(5, 'biyonse_2222222222222', 'biyonse', '2147483647', '2222222', 'おっとっと', '明治', 0, 'biyonse_2222222222222.jpg', 89, 0, '2020-03-01 04:34:24'),
(6, 'biyonse_44444444', 'biyonse', '44444444', '4444444', 'パイナップル', 'たねや', 0, '0', 123, 0, '2020-03-01 04:42:04'),
(7, 'biyonse_1234567890123', 'biyonse', '2147483647', '1234567', 'ウメッシュ', 'サントリー', 0, '0', 900, 0, '2020-03-01 04:43:50'),
(8, 'biyonse_8888888888888', 'biyonse', '2147483647', '8888888', 'チーズ', 'カントリー', 0, '0', 500, 0, '2020-03-01 04:46:20'),
(9, 'biyonse_5555555555555', 'biyonse', '2147483647', '5555555', '雪見だいふく', '雪印', 0, '0', 1222, 0, '2020-03-01 04:48:29'),
(10, 'biyonse_5555555555555', 'biyonse', '2147483647', '5555555', 'モナカ', '雪印', 0, '0', 1222, 0, '2020-03-01 04:58:39'),
(11, 'biyonse_5555555555555', 'biyonse', '2147483647', '5555555', '雪見だいふく', '雪印', 0, '0', 1222, 0, '2020-03-01 04:59:51'),
(12, 'biyonse_5555555555555', 'biyonse', '2147483647', '5555555', '雪見だいふく', '雪印', 0, '0', 1222, 0, '2020-03-01 05:00:51'),
(13, 'biyonse_6666666666666', 'biyonse', '6666666666666', '6666666', 'サイコロステーキ', 'げんさん', 0, '0', 999, 0, '2020-03-01 05:06:06');

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_question`
--

CREATE TABLE `shop_question` (
  `id` int(11) NOT NULL,
  `shop_id` varchar(20) NOT NULL,
  `type` int(2) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `post_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shop_question`
--

INSERT INTO `shop_question` (`id`, `shop_id`, `type`, `msg`, `post_time`) VALUES
(1, '0', 0, 'aaaa', '2020-02-24 15:54:55'),
(2, '0', 0, 'aaaa', '2020-02-24 15:55:16');

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_sell_product`
--

CREATE TABLE `shop_sell_product` (
  `id` int(9) NOT NULL,
  `shop_id` int(9) NOT NULL,
  `product_id` int(9) DEFAULT NULL,
  `price_cut` int(10) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `paste_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `close_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer_buy_product`
--
ALTER TABLE `buyer_buy_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buyer_list`
--
ALTER TABLE `buyer_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_login`
--
ALTER TABLE `buyer_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `buyer_pay`
--
ALTER TABLE `buyer_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_id` (`trade_id`),
  ADD KEY `credit_id` (`credit_id`);

--
-- Indexes for table `buyer_plofile`
--
ALTER TABLE `buyer_plofile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_question`
--
ALTER TABLE `buyer_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_status`
--
ALTER TABLE `buyer_status`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `buyer_trade`
--
ALTER TABLE `buyer_trade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buy_id` (`buy_id`);

--
-- Indexes for table `creditcard_list`
--
ALTER TABLE `creditcard_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `favorite_list`
--
ALTER TABLE `favorite_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `news_list`
--
ALTER TABLE `news_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_type` (`news_type`),
  ADD KEY `send_to` (`send_to`);

--
-- Indexes for table `news_type`
--
ALTER TABLE `news_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_list`
--
ALTER TABLE `shop_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_login`
--
ALTER TABLE `shop_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_plofile`
--
ALTER TABLE `shop_plofile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_product`
--
ALTER TABLE `shop_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_question`
--
ALTER TABLE `shop_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_sell_product`
--
ALTER TABLE `shop_sell_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_id` (`shop_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer_plofile`
--
ALTER TABLE `buyer_plofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `buyer_question`
--
ALTER TABLE `buyer_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shop_login`
--
ALTER TABLE `shop_login`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_plofile`
--
ALTER TABLE `shop_plofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_product`
--
ALTER TABLE `shop_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shop_question`
--
ALTER TABLE `shop_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `buyer_buy_product`
--
ALTER TABLE `buyer_buy_product`
  ADD CONSTRAINT `buyer_buy_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `shop_sell_product` (`id`),
  ADD CONSTRAINT `buyer_buy_product_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `buyer_login` (`id`);

--
-- テーブルの制約 `buyer_login`
--
ALTER TABLE `buyer_login`
  ADD CONSTRAINT `buyer_login_ibfk_1` FOREIGN KEY (`id`) REFERENCES `buyer_list` (`id`);

--
-- テーブルの制約 `buyer_pay`
--
ALTER TABLE `buyer_pay`
  ADD CONSTRAINT `buyer_pay_ibfk_1` FOREIGN KEY (`trade_id`) REFERENCES `buyer_trade` (`id`),
  ADD CONSTRAINT `buyer_pay_ibfk_2` FOREIGN KEY (`credit_id`) REFERENCES `creditcard_list` (`id`);

--
-- テーブルの制約 `buyer_trade`
--
ALTER TABLE `buyer_trade`
  ADD CONSTRAINT `buyer_trade_ibfk_1` FOREIGN KEY (`buy_id`) REFERENCES `shop_sell_product` (`id`);

--
-- テーブルの制約 `creditcard_list`
--
ALTER TABLE `creditcard_list`
  ADD CONSTRAINT `creditcard_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `buyer_login` (`id`);

--
-- テーブルの制約 `news_list`
--
ALTER TABLE `news_list`
  ADD CONSTRAINT `news_list_ibfk_1` FOREIGN KEY (`news_type`) REFERENCES `news_type` (`id`),
  ADD CONSTRAINT `news_list_ibfk_2` FOREIGN KEY (`send_to`) REFERENCES `buyer_login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
