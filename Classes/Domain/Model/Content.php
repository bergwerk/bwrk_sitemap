<?php

namespace BERGWERK\BwrkSitemap\Domain\Model;

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

/**
 * Class Content
 * @package BERGWERK\BwrkSitemap\Domain\Model
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /** @var string */
    protected $piFlexform = '';

    /** @var string */
    protected $listType = '';

    /**
     * @return string
     */
    public function getPiFlexform()
    {
        return $this->piFlexform;
    }

    /**
     * @param string $piFlexform
     */
    public function setPiFlexform($piFlexform)
    {
        $this->piFlexform = $piFlexform;
    }

    /**
     * @return string
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param string $listType
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
    }



}