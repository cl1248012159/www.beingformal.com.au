<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Adminhtml_Itag_PhaseController extends Mage_Adminhtml_Controller_Action  
{
    public function indexAction() 
    {
    	$id = $this->getRequest()->getParam('id');
		if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
		$this->_title($this->__('Phase List'));
    	
    	$this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_grid')->toHtml());
    }
    public function postAction()
    {
    	$id = $this->getRequest()->getParam('tags_id');
    	$text = trim($this->getRequest()->getParam('tags_text'));
    	$phase = $this->getRequest()->getParam('tags_phase');
    	if ($id && $text) {
    		$tags = Mage::getModel('iifire_tags/tags')->load($id);
    		if ($tags->getId()) {
    			$tags->setTagsText($text)
    				->setTagsPhase($phase);
				try {
					$tags->save();
					$this->_getSession()->addSuccess(
		                Mage::helper('iifire_tags')->__('record have been updated')
		            );
				} catch (Exception $e) {
					$this->_getSession()->addError(Mage::helper('iifire_tags')->__('An error occurred when edit record.'));
				}
    		}
    	} else {
    		$this->_getSession()->addError(Mage::helper('iifire_tags')->__('Tags text can not be null.'));
    	}
		$this->_redirect('*/*/index');
    }

    public function addAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	if ($id) {
    		$this->_title($this->__('Edit Phase'));
    	} else {
    		$this->_title($this->__('New Phase'));
    	}
    	$this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_new'));
        $this->renderLayout();
    }
    public function saveAction()
    {
    	$qs = trim($this->getRequest()->getParam('tags_phase'));
    	$storeId = (int)$this->getRequest()->getParam('store_id');
    	if ($qs) {
    		$qArr = explode("\n",$qs);
    		$i = 0;
    		$j = 0;
    		foreach ($qArr as $_q) {
    			$_q = explode("{",$_q,2);
    			if (is_array($_q) && count($_q==2)){
	    			$_k = trim($_q[0]);
	    			$_k = ltrim($_k, '"');
	    			$_k = rtrim($_k, '"');
	    			$_p = trim($_q[1]);
	    			$_p = rtrim($_p, '}');
	    			if ($_k && $_p) {
		    			$tags = Mage::getModel('iifire_tags/tags');
		    			$tags->setStoreId($storeId);
		    			$tags->loadByTagsText($_k);
		    			if (!$tags->getId()) {
		    				$tags->setTagsText($_k)
		    					->setTagsPhase($_p);
	    					try {
	    						$tags->save();
	    						$i++;
	    					} catch (Exception $e) {
	    						
	    					}	
		    			} else {
		    				if ($tags->getTagsPhase()) {
		    					$tmp = true;
		    				} else {
		    					$tmp = false;
		    				}
		    				$tags->setTagsPhase($_p);
		    				try {
	    						$tags->save();
	    						if ($tmp) {
	    							$j++;
	    						} else {
	    							$i++;
	    						}
	    						
	    					} catch (Exception $e) {
	    						
	    					}	
		    			}
	    			}
    			}
    		}
	    	if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('iifire_tags')->__('%d record(s) have been added.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('iifire_tags')->__('%d record(s) have can not save.',$j));
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
    		 $tags->setTagsPhase();
    		 $tags->save();
    		 $this->_getSession()->addSuccess(
                Mage::helper('iifire_tags')->__('1 record have been deleted.')
            );
    	} catch(Exception $e) {
    		$this->_getSession()->addError(Mage::helper('iifire_tags')->__('An error occurred when delete record.'));
    	}
    	$this->_redirect('*/*/phases');
    }
    public function massDeleteAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
        	$j = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/tags')->load($id);
                    if ($model->getId()) {
                        $model->setTagsPhase();
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
    			$this->_getSession()->addSuccess(Mage::helper('iifire_tags')->__('%d record(s) have been deleted.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('iifire_tags')->__('%d record(s) have can not delete.',$j));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function exportCsvAction()
    {
        $fileName   = 'tags_phase.csv';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_export')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    public function exportXmlAction()
    {
        $fileName   = 'tags_phase.xml';
        $content    = $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_export')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    protected function _getSession()
    {
    	return Mage::getSingleton('adminhtml/session');
    }
}