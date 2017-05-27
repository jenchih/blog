/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-05-20 16:23:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `utime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'jenchih', '$2a$10$6cea52277b0ddc2559badu/SmwUtyrqahtmQLQbBA6JA8JpWA82uO', '1', '2017-05-08 17:07:10', '2017-05-08 17:07:11');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` varchar(100) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `content` text,
  `status` tinyint(4) DEFAULT '1' COMMENT '是否显示 1显示 0 不显示',
  `utime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for article_type
-- ----------------------------
DROP TABLE IF EXISTS `article_type`;
CREATE TABLE `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `sorting` tinyint(4) DEFAULT '1' COMMENT '排序权重',
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('1', 'logo', 'http://i1.piimg.com/1949/977cee1cc8a3ec1b.jpg', '2017-05-04 18:24:16', '2017-05-04 18:24:18');
INSERT INTO `system_config` VALUES ('2', 'title', 'Jenchih Leslie`s Blog', '2017-05-20 15:04:24', '2017-05-20 15:04:28');
