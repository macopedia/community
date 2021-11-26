<?php
defined('TYPO3_MODE') or die();


return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo',
        'label' => 'image',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_photo.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'hidden, image',
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden,--palette--;;1,image,album'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'image' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', ['uploadfolder' => 'uploads/tx_community/photos'], 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai'),
        ),
        'album' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.album',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_community_domain_model_album',
                'maxitems' => 1
            ),
        ),
    ),
);
