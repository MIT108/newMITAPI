<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fileable = ['user_id', 'school_id','classe_id','status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function classe(){
        return $this->belongsTo(Classe::class);
    }
}
