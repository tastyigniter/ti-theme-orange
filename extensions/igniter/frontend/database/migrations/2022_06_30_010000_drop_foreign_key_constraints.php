<?php

namespace Igniter\Frontend\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyConstraints extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('igniter_frontend_banners', function (Blueprint $table) {
            $table->dropForeignKeyIfExists('language_id');
            $table->dropIndexIfExists(DB::getTablePrefix().'igniter_frontend_banners_language_id_foreign');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
    }
}
