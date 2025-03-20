@extends('layouts.app')

@section('title', 'Resultados da Prova')

@section('content')
<div class="container">
    <h1>Resultados da Prova - {{ $exam->name }}</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome do Aluno</th>
                <th>Acertos</th>
                <th>Total de Questões</th>
                <th>Porcentagem</th>
                @if ($hasMultipleSubjects)
                    <th>Acertos por Matéria</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result['student_name'] }}</td>
                    <td>{{ $result['score'] }}</td>
                    <td>{{ $result['total'] }}</td>
                    <td>
                        @if ($result['total'] > 0)
                            {{ round(($result['score'] / $result['total']) * 100, 2) }}%
                        @else
                            N/A
                        @endif
                    </td>
                    @if ($hasMultipleSubjects)
                        <td>
                            @foreach ($result['subject_results'] as $subject => $score)
                                <strong>{{ $subject }}:</strong> {{ $score }} acertos<br>
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('exams.index') }}" class="btn btn-primary">Voltar para Provas</a>
</div>
@endsection