<?php
namespace BERGWERK\BwrkSitemap\Controller;

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

use BERGWERK\BwrkSitemap\Domain\Model\Content;

/**
 * Class ViewController
 * @package BERGWERK\BwrkSitemap\Controller
 */
class ViewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \BERGWERK\BwrkSitemap\Domain\Repository\ViewRepository
     * @inject
     */
    protected $viewRepository;

    /**
     * @var \BERGWERK\BwrkSitemap\Domain\Repository\ContentRepository
     * @inject
     */
    protected $contentRepository;

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;

    /**
     * @var array
     */
    protected $pagesToExclude;

    /**
     * @var
     */
    protected $cObj;

    /**
     * @var int
     */
    protected $pid;

    /**
     *
     */
    protected function initializeAction()
    {
        $this->cObj = $this->configurationManager->getContentObject();
        $this->pid = $this->cObj->data['uid'];

        $this->getConfiguration();
        $this->pagesToExclude = $this->getPagesToExclude();
    }

    /**
     * showAction function.
     *
     * @access public
     * @return void
     */
    public function showAction()
    {
        $pages = $this->getPagesWithoutExcludes();


        /*
         * Signal for other Extensions
         */

        /**
         * @var array $linksArr
         */
        $linksArr = array();
        $linksArr[] = array(
            'uri' => 'http://google.de/',
            'lastModified' => time()
        );

        $dataArr = array();
        $dataArr[] = array(
            'plugin' => 'Plugin',
            'controller' => 'Controller',
            'action' => 'Action',
            'extension' => 'Extension',
            'pageUid' => 1,
            'lastModified' => time(),
            'arguments' => array(
                'key' => 'value'
            )
        );
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'addExtensionLinks', array(&$linksArr, &$dataArr));

        unset($linksArr[0]);
        unset($dataArr[0]);


        $this->view->assign('pages', $pages);
        $this->view->assign('linkArr', $linksArr);
        $this->view->assign('dataArr', $dataArr);
    }

    /**
     * @return array
     */
    private function getPagesWithoutExcludes()
    {
        $siteRoot = $this->viewRepository->getSiteRoot();
        $pages = $this->getPages($siteRoot);

        $newPages = array();
        foreach($pages as $page)
        {
            if(!in_array($page['uid'], $this->pagesToExclude))
            {
                $newPages[] = $page;
            }
        }
        return $newPages;
    }

    /**
     * @param array $siteRoots
     * @return array
     */
    private function getPages($siteRoots)
    {
        $pages = array();
        foreach($siteRoots as $siteRoot)
        {
            $this->findPagesRecursive($siteRoot['uid'], $pages);
        }
        return $pages;
    }

    /**
     * @return array
     */
    private function getPagesToExclude()
    {
        if(empty($this->settings['pagesToExclude'])) return array();

        $pagesToExclude = explode(',', $this->settings['pagesToExclude']);

        $whichPagesUids = array();
        $whichPages = array();
        foreach($pagesToExclude as $pageToExclude)
        {
            if($this->settings['recursive'] == 1)
            {
                $this->findPagesRecursive($pageToExclude, $whichPages);
            } else {
                $tmpPages = $this->findPages($pageToExclude);
                foreach($tmpPages as $tmpPage)
                {
                    $whichPages[] = $tmpPage;
                }
            }
        }
        foreach($whichPages as $whichPage)
        {
            $whichPagesUids[] = $whichPage['uid'];
        }
        return $whichPagesUids;
    }

    /**
     * @param int $pid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    private function findPages($pid)
    {
        return $this->viewRepository->getAllPagesForPid($pid);
    }

    /**
     * @param int $pid
     * @param array $pagesTmp
     * @return array
     */
    private function findPagesRecursive($pid, &$pagesTmp)
    {
        $pages = $this->findPages($pid);
        if(count($pages) > 0)
        {
            foreach($pages as $page)
            {
                $pagesTmp[] = $page;
                $this->findPagesRecursive($page['uid'], $pagesTmp);
            }
        }
        return $pagesTmp;
    }


    /**
     *
     */
    private function getConfiguration()
    {
        $conf = array();

        /** @var Content $contentElement */
        $contentElements = $this->contentRepository->findByPid($this->pid);
        foreach($contentElements as $contentElement)
        {
            if($contentElement->getListType() == 'bwrksitemap_bwrksitemap')
            {
                $this->configurationManager->getContentObject()->readFlexformIntoConf($contentElement->getPiFlexform(), $conf);
                break;
            }
        }

        $tmpConf = $conf;
        $conf = array();
        foreach($tmpConf as $key => $value)
        {
            $conf[str_replace('settings.', '', $key)] = $value;
        }

        $settings = $this->settings;
        foreach($settings as $key => $value)
        {
            $settings[$key] = $conf[$key];
        }
        $this->settings = $settings;
    }
}