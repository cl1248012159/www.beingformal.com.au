<?php
class My_Custom_IndexController extends Mage_Core_Controller_Front_Action{


    public function IndexAction() {
        $this->loadLayout();   
        $this->getLayout()->getBlock("head")->setTitle($this->__("Custom Dresses"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));
        $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Custom Dresses"),
                "title" => $this->__("Custom Dresses")
           ));
        $this->renderLayout(); 
    }




	
	public function addAction(){
		$data = $this->getRequest()->getPost();

        if( isset($_FILES) ){
            $path = Mage::getBaseDir('media').DS.'custom';
            for($i=1;$i<11;$i++){
                if(isset($_FILES['customimage'.$i]['name']) && $_FILES['customimage'.$i]['name'] != '') {
                    try {
                        $uploader = new Varien_File_Uploader('customimage'.$i);
                        $result = $uploader
                            ->setAllowedExtensions(array('jpg','jpeg','gif','png'))
                            ->setAllowRenameFiles(true)
                            ->setFilesDispersion(true)
                            ->setAllowCreateFolders(true)
                            ->save($path,$_FILES['customimage'.$i]['name'] );
                        $data['customimage'.$i] = $result['file'];
                    } catch (Exception $e) {}
                }
            }
        }


		try{
			$question = Mage::getModel('custom/custom');
			$question->updataQuestionsData($data);
			$question->save();
			$successMessage=Mage::helper('custom')->__('Add Your Own Dresses Successfully');
			Mage::getSingleton('core/session')->addSuccess($successMessage);
		}catch(Mage_Core_Exception $e){
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirectReferer();
		}
		$this->_redirectReferer();
		
	}
}