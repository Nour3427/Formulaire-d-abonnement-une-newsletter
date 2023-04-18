-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2023 at 08:59 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsletter`
--

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int NOT NULL,
  `interest_label` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `interest_label`) VALUES
(1, 'Peinture'),
(2, 'Sculpture'),
(3, 'Photographie'),
(4, 'Art contemporain'),
(5, 'Films'),
(6, 'Art numérique'),
(7, 'Installations');

-- --------------------------------------------------------

--
-- Table structure for table `origines`
--

CREATE TABLE `origines` (
  `id` int NOT NULL,
  `origineLabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `origines`
--

INSERT INTO `origines` (`id`, `origineLabel`) VALUES
(2, 'Un ami m’en a parlé'),
(3, 'Recherche sur internet'),
(4, 'Publicité dans un magazine');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `created` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `origine_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `created`, `email`, `firstname`, `lastname`, `origine_id`) VALUES
(7, '2023-02-13', 'alfred.dupont@gmail.com', 'Alfred', 'Dupont', NULL),
(8, '2023-02-13', 'b.lav@hotmail.fr', 'Bertrand', 'Lavoisier', NULL),
(9, '2023-02-13', 'sarahlamine@gmail.com', 'Sarah', 'Lamine', NULL),
(10, '2023-02-13', 'mo78@laposte.net', 'Mohamed', 'Ben Salam', NULL),
(11, '2023-02-14', 'nourelyakine.moumene@gmail.com', 'Nour', 'Ferraoun', 3),
(12, '2023-03-26', 'ferraoun.nour@gmail.com', 'yasmine', 'bent', 3),
(16, '2023-04-18', 'azertypassepartout@gmail.com', 'nour', 'qwertt', 4);

-- --------------------------------------------------------

--
-- Table structure for table `subs_interest`
--

CREATE TABLE `subs_interest` (
  `subs_id` int NOT NULL,
  `interest_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subs_interest`
--

INSERT INTO `subs_interest` (`subs_id`, `interest_id`) VALUES
(11, 6),
(11, 7),
(12, 4),
(12, 5),
(12, 3),
(16, 6),
(16, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `origines`
--
ALTER TABLE `origines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_origine_id` (`origine_id`);

--
-- Indexes for table `subs_interest`
--
ALTER TABLE `subs_interest`
  ADD KEY `fk_subscribers` (`subs_id`),
  ADD KEY `fk_interest` (`interest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `origines`
--
ALTER TABLE `origines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `fk_origine_id` FOREIGN KEY (`origine_id`) REFERENCES `origines` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `subs_interest`
--
ALTER TABLE `subs_interest`
  ADD CONSTRAINT `fk_interest` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_subscribers` FOREIGN KEY (`subs_id`) REFERENCES `subscribers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
