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
		'User' => 'details',
	),
	array(
		'User' => 'details',
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
		'User' => 'edit,update,editImage,updateImage,deleteImage',
	),
	array(
		'User' => 'edit,update,editImage,updateImage,deleteImage',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RelationManagement',
	array(
		'Relation' => 'list,request,cancel,confirm,reject',
	),
	array(
		'Relation' => 'list,request,cancel,confirm,reject',
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
	'FlashMessagesDisplayer',
	array(
		'Utils' => 'flashMessagesDisplay',
	),
	array(
		'Utils' => 'flashMessagesDisplay',
	)
);

?>