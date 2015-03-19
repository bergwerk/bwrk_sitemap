<?php
namespace BERGWERK\BwrkSitemap\Hook;

use BERGWERK\BwrkSitemap\Configuration;

class AddItemsToFlexform extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    function showBaseUrl($config)
    {
        $optionList = array();

        $baseUrl = Configuration::getBaseUrl();

        $optionList[0] = array(0 => $baseUrl);

        $config['items'] = array_merge($config['items'], $optionList);

        return $config;
    }
}