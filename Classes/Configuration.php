<?php

namespace BERGWERK\BwrkSitemap;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Georg Dümmler <gd@bergwerk.ag>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author	Georg Dümmler <gd@bergwerk.ag>
 * @package	TYPO3
 * @subpackage	bwrk_sitemap
 ***************************************************************/

use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class Configuration
 * @package BERGWERK\BwrkSitemap
 */
class Configuration
{
    /**
     * @var array
     */
    private static $_cache = array();

    /**
     * @param $key
     * @return mixed
     */
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

    /**
     * @param $key
     * @return mixed
     */
    private static function getExtensionConfiguration($key)
    {
        $extensionSetup = 'plugin.tx_bwrksitemap.settings.';
        $newKey = $extensionSetup . $key;

        return self::getConfiguration($newKey);
    }

    /**
     * @param $data
     * @param $key
     * @return null
     */
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

    /**
     * @return mixed
     */
    public static function getBaseUrl()
    {
        return self::getConfiguration('page.config.baseURL');
    }

    /**
     * @return mixed
     */
    public static function getDetailPidDefault()
    {
        return self::getExtensionConfiguration('products.detailPid.default');
    }

    /**
     * @param $uid
     * @return mixed
     */
    public static function getDetailPidByCategoryUid($uid)
    {
        $setting = self::getExtensionConfiguration('products.detailPid.'.$uid);

        if (empty($setting))
            return self::getDetailPidDefault();

        return $setting;
    }
}