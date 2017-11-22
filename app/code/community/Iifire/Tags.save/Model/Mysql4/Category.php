<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.hifasion.org)
 * @copyright Copyright &copy; 2011, Hifashion (http://www.magentokey.com, http://www.hifasion.org)
 * @version 1.0.0
 */
class Iifire_Tags_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('iifire_tags/category', 'category_id');
    }
}
