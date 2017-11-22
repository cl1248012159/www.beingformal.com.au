<?php
/**
 * @author Joy <yanggaojiao@qq.com> (http://ecommerce.iifire.com)
 * @copyright Copyright &copy; 2012, Iifire (http://demo.iifire.com)
 * @support Hellokeykey (http://www.hellokeykey.com)
 * @version 1.6.0
 */
class Iifire_Tags_Model_Sitemap extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('iifire_tags/sitemap','sitemap_id');
    }
    protected function _beforeSave()
    {
        $io = new Varien_Io_File();
        $realPath = $io->getCleanPath(Mage::getBaseDir() . '/' . $this->getSitemapPath());
		$realFilePath = $io->getCleanPath(Mage::getBaseDir() . '/' . $this->getSitemapFilePath());
        /**
         * Check path is allow
         */
        if (!$io->allowedPath($realPath, Mage::getBaseDir()) || !$io->allowedPath($realFilePath, Mage::getBaseDir())) {
            Mage::throwException(Mage::helper('sitemap')->__('Please define correct path'));
        }
        /**
         * Check exists and writeable path
         */
        if (!$io->fileExists($realPath, false) ||!$io->fileExists($realFilePath, false)) {
            Mage::throwException(Mage::helper('sitemap')->__('Please create the specified folder "%s" and "%s" before saving the sitemap.', Mage::helper('core')->htmlEscape($this->getSitemapPath()),Mage::helper('core')->htmlEscape($this->getSitemapFilePath())));
        }

        if (!$io->isWriteable($realPath) || !$io->isWriteable($realFilePath)) {
            Mage::throwException(Mage::helper('sitemap')->__('Please make sure that "%s" is writable by web-server.', $this->getSitemapPath()));
        }
        /**
         * Check allow filename
         */
        if (!preg_match('#^[a-zA-Z0-9_\.]+$#', $this->getSitemapFilename())) {
            Mage::throwException(Mage::helper('sitemap')->__('Please use only letters (a-z or A-Z), numbers (0-9) or underscore (_) in the filename. No spaces or other characters are allowed.'));
        }
        if (!preg_match('#\.xml$#', $this->getSitemapFilename())) {
            $this->setSitemapFilename($this->getSitemapFilename() . '.xml');
        }

        $this->setSitemapPath(rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $realPath), '/') . '/');
        $this->setSitemapFilePath(rtrim(str_replace(str_replace('\\', '/', Mage::getBaseDir()), '', $realFilePath), '/') . '/');
		
        return parent::_beforeSave();
    }
}
