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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('name');
            $table->boolean('gender');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('code-password')->nullable();
            $table->string('contact')->unique();
            $table->boolean('group');
            $table->enum('status', ['confirm', 'pending', 'cancel', 'confirmed', 'end', 'process'])->default('confirm');
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
        Schema::dropIfExists('members');
    }
};
