<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('student.dashboard');
    });
});