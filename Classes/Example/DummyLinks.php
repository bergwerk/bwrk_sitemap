<?php

namespace BERGWERK\BwrkSitemap\Example;

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
 * @subpackage	bwrk_onepage
 ***************************************************************/

/**
 * Class DummyLinks
 *
 * Example: How to register this Signal-Slot-Dispatcher in your ext_localconf
 *
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
        'BERGWERK\\BwrkSitemap\\Controller\\ViewController',
        'addExtensionLinks',
        'BERGWERK\\BwrkSitemap\\Example\\DummyLinks',
        'addLinks'
    );
 *
 * @package BERGWERK\BwrkSitemap\Example
 */
class DummyLinks
{
    /**
     * @return array
     */
    protected function getLinks()
    {
        // ... establish database connection, get models and generate urls

        return array(
            'http://www.facebook.com',
            'http://www.twitter.com'
        );
    }

    /**
     * @param array $links
     */
    public function addLinks(&$links)
    {
        foreach ($this->getLinks() as $link)
        {
            $links[] = array(
                'uri' => $link,
                'lastModified' => time()
            );
        }
    }
}