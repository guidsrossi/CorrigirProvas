@extends('layouts.app')

@section('title', 'Criar Nova Prova')

@section('content')
<div class="container">
    <h1>Criar Nova Prova</h1>
    <form action="{{ route('exams.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Prova</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">A prova tem mais de uma matéria?</label>
            <select id="has_multiple_subjects" name="has_multiple_subjects" class="form-control">
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>

        <div id="single-subject-container" class="mb-3">
            <label class="form-label">Nome da Matéria</label>
            <input type="text" class="form-control" name="single_subject_name" placeholder="Matéria da prova">
            
            <label class="form-label mt-2">Quantidade de Questões</label>
            <input type="number" class="form-control" id="single_subject_questions" name="single_subject_questions" placeholder="Quantidade de questões">
        </div>

        <div id="subjects-container" class="mb-3 d-none">
            <label class="form-label">Matérias e Quantidade de Questões</label>
            <div id="subjects-list">
                <div class="input-group mb-2 subject-item">
                    <input type="text" name="subjects[0][name]" class="form-control" placeholder="Nome da Matéria">
                    <input type="number" name="subjects[0][questions_count]" class="form-control subject-questions" placeholder="Quantidade de Questões">
                </div>
            </div>
            <button type="button" id="add-subject" class="btn btn-secondary">Adicionar Matéria</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Nota Total da Prova</label>
            <input type="number" step="0.1" class="form-control" name="total_score" placeholder="Ex: 10" required>
        </div>

        <div id="gabarito-container" class="mb-3 d-none">
            <h3>Gabarito da Prova</h3>
            <div id="gabarito-list"></div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasMultipleSubjects = document.getElementById('has_multiple_subjects');
        const singleSubjectContainer = document.getElementById('single-subject-container');
        const singleSubjectQuestions = document.getElementById('single_subject_questions');
        const subjectsContainer = document.getElementById('subjects-container');
        const subjectsList = document.getElementById('subjects-list');
        const addSubjectButton = document.getElementById('add-subject');
        const gabaritoContainer = document.getElementById('gabarito-container');
        const gabaritoList = document.getElementById('gabarito-list');

        let subjectIndex = 1;

        hasMultipleSubjects.addEventListener('change', function () {
            if (this.value == '1') {
                subjectsContainer.classList.remove('d-none');
                singleSubjectContainer.classList.add('d-none');
            } else {
                subjectsContainer.classList.add('d-none');
                singleSubjectContainer.classList.remove('d-none');
            }
            updateGabarito();
        });

        function updateGabarito() {
            let totalQuestions = 0;

            if (hasMultipleSubjects.value == '1') {
                document.querySelectorAll('.subject-questions').forEach(input => {
                    totalQuestions += parseInt(input.value) || 0;
                });
            } else {
                totalQuestions = parseInt(singleSubjectQuestions.value) || 0;
            }

            gabaritoList.innerHTML = "";
            if (totalQuestions > 0) {
                for (let i = 1; i <= totalQuestions; i++) {
                    let div = document.createElement('div');
                    div.classList.add('mb-2');
                    div.innerHTML = `
                        <label>Questão ${i}:</label>
                        <select name="gabarito[${i}]" class="form-control">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    `;
                    gabaritoList.appendChild(div);
                }
                gabaritoContainer.classList.remove('d-none');
            } else {
                gabaritoContainer.classList.add('d-none');
            }
        }

        singleSubjectQuestions.addEventListener('input', updateGabarito);

        addSubjectButton.addEventListener('click', function () {
            const newSubject = document.createElement('div');
            newSubject.classList.add('input-group', 'mb-2', 'subject-item');
            newSubject.innerHTML = `
                <input type="text" name="subjects[${subjectIndex}][name]" class="form-control" placeholder="Nome da Matéria">
                <input type="number" name="subjects[${subjectIndex}][questions_count]" class="form-control subject-questions" placeholder="Quantidade de Questões">
                <button type="button" class="btn btn-danger remove-subject">X</button>
            `;
            subjectsList.appendChild(newSubject);
            subjectIndex++;

            newSubject.querySelector('.remove-subject').addEventListener('click', function () {
                newSubject.remove();
                updateGabarito();
            });

            newSubject.querySelector('.subject-questions').addEventListener('input', updateGabarito);
        });
    });
</script>
@endsection