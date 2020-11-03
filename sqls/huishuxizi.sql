-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-11-03 15:36:28
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
(1, '水墨画', '水墨画', 1, '2020-11-03 10:04:18', 1),
(2, '素描写生', '素描写生', 1, '2020-11-03 10:04:44', 1),
(3, '硬笔书法', '硬笔书法', 1, '2020-11-03 10:04:56', 1),
(4, '毛笔书法', '毛笔书法', 1, '2020-11-03 10:06:49', 1),
(5, '诗词歌赋', '诗词歌赋', 1, '2020-11-03 10:07:02', 1),
(6, '阅读朗诵', '阅读朗诵', 1, '2020-11-03 10:08:09', 1),
(7, '瑜伽舞蹈', '瑜伽舞蹈', 1, '2020-11-03 10:09:20', 1);

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
(1, '硬笔书法第一课《硬笔书法基础理论》', 'http://localhost/api/public/upload/images/20201103/049b06e0d61c5704b4a3ba4a6970e934.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(2, '硬笔书法第二课《硬笔书法书写姿势演示》', 'http://localhost/api/public/upload/images/20201103/0a2bfd6640bcfe0a963e20c6cdfb4185.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(3, '硬笔书法第三课《硬笔书法基本笔划演示》', 'http://localhost/api/public/upload/images/20201103/98fdf8aeefdb912fb0714bfe02a533ce.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(4, '硬笔书法第四课《硬笔书法字形基础介绍》', 'http://localhost/api/public/upload/images/20201103/d05962424854a03cf4289ed02f3cc8ba.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(5, ' 硬笔书法第五课硬笔书法字形基础及例字示范', 'http://localhost/api/public/upload/images/20201103/e932c5907e9b35c76ba38586b8c5f314.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(6, ' 硬笔书法第六课《硬笔书法间架结构基础理论介绍》', 'http://localhost/api/public/upload/images/20201103/faecfb544730509f09e0e96e73bc28de.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(7, ' 硬笔书法第七课间架结构及例字示范', 'http://localhost/api/public/upload/images/20201103/6006369f08b7ba1954d2240bc4b8031c.jpeg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(8, '硬笔书法第八课《硬笔书法教学提升方法介绍》', 'http://localhost/api/public/upload/images/20201103/de3bb90eba2776b9763f8f8f5fce8a4b.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(9, '硬笔书法第九课《硬笔书法教材使用方法介绍》', 'http://localhost/api/public/upload/images/20201103/64dae95817b0581d5b7b02fc528832ae.jpg', 3, 1, 1, '2020-01-01 00:00:00', 1),
(10, ' 硬笔书法第十课硬笔书法字帖教学与使用示范', 'http://localhost/api/public/upload/images/20201103/ac2fd907158d28bfdb4bf2b1e5f91734.jpeg', 3, 1, 1, '2020-01-01 00:00:00', 1);

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
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `phone`, `avatar`, `password`, `dated`, `lastdated`, `type`, `status`) VALUES
(1, 'admin', '18365265643', 'http://localhost/api/public/upload/images/20201029/f01b06260d174a25d05bd8eda4a89a41.png', 'e10adc3949ba59abbe56e057f20f883e', '2020-09-01 17:32:08', '2020-11-03 13:25:46', 2, 1);

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
(1, 'http://localhost/api/public/upload/videos/20201103/381f46edf2950c854574fd927149eec2.mp4', 0, NULL, 3, 1, '2020-11-03 10:42:28', 1, 1),
(2, 'http://localhost/api/public/upload/videos/20201103/9af6b918712cf8d4f7a1afca48a03254.mp4', 0, NULL, 3, 2, '2020-11-03 11:50:21', 1, 1);

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
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `school_timetable`
--
ALTER TABLE `school_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
