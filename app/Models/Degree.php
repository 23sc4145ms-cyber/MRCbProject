<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
    
    // One-to-many: A degree has many students
    public function students()
    {
        return $this->hasMany(Student::class, 'degree_id');
    }
}
