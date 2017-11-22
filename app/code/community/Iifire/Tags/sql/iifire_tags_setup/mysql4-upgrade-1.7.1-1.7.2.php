<?php
$installer = $this;
$installer->startSetup();
$installer->run("
alter table {$this->getTable('iifire_tags_category')} add store_category varchar(255) default NULL;
");



