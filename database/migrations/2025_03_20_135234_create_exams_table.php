<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('has_multiple_subjects');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('exams');
    }
};
