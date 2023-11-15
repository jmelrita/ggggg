-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 09:14 AM
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
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(9, 'ako', '$2y$10$6YOXV18d87Qh2zKmShL9fOtUyR6eGoB3mwZOuVeV5Ny', '', ''),
(10, 'rita', '$2y$10$xfBNJ2XJIyVYpliOJAzKwex4tlGTwIrYOD2Gn8D7EUN', '', ''),
(11, 'haha', '$2y$10$fb0w2.SJOSzqhHdOOv0fTerxMpNGpj17dPEyJN6og0E', '', ''),
(12, 'poyy', '$2y$10$4eV1f2hswcr3NcWaC7XuRuk/sVCRX5st8JPO9LsNwUV', '', ''),
(13, 'rta', '$2y$10$Q2asRUH9mgaDqsI7mcYa8OJjP1PQmx5zourSyk6gDUw', '', ''),
(14, 'rta123', '$2y$10$BOxtLvAMm1blEegzGZP1eeFElifXGCaRYNmkeWFukSNMNaeOAda2.', '', ''),
(15, 'asdsad', '$2y$10$1U6MiJn5VVcytq1OC9nwpOyruNHyRm/8t9d5ywJKSpF3jj8apsxLS', '', ''),
(16, 'junmel', '$2y$10$CcZJcYgQGG7pohkdBPhFnumvdop6s/.fxAGUg1mGY.3zdY.yaKmBy', '', ''),
(17, 'junmelrita', '$2y$10$QIg6hZG6iEYeQyWCy5crLuxjAOnw7EUjLxeh94hlUdE4JneC9gNL2', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
