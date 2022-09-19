<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('creator_id')->nullable();
            $table->string('contact');
            $table->string('status')->default('active');
            $table->integer('password_changed')->default(0);
            $table->string('address')->nullable();
            $table->string('profile')->nullable();
            $table->string('cover')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'Super Admin',
            'email' => "admin@superadmin.com",
            'user_name' => 'SuperAdmin',
            'role_id' => 1,
            'country_id' => 1,
            'password' => Hash::make("password"),
            'contact' => "0023765852862"
        ]);
        User::create([
            'name' => 'Cameroon',
            'email' => "cameroon@admin.com",
            'user_name' => 'AdminCameroon',
            'role_id' => 2,
            'country_id' => 1,
            'password' => Hash::make("password"),
            'contact' => "00237658580000"
        ]);
        User::create([
            'name' => 'Angola',
            'email' => "angola@admin.com",
            'user_name' => 'AdminAngola',
            'role_id' => 2,
            'country_id' => 2,
            'password' => Hash::make("password"),
            'contact' => "00237658528670"
        ]);
        User::create([
            'name' => 'Central African Republic',
            'email' => "car@admin.com",
            'user_name' => 'AdminCAR',
            'role_id' => 2,
            'country_id' => 3,
            'password' => Hash::make("password"),
            'contact' => "00237658528671"
        ]);
        User::create([
            'name' => 'Chad',
            'email' => "chad@admin.com",
            'user_name' => 'AdminChad',
            'role_id' => 2,
            'country_id' => 4,
            'password' => Hash::make("password"),
            'contact' => "00237658528673"
        ]);
        User::create([
            'name' => 'Democratic Republic of the Congo',
            'email' => "drc@admin.com",
            'user_name' => 'AdminDRC',
            'role_id' => 2,
            'country_id' => 5,
            'password' => Hash::make("password"),
            'contact' => "00237658528674"
        ]);
        User::create([
            'name' => 'Zambia',
            'email' => "zambia@admin.com",
            'user_name' => 'AdminZambia',
            'role_id' => 2,
            'country_id' => 6,
            'password' => Hash::make("password"),
            'contact' => "002376585283"
        ]);
        User::create([
            'name' => 'Equatorial Guinea',
            'email' => "eg@admin.com",
            'user_name' => 'AdminEG',
            'role_id' => 2,
            'country_id' => 7,
            'password' => Hash::make("password"),
            'contact' => "00237658528675"
        ]);
        User::create([
            'name' => 'Gabon',
            'email' => "gabon@admin.com",
            'user_name' => 'AdminGabon',
            'role_id' => 2,
            'country_id' => 8,
            'password' => Hash::make("password"),
            'contact' => "00237658528676"
        ]);
        User::create([
            'name' => 'São Tomé and Príncipe',
            'email' => "stp@admin.com",
            'user_name' => 'AdminSTP',
            'role_id' => 2,
            'country_id' => 9,
            'password' => Hash::make("password"),
            'contact' => "00237658528678"
        ]);
        User::create([
            'name' => 'Rwanda',
            'email' => "rwanda@admin.com",
            'user_name' => 'AdminRwanda',
            'role_id' => 2,
            'country_id' => 10,
            'password' => Hash::make("password"),
            'contact' => "00237658528700"
        ]);
        User::create([
            'name' => 'Burundi',
            'email' => "burundi@admin.com",
            'user_name' => 'AdminBurundi',
            'role_id' => 2,
            'country_id' => 11,
            'password' => Hash::make("password"),
            'contact' => "00237658528000"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
