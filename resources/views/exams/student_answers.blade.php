@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultados - {{ $exam->name }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Acertos</th>
                <th>Total de Questões</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result['student_name'] }}</td>
                    <td>{{ $result['score'] }}</td>
                    <td>{{ $result['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection