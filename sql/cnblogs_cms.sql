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
    `view_type` int(4),
    PRIMARY KEY (`id`),
    KEY `tittle_key` (`title`),
    KEY `recommon_num_key` (`recommon_num`),
    KEY `view_num_key` (`view_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `douban_books` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `douban_book_id` int(11) NOT NULL COMMENT '豆瓣book_id',
    `title` varchar(100) NOT NULL,
    `url` varchar(300) NOT NULL,
    `tags` varchar(350) DEFAULT '' COMMENT '标签信息',
    `average` float(3,1) DEFAULT 0 COMMENT '评分',
    `isbn13` varchar(15) DEFAULT '' COMMENT 'isbn号',
    `author` varchar(20) DEFAULT '',
    `pubdate` varchar(10),
    `translator` varchar(30) COMMENT '译者',
    `pages` int(4) DEFAULT 0 COMMENT '书籍页数',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `douban_book_id` (`douban_book_id`),
    KEY `tittle_key` (`title`),
    KEY `tags_key` (`tags`),
    KEY `author_key` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cn_thinkphp_tuijian`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL  COMMENT '推荐内容的标题',
`title_url` varchar(100) NOT NULL COMMENT '推荐内容的URL',
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cn_kb_blogs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(300) NOT NULL,
    `content` varchar(500) DEFAULT '',
    `content_url` varchar(500) DEFAULT '',
    `kb_type` varchar(30) DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `tittle_key` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;