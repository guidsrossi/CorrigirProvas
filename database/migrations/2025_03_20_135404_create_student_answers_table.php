<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->string('student_name');
            $table->integer('question_number');
            $table->char('marked_answer', 1);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('student_answers');
    }
};
