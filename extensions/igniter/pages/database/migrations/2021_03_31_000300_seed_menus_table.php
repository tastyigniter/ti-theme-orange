<?php

namespace Igniter\Pages\Database\Migrations;

use Igniter\Pages\Models\Menu;
use Illuminate\Database\Migrations\Migration;

class SeedMenusTable extends Migration
{
    public function up()
    {
        Menu::syncAll();
    }

    public function down()
    {
    }
}
