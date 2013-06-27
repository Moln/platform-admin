/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50523
Source Host           : localhost:3306
Source Database       : platform

Target Server Type    : MYSQL
Target Server Version : 50523
File Encoding         : 65001

Date: 2013-06-27 17:22:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_assign_role_permission`
-- ----------------------------
DROP TABLE IF EXISTS `admin_assign_role_permission`;
CREATE TABLE `admin_assign_role_permission` (
  `role_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_assign_role_permission
-- ----------------------------
INSERT INTO `admin_assign_role_permission` VALUES ('2', '2');
INSERT INTO `admin_assign_role_permission` VALUES ('3', '2');
INSERT INTO `admin_assign_role_permission` VALUES ('4', '2');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '1');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '2');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '3');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '4');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '7');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '10');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '11');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '12');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '13');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '14');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '15');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '16');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '17');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '18');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '19');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '20');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '21');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '25');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '1');
INSERT INTO `admin_assign_role_permission` VALUES ('8', '1');
INSERT INTO `admin_assign_role_permission` VALUES ('9', '1');

-- ----------------------------
-- Table structure for `admin_assign_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_assign_user_role`;
CREATE TABLE `admin_assign_user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_assign_user_role
-- ----------------------------
INSERT INTO `admin_assign_user_role` VALUES ('2', '7');
INSERT INTO `admin_assign_user_role` VALUES ('1', '7');
INSERT INTO `admin_assign_user_role` VALUES ('1', '6');
INSERT INTO `admin_assign_user_role` VALUES ('2', '6');
INSERT INTO `admin_assign_user_role` VALUES ('15', '6');
INSERT INTO `admin_assign_user_role` VALUES ('16', '6');
INSERT INTO `admin_assign_user_role` VALUES ('17', '6');

-- ----------------------------
-- Table structure for `admin_permission`
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission`;
CREATE TABLE `admin_permission` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `controller` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`per_id`),
  UNIQUE KEY `action` (`module`,`controller`,`action`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_permission
-- ----------------------------
INSERT INTO `admin_permission` VALUES ('1', 'Application', 'Auth', 'index', 'aaabbb22');
INSERT INTO `admin_permission` VALUES ('2', 'Application', 'Auth', 'login', 'aaaApplication.Auth.login');
INSERT INTO `admin_permission` VALUES ('3', 'Application', 'Index', 'index', 'Application.Index.index');
INSERT INTO `admin_permission` VALUES ('4', 'Application', 'Index', 'test', 'Application.Index.test');
INSERT INTO `admin_permission` VALUES ('7', 'System', 'Index', 'index', 'System.Index.index');
INSERT INTO `admin_permission` VALUES ('10', 'System', 'Permission', 'read', 'System.Permission.read');
INSERT INTO `admin_permission` VALUES ('11', 'System', 'Permission', 'save', 'System.Permission.save');
INSERT INTO `admin_permission` VALUES ('12', 'System', 'Permission', 'init', '初始化权限');
INSERT INTO `admin_permission` VALUES ('13', 'System', 'Permission', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('14', 'System', 'Role', 'read', 'System.Role.read');
INSERT INTO `admin_permission` VALUES ('15', 'System', 'Role', 'save', 'System.Role.save');
INSERT INTO `admin_permission` VALUES ('16', 'System', 'Role', 'delete', 'System.Role.delete');
INSERT INTO `admin_permission` VALUES ('17', 'System', 'Role', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('18', 'System', 'User', 'read', 'System.User.read');
INSERT INTO `admin_permission` VALUES ('19', 'System', 'User', 'save', 'System.User.save');
INSERT INTO `admin_permission` VALUES ('20', 'System', 'User', 'delete', 'System.User.delete');
INSERT INTO `admin_permission` VALUES ('21', 'System', 'User', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('25', 'System', 'Permission', 'assign', '角色权限分配');
INSERT INTO `admin_permission` VALUES ('26', 'System', 'Index', 'self', 'System.Index.self');
INSERT INTO `admin_permission` VALUES ('27', 'System', 'Role', 'assignPermission', 'System.Role.assignPermission');
INSERT INTO `admin_permission` VALUES ('28', 'System', 'Role', 'assignUser', 'System.Role.assignUser');
INSERT INTO `admin_permission` VALUES ('29', 'System', 'User', 'assign', 'System.User.assign');

-- ----------------------------
-- Table structure for `admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('6', 'Administrators', null);
INSERT INTO `admin_role` VALUES ('7', 'Phpers', null);
INSERT INTO `admin_role` VALUES ('8', 'Testers', null);
INSERT INTO `admin_role` VALUES ('9', 'Guest', null);
INSERT INTO `admin_role` VALUES ('10', 'Test233', null);
INSERT INTO `admin_role` VALUES ('11', 'test334', null);
INSERT INTO `admin_role` VALUES ('12', 'test455', null);

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `real_name` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112', '0', 'administrator', 'admin@admin.com');
INSERT INTO `admin_user` VALUES ('2', 'test', '111111', '0', 'test', 'test@test.com');
INSERT INTO `admin_user` VALUES ('15', 'test2', 'e3ceb5881a0a1fdaad01296d7554868d', '0', '张三', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('16', 'test3', '4297f44b13955235245b2497399d7a93', '0', '张三', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('17', 'dfsdfs', '96e79218965eb72c92a549dd5a330112', '0', '张三', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('21', 'test4', '96e79218965eb72c92a549dd5a330112', '0', '张三', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('22', 'test5', 'e3ceb5881a0a1fdaad01296d7554868d', '0', '张三2', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('23', 'test6', '96e79218965eb72c92a549dd5a330112', '0', '张三', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('24', 'test7', '96e79218965eb72c92a549dd5a330112', '0', 'test7', 'xiemaomao520@163.com');
INSERT INTO `admin_user` VALUES ('25', 'test8', '96e79218965eb72c92a549dd5a330112', '0', '11212', '19177707182@qq.com');
