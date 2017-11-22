<?php
class Iifire_Tags_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();
    	$helper = Mage::helper('itags');
    	$letter = $this->getRequest()->getParam('w');
    	$p = $this->getRequest()->getParam('p');
    	$headBlock = $this->getLayout()->getBlock('head');
    	
		if ($letter) {
		    $title = $helper->getListLetterTitle();
		    $keywords = $helper->getListLetterKeywords();
	    	$description = $helper->getListLetterDescription();
	    	$title = !$p ? str_replace('{page}', '', $title) : str_replace('{page}', ' - '.$helper->__('Page ').$p, $title);
	    	$title = str_replace('{letter}', $letter, $title);
	    	$keywords = str_replace('{}', $letter, $keywords);
	    	$description = str_replace('{}', $letter, $description);
			$headBlock->setTitle($title)->setKeywords($keywords)->setDescription($description);
		} else {
			$title = $helper->getListTitle();
	    	$keywords = $helper->getListKeywords();
	    	$description = $helper->getListDescription();
	    	$title = !$p ? str_replace('{page}', '', $title) : str_replace('{page}', ' - '.$helper->__('Page ').$p, $title);
	        $headBlock->setTitle($title)->setKeywords($keywords)->setDescription($description);
		}
		$baseUrl = Mage::getBaseUrl();
    	$breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
		$breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>$baseUrl));
		$breadcrumbs->addCrumb($helper->getSubUrl(), array('label'=>$helper->__($helper->getSubUrl()), 'title'=>$helper->__($helper->getSubUrl()), 'link'=>$helper->getBaseSeoUrl()));
		if($letter) {
			$breadcrumbs->addCrumb($letter, array('label'=>$helper->__($letter), 'title'=>$helper->__($letter)));	
		}
		
    	$this->renderLayout();
    }
	public function homeAction()
    {
    	$this->loadLayout();
    	$helper = Mage::helper('itags');
    	$letter = $this->getRequest()->getParam('w');
    	$p = $this->getRequest()->getParam('p');
    	$headBlock = $this->getLayout()->getBlock('head');
    	
		if ($letter) {
		    $title = $helper->getListLetterTitle();
		    $keywords = $helper->getListLetterKeywords();
	    	$description = $helper->getListLetterDescription();
	    	$title = !$p ? str_replace('{page}', '', $title) : str_replace('{page}', ' - '.$helper->__('Page ').$p, $title);
	    	$title = str_replace('{letter}', $letter, $title);
	    	$keywords = str_replace('{}', $letter, $keywords);
	    	$description = str_replace('{}', $letter, $description);
			$headBlock->setTitle($title)->setKeywords($keywords)->setDescription($description);
		} else {
			$title = $helper->getListTitle();
	    	$keywords = $helper->getListKeywords();
	    	$description = $helper->getListDescription();
	    	$title = !$p ? str_replace('{page}', '', $title) : str_replace('{page}', ' - '.$helper->__('Page ').$p, $title);
	        $headBlock->setTitle($title)->setKeywords($keywords)->setDescription($description);
		}
		$baseUrl = Mage::getBaseUrl();
    	$breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
		$breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>$baseUrl));
		$breadcrumbs->addCrumb($helper->getSubUrl(), array('label'=>$helper->__($helper->getSubUrl()), 'title'=>$helper->__($helper->getSubUrl()), 'link'=>$helper->getBaseSeoUrl()));
		if($letter) {
			$breadcrumbs->addCrumb($letter, array('label'=>$helper->__($letter), 'title'=>$helper->__($letter)));	
		}
		
    	$this->renderLayout();
    }
	
    public function viewAction()
    {
    	$helper = Mage::helper('itags');
    	$p = $this->getRequest()->getParam('p');
    	$p = trim($p);
    	$query = Mage::helper('catalogsearch')->getQuery();
    	if ($query->getQueryText()) {
    		
	    	$this->loadLayout();
	    	
	    	$breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
	    	//echo "<xmp>"; var_dump($breadcrumbs); echo "</xmp>";
	    	$breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>Mage::getBaseUrl()));
			$breadcrumbs->addCrumb('search', array('label'=>$helper->__($helper->getSubUrl()), 'title'=>$helper->__($helper->getSubUrl()), 'link'=>$helper->getBaseSeoUrl()));
			if($this->getTagIndex()) {
				$letter = $this->getTagIndex();
				$breadcrumbs->addCrumb($letter, array('label'=>$helper->__($letter), 'title'=>$helper->__($letter),'link'=>$helper->getLetterUrl($letter)));
				$breadcrumbs->addCrumb($query->getQueryText(), array('label'=>$helper->__(ucwords($query->getQueryText())), 'title'=>$helper->__(ucwords($query->getQueryText()))));	
			}
			
	    	$q = $this->getRequest()->getParam('q');
	    	$head = $this->getLayout()->getBlock('head');
			if ($q) {
				$title = $helper->getViewTitle();
				$q = str_replace($helper->getConnector(),' ',$q);
				$title = !$p ? str_replace('{page}', '', $title) : str_replace('{page}', ' - '.$helper->__('Page ').$p, $title);
				
				$head->setTitle(str_replace("{}", ucwords($q), $title));
				$head->setKeywords(strtolower(str_replace("{}",$q,$helper->getViewKeywords())));
				$head->setDescription(strtolower(str_replace("{}",$q,$helper->getViewDescription())));
			}
			//echo 'yang';die();
	    	$this->renderLayout();
    	} else {
    		$this->_redirectReferer();
    	}
    }
    public function saveAction()
    {
        $customerSession = Mage::getSingleton('customer/session');
        if(!$customerSession->authenticate($this)) {
            return;
        }
        
        $tagName    = (string) $this->getRequest()->getQuery('productTagName');
        $productId  = (int)$this->getRequest()->getParam('product');

        if(strlen($tagName) && $productId) {
            $session = Mage::getSingleton('catalog/session');
            $product = Mage::getModel('catalog/product')
                ->load($productId);
            if(!$product->getId()){
                $session->addError($this->__('Unable to save tag(s).'));
            } else {
                try {
                    $customerId = $customerSession->getCustomerId();
                    $storeId = Mage::app()->getStore()->getId();

                    $tagModel = Mage::getModel('tag/tag');

                    // added tag relation statuses
                    $counter = array(
                        Mage_Tag_Model_Tag::ADD_STATUS_NEW => array(),
                        Mage_Tag_Model_Tag::ADD_STATUS_EXIST => array(),
                        Mage_Tag_Model_Tag::ADD_STATUS_SUCCESS => array(),
                        Mage_Tag_Model_Tag::ADD_STATUS_REJECTED => array()
                    );

                    $tagNamesArr = $this->_cleanTags($this->_extractTags($tagName));
                    foreach ($tagNamesArr as $tagName) {
                        // unset previously added tag data
                        $tagModel->unsetData()
                            ->loadByName($tagName);

                        if (!$tagModel->getId()) {
                            $tagModel->setName($tagName)
                                ->setFirstCustomerId($customerId)
                                ->setFirstStoreId($storeId)
                                ->setStatus($tagModel->getPendingStatus())
                                ->save();
                        }
                        
                        $tags = Mage::getModel('iifire_tags/tags');
		        		$tags->setStoreId($storeId);
		        		$tags->loadByTagsText($tagName);
		        		if (!$tags->getId()) {
		        			$tags->setStoreId(Mage::app()->getStore()->getId());
		        			$tags->setTagsText($tagName);
		        			try {
		        				$tags->save();
		        			} catch (Exception $e) {
		        				
		        			}
		        		}
                        
                        $relationStatus = $tagModel->saveRelation($productId, $customerId, $storeId);
                        $counter[$relationStatus][] = $tagName;
                    }
                    $this->_fillMessageBox($counter);
                } catch (Exception $e) {
                    Mage::logException($e);
                    $session->addError($this->__('Unable to save tag(s).'));
                }
            }
        }
        
        $this->_redirectReferer();
    }
    public function getQueryParam()
    {
    	return $this->getRequest()->getParam('q');
    }
    public function getTagIndex()
    {
    	$q = $this->getQueryParam();
    	if (trim($q)) {
    		$index = substr($q,0,1);
    		if (!is_numeric($index)) {
    			return strtoupper($index);
    		} else {
    			return '0-9';
    		}
    		
    	} else {
    		return false;
    	}
    }
        /**
     * Checks inputed tags on the correctness of symbols and split string to array of tags
     *
     * @param string $tagNamesInString
     * @return array
     */
    protected function _extractTags($tagNamesInString)
    {
        return explode("\n", preg_replace("/(\'(.*?)\')|(\s+)/i", "$1\n", $tagNamesInString));
    }

    /**
     * Clears the tag from the separating characters.
     *
     * @param array $tagNamesArr
     * @return array
     */
    protected function _cleanTags(array $tagNamesArr)
    {
        $helper = Mage::helper('core');
        foreach( $tagNamesArr as $key => $tagName ) {
            $tagNamesArr[$key] = trim($tagNamesArr[$key], '\'');
            $tagNamesArr[$key] = trim($tagNamesArr[$key]);
            $tagNamesArr[$key] = $helper->escapeHtml($tagNamesArr[$key]);
            if( $tagNamesArr[$key] == '' ) {
                unset($tagNamesArr[$key]);
            }
        }
        return $tagNamesArr;
    }

    /**
     * Fill Message Box by success and notice messages about results of user actions.
     *
     * @param array $counter
     * @return void
     */
    protected function _fillMessageBox($counter)
    {
        $session = Mage::getSingleton('catalog/session');

        if (count($counter[Mage_Tag_Model_Tag::ADD_STATUS_NEW])) {
            $session->addSuccess($this->__('%s tag(s) have been accepted for moderation.',
                count($counter[Mage_Tag_Model_Tag::ADD_STATUS_NEW]))
            );
        }

        if (count($counter[Mage_Tag_Model_Tag::ADD_STATUS_EXIST])) {
            foreach ($counter[Mage_Tag_Model_Tag::ADD_STATUS_EXIST] as $tagName) {
                $session->addNotice($this->__('Tag "%s" has already been added to the product.' ,$tagName));
            }
        }

        if (count($counter[Mage_Tag_Model_Tag::ADD_STATUS_SUCCESS])) {
            foreach ($counter[Mage_Tag_Model_Tag::ADD_STATUS_SUCCESS] as $tagName) {
                $session->addSuccess($this->__('Tag "%s" has been added to the product.' ,$tagName));
            }
        }

        if (count($counter[Mage_Tag_Model_Tag::ADD_STATUS_REJECTED])) {
            foreach ($counter[Mage_Tag_Model_Tag::ADD_STATUS_REJECTED] as $tagName) {
                $session->addNotice($this->__('Tag "%s" has been rejected by administrator.' ,$tagName));
            }
        }
    }
}