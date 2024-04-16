<?php

namespace Igniter\Socialite\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseStringLength extends Migration
{
    public function up()
    {
        Schema::table('igniter_socialite_providers', function (Blueprint $table) {
            $table->string('provider', 255)->change();
            $table->string('provider_id', 255)->change();
            $table->string('token', 255)->change();
            $table->string('user_type', 255)->change();
        });
    }

    public function down()
    {
    }
}
