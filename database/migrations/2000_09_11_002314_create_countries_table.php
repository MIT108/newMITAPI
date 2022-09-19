<?php

use App\Models\Country;
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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        Country::create([
            "name" => "Cameroon"
        ]);
        Country::create([
            "name" => "Angola"
        ]);
        Country::create([
            "name" => "Central African Republic"
        ]);
        Country::create([
            "name" => "Chad"
        ]);
        Country::create([
            "name" => "Democratic Republic of the Congo"
        ]);
        Country::create([
            "name" => "Zambia"
        ]);
        Country::create([
            "name" => "Equatorial Guinea"
        ]);
        Country::create([
            "name" => "Gabon"
        ]);
        Country::create([
            "name" => "São Tomé and Príncipe"
        ]);
        Country::create([
            "name" => "Rwanda"
        ]);
        Country::create([
            "name" => "Burundi"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
