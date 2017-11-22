<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Block_Pager extends Mage_Page_Block_Html_Pager
{
    public function getPagerUrl($params=array())
    {
        $urlParams = array();
        $urlParams['_current']  = true;
        $urlParams['_escape']   = true;
        $urlParams['_use_rewrite']   = true;
        $urlParams['_query']    = $params;
        $url = $this->getUrl('*/*/*', $urlParams);
        $q = $this->getRequest()->getParam('q');
    	return strtolower(preg_replace("/tags\/index\/view\/q\/(.*)\//","tags/".$q.".html",$url));
    }
}
?>
