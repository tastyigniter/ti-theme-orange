<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCustomerGroupsTables extends Migration
{
    public function up()
    {
        Schema::create('igniter_coupon_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('customer_id');
        });

        Schema::create('igniter_coupon_customer_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('customer_group_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('igniter_coupon_customers');
        Schema::dropIfExists('igniter_coupon_customer_groups');
    }
}
