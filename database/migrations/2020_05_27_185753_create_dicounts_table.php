<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDicountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dicounts', function (Blueprint $table) {
            $table->id();
            $table->text('code');
            $table->text('type');
            $table->double('amount', 8, 2);
            $table->integer('uses')->default(0);
            $table->text('scope')->default('all');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dicounts');
    }
}
