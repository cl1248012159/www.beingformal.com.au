<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Description_New extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/description/new.phtml');
    }
    protected function _prepareLayout()
    {
    	$this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Back'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/index').'\')',
                    'class'   => 'back'
                ))
        );
       $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Save'),
                    'onclick'   => 'tagsControl.save(\''.$this->getUrl('*/*/save', array('continue'=>false)).'\');',
                    'class'   => 'save'
                ))
        );
        
        $this->setChild('save_continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Save and continue add'),
                    'onclick'   => 'tagsControl.save(\''.$this->getUrl('*/*/save', array('continue'=>true)).'\');',
                    'class'     => 'save',
                ))
        );
        return parent::_prepareLayout();
        
    }
    public function getForm()
    {
    	return $this->getLayout()
            ->createBlock('iifire_tags/adminhtml_tags_description_new_form')
            ->toHtml();
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
    	return $this->getChildHtml('save_continue_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('New Description');
    }
}
