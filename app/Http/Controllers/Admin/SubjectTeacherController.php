<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Section;
use App\Models\User;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;

class SubjectTeacherController extends Controller
{
    public function index()
    {
        $subjectTeachers = SubjectTeacher::with([
            'subject',
            'section.classModel',
            'teacher'
        ])->latest()->get();

        return view(
            'admin.subject_teacher.index',
            compact('subjectTeachers')
        );
    }



    public function create()
    {
        $classes = ClassModel::latest()->get();

        $teachers = User::where(
            'role',
            'teacher'
        )->get();

        return view(
            'admin.subject_teacher.create',
            compact(
                'classes',
                'teachers'
            )
        );
    }



    public function store(Request $request)
    {
        $request->validate([

            'subject_id' => 'required',

            'section_id' => 'required',

            'teacher_id' => 'required',

        ]);


        SubjectTeacher::create([

            'subject_id' => $request->subject_id,

            'section_id' => $request->section_id,

            'teacher_id' => $request->teacher_id,

        ]);


        return redirect()
                ->route('subject-teacher.index')
                ->with(
                    'success',
                    'Assigned Successfully'
                );
    }




    public function edit($id)
    {
        $subjectTeacher = SubjectTeacher::findOrFail($id);

        $classes = ClassModel::latest()->get();

        $teachers = User::where(
            'role',
            'teacher'
        )->get();

        return view(
            'admin.subject_teacher.edit',
            compact(
                'subjectTeacher',
                'classes',
                'teachers'
            )
        );
    }




    public function update(Request $request, $id)
    {
        $request->validate([

            'subject_id' => 'required',

            'section_id' => 'required',

            'teacher_id' => 'required',

        ]);


        $subjectTeacher = SubjectTeacher::findOrFail($id);

        $subjectTeacher->update([

            'subject_id' => $request->subject_id,

            'section_id' => $request->section_id,

            'teacher_id' => $request->teacher_id,

        ]);


        return redirect()
                ->route('subject-teacher.index')
                ->with(
                    'success',
                    'Updated Successfully'
                );
    }




    public function destroy($id)
    {
        SubjectTeacher::findOrFail($id)->delete();

        return redirect()
                ->route('subject-teacher.index')
                ->with(
                    'success',
                    'Deleted Successfully'
                );
    }




    public function getSubjects($class_id)
    {
        $subjects = Subject::where(
            'class_id',
            $class_id
        )->get();

        return response()->json($subjects);
    }




    public function getSections($class_id)
    {
        $sections = Section::where(
            'class_id',
            $class_id
        )->get();

        return response()->json($sections);
    }
}