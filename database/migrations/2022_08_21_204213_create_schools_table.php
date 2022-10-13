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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('school_type_id')->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->string('name');
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->decimal('lat', 5.0000000000);
            $table->decimal('lng', 5.0000000000);
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->enum('status',['pending', 'active','inactive'])->default('pending');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('schools');
    }
};
