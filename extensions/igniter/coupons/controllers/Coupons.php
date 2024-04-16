<?php

namespace Igniter\Coupons\Controllers;

use Admin\Facades\AdminMenu;

class Coupons extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
        \Admin\Actions\LocationAwareController::class,
    ];

    public $locationConfig = [
        'addAbsenceConstraint' => true,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Igniter\Coupons\Models\Coupons_model::class,
            'title' => 'igniter.coupons::default.text_title',
            'emptyMessage' => 'igniter.coupons::default.text_empty',
            'defaultSort' => ['coupon_id', 'DESC'],
            'configFile' => 'coupons_model',
        ],
    ];

    public $formConfig = [
        'name' => 'igniter.coupons::default.text_form_name',
        'model' => \Igniter\Coupons\Models\Coupons_model::class,
        'request' => \Igniter\Coupons\Requests\Coupon::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/coupons/coupons/edit/{coupon_id}',
            'redirectClose' => 'igniter/coupons/coupons',
            'redirectNew' => 'igniter/coupons/coupons/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/coupons/coupons/edit/{coupon_id}',
            'redirectClose' => 'igniter/coupons/coupons',
            'redirectNew' => 'igniter/coupons/coupons/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'igniter/coupons/coupons',
        ],
        'delete' => [
            'redirect' => 'igniter/coupons/coupons',
        ],
        'configFile' => 'coupons_model',
    ];

    protected $requiredPermissions = 'Admin.Coupons';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('coupons', 'marketing');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->columnName == 'validity') {
            return ucwords($record->validity);
        }
    }
}
