<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Syn extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/syn.phtml');
    }
    protected function _prepareLayout()
    {
        $this->setChild('syn_search_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Search Terms Synchronization'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/sysSearch').'\')',
                ))
        );
        $this->setChild('syn_tags_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Tags Synchronization'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/sysTags').'\')',
                ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_syn_grid', 'syn.grid'));
        return parent::_prepareLayout();
        
    }
    public function getSynSearchButtonHtml()
    {
    	return $this->getChildHtml('syn_search_button');
    }
    public function getSynTagsButtonHtml()
    {
    	return $this->getChildHtml('syn_tags_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('Iifire Tags Syn');
    }
}
