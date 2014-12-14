-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 15 2014 г., 01:40
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `alcoshop`
--
CREATE DATABASE IF NOT EXISTS `alcoshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `alcoshop`;

-- --------------------------------------------------------

--
-- Структура таблицы `attribute`
--

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE IF NOT EXISTS `attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `unit` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `categoryId`, `unit`) VALUES
(1, 'ABV', 1, '%'),
(2, 'Distillery', 2, NULL),
(3, 'Attr', 1, 'unit');

-- --------------------------------------------------------

--
-- Структура таблицы `attributevalue`
--

DROP TABLE IF EXISTS `attributevalue`;
CREATE TABLE IF NOT EXISTS `attributevalue` (
  `productId` int(11) NOT NULL,
  `attributeId` int(11) NOT NULL,
  `value` varchar(256) NOT NULL,
  PRIMARY KEY (`productId`,`attributeId`),
  KEY `productId` (`productId`),
  KEY `attributeId` (`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attributevalue`
--

INSERT INTO `attributevalue` (`productId`, `attributeId`, `value`) VALUES
(1, 1, '53'),
(2, 1, '40'),
(2, 2, 'Blended'),
(3, 1, '40'),
(3, 2, 'Midleton'),
(4, 1, '35'),
(5, 1, '37');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `photo` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parentId`, `name`, `photo`) VALUES
(1, 0, 'Alcohol', 'files/alcohol.jpg'),
(2, 1, 'Whisky', 'files/whisky.jpeg'),
(3, 1, 'Absinthe', 'files/absent.jpg'),
(4, 1, 'Rum', 'files/rum.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `userId`, `productId`, `text`, `date`) VALUES
(1, 1, 1, 'This product was great in terms of quality. I would definitely buy another!', '2014-12-08'),
(2, 2, 1, 'This product was great in terms of quality. I would definitely buy another!', '2014-12-08'),
(4, 2, 1, 'my new comment', '2014-12-09'),
(5, 1, 3, 'This is the best game computer ever!', '2014-12-09'),
(6, 1, 5, 'some comment about this commodore computer', '2014-12-09');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `totalPrice` decimal(9,2) NOT NULL,
  `date` datetime NOT NULL,
  `paymentStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `userId`, `totalPrice`, `date`, `paymentStatus`) VALUES
(1, 1, '1398.00', '2014-11-03 00:00:00', 1),
(8, 1, '4098.00', '2014-12-08 17:04:50', 0),
(9, 1, '3754.85', '2014-12-09 05:33:57', 0),
(10, 1, '1470.85', '2014-12-09 09:26:51', 0),
(11, 1, '2319.55', '2014-12-09 09:54:41', 0),
(12, 1, '2319.55', '2014-12-09 09:54:50', 0),
(13, 1, '1398.00', '2014-11-03 00:00:00', 1),
(14, 1, '4098.00', '2014-12-08 17:04:50', 0),
(15, 1, '3754.85', '2014-12-09 05:33:57', 0),
(16, 1, '1470.85', '2014-12-09 09:26:51', 0),
(17, 1, '2319.55', '2014-12-09 09:54:41', 0),
(18, 1, '2319.55', '2014-12-09 09:54:50', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pricesnapshot`
--

DROP TABLE IF EXISTS `pricesnapshot`;
CREATE TABLE IF NOT EXISTS `pricesnapshot` (
  `productId` int(11) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `expireDate` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `pricesnapshot`
--

INSERT INTO `pricesnapshot` (`productId`, `price`, `expireDate`, `id`) VALUES
(1, '599.99', '2014-12-02 20:06:20', 1),
(1, '699.99', '2014-12-02 20:07:51', 2),
(4, '999.99', '2014-12-03 01:55:53', 4),
(2, '549.95', '2014-12-08 16:58:28', 5),
(1, '670.99', '2014-12-09 10:00:17', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `photo` varchar(256) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `ratingAmount` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `isAvailable`, `categoryId`, `photo`, `rating`, `ratingAmount`) VALUES
(1, 'La Clandestine', 'A long-term favourite of absinthe lovers, La Clandestine is hand-crafted in Couvet, Switzerland: the village where absinthe was born in the 1790''s. ', '43.51', 1, 3, 'files/6908.jpg', 5, 1),
(2, 'Chivas Regal - 18 Year Old', 'Connoisseurs of Chivas Regal have long appreciated the rich and generous style of Chivas Regal 12 Year Old. This is reflected in Chivas Regal 18 Year Old, which is also characterised by a deep, dark, mellow complexity of the special older whiskies selected for this 18 Year Old blend.\n', '55.64', 1, 2, 'files/2113.jpg', 0, 0),
(3, 'Jameson - Irish Whiskey Magnum', 'Founded in 1780 and produced at Midleton Distillery, Co Cork, by John Jameson and Son. Members of the family are still involved in the business, though in 1966 Jameson became a part of the Irish Distillers Group, who also make Bushmills. When John Jameson opened his distillery in Dublin in 1780 he was carrying on a tradition of whiskey making which had its origins in Ireland over a thousand years ago.', '43.28', 1, 2, 'files/5727.jpg', 3, 1),
(4, 'Jagermeister', 'Usually served as a chilled shot from their now famous Jager'' Tap Machines in pubs around the world, or combined with high-ernergy drinks, or in an explosive Jagerbomb!', '18.55', 1, 1, 'files/751.jpg', 0, 0),
(5, 'Bacardi - Black', 'The richest spirit produced by Bacardi is a blend of selected rums aged for periods of up to four years. ', '21.67', 1, 4, 'files/3971.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `productlist`
--

DROP TABLE IF EXISTS `productlist`;
CREATE TABLE IF NOT EXISTS `productlist` (
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  PRIMARY KEY (`orderId`,`productId`),
  KEY `productId` (`productId`),
  KEY `orderId` (`orderId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `productlist`
--

INSERT INTO `productlist` (`orderId`, `productId`, `quantity`, `price`) VALUES
(1, 1, 2, '699.00'),
(8, 1, 2, '699.00'),
(8, 2, 5, '540.00'),
(9, 1, 5, '670.99'),
(9, 3, 2, '199.95'),
(10, 2, 1, '550.95'),
(10, 3, 2, '199.95'),
(10, 5, 1, '520.00'),
(11, 3, 8, '199.95'),
(12, 3, 8, '199.95');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `roleId` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `passHash` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `roleId`, `email`, `passHash`) VALUES
(1, 'Johnatan Doe', 2, 'user@example.com', 'ee11cbb19052e40b07aac0ca060c23ee'),
(2, 'Daniel Lewis', 1, 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3'),
(5, 'Oleg', 1, 'oleg@oleg.com', '0448d165b9b0a6a07877a8c5cdd11178');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attribute`
--
ALTER TABLE `attribute`
  ADD CONSTRAINT `attribute_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `attributevalue`
--
ALTER TABLE `attributevalue`
  ADD CONSTRAINT `attributevalue_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `attributevalue_ibfk_2` FOREIGN KEY (`attributeId`) REFERENCES `attribute` (`id`);

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pricesnapshot`
--
ALTER TABLE `pricesnapshot`
  ADD CONSTRAINT `pricesnapshot_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `productlist`
--
ALTER TABLE `productlist`
  ADD CONSTRAINT `productlist_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `productlist_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
