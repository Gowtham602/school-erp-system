<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassTeacher;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ClassTeacherController extends Controller
{
    // INDEX

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $classTeachers = ClassTeacher::with([
                'classModel',
                'section',
                'teacher'
            ])->latest();

            return DataTables::of($classTeachers)

                ->addIndexColumn()

                ->addColumn('class_name', function ($row) {
                    return $row->classModel->name ?? '-';
                })

                ->addColumn('section_name', function ($row) {
                    return $row->section->name ?? '-';
                })

                ->addColumn('teacher_name', function ($row) {
                    return $row->teacher->name ?? '-';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button
                            class="btn btn-warning btn-sm editBtn"
                            data-id="'.$row->id.'">
                            Edit
                        </button>

                        <button
                            class="btn btn-danger btn-sm deleteBtn"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        $classes = ClassModel::all();

        $teachers = User::where('role', 'teacher')->get();

        return view(
            'admin.class-teachers.index',
            compact('classes', 'teachers')
        );
    }

    // GET SECTIONS

    public function getSections($classId)
    {
        $sections = Section::where(
            'class_id',
            $classId
        )->get();

        return response()->json($sections);
    }

    // STORE

    public function store(Request $request)
    {
        $request->validate([

            'class_id' => 'required',

            'section_id' => [
                'required',

                Rule::unique('class_teachers')
                    ->where(function ($query) use ($request) {

                        return $query
                            ->where('class_id', $request->class_id)
                            ->where('section_id', $request->section_id);
                    })
            ],

            'teacher_id' => 'required'
        ]);

        ClassTeacher::create([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'teacher_id' => $request->teacher_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Class Teacher Added Successfully'
        ]);
    }

    // EDIT

    public function edit($id)
    {
        $classTeacher = ClassTeacher::findOrFail($id);

        $sections = Section::where(
            'class_id',
            $classTeacher->class_id
        )->get();

        return response()->json([
            'classTeacher' => $classTeacher,
            'sections' => $sections
        ]);
    }

    // UPDATE

    public function update(Request $request, $id)
    {
        $request->validate([

            'class_id' => 'required',

            'section_id' => [

                'required',

                Rule::unique('class_teachers')
                    ->ignore($id)
                    ->where(function ($query) use ($request) {

                        return $query
                            ->where('class_id', $request->class_id)
                            ->where('section_id', $request->section_id);
                    })
            ],

            'teacher_id' => 'required'
        ]);

        $classTeacher = ClassTeacher::findOrFail($id);

        $classTeacher->update([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'teacher_id' => $request->teacher_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Class Teacher Updated Successfully'
        ]);
    }

    // DELETE

    public function destroy($id)
    {
        ClassTeacher::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }
}

