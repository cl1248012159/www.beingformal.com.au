<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Phase_New extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/phase/new.phtml');
    }


    protected function _prepareLayout()
    {
    	$this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('iifire_tags')->__('Back'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/index').'\')',
                    'class'   => 'back'
                ))
        );
        if (!$this->isEditMode()) {
        	$saveUrl = $this->getUrl('*/*/save', array('continue'=>false));
        } else {
        	$saveUrl = $this->getUrl('*/*/post');
        }
       $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('iifire_tags')->__('Save'),
                    'onclick'   => 'phaseControl.save(\''.$saveUrl.'\');',
                    'class'   => 'save'
                ))
        );
        
        $this->setChild('save_continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('iifire_tags')->__('Save and continue add'),
                    'onclick'   => 'phaseControl.continue(\''.$this->getUrl('*/*/save', array('continue'=>true)).'\');',
                    'class'     => 'save',
                ))
        );
        return parent::_prepareLayout();
        
    }
    public function getForm()
    {
		if (!$this->isEditMode()) {
    		return $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_new_form')->toHtml();
		} else {
			return $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_edit_form')->toHtml();
		}
    }
    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }
    public function getSaveButtonHtml()
    {
    	return $this->getChildHtml('save_button');
    }
    public function getSaveContinueButtonHtml()
    {
    	if (!$this->isEditMode()) {
    		return $this->getChildHtml('save_continue_button');
    	} else {
    		return;
    	}
    	
    }
    public function isEditMode()
    {
    	$id = $this->getRequest()->getParam('id');
		if (!isset($id)) {
			return false;
		} else {
			return true;
		}
    }
    public function getHeaderText()
    {
		if (!$this->isEditMode()) {
			return Mage::helper('iifire_tags')->__('New Phase');
		} else {
			return Mage::helper('iifire_tags')->__('Edit Phase');
		}
    }
}
