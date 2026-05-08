<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {

    $table->id();

    /*
    |--------------------------------------------------------------------------
    | Academic Details
    |--------------------------------------------------------------------------
    */

    // Unique Admission Number
    $table->string('admission_no')->unique();

    // Roll Number
    $table->string('roll_no')->nullable();

    // Student belongs to Section
    $table->foreignId('section_id')
        ->constrained('sections')
        ->cascadeOnDelete();

    // Admission Date
    $table->date('admission_date')->nullable();

    // Student Status
    $table->enum('status', [
        'active',
        'inactive'
    ])->default('active');


    /*
    |--------------------------------------------------------------------------
    | Student Personal Details
    |--------------------------------------------------------------------------
    */

    // First Name
    $table->string('first_name');

    // Last Name
    $table->string('last_name')->nullable();

    // Date of Birth
    $table->date('dob')->nullable();

    // Gender
    $table->enum('gender', [
        'male',
        'female',
        'other'
    ]);

    // Blood Group
    $table->string('blood_group')->nullable();

    // Student Photo
    $table->string('photo')->nullable();


    /*
    |--------------------------------------------------------------------------
    | Parent Details
    |--------------------------------------------------------------------------
    */

    // Father Name
    $table->string('father_name');

    // Mother Name
    $table->string('mother_name');

    // Guardian Phone
    $table->string('guardian_phone', 15)->nullable();


    /*
    |--------------------------------------------------------------------------
    | Contact Details
    |--------------------------------------------------------------------------
    */

    // Student Mobile
    $table->string('phone', 15);

    // Email
    $table->string('email')->nullable();

    // Address
    $table->text('address');


    /*
    |--------------------------------------------------------------------------
    | Extra ERP Details
    |--------------------------------------------------------------------------
    */

    // Religion
    $table->string('religion')->nullable();

    // Nationality
    $table->string('nationality')->nullable();

    // Aadhaar Number
    $table->string('aadhaar_no')->nullable();

    // Transport Route
    $table->string('transport_route')->nullable();


    /*
    |--------------------------------------------------------------------------
    | Audit Details
    |--------------------------------------------------------------------------
    */

    // Created By
    $table->foreignId('created_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    // Updated By
    $table->foreignId('updated_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();


    $table->timestamps();

    $table->softDeletes();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};