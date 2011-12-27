<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_community_domain_model_relation'] = array(
	'ctrl' => $TCA['tx_community_domain_model_relation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'initiating_user,requested_user,initiation_time,status'
	),
	'types' => array(
		'1' => array('showitem' => 'initiating_user,requested_user,initiation_time,status')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'initiating_user' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.initiating_user',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			)
		),
		'requested_user' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.requested_user',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			)
		),
		'initiation_time' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.initiation_time',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime'
			)
		),
		'status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.1', 1),
					array('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.2', 2),
					array('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.4', 4),
					array('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.8', 8)
				),
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 1
			)
		)
	)
);

?>