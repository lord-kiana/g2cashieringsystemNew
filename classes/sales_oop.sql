-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 01:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_oop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` float(50,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `quantity`) VALUES
(20, 'Water', 20.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'cashier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(11, 'Kiana', 'Olemberio', 'kiana', '$2y$10$K46opVHBfe1O.tp1waLiPuLQlEcuV5nwcGtPjaaGb8weDc1TLNr1W', 'admin'),
(12, 'sheng', 'sheng', 'sheng', '$2y$10$NDRy9TanSMukGaUsR11Vhu0Aepc0c43nASAr1L47Q.36OVfZOVNXO', 'admin'),
(13, 'sheng', 'sheng', 'sheng1', '$2y$10$jz7YBV66tGFEsq02Je316Oe5EbItRqcpALEzHnDUqPsBEykvEb6DG', 'cashier'),
(14, 'sheng', 'petalcurin', 'sheeeeyng123', '$2y$10$QpcdAJd055BRr8HA0Vy0jeCH3wdJuiHVyOZIiCsrwbWd9hgD2kZqe', 'cashier'),
(15, 'Kiana', 'Olemberio', '12345', '$2y$10$JXvQ/kJh.X1X6Uc36iZJAuG1JuspmzGYewGTOPNFbHF5c7zhLbMtK', 'cashier'),
(16, 'test', 'test', 'test', '$2y$10$cjT3XZZBpuf4JXUtzAzc2Ou9xfeQQj59210LsnP4OngJAdJAqrsYy', 'cashier'),
(17, 'kiana', 'kiana', 'admin2', '$2y$10$AbYlPfih/78tHO0JRrZssekAqxOgpPvzjxRAeIcTboC5KeqKnUQ7a', 'cashier'),
(18, 'test3', 'test3', 'test3', '$2y$10$zP85FheLED0HncZvMCe4kuU5Z8cdQUZT.Dlbyi3R7EwoyXmyg2q.W', 'cashier'),
(19, 'test4', 'test4', 'test4', '$2y$10$yddie7zwOKAcP6ixiRwdAO.P6ePWZ81KP7xGdL9iNNw5K90VFk4ve', 'cashier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
