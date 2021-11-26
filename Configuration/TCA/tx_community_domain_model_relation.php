<?php

defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation',
        'label' => 'initiating_user',
        'label_alt' => 'requested_user, status',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_relation.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'initiating_user,requested_user,initiation_time,status',
    ],
    'types' => [
        '1' => ['showitem' => 'initiating_user,requested_user,initiation_time,status'],
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
        'initiating_user' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.initiating_user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1,
            ],
        ],
        'requested_user' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.requested_user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1,
            ],
        ],
        'initiation_time' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.initiation_time',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
                'renderType' => 'inputDateTime',
            ],
        ],
        'status' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.1', 1],
                    ['LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.2', 2],
                    ['LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.4', 4],
                    ['LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation.status.8', 8],
                ],
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 1,
            ],
        ],
    ],
];
