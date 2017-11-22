<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Category_New extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/category/new.phtml');
    }
    protected function _prepareLayout()
    {
		$this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Back'),
                    'onclick'   => "window.location.href = '" . $this->getUrl('*/*/') . "'",
                    'class'     => 'back'
                ))
        );

        $this->setChild('reset_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Reset'),
                    'onclick'   => 'window.location.href = window.location.href'
                ))
        );
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Save'),
                    'onclick'   => 'categoryControl.save();',
                    'class'     => 'save'
                ))
        );
        $this->setChild('continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Save and Continue'),
                    'onclick'   => 'categoryControl.continue();',
                    'class'     => 'save'
                ))
        );
    }
    public function getContinueButtonHtml()
    {
        return $this->getChildHtml('continue_button');
    }
    /**
     * Retrieve Back Button HTML
     *
     * @return string
     */
    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }

    /**
     * Retrieve Reset Button HTML
     *
     * @return string
     */
    public function getResetButtonHtml()
    {
        return $this->getChildHtml('reset_button');
    }

    /**
     * Retrieve Save Button HTML
     *
     * @return string
     */
    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }
    public function getForm()
    {
        return $this->getLayout()
            ->createBlock('iifire_tags/adminhtml_tags_category_new_form')
            ->toHtml();
    }
    public function getHeaderText()
    {
    	if ($this->getRequest()->getParam('id')) {
    		return Mage::helper('itags')->__('Edit Tags Category');
    	} else {
    		return Mage::helper('itags')->__('Add Tags Category');
    	}
        
    }
}
