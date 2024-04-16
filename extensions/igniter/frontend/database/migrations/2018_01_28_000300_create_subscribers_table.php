<?php

namespace Igniter\FrontEnd\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('sampoyigi_frontend_subscribers')) {
            Schema::rename('sampoyigi_frontend_subscribers', 'igniter_frontend_subscribers');
        }

        if (Schema::hasTable('igniter_frontend_subscribers')) {
            return;
        }

        Schema::create('igniter_frontend_subscribers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('email', 128);
            $table->integer('statistics')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('igniter_frontend_subscribers');
    }
}
