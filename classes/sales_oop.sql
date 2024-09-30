-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 03:57 AM
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
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` float(50,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 'Beef Meat', 180.00, 0),
(2, 'Ground Beef', 599.00, 36),
(3, 'Chicken Breast', 149.00, 25),
(4, 'Pork Chops', 125.00, 26),
(5, 'Hotdog', 3.99, 49),
(6, 'Bacon', 499.00, 12),
(7, 'Garlic Sausage', 7.50, 19),
(8, 'Salt', 1.00, 99),
(9, 'Pepper', 2.50, 79),
(10, 'Ketchup', 3.00, 40),
(11, 'Cooking Oil', 5.00, 30),
(12, 'Sugar', 1.99, 74),
(13, 'Flour', 2.25, 50),
(14, 'Milk', 2.75, 39),
(15, 'Eggs', 3.50, 100),
(16, 'Spaghetti Noodles', 1.50, 59),
(17, 'Soy Sauce', 1.75, 38),
(18, 'Vinegar', 1.50, 31),
(19, 'Canned Tuna', 2.20, 60),
(20, 'Instant Noodles', 0.75, 120),
(21, 'Toothpaste', 2.00, 50),
(22, 'Coke', 1.50, 24),
(23, 'Water', 1.00, 34),
(24, 'Orange Juice', 2.00, 11),
(25, 'Coffee', 1.25, 12),
(26, 'M&M\'s', 1.00, 36),
(27, 'Cookies', 2.00, 12),
(28, 'Peanuts', 3.00, 11),
(29, 'Milk', 2.50, 12),
(30, 'Eggs', 1.50, 11),
(31, 'Cheddar Cheese', 3.00, 5),
(32, 'Bread', 1.50, 0),
(33, 'Pasta', 1.00, 12),
(34, 'Rice', 1.00, 12),
(35, 'Canned Beans', 1.00, 12),
(36, 'Ground Beef', 3.50, 9),
(37, 'Ribeye Steaks', 6.00, 5),
(38, 'Chuck Roast', 5.00, 5),
(39, 'Boneless Chicken Breasts', 4.00, 10),
(40, 'Chicken Thighs', 3.50, 10),
(41, 'Chicken Wings', 3.00, 10),
(42, 'Pork Chops', 4.50, 5),
(43, 'Ground Pork', 3.50, 10),
(44, 'Pork Ribs', 4.00, 3),
(45, 'Hot Dogs', 3.00, 10),
(46, 'Italian Sausage', 4.00, 5),
(47, 'Chorizo', 4.50, 5),
(48, 'Red Bull', 2.50, 12),
(49, 'Gatorade', 2.00, 12),
(50, 'Iced Tea', 1.50, 12),
(51, 'Lemonade', 1.50, 12),
(52, 'Popcorn Kernels', 2.00, 12),
(53, 'Granola Bars', 2.50, 12),
(54, 'Trail Mix', 3.00, 12),
(55, 'Yogurt', 2.00, 11),
(56, 'Butter', 2.50, 6),
(57, 'Margarine', 2.00, 5),
(58, 'Cereal', 2.50, 12),
(59, 'Oatmeal', 2.00, 12),
(60, 'Soup', 1.50, 12),
(61, 'Broth', 1.50, 12),
(62, 'Toilet Paper', 1.00, 12),
(63, 'Paper Towels', 1.50, 6),
(64, 'Trash Bags', 1.50, 12),
(65, 'Dish Soap', 2.00, 6),
(66, 'Brisket', 5.50, 5),
(67, 'Flank Steak', 5.00, 5),
(68, 'Short Ribs', 4.50, 5),
(69, 'Drumsticks', 3.00, 10),
(70, 'Tenders', 4.00, 9),
(71, 'Chicken Liver', 2.50, 10),
(72, 'Baby Back Ribs', 5.00, 5),
(73, 'Pork Belly', 4.50, 5),
(74, 'Ham', 4.00, 5),
(75, 'Breakfast Sausage', 3.50, 10),
(76, 'Knockwurst', 4.50, 4),
(77, 'Pepperoni', 4.00, 5),
(78, 'Salmon Fillets', 8.00, 0),
(79, 'Shrimp', 6.00, 4),
(80, 'Tuna Canned', 35.00, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
