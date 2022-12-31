-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 26, 2022 at 06:38 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testrequest`
--
CREATE DATABASE IF NOT EXISTS `testrequest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `testrequest`;

-- --------------------------------------------------------

--
-- Table structure for table `testapp`
--

DROP TABLE IF EXISTS `testapp`;
CREATE TABLE IF NOT EXISTS `testapp` (
  `idApp` int(11) NOT NULL AUTO_INCREMENT,
  `appName` varchar(200) NOT NULL,
  `appPlaceholder` varchar(200) NOT NULL,
  `appScenarioPath` varchar(1000) NOT NULL,
  `appSLA` int(11) NOT NULL,
  `appStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`idApp`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testapp`
--

INSERT INTO `testapp` (`idApp`, `appName`, `appPlaceholder`, `appScenarioPath`, `appSLA`, `appStatus`) VALUES
(1, 'Windows app', 'Ex: Open Broadcast Software', 'assets/testcases/Win10 POS template.xlsx', 5, 1),
(2, 'macOS app', 'Ex: Safari', 'assets/testcases/Server 2016 Distributed - template.xlsx', 10, 1),
(3, 'Linux app', 'Ex: LibreOffice', 'assets/testcases/Provisioning Tool - template.xlsx', 5, 1),
(4, 'Android app', 'Ex: Sync for Reddit', 'assets/testcases/gum.xlsx', 3, 1),
(5, 'iOS app', 'Ex: app from AppStore', 'assets/testcases/USERFUL - template.xlsx', 5, 1),
(6, 'Hardware', 'Ex: Lenovo Thinkpad T480', 'assets/testcases/makeusb.xlsx', 5, 1),
(7, 'Patch', 'Ex: ...', 'assets/testcases/iPXE - template.xlsx', 5, 1),
(8, 'Security Update', 'Ex: ...', 'assets/testcases/QFE patch Win10 - template', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testcomments`
--

DROP TABLE IF EXISTS `testcomments`;
CREATE TABLE IF NOT EXISTS `testcomments` (
  `idComm` int(11) NOT NULL AUTO_INCREMENT,
  `idRequest` int(11) NOT NULL,
  `comment` varchar(400) NOT NULL,
  `dateTime` datetime NOT NULL,
  `user` varchar(200) NOT NULL,
  PRIMARY KEY (`idComm`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testcomments`
--

INSERT INTO `testcomments` (`idComm`, `idRequest`, `comment`, `dateTime`, `user`) VALUES
(1, 5, 'dasdasdas', '2022-08-26 12:00:43', 'catalin.pirvu');

-- --------------------------------------------------------

--
-- Table structure for table `testenv`
--

DROP TABLE IF EXISTS `testenv`;
CREATE TABLE IF NOT EXISTS `testenv` (
  `idEnv` int(11) NOT NULL AUTO_INCREMENT,
  `envAppName` varchar(200) NOT NULL,
  `envAppType` varchar(200) NOT NULL,
  `envAppVersion` varchar(200) NOT NULL,
  `envIsDefault` int(11) NOT NULL,
  `envIsStandard` int(11) NOT NULL,
  `envStatus` int(11) NOT NULL,
  PRIMARY KEY (`idEnv`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testenv`
--

INSERT INTO `testenv` (`idEnv`, `envAppName`, `envAppType`, `envAppVersion`, `envIsDefault`, `envIsStandard`, `envStatus`) VALUES
(1, 'Windows ', 'Windows', ' 11', 0, 0, 1),
(2, 'Windows', 'Windows', '10', 0, 1, 1),
(3, 'Big Sur', 'macOS', '11', 0, 0, 1),
(4, 'Monterey', 'macOS', '12', 1, 1, 1),
(5, 'Android', 'applications', '12', 0, 0, 1),
(6, 'Android', 'applications', '13', 1, 0, 1),
(7, 'iOS', 'applications', '15', 1, 1, 1),
(8, 'iOS', 'applications', '16', 0, 0, 1),
(9, 'Bootloader unlocked?', 'applications', 'No', 1, 1, 1),
(10, 'Bootloader unlocked?', 'applications', 'Yes', 0, 0, 1),
(11, 'Is jailbroken?', 'applications', 'No', 1, 1, 1),
(12, 'Is jailbroken?', 'applications', 'Yes', 0, 0, 1),
(14, 'placeholder', 'applications', 'random version', 0, 0, 0),
(15, 'Ubuntu', 'Linux', '22.04.1 ', 1, 1, 1),
(16, 'CentOS', 'Linux', '7-2009', 1, 1, 1),
(18, 'Catalina', 'macOS', '10.15', 0, 0, 1),
(19, 'Windows', 'Windows', '7', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testhardware`
--

DROP TABLE IF EXISTS `testhardware`;
CREATE TABLE IF NOT EXISTS `testhardware` (
  `idHW` int(11) NOT NULL AUTO_INCREMENT,
  `hardwareMade` varchar(200) NOT NULL,
  `hardwareModel` varchar(200) NOT NULL,
  `hardwareType` varchar(10) NOT NULL,
  `isDefault` int(11) NOT NULL,
  `isAvailable` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `hwStatus` int(11) NOT NULL,
  PRIMARY KEY (`idHW`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testhardware`
--

INSERT INTO `testhardware` (`idHW`, `hardwareMade`, `hardwareModel`, `hardwareType`, `isDefault`, `isAvailable`, `quantity`, `hwStatus`) VALUES
(1, 'Dell', 'R330', 'Server', 0, 0, 2, 1),
(2, 'Dell', 'R340', 'Server', 0, 0, 0, 1),
(3, 'Lenovo', 'SR250', 'Server', 0, 1, 1, 1),
(4, 'Lenovo', 'ST250', 'Server', 0, 1, 1, 0),
(5, 'Acer', 'Nitro 50', 'Desktop', 0, 0, 2, 1),
(6, 'Dell', 'Inspiron 3891', 'Desktop', 0, 0, 1, 1),
(8, 'MYRIA', 'Digital 33', 'Desktop', 0, 1, 3, 1),
(10, 'Lenovo', 'IdeaPad 3', 'Portable', 0, 1, 3, 1),
(11, 'Huawei', 'MateBook D15', 'Portable', 0, 1, 3, 1),
(12, 'Apple', 'iPad 3', 'Portable', 0, 1, 1, 1),
(16, 'Huawei ', 'P30 Pro', 'Smartphone', 0, 1, 3, 1),
(17, 'Raspberry ', 'Pi 3', 'IoT', 0, 1, 2, 1),
(18, 'Arduino ', 'Uno 3', 'IoT', 0, 1, 1, 1),
(19, 'Apple', 'iPhone 10', 'Smartphone', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testrequest`
--

DROP TABLE IF EXISTS `testrequest`;
CREATE TABLE IF NOT EXISTS `testrequest` (
  `idTest` int(11) NOT NULL AUTO_INCREMENT,
  `testApp` varchar(800) NOT NULL,
  `testEnv` varchar(800) NOT NULL,
  `testHW` varchar(800) NOT NULL,
  `testScenarios` varchar(800) NOT NULL,
  `testRequester` varchar(200) NOT NULL,
  `testRequesterEmail` varchar(200) NOT NULL,
  `testUser` varchar(200) DEFAULT NULL,
  `testDateRequest` datetime NOT NULL,
  `testDueDate` date NOT NULL,
  `testCompletedDate` datetime DEFAULT NULL,
  `testModifiedDate` datetime DEFAULT NULL,
  `testStatus` varchar(100) NOT NULL,
  `testResult` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idTest`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testrequest`
--

INSERT INTO `testrequest` (`idTest`, `testApp`, `testEnv`, `testHW`, `testScenarios`, `testRequester`, `testRequesterEmail`, `testUser`, `testDateRequest`, `testDueDate`, `testCompletedDate`, `testModifiedDate`, `testStatus`, `testResult`) VALUES
(3, 'Windows app,test,test', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'Windows app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', 'tester', '2022-08-22 18:17:34', '2022-08-27', '2022-08-22 18:18:22', '2022-08-22 18:18:22', 'Completed', '[{\"pass\":\"0\",\"fail\":\"0\",\"na\":\"1\",\"testCases\":\"assets/testResult/test.xlsx\"}]'),
(4, 'macOS app,dasdas,dasdas', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'macOS app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', NULL, '2022-08-26 14:34:27', '2022-09-05', NULL, NULL, 'Pending review', NULL),
(5, 'Windows app,dsadas,dasdas', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'Windows app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', 'catalin.pirvu', '2022-08-26 14:40:49', '2022-08-31', NULL, '2022-08-26 15:00:53', 'On Hold', '[{\"pass\":\"0\",\"fail\":\"0\",\"na\":\"1\",\"testCases\":\"assets/testResult/Japan labs.xlsx\"}]'),
(6, 'Windows app,dsaas,dasdas', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'Windows app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', NULL, '2022-08-26 15:00:27', '2022-08-31', NULL, NULL, 'Pending review', NULL),
(7, 'Windows app,tst,sss', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'Windows app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', 'catalin.pirvu', '2022-08-26 20:33:19', '2022-08-31', NULL, '2022-08-26 20:33:46', 'On Hold', '[{\"pass\":\"1\",\"fail\":\"1\",\"na\":\"1\",\"testCases\":\"assets/testResult/Japan labs.xlsx\"}]'),
(8, 'Android app,das,ff', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'Android app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', NULL, '2022-08-26 20:44:02', '2022-08-29', NULL, NULL, 'Pending review', NULL),
(9, 'macOS app,dasdas,dasdas', 'Windows 7,Monterey 12,CentOS 7-2009,Android-13,iOS-15,Bootloader unlocked?-No,Is jailbroken?-No', 'Not selected,Not selected,Not selected,Not selected', 'macOS app-AdditionalScenarios:', 'catalin.pirvu', 'pirvu.catalin15@gmail.com', NULL, '2022-08-26 21:21:30', '2022-09-05', NULL, NULL, 'Pending review', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `rights` int(11) NOT NULL,
  `testApp` varchar(100) NOT NULL,
  `testStatusAll` int(11) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `team` varchar(200) DEFAULT NULL,
  `emailN` varchar(200) NOT NULL,
  `receiveEmail` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `resetToken` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `email`, `name`, `surname`, `rights`, `testApp`, `testStatusAll`, `icon`, `team`, `emailN`, `receiveEmail`, `status`, `resetToken`) VALUES
(1, 'catalin.pirvu', 'Ke.tQZoHF4rjWHeOCnXvJu2Frsm6F5Gb5bbKyTlJpkIho.JD5jqMe', 'pirvu.catalin15@gmail.com', 'Pirvu', 'Catalin', 2, '1,2,3,4,5,6,7,8', 1, 'assets/images/user/avatar-2.jpg', 'Licenta (Administrator)', 'pirvu.catalin15@gmail.com', 1, 1, ''),
(2, 'tester', 'DZoCT8klef0I.dxndNis8u00d23K90ex7Ul61gA7UgMJWOD3HFDf.', 'catalin7331@gmail.com', 'tester', 'tester', 1, '1,2', 0, NULL, 'Licenta (Tester)', 'catalin7331@gmail.com', 1, 1, ''),
(3, 'requester', 'lPM2S9qWdqFTP8o7Q0atZODBGHbl6U88kjN.XfeB9uPi9KmWNkTnu', 'pirvu.catalin155@gmail.com', 'requester', 'requester', 0, '1,2,5', 1, NULL, 'Licenta (Requester)', 'pirvu.catalin155@gmail.com', 1, 1, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
