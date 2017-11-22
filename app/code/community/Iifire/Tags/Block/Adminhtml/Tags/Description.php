<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Description extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/description.phtml');
    }
    protected function _prepareLayout()
    {
    	$this->setChild('new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('New Description'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/add').'\')',
                    'class'   => 'add'
                ))
        );
        $this->setChild('asign_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Asign Description'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/asignProcess').'\')',
                    'class'   => 'save'
                ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_description_grid', 'description.grid'));
        return parent::_prepareLayout();
        
    }
    public function getNewButtonHtml()
    {
        return $this->getChildHtml('new_button');
    }
    public function getAsignButtonHtml()
    {
        return $this->getChildHtml('asign_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('Description List');
    }
}
