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
        'course_id',
        'user_id',
        'password',
        'email',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students', 'student_id', 'course_id');
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