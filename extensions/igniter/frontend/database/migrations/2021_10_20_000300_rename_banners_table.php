<?php

namespace Igniter\FrontEnd\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameBannersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('igniter_frontend_banners')) {
            return;
        }

        Schema::rename('banners', 'igniter_frontend_banners');
    }

    public function down()
    {
    }
}
