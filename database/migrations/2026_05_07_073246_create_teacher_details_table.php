<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('employee_id')->unique();

            $table->string('phone',15);

            $table->string('alternate_phone',15)->nullable();

            $table->enum('gender',[
                'male',
                'female',
                'other'
            ]);

            $table->date('dob')->nullable();

            $table->string('qualification');

            $table->string('experience')->nullable();

            $table->date('joining_date');

            $table->decimal('salary',10,2)->nullable();

            $table->string('blood_group')->nullable();

            $table->string('aadhaar_no')->nullable();

            $table->text('address');

            $table->string('city')->nullable();

            $table->string('state')->nullable();

            $table->string('pincode')->nullable();

            $table->string('photo')->nullable();

            $table->enum('status',[
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_details');
    }
};