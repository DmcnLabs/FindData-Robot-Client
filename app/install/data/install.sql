
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

-- ----------------------------
-- Table structure for cloud_sys_conf
-- ----------------------------
DROP TABLE IF EXISTS `cloud_sys_conf`;

CREATE TABLE `cloud_sys_conf` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '',
  `title` varchar(50) NOT NULL COMMENT '',
  `value` text NOT NULL COMMENT '',
  `options` varchar(255) NOT NULL COMMENT '',
  `function` varchar(60) NOT NULL COMMENT '',
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '',
  `sub_group` tinyint(3) DEFAULT '0' COMMENT '',
  `type` varchar(16) NOT NULL DEFAULT '0' COMMENT '',
  `remark` varchar(500) NOT NULL COMMENT '',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `sort` smallint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='';

INSERT INTO `cloud_sys_conf` (`id`, `name`, `title`, `value`, `options`, `function`, `group`, `sub_group`, `type`, `remark`, `create_time`, `update_time`, `sort`, `status`) VALUES
(1, 'toggle_web_site', 'Client Switch', '1', '0:OFF\r\n1:ON', '', 1, 0, 'select', '', 1378898976, '2020-02-28 06:41:45', 1, 1),
(2, 'web_site_title', 'title', '', '', '', 6, 0, 'text', '', 1378898976, '2020-03-02 05:43:53', 2, 1),
(4, 'web_site_logo', 'LOGO', '250', '', '', 6, 0, 'picture', '', 1407003397, '2020-02-28 06:41:45', 4, 1),
(5, 'web_site_description', 'SEO', '', '', '', 6, 1, 'textarea', '', 1378898976, '2020-03-02 05:37:11', 6, 1),
(6, 'web_site_keyword', 'Keywords', '', '', '', 6, 1, 'textarea', '', 1378898976, '2020-02-28 06:41:46', 4, 1),
(7, 'web_site_copyright', 'Copyright', '', '', '', 1, 0, 'text', '', 1406991855, '2020-02-28 06:41:45', 7, 1),
(8, 'web_site_icp', 'ICP', '', '', '', 6, 0, 'text', '', 1378900335, '2020-02-28 06:41:45', 8, 1),
(9, 'web_site_statistics', 'Statistics', '', '', '', 1, 0, 'textarea', '', 1378900335, '2020-02-28 06:41:45', 9, 1),
(10, 'index_url', '????????????', '', '', '', 2, 0, 'text', '', 1471579753, '2020-02-28 06:41:46', 0, 1),
(11, 'save_method', '????????????', '0', '0:??????\r\n1:??????', '', 1, 0, 'select', '0=???????????????1=??????????????????', 1378898976, '2020-02-28 06:41:45', 10, 1),
(12, 'admin_page_rows', '????????????', '20', '', '', 2, 0, 'number', '???????????????????????????', 1434019462, '2020-02-28 06:41:45', 4, 1),
(13, 'admin_theme', '????????????', 'default', 'default:????????????\r\nblue:????????????\r\ngreen:????????????', '', 2, 0, 'select', '??????????????????', 1436678171, '2020-02-28 06:41:45', 5, 1),
(14, 'develop_mode', '????????????', '1', '1:??????\r\n0:??????', '', 3, 0, 'select', '????????????????????????????????????????????????????????????????????????????????????', 1432393583, '2020-02-28 06:41:45', 1, 1),
(15, 'app_trace', '??????????????????Trace', '1', '1:??????\r\n0:??????', '', 3, 0, 'select', '??????????????????Trace??????', 1387165685, '2020-02-28 06:41:45', 2, 1),
(16, 'auth_key', '????????????KEY', 'vzxI=vf[=xV)?a^XihbLKx?pYPw$;Mi^R*<mV;yJh$wy(~~E?<.JA&ANdIZ#QhPq', '', '', 3, 0, 'textarea', '????????????????????????????????????????????????????????????????????????????????????????????????key', 1438647773, '2020-02-28 06:41:45', 3, 1),
(17, 'only_auth_rule', '????????????????????????', '1', '1:??????\n0:??????', '', 4, 0, 'radio', '?????????????????????????????????????????????????????????????????????', 1473437355, '2020-02-28 06:41:45', 0, 1),
(18, 'static_domain', '????????????????????????', '', '', '', 3, 0, 'text', '', 1438564784, '2020-02-28 06:41:45', 3, 1),
(19, 'config_group_list', '????????????', '1:??????\r\n2:??????\r\n3:??????\r\n4:??????\r\n5:??????\r\n6:????????????\r\n7:??????\r\n8:??????', '', '', 3, 0, 'array', '??????????????????????????????????????????', 1379228036, '2020-02-28 06:41:45', 5, 1),
(20, 'app_key', 'appid', '', '', '', 3, 0, 'text', '', 1378898976, '2020-02-28 06:58:23', 2, 1),
(21, 'app_secret', '????????????KEY', '', '', '', 3, 0, 'text', '', 1378898976, '2020-02-28 06:58:23', 3, 1);

-- ----------------------------
-- Table structure for cloud_users
-- ----------------------------
DROP TABLE IF EXISTS `cloud_users`;
CREATE TABLE `cloud_users` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '?????????',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '????????????',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '??????key',
  `nickname` varchar(60) NOT NULL DEFAULT '' COMMENT '????????????',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '????????????',
  `mobile` varchar(20) DEFAULT '' COMMENT '?????????',
  `avatar` varchar(150) DEFAULT '' COMMENT '??????????????????',
  `sex` smallint(1) unsigned DEFAULT '0' COMMENT '?????????0????????????1?????????2??????',
  `birthday` date DEFAULT '1990-01-01' COMMENT '??????',
  `description` varchar(200) DEFAULT '' COMMENT '????????????',
  `register_ip` varchar(16) DEFAULT '' COMMENT '??????IP',
  `last_login_ip` varchar(16) DEFAULT '' COMMENT '????????????ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '??????????????????',
  `active_auth_sign` varchar(60) DEFAULT '' COMMENT '?????????',
  `url` varchar(100) DEFAULT '' COMMENT '????????????URL',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '????????????',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '??????',
  `freeze_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '????????????????????????????????????',
  `pay_pwd` char(32) DEFAULT '' COMMENT '????????????',
  `reg_from` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????1=PC??????2=WAP??????3=????????????4=APP??????5=????????????',
  `reg_method` varchar(30) NOT NULL DEFAULT '' COMMENT '',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `p_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????ID',
  `user_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '???????????????1=????????????;2=???????????????;3=???????????????',
  `allow_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????0=????????????1=??????',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '????????????',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '??????????????? 0=????????? 1=?????? ???2=?????????',
  `create_time` int(10) unsigned NOT NULL COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`uid`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='';


-- ----------------------------
-- Table structure for cloud_finndy_data
-- ----------------------------
DROP TABLE IF EXISTS `cloud_finndy_data`;
CREATE TABLE `cloud_finndy_data` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `robotid` int(11) DEFAULT NULL,
  `subject` mediumtext,
  `message` mediumtext,
  `extfield1` tinytext,
  `extfield2` tinytext,
  `extfield3` tinytext,
  `extfield4` tinytext,
  `extfield5` tinytext,
  `extfield6` tinytext,
  `extfield7` tinytext,
  `extfield8` tinytext,
  `extfield9` tinytext,
  `extfield10` tinytext,
  `extfield11` tinytext,
  `extfield12` tinytext,
  `extfield13` tinytext,
  `extfield14` tinytext,
  `extfield15` tinytext,
  `extfield16` tinytext,
  `extfield17` tinytext,
  `extfield18` tinytext,
  `extfield19` tinytext,
  `extfield20` tinytext,
  `extfield21` tinytext,
  `extfield22` tinytext,
  `extfield23` tinytext,
  `extfield24` tinytext,
  `extfield25` tinytext,
  `extfield26` tinytext,
  `extfield27` tinytext,
  `extfield28` tinytext,
  `extfield29` tinytext,
  `extfield30` tinytext,
  `extfield31` tinytext,
  `extfield32` tinytext,
  `extfield33` tinytext,
  `extfield34` tinytext,
  `extfield35` tinytext,
  `extfield36` tinytext,
  `extfield37` tinytext,
  `extfield38` tinytext,
  `extfield39` tinytext,
  `extfield40` tinytext,
  `extfield41` text,
  `extfield42` text,
  `extfield43` text,
  `extfield44` text,
  `extfield45` text,
  `extfield46` text,
  `extfield47` text,
  `extfield48` text,
  `create_time` int(10) unsigned NOT NULL COMMENT '',
  PRIMARY KEY (`itemid`),
  KEY `robotid` (`robotid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cloud_stat_robot`;
CREATE TABLE `cloud_stat_robot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL COMMENT '',
  `count` int(10) NOT NULL DEFAULT '0' COMMENT '',
  `dateline` int(10) NOT NULL COMMENT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='';

DROP TABLE IF EXISTS `cloud_user_robot`;
CREATE TABLE `cloud_user_robot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL COMMENT '',
  `robotid` int(10) NOT NULL DEFAULT '0' COMMENT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='';


DROP TABLE IF EXISTS `cloud_auth_group`;
CREATE TABLE `cloud_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(500) NOT NULL,
  `remark` varchar(100) NOT NULL COMMENT '',
  `create_time` int(10) unsigned NOT NULL COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cloud_auth_group_access`;
CREATE TABLE `cloud_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `cloud_auth_group` VALUES ('1', 'Normal user', '1', '115,116,135,136,139,140,141,142,157,137,126,125,138,127,153,154,155,158,159,100,101,151,190,193,195,196,194,191,207,208,201,202,203,204,205,206,192,197,198,199', 'Normal user', '1520931383', '2021-03-01 18:28:46');


DROP TABLE IF EXISTS `cloud_auth_rule`;
CREATE TABLE `cloud_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '??????type???1??? condition????????????????????????????????????',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  `icon` char(20) NOT NULL COMMENT '',
  `is_display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????????????????,1:?????? 0:?????????',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '',
  `level` int(10) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `cloud_auth_rule` VALUES ('206', 'article/top', 'Sticky article', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 15:05:54');
INSERT INTO `cloud_auth_rule` VALUES ('205', 'article/removeFile', 'Delete file', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 14:25:04');
INSERT INTO `cloud_auth_rule` VALUES ('204', 'article/upload', 'Picture upload', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 14:23:13');
INSERT INTO `cloud_auth_rule` VALUES ('203', 'article/del', 'Delete article', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 14:21:17');
INSERT INTO `cloud_auth_rule` VALUES ('202', 'article/edit', 'Edit article', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 14:20:11');
INSERT INTO `cloud_auth_rule` VALUES ('201', 'article/add', 'New article', '1', '1', '', '191', '', '0', '0', '2', '1524809989', '2020-04-27 14:19:49');
INSERT INTO `cloud_auth_rule` VALUES ('199', 'category/del', 'Delete category', '1', '1', '', '192', '', '0', '3', '2', '1524797335', '2020-04-27 16:53:55');
INSERT INTO `cloud_auth_rule` VALUES ('198', 'category/edit', 'Edit category', '1', '1', '', '192', '', '0', '0', '2', '1524797318', '2020-04-27 10:48:38');
INSERT INTO `cloud_auth_rule` VALUES ('197', 'category/add', 'New category', '1', '1', '', '192', '', '0', '0', '2', '1524797294', '2020-04-27 10:48:14');
INSERT INTO `cloud_auth_rule` VALUES ('196', 'tag/del', 'delete tag', '1', '1', '', '193', '', '0', '0', '2', '1524797256', '2020-04-27 10:47:36');
INSERT INTO `cloud_auth_rule` VALUES ('195', 'tag/edit', 'Edit tag', '1', '1', '', '193', '', '0', '0', '2', '1524797223', '2020-04-27 10:47:03');
INSERT INTO `cloud_auth_rule` VALUES ('194', 'tag/add', 'New tag', '1', '1', '', '193', '', '0', '0', '2', '1524797199', '2020-04-27 10:46:39');
INSERT INTO `cloud_auth_rule` VALUES ('193', 'tag/index', 'Tag setting', '1', '1', '', '190', '', '1', '3', '1', '1524797112', '2020-04-27 17:00:39');
INSERT INTO `cloud_auth_rule` VALUES ('192', 'category/index', 'Category settings', '1', '1', '', '190', '', '1', '2', '1', '1524797079', '2020-04-27 16:53:55');
INSERT INTO `cloud_auth_rule` VALUES ('191', 'article/index', 'Article list', '1', '1', '', '190', '', '1', '1', '1', '1524447561', '2020-04-27 16:53:55');
INSERT INTO `cloud_auth_rule` VALUES ('159', 'robot/loadingpostcat', 'Release data', '1', '1', '', '116', '', '0', '0', '1', '1522143157', '2021-03-01 17:32:37');
INSERT INTO `cloud_auth_rule` VALUES ('158', 'robot/getjsonp', 'Get local data', '1', '1', '', '116', '', '0', '0', '1', '1522142895', '2021-03-01 17:28:15');
INSERT INTO `cloud_auth_rule` VALUES ('190', 'article/shownav', 'Article settings', '1', '1', '', '0', 'bookmark', '0', '8', '0', '1524447515', '2020-04-23 09:40:21');
INSERT INTO `cloud_auth_rule` VALUES ('155', 'robot/importcopy', 'Import copy', '1', '1', '', '116', '', '0', '0', '1', '1522058372', '2021-03-01 09:45:20');
INSERT INTO `cloud_auth_rule` VALUES ('154', 'robot/import', 'Import rules', '1', '1', '', '116', '', '0', '0', '1', '1522058354', '2020-03-26 17:59:14');
INSERT INTO `cloud_auth_rule` VALUES ('153', 'robot/progress', 'Collection progress', '1', '1', '', '116', '', '0', '0', '1', '1522058193', '2020-03-26 17:56:33');
INSERT INTO `cloud_auth_rule` VALUES ('151', 'user/resetpwd', 'Change Password', '1', '1', '', '101', '', '0', '0', '2', '1522056235', '2020-03-26 17:34:59');
INSERT INTO `cloud_auth_rule` VALUES ('149', 'authrule/del', 'Delete permissions', '1', '1', '', '105', '', '0', '0', '2', '1521541013', '2020-03-26 17:44:33');
INSERT INTO `cloud_auth_rule` VALUES ('156', 'sysconf/sysset', 'Site settings', '1', '1', '', '104', '', '1', '0', '1', '1522115434', '2021-03-01 09:50:34');
INSERT INTO `cloud_auth_rule` VALUES ('105', 'authrule/index', 'Permission setting', '1', '1', '', '104', '', '1', '0', '1', '0', '2020-03-15 12:18:42');
INSERT INTO `cloud_auth_rule` VALUES ('145', 'user/edit', 'Edit user', '1', '1', '', '100', '', '0', '0', '1', '1521540504', '2020-03-20 18:08:24');
INSERT INTO `cloud_auth_rule` VALUES ('157', 'robot/stoprun', 'Stop acquisition', '1', '1', '', '116', '', '0', '0', '1', '1522142758', '2021-03-01 17:25:58');
INSERT INTO `cloud_auth_rule` VALUES ('143', 'user/del', 'delete user', '1', '1', '', '100', '', '0', '0', '1', '1521540413', '2020-03-20 18:06:53');
INSERT INTO `cloud_auth_rule` VALUES ('142', 'robot/export_json', 'Export data in JSON', '1', '1', '', '116', '', '0', '0', '1', '1521539245', '2020-03-20 17:47:25');
INSERT INTO `cloud_auth_rule` VALUES ('141', 'robot/export_csv', 'Export data in CSV', '1', '1', '', '116', '', '0', '0', '1', '1521539217', '2020-03-20 17:46:57');
INSERT INTO `cloud_auth_rule` VALUES ('140', 'robot/cleardata', 'Delete data', '1', '1', '', '116', '', '0', '0', '1', '1521539185', '2020-03-20 17:46:25');
INSERT INTO `cloud_auth_rule` VALUES ('139', 'robot/detail', 'view source', '1', '1', '', '116', '', '0', '0', '1', '1521539096', '2020-03-20 17:45:10');
INSERT INTO `cloud_auth_rule` VALUES ('133', 'authgroup/add', 'Add user group', '1', '1', '', '106', '', '0', '0', '2', '1521447446', '2020-03-20 18:15:13');
INSERT INTO `cloud_auth_rule` VALUES ('148', 'authrule/edit', 'Edit permission', '1', '1', '', '105', '', '0', '0', '2', '1521541002', '2020-03-20 18:16:42');
INSERT INTO `cloud_auth_rule` VALUES ('136', 'robot/debugrobot', 'Test collection', '1', '1', '', '116', '', '0', '0', '1', '1521538956', '2021-03-01 09:47:45');
INSERT INTO `cloud_auth_rule` VALUES ('135', 'robot/startrun', 'Start collection', '1', '1', '', '116', '', '0', '0', '1', '1521530818', '2021-03-01 17:25:36');
INSERT INTO `cloud_auth_rule` VALUES ('137', 'robot/copy', 'Copy data source', '1', '1', '', '116', '', '0', '0', '1', '1521538994', '2020-03-20 17:43:14');
INSERT INTO `cloud_auth_rule` VALUES ('126', 'robot/edit', 'Edit data source', '1', '1', '', '116', '', '0', '0', '1', '1521088299', '2020-03-15 12:31:39');
INSERT INTO `cloud_auth_rule` VALUES ('125', 'robot/add', 'New robot', '1', '1', '', '116', '', '1', '0', '1', '1521088281', '2020-03-20 14:46:28');
INSERT INTO `cloud_auth_rule` VALUES ('127', 'robot/index', 'Data source list', '1', '1', '', '116', '', '1', '0', '1', '1521093668', '2020-03-15 14:01:08');
INSERT INTO `cloud_auth_rule` VALUES ('119', 'user/add', 'Increase membership', '1', '1', '', '100', '', '0', '0', '1', '1521081526', '2020-03-19 17:22:40');
INSERT INTO `cloud_auth_rule` VALUES ('115', 'index/index', 'Home', '1', '1', '', '0', 'tachometer', '1', '0', '0', '1521078076', '2020-03-15 14:56:54');
INSERT INTO `cloud_auth_rule` VALUES ('116', 'robot/shownav', 'Data management', '1', '1', '', '0', 'cog', '1', '1', '0', '1521078157', '2020-03-19 17:17:31');
INSERT INTO `cloud_auth_rule` VALUES ('138', 'robot/export', 'Export rules', '1', '1', '', '116', '', '0', '0', '1', '1521539020', '2020-03-20 17:43:40');
INSERT INTO `cloud_auth_rule` VALUES ('106', 'authgroup/index', 'User group settings', '1', '1', '', '104', '', '1', '0', '1', '0', '2020-03-15 12:18:39');
INSERT INTO `cloud_auth_rule` VALUES ('146', 'authgroup/edit', 'Modify user group', '1', '1', '', '106', '', '0', '0', '2', '1521540753', '2020-03-20 18:12:33');
INSERT INTO `cloud_auth_rule` VALUES ('104', 'sysconf/shownav', 'System settings', '1', '1', '', '0', 'th', '1', '4', '0', '0', '2020-04-27 11:52:09');
INSERT INTO `cloud_auth_rule` VALUES ('200', 'user/index', 'Membership list', '1', '1', '', '100', '', '1', '0', '1', '1524798889', '2020-04-27 11:29:30');
INSERT INTO `cloud_auth_rule` VALUES ('101', 'user/profile', 'My panel', '1', '1', '', '100', '', '1', '0', '1', '1520851354', '2020-03-15 12:18:37');
INSERT INTO `cloud_auth_rule` VALUES ('132', 'authrule/add', 'Add permissions', '1', '1', '', '105', '', '0', '0', '2', '1521447405', '2020-03-19 16:16:45');
INSERT INTO `cloud_auth_rule` VALUES ('100', 'user/shownav', 'User management', '1', '1', '', '0', 'user', '1', '3', '0', '1520851347', '2020-04-18 17:35:42');
INSERT INTO `cloud_auth_rule` VALUES ('207', 'article/post', 'Post articles', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 15:05:56');
INSERT INTO `cloud_auth_rule` VALUES ('208', 'article/recommend', 'Recommend article', '1', '1', '', '191', '', '0', '0', '2', '1524810011', '2020-04-27 15:05:57');


DROP TABLE IF EXISTS `cloud_article`;
CREATE TABLE `cloud_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `cateid` int(10) NOT NULL COMMENT '',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '',
  `content` text COMMENT '',
  `summary` varchar(500) NOT NULL DEFAULT '' COMMENT '',
  `thumb` varchar(255) NOT NULL COMMENT '',
  `keywords` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo keywords',
  `poststatus` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '??????;1:?????????;0:?????????;',
  `commentstatus` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '????????????;1:??????;0:?????????',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '????????????;1:??????;0:?????????',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '????????????;1:??????;0:?????????',
  `click` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '?????????',
  `post_like` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '?????????',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `source` varchar(150) NOT NULL DEFAULT '' COMMENT '????????????',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COMMENT='';



DROP TABLE IF EXISTS `cloud_article_category`;
CREATE TABLE `cloud_article_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '??????id',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '????????????',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '????????????',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '?????????id',
  `articlecount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????',
  `level` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '??????,1:??????,0:??????',
  `sort` int(10) NOT NULL DEFAULT '10000' COMMENT '??????',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=' ???????????????';

DROP TABLE IF EXISTS `cloud_article_tag`;
CREATE TABLE `cloud_article_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '??????id',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '????????????',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '??????,1:??????,0:??????',
  `count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '???????????????',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='???????????????';


DROP TABLE IF EXISTS `cloud_article_tag_access`;
CREATE TABLE `cloud_article_tag_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL COMMENT '??????id',
  `tagid` int(10) NOT NULL COMMENT '??????id',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='?????????????????????';



