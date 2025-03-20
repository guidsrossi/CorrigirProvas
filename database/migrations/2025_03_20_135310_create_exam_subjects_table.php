<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('exam_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->string('subject_name');
            $table->integer('questions_count');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('exam_subjects');
    }
};
