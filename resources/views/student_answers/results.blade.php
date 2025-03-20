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
                <th>Nota Final</th>
                @if ($hasMultipleSubjects)
                    <th>Notas por Matéria</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result['student_name'] }}</td>
                    <td>{{ $result['score'] }}</td>
                    <td>{{ $result['total'] }}</td>
                    <td>{{ $result['nota_final'] }}</td>
                    @if ($hasMultipleSubjects)
                        <td>
                            @foreach ($result['subject_results'] as $subject => $data)
                                <strong>{{ $subject }}:</strong> 
                                {{ $data['acertos'] }} acertos - Nota: {{ $data['nota'] }}<br>
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