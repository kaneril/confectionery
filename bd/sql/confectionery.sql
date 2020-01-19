-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 19 2020 г., 23:50
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
(14, 16, '2020-01-20 01:46:12', 'delete_manager', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(20) NOT NULL CHECK (`login` <> ''),
  `password` varchar(30) NOT NULL CHECK (char_length(`password`) > 6),
  `role` enum('manager','supermanager','anouther') NOT NULL DEFAULT 'manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`id`, `login`, `password`, `role`) VALUES
(1, 'Kate', 'Gfhjkm Rfnz', 'supermanager'),
(2, 'Lena', 'gfhjkm ktyf', 'manager'),
(3, 'Anna', 'gfhjkm fyz', 'manager'),
(4, 'Auto', 'password', 'anouther');

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
) ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `phone_number`, `customer_name`, `created_date`, `packaging_cost`, `production_cost`) VALUES
(1, '89051826930', 'Katherine', '2020-01-19 21:35:24', '0.00', '660.00'),
(2, '89051826930', 'Katherine', '2020-01-19 21:35:43', '0.00', '748.00'),
(3, '89051826930', 'Katherine', '2020-01-19 21:36:04', '0.00', '1750.00'),
(4, '89051826930', 'Katherine', '2020-01-19 21:36:56', '0.00', '19800.00'),
(7, '89051826930', 'Kate', '2020-01-20 01:30:19', '0.00', '1280.00');

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
) ;

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
(30, 7, 9, 8, '5.00');

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
(11, 2, 'new', '2020-01-20 01:44:33', 1);

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
) ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img_url`, `availability`) VALUES
(1, 'Капкейк Мачо', '100.00', '1.jpg', 1),
(2, 'Капкейк Шоколадный мусс', '135.00', '2.jpg', 1),
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
(16, 1, '2020-01-20 01:33:03', '2020-01-20 01:48:56');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_processing`
--
ALTER TABLE `order_processing`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
