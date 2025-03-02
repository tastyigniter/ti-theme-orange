<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterColumnsOnPagesTable extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('heading');

            $table->dropColumn('layout_id');
            $table->string('layout')->nullable();

            $table->mediumText('metadata')->nullable();

            $table->integer('priority')->nullable();
        });

        DB::table('pages')->update(['layout' => 'static']);
        DB::table('pages')->get()->each(function ($model) {
            $navigation = @unserialize($model->navigation) ?: [];
            DB::table('pages')->where('page_id', $model->page_id)->update([
                'metadata' => json_encode(['navigation' => empty($navigation) ? '0' : '1']),
            ]);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('navigation');
        });
    }

    public function down()
    {
    }
}
