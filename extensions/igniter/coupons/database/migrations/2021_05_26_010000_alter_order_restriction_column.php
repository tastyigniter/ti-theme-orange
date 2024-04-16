<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterOrderRestrictionColumn extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->text('order_restriction')->nullable()->change();
        });

        $this->updateOrderRestrictionColumn();
    }

    public function down()
    {
    }

    protected function updateOrderRestrictionColumn()
    {
        DB::table('igniter_coupons')->get()->each(function ($model) {
            $restriction = null;
            if ($model->order_restriction) {
                $restriction[] = array_get([
                    1 => 'delivery',
                    2 => 'collection',
                ], $model->order_restriction);

                $restriction = json_encode($restriction);
            }

            DB::table('igniter_coupons')
                ->where('coupon_id', $model->coupon_id)
                ->update(['order_restriction' => $restriction]);
        });
    }
}
