<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Sitemap_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('sitemap_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Sitemap Information'));
    }


    protected function _prepareForm()
    {
        $model = Mage::registry('sitemap_sitemap');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('add_sitemap_form', array('legend' => Mage::helper('itags')->__('Sitemap')));

        if ($model->getId()) {
            $fieldset->addField('sitemap_id', 'hidden', array(
                'name' => 'sitemap_id',
            ));
        }

        $fieldset->addField('sitemap_filename', 'text', array(
            'label' => Mage::helper('itags')->__('Filename'),
            'name'  => 'sitemap_filename',
            'required' => true,
            'note'  => Mage::helper('adminhtml')->__('example: sitemap.xml'),
            'value' => $model->getSitemapFilename()
        ));
	    $fieldset->addField('sitemap_file_path', 'text', array(
            'label' => Mage::helper('itags')->__('File Path'),
            'name'  => 'sitemap_file_path',
            'required' => true,
            'note'  => Mage::helper('adminhtml')->__('example: "sitemap/" or "/" for base path (path must be writeable)'),
            'value' => $model->getSitemapFilePath()
        ));
        $fieldset->addField('sitemap_path', 'text', array(
            'label' => Mage::helper('itags')->__('Path'),
            'name'  => 'sitemap_path',
            'required' => true,
            'note'  => Mage::helper('adminhtml')->__('example: "sitemap/" or "/" for base path (path must be writeable)'),
            'value' => $model->getSitemapPath()
        ));
		$fieldset->addField('sitemap_baseurl', 'text', array(
            'label' => Mage::helper('itags')->__('Base Url'),
            'name'  => 'sitemap_baseurl',
            'required' => false,
            'note'  => Mage::helper('itags')->__('example: http://www.iifire.com/'),
            'value' => $model->getSitemapBaseurl(),
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label'    => Mage::helper('itags')->__('Store View'),
                'title'    => Mage::helper('itags')->__('Store View'),
                'name'     => 'store_id',
                'required' => true,
                'value'    => $model->getStoreId(),
                'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm()
            ));
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'     => 'store_id',
                'value'    => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('generate', 'hidden', array(
            'name'     => 'generate',
            'value'    => ''
        ));

        $form->setValues($model->getData());

        $form->setUseContainer(true);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
