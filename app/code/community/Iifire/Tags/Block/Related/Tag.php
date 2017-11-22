<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Tag extends Mage_Core_Block_Template
{
	protected $_pageSize = 10;
    
	public function getCollection()
	{
		$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		$tagId = $tags->getId();
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
                ->addFieldToFilter('store_id',$storeId);
        if ($tagId) {
        	$collection->addFieldToFilter('tags_id',array('gt'=>$tagId));
        	
        }
        $collection->getSelect()->limit($this->getPageSize());
        return $collection;
	}
	public function getPageSize()
	{
		$pageSize = (int)Mage::getStoreConfig('iifire_tags/general/tags_view_random');
		return $pageSize ? $pageSize : $this->_pageSize;
	}
}

