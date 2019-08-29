<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAreaPcAndOrgtech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rate_pc', function (Blueprint $table) {
            $table->string('area');
        });
        Schema::table('rate_orgtech', function (Blueprint $table) {
            $table->string('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rate_pc', function (Blueprint $table) {
            $table->dropColumn('area');
        });
        Schema::table('rate_orgtech', function (Blueprint $table) {
            $table->dropColumn('area');
        });
    }
}
