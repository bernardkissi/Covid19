<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towns', function (Blueprint $table) {
            $table->id(); 
            $table->uuid('uuid')->unique();
            $table->foreignId('district_id');
            $table->string('name')->unique()->nullable();
            $table->integer('confirmed')->default(0);
            $table->integer('active')->default(0);
            $table->integer('recovered')->default(0);
            $table->integer('deceased')->default(0);
            $table->integer('local')->default(0);
            $table->integer('imported')->default(0);
            $table->integer('counter')->default(0);
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('towns');
    }
}
