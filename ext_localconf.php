<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'UserImage',
	array(
		'User' => 'image',
	),
	array(
		'User' => 'image',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'UserDetails',
	array(
		'User' => 'details,report',
	),
	array(
		'User' => 'details,report',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'InteracionMenu',
	array(
		'User' => 'interaction',
	),
	array(
		'User' => 'interaction',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ListRelations',
	array(
		'Relation' => 'listSome',
	),
	array(
		'Relation' => 'listSome',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'UnconfirmedRelations',
	array(
		'Relation' => 'unconfirmed',
	),
	array(
		'Relation' => 'unconfirmed',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Wall',
	array(
		'WallPost' => 'list',
	),
	array(
		'WallPost' => 'list',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'WallForm',
	array(
		'WallPost' => 'new,delete,create',
	),
	array(
		'WallPost' => 'new,delete,create',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'MessageBox',
	array(
		'Message' => 'inbox,outbox,unread,read,delete',
	),
	array(
		'Message' => 'inbox,outbox,unread,read,delete',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'MessageWriteBox',
	array(
		'Message' => 'write,send',
	),
	array(
		'Message' => 'write,send',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ThreadedMessageBox',
	array(
		'Message' => 'listThreads,thread,deleteThreaded',
	),
	array(
		'Message' => 'listThreads,thread,deleteThreaded',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ThreadedMessageWriteBox',
	array(
		'Message' => 'writeThreaded,send',
	),
	array(
		'Message' => 'writeThreaded,send',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'SearchBox',
	array(
		'User' => 'searchBox',
	),
	array(
		'User' => 'searchBox',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'SearchResults',
	array(
		'User' => 'search',
	),
	array(
		'User' => 'search',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'EditProfile',
	array(
		'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
	),
	array(
		'User' => 'edit,update,editImage,updateImage,deleteImage,deleteAccount',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RelationManagement',
	array(
		'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
	),
	array(
		'Relation' => 'list,request,cancel,confirm,reject,unconfirmed',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
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

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ListUsers',
	array(
		'User' => 'list',
	),
	array(
		'User' => 'list',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
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

?>
