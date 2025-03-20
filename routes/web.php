<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamAnswerController;
use App\Http\Controllers\StudentAnswerController;

Route::resource('exams', ExamController::class);
Route::get('exam/{exam_id}/answers', [ExamAnswerController::class, 'create'])->name('exam_answers.create');
Route::post('exam/{exam_id}/answers', [ExamAnswerController::class, 'store'])->name('exam_answers.store');

Route::get('exam/{exam_id}/student', [StudentAnswerController::class, 'create'])->name('student_answers.create');
Route::post('exam/{exam_id}/student', [StudentAnswerController::class, 'store'])->name('student_answers.store');
Route::get('exam/{exam_id}/results', [StudentAnswerController::class, 'results'])->name('student_answers.results');