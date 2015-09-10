<?php
namespace BERGWERK\BwrkSitemap\Domain\Repository;

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
 * Class ViewRepository
 * @package BERGWERK\BwrkSitemap\Domain\Repository
 */
class ViewRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getSiteRoot()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement('SELECT * FROM pages WHERE hidden=0 AND deleted=0 AND is_siteroot=1');
        return $query->execute();
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getAllPages()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement('SELECT * FROM pages WHERE hidden=0 AND deleted=0 AND doktype!=199 AND doktype!=254 AND nav_hide=0 AND is_siteroot=0 ORDER BY pid,sorting,uid');
        return $query->execute();
    }

    /**
     * @param $pid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getAllPagesForPid($pid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement('SELECT * FROM pages WHERE hidden=0 AND deleted=0 AND doktype!=199 AND doktype!=254 AND nav_hide=0 AND pid='.$pid);
        return $query->execute();
    }
}