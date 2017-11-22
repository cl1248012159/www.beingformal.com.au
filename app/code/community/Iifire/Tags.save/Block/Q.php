<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Q extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $helper = Mage::helper('itags');
   //     if ($helper->isSearchAuto()) {
        	$query = Mage::helper('catalogsearch')->getQuery();
	        $storeId = Mage::app()->getStore()->getId();
	        $query->setStoreId($storeId);
	        $queryText = $query->getQueryText();
	        $tags = Mage::getModel('iifire_tags/tags');
	        $auto = $tags->getTermAuto();
	        if ($queryText && $auto) {
	        	$listBlock = Mage::getBlockSingleton('catalog/product_list');
	        	$resultCount = count($listBlock->getLoadedProductCollection());
	        	if(!Mage::helper('catalogsearch')->isMinQueryLength() && $resultCount) {
	        		
	        		$tags->setStoreId($storeId);
	        		$tags->loadByTagsText($queryText);
	        		if (!$tags->getId()) {
	        			$tags->setStoreId(Mage::app()->getStore()->getId());
	        			$tags->setTagsText($queryText);
	        			try {
	        				$tags->save();
	        				
	        			} catch (Exception $e) {
	        				
	        			}
	        		}
	        		
	        	}
	        }
 //       }
	        
    }
}
