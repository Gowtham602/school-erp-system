<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','phone','qualification','experience_type','address'
    ];
    public function user()     
    {
        return $this->belongsTo(User::class);         
    }
}


