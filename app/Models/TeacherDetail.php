<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'user_id',
        'employee_id',
        'phone',
        'alternate_phone',
        'gender',
        'dob',
        'qualification',
        'experience',
        'joining_date',
        'salary',
        'blood_group',
        'aadhaar_no',
        'address',
        'city',
        'state',
        'pincode',
        'photo',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}