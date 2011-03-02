<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'User' => 'image',
	),
	array(
		'User' => 'image',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi2',
	array(
		'User' => 'details',
	),
	array(
		'User' => 'details',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi3',
	array(
		'User' => 'interaction',
	),
	array(
		'User' => 'interaction',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi4',
	array(
		'Relation' => 'listSome',
	),
	array(
		'Relation' => 'listSome',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi5',
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
	'Pi10',
	array(
		'Relation' => 'list,request,cancel,confirm,reject',
		'User' => 'search,edit,update,editImage,updateImage',
		'Message' => 'inbox,outbox,unread,write,send,read,delete',
	),
	array(
		'Relation' => 'list,request,cancel,confirm,reject',
		'Message' => 'inbox,outbox,unread,write,send,read,delete',
		'User' => 'search,edit,update,editImage,updateImage',
	)
);



?>