<?php

declare(strict_types=1);

/**
 * Pages that can be edited with the page builder.
 *
 * Each page default reproduces the page markup the theme shipped with, so a
 * page renders the same until it is changed in Design > Themes > Page builder.
 * Required blocks cannot be removed and are added back when missing.
 */
$block = fn(string $id, string $code, array $settings = []): array => [
    'id' => $id,
    'code' => $code,
    'settings' => $settings,
];

$section = fn(string $id, string $layout, array $columns, array $settings = []): array => [
    'id' => $id,
    'layout' => $layout,
    'settings' => $settings,
    'columns' => array_map(fn(array $blocks): array => ['blocks' => $blocks], $columns),
];

$card = ['wrapper_card' => true];

$accountPage = fn(string $id, array $blocks, string $spacing = 'lg'): array => [
    $section('s_'.$id, 'sidebar-left-2', [
        [$block('b_'.$id.'_nav', 'account-nav')],
        $blocks,
    ], ['spacing' => $spacing]),
];

return [
    'pages' => [
        'home' => [
            'label' => 'igniter.orange::default.home_title',
            'default' => [
                $section('s_home_slider', 'cols-1', [
                    [$block('b_home_slider', 'slider', ['code' => 'home-slider'])],
                ], ['container' => 'full', 'spacing' => 'none']),
                $section('s_home_search', 'center-3', [
                    [],
                    [$block('b_home_search', 'local-search')],
                    [],
                ], ['spacing' => 'lg', 'css_class' => 'border-bottom']),
                $section('s_home_featured', 'cols-1', [
                    [$block('b_home_featured', 'featured-items')],
                ], ['container' => 'full', 'spacing' => 'none']),
            ],
        ],

        'local.menus' => [
            'label' => 'igniter.orange::default.menus_title',
            'required' => ['menu-item-list'],
            'default' => [
                $section('s_menus_header', 'sidebar-right-4', [
                    [
                        $block('b_menus_back', 'back-link', ['page' => 'locations']),
                        $block('b_menus_local', 'local-header'),
                    ],
                    [$block('b_menus_fulfillment', 'fulfillment', ['wrapper_class' => 'local-control p-3 border rounded fw-bold'])],
                ], ['spacing' => 'md', 'css_class' => 'bg-white border-bottom border-1']),
                $section('s_menus_categories', 'cols-1', [
                    [$block('b_menus_categories', 'category-list')],
                ], ['spacing' => 'none', 'css_class' => 'sticky-top bg-white border-bottom border-1']),
                $section('s_menus_items', 'sidebar-right-4', [
                    [$block('b_menus_items', 'menu-item-list')],
                    [$block('b_menus_cart', 'cart-box', ['wrapper_class' => 'd-none d-lg-block'])],
                ], ['spacing' => 'lg']),
            ],
        ],

        'local.reviews' => [
            'label' => 'igniter.orange::default.reviews_title',
            'required' => ['review-list'],
            'default' => [
                $section('s_reviews_header', 'sidebar-right-4', [
                    [
                        $block('b_reviews_back', 'back-link', ['page' => 'local.menus']),
                        $block('b_reviews_local', 'local-header'),
                    ],
                    [],
                ], ['spacing' => 'md', 'css_class' => 'bg-white border-bottom border-1']),
                $section('s_reviews_list', 'sidebar-right-4', [
                    [$block('b_reviews_list', 'review-list')],
                    [$block('b_reviews_cart', 'cart-box', ['wrapper_class' => 'd-none d-lg-block'])],
                ], ['spacing' => 'lg']),
            ],
        ],

        'cart' => [
            'label' => 'igniter.orange::default.cart_title',
            'required' => ['cart-box'],
            'default' => [
                $section('s_cart', 'center-3', [
                    [],
                    [
                        $block('b_cart_back', 'back-link', ['page' => 'local.menus']),
                        $block('b_cart_local', 'local-header', $card),
                        $block('b_cart_box', 'cart-box'),
                    ],
                    [],
                ], ['spacing' => 'lg']),
            ],
        ],

        'checkout.checkout' => [
            'label' => 'igniter.orange::default.checkout_title',
            'required' => ['checkout'],
            'default' => [
                $section('s_checkout', 'cols-1', [
                    [$block('b_checkout', 'checkout')],
                ], ['spacing' => 'none']),
            ],
        ],

        'checkout.success' => [
            'label' => 'igniter.orange::default.checkout_success_title',
            'required' => ['order-preview'],
            'default' => [
                $section('s_checkout_success', 'center-2', [
                    [],
                    [$block('b_checkout_success', 'order-preview')],
                    [],
                ], ['spacing' => 'md']),
            ],
        ],

        'reservation.reservation' => [
            'label' => 'igniter.orange::default.reservation_title',
            'required' => ['booking'],
            'default' => [
                $section('s_reservation', 'cols-1', [
                    [
                        $block('b_reservation_back', 'back-link', ['page' => 'locations']),
                        $block('b_reservation_local', 'local-header', $card),
                        $block('b_reservation_booking', 'booking'),
                    ],
                ], ['spacing' => 'lg']),
            ],
        ],

        'reservation.success' => [
            'label' => 'igniter.orange::default.reservation_success_title',
            'required' => ['reservation-preview'],
            'default' => [
                $section('s_reservation_success', 'cols-1', [
                    [
                        $block('b_reservation_success_local', 'local-header', $card),
                        $block('b_reservation_success', 'reservation-preview'),
                    ],
                ], ['spacing' => 'lg']),
            ],
        ],

        'contact' => [
            'label' => 'igniter.orange::default.contact_title',
            'required' => ['contact'],
            'default' => [
                $section('s_contact', 'center-3', [
                    [],
                    [
                        $block('b_contact_heading', 'heading', ['title' => 'igniter.orange::default.contact.text_contact_us']),
                        $block('b_contact', 'contact'),
                    ],
                    [],
                ], ['spacing' => 'lg']),
            ],
        ],

        'locations' => [
            'label' => 'igniter.orange::default.locations_title',
            'required' => ['location-list'],
            'default' => [
                $section('s_locations', 'cols-1', [
                    [$block('b_locations', 'location-list')],
                ], ['spacing' => 'lg']),
            ],
        ],

        'account.login' => [
            'label' => 'igniter.orange::default.account_login_title',
            'required' => ['login'],
            'default' => [
                $section('s_login', 'cols-3', [
                    [],
                    [
                        $block('b_login', 'login', $card),
                        $block('b_login_socialite', 'socialite', $card),
                    ],
                    [],
                ], ['spacing' => 'lg']),
            ],
        ],

        'account.register' => [
            'label' => 'igniter.orange::default.account_register_title',
            'required' => ['register'],
            'default' => [
                $section('s_register', 'center-3', [
                    [],
                    [$block('b_register', 'register', ['agreeTermsSlug' => 'terms-and-conditions'])],
                    [],
                ], ['spacing' => 'lg']),
            ],
        ],

        'account.reset' => [
            'label' => 'igniter.orange::default.account_reset_title',
            'required' => ['reset-password'],
            'default' => [
                $section('s_reset', 'center-3', [
                    [],
                    [
                        $block('b_reset_heading', 'heading', ['title' => 'igniter.orange::default.account_reset_title', 'level' => 'h1']),
                        $block('b_reset', 'reset-password', $card),
                    ],
                    [],
                ], ['spacing' => 'lg']),
            ],
        ],

        'account.account' => [
            'label' => 'igniter.orange::default.account_title',
            'required' => ['account-dashboard'],
            'default' => $accountPage('account', [
                $block('b_account_dashboard', 'account-dashboard'),
                $block('b_account_settings', 'account-settings'),
            ]),
        ],

        'account.address' => [
            'label' => 'igniter.orange::default.account_address_title',
            'required' => ['address-book'],
            'default' => $accountPage('address', [
                $block('b_address_book', 'address-book'),
            ]),
        ],

        'account.orders' => [
            'label' => 'igniter.orange::default.account_orders_title',
            'required' => ['order-list'],
            'default' => $accountPage('orders', [
                $block('b_orders_list', 'order-list', $card),
            ]),
        ],

        'account.order' => [
            'label' => 'igniter.orange::default.account_order_title',
            'required' => ['order-preview'],
            'default' => $accountPage('order', [
                $block('b_order_preview', 'order-preview', ['hideReorderBtn' => false]),
            ], 'md'),
        ],

        'account.reservations' => [
            'label' => 'igniter.orange::default.account_reservations_title',
            'required' => ['reservation-list'],
            'default' => $accountPage('reservations', [
                $block('b_reservations_list', 'reservation-list', $card),
            ]),
        ],

        'account.reservation' => [
            'label' => 'igniter.orange::default.account_reservation_title',
            'required' => ['reservation-preview'],
            'default' => $accountPage('reservation', [
                $block('b_reservation_local', 'local-header', $card),
                $block('b_reservation_preview', 'reservation-preview'),
                $block('b_reservation_review', 'leave-review', ['type' => 'reservation']),
            ]),
        ],
    ],
];
