-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 26 2019 г., 05:30
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
(10, 73, 1, 'Деньги то он ему так и не отдал', '2019-12-25 19:07:31', 0),
(11, 69, 1, 'Ничего не понял,но немножко испугался', '2019-12-25 19:10:35', 0),
(12, 70, 1, '40 секунд пожара и 1 секунда САМОЛЁТИК ВЖУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУУ', '2019-12-25 19:12:05', 0),
(13, 72, 1, 'Лайк за спорт. Дизлайк за всё остальное', '2019-12-25 19:13:38', 0);

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
(69, 'Кукла 2: Брамс', 'Благополучная английская семья переезжает в старинный особняк Хилшир. В одной из комнат младший сын находит странную комнату.', 'users\\rikz\\1.jpeg', 'users\\rikz\\1.mp4', 'Уильям Брент Белл', 1, 1, '2019-12-26', 2, 5, 1, 0),
(70, 'Огонь', '', 'users\\rikz\\2.jpeg', 'users\\rikz\\2.mp4', ' Алексей Черномазов', 1, 1, '2019-12-26', 2, 6, 1, 0),
(72, 'На острие', '', 'users\\rikz\\4.jpeg', 'users\\rikz\\4.mp4', ' Эдуард Бордуков', 1, 1, '2019-12-26', 2, 2, 1, 0),
(73, 'Шахматист', '', 'users\\rikz\\3.jpeg', 'users\\rikz\\3.mp4', ' Пьер-Франсуа Мартен-Лаваль', 1, 1, '2019-12-26', 2, 7, 1, 0);

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
(3, 'Мультфильмы'),
(4, 'Артхаус'),
(5, 'Боевики'),
(6, 'Военные'),
(7, 'Детективы'),
(8, 'Для всей семьи\r\n'),
(9, 'Для детей'),
(10, 'Документальные'),
(11, 'Драмы'),
(12, 'Исторические\r\n'),
(13, 'Комедии'),
(14, 'Криминальные'),
(15, 'Мелодрамы\r\n'),
(16, 'Мистические'),
(17, 'Приключения\r\n'),
(18, 'Фильмы-катастрофы'),
(19, 'Триллеры'),
(20, 'Ужасы'),
(21, 'Фантастика'),
(22, 'Фэнтези');

-- --------------------------------------------------------

--
-- Структура таблицы `genre_association`
--

CREATE TABLE `genre_association` (
  `id` int(11) UNSIGNED NOT NULL,
  `genre_id` int(11) UNSIGNED NOT NULL,
  `video_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre_association`
--

INSERT INTO `genre_association` (`id`, `genre_id`, `video_id`) VALUES
(25, 7, 69),
(26, 19, 69),
(27, 20, 69),
(28, 13, 71),
(29, 15, 71),
(30, 13, 73),
(31, 15, 73);

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
(9, 73, 1, 7),
(10, 69, 1, 5),
(11, 70, 1, 6),
(12, 72, 1, 2);

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
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `genre_association`
--
ALTER TABLE `genre_association`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
