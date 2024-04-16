<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeIsLimitedToCartItemToApplyCouponOnEnum extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->enum(
                'apply_coupon_on',
                ['whole_cart', 'menu_items', 'delivery_fee']
            )->default('whole_cart')->after('order_restriction');
        });
        $this->updateApplyCouponOnEnum();
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->dropColumn('is_limited_to_cart_item');
        });
    }

    // migrate is_limited_to_cart_item to the new apply_coupon_on enum that supports multiple options
    protected function updateApplyCouponOnEnum()
    {
        DB::table('igniter_coupons')
            ->where('is_limited_to_cart_item', 1)->get()->each(
                function ($model) {
                    DB::table('igniter_coupons')
                        ->where('coupon_id', $model->coupon_id)
                        ->update([
                            'apply_coupon_on' => 'menu_items',
                        ]);
                }
            );
    }
}
