<?php

namespace Igniter\Socialite\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserTypeColumnSocialiteProvidersTable extends Migration
{
    public function up()
    {
        Schema::table('igniter_socialite_providers', function (Blueprint $table) {
            $table->string('user_type')->nullable();
        });

        DB::table('igniter_socialite_providers')->update([
            'user_type' => 'customers',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('igniter_socialite_providers');
    }
}
