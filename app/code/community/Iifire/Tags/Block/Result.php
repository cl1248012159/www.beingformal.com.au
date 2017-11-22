<?php
class Iifire_Tags_Block_Result extends Mage_Core_Block_Template
{

    public function getDescription()
    {
    	
    	$tags = Mage::getModel('iifire_tags/tags');
		$tags->setStoreId(Mage::app()->getStore()->getId());
		$tags->loadByTagsText($this->helper('catalogsearch')->getEscapedQueryText());
		if ($tags->getId() && trim($tags->getTagsDescription())) {
			return str_replace('{}',"<strong>".$this->helper('catalogsearch')->getEscapedQueryText()."</strong>",$tags->getTagsDescription());
		} else {
			return false;
		}
    }
}
