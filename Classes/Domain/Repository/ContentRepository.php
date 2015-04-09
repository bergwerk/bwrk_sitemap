<?php

namespace BERGWERK\BwrkSitemap\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function __construct(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager);

        $querySettings = new Typo3QuerySettings();
        $querySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($querySettings);
    }


}