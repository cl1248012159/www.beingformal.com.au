<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Adminhtml_Itag_SynController extends Mage_Adminhtml_Controller_Action  
{
    public function indexAction()
    {
        $this->_title($this->__('Synchronization Management'));
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_syn'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_syn_grid')->toHtml());
    }

    public function sysSearchAction()
    {
    	$synSingleton = Mage::getSingleton('iifire_tags/syn');
    	$lastId = $synSingleton->getLastSynId($synSingleton->getSearchType());
    	$searchCollection = Mage::getResourceModel('catalogsearch/query_collection')
				->setOrder('query_id','asc');
    	if ($lastId) {
    		$searchCollection->addFieldToFilter('query_id',array('gt'=>$lastId));
    	}
    	$i = 0;
    	if ($searchCollection->getSize()) {
    		$pkId = false;
    		foreach ($searchCollection as $_c) {
    			$tags = Mage::getModel('iifire_tags/tags');
    			$tags->setStoreId($_c->getStoreId());
    			$tags->loadByTagsText($_c->getQueryText());
    			if (!$tags->getId() && $_c->getStoreId()) {
    				$tags->setStoreId($_c->getStoreId())
	    				->setTagsText($_c->getQueryText());
					try {
						$tags->save();
						$i++;
					} catch (Exception $e) {
						
					}
					$pkId = $_c->getId();
    			}
	    			
    		}
    		if ($pkId) {
	    		$syn = Mage::getModel('iifire_tags/syn')
	    			->setSynType($synSingleton->getSearchType())
	    			->setPkId($pkId);
				try {
					$syn->save();
				} catch (Exception $e) {
					
				}
    		}
    	}
    	if ($i) {
			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been added(Search Terms).',$i));
		} else {
			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) need to Synchronization(Search Terms).',$i));
		}
    	$this->_redirect('*/*/index');
    }
    public function sysTagsAction()
    {
    	$synSingleton = Mage::getSingleton('iifire_tags/syn');
    	$lastId = $synSingleton->getLastSynId($synSingleton->getTagsType());
    	$storeCollection = Mage::getModel('adminhtml/system_store')->getStoreCollection();
    	$pkId = false;
    	$pkIdArray = array();
    	foreach ($storeCollection as $_s) {
	    	$tagsCollection = Mage::getResourceModel('tag/tag_collection')
	    		->join(array('s'=>'summary'),
	    			'main_table.tag_id=s.tag_id',
	    			array('store_id')
	    			)
	            ->addStoresVisibility()
	            ->addFieldToFilter('store_id',$_s->getId())
	            ->addFieldToFilter('status',Mage_Tag_Model_Tag::STATUS_APPROVED)
				->setOrder('tag_id','asc');
			//echo $tagsCollection->getSelect();die();
	    	if ($lastId) {
	    		$tagsCollection->addFieldToFilter('tag_id',array('gt'=>$lastId));
	    	}
	    	$i = 0;
	    	if ($tagsCollection->getSize()) {
	    		foreach ($tagsCollection as $_c) {
	    			$tags = Mage::getModel('iifire_tags/tags');
	    			$tags->setStoreId($_c->getStoreId());
	    			$tags->loadByTagsText($_c->getName());
	    			if (!$tags->getId()&&$_c->getStoreId()) {
	    				$tags->setStoreId($_c->getStoreId())
		    				->setTagsText($_c->getName());
						try {
							$tags->save();
							$i++;
						} catch (Exception $e) {
							
						}
						$pkId = $_c->getId();
	    			}
	    		}
	    		array_push($pkIdArray, $pkId);
	    	}
    	}
    	if (count($pkIdArray)) {
	    		$syn = Mage::getModel('iifire_tags/syn')
	    			->setSynType($synSingleton->getTagsType())
	    			->setPkId(max($pkIdArray));
				try {
					$syn->save();
				} catch (Exception $e) {
					
				}
    		}
    	if ($i) {
			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been added(Tags).',$i));
		} else {
			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) need to Synchronization(Tags).',$i));
		}
    	$this->_redirect('*/*/index');	
    }
    protected function _getSession()
    {
    	return Mage::getSingleton('adminhtml/session');
    }
}