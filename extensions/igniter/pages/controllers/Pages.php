<?php

namespace Igniter\Pages\Controllers;

use Admin\Facades\AdminMenu;
use Igniter\Pages\Models\Menu;

class Pages extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Igniter\Pages\Models\Pages_model::class,
            'title' => 'lang:igniter.pages::default.text_title',
            'emptyMessage' => 'lang:igniter.pages::default.text_empty',
            'defaultSort' => ['page_id', 'DESC'],
            'configFile' => 'pages_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:igniter.pages::default.text_form_name',
        'model' => \Igniter\Pages\Models\Pages_model::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/pages/pages/edit/{page_id}',
            'redirectClose' => 'igniter/pages/pages',
            'redirectNew' => 'igniter/pages/pages/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/pages/pages/edit/{page_id}',
            'redirectClose' => 'igniter/pages/pages',
            'redirectNew' => 'igniter/pages/pages/create',
        ],
        'delete' => [
            'redirect' => 'igniter/pages/pages',
        ],
        'configFile' => 'pages_model',
    ];

    protected $requiredPermissions = 'Igniter.Pages.*';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pages', 'design');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Igniter.PageMenus.Manage')) {
            Menu::syncAll();
        }

        $this->asExtension('ListController')->index();
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['language_id', 'lang:igniter.pages::default.label_language', 'required|integer'];
        $rules[] = ['title', 'lang:igniter.pages::default.label_title', 'required|min:2|max:255'];
        $rules[] = ['permalink_slug', 'lang:igniter.pages::default.label_permalink_slug', 'alpha_dash|max:255'];
        $rules[] = ['content', 'lang:igniter.pages::default.label_content', 'required|min:2'];
        $rules[] = ['navigation.*', 'lang:igniter.pages::default.label_navigation', 'required'];
        $rules[] = ['status', 'lang:admin::lang.label_status', 'required|integer'];

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}
