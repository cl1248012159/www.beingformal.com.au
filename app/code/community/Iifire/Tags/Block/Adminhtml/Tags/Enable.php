<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Enable extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/enable.phtml');
    }


    protected function _prepareLayout()
    {
        $this->setChild('new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('itags')->__('Save'),
                    'onclick'   => 'tagsControl.save(\''.$this->getUrl('*/*/enableTags', array('continue'=>false)).'\');',
                    'class'   => 'save'                
            ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_category_grid', 'category.grid'));
        return parent::_prepareLayout();
        
    }
    public function getForm()
    {
    	return $this->getLayout()
            ->createBlock('iifire_tags/adminhtml_tags_enable_form')
            ->toHtml();
    }
    
    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('new_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('Enable Tags');
    }
}
