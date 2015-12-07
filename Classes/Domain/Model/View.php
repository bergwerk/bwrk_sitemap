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
     * @author    Georg Dümmler <gd@bergwerk.ag>
     * @package    TYPO3
     * @subpackage    bwrk_sitemap
     ***************************************************************/

/**
 * Class View
 * @package BERGWERK\BwrkSitemap\Domain\Model
 */
class View extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $sorting = 0;

    /**
     * @var int
     */
    protected $deleted = 0;

    /**
     * @var int
     */
    protected $editlock = 0;

    /**
     * @var int
     */
    protected $hidden = 0;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var int
     */
    protected $doktype = 0;

    /**
     * @var int
     */
    protected $isSiteroot = 0;

    /**
     * @return int
     */
    public function getIsSiteroot()
    {
        return $this->isSiteroot;
    }

    /**
     * @param int $isSiteroot
     */
    public function setIsSiteroot($isSiteroot)
    {
        $this->isSiteroot = $isSiteroot;
    }

    /**
     * @return int
     */
    public function getDoktype()
    {
        return $this->doktype;
    }

    /**
     * @param int $doktype
     */
    public function setDoktype($doktype)
    {
        $this->doktype = $doktype;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param int $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return int
     */
    public function getEditlock()
    {
        return $this->editlock;
    }

    /**
     * @param int $editlock
     */
    public function setEditlock($editlock)
    {
        $this->editlock = $editlock;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param int $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }


}