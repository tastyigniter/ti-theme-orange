<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTableOrRename extends Migration
{
    public function up()
    {
        if (Schema::hasTable('coupons')) {
            Schema::rename('coupons', 'igniter_coupons');
        }

        if (Schema::hasTable('coupons_history')) {
            Schema::rename('coupons_history', 'igniter_coupons_history');
        }

        if (Schema::hasTable('igniter_coupons')) {
            return;
        }

        Schema::create('igniter_coupons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('coupon_id');
            $table->string('name');
            $table->string('code', 15)->unique('code');
            $table->char('type', 1);
            $table->decimal('discount', 15, 4)->nullable();
            $table->decimal('min_total', 15, 4)->nullable();
            $table->integer('redemptions')->default(0);
            $table->integer('customer_redemptions')->default(0);
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
            $table->date('date_added');
            $table->char('validity', 15)->nullable();
            $table->date('fixed_date')->nullable();
            $table->time('fixed_from_time')->nullable();
            $table->time('fixed_to_time')->nullable();
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->string('recurring_every', 35)->nullable();
            $table->time('recurring_from_time')->nullable();
            $table->time('recurring_to_time')->nullable();
            $table->boolean('order_restriction');
        });

        Schema::create('igniter_coupons_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('coupon_history_id');
            $table->integer('coupon_id');
            $table->integer('order_id');
            $table->integer('customer_id');
            $table->string('code', 15);
            $table->decimal('min_total', 15, 4)->nullable();
            $table->decimal('amount', 15, 4)->nullable();
            $table->dateTime('date_used');
            $table->boolean('status');
        });

        $this->seedCoupons();
    }

    public function down()
    {
        Schema::dropIfExists('igniter_coupons');
        Schema::dropIfExists('igniter_coupons_history');
    }

    protected function seedCoupons()
    {
        if (DB::table('igniter_coupons')->count()) {
            return;
        }

        DB::table('igniter_coupons')->insert(array_map(function ($record) {
            $record['order_restriction'] = 0;
            $record['date_added'] = now();

            return $record;
        }, $this->getSeedRecords('coupons')));
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents(__DIR__.'/../records/'.$name.'.json'), true);
    }
}
