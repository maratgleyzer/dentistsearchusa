-- MySQL dump 10.13  Distrib 5.5.9, for Win32 (x86)
--
-- Host: 174.122.31.166    Database: dentists_dsusa_site
-- ------------------------------------------------------
-- Server version	5.0.92-community

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Current Database: `dentists_dsusa_site`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dentists_dsusa_site` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `dentists_dsusa_site_innodb`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `login` char(64) default NULL,
  `password` char(64) default NULL,
  `salt` char(64) default NULL,
  `level` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_advertisements`
--

DROP TABLE IF EXISTS `admin_advertisements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_advertisements` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `image` char(64) default NULL,
  `title` char(64) default NULL,
  `text` char(255) default NULL,
  `links` char(128) default NULL,
  `name` char(64) default NULL,
  `page` char(128) default NULL,
  `order` tinyint(3) unsigned default NULL,
  `use_default` tinyint(1) unsigned default NULL,
  `align` enum('left','right') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_email_templates`
--

DROP TABLE IF EXISTS `admin_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_email_templates` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `subject` char(255) default NULL,
  `content` text,
  `type` char(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_inquiries`
--

DROP TABLE IF EXISTS `admin_inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_inquiries` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` char(32) default NULL,
  `email` char(64) default NULL,
  `message` text,
  `date` char(32) default NULL,
  `is_dentist` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_privileges`
--

DROP TABLE IF EXISTS `admin_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_privileges` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `privilege_id` tinyint(1) unsigned default NULL,
  `admin_id` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_profiles`
--

DROP TABLE IF EXISTS `admin_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_profiles` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `user_id` tinyint(3) unsigned NOT NULL,
  `fname` char(16) NOT NULL,
  `mname` char(16) NOT NULL,
  `lname` char(16) NOT NULL,
  `photo` char(128) NOT NULL,
  `st` char(32) NOT NULL,
  `town` char(32) NOT NULL,
  `city` char(32) NOT NULL,
  `zipcode` char(16) NOT NULL,
  `state_id` tinyint(3) unsigned NOT NULL,
  `telno` char(16) NOT NULL,
  `emailaddress` text NOT NULL,
  `website` char(64) NOT NULL,
  `shortbio` text NOT NULL,
  `ofchrs` text NOT NULL,
  `promos` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_seo_tags`
--

DROP TABLE IF EXISTS `admin_seo_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_seo_tags` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `page` char(128) default NULL,
  `title` char(128) default NULL,
  `keywords` char(255) default NULL,
  `description` text,
  `content` text,
  `editable_content` tinyint(1) unsigned default NULL,
  `content_only` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_setting_choices`
--

DROP TABLE IF EXISTS `admin_setting_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_setting_choices` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `value` char(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_setting_privileges`
--

DROP TABLE IF EXISTS `admin_setting_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_setting_privileges` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` char(64) default NULL,
  `description` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_settings` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `analytics_id` char(64) default NULL,
  `search_result_text` char(255) default NULL,
  `footer_tags` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_social_media_icons`
--

DROP TABLE IF EXISTS `admin_social_media_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_social_media_icons` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `icon` char(64) default NULL,
  `link` char(128) default NULL,
  `tooltip` char(128) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `bayesian_rating`
--

DROP TABLE IF EXISTS `bayesian_rating`;
/*!50001 DROP VIEW IF EXISTS `bayesian_rating`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `bayesian_rating` (
  `user_id` int(11),
  `avg_num_votes` decimal(23,4),
  `avg_rating` double,
  `this_num_votes` bigint(20),
  `this_rating` double,
  `the_rating` double
) ENGINE=InnoDB */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `city_population`
--

DROP TABLE IF EXISTS `city_population`;
/*!50001 DROP VIEW IF EXISTS `city_population`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `city_population` (
  `city_population` decimal(30,0),
  `city_name` varchar(40),
  `state_abbr` varchar(2)
) ENGINE=InnoDB */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `cms_patients`
--

DROP TABLE IF EXISTS `cms_patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_patients` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `caller_name` char(64) default NULL,
  `dental_emergency` char(1) unsigned default NULL,
  `phone` char(16) default NULL,
  `pain_level` char(2) default NULL,
  `patient_name` char(64) default NULL,
  `dentist_assigned_to` mediumint(8) unsigned default NULL,
  `fear_of_dentist` char(1) default NULL,
  `last_appointment_date` date default NULL,
  `birth_day` date default NULL,
  `address` char(64) default NULL,
  `city` char(32) default NULL,
  `state` char(32) default NULL,
  `zip` char(16) default NULL,
  `email` char(64) default NULL,
  `notes` text,
  `office_contact` char(64) default NULL,
  `author_added` char(255) default NULL,
  `author_updated` mediumint(8) unsigned default NULL,
  `added` datetime mediumint(8) unsigned default NULL,
  `updated` datetime default NULL,
  `pdf_file` char(64) default NULL,
  `appointment_date` date default NULL,
  `appointment_time` char(16) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_users` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` char(64) default NULL,
  `login` char(64) default NULL,
  `password` char(64) default NULL,
  `salt` char(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_articles`
--

DROP TABLE IF EXISTS `content_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_articles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(128) default NULL,
  `summary` text,
  `content` text,
  `image` char(64) default NULL,
  `author` char(64) default NULL,
  `date` date default NULL,
  `category_id` smallint(5) unsigned NOT NULL,
  `tags` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`,`summary`,`content`,`tags`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_categories`
--

DROP TABLE IF EXISTS `content_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_categories` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `category_title` char(64) default NULL,
  `description` text,
  `type` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_videos`
--

DROP TABLE IF EXISTS `content_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_videos` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` char(64) default NULL,
  `size` char(64) default NULL,
  `summary` text,
  `date` date default NULL,
  `tags` text,
  `image` char(64) default NULL,
  `filename` char(128) default NULL,
  `category_id` smallint(5) unsigned default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`,`summary`,`tags`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_cities`
--

DROP TABLE IF EXISTS `data_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_cities` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `city_name` char(32) character set utf8 default NULL,
  `state_abbr` char(2) character set utf8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29829 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_dentists_raw_distinct`
--

DROP TABLE IF EXISTS `data_dentists_raw_distinct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_dentists_raw_distinct` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) default NULL,
  `first_name` char(32) default NULL,
  `last_name` char(32) default NULL,
  `middle_initial` char(4) default NULL,
  `post_nominal` char(32) default NULL,
  `name` char(64) default NULL,
  `company_name` char(128) default NULL,
  `bio` text default NULL,
  `address` char(64) default NULL,
  `city` char(32) default NULL,
  `state` char(32) default NULL,
  `zip` char(16) default NULL,
  `phone` char(16) default NULL,
  `login_email` char(64) default NULL,
  `email` char(64) default NULL,
  `website` char(64) default NULL,
  `monday` char(32) default NULL,
  `tuesday` char(32) default NULL,
  `wednesday` char(32) default NULL,
  `thursday` char(32) default NULL,
  `friday` char(32) default NULL,
  `saturday` char(32) default NULL,
  `sunday` char(32) default NULL,
  `qualifications` text default NULL,
  `certifications` text default NULL,
  `specialties` text default NULL,
  `promotion_titles` text default NULL,
  `promotion_descriptions` text default NULL,
  `promo_codes` text default NULL,
  `prof_pic` char(64) default NULL,
  `dentist_image` text default NULL,
  `dentist_description_image` text,
  `other_images` text default NULL,
  `before_and_after` text default NULL,
  `source_file` char(64) default NULL,
  `valid_city` tinyint(1) unsigned default NULL,
  `valid_zip` tinyint(1) unsigned default NULL,
  `valid_state` tinyint(1) unsigned default NULL,
  `valid_email` tinyint(1) unsigned default NULL,
  `valid_website` tinyint(1) unsigned default NULL,
  `valid_name` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=946 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_locations`
--

DROP TABLE IF EXISTS `data_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_locations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `zip_code` char(16) character set utf8 default NULL,
  `city_name` char(32) character set utf8 default NULL,
  `state_abbr` char(2) character set utf8 default NULL,
  `state_long` char(32) default NULL,
  `longitude` float default NULL,
  `latitude` float default NULL,
  `elevation` smallint(5) unsigned default NULL,
  `population` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `zip_code` (`zip_code`),
  FULLTEXT KEY `city_name` (`city_name`),
  FULLTEXT KEY `state_abbr` (`state_abbr`)
) ENGINE=InnoDB AUTO_INCREMENT=42487 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_states`
--

DROP TABLE IF EXISTS `data_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_states` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `state_abbr` char(2) character set utf8 default NULL,
  `state_long` char(32) default NULL,
  `disabled` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_plan_types`
--

DROP TABLE IF EXISTS `payment_plan_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_plan_types` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` char(32) default NULL,
  `is_recurring` tinyint(1) unsigned default NULL,
  `recurring_type` char(16) default NULL,
  `recurring_cycles` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_plans`
--

DROP TABLE IF EXISTS `payment_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_plans` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` tinyint(3) unsigned default NULL,
  `initial_payment` smallint(5) unsigned default NULL,
  `recurring_payment` smallint(5) unsigned default NULL,
  `name` char(32) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paypal_transactions`
--

DROP TABLE IF EXISTS `paypal_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paypal_transactions` (
  `entryID` int(10) unsigned NOT NULL auto_increment,
  `type` char(255) NOT NULL,
  `results` char(255) NOT NULL,
  `timestamp` int(14) unsigned NOT NULL,
  PRIMARY KEY  (`entryID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `total_votes`
--

DROP TABLE IF EXISTS `total_votes`;
/*!50001 DROP VIEW IF EXISTS `total_votes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `total_votes` (
  `user_id` mediumint(8) unsigned,
  `total_votes` smallint(5) unsigned
) ENGINE=InnoDB */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_accounts` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `email` char(64) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(64) NOT NULL,
  `plan_id` smallint(5) unsigned default NULL,
  `status` tinyint(1) unsigned default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_appointments`
--

DROP TABLE IF EXISTS `user_appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_appointments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `appointment` char(64) default NULL,
  `name` char(64) default NULL,
  `age` char(3) default NULL,
  `oral_health` char(128) default NULL,
  `last_visit` date default NULL,
  `app_date` date default NULL,
  `app_time` char(16) default NULL,
  `email` char(64) default NULL,
  `telephone` char(16) default NULL,
  `mobile` char(16) default NULL,
  `comments` text,
  `pid` int(10) unsigned default NULL,
  `is_read` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_certifications`
--

DROP TABLE IF EXISTS `user_certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_certifications` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `filename` char(64) default NULL,
  `path` char(128) default NULL,
  `group` char(64) default NULL,
  `type` char(64) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_company_info`
--

DROP TABLE IF EXISTS `user_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_company_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `company_name` char(128) default NULL,
  `address` char(64) default NULL,
  `city` char(32) default NULL,
  `state` char(32) default NULL,
  `zip` char(16) default NULL,
  `telephone` char(16) default NULL,
  `dsusa_telephone` char(16) default NULL,
  `website` char(64) default NULL,
  `company_email` char(64) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `zip` (`zip`)
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `user_count`
--

DROP TABLE IF EXISTS `user_count`;
/*!50001 DROP VIEW IF EXISTS `user_count`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `user_count` (
  `user_count` bigint(21),
  `city` varchar(255),
  `state` varchar(255)
) ENGINE=InnoDB */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `user_count_and_city_population`
--

DROP TABLE IF EXISTS `user_count_and_city_population`;
/*!50001 DROP VIEW IF EXISTS `user_count_and_city_population`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `user_count_and_city_population` (
  `user_count` bigint(21),
  `city_population` decimal(30,0),
  `city_name` varchar(40),
  `state_abbr` varchar(2)
) ENGINE=InnoDB */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_dashboard_info`
--

DROP TABLE IF EXISTS `user_dashboard_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_dashboard_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned default NULL,
  `promotional` text,
  `documents_intro` text,
  `gallery_intro` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_events`
--

DROP TABLE IF EXISTS `user_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `message` text,
  `note` char(128) default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_files`
--

DROP TABLE IF EXISTS `user_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `filename` char(64) default NULL,
  `path` char(128) default NULL,
  `group` char(64) default NULL,
  `type` char(64) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_images`
--

DROP TABLE IF EXISTS `user_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `path` char(128) default NULL,
  `filename` char(64) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_personal_info`
--

DROP TABLE IF EXISTS `user_personal_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_personal_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_nominal` char(32) default NULL,
  `first_name` char(32) default NULL,
  `last_name` char(32) default NULL,
  `bio` text,
  `mobile_number` char(16) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  `prof_pic` char(64) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  FULLTEXT KEY `last_name` (`last_name`)
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_pre_registrations`
--

DROP TABLE IF EXISTS `user_pre_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_pre_registrations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` char(64) default NULL,
  `phone` char(16) default NULL,
  `email` char(64) default NULL,
  `interested_in` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_promotionals`
--

DROP TABLE IF EXISTS `user_promotionals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_promotionals` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(64) default NULL,
  `code` char(32) default NULL,
  `description` text,
  `file_path` char(128) default NULL,
  `file` char(64) default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_reviews`
--

DROP TABLE IF EXISTS `user_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_reviews` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(64) default NULL,
  `email` char(64) default NULL,
  `website` char(64) default NULL,
  `message` text,
  `rating` float default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  `date` date default NULL,
  `is_read` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_schedules`
--

DROP TABLE IF EXISTS `user_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_schedules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `day` char(16) default NULL,
  `login` char(16) default NULL,
  `break_in` varchar(16) default NULL,
  `break_out` varchar(16) default NULL,
  `logout` varchar(16) default NULL,
  `order` tinyint(3) unsigned default NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_specialties`
--

DROP TABLE IF EXISTS `user_specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_specialties` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `specialty_id` tinyint(3) unsigned default NULL,
  `specialty_text` text,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_specialty_categories`
--

DROP TABLE IF EXISTS `user_specialty_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_specialty_categories` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `specialty_title` char(64) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_statistics`
--

DROP TABLE IF EXISTS `user_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statistics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_view` int(10) unsigned default NULL,
  `user_id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=923 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Current Database: `dentists_dsusa_site`
--

USE `dentists_dsusa_site`;

--
-- Final view structure for view `bayesian_rating`
--

/*!50001 DROP TABLE IF EXISTS `bayesian_rating`*/;
/*!50001 DROP VIEW IF EXISTS `bayesian_rating`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bayesian_rating` AS select `e`.`user_id` AS `user_id`,(select avg(`t`.`total_votes`) AS `AVG(t.total_votes)` from `total_votes` `t` where (`t`.`total_votes` > 0)) AS `avg_num_votes`,(select avg(`user_reviews`.`rating`) AS `AVG(rating)` from `user_reviews`) AS `avg_rating`,(select `total_votes`.`total_votes` AS `total_votes` from `total_votes` where (`total_votes`.`user_id` = `e`.`user_id`)) AS `this_num_votes`,(select avg(`user_reviews`.`rating`) AS `AVG(rating)` from `user_reviews` where (`user_reviews`.`user_id` = `e`.`user_id`)) AS `this_rating`,(select (((`avg_num_votes` * `avg_rating`) + (`this_num_votes` * `this_rating`)) / (`avg_num_votes` + `this_num_votes`)) AS `( (avg_num_votes * avg_rating) + (this_num_votes * this_rating) ) / (avg_num_votes + this_num_votes)`) AS `the_rating` from `user_reviews` `e` group by `e`.`user_id` */;

--
-- Final view structure for view `city_population`
--

/*!50001 DROP TABLE IF EXISTS `city_population`*/;
/*!50001 DROP VIEW IF EXISTS `city_population`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`dentists_webuser`@`184.195.228.%` SQL SECURITY DEFINER VIEW `city_population` AS select sum(`d`.`population`) AS `city_population`,`d`.`city_name` AS `city_name`,`d`.`state_abbr` AS `state_abbr` from `data_locations` `d` group by `d`.`state_abbr`,`d`.`city_name` */;

--
-- Final view structure for view `total_votes`
--

/*!50001 DROP TABLE IF EXISTS `total_votes`*/;
/*!50001 DROP VIEW IF EXISTS `total_votes`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_votes` AS select distinct `o`.`user_id` AS `user_id`,(select count(`user_reviews`.`user_id`) AS `COUNT(user_id)` from `user_reviews` where (`user_reviews`.`user_id` = `o`.`user_id`)) AS `total_votes` from `user_reviews` `o` */;

--
-- Final view structure for view `user_count`
--

/*!50001 DROP TABLE IF EXISTS `user_count`*/;
/*!50001 DROP VIEW IF EXISTS `user_count`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`dentists_webuser`@`184.195.228.%` SQL SECURITY DEFINER VIEW `user_count` AS select count(0) AS `user_count`,`u`.`city` AS `city`,`u`.`state` AS `state` from `user_company_info` `u` group by `u`.`state`,`u`.`city` */;

--
-- Final view structure for view `user_count_and_city_population`
--

/*!50001 DROP TABLE IF EXISTS `user_count_and_city_population`*/;
/*!50001 DROP VIEW IF EXISTS `user_count_and_city_population`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`dentists_webuser`@`184.195.228.%` SQL SECURITY DEFINER VIEW `user_count_and_city_population` AS select `u`.`user_count` AS `user_count`,`c`.`city_population` AS `city_population`,`c`.`city_name` AS `city_name`,`c`.`state_abbr` AS `state_abbr` from (`city_population` `c` left join `user_count` `u` on(((`c`.`state_abbr` = convert(`u`.`state` using utf8)) and (`c`.`city_name` = convert(`u`.`city` using utf8))))) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-10-21  0:46:00
