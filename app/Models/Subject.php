<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'class_id'
    ];


    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }


    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'subject_teachers',
            'subject_id',
            'teacher_id'
        );
    }
}