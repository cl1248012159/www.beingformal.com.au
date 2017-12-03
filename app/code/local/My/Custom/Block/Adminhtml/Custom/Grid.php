<?php

class My_Custom_Block_Adminhtml_Custom_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("customGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("custom/custom")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("custom")->__("ID"),
				"align" =>"right",
				"width" => "20px",
			    "type" => "number",
				"index" => "id",
				));
				
				$this->addColumn("name", array(
				"header" => Mage::helper("custom")->__("Name"),
				"align" =>"right",
				"width" => "30px",
			    "type" => "varcher",
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("custom")->__("Email"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "varcher",
				"index" => "email",
				));
				$this->addColumn("telephone", array(
				"header" => Mage::helper("custom")->__("Telephone"),
				"align" =>"right",
				"width" => "20px",
			    "type" => "varcher",
				"index" => "telephone",
				));
				$this->addColumn("size", array(
				"header" => Mage::helper("custom")->__("Size"),
				"align" =>"right",
				"width" => "20px",
			    "type" => "varcher",
				"index" => "size",
				));
				$this->addColumn("color", array(
				"header" => Mage::helper("custom")->__("Color"),
				"align" =>"right",
				"width" => "20px",
			    "type" => "varcher",
				"index" => "color",
				));
				$this->addColumn("color", array(
				"header" => Mage::helper("custom")->__("Color"),
				"align" =>"right",
				"width" => "20px",
			    "type" => "varcher",
				"index" => "color",
				));
				
                $this->addColumn("special_need", array(
				"header" => Mage::helper("custom")->__("Special Need"),
				"align" =>"right",
				"width" => "150px",
			    "type" => "varcher",
				"index" => "special_need",
				));
            
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_custom', array(
					 'label'=> Mage::helper('custom')->__('Remove Custom'),
					 'url'  => $this->getUrl('*/adminhtml_custom/massRemove'),
					 'confirm' => Mage::helper('custom')->__('Are you sure?')
				));
			return $this;
		}
			

}