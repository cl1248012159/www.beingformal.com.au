<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_View extends Mage_Core_Block_Template
{
	public function getCollection($pageSize=16)
	{
		$product = Mage::registry('current_product');
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
                ->addFieldToFilter('store_id',$storeId);
        if ($product && $product->getId()) {
        	$productCatId = $product->getCategoryId();
        	$tagCats = Mage::getModel('iifire_tags/category')->getCollection();
        	$tagCatId = 0;
        	if (count($tagCats)) {
        		foreach ($tagCats as $_tagCat) {
        			$idArr = explode(',', $_tagCat->getStoreCategory());
        			if (in_array($productCatId, $idArr)) {
        				$tagCatId = $_tagCat->getId();
        				break;
        			}
        		}
        	}
        	if ($tagCatId) {
        		$collection->addFieldToFilter('category_id',$tagCatId);
        	}
        
        }
        $collection->setCurPage(1)->setPageSize($pageSize);
        //echo $collection->getSelect();
        $collection->getSelect()->order('rand()');
        return $collection;
	}
}

