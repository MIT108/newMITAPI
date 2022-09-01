<?php

use App\Models\TeacherType;
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
        Schema::create('teacher_types', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });
        TeacherType::create([
            'name' => 'School Head'
        ]);
        TeacherType::create([
            'name' => 'Teacher'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_types');
    }
};
