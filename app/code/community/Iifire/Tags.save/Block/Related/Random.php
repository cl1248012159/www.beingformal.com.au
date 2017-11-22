<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Random extends Mage_Core_Block_Template
{
	protected $_pageSize = 20;
	public function getTags()
	{
		$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		$tagId = $tags->getId();
		$storeId = Mage::app()->getStore()->getId();
		$str = '';

        if ($tagId) {
        	if (!$tags->getRandomTags()) {
        		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
	                ->addFieldToFilter('store_id',$storeId)
	                ->addFieldToFilter('is_important',1);
	        	    $collection->getSelect()->limit($this->getPageSize())->order('rand()');
	        	    foreach ($collection as $tag) {
	        	    	$str .= $tag->getTagsText().',';
	        	    }
	        		$tags->setRandomTags(rtrim($str,','));
	        		try {
	        			$tags->save();
	        		} catch (Exception $e) {
	        			$str = '';
	        		}
        	} else {
        		$str = $tags->getRandomTags();
        	}	
        }
        return $str;
	}
	public function getPageSize()
	{
		$pageSize = (int)Mage::getStoreConfig('iifire_tags/general/tags_view_random');
		return $pageSize ? $pageSize : $this->_pageSize;
	}
}

