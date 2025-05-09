-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 04:39 PM
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
-- Database: `servicehub_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `no` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `email`, `password`, `no`) VALUES
(1, 'Shouvik banerjee', 'shouvik', 'Shouvik@gmail.com', 'shouvik@2005', '9749497770'),
(4, 'Riya Das', 'riya', 'Riya@gmail.com', 'riya@2005', '9832101870'),
(5, 'Sk Asraful', 'asraful', 'Asraful@gmail.com', 'asraful@2004', '9382594060'),
(8, 'Sayan Majumdar', 'sayan', 'Sayan@gmail.com', 'sayan@2004', '9883422711');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `booking_status` enum('pending','accepted','rejected','completed') NOT NULL,
  `booking_time` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` enum('card','paypal','upi','cash') NOT NULL,
  `payment_status` enum('pending','success','failed','refunded') NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_status` enum('pending','approved','rejected') NOT NULL,
  `booking_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `service_id`, `provider_id`, `booking_status`, `booking_time`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created_at`, `approved_status`, `booking_no`) VALUES
(3, 6, 27, 14, 'accepted', '2025-05-05 09:34:10', 2000, 'cash', 'pending', '1111111', '2025-05-05 07:36:35', 'pending', 5555),
(4, 9, 26, 15, 'accepted', '2025-05-05 09:34:10', 2001, 'paypal', 'pending', '555', '2025-05-05 07:36:35', 'pending', 6666);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `provider_id`, `rating`, `comment`, `created_at`) VALUES
(1, 6, 14, 4, 'Wonderful services.', '2025-05-05 07:27:27'),
(2, 9, 15, 5, 'very good performance.', '2025-05-05 07:27:27'),
(3, 6, 20, 4, 'beautiful', '2025-05-08 02:47:38'),
(4, 9, 20, 5, 'wonderful', '2025-05-08 02:47:38'),
(5, 11, 20, 4, 'beautiful', '2025-05-08 02:47:43'),
(6, 12, 20, 5, 'wonderful', '2025-05-08 02:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(20) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_name`, `image`) VALUES
(24, 'Electrician', '6b5c5d8f515e9fa4205182b3dd1e1766.jpg'),
(25, 'Cleaning', '02ec059100dfe256d44d50ef555591e8.jpg'),
(26, 'AC Technician', '493b032192f9e5b0aac6e38cb86476c4.jpg'),
(27, 'Interior Designer', '0cad8dc4e42fa830745515897bd1e7b1.jpg'),
(28, 'Car Mechanic', 'b95e591a4378b1149c4fc8efff3e802d.jpg'),
(29, 'Carpenter', 'ef1b971675330f2100340a494e15cf6d.jpg'),
(30, 'Plumber', '1c6445f2df7b290de11c78245a1916db.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `provider_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `service_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `approved_action` enum('pending','approved','rejected') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `businessname` varchar(50) NOT NULL,
  `lisenceno` int(11) NOT NULL,
  `identityno` int(11) NOT NULL,
  `identityimage` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(10) DEFAULT NULL,
  `provider_name` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`provider_id`, `image`, `service_id`, `description`, `approved_action`, `created_at`, `businessname`, `lisenceno`, `identityno`, `identityimage`, `email`, `phone`, `provider_name`, `password`, `address`) VALUES
(14, '', 27, 'We provide a good service.', 'approved', '2025-05-05 07:23:20', 'DesignX', 1111100000, 25206547, '', 'riya@gmail.com', 1234567891, 'Riya Das', 'Riya@2005', 'Burdwan'),
(15, '', 26, 'we provide good service. very good. ', 'approved', '2025-05-05 07:23:20', 'Sony Max', 222111, 147852, '', 'sayan@gmail.com', 987452410, 'Sayan Majumdar', 'sayan@2004', 'Mameri'),
(18, '', 24, '', 'approved', '2025-05-05 14:40:39', 'ghosh electronic', 0, 0, '', 'chinmoy@gmail.com', 2147483647, 'chinmoy ghosh', 'chinmoy@2000', 'Delhi'),
(19, '', 28, 'We provide a good service.', 'pending', '2025-05-06 14:51:39', 'OLA', 0, 0, '', 'debu@gmail.com', 2147483647, 'Debu Banerjee', 'debu@2001', 'Burdwan'),
(20, '', 30, 'We provide a good service. ', 'pending', '2025-05-08 02:41:53', 'Santra Hub', 0, 0, '', 'Anik@gmail.com', 2147483647, 'Anik Santra', 'Anik@2002', 'hooghly');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `dob`, `email`, `password`, `phone`, `address`, `image`, `created_at`, `updated_at`) VALUES
(6, 'shouvik banerjee', '2015-05-01', 'shouvik@gmail.com', 'shouvik@2005', '1234567890', 'Kolkata', '', '2025-05-05 07:04:49', '2025-05-05 07:04:49'),
(9, 'Sk Asraful', '2025-05-06', 'Asraful@gmail.com', 'Asraful@2004', '9784563210', 'Nigan', '', '2025-05-05 07:09:27', '2025-05-05 07:09:27'),
(11, 'Soham dutta', '0000-00-00', 'soham@gmail.com', 'soham@2005', '7797472017', '', '', '2025-05-05 14:10:23', '2025-05-05 14:10:23'),
(12, 'Sudipta Samanta', '0000-00-00', 'Sudipta@gmail.com', 'sudipta@2005', '6295069367', '', '', '2025-05-08 02:39:14', '2025-05-08 02:39:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`,`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `service_providers`
--
ALTER TABLE `service_providers`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
