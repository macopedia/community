<?php


$EM_CONF[$_EXTKEY] = array(
    'title' => 'Community',
    'description' => 'A flexible community / social network system based on Extbase and Fluid. Friends (buddies), messages, user profile, wall, gallery, notification service, and a lot more.',
    'category' => 'plugin',
    'version' => '4.0.0',
    'dependencies' => 'cms,extbase,fluid',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => 'uploads/tx_community,uploads/tx_community/photos',
    'modify_tables' => 'fe_users',
    'clearcacheonload' => 0,
    'author' => 'Tymoteusz Motylewski',
    'author_email' => 't.motylewski@gmail.com',
    'author_company' => 'Macopedia.pl',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.7.0-8.7.99',
            'extbase' => '',
            'fluid' => '',
            'static_info_tables' => '6.0.0-7.99.99',
        ),
        'conflicts' => array(),
        'suggests' => array(
            'smilie' => '',
        ),
    ),
    'suggests' => array()
);
