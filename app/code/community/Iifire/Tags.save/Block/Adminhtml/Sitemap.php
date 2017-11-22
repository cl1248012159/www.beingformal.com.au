<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Sitemap extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iifire/tags/sitemap.phtml');
    }
    protected function _prepareLayout()
    {
        $this->setChild('sitemap_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('itags')->__('Add Sitemap'),
                    'onclick' => 'setLocation(\''.$this->getUrl('*/*/sitemapProcess').'\')',
                	'class'   => 'add',
                ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('iifire_tags/adminhtml_sitemap_grid', 'sitemap.grid'));
        return parent::_prepareLayout();
    }
    public function getSitemapButtonHtml()
    {
    	return $this->getChildHtml('sitemap_button');
    }
    public function getHeaderText()
    {
        return Mage::helper('itags')->__('Sitemap Management');
    }
}
