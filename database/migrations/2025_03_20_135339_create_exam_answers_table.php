<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('exam_subjects')->onDelete('cascade');
            $table->integer('question_number');
            $table->char('correct_answer', 1);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('exam_answers');
    }
};
