<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// extend fe_users
$feUserColumns = [
    'political_view' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.politicalView',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'religious_view' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.religiousView',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'activities' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.activities',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'interests' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.interests',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'music' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.music',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'movies' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.movies',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'books' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.books',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'quotes' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.quotes',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'about_me' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.aboutMe',
        'config' => [
            'type' => 'text',
            'cols' => 30,
            'rows' => 5,
        ],
    ],
    'cellphone' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.cellphone',
        'config' => [
            'type' => 'input',
            'width' => 30,
        ],
    ],
    'gender' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender',
        'config' => [
            'type' => 'radio',
            'items' => [
                [
                    'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.0',
                    '0',
                ],
                [
                    'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.1',
                    '1',
                ],
            ],
        ],
    ],

    'date_of_birth' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.dateOfBirth',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
            'default' => 0,
        ],
    ],
    'profile_image' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.profileImage',
        'config' => [
            'type' => 'group',
            'internal_type' => 'file',
            'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
            'uploadfolder' => 'uploads/tx_community/photos',
            'show_thumbs' => '1',
            'size' => '1',
            'maxitems' => '1',
            'minitems' => '0',
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUserColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users', 'gender', '', 'after:name');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users', '--div--;Community,political_view,religious_view,activities,interests,music,movies,books,quotes,about_me,cellphone,date_of_birth,profile_image;;;;1-1-1');
