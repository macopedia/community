<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_community_domain_model_message'] = array(
	'ctrl' => $TCA['tx_community_domain_model_message']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sender,recipient,read,sent,read_date,sent_date,subject,message'
	),
	'types' => array(
		'1' => array('showitem' => 'sender,recipient,read,sent,read_date,sent_date,subject,message')
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
		'sender' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sender',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			)
		),
		'recipient' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.recipient',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			)
		),
		'sent_date' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sent_date',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime'
			)
		),
		'read_date' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.read_date',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime'
			)
		),
		'sent' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sent',
			'config'  => array(
				'type' => 'check'
			)
		),
		'tx_community_read' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.read',
			'config'  => array(
				'type' => 'check'
			)
		),
		'subject' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.subject',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'message' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.message',
			'config'  => array(
				'type' => 'text',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'sender_deleted' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sender_deleted',
			'config'  => array(
				'type' => 'check'
			)
		),
		'recipient_deleted' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.recipient_deleted',
			'config'  => array(
				'type' => 'check'
			)
		),
	)
);
?>