-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 05 月 05 日 21:19
-- 服务器版本: 5.5.40
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ujelly_billion-dollar-club`
--

-- --------------------------------------------------------

--
-- 表的结构 `wp_company_valuation`
--

DROP TABLE IF EXISTS `wp_company_valuation`;
CREATE TABLE IF NOT EXISTS `wp_company_valuation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `valuation` double NOT NULL DEFAULT '0',
  `valuation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `totale_quity_funding` double NOT NULL DEFAULT '0',
  `rounds_offunding` bigint(20) unsigned NOT NULL DEFAULT '0',
  `product_name` varchar(100) NOT NULL DEFAULT '',
  `oonline_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `wp_company_valuation`
--

INSERT INTO `wp_company_valuation` (`id`, `company_id`, `valuation`, `valuation_date`, `totale_quity_funding`, `rounds_offunding`, `product_name`, `oonline_date`) VALUES
(1, 1, 1, '2015-05-05 00:00:00', 1, 11, '', '2015-05-05 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
