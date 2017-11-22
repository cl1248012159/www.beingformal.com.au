<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Adminhtml_Tags_Syn_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('synGrid');
        $this->setDefaultSort('syn_id', 'desc');
    }
    public function _construct()
    {
        $this->setEmptyText(Mage::helper('itags')->__('No Record Found'));
    }

    protected function _prepareCollection()
    {
		$collection = Mage::getResourceModel('iifire_tags/syn_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('syn_id', array(
            'header'    => Mage::helper('itags')->__('ID'),
            'index'     => 'syn_id',
            'width'     => '80px',
            'align'     => 'center',
            'type'      => 'number',
        ));
		$this->addColumn('syn_type', array(
            'header'    => Mage::helper('itags')->__('Type'),
            'index'     => 'syn_type',
            'width'     => '300px',
            'type'      => 'options',
            'options'   => Mage::getSingleton('iifire_tags/syn')->getTypeOptions(),
        ));
        $this->addColumn('pk_id', array(
            'header'    => Mage::helper('itags')->__('Last Syn Id'),
            'index'     => 'pk_id',
            'width'     => '80px',
        ));
		$this->addColumn('created_at', array(
            'header'    => Mage::helper('itags')->__('Created At'),
            'index'     => 'created_at',
            'width'     => '150px',
            'type'      => 'datetime'
        ));
        return $this;
    }   
}
