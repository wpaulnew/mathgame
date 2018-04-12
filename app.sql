-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 16 2018 г., 16:25
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `battle`
--

CREATE TABLE `battle` (
  `id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `question_condition` int(1) NOT NULL COMMENT 'Закрыт вопрос или открыт',
  `answered` int(11) NOT NULL COMMENT 'id пользователя кто правильно ответил'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(1232) NOT NULL DEFAULT '1234',
  `photo` text NOT NULL,
  `current_room` int(11) NOT NULL DEFAULT '0',
  `round` int(11) NOT NULL,
  `win` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `players`
--

INSERT INTO `players` (`id`, `login`, `password`, `photo`, `current_room`, `round`, `win`) VALUES
(1, 'Paul', '1234', 'i.png', 0, 0, 1),
(2, 'Alex', '1234', 'i.png', 5, 0, 1),
(3, 'Artem', '1234', 'i.png', 0, 0, 0),
(4, 'Paul1', '1234', 'i.png', 0, 0, 2),
(9, 'ART', '1234', '', 0, 0, 0),
(6, 'Bob', '1234', 'i.png', 0, 0, 3),
(7, 'Ali', '1234', 'i.png', 0, 0, 0),
(8, 'A', '1234', 'i.png', 0, 0, 0),
(10, 'B', '1234', 'i.png', 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` varchar(20) NOT NULL,
  `answer` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer`) VALUES
(1, '7 + 2', '9'),
(2, '1 + 2', '3'),
(3, '4 + 5', '9'),
(4, '9 + 11', '20'),
(5, '6 + 7', '13'),
(6, '9 + 3', '12'),
(7, '5 + 13', '18'),
(8, '3 + 5', '8'),
(9, '1 + 9', '10'),
(10, '6 + 1', '7'),
(11, '5 + 5', '10'),
(12, '21 + 10', '31'),
(13, '12 + 13', '25'),
(14, '31 + 17', '48');

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `number_max` int(11) NOT NULL DEFAULT '3',
  `number_now` int(11) NOT NULL DEFAULT '0',
  `room_condition` int(11) NOT NULL DEFAULT '0' COMMENT 'Типа статус',
  `round_max` int(11) NOT NULL DEFAULT '5' COMMENT 'Количество раундов',
  `round_now` int(11) NOT NULL,
  `winner` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `battle`
--
ALTER TABLE `battle`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `battle`
--
ALTER TABLE `battle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
