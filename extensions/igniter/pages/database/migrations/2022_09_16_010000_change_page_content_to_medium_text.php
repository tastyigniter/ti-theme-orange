<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePageContentToMediumText extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->mediumText('content')->change();
        });
    }

    public function down()
    {
    }
}
