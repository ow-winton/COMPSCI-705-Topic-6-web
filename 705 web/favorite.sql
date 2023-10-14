/*
Navicat MySQL Data Transfer

Source Server         : sss
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : 112

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2023-10-13 18:22:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for favorite
-- ----------------------------
DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of favorite
-- ----------------------------
INSERT INTO `favorite` VALUES ('5', '5', '3');
INSERT INTO `favorite` VALUES ('4', '1', '3');

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('5', '11696753594.txt', 'uploads/11696753594.txt', '3', '2023-10-08 16:26:34', null);
INSERT INTO `files` VALUES ('4', '11696751408.txt', 'uploads/11696751408.txt', '3', '2023-10-08 15:50:08', null);
INSERT INTO `files` VALUES ('6', '21697185281.png', 'uploads/21697185281.png', '3', '2023-10-13 16:21:21', '2');
INSERT INTO `files` VALUES ('7', '21697187177.png', 'uploads/21697187177.png', '3', '2023-10-13 16:52:57', '2');
