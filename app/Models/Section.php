<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'name',
        'class_teacher_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Section belongs to Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Section Teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'class_teacher_id');
    }

    // One Section -> Many Students
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}