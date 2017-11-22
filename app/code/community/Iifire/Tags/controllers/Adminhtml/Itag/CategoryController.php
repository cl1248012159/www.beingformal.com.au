<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.iifire.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Adminhtml_Itag_CategoryController extends Mage_Adminhtml_Controller_Action  
{
    public function indexAction()
    {
        $this->_title($this->__('Tags Category Management'));
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();
        
        $this->_setActiveMenu('catalog');
        
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_category', 'tags.category'));
        $this->renderLayout();
    }
    public function addAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
    	if ($id = $this->getRequest()->getParam('id')) {
    		$this->_title($this->__('Edit Tags Category'));
    	} else {
    		$this->_title($this->__('Add Tags Category'));
    	}
        
        $this->loadLayout();
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_category_new', 'tags.category.new'));
        $this->renderLayout();
    }
    public function massDeleteAction()
    {
        $ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
            try {
            	$i = 0;
                foreach ($ids as $id) {
                	if($id) {
                		$model = Mage::getModel('iifire_tags/category')
	                        ->load($id);
	                    if ($model->getId()) {
                            $model->delete();
	                    }
	                    $i++;
                	} 
                }
                $this->_getSession()->addSuccess(
                    Mage::helper('itags')->__('Total of %d record(s) have been deleted.', $i)
                );
               
            } catch (Mage_Core_Exception $e) {
				 $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
				$session->addException($e, Mage::helper('itags')->__('An error occurred when delete record.'));
            }
        }
        $this->_redirect('*/*/index');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_tags_category_grid')->toHtml());
    }
    public function saveAction()
    {
    	$request = $this->getRequest();
    	$id = (int)$request->getParam('category_id');
    	$name = $request->getParam('category_name');
    	$storeCategory = $request->getParam('store_category');
    	$storeId = (int)$request->getParam('store_id');
    	if ($name) {
    		$categoryModel = Mage::getModel('iifire_tags/category');
			if ($id) {
				$categoryModel = $categoryModel->load($id);
			}
			$categoryModel->setStoreId($storeId)
				->setStoreCategory($storeCategory)
				->setCategoryName($name);
			try {
				$categoryModel->save();
				if (!$id) {
					$this->_getSession()->addSuccess(Mage::helper('itags')->__("Category added successfully."));
				} else {
					$this->_getSession()->addSuccess(Mage::helper('itags')->__("Category Save successfully."));
				}
				
			} catch (Exception $e) {
				if (!$id) {
					$this->_getSession()->addError(Mage::helper('itags')->__("Category added failed."));
				} else {
					$this->_getSession()->addError(Mage::helper('itags')->__("Category Save failed."));
				}
			}
    		
    	} else {
    		$this->_getSession()->addError(Mage::helper('itags')->__("Category Name cann't be null."));
    	}
    	if ($request->getParam('continue')) {
    		$this->_redirect('*/*/edit',array('id'=>$id));
    	} else {
    		$this->_redirect('*/*/index');
    	}
    }
}