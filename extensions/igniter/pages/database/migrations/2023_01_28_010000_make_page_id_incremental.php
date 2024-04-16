<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakePageIdIncremental extends Migration
{
    public function up()
    {
        $tablePrefix = Schema::getConnection()->getTablePrefix();
        if (DB::select(DB::raw('SHOW KEYS FROM '.$tablePrefix.'pages WHERE Key_name=\'PRIMARY\' AND Column_name=\'page_id\''))) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id', true)->change();
        });
    }

    public function down()
    {
    }
}
