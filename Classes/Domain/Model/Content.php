<?php

namespace BERGWERK\BwrkSitemap\Domain\Model;

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