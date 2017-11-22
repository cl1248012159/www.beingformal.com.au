<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Tags_New_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'legend'    => Mage::helper('itags')->__('Tags Setting'),
            'class'     => 'fieldset-wide'
        ));
		
		if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label'     => Mage::helper('itags')->__('Choose Store'),
                'required'  => true,
                'name'      => 'store_id',
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'store_id',
                'value'     => Mage::app()->getStore(true)->getId(),
            ));
        }
        $fieldset->addField('tags_type', 'select', array(
            'name'      => 'tags_type',
            'label'     => Mage::helper('itags')->__('Status'),
            'title'     => Mage::helper('itags')->__('Status'),
            'required'  => true,
            'value'     => 1,
            'values'    => array('1'=>Mage::helper('itags')->__('Enable'),'0'=>Mage::helper('itags')->__('Disable')),
        ));
        $categories = Mage::getSingleton('iifire_tags/category')->getCategoryAsOption(true);
        if (is_array($categories) && count($categories)>1) {
	        $fieldset->addField('category_id', 'select', array(
	            'name'      => 'category_id',
	            'label'     => Mage::helper('itags')->__('Category'),
	            'title'     => Mage::helper('itags')->__('Category'),
	            'required'  => false,
	            'values'    => $categories,
	        ));
        }
        $fieldset->addField('q_important', 'select', array(
            'name'      => 'q_important',
            'label'     => Mage::helper('itags')->__('Important'),
            'title'     => Mage::helper('itags')->__('Important'),
            'required'  => true,
            'value'     => 1,
            'values'    => array('1'=>Mage::helper('itags')->__('Enable'),'0'=>Mage::helper('itags')->__('Disable')),
        ));
        
    	$fieldset->addField('q', 'textarea', array(
            'name'      => 'q',
            'label'     => Mage::helper('itags')->__('Tags'),
            'title'     => Mage::helper('itags')->__('Tags'),
            'required'  => true,
        ));

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
