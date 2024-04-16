<?php

namespace Igniter\Frontend\Controllers;

use Admin\Facades\AdminMenu;

class Banners extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Igniter\Frontend\Models\Banners::class,
            'title' => 'lang:igniter.frontend::default.banners.text_title',
            'emptyMessage' => 'lang:igniter.frontend::default.banners.text_empty',
            'defaultSort' => ['banner_id', 'DESC'],
            'configFile' => 'banners',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:igniter.frontend::default.banners.text_form_name',
        'model' => \Igniter\Frontend\Models\Banners::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/frontend/banners/edit/{banner_id}',
            'redirectClose' => 'igniter/frontend/banners',
            'redirectNew' => 'igniter/frontend/banners/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/frontend/banners/edit/{banner_id}',
            'redirectClose' => 'igniter/frontend/banners',
            'redirectNew' => 'igniter/frontend/banners/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'igniter/frontend/banners',
        ],
        'delete' => [
            'redirect' => 'igniter/frontend/banners',
        ],
        'configFile' => 'banners',
    ];

    protected $requiredPermissions = 'Igniter.FrontEnd.ManageBanners';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('sliders', 'design');
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['name', 'lang:admin::lang.label_name', 'required|min:2|max:255'],
            ['type', 'lang:igniter.frontend::default.banners.label_type', 'required|alpha|max:8'],
            ['click_url', 'lang:igniter.frontend::default.banners.label_click_url', 'required|min:2|max:255'],
            ['custom_code', 'lang:igniter.frontend::default.banners.label_custom_code', 'required_if:type,custom'],
            ['alt_text', 'lang:igniter.frontend::default.banners.label_alt_text', 'required_if:type,image|min:2|max:255'],
            ['image_code', 'lang:igniter.frontend::default.banners.label_image', 'required_if:type,image'],
            ['language_id', 'lang:igniter.frontend::default.banners.label_language', 'required|integer'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}
