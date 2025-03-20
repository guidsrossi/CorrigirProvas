<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('exams', function (Blueprint $table) {
            $table->decimal('total_score', 5, 2)->default(10)->after('has_multiple_subjects'); // Nota da prova
        });
    }

    public function down() {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('total_score');
        });
    }
};