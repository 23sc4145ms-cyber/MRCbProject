<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'units'
    ];
    
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
                    ->withTimestamps();
    }
}
