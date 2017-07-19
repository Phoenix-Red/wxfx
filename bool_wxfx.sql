-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-19 14:05:14
-- 服务器版本： 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bool_wxfx`
--

-- --------------------------------------------------------

--
-- 表的结构 `fees`
--

CREATE TABLE `fees` (
  `fid` int(10) UNSIGNED NOT NULL,
  `oid` int(11) NOT NULL,
  `byid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `money` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `fees`
--

INSERT INTO `fees` (`fid`, `oid`, `byid`, `uid`, `money`) VALUES
(1, 15, 2, 0, 9.52),
(2, 15, 2, 0, 4.76),
(3, 15, 2, 0, 2.38);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE `goods` (
  `gid` int(10) UNSIGNED NOT NULL,
  `goods_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `goods_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `goods_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`gid`, `goods_name`, `goods_price`, `goods_img`) VALUES
(1, '月季', '23.8', 'goods_1.jpg'),
(2, '玫瑰', '45.6', 'goods_2.jpg'),
(3, '桃花', '30.8', 'goods_3.jpg'),
(4, '妖姬', '55.6', 'goods_4.jpg'),
(5, '月季', '23.8', 'goods_1.jpg'),
(6, '玫瑰', '45.6', 'goods_2.jpg'),
(7, '桃花', '30.8', 'goods_3.jpg'),
(8, '妖姬', '55.6', 'goods_4.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `items`
--

CREATE TABLE `items` (
  `iid` int(10) UNSIGNED NOT NULL,
  `oid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `goods_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(7,2) NOT NULL,
  `amount` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `items`
--

INSERT INTO `items` (`iid`, `oid`, `gid`, `goods_name`, `price`, `amount`) VALUES
(1, 1, 4, '妖姬', 55.60, 2),
(2, 1, 2, '玫瑰', 45.60, 3),
(3, 3, 3, '桃花', 30.80, 1),
(4, 3, 4, '妖姬', 55.60, 2),
(5, 4, 2, '玫瑰', 45.60, 2),
(6, 5, 4, '妖姬', 55.60, 1),
(7, 6, 1, '月季', 23.80, 1),
(8, 7, 8, '妖姬', 55.60, 1),
(9, 8, 2, '玫瑰', 45.60, 1),
(10, 9, 1, '月季', 23.80, 1),
(11, 10, 1, '月季', 23.80, 1),
(12, 11, 1, '月季', 23.80, 1),
(13, 12, 1, '月季', 23.80, 1),
(14, 13, 1, '月季', 23.80, 1),
(15, 14, 1, '月季', 23.80, 1),
(16, 15, 1, '月季', 23.80, 1);

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_06_13_113612_create_goods_table', 2),
('2017_06_13_134329_create_orders_table', 3),
('2017_06_13_134405_create_items_table', 3),
('2017_06_13_152727_create_fees_table', 4);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `oid` int(10) UNSIGNED NOT NULL,
  `ordsn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `xm` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `money` double(7,2) NOT NULL,
  `ispay` tinyint(4) NOT NULL,
  `ordtime` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`oid`, `ordsn`, `uid`, `openid`, `xm`, `address`, `tel`, `money`, `ispay`, `ordtime`) VALUES
(1, '2017061315240419957', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 248.00, 0, 1497338644),
(2, '2017061315252534984', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 0.00, 1, 1497338725),
(3, '2017061315381940665', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '李兴部', '北京市海淀区白水洼77号院', '18518179834', 142.00, 1, 1497339499),
(4, '2017061315433362773', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 91.20, 1, 1497339813),
(5, '2017061315451243771', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 55.60, 1, 1497339912),
(6, '2017061315532718421', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 23.80, 1, 1497340407),
(7, '2017061315570684958', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 55.60, 1, 1497340626),
(8, '2017061315575971074', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 45.60, 1, 1497340679),
(9, '2017061317461826780', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '', '', '', 23.80, 1, 1497347178),
(10, '2017061317501232545', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '123', '123', '123', 23.80, 1, 1497347412),
(11, '2017061317511434980', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '123', '123', '123', 23.80, 1, 1497347474),
(12, '2017061317521483494', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '123', '123', '123', 23.80, 1, 1497347534),
(13, '2017061317525156225', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '123', '123', '123', 23.80, 1, 1497347571),
(14, '2017061317541231801', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', '123', '123', '123', 23.80, 1, 1497347652),
(15, '2017061317560940703', 2, 'oMe36v0LmdQBsI96H8fymPgxC_w4', 'dasd', 'dfas', 'asdas', 23.80, 1, 1497347769);

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtime` int(11) NOT NULL,
  `p1` int(11) NOT NULL DEFAULT '0',
  `p2` int(11) NOT NULL DEFAULT '0',
  `p3` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`uid`, `name`, `openid`, `subtime`, `p1`, `p2`, `p3`, `status`) VALUES
(2, '????????Phoenix_Red????????', 'oMe36v0LmdQBsI96H8fymPgxC_w4', 1497250693, 0, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`iid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `fees`
--
ALTER TABLE `fees`
  MODIFY `fid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `gid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `iid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
