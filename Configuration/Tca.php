<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

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
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
			//	'foreign_table' => 'tx_community_domain_model_aclrule',
			//	'foreign_table_where' => 'AND tx_community_domain_model_aclrule.uid=###REC_FIELD_l18n_parent### AND tx_community_domain_model_aclrule.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
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
				'type' => 'inline',
				'foreign_table' => 'fe_users',
				'foreign_class' => 'Tx_Community_Domain_Model_User',
				'maxitems' => 1
			)
		),
		'requested_user' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.requested_user',
			'config'  => array(
				'type' => 'inline',
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
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_community_domain_model_aclrule',
				'foreign_table_where' => 'AND tx_community_domain_model_aclrule.uid=###REC_FIELD_l18n_parent### AND tx_community_domain_model_aclrule.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
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
				'type' => 'input',
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