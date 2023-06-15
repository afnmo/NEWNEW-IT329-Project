-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 15, 2023 at 01:16 PM
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
-- Database: `nuzl`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicationstatus`
--

CREATE TABLE `applicationstatus` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('under consideration','declined','accepted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `applicationstatus`
--

INSERT INTO `applicationstatus` (`id`, `status`) VALUES
(111, 'accepted'),
(222, 'declined'),
(333, 'under consideration');

-- --------------------------------------------------------

--
-- Table structure for table `homeowner`
--

CREATE TABLE `homeowner` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone_number` int(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `homeowner`
--

INSERT INTO `homeowner` (`id`, `name`, `phone_number`, `email_address`, `password`) VALUES
(1, 'Ahmed Saad', 569698827, 'ahmedSaad@gmail.com', '$2y$10$dFsUsdHZrg0E7mhJRTJd3e38YXVFUk3Dsw9Qtb8J4ykkMCcd2Kf26'),
(2, 'Sarah Mohammed', 505897658, 'Sarah2002@gmail.com', '$2y$10$7BbN9fGUX4/ybZgFYKllleg/gcju7CgVTpdfhrLbLuYw2m6dj6MRy'),
(3, 'Rahaf Hamad', 505446349, 'Rahaf@gmail.com', '$2y$10$lykEqjP7Zmpf0Vqze0IsiO9hMvGnqNsBzBaY6TL8CYxLM7qYxLCS.'),
(4, 'Ragad Waheed', 505778435, 'Ragadwh20@hotmail.com', '$2y$10$1ZucZy1BwqGeNUcMMz6ZNO785Uy/m2uipgk6aj/Rgd8RPYN7lDtDi'),
(5, 'Sarah Alomar', 505664356, 'sarahJamal@gmail.com', '$2y$10$hb6fs8NZZComIC9iq0WJZuADNcRZXAJOsNN4SmyGidXOEkj78vGsO'),
(6, 'Saleh Alshehri', 505887964, 'Saleh1@gmail.com', '$2y$10$au7W3QErqnPYpEhxlH.52Oh.6ghPKL9ejVHGQH1Z4NcnwuVm.xK.e');

-- --------------------------------------------------------

--
-- Table structure for table `homeseeker`
--

CREATE TABLE `homeseeker` (
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

--
-- Dumping data for table `homeseeker`
--

INSERT INTO `homeseeker` (`id`, `first_name`, `last_name`, `age`, `family_members`, `income`, `job`, `phone_number`, `email_address`, `password`) VALUES
(1, 'Ragad ', 'Saad', 35, 3, '20000', 'Dentist', 564643387, 'RagadSaad80@gmail.com', '$2y$10$uBvF2W1zfux1TaaCdAVbRuUR/tfTB5G5Ylz05a3hLblibQQnb19rS'),
(2, 'Ahmed', 'Alslaeh', 38, 4, '17000', 'Chef', 569693326, 'Ahmed1990@gmail.com', '$2y$10$bU8dzXR1Ew8LyS6vt7Ub3umhMTcBEwS9mVQT7iIu0AO.umTXnBHSu'),
(3, 'Reem', 'Waheed', 27, 3, '14000', 'Accountant', 505342981, 'Reemy12@gmail.com', '$2y$10$F42Aeyp2/mHLbTeIeqZDPuDcOQYUVn0cbU7cKKFDKdRnHuD1Y362m'),
(4, 'Abdullah', 'Alghamdi', 39, 4, '24000', 'Engineer', 597664231, 'EngAbdullah@gmail.com', '$2y$10$315nmzXOdo.CbLjtEmOBFePwd2K24VbEsnwI26dfAGm.NZ6OBnh5u');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
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

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `homeowner_id`, `property_category_id`, `name`, `rooms`, `rent_cost`, `location`, `max_tanants`, `description`) VALUES
(1, 1, 1, 'Al-Hittin plaza', 3, '5000', 'Riyadh, Hiitin dist.', 6, 'This villa is located in the Hittin district of Riyadh and has three spacious rooms, each with its own unique design and amenities. The villa is ideal for families or groups of friends of up to six people looking for a luxurious stay in the city.\r\n'),
(2, 4, 1, 'Holiday Villa', 6, '7000', 'Riyadh, AlAqeeq dist.\r\n', 6, 'This villa is located in the AlAqeeq district of Riyadh and has six spacious rooms, each with its own unique design and amenities. The villa is ideal for families or groups of friends of up to six people looking for a luxurious stay in the city.\r\n'),
(3, 3, 1, 'AlNakheel Home', 4, '6000', 'Riyadh, Alnakheel dist.', 6, 'Located in the AlNakheel district of Riyadh, this villa boasts four spacious rooms, each with its own unique design and amenities. It is an ideal accommodation option for families or groups of friends of up to six people who are seeking a luxurious stay in the city.'),
(4, 5, 2, 'Rawabi Square', 4, '1000', 'Riyadh, AlRawabi dist.', 4, 'AlRawabi Square is an affordable apartment that is suitable for families of up to four people. It consists of four rooms located in AlRawabi district.'),
(5, 2, 3, 'AlFalah Duplex', 3, '2500', 'Riyadh, AlFalah dist.', 5, 'This charming duplex is the ideal home for families or a group of friends. With three cozy bedrooms, it can comfortably accommodate up to five people. The property boasts a spacious living area, fully equipped kitchen, and two modern bathrooms. The outdoor garden area is perfect for enjoying the sunshine and fresh air. Located in a quiet neighborhood, this duplex offers easy access to local amenities and is the perfect place to call home.'),
(6, 6, 2, 'AlNaseem Apartment', 5, '3000', 'Riyadh, AlNaseem dist.', 7, '\r\nwrite a short description of an apartment that i want to make it for sale, it has 5 rooms and maximum for 8 people\r\n\r\nThis stunning apartment is the perfect home for larger families or groups of friends. With five spacious rooms, it can comfortably accommodate up to eight people. The apartment features a beautifully decorated living area, fully equipped kitchen, and two modern bathrooms. The bedrooms are tastefully furnished and provide ample storage space. Located in a desirable neighborhood, this apartment is conveniently located near local amenities and attractions. Don\'t miss your chance to own this fantastic property – schedule a viewing today and see for yourself why it\'s the perfect place to call home.'),
(7, 4, 1, 'AlIzdihar Villa', 5, '4000', 'Riyadh, AlIzdihar dist.', 9, 'Experience luxurious living at its finest with our stunning 5-room villa in the highly sought-after Al Izdihar district of Riyadh. With a maximum occupancy of 9 tenants, this villa is perfect for large families or groups of friends looking for a spacious and stylish living space. Located in a peaceful and convenient neighborhood, you\'ll have easy access to all the amenities you need, including supermarkets, restaurants, and shopping centers. Don\'t miss out on the opportunity to live in one of the most prestigious areas of Riyadh.');

-- --------------------------------------------------------

--
-- Table structure for table `propertycategory`
--

CREATE TABLE `propertycategory` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `propertycategory`
--

INSERT INTO `propertycategory` (`id`, `category`) VALUES
(1, 'villa'),
(2, 'apartment'),
(3, 'duplex ');

-- --------------------------------------------------------

--
-- Table structure for table `propertyimage`
--

CREATE TABLE `propertyimage` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL,
  `path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `propertyimage`
--

INSERT INTO `propertyimage` (`id`, `property_id`, `path`) VALUES
(1, 5, 'Images/image(1.1).jpg'),
(2, 5, 'Images/image(1.2).jpg'),
(3, 5, 'Images/image(1.3).jpg'),
(4, 1, 'Images/image(2.2).jpg'),
(5, 1, 'Images/image(2.1).jpg'),
(6, 1, 'Images/image(2.3).jpg'),
(7, 7, 'Images/image(3.1).jpg'),
(8, 7, 'Images/image(3.2).jpg'),
(9, 7, 'Images/image(3.3).jpg'),
(10, 3, 'Images/image(4.1).jpg'),
(11, 3, 'Images/image(4.2).jpg'),
(12, 3, 'Images/image(4.3).jpg'),
(13, 6, 'Images/image(5.1).jpg'),
(14, 6, 'Images/image(5.2).jpg'),
(15, 6, 'Images/image(5.3).jpg'),
(16, 4, 'Images/image(6.1).jpg'),
(17, 4, 'Images/image(6.2).jpg'),
(18, 4, 'Images/image(6.3).jpg'),
(19, 2, 'Images/image(7.1).jpg'),
(20, 2, 'Images/image(7.2).jpg'),
(21, 2, 'Images/image(7.3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rentalapplication`
--

CREATE TABLE `rentalapplication` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL,
  `home_seeker_id` int(10) UNSIGNED NOT NULL,
  `application_status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rentalapplication`
--

INSERT INTO `rentalapplication` (`id`, `property_id`, `home_seeker_id`, `application_status_id`) VALUES
(1, 2, 4, 333),
(2, 4, 2, 333),
(3, 3, 3, 222),
(4, 1, 1, 333),
(5, 6, 3, 111),
(6, 7, 3, 222),
(7, 2, 2, 333);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicationstatus`
--
ALTER TABLE `applicationstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeowner`
--
ALTER TABLE `homeowner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeseeker`
--
ALTER TABLE `homeseeker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeowner_id` (`homeowner_id`),
  ADD KEY `property_category_id` (`property_category_id`);

--
-- Indexes for table `propertycategory`
--
ALTER TABLE `propertycategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `propertyimage`
--
ALTER TABLE `propertyimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `rentalapplication`
--
ALTER TABLE `rentalapplication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_status_id` (`application_status_id`),
  ADD KEY `home_seeker_id` (`home_seeker_id`),
  ADD KEY `property_id` (`property_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicationstatus`
--
ALTER TABLE `applicationstatus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `homeowner`
--
ALTER TABLE `homeowner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `homeseeker`
--
ALTER TABLE `homeseeker`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `propertycategory`
--
ALTER TABLE `propertycategory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `propertyimage`
--
ALTER TABLE `propertyimage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rentalapplication`
--
ALTER TABLE `rentalapplication`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`homeowner_id`) REFERENCES `homeowner` (`id`),
  ADD CONSTRAINT `property_ibfk_2` FOREIGN KEY (`property_category_id`) REFERENCES `propertycategory` (`id`);

--
-- Constraints for table `propertyimage`
--
ALTER TABLE `propertyimage`
  ADD CONSTRAINT `propertyimage_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`);

--
-- Constraints for table `rentalapplication`
--
ALTER TABLE `rentalapplication`
  ADD CONSTRAINT `rentalapplication_ibfk_1` FOREIGN KEY (`application_status_id`) REFERENCES `applicationstatus` (`id`),
  ADD CONSTRAINT `rentalapplication_ibfk_2` FOREIGN KEY (`home_seeker_id`) REFERENCES `homeseeker` (`id`),
  ADD CONSTRAINT `rentalapplication_ibfk_3` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
