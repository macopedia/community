<?php

########################################################################
# Extension Manager/Repository config file for ext "community".
#
# Auto generated 20-05-2012 01:00
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Community',
	'description' => 'A flexible community / social network system based on Extbase and Fluid. Friends (buddies), messages, user profile, wall, gallery, notification service, and a lot more.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.7.1',
	'dependencies' => 'extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'TYPO3_version' => '4.5.0-0.0.0',
	'PHP_version' => '5.2.0-0.0.0',
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
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'smilie' => ''
		),
	),
);

?>