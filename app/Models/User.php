<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'contact',
        'user_name',
        'address',
        'role_id',
        'profile',
        'cover',
        'password_changed',
        'country_id',
        'creator_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }
    public function student(){
        return $this->hasOne(Student::class);
    }
    public function creator(){
        return $this->belongsTo(User::class, 'creator_id');
    }
}
