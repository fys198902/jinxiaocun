/*
Navicat MySQL Data Transfer

Source Server         : jxc
Source Server Version : 50173
Source Host           : hdm325607443.my3w.com:3306
Source Database       : hdm325607443_db

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2020-04-06 09:53:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for caigou
-- ----------------------------
DROP TABLE IF EXISTS `caigou`;
CREATE TABLE `caigou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caig_xt_id` varchar(15) NOT NULL,
  `caig_date` date NOT NULL,
  `gongys_id` int(11) NOT NULL,
  `caig_zhaiy` varchar(255) DEFAULT NULL,
  `caig_cangk_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for caigouentry
-- ----------------------------
DROP TABLE IF EXISTS `caigouentry`;
CREATE TABLE `caigouentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caig_id` int(11) NOT NULL,
  `wuliao_id` int(11) NOT NULL,
  `danw_id` int(11) NOT NULL,
  `shul` int(11) NOT NULL,
  `danj` double DEFAULT NULL,
  `jine` double DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for cangku
-- ----------------------------
DROP TABLE IF EXISTS `cangku`;
CREATE TABLE `cangku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cangk_name` varchar(20) NOT NULL,
  `cangk_dizhi` varchar(100) DEFAULT NULL,
  `cangk_lianxfs` varchar(50) DEFAULT NULL,
  `zhangt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for chengben
-- ----------------------------
DROP TABLE IF EXISTS `chengben`;
CREATE TABLE `chengben` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jiezhang_id` int(11) NOT NULL,
  `wuliaoid` int(11) NOT NULL,
  `shul` int(11) NOT NULL,
  `jine` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for danw
-- ----------------------------
DROP TABLE IF EXISTS `danw`;
CREATE TABLE `danw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `danw_zu` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for danwentry
-- ----------------------------
DROP TABLE IF EXISTS `danwentry`;
CREATE TABLE `danwentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `danw_zu_id` int(11) NOT NULL,
  `danw_name` varchar(10) NOT NULL,
  `danw_huans` int(11) NOT NULL,
  `danw_leibie` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for fukuan
-- ----------------------------
DROP TABLE IF EXISTS `fukuan`;
CREATE TABLE `fukuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fukuan_xt_id` varchar(13) NOT NULL,
  `fdate` date NOT NULL,
  `gongys_id` int(11) NOT NULL,
  `zhaiyao` text,
  `shoukleibie_id` int(11) NOT NULL,
  `shifu` double DEFAULT NULL,
  `zhekou` double DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for gongys
-- ----------------------------
DROP TABLE IF EXISTS `gongys`;
CREATE TABLE `gongys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gongys_name` varchar(50) NOT NULL,
  `gongys_dizhi` varchar(100) DEFAULT NULL,
  `gongys_lianxr` varchar(10) DEFAULT NULL,
  `gongys_lianxfs` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for jiezhang
-- ----------------------------
DROP TABLE IF EXISTS `jiezhang`;
CREATE TABLE `jiezhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fyear` int(4) NOT NULL,
  `fmonth` int(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for juese
-- ----------------------------
DROP TABLE IF EXISTS `juese`;
CREATE TABLE `juese` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jues_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for juesequanxian
-- ----------------------------
DROP TABLE IF EXISTS `juesequanxian`;
CREATE TABLE `juesequanxian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jues_id` int(11) DEFAULT NULL,
  `quanx_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for kehu
-- ----------------------------
DROP TABLE IF EXISTS `kehu`;
CREATE TABLE `kehu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kehu_name` varchar(50) NOT NULL,
  `kehu_dizhi` varchar(100) DEFAULT NULL,
  `kehu_lianxr` varchar(10) DEFAULT NULL,
  `kehu_lianxfs` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for qitashouzhi
-- ----------------------------
DROP TABLE IF EXISTS `qitashouzhi`;
CREATE TABLE `qitashouzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shouz_xt_id` varchar(13) NOT NULL,
  `fdate` date NOT NULL,
  `zhaiyao` text,
  `leibie` int(1) NOT NULL,
  `shoukleibie_id` int(11) NOT NULL,
  `jine` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for quanxian
-- ----------------------------
DROP TABLE IF EXISTS `quanxian`;
CREATE TABLE `quanxian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quanx_name` varchar(20) DEFAULT NULL,
  `model` varchar(20) DEFAULT NULL,
  `controller` varchar(20) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for shoukuan
-- ----------------------------
DROP TABLE IF EXISTS `shoukuan`;
CREATE TABLE `shoukuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shouk_xt_id` varchar(13) NOT NULL,
  `fdate` date NOT NULL,
  `kehu_id` int(11) NOT NULL,
  `zhaiyao` text,
  `shoukleibie_id` int(11) NOT NULL,
  `shishou` double(255,0) DEFAULT NULL,
  `zhekou` double(255,0) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for shoukuanentry
-- ----------------------------
DROP TABLE IF EXISTS `shoukuanentry`;
CREATE TABLE `shoukuanentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shouk_id` int(11) NOT NULL,
  `xiaoshou_id` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for shoukuanleibie
-- ----------------------------
DROP TABLE IF EXISTS `shoukuanleibie`;
CREATE TABLE `shoukuanleibie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shoukleibie` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `closingdate` date NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  `lastlogintime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for userjuese
-- ----------------------------
DROP TABLE IF EXISTS `userjuese`;
CREATE TABLE `userjuese` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `jues_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for weixin_baifang
-- ----------------------------
DROP TABLE IF EXISTS `weixin_baifang`;
CREATE TABLE `weixin_baifang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fdate` datetime DEFAULT NULL,
  `zhongd_id` int(11) DEFAULT NULL,
  `neirong` varchar(255) CHARACTER SET gbk DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for weixin_baifangentry
-- ----------------------------
DROP TABLE IF EXISTS `weixin_baifangentry`;
CREATE TABLE `weixin_baifangentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baifang_id` int(11) DEFAULT NULL,
  `uploadfile` varchar(255) CHARACTER SET gbk DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for weixin_user
-- ----------------------------
DROP TABLE IF EXISTS `weixin_user`;
CREATE TABLE `weixin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `weixinid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for wuliao
-- ----------------------------
DROP TABLE IF EXISTS `wuliao`;
CREATE TABLE `wuliao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zu_id` int(11) NOT NULL,
  `wuliao_name` varchar(50) NOT NULL,
  `danw_zu_id` int(11) NOT NULL,
  `jinjia` double(255,0) DEFAULT NULL,
  `shoujia` double(255,0) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for wuliaozu
-- ----------------------------
DROP TABLE IF EXISTS `wuliaozu`;
CREATE TABLE `wuliaozu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wuliao_zu` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for xiaoshou
-- ----------------------------
DROP TABLE IF EXISTS `xiaoshou`;
CREATE TABLE `xiaoshou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xiaos_xt_id` varchar(15) NOT NULL,
  `xiaos_date` date NOT NULL,
  `kehu_id` int(11) NOT NULL,
  `kehu_name` varchar(80) DEFAULT NULL,
  `kehu_dizhi` varchar(100) DEFAULT NULL,
  `xiaos_zhaiy` varchar(255) DEFAULT NULL,
  `xiaos_cangk_id` int(11) NOT NULL,
  `cangk_name` varchar(50) DEFAULT NULL,
  `yuang_id` int(11) DEFAULT NULL,
  `yuang` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `zhangt_id` int(11) NOT NULL,
  `kehu_lianxfs` varchar(30) DEFAULT NULL,
  `cangk_lianxfs` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for xiaoshouentry
-- ----------------------------
DROP TABLE IF EXISTS `xiaoshouentry`;
CREATE TABLE `xiaoshouentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xiaos_id` int(11) NOT NULL,
  `wuliao_id` int(11) NOT NULL,
  `wuliao_name` varchar(80) DEFAULT NULL,
  `danw_id` int(11) NOT NULL,
  `danw_name` varchar(10) DEFAULT NULL,
  `danw_huans` int(11) DEFAULT NULL,
  `shul` int(11) NOT NULL,
  `danj` double DEFAULT NULL,
  `jine` double DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for yuangong
-- ----------------------------
DROP TABLE IF EXISTS `yuangong`;
CREATE TABLE `yuangong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yuang` varchar(20) NOT NULL,
  `lianxfs` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `zhangt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for zhangtao
-- ----------------------------
DROP TABLE IF EXISTS `zhangtao`;
CREATE TABLE `zhangtao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhangtao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for wuliaolist
-- ----------------------------
DROP VIEW IF EXISTS `wuliaolist`;
create view wuliaolist as select `b`.`id` AS `id`,`a`.`id` AS `zuid`,`a`.`wuliao_zu` AS `wuliao_zu`,`b`.`wuliao_name` AS `wuliao_name`,`c`.`id` AS `danw_zu_id`,`c`.`danw_zu` AS `danw_zu`,`a`.`zhangt_id` AS `zhangt_id` from (`danw` `c` join (`wuliao` `b` left join `wuliaozu` `a` on((`a`.`id` = `b`.`zu_id`)))) where (`b`.`danw_zu_id` = `c`.`id`);

-- ----------------------------
-- View structure for caigoulist
-- ----------------------------
DROP VIEW IF EXISTS `caigoulist`;
CREATE VIEW `caigoulist` AS select `a`.`id` AS `id`,`b`.`id` AS `caigentry_id`,`a`.`caig_xt_id` AS `caig_xt_id`,`a`.`caig_date` AS `caig_date`,`f`.`id` AS `gongysid`,`f`.`gongys_name` AS `gongys_name`,`f`.`gongys_dizhi` AS `gongys_dizhi`,`f`.`gongys_lianxr` AS `gongys_lianxr`,`f`.`gongys_lianxfs` AS `gongys_lianxfs`,`a`.`caig_zhaiy` AS `caig_zhaiy`,`a`.`caig_cangk_id` AS `caig_cangk_id`,`e`.`cangk_name` AS `cangk_name`,`e`.`cangk_lianxfs` AS `cangk_lianxfs`,`g`.`username` AS `username`,`c`.`id` AS `wuliaoid`,`c`.`wuliao_zu` AS `wuliao_zu`,`c`.`wuliao_name` AS `wuliao_name`,`d`.`id` AS `danwid`,`d`.`danw_name` AS `danw_name`,`d`.`danw_huans` AS `danw_huans`,`b`.`shul` AS `shul`,`b`.`danj` AS `danj`,`b`.`jine` AS `jine`,`b`.`beizhu` AS `beizhu`,`a`.`zhangt_id` AS `zhangt_id` from ((((((`caigou` `a` left join `caigouentry` `b` on((`a`.`id` = `b`.`caig_id`))) left join `wuliaolist` `c` on((`b`.`wuliao_id` = `c`.`id`))) left join `danwentry` `d` on((`b`.`danw_id` = `d`.`id`))) left join `cangku` `e` on((`a`.`caig_cangk_id` = `e`.`id`))) left join `gongys` `f` on((`a`.`gongys_id` = `f`.`id`))) left join `user` `g` on((`a`.`user_id` = `g`.`id`))) ;

-- ----------------------------
-- View structure for chengbenlist
-- ----------------------------
DROP VIEW IF EXISTS `chengbenlist`;
CREATE VIEW `chengbenlist` AS select `a`.`id` AS `id`,`a`.`jiezhang_id` AS `jiezhang_id`,`a`.`wuliaoid` AS `wuliaoid`,`b`.`wuliao_name` AS `wuliao_name`,`a`.`shul` AS `shul`,`a`.`jine` AS `jine` from (`chengben` `a` left join `wuliao` `b` on((`a`.`wuliaoid` = `b`.`id`))) ;

-- ----------------------------
-- View structure for danwlist
-- ----------------------------
DROP VIEW IF EXISTS `danwlist`;
CREATE VIEW `danwlist` AS select `a`.`id` AS `zuid`,`a`.`danw_zu` AS `danw_zu`,`b`.`id` AS `danwid`,`b`.`danw_name` AS `danw_name`,`b`.`danw_huans` AS `danw_huans`,`b`.`danw_leibie` AS `danw_leibie`,`a`.`zhangt_id` AS `zhangt_id` from (`danw` `a` left join `danwentry` `b` on((`a`.`id` = `b`.`danw_zu_id`))) ;

-- ----------------------------
-- View structure for fukuanlist
-- ----------------------------
DROP VIEW IF EXISTS `fukuanlist`;
CREATE VIEW `fukuanlist` AS select `a`.`id` AS `id`,`a`.`fukuan_xt_id` AS `fukuan_xt_id`,`a`.`gongys_id` AS `gongys_id`,`a`.`fdate` AS `fdate`,`b`.`gongys_name` AS `gongys_name`,`b`.`gongys_dizhi` AS `gongys_dizhi`,`b`.`gongys_lianxr` AS `gongys_lianxr`,`b`.`gongys_lianxfs` AS `gongys_lianxfs`,`a`.`zhaiyao` AS `zhaiyao`,`d`.`shoukleibie` AS `shoukleibie`,`a`.`shifu` AS `shifu`,`a`.`zhekou` AS `zhekou`,(`a`.`shifu` + `a`.`zhekou`) AS `heji`,`c`.`username` AS `username`,`a`.`zhangt_id` AS `zhangt_id` from (((`fukuan` `a` left join `gongys` `b` on((`a`.`gongys_id` = `b`.`id`))) left join `user` `c` on((`a`.`user_id` = `c`.`id`))) left join `shoukuanleibie` `d` on((`a`.`shoukleibie_id` = `d`.`id`))) ;

-- ----------------------------
-- View structure for xiaoshoulist
-- ----------------------------
DROP VIEW IF EXISTS `xiaoshoulist`;
create view xiaoshoulist as select `a`.`id` AS `id`,`a`.`xiaos_xt_id` AS `xiaos_xt_id`,`a`.`xiaos_date` AS `xiaos_date`,`a`.`kehu_id` AS `kehu_id`,`a`.`kehu_id` AS `kehuid`,`a`.`kehu_name` AS `kehu_name`,`a`.`kehu_dizhi` AS `kehu_dizhi`,`a`.`kehu_lianxfs` AS `kehu_lianxfs`,`a`.`xiaos_zhaiy` AS `xiaos_zhaiy`,`a`.`xiaos_cangk_id` AS `xiaos_cangk_id`,`a`.`cangk_name` AS `cangk_name`,`a`.`cangk_lianxfs` AS `cangk_lianxfs`,`a`.`yuang_id` AS `yuang_id`,`a`.`yuang` AS `yuang`,`a`.`user_id` AS `user_id`,`a`.`username` AS `username`,`a`.`zhangt_id` AS `zhangt_id`,`b`.`wuliao_id` AS `wuliaoid`,`b`.`wuliao_name` AS `wuliao_name`,`b`.`danw_id` AS `danwid`,`b`.`danw_name` AS `danw_name`,`b`.`danw_huans` AS `danw_huans`,`b`.`shul` AS `shul`,`b`.`danj` AS `danj`,`b`.`jine` AS `jine`,`b`.`beizhu` AS `beizhu` from (`xiaoshou` `a` left join `xiaoshouentry` `b` on((`a`.`id` = `b`.`xiaos_id`)));

-- ----------------------------
-- View structure for taizhang
-- ----------------------------
DROP VIEW IF EXISTS `taizhang`;
CREATE VIEW `taizhang` AS select `caigoulist`.`caig_date` AS `fdate`,'购入' AS `leibie`,`caigoulist`.`caig_xt_id` AS `bianhao`,`caigoulist`.`gongys_name` AS `xiangmu`,`caigoulist`.`caig_cangk_id` AS `cangk_id`,`caigoulist`.`cangk_name` AS `cangk_name`,`caigoulist`.`wuliaoid` AS `wuliaoid`,`caigoulist`.`wuliao_name` AS `wuliao_name`,`caigoulist`.`danw_huans` AS `danw_huans`,`caigoulist`.`username` AS `username`,(`caigoulist`.`shul` * `caigoulist`.`danw_huans`) AS `shul`,`caigoulist`.`jine` AS `jine`,`caigoulist`.`beizhu` AS `beizhu`,`caigoulist`.`zhangt_id` AS `zhangt_id` from `caigoulist` union all select `xiaoshoulist`.`xiaos_date` AS `xiaos_date`,'售出' AS `售出`,`xiaoshoulist`.`xiaos_xt_id` AS `xiaos_xt_id`,`xiaoshoulist`.`kehu_name` AS `kehu_name`,`xiaoshoulist`.`xiaos_cangk_id` AS `xiaos_cangk_id`,`xiaoshoulist`.`cangk_name` AS `cangk_name`,`xiaoshoulist`.`wuliaoid` AS `wuliaoid`,`xiaoshoulist`.`wuliao_name` AS `wuliao_name`,`xiaoshoulist`.`danw_huans` AS `danw_huans`,`xiaoshoulist`.`username` AS `username`,(-(`xiaoshoulist`.`shul`) * `xiaoshoulist`.`danw_huans`) AS `shul`,-(`xiaoshoulist`.`jine`) AS `jine`,`xiaoshoulist`.`beizhu` AS `beizhu`,`xiaoshoulist`.`zhangt_id` AS `zhangt_id` from `xiaoshoulist` ;

-- ----------------------------
-- View structure for jishikucun
-- ----------------------------
DROP VIEW IF EXISTS `jishikucun`;
CREATE VIEW `jishikucun` AS select `taizhang`.`zhangt_id` AS `zhangt_id`,`taizhang`.`wuliaoid` AS `wuliaoid`,`taizhang`.`wuliao_name` AS `wuliao_name`,`taizhang`.`cangk_id` AS `cangk_id`,`taizhang`.`cangk_name` AS `cangk_name`,sum(`taizhang`.`shul`) AS `jiben` from `taizhang` group by `taizhang`.`zhangt_id`,`taizhang`.`wuliaoid`,`taizhang`.`wuliao_name`,`taizhang`.`cangk_id`,`taizhang`.`cangk_name` ;

-- ----------------------------
-- View structure for qitashouzhilist
-- ----------------------------
DROP VIEW IF EXISTS `qitashouzhilist`;
CREATE VIEW `qitashouzhilist` AS select `a`.`id` AS `id`,`a`.`shouz_xt_id` AS `shouz_xt_id`,`a`.`fdate` AS `fdate`,`a`.`zhaiyao` AS `zhaiyao`,`a`.`leibie` AS `leibie`,(case `a`.`leibie` when 0 then '支出' else '收入' end) AS `leibieentry`,`c`.`shoukleibie` AS `shoukleibie`,`a`.`jine` AS `jine`,`a`.`user_id` AS `user_id`,`a`.`zhangt_id` AS `zhangt_id`,`b`.`username` AS `username` from ((`qitashouzhi` `a` left join `user` `b` on((`a`.`user_id` = `b`.`id`))) left join `shoukuanleibie` `c` on((`a`.`shoukleibie_id` = `c`.`id`))) ;

-- ----------------------------
-- View structure for rijizhangentry
-- ----------------------------
DROP VIEW IF EXISTS `rijizhangentry`;
CREATE VIEW `rijizhangentry` AS select '收款单' AS `leibie`,`a`.`shouk_xt_id` AS `xt_id`,`a`.`fdate` AS `fdate`,`b`.`kehu_name` AS `fitem`,`a`.`zhaiyao` AS `zhaiyao`,`a`.`shoukleibie_id` AS `shoukleibie_id`,`a`.`shishou` AS `jine`,`a`.`user_id` AS `user_id`,`a`.`zhangt_id` AS `zhangt_id` from (`shoukuan` `a` left join `kehu` `b` on((`a`.`kehu_id` = `b`.`id`))) union select '付款单' AS `leibie`,`a`.`fukuan_xt_id` AS `fukuan_xt_id`,`a`.`fdate` AS `fdate`,`b`.`gongys_name` AS `gongys_name`,`a`.`zhaiyao` AS `zhaiyao`,`a`.`shoukleibie_id` AS `shoukleibie_id`,(-(1) * `a`.`shifu`) AS `-1*a.shifu`,`a`.`user_id` AS `user_id`,`a`.`zhangt_id` AS `zhangt_id` from (`fukuan` `a` left join `gongys` `b` on((`a`.`gongys_id` = `b`.`id`))) union select '其他收支单' AS `leibie`,`qitashouzhi`.`shouz_xt_id` AS `shouz_xt_id`,`qitashouzhi`.`fdate` AS `fdate`,'其他收支' AS `其他收支`,`qitashouzhi`.`zhaiyao` AS `zhaiyao`,`qitashouzhi`.`shoukleibie_id` AS `shoukleibie_id`,(case `qitashouzhi`.`leibie` when 0 then (-(1) * `qitashouzhi`.`jine`) else `qitashouzhi`.`jine` end) AS `case leibie when 0 then -1*jine else jine end`,`qitashouzhi`.`user_id` AS `user_id`,`qitashouzhi`.`zhangt_id` AS `zhangt_id` from `qitashouzhi` ;

-- ----------------------------
-- View structure for rijizhang
-- ----------------------------
DROP VIEW IF EXISTS `rijizhang`;
CREATE VIEW `rijizhang` AS select `a`.`leibie` AS `leibie`,`a`.`xt_id` AS `xt_id`,`a`.`fdate` AS `fdate`,`a`.`fitem` AS `fitem`,`a`.`zhaiyao` AS `zhaiyao`,`b`.`shoukleibie` AS `shoukleibie`,`a`.`jine` AS `jine`,`a`.`user_id` AS `user_id`,`a`.`zhangt_id` AS `zhangt_id` from (`rijizhangentry` `a` left join `shoukuanleibie` `b` on((`a`.`shoukleibie_id` = `b`.`id`))) ;

-- ----------------------------
-- View structure for shoukuanlist
-- ----------------------------
DROP VIEW IF EXISTS `shoukuanlist`;
CREATE VIEW `shoukuanlist` AS select `a`.`id` AS `id`,`a`.`shouk_xt_id` AS `shouk_xt_id`,`d`.`xiaoshou_id` AS `xiaoshou_id`,`a`.`kehu_id` AS `kehu_id`,`a`.`fdate` AS `fdate`,`b`.`kehu_name` AS `kehu_name`,`b`.`kehu_dizhi` AS `kehu_dizhi`,`b`.`kehu_lianxr` AS `kehu_lianxr`,`b`.`kehu_lianxfs` AS `kehu_lianxfs`,`a`.`zhaiyao` AS `zhaiyao`,`e`.`shoukleibie` AS `shoukleibie`,`a`.`shishou` AS `shishou`,`a`.`zhekou` AS `zhekou`,(`a`.`shishou` + `a`.`zhekou`) AS `heji`,`c`.`username` AS `username`,`a`.`zhangt_id` AS `zhangt_id` from ((((`shoukuan` `a` left join `kehu` `b` on((`a`.`kehu_id` = `b`.`id`))) left join `user` `c` on((`a`.`user_id` = `c`.`id`))) left join `shoukuanentry` `d` on((`a`.`id` = `d`.`shouk_id`))) left join `shoukuanleibie` `e` on((`a`.`shoukleibie_id` = `e`.`id`))) ;

-- ----------------------------
-- View structure for user_juesename
-- ----------------------------
DROP VIEW IF EXISTS `user_juesename`;
CREATE VIEW `user_juesename` AS select `a`.`id` AS `id`,`c`.`id` AS `jueseid`,`a`.`username` AS `username`,`c`.`jues_name` AS `jues_name` from ((`user` `a` left join `userjuese` `b` on((`a`.`id` = `b`.`user_id`))) left join `juese` `c` on((`b`.`jues_id` = `c`.`id`)));
