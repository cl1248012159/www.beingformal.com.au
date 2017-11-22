<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Review
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Review controller
 *
 * @category   Mage
 * @package    Mage_Review
 * @author     Magento Core Team <core@magentocommerce.com>
 */
require_once("Mage/Review/controllers/ProductController.php");
class Kush_Reviewimage_ProductController extends Mage_Review_ProductController
{


    /**
     * Submit new review action
     *
     */
    public function postAction()
    {

        if (!$this->_validateFormKey()) {
            // returns to the product item page
            $this->_redirectReferer();
            return;
        }
        if ($data = Mage::getSingleton('review/session')->getFormData(true)) {
            $rating = array();
            if (isset($data['ratings']) && is_array($data['ratings'])) {
                $rating = $data['ratings'];
            }
        } else {
            $data   = $this->getRequest()->getPost();
            $rating = $this->getRequest()->getParam('ratings', array());
        }

        if( isset($_FILES) ){
            $path = Mage::getBaseDir('media').DS.'reviewimages';
            for($i=1;$i<6;$i++){
                if(isset($_FILES['reviewimage'.$i]['name']) && $_FILES['reviewimage'.$i]['name'] != '') {
                    try {
                        $uploader = new Varien_File_Uploader('reviewimage'.$i);
                        $result = $uploader
                            ->setAllowedExtensions(array('jpg','jpeg','gif','png'))
                            ->setAllowRenameFiles(true)
                            ->setFilesDispersion(true)
                            ->setAllowCreateFolders(true)
                            ->save($path,$_FILES['reviewimage'.$i]['name'] );
                        $data['reviewimage'.$i] = $result['file'];
                    } catch (Exception $e) {}
                }
            }
        }


        if( $productku = $this->getRequest()->getParam('sku', false) ){
            $productId = Mage::getModel('catalog/product')->getIdBySku($productku);
            $this->getRequest()->setParam('id', $productId);
        }






        if (($product = $this->_initProduct()) && !empty($data)) {
            $session    = Mage::getSingleton('core/session');
            /* @var $session Mage_Core_Model_Session */
            $review     = Mage::getModel('review/review')->setData($data);
            /* @var $review Mage_Review_Model_Review */

            $validate = $review->validate();
            $data_success = true;
            if ($validate === true) {
                try {
                    $review->setEntityId($review->getEntityIdByCode(Mage_Review_Model_Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Mage_Review_Model_Review::STATUS_APPROVED)
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStores(array(Mage::app()->getStore()->getId()))
                        ->save();

                    foreach ($rating as $ratingId => $optionId) {
                        Mage::getModel('rating/rating')
                        ->setRatingId($ratingId)
                        ->setReviewId($review->getId())
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->addOptionVote($optionId, $product->getId());
                    }

                    $review->aggregate();
                    $session->addSuccess($this->__('Your review has been accepted for moderation.'));
                    $data_success = true;
                }
                catch (Exception $e) {
                    Mage::log($e);
                    $session->setFormData($data);
                    $session->addError($this->__('Unable to post the review.'));
                    $data_success = false;
                }
            }
            else {
                $session->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $session->addError($errorMessage);
                        $data_success = false;
                    }
                }
                else {
                    $session->addError($this->__('Unable to post the review.'));
                    $data_success = false;
                }
            }
        }

        if ($redirectUrl = Mage::getSingleton('review/session')->getRedirectUrl(true)) {
            $this->_redirectUrl($redirectUrl);
            return;
        }
        if($data_success){
            $this->_redirectRefererAddAnchor(null,'#review-form');
        }else{
            $this->_redirectReferer();
        }
        
    }

    
}
