<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToTables extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id')->change();
            $table->foreignId('language_id')->change()->constrained('languages', 'language_id');
        });
    }

    public function down()
    {
        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropForeign(['language_id']);
            });
        } catch (\Exception $e) {
        }
    }
}
