<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->boolean('trial_status')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('payment_status')->nullable();
            $table->string('recurring_id')->nullable();
            $table->float('payment_amount')->default(0.0);
            $table->string('currency_unit')->default('MXN');
            $table->string('payment_method')->nullable();
            $table->datetime('payment_date')->default(Carbon::now());
            $table->datetime('expiration_date')->default(Carbon::now()->addMonths(1));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};
