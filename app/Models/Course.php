<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'chairperson_id'
    ];

    public function chairperson() {
        return $this->hasMany(User::class, 'id', 'chairperson_id');
    }

    public function subject() {
        return $this->hasMany(Subject::class, 'course_id', 'id');
    }
}
