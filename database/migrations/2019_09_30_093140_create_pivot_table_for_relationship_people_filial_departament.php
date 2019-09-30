<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableForRelationshipPeopleFilialDepartament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filial_departament_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('filial_id')->unsigned()->default(0);
            $table->foreign('filial_id')->references('id')->on('filials');
            $table->bigInteger('departament_id')->unsigned()->default(0);
            $table->foreign('departament_id')->references('id')->on('departaments');
            $table->bigInteger('people_id')->unsigned()->default(0);
            $table->foreign('people_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filial_departament_people');
    }
}
