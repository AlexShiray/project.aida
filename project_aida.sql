-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 15 2018 г., 16:51
-- Версия сервера: 5.7.19
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project.aida`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bus`
--

CREATE TABLE `bus` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'цена',
  `trans` text NOT NULL COMMENT 'транспортер'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bus_chart`
--

CREATE TABLE `bus_chart` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL COMMENT 'ID автобуса',
  `week_day` enum('mon','tue','wed','thu','fri','sat','sun') NOT NULL COMMENT 'День недели',
  `sel_station` text NOT NULL COMMENT 'пункт отправления',
  `sel_time` text NOT NULL COMMENT 'время отправления',
  `rec_station` text NOT NULL COMMENT 'пункт прибытия',
  `rec_time` text NOT NULL COMMENT 'время прибытия'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bus_chart`
--
ALTER TABLE `bus_chart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bus_one_week` (`bus_id`,`week_day`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bus_chart`
--
ALTER TABLE `bus_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
