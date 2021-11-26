<?php

defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message',
        'label' => 'subject',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_message.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sender,recipient,read,sent,read_date,sent_date,subject,message',
    ],
    'types' => [
        '1' => ['showitem' => 'sender,recipient,read,sent,read_date,sent_date,subject,message'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'sender' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sender',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1,
            ],
        ],
        'recipient' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.recipient',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1,
            ],
        ],
        'sent_date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sent_date',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
                'renderType' => 'inputDateTime',
            ],
        ],
        'read_date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.read_date',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
                'renderType' => 'inputDateTime',
            ],
        ],
        'sent' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sent',
            'config' => [
                'type' => 'check',
            ],
        ],
        'tx_community_read' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.read',
            'config' => [
                'type' => 'check',
            ],
        ],
        'subject' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'message' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.message',
            'config' => [
                'type' => 'text',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'sender_deleted' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.sender_deleted',
            'config' => [
                'type' => 'check',
            ],
        ],
        'recipient_deleted' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message.recipient_deleted',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
];
