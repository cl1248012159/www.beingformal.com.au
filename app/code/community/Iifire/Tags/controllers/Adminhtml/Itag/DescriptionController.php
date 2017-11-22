<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Adminhtml_Itag_DescriptionController extends Mage_Adminhtml_Controller_Action  
{
    public function indexAction()
    {
        $this->_title($this->__('Description Management'));
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_grid')->toHtml());
    }
    public function addAction()
    {
        $this->_title($this->__('New Description'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_new'));
        $this->renderLayout();
    }
    public function editAction()
    {
        $this->_title($this->__('Edit Description'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_edit'));
        $this->renderLayout();
    }
    public function asignProcessAction()
    {
        $this->_title($this->__('Asign Description'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_asign'));
        $this->renderLayout();
    }

    public function saveAction()
    {
    	$q = trim($this->getRequest()->getParam('content'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	$categoryId = (int)$this->getRequest()->getParam('category_id');
    	if ($q) {
    		$qArr = explode("\n",$q);
    		$i = 0;
    		$j = 0;
    		foreach ($qArr as $_q) {
    			$_q = trim($_q);
    			$_q = ltrim($_q, '"');
    			$_q = rtrim($_q, '"');
    			if ($_q) {
	    			$description = Mage::getModel('iifire_tags/description');
	    			$description->setStoreId($storeId);
	    			$description->setContent($_q);
	    			if ($categoryId) {
	    				$description->setCategoryId($categoryId);
	    			}
					try {
						$description->save();
						$i++;
					} catch (Exception $e) {
						$j++;
					}	
	    			
    			}
    		}
    		if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been added.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) have can not save.',$j));
    		}
    	}
    	if ($this->getRequest()->getParam('continue')) {
    		$this->_redirect('*/*/add');
    	} else {
    		$this->_redirect('*/*/index');
    	}
    }
    public function postAction()
    {
    	$content = trim($this->getRequest()->getParam('content'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	$categoryId = (int)$this->getRequest()->getParam('category_id');
    	$descriptionId = (int)$this->getRequest()->getParam('description_id');
    	if ($descriptionId && $content) {
			$description = Mage::getModel('iifire_tags/description')->load($descriptionId);
			if ($description->getId()) {
				$description->setStoreId($storeId);
    			$description->setContent($content);
    			if ($categoryId) {
    				$description->setCategoryId($categoryId);
    			}
				try {
					$description->save();
					$this->_getSession()->addSuccess(Mage::helper('itags')->__('Description save successfully.'));
				} catch (Exception $e) {
					$this->_getSession()->addError(Mage::helper('itags')->__('Description save failed.'));
				}
			} else {
				$this->_getSession()->addError(Mage::helper('itags')->__('Description not exist.'));
			}

    	}
		$this->_redirect('*/*/index');
    }
	public function asignAction()
	{
		$storeId = (int)$this->getRequest()->getParam('store_id');
		
		if ($storeId) {
			$categoryIds = array();
			$categoryIds = Mage::getSingleton('iifire_tags/category')->getCategoryIds($storeId);
			
        	if (is_array($categoryIds) && count($categoryIds)) {
        		array_push($categoryIds,NULL);
        		
        		$i = 0;
        		foreach ($categoryIds as $_id) {
        			
			    	$descriptionCollection = Mage::getModel('iifire_tags/description')->getCollection()
			    		->addFieldToFilter('store_id',$storeId);
		    		if ($_id) {
		    			$descriptionCollection->addFieldToFilter('category_id',$_id);
		    		} else {
		    			$descriptionCollection->addFieldToFilter('category_id',array('null'=>true));
		    		}
			    		
					$descriptionArray = array();
					if(count($descriptionCollection)) {
						foreach ($descriptionCollection as $d) {
							array_push($descriptionArray,$d);
						}
					}
					$tagsCollection = Mage::getModel('iifire_tags/tags')->getCollection()
						->addFieldToFilter('store_id',$storeId);
					if ($_id) {	
						$tagsCollection->addFieldToFilter('category_id',$_id);
					} else {
						$tagsCollection->addFieldToFilter('category_id',array('null'=>true));
					}
					$tagsCollection->addFieldToFilter('tags_description',array('null'=>TRUE))
						->setPageSize(10000)
			    		->setCurPage(1);
					
					if(count($tagsCollection) && count($descriptionArray)) {
						foreach ($tagsCollection as $tag) {
							shuffle($descriptionArray);
							$tag->setTagsDescription($descriptionArray[0]->getContent());
							try {
								$tag->save();
								$i++;
							} catch (Exception $e) {
								$this->_getSession()->addError($e->getMessage());
							}
						}
					}
        		}
				$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d tags have asign decription',$i));
			}
		}
		$this->_redirect('*/*/index');
	}
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$description = Mage::getModel('iifire_tags/description')->load($id);
    	try {
    		 $description->delete();
    		 $this->_getSession()->addSuccess(
                Mage::helper('itags')->__('1 record have been deleted.')
            );
    	} catch(Exception $e) {
    		$this->_getSession()->addError(Mage::helper('itags')->__('An error occurred.'));
    	}
    	$this->_redirect('*/*/index');
    }
    public function massDeleteAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
        	$j = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/description')
                        ->load($id);
                    if ($model->getId()) {
                        try {
                        	$model->delete();
                        	$i++;
                        } catch (Exception $e) {
                        	$j++;
                        }
                    } else {
                    	$j++;
                    }
            	} 
            }
            if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been deleted.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) have can not delete.',$j));
    		}
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'description.csv';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_export')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    public function exportXmlAction()
    {
        $fileName   = 'description.xml';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_export')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    protected function _getSession()
    {
    	return Mage::getSingleton('adminhtml/session');
    }
}