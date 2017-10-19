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

USE `dentists_dsusa_site`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `salt` varchar(255) default NULL,
  `level` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_advertisements`
--

DROP TABLE IF EXISTS `admin_advertisements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_advertisements` (
  `id` int(11) NOT NULL auto_increment,
  `image` varchar(255) default NULL,
  `title` varchar(64) default NULL,
  `text` varchar(255) default NULL,
  `links` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `order` int(11) default NULL,
  `use_default` int(11) default NULL,
  `align` enum('left','right') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_email_templates`
--

DROP TABLE IF EXISTS `admin_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_email_templates` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) default NULL,
  `content` text,
  `type` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_inquiries`
--

DROP TABLE IF EXISTS `admin_inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_inquiries` (
  `id` int(18) NOT NULL auto_increment,
  `name` varchar(150) default NULL,
  `email` varchar(150) default NULL,
  `message` text,
  `date` varchar(150) default NULL,
  `is_dentist` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_privileges`
--

DROP TABLE IF EXISTS `admin_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_privileges` (
  `id` int(11) NOT NULL auto_increment,
  `privilege_id` int(11) default NULL,
  `admin_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_profiles`
--

DROP TABLE IF EXISTS `admin_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_profiles` (
  `id` int(255) NOT NULL auto_increment,
  `user_id` text NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `photo` text NOT NULL,
  `st` text NOT NULL,
  `town` text NOT NULL,
  `city` text NOT NULL,
  `zipcode` text NOT NULL,
  `state_id` text NOT NULL,
  `telno` text NOT NULL,
  `emailaddress` text NOT NULL,
  `website` text NOT NULL,
  `shortbio` text NOT NULL,
  `ofchrs` text NOT NULL,
  `promos` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_seo_tags`
--

DROP TABLE IF EXISTS `admin_seo_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_seo_tags` (
  `id` int(11) NOT NULL auto_increment,
  `page` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` text,
  `content` text,
  `editable_content` int(11) default NULL,
  `content_only` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_setting_choices`
--

DROP TABLE IF EXISTS `admin_setting_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_setting_choices` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_setting_privileges`
--

DROP TABLE IF EXISTS `admin_setting_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_setting_privileges` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL auto_increment,
  `analytics_id` varchar(255) default NULL,
  `search_result_text` varchar(255) default NULL,
  `footer_tags` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_social_media_icons`
--

DROP TABLE IF EXISTS `admin_social_media_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_social_media_icons` (
  `id` int(11) NOT NULL auto_increment,
  `icon` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `tooltip` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM */;
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
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `cms_patients`
--

DROP TABLE IF EXISTS `cms_patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_patients` (
  `id` int(11) NOT NULL auto_increment,
  `caller_name` varchar(255) default NULL,
  `dental_emergency` varchar(1) default NULL,
  `phone` varchar(255) default NULL,
  `pain_level` varchar(2) default NULL,
  `patient_name` varchar(255) default NULL,
  `dentist_assigned_to` int(11) default NULL,
  `fear_of_dentist` varchar(1) default NULL,
  `last_appointment_date` date default NULL,
  `birth_day` date default NULL,
  `address` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `zip` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `notes` text,
  `office_contact` varchar(255) default NULL,
  `author_added` int(255) default NULL,
  `author_updated` int(255) default NULL,
  `added` datetime default NULL,
  `updated` datetime default NULL,
  `pdf_file` varchar(255) default NULL,
  `appointment_date` date default NULL,
  `appointment_time` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `login` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `salt` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_articles`
--

DROP TABLE IF EXISTS `content_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_articles` (
  `id` int(18) NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `summary` text,
  `content` text,
  `image` varchar(200) default NULL,
  `author` varchar(200) default NULL,
  `date` date default NULL,
  `category_id` int(18) NOT NULL,
  `tags` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`,`summary`,`content`,`tags`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_categories`
--

DROP TABLE IF EXISTS `content_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_categories` (
  `id` int(18) NOT NULL auto_increment,
  `category_title` varchar(200) default NULL,
  `description` text,
  `type` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_videos`
--

DROP TABLE IF EXISTS `content_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_videos` (
  `id` int(18) NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `size` varchar(150) default NULL,
  `summary` text,
  `date` date default NULL,
  `tags` text,
  `image` varchar(150) default NULL,
  `filename` varchar(150) default NULL,
  `category_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`,`summary`,`tags`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_cities`
--

DROP TABLE IF EXISTS `data_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_cities` (
  `id` int(11) NOT NULL auto_increment,
  `city_name` varchar(40) character set utf8 default NULL,
  `state_abbr` varchar(2) character set utf8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29829 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_dentists_raw_distinct`
--

DROP TABLE IF EXISTS `data_dentists_raw_distinct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_dentists_raw_distinct` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `first_name` varchar(255) default NULL,
  `last_name` varchar(255) default NULL,
  `middle_initial` varchar(255) default NULL,
  `post_nominal` varchar(255) default NULL,
  `name` text,
  `company_name` text,
  `bio` text,
  `address` text,
  `city` text,
  `state` text,
  `zip` text,
  `phone` text,
  `login_email` varchar(255) default NULL,
  `email` text,
  `website` text,
  `monday` text,
  `tuesday` text,
  `wednesday` text,
  `thursday` text,
  `friday` text,
  `saturday` text,
  `sunday` text,
  `qualifications` text,
  `certifications` text,
  `specialties` text,
  `promotion_titles` text,
  `promotion_descriptions` text,
  `promo_codes` text,
  `prof_pic` varchar(255) default NULL,
  `dentist_image` text,
  `dentist_description_image` text,
  `other_images` text,
  `before_and_after` text,
  `source_file` varchar(255) default NULL,
  `valid_city` int(11) default NULL,
  `valid_zip` int(11) default NULL,
  `valid_state` int(11) default NULL,
  `valid_email` int(11) default NULL,
  `valid_website` int(11) default NULL,
  `valid_name` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=946 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_locations`
--

DROP TABLE IF EXISTS `data_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_locations` (
  `id` int(11) NOT NULL auto_increment,
  `zip_code` char(5) character set utf8 default NULL,
  `city_name` varchar(40) character set utf8 default NULL,
  `state_abbr` varchar(2) character set utf8 default NULL,
  `state_long` varchar(45) default NULL,
  `longitude` float default NULL,
  `latitude` float default NULL,
  `elevation` smallint(6) default NULL,
  `population` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `zip_code` (`zip_code`),
  FULLTEXT KEY `city_name` (`city_name`),
  FULLTEXT KEY `state_abbr` (`state_abbr`)
) ENGINE=MyISAM AUTO_INCREMENT=42487 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_states`
--

DROP TABLE IF EXISTS `data_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_states` (
  `id` int(11) NOT NULL auto_increment,
  `state_abbr` varchar(2) character set utf8 default NULL,
  `state_long` varchar(45) default NULL,
  `disabled` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_plan_types`
--

DROP TABLE IF EXISTS `payment_plan_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_plan_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `is_recurring` int(11) default NULL,
  `recurring_type` varchar(255) default NULL,
  `recurring_cycles` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_plans`
--

DROP TABLE IF EXISTS `payment_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_plans` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) default NULL,
  `initial_payment` int(11) default NULL,
  `recurring_payment` int(11) default NULL,
  `name` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paypal_transactions`
--

DROP TABLE IF EXISTS `paypal_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paypal_transactions` (
  `entryID` int(11) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `results` varchar(255) NOT NULL,
  `timestamp` int(14) NOT NULL,
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
  `user_id` int(11),
  `total_votes` bigint(21)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_accounts` (
  `id` int(255) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `plan_id` int(11) default NULL,
  `status` int(11) default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_appointments`
--

DROP TABLE IF EXISTS `user_appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_appointments` (
  `id` int(18) NOT NULL auto_increment,
  `appointment` varchar(150) default NULL,
  `name` varchar(255) default NULL,
  `age` varchar(50) default NULL,
  `oral_health` varchar(150) default NULL,
  `last_visit` date default NULL,
  `app_date` date default NULL,
  `app_time` varchar(50) default NULL,
  `email` varchar(150) default NULL,
  `telephone` varchar(150) default NULL,
  `mobile` varchar(150) default NULL,
  `comments` text,
  `pid` int(18) default NULL,
  `is_read` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_certifications`
--

DROP TABLE IF EXISTS `user_certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_certifications` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) default NULL,
  `path` varchar(255) default NULL,
  `group` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_company_info`
--

DROP TABLE IF EXISTS `user_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_company_info` (
  `id` int(11) NOT NULL auto_increment,
  `company_name` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `zip` varchar(25) default NULL,
  `telephone` varchar(25) default NULL,
  `dsusa_telephone` varchar(55) default NULL,
  `website` varchar(255) default NULL,
  `company_email` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `zip` (`zip`)
) ENGINE=MyISAM AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM */;
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
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_dashboard_info`
--

DROP TABLE IF EXISTS `user_dashboard_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_dashboard_info` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `promotional` text,
  `documents_intro` text,
  `gallery_intro` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_events`
--

DROP TABLE IF EXISTS `user_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_events` (
  `id` int(18) NOT NULL auto_increment,
  `message` text,
  `note` varchar(150) default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `user_id` int(18) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_files`
--

DROP TABLE IF EXISTS `user_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_files` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) default NULL,
  `path` varchar(255) default NULL,
  `group` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_images`
--

DROP TABLE IF EXISTS `user_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_images` (
  `id` int(11) NOT NULL auto_increment,
  `path` varchar(255) default NULL,
  `filename` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_personal_info`
--

DROP TABLE IF EXISTS `user_personal_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_personal_info` (
  `id` int(11) NOT NULL auto_increment,
  `post_nominal` varchar(25) default NULL,
  `first_name` varchar(55) default NULL,
  `last_name` varchar(55) default NULL,
  `bio` text,
  `mobile_number` varchar(55) default NULL,
  `user_id` int(11) default NULL,
  `prof_pic` varchar(150) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  FULLTEXT KEY `last_name` (`last_name`)
) ENGINE=MyISAM AUTO_INCREMENT=922 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_pre_registrations`
--

DROP TABLE IF EXISTS `user_pre_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_pre_registrations` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `interested_in` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_promotionals`
--

DROP TABLE IF EXISTS `user_promotionals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_promotionals` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `code` varchar(255) default NULL,
  `description` text,
  `file_path` varchar(255) default NULL,
  `file` varchar(255) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_reviews`
--

DROP TABLE IF EXISTS `user_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `website` varchar(255) default NULL,
  `message` text,
  `rating` float default NULL,
  `user_id` int(11) default NULL,
  `date` date default NULL,
  `is_read` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_schedules`
--

DROP TABLE IF EXISTS `user_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_schedules` (
  `id` int(18) NOT NULL auto_increment,
  `day` varchar(50) default NULL,
  `login` varchar(50) default NULL,
  `break_in` varchar(50) default NULL,
  `break_out` varchar(50) default NULL,
  `logout` varchar(50) default NULL,
  `order` int(10) default NULL,
  `user_id` int(18) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_specialties`
--

DROP TABLE IF EXISTS `user_specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_specialties` (
  `id` int(11) NOT NULL auto_increment,
  `specialty_id` int(11) default NULL,
  `specialty_text` text,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_specialty_categories`
--

DROP TABLE IF EXISTS `user_specialty_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_specialty_categories` (
  `id` int(18) NOT NULL auto_increment,
  `specialty_title` varchar(200) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_statistics`
--

DROP TABLE IF EXISTS `user_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `page_view` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=923 DEFAULT CHARSET=latin1;
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
