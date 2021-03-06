<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials');
            $table->bigInteger('departament_id')->unsigned();
            $table->foreign('departament_id')->references('id')->on('departaments');
            $table->text('name');
            $table->text('profession');
            $table->text('short_number')->nullable()->comment('короткий номер');
            $table->text('ext_number')->nullable()->comment('внешний(городской) номер');
            $table->text('speed_number')->nullable()->comment('быстрый набор для ЦРПБ');
            $table->text('mobile_number')->nullable()->comment('мобильный');
            $table->date('birthday')->nullable();
            $table->integer('order')->default('100');
            $table->softDeletes();
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
        Schema::dropIfExists('people');
    }
}
