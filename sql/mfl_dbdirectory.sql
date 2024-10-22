-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 07:10 AM
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
-- Database: `mfl_dbdirectory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_ID` int(11) NOT NULL,
  `ADMIN_EMAIL` varchar(255) DEFAULT NULL,
  `ADMIN_PASS` varchar(255) DEFAULT NULL,
  `ADMIN_USERNAME` varchar(255) DEFAULT NULL,
  `ADMIN_POSITION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `ADMIN_EMAIL`, `ADMIN_PASS`, `ADMIN_USERNAME`, `ADMIN_POSITION`) VALUES
(1, 'danielsyauqi@icloud.com', 'daniel08', 'Daniel Syauqi', 'Project Manager');

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `APPROVAL_ID` int(11) NOT NULL,
  `FA_ID` int(11) DEFAULT NULL,
  `ADMIN_ID` int(11) DEFAULT NULL,
  `TEMP_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`APPROVAL_ID`, `FA_ID`, `ADMIN_ID`, `TEMP_ID`) VALUES
(1, 1, 1, 1),
(17, 11, 1, 8),
(18, 8, 1, 7),
(19, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUST_ID` int(11) NOT NULL,
  `CUST_EMAIL` varchar(255) DEFAULT NULL,
  `CUST_PASS` varchar(255) DEFAULT NULL,
  `CUST_IC_NAME` varchar(255) DEFAULT NULL,
  `CUST_IC_NUM` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUST_ID`, `CUST_EMAIL`, `CUST_PASS`, `CUST_IC_NAME`, `CUST_IC_NUM`) VALUES
(5, 'danielcruzz04@gmail.com', 'Allahswt01', 'Muhammad Daniel Syauqi bin Hardina', '040914-01-1141'),
(6, '23fareast@gmail.com', '2312@Fareast', 'Faaris Danish', '051223050225'),
(8, 'muhammadhassnaim17@gmail.com', 'ben', 'Muhammad Hassnaim bin Ibrahim', '041020101089'),
(9, 'irfantaufik0306@gmail.com', '030609010573', 'Muhammad Irfan bin Muhammad Taufik', '030609010573'),
(10, 'syedalhaqeem050107@gmail.com', 'Kiwafifel05', 'Syed Al Haqeem ', '050107100841'),
(11, 'muhdazrafiqdaniel@gmail.com', '123456', 'Azrafiq Daniel', '040227010657'),
(12, 'amir@gmail.com', '', 'AIZAT HARITH BIN HARITH', '0009998888');

-- --------------------------------------------------------

--
-- Table structure for table `fa`
--

CREATE TABLE `fa` (
  `FA_ID` int(11) NOT NULL,
  `FA_NAME` varchar(255) DEFAULT NULL,
  `FA_EMAIL` varchar(255) DEFAULT NULL,
  `FA_PASSWORD` varchar(255) DEFAULT NULL,
  `TEAM_NAME` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fa`
--

INSERT INTO `fa` (`FA_ID`, `FA_NAME`, `FA_EMAIL`, `FA_PASSWORD`, `TEAM_NAME`) VALUES
(1, 'Persatuan Bolasepak Negeri Johor', 'pbnj@gmail.com', 'pbnj2024', 'JOHOR DARUL TA\'ZIM'),
(2, 'Persatuan Bolasepak Negeri Sembilan', 'pbns@gmail.com', 'pbns2024', 'NEGERI SEMBILAN F.C.'),
(3, 'Persatuan Bolasepak Negeri Sarawak', 'pbsarawak@gmail.com', 'sarawakfa2024', 'KUCHING F.C.'),
(4, 'Persatuan Bolasepak Negeri Selangor', 'selangorfa@gmail.com', 'selangor2024', 'SELANGOR F.C.'),
(5, 'Persatuan Bolasepak Negeri Terengganu', 'pbnt@gmail.com', 'pbnt2024', 'TERENGGANU F.C.'),
(6, 'Persatuan Bolasepak Negeri Perak', 'pbnp@gmail.com', 'pbnp2024', 'PERAK F.C.'),
(7, 'Persatuan Bolasepak Negeri Pahang', 'pbnpahang@gmail.com', 'pbnpahang2024', 'SRI PAHANG F.C.'),
(8, 'Persatuan Bolasepak Sabah', 'pbs@gmail.com', 'pbs2024', 'SABAH F.C.'),
(9, 'Kelab Bolasepak Polis Diraja Malaysia', 'kbpdrm@gmail.com', 'kbdprm2024', 'PDRM F.C.'),
(10, 'Persatuan Bolasepak Negeri Pulau Pinang', 'pbpp@gmail.com', 'pbpp2024', 'PENANG F.C.'),
(11, 'Persatuan Bolasepak Kuala Lumpur', 'pbkl@gmail.com', 'pbkl2024', 'KUALA LUMPUR F.C.'),
(12, 'Persatuan Bolasepak Negeri Kedah', 'pbnkedah@gmail.com', 'pbnkedah2024', 'KEDAH DARUL AMAN F.C.'),
(13, 'Persatuan Bolasepak Negeri Kelantan', 'pbnkelantan@gmail.com', 'pbnk2024', 'KELANTAN DARUL NAIM F.C.');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENT_ID` int(11) NOT NULL,
  `TICKET_QTY` int(11) DEFAULT NULL,
  `DATE_PAYMENT` date DEFAULT NULL,
  `CUST_ID` int(11) DEFAULT NULL,
  `MATCH_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENT_ID`, `TICKET_QTY`, `DATE_PAYMENT`, `CUST_ID`, `MATCH_ID`) VALUES
(1504, 1, '2024-07-24', 5, 5),
(2180, 1, '2024-08-06', 5, 5),
(5725, 1, '2024-09-13', 12, 5),
(7328, 1, '2024-09-13', 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `standings`
--

CREATE TABLE `standings` (
  `STANDINGS_ID` int(11) NOT NULL,
  `FA_ID` int(11) DEFAULT NULL,
  `GAMES_PLAYED` int(11) DEFAULT NULL,
  `WON` int(11) DEFAULT NULL,
  `DRAW` int(11) DEFAULT NULL,
  `LOSE` int(11) DEFAULT NULL,
  `GOALS_SCORED` int(11) DEFAULT NULL,
  `GOALS_CONCEDED` int(11) DEFAULT NULL,
  `LAST_5` varchar(255) DEFAULT NULL,
  `PENALTY` int(11) DEFAULT NULL,
  `TOTAL_POINTS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standings`
--

INSERT INTO `standings` (`STANDINGS_ID`, `FA_ID`, `GAMES_PLAYED`, `WON`, `DRAW`, `LOSE`, `GOALS_SCORED`, `GOALS_CONCEDED`, `LAST_5`, `PENALTY`, `TOTAL_POINTS`) VALUES
(1, 1, 11, 7, 0, 4, 20, 12, NULL, NULL, 21),
(2, 5, 10, 6, 1, 3, 16, 9, NULL, NULL, 18),
(3, 7, 2, 1, 1, 0, 3, 2, NULL, NULL, 3),
(4, 8, 6, 3, 2, 1, 8, 7, NULL, NULL, 9),
(5, 9, 3, 1, 1, 1, 4, 4, NULL, NULL, 3),
(6, 4, 7, 3, 1, 3, 9, 7, NULL, NULL, 9),
(7, 3, 4, 1, 2, 1, 5, 5, NULL, NULL, 3),
(8, 10, 3, 0, 3, 0, 1, 1, NULL, NULL, 0),
(9, 11, 2, 0, 1, 1, 2, 6, NULL, NULL, 0),
(10, 12, 3, 1, 0, 2, 1, 3, NULL, NULL, 3),
(11, 13, 3, 0, 0, 3, 2, 7, NULL, NULL, 0),
(12, 2, 3, 0, 0, 3, 1, 8, NULL, NULL, 0),
(13, 6, 3, 1, 0, 2, 5, 6, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `temp_ticket`
--

CREATE TABLE `temp_ticket` (
  `TEMP_ID` int(11) NOT NULL,
  `MATCH_HOME` int(11) NOT NULL,
  `MATCH_AWAY` int(11) NOT NULL,
  `MATCH_DATE` date DEFAULT NULL,
  `MATCH_TIME` time DEFAULT NULL,
  `MATCH_PRICE` double(10,2) DEFAULT NULL,
  `MATCH_VENUE` varchar(255) DEFAULT NULL,
  `DATE_REQUEST` date DEFAULT NULL,
  `TIME_REQUEST` time DEFAULT NULL,
  `STATUS` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_ticket`
--

INSERT INTO `temp_ticket` (`TEMP_ID`, `MATCH_HOME`, `MATCH_AWAY`, `MATCH_DATE`, `MATCH_TIME`, `MATCH_PRICE`, `MATCH_VENUE`, `DATE_REQUEST`, `TIME_REQUEST`, `STATUS`) VALUES
(1, 1, 5, '2024-07-26', '20:15:00', 20.50, 'Stadium Sultan Ibrahim', '2024-06-20', '12:44:00', 'APPROVED'),
(7, 8, 1, '2024-07-13', '20:15:00', 15.00, 'Stadium Likas', '2024-06-27', '11:42:00', 'APPROVED'),
(8, 11, 4, '2024-07-14', '20:15:00', 19.50, 'Stadium Bolasepak Cheras', '2024-06-27', '11:46:00', 'APPROVED'),
(9, 1, 9, '2024-09-20', '22:10:00', 20.00, 'STADIUM SULTAN IBRAHIM', '2024-09-13', '03:38:00', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `ticketmatch`
--

CREATE TABLE `ticketmatch` (
  `MATCH_ID` int(11) NOT NULL,
  `MATCH_URL` varchar(255) DEFAULT NULL,
  `APPROVAL_ID` int(11) DEFAULT NULL,
  `TEMP_ID` int(11) NOT NULL,
  `DEPLOY` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticketmatch`
--

INSERT INTO `ticketmatch` (`MATCH_ID`, `MATCH_URL`, `APPROVAL_ID`, `TEMP_ID`, `DEPLOY`) VALUES
(1, 'JDTvsTGFC.png', 1, 1, 'UNREADY'),
(4, 'KLCITYvsSELANGOR.png', 17, 8, 'READY'),
(5, 'SABAHvsJDT.png', 18, 7, 'UNREADY'),
(6, '26.png', 19, 9, 'READY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
  ADD PRIMARY KEY (`APPROVAL_ID`),
  ADD KEY `FA_ID` (`FA_ID`),
  ADD KEY `ADMIN_ID` (`ADMIN_ID`),
  ADD KEY `fk_temp_in_approval` (`TEMP_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUST_ID`);

--
-- Indexes for table `fa`
--
ALTER TABLE `fa`
  ADD PRIMARY KEY (`FA_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PAYMENT_ID`),
  ADD KEY `CUST_ID` (`CUST_ID`),
  ADD KEY `MATCH_ID` (`MATCH_ID`);

--
-- Indexes for table `standings`
--
ALTER TABLE `standings`
  ADD PRIMARY KEY (`STANDINGS_ID`),
  ADD KEY `FA_ID` (`FA_ID`);

--
-- Indexes for table `temp_ticket`
--
ALTER TABLE `temp_ticket`
  ADD PRIMARY KEY (`TEMP_ID`),
  ADD KEY `TEMP_FA_FK` (`MATCH_HOME`);

--
-- Indexes for table `ticketmatch`
--
ALTER TABLE `ticketmatch`
  ADD PRIMARY KEY (`MATCH_ID`),
  ADD KEY `TEMP_ID` (`TEMP_ID`),
  ADD KEY `fk_approval_ticketmatch` (`APPROVAL_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ADMIN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
  MODIFY `APPROVAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CUST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fa`
--
ALTER TABLE `fa`
  MODIFY `FA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `standings`
--
ALTER TABLE `standings`
  MODIFY `STANDINGS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `temp_ticket`
--
ALTER TABLE `temp_ticket`
  MODIFY `TEMP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticketmatch`
--
ALTER TABLE `ticketmatch`
  MODIFY `MATCH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval`
--
ALTER TABLE `approval`
  ADD CONSTRAINT `approval_ibfk_1` FOREIGN KEY (`FA_ID`) REFERENCES `fa` (`FA_ID`),
  ADD CONSTRAINT `approval_ibfk_2` FOREIGN KEY (`ADMIN_ID`) REFERENCES `admin` (`ADMIN_ID`),
  ADD CONSTRAINT `fk_temp_in_approval` FOREIGN KEY (`TEMP_ID`) REFERENCES `temp_ticket` (`TEMP_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`CUST_ID`) REFERENCES `customer` (`CUST_ID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`MATCH_ID`) REFERENCES `ticketmatch` (`MATCH_ID`);

--
-- Constraints for table `standings`
--
ALTER TABLE `standings`
  ADD CONSTRAINT `standings_ibfk_1` FOREIGN KEY (`FA_ID`) REFERENCES `fa` (`FA_ID`);

--
-- Constraints for table `temp_ticket`
--
ALTER TABLE `temp_ticket`
  ADD CONSTRAINT `TEMP_FA_FK` FOREIGN KEY (`MATCH_HOME`) REFERENCES `fa` (`FA_ID`);

--
-- Constraints for table `ticketmatch`
--
ALTER TABLE `ticketmatch`
  ADD CONSTRAINT `fk_approval_ticketmatch` FOREIGN KEY (`APPROVAL_ID`) REFERENCES `approval` (`APPROVAL_ID`),
  ADD CONSTRAINT `ticketmatch_ibfk_1` FOREIGN KEY (`TEMP_ID`) REFERENCES `temp_ticket` (`TEMP_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
