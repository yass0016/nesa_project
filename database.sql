SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `default_term` int(11) NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

DROP TABLE IF EXISTS `rawScore`;
CREATE TABLE IF NOT EXISTS `rawScore` (
  `raw_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_score` double NOT NULL,
  `fa_score` double NOT NULL,
  `swe_score` double NOT NULL,
  `pi_score` double NOT NULL,
  `sos_score` double NOT NULL,
  `a1_score` double NOT NULL,
  `a2_score` double NOT NULL,
  `design_score` double NOT NULL,
  `TeacherID` int(11) NOT NULL,
  PRIMARY KEY (`raw_id`),
  KEY `TeacherID` (`TeacherID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `test` double NOT NULL,
  `final_test` double NOT NULL,
  `swe` double NOT NULL,
  `pi` double NOT NULL,
  `sos` double NOT NULL,
  `advisor1` double NOT NULL,
  `advisor2` double NOT NULL,
  `design` double NOT NULL,
  `s_id` int(11) NOT NULL,
  PRIMARY KEY (`score_id`),
  KEY `s_id` (`s_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_number` varchar(9) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) DEFAULT NULL,
  `TeacherID` int(11) NOT NULL,
  `TermID` int(11) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `TermID` (`TermID`),
  KEY `TeacherID` (`TeacherID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

DROP TABLE IF EXISTS `terms`;
CREATE TABLE IF NOT EXISTS `terms` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `startm` int(2) NOT NULL,
  `startd` int(2) NOT NULL,
  `starty` int(4) NOT NULL,
  `endm` int(2) NOT NULL,
  `endd` int(2) NOT NULL,
  `endy` int(4) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  PRIMARY KEY (`term_id`),
  KEY `TeacherID` (`TeacherID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
