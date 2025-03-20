<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\StudentAnswer;
use App\Models\ExamAnswer;
use App\Models\ExamSubject;

class StudentAnswerController extends Controller {
    public function create($exam_id) {
        $exam = Exam::findOrFail($exam_id);
        
        // Pegando a quantidade total de questões na prova
        if ($exam->has_multiple_subjects) {
            $totalQuestions = ExamSubject::where('exam_id', $exam_id)->sum('questions_count');
        } else {
            $totalQuestions = ExamSubject::where('exam_id', $exam_id)->value('questions_count');
        }

        return view('student_answers.create', compact('exam', 'totalQuestions'));
    }

    public function store(Request $request, $exam_id) {
        $exam = Exam::findOrFail($exam_id);
        
        foreach ($request->answers as $question => $answer) {
            StudentAnswer::create([
                'exam_id' => $exam->id,
                'student_name' => $request->student_name,
                'question_number' => $question,
                'marked_answer' => $answer
            ]);
        }

        return redirect()->route('student_answers.results', $exam_id);
    }

    public function results($exam_id) {
        $exam = Exam::findOrFail($exam_id);
    
        $students = StudentAnswer::select('student_name')
            ->where('exam_id', $exam_id)
            ->groupBy('student_name')
            ->get();
    
        $correctAnswers = ExamAnswer::where('exam_id', $exam_id)->get();
        $totalQuestions = $correctAnswers->count();
        $subjects = ExamSubject::where('exam_id', $exam_id)->get();
        $hasMultipleSubjects = $exam->has_multiple_subjects;
    
        $results = [];
    
        foreach ($students as $student) {
            $studentAnswers = StudentAnswer::where('exam_id', $exam_id)
                ->where('student_name', $student->student_name)
                ->get();
    
            $score = 0;
            $subjectScores = [];
    
            foreach ($studentAnswers as $studentAnswer) {
                $correct = $correctAnswers->where('question_number', $studentAnswer->question_number)->first();
    
                if ($correct && $correct->correct_answer === $studentAnswer->marked_answer) {
                    $score++;
                    if ($hasMultipleSubjects) {
                        $subjectId = $correct->subject_id;
                        if (!isset($subjectScores[$subjectId])) {
                            $subjectScores[$subjectId] = 0;
                        }
                        $subjectScores[$subjectId]++;
                    }
                }
            }
    
            $subjectResults = [];
            if ($hasMultipleSubjects) {
                foreach ($subjects as $subject) {
                    $subjectResults[$subject->subject_name] = $subjectScores[$subject->id] ?? 0;
                }
            }
    
            $results[] = [
                'student_name' => $student->student_name,
                'score' => $score,
                'total' => $totalQuestions,
                'subject_results' => $subjectResults
            ];
        }
    
        return view('student_answers.results', compact('exam', 'results', 'hasMultipleSubjects'));
    }      
}