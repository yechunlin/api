-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-10-27 18:32:19
-- 服务器版本： 5.7.26-log
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `huishuxizi`
--

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `dated` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='?༶?';

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `name`, `description`, `admin_id`, `dated`, `status`) VALUES
(1, '硬笔书法101班', '一笔笔异步阿搜房网是色女方品味高耗能博尔特', 1, '2020-10-14 10:21:17', 1),
(2, '硬笔书法102班', '一笔笔异步阿搜房网是色女方品味高耗能博尔特', 1, '2020-10-14 11:14:19', 1),
(3, '硬笔书法103班', '一笔笔异步阿搜房网是色女方品味高耗能博尔特', 1, '2020-10-14 11:14:24', 1),
(4, '硬笔书法104班', '一笔笔异步阿搜房网是色女方品味高耗能博尔特', 1, '2020-10-14 17:16:05', 1),
(5, '草书', '但凡认识一个就算我输', 1, '2020-10-14 17:27:09', 1),
(6, '行书', '这个大部分都认得，保证', 1, '2020-10-14 17:29:31', 1),
(7, '儿歌班', '和小朋友一起嗨皮1', 1, '2020-10-14 17:33:05', 1),
(8, '毛笔基础班', '正确入门课', 1, '2020-10-14 17:36:22', 1),
(9, '国画班', '水墨画', 1, '2020-10-21 17:30:01', 0);

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `dated` datetime NOT NULL DEFAULT '2020-01-01 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='?γ????ݱ';

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `title`, `cover`, `class_id`, `teacher_id`, `admin_id`, `dated`, `status`) VALUES
(1, '硬笔书法基础1：选好工具', 'http://localhost/api/public/upload/images/20201019\\6322c4209760d648aeb459ac862b1a55.jpg', 1, 1, 1, '2020-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `school_timetable`
--

CREATE TABLE `school_timetable` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `recom` tinyint(4) NOT NULL DEFAULT '0',
  `start_dated` date NOT NULL,
  `end_dated` date NOT NULL,
  `dated` datetime NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='?γ̱';

--
-- 转存表中的数据 `school_timetable`
--

INSERT INTO `school_timetable` (`id`, `user_id`, `class_id`, `recom`, `start_dated`, `end_dated`, `dated`, `admin_id`, `status`) VALUES
(2, 1, 1, 0, '2020-10-28', '2020-10-31', '2020-10-27 16:36:26', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dated` datetime NOT NULL,
  `lastdated` datetime NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `phone`, `avatar`, `password`, `dated`, `lastdated`, `access_token`, `status`) VALUES
(1, 'admin', '18365265643', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif', 'e10adc3949ba59abbe56e057f20f883e', '2020-09-01 17:32:08', '2020-10-27 17:57:53', 'a66abb5684c45962d887564f08346e8d', 1);

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `dated` datetime NOT NULL,
  `admin_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='??Ƶ?';

--
-- 转存表中的数据 `video`
--

INSERT INTO `video` (`id`, `path`, `duration`, `cover`, `class_id`, `course_id`, `dated`, `admin_id`, `status`) VALUES
(1, 'http://localhost/api/public/upload/videos/20201027/527a4bd7ea6a7893eee6481ba220c124.mp4', 0, NULL, 1, 1, '2020-10-27 11:36:51', 1, 0),
(2, 'http://localhost/api/public/upload/videos/20201027/1a8b0bff192681632f003bca234e80f4.mp4', 0, NULL, 1, 1, '2020-10-27 11:55:14', 1, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `school_timetable`
--
ALTER TABLE `school_timetable`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- 表的索引 `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `school_timetable`
--
ALTER TABLE `school_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
