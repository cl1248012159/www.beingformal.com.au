<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setEmptyText(Mage::helper('itags')->__('No Record Found'));
        $this->setDefaultSort('created_at');
        $this->setDefaultOrder('desc');
    }

    protected function _prepareCollection()
    {
    	
        $collection = Mage::getResourceModel('iifire_tags/category_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('category_id',
            array(
				'header'  => Mage::helper('itags')->__('ID'), 
				'align'   => 'center',
				'width'   => '100px',
				'index'   => 'category_id',
		));
		$this->addColumn('store_category',
            array(
                'header'=>Mage::helper('itags')->__('Product Category'),
                'index'=>'store_category',
                'renderer' => 'iifire_tags/adminhtml_tags_category_renderer_storecategory',
        		'width'     => '300px',
        ));
		$this->addColumn('category_name',
            array(
                'header'=>Mage::helper('itags')->__('Category Name'),
                'index'=>'category_name',
                'width'     => '400px',
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('itags')->__('Store View'),
                'index'     => 'store_id',
                'type'      => 'store',
                'width'     => '200px',
            ));
        }
        

        return $this;
    }
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('itags')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('itags')->__('Are you sure?')
        ));
        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}

