<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model {
    use HasFactory;
    protected $fillable = ['name', 'has_multiple_subjects'];

    public function subjects() {
        return $this->hasMany(ExamSubject::class);
    }

    public function answers() {
        return $this->hasMany(ExamAnswer::class);
    }
}