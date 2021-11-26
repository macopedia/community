<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'ListUsers',
    'Community: List Users'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'UserImage',
    'Community: User image'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'UserDetails',
    'Community: User details'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'InteracionMenu',
    'Community: User menu'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'ListRelations',
    'Community: List relations'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'UnconfirmedRelations',
    'Community: Unconfirmed relations'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'RelationManagement',
    'Community: Relation Management'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'Wall',
    'Community: User wall'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'WallForm',
    'Community: User wall form'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'MessageBox',
    'Community: Messages'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'MessageWriteBox',
    'Community: Write Message'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'ThreadedMessageBox',
    'Community: Threaded Messages'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'ThreadedMessageWriteBox',
    'Community: Write Threaded Message'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'SearchResults',
    'Community: Search Results'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'SearchBox',
    'Community: SearchBox'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'EditProfile',
    'Community: Edit Profile'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'Gallery',
    'Community: Gallery'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'community',
    'FlashMessagesDisplayer',
    'Community: FlashMessagesDisplayer'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('community', 'Configuration/TypoScript', 'Community');

// Flexforms
$pluginSignature = str_replace('_', '', 'community') . '_listusers';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:community/Configuration/FlexForms/flexform_ListUsers.xml');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_relation', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_relation.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_relation');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_message', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_message.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_message');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_wallpost', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_wallpost.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_wallpost');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_album', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_album.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_album');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_photo', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_photo.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_photo');


/**
 * Add "community" plugin to new content element wizard
 * see here for more info http://docs.typo3.org/TYPO3/CoreApiReference/ApiOverview/Examples/ContentElementWizard/Index.html
 */
if (TYPO3_MODE == 'BE') {
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['Tx_Community_Resources_Private_Php_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('community') . '/Resources/Private/Php/class.community_wizicon.php';
}
