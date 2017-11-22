<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Phase_Export extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        $this->setEmptyText(Mage::helper('iifire_tags')->__('No Record Found'));
        $this->setDefaultSort('tags_id');
        $this->setDefaultOrder('desc');
    }
    protected function _prepareCollection()
    {
		$collection = Mage::getModel('iifire_tags/tags')
            ->getResourceCollection();
        $collection->addFieldToFilter('tags_phase', array(array('notnull' => true)));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
    	$this->addColumn('tags_id', array(
            'header'    => Mage::helper('iifire_tags')->__('ID'),
            'index'     => 'tags_id',
            'width'     => '50px'
        ));
        $this->addColumn('tags_text', array(
            'header'    => Mage::helper('iifire_tags')->__('Tags'),
            'index'     => 'tags_text',
            'width'     => '300px'
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
        return parent::_prepareColumns();
    }
    protected function _getStoreOptions()
    {
        return Mage::getModel('adminhtml/system_store')->getStoreOptionHash();
    }
}
