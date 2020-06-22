<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigInteger('order_id');
            $table->primary('order_id');
            $table->string('order_type', 100)->nullable($value=true);
            $table->double('order_price', 100, 2)->default(0.00);
            $table->json('order_message')->nullable();
            $table->string('order_status', 100)->default('unclaimed');
            $table->string('payout_status', 100)->default('in-progress');

            $table->bigInteger('client_id')->nullable($value=true);
            $table->bigInteger('booster_id')->nullable($value=true);
            $table->timestamps(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
