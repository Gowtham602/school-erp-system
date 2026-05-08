<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.students.index');
    }

    public function data()
    {
        $students = Student::with('section.class');

        return DataTables::of($students)

            ->addColumn('student_name', function ($row) {

                return $row->first_name;
            })

            ->addColumn('class', function ($row) {

                return $row->section->class->name ?? '-';
            })

            ->addColumn('section', function ($row) {

                return $row->section->name ?? '-';
            })
             ->addColumn('teacher', function ($row) {

            return $row->section->teacher->name ?? '-';
        })

            ->addColumn('action', function ($row) {

                return '
                 <a href="'.route('students.show',$row->id).'"
                        class="btn btn-info btn-sm">

                        <i class="bi bi-eye"></i>

                    </a>

                    <a href="'.route('students.edit',$row->id).'"
                        class="btn btn-primary btn-sm">

                        <i class="bi bi-pencil"></i>

                    </a>

                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-id="'.$row->id.'">

                        <i class="bi bi-trash"></i>

                    </button>
                ';
            })

            ->rawColumns(['action'])

            ->make(true);
    }

    public function create()
    {
        $sections = Section::with('class')->get();

        return view(
            'admin.students.create',
            compact('sections')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'admission_no' => 'required|unique:students',

            'section_id' => 'required|exists:sections,id',

            'first_name' => 'required|string|max:100',

            'phone' => 'required|digits:10',

            'father_name' => 'required',

            'mother_name' => 'required',

            'gender' => 'required',

            'address' => 'required'
        ]);


        Student::create([

            ...$request->all(),

            'created_by' => auth()->id()
        ]);


        return response()->json([

            'success' => true,

            'message' => 'Student Added Successfully'
        ]);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        $sections = Section::with('class')->get();

        return view(
            'admin.students.edit',
            compact('student', 'sections')
        );
    }

   public function update(Request $request, $id)
    {
    $request->validate([

        'admission_no' =>
            'required|unique:students,admission_no,'.$id,

        'section_id' =>
            'required|exists:sections,id',

        'first_name' =>
            'required|string|max:100',

        'phone' =>
            'required|digits:10',

        'email' =>
            'nullable|email',

        'father_name' =>
            'required',

        'mother_name' =>
            'required',

        'gender' =>
            'required',

        'address' =>
            'required'
    ]);


    $student = Student::findOrFail($id);

    $student->update([

        ...$request->all(),

        'updated_by' => auth()->id()
    ]);


    return response()->json([

        'success' => true,

        'message' => 'Student Updated Successfully'
    ]);
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();

        return response()->json([

            'success' => true
        ]);
    }

    public function show($id)
    {
        $student = Student::with(['section.class','section.teacher' ])->findOrFail($id);

        return view('admin.students.show', compact('student'));
    }

}