<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountSettings extends Migration
{
    public function up()
    {
        Schema::create('seat_billing_discount_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->float('value');
            $table->timestamps();
        });

        // Добавляем начальные настройки
        DB::table('seat_billing_discount_settings')->insert([
            ['key' => 'max_discount', 'value' => 20],
            ['key' => 'discount_per_fleet', 'value' => 1],
            ['key' => 'max_fleet_discount', 'value' => 20],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('seat_billing_discount_settings');
    }
}