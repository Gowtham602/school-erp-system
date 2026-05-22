<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // OLD SECTION
            $table->foreignId('from_section_id')
                ->constrained('sections')
                ->cascadeOnDelete();

            // NEW SECTION
            $table->foreignId('to_section_id')
                ->constrained('sections')
                ->cascadeOnDelete();

            $table->string('academic_year');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_histories');
    }
};