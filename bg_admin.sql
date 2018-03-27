/*
Navicat MySQL Data Transfer

Source Server         : 虚拟机
Source Server Version : 50721
Source Host           : 66.66.66.66:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-03-27 14:59:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bg_admin
-- ----------------------------
DROP TABLE IF EXISTS `bg_admin`;
CREATE TABLE `bg_admin` (
  `admin_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(20) NOT NULL,
  `admin_pass` char(32) NOT NULL,
  `login_ip` varchar(30) NOT NULL,
  `login_nums` int(10) unsigned NOT NULL DEFAULT '0',
  `login_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of bg_admin
-- ----------------------------
INSERT INTO `bg_admin` VALUES ('1', 'admin', '25d55ad283aa400af464c76d713c07ad', '66.66.66.1', '45', '1522132416');

-- ----------------------------
-- Table structure for bg_article
-- ----------------------------
DROP TABLE IF EXISTS `bg_article`;
CREATE TABLE `bg_article` (
  `art_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) unsigned NOT NULL COMMENT '文章所属分类',
  `title` varchar(50) NOT NULL COMMENT '文章标题',
  `thumb` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `art_desc` varchar(255) DEFAULT NULL COMMENT '文章描述',
  `content` text NOT NULL COMMENT '文章内容',
  `author` varchar(20) NOT NULL COMMENT '文章作者',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `reply_nums` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `is_recommend` enum('0','1') NOT NULL DEFAULT '0',
  `is_del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  `keywords` varchar(100) NOT NULL DEFAULT 'PHP博客' COMMENT '文章关键词',
  PRIMARY KEY (`art_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_article
-- ----------------------------
INSERT INTO `bg_article` VALUES ('16', '14', '1', '20180327145318896355.png', '1', '<p>1</p>\r\n', '1', '6', '4', '1522133598', '0', '0', '');

-- ----------------------------
-- Table structure for bg_category
-- ----------------------------
DROP TABLE IF EXISTS `bg_category`;
CREATE TABLE `bg_category` (
  `cate_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(20) NOT NULL,
  `cate_pid` smallint(5) unsigned NOT NULL COMMENT '父类ID',
  `cate_sort` smallint(6) NOT NULL COMMENT '分类排序',
  `cate_desc` varchar(255) DEFAULT NULL COMMENT '分类描述',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_category
-- ----------------------------
INSERT INTO `bg_category` VALUES ('14', '1', '0', '1', '1');

-- ----------------------------
-- Table structure for bg_comment
-- ----------------------------
DROP TABLE IF EXISTS `bg_comment`;
CREATE TABLE `bg_comment` (
  `cmt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` smallint(5) unsigned DEFAULT NULL,
  `cmt_user` varchar(20) NOT NULL,
  `cmt_content` text NOT NULL,
  `cmt_time` int(10) unsigned NOT NULL,
  `cmt_status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '评论状态0未审核、1已审核、2已删除',
  PRIMARY KEY (`cmt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_comment
-- ----------------------------
INSERT INTO `bg_comment` VALUES ('36', '16', '4', 'afawefwa', '1522133733', '0');
INSERT INTO `bg_comment` VALUES ('37', '16', '4', 'faqw', '1522133820', '0');
INSERT INTO `bg_comment` VALUES ('38', '16', '4', 'fawe', '1522133838', '0');
INSERT INTO `bg_comment` VALUES ('39', '16', '4', 'fawe', '1522133854', '0');

-- ----------------------------
-- Table structure for bg_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `bg_loginlog`;
CREATE TABLE `bg_loginlog` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `login_time` int(10) unsigned NOT NULL,
  `login_ip` varchar(20) NOT NULL DEFAULT '127.0.0.1',
  `login_client` varchar(250) NOT NULL DEFAULT 'chrome',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_loginlog
-- ----------------------------
INSERT INTO `bg_loginlog` VALUES ('12', '4', '4294967295', '66.66.66.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');

-- ----------------------------
-- Table structure for bg_master
-- ----------------------------
DROP TABLE IF EXISTS `bg_master`;
CREATE TABLE `bg_master` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `job` varchar(50) NOT NULL,
  `home` varchar(50) NOT NULL,
  `tel` char(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_master
-- ----------------------------
INSERT INTO `bg_master` VALUES ('1', '站长', '执剑人', '黑暗森林', '123456789', '2270933604@qq.com');

-- ----------------------------
-- Table structure for bg_singlePage
-- ----------------------------
DROP TABLE IF EXISTS `bg_singlePage`;
CREATE TABLE `bg_singlePage` (
  `page_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_singlePage
-- ----------------------------
INSERT INTO `bg_singlePage` VALUES ('1', '单页一', '哈哈发北方13');

-- ----------------------------
-- Table structure for bg_user
-- ----------------------------
DROP TABLE IF EXISTS `bg_user`;
CREATE TABLE `bg_user` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_pass` char(32) NOT NULL,
  `user_image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `user_time` int(10) unsigned NOT NULL,
  `user_mail` varchar(50) NOT NULL DEFAULT '123@qq.com' COMMENT '用户邮箱',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bg_user
-- ----------------------------
INSERT INTO `bg_user` VALUES ('4', '12345', '25d55ad283aa400af464c76d713c07ad', 'default.jpg', '1522133681', '12');
