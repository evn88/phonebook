<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDateEntryInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_pc', function (Blueprint $table) {
            $table->dropColumn(['date_entry']);
        });
        Schema::table('article_orgtech', function (Blueprint $table) {
            $table->dropColumn(['date_entry']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_pc', function (Blueprint $table) {
            $table->date('date_entry');
        });

        Schema::table('article_orgtech', function (Blueprint $table) {
            $table->date('date_entry');
        });
    }
}
