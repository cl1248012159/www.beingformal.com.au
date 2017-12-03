<?php
class My_Custom_Model_Mysql4_Custom extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("custom/custom", "id");
    }
}