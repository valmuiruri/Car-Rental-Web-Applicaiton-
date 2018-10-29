-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2017 at 03:13 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28
/* 
Store data (insert statements) in csv and have bash file to import data?

*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CarRental`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `vin` varchar(20) NOT NULL,
  `pickup_location` varchar(40) NOT NULL,
  `dropoff_location` varchar(40) DEFAULT NULL,
  `make_model` varchar(25) NOT NULL,
  `year` year(4) NOT NULL,
  `rental_fee` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `available` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`vin`, `pickup_location`, `dropoff_location`, `make_model`, `year`, `rental_fee`, `carID`, `available`) VALUES
('1HGCM82633A0043', '763 Princess St.', '763 Princess St.', 'Toyota FJ-40', 2011, 15, 10000, 1),
('FYUHF05J542790972', '89 Brock St.', '89 Brock St.', 'Range Rover Sport', 2016, 30, 10001, 1),
('UIFJE05J542073846', '300 University Ave.', '300 University Ave.', 'Nissan M45', 2013, 20, 10002, 1),
('HUYJE05J542238976', '300 University Ave.', '300 University Ave.', 'Volvo XC', 2016, 25, 10003, 0),
('YUESH05J542053195', '763 Princess St.', '763 Princess St.', 'Audi S4', 2016, 25, 10004, 0),
('JKWEU05J542053195', '89 Brock St.', '89 Brock St.', 'BMX X3', 2014, 35, 10005, 0),
('JTEHT05J542053195', '300 University Ave.', '300 University Ave.', 'Honda Accord', 2013, 30, 10006, 1),
('KIYJF05J542798673', '763 Princess St.', '763 Princess St.', 'Ford Ranger', 2015, 25, 10007, 0),
('OJRJF05J542762095', '763 Princess St.', '763 Princess St.', 'Toyota Yaris', 2015, 20, 10008, 1),
('RUSHE05J542279827', '89 Brock St.', '89 Brock St.', 'Toyota IS340', 2014, 20, 10009, 0),
('123456789', '300 University Ave.', '300 University Ave.', 'Cat ', 2017, 20, 10010, 0),
('101023424', '89 Brock St.', '89 Brock St.', 'CISC 332', 0000, 100, 10014, 0),
('12345678', '300 University Ave.', '300 University Ave.', 'Toyota', 2014, 20, 10015, 0);

-- --------------------------------------------------------

--
-- Table structure for table `car_history`
--

CREATE TABLE `car_history` (
  `carID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `pickup_odometer` int(11) NOT NULL,
  `dropoff_odometer` int(11) NOT NULL,
  `return_stat` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_history`
--

INSERT INTO `car_history` (`carID`, `memberID`, `pickup_odometer`, `dropoff_odometer`, `return_stat`) VALUES
(10000, 1000000, 72733, 77800, 'normal'),
(10001, 1000003, 72750, 72766, 'normal'),
(10002, 1000002, 26783, 26800, 'normal'),
(10003, 1000007, 46789, 46802, 'damaged'),
(10004, 1000000, 88678, 88680, 'damaged'),
(10005, 1000008, 67830, 67845, 'normal'),
(10006, 1000001, 89080, 89095, 'normal'),
(10007, 1000002, 89064, 89080, 'normal'),
(10008, 1000009, 56342, 56400, 'normal'),
(10009, 1000005, 67832, 67856, 'not running');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `memberID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `date` date NOT NULL,
  `rating` int(5) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `admin_response` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`memberID`, `carID`, `date`, `rating`, `comment`, `admin_response`) VALUES
(1000000, 10000, '2017-02-08', 4, 'Car was a little dirty, overall an enjoyable experience', 'cool!'),
(1000000, 10002, '2017-04-05', 4, 'What a cool system!!! 10/10', 'THATS SICK BRO'),
(1000000, 10004, '2017-02-11', 3, 'Car was damaged, not as advertised. ', 'We''re sorry about your experience!'),
(1000000, 10010, '2017-04-04', 4, '10/10 would use car again', 'hiiiiiii'),
(1000000, 10014, '2017-04-04', 4, '10/10 would use car again', NULL),
(1000001, 10006, '2017-03-13', 4, 'Exactly as advertised. ', NULL),
(1000002, 10002, '2017-02-06', 4, 'Mediocre car, would rent again.', ''),
(1000002, 10007, '2017-03-05', 3, 'Good car, does what it''s supposed to.', NULL),
(1000003, 10001, '2017-02-24', 4, 'Great car! Loved the colour', ''),
(1000005, 10006, '2017-02-28', 1, 'Car broke down a couple times, had to jumpstart. Please get this fixed.', NULL),
(1000007, 10003, '2017-03-25', 2, 'AC does not work, would not recommend', 'AC now fixed! '),
(1000008, 10005, '2017-03-19', 4, 'Great car!', NULL),
(1000009, 10008, '2017-03-02', 3, 'Normal car, nothing special. Gets the job done.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `carID` int(11) NOT NULL,
  `date` date NOT NULL,
  `odo_reading` int(11) NOT NULL,
  `maintenance_type` varchar(9) NOT NULL,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`carID`, `date`, `odo_reading`, `maintenance_type`, `description`) VALUES
(10000, '2017-02-15', 72766, 'scheduled', 'Scheduled cleaning, in good condition'),
(10001, '2017-03-07', 72800, 'Body work', 'Some minor fixes.'),
(10002, '2017-03-15', 2690, 'repair', 'Engine repair'),
(10003, '2017-02-19', 46802, 'repair', 'Repaired tires, acceptable condition'),
(10004, '2017-02-21', 88680, 'Scheduled', 'Scheduled cleaning, in good condition'),
(10005, '2017-03-20', 67845, 'scheduled', 'Scheduled repair, in good condition'),
(10006, '2017-03-26', 95000, 'scheduled', 'Scheduled cleaning, great condition '),
(10007, '2017-03-29', 8999, 'repair', 'repaired tires');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberID` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `driver_license_num` varchar(15) NOT NULL,
  `membership_fee` int(11) NOT NULL DEFAULT '5',
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberID`, `name`, `address`, `phone_number`, `email`, `driver_license_num`, `membership_fee`, `username`, `password`, `admin`) VALUES
(10124, 'CISC 332', '291 university', '5198943014', 'queens@queensu.ca', '101QFDW39W', 50, 'user', '12345', 0),
(1000000, 'Brandon Raya', '78 Johnson St, Kingston, ON', '6789026354', 'brandon@email.com', 'JK123456', 5, 'braya', '1234', 0),
(1000001, 'Franklin Wong', '73 York St, Kingston, ON', '5145678902', 'fwong@mac.com', 'HIJ973892', 5, 'fwong', '1234', 1),
(1000002, 'Gayle Legette', '10 Johnson St, Kingston, ON', '7893427891', 'gayle@mac.com', 'JKK678432', 5, 'glegette', '1234', 0),
(1000003, 'John Smith', '234 Barrie St, Kingston, ON', '6131111111', 'johnsmith@gmail.com', 'CX781938', 5, 'jsmith', '1234', 1),
(1000004, 'Latina Buss', '89 Brock, Kingston, ON', '2378489027', 'latina@gmail.com', 'RTY83902', 5, 'lbuss', '1234', 0),
(1000005, 'Lucio Landon', '655 Princess St, Kingston, ON', '6137890998', 'lucio@email.com', 'CX123456', 5, 'llandon', '1234', 0),
(1000006, 'Mittie Colston', '2 Albert St, Kingston, ON', '6783984781', 'mittie@email.com', 'YUI67873', 5, 'mcolston', '1234', 0),
(1000007, 'Otto Leavens', '89 Frontenac St, Kingston, ON', '7895761234', 'otto@gmail.com', 'YUX78923', 5, 'oleavens', '1234', 0),
(1000008, 'Shanon Mckenna', '65 Victoria St, Kingston, ON', '6475678902', 'vic@gmail.com', 'CJI78943', 5, 'smckenna', '1234', 0),
(1000009, 'Velvet Solorio', '77 Division St, Kington, ON', '6563451234', 'velv@email.com', 'JIK67852', 5, 'vsolorio', '1234', 0),
(9867865, 'Melody Huang', '140 Nelson', '6478014226', 'melody@gmail.com', 'CUH8773', 5, 'mhuang', '1234', 1),
(9867876, 'Cat', '123 Cat st.', '12345678', 'cat@cat.com', 'catcatcat', 5, 'cat', 'cat', 0),
(9867878, 'Tino M', '300 Brock', '123456789', 'tino@swag.com', 'CXS12345678', 5, 'tinom', '1234', 0),
(9867880, 'cisc332', '338 brock street', '2263391853', 'joe@gmail.com', '1011ersers', 5, 'user1', '12345', 0),
(9867881, '101WS35Q3', 'Trial', 'Proof This work', '2263391853', 'trial@gmail.com', 50, 'user', '1234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member_history`
--

CREATE TABLE `member_history` (
  `carID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `pickup_odometer` int(11) DEFAULT NULL,
  `dropoff_odometer` int(11) DEFAULT NULL,
  `return_stat` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_history`
--

INSERT INTO `member_history` (`carID`, `memberID`, `pickup_odometer`, `dropoff_odometer`, `return_stat`) VALUES
(10000, 1000000, 72733, 9867, 'normal'),
(10001, 1000003, 72750, 72766, 'not running'),
(10002, 1000000, 5000, 9867, 'normal'),
(10002, 1000002, 26783, 26800, 'normal'),
(10003, 1000007, 46789, 46802, 'damaged'),
(10003, 9867865, 5000, NULL, NULL),
(10004, 1000000, 88678, 9867, 'normal'),
(10005, 1000008, 67830, 67845, 'normal'),
(10006, 1000000, 5000, 9867, 'normal'),
(10006, 1000001, 89080, 89095, 'normal'),
(10006, 1000005, 89095, 90367, 'normal'),
(10007, 1000002, 89064, 89080, 'normal'),
(10008, 1000000, 5000, 9867, 'normal'),
(10008, 1000009, 56342, 56400, 'normal'),
(10010, 1000000, 5000, 9867, 'normal'),
(10014, 1000000, 5000, 9867, 'normal'),
(100001, 2000, 1234, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `address` varchar(20) NOT NULL,
  `spots_avaliable` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`address`, `spots_avaliable`) VALUES
('300 University Ave.', 31),
('763 Princess St.', 24),
('89 Brock St.', 14);

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `memberID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `driver_license` varchar(15) NOT NULL,
  `membership_fee` int(11) NOT NULL,
  `pickup_location` varchar(40) NOT NULL,
  `dropoff_location` varchar(40) NOT NULL,
  `make_model` varchar(20) NOT NULL,
  `year` year(4) NOT NULL,
  `rental_fee` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`memberID`, `carID`, `name`, `address`, `phone_number`, `email`, `driver_license`, `membership_fee`, `pickup_location`, `dropoff_location`, `make_model`, `year`, `rental_fee`, `comment`) VALUES
(1000001, 7890993, 'Franklin Wong', '73 York St, Kingston, ON''', '5145678902', 'fwong@mac.com', 'HIJ973892', 50, '300 University Ave.', '300 University Ave.', 'Honda Accord', 2013, 70, '''Car was damaged, not as advertised. '),
(1000003, 1234567, 'John Smith', '234 Barrie St, Kingston, ON', '6131111111', '''johnsmith@email.com', 'CX781938', 50, '763 Princess St.', '''763 Princess St.', 'Toyota FJ-40', 1982, 35, '''Car was a little dirty, overall an enjoyable experience');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `carID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `reservation_num` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `access_code` varchar(20) NOT NULL,
  `length_of_reservation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`carID`, `memberID`, `reservation_num`, `date`, `access_code`, `length_of_reservation`) VALUES
(10000, 1000000, '12345678', '2017-02-08', 'XY182JW83', 2),
(10001, 1000003, '12345680', '2017-02-24', 'XH7862394', 5),
(10002, 1000002, '23764932', '2017-02-06', 'JKI2384761', 3),
(10003, 1000007, '63728374', '2017-03-25', 'UIO897340', 7),
(10004, 1000000, '12345679', '2017-02-11', 'KSI3874HI8', 1),
(10005, 1000008, '62783948', '2017-03-19', 'HUI9878921', 17),
(10006, 1000001, 'FRT87123', '2017-03-13', 'LOI9721399', 1),
(10006, 1000005, '23984782', '2017-02-28', 'YUI239847', 2),
(10007, 1000002, '12768327', '2017-03-05', 'JIK8761238', 3),
(10008, 1000009, '89087782', '2017-03-02', 'RTY871236', 9);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_cars_by_location`
--
CREATE TABLE `view_cars_by_location` (
`make_model` varchar(25)
,`year` year(4)
,`rental_fee` int(11)
,`pick_up_from` varchar(40)
);

-- --------------------------------------------------------

--
-- Structure for view `view_cars_by_location`
--
DROP TABLE IF EXISTS `view_cars_by_location`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `CarRental`.`view_cars_by_location`  AS  select `CarRental`.`car`.`make_model` AS `make_model`,`CarRental`.`car`.`year` AS `year`,`CarRental`.`car`.`rental_fee` AS `rental_fee`,`CarRental`.`car`.`dropoff_location` AS `pick_up_from` from `CarRental`.`car` order by `CarRental`.`car`.`dropoff_location` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`carID`);

--
-- Indexes for table `car_history`
--
ALTER TABLE `car_history`
  ADD PRIMARY KEY (`carID`,`memberID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`memberID`,`carID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`carID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `member_history`
--
ALTER TABLE `member_history`
  ADD PRIMARY KEY (`carID`,`memberID`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`address`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`memberID`,`carID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`carID`,`memberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `carID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10016;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `memberID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9867882;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
