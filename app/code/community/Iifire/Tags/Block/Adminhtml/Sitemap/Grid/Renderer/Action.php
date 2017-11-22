<?php
class Iifire_Tags_Block_Adminhtml_Sitemap_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $this->getColumn()->setActions(array(array(
            'url'     => $this->getUrl('*/*/generate', array('sitemap_id' => $row->getSitemapId())),
            'caption' => Mage::helper('itags')->__('Generate'),
        )));
        return parent::render($row);
    }
}
