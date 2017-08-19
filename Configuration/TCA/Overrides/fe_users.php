<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

// extend fe_users
$feUserColumns = array(
    'political_view' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.politicalView',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'religious_view' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.religiousView',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'activities' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.activities',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'interests' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.interests',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'music' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.music',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'movies' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.movies',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'books' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.books',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'quotes' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.quotes',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'about_me' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.aboutMe',
        'config' => array(
            'type' => 'text',
            'cols' => 30,
            'rows' => 5
        )
    ),
    'cellphone' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.cellphone',
        'config' => array(
            'type' => 'input',
            'width' => 30
        )
    ),
    'gender' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender',
        'config' => array(
            'type' => 'radio',
            'items' => [
                [
                    'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.0',
                    '0'
                ],
                [
                    'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.1',
                    '1'
                ]
            ],
        )
    ),

    'date_of_birth' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.dateOfBirth',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
            'default' => 0,
        ]
    ),
    'profile_image' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.profileImage',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'file',
            'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
            'uploadfolder' => 'uploads/tx_community/photos',
            'show_thumbs' => '1',
            'size' => '1',
            'maxitems' => '1',
            'minitems' => '0'
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUserColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users', 'gender', '', 'after:name');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users', '--div--;Community,political_view,religious_view,activities,interests,music,movies,books,quotes,about_me,cellphone,date_of_birth,profile_image;;;;1-1-1');
