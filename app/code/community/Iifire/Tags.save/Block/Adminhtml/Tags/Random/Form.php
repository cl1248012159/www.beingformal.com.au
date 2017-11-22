<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Random_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'legend'    => Mage::helper('itags')->__('Important Tags Setting'),
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
        $fieldset->addField('q', 'textarea', array(
            'name'      => 'q',
            'label'     => Mage::helper('itags')->__('Important Tags'),
            'title'     => Mage::helper('itags')->__('Important Tags'),
            'required'  => true,
        ));
	        
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
