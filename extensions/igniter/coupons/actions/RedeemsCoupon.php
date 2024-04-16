<?php

namespace Igniter\Coupons\Actions;

use Igniter\Coupons\Models\Coupons_history_model;
use Igniter\Flame\Cart\CartCondition;
use Igniter\Flame\Traits\ExtensionTrait;
use System\Actions\ModelAction;

class RedeemsCoupon extends ModelAction
{
    use ExtensionTrait;

    /**
     * Redeem coupon by order
     */
    public function redeemCoupon()
    {
        if (!$this->model->getOrderTotals()->keyBy('code')->get('coupon')) {
            return;
        }

        Coupons_history_model::redeem($this->model->order_id);
    }

    /**
     * Add cart coupon to order by order_id
     *
     * @param \Admin\Models\Orders_model $order
     * @param \Igniter\Flame\Cart\CartCondition $couponCondition
     * @param \Admin\Models\Customers_model $customer
     *
     * @return int|bool
     */
    public function logCouponHistory($couponCondition)
    {
        if (!$couponCondition instanceof CartCondition) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid argument, expected %s, got %s',
                CartCondition::class, get_class($couponCondition)
            ));
        }

        // Make sure order model exists
        if (!$this->model->exists) {
            return false;
        }

        return Coupons_history_model::createHistory($couponCondition, $this->model);
    }
}
