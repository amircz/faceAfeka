-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2017 at 08:37 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faceafeka`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `date`) VALUES
(143, 343, 39, 'nice', '2017-08-05 23:35:03'),
(142, 347, 39, 'aa', '2017-08-05 23:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `followed_user` int(11) NOT NULL,
  `following_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friend_id`, `followed_user`, `following_user`) VALUES
(1, 1, 2),
(2, 2, 1),
(15, 1, 5),
(16, 5, 1),
(69, 1, 39),
(70, 39, 1),
(72, 40, 1),
(71, 1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(95, 39, 347),
(94, 40, 343);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `private` tinyint(1) NOT NULL,
  `content` text NOT NULL,
  `images` varchar(300) NOT NULL,
  `likes` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `comments` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `date`, `private`, `content`, `images`, `likes`, `location`, `comments`) VALUES
(313, 1, '2017-08-01 17:34:00', 0, 'new msg- At Ashdod,IL', '', 0, 'Ashdod,IL', 0),
(312, 1, '2017-08-01 17:33:09', 0, 'aa', '', 0, '', 0),
(343, 1, '2017-08-05 16:57:49', 0, 'new ', '2b.jpg@', 1, '', 1),
(310, 1, '2017-08-01 14:29:28', 0, 'test', '@', 0, '', 0),
(315, 5, '2017-08-02 08:40:19', 0, 'my', '1m.jpg@2b.jpg@', 0, '', 0),
(316, 5, '2017-08-02 08:44:40', 0, 'ada', '3m.jpg@4b.jpg@4m.jpg@5b.jpg@5m.jpg@', 0, '', 0),
(317, 5, '2017-08-02 08:55:42', 0, 'dsf- At Ashdod,IL', '@', 0, 'Ashdod,IL', 0),
(318, 5, '2017-08-02 08:57:11', 0, 'safsaff', '@', 0, '', 0),
(319, 5, '2017-08-02 08:57:14', 0, 'safsaf- At Hod Hasaron,IL', '@', 0, 'Hod Hasaron,IL', 0),
(347, 39, '2017-08-05 19:14:55', 1, 'new', '1024_fob.jpg@1024_lancer_black.jpg@', 1, '', 1),
(331, 2, '2017-08-05 06:52:09', 0, 'home', '@', 0, '', 0),
(332, 5, '2017-08-05 06:54:57', 0, 'nnew', '@', 0, '', 0),
(330, 1, '2017-08-02 16:25:01', 0, 'somhthing ', 'wAc2S.jpg@sx1oD.jpg@kiq9e.jpg@', 0, '', 0),
(339, 1, '2017-08-05 16:07:07', 0, 'aa', '@', 0, '', 0),
(340, 1, '2017-08-05 16:07:13', 0, 'ss- At Ashdod,IL', '@', 0, 'Ashdod,IL', 0),
(341, 1, '2017-08-05 16:22:29', 0, 'hello world #', 'vywTF.jpg@Nhvf0.jpg@MCwxX.jpg@', 0, '', 0),
(348, 40, '2017-08-05 20:28:21', 0, 'abi', '@', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL DEFAULT 'images/user1-256x256.png'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `userName`, `password`, `img`) VALUES
(1, 'avi', '87373df3f89fa9932a9c6c58cc75e309', 'images/user1-256x256.png'),
(2, 'karin', '87373df3f89fa9932a9c6c58cc75e309', 'images/user1-256x256.png'),
(5, 'new', '87373df3f89fa9932a9c6c58cc75e309', 'images/user1-256x256.png'),
(40, 'usr', '87373df3f89fa9932a9c6c58cc75e309', 'userPic/usr.jpg'),
(39, 'user', '87373df3f89fa9932a9c6c58cc75e309', 'userPic/user.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
