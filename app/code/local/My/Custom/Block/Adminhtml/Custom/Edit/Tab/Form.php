<?php
class My_Custom_Block_Adminhtml_Custom_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("custom_form", array("legend"=>Mage::helper("custom")->__("Item information")));

				

				if (Mage::getSingleton("adminhtml/session")->getCustomData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCustomData());
					Mage::getSingleton("adminhtml/session")->setCustomData(null);
				} 
				elseif(Mage::registry("custom_data")) {
				    $form->setValues(Mage::registry("custom_data")->getData());
				}
				return parent::_prepareForm();
		}
}
