<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Viewrandom extends Mage_Core_Block_Template
{
	protected $_pageSize = 10;
    
	public function getTags()
	{
		$storeId = Mage::app()->getStore()->getId();
		$str = '';
		$product = Mage::registry('current_product');
		if($product->getId()){
	    	if (!$product->getRelatedProductTags()) {
	    		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
	                ->addFieldToFilter('store_id',$storeId)
	                ->addFieldToFilter('is_important',1);
	        	    $collection->getSelect()->limit($this->getPageSize())->order('rand()');
	        	    foreach ($collection as $tag) {
	        	    	$str .= $tag->getTagsText().',';
	        	    }
	        		$product->setRelatedProductTags(rtrim($str,','));
	        		try {
	        			$product->save();
	        		} catch (Exception $e) {
	        			//
	        			$str = '';
	        		}
	    	} else {
	    		$str = $product->getRelatedProductTags();
	    	}
		}
        return $str;
	}
	public function getPageSize()
	{
		$pageSize = (int)Mage::getStoreConfig('iifire_tags/general/product_view_random');
		return $pageSize ? $pageSize : $this->_pageSize;
	}
}

