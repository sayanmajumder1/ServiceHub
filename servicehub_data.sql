-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 08:19 AM
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
  `booking_no` varchar(100) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `service_id`, `provider_id`, `booking_status`, `booking_time`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created_at`, `booking_no`, `reason`) VALUES
(3, 6, 27, 14, 'completed', '2025-05-05 09:34:10', 0, '', 'success', '1111111', '2025-05-05 07:36:35', '5555', ''),
(4, 9, 26, 14, 'completed', '2025-05-05 09:34:10', 2001, 'paypal', 'success', '555', '2025-05-05 07:36:35', '6666', 'bad behaviour'),
(7, 6, 26, 15, 'pending', '2025-05-18 05:29:03', 0, '', 'pending', '', '2025-05-18 12:29:03', 'BOOK682953FFDBC00', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(3, 'Riya Das', 'rd@gmail.com', 'fiii', '2025-05-18 05:57:21'),
(4, 'Riya Das', 'rd3456@gmail.com', 'hi guysssss', '2025-05-18 06:01:05');

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
(2, 9, 14, 5, 'very good performance.', '2025-05-05 07:27:27'),
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
(24, 'Electrician', 'b1fa214830d20693ddb1cf357a4b0146.jpg'),
(25, 'Cleaning', '504123278efd205df7aabb9764967ad3.jpg'),
(26, 'AC Technician', '493b032192f9e5b0aac6e38cb86476c4.jpg'),
(27, 'Interior Designer', '0cad8dc4e42fa830745515897bd1e7b1.jpg'),
(28, 'Car Mechanic', 'b95e591a4378b1149c4fc8efff3e802d.jpg'),
(29, 'Carpenter', '6091ff8ee4440af26ec9fd5c0f92fb23.jpg'),
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
  `lisenceno` text NOT NULL,
  `identityno` text NOT NULL,
  `identityimage` text NOT NULL,
  `email` text NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `provider_name` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`provider_id`, `image`, `service_id`, `description`, `approved_action`, `created_at`, `businessname`, `lisenceno`, `identityno`, `identityimage`, `email`, `phone`, `provider_name`, `password`, `address`) VALUES
(14, '651c83cfb989c9b7e91285fad7c9c83f.jpg', 27, 'We provide a good service.', 'approved', '2025-05-05 07:23:20', 'DesignX', '1111100000', '25206547', '', 'riya@gmail.com', '1234567890', 'Riya Das', 'Riya@2005', 'Burdwan'),
(15, '', 26, 'we provide good service. very good. ', 'approved', '2025-05-05 07:23:20', 'Sony Max', '222111', '147852', '', 'sayan@gmail.com', '987452410', 'Sayan Majumdar', 'sayan@2004', 'Memeri'),
(22, '', 28, '', 'approved', '2025-05-13 03:49:27', 'Santra Hub', 'A222111A', 'A111A', 'uploads/6822c141cad44_naihati ma.jpg', 'Anik@gmail.com', '2147483647', 'Anik Santra', '1234', 'Jamalpur');

-- --------------------------------------------------------

--
-- Table structure for table `subservice`
--

CREATE TABLE `subservice` (
  `subservice_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `subservice_name` varchar(20) NOT NULL,
  `service_des` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subservice`
--

INSERT INTO `subservice` (`subservice_id`, `service_id`, `subservice_name`, `service_des`, `image`) VALUES
(5, 26, 'Gas Pipe Repairing', 'we provide better repairing', '16f365ab23faa72a9eaf2c585075efef.jpg'),
(6, 26, 'Foam Wash', 'we provide better Foam Wash', '2569191a5406adbf3503969a55783d5c.jpg'),
(7, 24, 'wairing', 'we provide better repairing', 'd439c618e976eded7450b293767e66a7.jpg'),
(8, 26, 'Ac installation', 'we provide better repairing', 'af737a013c3c45a3793937e0ad1488d0.jpg'),
(9, 26, 'Repair', 'we provide better repairing', 'ea9654df2ac1d5b95518c600ff98a763.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subservice_price_map`
--

CREATE TABLE `subservice_price_map` (
  `subprice_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `subservice_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subservice_price_map`
--

INSERT INTO `subservice_price_map` (`subprice_id`, `service_id`, `subservice_id`, `provider_id`, `price`) VALUES
(1, 26, 5, 15, 2000),
(2, 26, 6, 15, 5000),
(3, 26, 8, 15, 6000);

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
(6, 'shouvik banerjee', '2025-05-29', 'shouvik@gmail.com', 'shouvik@2005', '1234567890', 'Kolkata', '2025-05-13_050657_user_6.jpg', '2025-05-05 07:04:49', '2025-05-13 03:46:51'),
(9, 'Sk Asraful', '2025-05-06', 'Asraful@gmail.com', 'Asraful@2004', '9784563210', 'Nigan', '2025-05-14_162419_user_9.jpg', '2025-05-05 07:09:27', '2025-05-14 14:59:14'),
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
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `subservice`
--
ALTER TABLE `subservice`
  ADD PRIMARY KEY (`subservice_id`);

--
-- Indexes for table `subservice_price_map`
--
ALTER TABLE `subservice_price_map`
  ADD PRIMARY KEY (`subprice_id`);

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subservice`
--
ALTER TABLE `subservice`
  MODIFY `subservice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subservice_price_map`
--
ALTER TABLE `subservice_price_map`
  MODIFY `subprice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
