<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tutor', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('name');
            $table->string('phone');
            $table->string('sex');
            $table->string('birth');
            $table->integer('id_country');
            $table->integer('id_district');
            $table->string('address');
            $table->text('desc');
            $table->string('role');
            $table->string('time');
            $table->string('level');
            $table->string('special');
            $table->integer('id_class');
            $table->integer('id_subject');
            $table->string('type');
            $table->text('schedule');
            $table->string('avatar');
            $table->string('certificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor');
    }
};
