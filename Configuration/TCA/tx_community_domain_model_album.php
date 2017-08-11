<?php
defined('TYPO3_MODE') or die();

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_album.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'hidden, name, private, photos',
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden;;1, name, user, private, photos'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'private' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.private',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.public', 0),
                    array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.loggedInOnly', 1),
                    array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.album.friendsOnly', 2),
                ),
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required'
            ),
        ),
        'album_type' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.type',
            'config' => array(
                'type' => 'none'
            ),
        ),
        'main_photo' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.main_photo',
            'config' => array(
                'type' => 'none'
            ),
        ),
        'photos' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.photos',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_community_domain_model_photo',
                'foreign_field' => 'album',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapse' => 0,
                    'levelLinksPosition' => 'both',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'user' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album.user',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1
            ),
        ),
    ),
);
