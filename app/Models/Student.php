<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contact',
        'degree_id',
        'user_id',
        'password',
        'email',
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }
    
    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }
}