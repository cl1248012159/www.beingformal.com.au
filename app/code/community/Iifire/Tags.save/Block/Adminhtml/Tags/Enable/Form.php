<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Enable_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
    }


    protected function _prepareForm()
    {
        $form   = new Varien_Data_Form(array(
            'id'        => 'tags_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));
		
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('itags')->__('Enable Setting'),
            'class'     => 'fieldset-wide'
        ));
		$fieldset->addField('num', 'text', array(
            'name'      => 'num',
            'label'     => Mage::helper('itags')->__('Num'),
            'title'     => Mage::helper('itags')->__('Num'),
            'required'  => true,
            'value'     => 1000,
             
        ));
    	if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label'     => Mage::helper('itags')->__('Visible In'),
                'required'  => true,
                'name'      => 'store_id',
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
            ));
        } else {
            $fieldset->addField('store_ids', 'hidden', array(
                'name'      => 'store_id',
                'value'     => Mage::app()->getStore(true)->getId(),
                
            ));
        }
	        
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
