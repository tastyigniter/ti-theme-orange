<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToCoupons extends Migration
{
    public function up()
    {
        Schema::table('igniter_coupons', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });

        Schema::table('igniter_coupons_history', function (Blueprint $table) {
            $table->timestamp('date_used')->change();
            $table->renameColumn('date_used', 'created_at');
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
    }
}
