-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 19 2019 г., 01:21
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `acon`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(15) UNSIGNED NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL,
  `reply` int(15) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `file_id`, `user_id`, `text`, `time`, `reply`) VALUES
(2, 25, 1, 'da', '2019-12-18 13:30:14', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `preview` varchar(500) DEFAULT NULL,
  `location` varchar(500) NOT NULL,
  `author` varchar(200) DEFAULT NULL,
  `main_genre` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `creator` int(11) UNSIGNED NOT NULL,
  `upload_date` date NOT NULL,
  `views` int(15) UNSIGNED DEFAULT NULL,
  `middle_rating` float UNSIGNED NOT NULL DEFAULT 0,
  `showing` int(10) UNSIGNED NOT NULL,
  `moderating` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `title`, `description`, `preview`, `location`, `author`, `main_genre`, `creator`, `upload_date`, `views`, `middle_rating`, `showing`, `moderating`) VALUES
(13, 'GRADUATES', 'фыф', 'users\\rikz\\20100210210141!Scrooge2.jpg', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\rikz\\fdfdfdfd.html', '', 1, 1, '2019-12-14', 70, 0, 1, 0),
(14, 'STAY IN LINK', 'Ага', 'users\\rikz\\bc172118ed375dfc9fe1406b899094860bcc9cca.png', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\rikz\\ppoxvmn.html', 'Ебанько', 1, 1, '2019-12-14', 4, 0, 1, 0),
(15, 'ПРОКСИМА ЦЕНТАВРА', 'Планета', 'users\\rikz\\maxresdefault.jpg', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\rikz\\fes.html', '', 1, 1, '2019-12-14', 7, 0, 1, 0),
(16, 'THE BEST GRADUATES', '', 'users\\rikz\\kakashi.png', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\rikz\\depositphotos_139632918-stock-illustration-blank-comic-speech-cloud-bubble.jpg', 'GFIJK YF{EQ', 1, 1, '2019-12-14', 6, 0, 1, 0),
(17, 'ASSAS', '', 'users\\rikz\\13.png', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\rikz\\тест.docx', 'SSS', 1, 1, '2019-12-14', 5, 0, 1, 0),
(22, 'Telefon', '', 'users\\admin\\OH_MY.png', 'C:\\OSPanel\\domains\\ACON\\lib\\..\\users\\admin\\a2d82c8f85808639928e93a0aa85a866.480.mp4', '', 1, 11, '2019-12-15', 24, 1, 1, 0),
(25, 'AAEEEEE', '', 'users\\admin\\Blyat(.png', 'users\\admin\\a2d82c8f85808639928e93a0aa85a866.480.mp4', '', 1, 11, '2019-12-15', 293, 4.3, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `id` int(11) UNSIGNED NOT NULL,
  `genre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'Фильмы'),
(2, 'Сериалы'),
(3, 'Мультфильмы');

-- --------------------------------------------------------

--
-- Структура таблицы `genre_association`
--

CREATE TABLE `genre_association` (
  `id` int(11) UNSIGNED NOT NULL,
  `genre_id` int(11) UNSIGNED NOT NULL,
  `video_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) UNSIGNED NOT NULL,
  `video_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `rating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ratings`
--

INSERT INTO `ratings` (`id`, `video_id`, `user_id`, `rating`) VALUES
(1, 1, 2, 4),
(4, 25, 11, 1),
(5, 25, 9, 10),
(6, 25, 1, 2),
(7, 22, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Creator'),
(2, 'Admin'),
(3, 'Moderator'),
(4, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` int(10) NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'rikz', 'kbRmWkyZA8sM1Wn4l3iBO1', 'ebe392edf93f0f00064aa3c54c7b46b47352e0a7', 1),
(9, 'fuf', 'bIqLDmsCPpE3qxZv1', '5968cbd2dc9e565dd1efd7e15da0b172b484bd01', 3),
(10, 'qwerty', 'cxv7CyYSxxSMyhrsfP5/', '5182ea111238759db9c4a9902bc8ebc00b3483ef', 4),
(11, 'admin', 'WpnZpUx.vTroWPXPIB0', '892e35c1818144458a1ca65e99b1bf0436986c7e', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `genre_association`
--
ALTER TABLE `genre_association`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `genre_association`
--
ALTER TABLE `genre_association`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
