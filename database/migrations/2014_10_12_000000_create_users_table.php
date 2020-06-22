<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->primary('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->default('client');
            $table->mediumText('bio')->nullable();
            $table->longText('photo')->default('profile.png');
            $table->double('payout', 10, 2)->default(0.00);
            $table->string('rank')->default('C');

            $table->integer('ongoing_orders')->default(0);
            $table->integer('completed_orders')->default(0);
            //$emptyArr = array();
            $table->json('ongoing_orders_arr')->nullable();
            $table->json('current_orders_arr')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
