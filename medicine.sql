-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 06 2018 г., 14:43
-- Версия сервера: 10.1.36-MariaDB
-- Версия PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `medicine`
--

CREATE TABLE `medicine` (
  `id_medicine` int(11) NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `cost` int(11) NOT NULL,
  `available_in_warehouse` tinyint(1) NOT NULL,
  `amount` int(11) NOT NULL,
  `average_rating_by_medicine` float NOT NULL,
  `search_by_medicine` varchar(60) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `medicine`
--

INSERT INTO `medicine` (`id_medicine`, `title`, `cost`, `available_in_warehouse`, `amount`, `average_rating_by_medicine`, `search_by_medicine`) VALUES
(1, 'Ледокоин', 2500, 0, 0, 0, 'NULL'),
(2, 'Уголь', 12, 0, 1200, 0, 'NULL'),
(3, 'Но-шпа', 551, 0, 0, 0, 'NULL'),
(4, 'Фазин', 342, 0, 0, 0, 'NULL'),
(5, 'Ибусан', 1671, 0, 0, 0, 'NULL'),
(6, 'Игрель', 2410, 0, 0, 0, 'NULL'),
(7, 'Икс-преп', 411, 0, 0, 0, 'NULL'),
(8, 'Имвек', 912, 0, 0, 0, 'nu'),
(9, 'Имусан', 1314, 0, 0, 0, 'NULL'),
(10, 'Белый уголь', 24, 0, 0, 0, 'NULL'),
(11, 'Тазан', 815, 0, 0, 0, 'NULL'),
(12, 'Танлиза', 412, 0, 0, 0, 'NULL'),
(13, 'Тимогексал', 885, 0, 0, 0, 'NULL'),
(14, 'Торим', 613, 0, 0, 0, 'NULL'),
(15, 'Багомет', 951, 0, 0, 0, 'NULL'),
(17, 'Аскорбинка', 15, 0, 0, 0, 'NULL');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id_medicine`),
  ADD KEY `average_rating_by_medicine` (`average_rating_by_medicine`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id_medicine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
