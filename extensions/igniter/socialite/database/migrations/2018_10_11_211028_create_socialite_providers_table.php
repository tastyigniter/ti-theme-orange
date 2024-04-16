<?php

namespace Igniter\Socialite\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialiteProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('igniter_socialite_providers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('token')->nullable();
            $table->index(['provider', 'token'], 'provider_token_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('igniter_socialite_providers');
    }
}
