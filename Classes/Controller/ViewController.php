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


    protected $cObj;
    protected $pid;

    protected function initializeAction()
    {
        $this->cObj = $this->configurationManager->getContentObject();
        $this->pid = $this->cObj->data['uid'];

        $this->getConfiguration();

    }


    /**
     * showAction function.
     *
     * @access public
     * @return void
     */
    public function showAction()
    {
        $siteRoot = $this->viewRepository->getSiteRoot();

        $pages = $this->getPages($siteRoot);


        $tree = $this->excludePages($pages);

        DebuggerUtility::var_dump($this->settings);
        DebuggerUtility::var_dump($pages);

        $this->view->assign('pages', $pages);

    }


    private function getPages($sites)
    {
        $pages = array();
        foreach($sites as $site)
        {
            $pages[] = $this->viewRepository->getAllPages($site['uid']);
        }
        return $pages;
    }




    private function excludePages($pages)
    {
        if(empty($this->settings['pagesToExclude'])) return $pages;

        $pagesToExclude = explode(',', $this->settings['pagesToExclude']);

        if($this->settings['recursive'] == 0)
        {
            $pagesTmp = array();
            foreach($pages as $page)
            {
                if(!in_array($page['uid'], $pagesToExclude))
                {
                    $pagesTmp[] = $page;
                }
            }
            $pages = $pagesTmp;
        } else {

        }






        return $pages;
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