<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model {
    use HasFactory;
    protected $fillable = ['exam_id', 'subject_id', 'question_number', 'correct_answer'];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function subject() {
        return $this->belongsTo(ExamSubject::class);
    }
}