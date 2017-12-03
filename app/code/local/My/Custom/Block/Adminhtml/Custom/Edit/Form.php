<?php
class My_Custom_Block_Adminhtml_Custom_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{
				$form = new Varien_Data_Form(array(
				"id" => "edit_form",
				"action" => $this->getUrl("*/*/save", array("id" => $this->getRequest()->getParam("id"))),
				"method" => "post",
				"enctype" =>"multipart/form-data",
				)
				);
				$form->setUseContainer(true);
				$id = $this->getRequest()->getParam('id');
				$model = Mage::getModel("custom/custom")->load($id);
				$fieldset = $form->addFieldset('questions_form', array('legend'=>Mage::helper('custom')->__('Custom information')));
				
                $fieldset->addField('size','textarea',array(
					'name'      => 'title',
					'label'     => Mage::helper('custom')->__('Size'),
					'title'     => Mage::helper('custom')->__('Size'),
					'required'  => true,
					'value'     => $model->getSize(),
				));

				$fieldset->addField('color','text',array(
					'name'      => 'color',
					'label'     => Mage::helper('custom')->__('color'),
					'title'     => Mage::helper('custom')->__('color'),
					'required'  => true,
					'value'     => $model->getColor(),
				));

               
        
                if($model->getCustomimage1()){
                    $fieldset->addField('customimage1', 'note', array(
                        'label'     => 'customimage1',
                        'text'      => "<a onClick='imagePreview(\"img_customimage1\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage1()."><img id='img_customimage1' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage1()."'></a>",
                    ));
                }
                if($model->getCustomimage2()){
                    $fieldset->addField('customimage2', 'note', array(
                        'label'     => 'customimage2',
                        'text'      => "<a onClick='imagePreview(\"img_customimage2\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage2()."><img id='img_customimage2' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage2()."'></a>",
                    ));
                }
                if($model->getCustomimage3()){
                    $fieldset->addField('customimage3', 'note', array(
                        'label'     => 'customimage3',
                        'text'      => "<a onClick='imagePreview(\"img_customimage3\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage3()."><img id='img_customimage3' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage3()."'></a>",
                    ));
                }
                if($model->getCustomimage4()){
                    $fieldset->addField('customimage4', 'note', array(
                        'label'     => 'customimage4',
                        'text'      => "<a onClick='imagePreview(\"img_customimage4\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage4()."><img id='img_customimage4' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage4()."'></a>",
                    ));
                }
                if($model->getCustomimage5()){
                    $fieldset->addField('customimage5', 'note', array(
                        'label'     => 'customimage5',
                        'text'      => "<a onClick='imagePreview(\"img_customimage5\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage5()."><img id='img_customimage5' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage5()."'></a>",
                    ));
                }
                if($model->getCustomimage6()){
                    $fieldset->addField('customimage6', 'note', array(
                        'label'     => 'customimage6',
                        'text'      => "<a onClick='imagePreview(\"img_customimage6\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage6()."><img id='img_customimage6' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage6()."'></a>",
                    ));
                }
                if($model->getCustomimage7()){
                    $fieldset->addField('customimage7', 'note', array(
                        'label'     => 'customimage7',
                        'text'      => "<a onClick='imagePreview(\"img_customimage7\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage7()."><img id='img_customimage7' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage7()."'></a>",
                    ));
                }
                if($model->getCustomimage8()){
                    $fieldset->addField('customimage8', 'note', array(
                        'label'     => 'customimage8',
                        'text'      => "<a onClick='imagePreview(\"img_customimage8\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage8()."><img id='img_customimage8' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage8()."'></a>",
                    ));
                }
                if($model->getCustomimage9()){
                    $fieldset->addField('customimage9', 'note', array(
                        'label'     => 'customimage9',
                        'text'      => "<a onClick='imagePreview(\"img_customimage9\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage9()."><img id='img_customimage9' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage9()."'></a>",
                    ));
                }
                if($model->getCustomimage10()){
                    $fieldset->addField('customimage10', 'note', array(
                        'label'     => 'customimage10',
                        'text'      => "<a onClick='imagePreview(\"img_customimage10\"); return false;' href=".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage10()."><img id='img_customimage10' height =60 width=60  src='".Mage::getBaseUrl("media").'custom/'.$model->getCustomimage10()."'></a>",
                    ));
                }
                

                
                


				$fieldset->addField('name', 'text', array(
					'name'      => 'name',
					'label'     => Mage::helper('custom')->__('name'),
					'title'     => Mage::helper('custom')->__('name'),
					'required'  => true,
					'value'     => $model->getName(),
				));
                $fieldset->addField('telephone', 'text', array(
                    'name'      => 'telephone',
                    'label'     => Mage::helper('custom')->__('telephone'),
                    'title'     => Mage::helper('custom')->__('telephone'),
                    'required'  => true,
                    'value'     => $model->getTelephone(),
                ));
                $fieldset->addField('email', 'text', array(
                    'name'      => 'email',
                    'label'     => Mage::helper('custom')->__('email'),
                    'title'     => Mage::helper('custom')->__('email'),
                    'required'  => true,
                    'value'     => $model->getEmail(),
                ));
                $fieldset->addField('special_need', 'textarea', array(
                    'name'      => 'special_need',
                    'label'     => Mage::helper('custom')->__('special need'),
                    'title'     => Mage::helper('custom')->__('special need'),
                    'required'  => false,
                    'value'     => $model->getSpecialNeed(),
                ));

            $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
            $fieldset->addField('created_at', 'date', array(
                'name'   => 'created_at',
                'label'  => Mage::helper('custom')->__('创建时间'),
                'title'  => Mage::helper('custom')->__('创建时间'),
                'image'  => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
                'value'     => $model->getCreatedAt(),
                'format'       => $dateFormatIso
            ));
				
				$this->setForm($form);
				return parent::_prepareForm();
		}
}
