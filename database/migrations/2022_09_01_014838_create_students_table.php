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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id');
            // $table->foreignId('school_id');
            // $table->foreignId('class_room_id');
            // $table->string('level')->nullable();
            // $table->string('matricule')->unique();
            // $table->string('field')->nullable();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('school_id')->references('id')->on('schools');
            // $table->foreign('class_room_id')->references('id')->on('class_rooms');
            // $table->string('current_address')->nullable();
            // $table->enum('account_status',['active','suspended','blocked','disactivated','inactive'])->default('inactive');
            // $table->boolean('status')->default(false);
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
        Schema::dropIfExists('students');
    }
};
