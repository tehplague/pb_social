<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Socialbar',
	array(
		'Item' => 'showSocialBar',
		
	),
	// non-cacheable actions
	array(
		'Item' => 'showSocialBar',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Socialfeed',
	array(
		'Item' => 'showSocialFeed,showContentForUrl',
		
	),
	// non-cacheable actions
	array(
		'Item' => 'showSocialFeed,showContentForUrl',
		
	)
);

?>