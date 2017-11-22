<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://www.iifire.com)
 * @version 1.7.0
 */
class Iifire_Tags_Adminhtml_Itag_SitemapController extends Mage_Adminhtml_Controller_Action  
{
	protected $_xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<?xml-stylesheet type=\"text/xsl\" href=\"####\"?>
			<sitemapindex xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
			        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
			        http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\"
			        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    protected $_urlset  = '<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<?xml-stylesheet type=\"text/xsl\" href=\"####\"?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">';
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('catalog/iifire_tags')
            ->_addBreadcrumb(
                Mage::helper('itags')->__('Catalog'),
                Mage::helper('itags')->__('Catalog'))
            ->_addBreadcrumb(
                Mage::helper('itags')->__('Tags Sitemap'),
                Mage::helper('itags')->__('Tags Sitemap'))
        ;
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Sitemap Management'));
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();
        $this->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_sitemap'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('iifire_tags/adminhtml_sitemap_grid')->toHtml());
    }

    public function sitemapProcessAction()
    {
    	$this->_initAction();
        $this->_title($this->__('Catalog'))->_title($this->__('Tags Sitemaps'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('sitemap_id');
        $model = Mage::getModel('iifire_tags/sitemap');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('itags')->__('This sitemap no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
		// 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        Mage::register('sitemap_sitemap', $model);
        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('itags')->__('Edit Sitemap') : Mage::helper('itags')->__('New Sitemap'),
                $id ? Mage::helper('itags')->__('Edit Sitemap') : Mage::helper('itags')->__('New Sitemap'))
            ->_addContent($this->getLayout()->createBlock('iifire_tags/adminhtml_sitemap_edit'))
            ->renderLayout();
    }
    public function saveAction()
    {
    	if ($data = $this->getRequest()->getPost()) {
    		if (!empty($data['sitemap_filename']) && !empty($data['sitemap_path']) && !empty($data['sitemap_file_path']) && !empty($data['store_id'])) {
	    		$store = Mage::getModel('core/store')->load($data['store_id']);
				if ($store->getId()) {   
					$baseurl =  $data['sitemap_baseurl'];		
		    		$path = rtrim($data['sitemap_path'], '\\/') . DS . $data['sitemap_filename'];
		    		$filePath = rtrim($data['sitemap_file_path'], '\\/') . DS . $data['sitemap_filename'];
	                $validator = Mage::getModel('core/file_validator_availablePath');
	                $helper = Mage::helper('adminhtml/catalog');
	                $validator->setPaths($helper->getSitemapValidPaths());
	                if (!$validator->isValid($path) || !$validator->isValid($filePath)) {
                		foreach ($validator->getMessages() as $message) {
	                        Mage::getSingleton('adminhtml/session')->addError($message);
	                    }
	                    // save data in session
	                    Mage::getSingleton('adminhtml/session')->setFormData($data);
	                    // redirect to edit form
	                    $this->_redirect('*/*/sitemapProcess', array(
	                        'sitemap_id' => $this->getRequest()->getParam('sitemap_id')));
	                    return;
	                } else {
		    			$helper = Mage::helper('itags');
		    			$storeId = $data['store_id'];
		    			$filename = $data['sitemap_filename'];
		    			$io = new Varien_Io_File();
        				$path = $io->getCleanPath(Mage::getBaseDir() . '/' . $data['sitemap_path']);
						$filePath = $io->getCleanPath(Mage::getBaseDir() . '/' . $data['sitemap_file_path']);
		    			$path = rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $path), '/') . '/';
		    			$filePath = rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $filePath), '/') . '/';
		    			//save
		    			$model = Mage::getModel('iifire_tags/sitemap');
		    			$model->setSitemapFilename($filename)
		    				->setSitemapPath($path)
		    				->setSitemapFilePath($filePath)
		    			    ->setSitemapBaseurl($baseurl)
		    				->setStoreId($storeId);
						try {
							if($model->save()) {

		    					$this->_getSession()->addSuccess($helper->__("Sitemap Save Successfully."));
				    		
							} else {
								$this->_getSession()->addError($helper->__("Sitemap Save Failed."));
							};
						} catch (Exception $e) {
							$this->_getSession()->addError($e->getMessage());
						}
	                }
				} else {
					$this->_getSession()->addError($helper->__("Sitemap Save Failed."));
				}
    		}
    	}
    	//die();
    	 $this->_redirect('*/*/');
    }
    public function massDeleteAction()
    {
    	$ids= $this->getRequest()->getParam('massaction');
        if (count($ids)) {
        	$i = 0;
        	$j = 0;
            foreach ($ids as $id) {
            	if($id) {
            		$model = Mage::getModel('iifire_tags/sitemap')
                        ->load($id);
                    if ($model->getId()) {
                        try {
                        	$model->delete();
                        	$i++;
                        } catch (Exception $e) {
                        	$j++;
                        }
                    } else {
                    	$j++;
                    }
            	} 
            }
            if ($i) {
    			$this->_getSession()->addSuccess(Mage::helper('itags')->__('%d record(s) have been deleted.',$i));
    		} 
    		if ($j) {
    			$this->_getSession()->addError(Mage::helper('itags')->__('%d record(s) have can not delete.',$j));
    		}
        }
        $this->_redirect('*/*/index');
    }
    public function generateAction()
    {
    	$sitemapId = (int)$this->getRequest()->getParam('sitemap_id');
    	$sitemap = Mage::getModel('iifire_tags/sitemap')->load($sitemapId);
    	if ($sitemap->getId() && $sitemap->getStoreId()) {
    		$store = Mage::getModel('core/store')->load($sitemap->getStoreId());
    		if ($store->getId()) { 
    			$path = rtrim($sitemap->getSitemapPath(), '\\/') . DS . $sitemap->getSitemapFilename();
	    		$filePath = rtrim($sitemap->getSitemapFilePath(), '\\/') . DS . $sitemap->getSitemapFilename();
                $baseurl = $sitemap->getSitemapBaseurl();
                $validator = Mage::getModel('core/file_validator_availablePath');
                $helper = Mage::helper('adminhtml/catalog');
                $validator->setPaths($helper->getSitemapValidPaths());
                if (!$validator->isValid($path) || !$validator->isValid($filePath)) {
            		foreach ($validator->getMessages() as $message) {
                        Mage::getSingleton('adminhtml/session')->addError($message);
                    }
                    // redirect to edit form
                    $this->_redirect('*/*/index');
                    return;
                } else {
	    			$helper = Mage::helper('itags');
	    			$storeId = $store->getId();
	    			$filename = $sitemap->getSitemapFilename();
	    			$io = new Varien_Io_File();
    				$path = $io->getCleanPath(Mage::getBaseDir() . '/' . $sitemap->getSitemapPath());
					$filePath = $io->getCleanPath(Mage::getBaseDir() . '/' . $sitemap->getSitemapFilePath());
	    			$path = rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $path), '/') . '/';
	    			$filePath = rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $filePath), '/') . '/';
	    			
	    			$sitemap->setSitemapTime(Mage::getSingleton('core/date')->gmtDate('Y-m-d h:i:s'));
	    			
					try {
						if($sitemap->save()) {
	    					$storeCode = $store->getCode();
    						$storeName = $store->getName();
    						$this->generateTagsFile($store,$path,$filePath,$baseurl);
    						$this->generateProductsFile($store,$path,$filePath,$baseurl);
    						$this->generateCategoryFile($store,$path,$filePath,$baseurl);
    						$this->generateSitemap($store,$path,$filePath,$baseurl);
    						$this->_getSession()->addSuccess($helper->__("Sitemap Generate Successfully."));
						} else {
							$this->_getSession()->addError($helper->__("Sitemap Save Failed."));
						};
					} catch (Exception $e) {
						$this->_getSession()->addError($e->getMessage());
					}
                }
    		}
    	} else {
    		$this->_getSession()->addError($helper->__("Invalid Sitemap."));
    	}
    	 $this->_redirect('*/*/');
    }
    public function generateTagsFile($store,$path,$filePath,$baseurl='')
    {
    	 
    	$helper = Mage::helper('itags');
    	$identify = 'atoz';
    	$num = $helper->getSitemapNumPerFile();
    	$helper->delDirFiles($helper->getSitemapDir($filePath),$identify,$store->getCode());
		$collection = Mage::getModel('iifire_tags/tags')
            ->getResourceCollection()
            ->addFieldToFilter('store_id', $store->getId());
        $collection->setPageSize($num);
		$lastPage = $collection->getLastPageNumber();
		for($i=1;$i<=$lastPage;$i++) {
			$collection2 = Mage::getModel('iifire_tags/tags')
	            ->getResourceCollection()
	            ->addFieldToFilter('store_id', $store->getId())
				->setPageSize($num)
			    ->setCurPage($i);
		   
			$this->generateTagsXml($collection2,$store,$i,$filePath,$baseurl);
		}
    }
    public function generateProductsFile($store,$path,$filePath,$baseurl='')
    {
    	$helper = Mage::helper('itags');
    	$identify = 'products';
    	$helper->delDirFiles($helper->getSitemapDir($filePath),$identify,$store->getCode());
		
		
		$collection = Mage::getResourceModel('iifire_tags/catalog_product')->getCollection($store->getId());
		if(count($collection)) {
			$collection2 = Mage::getResourceModel('iifire_tags/catalog_product')->getCollection($store->getId());
			$this->generateProductsXml($collection2,$store,1,$filePath,$baseurl);
		}
    }
    public function generateProductsXml($collection, $store, $number, $filePath,$baseurl='')
    {
    	$helper = Mage::helper('itags');
    	$num = $helper->getSitemapNumPerFile();
    	$changeFreq = $helper->getSitemapChangeFreq();
    	$identify = 'products';
    	$priority = $helper->getProductSitemapPriotity();
		$mediaPath  = $helper->getSitemapDir($filePath);
		if (!$baseurl) {
    		$gssUrl = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    	} else {
    		$gssUrl = $baseurl;
    	}
    	$gssUrl = $gssUrl.'gss.xsl';
    	$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
		xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\"
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
    	if ($total = count($collection)) {
    		$i = 0;
    		$j = 0;
    		foreach ($collection as $c) {
    			if ($i%$num == 1 || $i == 0) {
    				$xml = $xmlHeader;
    			}
    			$url=$c->getUrl();
				$urls=explode('/',$url);
				if(count($urls)>1){
					if (!$baseurl) {
						$loc = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$urls[1];
					} else {
						$loc = $baseurl.$urls[1];
					}
				}else{
					if (!$baseurl) {
						$loc = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$c->getUrl();
					} else {
						$loc = $baseurl.$c->getUrl();
					}
				}
				$baseUrl=Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    			$xml .= $helper->createProductItem($loc,$changeFreq,$priority,$c,$baseUrl);
    			if (($i%$num == 0 && $i != 0) || $i==$total-1) {
    				$xml .= "</urlset>";
    				$jj = $j+1;
    			//	$code = $store->getCode();
				$code='en';
    				//$fileName = $mediaPath."sitemap-$identify-$code-$number.xml";
    				//$gz = gzopen($fileName.'.gz', 'w');
					//gzwrite($gz, $xml);
					//gzclose($gz);
					$fileName = $mediaPath."sitemap-$code-$identify.xml";
					if (file_exists($fileName)) {
							unlink($fileName);
						}
					$file = fopen($fileName,'a');
					fwrite($file, $xml);
					fclose($file);
    				$j++;
    			}
    			$i++;
    		}
    	}	
    }
    public function generateCategoryFile($store,$path,$filePath,$baseurl='')
    {
    	$helper = Mage::helper('itags');
    	$identify = 'categories';
    	$num = $helper->getSitemapNumPerFile();
    	$helper->delDirFiles($helper->getSitemapDir($filePath),$identify,$store->getCode());
		
		
		$collection = Mage::getResourceModel('iifire_tags/catalog_category')->getCollection($store->getId());
		if (count($collection)) {
			$collection2 = Mage::getResourceModel('iifire_tags/catalog_category')->getCollection($store->getId());
			$this->generateCategoryXml($collection2,$store,1,$filePath,$baseurl);
		}
    }
    public function generateCategoryXml($collection, $store, $number, $filePath,$baseurl='')
    {
    	$helper = Mage::helper('itags');
    	$num = $helper->getSitemapNumPerFile();
    	$changeFreq = $helper->getSitemapChangeFreq();
    	$identify = 'categories';
    	$priority = $helper->getCategorySitemapPriotity();
		$mediaPath  = $helper->getSitemapDir($filePath);
		
    	if (!$baseurl) {
    		$gssUrl = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    	} else {
    		$gssUrl = $baseurl;
    	}
    	$gssUrl = $gssUrl.'gss.xsl';
    	$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
    	if ($total = count($collection)) {
    		$i = 0;
    		$j = 0;
    		foreach ($collection as $c) {
    			if ($i%$num == 1 || $i == 0) {
    				$xml = $xmlHeader.'<url>
					<loc>'.Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'</loc>
					<changefreq>weekly</changefreq>
					<priority>1.0</priority>
					</url>';
    			}
    			if (!$baseurl) {
    				$loc = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$c->getUrl();
    			} else {
    				$loc = $baseurl.$c->getUrl();
    			}
    			
    			$xml .= $helper->createItem($loc,$changeFreq,$priority);
    			if (($i%$num == 0 && $i != 0) || $i==$total-1) {
    				$xml .= "</urlset>";
    				$jj = $j+1;
    				//$code = $store->getCode();
					$code='en';
    				//$fileName = $mediaPath."sitemap-$identify-$code-$number.xml";
    				//$gz = gzopen($fileName.'.gz', 'w');
					//gzwrite($gz, $xml);
					//gzclose($gz);
					$fileName = $mediaPath."sitemap-$code-$identify.xml";
					if (file_exists($fileName)) {
						unlink($fileName);
					}
					$file = fopen($fileName,'a');
					fwrite($file, $xml);
					fclose($file);
    				$j++;
    			}
    			$i++;
    		}
    	}	
    }
    public function generateTagsXml($collection, $store, $number, $filePath,$baseurl='')
    {
    	
    	$helper = Mage::helper('itags');
    	$num = $helper->getSitemapNumPerFile();
    	$changeFreq = $helper->getSitemapChangeFreq();
    	$identify = 'atoz';
		$mediaPath  = $helper->getSitemapDir($filePath);
    	if (!$baseurl) {
    		$gssUrl = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    	} else {
    		$gssUrl = $baseurl;
    	}
    	
    	$gssUrl = $gssUrl.'gss.xsl';
    	$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
		echo count($collection);
    	if ($total = count($collection)) {
    		$i = 0;
    		$j = 0;
    		foreach ($collection as $c) {
    			if ($i%$num == 1 || $i == 0) {
    				$xml = $xmlHeader;
    			}
    			//$tag = ucwords($c->getTagsText());
				$tag=strtolower($c->getTagsText());
    			$connector = $helper->getConnector();
    			if (!$baseurl) {
    				$loc = str_replace('index.php/','',$helper->getStoreBaseSeoUrl($c->getStoreId())).str_replace(" ",$connector,$tag).".html";
    			} else {
    				$loc = $baseurl.$helper->getSubUrl()."/".str_replace(" ",$connector,$tag).".html";
    			}
    			
    			$xml .= $helper->createItem($loc,$changeFreq);
    			if (($i%$num == 0 && $i != 0) || $i==$total-1) {
    				$xml .= "</urlset>";
    				$jj = $j+1;
    				$code = $store->getCode();
					$code='en';
    				//$fileName = $mediaPath."sitemap-$identify-$code-$number.xml";
    				//$gz = gzopen($fileName.'.gz', 'w');
					//gzwrite($gz, $xml);
					//gzclose($gz);
					$fileName = $mediaPath."sitemap-$code-$identify-$number.xml";
					if (file_exists($fileName)) {
						unlink($fileName);
					}
					$file = fopen($fileName,'a');
					fwrite($file, $xml);
					fclose($file);
    				$j++;
    			}
    			$i++;
    		}
    	}	
    }
    public function generateSitemap($store,$path,$filePath,$baseurl='')
    {
    	
    	$helper = Mage::helper('itags');
    	if (!$baseurl) {
    		$gssUrl = Mage::app()->getStore($store->getId())->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    	} else {
    		$gssUrl = $baseurl;
    	}
    	
    	$gssUrl = $gssUrl.'gss.xsl';
    	$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<?xml-stylesheet type=\"text/xsl\" href=\"$gssUrl\"?>
			<sitemapindex xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
			        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
			        http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\"
			        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$code='en';
		$sitemaps = $helper->getSitemaps($code,$filePath,$baseurl);
	//	$sitemaps = $helper->getSitemaps($store->getCode(),$filePath,$baseurl);
		//var_dump(count($sitemaps));
		if (count($sitemaps)) {
			$xml = $xmlHeader;
			foreach ($sitemaps as $s) {
				$xml .= $helper->createSitemapXmlItem($s['file'],$s['date']);
			}
			$xml .= "</sitemapindex>";
			$fileName = Mage::getBaseDir().$path.'sitemap.xml';
			
			if (file_exists($fileName)) {
				unlink($fileName);
			}
			$file = fopen($fileName,'a');
			fwrite($file, $xml);
			fclose($file);
		}
    }
    protected function _getSession()
    {
    	return Mage::getSingleton('adminhtml/session');
    }
    
    
}