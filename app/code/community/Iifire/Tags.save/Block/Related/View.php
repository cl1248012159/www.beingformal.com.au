<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Related_View extends Mage_Core_Block_Template
{
	public function getCollection($pageSize=20)
	{
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getModel('iifire_tags/tags')->getCollection()
                ->addFieldToFilter('store_id',$storeId);
        $collection->setCurPage(1)->setPageSize($pageSize);
        $collection->getSelect()->order('rand()');
        return $collection;
	}
}

