<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Mysql4_Syn extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('iifire_tags/syn','syn_id');
    }
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->hasCreatedAt()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }

        return parent::_beforeSave($object);
    }
}
