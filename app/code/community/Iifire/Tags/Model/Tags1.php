<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Tags1 extends Mage_Core_Model_Abstract
{
	const XML_TAGS_LIST_PAGE_SIZE = 'iifire_tags/list/pagesize';
	const XML_TAGS_VIEW_PAGE_SIZE = 'iifire_tags/view/pagesize';

	protected function _construct()
    {
        $this->_init('iifire_tags/tags1','tags_id');
    }
    public function loadByTagsText($text)
    {
        $this->_getResource()->loadByTagsText($this, $text);
        $this->_afterLoad();
        $this->setOrigData();
        return $this;
    }
    public function getListPageSize()
    {
    	return Mage::getStoreConfig(self::XML_TAGS_LIST_PAGE_SIZE);
    }
    public function getViewPageSize()
    {
    	return Mage::getStoreConfig(self::XML_TAGS_VIEW_PAGE_SIZE);
    }
}
