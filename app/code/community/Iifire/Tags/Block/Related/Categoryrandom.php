<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Categoryrandom extends Mage_Core_Block_Template
{
	protected $_pageSize = 10;
    
	public function getCollection($pageSize=10)
	{
		$category = Mage::registry('current_category');
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
                ->addFieldToFilter('store_id',$storeId);
        if ($category && $category->getId()) {

        	$tagCats = Mage::getModel('iifire_tags/category')->getCollection();
        	$tagCatId = 0;
        	if (count($tagCats)) {
        		foreach ($tagCats as $_tagCat) {
        			$idArr = explode(',', $_tagCat->getStoreCategory());
        			if (in_array($category->getId(), $idArr)) {
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

