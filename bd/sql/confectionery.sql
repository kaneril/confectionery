-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 20 2020 г., 20:26
-- Версия сервера: 10.4.10-MariaDB
-- Версия PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `confectionery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `log_list`
--

CREATE TABLE `log_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `action_type` enum('add_order','change_order','delete_order','add_product','change_product','delete_product','add_manager','change_manager','delete_manager','change_password') NOT NULL,
  `elem_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `log_list`
--

INSERT INTO `log_list` (`id`, `session_id`, `created_date`, `action_type`, `elem_id`) VALUES
(1, 10, '2020-01-19 21:37:27', 'change_order', 1),
(2, 10, '2020-01-19 21:37:42', 'change_order', 3),
(3, 10, '2020-01-19 21:37:57', 'change_product', 2),
(4, 10, '2020-01-19 21:38:48', 'add_manager', 7),
(5, 11, '2020-01-19 22:38:49', 'change_order', 2),
(6, 12, '2020-01-19 22:39:51', 'change_password', 12),
(7, 15, '2020-01-20 01:31:40', 'change_order', 7),
(8, 15, '2020-01-20 01:32:22', 'change_product', 2),
(9, 15, '2020-01-20 01:32:51', 'change_password', 15),
(10, 16, '2020-01-20 01:44:33', 'change_order', 2),
(11, 16, '2020-01-20 01:45:06', 'add_product', 18),
(12, 16, '2020-01-20 01:45:23', 'change_product', 18),
(13, 16, '2020-01-20 01:45:38', 'delete_product', 18),
(14, 16, '2020-01-20 01:46:12', 'delete_manager', 7),
(15, 17, '2020-01-20 02:20:25', 'change_order', 9),
(16, 17, '2020-01-20 02:21:38', 'change_product', 2),
(17, 18, '2020-01-20 02:25:06', 'change_order', 10),
(18, 18, '2020-01-20 02:26:09', 'change_product', 2),
(19, 18, '2020-01-20 02:26:35', 'change_product', 2),
(20, 18, '2020-01-20 02:27:13', 'add_product', 19),
(21, 19, '2020-01-20 02:28:10', 'delete_order', 10),
(22, 19, '2020-01-20 02:28:55', 'change_product', 19),
(23, 19, '2020-01-20 02:29:09', 'delete_product', 19),
(24, 19, '2020-01-20 02:29:52', 'add_manager', 8),
(25, 19, '2020-01-20 02:30:27', 'change_manager', 8),
(26, 19, '2020-01-20 02:30:39', 'delete_manager', 8),
(27, 19, '2020-01-20 02:34:07', 'change_password', 19),
(28, 20, '2020-01-20 02:48:59', 'change_manager', 4),
(29, 20, '2020-01-20 02:49:32', 'change_manager', 4),
(30, 20, '2020-01-20 02:50:06', 'change_manager', 4),
(31, 20, '2020-01-20 02:50:26', 'change_manager', 4),
(32, 20, '2020-01-20 02:52:08', 'change_manager', 2),
(33, 20, '2020-01-20 02:52:18', 'change_manager', 2),
(34, 20, '2020-01-20 02:52:30', 'change_manager', 2),
(35, 20, '2020-01-20 02:52:55', 'change_manager', 2),
(36, 20, '2020-01-20 02:53:23', 'change_manager', 2),
(37, 20, '2020-01-20 02:55:06', 'change_manager', 2),
(38, 20, '2020-01-20 02:56:50', 'change_manager', 2),
(39, 20, '2020-01-20 02:57:07', 'change_manager', 2),
(40, 20, '2020-01-20 02:57:35', 'change_manager', 2),
(41, 20, '2020-01-20 02:58:46', 'change_manager', 2),
(42, 20, '2020-01-20 02:58:59', 'change_manager', 2),
(43, 20, '2020-01-20 02:59:22', 'change_manager', 2),
(44, 20, '2020-01-20 02:59:44', 'change_manager', 2),
(45, 20, '2020-01-20 03:00:02', 'change_manager', 2),
(46, 20, '2020-01-20 03:00:14', 'change_manager', 2),
(47, 20, '2020-01-20 03:03:33', 'change_manager', 2),
(48, 20, '2020-01-20 03:03:48', 'change_manager', 2),
(49, 20, '2020-01-20 03:04:04', 'change_manager', 2),
(50, 20, '2020-01-20 03:04:16', 'change_manager', 2),
(51, 20, '2020-01-20 03:04:51', 'change_password', 20),
(52, 20, '2020-01-20 03:05:43', 'change_manager', 2),
(53, 20, '2020-01-20 03:05:51', 'change_manager', 2),
(54, 20, '2020-01-20 03:09:22', 'change_password', 20),
(55, 20, '2020-01-20 03:10:08', 'change_password', 20),
(56, 20, '2020-01-20 03:12:43', 'change_password', 20),
(57, 20, '2020-01-20 03:13:24', 'change_password', 20),
(58, 20, '2020-01-20 03:13:59', 'change_password', 20),
(59, 21, '2020-01-20 03:18:11', 'change_order', 11),
(60, 21, '2020-01-20 03:18:50', 'change_order', 11),
(61, 21, '2020-01-20 03:19:47', 'change_product', 2),
(62, 21, '2020-01-20 03:20:14', 'add_product', 20),
(63, 21, '2020-01-20 03:20:37', 'change_product', 2),
(64, 21, '2020-01-20 03:20:49', 'change_product', 20),
(65, 22, '2020-01-20 03:21:33', 'delete_product', 20),
(66, 22, '2020-01-20 03:22:01', 'delete_order', 11),
(67, 22, '2020-01-20 03:22:42', 'change_manager', 2),
(68, 22, '2020-01-20 03:22:56', 'change_manager', 2),
(69, 22, '2020-01-20 03:23:08', 'add_manager', 9),
(70, 22, '2020-01-20 03:23:21', 'delete_manager', 9),
(71, 22, '2020-01-20 03:25:13', 'change_password', 22),
(72, 22, '2020-01-20 03:25:32', 'change_manager', 1),
(73, 24, '2020-01-20 11:22:16', 'change_order', 2),
(74, 24, '2020-01-20 11:22:30', 'change_order', 2),
(75, 24, '2020-01-20 11:22:52', 'change_order', 3),
(76, 24, '2020-01-20 11:23:26', 'change_order', 2),
(77, 24, '2020-01-20 11:27:48', 'change_order', 1),
(78, 25, '2020-01-20 12:45:01', 'change_order', 3),
(79, 25, '2020-01-20 12:46:17', 'change_product', 2),
(80, 25, '2020-01-20 12:46:36', 'change_product', 2),
(81, 29, '2020-01-20 21:20:14', 'change_password', 29),
(82, 29, '2020-01-20 21:21:31', 'change_password', 29),
(83, 29, '2020-01-20 21:26:51', 'change_password', 29),
(84, 31, '2020-01-20 21:44:11', 'change_password', 31),
(85, 31, '2020-01-20 21:45:16', 'change_password', 31),
(86, 31, '2020-01-20 21:48:15', 'change_password', 31),
(87, 31, '2020-01-20 21:49:52', 'change_password', 31),
(88, 31, '2020-01-20 21:50:51', 'change_password', 31),
(89, 32, '2020-01-20 21:53:19', 'change_manager', 2),
(90, 32, '2020-01-20 21:53:39', 'change_manager', 3),
(91, 32, '2020-01-20 21:53:51', 'change_manager', 4),
(92, 32, '2020-01-20 21:58:15', 'add_manager', 10),
(93, 32, '2020-01-20 21:59:11', 'change_manager', 10),
(94, 32, '2020-01-20 22:05:19', 'change_manager', 10),
(95, 32, '2020-01-20 22:06:29', 'change_manager', 10),
(96, 32, '2020-01-20 22:06:47', 'change_manager', 10),
(97, 33, '2020-01-20 22:18:57', 'change_password', 33),
(98, 33, '2020-01-20 22:19:34', 'change_password', 33),
(99, 33, '2020-01-20 22:20:07', 'change_password', 33),
(100, 33, '2020-01-20 22:20:45', 'change_password', 33),
(101, 33, '2020-01-20 22:21:15', 'change_manager', 1),
(102, 34, '2020-01-20 22:23:42', 'change_password', 34),
(103, 34, '2020-01-20 22:24:11', 'change_password', 34),
(104, 34, '2020-01-20 22:24:37', 'change_password', 34);

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(20) NOT NULL CHECK (`login` <> ''),
  `password` varchar(255) NOT NULL,
  `role` enum('manager','supermanager','anouther') NOT NULL DEFAULT 'manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`id`, `login`, `password`, `role`) VALUES
(1, 'Kate', '$2y$10$M9FApaIOyILjLaYEhuc2Ge98navuaV7u2Cu/HhqWAl0awRE5VsRO.', 'supermanager'),
(2, 'Lena', '$2y$10$2cU7zVAaKU7W2ixaWGa6T.S2KhV3Lb8aOH5XKo9JI5aA6dsvkgbTi', 'manager'),
(3, 'Anna', '$2y$10$Y8I9PsTZaQTgD0Y/Lr7ywO1IZ0IhB5GY9fuEZhd/OOk9Xy87NYy/a', 'manager'),
(4, 'Auto', '$2y$10$rOFON0O9p4p7SM2bT7A67OxadMWo2dfBY75G0efc5rWALN0Lm8Pxm', 'anouther'),
(10, 'Katherine', '$2y$10$NO0LSP9GBuW6uoprefpxcO0Vea5YA9lQGAVRjRzzimyx1YqT8UJd2', 'anouther');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `packaging_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `production_cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `phone_number`, `customer_name`, `created_date`, `packaging_cost`, `production_cost`) VALUES
(1, '89051826930', 'Katherine', '2020-01-19 21:35:24', '0.00', '660.00'),
(2, '89051826930', 'Katherine', '2020-01-19 21:35:43', '0.00', '748.00'),
(3, '89051826930', 'Katherine', '2020-01-19 21:36:04', '0.00', '1750.00'),
(4, '89051826930', 'Katherine', '2020-01-19 21:36:56', '0.00', '19800.00'),
(7, '89051826930', 'Kate', '2020-01-20 01:30:19', '0.00', '1280.00'),
(8, '89051826930', 'Katherine', '2020-01-20 02:15:38', '0.00', '1205.00'),
(9, '89051826930', 'Kate', '2020-01-20 02:19:35', '0.00', '1425.00');

-- --------------------------------------------------------

--
-- Структура таблицы `order_list`
--

CREATE TABLE `order_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL,
  `cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `product_id`, `quantity`, `cost`) VALUES
(1, 1, 1, 1, '100.00'),
(2, 1, 2, 1, '120.00'),
(3, 1, 3, 1, '120.00'),
(4, 1, 4, 1, '120.00'),
(5, 1, 5, 1, '100.00'),
(6, 1, 6, 1, '100.00'),
(7, 2, 1, 3, '100.00'),
(8, 2, 7, 3, '50.00'),
(9, 2, 8, 4, '40.00'),
(10, 2, 9, 3, '6.00'),
(11, 2, 10, 4, '30.00'),
(12, 3, 1, 3, '100.00'),
(13, 3, 4, 3, '120.00'),
(14, 3, 5, 4, '100.00'),
(15, 3, 6, 4, '100.00'),
(16, 3, 7, 3, '50.00'),
(17, 3, 8, 3, '40.00'),
(18, 3, 9, 4, '5.00'),
(19, 4, 1, 30, '100.00'),
(20, 4, 2, 30, '120.00'),
(21, 4, 3, 30, '120.00'),
(22, 4, 4, 30, '120.00'),
(23, 4, 5, 30, '100.00'),
(24, 4, 6, 30, '100.00'),
(25, 7, 4, 1, '120.00'),
(26, 7, 5, 3, '100.00'),
(27, 7, 6, 3, '100.00'),
(28, 7, 7, 4, '50.00'),
(29, 7, 8, 8, '40.00'),
(30, 7, 9, 8, '5.00'),
(31, 8, 1, 2, '100.00'),
(32, 8, 2, 3, '135.00'),
(33, 8, 3, 4, '120.00'),
(34, 8, 10, 4, '30.00'),
(35, 9, 1, 3, '100.00'),
(36, 9, 2, 3, '135.00'),
(37, 9, 3, 3, '120.00'),
(38, 9, 4, 3, '120.00');

-- --------------------------------------------------------

--
-- Структура таблицы `order_processing`
--

CREATE TABLE `order_processing` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_status` enum('processed','new','made','received','canceled') NOT NULL,
  `changing_date` datetime NOT NULL DEFAULT current_timestamp(),
  `manager_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_processing`
--

INSERT INTO `order_processing` (`id`, `order_id`, `order_status`, `changing_date`, `manager_id`) VALUES
(1, 1, 'new', '2020-01-19 21:35:25', 4),
(2, 2, 'new', '2020-01-19 21:35:43', 4),
(3, 3, 'new', '2020-01-19 21:36:04', 4),
(4, 4, 'new', '2020-01-19 21:36:56', 4),
(5, 1, 'processed', '2020-01-19 21:37:27', 1),
(6, 3, 'processed', '2020-01-19 21:37:42', 1),
(7, 2, 'new', '2020-01-19 22:35:19', 1),
(8, 2, 'new', '2020-01-19 22:38:49', 1),
(9, 7, 'new', '2020-01-20 01:30:19', 4),
(10, 7, 'new', '2020-01-20 01:31:40', 2),
(11, 2, 'new', '2020-01-20 01:44:33', 1),
(12, 8, 'new', '2020-01-20 02:15:38', 4),
(13, 9, 'new', '2020-01-20 02:19:35', 4),
(14, 9, 'processed', '2020-01-20 02:20:25', 2),
(20, 2, 'processed', '2020-01-20 11:22:16', 1),
(21, 2, 'made', '2020-01-20 11:22:30', 1),
(22, 3, 'made', '2020-01-20 11:22:52', 1),
(23, 2, 'received', '2020-01-20 11:23:26', 1),
(24, 1, 'received', '2020-01-20 11:27:48', 1),
(25, 3, 'received', '2020-01-20 12:45:01', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img_url` varchar(200) NOT NULL DEFAULT '0.jpg',
  `availability` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img_url`, `availability`) VALUES
(1, 'Капкейк Мачо', '100.00', '1.jpg', 1),
(2, 'Капкейк Шоколадный мусс', '135.00', '2.jpg', 0),
(3, 'Капкейк Летний микс', '120.00', '3.jpg\r', 1),
(4, 'Капкейк Фреш', '120.00', '4.jpg\r', 1),
(5, 'Капкейк Оранжевое настроение', '100.00', '5.jpg', 1),
(6, 'Капкейк Вишенка', '100.00', '6.jpg', 1),
(7, 'Торт Воздушное облако', '50.00', '7.jpg\r', 1),
(8, 'Эклер Мечта', '40.00', '8.jpg\r', 1),
(9, 'Печенье По-домашнему', '5.00', '9.jpg\r', 1),
(10, 'Трубочка вафельная', '30.00', '10.jpg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `manager_id` int(10) UNSIGNED NOT NULL,
  `begin_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `manager_id`, `begin_date`, `end_date`) VALUES
(1, 1, '2020-01-19 15:54:01', '2020-01-19 15:55:47'),
(2, 2, '2020-01-19 15:56:15', '2020-01-19 15:56:20'),
(3, 1, '2020-01-19 16:26:57', '2020-01-19 16:28:03'),
(4, 1, '2020-01-19 16:28:23', '2020-01-19 16:41:42'),
(5, 1, '2020-01-19 16:47:25', '2020-01-19 17:42:41'),
(6, 1, '2020-01-19 17:42:51', '2020-01-19 17:54:26'),
(7, 1, '2020-01-19 17:59:33', '2020-01-19 18:32:41'),
(8, 1, '2020-01-19 18:32:48', '2020-01-19 21:17:17'),
(9, 3, '2020-01-19 21:17:58', '2020-01-19 21:24:57'),
(10, 1, '2020-01-19 21:25:05', '2020-01-19 22:34:25'),
(11, 1, '2020-01-19 22:34:38', '2020-01-19 22:39:07'),
(12, 2, '2020-01-19 22:39:16', '2020-01-19 22:39:55'),
(13, 1, '2020-01-19 22:40:05', '2020-01-20 00:19:51'),
(14, 1, '2020-01-20 00:20:20', '2020-01-20 01:22:46'),
(15, 2, '2020-01-20 01:31:18', '2020-01-20 01:32:54'),
(16, 1, '2020-01-20 01:33:03', '2020-01-20 01:48:56'),
(17, 2, '2020-01-20 02:19:58', '2020-01-20 02:22:45'),
(18, 2, '2020-01-20 02:24:27', '2020-01-20 02:27:16'),
(19, 1, '2020-01-20 02:27:49', '2020-01-20 02:34:47'),
(20, 1, '2020-01-20 02:48:42', '2020-01-20 03:16:16'),
(21, 2, '2020-01-20 03:17:36', '2020-01-20 03:20:55'),
(22, 1, '2020-01-20 03:21:15', '2020-01-20 03:25:41'),
(23, 1, '2020-01-20 10:28:33', '2020-01-20 11:11:31'),
(24, 1, '2020-01-20 11:20:51', '2020-01-20 11:45:36'),
(25, 1, '2020-01-20 12:09:50', '2020-01-20 12:46:39'),
(26, 1, '2020-01-20 12:47:00', '2020-01-20 12:49:06'),
(27, 2, '2020-01-20 12:49:46', '2020-01-20 13:04:48'),
(28, 1, '2020-01-20 13:04:56', '2020-01-20 13:13:17'),
(29, 1, '2020-01-20 21:19:51', '2020-01-20 21:32:58'),
(30, 1, '2020-01-20 21:33:09', '2020-01-20 21:33:14'),
(31, 1, '2020-01-20 21:42:52', '2020-01-20 21:51:00'),
(32, 1, '2020-01-20 21:51:25', '2020-01-20 22:17:08'),
(33, 1, '2020-01-20 22:17:20', '2020-01-20 22:23:11'),
(34, 2, '2020-01-20 22:23:21', '2020-01-20 22:24:51'),
(35, 2, '2020-01-20 22:25:00', '2020-01-20 22:25:02'),
(36, 3, '2020-01-20 22:25:12', '2020-01-20 22:25:14');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `log_list`
--
ALTER TABLE `log_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_sessions_fk` (`session_id`);

--
-- Индексы таблицы `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_list_orders_fk` (`order_id`),
  ADD KEY `order_list_products_fk` (`product_id`);

--
-- Индексы таблицы `order_processing`
--
ALTER TABLE `order_processing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order__processing_orders_fk` (`order_id`),
  ADD KEY `order_processing_managers_fk` (`manager_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_managers_fk` (`manager_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `log_list`
--
ALTER TABLE `log_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `order_processing`
--
ALTER TABLE `order_processing`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `log_list`
--
ALTER TABLE `log_list`
  ADD CONSTRAINT `logs_sessions_fk` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_orders_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_list_products_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_processing`
--
ALTER TABLE `order_processing`
  ADD CONSTRAINT `order__processing_orders_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_processing_managers_fk` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_managers_fk` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
