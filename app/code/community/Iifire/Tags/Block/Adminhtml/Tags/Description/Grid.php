<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Description_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('descriptionGrid');
        $this->setDefaultSort('description_id', 'desc');
    }
    public function _construct()
    {
        $this->setEmptyText(Mage::helper('itags')->__('No Record Found'));
    }

    protected function _prepareCollection()
    {
		$collection = Mage::getResourceModel('iifire_tags/description_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('description_id', array(
            'header'    => Mage::helper('itags')->__('ID'),
            'index'     => 'description_id',
            'width'     => '80px',
            'align'     => 'center',
            'type'      => 'number',
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('catalog')->__('Store'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_view'    => true,
                'width'     => '80px',
                'sortable'      => false
            ));
        }
        $categories = Mage::getModel('iifire_tags/category')->getCategoryAsOption();
        if (is_array($categories) && count($categories)) {
			$this->addColumn('category_id', array(
	            'header'    => Mage::helper('itags')->__('Category'),
	            'index'     => 'category_id',
	            'width'     => '50',
	            'type' => 'options',
	            'options' => $categories,
	        ));
        }
		$this->addColumn('content', array(
            'header'    => Mage::helper('itags')->__('Description Content'),
            'index'     => 'content',
            'width'     => '500px',
        ));
		
		
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('itags')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(array(
                    'caption'   => Mage::helper('itags')->__('Delete'),
                    'url'       => array(
                        'base'=>'*/*/delete'
                    ),
                    'field'   => 'id'
                )),
                'filter'    => false,
                'index'     => 'catalog',
                'align'     => 'center',
                
                
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('adminhtml')->__('Excel XML'));
        return $this;
    }
    
    protected function _prepareMassaction()
    {
		$this->setMassactionIdField('description_id');
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('adminhtml')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('adminhtml')->__('Are you sure?')
        ));

        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}
