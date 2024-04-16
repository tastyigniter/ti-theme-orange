<?php

namespace Igniter\Coupons\ApiResources;

use Igniter\Api\Classes\ApiController;
use Igniter\Coupons\Requests\Coupon;

/**
 * Coupons API Controller
 */
class Coupons extends ApiController
{
    public $implement = ['Igniter.Api.Actions.RestController'];

    public $restConfig = [
        'actions' => [
            'index' => [
                'pageLimit' => 20,
            ],
            'store' => [],
            'show' => [],
            'update' => [],
            'destroy' => [],
        ],
        'request' => Coupon::class,
        'repository' => Repositories\CouponsRepository::class,
        'transformer' => Transformers\CouponsTransformer::class,
    ];

    protected $requiredAbilities = ['coupons:*'];
}
