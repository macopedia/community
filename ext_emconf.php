<?php


$EM_CONF[$_EXTKEY] = array(
	'title' => 'Community',
	'description' => 'A flexible community / social network system based on Extbase and Fluid. Friends (buddies), messages, user profile, wall, gallery, notification service, and a lot more.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '2.1.0',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_community,uploads/tx_community/photos',
	'modify_tables' => 'fe_users',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Tymoteusz Motylewski',
	'author_email' => 't.motylewski@gmail.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-7.6.99',
			'extbase' => '',
			'fluid' => '',
			'static_info_tables' => '6.0.0-7.99.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'smilie' => '',
		),
	),
	'suggests' => array(
	)
);
