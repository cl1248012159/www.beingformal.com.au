<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_Product extends Mage_Catalog_Block_Product_Abstract
{
	protected $_pageSize = 8;
    
	public function getCollection()
	{
		$collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents();
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        $collection->addStoreFilter();
        $collection->setCurPage(1)->setPageSize($this->getPageSize());
		$collection->getSelect()->order('rand()');
		return $collection;
	}
	public function getPageSize()
	{
		$pageSize = (int)Mage::getStoreConfig('iifire_tags/general/related_product_size');
		return $pageSize ? $pageSize : $this->_pageSize;
	}
}

