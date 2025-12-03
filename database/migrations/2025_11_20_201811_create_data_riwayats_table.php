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
        Schema::create('data_riwayats', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('religion')->nullable();
            $table->string('location')->nullable();
            $table->string('schedule')->nullable();
            $table->date('dateStart')->nullable();
            $table->date('dateEnd')->nullable();
            $table->string('participateBefore')->nullable();
            $table->string('nameGuru')->nullable();
            $table->string('nameGereja')->nullable();
            $table->string('addressGereja')->nullable();
            $table->string('namePriest')->nullable();
            $table->date('dateBaptis')->nullable();
            $table->string('numberBaptis')->nullable();
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
        Schema::dropIfExists('data_riwayats');
    }
};
