<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Adminhtml_Itag_IndexController extends Mage_Adminhtml_Controller_Action  
{
    public function indexAction()
    {
        $this->_title($this->__('Tags Management'));
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags'));
        
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_grid')->toHtml());
    }
    public function addAction()
    {
        $this->_title($this->__('New Tags'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_new'));
        $this->renderLayout();
    }
    public function editAction()
    {
        $this->_title($this->__('Edit Tags'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_edit'));
        $this->renderLayout();
    }
    public function postAction()
    {
    	$id = $this->getRequest()->getParam('tags_id');
    	$text = trim($this->getRequest()->getParam('tags_text'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	$description = $this->getRequest()->getParam('tags_description');
    	$categoryId = (int)$this->getRequest()->getParam('category_id');
    	$tagsType = (int)$this->getRequest()->getParam('tags_type');
    	if ($id && $text) {
    		$tags = Mage::getModel('iifire_tags/tags')->load($id);
    		if ($tags->getId()) {
    			$tags->setTagsText($text)
    				->setStoreId($storeId)
    				->setTagsType($tagsType)
    				->setTagsDescription($description);
				try {
					if ($categoryId) {
    					$tags->setCategoryId($categoryId);
    				}
					$tags->save();
					$this->_getSession()->addSuccess(
		                Mage::helper('itags')->__('1 record have been updated')
		            );
				} catch (Exception $e) {
					$this->_getSession()->addError(Mage::helper('itags')->__('An error occurred when edit record.'));
				}
    		}
    	} else {
    		$this->_getSession()->addError(Mage::helper('itags')->__('Tags text can not be null.'));
    	}
		$this->_redirect('*/*/index');  	
    }
    public function saveAction()
    {
    	$q = trim($this->getRequest()->getParam('q'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	$categoryId = (int)$this->getRequest()->getParam('category_id');
    	$tagsType = (int)$this->getRequest()->getParam('tags_type');
    	if ($q) {
    		$qArr = explode("\n",$q);
    		$i = 0;
    		$j = 0;
    		foreach ($qArr as $_q) {
    			$_q = trim($_q);
    			$_q = ltrim($_q, '"');
    			$_q = rtrim($_q, '"');
    			if ($_q) {
	    			$tags = Mage::getModel('iifire_tags/tags');
	    			$tags->setStoreId($storeId);
	    			$tags->loadByTagsText($_q);
	    			if (!$tags->getId()) {
	    				$tags->setTagsText(str_replace('_','-',$_q));
	    				if ($categoryId) {
	    					$tags->setCategoryId($categoryId);
	    				}
	    				$tags->setTagsType($tagsType);
    					try {
    						$tags->save();
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

    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$tags = Mage::getModel('iifire_tags/tags')->load($id);
    	try {
    		 $tags->delete();
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
            		$model = Mage::getModel('iifire_tags/tags')
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
    public function resetProductRelateTagsAction()
    {
    	$productIds = Mage::getModel('catalog/product')->getCollection()->getAllIds();
    	$attributeData = array('meta_keyword' => '');
    	try {
			Mage::getSingleton('catalog/product_action')
				->updateAttributes($productIds, $attributeData, 0);
    		$this->_getSession()->addSuccess(Mage::helper('itags')->__('Products tags have been reset.'));
    	} catch (Exception $e) {
    		
    	}
    	$this->_redirect('*/*/index');
    }
    public function massRandomAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
        	$j = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/tags')
                        ->load($id);
                    $model->setIsImportant(1);
                    try {
                    	$model->save();
                    	$i++;
                    } catch (Exception $e) {
                    	$j++;
                    }
                   
            	} 
            }
            if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been updated.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) have can not updated.',$j));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function enableProcessAction()
	{
		$this->_title($this->__('Enable Tags'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_enable'));
        $this->renderLayout();
	}
	public function enableTagsAction()
	{
		$origNum = 1000;
		$storeId = (int)$this->getRequest()->getParam('store_id');
		$num = (int)$this->getRequest()->getParam('num');
		$num = $num ? $num : $origNum;
		
		if ($storeId) {	
			$i = 0;
			$tagsCollection = Mage::getModel('iifire_tags/tags')->getCollection()
				->addFieldToFilter('store_id',$storeId)
				->addFieldToFilter('tags_type',0)
				->setPageSize($num)
				->setCurPage(1);
			foreach ($tagsCollection as $tag) {
				
				$tag->setTagsType(1);
				try {
					$tag->save();
					$i++;
				} catch (Exception $e) {
					
				}
			}
			if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been enabled.',$i));
    		} 
		}
		$this->_redirect('*/*/index');
	}
    public function randomAction()
    {
        $this->_title($this->__('Add Important Tags'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_random'));
        $this->renderLayout();
    }
    public function cancelImportantProcessAction()
    {
    	$this->_title($this->__('Cancel Important Tags'));
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_random_cancel'));
        $this->renderLayout();
    }
    
    public function cancelRandomAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
        	$j = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/tags')
                        ->load($id);
                    if ($model->getIsRandom()) {
                    	$model->setIsImportant(0);
	                    try {
	                    	$model->save();
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
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been updated.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) have can not updated.',$j));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function massEnableAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/tags')
                        ->load($id);
                    if (!$model->getTagsType()) {
                    	$model->setTagsType(1);
	                    try {
	                    	$model->save();
	                    	$i++;
	                    } catch (Exception $e) {
	                    	
	                    }
                    }
            	} 
            }
            if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been enable.',$i));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function massDisableAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/tags')
                        ->load($id);
                    if ($model->getTagsType()) {
                    	$model->setTagsType(0);
	                    try {
	                    	$model->save();
	                    	$i++;
	                    } catch (Exception $e) {
	                    	
	                    }
                    }
            	} 
            }
            if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been enable.',$i));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function SaveRandomAction()
    {
		$q = trim($this->getRequest()->getParam('q'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	if ($q) {
    		$qArr = explode("\n",$q);
    		$i = 0;
    		$j = 0;
    		foreach ($qArr as $_q) {
    			$_q = trim($_q);
    			$_q = ltrim($_q, '"');
    			$_q = rtrim($_q, '"');
    			if ($_q) {
	    			$tags = Mage::getModel('iifire_tags/tags');
	    			$tags->setStoreId($storeId);
	    			$tags->loadByTagsText(str_replace('_','-',$_q));
	    			
    				if (!$tags->getId()) {
    					$tags->setTagsText(str_replace('_','-',$_q));
       				} else {
    					$tags2 = Mage::getModel('iifire_tags/tags')->load($tags->getId());
    				}
    				
    				$tags->setIsImportant(1);
					try {
						$tags->save();
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
    		$this->_redirect('*/*/random');
    	} else {
    		$this->_redirect('*/*/index');
    	}
    }

    public function exportCsvAction()
    {
        $fileName   = 'tags.csv';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_export')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    public function exportXmlAction()
    {
        $fileName   = 'tags.xml';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_export')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    //Varien_Db_Adapter_Pdo_Mysql
    public function resetDescriptionAction()
    {
    	$resource = Mage::getSingleton('core/resource');
    	$write = $resource->getConnection('core_write');
		try {
			$write->query("update {$resource->getTableName('iifire_tags')} set tags_description=NULL;");
			$this->_getSession()->addSuccess(Mage::helper('itags')->__('Reset Description Success.'));
		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		$this->_redirect('*/*/index');
    }
    public function resetTagsProductsAction()
    {
    	
    	$resource = Mage::getSingleton('core/resource');
    	$write = $resource->getConnection('core_write');
		try {
			$write->query("update {$resource->getTableName('iifire_tags')} set tags_products=NULL;");
			$this->_getSession()->addSuccess(Mage::helper('itags')->__('Reset Tags Products Success.'));
		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		$this->_redirect('*/*/index');
    }
    
    public function resetImportantTagsAction()
    {
    	$resource = Mage::getSingleton('core/resource');
    	$write = $resource->getConnection('core_write');
		try {
			$write->query("update {$resource->getTableName('iifire_tags')} set random_tags=NULL;");
			
			$attributeCode = 'product_related_tags';
			$entityType = Mage::getModel('eav/config')->getEntityType('catalog_product');
	        $entityTypeId = $entityType->getEntityTypeId();
	        $product = Mage::getModel('catalog/product');
	        $attribute = $product->getResource()->getAttribute($attributeCode);
	        $attributeOptions = array();
	        if($attribute) {
	            $productIds = Mage::getResourceModel('catalog/product_collection')->getAllIds();
				$attributeData = array($attributeCode => NULL);
				$storeId = 0;
				Mage::getSingleton('catalog/product_action')->updateAttributes($productIds, $attributeData, $storeId);
	        }
			$this->_getSession()->addSuccess(Mage::helper('itags')->__('Reset Important Tags Success.'));
		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		$this->_redirect('*/*/index');
    }
    public function cancelImportantTagsAction()
    {
    	$q = trim($this->getRequest()->getParam('q'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	if ($q) {
    		$qArr = explode("\n",$q);
    		$i = 0;
    		foreach ($qArr as $_q) {
    			$_q = trim($_q);
    			$_q = ltrim($_q, '"');
    			$_q = rtrim($_q, '"');
    			if ($_q) {
	    			$tags = Mage::getModel('iifire_tags/tags');
	    			$tags->setStoreId($storeId);
	    			$tags->loadByTagsText(str_replace('_','-',$_q));
    				if ($tags->getId()) {
    					$tags2 = Mage::getModel('iifire_tags/tags')->load($tags->getId());
    					$tags->setIsImportant(0);
						try {
							$tags->save();
							$i++;
						} catch (Exception $e) { }
       				}	    			
    			}
    		}
    		if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been cancel.',$i));
    		}
    	}
    	
    	if ($this->getRequest()->getParam('continue')) {
    		$this->_redirect('*/*/cancelImportantProcess');
    	} else {
    		$this->_redirect('*/*/index');
    	}
    }
    
    protected function _getSession()
    {
    	return Mage::getSingleton('adminhtml/session');
    }
}