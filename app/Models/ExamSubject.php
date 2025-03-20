<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model {
    use HasFactory;
    protected $fillable = ['exam_id', 'subject_name', 'questions_count'];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}