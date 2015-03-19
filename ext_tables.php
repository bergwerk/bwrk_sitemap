<?php
	
	if(!defined('TYPO3_MODE')) die ('Access denied.');
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'BERGWERK.'.$_EXTKEY,
		'bwrkSitemap',
		'BERGWERK Sitemap'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BERGWERK Sitemap');
?>