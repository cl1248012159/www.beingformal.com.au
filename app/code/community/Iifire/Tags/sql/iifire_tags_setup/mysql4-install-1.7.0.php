<?php
$installer = $this;
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('iifire_tags_category')};
CREATE TABLE {$this->getTable('iifire_tags_category')} (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` smallint(5) unsigned NOT NULL COMMENT 'Store ID',
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `category_description` text,
  PRIMARY KEY (`category_id`),
  KEY `FK_MAGENTOKEY_CONSULT_STORE` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tags Category';
DROP TABLE IF EXISTS {$this->getTable('iifire_tags')};
CREATE TABLE {$this->getTable('iifire_tags')} (
  `tags_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` smallint(5) unsigned NOT NULL,
  `tags_text` varchar(255) DEFAULT NULL,
  `tags_type` smallint(5) DEFAULT 0,
  `category_id` smallint(5) unsigned default NULL,
  `tags_description` text,
  `related_tags` text DEFAULT NULL,
  `random_tags` text DEFAULT NULL,
  `is_important` int(4) DEFAULT 0,
  PRIMARY KEY (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Iifire Tags';
DROP TABLE IF EXISTS {$this->getTable('iifire_tags_syn')};
CREATE TABLE {$this->getTable('iifire_tags_syn')} (
  `syn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Syn Id',
  `syn_type` smallint(5) DEFAULT 0,
  `pk_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT 'Created At',
  PRIMARY KEY (`syn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Iifire Tags Syn';
DROP TABLE IF EXISTS {$this->getTable('iifire_tags_description')};
CREATE TABLE {$this->getTable('iifire_tags_description')} (
  `description_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Description Id',
  `store_id` smallint(5) unsigned NOT NULL,
  `category_id` smallint(5) unsigned default NULL,
  `content` text COMMENT 'Ddescription Content',
  `created_at` datetime DEFAULT NULL COMMENT 'Created At',
  PRIMARY KEY (`description_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Iifire Tags Description';
DROP TABLE IF EXISTS {$this->getTable('iifire_tags_sitemap')};
CREATE TABLE {$this->getTable('iifire_tags_sitemap')} (
  `sitemap_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Sitemap Id',
  `sitemap_type` varchar(32) DEFAULT NULL COMMENT 'Sitemap Type',
  `sitemap_filename` varchar(32) DEFAULT NULL COMMENT 'Sitemap Filename',
  `sitemap_path` varchar(255) DEFAULT NULL COMMENT 'Sitemap Path',
  `sitemap_file_path` varchar(255) DEFAULT NULL COMMENT 'Sitemap File Path',
  `sitemap_time` timestamp NULL DEFAULT NULL COMMENT 'Sitemap Time',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store id',
  PRIMARY KEY (`sitemap_id`),
  KEY `IDX_IIFIRE_TAGS_SITEMAP_STORE_ID` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Iifire Tags Sitemap';
");