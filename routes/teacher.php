<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\StudentController;

Route::middleware(['auth', 'role:teacher'])

    ->prefix('teacher')

    ->name('teacher.')

    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | SUBJECTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/subjects',
            [DashboardController::class, 'teacherSubjects']
        )->name('subjects');



        /*
        |--------------------------------------------------------------------------
        | STUDENTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/students',
            [StudentController::class, 'index']
        )->name('students.index');



        Route::get(
            '/students-data',
            [StudentController::class, 'data']
        )->name('students.data');



        Route::post(
            '/students/store',
            [StudentController::class, 'store']
        )->name('students.store');



        Route::get(
            '/students/{id}/edit',
            [StudentController::class, 'edit']
        )->name('students.edit');



        Route::put(
            '/students/{id}',
            [StudentController::class, 'update']
        )->name('students.update');



        Route::delete(
            '/students/{id}',
            [StudentController::class, 'destroy']
        )->name('students.delete');
    });