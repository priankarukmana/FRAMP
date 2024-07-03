-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 06:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(62, 1, 'Candle', 10, 100, '2.jpg'),
(69, 9, 'Wallet', 5, 1, '1.jpg'),
(70, 9, 'Perfume', 10, 1, '8.jpg'),
(71, 9, 'Keychain', 6, 10, '4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 1, 'Monica Angel', 'monicaangel48@gmail.com', '7980', 'Thank you for the good merchandise'),
(11, 6, 'Raihan Almi', 'raihan@gmail.com', '01273981', 'owahs');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `request` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `request`) VALUES
(13, 1, 'Rayyan', '213390340934', 'rayan@gmail.com', 'paypal', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Candle (1) ', 10, '21-Feb-2024', 'pending', 'I want the candle in chocolate color with text of Happy Wedding R&S'),
(14, 3, 'Monica Angel', '9031312321', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Candle (10) ', 100, '21-Feb-2024', 'pending', 'I want the candle in chocolate color with text of Happy Wedding R&S'),
(15, 3, 'Monica Monica', '39033213123', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Wallet (10) ', 50, '19-Mar-2024', 'pending', 'Red Color'),
(16, 6, 'Monica Monica', '39033213123', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Wallet (1) ', 5, '20-Mar-2024', 'pending', 'Red Color'),
(17, 9, 'admin01', '227648732', 'admin01@gmail.com', 'cash on delivery', 'Raihan Almi, Bekasi, Indonesia - 17510', ', Wallet (1) ', 5, '08-May-2024', 'pending', 'sdksagdkasda');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(2, 'Wallet', 5, '1.jpg'),
(3, 'Candle', 11, '2.jpg'),
(4, 'Eating Utensils', 3, '3.jpg'),
(5, 'Keychain', 6, '4.jpg'),
(6, 'Lanyard ', 5, '5.jpg'),
(7, 'Pouch', 8, '6.jpg'),
(8, 'Mug', 10, '7.jpg'),
(9, 'Perfume', 10, '8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_name`, `user_rating`, `user_review`, `datetime`) VALUES
(0, 'Fakhira Dhifa', 5, 'ok', 1719929004);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(6, 'user', 'user@gmail.com', '42810cb02db3bb2cbb428af0d8b0376e', 'user'),
(7, 'prianka', 'prianka@gmail.com', 'e00cf25ad42683b3df678c61f42c6bda', 'admin'),
(8, 'halmeera', 'booyaa.kkukku@gmail.com', '90537ffda9e256f00ce0c78f20cdbbe1', 'user'),
(9, 'raden', 'raden@gmail.com', 'c399440fe7440b7a33e8de0cdcd7f015', 'user'),
(10, 'admin2', 'admin2@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
