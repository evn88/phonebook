<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateOrgtechTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rate_orgtech');
        Schema::create('rate_orgtech', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('orgtech_id')->unsigned();
            $table->foreign('orgtech_id')->references('id')->on('article_orgtech');
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
        Schema::dropIfExists('rate_orgtech');
    }
}
