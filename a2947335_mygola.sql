
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2015 at 12:42 AM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a2947335_mygola`
--

-- --------------------------------------------------------
CREATE DATABASE a2947335_mygola;
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vUsername` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `vPassword` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `eStatus` enum('Active','Inactive') COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` VALUES(1, 'admin', 'admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `hotel_name` varchar(255) NOT NULL,
  `points` text NOT NULL,
  `prize` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `status` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` VALUES(1, 'kfc@kfctest.com', '99d23a6fe68a2c269cb5314c6db7e3a6', 'KFC HSR Layout', '', 'Buy one Get One', 12.90813600, 77.64760800, '1');
INSERT INTO `merchant` VALUES(2, 'dominos@dominostest.com', 'admin', 'Dominos HSR Layout', '', '', 12.92341100, 77.64709700, '1');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `text_msg` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `points`
--

INSERT INTO `points` VALUES(1, 1, 12.91180142, 77.64973909, 'p1');
INSERT INTO `points` VALUES(2, 1, 12.91207037, 77.64501940, 'p');
INSERT INTO `points` VALUES(3, 1, 12.91217985, 77.63845336, 'p3');
