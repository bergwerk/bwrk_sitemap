<?php

namespace BERGWERK\BwrkSitemap;

use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class Configuration
{
    private static $_cache = array();

    private static function getConfiguration($key)
    {
        if (!isset(self::$_cache[$key])) {
            /* @var $objectManager ObjectManager */
            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

            /* @var $configurationManager ConfigurationManager */
            $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');

            $setup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

            $arrayKey = explode('.', $key);

            self::$_cache[$key] = self::getConfigurationSub($setup, $arrayKey);
        }

        return self::$_cache[$key];
    }
    private static function getExtensionConfiguration($key)
    {
        $extensionSetup = 'plugin.tx_bwrksitemap.settings.';
        $newKey = $extensionSetup . $key;

        return self::getConfiguration($newKey);
    }
    private static function getConfigurationSub($data, $key)
    {
        $currentKey = array_shift($key);

        if (count($key) > 0) {
            $currentKey .= '.';
        }

        if (!isset($data[$currentKey])) return null;

        $currentData = $data[$currentKey];

        if (!is_array($currentData)) return $currentData;

        return self::getConfigurationSub($currentData, $key);
    }

    public static function getBaseUrl()
    {
        return self::getConfiguration('page.config.baseURL');
    }

    public static function getDetailPidDefault()
    {
        return self::getExtensionConfiguration('products.detailPid.default');
    }

    public static function getDetailPidByCategoryUid($uid)
    {
        $setting = self::getExtensionConfiguration('products.detailPid.'.$uid);

        if (empty($setting))
            return self::getDetailPidDefault();

        return $setting;
    }
}