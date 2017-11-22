<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Sitemap_Edit extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/sitemap/edit.phtml');
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
        $this->setChild('reset_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Reset'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/sitemapProcess').'\')',
                    'class'   => 'reset'
                ))
        );
        $this->setChild('save_generate_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Save'),
                    'onclick' => "$('generate').value=1; editForm.submit();",
            		'class'   => 'add',
                ))
        );
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Save'),
                    'onclick' => "$('generate').value=0; editForm.submit();",
            		'class'   => 'save',
                ))
        );
        return parent::_prepareLayout();
        
    }
    public function getForm()
    {
    	return $this->getLayout()
            ->createBlock('iifire_tags/adminhtml_sitemap_edit_form')
            ->toHtml();
    }
    public function getUpdateUrl()
    {
    	return $this->getUrl('*/*/save');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('New Sitemap');
    }
}
