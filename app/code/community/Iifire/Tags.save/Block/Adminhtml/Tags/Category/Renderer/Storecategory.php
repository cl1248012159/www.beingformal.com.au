<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.iifire.org)
 * @copyright Copyright &copy; 2011, IIFire (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */ 
class Iifire_Tags_Block_Adminhtml_Tags_Category_Renderer_Storecategory extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	$storeCategories = Mage::getSingleton('iifire_tags/category')->getStoreCategories();
        $idString = $row->getStoreCategory();
        $ids = explode(',',$idString);
        $output = '';
        foreach ($ids as $id) {
        	if (array_key_exists($id,$storeCategories)) {
        		$output .= $storeCategories[$id].'['.$id.']<br/>';
        	}
        }
        return $output;
    }
}
