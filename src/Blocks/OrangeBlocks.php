<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Igniter\Main\Classes\BaseBlock;

/**
 * Page builder blocks provided by the Orange theme.
 *
 * Content blocks render the theme `_builder/blocks/{code}` views. Component
 * blocks wrap the theme Livewire and Blade components, their settings come
 * from each component's defineProperties().
 */
class OrangeBlocks
{
    /**
     * @return list<BaseBlock|class-string<BaseBlock>>
     */
    public static function definitions(): array
    {
        return array_merge(self::contentBlocks(), self::componentBlocks());
    }

    /**
     * @return list<class-string<BaseBlock>>
     */
    public static function contentBlocks(): array
    {
        return [
            Heading::class,
            RichText::class,
            Image::class,
            ImageText::class,
            CallToAction::class,
            Html::class,
            Spacer::class,
            BackLink::class,
            AccountNav::class,
        ];
    }

    /**
     * @return list<OrangeComponentBlock>
     */
    public static function componentBlocks(): array
    {
        $blocks = [];
        foreach (self::componentDetails() as $componentCode => $details) {
            $blocks[] = $componentCode === 'igniter-orange::fulfillment'
                ? FulfillmentBlock::make($componentCode, $details)
                : OrangeComponentBlock::make($componentCode, $details);
        }

        return $blocks;
    }

    /**
     * Block details for each component, keyed by component code. Functional
     * components are limited to the pages they work on.
     */
    public static function componentDetails(): array
    {
        return [
            // Content
            'igniter-orange::slider' => ['icon' => 'fa fa-images'],
            'igniter-orange::banner-preview' => ['icon' => 'fa fa-rectangle-ad'],
            'igniter-orange::featured-items' => ['icon' => 'fa fa-star'],
            'igniter-orange::local-search' => ['icon' => 'fa fa-magnifying-glass-location', 'unique' => true],
            'igniter-orange::newsletter-subscribe-form' => ['icon' => 'fa fa-envelope'],

            // Ordering
            'igniter-orange::local-header' => [
                'icon' => 'fa fa-store',
                'unique' => true,
                'pages' => [
                    'local.menus', 'local.reviews', 'cart', 'checkout.checkout',
                    'reservation.reservation', 'reservation.success', 'account.reservation',
                ],
            ],
            // The checkout form shows the fulfillment and the checkout page renders its modal
            'igniter-orange::fulfillment' => [
                'icon' => 'fa fa-truck',
                'unique' => true,
                'pages' => ['local.menus', 'local.reviews', 'cart'],
            ],
            'igniter-orange::category-list' => [
                'icon' => 'fa fa-list',
                'unique' => true,
                'pages' => ['local.menus'],
            ],
            'igniter-orange::menu-item-list' => [
                'icon' => 'fa fa-utensils',
                'unique' => true,
                'wide' => true,
                'pages' => ['local.menus'],
            ],
            'igniter-orange::cart-box' => [
                'icon' => 'fa fa-basket-shopping',
                'unique' => true,
                'pages' => ['local.menus', 'local.reviews', 'cart', 'checkout.checkout'],
            ],
            'igniter-orange::cart-preview' => [
                'icon' => 'fa fa-receipt',
                'unique' => true,
                'pages' => ['cart', 'checkout.checkout'],
            ],
            'igniter-orange::review-list' => [
                'icon' => 'fa fa-comments',
                'unique' => true,
                'pages' => ['local.reviews'],
            ],
            'igniter-orange::checkout' => [
                'icon' => 'fa fa-cash-register',
                'unique' => true,
                'wide' => true,
                'pages' => ['checkout.checkout'],
            ],
            'igniter-orange::order-preview' => [
                'icon' => 'fa fa-file-invoice',
                'unique' => true,
                'wide' => true,
                'pages' => ['checkout.success', 'account.order'],
            ],
            'igniter-orange::leave-review' => [
                'icon' => 'fa fa-star-half-stroke',
                'unique' => true,
                'pages' => ['checkout.success', 'reservation.success', 'account.order', 'account.reservation'],
            ],

            // Reservations
            'igniter-orange::booking' => [
                'icon' => 'fa fa-calendar-check',
                'unique' => true,
                'wide' => true,
                'pages' => ['reservation.reservation'],
            ],
            'igniter-orange::reservation-preview' => [
                'icon' => 'fa fa-calendar-day',
                'unique' => true,
                'wide' => true,
                'pages' => ['reservation.success', 'account.reservation'],
            ],

            // Locations and contact
            'igniter-orange::location-list' => [
                'icon' => 'fa fa-location-dot',
                'unique' => true,
                'wide' => true,
                'pages' => ['locations'],
            ],
            'igniter-orange::contact' => [
                'icon' => 'fa fa-address-card',
                'unique' => true,
                'pages' => ['contact'],
            ],

            // Account
            'igniter-orange::login' => ['icon' => 'fa fa-right-to-bracket', 'unique' => true, 'pages' => ['account.login']],
            'igniter-orange::register' => ['icon' => 'fa fa-user-plus', 'unique' => true, 'pages' => ['account.register']],
            'igniter-orange::reset-password' => ['icon' => 'fa fa-key', 'unique' => true, 'pages' => ['account.reset']],
            'igniter-orange::socialite' => [
                'icon' => 'fa fa-share-nodes',
                'unique' => true,
                'pages' => ['account.login', 'account.register'],
            ],
            'igniter-orange::account-dashboard' => [
                'icon' => 'fa fa-gauge',
                'unique' => true,
                'pages' => ['account.account'],
            ],
            'igniter-orange::account-settings' => [
                'icon' => 'fa fa-user-gear',
                'unique' => true,
                'pages' => ['account.account'],
            ],
            'igniter-orange::address-book' => [
                'icon' => 'fa fa-address-book',
                'unique' => true,
                'wide' => true,
                'pages' => ['account.address'],
            ],
            'igniter-orange::order-list' => [
                'icon' => 'fa fa-bag-shopping',
                'unique' => true,
                'wide' => true,
                'pages' => ['account.orders'],
            ],
            'igniter-orange::reservation-list' => [
                'icon' => 'fa fa-calendar',
                'unique' => true,
                'wide' => true,
                'pages' => ['account.reservations'],
            ],
        ];
    }
}
