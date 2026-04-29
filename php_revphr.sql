-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2020 at 12:03 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_revphr`
--
CREATE DATABASE IF NOT EXISTS `php_revphr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `php_revphr`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `userid` varchar(100) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`userid`, `pwd`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `docrequest`
--

CREATE TABLE IF NOT EXISTS `docrequest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorid` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `accstatus` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`doctorid`,`userid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `docrequest`
--

INSERT INTO `docrequest` (`id`, `doctorid`, `userid`, `accstatus`) VALUES
(1, 'ganesh@gmail.com', 'ram@gmail.com', 'accept');

-- --------------------------------------------------------

--
-- Table structure for table `newdoctor`
--

CREATE TABLE IF NOT EXISTS `newdoctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `addr` varchar(1000) NOT NULL,
  `city` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `qual` varchar(200) NOT NULL,
  `special` varchar(100) NOT NULL,
  `certno` varchar(50) NOT NULL,
  `expr` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `accept` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `newdoctor`
--

INSERT INTO `newdoctor` (`id`, `name`, `gender`, `addr`, `city`, `mobile`, `userid`, `pwd`, `qual`, `special`, `certno`, `expr`, `dob`, `accept`) VALUES
(3, 'Ganesh', 'Male', '343,KK Nagar, I Street,', 'Madurai', '9875055958', 'ganesh@gmail.com', 'ganesh', 'MS', 'Ortho', 'MS8943483', '10', '1960-09-15', 'pending'),
(4, 'Hari', 'Male', '343,KK Nagar', 'Madurai', '9805495859', 'hari@gmail.com', 'hari', 'MBBS', 'General', 'MB4543943', '5', '1979-11-05', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `newpatient`
--

CREATE TABLE IF NOT EXISTS `newpatient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `addr` varchar(1000) NOT NULL,
  `city` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `dob` varchar(200) NOT NULL,
  `bgroup` varchar(200) NOT NULL,
  `skey` varchar(100) NOT NULL,
  `doctorid` varchar(200) NOT NULL,
  `accept` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `newpatient`
--

INSERT INTO `newpatient` (`id`, `name`, `gender`, `addr`, `city`, `mobile`, `userid`, `pwd`, `dob`, `bgroup`, `skey`, `doctorid`, `accept`) VALUES
(4, 'Henry', 'Male', '343,South Street,', 'Madurai', '9489494494', 'henry@gmail.com', 'henry', '1970-05-01', 'O+ve', '', 'ganesh@gmail.com', 'pending'),
(1, 'PgF2U2qiwl36Gzg=', 'RAGw3Wqiwl2lqSQw', 'SQFiZGqiwl3SKbMC/rTPq3xNdK+O84ElsR+gQ1s=', 'UQEs+mqiwl1hufnqUPNl', 'VwEuTWqiwl3pp1cvJXiMVyvg', 'ram@gmail.com', 'XQEIQWqiwl3379U=', 'YgHagGqiwl1dmZtZPVzWCjF+', 'aAFEqWqiwl1wiuqq', 'GAGUjGqiwl18RIrr', 'ganesh@gmail.com', 'accept'),
(3, '4gGMEIr+w105mtXqwLEg', '6AEOFIr+w11QxSwa', '7QFoLor+w10/w3qjxruSNsu3bfI7+ncLfw==', '9QG60or+w12QHkwvfFwc', '+wGkxYr+w10o/rwPipjNjn1Q', 'shankar@gmail.com', 'DAKyfIr+w13fyhJv66uH', 'AAJGf4r+w12JwAh4WBLQeFlb', 'BwJA5Yr+w12UJJKeFQ==', 'JwLSkXf+w119koxx', 'ganesh@gmail.com', 'accept'),
(2, 'Sundar', 'Male', '343,KK Nagar, Main Street,', 'Madurai', '8004949484', 'sundar@gmail.com', 'abc', '1975-11-04', 'B-ve', '', 'ganesh@gmail.com', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `pdisease`
--

CREATE TABLE IF NOT EXISTS `pdisease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorid` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `dt` varchar(200) NOT NULL,
  `disease` varchar(1000) NOT NULL,
  `sugar` varchar(200) NOT NULL,
  `bp` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pdisease`
--

INSERT INTO `pdisease` (`id`, `doctorid`, `userid`, `dt`, `disease`, `sugar`, `bp`) VALUES
(2, 'ganesh@gmail.com', 'ram@gmail.com', '3wIiXcr8w11CAv0aktgK9/eV', '5QLsY8r8w11hlwnzBQtB9HWDrw==', '6gLu08r8w11QnpA=', '8QLIIMr8w11LFB33pQ7L'),
(3, 'ganesh@gmail.com', 'ram@gmail.com', 'c/46wpzwXF52q0vY/FSq53ni', 'eP4kv5zwXF6kl2382FOP18/cpw==', 'fv7GupzwXF5AKJK6P7c=', 'hf7AOpzwXF49TPkVBgc=');

-- --------------------------------------------------------

--
-- Table structure for table `prescrip`
--

CREATE TABLE IF NOT EXISTS `prescrip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorid` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `dt` varchar(100) NOT NULL,
  `prescription` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prescrip`
--

INSERT INTO `prescrip` (`id`, `doctorid`, `userid`, `dt`, `prescription`) VALUES
(1, 'ganesh@gmail.com', 'ram@gmail.com', '1QF48tH9w12/Vnwf6YN1Upqh', '3wGKLdH9w13SzsBILLYWFktQVLtllF5H2soOxPw='),
(2, 'ganesh@gmail.com', 'ram@gmail.com', 'tPwy5MPwXF6Co2L6EG3MkEvZ', 'ufy8xcPwXF4rbg1841B7J2P+HA==');

-- --------------------------------------------------------

--
-- Table structure for table `scan`
--

CREATE TABLE IF NOT EXISTS `scan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorid` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `dt` varchar(100) NOT NULL,
  `fname` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `scan`
--

INSERT INTO `scan` (`id`, `doctorid`, `userid`, `dt`, `fname`) VALUES
(3, 'ganesh@gmail.com', 'ram@gmail.com', 'wfzo/ZHxXF6v9oMU8TjSXfJ5', 'x/w6LJHxXF6/RYtkqUQUAKedT0vFObNALQ/WmaYeQUngzjLWyadUttN/lkw='),
(4, 'ganesh@gmail.com', 'ram@gmail.com', 'bP2gjl/zXF6FgxPrdGzhicuD', 'cv2S2l/zXF7lATSWzb2/LVQ8hDHaRXjvZawf5JXXToMvLiKxhqko4w==');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
