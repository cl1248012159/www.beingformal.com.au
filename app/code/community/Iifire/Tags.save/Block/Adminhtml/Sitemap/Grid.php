<?php
class Iifire_Tags_Block_Adminhtml_Sitemap_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sitemapGrid');
        $this->setDefaultSort('sitemap_id');

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('iifire_tags/sitemap')->getCollection();
        /* @var $collection Mage_Sitemap_Model_Mysql4_Sitemap_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('sitemap_id', array(
            'header'    => Mage::helper('itags')->__('ID'),
            'width'     => '50px',
            'index'     => 'sitemap_id'
        ));

        $this->addColumn('sitemap_filename', array(
            'header'    => Mage::helper('itags')->__('Filename'),
            'index'     => 'sitemap_filename'
        ));

        $this->addColumn('sitemap_path', array(
            'header'    => Mage::helper('itags')->__('Path'),
            'index'     => 'sitemap_path'
        ));
        $this->addColumn('link', array(
            'header'    => Mage::helper('itags')->__('Link for Google'),
            'index'     => 'concat(sitemap_path, sitemap_filename)',
            'renderer'  => 'iifire_tags/adminhtml_sitemap_grid_renderer_link',
        ));
		$this->addColumn('sitemap_file_path', array(
            'header'    => Mage::helper('itags')->__('Gz File Path'),
            'index'     => 'sitemap_file_path'
        ));

        $this->addColumn('sitemap_time', array(
            'header'    => Mage::helper('itags')->__('Last Time Generated'),
            'width'     => '150px',
            'index'     => 'sitemap_time',
            'type'      => 'datetime',
        ));


        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('itags')->__('Store View'),
                'index'     => 'store_id',
                'type'      => 'store',
            ));
        }
        $this->addColumn('action', array(
            'header'   => Mage::helper('itags')->__('Action'),
            'filter'   => false,
            'sortable' => false,
            'width'    => '100',
            'renderer' => 'iifire_tags/adminhtml_sitemap_grid_renderer_action'
        ));

        return parent::_prepareColumns();
    }
    protected function _prepareMassaction()
    {
		$this->setMassactionIdField('sitemap_id');
		
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('adminhtml')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('adminhtml')->__('Are you sure?')
        ));
        

        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
    	
    }

}
