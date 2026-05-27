<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use App\Models\Student;
use App\Models\SubjectTeacher;
use App\Models\ClassTeacher;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    
    public function index()
    {
        $teacherId = auth()->id();



        /*
        |--------------------------------------------------------------------------
        | CLASS TEACHER DATA
        |--------------------------------------------------------------------------
        */

        $classTeachers = ClassTeacher::with([

            'classModel',
            'section'

        ])

        ->where(
            'teacher_id',
            $teacherId
        )

        ->get();



        /*
        |--------------------------------------------------------------------------
        | SECTION IDS
        |--------------------------------------------------------------------------
        */

        $sectionIds = $classTeachers
            ->pluck('section_id');



        /*
        |--------------------------------------------------------------------------
        | TOTAL STUDENTS
        |--------------------------------------------------------------------------
        */

        $studentsCount = Student::whereHas(

            'currentAcademic',

            function ($q) use ($sectionIds) {

                $q->whereIn(
                    'section_id',
                    $sectionIds
                );
            }

        )->count();



        /*
        |--------------------------------------------------------------------------
        | TOTAL SUBJECTS
        |--------------------------------------------------------------------------
        */

        $subjectsCount = SubjectTeacher::where(

            'teacher_id',
            $teacherId

        )->count();



        /*
        |--------------------------------------------------------------------------
        | TOTAL SECTIONS
        |--------------------------------------------------------------------------
        */

        $sectionsCount = $sectionIds->count();



        return view(

            'teacher.dashboard',

            compact(

                'studentsCount',
                'subjectsCount',
                'sectionsCount',
                'classTeachers'
            )
        );
    }

    public function teacherSubjects()
    {
        $subjects = SubjectTeacher::with([

            'subject.classModel',

            'section'

        ])

        ->where(
            'teacher_id',
            auth()->id()
        )

        ->latest()

        ->get();   



        return view(
            'teacher.subjects.index',
            compact('subjects')
        );
    }
}