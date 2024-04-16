<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoApplyFieldOnCouponsTable extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->boolean('auto_apply')->default(false);
        });
    }
}
