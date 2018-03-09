-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-09 12:18:32
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `work-system`
--

-- --------------------------------------------------------

--
-- 表的结构 `work_upload`
--

DROP TABLE IF EXISTS `work_upload`;
CREATE TABLE IF NOT EXISTS `work_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_by_user` int(11) NOT NULL COMMENT '提交user_id',
  `work_id` int(11) NOT NULL COMMENT '提交work_id',
  `file_name` varchar(100) NOT NULL COMMENT '保存文件名',
  `add_time` int(11) NOT NULL,
  `has_upload` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `work_upload`
--

INSERT INTO `work_upload` (`id`, `upload_by_user`, `work_id`, `file_name`, `add_time`, `has_upload`) VALUES
(31, 14, 6, '161540234黄初浩.docx', 1520251652, 0),
(32, 2, 6, '161540205默认姓名.docx', 1520251816, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
