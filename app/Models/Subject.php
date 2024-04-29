<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_description',
        'unit',
        'course_id',
        'chairperson_id'
    ];

    public function course() {
        return $this->hasMany(Course::class, 'id', 'course_id');
    }

    public function subjectForCredit() {
        return $this->hasMany(SubjectForCredit::class, 'subject_id', 'id');
    }

    public function chairperson() {
        return $this->hasMany(User::class, 'id', 'chairperson_id');
    }
}
