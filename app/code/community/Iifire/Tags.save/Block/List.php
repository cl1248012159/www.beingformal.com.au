<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_List extends Mage_Core_Block_Template
{
	protected $_tags;
	protected $_tagsCollection;
	protected $_pageSize = 60;
    
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->_loadTags();
        $pageSize = $this->_getPageSize();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'tags.pager');
        $pager->setFrameLength(10);
        $pager->setAvailableLimit(array($pageSize));
        $pager->setCollection($this->_tagsCollection);
        $pager->setTemplate('iifire/tags/pager.phtml');
        
        $this->setChild('pager', $pager);

		return $this;
        
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }  
    protected function _loadTags()
    {
    	$w = $this->getTagsW();
    	$storeId = Mage::app()->getStore()->getId();
    	$curpage = $this->getCurrentPage();
        if (empty($this->_tags)) {
            $this->_tags = array();
            $tagsCollection = Mage::getModel('iifire_tags/tags')->getCollection()
                ->addFieldToFilter('store_id',$storeId)
                ->addFieldToFilter('tags_type',1)
                ->setOrder('tags_text','asc');
            //echo $tagsCollection->getSelect();
            if ($w) {
            	if (strlen($w)==3) {
            		$tagsCollection->getSelect()->where('tags_text REGEXP "^[0-9]"');
            	} else {
            		$tagsCollection->addFieldToFilter('tags_text', array("like"=>$w.'%'));
            	}
            }
            $tagsCollection->setCurPage($curpage)
            	->setPageSize($this->_getPageSize());
			$this->_tagsCollection = $tagsCollection;
            if( count($tagsCollection) == 0 ) {
                return $this;
            }
            foreach ($tagsCollection as $tags) {
                $this->_tags[$tags->getTagsId()] = $tags;
            }
        }
        return $this;
    }

    public function getTags()
    {
        $this->_loadTags();
        return $this->_tags;
    }

    public function getCrumb()
    {
    	$baseUrl = Mage::getBaseUrl();
    	$breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
		$breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>$baseUrl));
		$breadcrumbs->addCrumb('All Tags', array('label'=>Mage::helper('cms')->__('All Tags'), 'title'=>Mage::helper('cms')->__('All Tags'), 'link'=>$baseUrl.'tags/'));
		if($this->getTagsW()) {
			$w= strtoupper($this->getTagsW());
			$breadcrumbs->addCrumb($w, array('label'=>Mage::helper('cms')->__($w), 'title'=>Mage::helper('cms')->__($w)));	
		}
		return $this->getLayout()->getBlock('breadcrumbs')->toHtml();
    }
    public function getCurrentPage()
    {
    	$curpage = $this->getRequest()->getParam('p');
    	$curpage = $curpage ? (int)$curpage : 1;
    	return $curpage;
    }
    public function getTagsW()
    {
    	return Mage::helper('itags')->getTagW($this->getRequest()->getParam('w'));
    }
    protected function _getPageSize()
    {
    	$pageSize = Mage::getSingleton('iifire_tags/tags')->getPageSize();
    	if ($pageSize) {
    		return $pageSize;
    	} else {
    		return $this->_pageSize;
    	}
    }
}

