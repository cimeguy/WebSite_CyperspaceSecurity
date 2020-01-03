-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 12 月 30 日 15:28
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `netsec`
--
CREATE DATABASE IF NOT EXISTS `netsec` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `netsec`;

-- --------------------------------------------------------

--
-- 表的结构 `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `sno` int(10) unsigned NOT NULL DEFAULT '0',
  `qno` int(10) NOT NULL DEFAULT '0',
  `wno` int(10) unsigned NOT NULL,
  `atext` text CHARACTER SET utf8,
  `ascore` int(3) DEFAULT NULL,
  KEY `sno` (`sno`),
  KEY `wno` (`wno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='作答表';

--
-- 转存表中的数据 `answer`
--

INSERT INTO `answer` (`sno`, `qno`, `wno`, `atext`, `ascore`) VALUES
(2017300000, 1, 4, 'C', 404),
(2017300000, 2, 4, 'xscs', 404),
(2017300000, 3, 4, '111', 404),
(2017300000, 4, 4, 'B', 404),
(2017300000, 1, 5, '51', 404),
(2017300000, 2, 5, 'C', 404),
(2017300000, 0, 8, 'B', 404),
(2017300000, 1, 8, 'jkl', 404),
(2017300000, 2, 8, 'jhgfd', 404);

-- --------------------------------------------------------

--
-- 表的结构 `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `bno` int(10) unsigned NOT NULL,
  `brief` text NOT NULL,
  `text` text NOT NULL,
  `btime` datetime NOT NULL,
  `bteacher` varchar(32) NOT NULL DEFAULT '陈旿',
  PRIMARY KEY (`bno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告表';

--
-- 转存表中的数据 `board`
--

INSERT INTO `board` (`bno`, `brief`, `text`, `btime`, `bteacher`) VALUES
(1, '理论作业1已经发布', '理论作业1已经发布理论作业1已经发布理论作业1已经发布理论作业1已经发布', '2019-12-24 00:00:00', '陈旿'),
(2, '欢迎来到我们网站', '啦啦啦啦啦啦啦啦', '2019-12-29 00:00:00', '陈旿'),
(3, '欢迎来到学习系统', '该网站为我们独立自主编写，若有抄袭必追究版权问题！', '2019-12-30 00:00:00', '高丽'),
(4, '欢迎回来', '欢迎回来欢迎回来欢迎回来欢迎回来欢迎回来欢迎回来', '2019-12-30 22:37:33', '白');

-- --------------------------------------------------------

--
-- 表的结构 `course_book`
--

CREATE TABLE IF NOT EXISTS `course_book` (
  `book_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `course_book`
--

INSERT INTO `course_book` (`book_name`) VALUES
('?????');

-- --------------------------------------------------------

--
-- 表的结构 `course_file`
--

CREATE TABLE IF NOT EXISTS `course_file` (
  `cfname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `flink` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`fno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `course_file`
--

INSERT INTO `course_file` (`cfname`, `flink`, `fno`) VALUES
('1', 'coursefiles/20191230053.zip', 1),
('1', 'coursefiles/20191230010.pdf', 2);

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `qno` int(10) unsigned NOT NULL COMMENT '题号',
  `qtitle` text CHARACTER SET utf8 NOT NULL COMMENT '内容',
  `is_select` int(1) NOT NULL COMMENT '是否为选择题',
  `qscore` int(3) NOT NULL,
  `wno` int(10) unsigned NOT NULL,
  `qkey` text CHARACTER SET utf8 NOT NULL COMMENT '标准答案',
  KEY `wno` (`wno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='题目记录';

--
-- 转存表中的数据 `question`
--

INSERT INTO `question` (`qno`, `qtitle`, `is_select`, `qscore`, `wno`, `qkey`) VALUES
(1, '我是第一题', 1, 5, 4, '我是第一题标准答案'),
(2, '4.2', 0, 10, 4, '4.2答案'),
(3, '4.3', 0, 10, 4, '4.3'),
(4, '4.4', 1, 4, 4, '4.4'),
(1, '51', 0, 5, 5, '51'),
(2, '52', 1, 5, 5, 'A'),
(0, '顶顶顶顶顶顶顶', 1, 5, 6, 'D'),
(0, '一', 1, 1, 8, 'A'),
(1, '二', 0, 5, 8, '顶顶顶'),
(2, '三', 0, 6, 8, '等等');

-- --------------------------------------------------------

--
-- 表的结构 `q_a`
--

CREATE TABLE IF NOT EXISTS `q_a` (
  `qano` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sno` int(10) unsigned NOT NULL,
  `qatext` text CHARACTER SET utf8 NOT NULL COMMENT '问的东西',
  `qanswer` text CHARACTER SET utf8,
  `qaarea` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '理论',
  `qatime` datetime NOT NULL,
  `qateacher` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `answer_time` datetime DEFAULT NULL,
  PRIMARY KEY (`qano`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `q_a`
--

INSERT INTO `q_a` (`qano`, `sno`, `qatext`, `qanswer`, `qaarea`, `qatime`, `qateacher`, `answer_time`) VALUES
(1, 201701, 'jnlml', ' ccd', '理论', '2019-12-30 04:07:15', '白', '2019-12-30 22:28:12'),
(2, 2017300000, '这题咋做', 'xxc', '理论', '2019-12-30 00:00:00', '白', '2019-12-30 22:27:58'),
(3, 2017300000, 'cdvcdvf', 'sxc', '实验', '2019-12-30 05:41:03', '白', '2019-12-30 22:26:17'),
(4, 2017300000, '老师，这道题咋写', '不知道', '理论', '2019-12-30 05:53:21', '陈旿', NULL),
(5, 2017300000, '老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么老师考试靠什么', NULL, '理论', '2019-12-30 06:00:16', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `q_choose`
--

CREATE TABLE IF NOT EXISTS `q_choose` (
  `wno` int(10) unsigned NOT NULL,
  `qno` int(10) unsigned NOT NULL,
  `A` text NOT NULL,
  `B` text NOT NULL,
  `C` text NOT NULL,
  `D` text NOT NULL,
  KEY `wno` (`wno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `q_choose`
--

INSERT INTO `q_choose` (`wno`, `qno`, `A`, `B`, `C`, `D`) VALUES
(4, 1, 'aAAA', 'BBB', 'CCC', 'DDD'),
(4, 4, 'aa', 'asad', 'dsafsdf', 'fsvdv'),
(5, 2, 'xssdc', 'cdfv', 'vfv', 'fbf'),
(6, 0, 'a', 'b', 'd', 'd''d'),
(8, 0, 'A', 'B', 'C', 'D');

-- --------------------------------------------------------

--
-- 表的结构 `selework`
--

CREATE TABLE IF NOT EXISTS `selework` (
  `sno` int(10) unsigned NOT NULL,
  `wno` int(10) unsigned NOT NULL,
  `grade` int(3) DEFAULT NULL,
  PRIMARY KEY (`sno`,`wno`),
  KEY `wno` (`wno`),
  KEY `sno` (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='选作业表';

--
-- 转存表中的数据 `selework`
--

INSERT INTO `selework` (`sno`, `wno`, `grade`) VALUES
(201701, 6, NULL),
(201701, 7, NULL),
(201701, 8, NULL),
(201702, 6, NULL),
(201702, 7, NULL),
(201702, 8, NULL),
(2017300000, 1, 70),
(2017300000, 2, 30),
(2017300000, 3, NULL),
(2017300000, 4, 404),
(2017300000, 5, 404),
(2017300000, 6, NULL),
(2017300000, 7, NULL),
(2017300000, 8, 3),
(2017300001, 6, NULL),
(2017300001, 7, NULL),
(2017300001, 8, NULL),
(2017301000, 6, NULL),
(2017301000, 7, NULL),
(2017301000, 8, NULL),
(2017302222, 6, NULL),
(2017302222, 7, NULL),
(2017302222, 8, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `name` varchar(32) NOT NULL,
  `sno` int(10) unsigned NOT NULL,
  `pw` varchar(32) NOT NULL,
  `class` varchar(16) NOT NULL,
  `college` varchar(32) NOT NULL,
  `regis_time` datetime NOT NULL,
  `last_time` datetime NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生表';

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`name`, `sno`, `pw`, `class`, `college`, `regis_time`, `last_time`) VALUES
('大明', 201701, '670b14728ad9902aecba32e22fa4f6bd', '0111701', '网安', '2019-12-27 00:43:58', '2019-12-27 00:43:58'),
('中明', 201702, 'a5fad663865a88aa1d6e76a89040cd3e', '', '', '2019-12-27 00:45:30', '2019-12-27 00:45:30'),
('高丽', 2017300000, '670b14728ad9902aecba32e22fa4f6bd', '', '', '2019-12-26 00:00:38', '2019-12-26 00:00:38'),
('С', 2017300001, 'fcea920f7412b5da7be0cf42b8c93759', '', '', '2019-12-26 00:28:11', '2019-12-26 00:28:11'),
('高一', 2017301000, '5f4dcc3b5aa765d61d8327deb882cf99', 'SC011701', '网络空间安全学院', '2019-12-26 23:03:33', '2019-12-26 23:03:33'),
('二皇子', 2017302222, 'bae5e3208a3c700e3db642b6631e95b9', '网安', '网安', '2019-12-26 21:58:27', '2019-12-26 21:58:27');

-- --------------------------------------------------------

--
-- 表的结构 `student_file`
--

CREATE TABLE IF NOT EXISTS `student_file` (
  `sfname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `flink` varchar(300) CHARACTER SET utf8 NOT NULL,
  `fno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sname` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `ftime` datetime NOT NULL,
  PRIMARY KEY (`fno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `student_file`
--

INSERT INTO `student_file` (`sfname`, `flink`, `fno`, `sname`, `ftime`) VALUES
('11', 'students_files/20191230066.jpg', 1, '大明', '2019-12-30 00:02:42'),
('2', 'students_files/20191230080.jpg', 2, '大明', '2019-12-30 00:02:51'),
('3', 'students_files/20191230056.jpg', 3, '大明', '2019-12-30 00:19:50'),
('tw', 'students_files/20191230079.zip', 4, '大明', '2019-12-30 00:20:11'),
('第三章', 'students_files/20191230047.pdf', 5, '高丽', '2019-12-30 00:47:44'),
('第三章', 'students_files/20191230025.pdf', 6, '高丽', '2019-12-30 00:47:44'),
('za', 'students_files/20191231556.docx', 7, '高丽', '2019-12-31 05:03:43'),
('xsx', 'students_files/20191231581.docx', 8, '高丽', '2019-12-31 05:03:53');

-- --------------------------------------------------------

--
-- 表的结构 `talk`
--

CREATE TABLE IF NOT EXISTS `talk` (
  `tno` int(10) unsigned NOT NULL,
  `sno` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `tarea` varchar(32) NOT NULL,
  `ttime` datetime NOT NULL,
  `reno` int(10) NOT NULL,
  `cno` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tno`,`cno`),
  KEY `sno` (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='讨论表';

--
-- 转存表中的数据 `talk`
--

INSERT INTO `talk` (`tno`, `sno`, `text`, `tarea`, `ttime`, `reno`, `cno`) VALUES
(1, 2017302222, '哈哈哈', '实验', '2019-12-25 00:00:00', 0, 1),
(1, 2017302222, '我自己回复我自己', '实验', '2019-12-28 00:00:00', 1, 3),
(1, 2017302222, '你好你好', '实验', '2019-12-31 00:00:00', 5, 6),
(1, 201701, 'xscvdv', '实验', '2019-12-27 13:53:37', 6, 9),
(1, 2017302222, 'aaaa', '实验', '2019-12-27 17:27:51', 2, 11),
(1, 201701, 'cdvgdfbgfbhh', '实验', '2019-12-27 23:09:47', 6, 18),
(2, 2017300000, 'swwdwd', '实验', '2019-12-30 04:29:57', 0, 1),
(2, 2017302222, '在吗', '实验', '2019-12-31 00:00:00', 1, 2),
(2, 2017300000, 'xs', '实验', '2019-12-30 04:42:00', 2, 3),
(2, 2017300000, '在', '实验', '2019-12-30 06:25:32', 2, 4),
(2, 2017300000, 'csdc', '实验', '2019-12-31 04:56:58', 2, 5),
(2, 2017300000, '不在', '实验', '2019-12-31 04:57:57', 2, 6),
(2, 2017300000, '不在', '实验', '2019-12-31 04:57:57', 2, 7),
(3, 201701, 'sdvfbfbgfngn', '实验', '2019-12-31 00:00:00', 0, 1),
(4, 2017300000, 'decdc', '理论', '2019-12-31 04:56:13', 0, 1),
(4, 2017300000, 'dcdsc', '理论', '2019-12-31 04:56:25', 1, 2),
(4, 2017300000, 'cde', '理论', '2019-12-31 04:56:38', 1, 3),
(4, 2017300000, 'dcs', '理论', '2019-12-31 04:56:44', 3, 4);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teano` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `register_time` datetime NOT NULL,
  `last_time` datetime DEFAULT NULL,
  `pw` varchar(32) CHARACTER SET utf8 NOT NULL,
  `college` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`teano`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`teano`, `name`, `register_time`, `last_time`, `pw`, `college`) VALUES
(1, '老师1', '2019-12-26 21:07:06', '2019-12-26 21:07:06', '670b14728ad9902aecba32e22fa4f6bd', NULL),
(2, 'aaaa', '2019-12-31 01:01:57', '2019-12-31 01:01:57', 'b9c93fbdfd2a30504e05d3b0b32307da', NULL),
(100, '陈老师', '2019-12-26 21:51:09', '2019-12-26 21:51:09', '670b14728ad9902aecba32e22fa4f6bd', NULL),
(111, '111', '2019-12-29 16:57:34', '2019-12-29 16:57:34', 'b9c93fbdfd2a30504e05d3b0b32307da', NULL),
(123, '白', '2019-12-30 22:22:34', '2019-12-30 22:22:34', 'b9c93fbdfd2a30504e05d3b0b32307da', NULL),
(222, '陈旿', '2019-12-26 20:40:09', '2019-12-26 20:40:09', '96e79218965eb72c92a549dd5a330112', NULL),
(111111, '陈旿', '2019-12-26 20:34:32', '2019-12-26 20:34:32', '96e79218965eb72c92a549dd5a330112', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `vno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vlink` varchar(32) NOT NULL,
  `vteacher` varchar(32) NOT NULL COMMENT '老师名字',
  `vzhang` varchar(32) DEFAULT NULL COMMENT '对应章节',
  `vtime` datetime NOT NULL,
  `vname` varchar(32) NOT NULL COMMENT '视频名字',
  PRIMARY KEY (`vno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `video`
--

INSERT INTO `video` (`vno`, `vlink`, `vteacher`, `vzhang`, `vtime`, `vname`) VALUES
(1, 'videos/1.mp4', '陈旿', '第一章', '2019-12-30 00:00:00', 'c1 绪论'),
(2, 'videos/2.avi', '陈旿', '第一章', '2019-12-30 00:00:00', 'c2 文件'),
(10, 'videos/20191231392.mp4', '老师1', '第一章', '2019-12-31 03:04:00', 'xscdv'),
(13, 'videos/20191231415.mp4', '老师1', '第一章', '2019-12-31 04:38:35', 'defcdse');

-- --------------------------------------------------------

--
-- 表的结构 `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `wno` int(10) unsigned NOT NULL,
  `wname` varchar(32) NOT NULL,
  `wcourse` varchar(32) NOT NULL,
  `wteacher` varchar(32) NOT NULL DEFAULT '陈旿',
  `ddl` datetime NOT NULL,
  `wchapter` varchar(32) NOT NULL,
  PRIMARY KEY (`wno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业表';

--
-- 转存表中的数据 `work`
--

INSERT INTO `work` (`wno`, `wname`, `wcourse`, `wteacher`, `ddl`, `wchapter`) VALUES
(1, '做个网站', '理论课', '陈旿', '2019-12-24 00:00:00', '第六章'),
(2, 'talk', 'lilun', 'chen', '2019-12-31 00:00:00', 'c6'),
(3, 'ee', 'e', 'e', '2019-12-03 00:00:00', '1'),
(4, '4', '理论课', '陈旿', '2019-12-17 00:00:00', '第七章'),
(5, 'q', '理论课', '陈旿', '2019-12-31 00:00:00', '第六章'),
(6, '地方撒打发的', '理论', '白', '2019-12-31 00:00:00', '第一章'),
(7, '打法', '实验', '白', '2019-12-31 00:00:00', '第六章'),
(8, '来了一个', '理论', '白', '2019-12-31 00:00:00', '第一章');

--
-- 限制导出的表
--

--
-- 限制表 `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`sno`) REFERENCES `student` (`sno`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`);

--
-- 限制表 `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`);

--
-- 限制表 `q_choose`
--
ALTER TABLE `q_choose`
  ADD CONSTRAINT `q_choose_ibfk_1` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`),
  ADD CONSTRAINT `q_choose_ibfk_2` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`),
  ADD CONSTRAINT `q_choose_ibfk_3` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`);

--
-- 限制表 `selework`
--
ALTER TABLE `selework`
  ADD CONSTRAINT `selework_ibfk_1` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`),
  ADD CONSTRAINT `selework_ibfk_2` FOREIGN KEY (`sno`) REFERENCES `student` (`sno`),
  ADD CONSTRAINT `selework_ibfk_3` FOREIGN KEY (`wno`) REFERENCES `work` (`wno`);

--
-- 限制表 `talk`
--
ALTER TABLE `talk`
  ADD CONSTRAINT `talk_ibfk_1` FOREIGN KEY (`sno`) REFERENCES `student` (`sno`),
  ADD CONSTRAINT `talk_ibfk_2` FOREIGN KEY (`sno`) REFERENCES `student` (`sno`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
