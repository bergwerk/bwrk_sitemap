<?php

namespace BERGWERK\BwrkSitemap\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class ReplaceViewHelper extends AbstractViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @inject
     */
    protected $configurationManager;
    /**
     * @var ContentObject
     */
    protected $_cObj;

    /**
     * @param string $context
     * @param string $search
     * @param string $replace
     * @return mixed
     */
    public function render($search, $replace, $context = '')
    {
        if (empty($context))
            $context = $this->renderChildren();

        return str_replace($search, $replace, $context);
    }
}