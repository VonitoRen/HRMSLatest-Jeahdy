-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 05:29 PM
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
-- Database: `db_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checkinout`
--

CREATE TABLE `tbl_checkinout` (
  `checkinout_id` int(10) NOT NULL DEFAULT 202400,
  `checkin_date` varchar(150) NOT NULL,
  `checkout_date` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkinout`
--

INSERT INTO `tbl_checkinout` (`checkinout_id`, `checkin_date`, `checkout_date`) VALUES
(1, '2024-11-29', '2024-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `reservation_id` int(10) NOT NULL,
  `client_id` varchar(150) NOT NULL,
  `client_fullname` varchar(150) NOT NULL,
  `total_members` varchar(150) NOT NULL,
  `room_type` varchar(150) NOT NULL,
  `room_utility` varchar(150) NOT NULL,
  `room_number` varchar(150) NOT NULL,
  `add_pillow` varchar(150) NOT NULL,
  `add_blanket` varchar(150) NOT NULL,
  `checkinout_id` varchar(150) NOT NULL,
  `total_cost_per_day` varchar(150) NOT NULL,
  `totalBill` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`reservation_id`, `client_id`, `client_fullname`, `total_members`, `room_type`, `room_utility`, `room_number`, `add_pillow`, `add_blanket`, `checkinout_id`, `total_cost_per_day`, `totalBill`) VALUES
(1, '5240000', 'Justine Ducusin', '1', 'Single', 'AC', '10', '2', '1', '1', '2445', '4890');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `room_id` int(10) NOT NULL,
  `room_number` varchar(150) NOT NULL,
  `room_type` varchar(150) NOT NULL,
  `ac_non_ac` varchar(150) NOT NULL,
  `room_capacity` int(10) NOT NULL,
  `room_price` int(10) NOT NULL,
  `room_status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`room_id`, `room_number`, `room_type`, `ac_non_ac`, `room_capacity`, `room_price`, `room_status`) VALUES
(1, '001', 'Single', 'AC', 1, 1595, 'AVAILABLE'),
(2, '002', 'Double', 'AC', 2, 2000, 'AVAILABLE'),
(3, '003', 'Single', 'NON-AC', 1, 1595, 'AVAILABLE'),
(4, '004', 'Double', 'NON-AC', 2, 2000, 'AVAILABLE'),
(5, '005', 'Family', 'AC', 3, 3000, 'AVAILABLE'),
(6, '006', 'Family', 'NON-AC', 3, 3000, 'AVAILABLE'),
(7, '007', 'Family', 'AC', 3, 3000, 'AVAILABLE'),
(8, '007', 'Family', 'AC', 3, 3000, 'AVAILABLE'),
(9, '009', 'Single', 'AC', 1, 1595, 'AVAILABLE'),
(10, '010', 'Single', 'AC', 1, 1595, 'OCCUPIED'),
(11, '011', 'Double', 'NON-AC', 2, 2000, 'AVAILABLE'),
(12, '012', 'Double', 'NON-AC', 2, 2000, 'AVAILABLE'),
(13, '013', 'Single', 'AC', 1, 1595, 'AVAILABLE'),
(14, '014', 'Single', 'NON-AC', 1, 1595, 'AVAILABLE'),
(15, '015', 'Double', 'AC', 2, 2000, 'AVAILABLE'),
(16, '015', 'Double', 'AC', 2, 2000, 'AVAILABLE'),
(17, '017', 'Family', 'NON-AC', 3, 3000, 'AVAILABLE'),
(18, '018', 'Family', 'NON-AC', 3, 3000, 'AVAILABLE'),
(19, '019', 'Family', 'NON-AC', 3, 3000, 'AVAILABLE'),
(20, '020', 'Single', 'NON-AC', 1, 1595, 'AVAILABLE'),
(21, '021', 'Double', 'AC', 2, 2000, 'AVAILABLE'),
(22, '022', 'Single', 'NON-AC', 1, 1595, 'AVAILABLE'),
(23, '023', 'Family', 'NON-AC', 4, 1, 'AVAILABLE'),
(24, '024', 'Double', 'NON-AC', 2, 2, 'AVAILABLE'),
(25, '025', 'Double', 'NON-AC', 2, 9, 'AVAILABLE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staff_id` int(8) NOT NULL,
  `staff_firstname` varchar(150) NOT NULL,
  `staff_lastname` varchar(150) NOT NULL,
  `staff_username` varchar(150) NOT NULL,
  `staff_email` varchar(150) NOT NULL,
  `staff_phonenumber` varchar(150) NOT NULL,
  `staff_status` varchar(150) NOT NULL,
  `staff_joineddate` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`staff_id`, `staff_firstname`, `staff_lastname`, `staff_username`, `staff_email`, `staff_phonenumber`, `staff_status`, `staff_joineddate`) VALUES
(20240002, 'Mark Jeahdy', 'Gabris', 'Jemiee', 'Jemiee@gmail.com', '09772345605', 'ACTIVE', '2024-05-13 12:33:50'),
(20240003, 'Jandel', 'Estioco', 'Tikoy', 'Tikoy@gmail.com', '0977234500', 'ACTIVE', '2024-05-13 17:43:20'),
(20240004, 'Joshua', 'Pablo', 'Pables', 'Pablo@gmail.com', '09772345612', 'ACTIVE', '2024-05-16 06:25:16'),
(20240005, 'Janramdel', 'Deguzguz', 'Deguzy', 'Deguzy@gmail.com', '09772345123', 'ACTIVE', '2024-05-16 06:28:32'),
(20240006, 'Jandel', 'asdasd', 'asdasd', 'sadasdasd@gmail.com', '09772345651', 'ACTIVE', '2024-05-16 15:04:59'),
(20240007, 'Jerome', 'Buraga', 'Max', 'jerome@gmail.com', '09772345123', 'ACTIVE', '2024-05-16 17:38:55'),
(20240008, 'Alvaro', 'Grande', 'alvzs', '21100586@slc-sflu.edu.ph', '09293829392', 'ACTIVE', '2024-05-16 23:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(8) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `userlevel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `userlevel`) VALUES
(20240001, 'Jandel Estioco', '$2y$10$mOtcHaQj6.M1o9pm2bXJA.4jSLmNsApIdQ/otOoafFzgYK30HxUou', 'Admin'),
(20240002, 'Jemiee', '$2y$10$18KgT0lZFm4FBQ3U0GtE2.5SBgobOIP0YIY15zjYeHIYv1E7vGlv2', 'Front Desk Staff'),
(20240003, 'Tikoy', '$2y$10$Xu2h9oG.SGLdJ9KeaiyavemaJza6YGZatDSR/p8FiNAG0Bopgjewm', 'Front Desk Staff'),
(20240004, 'Pables', '$2y$10$q86.JomGcr8Eb/5xq8yHx.ubRtN13t.WGmYaTQemmuBPzt6HfCRo.', 'Front Desk Staff'),
(20240005, 'Deguzy', '$2y$10$KQxW9RhzfG5hOQARS1kiq.eCN9ezoOD9nAsnx6CMXH2uNeh9IHHCm', 'Front Desk Staff'),
(20240006, 'asdasd', '$2y$10$MbY0Wj.VVrk92avx7NzkZejqTBjri3CjinCqx4zkmeW7goAthwWfC', 'Front Desk Staff'),
(20240007, 'Max', '$2y$10$usjHdtdIguYazsZeC0np7uK3zgh5CR1lDtMRJHQgeIagK8IQv8f6a', 'Front Desk Staff'),
(20240008, 'alvzs', '$2y$10$KDR5b9PUCHSUFSysxujE2eypf8i1SUCQ8Kx6CxeC5uI.UlRydyH6e', 'Front Desk Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userclient`
--

CREATE TABLE `tbl_userclient` (
  `client_id` int(11) NOT NULL,
  `client_fname` varchar(150) NOT NULL,
  `client_lname` varchar(150) NOT NULL,
  `client_bdate` date NOT NULL,
  `client_pnum` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_userclient`
--

INSERT INTO `tbl_userclient` (`client_id`, `client_fname`, `client_lname`, `client_bdate`, `client_pnum`) VALUES
(5240000, 'Justine', 'Ducusin', '2024-05-13', '09772345601'),
(5240001, 'Alvin Johny', 'Peria', '2024-05-13', '09977234560'),
(5240002, 'Joseph', 'Pedro', '2024-05-17', '09977234560'),
(5240003, 'Eliandro', 'Agorto', '2024-05-02', '09772344132'),
(5240004, 'Alvaro', 'Grande', '2024-05-17', '09293829392'),
(5240005, 'Fj', 'Bautista', '2024-05-17', '09349134917');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_checkinout`
--
ALTER TABLE `tbl_checkinout`
  ADD PRIMARY KEY (`checkinout_id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_userclient`
--
ALTER TABLE `tbl_userclient`
  ADD PRIMARY KEY (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `reservation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staff_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20240009;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20240009;

--
-- AUTO_INCREMENT for table `tbl_userclient`
--
ALTER TABLE `tbl_userclient`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5240006;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
