<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePrimaryKeyBigintAllTables extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id', true)->change();
        });

        Schema::table('igniter_coupons_history', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_history_id', true)->change();
        });
    }

    public function down()
    {
    }
}
