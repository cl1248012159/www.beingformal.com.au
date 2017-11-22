<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Description_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function _prepareForm()
    {
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('itags')->__('Description Setting'),
            'class'     => 'fieldset-wide'
        ));
		$description = Mage::getModel('iifire_tags/description')->load($this->getRequest()->getParam('id'));
		$fieldset->addField('description_id', 'hidden', array(
            'value'     => $description->getId(),
            'name'      => 'description_id',
        ));
		if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label'     => Mage::helper('itags')->__('Choose Store'),
                'required'  => true,
                'name'      => 'store_id',
                'value'     => $description->getStoreId(),
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'store_id',
                'value'     => Mage::app()->getStore(true)->getId(),
                
            ));
        }
        $categories = Mage::getSingleton('iifire_tags/category')->getCategoryAsOption(true);
        if (is_array($categories) && count($categories)>1) {
	        $fieldset->addField('category_id', 'select', array(
	            'name'      => 'category_id',
	            'label'     => Mage::helper('itags')->__('Category'),
	            'title'     => Mage::helper('itags')->__('Category'),
	            'required'  => false,
	            'value'     => $description->getCategoryId(),
	            'values'    => $categories,
	        ));
        }
        $fieldset->addField('content', 'textarea', array(
            'name'      => 'content',
            'label'     => Mage::helper('itags')->__('Description'),
            'title'     => Mage::helper('itags')->__('Description'),
            'required'  => true,
            'value'     => $description->getContent(),
        ));
	        
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
