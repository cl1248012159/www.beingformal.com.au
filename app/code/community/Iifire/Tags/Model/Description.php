<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Description extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('iifire_tags/description','description_id');
    }
    public function asignDescription()
    {
    	$storeId = Mage::app()->getStore()->getId();
    	$descriptionCollection = $this->getCollection()
    		->addFieldToFilter('store_id',$storeId);
		$tagsCollection = Mage::getModel('itags/tags')->getCollection()
			->addFieldToFilter('store_id',$storeId)
			->addFieldToFilter('tags_description',array('notnull'=>"true"));
		if(count($tagsCollection)) {
			foreach ($tagsCollection as $tag) {
				$tag = Mage::getModel('itags/tags');
				$description = array_rand($tagsCollection);
				$tag->setDescription($description->getContent());
				try {
					$tag->save();
				} catch (Exception $e) {
					//
				}
			}
		}
    }
}
