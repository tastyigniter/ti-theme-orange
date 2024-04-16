<?php

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('igniter_pages_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('theme_code')->index();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('igniter_pages_menu_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('code');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('url')->nullable();
            $table->string('reference')->nullable();
            $table->text('config')->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('igniter_pages_menus');
        Schema::dropIfExists('igniter_pages_menu_items');
    }
}
