@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Provas</h1>
    <a href="{{ route('exams.create') }}" class="btn btn-primary">Criar Nova Prova</a>
    <ul class="list-group mt-3">
        @foreach ($exams as $exam)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $exam->name }} 

                <div>
                    <a href="{{ route('student_answers.create', $exam->id) }}" class="btn btn-success btn-sm">Fazer Prova</a>
                    
                    <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault(); // Previne o envio do formulário diretamente

        if (confirm("Tem certeza que deseja excluir esta prova? Esta ação não pode ser desfeita!")) {
            event.target.submit(); // Envia o formulário se o usuário confirmar
        }
    }
</script>
@endsection