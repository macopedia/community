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
	'Pi10',
	array(
		'Relation' => 'request,cancel,confirm,reject',
		'User' => 'search,edit,update,editImage,updateImage',
		'Message' => 'inbox,outbox,unread,write,send,read,delete',
	),
	array(
		'Relation' => 'request,cancel,confirm,reject',
		'Message' => 'inbox,outbox,unread,write,send,read,delete',
		'User' => 'search,edit,update,editImage,updateImage',
	)
);


if (t3lib_extMgm::isLoaded('comments')) {
   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['customFunctionCode'][$_EXTKEY] = 'EXT:community/Classes/Service/CommentService.php:&tx_Community_Service_CommentService->customFunctionCode';
   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['comments_getComments'][$_EXTKEY] = 'EXT:community/Classes/Service/CommentService.php:&tx_Community_Service_CommentService->comments_getComments';
   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['processSubmission'][$_EXTKEY] = 'EXT:community/Classes/Service/CommentService.php:&tx_Community_Service_CommentService->processSubmission';
}
?>