<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Search extends Mage_Core_Block_Template
{
	protected $_pageSize = 10;
    
	public function getTags()
	{
		$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		$tagId = $tags->getId();
		$storeId = Mage::app()->getStore()->getId();
		$str = '';
        if ($tagId) {
        	if (!$tags->getRelatedTags()) {
        		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
	                ->addFieldToFilter('store_id',$storeId)
	        	    ->addFieldToFilter('tags_id',array('gt'=>$tagId-(int)($this->getPageSize()/2)));
	        	    $collection->getSelect()->limit($this->getPageSize());
	        	    
	        	    foreach ($collection as $tag) {
	        	    	$str .= $tag->getTagsText().',';
	        	    }
	        	    
	        		$tags->setRelatedTags(rtrim($str,','));
	        		try {
	        			$tags->save();
	        		} catch (Exception $e) {
	        			//
	        			$str = '';
	        		}
        	} else {
        		$str = $tags->getRelatedTags();
        	}
	    		
        }
        
        return $str;

	}
	public function getPageSize()
	{
		//$pageSize = (int)Mage::getStoreConfig('iifire_tags/general/related_tag_size');
		$pageSize = 10;
		return $pageSize ? $pageSize : $this->_pageSize;
	}
}

