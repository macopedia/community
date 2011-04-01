<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_community_domain_model_album'] = array(
	'ctrl' => $TCA['tx_community_domain_model_album']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, private, photos',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, user, private, photos,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_community_domain_model_album',
				'foreign_table_where' => 'AND tx_community_domain_model_album.pid=###CURRENT_PID### AND tx_community_domain_model_album.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' =>array(
				'type' =>'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
			'type' => 'input',
			'size' => '30',
			'max' => '255',
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0',
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0',
				'range' => array(
					'upper' => mktime(0, 0, 0, 12, 31, date('Y') + 10),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				),
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'private' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.private',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.public', 0),
					array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.loggedInOnly', 1),
					array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.friendsOnly', 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'photos' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.photos',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_community_domain_model_photo',
				'foreign_field' => 'album',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'both',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'user' => array(
			'exclude' => 0,
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'maxitems'      => 1
			),
		),
	),
);
?>