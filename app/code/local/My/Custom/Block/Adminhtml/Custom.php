<?php


class My_Custom_Block_Adminhtml_Custom extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_custom";
	$this->_blockGroup = "custom";
	$this->_headerText = Mage::helper("custom")->__("Custom Manager");
	$this->_addButtonLabel = Mage::helper("custom")->__("Add New Item");
	parent::__construct();
	
	}

}