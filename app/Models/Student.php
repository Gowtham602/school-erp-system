<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
   use SoftDeletes;
class Student extends Model
{
    use HasFactory;


     protected $fillable = [
        'name',
        'father_name',
        'mother_name',
        'phone',
        'address',
        'gender',
        'class_id',
        'created_by',
        'updated_by'
    ];

    // Relation: Student → Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Who updated
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function histories()
    {
        return $this->hasMany(StudentHistory::class);
    }

}
