<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS `custom` (
  `id`  int(4) NOT NULL AUTO_INCREMENT,
  `size`  varchar(255) CHARACTER SET latin1 NOT NULL,
  `color` varchar(255) CHARACTER SET latin1 NOT NULL,
  `customimage1` varchar(255) CHARACTER SET latin1 NOT NULL,
  `customimage2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage4` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage5` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage6` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage7` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage8` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage9` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `customimage10` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `name`  varchar(255) CHARACTER SET latin1 NOT NULL,
  `telephone`  varchar(255) CHARACTER SET latin1 NOT NULL,
  `email`  varchar(255) CHARACTER SET latin1 NOT NULL,
  `special_need` varchar(255) CHARACTER SET latin1 NOT NULL COMMENT '问题内容',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		
SQLTEXT;

$installer->run($sql);
$installer->endSetup();
	 