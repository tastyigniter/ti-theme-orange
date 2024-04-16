<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToPages extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });
    }

    public function down()
    {
    }
}
