<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->integer('confirmed_cases')->default(0);
            $table->integer('new_cases')->default(0);
            $table->integer('total_death')->default(0);
            $table->integer('new_deaths')->default(0);
            $table->integer('total_recovered')->default(0);
            $table->integer('active_cases')->default(0);
            $table->integer('critical_cases')->default(0);
            $table->integer('total_cases_per_mil')->default(0);
            $table->integer('total_death_per_mil')->default(0);
            $table->integer('total_tested');
            $table->integer('total_test_per_mil');
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
        Schema::dropIfExists('statistics');
    }
}
