/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-11 16:02:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ey_about`
-- ----------------------------
DROP TABLE IF EXISTS `ey_about`;
CREATE TABLE `ey_about` (
  `abid` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  PRIMARY KEY (`abid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ey_about
-- ----------------------------
INSERT INTO `ey_about` VALUES ('1', '<p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060116017.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060116017.jpg\" style=\"\" title=\"1493177060116017.jpg\"></p><p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060299070.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060299070.jpg\" style=\"\" title=\"1493177060299070.jpg\"></p><p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060810245.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060810245.jpg\" style=\"\" title=\"1493177060810245.jpg\"></p><p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060537897.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060537897.jpg\" style=\"\" title=\"1493177060537897.jpg\"></p><p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060212878.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060212878.jpg\" style=\"\" title=\"1493177060212878.jpg\"></p><p style=\"margin-bottom: 20px;\"><img src=\"/ueditor/php/upload/image/20170426/1493177060125071.jpg\" _src=\"/ueditor/php/upload/image/20170426/1493177060125071.jpg\" style=\"\" title=\"1493177060125071.jpg\">&nbsp; &nbsp;&nbsp; <br></p>');
