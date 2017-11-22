<?php
class Iifire_Tags_Model_System_Connector
{
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = array(
            	'-' => "-",
            	'_' => '_',
            );
        }
        $options = $this->_options;
        return $options;
    }
}