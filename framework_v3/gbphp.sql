-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.19 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных gbphp
DROP DATABASE IF EXISTS `gbphp`;
CREATE DATABASE IF NOT EXISTS `gbphp` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gbphp`;

-- Дамп структуры для таблица gbphp.comments
DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.comments: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `product_id`, `text`) VALUES
	(18, 2, 'тест'),
	(19, 1, 'новый'),
	(26, 1, 'Это хороший товар, надо брать!\r\n');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Дамп структуры для таблица gbphp.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_users_fk` (`user_id`),
  KEY `orders_status__fk` (`status_id`),
  CONSTRAINT `orders_status__fk` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  CONSTRAINT `orders_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.orders: ~14 rows (приблизительно)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `date`, `address`, `status_id`, `phone`) VALUES
	(1, 8, '2020-06-30 17:52:13', 'Vladivostok', 3, NULL),
	(7, 8, '2020-07-01 11:41:50', 'Brisbane, South Bank', 2, '8(333)333-33-33'),
	(8, 8, '2020-07-01 12:13:47', 'Vladivostok, Some street, 12-21, 690089', 1, '+7 (924) 339-14-01'),
	(9, 4, '2020-07-02 07:17:34', 'Far far away', 6, '(333)333-33-33'),
	(10, 4, '2020-07-02 07:21:44', 'somewhere', 6, '8 (924) 339-14-33'),
	(11, 4, '2020-07-02 07:35:44', 'nowhere', 1, ' (33) 333-33-33'),
	(13, 1, '2020-08-02 21:59:36', 'fgfhgfhgh', 1, '8 (924) 339-14-01'),
	(14, 1, '2020-08-02 22:00:00', 'fgfhgfhgh', 1, '8 (924) 339-14-01'),
	(15, 1, '2020-08-02 22:02:09', 'fgfhgfhgh', 1, '8 (924) 339-14-01'),
	(16, 1, '2020-08-02 22:02:34', 'fgfhgfhgh', 1, '8 (924) 339-14-01'),
	(17, 1, '2020-08-02 22:02:49', 'fgfhgfhgh', 1, '8 (924) 339-14-01'),
	(18, 1, '2020-08-02 22:09:41', 'hj', 1, '+79 (243) 391-40-15'),
	(19, 1, '2020-08-02 22:34:23', 'mnew', 1, '8 (924) 339-14-01'),
	(20, 1, '2020-08-02 22:35:57', 'my new', 1, '89 (244) 444-14-01'),
	(21, 1, '2020-08-02 22:39:39', 'hjkg', 1, '+7 (924) 339-14-01'),
	(27, 1, NULL, NULL, 1, NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Дамп структуры для таблица gbphp.order_product
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `order_product_products_id_fk` (`product_id`),
  CONSTRAINT `order_product_orders_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.order_product: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` (`order_id`, `product_id`, `price`, `qty`) VALUES
	(1, 1, 123.99, 1),
	(1, 2, 99.99, 2),
	(7, 2, 99.99, 1),
	(8, 1, 123.99, 2),
	(9, 1, 123.99, 8),
	(9, 2, 99.99, 1),
	(10, 2, 99.99, 1),
	(11, 2, 99.99, 5),
	(17, 2, 99.99, 2),
	(17, 4, 120.50, 2),
	(18, 2, 99.99, 1),
	(18, 5, 99.99, 1),
	(19, 2, 99.99, 2),
	(19, 5, 99.99, 5),
	(20, 1, 124.99, 1),
	(20, 4, 120.50, 1),
	(21, 2, 99.99, 1);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;

-- Дамп структуры для таблица gbphp.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.products: ~14 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title`, `price`, `info`, `img`) VALUES
	(1, 'First my product', 124.99, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f17df9c321b2.jpg'),
	(2, 'Вебинар2', 99.99, 'Новый интересный', 'img_5f1918f293261.jpg'),
	(4, 'Rose bush', 120.50, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f0ffbf64e1c1.svg'),
	(5, 'МАРИНЕКС • ', 99.99, 'сюрвейерские услуги Владивосток', 'img_5f1918c9395c3.jpg'),
	(6, 'Конференция по детскому сну • Записи', 123.99, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f0ffc2aa733d.svg'),
	(8, 'dolor', 445.00, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f0ffc9902222.svg'),
	(10, 'consectetur ', 11.00, ' sit amet consectetur adipisicing elit. ', 'img_5f1001522fdf0.svg'),
	(12, ' sit amet', 99.00, 'Loremme ipsum dolor, sit amet consectetur elit. ', 'img_5f191912c16d2.jpg'),
	(13, 'adipisicing ', 99.99, 'сюрвейерские услуги Владивосток', 'img_5f1001b88521b.jpg'),
	(15, 'Notebook', 2999.99, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f1549985c159.jpg'),
	(31, 'Конференция • Записи', 1243.99, 'Loremme ipsum dolor, consectetur adipisicing elit. ', 'img_5f19193152139.jpg'),
	(32, 'TEST', 112.32, 'Loremme ipsum dolor, sit amet consectetur elit. ', 'img_5f1918b4df487.svg'),
	(33, 'Видео2', 123.99, 'Loremme ipsum dolor, sit amet consectetur adipisicing elit. ', 'img_5f1fd6554fc10.jpg'),
	(34, 'Конференция', 99.90, 'Loremme ipsum dolor, consectetur adipisicing elit. ', 'img_5f22385d66105.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица gbphp.statuses
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.statuses: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` (`id`, `status`) VALUES
	(1, 'pending'),
	(2, 'paid'),
	(3, 'shipped'),
	(4, 'complete'),
	(5, 'processing'),
	(6, 'canceled');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;

-- Дамп структуры для таблица gbphp.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fio` varchar(50) NOT NULL COMMENT 'Фио',
  `login` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `is_admin` int NOT NULL DEFAULT '0' COMMENT '0 - user, 1 - admin',
  PRIMARY KEY (`id`),
  KEY `login` (`login`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbphp.users: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `fio`, `login`, `password`, `is_admin`) VALUES
	(1, 'admin_123', 'admin', '$2y$10$gJZeqLFyoZpJQKXL6bvOLuf6s/WPXsKUB5NBJmBxJezTUKQlU/m4e', 1),
	(4, 'zoya_7119', 'test', '$2y$10$eEnGY/Qy18Ppzw2yWxtkAuGPbZa/oEK7UH1HSnvy9vrBE7LhgDyui', 0),
	(8, 'zoya', 'zoya', '$2y$10$65n.vx90GenqUK730Qf3qOzZlbYecW8dhzhpXwdVxPe9yzHtgrXke', 0),
	(9, 'Zoja', 'zajazz', '$2y$10$WKO6M.GTL01XsDtoqI7.D.5sl9/oafUBzYGNQaIMCCL5OsCJt8OE6', 0),
	(17, 'John Doe', 'newone', '$2y$10$tHEsdY37inOU1XN/FhOYYuDJpwe.DPK4x9QQz8HVfa8A7st7SkW6.', 0),
	(18, 'Johnny Done', 'newby', '$2y$10$sUCabOObWfJdwIsg8xBZZeoOEU2eYcukFq0YgJdlFs.Bo6IDlxfsS', 0),
	(19, 'Johnny Done', 'zajazz@ya.ru', '$2y$10$RBWA3Y8PYH5MTAWDBZKe4OmhX7onfsaMFXzpAvLxRcbPbtrqZ7Upy', 0),
	(20, 'Mag Bane', 'brooklyn', '$2y$10$1NwkoYAcSCYbfJjJa41FKeKbhkxAHcMgCZ3.QKz68zaj/qWTW2A36', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
