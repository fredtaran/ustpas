<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectForCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'code_id',
        'grade',
        'status'
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
