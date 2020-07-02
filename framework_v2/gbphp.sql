-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3305
-- Время создания: Июл 02 2020 г., 16:41
-- Версия сервера: 8.0.19
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gbphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `text`) VALUES
(18, 2, 'тест'),
(19, 1, 'новый'),
(26, 1, 'Это хороший товар, надо брать!\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `address`, `status_id`, `phone`) VALUES
(1, 8, '2020-06-30 17:52:13', 'Vladivostok', 3, NULL),
(7, 8, '2020-07-01 11:41:50', 'Brisbane, South Bank', 2, '8(333)333-33-33'),
(8, 8, '2020-07-01 12:13:47', 'Vladivostok, Some street, 12-21, 690089', 1, '+7 (924) 339-14-01'),
(9, 4, '2020-07-02 07:17:34', 'Far far away', 6, '(333)333-33-33'),
(10, 4, '2020-07-02 07:21:44', 'somewhere', 6, '8 (924) 339-14-33'),
(11, 4, '2020-07-02 07:35:44', 'nowhere', 1, ' (33) 333-33-33');

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `price`, `qty`) VALUES
(1, 1, '123.99', 1),
(1, 2, '99.99', 2),
(7, 2, '99.99', 1),
(8, 1, '123.99', 2),
(9, 1, '123.99', 8),
(9, 2, '99.99', 1),
(10, 2, '99.99', 1),
(11, 2, '99.99', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `info`, `img`) VALUES
(1, 'Первый товар', '123.99', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. ', '1.jpg'),
(2, 'Вебинар', '99.99', 'Новый интересный', 'shapka_10-1536x864.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(1, 'pending'),
(2, 'paid'),
(3, 'shipped'),
(4, 'complete'),
(5, 'processing'),
(6, 'canceled');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fio` varchar(50) NOT NULL COMMENT 'Фио',
  `login` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `is_admin` int NOT NULL DEFAULT '0' COMMENT '0 - user, 1 - admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `login`, `password`, `is_admin`) VALUES
(1, 'admin_123', 'admin', '$2y$10$gJZeqLFyoZpJQKXL6bvOLuf6s/WPXsKUB5NBJmBxJezTUKQlU/m4e', 1),
(4, 'zoya_7119', 'test', '$2y$10$eEnGY/Qy18Ppzw2yWxtkAuGPbZa/oEK7UH1HSnvy9vrBE7LhgDyui', 0),
(8, 'zoya', 'zoya', '$2y$10$65n.vx90GenqUK730Qf3qOzZlbYecW8dhzhpXwdVxPe9yzHtgrXke', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_users_fk` (`user_id`),
  ADD KEY `orders_status__fk` (`status_id`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `order_product_products_id_fk` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_status__fk` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `orders_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_orders_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
