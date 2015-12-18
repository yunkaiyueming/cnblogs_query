SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `cnblogs_cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cnblogs_cms`;

CREATE TABLE IF NOT EXISTS `cn_blogs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(300) NOT NULL,
    `content` varchar(500) DEFAULT '',
    `content_url` varchar(500) DEFAULT '',
    `img_url` varchar(500) DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `tittle_key` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cn_php_blogs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(300) NOT NULL,
    `content_url` varchar(400) NOT NULL,
    `recommon_num` varchar(15) DEFAULT '0',
    `comment_num` varchar(15) DEFAULT '0',
    `view_num` varchar(15) DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `tittle_key` (`title`),
    KEY `recommon_num_key` (`recommon_num`),
    KEY `view_num_key` (`view_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;