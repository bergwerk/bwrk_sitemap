<?php
namespace BERGWERK\BwrkSitemap\Controller;

use BERGWERK\BwrkProducts\Domain\Model\Item;
use BERGWERK\BwrkProducts\Domain\Repository\ItemRepository;
use BERGWERK\BwrkSitemap\Configuration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ViewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \BERGWERK\BwrkSitemap\Domain\Repository\ViewRepository
     * @inject
     */
    protected $viewRepository;

    /**
     * showAction function.
     *
     * @access public
     * @return void
     */
    public function showAction()
    {
        $siteRoot = $this->viewRepository->getSiteRoot();

        for ($i = 0; $i < count($siteRoot); $i++) {
            $rootID = $siteRoot[$i]['uid'];
            $tree = $this->viewRepository->getAllPages($rootID);
        }

        $this->view->assign('pages', $tree);

        $this->assignProducts();
    }

    private function assignProducts()
    {
        $productRepository = ItemRepository::create();
        $products = $productRepository->findAll();

        $view = array();

        /** @var Item $product */
        foreach ($products as $product)
        {
            $category = $product->getCategory();

            $detailPid = Configuration::getDetailPidDefault();

            if (!is_null($category))
            {
                $detailPid = Configuration::getDetailPidByCategoryUid($category->getUid());
            }

            $view[] = array(
                'uid' => $product->getUid(),
                'detailPid' => $detailPid,
                'tstamp' => time()
            );
        }

        $this->view->assign('products', $view);
    }
}