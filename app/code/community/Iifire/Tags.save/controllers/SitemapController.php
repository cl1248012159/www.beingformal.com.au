<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_SitemapController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();
    	$w = $this->getRequest()->getParam('w');
    	$headBlock = $this->getLayout()->getBlock('head');
        $headBlock->setTitle('All Tags');
		if ($w) {
			$headBlock->setTitle(strtoupper($w).' - All Tags');
		}
    	$this->renderLayout();
    }
}