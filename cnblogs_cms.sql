SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `cnblogs_cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cnblogs_cms`;

CREATE TABLE IF NOT EXISTS `cn_blogs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(300) DEFAULT '0' NOT NULL,
    `content` varchar(500) NOT NULL,
    `content_url` varchar(500) NOT NULL,
    `img_url` varchar(500) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `tittle_key` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;