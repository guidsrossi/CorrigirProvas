@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Definir Respostas da Prova - {{ $exam->name }}</h1>
    <form action="{{ route('exam_answers.store', $exam->id) }}" method="POST">
        @csrf
        @for ($i = 1; $i <= 10; $i++)
            <label>Questão {{ $i }}</label>
            <select name="answers[{{ $i }}]" class="form-control">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
        @endfor
        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
    </form>
</div>
@endsection