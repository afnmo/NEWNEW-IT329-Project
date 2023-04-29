-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 29, 2023 at 01:48 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nuzldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ApplicationStatus`
--

CREATE TABLE `ApplicationStatus` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('under consideration','declined','accepted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Homeowner`
--

CREATE TABLE `Homeowner` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone_number` int(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `HomeSeeker`
--

CREATE TABLE `HomeSeeker` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` tinyint(3) NOT NULL,
  `family_members` tinyint(3) NOT NULL,
  `income` decimal(10,0) NOT NULL,
  `job` varchar(100) NOT NULL,
  `phone_number` int(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Property`
--

CREATE TABLE `Property` (
  `id` int(10) UNSIGNED NOT NULL,
  `homeowner_id` int(11) UNSIGNED NOT NULL,
  `property_category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `rooms` tinyint(2) NOT NULL,
  `rent_cost` decimal(10,0) NOT NULL,
  `location` varchar(150) NOT NULL,
  `max_tanants` tinyint(2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PropertyCategory`
--

CREATE TABLE `PropertyCategory` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PropertyImage`
--

CREATE TABLE `PropertyImage` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL,
  `path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `RentalApplication`
--

CREATE TABLE `RentalApplication` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL,
  `home_seeker_id` int(10) UNSIGNED NOT NULL,
  `application_status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ApplicationStatus`
--
ALTER TABLE `ApplicationStatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Homeowner`
--
ALTER TABLE `Homeowner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `HomeSeeker`
--
ALTER TABLE `HomeSeeker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Property`
--
ALTER TABLE `Property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeowner_id` (`homeowner_id`),
  ADD KEY `property_category_id` (`property_category_id`);

--
-- Indexes for table `PropertyCategory`
--
ALTER TABLE `PropertyCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PropertyImage`
--
ALTER TABLE `PropertyImage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `RentalApplication`
--
ALTER TABLE `RentalApplication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_status_id` (`application_status_id`),
  ADD KEY `home_seeker_id` (`home_seeker_id`),
  ADD KEY `property_id` (`property_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ApplicationStatus`
--
ALTER TABLE `ApplicationStatus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Homeowner`
--
ALTER TABLE `Homeowner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `HomeSeeker`
--
ALTER TABLE `HomeSeeker`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Property`
--
ALTER TABLE `Property`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PropertyCategory`
--
ALTER TABLE `PropertyCategory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PropertyImage`
--
ALTER TABLE `PropertyImage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `RentalApplication`
--
ALTER TABLE `RentalApplication`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Property`
--
ALTER TABLE `Property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`homeowner_id`) REFERENCES `Homeowner` (`id`),
  ADD CONSTRAINT `property_ibfk_2` FOREIGN KEY (`property_category_id`) REFERENCES `PropertyCategory` (`id`);

--
-- Constraints for table `PropertyImage`
--
ALTER TABLE `PropertyImage`
  ADD CONSTRAINT `propertyimage_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `Property` (`id`);

--
-- Constraints for table `RentalApplication`
--
ALTER TABLE `RentalApplication`
  ADD CONSTRAINT `rentalapplication_ibfk_1` FOREIGN KEY (`application_status_id`) REFERENCES `ApplicationStatus` (`id`),
  ADD CONSTRAINT `rentalapplication_ibfk_2` FOREIGN KEY (`home_seeker_id`) REFERENCES `HomeSeeker` (`id`),
  ADD CONSTRAINT `rentalapplication_ibfk_3` FOREIGN KEY (`property_id`) REFERENCES `Property` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
