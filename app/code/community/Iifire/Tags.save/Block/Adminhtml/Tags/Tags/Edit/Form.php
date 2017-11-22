<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Tags_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$tags = Mage::getModel('iifire_tags/tags')->load($this->getRequest()->getParam('id'));
		$fieldset->addField('tags_id', 'hidden', array(
            'name'      => 'tags_id',
            'value'     => $tags->getId(),
            
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label'     => Mage::helper('itags')->__('Choose Store'),
                'required'  => true,
                'name'      => 'store_id',
                'value'     => $tags->getStoreId(),
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
            'value'     => $tags->getTagsType(),
            'values'    => array('1'=>Mage::helper('itags')->__('Enable'),'0'=>Mage::helper('itags')->__('Disable')),
        ));
        $categories = Mage::getSingleton('iifire_tags/category')->getCategoryAsOption(true);
        if (is_array($categories) && count($categories)>1) {
	        $fieldset->addField('category_id', 'select', array(
	            'name'      => 'category_id',
	            'label'     => Mage::helper('itags')->__('Category'),
	            'title'     => Mage::helper('itags')->__('Category'),
	            'required'  => false,
	            'value'     => $tags->getCategoryId(),
	            'values'    => $categories,
	        ));
        }
        $fieldset->addField('tags_text', 'text', array(
            'name'      => 'tags_text',
            'label'     => Mage::helper('itags')->__('Tags'),
            'title'     => Mage::helper('itags')->__('Tags'),
            'value'     => $tags->getTagsText(),
            'required'  => true,
        ));
	    $fieldset->addField('tags_description', 'textarea', array(
            'name'      => 'tags_description',
            'label'     => Mage::helper('itags')->__('Description'),
            'title'     => Mage::helper('itags')->__('Description'),
            'value'     => $tags->getTagsDescription(),
            'required'  => false,
        ));    
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
