<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://www.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://www.iifire.com)
 * @version 1.7.0
 */
class Iifire_Tags_Model_Observer
{

    /**
     * Enable/disable configuration
     */
    const XML_PATH_SITEMAPCRON_ENABLED = 'iifire_tags/sitemap_cron/enabled';

    /**
     * Cronjob expression configuration
     */
    const XML_PATH_CRON_EXPR = 'crontab/jobs/generate_sitemaps/schedule/cron_expr';

    /**
     * Error email template configuration
     */
    const XML_PATH_ERROR_TEMPLATE  = 'iifire_tags/sitemap_cron/error_email_template';

    /**
     * Error email identity configuration
     */
    const XML_PATH_ERROR_IDENTITY  = 'iifire_tags/sitemap_cron/error_email_identity';

    /**
     * 'Send error emails to' configuration
     */
    const XML_PATH_ERROR_RECIPIENT = 'iifire_tags/sitemap_cron/error_email';

    /**
     * Generate sitemaps
     *
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function scheduledGenerateSitemaps($schedule)
    {
    	echo 'gao';die();
        $errors = array();
        // check if scheduled generation enabled
        if (!Mage::getStoreConfigFlag(self::XML_PATH_SITEMAPCRON_ENABLED)) {
            return;
        }
		foreach (Mage::getModel('admihtml/system_store')->getStoreOptionHash() as $_store) {
			$storeName = $_store->getName();
    		$storeCode = $_store->getCode();
    		$storeName = $_store->getName();
	    	$helper = Mage::helper('itags');
	    	try {
	        	$this->generateAllXml($storeCode);
	    	} catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
		};
        if ($errors && Mage::getStoreConfig(self::XML_PATH_ERROR_RECIPIENT)) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);

            $emailTemplate = Mage::getModel('core/email_template');
            /* @var $emailTemplate Mage_Core_Model_Email_Template */
            $emailTemplate->setDesignConfig(array('area' => 'backend'))
                ->sendTransactional(
                    Mage::getStoreConfig(self::XML_PATH_ERROR_TEMPLATE),
                    Mage::getStoreConfig(self::XML_PATH_ERROR_IDENTITY),
                    Mage::getStoreConfig(self::XML_PATH_ERROR_RECIPIENT),
                    null,
                    array('warnings' => join("\n", $errors))
                );
            $translate->setTranslateInline(true);
        }
    }
    public function generateAllXml($storeCode)
    {
    	$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<?xml-stylesheet type=\"text/xsl\" href=\"gss.xsl\"?>
			<sitemapindex xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
			        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
			        http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\"
			        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$helper = Mage::helper('itags');
		$sitemaps = $helper->getSitemaps($storeCode);
		if (count($sitemaps)) {
			$xml = $xmlHeader;
			foreach ($sitemaps as $s) {
				$xml .= $helper->createSitemapXmlItem($s['file'],$s['date']);
			}
			$xml .= "</sitemapindex>";
			if (!Mage::app()->isSingleStoreMode()) {
				$fileName = Mage::getBaseDir().DS.'sitemap-'.$storeCode.'.xml';
			} else {
				$fileName = Mage::getBaseDir().DS.'sitemap.xml';
			}
			if (file_exists($fileName)) {
				unlink($fileName);
			}
			$file = fopen($fileName,'a');
			fwrite($file, $xml);
			fclose($file);
		}
    }
}
