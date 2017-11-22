<?php
class Iifire_Tags_Model_System_Sitemap_Freq
{
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = array(
            	'always' => 'always',
            	'hourly' => 'hourly',
            	'daily' => 'daily',
            	'weekly' => 'weekly',
            	'monthly' => 'monthly',
            	'yearly' => 'yearly',
            );
        }
        $options = $this->_options;
        return $options;
    }
}