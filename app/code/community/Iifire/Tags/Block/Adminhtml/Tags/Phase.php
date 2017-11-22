<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Phase extends Mage_Adminhtml_Block_Template
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
                    'label'   => Mage::helper('iifire_tags')->__('New Phase'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/add').'\')',
                    'class'   => 'add'
                ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_tags_phase_grid', 'phase.grid'));
        return parent::_prepareLayout();
        
    }
    public function getNewButtonHtml()
    {
        return $this->getChildHtml('new_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('iifire_tags')->__('Tags/Phase List');
    }
}
