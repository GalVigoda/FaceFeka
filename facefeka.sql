-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2019 at 05:39 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facefeka`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=hebrew;

-- --------------------------------------------------------

--
-- Table structure for table `game_requests`
--

DROP TABLE IF EXISTS `game_requests`;
CREATE TABLE IF NOT EXISTS `game_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=hebrew;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `post_id` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `file_name`, `post_id`, `upload_time`) VALUES
(1, 'IMG_20190724_160602_335.PNG', 67, '2019-07-24 16:06:02'),
(2, 'IMG_20190724_160641_935.PNG', 68, '2019-07-24 16:06:41'),
(3, 'IMG_20190724_160641_735.PNG', 68, '2019-07-24 16:06:41'),
(4, 'IMG_20190724_160641_744.PNG', 68, '2019-07-24 16:06:41'),
(5, 'IMG_20190724_160641_473.PNG', 68, '2019-07-24 16:06:41'),
(6, 'IMG_20190724_162231_791.PNG', 69, '2019-07-24 16:22:31'),
(7, 'IMG_20190724_163212_669.PNG', 70, '2019-07-24 16:32:12'),
(8, 'IMG_20190726_052133_115.PNG', 77, '2019-07-26 05:21:33'),
(9, 'IMG_20190726_052133_562.PNG', 77, '2019-07-26 05:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isPrivate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `user_id`, `date`, `isPrivate`) VALUES
(2, 'This is a post of id 1', 1, '2019-07-10 04:17:18', 0),
(3, 'This is a post of id 2', 2, '2019-07-08 09:28:13', 0),
(4, 'This is a post of id 3', 3, '2019-07-06 14:11:26', 0),
(5, 'lolololo', 2, '2019-07-16 20:31:09', 0),
(6, 'hhhh', 1, '2019-07-24 12:32:34', 0),
(7, 'kkk', 1, '2019-07-24 12:33:11', 0),
(8, 'fgfg', 1, '2019-07-24 12:33:54', 0),
(9, 'dddd', 1, '2019-07-24 12:34:25', 0),
(10, 'ghdghdfgh', 2, '2019-07-24 12:35:26', 1),
(11, 'this is naor post private', 1, '2019-07-24 12:55:41', 1),
(13, 'lolololo', 2, '2019-07-24 14:45:19', 1),
(14, ' Hey :)', 2, '2019-07-24 14:45:27', 0),
(15, 'ffffffff', 1, '2019-07-24 15:35:42', 1),
(16, 'gggg', 1, '2019-07-24 15:36:08', 0),
(17, 'dddd', 1, '2019-07-24 15:36:18', 0),
(18, 'lolololo', 1, '2019-07-24 15:45:52', 1),
(19, 'bb', 1, '2019-07-24 15:48:10', 0),
(20, '×¢×¢×¢×¢', 1, '2019-07-24 15:50:16', 0),
(21, ' Hey :)', 1, '2019-07-24 15:50:54', 0),
(22, 'lolololo', 1, '2019-07-24 15:53:06', 0),
(23, 'bb', 1, '2019-07-24 15:53:13', 0),
(24, 'bb', 1, '2019-07-24 15:54:28', 0),
(25, 'bb', 1, '2019-07-24 15:54:55', 0),
(26, 'bb', 1, '2019-07-24 15:55:14', 0),
(27, 'bb', 1, '2019-07-24 15:55:21', 0),
(28, 'kkk', 1, '2019-07-24 15:55:28', 0),
(29, 'bb', 1, '2019-07-24 15:58:35', 1),
(30, 'bb', 1, '2019-07-24 15:59:51', 1),
(31, 'bb', 1, '2019-07-24 16:00:56', 0),
(32, 'bb', 1, '2019-07-24 16:01:35', 0),
(33, 'ffffffff', 1, '2019-07-24 16:02:36', 1),
(34, 'bb', 1, '2019-07-24 16:03:39', 0),
(35, 'lolololo', 1, '2019-07-24 16:03:56', 1),
(36, ' Hey :)', 1, '2019-07-24 16:05:05', 1),
(37, ' Hey :)', 1, '2019-07-24 16:05:58', 1),
(38, 'lolololo', 1, '2019-07-24 16:06:11', 0),
(39, 'bb', 1, '2019-07-24 16:07:44', 0),
(40, ' Hey :)', 1, '2019-07-24 16:08:25', 1),
(41, ' Hey :)', 1, '2019-07-24 16:14:02', 0),
(42, 'bb', 1, '2019-07-24 16:16:41', 0),
(43, 'lolololo', 1, '2019-07-24 16:18:10', 0),
(44, 'lolololo', 1, '2019-07-24 16:19:51', 0),
(45, 'bb', 1, '2019-07-24 17:18:47', 0),
(46, 'lolololo', 1, '2019-07-24 17:22:47', 0),
(47, 'bb', 1, '2019-07-24 17:28:13', 0),
(48, 'lolololo', 1, '2019-07-24 17:39:39', 0),
(49, 'bb', 1, '2019-07-24 17:55:33', 0),
(50, 'bb', 1, '2019-07-24 18:00:20', 0),
(51, 'lolololo', 1, '2019-07-24 18:03:42', 1),
(52, 'lolololo', 1, '2019-07-24 18:03:56', 0),
(53, 'lolololo', 1, '2019-07-24 18:13:10', 0),
(54, 'lolololo', 1, '2019-07-24 18:16:24', 0),
(55, 'bb', 1, '2019-07-24 18:27:17', 0),
(56, 'lolololo', 1, '2019-07-24 18:30:09', 0),
(57, 'lolololo', 1, '2019-07-24 18:33:33', 0),
(58, 'bb', 1, '2019-07-24 18:34:32', 0),
(59, 'bb', 1, '2019-07-24 18:37:36', 0),
(60, 'lolololo', 1, '2019-07-24 18:41:52', 0),
(61, 'lolololo', 1, '2019-07-24 18:43:37', 0),
(62, 'lolololo', 1, '2019-07-24 18:44:08', 0),
(63, 'lolololo', 1, '2019-07-24 18:44:55', 0),
(64, 'bb', 1, '2019-07-24 18:45:59', 0),
(65, 'bb', 1, '2019-07-24 18:46:09', 0),
(66, 'lolololo', 1, '2019-07-24 19:05:19', 0),
(67, ' Hey :)', 1, '2019-07-24 19:06:02', 0),
(68, 'lolololo', 1, '2019-07-24 19:06:41', 1),
(69, 'lolololo', 1, '2019-07-24 19:22:31', 1),
(70, ' Hey :)', 2, '2019-07-24 19:32:12', 0),
(71, 'lolololo', 1, '2019-07-26 08:11:05', 0),
(72, ' Hey :)', 1, '2019-07-26 08:12:22', 0),
(73, 'bb', 1, '2019-07-26 08:12:53', 0),
(74, ' Hey :)', 1, '2019-07-26 08:13:32', 0),
(75, 'bb', 1, '2019-07-26 08:17:00', 0),
(76, ' Hey :)', 1, '2019-07-26 08:21:26', 0),
(77, 'lolololo', 1, '2019-07-26 08:21:33', 0),
(78, 'bb', 1, '2019-07-26 08:25:38', 1),
(79, 'this is LOLOLO post', 3, '2019-07-26 08:33:03', 1),
(80, 'this is naor post not private', 1, '2019-07-26 08:35:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comment`) VALUES
(3, 11, 1, 'gggg'),
(2, 11, 1, 'comment2'),
(4, 11, 1, 'gggg'),
(8, 79, 3, 'this is lololo comment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'naor', '$2y$10$dbdLc5LGGHh1lRMvbuK9J.7qTjGwwk3eT03tmLQyydF6Eyjnh3Yoi'),
(2, 'LOLO', '$2y$10$QNEKp7Ng8a7AZ0eYkqTDsed8XR3eQaJCHHamgzx33tbtojRsbPgku'),
(3, 'LOLOLO', '$2y$10$Oaxjp5u6eSW3LlfAIorSpOSiYirYodGv8qzCrRv1gROO9HK8g527y');

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `user_friends`
--

INSERT INTO `user_friends` (`id`, `user_id`, `friend_id`) VALUES
(9, 2, 1),
(10, 1, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
