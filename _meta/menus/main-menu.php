<?php

return [
    'name' => 'Main menu',
    'items' => [
        [
            'title' => 'main::lang.menu_menu',
            'code' => 'view-menu',
            'type' => 'theme-page',
            'reference' => 'local'.DIRECTORY_SEPARATOR.'menus',
        ],
        [
            'title' => 'main::lang.menu_reservation',
            'code' => 'reservation',
            'type' => 'theme-page',
            'reference' => 'reservation'.DIRECTORY_SEPARATOR.'reservation',
        ],
        [
            'title' => 'main::lang.menu_login',
            'code' => 'login',
            'type' => 'theme-page',
            'reference' => 'account'.DIRECTORY_SEPARATOR.'login',
        ],
        [
            'title' => 'main::lang.menu_register',
            'code' => 'register',
            'type' => 'theme-page',
            'reference' => 'account'.DIRECTORY_SEPARATOR.'register',
        ],
        [
            'title' => 'main::lang.menu_my_account',
            'code' => 'account',
            'type' => 'theme-page',
            'reference' => 'account'.DIRECTORY_SEPARATOR.'account',
            'items' => [
                [
                    'title' => 'main::lang.menu_recent_order',
                    'code' => 'recent-orders',
                    'type' => 'theme-page',
                    'reference' => 'account'.DIRECTORY_SEPARATOR.'orders',
                ],
                [
                    'title' => 'main::lang.menu_my_account',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account'.DIRECTORY_SEPARATOR.'account',
                ],
                [
                    'title' => 'main::lang.menu_address',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account'.DIRECTORY_SEPARATOR.'address',
                ],
                [
                    'title' => 'main::lang.menu_recent_reservation',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account'.DIRECTORY_SEPARATOR.'reservations',
                ],
                [
                    'title' => 'main::lang.menu_logout',
                    'code' => '',
                    'type' => 'url',
                    'url' => 'javascript:;',
                    'extraAttributes' => 'data-request="session::onLogout"',
                ],
            ],
        ],
    ],
];
