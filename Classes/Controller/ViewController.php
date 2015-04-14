<?php
namespace BERGWERK\BwrkSitemap\Controller;

use BERGWERK\BwrkSitemap\Domain\Model\Content;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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

    protected $cObj;

    /**
     * @var int
     */
    protected $pid;

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