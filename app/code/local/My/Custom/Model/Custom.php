<?php

class My_Custom_Model_Custom extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("custom/custom");

    }

	/* 
	* update questions data 
	* $param  $data array
	* return $this
	*/
	public function updataQuestionsData($data){
		try{
			if(!empty($data)){
				$this->setSize($data['size']);
				$this->setColor($data['color']);
				$this->setCustomimage1($data['customimage1']);
				$this->setCustomimage2($data['customimage2']);
				$this->setCustomimage3($data['customimage3']);
				$this->setCustomimage4($data['customimage4']);
				$this->setCustomimage5($data['customimage5']);
				$this->setCustomimage6($data['customimage6']);
				$this->setCustomimage7($data['customimage7']);
				$this->setCustomimage8($data['customimage8']);
				$this->setCustomimage9($data['customimage9']);
				$this->setCustomimage10($data['customimage10']);
				$this->setName($data['name']);
				$this->setTelephone($data['telephone']);
				$this->setEmail($data['email']);
				$this->setSpecialNeed($data['special_need']);
				$time=now();
				$this->setCreatedAt($time);
			}else{
				throw new Exception("Error Processing Request:Insufficient Data Provided");
			}
		}catch(Exception $e){
			Mage::logException($e);
		}
		return $this;
	}
}
	 