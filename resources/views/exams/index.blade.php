@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Provas</h1>
    <a href="{{ route('exams.create') }}" class="btn btn-primary">Criar Nova Prova</a>
    <ul class="list-group mt-3">
        @foreach ($exams as $exam)
            <li class="list-group-item">
                {{ $exam->name }} 
                <a href="{{ route('student_answers.create', $exam->id) }}" class="btn btn-success btn-sm float-end">Fazer Prova</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection