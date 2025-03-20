<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model {
    use HasFactory;
    protected $fillable = ['exam_id', 'student_name', 'question_number', 'marked_answer'];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}