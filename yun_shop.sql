SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `yun_shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yun_shop`;

CREATE TABLE IF NOT EXISTS `goods` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `goods_num` varchar(20) NOT NULL COMMENT '商品编号',
    `goods_name` varchar(300) NOT NULL COMMENT '商品名称',  
    `goods_price` float(20) DEFAULT 0 COMMENT '商品价格',
    `type_id` int(11) NOT NULL COMMENT '商品分类ID',
    `label_ids` varchar(20) COMMENT '商品标签',
    `goods_order` int(11) DEFAULT 0 COMMENT '商品排序字段',
    `is_hot` int(1)  DEFAULT 0 COMMENT '是否热卖',
    `is_advice` int(1)  DEFAULT 0 COMMENT '是否推荐',
    `create_time` datetime NOT NULL COMMENT '创建时间',
    `goods_exist_num` int(11) NOT NULL COMMENT '库存数量',
    `memo` varchar(200),
    PRIMARY KEY (`id`),
    UNIQUE KEY `goods_num_key` (`goods_num`),
    KEY `goods_order_key` (`goods_order`),
    KEY `goods_name_key` (`goods_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `goods_type`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(15) NOT NULL  COMMENT '商品分类名称',
`type_des` varchar(100) NOT NULL COMMENT '商品分类描述',
`fid` int(11) NOT NULL COMMENT '父类',
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(15) NOT NULL,
    `user_pwd` varchar(15) NOT NULL,
    `user_mail` varchar(15) DEFAULT '',
    `user_phone` varchar(15) NOT NULL,
    `real_name` varchar(15) NOT NULL,
    `create_time`
    `level`
    `status`
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `address` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL ,
    `sheng` varchar(15) NOT NULL,
    `shi` varchar(15) NOT NULL,
    `xian` varchar(15) NOT NULL,
    `jiedao` varchar(15) NOT NULL
    PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `shop_car`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`goods_id` int(11) NOT NULL  COMMENT '商品ID',
`user_id` int(11) NOT NULL  COMMENT '用户ID'
`goods_num` int(11) Not null DEFAULT 1
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `orders`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`order_num` varchar(40) NOT NULL COMMENT '订单号'
`order_time` date NOT NULL  COMMENT '订单时间',
`order_status` varchar(10) NOT NULL COMMENT '订单状态',
`user_id` int(11) NOT NULL  COMMENT '用户ID',
`address_id` int(11) NOT NULL COMMENT '收货地址ID',
`price_sum` float(20) NOT null COMMENT '总金额',
`pay_id` int(11) NOT NULL COMMENT '付款方式',
`transfer_id` int(11) NOT NULL COMMENT '物流公司',
`emsn_num` varchar(10) NOT NULL COMMENT '物流号'
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `orders_detail`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`orders_id` int(11) NOT NULL,
`goods_id`  int(11) NOT NULL,
`goods_num` int(11) NOT NULL  COMMENT '商品数量',
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `label`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`label_name` varchar(10) NOT NULL,
`label_des`  varchar(15) NOT NULL
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `friend_link`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`friend_link_url` varchar(30) NOT NULL COMMENT '友情链接url'
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `pay`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`pay_type` varchar(30) NOT NULL COMMENT '支付方式'
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `transfer`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`transfer_type` varchar(30) NOT NULL COMMENT '物流方式',
 PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*
ToDo_List:
补全用户表字段，地址表中字段用英文，在相应的表中要考虑加入create_time
*/