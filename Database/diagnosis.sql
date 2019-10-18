-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2019 at 01:35 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnosis`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postId`, `userId`, `comment`, `created_at`) VALUES
(18, 33, 2, 'Nice one over here', '2019-06-03 15:43:26'),
(19, 33, 3, 'Hello Dudes', '2019-06-07 15:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE IF NOT EXISTS `experts` (
  `userId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `specialty` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`userId`, `name`, `email`, `specialty`, `phone`) VALUES
(2, 'John Doe', 'johndoe@gmail.com', 'Dentist', '08088776655'),
(3, 'Mike Smith', 'mikesmith@gmail.com', 'Optician', '08044556677'),
(4, 'Jane Kings', 'janekings@gmail.com', 'Vet', '08066775544');

-- --------------------------------------------------------

--
-- Table structure for table `latest_news`
--

CREATE TABLE IF NOT EXISTS `latest_news` (
  `id` int(11) NOT NULL,
  `news` text NOT NULL,
  `expertId` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `latest_news`
--

INSERT INTO `latest_news` (`id`, `news`, `expertId`, `published`, `created_at`) VALUES
(1, 'hello latest and gentlemen, it''s a privilege to be here in your midst once again.', 2, 1, '2019-06-07 13:18:27'),
(2, 'lorem ipsum from the man of the year.', 2, 1, '2019-06-07 13:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `userId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`userId`, `name`, `email`, `phone`, `gender`, `created_at`) VALUES
(5, 'Patient Jobs', 'patient@gmail.com', '08044223344', 'on', '2019-05-06 17:21:30'),
(6, 'Patient Lips', 'patient2@gmail.com', '08077336644', 'Female', '2019-05-06 19:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE IF NOT EXISTS `queries` (
  `id` int(11) NOT NULL,
  `patientId` int(11) NOT NULL,
  `expertId` int(11) NOT NULL,
  `description` text NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `patientId`, `expertId`, `description`, `visibility`, `status`, `created_at`) VALUES
(28, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:32'),
(29, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:38'),
(30, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:42'),
(31, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:47'),
(32, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:51'),
(33, 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ex libero minus, necessitatibus pariatur perferendis placeat quae reiciendis similique vel. Enim, iusto nemo nulla reiciendis reprehenderit sint! Ea inventore iure quidem repellat voluptatibus. A, accusamus alias aliquam architecto autem corporis dignissimos dolor ducimus, enim ex inventore libero minus nihil perferendis quos ratione repudiandae rerum tenetur voluptatibus, voluptatum? Aliquid at beatae cumque cupiditate delectus deleniti dolorem, doloribus, eum illo illum nam nesciunt omnis optio voluptatem voluptatibus? Asperiores at consequuntur cupiditate dicta dolor dolorum eum explicabo impedit in minima nulla praesentium quibusdam, reiciendis. Aut dolorem doloremque explicabo ipsum, minus pariatur quas ut.', 1, 0, '2019-06-03 14:00:55'),
(35, 5, 2, 'Hello, Dr. John Doe, am having some headache and i need some help.', 0, 0, '2019-06-10 13:32:41'),
(36, 5, 2, 'hello from the other, how are u doing... please help me check this out.', 0, 0, '2019-06-10 13:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `expertId` int(11) NOT NULL,
  `queryId` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`expertId`, `queryId`, `reply`, `created_at`) VALUES
(2, 7, 'You should only take this and that', '2019-05-22 14:49:37'),
(2, 7, 'More replies', '2019-05-22 14:51:11'),
(2, 8, 'jsadkfgwaudifbsdiaogbsidauofisjdaf', '2019-05-22 15:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `usergroup` varchar(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usergroup`, `is_active`, `created_at`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 1, '2019-05-22 10:12:35'),
(2, 'expert1', 'b780d252a12c8c472099c589d729a6d60a27dc7b', 'expert', 1, '2019-06-07 15:55:34'),
(3, 'expert2', 'b780d252a12c8c472099c589d729a6d60a27dc7b', 'expert', 1, '2019-05-22 10:12:35'),
(4, 'expert3', 'b780d252a12c8c472099c589d729a6d60a27dc7b', 'expert', 1, '2019-05-22 10:12:35'),
(5, 'patient1', 'b1b0b8de8a6228f6501c0560365d3a7d74ffcd8e', 'patient', 1, '2019-05-22 10:12:35'),
(6, 'patient2', 'b1b0b8de8a6228f6501c0560365d3a7d74ffcd8e', 'patient', 1, '2019-05-22 10:12:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `latest_news`
--
ALTER TABLE `latest_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `latest_news`
--
ALTER TABLE `latest_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
