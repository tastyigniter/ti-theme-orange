<?php
return [
    'name' => 'Footer menu',
    'items' => [
        [
            'title' => 'TastyIgniter',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'main::lang.menu_menu',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'local/menus',
                ],
                [
                    'title' => 'main::lang.menu_reservation',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'reservation/reservation',
                ],
                [
                    'title' => 'main::lang.menu_locations',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'locations',
                ],
            ],
        ],
        [
            'title' => 'main::lang.text_information',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'main::lang.menu_contact',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'contact',
                ],
                [
                    'title' => 'main::lang.menu_admin',
                    'code' => '',
                    'type' => 'url',
                    'url' => admin_url(),
                ],
                [
                    'title' => 'About Us',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'about-us',
                ],
                [
                    'title' => 'Privacy Policy',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'policy',
                ],
            ],
        ],
    ],
];