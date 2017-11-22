<?php
$installer = $this;
$installer->startSetup();
$installer->run("
alter table {$this->getTable('iifire_tags')} add tags_products varchar(255) default NULL;
alter table {$this->getTable('iifire_tags_sitemap')} add sitemap_baseurl varchar(255) default NULL;
");



