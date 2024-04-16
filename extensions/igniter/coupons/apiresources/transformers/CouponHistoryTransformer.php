<?php

namespace Igniter\Coupons\ApiResources\Transformers;

use Igniter\Coupons\Models\Coupons_history_model;
use League\Fractal\TransformerAbstract;

class CouponHistoryTransformer extends TransformerAbstract
{
    public function transform(Coupons_history_model $history)
    {
        return $history->toArray();
    }
}
