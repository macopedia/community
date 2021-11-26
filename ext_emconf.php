<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Community',
    'description' => 'A flexible community / social network system based on Extbase and Fluid. Friends (buddies), messages, user profile, wall, gallery, notification service, and a lot more.',
    'category' => 'plugin',
    'version' => '4.0.0',
    'state' => 'stable',
    'uploadfolder' => true,
    'createDirs' => 'uploads/tx_community,uploads/tx_community/photos',
    'author' => 'Tymoteusz Motylewski',
    'author_email' => 't.motylewski@gmail.com',
    'author_company' => 'Macopedia.pl',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'extbase' => '',
            'fluid' => '',
            'static_info_tables' => '6.0.0-7.99.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'smilie' => '',
        ],
    ],
];
