-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 10 2019 г., 02:01
-- Версия сервера: 10.1.22-MariaDB
-- Версия PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `golf`
--

-- --------------------------------------------------------

--
-- Структура таблицы `about`
--

CREATE TABLE `about` (
  `id` int(1) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `desc_az` varchar(255) NOT NULL,
  `desc_en` varchar(255) NOT NULL,
  `desc_ru` varchar(255) NOT NULL,
  `key_az` varchar(255) NOT NULL,
  `key_en` varchar(255) NOT NULL,
  `key_ru` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `about`
--

INSERT INTO `about` (`id`, `title_az`, `title_en`, `title_ru`, `text_az`, `text_en`, `text_ru`, `desc_az`, `desc_en`, `desc_ru`, `key_az`, `key_en`, `key_ru`) VALUES
(1, 'Haqqımızda', 'About Us', 'О Нас', '&lt;p&gt;Haqqımızda&lt;/p&gt;\r\n', '&lt;p&gt;About Us&lt;/p&gt;\r\n', '&lt;p&gt;О Нас&lt;/p&gt;\r\n', 'Bella Pizza haqqinda', 'Bella Pizza haqqinda', 'Bella Pizza haqqinda', 'Bella Pizza, haqqimizda bizim', 'Bella Pizza, haqqimizda bizim', 'Bella Pizza, haqqimizda bizim');

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` tinyint(2) NOT NULL COMMENT '1 - bas admin, 2 - admin, 3 - editor',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`, `email`, `name`, `role`, `status`) VALUES
(1, 'admin', '8147844f6da4535dfd2c05a222b41cd1', 'huseynceferov91@gmail.com', 'Ceferov Huseyn', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `text_az` text,
  `text_en` text NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `short_text_az` varchar(255) DEFAULT NULL,
  `short_text_en` varchar(255) DEFAULT NULL,
  `short_text_ru` text NOT NULL,
  `text_az` longtext,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `tags_az` varchar(255) DEFAULT NULL,
  `tags_en` varchar(255) NOT NULL,
  `tags_ru` varchar(255) NOT NULL,
  `meta_description_az` varchar(255) NOT NULL,
  `meta_description_en` varchar(255) NOT NULL,
  `meta_description_ru` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `middle` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `iframe` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `blogs`
--

INSERT INTO `blogs` (`id`, `album_id`, `title_az`, `title_en`, `title_ru`, `short_text_az`, `short_text_en`, `short_text_ru`, `text_az`, `text_en`, `text_ru`, `tags_az`, `tags_en`, `tags_ru`, `meta_description_az`, `meta_description_en`, `meta_description_ru`, `view_count`, `image`, `middle`, `thumb`, `iframe`, `slug`, `create_time`, `status`) VALUES
(1, 0, 'Noxud Pot Pie', 'Chickpea Pot Pie', 'Пирог из нута', 'Fırını 400 &deg; F-ə qədər qızdırın. Silikon döşəmə və ya perqament ilə bir təbəqə qabını çəkin.', 'Heat the oven to 400&deg;F. Line a sheet pan with a silicone mat or parchment.', 'Разогрейте духовку до 400 &deg; F. Выровняйте противень с силиконовым ковриком или пергаментом.', '&lt;p&gt;Fırını 400 &amp;deg; F-ə qədər qızdırın. Silikon d&amp;ouml;şəmə və ya perqament ilə bir təbəqə qabını &amp;ccedil;əkin. Yumurtanı ki&amp;ccedil;ik bir qaba &amp;ccedil;atdırın, 1 &amp;ccedil;imdik duz, 1 &amp;ccedil;ay qaşığı su əlavə edin və hamar qədər &amp;ccedil;əngəl ilə &amp;ccedil;ırpın. Yumşaq unlu bir səthdə 10x10 d&amp;uuml;yml&amp;uuml;k kvadrat şəkər pastası &amp;ccedil;əkin. 6 d&amp;uuml;zbucaqlı (bir pizza təkər burada yaxşı işləyir) daxil kəsilmiş. Hazırlanmış təbəqənin qabına qoyun. Hər par&amp;ccedil;anı yumurta yuyucusu ilə fır&amp;ccedil;alayın. Təravirin yarısına qədər d&amp;ouml;nən, təxminən 20 dəqiqə bişirin, pasta qızardı və qızıl qəhvəyi qədər.&lt;/p&gt;\r\n', '&lt;p&gt;Heat the oven to 400&amp;deg;F. Line a sheet pan with a silicone mat or parchment. Crack the egg into a small bowl, add 1 pinch salt, 1 teaspoon water, and whisk with a fork until smooth. Roll out the puff pastry on a lightly floured surface into a 10x10-inch square. Cut into 6 rectangles (a pizza wheel works well here). Set on the prepared sheet pan. Brush each piece with the egg wash. Bake for about 20 minutes, rotating the pan halfway through, until the pastry is puffed and golden brown.&lt;/p&gt;\r\n', '&lt;p&gt;Разогрейте духовку до 400 &amp;deg; F. Выровняйте противень с силиконовым ковриком или пергаментом. Разбейте яйцо в небольшую миску, добавьте 1 щепотку соли, 1 чайную ложку воды и взбейте вилкой до однородной массы. Раскатайте слоеное тесто на слегка посыпанную мукой поверхность в квадрат 10х10 дюймов. Разрезать на 6 прямоугольников (здесь хорошо работает колесо для пиццы). Установите на подготовленную противень. Смажьте каждый кусок яйцом. Выпекать около 20 минут, вращая сковороду на полпути, пока тесто не станет слоеным и не станет золотисто-коричневым.&lt;/p&gt;\r\n', 'Noxud Pot Pie, Noxud Pot Pie bella', 'Noxud Pot Pie, Noxud Pot Pie bella', 'Noxud Pot Pie, Noxud Pot Pie bella', '', '', '', 0, 'news/1/middle/1_0.jpg', '', 'news/1/thumbs/1_0.jpg', '', 'noxud-pot-pie', 1557073994, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_az` text,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `safe_mode` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `title_az`, `title_en`, `title_ru`, `text_az`, `text_en`, `text_ru`, `position`, `image`, `slug`, `status`, `safe_mode`) VALUES
(1, 0, 'Pizza', 'Pizza', 'Пицца', 'Pizza', 'Pizza', 'Пицца', 1, '', 'pizza', 1, 0),
(2, 0, 'Salatlar', 'Salads', 'Салаты', 'Salatlar', 'Salads', 'Салаты', 2, '', 'salatlar', 1, 0),
(3, 0, 'Içkilər', 'Drinks', 'Напитки', 'Içkilər', 'Drinks', 'Напитки', 3, '', 'ickiler', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `clubs`
--

CREATE TABLE `clubs` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `short_text_az` varchar(255) DEFAULT NULL,
  `short_text_en` varchar(255) DEFAULT NULL,
  `short_text_ru` text NOT NULL,
  `text_az` longtext,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `location_az` varchar(255) DEFAULT NULL,
  `location_en` varchar(255) NOT NULL,
  `location_ru` varchar(255) NOT NULL,
  `meta_description_az` varchar(255) NOT NULL,
  `meta_description_en` varchar(255) NOT NULL,
  `meta_description_ru` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `middle` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `iframe` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clubs`
--

INSERT INTO `clubs` (`id`, `album_id`, `title_az`, `title_en`, `title_ru`, `short_text_az`, `short_text_en`, `short_text_ru`, `text_az`, `text_en`, `text_ru`, `location_az`, `location_en`, `location_ru`, `meta_description_az`, `meta_description_en`, `meta_description_ru`, `view_count`, `image`, `middle`, `thumb`, `iframe`, `slug`, `create_time`, `status`) VALUES
(1, 0, 'Milli Golf Klubu', 'National Golf Club', 'Национальный Гольф Клуб', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!&lt;/p&gt;\r\n\r\n&lt;blockquote&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.&lt;/p&gt;\r\n\r\n&lt;p&gt;Someone famous in&amp;nbsp;&lt;cite&gt;Source Title&lt;/cite&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Someone famous in Source Title Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Someone famous in Source Title Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', 'Azərbaycan, Quba', 'Azerbaijan, Guba', 'Азербайджан, Губа', '', '', '', 0, 'clubs/1/1_0.jpg', 'clubs/1/middle/1_0.jpg', 'clubs/1/thumbs/1_0.jpg', '', 'milli-golf-klubu', 1570644852, 1),
(2, 0, 'Milli Golf Klubu 2', 'National Golf Club', 'Национальный Гольф Клуб', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', 'The National Golf Club is situated in Quba in the north-west of Azerbaijan sitting at the foot of the breathtaking Caucasus Mountains.', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!&lt;/p&gt;\r\n\r\n&lt;blockquote&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.&lt;/p&gt;\r\n\r\n&lt;p&gt;Someone famous in&amp;nbsp;&lt;cite&gt;Source Title&lt;/cite&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Someone famous in Source Title Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Someone famous in Source Title Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!&lt;/p&gt;\r\n', 'Azərbaycan, Quba', 'Azerbaijan, Guba', 'Азербайджан, Губа', '', '', '', 0, 'clubs/2/2_0.jpg', 'clubs/2/middle/2_0.jpg', 'clubs/2/thumbs/2_0.jpg', '', 'milli-golf-klubu-2', 1570645852, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `bonus_interest` int(1) NOT NULL COMMENT 'Istifadecilerin sifarisi esasinda qazandigi bonuslardi',
  `home_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) DEFAULT NULL,
  `other_tel` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `diff_az` text,
  `diff_en` text,
  `diff_ru` text,
  `address_az` varchar(255) DEFAULT NULL,
  `address_en` varchar(255) DEFAULT '',
  `address_ru` varchar(255) DEFAULT NULL,
  `working_days_az` varchar(255) DEFAULT NULL,
  `working_days_en` varchar(100) DEFAULT NULL,
  `working_days_ru` varchar(100) DEFAULT NULL,
  `weekend_days_az` varchar(255) DEFAULT NULL,
  `weekend_days_en` varchar(100) DEFAULT NULL,
  `weekend_days_ru` varchar(100) DEFAULT NULL,
  `logo` varchar(255) NOT NULL DEFAULT '',
  `logo2` varchar(255) DEFAULT NULL,
  `bg_img_az` varchar(255) NOT NULL,
  `bg_img_en` varchar(255) NOT NULL,
  `bg_img_ru` varchar(255) NOT NULL,
  `map_lat` varchar(15) DEFAULT '40.40926169',
  `map_long` varchar(15) DEFAULT '49.86709240',
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `google_plus` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `vkontakte` varchar(255) DEFAULT NULL,
  `vimeo` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `bonus_interest`, `home_tel`, `mobile_tel`, `other_tel`, `fax`, `email`, `diff_az`, `diff_en`, `diff_ru`, `address_az`, `address_en`, `address_ru`, `working_days_az`, `working_days_en`, `working_days_ru`, `weekend_days_az`, `weekend_days_en`, `weekend_days_ru`, `logo`, `logo2`, `bg_img_az`, `bg_img_en`, `bg_img_ru`, `map_lat`, `map_long`, `facebook`, `twitter`, `google_plus`, `instagram`, `linkedin`, `youtube`, `whatsapp`, `vkontakte`, `vimeo`, `pinterest`) VALUES
(2, 1, '+994 55 555 55 55', '+994 55 555 55 55', '+994 55 555 55 55', '000000000', 'info@golfazerbaijan.az', '', 'Ingilisce Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. ', '', 'Baku', 'S.Vurghun str. 61A ', 'ул. С.Вургуна 61A', '11:00 - 02:00', '11:00 - 02:00', '11:00 - 02:00', '', '', '', '', '', '', '', '', '40.375119867357', '49.841173543481', 'https://www.facebook.com/ExperienceAZE/', 'https://twitter.com/experienceaze', 'http://google.az', 'https://www.instagram.com/experienceazerbaijan/', 'https://www.linkedin.com/company/azerbaijan-tourism-board/', 'https://www.youtube.com/channel/UCJvKUQoRB97StBM5c-3PS4Q', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `fullname` varchar(25) NOT NULL,
  `code` varchar(3) NOT NULL,
  `rate` decimal(8,4) NOT NULL,
  `position` int(3) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0-Deaktivdir; 1 -Aktivdir'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `fullname`, `code`, `rate`, `position`, `default`, `status`) VALUES
(1, 'Dollar', 'ABŞ dolları', 'USD', '1.9200', 1, 1, 1),
(2, 'Euro', 'Avro', 'EUR', '2.0719', 2, 0, 1),
(3, 'Rubl', 'Rusiya rublu', 'RUB', '0.0319', 3, 0, 1),
(4, 'Lirə', 'Manat', 'TRY', '0.5078', 4, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `short_text_az` varchar(255) DEFAULT NULL,
  `short_text_en` varchar(255) DEFAULT NULL,
  `short_text_ru` text NOT NULL,
  `text_az` longtext,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `location_az` varchar(255) DEFAULT NULL,
  `location_en` varchar(255) NOT NULL,
  `location_ru` varchar(255) NOT NULL,
  `arena_az` varchar(255) NOT NULL,
  `arena_en` varchar(255) NOT NULL,
  `arena_ru` varchar(255) NOT NULL,
  `event_date_az` varchar(255) NOT NULL,
  `event_date_en` varchar(255) NOT NULL,
  `event_date_ru` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `middle` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `iframe` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `album_id`, `title_az`, `title_en`, `title_ru`, `short_text_az`, `short_text_en`, `short_text_ru`, `text_az`, `text_en`, `text_ru`, `location_az`, `location_en`, `location_ru`, `arena_az`, `arena_en`, `arena_ru`, `event_date_az`, `event_date_en`, `event_date_ru`, `view_count`, `image`, `middle`, `thumb`, `iframe`, `slug`, `create_time`, `status`) VALUES
(4, 0, 'Ladies Scramble in Dreamland Golf Club', 'Ladies Scramble in Dreamland Golf Club', 'Ladies Scramble in Dreamland Golf Club', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', 'Azərbaycan, Quba', 'Azerbaijan, Guba', 'Азербайджан, Губа', 'DREAMLAND GOLF KLUBU', 'THE DREAMLAND GOLF CLUB', 'THE DREAMLAND GOLF CLUB', '18 - 27 oktyabr 2019', '18 - 27 October 2019', '18 - 27 октября 2019 г.', 0, 'events/4/4_0.jpg', 'events/4/middle/4_0.jpg', 'events/4/thumbs/4_0.jpg', '', 'ladies-scramble-in-dreamland-golf-club', 1570642818, 1),
(3, 0, 'Ladies Scramble in Dreamland Golf Club 2', 'Ladies Scramble in Dreamland Golf Club', 'Ladies Scramble in Dreamland Golf Club', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', 'Dreamland Golf Club cordially invites you for monthly 4 player scramble event held by Dreamland Lady Golfers, usually 18 holes tournament.', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', 'Azərbaycan, Quba', 'Azerbaijan, Guba', 'Азербайджан, Губа', 'DREAMLAND GOLF KLUBU', 'THE DREAMLAND GOLF CLUB', 'THE DREAMLAND GOLF CLUB', '18 - 27 oktyabr 2019', '18 - 27 October 2019', '18 - 27 октября 2019 г.', 0, 'events/3/3_0.jpg', 'events/3/middle/3_0.jpg', 'events/3/thumbs/3_0.jpg', '', 'ladies-scramble-in-dreamland-golf-club-2', 1570645818, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

CREATE TABLE `languages` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(10) NOT NULL,
  `fullname` varchar(25) DEFAULT NULL,
  `position` tinyint(2) NOT NULL DEFAULT '0',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `flag` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `name`, `fullname`, `position`, `default`, `status`, `flag`) VALUES
(11, 'az', 'Azərbaycanca', 0, 1, 1, 'Azerbaijan.png'),
(6, 'en', 'English', 0, 0, 1, 'United-States.png'),
(13, 'ru', 'По Руский', 0, 0, 1, 'Russia.png');

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(25) NOT NULL,
  `text_az` text,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `menu_type` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `up` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `down` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `tags` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT '',
  `position` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `safe_mode` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `title_az`, `title_en`, `title_ru`, `text_az`, `text_en`, `text_ru`, `menu_type`, `url`, `up`, `down`, `tags`, `meta_description`, `position`, `slug`, `status`, `safe_mode`) VALUES
(1, 0, 'Qolf klubları', 'Golf Clubs', 'Гольф-клубы', '', '', '', 'site', NULL, 1, 1, '', '', 1, 'qolf-klublari', 1, 0),
(2, 0, 'Turlar', 'Tours', 'Экскурсии', '', '', '', 'site', NULL, 1, 1, '', '', 2, 'turlar', 1, 0),
(3, 0, 'Tədbirlər', 'Events', 'Мероприятия', '', '', '', 'site', NULL, 1, 1, '', '', 2, 'tedbirler', 1, 0),
(4, 0, 'Göstərişlər', 'Tips', 'Подсказки', '', '', '', 'site', NULL, 1, 1, '', '', 2, 'gosterisler', 0, 0),
(5, 0, 'Xəbərlər', 'News', 'Новости', '', '', '', 'site', NULL, 1, 1, '', '', 2, 'xeberler', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `short_text_az` varchar(255) DEFAULT NULL,
  `short_text_en` varchar(255) DEFAULT NULL,
  `short_text_ru` text NOT NULL,
  `text_az` longtext,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `tags_az` varchar(255) DEFAULT NULL,
  `tags_en` varchar(255) NOT NULL,
  `tags_ru` varchar(255) NOT NULL,
  `meta_description_az` varchar(255) NOT NULL,
  `meta_description_en` varchar(255) NOT NULL,
  `meta_description_ru` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `middle` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `iframe` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `album_id`, `title_az`, `title_en`, `title_ru`, `short_text_az`, `short_text_en`, `short_text_ru`, `text_az`, `text_en`, `text_ru`, `tags_az`, `tags_en`, `tags_ru`, `meta_description_az`, `meta_description_en`, `meta_description_ru`, `view_count`, `image`, `middle`, `thumb`, `iframe`, `slug`, `create_time`, `status`) VALUES
(1, 0, 'Azerbaijan Hosted IAGTO Golf Cup', 'Azerbaijan Hosted IAGTO Golf Cup', 'Azerbaijan Hosted IAGTO Golf Cup', NULL, NULL, '', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', NULL, '', '', '', '', '', 0, 'news/1/1_0.jpg', 'news/1/middle/1_0.jpg', 'news/1/thumbs/1_0.jpg', '', 'azerbaijan-hosted-iagto-golf-cup', 1570649243, 1),
(2, 0, 'Dreamland Golf Club versus Aghalarov&rsquo;s Golf Club', 'Dreamland Golf Club versus Aghalarov&rsquo;s Golf Club', 'Dreamland Golf Club versus Aghalarov&rsquo;s Golf Club', NULL, NULL, '', '&lt;h2&gt;Where does it come from?&lt;/h2&gt;\r\n\r\n&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &amp;quot;de Finibus Bonorum et Malorum&amp;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &amp;quot;Lorem ipsum dolor sit amet..&amp;quot;, comes from a line in section 1.10.32.&lt;/p&gt;\r\n\r\n&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &amp;quot;de Finibus Bonorum et Malorum&amp;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;\r\n', '&lt;h2&gt;Where does it come from?&lt;/h2&gt;\r\n\r\n&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &amp;quot;de Finibus Bonorum et Malorum&amp;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &amp;quot;Lorem ipsum dolor sit amet..&amp;quot;, comes from a line in section 1.10.32.&lt;/p&gt;\r\n\r\n&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &amp;quot;de Finibus Bonorum et Malorum&amp;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;\r\n', '&lt;h2&gt;Where does it come from?&lt;/h2&gt;\r\n\r\n&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &amp;quot;de Finibus Bonorum et Malorum&amp;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &amp;quot;Lorem ipsum dolor sit amet..&amp;quot;, comes from a line in section 1.10.32.&lt;/p&gt;\r\n\r\n&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &amp;quot;de Finibus Bonorum et Malorum&amp;quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;\r\n', NULL, '', '', '', '', '', 0, 'news/2/2_0.jpg', 'news/2/middle/2_0.jpg', 'news/2/thumbs/2_0.jpg', '', 'dreamland-golf-club-versus-aghalarov-s-golf-club', 1570649526, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title_az` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `table_name` varchar(50) NOT NULL,
  `row_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `roles_table`
--

CREATE TABLE `roles_table` (
  `id` int(11) UNSIGNED NOT NULL,
  `table_name` varchar(50) NOT NULL DEFAULT '',
  `super_admin` tinyint(2) NOT NULL DEFAULT '0',
  `admin` tinyint(2) NOT NULL DEFAULT '0',
  `editor` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles_table`
--

INSERT INTO `roles_table` (`id`, `table_name`, `super_admin`, `admin`, `editor`) VALUES
(1, 'categories', 1, 1, 0),
(2, 'albums', 1, 1, 1),
(3, 'languages', 1, 0, 0),
(5, 'about', 1, 1, 1),
(6, 'photos', 1, 1, 1),
(7, 'admins', 1, 1, 0),
(8, 'slider', 1, 1, 1),
(9, 'tours', 1, 1, 1),
(10, 'currencies', 1, 1, 1),
(11, 'events', 1, 1, 1),
(12, 'news', 1, 1, 1),
(14, 'contacts', 1, 1, 1),
(17, 'users', 1, 1, 1),
(22, 'blogs', 1, 1, 1),
(23, 'clubs', 1, 1, 1),
(24, 'menus', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `slider`
--

CREATE TABLE `slider` (
  `id` int(11) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `subtitle_az` text,
  `subtitle_en` text,
  `subtitle_ru` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `target` tinyint(2) UNSIGNED DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `slider`
--

INSERT INTO `slider` (`id`, `image`, `thumb`, `title_az`, `title_en`, `title_ru`, `subtitle_az`, `subtitle_en`, `subtitle_ru`, `link`, `target`, `create_time`, `position`, `status`) VALUES
(1, 'slider/1/1_0.png', 'slider/1/thumbs/1_0.png', 'Pepperoni pizza', 'Pepperoni pizza', 'Пицца пепперони', '&lt;p&gt;Pepperoni pizza&lt;/p&gt;\r\n', '&lt;p&gt;Pepperoni pizza&lt;/p&gt;\r\n', '&lt;p&gt;Пицца пепперони&lt;/p&gt;\r\n', 'http://localhost/bellapizza/pizza/pepperoni', 0, 1557208898, 1, 1),
(2, 'slider/2/2_0.png', 'slider/2/thumbs/2_0.png', 'Meksikano', 'Meksikano', 'Мексиканский', '&lt;p&gt;Meksikano&lt;/p&gt;\r\n', '&lt;p&gt;Meksikano&lt;/p&gt;\r\n', '', 'http://localhost/bellapizza/pizza/meksikano', 0, 1557209008, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tours`
--

CREATE TABLE `tours` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `title_az` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `short_text_az` varchar(255) DEFAULT NULL,
  `short_text_en` varchar(255) DEFAULT NULL,
  `short_text_ru` text NOT NULL,
  `text_az` longtext,
  `text_en` longtext,
  `text_ru` text NOT NULL,
  `price_az` varchar(255) DEFAULT NULL,
  `price_en` varchar(255) NOT NULL,
  `price_ru` varchar(255) NOT NULL,
  `location_az` varchar(255) NOT NULL,
  `location_en` varchar(255) NOT NULL,
  `location_ru` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `middle` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `iframe` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `album_id`, `title_az`, `title_en`, `title_ru`, `short_text_az`, `short_text_en`, `short_text_ru`, `text_az`, `text_en`, `text_ru`, `price_az`, `price_en`, `price_ru`, `location_az`, `location_en`, `location_ru`, `view_count`, `image`, `middle`, `thumb`, `iframe`, `slug`, `create_time`, `status`) VALUES
(1, 0, 'Explore Golf in Azerbaijan', 'Explore Golf in Azerbaijan', 'Explore Golf in Azerbaijan', NULL, NULL, '', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '1500 USD', '1500 USD', '1500 USD', '', '', '', 0, 'tours/1/1_0.jpg', 'tours/1/middle/1_0.jpg', 'tours/1/thumbs/1_0.jpg', '', 'explore-golf-in-azerbaijan', 1570648661, 1),
(2, 0, 'Explore Golf in Azerbaijan 2', 'Explore Golf in Azerbaijan 2', 'Explore Golf in Azerbaijan 2', NULL, NULL, '', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '&lt;p&gt;Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do&lt;strong&gt;lorem ipsum&lt;/strong&gt;, quia&amp;nbsp;&lt;strong&gt;dolor sit, amet, consectetur, adipisci&lt;/strong&gt;&amp;nbsp;v&lt;strong&gt;elit, sed&lt;/strong&gt;&amp;nbsp;quia non numquam&amp;nbsp;&lt;strong&gt;eius mod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;tempor&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;incidunt, ut labore et dolore magna&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;aliqua&lt;/strong&gt;m quaerat voluptatem.&amp;nbsp;&lt;strong&gt;Ut enim ad minim&lt;/strong&gt;a&amp;nbsp;&lt;strong&gt;veniam, quis nostru&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;exercitation&lt;/strong&gt;em&amp;nbsp;&lt;strong&gt;ullam co&lt;/strong&gt;rporis suscipit&lt;strong&gt;&amp;nbsp;labori&lt;/strong&gt;o&lt;strong&gt;s&lt;/strong&gt;am,&amp;nbsp;&lt;strong&gt;nisi ut aliquid ex ea commod&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;consequat&lt;/strong&gt;ur?&amp;nbsp;&lt;strong&gt;Quis aute&lt;/strong&gt;m vel eum&amp;nbsp;&lt;strong&gt;iure reprehenderit,&lt;/strong&gt;&amp;nbsp;qui&amp;nbsp;&lt;strong&gt;in&lt;/strong&gt;&amp;nbsp;ea&amp;nbsp;&lt;strong&gt;voluptate velit esse&lt;/strong&gt;, quam nihil molestiae&amp;nbsp;&lt;strong&gt;c&lt;/strong&gt;onsequatur, vel&amp;nbsp;&lt;strong&gt;illum&lt;/strong&gt;, qui&amp;nbsp;&lt;strong&gt;dolore&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;eu&lt;/strong&gt;m&amp;nbsp;&lt;strong&gt;fugiat&lt;/strong&gt;, quo voluptas&amp;nbsp;&lt;strong&gt;nulla pariatur&lt;/strong&gt;? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&amp;nbsp;&lt;strong&gt;exceptur&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;sint, obcaecat&lt;/strong&gt;i&amp;nbsp;&lt;strong&gt;cupiditat&lt;/strong&gt;e&amp;nbsp;&lt;strong&gt;non pro&lt;/strong&gt;v&lt;strong&gt;ident&lt;/strong&gt;, similique&amp;nbsp;&lt;strong&gt;sunt in culpa&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;qui officia deserunt mollit&lt;/strong&gt;ia&amp;nbsp;&lt;strong&gt;anim&lt;/strong&gt;i,&amp;nbsp;&lt;strong&gt;id est laborum&lt;/strong&gt;&amp;nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&lt;/p&gt;\r\n', '850 azn', '850 azn', '850 azn', '', '', '', 0, 'tours/2/2_0.jpg', 'tours/2/middle/2_0.jpg', 'tours/2/thumbs/2_0.jpg', '', 'explore-golf-in-azerbaijan-2', 1570647661, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `approve` tinyint(1) NOT NULL COMMENT '0 - Tesdiqlenmeyib; 1 - Tesdiqlenib;',
  `reg_date` int(11) NOT NULL,
  `bonus` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 - Deaktivdir; 1 - Aktivdir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `weather`
--

CREATE TABLE `weather` (
  `id` int(11) NOT NULL,
  `city_name` varchar(50) DEFAULT NULL,
  `temp_c` varchar(15) DEFAULT NULL,
  `icon_url` varchar(255) DEFAULT NULL,
  `first_time` int(11) DEFAULT NULL,
  `last_update_time` int(11) DEFAULT NULL,
  `az_name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `weather`
--

INSERT INTO `weather` (`id`, `city_name`, `temp_c`, `icon_url`, `first_time`, `last_update_time`, `az_name`, `status`) VALUES
(1, 'Agdam', '-2', 'http://icons.wxug.com/i/c/k/cloudy.gif', 1485929103, 1485929103, 'Ağdam', 0),
(2, 'Akstafa', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929103, 1485929103, 'Ağstafa', 0),
(3, 'Astara', '2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929104, 1485929104, 'Astara', 0),
(4, 'Baku', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929104, 1485929104, 'Bakı', 0),
(5, 'Barda', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929104, 1485929104, 'Bərdə', 0),
(6, 'Beylagan', '', '', 1485929105, 1485929105, 'Beyləqan', 1),
(7, 'Bilasuvar', '20', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929105, 1485929105, 'Biləsuvar', 0),
(8, 'Dashkasan', '-2', 'http://icons.wxug.com/i/c/k/mostlycloudy.gif', 1485929105, 1485929105, 'Daşkəsən', 0),
(9, 'Evlakh', '', '', 1481702281, 1481702281, 'Yevlax', 1),
(10, 'Fizuli', '-4', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929111, 1485929111, 'Fizuli', 0),
(11, 'Gadabay', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929111, 1485929111, 'Gədəbəy', 0),
(12, 'Gyoychay', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929112, 1485929112, 'Göyçay', 0),
(13, 'Imishli', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929112, 1485929112, 'İmişli', 0),
(14, 'Ismailly', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929112, 1485929112, 'İsmayıllı', 0),
(15, 'Khachmaz', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929113, 1485929113, 'Xaçmaz', 0),
(16, 'Khankandi', '-2', 'http://icons.wxug.com/i/c/k/clear.gif', 1485929113, 1485929113, 'Xankəndi', 0),
(17, 'Khojaly', '', '', 1481702285, 1481702285, 'Xocalı', 1),
(18, 'Khojavand', '', '', 1481702285, 1481702285, 'Xocavənd', 1),
(19, 'Kuba', '-1', 'http://icons.wxug.com/i/c/k/mostlycloudy.gif', 1485929114, 1485929114, 'Quba', 0),
(20, 'Kurdamir', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929114, 1485929114, 'Kürdəmir', 0),
(21, 'Lachin', '1', 'http://icons.wxug.com/i/c/k/clear.gif', 1485929114, 1485929114, 'Laçın', 0),
(22, 'Lankaran', '0', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929115, 1485929115, 'Lənkəran', 0),
(23, 'Mingachevir', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929115, 1485929115, 'Mingəçevir', 0),
(24, 'Naxcivan', '-8', 'http://icons.wxug.com/i/c/k/fog.gif', 1485929115, 1485929115, 'Naxçıvan', 0),
(25, 'Neftchala', '1', 'http://icons.wxug.com/i/c/k/cloudy.gif', 1485929116, 1485929116, 'Neftçala', 0),
(26, 'Oguz', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929116, 1485929116, 'Oğuz', 0),
(27, 'Ordubad', '-8', 'http://icons.wxug.com/i/c/k/mostlycloudy.gif', 1485929117, 1485929117, 'Ordubad', 0),
(28, 'Qabala', '-1', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929117, 1485929117, 'Qəbələ', 0),
(29, 'Salyan', '17', 'http://icons.wxug.com/i/c/k/cloudy.gif', 1485929118, 1485929118, 'Səlyan', 0),
(30, 'Shaki', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929118, 1485929118, 'Şəki', 0),
(31, 'Shamakhi', '6', 'http://icons.wxug.com/i/c/k/partlycloudy.gif', 1481704280, 1481704280, 'Şamaxı', 0),
(32, 'Shamkir', '', '', 1481702292, 1481702292, 'Şəmkir', 1),
(33, 'Shusha', '-10', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929118, 1485929118, 'Şuşa', 0),
(34, 'Sumgait', '-1.6', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929119, 1485929119, 'Sumqayıt', 0),
(35, 'Tar-tar', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929119, 1485929119, 'Tərtər', 0),
(36, 'Yardimli', '-7', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929120, 1485929120, 'Yardımlı', 0),
(37, 'Zakatala', '-2', 'http://icons.wxug.com/i/c/k/snow.gif', 1485929120, 1485929120, 'Zaqatala', 0),
(38, 'Zardab', '', '', 1481702294, 1481702294, 'Zərdab', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles_table`
--
ALTER TABLE `roles_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `about`
--
ALTER TABLE `about`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `languages`
--
ALTER TABLE `languages`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `roles_table`
--
ALTER TABLE `roles_table`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
