<?php
defined('TYPO3_MODE') or die();


return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost',
        'label' => 'subject',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'iconfile' => 'EXT:community/Resources/Public/Icons/tx_community_domain_model_wallpost.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sender,recipient,subject,message',
    ),
    'types' => array(
        '1' => array('showitem' => 'sender,recipient,subject,message'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            )
        ),
        'sender' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.sender',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1
            ),
        ),
        'recipient' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.recipient',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_class' => 'Tx_Community_Domain_Model_User',
                'maxitems' => 1
            ),
        ),
        'subject' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.subject',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'message' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost.message',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ),
        ),
    ),
);
?>