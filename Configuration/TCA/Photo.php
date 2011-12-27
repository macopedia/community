<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_community_domain_model_photo'] = array(
	'ctrl' => $TCA['tx_community_domain_model_photo']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, image',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, image, album'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.image',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_community/photos',
				'show_thumbs' => 1,
				'size' => 5,
				'allowed' => 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai',
				'disallowed' => '',
			),
		),
		'album' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:community/Resources/Private/Language/locallang_db.xml:tx_community_domain_model_photo.album',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_community_domain_model_album',
				'maxitems'      => 1
			),
		),
	),
);
?>