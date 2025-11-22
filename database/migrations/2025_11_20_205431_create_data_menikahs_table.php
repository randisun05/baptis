<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_menikahs', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('statusMarried')->nullable();
            $table->string('namePasangan')->nullable();
            $table->string('religionPasangan')->nullable();
            $table->string('placeMarried1')->nullable();
            $table->string('cityMarried1')->nullable();
            $table->date('dateMarried1')->nullable();
            $table->string('namePeneguh1')->nullable();
            $table->string('numberMarried1')->nullable();
            $table->string('placeMarried2')->nullable();
            $table->string('cityMarried2')->nullable();
            $table->date('dateMarried2')->nullable();
            $table->string('namePeneguh2')->nullable();
            $table->string('numberMarried2')->nullable();
            $table->string('cityMarried3')->nullable();
            $table->date('dateMarried3')->nullable();
            $table->string('numberMarried3')->nullable();
            $table->string('religionMarried')->nullable();
            $table->string('placeMarried4')->nullable();
            $table->string('cityMarried4')->nullable();
            $table->string('namePeneguh4')->nullable();
            $table->date('dateMarried4')->nullable();
            $table->string('numberMarried4')->nullable();
            $table->string('nameMantan')->nullable();
            $table->string('cityMantan')->nullable();
            $table->string('statusMantan')->nullable();
            $table->year('yearMantan')->nullable();
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
        Schema::dropIfExists('data_meMarrieds');
    }
};
