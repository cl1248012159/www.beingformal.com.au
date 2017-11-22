<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Tags extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/index.phtml');
    }
    protected function _prepareLayout()
    {
    	$this->setChild('new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('New Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/add').'\')',
                    'class'   => 'add'
                ))
        );
        
        $this->setChild('enable_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Enable Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/enableProcess').'\')',
                    'class'   => 'add'
                ))
        );
        
        $this->setChild('random_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Add Important Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/random').'\')',
                    'class'   => 'add'
                ))
        );
        
        $this->setChild('reset_product_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Reset Tags Products'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/resetTagsProducts').'\')',
                ))
        );
        
        $this->setChild('reset_important_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Reset Important Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/resetImportantTags').'\')',
                ))
        );
        
        $this->setChild('cancal_important_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Cancel Important Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/cancelImportantProcess').'\')',
                ))
        );
        
        $this->setChild('reset_description_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Reset Description'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/resetDescription').'\')',
                ))
        );
        
        $this->setChild('random_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Add Important Tags'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/random').'\')',
                    'class'   => 'add'
                ))
        );
       
       $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_tags_grid', 'tags.grid'));
        return parent::_prepareLayout();
        
    }
    public function getNewButtonHtml()
    {
        return $this->getChildHtml('new_button');
    }
    public function getRandomButtonHtml()
    {
        return $this->getChildHtml('random_button');
    }
    
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('Iifire Tags List');
    }
}
