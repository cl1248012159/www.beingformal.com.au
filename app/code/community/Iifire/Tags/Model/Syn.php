<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Syn extends Mage_Core_Model_Abstract
{
	const SYN_TYPE_SEARCH = 0;
	const SYN_TYPE_TAGS = 1;
	protected function _construct()
    {
        $this->_init('iifire_tags/syn','syn_id');
    }
    public function getLastSynId($type=self::SYN_TYPE_SEARCH)
    {
    	$lastSyn = $this->getCollection()
    		->addFieldToFilter('syn_type', $type)
    		->setOrder('pk_id','desc')
    		->getFirstItem();
		if ($lastSyn->getId()) {
			return $lastSyn->getPkId();
		}
		return false;
    }
    public function getSearchType()
    {
    	return self::SYN_TYPE_SEARCH;
    }
    public function getTagsType()
    {
    	return self::SYN_TYPE_TAGS;
    }
    public function getTypeOptions()
    {
    	return array(
    		self::SYN_TYPE_SEARCH => Mage::helper('itags')->__("Search Terms"),
    		self::SYN_TYPE_TAGS => Mage::helper('itags')->__("Tags")
    	);
    }
}
