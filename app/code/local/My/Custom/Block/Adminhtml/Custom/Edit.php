<?php
	
class My_Custom_Block_Adminhtml_Custom_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "custom";
				$this->_controller = "adminhtml_custom";
				$this->_updateButton("save", "label", Mage::helper("custom")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("custom")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("custom")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("custom_data") && Mage::registry("custom_data")->getId() ){

				    return Mage::helper("custom")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("custom_data")->getId()));

				} 
				else{

				     return Mage::helper("custom")->__("Add Item");

				}
		}
}