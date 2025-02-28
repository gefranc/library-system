-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 08:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, '[admin]', '[admin123]');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Genre` varchar(100) NOT NULL,
  `AvailableCopies` int(11) NOT NULL DEFAULT 1,
  `Active` tinyint(1) DEFAULT 1,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `Genre`, `AvailableCopies`, `Active`, `status`) VALUES
(1, 'Brave New World', 'Aldous Huxley', 'Classics', 5, 1, 'Active'),
(2, 'Moby-Dick', 'Herman Melville', 'Fiction', 3, 1, 'Active'),
(3, 'Pride and Prejudice', 'Jane Austen', 'Romance', 5, 1, 'Active'),
(4, 'The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 2, 1, 'Active'),
(5, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 5, 1, 'Active'),
(6, 'Dune', 'Frank Herbert', 'Sci-Fi', 3, 1, 'Active'),
(7, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Classic', 3, 1, 'Active'),
(8, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 7, 1, 'Active'),
(9, 'The Alchemist', 'Paulo Coelho', 'Philosophy', 5, 1, 'Active'),
(10, 'Frankenstein', 'Mary Shelley', 'Horror', 2, 1, 'Active'),
(11, 'Harry Potter', 'J.K. Rowling', 'Fantasy', 5, 1, 'Active'),
(12, 'eternals', 'michaels', 'Fiction', 5, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `borrowedbooks`
--

CREATE TABLE `borrowedbooks` (
  `TransactionID` int(10) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `BorrowedDate` date NOT NULL,
  `ReturnDate` date NOT NULL,
  `Status` enum('Borrowed','Returned','') NOT NULL DEFAULT 'Borrowed',
  `ReturnStatus` enum('Borrowed','Returned') DEFAULT 'Borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowedbooks`
--

INSERT INTO `borrowedbooks` (`TransactionID`, `CustomerID`, `BookID`, `BorrowedDate`, `ReturnDate`, `Status`, `ReturnStatus`) VALUES
(9, 1, 6, '2025-02-24', '2025-03-10', 'Borrowed', 'Borrowed'),
(11, 1, 5, '2025-02-24', '2025-03-10', 'Borrowed', 'Borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `Email`, `Password`, `FirstName`, `LastName`, `Approved`) VALUES
(1, 'allan@gmail.com', '$2y$10$SsVC2Wpsp/p7HjvgLoJboeEXeyWRjKFQlVWNWK9xF4bMNjb.90eH.', 'allan', 'miller', 1),
(2, 'susan@gmail.com', '$2y$10$DIpLsHcCVxlyIJEuYEEoNOF2DkuKDwWznlKjOeGshyaT4qcQ9oDTu', 'susan', 'wambui', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`);

--
-- Indexes for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `test` (`CustomerID`),
  ADD KEY `BookID` (`BookID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  MODIFY `TransactionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD CONSTRAINT `borrowedbooks_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `test` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
