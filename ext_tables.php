<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'UserImage',
	'Community: User image'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'UserDetails',
	'Community: User details'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'InteracionMenu',
	'Community: User menu'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ListRelations',
	'Community: List relations'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'UnconfirmedRelations',
	'Community: Unconfirmed relations'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RelationManagement',
	'Community: Relation Management'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Wall',
	'Community: User wall'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'WallForm',
	'Community: User wall form'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'MessageBox',
	'Community: Messages'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'MessageWriteBox',
	'Community: Write Message'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SearchResults',
	'Community: Search Results'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SearchBox',
	'Community: SearchBox'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'EditProfile',
	'Community: Edit Profile'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Gallery',
	'Community: Gallery'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'FlashMessagesDisplayer',
	'Community: FlashMessagesDisplayer'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Community');



t3lib_extMgm::addLLrefForTCAdescr('tx_community_domain_model_relation','EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_relation.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_community_domain_model_relation');
$TCA['tx_community_domain_model_relation'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_relation',
		'label' 			=> 'initiating_user',
		'label_alt'	    => 'requested_user, status',
		'label_alt_force'   => 1,
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_relation.gif'
	)
);

// flexform to select the action
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$plugins = array('_interacionmenu','_relationmanagement');

foreach ($plugins as $plugin) {
	$pluginSignature = strtolower($extensionName) . $plugin;
	$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
	t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForm/Actions.xml');
}

// extend fe_users
t3lib_div::loadTCA('fe_users');
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
				array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.female', 'female'),
				array('LLL:EXT:community/Resources/Private/Language/locallang.xml:profile.details.gender.male', 'male'),
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
			'uploadfolder' => 'uploads/pics',
			'show_thumbs' => '1',
			'size' => '1',
			'maxitems' => '1',
			'minitems' => '0'
		)
	),
);


t3lib_extMgm::addTCAcolumns('fe_users',$feUserColumns, 1);

t3lib_extMgm::addToAllTCATypes('fe_users','gender','', 'after:name');
t3lib_extMgm::addToAllTCATypes('fe_users','--div--;Community,political_view,religious_view,activities,interests,music,movies,books,quotes,about_me,cellphone,date_of_birth,profile_image;;;;1-1-1');



t3lib_extMgm::addLLrefForTCAdescr('tx_community_domain_model_message','EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_message.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_community_domain_model_message');
$TCA['tx_community_domain_model_message'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_message',
		'label' 			=> 'subject',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_message.gif'
	)
);




t3lib_extMgm::addLLrefForTCAdescr('tx_community_domain_model_wallpost', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_wallpost.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_community_domain_model_wallpost');
$TCA['tx_community_domain_model_wallpost'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_wallpost',
		'label' 			=> 'subject',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/WallPost.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_wallpost.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_community_domain_model_album', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_album.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_community_domain_model_album');
$TCA['tx_community_domain_model_album'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_album',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Album.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_album.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_community_domain_model_photo', 'EXT:community/Resources/Private/Language/locallang_csh_tx_community_domain_model_photo.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_community_domain_model_photo');
$TCA['tx_community_domain_model_photo'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo',
		'label' 			=> 'image',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Photo.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_community_domain_model_photo.gif'
	),
);

?>