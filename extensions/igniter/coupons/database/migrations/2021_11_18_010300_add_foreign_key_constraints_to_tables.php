<?php

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        // Commented out so foreign keys are not added on new installations.
        // For existing installations, another migration has been added to drop all foreign keys.

        //        Schema::table('igniter_coupons_history', function (Blueprint $table) {
        //            $table->foreignId('coupon_id')->nullable()->change();
        //            $table->foreign('coupon_id')
        //                ->references('coupon_id')
        //                ->on('igniter_coupons')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //
        //            $table->foreignId('order_id')->nullable()->change();
        //            $table->foreign('order_id')
        //                ->references('order_id')
        //                ->on('orders')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //
        //            $table->foreignId('customer_id')->nullable()->change();
        //            $table->foreign('customer_id')
        //                ->references('customer_id')
        //                ->on('customers')
        //                ->nullOnDelete()
        //                ->cascadeOnUpdate();
        //        });
        //
        //        Schema::table('igniter_coupon_categories', function (Blueprint $table) {
        //            $table->foreignId('coupon_id')->nullable()->change();
        //            $table->foreign('coupon_id')
        //                ->references('coupon_id')
        //                ->on('igniter_coupons')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //
        //            $table->foreignId('category_id')->nullable()->change();
        //            $table->foreign('category_id')
        //                ->references('category_id')
        //                ->on('categories')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //        });
        //
        //        Schema::table('igniter_coupon_menus', function (Blueprint $table) {
        //            $table->foreignId('coupon_id')->nullable()->change();
        //            $table->foreign('coupon_id')
        //                ->references('coupon_id')
        //                ->on('igniter_coupons')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //
        //            $table->foreignId('menu_id')->nullable()->change();
        //            $table->foreign('menu_id')
        //                ->references('menu_id')
        //                ->on('menus')
        //                ->cascadeOnDelete()
        //                ->cascadeOnUpdate();
        //        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        try {
            Schema::table('igniter_coupons_history', function (Blueprint $table) {
                $table->dropForeign(['coupon_id']);
                $table->dropForeign(['order_id']);
                $table->dropForeign(['customer_id']);
            });

            Schema::table('igniter_coupon_categories', function (Blueprint $table) {
                $table->dropForeign(['coupon_id']);
                $table->dropForeign(['category_id']);
            });

            Schema::table('igniter_coupon_menus', function (Blueprint $table) {
                $table->dropForeign(['coupon_id']);
                $table->dropForeign(['menu_id']);
            });
        } catch (\Exception $e) {
        }
    }
}
