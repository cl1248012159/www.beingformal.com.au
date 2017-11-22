<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Model_Category extends Mage_Core_Model_Abstract
{
	protected $_storeCategories;
    protected function _construct()
    {
        $this->_init('iifire_tags/category','category_id');
    }
    public function getCatsOptionByStoreId($storeId = 0)
    {
    	$collection = $this->getCollection()
    		->addFieldToSelect(array('category_id','category_name'))
    		->addFieldToFilter('store_id',$storeId);
		$options = array();
		if (count($collection)) {
			foreach ($collection as $_c) {
				$options[$_c->getCategoryId()] = $_c->getCategoryCode();
			}
		}
		return $options;
    }
    public function getCategories()
    {
    	$collection = $this->getCollection()
    		->addFieldToFilter('store_id', Mage::app()->getStore()->getId());
		return $collection;
    }
    public function getCategoryIds($storeId)
    {
    	$collection = $this->getCollection()
    		->addFieldToFilter('store_id', $storeId);
    	$categoryIds = array();
    	foreach ($collection as $_category) {
    		array_push($categoryIds,$_category->getId());
    	}
    	return $categoryIds;
    }
    public function getCategoryAsOption($useEmpty=false)
    {
    	$collection = $this->getCollection();
    	$stores = Mage::getSingleton('adminhtml/system_store')->getStoreOptionHash();
    	if (count($collection)) {
    		if ($useEmpty) {
    			$options = array(''=>Mage::helper('itags')->__('Please Select'));
    		} else {
    			$options = array();
    		}
    		
    		foreach($collection as $_category) {
    			$storeName = $stores[$_category->getStoreId()];
    			$options[$_category->getId()] = $_category->getCategoryName()."  [$storeName]";
    		}
    		return $options;
    	} else {
    		return false;
    	}
    }
    public function getStoreCategories()
    {
    	if (!$this->_storeCategories) {
    		$category = Mage::getModel('catalog/category');
			$tree = $category->getTreeModel();
			$tree->load();
			$ids = $tree->getCollection()->getAllIds();
			$arr = array();
			
			if ($ids){
				foreach ($ids as $id){
					$cat = Mage::getModel('catalog/category');
					$cat->load($id);
					$arr[$id] = $cat->getName();
				}
			} 
			$this->_storeCategories = $arr;
    	}
		return $this->_storeCategories;	
    }
    public function getStoreCategoriesNote() 
    {
    	$categories = $this->getStoreCategories();
    	$str = '';
    	foreach ($categories as $key=>$value) {
    		$str .= '<label>'.$value.'['.$key.']'.'</label>&nbsp;&nbsp;';
    	}
    	return $str;
    }
}
