<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatePcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rate_pc');
        Schema::create('rate_pc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pc_id')->unsigned();
            $table->foreign('pc_id')->references('id')->on('article_pc');
            $table->text('username');
            $table->integer('price');
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
        Schema::dropIfExists('rate_pc');
    }
}
