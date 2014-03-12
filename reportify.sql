-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2014 at 03:52 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Web'),
(2, 'Internal'),
(3, 'External');

-- --------------------------------------------------------

--
-- Table structure for table `category_tasks`
--

CREATE TABLE IF NOT EXISTS `category_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category_tasks`
--

INSERT INTO `category_tasks` (`id`, `category`, `task`) VALUES
(1, 'Web', 'SQLi'),
(3, 'Internal', 'Scanning'),
(4, 'Web', 'Enumeration');

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
(1, 'OpenWire', 'Nick', 'Knight', '9570 Cobbler Vista Ln', 'Marshall', 'Virginia', '20115');

-- --------------------------------------------------------

--
-- Table structure for table `engagements`
--

CREATE TABLE IF NOT EXISTS `engagements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) DEFAULT NULL,
  `engagement_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `complete` varchar(255) NOT NULL DEFAULT '0',
  `start` date DEFAULT NULL,
  `stop` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `engagements`
--

INSERT INTO `engagements` (`id`, `company`, `engagement_name`, `username`, `complete`, `start`, `stop`) VALUES
(1, 'OpenWire', 'OpenWire-Web', 'logic', '100', '2014-02-09', '2014-02-16'),
(2, 'OpenWire', 'OpenWire-Internal', 'lordsaibat', '0', '2014-02-09', '2014-02-12'),
(3, 'OpenWire', 'OpenWire-External', NULL, '0', '2014-02-09', '2014-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `findings`
--

CREATE TABLE IF NOT EXISTS `findings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `findingname` text,
  `findingid` text NOT NULL,
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
  `engagement` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `findings`
--

INSERT INTO `findings` (`id`, `findingname`, `findingid`, `dreaddamage`, `dreadrepro`, `dreadexpl`, `dreadaffect`, `dreaddiscover`, `remediation_effort`, `summary`, `recommendations`, `custom`, `username`, `engagement`) VALUES
(1, 'Remnant Files Identified', 'remnant_files ', 6, 6, 6, 6, 9, 'LOW', 'During the installation process of applications many files are written to different directories on the disk and are sometimes not correctly removed when the installation is complete. Some of the files left by the installation can be used to gather information about the system, databases, or the functionality of the application. Detection of these files also helps an attacker decipher installed applications. \n\nSome developers copy over the development directories to production. This action could include backup or temporary files that could allow an attacker access to sensitive functions or business processes.\n', 'Remove all unused code from the application/webserver. ', 0, 'logic', NULL),
(2, 'SessionId in URL', 'sessionid_in_url', 8, 3, 3, 3, 3, 'MEDIUM', 'SessionIds are used to keep track of the user, their actions, and permissions in the application. The assessor found that this application generates URLs with sessionIds embedded in the link. Sensitive information within URLs may be logged in various locations, including the user''s browser, the web server, and any forward or reverse proxy servers between the two endpoints. URLs may also be displayed on-screen, bookmarked or emailed around by users. They may be disclosed to third parties via the Referer header when any off-site links are followed. Placing session tokens into the URL increases the risk that an attacker will capture them.', 'The application should use an alternative mechanism for transmitting session tokens, such as HTTP cookies or hidden fields in forms that are submitted using the POST method.', 0, NULL, NULL),
(3, 'Directory Listing', 'directory_listing', 5, 3, 3, 3, 6, 'LOW', 'A directory listing vulnerability exists within this web application.  Although seemingly innocuous and often overlooked, the security implication here was that an attacker discovering a directory listing could use the information discovered to further an attack against an organization.  For example, a malicious user could discover data files, backed-up source code, or applications in development that may have otherwise not been visible to them.\n\nAutomatic directory listing is a web server function that lists all of the files within a requested directory if the normal base file (index.html/home.html/default.htm) is not present. When a user requests the main page of a web site, they normally type in a URL such as: ?http://host/? using the domain name and excluding a specific file. The web server processes this request and searches the document root directory for the default file name and sends this page to the client. If this page is not present, the web server will issue a directory listing and send the output to the client.  Essentially, this is equivalent to issuing an "ls" (Unix) or "dir"(Windows) command within this directory and showing the results in HTML form.\n', 'The following recommendations help ensure that unintentionally access to sensitive information or propriety data stored in publicly accessible directories is prevented.\n? Turn off the Automatic Directory Listing feature in whatever application server package that you utilize.\n? Restrict access to important files or directories only to those who actually need it.\n? Ensure that files containing sensitive information are not left publicly accessible.\n? Don''t follow standard naming procedures for hidden directories. For example, don''t create a hidden directory called "cgi" that contains cgi scripts. Obvious directory names are just that...readily guessed by an attacker.\nRecommendations include restricting access to important directories or files by adopting a "need to know" requirement for both the document and server root, and turning off features such as Automatic Directory Listings that provide information that could be utilized by an attacker when formulating or conducting an attack.\n\nApache\n\nDisable web directory browsing for all directories and subdirectories\nIn your httpd.conf file, disable the "Indexes" option for the appropriate Directory tag by removing it from the Options line.\nIn addition, you should always make sure that proper permissions are set on all files and directories within the web root (including CGI scripts and backup files). Do not copy files in the web root unless you want these files to be available over the web. Periodically go through your web directories and clean out any unused, obsolete, or unknown files and directories.\n\nIIS, PWS, Microsoft-IIS, Internet Information Server, Internet Information Services, Microsoft-PWS\n\nDisable web directory browsing for all directories and subdirectories\nIn the Internet Information Services control panel or MMC, choose the appropriate virtual directory entry and select Properties. Uncheck the ''Allow Directory Browsing'' option.\nIn addition, you should always make sure that proper permissions are set on all files and directories within the web root (including CGI scripts and backup files). Do not copy files in the web root unless you want these files to be available over the web. Periodically go through your web directories and clean out any unused, obsolete, or unknown files and directories.\n\nApache Tomcat, Tomcat, Tomcat Web Server, Apache Coyote, Apache-Coyote\n\nDisable web directory browsing for all directories and subdirectories\nEdit Tomcat''s web.xml file. In the "default" servlet, change the "listings" parameter from "true" to "false". Restart the server.\nIn addition, you should always make sure that proper permissions are set on all files and directories within the web root (including CGI scripts and backup files). Do not copy files in the web root unless you want these files to be available over the web. Periodically go through your web directories and clean out any unused, obsolete, or unknown files and directories.\n', 0, NULL, NULL),
(4, 'Password Field with Autocomplete enabled', 'password_field_with_autocomplete_enabled', 3, 5, 5, 3, 4, 'LOW', 'Most browsers have a facility to remember user credentials that are entered into HTML forms. This function can be configured by the user and also by applications, which employ user credentials. If the function is enabled, then credentials entered by the user are stored on their local computer and retrieved by the browser on future visits to the same application.  An attacker who gains access to the computer, either locally or through some remote compromise, can capture the stored credentials. Further, methods have existed whereby a malicious web site can retrieve the stored credentials for other applications, by exploiting browser vulnerabilities or through application-level cross-domain attacks.', 'To prevent browsers from storing credentials entered into HTML forms, you should include the attribute autocomplete="off" within the FORM tag (to protect all form fields) or within the relevant INPUT tags (to protect specific individual fields). ', 0, NULL, NULL),
(5, 'Cookie Sent without Secure Flag Set', 'cookie_sent_without_secure_flag_set', 3, 4, 5, 3, 4, 'MEDIUM', 'The assessor determined that it might be possible to steal user and session information (via cookies) that were sent during an encrypted session.  During this penetration test, the assessor detected the web application set a cookie without the "secure" attribute, during an encrypted session. Since this cookie does not contain the "secure" attribute, it might also be sent to the site during an unencrypted session. The Request For Comments (RFC) states that if the cookie does not have the secure attribute assigned to it, then the client can pass the cookie to the server over non-secure channels (http).\nAny information such as cookies, session tokens or user credentials that are sent to the server as clear text, may be stolen and used later for identity theft or user impersonation.\n\nThis vulnerability has been made considerably more critical by the recent release of the FireSheep Firefox plug-in (http://codebutler.com/firesheep).  In particular, the release of this tool has made it almost trivial to exploit this vulnerability and hijack a users session for non-encrypted traffic (especially on open wireless networks). Significant evidence exists that there are a number of popular applications that are currently being exploited in the wild including Facebook, LinkedIn, Twitter, and Google.\n', 'It is best business practice that any cookies that are sent (set-cookie) over an SSL connection to explicitly state secure on them.  As such, make sure that sensitive cookies, which are sent over an encrypted connection to the server, are set with the "secure" attribute.\nReferences\n? http://www.owasp.org/index.php/Authentication_Cheat_Sheet#Secure_Flag\n? http://www.owasp.org/index.php/Testing_for_cookies_attributes_%28OWASP-SM-002%29\n? http://cwe.mitre.org/data/definitions/614.html\n? http://capec.mitre.org/data/definitions/102.html\n', 0, NULL, NULL),
(6, 'Frameable Response (Click Jacking)', 'frameable_response_click_jacking', 1, 1, 1, 1, 6, 'LOW', 'It might be possible for a web page controlled by an attacker to load the content of this response within an iframe on the attacker''s page. This may enable a "click jacking" attack, in which the attacker''s page overlays the target application''s interface with a different interface provided by the attacker. By inducing victim users to perform actions such as mouse clicks and keystrokes, the attacker can cause them to unwittingly carry out actions within the application that is being targeted. This technique allows the attacker to circumvent defenses against cross-site request forgery, and may result in unauthorized actions.  Note that this issue is being reported because the application''s response does not set a suitable X-Frame-Options header in order to prevent framing attacks. Some applications attempt to prevent these attacks from within the HTML page itself, using "framebusting" code. However, this type of defense is normally ineffective and can usually be circumvented by a skilled attacker.  ', 'You should review the application functions that are accessible from within the response, and determine whether application users perform any sensitive actions within the application can use them. If so, then a framing attack targeting this response may result in unauthorized actions.  To effectively prevent framing attacks, the application should return a response header with the name X-Frame-Options and the value DENY to prevent framing altogether, or the value SAMEORIGIN to allow framing only by pages on the same origin as the response itself. ', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `date`, `company_id`, `finding_id`, `tasks`, `category_id`, `closed`) VALUES
(1, 1, '2014-01-14', 1, '1,3,5', '', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `screenshots`
--

INSERT INTO `screenshots` (`id`, `task`, `url`, `engagement`) VALUES
(1, 'Enumeration', '0', 'OpenWire-Web');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `engagement`, `username`, `order_num`, `status`) VALUES
(1, 'SQLi', 'OpenWire-Web', 'logic', NULL, 1),
(3, 'Scanning', 'OpenWire-Internal', 'lordsaibat', NULL, 0),
(4, 'Enumeration', 'OpenWire-Web', 'logic', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `template_ID`) VALUES
(1, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `group`) VALUES
(2, 'logic', 'acf1e4bff313da41de3036af477a736988de2295f55a874fc5170f1fd5662190', 'AmKfy5j?w9GucyePnnRxwbp*ww!WLfjL', 2),
(3, 'root', 'd073825d2546cf3cd61e4e8886adefd77d6201ca084ee1507f25238c8483aeb9', '6tQ3vZehDIi%P2u2Y1w7R!eOj8HHqSY?', 2),
(5, 'lordsaibat', '13e5537c96cca6802b6b15498bfa4e9da8f2eb48325c37c1bc025980a28e1ac6', 'R4%JlELEnibZgv7kr#2q&bu2L$%xit5z', 1);

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
