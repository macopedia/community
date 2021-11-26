<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UserImage',
    [
        'User' => 'image',
    ],
    [
        'User' => 'image',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UserDetails',
    [
        'User' => 'details,report',
    ],
    [
        'User' => 'details,report',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'InteracionMenu',
    [
        'User' => 'interaction',
    ],
    [
        'User' => 'interaction',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ListRelations',
    [
        'Relation' => 'listSome',
    ],
    [
        'Relation' => 'listSome',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'UnconfirmedRelations',
    [
        'Relation' => 'unconfirmed',
    ],
    [
        'Relation' => 'unconfirmed',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'Wall',
    [
        'WallPost' => 'list',
    ],
    [
        'WallPost' => 'list',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'WallForm',
    [
        'WallPost' => 'new,delete,create',
    ],
    [
        'WallPost' => 'new,delete,create',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'MessageBox',
    [
        'Message' => 'inbox,outbox,unread,read,delete',
    ],
    [
        'Message' => 'inbox,outbox,unread,read,delete',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'MessageWriteBox',
    [
        'Message' => 'write,send',
    ],
    [
        'Message' => 'write,send',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ThreadedMessageBox',
    [
        'Message' => 'listThreads,thread,deleteThreaded',
    ],
    [
        'Message' => 'listThreads,thread,deleteThreaded',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ThreadedMessageWriteBox',
    [
        'Message' => 'writeThreaded,send',
    ],
    [
        'Message' => 'writeThreaded,send',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'SearchBox',
    [
        'User' => 'searchBox',
    ],
    [
        'User' => 'searchBox',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'SearchResults',
    [
        'User' => 'search',
    ],
    [
        'User' => 'search',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'EditProfile',
    [
        'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
    ],
    [
        'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'RelationManagement',
    [
        'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
    ],
    [
        'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'Gallery',
    [
        'Album' => 'list,show,new,create,edit,update,delete,showMostRecent',
        'Photo' => 'new,create,delete,avatar,mainPhoto',
    ],
    [
        'Album' => 'list,show,new,create,edit,update,delete,showMostRecent',
        'Photo' => 'new,create,delete,avatar,mainPhoto',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'ListUsers',
    [
        'User' => 'list',
    ],
    [
        'User' => 'list',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Macopedia.' . 'community',
    'FlashMessagesDisplayer',
    [
        'Utils' => 'flashMessagesDisplay',
    ],
    [
        'Utils' => 'flashMessagesDisplay',
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:community/Classes/Hook/Tcemain.php:&Tx_Community_Hook_Tcemain';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:community/Classes/Hook/Tcemain.php:&Tx_Community_Hook_Tcemain';
