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
        
        if ($this->getTagId()) {
	        $this->_loadTagsCollection();
	        $pageSizeTags = $this->_getPageSizeTags();
	        $pagerTags = $this->getLayout()->createBlock('iifire_tags/pager', 'tags.tags.pager');
	        $pagerTags->setAvailableLimit(array($pageSizeTags));
	        $pagerTags->setCollection($this->_tagsCollection);
	        $pagerTags->setTemplate('iifire/tags/pager/search.phtml');
	        $this->setChild('pagerTags', $pagerTags);
        }        
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
            ->addAttributeToSelect('rating_summary')
            ->addSearchFilter(Mage::helper('catalogsearch')->getQuery()->getQueryText())
            ->setStore(Mage::app()->getStore())
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
    protected function _loadTagsCollection()
    {
    	if ($this->getTagId()){
	        if(is_null($this->_tagsCollection)) {
	            $tagModel = Mage::getModel('tag/tag');
	            $tagsCollection = $tagModel->getEntityCollection()
	                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
	                ->addAttributeToSelect('rating_summary')
	                ->addTagFilter($this->getTagId())
	                ->addStoreFilter(Mage::app()->getStore()->getId())
	                ->addMinimalPrice()
	                ->addUrlRewrite()
	                ->setActiveFilter();
	            Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($tagsCollection);
	            Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($tagsCollection);
	        	$tagsCollection->setCurPage(1)->setPageSize($this->_getPageSizeTags());
	        	$this->_tagsCollection = $tagsCollection;
	        } else {
	        	return $this->_tagsCollection;
	        }
    	} else {
    		$this->_tagsCollection = NULL;
    	}
    }
    public function getTagId()
    {
    	$model = Mage::getModel('tag/tag')->loadByName($this->_getQuery()->getQueryText());
    	if ($model->getId()) {
    		return $model->getId();
    	} else {
    		return false;
    	}

    }
    public function getSearchCollection()
    {
        $this->_loadSearchCollection();
        return $this->_searchCollection;
    }
    public function getTagsCollection()
    {
        $this->_loadTagsCollection();
        return $this->_tagsCollection;
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
    	$pageSize = Mage::getSingleton('iifire_tags/tags')->getViewPageSize();
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
    public function getPhase()
    {
    	$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		if ($tags->getId() && trim($tags->getTagsPhase())) {
			return str_replace('{}',$this->helper('catalogsearch')->getEscapedQueryText(),$tags->getTagsPhase());
		} else {
			return false;
		}
    }

}
