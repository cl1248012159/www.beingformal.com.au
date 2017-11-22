<?php
class Iifire_Tags_Block_Productlist extends Mage_Catalog_Block_Product_Abstract
{
	protected $_tagsProducts = NULL;
	protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $collection = Mage::getResourceModel('catalog/product_collection');
            $collection->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes());
            $tags = Mage::getModel('iifire_tags/tags');
			$tags->setStoreId(Mage::app()->getStore()->getId());
			$tags->loadByTagsText(Mage::helper('catalogsearch')->getEscapedQueryText());
			$productIds = array();
			if ($tags->getId()) {
				$productIds = trim($tags->getTagsProducts());
				if ($productIds) {
					$ids = explode(',',$productIds);
					$ids = array_unique($ids);
					$tmp = array();
					foreach ($ids as $_id) {
						if ($_id) {
							array_push($tmp,$_id);
						}
					}
					if (count($tmp)) {
						$productIds = $tmp;
					}
				}
			}
            
        	if (is_array($productIds) && count($productIds)) {
        		$collection->addAttributeToFilter('entity_id',array('in'=>$productIds));
        		$this->_tagsProducts = $productIds;
        	} else {
        		$adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        		$query = Mage::helper('catalogsearch')->getQuery();
		        $words = Mage::helper('core/string')->splitWords($query->getQueryText(), true, $query->getMaxQueryWords());
		        $like = '(';
		        $i =  0;
		        $wordsCopy = Mage::helper('itags')->cleanWords($words);
		        if (!count($wordsCopy)) {
		        	$wordsCopy = $words;
		        }
				
		        $removetagsword=array('for','and','in','with','or','the','of','on','can','to','get','find','do','you','a');
		        foreach ($wordsCopy as $word) {
					if(!in_array($word,$removetagsword)){
		        	if ($i!=0) {
		    			$like .= ' or f.data_index like "%'.$word.'%" ';
		        	} else {
		        		$like .= 'f.data_index like "%'.$word.'%" ';
		        	}
		            $i++;
					}
		        }
		        $like .= ')';
		        $collection->getSelect()->joinInner(
		        	array('f' => Mage::getSingleton('core/resource')->getTableName('catalogsearch_fulltext')),
		        	'e.entity_id = f.product_id and f.store_id='.Mage::app()->getStore()->getId().' and '.$like.'',
		        	''
		        );
        	}
			
        	if ($tags->getId()) {
        		$tagsCategory = Mage::getModel('iifire_tags/category')->load($tags->getCategoryId());
        		if ($tagsCategory->getId() && trim($tagsCategory->getStoreCategory())) {
					$tagscat=$tagsCategory->getStoreCategory();
					$tagscats=explode(',',$tagscat);
					$conditions = array();
					$conditions[] = array('attribute' => 'category_id', array('in' => $tagscats));
        			$collection->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
        				   ->addAttributeToFilter($conditions)->groupByAttribute('entity_id');
						//$collection->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
        				//->addAttributeToFilter('category_id',array('in'=>array('finset'=>trim($tagsCategory->getStoreCategory()))));
        		}
        		//echo $tagsCategory->getStoreCategory();
        	}
        	
        	$collection->setStore(Mage::app()->getStore())
	            ->addMinimalPrice()
	            ->addFinalPrice()
	            ->addTaxPercents()
	            ->addStoreFilter()
	            ->addUrlRewrite();
	        //Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
	        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
            if (!$this->_tagsProducts) {
            	$collection->getSelect()->order('rand()')->limit(16);
            } else {
            	$collection->getSelect()->limit(16);
            }
            $ids = array();
            foreach ($collection as $_c) {
                array_push($ids,$_c->getId());
            
            }
            $productIds = is_array($productIds) ? $productIds : array();
            if (!count($productIds) && Mage::helper('itags')->isFixedResultEnable() && count($ids)) {
            	$tags->setTagsProducts(implode(',',$ids));
            	if ($tags->getId()) {
	            	try {
	            		$tags->save();
	            	} catch (Exception $e) {
	            		
	            	}
            	}
            }
            if ($tags->getId() && !count($ids) && Mage::helper('itags')->isRemoveTags()) {
            	try {
            		$tags->delete();
            	} catch (Exception $e) {
            		//
            	}
            }
            //echo $collection->getSelect();
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }
    public function getTagsProducts()
    {
    	$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText(Mage::helper('catalogsearch')->getEscapedQueryText());
		if ($tags->getId()) {
			$productIds = $tags->getTagsProducts();
			if ($productIds) {
				$ids = explode(',',$productIds);
				$ids = array_unique($ids);
				$tmp = array();
				foreach ($ids as $_id) {
					if ($_id) {
						array_push($tmp,$_id);
					}
				}
				if (count($tmp)) {
					//$collection->addAttributeToFilter('entity_id',array('in'=>$ids));
					//$flag = true;
					return $tmp;
				}
			}
		}
		return array();
    }
}
?>
