<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\StudentAnswer;
use App\Models\ExamAnswer;

class ExamController extends Controller {
    public function index() {
        $exams = Exam::all();
        return view('exams.index', compact('exams'));
    }

    public function create() {
        return view('exams.create');
    }

    public function destroy($id) {
        $exam = Exam::findOrFail($id);
    
        // Excluir matérias relacionadas
        ExamSubject::where('exam_id', $id)->delete();
    
        // Excluir gabarito da prova
        ExamAnswer::where('exam_id', $id)->delete();
    
        // Excluir respostas dos alunos
        StudentAnswer::where('exam_id', $id)->delete();
    
        // Excluir a prova
        $exam->delete();
    
        return redirect()->route('exams.index')->with('success', 'Prova excluída com sucesso.');
    }
    

    public function store(Request $request) {
        $exam = Exam::create([
            'name' => $request->name,
            'has_multiple_subjects' => $request->has_multiple_subjects ? true : false,
            'total_score' => $request->total_score
        ]);
    
        $totalQuestions = 0;
        $subjectIndex = 0;
        $subjectBoundaries = [];
    
        if ($exam->has_multiple_subjects && isset($request->subjects)) {
            foreach ($request->subjects as $subject) {
                $subjectModel = ExamSubject::create([
                    'exam_id' => $exam->id,
                    'subject_name' => $subject['name'],
                    'questions_count' => $subject['questions_count']
                ]);
    
                $subjectBoundaries[] = [
                    'subject_id' => $subjectModel->id,
                    'start' => $totalQuestions + 1,
                    'end' => $totalQuestions + $subject['questions_count']
                ];
    
                $totalQuestions += $subject['questions_count'];
            }
        } else {
            $subjectModel = ExamSubject::create([
                'exam_id' => $exam->id,
                'subject_name' => $request->single_subject_name,
                'questions_count' => $request->single_subject_questions
            ]);
    
            $subjectBoundaries[] = [
                'subject_id' => $subjectModel->id,
                'start' => 1,
                'end' => $request->single_subject_questions
            ];
    
            $totalQuestions = $request->single_subject_questions;
        }
    
        // Associar as questões ao gabarito respeitando os limites de matéria
        for ($i = 1; $i <= $totalQuestions; $i++) {
            $subjectId = null;
    
            foreach ($subjectBoundaries as $boundary) {
                if ($i >= $boundary['start'] && $i <= $boundary['end']) {
                    $subjectId = $boundary['subject_id'];
                    break;
                }
            }
    
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'subject_id' => $subjectId,
                'question_number' => $i,
                'correct_answer' => $request->gabarito[$i] ?? 'A'
            ]);
        }
    
        return redirect()->route('exams.index');
    }    
}