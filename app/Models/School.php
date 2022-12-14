<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'school_type_id',
        'name',
        'email1',
        'email2',
        'phone1',
        'phone2',
        'lat',
        'lng',
        'logo',
        'cover',
        'status',
        'description',
    ];

    public function school_type(){
        return $this->belongsTo(SchoolType::class);
    }

    // public function student(){
    //     return $this->hasMany(Student::class);
    // }
    public function teacher(){
        return $this->hasMany(Teacher::class);
    }
}
