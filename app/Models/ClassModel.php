<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name'
    ];

   

    // One Class -> Many Sections
      public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    // One Class -> Many Subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }
}