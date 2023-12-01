-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2023 at 08:12 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmer`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`) VALUES
(1, 1, 2, 'how far'),
(2, 1, 2, 'how you dey'),
(3, 2, 1, 'I dey jare'),
(4, 1, 3, 'Good morning'),
(5, 3, 1, 'Good morning how are you doing');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `buyer_name` varchar(100) NOT NULL,
  `total` bigint(10) NOT NULL,
  `status` text NOT NULL DEFAULT 'pending',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `farmer_id`, `buyer_id`, `product_id`, `quantity`, `amount`, `product_name`, `buyer_name`, `total`, `status`, `updated_at`) VALUES
(1, 2, 1, 1, 3, 1000, 'Cocoa', 'Timilehin Amu', 3000, 'pending', '2023-11-30 17:48:37'),
(2, 3, 1, 2, 6, 1000, 'Cocoa seed', 'Timilehin Amu', 6000, 'pending', '2023-12-01 08:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` bigint(10) NOT NULL,
  `amount` bigint(10) NOT NULL,
  `farmer_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `quantity`, `amount`, `farmer_id`, `created_at`) VALUES
(1, 'Cocoa', 'cocoa.jpeg', 10, 1000, 2, '2023-11-30 15:24:16'),
(2, 'Cocoa seed', 'cocoa.jpeg', 20, 1000, 3, '2023-12-01 08:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `local_govt` varchar(80) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `type` text NOT NULL DEFAULT 'buyer',
  `balance` bigint(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pin` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `gender`, `image`, `state`, `local_govt`, `address`, `phone`, `type`, `balance`, `password`, `pin`, `updated_at`) VALUES
(1, 'Timilehin Amu', 'amuoladipupo@gmail.com', 'male', 'mypic.jpg', 'Lagos', 'Ikorodu', '17, Adetunji Adebajo, Lucky Fibres', '+2347015281103', 'buyer', 0, '$2y$10$4euGlLyaRbK.SI0qVJGbmOSTyjZ6424cVVgphBdcQOZ3kBa1CjlGK', '', '2023-11-30 14:02:45'),
(2, 'Amu Oladipupo', 'amuoladipupo420@gmail.com', 'male', 'male.jpg', 'Lagos', 'Ikorodu', '17, Adetunji Adebajo, Lucky Fibres', '+2348181107488', 'farmer', 0, '$2y$10$5hLPDWGHsD7SvGy6bJE6Lu2aao5c/AZdOfbn.h0gQPJPqk1ChS/oS', '', '2023-11-30 16:38:30'),
(3, 'Dwight xawft', 'dwightxawft@gmail.com', 'male', 'male.jpg', 'Lagos', 'Ikeja', '17, Allen Ave', '+2349090943171', 'farmer', 0, '$2y$10$xP4p8.avX3V8ZQk89Ag0t.AFH1oSulP.P5qIKJXq3Nq3tJpaTzwxC', '', '2023-12-01 07:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `bank_code` varchar(10) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `report` varchar(100) NOT NULL,
  `amount` bigint(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
