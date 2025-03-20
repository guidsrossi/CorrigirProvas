@extends('layouts.app')

@section('title', 'Responder Prova')

@section('content')
<div class="container">
    <h1>Responder Prova - {{ $exam->name }}</h1>

    <form action="{{ route('student_answers.store', $exam->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_name" class="form-label">Nome do Aluno</label>
            <input type="text" class="form-control" id="student_name" name="student_name" required>
        </div>

        <h3>Responda as questões:</h3>
        @for ($i = 1; $i <= $totalQuestions; $i++)
            <div class="mb-3">
                <label class="form-label">Questão {{ $i }}</label>
                <select name="answers[{{ $i }}]" class="form-control" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
        @endfor

        <button type="submit" class="btn btn-success">Enviar Respostas</button>
    </form>
</div>
@endsection