<?php

namespace Igniter\Orange;

use Igniter\Flame\Igniter;
use Igniter\System\Classes\ComponentManager;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        resolve(ComponentManager::class)->registerComponents(function (ComponentManager $manager) {
            foreach ($this->registerComponents() as $component => $definition) {
                $manager->registerComponent($component, $definition);
            }
        });
    }

    public function boot()
    {
        Igniter::loadResourcesFrom(__DIR__.'/../resources', 'igniter.orange');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'igniter.orange');
    }

    protected function registerComponents()
    {
        return [
            Components\Menu::class => [
                'code' => 'localMenu',
                'name' => 'lang:igniter.orange::default.menu_component_title',
                'description' => 'lang:igniter.orange::default.menu_component_desc',
            ],
            Components\Categories::class => [
                'code' => 'categories',
                'name' => 'lang:igniter.orange::default.categories_component_title',
                'description' => 'lang:igniter.orange::default.categories_component_desc',
            ],
            Components\CartBox::class => [
                'code' => 'cartBox',
                'name' => 'lang:igniter.orange::default.text_component_title',
                'description' => 'lang:igniter.orange::default.text_component_desc',
            ],
            Components\Checkout::class => [
                'code' => 'checkout',
                'name' => 'lang:igniter.orange::default.text_checkout_component_title',
                'description' => 'lang:igniter.orange::default.text_checkout_component_desc',
            ],
            Components\Orders::class => [
                'code' => 'accountOrders',
                'name' => 'lang:igniter.orange::default.orders_component_title',
                'description' => 'lang:igniter.orange::default.orders_component_desc',
            ],
            Components\Order::class => [
                'code' => 'orderPage',
                'name' => 'lang:igniter.orange::default.order_component_title',
                'description' => 'lang:igniter.orange::default.order_component_desc',
            ],

            Components\Banners::class => [
                'code' => 'banners',
                'name' => 'lang:igniter.orange::default.banners_component_title',
                'description' => 'lang:igniter.orange::default.banners_component_desc',
            ],
            Components\Contact::class => [
                'code' => 'contact',
                'name' => 'lang:igniter.orange::default.contact_component_title',
                'description' => 'lang:igniter.orange::default.contact_component_desc',
            ],
            Components\Slider::class => [
                'code' => 'slider',
                'name' => 'lang:igniter.orange::default.slider_component_title',
                'description' => 'lang:igniter.orange::default.slider_component_desc',
            ],
            Components\Newsletter::class => [
                'code' => 'newsletter',
                'name' => 'lang:igniter.orange::default.newsletter_component_title',
                'description' => 'lang:igniter.orange::default.newsletter_component_desc',
            ],
            Components\FeaturedItems::class => [
                'code' => 'featuredItems',
                'name' => 'lang:igniter.orange::default.featured_component_title',
                'description' => 'lang:igniter.orange::default.featured_component_desc',
            ],
            Components\Captcha::class => [
                'code' => 'captcha',
                'name' => 'lang:igniter.orange::default.captcha_component_title',
                'description' => 'lang:igniter.orange::default.captcha_component_desc',
            ],

            Components\LocalBox::class => [
                'code' => 'localBox',
                'name' => 'lang:igniter.orange::local_component_title',
                'description' => 'lang:igniter.orange::local_component_desc',
            ],
            Components\Search::class => [
                'code' => 'localSearch',
                'name' => 'lang:igniter.orange::default.search_component_title',
                'description' => 'lang:igniter.orange::default.search_component_desc',
            ],
            Components\Review::class => [
                'code' => 'localReview',
                'name' => 'lang:igniter.orange::default.review_component_title',
                'description' => 'lang:igniter.orange::default.review_component_desc',
            ],
            Components\Info::class => [
                'code' => 'localInfo',
                'name' => 'lang:igniter.orange::default.info_component_title',
                'description' => 'lang:igniter.orange::default.info_component_desc',
            ],
            Components\Gallery::class => [
                'code' => 'localGallery',
                'name' => 'lang:igniter.orange::default.gallery_component_title',
                'description' => 'lang:igniter.orange::default.gallery_component_desc',
            ],
            Components\LocalList::class => [
                'code' => 'localList',
                'name' => 'lang:igniter.orange::default.list_component_title',
                'description' => 'lang:igniter.orange::default.list_component_desc',
            ],

            Components\Booking::class => [
                'code' => 'booking',
                'name' => 'lang:igniter.orange::default.booking_component_title',
                'description' => 'lang:igniter.orange::default.booking_component_desc',
            ],
            Components\Reservations::class => [
                'code' => 'accountReservations',
                'name' => 'lang:igniter.orange::default.reservations_component_title',
                'description' => 'lang:igniter.orange::default.reservations_component_desc',
            ],

            Components\StaticPage::class => [
                'code' => 'staticPage',
                'name' => 'lang:igniter.orange::default.static_page_component_title',
                'description' => 'lang:igniter.orange::default.static_page_component_desc',
            ],
            Components\StaticMenu::class => [
                'code' => 'staticMenu',
                'name' => 'lang:igniter.orange::default.static_menu_component_title',
                'description' => 'lang:igniter.orange::default.static_menu_component_desc',
            ],

            Components\Socialite::class => [
                'code' => 'socialite',
                'name' => 'Socialite component',
                'description' => 'Displays the social networks login buttons',
            ],
            Components\LocalePicker::class => [
                'code' => 'localePicker',
                'name' => 'Language Picker',
                'description' => 'Displays a dropdown to select a front-end language.',
            ],

            Components\Session::class => [
                'code' => 'session',
                'name' => 'lang:igniter.orange::default.session_component_title',
                'description' => 'lang:igniter.orange::default.session_component_desc',
            ],
            Components\Account::class => [
                'code' => 'account',
                'name' => 'lang:igniter.orange::default.account_component_title',
                'description' => 'lang:igniter.orange::default.account_component_desc',
            ],
            Components\ResetPassword::class => [
                'code' => 'resetPassword',
                'name' => 'lang:igniter.orange::default.reset_component_title',
                'description' => 'lang:igniter.orange::default.reset_component_desc',
            ],
            Components\AddressBook::class => [
                'code' => 'accountAddressBook',
                'name' => 'lang:igniter.orange::default.addressbook_component_title',
                'description' => 'lang:igniter.orange::default.addressbook_component_desc',
            ],
        ];
    }
}
