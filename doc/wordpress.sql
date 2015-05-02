-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: 101.251.196.91    Database: wordpress1
-- ------------------------------------------------------
-- Server version	5.6.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_commentmeta`
--

LOCK TABLES `wp_commentmeta` WRITE;
/*!40000 ALTER TABLE `wp_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_comments`
--

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;
INSERT INTO `wp_comments` VALUES (1,1,'Mr WordPress','','https://wordpress.org/','','2015-04-26 03:17:55','2015-04-26 03:17:55','Hi, this is a comment.\nTo delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.',0,'1','','',0,0);
/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_education`
--

DROP TABLE IF EXISTS `wp_hrm_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_education`
--

LOCK TABLES `wp_hrm_education` WRITE;
/*!40000 ALTER TABLE `wp_hrm_education` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_holiday`
--

DROP TABLE IF EXISTS `wp_hrm_holiday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_holiday` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text,
  `from` timestamp NULL DEFAULT NULL,
  `to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `length` varchar(10) NOT NULL,
  `index_holiday` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_holiday`
--

LOCK TABLES `wp_hrm_holiday` WRITE;
/*!40000 ALTER TABLE `wp_hrm_holiday` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_holiday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_job_category`
--

DROP TABLE IF EXISTS `wp_hrm_job_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `active` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_job_category`
--

LOCK TABLES `wp_hrm_job_category` WRITE;
/*!40000 ALTER TABLE `wp_hrm_job_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_job_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_job_title`
--

DROP TABLE IF EXISTS `wp_hrm_job_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_job_title` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(100) NOT NULL,
  `job_description` varchar(400) DEFAULT NULL,
  `note` varchar(400) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_job_title`
--

LOCK TABLES `wp_hrm_job_title` WRITE;
/*!40000 ALTER TABLE `wp_hrm_job_title` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_job_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_language`
--

DROP TABLE IF EXISTS `wp_hrm_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_language`
--

LOCK TABLES `wp_hrm_language` WRITE;
/*!40000 ALTER TABLE `wp_hrm_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_leave`
--

DROP TABLE IF EXISTS `wp_hrm_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_status` smallint(6) DEFAULT NULL,
  `leave_comments` varchar(256) DEFAULT NULL,
  `leave_type_id` varchar(13) NOT NULL,
  `emp_id` int(7) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_leave`
--

LOCK TABLES `wp_hrm_leave` WRITE;
/*!40000 ALTER TABLE `wp_hrm_leave` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_leave_type`
--

DROP TABLE IF EXISTS `wp_hrm_leave_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_leave_type` (
  `id` bigint(13) NOT NULL AUTO_INCREMENT,
  `leave_type_name` varchar(50) DEFAULT NULL,
  `entitlement` smallint(6) DEFAULT NULL,
  `entitle_from` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entitle_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_leave_type`
--

LOCK TABLES `wp_hrm_leave_type` WRITE;
/*!40000 ALTER TABLE `wp_hrm_leave_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_leave_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_location`
--

DROP TABLE IF EXISTS `wp_hrm_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(110) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(35) DEFAULT NULL,
  `phone` varchar(35) DEFAULT NULL,
  `fax` varchar(35) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_code` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_location`
--

LOCK TABLES `wp_hrm_location` WRITE;
/*!40000 ALTER TABLE `wp_hrm_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_notice`
--

DROP TABLE IF EXISTS `wp_hrm_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_notice`
--

LOCK TABLES `wp_hrm_notice` WRITE;
/*!40000 ALTER TABLE `wp_hrm_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_pay_grade`
--

DROP TABLE IF EXISTS `wp_hrm_pay_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_pay_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_pay_grade`
--

LOCK TABLES `wp_hrm_pay_grade` WRITE;
/*!40000 ALTER TABLE `wp_hrm_pay_grade` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_pay_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_personal_education`
--

DROP TABLE IF EXISTS `wp_hrm_personal_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_personal_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `institute` varchar(100) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `year` timestamp NULL DEFAULT NULL,
  `score` varchar(25) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_number` (`emp_id`),
  KEY `education_id` (`education_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_personal_education`
--

LOCK TABLES `wp_hrm_personal_education` WRITE;
/*!40000 ALTER TABLE `wp_hrm_personal_education` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_personal_education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_personal_language`
--

DROP TABLE IF EXISTS `wp_hrm_personal_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_personal_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(7) NOT NULL,
  `language_id` int(11) NOT NULL,
  `fluency` text NOT NULL,
  `competency` text NOT NULL,
  `comments` varchar(100) DEFAULT NULL,
  KEY `lang_id` (`language_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_personal_language`
--

LOCK TABLES `wp_hrm_personal_language` WRITE;
/*!40000 ALTER TABLE `wp_hrm_personal_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_personal_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_personal_skill`
--

DROP TABLE IF EXISTS `wp_hrm_personal_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_personal_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(7) NOT NULL DEFAULT '0',
  `skill_id` int(11) NOT NULL,
  `years_of_exp` decimal(2,0) DEFAULT NULL,
  `comments` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `emp_number` (`emp_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_personal_skill`
--

LOCK TABLES `wp_hrm_personal_skill` WRITE;
/*!40000 ALTER TABLE `wp_hrm_personal_skill` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_personal_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_salary`
--

DROP TABLE IF EXISTS `wp_hrm_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `pay_grade` varchar(50) NOT NULL,
  `component` varchar(100) NOT NULL,
  `frequency` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `comments` text NOT NULL,
  `direct_deposit` varchar(3) NOT NULL,
  `account_number` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `specify` varchar(200) NOT NULL,
  `routing` int(11) NOT NULL,
  `dipo_amount` int(11) NOT NULL,
  `billing_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_salary`
--

LOCK TABLES `wp_hrm_salary` WRITE;
/*!40000 ALTER TABLE `wp_hrm_salary` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_skill`
--

DROP TABLE IF EXISTS `wp_hrm_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_skill`
--

LOCK TABLES `wp_hrm_skill` WRITE;
/*!40000 ALTER TABLE `wp_hrm_skill` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_user_role`
--

DROP TABLE IF EXISTS `wp_hrm_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_user_role` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_user_role`
--

LOCK TABLES `wp_hrm_user_role` WRITE;
/*!40000 ALTER TABLE `wp_hrm_user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_hrm_work_experience`
--

DROP TABLE IF EXISTS `wp_hrm_work_experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_hrm_work_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_number` varchar(7) NOT NULL DEFAULT '0',
  `eexp_company` varchar(100) DEFAULT NULL,
  `eexp_jobtit` varchar(120) DEFAULT NULL,
  `eexp_from_date` varchar(15) DEFAULT NULL,
  `eexp_to_date` varchar(15) DEFAULT NULL,
  `eexp_comments` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_hrm_work_experience`
--

LOCK TABLES `wp_hrm_work_experience` WRITE;
/*!40000 ALTER TABLE `wp_hrm_work_experience` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_hrm_work_experience` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_lddbusinessdirectory`
--

DROP TABLE IF EXISTS `wp_lddbusinessdirectory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_lddbusinessdirectory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `categories` text NOT NULL,
  `address_street` text NOT NULL,
  `address_city` text NOT NULL,
  `address_state` text,
  `address_zip` char(15) DEFAULT NULL,
  `address_country` text NOT NULL,
  `phone` char(15) NOT NULL,
  `fax` char(15) DEFAULT NULL,
  `email` varchar(55) NOT NULL DEFAULT '',
  `contact` tinytext NOT NULL,
  `url` varchar(55) NOT NULL DEFAULT '',
  `facebook` varchar(256) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `linkedin` varchar(256) DEFAULT NULL,
  `promo` enum('true','false') NOT NULL,
  `promoDescription` text,
  `logo` varchar(256) NOT NULL DEFAULT '',
  `login` text NOT NULL,
  `password` varchar(64) NOT NULL,
  `approved` enum('true','false') NOT NULL,
  `other_info` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_lddbusinessdirectory`
--

LOCK TABLES `wp_lddbusinessdirectory` WRITE;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_lddbusinessdirectory_cats`
--

DROP TABLE IF EXISTS `wp_lddbusinessdirectory_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_lddbusinessdirectory_cats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `count` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_lddbusinessdirectory_cats`
--

LOCK TABLES `wp_lddbusinessdirectory_cats` WRITE;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory_cats` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory_cats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_lddbusinessdirectory_docs`
--

DROP TABLE IF EXISTS `wp_lddbusinessdirectory_docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_lddbusinessdirectory_docs` (
  `doc_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bus_id` bigint(20) NOT NULL,
  `doc_path` varchar(256) NOT NULL,
  `doc_name` tinytext NOT NULL,
  `doc_description` longtext,
  PRIMARY KEY (`doc_id`),
  KEY `bus_id` (`bus_id`),
  CONSTRAINT `wp_lddbusinessdirectory_docs_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `wp_lddbusinessdirectory` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_lddbusinessdirectory_docs`
--

LOCK TABLES `wp_lddbusinessdirectory_docs` WRITE;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory_docs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lddbusinessdirectory_docs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_links`
--

LOCK TABLES `wp_links` WRITE;
/*!40000 ALTER TABLE `wp_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_options`
--

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;
INSERT INTO `wp_options` VALUES (1,'siteurl','http://samples.app.ucai.cn/wordpress','yes'),(2,'home','http://samples.app.ucai.cn/wordpress','yes'),(3,'blogname','亿元俱乐部','yes'),(4,'blogdescription','清华陆向谦创业创新公开课-亿元俱乐部','yes'),(5,'users_can_register','1','yes'),(6,'admin_email','wuxing@ucai.cn','yes'),(7,'start_of_week','1','yes'),(8,'use_balanceTags','0','yes'),(9,'use_smilies','1','yes'),(10,'require_name_email','1','yes'),(11,'comments_notify','1','yes'),(12,'posts_per_rss','10','yes'),(13,'rss_use_excerpt','0','yes'),(14,'mailserver_url','mail.example.com','yes'),(15,'mailserver_login','login@example.com','yes'),(16,'mailserver_pass','password','yes'),(17,'mailserver_port','110','yes'),(18,'default_category','1','yes'),(19,'default_comment_status','open','yes'),(20,'default_ping_status','open','yes'),(21,'default_pingback_flag','1','yes'),(22,'posts_per_page','10','yes'),(23,'date_format','Y年n月j日','yes'),(24,'time_format','ag:i','yes'),(25,'links_updated_date_format','F j, Y g:i a','yes'),(26,'comment_moderation','0','yes'),(27,'moderation_notify','1','yes'),(28,'permalink_structure','/index.php/%year%/%monthnum%/%day%/%postname%/','yes'),(29,'gzipcompression','0','yes'),(30,'hack_file','0','yes'),(31,'blog_charset','UTF-8','yes'),(32,'moderation_keys','','no'),(33,'active_plugins','a:3:{i:0;s:41:\"ldd-directory-lite/ldd-directory-lite.php\";i:1;s:41:\"pronamic-companies/pronamic-companies.php\";i:2;s:20:\"wpjobboard/index.php\";}','yes'),(34,'category_base','','yes'),(35,'ping_sites','http://rpc.pingomatic.com/','yes'),(36,'advanced_edit','0','yes'),(37,'comment_max_links','2','yes'),(38,'gmt_offset','0','yes'),(39,'default_email_category','1','yes'),(40,'recently_edited','a:2:{i:0;s:80:\"/home/wwwroot/ucai_app/samples/wordpress/wp-content/plugins/wpjobboard/index.php\";i:1;s:0:\"\";}','no'),(41,'template','twentyfourteen','yes'),(42,'stylesheet','twentyfourteen','yes'),(43,'comment_whitelist','1','yes'),(44,'blacklist_keys','','no'),(45,'comment_registration','0','yes'),(46,'html_type','text/html','yes'),(47,'use_trackback','0','yes'),(48,'default_role','subscriber','yes'),(49,'db_version','31533','yes'),(50,'uploads_use_yearmonth_folders','1','yes'),(51,'upload_path','','yes'),(52,'blog_public','1','yes'),(53,'default_link_category','2','yes'),(54,'show_on_front','posts','yes'),(55,'tag_base','','yes'),(56,'show_avatars','1','yes'),(57,'avatar_rating','G','yes'),(58,'upload_url_path','','yes'),(59,'thumbnail_size_w','150','yes'),(60,'thumbnail_size_h','150','yes'),(61,'thumbnail_crop','1','yes'),(62,'medium_size_w','300','yes'),(63,'medium_size_h','300','yes'),(64,'avatar_default','mystery','yes'),(65,'large_size_w','1024','yes'),(66,'large_size_h','1024','yes'),(67,'image_default_link_type','file','yes'),(68,'image_default_size','','yes'),(69,'image_default_align','','yes'),(70,'close_comments_for_old_posts','0','yes'),(71,'close_comments_days_old','14','yes'),(72,'thread_comments','1','yes'),(73,'thread_comments_depth','5','yes'),(74,'page_comments','0','yes'),(75,'comments_per_page','50','yes'),(76,'default_comments_page','newest','yes'),(77,'comment_order','asc','yes'),(78,'sticky_posts','a:0:{}','yes'),(79,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(80,'widget_text','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(81,'widget_rss','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(82,'uninstall_plugins','a:0:{}','no'),(83,'timezone_string','','yes'),(84,'page_for_posts','0','yes'),(85,'page_on_front','0','yes'),(86,'default_post_format','0','yes'),(87,'link_manager_enabled','0','yes'),(88,'initial_db_version','31532','yes'),(89,'wp_user_roles','a:6:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:9:\"add_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:12:\"hrm_employee\";a:2:{s:4:\"name\";s:12:\"HRM employee\";s:12:\"capabilities\";a:1:{s:4:\"read\";b:1;}}}','yes'),(90,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(91,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(92,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(93,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(94,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(95,'sidebars_widgets','a:5:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";N;s:9:\"sidebar-3\";N;s:13:\"array_version\";i:3;}','yes'),(98,'cron','a:7:{i:1430479885;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1430493478;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1430508120;a:1:{s:20:\"wp_maybe_auto_update\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1430536701;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1430541353;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1430545487;a:1:{s:18:\"wpjb_event_counter\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}','yes'),(108,'_transient_random_seed','e310fc2797beb664c9391e44211a48a6','yes'),(109,'_site_transient_timeout_browser_494faabc6069826e1f8cce537ed8ad87','1430623102','yes'),(110,'_site_transient_browser_494faabc6069826e1f8cce537ed8ad87','a:9:{s:8:\"platform\";s:9:\"Macintosh\";s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:13:\"40.0.2214.115\";s:10:\"update_url\";s:28:\"http://www.google.com/chrome\";s:7:\"img_src\";s:49:\"http://s.wordpress.org/images/browsers/chrome.png\";s:11:\"img_src_ssl\";s:48:\"https://wordpress.org/images/browsers/chrome.png\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;}','yes'),(115,'recently_activated','a:2:{s:11:\"hrm/hrm.php\";i:1430023005;s:37:\"ldd-business-directory/lddbd_core.php\";i:1430022934;}','yes'),(116,'_transient_timeout_feed_ac0b00fe65abe10e0c5b588f3ed8c7ca','1430061509','no'),(121,'_transient_timeout_feed_d117b5738fbd35bd8c0391cda1f2b5d9','1430061512','no'),(130,'_site_transient_client_key_4cf23','-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCt3AGlyGc8HRiu\nflic487IvFOjaZSSiteeCcsS5trbszNPnNAm9gTHFaJBRgmARAu7og8JzKZEUAK+\nD5RSa5ihB+VRuMvDwh1IEFgoyLgmJtwdkMjScZjrfDtpPKakwWWceSwBXsMUsMXg\n3dCAFKB2Ff8i1viXjSF3ELJWjnUDmATv0nUIN7EL84mev9NsK4aa3HD4QnAuEvmJ\n8t0n1uGpvXsXtvSu5/o34YdGYemSBVer0wbXmaBkMAtgUDYb0P5atTuQPFpsyfbV\nOY2msfMPgb5uYEddaOzD5xe9aCLpc2V6AsQ8c0vQ0caqiM3zucVFNjXWDjdWn93+\nn1jB6L/nAgMBAAECggEAcPy8uV++74s9QhFsRzGpbj0t4dI4su+2ZseYiQUskIEq\nRH/1qoxR2IwPsXnxrMEMGvmb6lNsbpLM5XW8f7/bJjO6bVy6V9MsMmwkzwR64Jh6\njmBMkq8uoUNQXPkEl6f0ADejSJSsFSM4xgWBfetpyLRM5fhtABjA+d8I90WHeDhd\n6Poy3GCUT9Q7IHpQZVIj8XjKfu2d3/Z/YwgxRAIqIA9fSFEDIQiCBCPA3SDkWOSM\nSZDH+LDfjioZql7qZBArk/+jT0cj8ksQvAo47BeioV2DaINJc3iI2tuhA/gV0Uuz\nCkNtKOuQGCniHqPcpx1YR7MrgQ5cj36yOyishMcB4QKBgQDclATWR6rSrh4kRTnk\nzulpDSdHDgPzWNldPcwrcQTPE2bLKPWGcjUIJtgICswYBWmMMG6be5RYQAUGBUND\nJ8cqSBDwcMteWgkoA+LgUg6JlcxV+fFhI9XmMtD7hdnel2zo9eWJqmYo3uAMr+Xf\n8xBDZUaO2eVmtb6yWqGmzm7FMQKBgQDJx2AVNO6ZCYG72dFrtE5QxEYnLo33v1aG\nlXKZ3NXe27FQW+hK+Ogugwlh/dnpE4ZDemZsd/WISvaBvlGzTO7DupQLduTL9I/B\nNX6VAnUNr8eXdUCir0BH7J6qytKB1lQwr5GFPq9k6GAawnFhz2MDDjo/1a+eSj8T\nn3QZ3d1wlwKBgBuwjSblGkGWT/xXoFvjyZNBbnPSA5bxyV+WGWI+rs7b7aSFQMUe\n4x9h2O6xhEtjqotJrSjhi47Egpzt3jK49JyPLWkxj6YJgWq/iiSEyIRnBJ6qYK3E\nFN7v9CIO/Hmf4rEf5S+x718kE1YkYqQJXDpJpWDbY5vQJt8212IcOfWRAoGAZo2z\n0vN1NUj0rCI34zLf/wLS2QU7WKjh9EMu3O61sLAePcaImNpLP6CP+0MHJwQqYE9s\nkUKjA2N+SFEPuz6lt8szhWQnQ1YIXl2u+VMnZQ5rNhp9AHJsDGJB/nJZbW4emiQR\npRRIFtRYTCF5eQnru9jWWC1mNeBskK+hVahC7P8CgYEAqiNYnUi3yyYlYked6d/Q\ndpP58VbyO+pk99OnLHKx4lYtP95AhRdQdoMQ4TGS4mHTciuW5LPMxckUKndaDngF\nTCsOEBfO78+VBQ2pgy/Iu3HrdWEQsK7htQXHNlx1InivmR95d1vQ5Ni2kLFssSBF\n9iBawnDDpMYFPTbhpueWY/E=\n-----END PRIVATE KEY-----\n','yes'),(131,'_site_transient_client_properties_4cf23','{\"data\":\"Dq4P2w2QveIWr5Mtn6RPehe9Sp\\/lnx9dIqoXhN8GtL\\/zk3ZzkCsb3rV8kq\\/R8c7FjLHdxd4JcljWXaVvh1+hQAAXt9hG8yQYmipM\\/bRVtEJxvvFd2vAwX7DXMPi31ALFdjgSV4lXnAAaUTGlo0jEwco2mcH3vGnvgSJmcxep+8hEKmmBy6LfFbC3NfZ26qCwRakWA3e+iiZ0dFOqjPXJ+lnxh13Vx1apUbgVB9MDChlqpuyeFZHHpNSwfOwsRNPFL4l0EjMwDWpvk9rkwvx87LvYg\\/26pQnGpyOXD9y5dhRkm3PTPLF3H9FZLP0\\/TuP+PR2esqrm3tWGflYuiABQU7qnQuSDSAhJzau7sDjdEh\\/TpXA2YgXpocy+oezSdr9a0h90DMqWN2YQq9JlJHDmI0WwIhIGO4ljJI\\/lE4fZLuOR5JRp7y6h2XcLzBWFGs1dOoJDpnkHPTSk2\\/IBPkTtJtrORD10anq2B1ZAuvLuqIFEqKBp42FBUk0tj2nB0VqqWbpGO3cndQyCJWAvZamfHOKAzHnMDyrLHQ+IykyDAbFvkTAdtC7f9SvVtpRfoTiGGpec3t3DOPD0bfr\\/QA6SYO8J4B481PWzP5wIb3Whp2\\/I16zQbAG1OV3I3VkY3qR\\/jJPoc5dwuavfe2VBlcyXE6V671zjjoTrp6CJq\\/fvaUVd2AEK3iAvXSMI5ncuHh\\/AM1yACxbEPHHeEnaH\\/0H0D4CZMc8Z8aIGo8RJQSM1HSJnP8PBCe+POHb9IR8vKFhGxXvrD3i2ldIg4R3ZpqElOhCg0nWfIntLLFgWDmRw+5ZFfyZNTnnY9blctMhEHjG9j\\/WVhf9JxqqiM11f9eApnXB6+9JznlJCyDRkjcr6g8UvDUr3v8a6hgoMAP0oPqCtMGVImLz6qANH4GT0TqZnyh\\/B0QiuxMq+f46cJJYx5wPh0YKqi\\/12gdqhU\\/3YvZ3UtCZJkFFTOaJpNINnjmJk5NeI6BIv1BjD3hsvrliwDqtootfg5rgyk2bsBWaBvfVxXrqARdNIOpehaxlqgDGQ8xdhsaf\\/pk1VTQcioBzm+CL7tyaZ0qX\\/1FVQpZt9nW0OkFmAKNLyStbXyBHJP8yjYKxvPpZ1ezrH22fpns7D7bxb3xmz4+vLnDETVeSFu2paNs17DQPM6j\\/0ZOMDpJyyYT1r9HppR8V+2toGLTu1YC9ouMgawurw1RkO5fELG\\/KiRPzvclqVsu9AAw2oUlI6lDK7pSCOy1g28pU4K4H7BMurXa02KEfiXEAsc38fS4V2SGNThFW5wew3u3KvYN\\/EurE\\/f6FAxnBZgMiE9kXRCoPvaEJagdVow78yXDohe0\\/VCVz2bzIaWZD\\/hy\\/HFcQ99anFCkCfzD96F\\/fWhpiBaSlRLP4O35yhiv9MgFKcL5YKfIAbyYVemIyQfHLt6yiLbqM+3WLG34pFAq9xCcccoJscIPyI+XkF9ILN8UY0cKPhT6zxR\\/TzX2bnL9x9s5bJJ1qoxUo71V3CIgdse7A4pfrybkZwa+t3+kEfQXu2J9tgsp8Y+XXbGnHOOyQ1jnPeyu5JOOxZWbozdCteE9VXWVzRLT0Bp\\/d6yKn2FFgfGlRF6RuxDzdzcfa+BON\\/5YLyCM9UtJPqq+hArr0x\\/KLes4Ll7mZ7b32k3ithr698aVgXR84KdS8Ti2GMcEdMqc+8Yid6vdEJLBixrOkriwq3majhdn0RRYU6eooKy0NFVGwBAmRCruxqgnphN7e680OghU6edTOaPzjeRfYDeDxWUxtSed8xte05RFVCoc+6DRag7UTCciYWRikz5e0BYY5MHI1nbBsIN3CsGw6diFseibF+0qT7hC1ZUjvPrVFvp0f8MW+HVRaRF4BWqiBKNs9pFu6X6GQk\\/lawXDeovH5eKM3ZppxUQVPJ7E9Ns7NiD2Darj5zyFX1YZg8g0TQCxayr3qXdWGRZq24kCWxfqMZelK0zDqdho6afr2vpn4tYKKXMjdEy\\/dOVq83R9ZumWI8c5jNBkfhFhrhBElJMMBqH0+Cwh3DwBipoWBkcsoeddK\\/ef9tbcAYmTnYO6nlpnoOY0gqUsDtSdymm+pL9drWJ0SS\\/4JHXxK+Pn1UkVmEXBn79cIL+sZyL9HgcSq0QAGox0Y6WxeUEyS1NXqHdigiAsqAXULpd7h8hNQRPSGHVf4S0IcxQP2inSxow+IMKFt+OiMR4BOLH3xx54SncIIFfLWpGSnMuwr38IDygldu3KtlVqIpdp79Yuia6prVQipOvFcV0g1jXsfbIZ34pPlJn334jZJIwGWLudNTZ8CKhyLTjEWrNpJn9xWSUDyth0gUWoG4CvBBHG7v1FZID1RU2Vx9fftHML0\\/iZgdkjGxchoyoFP3FtzGFpytuKGsfZv0CLs53IBEW25fuXaWTsLQcyMqKIsXDQR0BLALzweyBhvigwGFXU5nKekttfXca\\/Xzv3ShGTB\\/2vyWL8wGpsa7rQPOBHXjGdjyV5dskGyhSP6WWB0ENmMzSYVTM\\/mPkXfRy45U8UiP5YxE5Q5MLkzEfNHfXztrs1LlaRmcnYEkIOgFakKVobMif\\/SZe\\/fhFrRFyBd8R2XjqVqJtb\\/g5zsEwFup3yabMT+Af5vGi2CBtSbl0lL5wEnUX2CAlOkULeujQkJtqL+z9AN0Hqpayy1LjHERTcqaIKphZkKj1KUL3uJqTVDlCIRDOuvsI9n4RfVTUzJX6e7E8TiaaNx4mI8gycyugjkeJJrFjgK2TWj01VS2bhNi2Df5SKfjQPzd2rcyOdQw0mvGOy0J24ERIBfDqvsdz4t3\\/E0KczPZTKhzCZiOEAew+Gny0gRrtF+oUt7bAiqZJJE\\/QTZ1DcmickiWMRWcKaEDZu0Lap1PTpvG2yT+e2PojRrZByJ9TCDZ6EpC9SfVEFS7yWPjHve1ziUYKXUzqTWG9Y\\/tAh2QKU7nFVCvbEmQudYvOa8pAQUr+TLh\\/ANBMkEqj5cw52uv96wkjY7zHlMqvdIbUSraBM479OAxdHEpsTD8ESWmHdBoGnIJIjy3Wh98vWyD09HLbTud6gK+LUF+lrxks8k0SGyQxYhyMPZ7D6EpciCjRz8purykt1FlE82cScDsRxjF2khrUERsw2bkFWSEKkfe8wi5hbw4Gc3XDHqb22\\/SzBWiNVlt\\/ezTwRIZquuGvmWiW9gz8OMKZKscSNc\\/\\/T0bhWWOPW83diwDMJr5UMdHQvZn8XAWDUGmtYmSb1y9o5+WnaCVpwPzukttpcWyELDtsPwtu1VJYM6CPp\\/mSVreARzMzbpxgxmIfP5JAnvrVIO0itynQcsuzAUBhruKMF0nE11tpckyj4uJ67MtexuZlehd0hINEF4ENq3qWajYjkdCn\\/8rJO4iZ5gZ33OUwDTMI0mQwXLoQcxhVPu+aszYExSynsl2gmv2LhSyDdULSrIodtQpL5HwEHdqYHRPhZW\\/lNhwFYESNczaG1EsX\\/sCiXW+IA+HnA5Fm1A\\/YXG4MOgZmIl6pfItblyzHKS\\/WT8eqH3nK5ju3+hjArTOGIvZm2jgf5EM8+cHPgUw51Xk44EwA7o3w393UTB0cDPfYK9oGscmGcQEalRw\\/zzMwnyyyDXPFGkRE0jm1ylMuIoN4xjwiLQWSdb5bvGSO7VNw4CodfXVufCR7\\/pQapbn5rIqj40aIWwI+l8pOoyCqfOjRKHvdAm0ugSPP16DcgbSPqYXMzulJ6bxQj4WMRjEwNrhNrQg0vBs7ok8yC2Mj5NeOGChqI9gUBOiSx1pboYXbrlv1P\\/OGWrZcEtoxPsRzniez81eAoy2ziPNSLMEPjLTJs18pKFA4sKDsgnssHrJWh7hsE3MEfRm84Q55KX1Cz6wmv9FU+E9PQqLByWCXt+ndvDg2qjDwUPzeXgrIsQyVtBGJNfdyRXVvXgJxVW6scJLAgxRA7twfrZUWFcx9uy2v+YpaAgt\\/qhrxMQF15oB\\/op7WCICNQyQEw21PULRclWtkzRjbF1en7glL+\\/wVwFvM5USvrLP9BrVIsE4Vi7ctm25SDQLt3vr9tmT9ErjUkVGr2N4B2wrApnal4y2NBqs0Qi7Eq6OiOXhoC20UHwoTqHewA8eJLgAt3Gg+WjMvUswCKVejMXqYfy8ed5qCnpaoAziwEUJIBMICFuMFNpygQWxhs229oPERciRRlfJb3fSDmdoQOpvuZ8D5lym6WKysVUmELSMPYCt5IpUiRwRwjRQLetvb0eOmex77oEogXd42k5Ne3CHX6NjUBvvJKJrfr\\/I6m+EtArcvLwwsJGXYSzN7bf9ujoqE9wXzXHf83gnSbShFycxaO\\/J8M65AMofMoJA9aTfibQhEkWJCRPfK7ScW9JDiJePTzHeODzorCwrnnMN19C\\/u+VvqqjwIVjSM64UldPO+FuvrPWMFqJnDxfvM7Rbaa4a4CDjblnH8QenSHBjG1cNENjKa92ybbtUrEfkz6pKrVSwJqbPteP2OSYH59TRFfpwgnDQwOO\\/6FamqcTfXjNXE9XeJ5XmHfFMq7f5wYAOJ7VilESQyTGQdi2dHH8lc7htXhOIdV+Sa9jCN35HNgsf2rOzFjx5vhbaDt0XpXLgUUCey29SuU0OAHT0RkmcAmsZuB5Px3lY6mxxsKW7t3nInaO5z5FGVSbInKu7zGZq1e67fLGyNsu6N3QrXqgeIo7WhvfDQJgG+tsmno25cbZzh\\/Py2Pd7VfrnUXUrFoTfyppY4pZVHK+vthduNCLlpG5rOnsHssJ1D3ussul9WMQ8M4a+qVhW4iP\\/lrxMIWI0GvjCzhbbx\\/gg7Ahs4JutG+BLSjkuFXyYKFvs8u9pNXS9Dh7SM0pFN+HTCkcnnuuy52kzoLywMD0vMBAddvFnd+o03KYnnEOZ0edVOVdiegVHPnssP\\/mr+eojBQTAt5f3IhTDCt9d89bHI8U3H6pC2umnVOWnRnoulhhE28X6PBrQ+e++I1pSdCSsJ7InQh\\/WHNe5XQNLxmm\\/EItfLxn3KVAdG5c7CVlB7pypCt5NJW6ZFclQXn8wA+VJ901G7s1vCR3LmYm6ZEQbNU1FzBaqxsdjwmw0FN\\/LAOdUVZn07GKfW4E\\/OagSo8DYd1eqKHxXNXTPsa9KlNHP4VpDJ0h2uBiIaV6ooLwFYqj0TKNcMnYsiCNE2tZGvF\\/\\/3536eWUSOZEwVc7lh5lMX55Pzb\\/FCM4ntefOWdlgEtrOjpTVZaKZhNvCcayHaAjLPHNCQeJvQjz0d6sKyrxv+H5Oui\\/SO4nN2yu1MRbnVqODG9f6QjRSS8TnegRkeLUZG+fGYr2LkDbCkBZhezCT8z5e31sQbuLXiu0gZIyGzypecifqs5pM0S7iAcAABe0ww\\/ZcZLJX3q2JCGt2vIL5zog8B93LRieWQUIycsUqAVymcQXvJ0Rgh\\/llkOo4v4NdCj1bArcLwNnUJj0cxM04ludAE9BN08nT9KyaGstrPqJyagYDztLTD0AlDDXdhWqW5ohlM8kKruK4E5VPUTjomIzpzkGD454xWk8tkgjHXHs7K+IbMYI9xmy2CDDnMtCMm+0ymvI60farCxkUfyv+Ipxph9Ge586j7G5Zr+zY27Xmm1Ov9sIo9rVh2fLzPMiVdp2RH6UgzL5EQKrt+YzWWuEksrXrpst+tTxR8hVw6gyY\\/OOKJOQF0NgoR+1Liln7Uo0TKBVqpYEZQr2I4XUnnhvEkcu6oEBF3n4RDeUpCAzXlxu+6YjHHak2A6zdzXDnmQ7PJUcgFUSqvWtmRU7XBrDBidKKLrEz2x9t2kVK8VBPCz4RexkCExzupRVeq7GZwwo1ow82sOLH1GR1HHGMr7rPlbfnEt76VAXYUOmMGQG2dNdQKBVfKyOyLuMnbFdUZxfuEvw8ViFXxncWipKstID89bMCNe3GU80PdQZzhI\\/rLlz7+v0pcAsoU\\/WT5ViMj353gnWpeofosZe1NML4BGwY6fTk+wRyVZsVlz\\/2kXwJxK482d5KaukSLdiM+NsAOTBSy2U+\\/iMJEbjj2phJbx+GrBo9z15Pnci7iIYEGQRxfTf46tjLtBOfRp\\/qB\\/udMwCGr1bVm7KzylN6Gaf8nq2XwCIy2KjQSO1NqYXDJ+FdLSydxgkYcA0fCdfT6oUHO8aEKJbHujCVi4x05b+zU8+dsfr8tPw53yJFoPnMzVVV2wWJy4WHmXoTITopgN16UplX4K+NKA5cGOcEwGdDiEXxHCtCBR6TwfeJ\\/6LtIOMDD2H\\/nAM7+IewzCUADT8Ztmnl10P9Ii0r+q2I722PNAEk5PX\\/sbT3VRBP4dE3wo+CWGehHMmRg65afoyF+o2k4gL7\\/tmjYAeiIs2FP0tMSoAdrLknriKqlb8yYIsiRg2m4LNlorZnYlr+I9ZKgSEbFlYaZ17MFHnHh3ear116XEwZ\\/EnM+AeUv2sKVBYzz5bEjklHGWqzhMnSOPHdx3moJcYCCgzaXqPk6mQel24lcEBo0G2FdgJ8h9oXJ+mOlWyKrAigT\\/a7UvvNHlqzA3HLg2GsD65dPZsMVO8lblT7BsgFHBH+VbSld\\/d6q1PgXcA95IXX2SeIW2FULmBPEDjv7jhQ2XLanyOCCGIPIPmYBV7nef6i\\/AqnAbh2xgNk56hsFCLN\\/8UY5uyOeAqGrEba5gxq8UOUgHpnKctqYlv25sQznaNIVHF9aKF9QA\\/iIoQVonVbsnnkg3ok0WFFx77cXho5z7ZjpSvpNpKSpM5zfDy5iFpg4c4b5P2u5Oick9xdpM30nm12TBFPVLSiSM87wE8CmE06SCYVKRlLY+odiZZHiwnmMwb\\/GIr5jMePvCubQ0k8iMa+qtePVwbmdKh+uxYEFBVc5fh7U0Mm6dU6Xi\\/H6YpsjS\\/LEpEs8LtdtzP3PMdeWRdGP3X69EW19cmBdjjkxgtTPu0Uq0ROCpeWYRw+nARpISPkvNRjZi14DGxkeorZYbCW0Ord3WTm3kgAo9WleN5NSg8BtwOzkcwGv2x1Maxx2PtgcYm8mEyPJ7wypPiN1pWT0G6AQ18UcNoczFE5\\/XEcj381s0AzZ1Q9WLN0TY705NyErPSLkQjGDJ4CG0dHcvyp03sK+PuPsau+5nXhGepRYzYqnClyIurc4awBq5ji5TXscya3LtZZZnlG0RDq2WDCxZFzbx4QnN0u7R2yLfOS99\\/SRMCOS9ZqIt9F8BaZOqPS75xf4pvdrpTw2iheDavQrwdXsrX4Wn28nZtUnaQZkHJ24VJTSMFzp\\/Ny9yFPO6w1wfR5ztkPYXskk6KikdYKPLVol+S9QDnjRLWLBm+m0w\\/QPCf0nYZVWsD4mpnMU9YgwVaE9VOYJ4z0gs9AHuHbUIcEmqV4gyiXdupzk0uB\\/Gougc5\\/kLGKEo14uGQKX\\/+olb885FINZGSeMRlz5mgvzp1LIW9lQ6n2GYj7rvupMygbRsdecQ8p7FV6wNtoxevf3eCBR7ZQUyHwAsjDAz7ICiJsMM6CfcpAiN7QQroUaHBfqSQDcB4bn+dCHSCk2jT\\/dpB9wPZ1hu4Fb\\/kMCpdxQt1EtyQBr4QtfLzxsnMpYbFzmpubJSFDaL5ktX7CxM6Jis2jashb7L\\/cxSwSQGw8qfAa+trEn84ET6uqEWe8GIDn5sP8GOw0zRsvf6h\\/2PH+gxd5ltJA3Kmg6zx6nLKlNxOlr+aDpi9S3wdjIFrh84AFJ2pD0Phxl492vmxjEGnJuoFlUvfpNwGxkWI16eNbYKJ8+o3mXttNmVzqnL1jNTWHMFlQ84BZXtAuISWQpVeLHg3XCTtscnjo3Or69WFPGV1FBb\\/1lLqrtov5ycl0iYN2FdbfCPgoupsbMesIeVSFLXMa5EbapYYYATiGa4+TycgYPWEP83q+799FIu+o53dYpercSQvbHwHa\\/rsq+gefO9DuEyEogLZedOCsxQ74mJDxG2Ze16c2JSw4csR5icfSGnWHSVGGkglyWdfKVTZx+yNAL5R0U9zpkFHznijletpJgZUU1iRCdWNllDMczazGCLLfTJ\\/aAQt8gn82JvUlwHmCrAzPFj\\/66nUbppkRwBnXMX\\/rqC0Cmsx7wryD2II438lEUZM2a3KJrJO9awa\\/WLg+uKB\\/an1Iei8gEBc27xWQX1fsauoPkaFLgE1V8Fj\\/aRCojThOYeZwzCd5YSF6r8IXpSQx\\/9I0XXDLGyqZ4x5O0EwddqBhma9CimdPBPbNuduQ6mGp8k078ehe5zY+N3HTC07kHt7oqlLftrpgN5ty6DEZuT9N4iEWeJYlIKhZ9ZAEAFVjcQjtkdqkIEUy7kF2itfFR0oA2uAKaAAg4\\/aRmNbuS1tA4o2pI8gpUj4NxYhTqVPUZvBjxpmpiJr5HqM+5zEQ2keb\\/4gI\\/ciz6AUWPMDt92akcH\\/RdBl2b0rxL04u1RNcp2Xdq+1tYWn8P4DntrYugOVTU0ULhufPx0ev8nMXGLK3O6hGbPod6CRV2Uf7cw4iDGz7ciVWvgIUJmhMRe73g7zTXu5omv60bOUBx+qJ\\/1oLXNBRhTI3dtG\\/A3Yfp1rdlj23a4Onr9\\/URNiorW1d70XehAEbqmnQkpjq8U4yKWUq1UO8qHBJtgNV8PZkRnpFM8x\\/p7PLd4WMDZin0IHtbRZik0XjZ1v2rtKSP17PbhZDUpYLy7sVl3EKyHgEvwyZD9sv+IYV9jlbe+OYN5mYQySw6Qb13X42CzDlPxp\\/Yk1c2XXd94aXNh9vHFR2S1PPnS4JeBl3d1QPSYQuuxW158ggLCsuEratEwwfSbF\\/xcem73QNnIeL+rOYq4IZgtaSwJjZDXW1F0oAsXyTz5raQpOxY9TAGA8TcDltG4k4bgF8p0FvJPjUuXNtaJ4vtsdWQloxnEvuI4TgKA99xnEYd4soXBUXleJhTMsxbrsacwoVxvwcLZpRO8edQmEdNRIcCNItwfbxMqDi47wsaHYntrnPnpXbokgyZCavviE3qp\\/OlFMkDt6mwtykdP7GIzGVlZeJDujpI\\/G9W5Ow2xVerdB3xBjYe5s2Ur2qrtuGe\\/iKR8AGio44xRqo8DYQQjr9Y1YYwuSiUOQSOOiwJgkgVlCOWi+fh+Y2t7sKFZmfdnKlwCyMvXc1RMUKC345I\\/0KHV014hwNeMFAzu1atM8OrxQIEDNiDx\\/B5QPirKgCnAl3DhtP0SSrrDDRm74TXGdyKv7Vw3lGcgXdymZ00zneIcTzUtE0mHVgoghB0DMzeE9YFfIA3a6p46kML3gWsgwwNNk1k5UFdy7F4OYpfpyC67AzHww\\/CIXTFO0PbELavDNllDkej2oNiBW9qMbtW5WkOYXPA8ihHhqbuvZJJU7eoK5v9DMpZcsSSLwIDX1Tl7S2I9gRYSY5\\/CA1DmJmHwQtJ0FFvYkZA\\/EZ1JNHqxhBS0JRNawZ4HnqEAin1vFCe+m3xWGvC+Zjj\\/tngkvbGTMWUTj+PNjdKA3TND+inm944CqFOtnJfmCgaxWa37T9SnOmOTd\\/Ne4eNKT6DbB+yizbMFYclPCz+KJ1rb6s8fgYoJWJA\\/q434lLe2OZ+JSaWfzcllbtI+rWoDTRVRNik5lin2o3qP5MPx2IVYPNsEdo+8ykUcF2c1R00EZT5jExopWqxQgkP8d77vIH6KNoFr\\/l6rhr4FR3WCn8STy9tyUERldEml1WOW\\/TgVc2UaKaw78KHYEOLG8oqQICIp8XQGnGGGxGbFNc+5dXdjDtAQXc8p1UkQuJNAhSvanH5B5sQDjHoqHuzmTLnWKpqnJEj3Hg8xeOYmbeiGRaxTaFK8c5S8dWEZi9FD1HgmVfrsxfCn06mbJmnsk6hDkepELhsy1B6ksAD1sasFTL9HzgGNyt8evdLyrL+O\\/Q5shI3bHTl2i8cyPKj0iX0N44jbxD\\/njoPB5dtowo8+S83Mz7MkgGfD7ZAKsuDIeObzmIUJlA8dc\\/3UQ3Brcjbkyeib\\/+c5Va9pizd\\/Nji0OMKHlutVdS3WtdGVBMSydSekz9TnzLZlOBuB5n6elLiV8MKBWEuUfN3RVGy\\/iA0pAxhjQG\\/I8Og3jG8721PdkBqwLHj7995HEWQ0biOinaM6VT6XaRrXEIKTq7kSmANLvagLD1YuE4OUWt51GZQi3LDXfDL161qhc1n2f3HRaSikT2EEBo+jMr+gNqheZNKehMrahfZBhbVUdEl9VwPaBfzOOu\\/c4oy+rQLIUxnuNFja6wFHk6apk+sJtqTaRlVlA6HxytTn5x5C\\/UeOHs7jceNgCgduLxPC7IsAC4lpMpHQrKZccgnFjNN2fgxbgeO6Ym+jVhRwqBwcJQ6XikPIrSqfwUtzgCfF5X+ymT1c+\\/qfI0cfHh\\/m0vl\\/3ce7k\\/AOttT7yqlt6kvRn\\/RFg2zfb3koWPIDn9UYH0KPmV0+W9dhael\\/u1r8SSh21dXZZnLkJwT8gzkmJItu6cxWEUMt9ELmWTHXSkyw9kZEIz3oMHFQYZvbUbZhieZmvT8vR8rcDpqNqZ5Fy3tc\\/KTCLNFke\\/ZdxnUYRnhdA12DLL9KSfMTdLnLM0uCY3uLdAG3oy7HLCtTzqEPBG0mzMVSjXkotsbt+2mZ+GEAV5DFOZbFcMB\\/N9Ic1S9wMfBtR5abi+F\\/Qir7QPVMVqZF3LfxzsVlPlfyzNHII4amqEeeZcU2ojXfrf+TldhMsrZwotOLg2kYCVCeVK8w\\/UcaU1j7NCGCvMHqM0Fbyk8RHhQ1KMY2HUTvbBXSGYK83vIVE+ykAO4drGwEekaRue6pDt6Ch8TRkkUz1+dcp\\/67JNrbLLFaorH3rIytzGaEPthcT0JwA2yfjOh\\/Qeqf8t12hyBi+TP8DwY2gRdC9Tg5A7PAGnfl1HPtMn8nFwTGFXJww6uvjEFVtpt\\/86c2PltYG5OBDTnfGTHhu3RBfs\\/y13xWjk+No5\\/ttPiQc4xFuh0\\/3LWsoyZuUemwxQhwRm1Mk5X2bsRNL5rrj3dhto3KPDB6hA6h0g2vmcno2ntSMFM6PEUsv7lz8\\/1AonT+WXrgVjLoTpDpwIGUamrtps1jLEMMzg2YcQIndgZEfqy9o6FfrHF4ihR9aKLIOQpKCkjKw9q0Lm5BRyIhNyk6KFv\\/cQygNEq7iVpIa5aRiWke\\/dCSVn23UR5hSFjM20CHNpuyyhPNHNoDmlOxH0PFahJ470VLc1MySKwGuXjSg2hB5uAul7YxUhIWzE5Af2LxHWnjma++3S2ejaDv76mQ1lResc9U0NYvVwb\\/W8He\\/lxaS9I5sxg\\/vWRRazF33xVZRkvFuEXoqY85DaiiHfr5J9i3WU4JB5XO7FRchxNQQ7Lr6ETkbVYGxzCYX2oTymHX0JnFaUWsiJNshH6+ns3yUNkXYQ7Cl6Eo5+J1p+dAgEmlK9HqDI\\/q1LfG7c4PiMIKVsxtw\\/LFJntNYaU0SyOyLX7r+wO8LUx5h53RMJELTGl1X8Rmwt8R81Vs3H8myKOmDvmQQbNzChTt9cuyVjhXUrR3tPpL2q5POgH8oJco\\/qwEOOqWFJRQut5m5SQ+S9GN7ag8tiPbRWqna7gPZ+2ZSLo8koCgIeHMaIqdmT1qcFSadikIyuyDDv9oXl28Lg1I+rfpHGa2O1bro2iE7PzxpSeLLyibMj0tOY4T2+jzwuB5cG\\/rcKlvvWvSSINeXGozpqUT4cpXP3l4jjKgYOPkk0RswspKd+BiAvqfQyCL\\/Tn3WUABB9xMHjafANnbw8YL3REQb3vBjutucbrbruffAkFXDd45ObVXbR8VekGxAi7bNqLHYADJ50MTIoCwIV99UFeNUsquozhNJ1gELDfvVIzE+nXKkT6ExtT63PwX9u0h8Aj+T9EsSPdQB0x6E6Qiz0UBLwepJyHg9UJStdYkf+RFkVSXasObYTs3wCfmHg1QXIFX75K5wjZfAJKOPUPIKgswb0uMySjutrSe9c1osGrqYOLZV9+AMiztqOIbQEnUFmwCXnNAQ9wp\\/8u8m4jqPPvWRyqRs1g2Pk98tfjuuPW5FFbSujPidTKy0Y1oDU6lLYz7C6GfVcVQDqNDyGfUqkP9MVJ2II9O7QEGaH\\/qKN8oLPlSSaBXpyJGd2qzIQFvfsLnDSZ2pVHl2tu0A941RWge0RTHk1J\\/b0WZ5+k1Xy+KWKoT6IpmgzBrMP1a7G9oN4nPdzViOzxq5VRTVKwARGGM817mTsMpegxHNDCzAtz5tjL9\\/oPXs36almgEwdNEnO8+ejSonk1LFwxn86jtHePjevKzg76Z9NV81fxOvMaOCQAqNVL6C\\/2mYINLms2MWfeOMrQnIZ0E9NkuigeXp6rpd2Q1Hd3MgRQ6prEmtS2kpOQ6zw2KGVIkOXpPhi\\/JZJ8VIIeaBt4KMcrvNoLjIYkdFo8e2Ft2YDyxstlRxlgz9IfPJwsCnBzgLtbUKr+dfmIa+qwKDGdPxbfbUM0w+mfMSXsv2TPj6tpCtZIWxzbgwEr4ICqcJcn1qpjzt\\/1\\/AQSBKxfQuI2wa0P2akxGuCSaST3Fb+Yy14+JZJ6W\\/+CBEyCOQfXe1UNTNOBLtqM9c+RUs+feYxSVp8jxcCtxX4KRBb9DP0cmoWhDCXLyoaPmsgV2oUkZTlNiRyxgC39GSlHgoZdyyChZ7wWc2TIhck7OBx92JaMpTxXTGhZDBegq1bX4cTjMRvKOjatxxqtY2bZbzUpbEPPiuLiVmyAWI6QEMCodFPK6\\/D9mP4\\/zUpzrKV1oT+LWE9NAr0Tu\\/76b6OGX2RyvQTh3vDNC+IDg0zexCxovv7CnzGw6PP2jUcnfN3O7VNTv9vDTLNDFl5jqXVm1LaKXNDHbYJEn+SLJx\\/zZnLj8ogqTWsBxDHR4zHX5x+w6MJ8LbKoCg3LhGua1Y5S5SWjYwtRPD9tmYXTxrA0VMvTW\\/b5t3gFzE90WA9narUKLG3s7A+C8ls4An7AqMr6WJqZ4MV\\/G4YeZCjK4pjrIXtEKNfJ9DRNL\\/Bqg==\",\"key\":\"OlA6a6\\/XYYydWjV1YVTo8kW6P+DsyFV4rAgmgslDJUTvNZrRaq4NJKFt69nYQB8Ti8V2VBttpu7KtLObk8ieFpSFeU+lwHEAroMzYom4pI7ls8hDhENjJnwxi8HQddAsAV6cQpOkx7+W30n9lWsPpqXK42Y+2GdpvKJVSXsFeEDbtrJ9EZRBnr+k2MqfEDxDFwcE+VoqvobPZgcPGKvIt+rA586saXb+xA+5YTh\\/pyJX3FeswN0so54L5VQnQvZ6\\/TOPLhvvc83I3Bc3mRhMdLe02ZIoSGGjZ4raySl2CbTRXfLKhGm7vhG1V4MxHg\\/PQpx2uBr6jBKO3BzBRdRzjQ==\"}','yes'),(132,'wpjb_config','a:10:{s:9:\"link_jobs\";i:5;s:12:\"link_resumes\";i:6;s:23:\"front_show_related_jobs\";i:1;s:10:\"cv_enabled\";i:1;s:14:\"front_template\";s:9:\"twentyten\";s:20:\"api_twitter_username\";s:0:\"\";s:20:\"api_twitter_password\";s:0:\"\";s:7:\"version\";s:5:\"3.5.3\";s:9:\"show_maps\";b:1;s:5:\"count\";a:2:{s:8:\"category\";a:1:{i:1;s:1:\"1\";}s:4:\"type\";a:1:{i:3;s:1:\"1\";}}}','yes'),(134,'_site_transient_client_properties_4cf231','1430019268','yes'),(137,'hrm_general_info','a:2:{s:9:\"field_dif\";a:12:{i:0;s:17:\"organization_name\";i:1;s:6:\"tax_id\";i:2;s:19:\"registration_number\";i:3;s:5:\"phone\";i:4;s:3:\"fax\";i:5;s:15:\"addres_street_1\";i:6;s:16:\"address_street_2\";i:7;s:4:\"city\";i:8;s:14:\"state_province\";i:9;s:3:\"zip\";i:10;s:7:\"country\";i:11;s:4:\"note\";}s:4:\"data\";a:12:{s:17:\"organization_name\";s:6:\"小米\";s:6:\"tax_id\";s:0:\"\";s:19:\"registration_number\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:3:\"fax\";s:0:\"\";s:15:\"addres_street_1\";s:0:\"\";s:16:\"address_street_2\";s:0:\"\";s:4:\"city\";s:0:\"\";s:14:\"state_province\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:7:\"country\";s:0:\"\";s:4:\"note\";s:0:\"\";}}','yes'),(138,'hrm_location_option','a:3:{s:10:\"table_name\";s:12:\"hrm_location\";s:12:\"table_format\";a:9:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%s\";i:6;s:2:\"%s\";i:7;s:2:\"%s\";i:8;s:2:\"%s\";}s:12:\"table_option\";a:9:{s:4:\"name\";s:4:\"name\";s:12:\"country_code\";s:7:\"country\";s:8:\"province\";s:8:\"province\";s:4:\"city\";s:4:\"city\";s:7:\"address\";s:7:\"address\";s:8:\"zip_code\";s:7:\"zipcode\";s:5:\"phone\";s:5:\"phone\";s:3:\"fax\";s:3:\"fax\";s:5:\"notes\";s:5:\"notes\";}}','yes'),(139,'hrm_notice','a:3:{s:10:\"table_name\";s:10:\"hrm_notice\";s:12:\"table_format\";a:4:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%d\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:5:\"title\";s:5:\"title\";s:11:\"description\";s:11:\"description\";s:7:\"user_id\";s:7:\"user_id\";s:4:\"date\";s:4:\"date\";}}','yes'),(140,'hrm_job_title_option','a:3:{s:10:\"table_name\";s:13:\"hrm_job_title\";s:12:\"table_format\";a:3:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";}s:12:\"table_option\";a:3:{s:9:\"job_title\";s:9:\"job_title\";s:15:\"job_description\";s:15:\"job_description\";s:4:\"note\";s:4:\"note\";}}','yes'),(141,'hrm_job_category','a:3:{s:10:\"table_name\";s:16:\"hrm_job_category\";s:12:\"table_format\";a:2:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";}s:12:\"table_option\";a:2:{s:4:\"name\";s:12:\"job_category\";s:6:\"active\";s:6:\"active\";}}','yes'),(142,'hrm_pay_grade','a:3:{s:10:\"table_name\";s:13:\"hrm_pay_grade\";s:12:\"table_format\";a:1:{i:0;s:2:\"%s\";}s:12:\"table_option\";a:1:{s:4:\"name\";s:4:\"name\";}}','yes'),(143,'hrm_qualification_skills','a:3:{s:10:\"table_name\";s:9:\"hrm_skill\";s:12:\"table_format\";a:2:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";}s:12:\"table_option\";a:2:{s:4:\"name\";s:10:\"skill_name\";s:11:\"description\";s:10:\"skill_desc\";}}','yes'),(144,'hrm_qualification_education','a:3:{s:10:\"table_name\";s:13:\"hrm_education\";s:12:\"table_format\";a:1:{i:0;s:2:\"%s\";}s:12:\"table_option\";a:1:{s:4:\"name\";s:14:\"education_name\";}}','yes'),(145,'hrm_language','a:3:{s:10:\"table_name\";s:12:\"hrm_language\";s:12:\"table_format\";a:1:{i:0;s:2:\"%s\";}s:12:\"table_option\";a:1:{s:4:\"name\";s:8:\"language\";}}','yes'),(146,'hrm_leave_type','a:3:{s:10:\"table_name\";s:14:\"hrm_leave_type\";s:12:\"table_format\";a:4:{i:0;s:2:\"%s\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:15:\"leave_type_name\";s:10:\"leave_type\";s:11:\"entitlement\";s:11:\"entitlement\";s:12:\"entitle_from\";s:12:\"entitle_from\";s:10:\"entitle_to\";s:10:\"entitle_to\";}}','yes'),(147,'hrm_work_week','a:1:{s:9:\"field_dif\";a:7:{i:0;s:8:\"saturday\";i:1;s:6:\"sunday\";i:2;s:6:\"monday\";i:3;s:7:\"tuesday\";i:4;s:9:\"wednesday\";i:5;s:8:\"thursday\";i:6;s:6:\"friday\";}}','yes'),(148,'hrm_holiday','a:3:{s:10:\"table_name\";s:11:\"hrm_holiday\";s:12:\"table_format\";a:5:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";}s:12:\"table_option\";a:5:{s:4:\"name\";s:4:\"name\";s:11:\"description\";s:11:\"description\";s:4:\"from\";s:4:\"from\";s:2:\"to\";s:2:\"to\";s:6:\"length\";s:6:\"length\";}}','yes'),(149,'hrm_leave','a:3:{s:10:\"table_name\";s:9:\"hrm_leave\";s:12:\"table_format\";a:6:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%d\";}s:12:\"table_option\";a:6:{s:10:\"start_time\";s:4:\"from\";s:8:\"end_time\";s:2:\"to\";s:14:\"leave_comments\";s:7:\"comment\";s:13:\"leave_type_id\";s:7:\"type_id\";s:6:\"emp_id\";s:6:\"emp_id\";s:12:\"leave_status\";s:12:\"leave_status\";}}','yes'),(150,'hrm_salary','a:3:{s:10:\"table_name\";s:10:\"hrm_salary\";s:12:\"table_format\";a:13:{i:0;s:2:\"%d\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%d\";i:4;s:2:\"%s\";i:5;s:2:\"%d\";i:6;s:2:\"%s\";i:7;s:2:\"%s\";i:8;s:2:\"%s\";i:9;s:2:\"%d\";i:10;s:2:\"%d\";i:11;s:2:\"%d\";i:12;s:2:\"%s\";}s:12:\"table_option\";a:13:{s:6:\"emp_id\";s:6:\"emp_id\";s:9:\"pay_grade\";s:9:\"pay_grade\";s:9:\"component\";s:9:\"component\";s:9:\"frequency\";s:9:\"frequency\";s:8:\"currency\";s:8:\"currency\";s:6:\"amount\";s:6:\"amount\";s:8:\"comments\";s:8:\"comments\";s:14:\"direct_deposit\";s:14:\"direct_deposit\";s:14:\"account_number\";s:14:\"account_number\";s:12:\"account_type\";s:12:\"account_type\";s:7:\"routing\";s:7:\"routing\";s:11:\"dipo_amount\";s:11:\"dipo_amount\";s:12:\"billing_date\";s:12:\"billing_date\";}}','yes'),(151,'hrm_work_experience','a:3:{s:10:\"table_name\";s:19:\"hrm_work_experience\";s:12:\"table_format\";a:6:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%s\";}s:12:\"table_option\";a:6:{s:10:\"emp_number\";s:6:\"emp_id\";s:12:\"eexp_company\";s:12:\"company_name\";s:11:\"eexp_jobtit\";s:9:\"job_title\";s:14:\"eexp_from_date\";s:4:\"form\";s:12:\"eexp_to_date\";s:2:\"to\";s:13:\"eexp_comments\";s:11:\"description\";}}','yes'),(152,'hrm_personal_education','a:3:{s:10:\"table_name\";s:22:\"hrm_personal_education\";s:12:\"table_format\";a:8:{i:0;s:2:\"%d\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%f\";i:6;s:2:\"%s\";i:7;s:2:\"%s\";}s:12:\"table_option\";a:8:{s:6:\"emp_id\";s:6:\"emp_id\";s:12:\"education_id\";s:12:\"education_id\";s:9:\"institute\";s:9:\"institute\";s:5:\"major\";s:5:\"major\";s:4:\"year\";s:4:\"year\";s:5:\"score\";s:5:\"score\";s:10:\"start_date\";s:10:\"start_date\";s:8:\"end_date\";s:8:\"end_date\";}}','yes'),(153,'hrm_personal_skill','a:3:{s:10:\"table_name\";s:18:\"hrm_personal_skill\";s:12:\"table_format\";a:4:{i:0;s:2:\"%d\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:6:\"emp_id\";s:6:\"emp_id\";s:8:\"skill_id\";s:8:\"skill_id\";s:12:\"years_of_exp\";s:12:\"years_of_exp\";s:8:\"comments\";s:8:\"comments\";}}','yes'),(154,'hrm_personal_language','a:3:{s:10:\"table_name\";s:21:\"hrm_personal_language\";s:12:\"table_format\";a:5:{i:0;s:2:\"%d\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";}s:12:\"table_option\";a:5:{s:6:\"emp_id\";s:6:\"emp_id\";s:11:\"language_id\";s:11:\"language_id\";s:7:\"fluency\";s:7:\"fluency\";s:10:\"competency\";s:10:\"competency\";s:8:\"comments\";s:8:\"comments\";}}','yes'),(155,'hrm_personal_info','a:12:{s:7:\"_gender\";s:6:\"gender\";s:15:\"_marital_status\";s:14:\"marital_status\";s:14:\"_national_code\";s:13:\"national_code\";s:9:\"_birthday\";s:8:\"birthday\";s:8:\"_street1\";s:7:\"street1\";s:8:\"_street2\";s:7:\"street2\";s:10:\"_city_code\";s:9:\"city_code\";s:6:\"_state\";s:5:\"state\";s:4:\"_zip\";s:3:\"zip\";s:13:\"_country_code\";s:12:\"country_code\";s:12:\"_work_mobile\";s:11:\"work_mobile\";s:11:\"_work_email\";s:10:\"work_email\";}','yes'),(156,'hrm_personal_job','a:6:{s:10:\"_job_title\";s:9:\"job_title\";s:13:\"_job_category\";s:12:\"job_category\";s:9:\"_location\";s:8:\"location\";s:15:\"_contract_start\";s:14:\"contract_start\";s:13:\"_contract_end\";s:12:\"contract_end\";s:17:\"_contract_details\";s:16:\"contract_details\";}','yes'),(157,'hrm_projects','a:1:{s:12:\"table_option\";a:1:{s:5:\"title\";s:5:\"title\";}}','yes'),(158,'hrm_employee','a:1:{s:12:\"table_option\";a:5:{s:4:\"user\";s:4:\"user\";s:10:\"first_name\";s:10:\"first_name\";s:9:\"last_name\";s:9:\"last_name\";s:6:\"status\";s:6:\"status\";s:6:\"mobile\";s:6:\"mobile\";}}','yes'),(159,'hrm_attendance','a:1:{s:12:\"table_option\";a:1:{s:4:\"date\";s:4:\"date\";}}','yes'),(160,'hrm_attendance_record_both','a:1:{s:12:\"table_option\";a:3:{s:9:\"from_date\";s:9:\"from_date\";s:7:\"to_date\";s:7:\"to_date\";s:7:\"user_id\";s:7:\"user_id\";}}','yes'),(161,'hrm_user_search','a:1:{s:12:\"table_option\";a:1:{s:8:\"employer\";s:8:\"employer\";}}','yes'),(162,'hrm_rating_record','a:1:{s:12:\"table_option\";a:2:{s:9:\"from_date\";s:9:\"from_date\";s:7:\"to_date\";s:7:\"to_date\";}}','yes'),(163,'hrm_admin','1','yes'),(164,'hrm_version','0.6','yes'),(165,'hrm_db_version','0.2','yes'),(174,'widget_calendar','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(175,'widget_nav_menu','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(176,'widget_wpjb-featured-jobs','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(177,'widget_wpjb-widget-alerts','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(178,'widget_wpjb-job-board-menu','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(179,'widget_wpjb-job-categories','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(180,'widget_wpjb-widget-feeds','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(181,'widget_wpjb-job-types','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(182,'widget_pages','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(183,'widget_wpjb-recent-jobs','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(184,'widget_wpjb-recently-viewed','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(185,'widget_wpjb-resumes-menu','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(187,'widget_wpjb-search','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(188,'widget_tag_cloud','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(190,'lddlite_version','0.8.4-beta','yes'),(192,'lddlite_settings','a:4:{s:20:\"directory_front_page\";i:10;s:21:\"directory_submit_page\";i:11;s:21:\"directory_manage_page\";i:12;s:27:\"appearance_display_featured\";s:1:\"1\";}','yes'),(221,'category_children','a:2:{i:1;a:5:{i:0;i:3;i:1;i:4;i:2;i:5;i:3;i:6;i:4;i:7;}i:8;a:8:{i:0;i:9;i:1;i:10;i:2;i:11;i:3;i:12;i:4;i:13;i:5;i:14;i:6;i:15;i:7;i:16;}}','yes'),(222,'pronamic_company_category_children','a:0:{}','yes'),(227,'theme_mods_twentyfifteen','a:1:{s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1430026949;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','yes'),(228,'current_theme','Twenty Fourteen','yes'),(229,'theme_mods_twentyfourteen','a:1:{i:0;b:0;}','yes'),(230,'theme_switched','','yes'),(235,'rewrite_rules','a:135:{s:19:\"index.php/jobs/(.*)\";s:41:\"index.php?page_id=5&job_board=$matches[1]\";s:22:\"index.php/resumes/(.*)\";s:43:\"index.php?page_id=6&job_resumes=$matches[1]\";s:20:\"index.php/listing/?$\";s:38:\"index.php?post_type=directory_listings\";s:22:\"index.php/companies/?$\";s:36:\"index.php?post_type=pronamic_company\";s:52:\"index.php/companies/feed/(feed|rdf|rss|rss2|atom)/?$\";s:53:\"index.php?post_type=pronamic_company&feed=$matches[1]\";s:47:\"index.php/companies/(feed|rdf|rss|rss2|atom)/?$\";s:53:\"index.php?post_type=pronamic_company&feed=$matches[1]\";s:39:\"index.php/companies/page/([0-9]{1,})/?$\";s:54:\"index.php?post_type=pronamic_company&paged=$matches[1]\";s:57:\"index.php/category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:52:\"index.php/category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:45:\"index.php/category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:27:\"index.php/category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:54:\"index.php/tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:49:\"index.php/tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:42:\"index.php/tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:24:\"index.php/tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:55:\"index.php/type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:50:\"index.php/type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:43:\"index.php/type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:25:\"index.php/type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:59:\"index.php/listings/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:55:\"index.php?listing_category=$matches[1]&feed=$matches[2]\";s:54:\"index.php/listings/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:55:\"index.php?listing_category=$matches[1]&feed=$matches[2]\";s:47:\"index.php/listings/([^/]+)/page/?([0-9]{1,})/?$\";s:56:\"index.php?listing_category=$matches[1]&paged=$matches[2]\";s:29:\"index.php/listings/([^/]+)/?$\";s:38:\"index.php?listing_category=$matches[1]\";s:45:\"index.php/listing/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:55:\"index.php/listing/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:75:\"index.php/listing/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"index.php/listing/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"index.php/listing/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:38:\"index.php/listing/([^/]+)/trackback/?$\";s:45:\"index.php?directory_listings=$matches[1]&tb=1\";s:46:\"index.php/listing/([^/]+)/page/?([0-9]{1,})/?$\";s:58:\"index.php?directory_listings=$matches[1]&paged=$matches[2]\";s:53:\"index.php/listing/([^/]+)/comment-page-([0-9]{1,})/?$\";s:58:\"index.php?directory_listings=$matches[1]&cpage=$matches[2]\";s:38:\"index.php/listing/([^/]+)(/[0-9]+)?/?$\";s:57:\"index.php?directory_listings=$matches[1]&page=$matches[2]\";s:34:\"index.php/listing/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:44:\"index.php/listing/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:64:\"index.php/listing/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"index.php/listing/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"index.php/listing/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:47:\"index.php/companies/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"index.php/companies/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"index.php/companies/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"index.php/companies/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"index.php/companies/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:40:\"index.php/companies/([^/]+)/trackback/?$\";s:43:\"index.php?pronamic_company=$matches[1]&tb=1\";s:60:\"index.php/companies/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:55:\"index.php?pronamic_company=$matches[1]&feed=$matches[2]\";s:55:\"index.php/companies/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:55:\"index.php?pronamic_company=$matches[1]&feed=$matches[2]\";s:48:\"index.php/companies/([^/]+)/page/?([0-9]{1,})/?$\";s:56:\"index.php?pronamic_company=$matches[1]&paged=$matches[2]\";s:55:\"index.php/companies/([^/]+)/comment-page-([0-9]{1,})/?$\";s:56:\"index.php?pronamic_company=$matches[1]&cpage=$matches[2]\";s:40:\"index.php/companies/([^/]+)(/[0-9]+)?/?$\";s:55:\"index.php?pronamic_company=$matches[1]&page=$matches[2]\";s:36:\"index.php/companies/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:46:\"index.php/companies/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:66:\"index.php/companies/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"index.php/companies/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"index.php/companies/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:67:\"index.php/company-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?pronamic_company_category=$matches[1]&feed=$matches[2]\";s:62:\"index.php/company-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?pronamic_company_category=$matches[1]&feed=$matches[2]\";s:55:\"index.php/company-category/([^/]+)/page/?([0-9]{1,})/?$\";s:65:\"index.php?pronamic_company_category=$matches[1]&paged=$matches[2]\";s:37:\"index.php/company-category/([^/]+)/?$\";s:47:\"index.php?pronamic_company_category=$matches[1]\";s:68:\"index.php/company-character/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:65:\"index.php?pronamic_company_character=$matches[1]&feed=$matches[2]\";s:63:\"index.php/company-character/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:65:\"index.php?pronamic_company_character=$matches[1]&feed=$matches[2]\";s:56:\"index.php/company-character/([^/]+)/page/?([0-9]{1,})/?$\";s:66:\"index.php?pronamic_company_character=$matches[1]&paged=$matches[2]\";s:38:\"index.php/company-character/([^/]+)/?$\";s:48:\"index.php?pronamic_company_character=$matches[1]\";s:65:\"index.php/company-region/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:62:\"index.php?pronamic_company_region=$matches[1]&feed=$matches[2]\";s:60:\"index.php/company-region/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:62:\"index.php?pronamic_company_region=$matches[1]&feed=$matches[2]\";s:53:\"index.php/company-region/([^/]+)/page/?([0-9]{1,})/?$\";s:63:\"index.php?pronamic_company_region=$matches[1]&paged=$matches[2]\";s:35:\"index.php/company-region/([^/]+)/?$\";s:45:\"index.php?pronamic_company_region=$matches[1]\";s:66:\"index.php/company-keyword/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:63:\"index.php?pronamic_company_keyword=$matches[1]&feed=$matches[2]\";s:61:\"index.php/company-keyword/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:63:\"index.php?pronamic_company_keyword=$matches[1]&feed=$matches[2]\";s:54:\"index.php/company-keyword/([^/]+)/page/?([0-9]{1,})/?$\";s:64:\"index.php?pronamic_company_keyword=$matches[1]&paged=$matches[2]\";s:36:\"index.php/company-keyword/([^/]+)/?$\";s:46:\"index.php?pronamic_company_keyword=$matches[1]\";s:64:\"index.php/company-brand/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:61:\"index.php?pronamic_company_brand=$matches[1]&feed=$matches[2]\";s:59:\"index.php/company-brand/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:61:\"index.php?pronamic_company_brand=$matches[1]&feed=$matches[2]\";s:52:\"index.php/company-brand/([^/]+)/page/?([0-9]{1,})/?$\";s:62:\"index.php?pronamic_company_brand=$matches[1]&paged=$matches[2]\";s:34:\"index.php/company-brand/([^/]+)/?$\";s:44:\"index.php?pronamic_company_brand=$matches[1]\";s:63:\"index.php/company-type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:60:\"index.php?pronamic_company_type=$matches[1]&feed=$matches[2]\";s:58:\"index.php/company-type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:60:\"index.php?pronamic_company_type=$matches[1]&feed=$matches[2]\";s:51:\"index.php/company-type/([^/]+)/page/?([0-9]{1,})/?$\";s:61:\"index.php?pronamic_company_type=$matches[1]&paged=$matches[2]\";s:33:\"index.php/company-type/([^/]+)/?$\";s:43:\"index.php?pronamic_company_type=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:42:\"index.php/feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:37:\"index.php/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:30:\"index.php/page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:51:\"index.php/comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:46:\"index.php/comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:54:\"index.php/search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:49:\"index.php/search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:42:\"index.php/search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:24:\"index.php/search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:57:\"index.php/author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:52:\"index.php/author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:45:\"index.php/author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:27:\"index.php/author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:79:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:74:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:67:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:49:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:66:\"index.php/([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:61:\"index.php/([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:54:\"index.php/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:36:\"index.php/([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:53:\"index.php/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:48:\"index.php/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:41:\"index.php/([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:23:\"index.php/([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:68:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:78:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:98:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:93:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:93:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:67:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:87:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:82:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:75:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:82:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:67:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(/[0-9]+)?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:57:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:67:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:87:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:82:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:82:\"index.php/[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:74:\"index.php/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:61:\"index.php/([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:48:\"index.php/([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:37:\"index.php/.?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:47:\"index.php/.?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:67:\"index.php/.?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"index.php/.?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"index.php/.?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:30:\"index.php/(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:50:\"index.php/(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:45:\"index.php/(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:38:\"index.php/(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:45:\"index.php/(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:30:\"index.php/(.?.+?)(/[0-9]+)?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}','yes'),(244,'listing_category_children','a:0:{}','yes'),(257,'_transient_featured_content_ids','a:0:{}','yes'),(258,'_transient_is_multi_author','0','yes'),(259,'_transient_twentyfourteen_category_count','1','yes'),(262,'WPLANG','zh_CN','yes'),(297,'db_upgraded','1','yes'),(302,'auto_core_update_notified','a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:14:\"wuxing@ucai.cn\";s:7:\"version\";s:5:\"4.2.1\";s:9:\"timestamp\";i:1430205737;}','yes'),(345,'_site_transient_timeout_theme_roots','1430478086','yes'),(346,'_site_transient_theme_roots','a:3:{s:13:\"twentyfifteen\";s:7:\"/themes\";s:14:\"twentyfourteen\";s:7:\"/themes\";s:14:\"twentythirteen\";s:7:\"/themes\";}','yes'),(351,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.2.1.zip\";s:6:\"locale\";s:5:\"zh_CN\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.2.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-4.2.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.2.1-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"4.2.1\";s:7:\"version\";s:5:\"4.2.1\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.1\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1430476295;s:15:\"version_checked\";s:5:\"4.2.1\";s:12:\"translations\";a:1:{i:0;a:7:{s:4:\"type\";s:4:\"core\";s:4:\"slug\";s:7:\"default\";s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:5:\"4.2.1\";s:7:\"updated\";s:19:\"2015-04-23 15:23:08\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.2.1/zh_CN.zip\";s:10:\"autoupdate\";b:1;}}}','yes'),(352,'_site_transient_update_themes','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1430476297;s:7:\"checked\";a:3:{s:13:\"twentyfifteen\";s:3:\"1.1\";s:14:\"twentyfourteen\";s:3:\"1.4\";s:14:\"twentythirteen\";s:3:\"1.5\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:3:{i:0;a:7:{s:4:\"type\";s:5:\"theme\";s:4:\"slug\";s:13:\"twentyfifteen\";s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:3:\"1.1\";s:7:\"updated\";s:19:\"2015-04-23 01:39:39\";s:7:\"package\";s:77:\"https://downloads.wordpress.org/translation/theme/twentyfifteen/1.1/zh_CN.zip\";s:10:\"autoupdate\";b:1;}i:1;a:7:{s:4:\"type\";s:5:\"theme\";s:4:\"slug\";s:14:\"twentyfourteen\";s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:3:\"1.4\";s:7:\"updated\";s:19:\"2015-04-23 01:48:58\";s:7:\"package\";s:78:\"https://downloads.wordpress.org/translation/theme/twentyfourteen/1.4/zh_CN.zip\";s:10:\"autoupdate\";b:1;}i:2;a:7:{s:4:\"type\";s:5:\"theme\";s:4:\"slug\";s:14:\"twentythirteen\";s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:3:\"1.5\";s:7:\"updated\";s:19:\"2015-04-23 01:39:12\";s:7:\"package\";s:78:\"https://downloads.wordpress.org/translation/theme/twentythirteen/1.5/zh_CN.zip\";s:10:\"autoupdate\";b:1;}}}','yes'),(353,'_site_transient_update_plugins','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1430476297;s:8:\"response\";a:0:{}s:12:\"translations\";a:1:{i:0;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:7:\"akismet\";s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:3:\"3.1\";s:7:\"updated\";s:19:\"2015-04-23 02:24:05\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/translation/plugin/akismet/3.1/zh_CN.zip\";s:10:\"autoupdate\";b:1;}}s:9:\"no_update\";a:6:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:2:\"15\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"3.1.1\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.3.1.1.zip\";}s:9:\"hello.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"3564\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/hello-dolly.1.6.zip\";}s:37:\"ldd-business-directory/lddbd_core.php\";O:8:\"stdClass\":7:{s:2:\"id\";s:5:\"34187\";s:4:\"slug\";s:22:\"ldd-business-directory\";s:6:\"plugin\";s:37:\"ldd-business-directory/lddbd_core.php\";s:11:\"new_version\";s:5:\"1.4.1\";s:3:\"url\";s:53:\"https://wordpress.org/plugins/ldd-business-directory/\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/plugin/ldd-business-directory.1.4.1.zip\";s:14:\"upgrade_notice\";s:181:\"Fixes issues with logo upload file names being malformed. Please be advised that this plugin is no longer fully supported as development has moved to the LDD Directory Lite project.\";}s:41:\"ldd-directory-lite/ldd-directory-lite.php\";O:8:\"stdClass\":7:{s:2:\"id\";s:5:\"49334\";s:4:\"slug\";s:18:\"ldd-directory-lite\";s:6:\"plugin\";s:41:\"ldd-directory-lite/ldd-directory-lite.php\";s:11:\"new_version\";s:10:\"0.8.4-beta\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/ldd-directory-lite/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/ldd-directory-lite.0.8.4-beta.zip\";s:14:\"upgrade_notice\";s:73:\"Fixes a major issue with the submission process, and other minor updates.\";}s:41:\"pronamic-companies/pronamic-companies.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"33243\";s:4:\"slug\";s:18:\"pronamic-companies\";s:6:\"plugin\";s:41:\"pronamic-companies/pronamic-companies.php\";s:11:\"new_version\";s:5:\"1.0.1\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/pronamic-companies/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/pronamic-companies.1.0.1.zip\";}s:11:\"hrm/hrm.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"52451\";s:4:\"slug\";s:3:\"hrm\";s:6:\"plugin\";s:11:\"hrm/hrm.php\";s:11:\"new_version\";s:3:\"0.6\";s:3:\"url\";s:34:\"https://wordpress.org/plugins/hrm/\";s:7:\"package\";s:46:\"https://downloads.wordpress.org/plugin/hrm.zip\";}}}','yes');
/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_postmeta`
--

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;
INSERT INTO `wp_postmeta` VALUES (1,2,'_wp_page_template','default'),(6,14,'_pronamic_google_maps_address','\r\n '),(7,15,'_pronamic_google_maps_address','北京市海淀区清河中街68号 华润五彩城写字楼\r\n100085 北京市'),(8,15,'_edit_last','1'),(9,15,'_edit_lock','1430026726:1'),(10,16,'_wp_attached_file','2015/04/about_index_01.jpg'),(11,16,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:800;s:6:\"height\";i:354;s:4:\"file\";s:26:\"2015/04/about_index_01.jpg\";s:5:\"sizes\";a:3:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:26:\"about_index_01-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"about_index_01-300x133.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:133;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:17:\"directory-listing\";a:4:{s:4:\"file\";s:26:\"about_index_01-300x133.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:133;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:11:{s:8:\"aperture\";i:0;s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";i:0;s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";i:0;s:3:\"iso\";i:0;s:13:\"shutter_speed\";i:0;s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:0;}}'),(12,15,'_pronamic_company_contact',''),(13,15,'_pronamic_company_address','北京市海淀区清河中街68号 华润五彩城写字楼'),(14,15,'_pronamic_company_postal_code','100085'),(15,15,'_pronamic_company_city','北京市'),(16,15,'_pronamic_company_country','中国'),(17,15,'_pronamic_company_mailing_address',''),(18,15,'_pronamic_company_mailing_postal_code',''),(19,15,'_pronamic_company_mailing_city',''),(20,15,'_pronamic_company_mailing_country',''),(21,15,'_pronamic_company_kvk_establishment',''),(22,15,'_pronamic_company_kvk_number',''),(23,15,'_pronamic_company_tax_number',''),(24,15,'_pronamic_company_phone_number',''),(25,15,'_pronamic_company_fax_number',''),(26,15,'_pronamic_company_email',''),(27,15,'_pronamic_company_website','http://www.mi.com'),(28,15,'_pronamic_company_rss',''),(29,15,'_pronamic_company_video',''),(30,15,'_pronamic_company_twitter','http://www.weibo.com/u/2202387347'),(31,15,'_pronamic_company_facebook',''),(32,15,'_pronamic_company_linkedin',''),(33,15,'_pronamic_company_google_plus',''),(34,15,'_thumbnail_id','16'),(35,6,'_edit_lock','1430027487:1'),(36,11,'_edit_lock','1430027208:1'),(37,11,'_edit_last','1'),(38,11,'_wp_page_template','default'),(39,10,'_edit_lock','1430027051:1'),(40,10,'_edit_last','1'),(41,10,'_wp_page_template','default'),(42,5,'_edit_lock','1430027067:1'),(43,5,'_edit_last','1'),(44,5,'_wp_page_template','default'),(45,6,'_edit_last','1'),(46,6,'_wp_page_template','default'),(47,12,'_edit_lock','1430027130:1'),(48,12,'_edit_last','1'),(49,12,'_wp_page_template','default'),(50,2,'_edit_lock','1430027149:1'),(51,2,'_edit_last','1'),(52,27,'_edit_last','1'),(53,27,'_edit_lock','1430027647:1'),(54,27,'_lddlite_address_one','北京市海淀区清河中街68号 华润五彩城写字楼'),(55,27,'_lddlite_postal_code','100085'),(56,27,'_lddlite_country','中国'),(57,27,'_lddlite_geo','a:2:{s:3:\"lat\";s:9:\"40.030556\";s:3:\"lng\";s:18:\"116.33282600000007\";}'),(58,27,'_lddlite_url_website','http://www.mi.com'),(59,1,'_edit_lock','1430027890:1'),(60,1,'_edit_last','1');
/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_posts`
--

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;
INSERT INTO `wp_posts` VALUES (1,1,'2015-04-26 03:17:55','2015-04-26 03:17:55','”亿元俱乐部“项目是清华陆向谦创业创新公开课的学生实战项目。\r\n\r\n旨在通过众包的方式收集亿元俱乐部的公司，跟踪公司发展，为同学们提供创业和学习的机会。\r\n\r\n本项目由优才网指导和组织实施，发动陆老师课堂同学参与，参与同学根据能力分成两部分，一部分是有Web开发和实战经验的同学，直接参与功能的升级和开发。一部分对项目和工程感兴趣的，进入”优才网校园星计划”来学习参与项目所需要具备的能力。','”亿元俱乐部“项目开始着手实施','','publish','open','open','','hello-world','','','2015-04-26 06:00:20','2015-04-26 06:00:20','',0,'http://samples.app.ucai.cn/wordpress/?p=1',0,'post','',1),(2,1,'2015-04-26 03:17:55','2015-04-26 03:17:55','This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\r\n<blockquote>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like piña coladas. (And gettin\' caught in the rain.)</blockquote>\r\n...or something like this:\r\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\r\nAs a new WordPress user, you should go to <a href=\"http://samples.app.ucai.cn/wordpress/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!','Sample Page','','draft','open','open','','sample-page','','','2015-04-26 05:48:11','2015-04-26 05:48:11','',0,'http://samples.app.ucai.cn/wordpress/?page_id=2',0,'page','',0),(3,1,'2015-04-26 03:18:22','0000-00-00 00:00:00','','Auto Draft','','auto-draft','open','open','','','','','2015-04-26 03:18:22','0000-00-00 00:00:00','',0,'http://samples.app.ucai.cn/wordpress/?p=3',0,'post','',0),(5,1,'2015-04-26 03:19:32','2015-04-26 03:19:32','[wpjobboard-jobs]','工作机会','','publish','closed','closed','','jobs','','','2015-04-26 05:46:49','2015-04-26 05:46:49','',0,'http://samples.app.ucai.cn/wordpress/index.php/jobs/',0,'page','',0),(6,1,'2015-04-26 03:19:32','2015-04-26 03:19:32','[wpjobboard-resumes]','提交简历','','draft','closed','closed','','resumes','','','2015-04-26 05:53:48','2015-04-26 05:53:48','',0,'http://samples.app.ucai.cn/wordpress/index.php/resumes/',0,'page','',0),(8,1,'2015-04-26 04:02:33','2015-04-26 04:02:33','[wpjobboard-jobs]','Jobs','','inherit','open','open','','5-revision-v1','','','2015-04-26 04:02:33','2015-04-26 04:02:33','',5,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/5-revision-v1/',0,'revision','',0),(9,1,'2015-04-26 04:02:33','2015-04-26 04:02:33','[wpjobboard-resumes]','Resumes','','inherit','open','open','','6-revision-v1','','','2015-04-26 04:02:33','2015-04-26 04:02:33','',6,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/6-revision-v1/',0,'revision','',0),(10,1,'2015-04-26 04:35:13','2015-04-26 04:35:13','[directory]','亿元俱乐部','','publish','closed','open','','directory','','','2015-04-26 05:46:32','2015-04-26 05:46:32','',0,'http://samples.app.ucai.cn/wordpress/index.php/directory/',0,'page','',0),(11,1,'2015-04-26 04:35:13','2015-04-26 04:35:13','[directory_submit]','提交创业公司','','publish','closed','open','','submit-listing','','','2015-04-26 05:49:10','2015-04-26 05:49:10','',10,'http://samples.app.ucai.cn/wordpress/index.php/directory/submit-listing/',0,'page','',0),(12,1,'2015-04-26 04:35:13','2015-04-26 04:35:13','[directory_manage]','管理公司信息','','publish','closed','open','','manage-listings','','','2015-04-26 05:47:48','2015-04-26 05:47:48','',10,'http://samples.app.ucai.cn/wordpress/index.php/directory/manage-listings/',0,'page','',0),(13,1,'2015-04-26 04:35:53','0000-00-00 00:00:00','','自动草稿','','auto-draft','open','open','','','','','2015-04-26 04:35:53','0000-00-00 00:00:00','',0,'http://samples.app.ucai.cn/wordpress/?post_type=directory_listings&p=13',0,'directory_listings','',0),(14,1,'2015-04-26 04:36:27','0000-00-00 00:00:00','','自动草稿','','auto-draft','open','open','','','','','2015-04-26 04:36:27','0000-00-00 00:00:00','',0,'http://samples.app.ucai.cn/wordpress/?post_type=pronamic_company&p=14',0,'pronamic_company','',0),(15,1,'2015-04-26 05:14:58','2015-04-26 05:14:58','&nbsp;\r\n<div class=\"about_index_box\">\r\n\r\n小米公司正式成立于2010年4月，是一家专注于高端智能手机、互联网电视以及智能家居生态链建设的创新型科技企业。\r\n\r\n“让每个人都可享受科技的乐趣”是小米公司的愿景。小米公司首创了用互联网开发模式开发产品的模式，用极客精神做产品，用互联网模式干掉中间环节，致力于让全球每个人，都能享用来自中国的优质科技产品。\r\n\r\n小米公司自创办以来，保持了令世界惊讶的增长速度，小米公司在2012年全年售出手机719万台，2013年售出手机1870万台，2014年售出手机6112万台。小米手机及其子品牌红米手机已经成为了中国市销量第一，全球销量排名前五的优秀产品，小米手机亦成为全球首个互联网手机品牌。\r\n\r\n小米公司在互联网电视机顶盒、互联网智能电视，以及家用智能路由器和智能家居产品等领域也颠覆了传统市场。截至2014年年底，小米公司旗下生态链企业已达22家，其中紫米科技的小米移动电源、华米科技的小米手环、智米科技的小米空气净化器、加一联创的小米活塞耳机等产品均在短时间内迅速成为影响整个中国消费电子市场的明星产品。\r\n\r\n小米生态链建设将秉承开放、不排他、非独家的合作策略，和业界合作伙伴一起推动智能生态链建设。\r\n\r\n</div>\r\n<div class=\"about_index_box\">\r\n<h3 class=\"tit\">小米团队</h3>\r\n小米公司由著名天使投资人雷军带领创建。小米公司共计八名创始人，分别为创始人、董事长兼CEO雷军，联合创始人兼总裁林斌，联合创始人及副总裁周光平、黎万强、黄江吉、刘德、洪锋、王川。\r\n\r\n小米早期核心研发团队主要由来自微软、谷歌、金山、MOTO等国内外IT公司的资深员工所组成，现在小米公司聚集了来自包括硅谷公司在内的全球各行各业的顶尖人才。\r\n\r\n小米人都喜欢创新、快速的互联网文化。小米拒绝平庸，小米人任何时候都能让你感受到他们的创意。在小米团队中，没有冗长无聊的会议和流程，每一位小米人都在平等、轻松的伙伴式工作氛围中，享受与技术、产品、设计等各领域顶尖人才共同创业成长的快意。\r\n\r\n</div>\r\n<div class=\"about_index_box about_index_box_last\">\r\n<h3 class=\"tit\">小米名字由来</h3>\r\n小米的LOGO是一个“MI”形，是Mobile Internet的缩写，代表小米是一家移动互联网公司。\r\n\r\n另外，小米的LOGO倒过来是一个心字，少一个点，意味着小米要让我们的用户省一点心。\r\n\r\n</div>\r\n&nbsp;','小米','','publish','closed','closed','','%e5%b0%8f%e7%b1%b3','','','2015-04-26 05:23:22','2015-04-26 05:23:22','',0,'http://samples.app.ucai.cn/wordpress/?post_type=pronamic_company&#038;p=15',0,'pronamic_company','',0),(16,1,'2015-04-26 05:11:13','2015-04-26 05:11:13','','about_index_01','','inherit','open','open','','about_index_01','','','2015-04-26 05:11:13','2015-04-26 05:11:13','',15,'http://samples.app.ucai.cn/wordpress/wp-content/uploads/2015/04/about_index_01.jpg',0,'attachment','image/jpeg',0),(18,1,'2015-04-26 05:46:02','2015-04-26 05:46:02','[directory_submit]','提交亿元俱乐部创业公司信息','','inherit','open','open','','11-revision-v1','','','2015-04-26 05:46:02','2015-04-26 05:46:02','',11,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/11-revision-v1/',0,'revision','',0),(19,1,'2015-04-26 05:46:32','2015-04-26 05:46:32','[directory]','亿元俱乐部','','inherit','open','open','','10-revision-v1','','','2015-04-26 05:46:32','2015-04-26 05:46:32','',10,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/10-revision-v1/',0,'revision','',0),(20,1,'2015-04-26 05:46:49','2015-04-26 05:46:49','[wpjobboard-jobs]','工作机会','','inherit','open','open','','5-revision-v1','','','2015-04-26 05:46:49','2015-04-26 05:46:49','',5,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/5-revision-v1/',0,'revision','',0),(21,1,'2015-04-26 05:47:03','2015-04-26 05:47:03','[wpjobboard-resumes]','提交简历','','inherit','open','open','','6-revision-v1','','','2015-04-26 05:47:03','2015-04-26 05:47:03','',6,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/6-revision-v1/',0,'revision','',0),(22,1,'2015-04-26 05:47:44','2015-04-26 05:47:44','[directory_manage]','管理公司信息','','inherit','open','open','','12-autosave-v1','','','2015-04-26 05:47:44','2015-04-26 05:47:44','',12,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/12-autosave-v1/',0,'revision','',0),(23,1,'2015-04-26 05:47:48','2015-04-26 05:47:48','[directory_manage]','管理公司信息','','inherit','open','open','','12-revision-v1','','','2015-04-26 05:47:48','2015-04-26 05:47:48','',12,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/12-revision-v1/',0,'revision','',0),(24,1,'2015-04-26 05:48:11','2015-04-26 05:48:11','This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\r\n<blockquote>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like piña coladas. (And gettin\' caught in the rain.)</blockquote>\r\n...or something like this:\r\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\r\nAs a new WordPress user, you should go to <a href=\"http://samples.app.ucai.cn/wordpress/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!','Sample Page','','inherit','open','open','','2-revision-v1','','','2015-04-26 05:48:11','2015-04-26 05:48:11','',2,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/2-revision-v1/',0,'revision','',0),(25,1,'2015-04-26 05:49:10','2015-04-26 05:49:10','[directory_submit]','提交创业公司','','inherit','open','open','','11-revision-v1','','','2015-04-26 05:49:10','2015-04-26 05:49:10','',11,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/11-revision-v1/',0,'revision','',0),(26,1,'2015-04-26 05:49:18','0000-00-00 00:00:00','','自动草稿','','auto-draft','open','open','','','','','2015-04-26 05:49:18','0000-00-00 00:00:00','',0,'http://samples.app.ucai.cn/wordpress/?post_type=directory_listings&p=26',0,'directory_listings','',0),(27,1,'2015-04-26 05:51:33','2015-04-26 05:51:33','<a href=\"http://samples.app.ucai.cn/wordpress/wp-content/uploads/2015/04/about_index_01.jpg\"><img class=\"alignnone size-medium wp-image-16\" src=\"http://samples.app.ucai.cn/wordpress/wp-content/uploads/2015/04/about_index_01-300x133.jpg\" alt=\"about_index_01\" width=\"300\" height=\"133\" /></a>\r\n\r\n&nbsp;\r\n<div class=\"about_index_box\">\r\n\r\n小米公司正式成立于2010年4月，是一家专注于高端智能手机、互联网电视以及智能家居生态链建设的创新型科技企业。\r\n\r\n“让每个人都可享受科技的乐趣”是小米公司的愿景。小米公司首创了用互联网开发模式开发产品的模式，用极客精神做产品，用互联网模式干掉中间环节，致力于让全球每个人，都能享用来自中国的优质科技产品。\r\n\r\n小米公司自创办以来，保持了令世界惊讶的增长速度，小米公司在2012年全年售出手机719万台，2013年售出手机1870万台，2014年售出手机6112万台。小米手机及其子品牌红米手机已经成为了中国市销量第一，全球销量排名前五的优秀产品，小米手机亦成为全球首个互联网手机品牌。\r\n\r\n小米公司在互联网电视机顶盒、互联网智能电视，以及家用智能路由器和智能家居产品等领域也颠覆了传统市场。截至2014年年底，小米公司旗下生态链企业已达22家，其中紫米科技的小米移动电源、华米科技的小米手环、智米科技的小米空气净化器、加一联创的小米活塞耳机等产品均在短时间内迅速成为影响整个中国消费电子市场的明星产品。\r\n\r\n小米生态链建设将秉承开放、不排他、非独家的合作策略，和业界合作伙伴一起推动智能生态链建设。\r\n\r\n</div>\r\n<div class=\"about_index_box\">\r\n<h3 class=\"tit\">小米团队</h3>\r\n小米公司由著名天使投资人雷军带领创建。小米公司共计八名创始人，分别为创始人、董事长兼CEO雷军，联合创始人兼总裁林斌，联合创始人及副总裁周光平、黎万强、黄江吉、刘德、洪锋、王川。\r\n\r\n小米早期核心研发团队主要由来自微软、谷歌、金山、MOTO等国内外IT公司的资深员工所组成，现在小米公司聚集了来自包括硅谷公司在内的全球各行各业的顶尖人才。\r\n\r\n小米人都喜欢创新、快速的互联网文化。小米拒绝平庸，小米人任何时候都能让你感受到他们的创意。在小米团队中，没有冗长无聊的会议和流程，每一位小米人都在平等、轻松的伙伴式工作氛围中，享受与技术、产品、设计等各领域顶尖人才共同创业成长的快意。\r\n\r\n</div>\r\n<div class=\"about_index_box about_index_box_last\">\r\n<h3 class=\"tit\">小米名字由来</h3>\r\n小米的LOGO是一个“MI”形，是Mobile Internet的缩写，代表小米是一家移动互联网公司。\r\n\r\n另外，小米的LOGO倒过来是一个心字，少一个点，意味着小米要让我们的用户省一点心。\r\n\r\n</div>','小米','','publish','closed','closed','','%e5%b0%8f%e7%b1%b3','','','2015-04-26 05:51:33','2015-04-26 05:51:33','',0,'http://samples.app.ucai.cn/wordpress/?post_type=directory_listings&#038;p=27',0,'directory_listings','',0),(28,1,'2015-04-26 05:51:33','2015-04-26 05:51:33','<a href=\"http://samples.app.ucai.cn/wordpress/wp-content/uploads/2015/04/about_index_01.jpg\"><img class=\"alignnone size-medium wp-image-16\" src=\"http://samples.app.ucai.cn/wordpress/wp-content/uploads/2015/04/about_index_01-300x133.jpg\" alt=\"about_index_01\" width=\"300\" height=\"133\" /></a>\r\n\r\n&nbsp;\r\n<div class=\"about_index_box\">\r\n\r\n小米公司正式成立于2010年4月，是一家专注于高端智能手机、互联网电视以及智能家居生态链建设的创新型科技企业。\r\n\r\n“让每个人都可享受科技的乐趣”是小米公司的愿景。小米公司首创了用互联网开发模式开发产品的模式，用极客精神做产品，用互联网模式干掉中间环节，致力于让全球每个人，都能享用来自中国的优质科技产品。\r\n\r\n小米公司自创办以来，保持了令世界惊讶的增长速度，小米公司在2012年全年售出手机719万台，2013年售出手机1870万台，2014年售出手机6112万台。小米手机及其子品牌红米手机已经成为了中国市销量第一，全球销量排名前五的优秀产品，小米手机亦成为全球首个互联网手机品牌。\r\n\r\n小米公司在互联网电视机顶盒、互联网智能电视，以及家用智能路由器和智能家居产品等领域也颠覆了传统市场。截至2014年年底，小米公司旗下生态链企业已达22家，其中紫米科技的小米移动电源、华米科技的小米手环、智米科技的小米空气净化器、加一联创的小米活塞耳机等产品均在短时间内迅速成为影响整个中国消费电子市场的明星产品。\r\n\r\n小米生态链建设将秉承开放、不排他、非独家的合作策略，和业界合作伙伴一起推动智能生态链建设。\r\n\r\n</div>\r\n<div class=\"about_index_box\">\r\n<h3 class=\"tit\">小米团队</h3>\r\n小米公司由著名天使投资人雷军带领创建。小米公司共计八名创始人，分别为创始人、董事长兼CEO雷军，联合创始人兼总裁林斌，联合创始人及副总裁周光平、黎万强、黄江吉、刘德、洪锋、王川。\r\n\r\n小米早期核心研发团队主要由来自微软、谷歌、金山、MOTO等国内外IT公司的资深员工所组成，现在小米公司聚集了来自包括硅谷公司在内的全球各行各业的顶尖人才。\r\n\r\n小米人都喜欢创新、快速的互联网文化。小米拒绝平庸，小米人任何时候都能让你感受到他们的创意。在小米团队中，没有冗长无聊的会议和流程，每一位小米人都在平等、轻松的伙伴式工作氛围中，享受与技术、产品、设计等各领域顶尖人才共同创业成长的快意。\r\n\r\n</div>\r\n<div class=\"about_index_box about_index_box_last\">\r\n<h3 class=\"tit\">小米名字由来</h3>\r\n小米的LOGO是一个“MI”形，是Mobile Internet的缩写，代表小米是一家移动互联网公司。\r\n\r\n另外，小米的LOGO倒过来是一个心字，少一个点，意味着小米要让我们的用户省一点心。\r\n\r\n</div>','小米','','inherit','open','open','','27-revision-v1','','','2015-04-26 05:51:33','2015-04-26 05:51:33','',27,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/27-revision-v1/',0,'revision','',0),(29,1,'2015-04-26 05:59:20','2015-04-26 05:59:20','”亿元俱乐部“项目是清华陆向谦创业创新公开课的学生实战项目。\n\n旨在通过众包的方式收集亿元俱乐部的公司，跟踪公司发展，为同学们提供创业和学习的机会。\n\n本项目由优才网指导和组织实施，发动陆老师课堂同学参与，参与同学根据能力分成两部分，一部分是有Web开发和实战经验的同学，直接参与功能的升级和开发。一部分对adh','”亿元俱乐部“项目开始着手实施','','inherit','open','open','','1-autosave-v1','','','2015-04-26 05:59:20','2015-04-26 05:59:20','',1,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/1-autosave-v1/',0,'revision','',0),(30,1,'2015-04-26 05:56:48','2015-04-26 05:56:48','”亿元俱乐部“项目是清华陆向谦创业创新公开课的学生实战项目。\r\n\r\n旨在通过众包的方式收集亿元俱乐部的公司，跟踪公司发展，为同学们提供创业和学习的机会。','”亿元俱乐部“项目开始着手实施','','inherit','open','open','','1-revision-v1','','','2015-04-26 05:56:48','2015-04-26 05:56:48','',1,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/1-revision-v1/',0,'revision','',0),(31,1,'2015-04-26 05:59:58','2015-04-26 05:59:58','”亿元俱乐部“项目是清华陆向谦创业创新公开课的学生实战项目。\r\n\r\n旨在通过众包的方式收集亿元俱乐部的公司，跟踪公司发展，为同学们提供创业和学习的机会。\r\n\r\n本项目由优才网指导和组织实施，发动陆老师课堂同学参与，参与同学根据能力分成两部分，一部分是有Web开发和实战经验的同学，直接参与功能的升级和开发。一部分对项目和工程感兴趣的，进入”优才网校园星“计划参与项目所需要具备的能力来进行学习。','”亿元俱乐部“项目开始着手实施','','inherit','open','open','','1-revision-v1','','','2015-04-26 05:59:58','2015-04-26 05:59:58','',1,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/1-revision-v1/',0,'revision','',0),(32,1,'2015-04-26 06:00:20','2015-04-26 06:00:20','”亿元俱乐部“项目是清华陆向谦创业创新公开课的学生实战项目。\r\n\r\n旨在通过众包的方式收集亿元俱乐部的公司，跟踪公司发展，为同学们提供创业和学习的机会。\r\n\r\n本项目由优才网指导和组织实施，发动陆老师课堂同学参与，参与同学根据能力分成两部分，一部分是有Web开发和实战经验的同学，直接参与功能的升级和开发。一部分对项目和工程感兴趣的，进入”优才网校园星计划”来学习参与项目所需要具备的能力。','”亿元俱乐部“项目开始着手实施','','inherit','open','open','','1-revision-v1','','','2015-04-26 06:00:20','2015-04-26 06:00:20','',1,'http://samples.app.ucai.cn/wordpress/index.php/2015/04/26/1-revision-v1/',0,'revision','',0);
/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_relationships`
--

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;
INSERT INTO `wp_term_relationships` VALUES (1,1,0),(14,2,0),(15,17,0),(15,18,0),(27,19,0);
/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_taxonomy`
--

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
INSERT INTO `wp_term_taxonomy` VALUES (1,1,'category','',0,1),(2,2,'pronamic_company_character','',0,0),(3,3,'category','',1,0),(4,4,'category','',1,0),(5,5,'category','',1,0),(6,6,'category','',1,0),(7,7,'category','',1,0),(8,8,'category','',0,0),(9,9,'category','',8,0),(10,10,'category','',8,0),(11,11,'category','',8,0),(12,12,'category','',8,0),(13,13,'category','',8,0),(14,14,'category','',8,0),(15,15,'category','',8,0),(16,16,'category','',8,0),(17,17,'pronamic_company_category','',0,1),(18,18,'pronamic_company_character','',0,1),(19,19,'listing_category','',0,1);
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_terms`
--

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;
INSERT INTO `wp_terms` VALUES (1,'移动互联网','%e7%a7%bb%e5%8a%a8%e4%ba%92%e8%81%94%e7%bd%91',0),(2,'','2',0),(3,'B2D开发者服务','b2d%e5%bc%80%e5%8f%91%e8%80%85%e6%9c%8d%e5%8a%a1',0),(4,'应用分发和渠道','%e5%ba%94%e7%94%a8%e5%88%86%e5%8f%91%e5%92%8c%e6%b8%a0%e9%81%93',0),(5,'社交类应用','%e7%a4%be%e4%ba%a4%e7%b1%bb%e5%ba%94%e7%94%a8',0),(6,'工具类应用','%e5%b7%a5%e5%85%b7%e7%b1%bb%e5%ba%94%e7%94%a8',0),(7,'垂直产业类应用','%e5%9e%82%e7%9b%b4%e4%ba%a7%e4%b8%9a%e7%b1%bb%e5%ba%94%e7%94%a8',0),(8,'教育','%e6%95%99%e8%82%b2',0),(9,'教育媒体及社区','%e6%95%99%e8%82%b2%e5%aa%92%e4%bd%93%e5%8f%8a%e7%a4%be%e5%8c%ba',0),(10,'职业培训','%e8%81%8c%e4%b8%9a%e5%9f%b9%e8%ae%ad',0),(11,'儿童早教','%e5%84%bf%e7%ab%a5%e6%97%a9%e6%95%99',0),(12,'K12教育','k12%e6%95%99%e8%82%b2',0),(13,'大学生教育','%e5%a4%a7%e5%ad%a6%e7%94%9f%e6%95%99%e8%82%b2',0),(14,'出国留学','%e5%87%ba%e5%9b%bd%e7%95%99%e5%ad%a6',0),(15,'语言学习','%e8%af%ad%e8%a8%80%e5%ad%a6%e4%b9%a0',0),(16,'兴趣教育','%e5%85%b4%e8%b6%a3%e6%95%99%e8%82%b2',0),(17,'移动互联网','%e7%a7%bb%e5%8a%a8%e4%ba%92%e8%81%94%e7%bd%91',0),(18,'小米','%e5%b0%8f%e7%b1%b3',0),(19,'移动互联网','%e7%a7%bb%e5%8a%a8%e4%ba%92%e8%81%94%e7%bd%91',0);
/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_usermeta`
--

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
INSERT INTO `wp_usermeta` VALUES (1,1,'nickname','admin'),(2,1,'first_name',''),(3,1,'last_name',''),(4,1,'description',''),(5,1,'rich_editing','true'),(6,1,'comment_shortcuts','false'),(7,1,'admin_color','fresh'),(8,1,'use_ssl','0'),(9,1,'show_admin_bar_front','true'),(10,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(11,1,'wp_user_level','10'),(12,1,'dismissed_wp_pointers','wp360_locks,wp390_widgets,wp410_dfw'),(13,1,'show_welcome_panel','1'),(14,1,'session_tokens','a:1:{s:64:\"79d422dd4cd0a6e933db8c31d2b031cf53a4b346496763a878703cca38673719\";a:4:{s:10:\"expiration\";i:1430191101;s:2:\"ip\";s:14:\"123.125.35.158\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36\";s:5:\"login\";i:1430018301;}}'),(15,1,'wp_dashboard_quick_press_last_post_id','3'),(16,1,'is_employer','1'),(17,1,'wp_user-settings','mfold=o&libraryContent=browse&posts_list_mode=list'),(18,1,'wp_user-settings-time','1430026179'),(19,1,'closedpostboxes_pronamic_company','a:0:{}'),(20,1,'metaboxhidden_pronamic_company','a:1:{i:0;s:7:\"slugdiv\";}'),(21,2,'nickname','wuxing'),(22,2,'first_name',''),(23,2,'last_name',''),(24,2,'description',''),(25,2,'rich_editing','true'),(26,2,'comment_shortcuts','false'),(27,2,'admin_color','fresh'),(28,2,'use_ssl','0'),(29,2,'show_admin_bar_front','true'),(30,2,'wp_capabilities','a:1:{s:10:\"subscriber\";b:1;}'),(31,2,'wp_user_level','0'),(32,2,'default_password_nag',''),(33,2,'session_tokens','a:2:{s:64:\"3da740dc60bf82eb6283701bf68fef590d39c335c10c28723d0af6d61cc6283d\";a:4:{s:10:\"expiration\";i:1430201247;s:2:\"ip\";s:14:\"123.125.35.158\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36\";s:5:\"login\";i:1430028447;}s:64:\"3c55ed3192d37b59285eaf81b4ca8f5a6ce547b613b9866674674a2a0014fb80\";a:4:{s:10:\"expiration\";i:1431238206;s:2:\"ip\";s:14:\"123.151.64.142\";s:2:\"ua\";s:214:\"Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; HM NOTE 1S Build/KTU84P) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.4 TBS/025411 Mobile Safari/533.1 MicroMessenger/6.1.0.73_r1097298.543 NetType/WIFI\";s:5:\"login\";i:1430028606;}}'),(34,3,'nickname','OwenSSMocn'),(35,3,'first_name',''),(36,3,'last_name',''),(37,3,'description',''),(38,3,'rich_editing','true'),(39,3,'comment_shortcuts','false'),(40,3,'admin_color','fresh'),(41,3,'use_ssl','0'),(42,3,'show_admin_bar_front','true'),(43,3,'wp_capabilities','a:1:{s:10:\"subscriber\";b:1;}'),(44,3,'wp_user_level','0'),(45,3,'default_password_nag','1'),(46,4,'nickname','shenshihao'),(47,4,'first_name',''),(48,4,'last_name',''),(49,4,'description',''),(50,4,'rich_editing','true'),(51,4,'comment_shortcuts','false'),(52,4,'admin_color','fresh'),(53,4,'use_ssl','0'),(54,4,'show_admin_bar_front','true'),(55,4,'wp_capabilities','a:1:{s:10:\"subscriber\";b:1;}'),(56,4,'wp_user_level','0'),(57,4,'default_password_nag','1');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_users`
--

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES (1,'admin','$P$BYE/qSO/l0Wd.OmfoHzBS33wvJ4Fbi1','admin','wuxing@ucai.cn','','2015-04-26 03:17:55','',0,'admin'),(2,'wuxing','$P$BlovWPGOtwE1xZ9ni5MsNNxPW0LQPT1','wuxing','ucai@ucai.cn','','2015-04-26 06:03:17','',0,'wuxing'),(3,'OwenSSMocn','$P$BGo2pDLQ0.CsbRn4EMEoRAK2D3799w1','owenssmocn','jadatrojanowskimh4688@yahoo.com','','2015-04-26 07:48:26','',0,'OwenSSMocn'),(4,'shenshihao','$P$BKMlTr5CMbX52pm9N7pDVSx3sdZtea0','shenshihao','794262212@qq.com','','2015-05-01 10:36:39','',0,'shenshihao');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_additional_field`
--

DROP TABLE IF EXISTS `wpjb_additional_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_additional_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL COMMENT '1:text; 3:ckbox; 4:select; 6:textarea',
  `is_active` tinyint(1) unsigned NOT NULL,
  `is_required` tinyint(1) unsigned NOT NULL,
  `validator` varchar(120) NOT NULL,
  `label` varchar(120) NOT NULL,
  `hint` varchar(250) NOT NULL,
  `default_value` varchar(120) DEFAULT NULL,
  `field_for` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:job; 2:job apply, 3:resume',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_additional_field`
--

LOCK TABLES `wpjb_additional_field` WRITE;
/*!40000 ALTER TABLE `wpjb_additional_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_additional_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_alert`
--

DROP TABLE IF EXISTS `wpjb_alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_alert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `is_active_2` (`is_active`,`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_alert`
--

LOCK TABLES `wpjb_alert` WRITE;
/*!40000 ALTER TABLE `wpjb_alert` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_alert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_application`
--

DROP TABLE IF EXISTS `wpjb_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_application` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `applied_at` datetime NOT NULL,
  `applicant_name` varchar(120) NOT NULL,
  `title` varchar(120) NOT NULL,
  `resume` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `employer_note` text NOT NULL,
  `admin_note` text NOT NULL,
  `is_rejected` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `wpjb_application_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `wpjb_job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_application`
--

LOCK TABLES `wpjb_application` WRITE;
/*!40000 ALTER TABLE `wpjb_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_career_builder_log`
--

DROP TABLE IF EXISTS `wpjb_career_builder_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_career_builder_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `did` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_career_builder_log`
--

LOCK TABLES `wpjb_career_builder_log` WRITE;
/*!40000 ALTER TABLE `wpjb_career_builder_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_career_builder_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_category`
--

DROP TABLE IF EXISTS `wpjb_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_category`
--

LOCK TABLES `wpjb_category` WRITE;
/*!40000 ALTER TABLE `wpjb_category` DISABLE KEYS */;
INSERT INTO `wpjb_category` VALUES (1,'default','Default','');
/*!40000 ALTER TABLE `wpjb_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_discount`
--

DROP TABLE IF EXISTS `wpjb_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_discount` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `code` varchar(20) NOT NULL,
  `discount` decimal(10,2) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '1=%; 2=$',
  `currency` tinyint(3) unsigned NOT NULL,
  `expires_at` date NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `used` int(11) NOT NULL,
  `max_uses` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_discount`
--

LOCK TABLES `wpjb_discount` WRITE;
/*!40000 ALTER TABLE `wpjb_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_employer`
--

DROP TABLE IF EXISTS `wpjb_employer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_employer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'foreign key wp_users.id',
  `company_name` varchar(120) NOT NULL DEFAULT '',
  `company_website` varchar(120) NOT NULL DEFAULT '',
  `company_info` text NOT NULL,
  `company_logo_ext` char(5) NOT NULL DEFAULT '',
  `company_country` smallint(5) unsigned NOT NULL,
  `company_state` varchar(40) NOT NULL,
  `company_zip_code` varchar(20) NOT NULL,
  `company_location` varchar(250) NOT NULL DEFAULT '',
  `jobs_posted` int(11) unsigned NOT NULL DEFAULT '0',
  `is_public` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0: inactive; 1: active; 2: requesting; 3: decline; 4:full-access',
  `access_until` date NOT NULL DEFAULT '0000-00-00',
  `geo_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `geo_latitude` float(9,6) NOT NULL DEFAULT '0.000000',
  `geo_longitude` float(9,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_employer`
--

LOCK TABLES `wpjb_employer` WRITE;
/*!40000 ALTER TABLE `wpjb_employer` DISABLE KEYS */;
INSERT INTO `wpjb_employer` VALUES (1,1,'','','','',0,'','','',0,0,1,'0000-00-00',0,0.000000,0.000000);
/*!40000 ALTER TABLE `wpjb_employer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_field_option`
--

DROP TABLE IF EXISTS `wpjb_field_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_field_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL,
  `value` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `wpjb_field_option_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `wpjb_additional_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_field_option`
--

LOCK TABLES `wpjb_field_option` WRITE;
/*!40000 ALTER TABLE `wpjb_field_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_field_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_field_value`
--

DROP TABLE IF EXISTS `wpjb_field_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_field_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL,
  `job_id` int(11) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `wpjb_field_value_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `wpjb_additional_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_field_value`
--

LOCK TABLES `wpjb_field_value` WRITE;
/*!40000 ALTER TABLE `wpjb_field_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_field_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_job`
--

DROP TABLE IF EXISTS `wpjb_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(120) NOT NULL,
  `company_website` varchar(240) NOT NULL,
  `company_email` varchar(240) NOT NULL,
  `company_logo_ext` char(5) NOT NULL DEFAULT '',
  `job_type` int(11) unsigned NOT NULL,
  `job_category` int(11) unsigned NOT NULL,
  `job_source` tinyint(3) unsigned NOT NULL COMMENT '1:native; 2:admin; 3:external',
  `job_country` smallint(5) unsigned NOT NULL,
  `job_state` varchar(40) NOT NULL DEFAULT '',
  `job_zip_code` varchar(20) NOT NULL DEFAULT '',
  `job_location` varchar(120) NOT NULL,
  `job_limit_to_country` tinyint(1) unsigned NOT NULL,
  `job_title` varchar(120) NOT NULL,
  `job_slug` varchar(120) NOT NULL,
  `job_visible` smallint(5) unsigned NOT NULL,
  `job_created_at` datetime NOT NULL,
  `job_expires_at` datetime NOT NULL,
  `job_modified_at` datetime NOT NULL,
  `job_description` text NOT NULL,
  `is_approved` tinyint(1) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `is_filled` tinyint(1) unsigned NOT NULL,
  `is_featured` tinyint(1) unsigned NOT NULL,
  `payment_sum` float(10,2) unsigned NOT NULL,
  `payment_paid` float(10,2) unsigned NOT NULL,
  `payment_currency` smallint(5) unsigned NOT NULL,
  `payment_discount` float(10,2) unsigned NOT NULL,
  `stat_views` int(11) unsigned NOT NULL DEFAULT '0',
  `stat_unique` int(11) unsigned NOT NULL DEFAULT '0',
  `stat_apply` int(11) unsigned NOT NULL DEFAULT '0',
  `employer_id` int(11) unsigned DEFAULT NULL,
  `discount_id` int(11) NOT NULL DEFAULT '0',
  `geo_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `geo_latitude` float(9,6) NOT NULL DEFAULT '0.000000',
  `geo_longitude` float(9,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `is_approved` (`is_approved`,`is_active`,`job_created_at`,`job_visible`),
  KEY `job_category` (`job_category`),
  KEY `job_type` (`job_type`),
  KEY `employer_id` (`employer_id`),
  CONSTRAINT `wpjb_job_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `wpjb_employer` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_job`
--

LOCK TABLES `wpjb_job` WRITE;
/*!40000 ALTER TABLE `wpjb_job` DISABLE KEYS */;
INSERT INTO `wpjb_job` VALUES (1,'优才网','http://www.ucai.cn','wuxing@ucai.cn','',3,1,2,156,'','','China',0,'开发工程师','billions',30,'2015-04-26 04:05:39','2015-05-26 04:05:39','2015-04-26 04:08:12','开发工程师',1,1,0,1,0.00,0.00,18,0.00,11,11,0,NULL,0,1,0.000000,0.000000);
/*!40000 ALTER TABLE `wpjb_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_job_search`
--

DROP TABLE IF EXISTS `wpjb_job_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_job_search` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(11) unsigned NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `company` varchar(120) NOT NULL,
  `location` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_id` (`job_id`),
  FULLTEXT KEY `search` (`title`,`description`,`location`,`company`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_job_search`
--

LOCK TABLES `wpjb_job_search` WRITE;
/*!40000 ALTER TABLE `wpjb_job_search` DISABLE KEYS */;
INSERT INTO `wpjb_job_search` VALUES (1,1,'开发工程师','开发工程师','优才网','CN CHN China  China ');
/*!40000 ALTER TABLE `wpjb_job_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_listing`
--

DROP TABLE IF EXISTS `wpjb_listing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_listing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `price` float(10,2) NOT NULL,
  `currency` tinyint(3) unsigned NOT NULL,
  `visible` smallint(5) unsigned NOT NULL,
  `is_featured` tinyint(1) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_listing`
--

LOCK TABLES `wpjb_listing` WRITE;
/*!40000 ALTER TABLE `wpjb_listing` DISABLE KEYS */;
INSERT INTO `wpjb_listing` VALUES (1,'Premium',20.00,18,30,1,1,''),(2,'Free',0.00,18,30,0,1,'');
/*!40000 ALTER TABLE `wpjb_listing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_mail`
--

DROP TABLE IF EXISTS `wpjb_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_mail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sent_to` tinyint(1) unsigned NOT NULL COMMENT '1:admin; 2:job poster; 3: other',
  `sent_when` varchar(120) NOT NULL,
  `mail_title` varchar(120) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_from` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_mail`
--

LOCK TABLES `wpjb_mail` WRITE;
/*!40000 ALTER TABLE `wpjb_mail` DISABLE KEYS */;
INSERT INTO `wpjb_mail` VALUES (1,1,'Sent to Admin when job is added to database (but not yet payed) ','New Job has been posted.','New job titled \"{$position_title}\" ({$id}) has been posted in {$category}.\r\n\r\nBuyer ({$company} {$email}) selected {$listing_type} which costs {$price}.\r\n\r\nAdded discount {$discount}.','wuxing@ucai.cn'),(2,1,'Sent when PayPal confirms that payment was received ','Payment Received.','You have received payment {$paid} from {$company} ({$email}) for listing {$id},\r\n\r\nThis listing is currently {$active}.','wuxing@ucai.cn'),(3,2,'Sent when client finishes posting FREE job ','Your job listing has been saved.','Hello,\r\nyour job listing titled \"{$position_title}\" has been saved.\r\n\r\nIt\'s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nListing will be visible for {$visible} and will expire on {$expiration}\r\n\r\nBest Regards\r\nJob Board Support','wuxing@ucai.cn'),(4,2,'Sent when client finishes posting PAID job ','Your job listing has been saved.','Hello,\r\nyour job listing titled \"{$position_title}\" has been saved.\r\n\r\nIt\'s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nBest Regards\r\nJob Board Support','wuxing@ucai.cn'),(5,2,'Sent to client to inform him that his listing will expire soon ','Listing will expire soon.','Hello,\r\nyour job listing titled \"{$position_title}\" has been saved.\r\n\r\nIt\'s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nBest Regards\r\nJob Board Support','wuxing@ucai.cn'),(6,2,'When applicant applies for job','Application for: {$position_title}','Application for position: {$position_title}\r\nApplicant E-mail: {$applicant_email}\r\n----------------------------------------\r\n{$applicant_cv}','wuxing@ucai.cn'),(7,3,'Alert is sent to subscriber who created alert','Job Board Alert','Hello,\r\njob board alert was triggered because someone posted a job that matched your keyword: \"{$alert_keyword}\".\r\n\r\nYou can view the job at: {$url}\r\n\r\nIf you wish to no longer receive email alerts for this keyword click following link: {$alert_unsubscribe_url}\r\n\r\nBest Regards\r\nJob Board Team','wuxing@ucai.cn'),(8,3,'E-mail sent to applicant who applied for job','Your application has been sent','Hello,\r\nyour application has been sent successfully. If employer will find your resume interesting you should be contacted shortly.\r\nThank you for using our job board.\r\n\r\nBest Regards\r\nJob Board Team','wuxing@ucai.cn'),(9,3,'Employer registers','Your login and password','Username: {$username}\r\nPassword: {$password}\r\n{$login_url}\r\n\r\n\r\n\r\n','example@example.com'),(10,3,'Job seeker registers','Your login and password','Username: {$username}\r\nPassword: {$password}\r\n{$login_url}','example@example.com'),(11,1,'Admin has to manually approve user resume','User resume is pending approval','You have received this email because user {$firstname} {$lastname} (ID: {$id}) posted or updated his resume, and admin action is required in order to approve or reject the resume.\n\nResume edit link:\n{$resume_admin_url}',''),(12,1,'Admin has to manually grant company access to resumes','Company is requesting access to resumes','You have received this email because employer {$company_name} (ID: {$id}) is requesting full resumes access.\n\nYou can approve/reject this request at:\n{$company_admin_url}','');
/*!40000 ALTER TABLE `wpjb_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_payment`
--

DROP TABLE IF EXISTS `wpjb_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_payment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'foreign key: wp_users.ID',
  `object_id` int(11) unsigned NOT NULL,
  `object_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:job; 2:resumes',
  `engine` varchar(40) NOT NULL,
  `external_id` varchar(80) NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `message` varchar(120) NOT NULL,
  `made_at` datetime NOT NULL,
  `payment_sum` float(10,2) unsigned NOT NULL,
  `payment_paid` float(10,2) unsigned NOT NULL,
  `payment_currency` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_payment`
--

LOCK TABLES `wpjb_payment` WRITE;
/*!40000 ALTER TABLE `wpjb_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_resume`
--

DROP TABLE IF EXISTS `wpjb_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_resume` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT 'Professional Headline',
  `firstname` varchar(80) NOT NULL DEFAULT '',
  `lastname` varchar(80) NOT NULL DEFAULT '',
  `headline` text NOT NULL,
  `experience` text NOT NULL,
  `education` text NOT NULL,
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `address` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(120) NOT NULL DEFAULT '',
  `phone` varchar(40) NOT NULL DEFAULT '',
  `website` varchar(120) NOT NULL DEFAULT '',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `degree` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `years_experience` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `image_ext` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `search` (`title`,`headline`),
  FULLTEXT KEY `search_extended` (`title`,`headline`,`experience`,`education`),
  FULLTEXT KEY `address` (`address`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_resume`
--

LOCK TABLES `wpjb_resume` WRITE;
/*!40000 ALTER TABLE `wpjb_resume` DISABLE KEYS */;
INSERT INTO `wpjb_resume` VALUES (1,1,0,'','','','','','',0,'','','','',0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',''),(2,2,0,'','','','','','',0,'','','','',0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `wpjb_resume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_resumes_access`
--

DROP TABLE IF EXISTS `wpjb_resumes_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_resumes_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employer_id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `extend` smallint(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employer_id` (`employer_id`),
  CONSTRAINT `wpjb_resumes_access_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `wpjb_employer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_resumes_access`
--

LOCK TABLES `wpjb_resumes_access` WRITE;
/*!40000 ALTER TABLE `wpjb_resumes_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `wpjb_resumes_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpjb_type`
--

DROP TABLE IF EXISTS `wpjb_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpjb_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpjb_type`
--

LOCK TABLES `wpjb_type` WRITE;
/*!40000 ALTER TABLE `wpjb_type` DISABLE KEYS */;
INSERT INTO `wpjb_type` VALUES (1,'full-time','Full-Time','',''),(2,'part-time','Part-time','',''),(3,'contractor','Contractor','',''),(4,'intern','Intern','',''),(5,'seasonal-temp','Seasonal/Temp','','');
/*!40000 ALTER TABLE `wpjb_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-02  8:18:24
