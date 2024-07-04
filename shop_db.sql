-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04 Jul 2024 pada 17.28
-- Versi Server: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(62, 1, 'Candle', 10, 100, '2.jpg'),
(69, 9, 'Wallet', 5, 1, '1.jpg'),
(70, 9, 'Perfume', 10, 1, '8.jpg'),
(71, 9, 'Keychain', 6, 10, '4.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 1, 'Monica Angel', 'monicaangel48@gmail.com', '7980', 'Thank you for the good merchandise'),
(11, 6, 'Raihan Almi', 'raihan@gmail.com', '01273981', 'owahs'),
(12, 2, 'ahmad', 'ahmad@gmail.com', '08123123123', 'Very Very Nicc');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `request`) VALUES
(13, 1, 'Rayyan', '213390340934', 'rayan@gmail.com', 'paypal', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Candle (1) ', 10, '21-Feb-2024', 'pending', 'I want the candle in chocolate color with text of Happy Wedding R&S'),
(14, 3, 'Monica Angel', '9031312321', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Candle (10) ', 100, '21-Feb-2024', 'pending', 'I want the candle in chocolate color with text of Happy Wedding R&S'),
(15, 3, 'Monica Monica', '39033213123', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Wallet (10) ', 50, '19-Mar-2024', 'pending', 'Red Color'),
(16, 6, 'Monica Monica', '39033213123', 'monicaangel48@gmail.com', 'cash on delivery', 'Pondok Ungu Permai Blok AL 3/12, Bekasi Utara, BEKASI, Indonesia - 17610', ', Wallet (1) ', 5, '20-Mar-2024', 'pending', 'Red Color'),
(17, 9, 'admin01', '227648732', 'admin01@gmail.com', 'cash on delivery', 'Raihan Almi, Bekasi, Indonesia - 17510', ', Wallet (1) ', 5, '08-May-2024', 'pending', 'sdksagdkasda'),
(18, 2, 'Stevie', '081319082309', 'ss@gmail.com', 'paypal', 'jl. Damai, Cikarang, Indonesia - 123444', ', Mug (1) ', 10, '02-Jul-2024', 'pending', 'anti break');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `products`
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
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `review_id` int(100) NOT NULL,
  `id` int(1) DEFAULT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `review`
--

INSERT INTO `review` (`review_id`, `id`, `user_name`, `user_rating`, `user_review`, `datetime`) VALUES
(1, 4, 'John', 4, 'NIce', 1720070236),
(2, 4, 'John', 4, 'Nicee', 1720070753),
(3, 2, 'Danu', 2, 'Good', 1720071929),
(4, 8, 'James', 3, 'Naices', 1720075000),
(5, 4, 'Mike', 2, 'Wow', 1720075310),
(6, 2, 'Noah', 5, 'Great', 1720075931),
(7, 2, 'John', 1, 'Bad', 1720077926),
(8, 2, 'Weed', 0, 'Not Bad', 1720078375),
(9, 2, 'Rin', 2, '2 Star', 1720078598),
(10, 2, 'Dani', 3, 'Medium', 1720079380),
(11, 2, 'Hades', 5, 'Excellent', 1720080538),
(12, 2, 'Thomas', 5, 'Nice Work', 1720081065),
(13, 4, 'Danish', 1, 'So Bad', 1720086293);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(6, 'user', 'user@gmail.com', '42810cb02db3bb2cbb428af0d8b0376e', 'user'),
(7, 'prianka', 'prianka@gmail.com', 'e00cf25ad42683b3df678c61f42c6bda', 'admin'),
(8, 'halmeera', 'booyaa.kkukku@gmail.com', '90537ffda9e256f00ce0c78f20cdbbe1', 'user'),
(9, 'raden', 'raden@gmail.com', 'c399440fe7440b7a33e8de0cdcd7f015', 'user'),
(10, 'admin2', 'admin2@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin'),
(11, 'john', 'john@gmail.com', '6e0b7076126a29d5dfcbd54835387b7b', 'user');

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
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `id` (`id`);

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id`) REFERENCES `products` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
