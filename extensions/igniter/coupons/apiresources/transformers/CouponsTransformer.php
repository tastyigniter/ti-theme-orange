<?php

namespace Igniter\Coupons\ApiResources\Transformers;

use Igniter\Api\ApiResources\Transformers\CategoryTransformer;
use Igniter\Api\ApiResources\Transformers\MenuTransformer;
use Igniter\Coupons\Models\Coupons_model;
use League\Fractal\TransformerAbstract;

class CouponsTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'menus',
        'categories',
        'history',
    ];

    public function transform(Coupons_model $coupon)
    {
        return $coupon->toArray();
    }

    public function includeCategories(Coupons_model $coupon)
    {
        return $this->collection(
            $coupon->categories,
            new CategoryTransformer,
            'categories'
        );
    }

    public function includeMenus(Coupons_model $coupon)
    {
        return $this->collection(
            $coupon->menus,
            new MenuTransformer,
            'menus'
        );
    }

    public function includeHistory(Coupons_model $coupon)
    {
        return $this->collection(
            $coupon->history,
            new CouponHistoryTransformer,
            'history'
        );
    }
}
