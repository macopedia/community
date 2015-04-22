<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'ListUsers',
	'Community: List Users'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'UserImage',
	'Community: User image'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'UserDetails',
	'Community: User details'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'InteracionMenu',
	'Community: User menu'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'ListRelations',
	'Community: List relations'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'UnconfirmedRelations',
	'Community: Unconfirmed relations'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'RelationManagement',
	'Community: Relation Management'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Wall',
	'Community: User wall'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'WallForm',
	'Community: User wall form'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'MessageBox',
	'Community: Messages'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'MessageWriteBox',
	'Community: Write Message'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'ThreadedMessageBox',
	'Community: Threaded Messages'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'ThreadedMessageWriteBox',
	'Community: Write Threaded Message'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'SearchResults',
	'Community: Search Results'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'SearchBox',
	'Community: SearchBox'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'EditProfile',
	'Community: Edit Profile'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Gallery',
	'Community: Gallery'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'FlashMessagesDisplayer',
	'Community: FlashMessagesDisplayer'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Community');

// Flexforms
$pluginSignature = str_replace('_','',$_EXTKEY) . '_listusers';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_ListUsers.xml');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_relation','EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_relation.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_relation');
$TCA['tx_community_domain_model_relation'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation',
		'label' 			=> 'initiating_user',
		'label_alt'	    => 'requested_user, status',
		'label_alt_force'   => 1,
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Relation.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_relation.gif'
	)
);

// extend fe_users
$feUserColumns  = array(
	'political_view' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.politicalView',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'religious_view' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.religiousView',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'activities' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.activities',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'interests' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.interests',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'music' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.music',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'movies' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.movies',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'books' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.books',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'quotes' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.quotes',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'about_me' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.aboutMe',
		'config' => array(
			'type' => 'text',
			'cols' => 30,
			'rows' => 5
		)
	),
	'cellphone' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.cellphone',
		'config' => array(
			'type' => 'input',
			'width' => 30
		)
	),
	'gender' => array(
		'exclude' => 0,
		'label'	=> 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('---', ''),
				array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.female', 1),
				array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.male', 0),
			)
		)
	),
	'date_of_birth' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.dateOfBirth',
		'config'  => array(
			'type' => 'input',
			'eval' => 'date'
		)
	),
	'profile_image' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.profileImage',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'file',
			'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'uploadfolder' => 'uploads/tx_community/photos',
			'show_thumbs' => '1',
			'size' => '1',
			'maxitems' => '1',
			'minitems' => '0'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$feUserColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users','gender','', 'after:name');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users','--div--;Community,political_view,religious_view,activities,interests,music,movies,books,quotes,about_me,cellphone,date_of_birth,profile_image;;;;1-1-1');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_message','EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_message.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_message');
$TCA['tx_community_domain_model_message'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message',
		'label' 			=> 'subject',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Message.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_message.gif'
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_wallpost', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_wallpost.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_wallpost');
$TCA['tx_community_domain_model_wallpost'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost',
		'label' 			=> 'subject',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/WallPost.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_wallpost.gif'
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_album', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_album.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_album');
$TCA['tx_community_domain_model_album'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Album.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_album.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_community_domain_model_photo', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_photo.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_community_domain_model_photo');
$TCA['tx_community_domain_model_photo'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo',
		'label' 			=> 'image',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Photo.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_photo.gif'
	),
);

/**
* Add "community" plugin to new content element wizard
* see here for more info http://docs.typo3.org/TYPO3/CoreApiReference/ApiOverview/Examples/ContentElementWizard/Index.html
*/
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['Tx_Community_Resources_Private_Php_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . '/Resources/Private/Php/class.community_wizicon.php';
}

?>