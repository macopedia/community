<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UserImage',
    array(
        'User' => 'image',
    ),
    array(
        'User' => 'image',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UserDetails',
    array(
        'User' => 'details,report',
    ),
    array(
        'User' => 'details,report',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'InteracionMenu',
    array(
        'User' => 'interaction',
    ),
    array(
        'User' => 'interaction',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ListRelations',
    array(
        'Relation' => 'listSome',
    ),
    array(
        'Relation' => 'listSome',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UnconfirmedRelations',
    array(
        'Relation' => 'unconfirmed',
    ),
    array(
        'Relation' => 'unconfirmed',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'Wall',
    array(
        'WallPost' => 'list',
    ),
    array(
        'WallPost' => 'list',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'WallForm',
    array(
        'WallPost' => 'new,delete,create',
    ),
    array(
        'WallPost' => 'new,delete,create',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'MessageBox',
    array(
        'Message' => 'inbox,outbox,unread,read,delete',
    ),
    array(
        'Message' => 'inbox,outbox,unread,read,delete',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'MessageWriteBox',
    array(
        'Message' => 'write,send',
    ),
    array(
        'Message' => 'write,send',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ThreadedMessageBox',
    array(
        'Message' => 'listThreads,thread,deleteThreaded',
    ),
    array(
        'Message' => 'listThreads,thread,deleteThreaded',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ThreadedMessageWriteBox',
    array(
        'Message' => 'writeThreaded,send',
    ),
    array(
        'Message' => 'writeThreaded,send',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'SearchBox',
    array(
        'User' => 'searchBox',
    ),
    array(
        'User' => 'searchBox',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'SearchResults',
    array(
        'User' => 'search',
    ),
    array(
        'User' => 'search',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'EditProfile',
    array(
        'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
    ),
    array(
        'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'RelationManagement',
    array(
        'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
    ),
    array(
        'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'Gallery',
    array(
        'Album' => 'list,show,new,create,edit,update,delete,showMostRecent',
        'Photo' => 'new,create,delete,avatar,mainPhoto',
    ),
    array(
        'Album' => 'list,show,new,create,edit,update,delete,showMostRecent',
        'Photo' => 'new,create,delete,avatar,mainPhoto',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ListUsers',
    array(
        'User' => 'list',
    ),
    array(
        'User' => 'list',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'FlashMessagesDisplayer',
    array(
        'Utils' => 'flashMessagesDisplay',
    ),
    array(
        'Utils' => 'flashMessagesDisplay',
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:community/Classes/Hook/Tcemain.php:&Tx_Community_Hook_Tcemain';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:community/Classes/Hook/Tcemain.php:&Tx_Community_Hook_Tcemain';
