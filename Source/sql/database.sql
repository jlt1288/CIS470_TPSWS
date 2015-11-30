-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2015 at 05:25 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `tps`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `candidateID` int(11) NOT NULL,
  `staffRequestID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `FName` varchar(32) NOT NULL,
  `LName` int(32) NOT NULL,
  `city` int(32) NOT NULL,
  `state` int(2) NOT NULL,
  `zip` int(5) NOT NULL,
  `experience` varchar(11) NOT NULL,
  `education` varchar(20) NOT NULL,
  `salary` int(10) NOT NULL,
  `picture` varchar(64) NOT NULL,
  `resume` varchar(64) NOT NULL,
  `userID` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `workType` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staffrequest`
--

CREATE TABLE `staffrequest` (
  `staffRequestID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `workType` varchar(16) NOT NULL,
  `experience` int(11) NOT NULL,
  `education` varchar(20) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `distance` int(3) NOT NULL,
  `status` varchar(20) NOT NULL,
  `dateOpened` date NOT NULL,
  `approvalNumber` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `userPassword` varchar(36) NOT NULL,
  `userEmail` varchar(256) NOT NULL,
  `userAccess` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zipcodes`
--

CREATE TABLE `zipcodes` (
  `code` int(5) NOT NULL,
  `state_abb` varchar(2) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `city` varchar(256) NOT NULL,
  `state` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`candidateID`),
  ADD KEY `staffReqCan` (`staffRequestID`),
  ADD KEY `staffIDCan` (`staffID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `USERID` (`userID`);

--
-- Indexes for table `staffrequest`
--
ALTER TABLE `staffrequest`
  ADD PRIMARY KEY (`staffRequestID`),
  ADD KEY `USERIDStR` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `zipcodes`
--
ALTER TABLE `zipcodes`
  ADD PRIMARY KEY (`code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`staffRequestID`) REFERENCES `staffrequest` (`staffRequestID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `candidate_ibfk_2` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `staffrequest`
--
ALTER TABLE `staffrequest`
  ADD CONSTRAINT `staffrequest_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
