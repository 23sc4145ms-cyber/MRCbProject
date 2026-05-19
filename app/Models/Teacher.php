<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'contact',
        'user_id',
    ];

    /**
     * Get the user account associated with the teacher.
     */
    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }
}
