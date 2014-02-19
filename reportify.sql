-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2014 at 05:40 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reportify`
--
CREATE DATABASE IF NOT EXISTS `reportify` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `reportify`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'Web'),
(5, 'Internal'),
(6, 'External');

-- --------------------------------------------------------

--
-- Table structure for table `category_tasks`
--

CREATE TABLE IF NOT EXISTS `category_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category_tasks`
--

INSERT INTO `category_tasks` (`id`, `category`, `task`) VALUES
(1, 'Web', 'SQLi'),
(2, 'Web', 'CSRF'),
(3, 'Web', 'XSS'),
(4, 'Internal', 'Scanning'),
(5, 'Internal', 'Enumeration'),
(6, 'External', 'Enumeration');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `POC_First_name` text,
  `POC_Last_name` text,
  `POC_Address` text,
  `POC_City` text,
  `POC_State` text,
  `POC_Zip` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `POC_First_name`, `POC_Last_name`, `POC_Address`, `POC_City`, `POC_State`, `POC_Zip`) VALUES
(1, 'OpenWire', 'Nicholas', 'Knight', '9570 Cobbler Vista Ln', 'Marshall', 'Virginia', '20115');

-- --------------------------------------------------------

--
-- Table structure for table `engagements`
--

CREATE TABLE IF NOT EXISTS `engagements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) DEFAULT NULL,
  `engagement_name` varchar(255) DEFAULT NULL,
  `complete` varchar(255) NOT NULL DEFAULT '0',
  `start` date DEFAULT NULL,
  `stop` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `engagements`
--

INSERT INTO `engagements` (`id`, `company`, `engagement_name`, `complete`, `start`, `stop`) VALUES
(1, 'OpenWire', 'OpenWire-Web', '33', '2014-02-08', '2014-02-15'),
(2, 'OpenWire', 'OpenWire-Internal', '0', '2014-02-12', '2014-02-19'),
(3, 'OpenWire', 'OpenWire-External', '100', '2014-02-24', '2014-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `findings`
--

CREATE TABLE IF NOT EXISTS `findings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement` varchar(255) DEFAULT NULL,
  `taskname` varchar(255) DEFAULT NULL,
  `findingname` text,
  `dreaddamage` int(11) DEFAULT NULL,
  `dreadrepro` int(11) DEFAULT NULL,
  `dreadexpl` int(11) DEFAULT NULL,
  `dreadaffect` int(11) DEFAULT NULL,
  `dreaddiscover` int(11) DEFAULT NULL,
  `remediation_effort` text,
  `summary` text,
  `recommendations` text,
  `custom` tinyint(1) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Peer', '{"peer":1}'),
(2, 'Manager', '{"manager":1}');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `company_id` int(11) NOT NULL,
  `finding_id` text NOT NULL,
  `tasks` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

CREATE TABLE IF NOT EXISTS `screenshots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `engagement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `engagement` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `engagement`, `username`, `order_num`, `status`) VALUES
(1, 'SQLi', 'OpenWire-Web', 'logic', NULL, 1),
(2, 'CSRF', 'OpenWire-Web', 'logic', NULL, 0),
(3, 'XSS', 'OpenWire-Web', 'logic', NULL, 0),
(4, 'Scanning', 'OpenWire-Internal', 'logic', NULL, 0),
(5, 'Enumeration', 'OpenWire-Internal', 'logic', NULL, 0),
(6, 'Enumeration', 'OpenWire-External', 'logic', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `group` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `group`) VALUES
(2, 'logic', 'acf1e4bff313da41de3036af477a736988de2295f55a874fc5170f1fd5662190', 'AmKfy5j?w9GucyePnnRxwbp*ww!WLfjL', 2),
(3, 'root', 'd073825d2546cf3cd61e4e8886adefd77d6201ca084ee1507f25238c8483aeb9', '6tQ3vZehDIi%P2u2Y1w7R!eOj8HHqSY?', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE IF NOT EXISTS `user_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `report_id` varchar(255) DEFAULT NULL,
  `tasks_open` text NOT NULL,
  `task_closed` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
