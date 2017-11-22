<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire
 * @version 1.7.0
 */
class Iifire_Tags_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_priority = 0.5;
	protected $_priorityProduct = 0.8;
	protected $_priorityCategory = 0.8;
	protected $_viewPageSize = 36;
	protected $_sitemapNum = 20000;
	protected $_changeFreq = "weekly";
	protected $_urlSuffix = ".html";
	protected $_subUrl = 'Mostpopular';
	
	public function getSubUrl()
	{
		return $this->_subUrl;
	}
    public function getUrlSuffix()
    {
    	return $this->_urlSuffix;
    }
	public function getBaseSeoUrl()
	{
		return Mage::getBaseUrl().$this->_subUrl.'/';
	}
	public function getStoreBaseSeoUrl($storeId)
	{
		$baseUrl = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
		return $baseUrl.$this->_subUrl.'/';
	}
	public function formatTag($tag)
	{
		$tag = preg_replace("/[ ]{1,}/",' ',$tag);
		$tag = strtolower($tag);
		return str_replace(' ', $this->getConnector(), trim($tag));
	}   
	
	public function getTagW($w='')
    {
    	if (strlen($w) == 1) {
    		if (preg_match("/^[a-zA-Z]{1}$/",$w)) {
    			return $w;
    		}
    	} elseif (strlen($w) == 3) {
    		if (preg_match("/^[0-9]\-[0-9]$/",$w)) {
    			return $w;
    		}
    	}
    	return false;
    }

    public function getAlphabet()
    {
    	return array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0-9');
    }
    public function getLetterUrl($letter='')
	{
		$letter = strtoupper($letter);
		return in_array($letter,$this->getAlphabet()) ? $this->getBaseSeoUrl().$letter.'/' : $this->getBaseSeoUrl();
	}
	public function getProductListUrl($tag)
	{
		$tag = $this->formatTag($tag);
		if ($tag) {
			return $this->getBaseSeoUrl().$tag.$this->_urlSuffix;
		}
	}
    public function getSitemapNumPerFile()
    {
    	$num = (int)Mage::getStoreConfig('iifire_tags/sitemap/num');
    	return $num ? $num : $this->_sitemapNum;
    }
    public function getViewPageSizeOr()
    {
    	$pagesize = (int)Mage::getStoreConfig('iifire_tags/view/pagesize_or');
    	return $pagesize ? $pagesize : $this->_viewPageSize;
    }
    public function getConnector()
    {
    	return "-";
    }
    public function getViewTitle()
    {
    	return Mage::getStoreConfig('iifire_tags/view/title');
    }
    public function getViewKeywords()
    {
    	return Mage::getStoreConfig('iifire_tags/view/keywords');
    }
    public function getViewDescription()
    {
    	return Mage::getStoreConfig('iifire_tags/view/description');
    }
    public function getListTitle()
    {
    	return Mage::getStoreConfig('iifire_tags/list/title');
    }
    public function getListKeywords()
    {
    	return Mage::getStoreConfig('iifire_tags/list/keywords');
    }
    public function getListDescription()
    {
    	return Mage::getStoreConfig('iifire_tags/list/description');
    }
    public function getListLetterTitle()
    {
    	return Mage::getStoreConfig('iifire_tags/list/title_letter');
    }
    public function getListLetterKeywords()
    {
    	return Mage::getStoreConfig('iifire_tags/list/keywords_letter');
    }
    public function getListLetterDescription()
    {
    	return Mage::getStoreConfig('iifire_tags/list/description_letter');
    }
    public function getViewWordMin()
    {
    	return (int)Mage::getStoreConfig('iifire_tags/view/word_min');
    }
    public function getViewWordExcept()
    {
    	return Mage::getStoreConfig('iifire_tags/view/word_except');
    }
    public function cleanWords($wordArray)
    {
    	$exceptArray = explode(',',$this->getViewWordExcept());
    	$minLength = $this->getViewWordMin();
    	$tmpArray = array();
    	foreach ($wordArray as $_word) {
    		if (strlen($_word)>=$minLength &&!in_array($_word,$tmpArray)) {
    			array_push($tmpArray,$_word);
    		}
    	}
    	return $tmpArray;
    }
    public function getPagesizeOr()
    {
    	return Mage::getStoreConfig('iifire_tags/view/pagesize_or');
    }
    public function isFixedResultEnable()
    {
    	return Mage::getStoreConfig('iifire_tags/view/fixed_result');
    }
	public function isRemoveTags()
    {
    	return Mage::getStoreConfig('iifire_tags/view/tags_remove');
    }
    public function getSitemapChangeFreq()
    {
    	$changeFreq = Mage::getStoreConfig('iifire_tags/sitemap/change_freq');
    	return $changeFreq ? $changeFreq : $this->_changeFreq;
    }
    public function getSitemapPriority()
    {
    	$priority = Mage::getStoreConfig('iifire_tags/sitemap/priority');
    	return $priority ? $priority : $this->_priority;
    }
    public function getProductSitemapPriotity()
    {
    	$priority = Mage::getStoreConfig('iifire_tags/sitemap/priority_product');
    	return $priority ? $priority : $this->_priorityProduct;
    }
    public function getCategorySitemapPriotity()
    {
    	$priority = Mage::getStoreConfig('iifire_tags/sitemap/priority_category');
    	return $priority ? $priority : $this->_priorityCategory;
    }
    
    public function getSitemapDir($filePath)
    {
    	return $mediaPath  = Mage::getBaseDir().$filePath;
    }
    public function getSitemapUrl($filePath,$baseurl='')
    {
    	
    	if (!$baseurl) {
    		return str_replace('index.php/','',Mage::getBaseUrl()).ltrim($filePath,"/");
    	} else {
    		return $baseurl.ltrim($filePath,"/");
    	}
    	
    }
    public function getSitemaps($storeCode,$filePath,$baseurl='')
	{
		
		$dir = Mage::helper('itags')->getSitemapDir($filePath);
		$url = Mage::helper('itags')->getSitemapUrl($filePath,$baseurl);
		
    	$dh = opendir($dir);
    	$sitemapArray = array();
    	while ($file = readdir($dh)) {
    		$tmp = array();
    		if($file!="." && $file!=".." && strpos($file,"-$storeCode-")) {
		        $fullpath=$url.$file;
		        $tmp['file'] = $fullpath;
		        $tmp['date'] = date("Y-m-d", @filemtime($dir.$file));
	            array_push($sitemapArray,$tmp);
    		}
	    }
	    return $sitemapArray;
	}
	
    public function delDirFiles($dir,$identify,$storeCode)
    {
    	$dh = opendir($dir);
    	while ($file = readdir($dh)) {
    		if($file!="." && $file!=".." && strpos($file,$identify) && strpos($file,"-$storeCode-")) {
		        $fullpath=$dir."/".$file;
	            unlink($fullpath);
    		}
	    }
    }
    public function createItem($loc, $changefreq,$priority='')
    {
    	$priority = !$priority ? $this->getSitemapPriority() : $priority;
    	$item = "<url>\n";
		$item .= "<loc>" . $loc . "</loc>\n";
		$item .= "<changefreq>" . $changefreq . "</changefreq>\n";
		$item .= "<priority>" . $priority. "</priority>\n";
		$item .= "</url>\n";   
		return $item;	
    }
    public function createSitemapXmlItem($loc, $lastModify) 
    {
    	 $item = "<sitemap>\n";
		$item .= "<loc>" . $loc . "</loc>\n";
		$item .= "<lastmod>" . $lastModify . "</lastmod>\n";
		$item .= "</sitemap>\n";   
		return $item;	
    }
    public function replaceTagUrl($url)
    {
    	$q = Mage::app()->getRequest()->getParam('q');
    	return preg_replace("/tags\/index\/view\/q\/(.*)\//","Mostpopular/".$q.".html",$url);
    }
}
