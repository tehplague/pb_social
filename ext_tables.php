<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Socialbar',
	'SocialBar'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Socialfeed',
	'SocialFeed'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BeSocial');

t3lib_extMgm::addLLrefForTCAdescr('tx_pbbesocial_domain_model_item', 'EXT:pb_besocial/Resources/Private/Language/locallang_csh_tx_pbbesocial_domain_model_item.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pbbesocial_domain_model_item');
$TCA['tx_pbbesocial_domain_model_item'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pb_besocial/Resources/Private/Language/locallang_db.xml:tx_pbbesocial_domain_model_item',
		'label' => 'url',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'type,url,date,result,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Item.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pbbesocial_domain_model_item.gif'
	),
);

?>