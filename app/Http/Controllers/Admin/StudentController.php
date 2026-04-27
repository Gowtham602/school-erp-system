<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassModel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.students.index');
    }

    public function data()
    {
        $students = Student::with('class.teacher');

        return DataTables::of($students)
            ->addColumn('class', fn($row) => $row->class->name ?? '-')
            ->addColumn('section', fn($row) => $row->class->section ?? '-')
            ->addColumn('teacher', fn($row) => $row->class->teacher->name ?? '-')
            ->addColumn('created_by', fn($row) => $row->creator->name ?? '-')

            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('students.edit',$row->id).'" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <button data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteBtn">
                        <i class="bi bi-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $classes = ClassModel::all()->groupBy('name');
        return view('admin.students.create', compact('classes'));
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'father_name' => 'required',
        'mother_name' => 'required',
        'phone' => 'required|digits:10',
        'address' => 'required',
        'gender' => 'required',
        'class_id' => 'required|exists:classes,id'
    ]);

    Student::create([
        ...$request->all(),
        'created_by' => auth()->id()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Student added successfully'
    ]);
}

  public function edit($id)
{
    $student = Student::findOrFail($id);

    $classes = ClassModel::all()->groupBy('name'); 

    return view('admin.students.edit', compact('student','classes'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
            'gender' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);

        $student = Student::findOrFail($id);

        $student->update([
            ...$request->all(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('students.index');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}

