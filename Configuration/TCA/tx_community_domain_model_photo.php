<?php

defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo',
        'label' => 'image',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_photo.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, image',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden,--palette--;;1,image,album'],
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
        'image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', ['uploadfolder' => 'uploads/tx_community/photos'], 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai'),
        ],
        'album' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.album',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_community_domain_model_album',
                'maxitems' => 1,
            ],
        ],
    ],
];
