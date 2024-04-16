<?php

namespace Igniter\Frontend;

use Illuminate\Support\Facades\Validator;

class Extension extends \System\Classes\BaseExtension
{
    public function boot()
    {
        $this->addCaptchaValidationRule();
    }

    public function register()
    {
        $this->registerReCaptcha();
    }

    public function registerComponents()
    {
        return [
            \Igniter\Frontend\Components\Banners::class => [
                'code' => 'banners',
                'name' => 'lang:igniter.frontend::default.banners.component_title',
                'description' => 'lang:igniter.frontend::default.banners.component_desc',
            ],
            \Igniter\Frontend\Components\Contact::class => [
                'code' => 'contact',
                'name' => 'lang:igniter.frontend::default.contact.component_title',
                'description' => 'lang:igniter.frontend::default.contact.component_desc',
            ],
            \Igniter\Frontend\Components\Slider::class => [
                'code' => 'slider',
                'name' => 'lang:igniter.frontend::default.slider.component_title',
                'description' => 'lang:igniter.frontend::default.slider.component_desc',
            ],
            \Igniter\Frontend\Components\Newsletter::class => [
                'code' => 'newsletter',
                'name' => 'lang:igniter.frontend::default.newsletter.component_title',
                'description' => 'lang:igniter.frontend::default.newsletter.component_desc',
            ],
            \Igniter\Frontend\Components\FeaturedItems::class => [
                'code' => 'featuredItems',
                'name' => 'lang:igniter.frontend::default.featured.component_title',
                'description' => 'lang:igniter.frontend::default.featured.component_desc',
            ],
            \Igniter\Frontend\Components\Captcha::class => [
                'code' => 'captcha',
                'name' => 'lang:igniter.frontend::default.captcha.component_title',
                'description' => 'lang:igniter.frontend::default.captcha.component_desc',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'design' => [
                'child' => [
                    'sliders' => [
                        'priority' => 30,
                        'class' => 'sliders',
                        'href' => admin_url('igniter/frontend/sliders'),
                        'title' => lang('igniter.frontend::default.text_side_menu'),
                        'permission' => ['Igniter.FrontEnd.ManageBanners', 'Igniter.FrontEnd.ManageSlideshow'],
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'Igniter.FrontEnd.ManageSettings' => [
                'description' => 'Configure google recaptcha and mailchimp settings',
                'group' => 'module',
            ],
            'Igniter.FrontEnd.ManageBanners' => [
                'description' => 'Create, modify and delete front-end banners',
                'group' => 'module',
            ],
            'Igniter.FrontEnd.ManageSlideshow' => [
                'group' => 'module',
                'description' => 'Create, modify and delete front-end sliders',
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'captchasettings' => [
                'label' => 'reCaptcha Settings',
                'description' => 'Manage google reCAPTCHA settings.',
                'icon' => 'fa fa-gear',
                'model' => \Igniter\Frontend\Models\CaptchaSettings::class,
                'permissions' => ['Igniter.FrontEnd.ManageSettings'],
            ],
            'mailchimpsettings' => [
                'label' => 'Mailchimp Settings',
                'description' => 'Manage Mailchimp API settings.',
                'icon' => 'fa fa-gear',
                'model' => \Igniter\Frontend\Models\MailchimpSettings::class,
                'permissions' => ['Igniter.FrontEnd.ManageSettings'],
            ],
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'igniter.frontend::mail.contact' => 'Contact form email to admin',
        ];
    }

    protected function registerReCaptcha()
    {
        $this->app->singleton('recaptcha', function ($app) {
            $settings = Models\CaptchaSettings::instance();

            return new Classes\ReCaptcha(
                $settings->get('api_secret_key'),
                $settings->get('version')
            );
        });
    }

    /**
     * Extends Validator to include a recaptcha type
     */
    protected function addCaptchaValidationRule()
    {
        Validator::extendImplicit('recaptcha', function ($attribute, $value, $parameters, $validator) {
            return app('recaptcha')->verifyResponse($value);
        }, lang('igniter.frontend::default.captcha.error_recaptcha'));
    }
}
