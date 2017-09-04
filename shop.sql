-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 29 2017 г., 10:57
-- Версия сервера: 10.1.22-MariaDB
-- Версия PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `picture` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`id`, `title`, `picture`) VALUES
(1, 'Computers', '1.jpg'),
(2, 'Mobiles', 'mobs.jpg'),
(5, '4g devices', 'phpAB9B_59a26f0859f452_70400093.JPG');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `cell` int(9) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cart` text NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `comment` text,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `short` varchar(200) DEFAULT NULL,
  `description` text,
  `price` int(100) DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `rest` int(100) DEFAULT NULL,
  `cat` int(11) NOT NULL,
  `other_pics` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `short`, `description`, `price`, `picture`, `rest`, `cat`, `other_pics`) VALUES
(1, 'MacBook Pro Air Sample', '15, 256SSD, 2GB GTX 1000m', 'MacBook Pro Air Sample, 15, 256SSD, 2GB GTX 1000m', 2700, 'php5986_59a4f58b6ad543_76649813.png', 2, 1, '[\"php5987_59a4f58b6b13d3_66739358.png\"]'),
(2, 'Microsoft surface', 'Microsoft surface', 'Microsoft surface', 3000, 'php17B8_59a4f5bc38bbb3_47137082.jpg', 57, 1, '[\"php17B9_59a4f5bc38fa30_43133214.jpg\",\"php17BA_59a4f5bc3938b1_98172326.png\",\"php17CA_59a4f5bc3938b0_71530873.png\"]'),
(3, 'Galaxy S8', 'Galaxy S8', 'Galaxy S8', 2, 'php81C4_59a4f618932270_44425911.png', 700, 2, '[\"php81C5_59a4f6189360f4_30816825.jpg\",\"php81C6_59a4f618939f72_41572634.png\"]'),
(4, 'Mobile', 'Mobile', 'Mobile', 270, 'php18B8_59a4f63f7bc081_60405696.jpg', 27, 2, '[\"php18D9_59a4f63f7c3d88_83129548.jpg\",\"php18E9_59a4f63f7c7c03_65097017.jpg\",\"php18FA_59a4f63f7c7c02_47602616.jpg\",\"php18FB_59a4f63f7d7601_73232967.png\"]'),
(5, '4G Device modem WIFI', '4G Device modem WIFI', '4G Device modem WIFI', 1, 'phpD25B_59a4f6b0a8ca29_11867069.jpg', 170, 5, '[\"phpD25C_59a4f6b0a985a8_42136118.jpg\",\"phpD25D_59a4f6b0a9c425_07102608.jpg\"]'),
(6, 'Notebook ', 'Notebook ', 'Notebook ', 170, 'php67AA_59a4f6d68dbb11_19349672.jpg', 170, 1, '[\"php67BB_59a4f6d68e3816_89474938.jpg\",\"php67BC_59a4f6d68e7691_52554408.png\"]'),
(7, 'Samsung', 'Samsung', 'Samsung', 50, 'php94E5_59a4f723b273e6_53556691.jpg', 50, 2, '[\"php94E6_59a4f723b2b266_27980393.jpg\",\"php94E7_59a4f723b2f0e5_25367314.jpg\",\"php94F7_59a4f723b32f65_12394350.jpg\",\"php9508_59a4f723b32f69_94256308.png\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(400) NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  `registered_from_ip` varchar(100) DEFAULT NULL,
  `avatar` varchar(400) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `thumbnail` varchar(4000) DEFAULT NULL,
  `email_confirmed` tinyint(4) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT '1',
  `cell` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `nick`, `email`, `pass`, `token`, `last_visit`, `registered_from_ip`, `avatar`, `reg_date`, `thumbnail`, `email_confirmed`, `role`, `cell`) VALUES
(7, 'Beks', 'beks.sch@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', 'b08b858025fb5665c36d65176b024a5b', NULL, '127.0.0.1', '20170827135443.jpg', '2017-08-03', '20170827135443.jpg', NULL, 3, 552552039),
(8, 'Beks', 'beks@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', 'df6df01913096aedf781d582441792b2', NULL, '127.0.0.1', '20170827155942.JPG', '2017-08-27', '20170827155942.JPG', NULL, 2, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `user_2` (`user`),
  ADD KEY `user_3` (`user`),
  ADD KEY `user_4` (`user`),
  ADD KEY `user_5` (`user`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat` (`cat`),
  ADD KEY `cat_2` (`cat`),
  ADD KEY `cat_3` (`cat`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `cats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
