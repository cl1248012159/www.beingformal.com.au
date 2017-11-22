<?php
$installer = $this;
$installer->startSetup();
$tablename = $this->getTable('review/review_detail');
$installer->run("ALTER TABLE `$tablename` ADD `reviewimage1` VARCHAR(255) DEFAULT NULL;");
$installer->run("ALTER TABLE `$tablename` ADD `reviewimage2` VARCHAR(255) DEFAULT NULL;");
$installer->run("ALTER TABLE `$tablename` ADD `reviewimage3` VARCHAR(255) DEFAULT NULL;");
$installer->run("ALTER TABLE `$tablename` ADD `reviewimage4` VARCHAR(255) DEFAULT NULL;");
$installer->run("ALTER TABLE `$tablename` ADD `reviewimage5` VARCHAR(255) DEFAULT NULL;");
$installer->endSetup(); 


?>