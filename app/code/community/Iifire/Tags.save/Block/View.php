
<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_View extends Mage_Catalog_Block_Product_Abstract
{
	
    protected $_searchCollection;
    protected $_tagsCollection;
    protected $_pageSizeSearch = 8;
    protected $_pageSizeTags = 8;

    protected function _getQuery()
    {
        return $this->helper('catalogsearch')->getQuery();
    }
	public function getQueryText()
	{
		return Mage::helper('catalogsearch')->getQuery()->getQueryText();
	}
    protected function _prepareLayout()
    {
    	parent::_prepareLayout();
        $this->_loadSearchCollection();
        $pageSizeSearch = $this->_getPageSizeSearch();
        
        $pagerSearch = $this->getLayout()->createBlock('iifire_tags/pager', 'tags.search.pager');
        $pagerSearch->setAvailableLimit(array($pageSizeSearch));
        $pagerSearch->setCollection($this->_searchCollection);
        $pagerSearch->setTemplate('iifire/tags/pager/search.phtml');
        $this->setChild('pagerSearch', $pagerSearch);
        
        return $this;
        //$title = $this->__("Tags results for: '%s'", $this->helper('catalogsearch')->getEscapedQueryText());
        //$this->getLayout()->getBlock('head')->setTitle($title);
        //return parent::_prepareLayout();
    }
    protected function _loadSearchCollection()
    {
    	if (is_null($this->_searchCollection)) {
            $collectionSearch = Mage::getResourceModel('catalogsearch/fulltext_collection');
            $collectionSearch->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addAttributeToSelect('rating_summary');
            $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
            $query = Mage::helper('catalogsearch')->getQuery();
            $words = Mage::helper('core/string')->splitWords($query->getQueryText(), true, $query->getMaxQueryWords());
            $like = '(';
            $i =  0;
            foreach ($words as $word) {
            	if ($i!=0) {
            		$like .= ' or f.data_index like "%'.$word.'%" ';
            	} else {
            		$like .= 'f.data_index like "%'.$word.'%" ';
            	}
                $i++;
            }
            $like .= ')';
            $collectionSearch->getSelect()->joinInner(
            	array('f' => $adapter->getTableName('catalogsearch_fulltext')),
            	'e.entity_id = f.product_id and f.store_id='.Mage::app()->getStore()->getId().' and '.$like.'',
            	''
            );
           // echo $collectionSearch->getSelect();
           // ->addAttributeToFilter('data_index',array( 'LIKE' =>'%'.Mage::helper('catalogsearch')->getQuery()->getQueryText().'%'));
            //->addAttributeToFilter('entity_id',array('in'=>$this->getSearchProductIds(Mage::helper('catalogsearch')->getQuery()->getQueryText())))
            $collectionSearch->setStore(Mage::app()->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();

        	Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collectionSearch);
       		Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collectionSearch);
        	$collectionSearch->setCurPage(1)->setPageSize($this->_getPageSizeSearch());
        	$this->_searchCollection = $collectionSearch;
    	}
    }
    public function getSearchCollection()
    {
        $this->_loadSearchCollection();
        return $this->_searchCollection;
    }
    protected function _getPageSizeSearch()
    {
    	$pageSize = Mage::getSingleton('iifire_tags/tags')->getPageSizeSearch();
    	if ($pageSize) {
    		return $pageSize;
    	} else {
    		return $this->_pageSizeSearch;
    	}
    }
    protected function _getPageSizeTags()
    {
    	$pageSize = Mage::getSingleton('iifire_tags/tags')->getPageSizeTags();
    	if ($pageSize) {
    		return $pageSize;
    	} else {
    		return $this->_pageSizeTags;
    	}
    }
    public function getDomain()
    {
    	$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    	return $domain;
    }
    public function getDescription()
    {
    	
    	$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		if ($tags->getId() && trim($tags->getTagsDescription())) {
			return str_replace('{}',$this->helper('catalogsearch')->getEscapedQueryText(),$tags->getTagsDescription());
		} else {
			return false;
		}
    }

}
