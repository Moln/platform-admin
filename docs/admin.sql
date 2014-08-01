/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50523
Source Host           : localhost:3306
Source Database       : platform

Target Server Type    : MYSQL
Target Server Version : 50523
File Encoding         : 65001

Date: 2013-11-11 18:12:45
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
INSERT INTO `admin_assign_role_permission` VALUES ('6', '5');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '6');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '7');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '8');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '9');
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
INSERT INTO `admin_assign_role_permission` VALUES ('6', '22');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '23');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '24');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '25');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '26');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '27');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '28');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '29');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '30');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '31');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '32');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '33');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '34');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '35');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '36');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '37');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '38');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '39');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '40');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '41');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '42');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '43');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '44');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '45');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '46');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '47');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '48');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '49');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '50');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '51');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '52');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '54');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '55');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '56');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '57');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '59');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '61');
INSERT INTO `admin_assign_role_permission` VALUES ('6', '62');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '1');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '5');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '6');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '7');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '8');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '9');
INSERT INTO `admin_assign_role_permission` VALUES ('7', '10');
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
INSERT INTO `admin_assign_user_role` VALUES ('16', '6');
INSERT INTO `admin_assign_user_role` VALUES ('17', '6');
INSERT INTO `admin_assign_user_role` VALUES ('2', '6');
INSERT INTO `admin_assign_user_role` VALUES ('2', '8');
INSERT INTO `admin_assign_user_role` VALUES ('2', '7');
INSERT INTO `admin_assign_user_role` VALUES ('16', '7');
INSERT INTO `admin_assign_user_role` VALUES ('17', '7');
INSERT INTO `admin_assign_user_role` VALUES ('1', '6');

-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `parents` varchar(250) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL,
  `per_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', null, '12', '0', '/123', '1212');
INSERT INTO `admin_menu` VALUES ('2', '0', null, '123', '0', '/123', '1212');

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_permission
-- ----------------------------
INSERT INTO `admin_permission` VALUES ('1', 'core', 'auth', 'index', 'core.auth.index');
INSERT INTO `admin_permission` VALUES ('2', 'core', 'auth', 'login', 'core.auth.login');
INSERT INTO `admin_permission` VALUES ('3', 'core', 'index', 'index', 'core.index.index');
INSERT INTO `admin_permission` VALUES ('4', 'core', 'index', 'application', 'core.index.application');
INSERT INTO `admin_permission` VALUES ('5', 'admin', 'image-browser', 'read', '图片上传-列表图片');
INSERT INTO `admin_permission` VALUES ('6', 'admin', 'image-browser', 'delete', '图片上传-删除图片');
INSERT INTO `admin_permission` VALUES ('7', 'admin', 'image-browser', 'create', '图片上传-创建文件夹');
INSERT INTO `admin_permission` VALUES ('8', 'admin', 'image-browser', 'thumbnail', 'admin.image-browser.thumbnail');
INSERT INTO `admin_permission` VALUES ('9', 'admin', 'image-browser', 'upload', 'admin.image-browser.upload');
INSERT INTO `admin_permission` VALUES ('10', 'admin', 'image-browser', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('11', 'admin', 'index', 'self', 'admin.index.self');
INSERT INTO `admin_permission` VALUES ('12', 'admin', 'index', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('13', 'admin', 'permission', 'read', 'admin.permission.read');
INSERT INTO `admin_permission` VALUES ('14', 'admin', 'permission', 'save', 'admin.permission.save');
INSERT INTO `admin_permission` VALUES ('15', 'admin', 'permission', 'init', '初始化权限');
INSERT INTO `admin_permission` VALUES ('16', 'admin', 'permission', 'assign', '角色权限分配');
INSERT INTO `admin_permission` VALUES ('17', 'admin', 'permission', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('18', 'admin', 'role', 'read', 'admin.role.read');
INSERT INTO `admin_permission` VALUES ('19', 'admin', 'role', 'save', 'admin.role.save');
INSERT INTO `admin_permission` VALUES ('20', 'admin', 'role', 'delete', 'admin.role.delete');
INSERT INTO `admin_permission` VALUES ('21', 'admin', 'role', 'assign-permission', 'admin.role.assign-permission');
INSERT INTO `admin_permission` VALUES ('22', 'admin', 'role', 'assign-user', 'admin.role.assign-user');
INSERT INTO `admin_permission` VALUES ('23', 'admin', 'role', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('24', 'admin', 'user', 'read', 'admin.user.read');
INSERT INTO `admin_permission` VALUES ('25', 'admin', 'user', 'save', 'admin.user.save');
INSERT INTO `admin_permission` VALUES ('26', 'admin', 'user', 'delete', 'admin.user.delete');
INSERT INTO `admin_permission` VALUES ('27', 'admin', 'user', 'assign', 'admin.user.assign');
INSERT INTO `admin_permission` VALUES ('28', 'admin', 'user', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('29', 'shop', 'category', 'read', 'shop.category.read');
INSERT INTO `admin_permission` VALUES ('30', 'shop', 'category', 'save', 'shop.category.save');
INSERT INTO `admin_permission` VALUES ('31', 'shop', 'category', 'delete', 'shop.category.delete');
INSERT INTO `admin_permission` VALUES ('32', 'shop', 'category', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('33', 'shop', 'express', 'read', 'shop.express.read');
INSERT INTO `admin_permission` VALUES ('34', 'shop', 'express', 'save', 'shop.express.save');
INSERT INTO `admin_permission` VALUES ('35', 'shop', 'express', 'delete', 'shop.express.delete');
INSERT INTO `admin_permission` VALUES ('36', 'shop', 'express', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('37', 'shop', 'game-category', 'read', 'shop.game-category.read');
INSERT INTO `admin_permission` VALUES ('38', 'shop', 'game-category', 'save', 'shop.game-category.save');
INSERT INTO `admin_permission` VALUES ('39', 'shop', 'game-category', 'delete', 'shop.game-category.delete');
INSERT INTO `admin_permission` VALUES ('40', 'shop', 'game-category', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('41', 'shop', 'goods', 'read', 'shop.goods.read');
INSERT INTO `admin_permission` VALUES ('42', 'shop', 'goods', 'save', 'shop.goods.save');
INSERT INTO `admin_permission` VALUES ('43', 'shop', 'goods', 'delete', 'shop.goods.delete');
INSERT INTO `admin_permission` VALUES ('44', 'shop', 'goods', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('45', 'shop', 'index', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('46', 'shop', 'order', 'index', 'shop.order.index');
INSERT INTO `admin_permission` VALUES ('47', 'shop', 'order', 'read', 'shop.order.read');
INSERT INTO `admin_permission` VALUES ('48', 'shop', 'order', 'save', 'shop.order.save');
INSERT INTO `admin_permission` VALUES ('49', 'shop', 'order', 'close', 'shop.order.close');
INSERT INTO `admin_permission` VALUES ('50', 'shop', 'virtual-data', 'index', 'shop.virtual-data.index');
INSERT INTO `admin_permission` VALUES ('51', 'shop', 'virtual-data', 'read', 'shop.virtual-data.read');
INSERT INTO `admin_permission` VALUES ('52', 'shop', 'virtual-data', 'remove-unused', 'shop.virtual-data.remove-unused');
INSERT INTO `admin_permission` VALUES ('54', 'shop', 'virtual-data', 'file-remove', 'shop.virtual-data.file-remove');
INSERT INTO `admin_permission` VALUES ('55', 'user', 'index', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('56', 'payment', 'index', 'index', 'Default action if none provided');
INSERT INTO `admin_permission` VALUES ('57', 'admin', 'menu', 'index', 'admin.menu.index');
INSERT INTO `admin_permission` VALUES ('59', 'admin', 'menu', 'save', 'admin.menu.save');
INSERT INTO `admin_permission` VALUES ('61', 'shop', 'virtual-data', 'import', 'shop.virtual-data.import');
INSERT INTO `admin_permission` VALUES ('62', 'admin', 'permission', 'query', 'admin.permission.query');

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112', '1', 'administrator', 'admin@admin.com');
