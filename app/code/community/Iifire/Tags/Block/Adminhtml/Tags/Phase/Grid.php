<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Phase_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('tagsGrid');
        $this->setDefaultSort('tags_id');
        $this->setDefaultOrder('desc');
    }
    public function _construct()
    {
        $this->setEmptyText(Mage::helper('iifire_tags')->__('No Record Found'));
    }
    protected function _prepareCollection()
    {
		$collection = Mage::getResourceSingleton('iifire_tags/tags_collection');
        $collection->addFieldToFilter('tags_phase', array(array('notnull' => true)));
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
    	$this->addColumn('tags_id', array(
            'header'    => Mage::helper('iifire_tags')->__('Tags ID'),
            'index'     => 'tags_id',
            'width'     => '50px',
            'type'      => 'number',
        ));
        $this->addColumn('tags_text', array(
            'header'    => Mage::helper('iifire_tags')->__('Tags'),
            'index'     => 'tags_text',
            'width'     => '300px',
        ));
		$this->addColumn('tags_phase', array(
            'header'    => Mage::helper('iifire_tags')->__('Phase'),
            'index'     => 'tags_phase',
            'width'     => '650px'
        ));
		if (!Mage::app()->isSingleStoreMode()) {
	        $this->addColumn('store', array(
	            'header'    => Mage::helper('iifire_show')->__('Store View'),
	            'index'     => 'store_id',
	            'type'      => 'options',
	            'options'   => $this->_getStoreOptions(),
	            'width'     => '120px',
	            'align'     => 'center',
	        ));
		}
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('adminhtml')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(array(
                    'caption'   => Mage::helper('iifire_tags')->__('Delete'),
                    'url'       => array(
                        'base'=>'*/*/delPhase'
                    ),
                    'field'   => 'id'
                )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'tags_id',
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('adminhtml')->__('Excel XML'));
        
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('tags_id');
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('iifire_tags')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('iifire_tags')->__('Are you sure?')
        ));

        return parent::_prepareMassaction();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/add', array('id'=>$row->getId(),'flag'=>true));
    }
    protected function _getStoreOptions()
    {
        return Mage::getModel('adminhtml/system_store')->getStoreOptionHash();
    }
}
