<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullableColumns extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons_history', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->unsignedBigInteger('customer_id')->nullable()->change();
        });
    }

    public function down()
    {
    }
}
