-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: platform-admin
-- ------------------------------------------------------
-- Server version	5.6.17-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_assign_role_permission`
--

DROP TABLE IF EXISTS `admin_assign_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_assign_role_permission` (
  `role_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_assign_role_permission`
--

LOCK TABLES `admin_assign_role_permission` WRITE;
/*!40000 ALTER TABLE `admin_assign_role_permission` DISABLE KEYS */;
INSERT INTO `admin_assign_role_permission` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37);
/*!40000 ALTER TABLE `admin_assign_role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_assign_user_role`
--

DROP TABLE IF EXISTS `admin_assign_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_assign_user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_assign_user_role`
--

LOCK TABLES `admin_assign_user_role` WRITE;
/*!40000 ALTER TABLE `admin_assign_user_role` DISABLE KEYS */;
INSERT INTO `admin_assign_user_role` VALUES (1,1);
/*!40000 ALTER TABLE `admin_assign_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `parents` varchar(250) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL,
  `per_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_operation_log`
--

DROP TABLE IF EXISTS `admin_operation_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_operation_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uri` text NOT NULL,
  `param` text,
  `method` varchar(10) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COMMENT='操作日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_operation_log`
--

LOCK TABLES `admin_operation_log` WRITE;
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;
INSERT INTO `admin_operation_log` VALUES (1,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:34:40',1),(2,'admin.menu.index','{\"get\":{\"_\":\"1413279280699\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:35:29',1),(3,'admin.menu.save','{\"get\":[],\"post\":{\"data\":\"[{\\\"text\\\":\\\"\\u7cfb\\u7edf\\\",\\\"index\\\":0,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u7528\\u6237\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/admin\\/user\\\",\\\"permission\\\":\\\"admin.user.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":818}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"url\\\":\\\".\\/admin\\/role\\\",\\\"permission\\\":\\\"admin.role.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u6743\\u9650\\u7ba1\\u7406\\\",\\\"index\\\":2,\\\"url\\\":\\\".\\/admin\\/permission\\\",\\\"permission\\\":\\\"admin.permission.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":1096}\\\"},{\\\"text\\\":\\\"\\u83dc\\u5355\\u7ba1\\u7406\\\",\\\"index\\\":3,\\\"url\\\":\\\".\\/admin\\/menu\\\",\\\"permission\\\":\\\"admin.menu.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"height\\\\\\\":700}\\\"},{\\\"text\\\":\\\"\\u4e2a\\u4eba\\u4fe1\\u606f\\\",\\\"index\\\":4,\\\"url\\\":\\\".\\/admin\\/index\\/self\\\",\\\"permission\\\":\\\"admin.index.self\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u5173\\u7cfb\\\",\\\"index\\\":5,\\\"url\\\":\\\".\\/admin\\/role\\/trees\\\",\\\"permission\\\":\\\"admin.role.trees\\\"},{\\\"text\\\":\\\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\\",\\\"index\\\":6,\\\"url\\\":\\\".\\/admin\\/operation-log\\/list\\\",\\\"permission\\\":\\\"admin.operation-log.list\\\"}]}]\"},\"route\":[]}','POST',0,'2014-10-14 09:35:40',1),(4,'admin.permission.index','{\"get\":{\"_\":\"1413279280700\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:35:51',1),(5,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:35:51',1),(6,'admin.permission.init','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:35:55',1),(7,'admin.menu.index','{\"get\":{\"_\":\"1413279280701\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:45:28',1),(8,'admin.permission.init','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:45:55',1),(9,'admin.permission.index','{\"get\":{\"_\":\"1413279280702\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:46:10',1),(10,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:46:10',1),(11,'admin.role.index','{\"get\":{\"_\":\"1413279280703\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:46:16',1),(12,'admin.role.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:46:16',1),(13,'admin.role.assign-permission','{\"get\":{\"_\":\"1413279280704\"},\"post\":[],\"route\":{\"id\":\"1\"}}','GET',0,'2014-10-14 09:46:24',1),(14,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:46:25',1),(15,'admin.role.assign-permission','{\"get\":[],\"post\":{\"per_id\":[\"1\",\"2\",\"3\",\"5\",\"7\",\"8\",\"9\",\"4\",\"6\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"30\",\"23\",\"25\",\"26\",\"27\",\"28\",\"29\",\"24\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\"]},\"route\":{\"id\":\"1\"}}','POST',0,'2014-10-14 09:46:37',1),(16,'admin.role.assign-user','{\"get\":{\"_\":\"1413279280705\"},\"post\":[],\"route\":{\"id\":\"1\"}}','GET',0,'2014-10-14 09:46:42',1),(17,'admin.user.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:46:43',1),(18,'admin.role.index','{\"get\":{\"_\":\"1413279280706\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:47:57',1),(19,'admin.role.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:47:57',1),(20,'admin.role.assign-permission','{\"get\":{\"_\":\"1413279280707\"},\"post\":[],\"route\":{\"id\":\"1\"}}','GET',0,'2014-10-14 09:48:00',1),(21,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:48:00',1),(22,'admin.role.assign-user','{\"get\":{\"_\":\"1413279280708\"},\"post\":[],\"route\":{\"id\":\"1\"}}','GET',0,'2014-10-14 09:48:02',1),(23,'admin.user.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:48:03',1),(24,'admin.user.index','{\"get\":{\"_\":\"1413279280709\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:48:08',1),(25,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:48:09',1),(26,'admin.user.save','{\"get\":[],\"post\":{\"user_id\":\"1\",\"account\":\"admin\",\"real_name\":\"administrator\",\"email\":\"admin@admin.com\",\"status\":\"0\"},\"route\":[]}','POST',0,'2014-10-14 09:48:19',1),(27,'admin.user.save','{\"get\":[],\"post\":{\"user_id\":\"2\",\"account\":\"test\",\"real_name\":\"Test\",\"email\":\"test@test.com\",\"status\":\"0\"},\"route\":[]}','POST',0,'2014-10-14 09:48:27',1),(28,'admin.user.assign','{\"get\":{\"_\":\"1413279280710\"},\"post\":[],\"route\":{\"id\":\"2\"}}','GET',0,'2014-10-14 09:48:30',1),(29,'admin.role.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:48:31',1),(30,'admin.role.index','{\"get\":{\"_\":\"1413279280711\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:48:35',1),(31,'admin.role.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 09:48:36',1),(32,'admin.menu.index','{\"get\":{\"_\":\"1413279280712\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:49:12',1),(33,'admin.permission.query','{\"get\":[],\"post\":{\"url\":\"\\/product\"},\"route\":[]}','POST',0,'2014-10-14 09:49:24',1),(34,'admin.menu.save','{\"get\":[],\"post\":{\"data\":\"[{\\\"text\\\":\\\"\\u7cfb\\u7edf\\\",\\\"index\\\":0,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u7528\\u6237\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/admin\\/user\\\",\\\"permission\\\":\\\"admin.user.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":818}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"url\\\":\\\".\\/admin\\/role\\\",\\\"permission\\\":\\\"admin.role.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u6743\\u9650\\u7ba1\\u7406\\\",\\\"index\\\":2,\\\"url\\\":\\\".\\/admin\\/permission\\\",\\\"permission\\\":\\\"admin.permission.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":1096}\\\"},{\\\"text\\\":\\\"\\u83dc\\u5355\\u7ba1\\u7406\\\",\\\"index\\\":3,\\\"url\\\":\\\".\\/admin\\/menu\\\",\\\"permission\\\":\\\"admin.menu.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"height\\\\\\\":700}\\\"},{\\\"text\\\":\\\"\\u4e2a\\u4eba\\u4fe1\\u606f\\\",\\\"index\\\":4,\\\"url\\\":\\\".\\/admin\\/index\\/self\\\",\\\"permission\\\":\\\"admin.index.self\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u5173\\u7cfb\\\",\\\"index\\\":5,\\\"url\\\":\\\".\\/admin\\/role\\/trees\\\",\\\"permission\\\":\\\"admin.role.trees\\\"},{\\\"text\\\":\\\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\\",\\\"index\\\":6,\\\"url\\\":\\\".\\/admin\\/operation-log\\/list\\\",\\\"permission\\\":\\\"admin.operation-log.list\\\"}]},{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"url\\\":\\\"\\/product\\\",\\\"permission\\\":\\\"product.index.index\\\",\\\"index\\\":1}]\"},\"route\":[]}','POST',0,'2014-10-14 09:49:30',1),(35,'admin.permission.query','{\"get\":[],\"post\":{\"url\":\"\"},\"route\":[]}','POST',0,'2014-10-14 09:49:37',1),(36,'admin.menu.save','{\"get\":[],\"post\":{\"data\":\"[{\\\"text\\\":\\\"\\u7cfb\\u7edf\\\",\\\"index\\\":0,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u7528\\u6237\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/admin\\/user\\\",\\\"permission\\\":\\\"admin.user.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":818}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"url\\\":\\\".\\/admin\\/role\\\",\\\"permission\\\":\\\"admin.role.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u6743\\u9650\\u7ba1\\u7406\\\",\\\"index\\\":2,\\\"url\\\":\\\".\\/admin\\/permission\\\",\\\"permission\\\":\\\"admin.permission.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":1096}\\\"},{\\\"text\\\":\\\"\\u83dc\\u5355\\u7ba1\\u7406\\\",\\\"index\\\":3,\\\"url\\\":\\\".\\/admin\\/menu\\\",\\\"permission\\\":\\\"admin.menu.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"height\\\\\\\":700}\\\"},{\\\"text\\\":\\\"\\u4e2a\\u4eba\\u4fe1\\u606f\\\",\\\"index\\\":4,\\\"url\\\":\\\".\\/admin\\/index\\/self\\\",\\\"permission\\\":\\\"admin.index.self\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u5173\\u7cfb\\\",\\\"index\\\":5,\\\"url\\\":\\\".\\/admin\\/role\\/trees\\\",\\\"permission\\\":\\\"admin.role.trees\\\"},{\\\"text\\\":\\\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\\",\\\"index\\\":6,\\\"url\\\":\\\".\\/admin\\/operation-log\\/list\\\",\\\"permission\\\":\\\"admin.operation-log.list\\\"}]},{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"url\\\":\\\"\\\",\\\"permission\\\":\\\"\\\",\\\"index\\\":1,\\\"selected\\\":true,\\\"attributes\\\":\\\"\\\"}]\"},\"route\":[]}','POST',0,'2014-10-14 09:49:41',1),(37,'admin.permission.query','{\"get\":[],\"post\":{\"url\":\"\"},\"route\":[]}','POST',0,'2014-10-14 09:49:55',1),(38,'admin.permission.query','{\"get\":[],\"post\":{\"url\":\"\\/product\"},\"route\":[]}','POST',0,'2014-10-14 09:49:58',1),(39,'admin.menu.save','{\"get\":[],\"post\":{\"data\":\"[{\\\"text\\\":\\\"\\u7cfb\\u7edf\\\",\\\"index\\\":0,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u7528\\u6237\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/admin\\/user\\\",\\\"permission\\\":\\\"admin.user.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":818}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"url\\\":\\\".\\/admin\\/role\\\",\\\"permission\\\":\\\"admin.role.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u6743\\u9650\\u7ba1\\u7406\\\",\\\"index\\\":2,\\\"url\\\":\\\".\\/admin\\/permission\\\",\\\"permission\\\":\\\"admin.permission.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":1096}\\\"},{\\\"text\\\":\\\"\\u83dc\\u5355\\u7ba1\\u7406\\\",\\\"index\\\":3,\\\"url\\\":\\\".\\/admin\\/menu\\\",\\\"permission\\\":\\\"admin.menu.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"height\\\\\\\":700}\\\"},{\\\"text\\\":\\\"\\u4e2a\\u4eba\\u4fe1\\u606f\\\",\\\"index\\\":4,\\\"url\\\":\\\".\\/admin\\/index\\/self\\\",\\\"permission\\\":\\\"admin.index.self\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u5173\\u7cfb\\\",\\\"index\\\":5,\\\"url\\\":\\\".\\/admin\\/role\\/trees\\\",\\\"permission\\\":\\\"admin.role.trees\\\"},{\\\"text\\\":\\\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\\",\\\"index\\\":6,\\\"url\\\":\\\".\\/admin\\/operation-log\\/list\\\",\\\"permission\\\":\\\"admin.operation-log.list\\\"}]},{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"url\\\":\\\"\\\",\\\"permission\\\":\\\"\\\",\\\"index\\\":1,\\\"attributes\\\":\\\"\\\",\\\"items\\\":[{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"url\\\":\\\"\\/product\\\",\\\"permission\\\":\\\"product.index.index\\\",\\\"index\\\":0}],\\\"expanded\\\":true,\\\"selected\\\":true}]\"},\"route\":[]}','POST',0,'2014-10-14 09:50:04',1),(40,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:50:06',1),(41,'admin.menu.index','{\"get\":{\"_\":\"1413280224395\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:50:47',1),(42,'admin.permission.query','{\"get\":[],\"post\":{\"url\":\".\\/product\"},\"route\":[]}','POST',0,'2014-10-14 09:50:52',1),(43,'admin.menu.save','{\"get\":[],\"post\":{\"data\":\"[{\\\"text\\\":\\\"\\u7cfb\\u7edf\\\",\\\"index\\\":0,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u7528\\u6237\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/admin\\/user\\\",\\\"permission\\\":\\\"admin.user.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":818}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"url\\\":\\\".\\/admin\\/role\\\",\\\"permission\\\":\\\"admin.role.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u6743\\u9650\\u7ba1\\u7406\\\",\\\"index\\\":2,\\\"url\\\":\\\".\\/admin\\/permission\\\",\\\"permission\\\":\\\"admin.permission.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":1096}\\\"},{\\\"text\\\":\\\"\\u83dc\\u5355\\u7ba1\\u7406\\\",\\\"index\\\":3,\\\"url\\\":\\\".\\/admin\\/menu\\\",\\\"permission\\\":\\\"admin.menu.index\\\",\\\"attributes\\\":\\\"{\\\\\\\"height\\\\\\\":700}\\\"},{\\\"text\\\":\\\"\\u4e2a\\u4eba\\u4fe1\\u606f\\\",\\\"index\\\":4,\\\"url\\\":\\\".\\/admin\\/index\\/self\\\",\\\"permission\\\":\\\"admin.index.self\\\",\\\"attributes\\\":\\\"{\\\\\\\"width\\\\\\\":600}\\\"},{\\\"text\\\":\\\"\\u89d2\\u8272\\u5173\\u7cfb\\\",\\\"index\\\":5,\\\"url\\\":\\\".\\/admin\\/role\\/trees\\\",\\\"permission\\\":\\\"admin.role.trees\\\"},{\\\"text\\\":\\\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\\",\\\"index\\\":6,\\\"url\\\":\\\".\\/admin\\/operation-log\\/list\\\",\\\"permission\\\":\\\"admin.operation-log.list\\\"}]},{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"index\\\":1,\\\"expanded\\\":true,\\\"items\\\":[{\\\"text\\\":\\\"\\u4ea7\\u54c1\\u7ba1\\u7406\\\",\\\"index\\\":0,\\\"url\\\":\\\".\\/product\\\",\\\"permission\\\":\\\"product.index.index\\\",\\\"selected\\\":true,\\\"attributes\\\":\\\"\\\"}]}]\"},\"route\":[]}','POST',0,'2014-10-14 09:50:53',1),(44,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:50:57',1),(45,'product.index.index','{\"get\":{\"_\":\"1413280258010\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:50:59',1),(46,'product.index.index','{\"get\":{\"_\":\"1413280258011\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:51:32',1),(47,'product.index.index','{\"get\":{\"_\":\"1413280258012\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:51:59',1),(48,'product.index.index','{\"get\":{\"_\":\"1413280258013\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:52:19',1),(49,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:52:26',1),(50,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:57:20',1),(51,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:57:44',1),(52,'admin.user.index','{\"get\":{\"_\":\"1413280665155\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:57:46',1),(53,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:57:47',1),(54,'product.index.index','{\"get\":{\"_\":\"1413280665156\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:57:49',1),(55,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:58:28',1),(56,'product.index.index','{\"get\":{\"_\":\"1413280708909\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:58:30',1),(57,'product.index.index','{\"get\":{\"_\":\"1413280708910\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:58:55',1),(58,'product.indexread.index','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:58:55',1),(59,'product.index.index','{\"get\":{\"_\":\"1413280708911\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:59:07',1),(60,'product.indexread.index','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:59:07',1),(61,'product.index.index','{\"get\":{\"_\":\"1413280708912\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:59:16',1),(62,'product.indexread.index','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:59:17',1),(63,'admin.user.index','{\"get\":{\"_\":\"1413280708913\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 09:59:31',1),(64,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 09:59:31',1),(65,'product.index.index','{\"get\":{\"_\":\"1413280708914\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:00:01',1),(66,'product.indexread.index','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:00:02',1),(67,'product.indexsave.index','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"test\",\"price\":\"0\",\"desc\":\"sdfsdffs\"},\"route\":[]}','POST',0,'2014-10-14 10:00:09',1),(68,'product.indexsave.index','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"test\",\"price\":\"0\",\"desc\":\"sdfsdffs\"},\"route\":[]}','POST',0,'2014-10-14 10:00:10',1),(69,'product.index.index','{\"get\":{\"_\":\"1413280708915\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:00:47',1),(70,'product.indexread.index','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:00:48',1),(71,'product.indexsave.index','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"\\u4e3b\\u673a\",\"price\":\"120\",\"desc\":\"123123213\"},\"route\":[]}','POST',0,'2014-10-14 10:01:02',1),(72,'product.indexsave.index','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"Product1\",\"price\":\"12\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:12:50',1),(73,'product.index.index','{\"get\":{\"_\":\"1413280708916\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:13:06',1),(74,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:13:06',1),(75,'product.index.save','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"Product1\",\"price\":\"0\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:13:15',1),(76,'product.index.index','{\"get\":{\"_\":\"1413280708917\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:13:18',1),(77,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:13:19',1),(78,'product.index.save','{\"get\":[],\"post\":{\"id\":\"1\",\"name\":\"Product1\",\"price\":\"12\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:13:23',1),(79,'product.index.index','{\"get\":{\"_\":\"1413280708918\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:13:28',1),(80,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:13:28',1),(81,'product.index.index','{\"get\":{\"_\":\"1413280708919\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:13:34',1),(82,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:13:34',1),(83,'product.index.save','{\"get\":[],\"post\":{\"id\":\"1\",\"name\":\"Product1\",\"price\":\"123\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:13:49',1),(84,'product.index.index','{\"get\":{\"_\":\"1413280708920\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:14:13',1),(85,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:14:14',1),(86,'product.index.delete','{\"get\":[],\"post\":{\"id\":\"1\",\"name\":\"Product1\",\"price\":\"0\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:14:28',1),(87,'product.index.index','{\"get\":{\"_\":\"1413280708921\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:14:54',1),(88,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:14:55',1),(89,'product.index.index','{\"get\":{\"_\":\"1413280708922\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:16:06',1),(90,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:16:07',1),(91,'product.index.index','{\"get\":{\"_\":\"1413280708923\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:16:15',1),(92,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:16:16',1),(93,'product.index.save','{\"get\":[],\"post\":{\"id\":\"3\",\"name\":\"Product2\",\"price\":\"123\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:16:25',1),(94,'product.index.index','{\"get\":{\"_\":\"1413280708924\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:16:57',1),(95,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:16:57',1),(96,'product.index.save','{\"get\":[],\"post\":{\"id\":\"2\",\"name\":\"Product1\",\"price\":\"123\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:17:03',1),(97,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:26:08',1),(98,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:26:30',1),(99,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:27:13',1),(100,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:27:30',1),(101,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:28:00',1),(102,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product1\",\"price\":\"1233\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:28:38',1),(103,'product.index.index','{\"get\":{\"_\":\"1413280708925\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:28:42',1),(104,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:28:42',1),(105,'product.index.save','{\"get\":[],\"post\":{\"id\":\"2\",\"name\":\"Product1\",\"price\":\"1\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:28:49',1),(106,'product.index.index','{\"get\":{\"_\":\"1413280708926\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:28:52',1),(107,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:28:52',1),(108,'product.index.save','{\"get\":[],\"post\":{\"id\":\"3\",\"name\":\"Product1\",\"price\":\"12\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:28:59',1),(109,'product.index.save','{\"get\":[],\"post\":{\"id\":\"3\",\"name\":\"Product2\",\"price\":\"12\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:29:04',1),(110,'product.index.save','{\"get\":[],\"post\":{\"id\":\"4\",\"name\":\"Product3\",\"price\":\"123\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:29:09',1),(111,'product.index.save','{\"get\":[],\"post\":{\"id\":\"5\",\"name\":\"Product4\",\"price\":\"1234\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:29:16',1),(112,'product.index.index','{\"get\":{\"_\":\"1413280708927\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:29:19',1),(113,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:29:19',1),(114,'product.index.index','{\"get\":{\"_\":\"1413280708928\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:29:31',1),(115,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:29:32',1),(116,'product.index.save','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"Product5\",\"price\":\"6\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:29:46',1),(117,'product.index.save','{\"get\":[],\"post\":{\"id\":\"\",\"name\":\"Product5\",\"price\":\"5\",\"desc\":\"test\"},\"route\":[]}','POST',0,'2014-10-14 10:30:14',1),(118,'product.index.index','{\"get\":{\"_\":\"1413280708929\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:30:17',1),(119,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:30:17',1),(120,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\",\"sort\":[{\"field\":\"id\",\"dir\":\"asc\"}]},\"route\":[]}','POST',0,'2014-10-14 10:30:30',1),(121,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\",\"sort\":[{\"field\":\"id\",\"dir\":\"desc\"}]},\"route\":[]}','POST',0,'2014-10-14 10:30:31',1),(122,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:37:42',1),(123,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\",\"sort\":[{\"field\":\"id\",\"dir\":\"asc\"}]},\"route\":[]}','POST',0,'2014-10-14 10:37:43',1),(124,'admin.operation-log.list','{\"get\":{\"_\":\"1413280708930\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:42:53',1),(125,'admin.operation-log.read','{\"get\":[],\"post\":{\"take\":\"15\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"15\"},\"route\":[]}','POST',0,'2014-10-14 10:42:53',1),(126,'admin.role.trees','{\"get\":{\"_\":\"1413280708931\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:43:01',1),(127,'admin.menu.index','{\"get\":{\"_\":\"1413280708932\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:43:07',1),(128,'admin.role.index','{\"get\":{\"_\":\"1413280708933\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:43:12',1),(129,'admin.role.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 10:43:13',1),(130,'admin.user.index','{\"get\":{\"_\":\"1413280708934\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:43:15',1),(131,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:43:16',1),(132,'product.index.index','{\"get\":{\"_\":\"1413280708935\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 10:43:19',1),(133,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 10:43:19',1),(134,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:22:36',1),(135,'admin.user.index','{\"get\":{\"_\":\"1413285756686\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:22:43',1),(136,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 11:22:43',1),(137,'product.index.index','{\"get\":{\"_\":\"1413285756687\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:22:44',1),(138,'product.index.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 11:22:44',1),(139,'admin.permission.index','{\"get\":{\"_\":\"1413285756688\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:22:48',1),(140,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 11:22:48',1),(141,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:23:18',1),(142,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:23:51',1),(143,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:24:07',1),(144,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:27:08',1),(145,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:27:23',1),(146,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:28:16',1),(147,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:28:21',1),(148,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:29:14',1),(149,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:29:31',1),(150,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:29:35',1),(151,'admin.user.index','{\"get\":{\"_\":\"1413286175301\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:29:38',1),(152,'admin.user.read','{\"get\":[],\"post\":{\"take\":\"20\",\"skip\":\"0\",\"page\":\"1\",\"pageSize\":\"20\"},\"route\":[]}','POST',0,'2014-10-14 11:29:38',1),(153,'admin.index.index','{\"get\":[],\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:30:20',1),(154,'admin.index.self','{\"get\":{\"_\":\"1413286175302\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:30:20',1),(155,'admin.index.self','{\"get\":{\"_\":\"1413286220965\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:30:23',1),(156,'admin.index.self','{\"get\":[],\"post\":{\"password\":\"\",\"confirm_password\":\"\",\"real_name\":\"administrators\",\"email\":\"admin@admin.com\"},\"route\":[]}','POST',0,'2014-10-14 11:30:25',1),(157,'admin.menu.index','{\"get\":{\"_\":\"1413286220966\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:30:30',1),(158,'admin.permission.index','{\"get\":{\"_\":\"1413286220967\"},\"post\":[],\"route\":[]}','GET',0,'2014-10-14 11:30:31',1),(159,'admin.permission.read','{\"get\":[],\"post\":[],\"route\":[]}','POST',0,'2014-10-14 11:30:32',1);
/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_param_permission`
--

DROP TABLE IF EXISTS `admin_param_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_param_permission` (
  `per_id` int(11) NOT NULL COMMENT '权限ID',
  `role_id` smallint(6) NOT NULL,
  `param_key` varchar(15) NOT NULL COMMENT '参数键',
  `param_value` int(11) DEFAULT NULL COMMENT '参数值',
  KEY `role_id` (`role_id`),
  KEY `per_id` (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='扩展参数权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_param_permission`
--

LOCK TABLES `admin_param_permission` WRITE;
/*!40000 ALTER TABLE `admin_param_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_param_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_permission`
--

DROP TABLE IF EXISTS `admin_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_permission` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `controller` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`per_id`),
  UNIQUE KEY `action` (`module`,`controller`,`action`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permission`
--

LOCK TABLES `admin_permission` WRITE;
/*!40000 ALTER TABLE `admin_permission` DISABLE KEYS */;
INSERT INTO `admin_permission` VALUES (1,'admin','auth','index','admin.auth.index'),(2,'admin','auth','login','admin.auth.login'),(3,'admin','auth','logout','admin.auth.logout'),(4,'admin','image-browser','read','admin.image-browser.read'),(5,'admin','image-browser','delete','admin.image-browser.delete'),(6,'admin','image-browser','create','admin.image-browser.create'),(7,'admin','image-browser','thumbnail','admin.image-browser.thumbnail'),(8,'admin','image-browser','upload','admin.image-browser.upload'),(9,'admin','image-browser','index','Default action if none provided'),(10,'admin','index','index','admin.index.index'),(11,'admin','index','self','admin.index.self'),(12,'admin','menu','index','admin.menu.index'),(13,'admin','menu','save','admin.menu.save'),(14,'admin','operation-log','list','admin.operation-log.list'),(15,'admin','operation-log','read','admin.operation-log.read'),(16,'admin','operation-log','index','Default action if none provided'),(17,'admin','permission','read','admin.permission.read'),(18,'admin','permission','save','admin.permission.save'),(19,'admin','permission','init','初始化权限'),(20,'admin','permission','assign','角色权限分配'),(21,'admin','permission','query','admin.permission.query'),(22,'admin','permission','index','Default action if none provided'),(23,'admin','role','read','admin.role.read'),(24,'admin','role','save','admin.role.save'),(25,'admin','role','update','admin.role.update'),(26,'admin','role','delete','admin.role.delete'),(27,'admin','role','assign-permission','admin.role.assign-permission'),(28,'admin','role','assign-user','admin.role.assign-user'),(29,'admin','role','assign-product','admin.role.assign-product'),(30,'admin','role','trees','admin.role.trees'),(31,'admin','role','index','Default action if none provided'),(32,'admin','user','read','admin.user.read'),(33,'admin','user','save','admin.user.save'),(34,'admin','user','delete','admin.user.delete'),(35,'admin','user','assign','admin.user.assign'),(36,'admin','user','index','Default action if none provided'),(37,'product','index','index','product.index.index');
/*!40000 ALTER TABLE `admin_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role`
--

DROP TABLE IF EXISTS `admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role`
--

LOCK TABLES `admin_role` WRITE;
/*!40000 ALTER TABLE `admin_role` DISABLE KEYS */;
INSERT INTO `admin_role` VALUES (1,'Administrators',0);
/*!40000 ALTER TABLE `admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `real_name` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user`
--

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',0,'administrators','admin@admin.com'),(2,'test','96e79218965eb72c92a549dd5a330112',0,'Test','test@test.com');
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'Product1',1.00,'test'),(3,'Product2',12.00,'test'),(4,'Product3',123.00,'test'),(5,'Product4',1234.00,'test'),(6,'Product5',5.00,'test');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-14 19:35:43
