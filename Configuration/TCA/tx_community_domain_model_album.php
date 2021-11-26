<?php

defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_album.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, name, private, photos',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden,--palette--;;1,name,user,private,photos'],
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
        'name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'private' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.private',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.public', 0],
                    ['LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.loggedInOnly', 1],
                    ['LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.friendsOnly', 2],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required',
            ],
        ],
        'album_type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.type',
            'config' => [
                'type' => 'none',
            ],
        ],
        'main_photo' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.main_photo',
            'config' => [
                'type' => 'none',
            ],
        ],
        'photos' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.photos',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_community_domain_model_photo',
                'foreign_field' => 'album',
                'maxitems' => 9999,
                'appearance' => [
                    'collapse' => 0,
                    'levelLinksPosition' => 'both',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                ],
            ],
        ],
        'user' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
    ],
];
