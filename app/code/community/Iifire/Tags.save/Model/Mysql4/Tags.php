<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Mysql4_Tags extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('iifire_tags/tags','tags_id');
    }
    public function loadByTagsText(Mage_Core_Model_Abstract $object, $value)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('tags_text = ?', $value)
            ->where('store_id = ?', $object->getStoreId())
            ->limit(1);
        if ($data = $this->_getReadAdapter()->fetchRow($select)) {
            $object->setData($data);
            $this->_afterLoad($object);
        }
        return $this;
    }
}
