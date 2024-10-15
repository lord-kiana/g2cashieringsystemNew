-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 10:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_cost`) VALUES
(61, 1, '2024-10-15', 779.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `price`) VALUES
(82, 61, 1, 180.00),
(83, 61, 2, 599.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` float(50,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`) VALUES
(1, 'Beef Meat', 180.00),
(2, 'Ground Beef', 599.00),
(3, 'Chicken Breast', 149.00),
(4, 'Pork Chops', 125.00),
(5, 'Hotdog', 3.99),
(6, 'Bacon', 499.00),
(7, 'Garlic Sausage', 7.50),
(8, 'Salt', 1.00),
(9, 'Pepper', 2.50),
(10, 'Ketchup', 3.00),
(11, 'Cooking Oil', 5.00),
(12, 'Sugar', 1.99),
(13, 'Flour', 2.25),
(14, 'Milk', 2.75),
(15, 'Eggs', 3.50),
(16, 'Spaghetti Noodles', 1.50),
(17, 'Soy Sauce', 1.75),
(18, 'Vinegar', 1.50),
(19, 'Canned Tuna', 2.20),
(20, 'Instant Noodles', 0.75),
(21, 'Toothpaste', 2.00),
(22, 'Coke', 1.50),
(23, 'Water', 1.00),
(24, 'Orange Juice', 2.00),
(25, 'Coffee', 1.25),
(26, 'M&M\'s', 1.00),
(27, 'Cookies', 2.00),
(28, 'Peanuts', 3.00),
(29, 'Milk', 2.50),
(30, 'Eggs', 1.50),
(31, 'Cheddar Cheese', 3.00),
(32, 'Bread', 1.50),
(33, 'Pasta', 1.00),
(34, 'Rice', 1.00),
(35, 'Canned Beans', 1.00),
(36, 'Ground Beef', 3.50),
(37, 'Ribeye Steaks', 6.00),
(38, 'Chuck Roast', 5.00),
(39, 'Boneless Chicken Breasts', 4.00),
(40, 'Chicken Thighs', 3.50),
(41, 'Chicken Wings', 3.00),
(42, 'Pork Chops', 4.50),
(43, 'Ground Pork', 3.50),
(44, 'Pork Ribs', 4.00),
(45, 'Hot Dogs', 3.00),
(46, 'Italian Sausage', 4.00),
(47, 'Chorizo', 4.50),
(48, 'Red Bull', 2.50),
(49, 'Gatorade', 2.00),
(50, 'Iced Tea', 1.50),
(51, 'Lemonade', 1.50),
(52, 'Popcorn Kernels', 2.00),
(53, 'Granola Bars', 2.50),
(54, 'Trail Mix', 3.00),
(55, 'Yogurt', 2.00),
(56, 'Butter', 2.50),
(57, 'Margarine', 2.00),
(58, 'Cereal', 2.50),
(59, 'Oatmeal', 2.00),
(60, 'Soup', 1.50),
(61, 'Broth', 1.50),
(62, 'Toilet Paper', 1.00),
(63, 'Paper Towels', 1.50),
(64, 'Trash Bags', 1.50),
(65, 'Dish Soap', 2.00),
(66, 'Brisket', 5.50),
(67, 'Flank Steak', 5.00),
(68, 'Short Ribs', 4.50),
(69, 'Drumsticks', 3.00),
(70, 'Tenders', 4.00),
(71, 'Chicken Liver', 2.50),
(72, 'Baby Back Ribs', 5.00),
(73, 'Pork Belly', 4.50),
(74, 'Ham', 4.00),
(75, 'Breakfast Sausage', 3.50),
(76, 'Knockwurst', 4.50),
(77, 'Pepperoni', 4.00),
(78, 'Salmon Fillets', 8.00),
(79, 'Shrimp', 6.00),
(80, 'Tuna Canned', 35.00);

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
(1, 'Kiana', 'Olemberio', 'admin', '$2y$10$K46opVHBfe1O.tp1waLiPuLQlEcuV5nwcGtPjaaGb8weDc1TLNr1W', 'admin'),
(2, 'sheng', 'sheng', 'sheng', '$2y$10$NDRy9TanSMukGaUsR11Vhu0Aepc0c43nASAr1L47Q.36OVfZOVNXO', 'admin'),
(3, 'sheng', 'sheng', 'sheng1', '$2y$10$jz7YBV66tGFEsq02Je316Oe5EbItRqcpALEzHnDUqPsBEykvEb6DG', 'admin'),
(4, 'sheng', 'petalcurin', 'sheeeeyng123', '$2y$10$QpcdAJd055BRr8HA0Vy0jeCH3wdJuiHVyOZIiCsrwbWd9hgD2kZqe', 'cashier'),
(5, 'Kiana', 'Olemberio', '12345', '$2y$10$JXvQ/kJh.X1X6Uc36iZJAuG1JuspmzGYewGTOPNFbHF5c7zhLbMtK', 'cashier'),
(6, 'test', 'test', 'test', '$2y$10$cjT3XZZBpuf4JXUtzAzc2Ou9xfeQQj59210LsnP4OngJAdJAqrsYy', 'cashier'),
(7, 'kiana', 'kiana', 'admin2', '$2y$10$AbYlPfih/78tHO0JRrZssekAqxOgpPvzjxRAeIcTboC5KeqKnUQ7a', 'cashier'),
(8, 'test3', 'test3', 'test3', '$2y$10$zP85FheLED0HncZvMCe4kuU5Z8cdQUZT.Dlbyi3R7EwoyXmyg2q.W', 'cashier'),
(9, 'test4', 'test4', 'test4', '$2y$10$yddie7zwOKAcP6ixiRwdAO.P6ePWZ81KP7xGdL9iNNw5K90VFk4ve', 'cashier'),
(10, 'she', 'she', 'she', '$2y$10$Z4lvTbkMRwUKxcUl61K24emcoU0pewM0G1SCjk4gx7u7Hjt1eRpWW', 'cashier'),
(11, 'william', 'jabasa', 'will', '$2y$10$mFtgsyfn6Q9A4z.mBKtFi.nS1AN.oWK3Z5W.DA33PWN2xzXjmrx.2', 'cashier'),
(12, 'jiselle', 'jiselle', 'jiselle', '$2y$10$fx0jnoS7znFTnKtws0vZTucC0ThlCOkxu9KR5CF4pDVg/HDmpWhhq', 'cashier'),
(13, 'shan', 'shan', 'shan', '$2y$10$G2gfdwo7HKeBhVQOa8zeh.4vla6y0bj.9eaFFGKc3O7iTjM.Lwwre', 'cashier'),
(14, 'shan', 'shan', 'shan2', '$2y$10$VdwHaUBeqgd86RFUWYWNoOhpLa3QDtR4wmrLgoxU0lf9JEKq.eA4i', 'cashier'),
(15, 'test5', 'test5', 'test5', '$2y$10$BhN4dSnLjGQ1G0mAm8weeOtx5yZflhcwrL2F5mYmQbBkOqlnFzKiy', 'cashier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
