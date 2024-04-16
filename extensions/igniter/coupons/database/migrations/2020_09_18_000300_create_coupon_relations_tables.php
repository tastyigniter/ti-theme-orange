<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponRelationsTables extends Migration
{
    public function up()
    {
        if (Schema::hasTable('igniter_coupon_categories')) {
            return;
        }

        Schema::create('igniter_coupon_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->unique(['coupon_id', 'category_id']);
        });

        Schema::create('igniter_coupon_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('menu_id')->unsigned()->index();
            $table->unique(['coupon_id', 'menu_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('igniter_coupon_categories');
        Schema::dropIfExists('igniter_coupon_menus');
    }
}
