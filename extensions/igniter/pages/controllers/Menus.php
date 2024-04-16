<?php

namespace Igniter\Pages\Controllers;

use Admin\Facades\AdminMenu;
use Igniter\Pages\Models\Menu;
use Igniter\Pages\Models\MenuItem;
use Illuminate\Support\Facades\Request;

/**
 * Menus Admin Controller
 */
class Menus extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\FormController::class,
        \Admin\Actions\ListController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Igniter\Pages\Models\Menu::class,
            'title' => 'Static Menus',
            'emptyMessage' => 'lang:admin::lang.list.text_empty',
            'defaultSort' => ['id', 'DESC'],
            'configFile' => 'menu',
        ],
    ];

    public $formConfig = [
        'name' => 'Static Menu',
        'model' => \Igniter\Pages\Models\Menu::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/pages/menus/edit/{id}',
            'redirectClose' => 'igniter/pages/menus',
            'redirectNew' => 'igniter/pages/menus/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/pages/menus/edit/{id}',
            'redirectClose' => 'igniter/pages/menus',
            'redirectNew' => 'igniter/pages/menus/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'igniter/pages/menus',
        ],
        'delete' => [
            'redirect' => 'igniter/pages/menus',
        ],
        'configFile' => 'menu',
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

    public function edit($context, $recordId)
    {
        $this->addJs('$/igniter/pages/assets/js/menuitemseditor.js');

        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function edit_onNewItem($context, $recordId)
    {
        $model = $this->asExtension('FormController')->formFindModelObject($recordId);
        $model->items()->create([
            'menu_id' => $recordId,
            'code' => 'new-item',
            'title' => 'New Item',
            'type' => 'url',
            'url' => '/',
        ]);

        $model->reload();
        $this->asExtension('FormController')->initForm($model, $context);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Menu item created'))->now();

        $formField = $this->widgets['form']->getField('items');

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$formField->getId('group') => $this->widgets['form']->renderField($formField, [
                'useContainer' => false,
            ]),
        ];
    }

    public function edit_onGetMenuItemTypeInfo($context, $recordId)
    {
        $this->asExtension('FormController')->formFindModelObject($recordId);

        $type = Request::input('type');

        return [
            'menuItemTypeInfo' => MenuItem::getTypeInfo($type),
        ];
    }
}
