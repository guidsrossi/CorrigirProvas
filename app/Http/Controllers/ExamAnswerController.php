<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamSubject;

class ExamAnswerController extends Controller {
    public function create($exam_id) {
        $exam = Exam::findOrFail($exam_id);
        return view('exam_answers.create', compact('exam'));
    }

    public function store(Request $request, $exam_id) {
        $exam = Exam::findOrFail($exam_id);

        foreach ($request->answers as $question => $answer) {
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'question_number' => $question,
                'correct_answer' => $answer
            ]);
        }

        return redirect()->route('exams.index');
    }
}