<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Category_New_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'id'        => 'category_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));
		$model = Mage::getModel('iifire_tags/category');
		if ($id = $this->getRequest()->getParam('id')) {
			$model = $model->load($id);
		}
		
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('itags')->__('Category Setting'),
        ));
        if ($model->getId()) {
            $fieldset->addField('category_id', 'hidden', array(
                'name'      => 'category_id',
                'value'     => $model->getId(),
            ));
        }
        
		$fieldset->addField('category_name', 'text', array(
            'name'      => 'category_name',
            'label'     => Mage::helper('itags')->__('Category Name'),
            'title'     => Mage::helper('itags')->__('Category Name'),
            'required'  => true,
            'value'     => $model->getCategoryName(),
             
        ));
        $fieldset->addField('store_category', 'text', array(
            'name'      => 'store_category',
            'label'     => Mage::helper('itags')->__('Product Category Ids'),
            'title'     => Mage::helper('itags')->__('Product Category Ids'),
            'required'  => false,
            'value'     => $model->getStoreCategory(),
            'after_element_html' => '<small>seperate by ","</small>',
             
        ));
        $fieldset->addField('note', 'note', array(
			'text'     => Mage::getSingleton('iifire_tags/category')->getStoreCategoriesNote(),
		));
        if ($model->getId()) {
            $fieldset->addField('store_id_copy', 'text', array(
            	'label'     => Mage::helper('itags')->__('Visible In'),
                'name'      => 'store_id_copy',
                'value'     => Mage::getSingleton('adminhtml/system_store')->getStoreName($model->getStoreId()),
                'disabled'  => true,
                
            ));
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'store_id',
                'value'     => $model->getStoreId(),
            ));
        } else {
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
        }
	     
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
