<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Phase_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$id = $this->getRequest()->getParam('id');
		$model = Mage::getModel('iifire_tags/tags')->load($id);
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('iifire_tags')->__('Phase Setting'),
            'class'     => 'fieldset-wide'
        ));
        $fieldset->addField('tags_id', 'hidden', array(
            'name'      => 'tags_id',
            'value'     => $model->getId(),
            
        ));
        $fieldset->addField('store_id', 'hidden', array(
            'name'      => 'store_id',
            'value'     => $model->getStoreId(),
            
        ));
        $fieldset->addField('tags_text', 'text', array(
            'name'      => 'tags_text',
            'label'     => Mage::helper('iifire_tags')->__('Tags'),
            'title'     => Mage::helper('iifire_tags')->__('Tags'),
            'value'     => $model->getTagsText(),
            'required'  => true,
        ));
        $fieldset->addField('tags_phase', 'textarea', array(
            'name'      => 'tags_phase',
            'label'     => Mage::helper('iifire_tags')->__('Phase'),
            'title'     => Mage::helper('iifire_tags')->__('Phase'),
            'required'  => true,
            'value'     => $model->getTagsPhase(),
        ));
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
