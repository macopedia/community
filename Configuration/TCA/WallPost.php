<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_community_domain_model_wallpost'] = array(
	'ctrl' => $TCA['tx_community_domain_model_wallpost']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'sender,recipient,subject,message',
	),
	'types' => array(
		'1' => array('showitem'	=> 'sender,recipient,subject,message'),
	),
	'palettes' => array(
		'1' => array('showitem'	=> ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude'			=> 1,
			'label'				=> 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config'			=> array(
				'type'					=> 'select',
				'foreign_table'			=> 'sys_language',
				'foreign_table_where'	=> 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
				),
			)
		),
		'l10n_parent' => array(
			'displayCond'	=> 'FIELD:sys_language_uid:>:0',
			'exclude'		=> 1,
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.l10n_parent',
			'config'		=> array(
				'type'			=> 'select',
				'items'			=> array(
					array('', 0),
				),
				'foreign_table' => 'tx_community_domain_model_wallpost',
				'foreign_table_where' => 'AND tx_community_domain_model_wallpost.uid=###REC_FIELD_l10n_parent### AND tx_community_domain_model_wallpost.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array(
			'config'		=>array(
				'type'		=>'passthrough',
			)
		),
		't3ver_label' => array(
			'displayCond'	=> 'FIELD:t3ver_label:REQ:true',
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config'		=> array(
				'type'		=>'none',
				'cols'		=> 27,
			)
		),
		'hidden' => array(
			'exclude'	=> 1,
			'label'		=> 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'	=> array(
				'type'	=> 'check',
			)
		),
		'sender' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.sender',
			'config'	=> array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			),
		),
		'recipient' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.recipient',
			'config'	=> array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			),
		),
		'subject' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.subject',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'message' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.message',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
	),
);
?>