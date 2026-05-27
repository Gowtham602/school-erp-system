<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\ClassModel;
 use App\Models\ClassTeacher;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
   

class StudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */


public function index()
{
    $teacherId = auth()->id();

    $classTeacherIds = ClassTeacher::where(
        'teacher_id',
        $teacherId
    )->pluck('section_id');



    $classes = ClassModel::with('sections')

        ->whereHas('sections', function ($q)
        use ($classTeacherIds) {

            $q->whereIn('id', $classTeacherIds);
        })

        ->get();



    return view(
        'teacher.students.index',
        compact('classes')
    );
}



    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    public function data()
{
    $teacherId = auth()->id();

    $sectionIds = ClassTeacher::where(
        'teacher_id',
        $teacherId
    )->pluck('section_id');



    $students = Student::with([
        'currentAcademic.section.classModel'
    ])

    ->whereHas(
        'currentAcademic',
        function ($q) use ($sectionIds) {

            $q->whereIn(
                'section_id',
                $sectionIds
            );
        }
    );



    return DataTables::of($students)

        ->addColumn('student_name', function ($row) {

            return $row->first_name . ' ' . $row->last_name;
        })

        ->addColumn('class', function ($row) {

            return $row->currentAcademic
                ->section
                ->classModel
                ->name ?? '-';
        })

        ->addColumn('section', function ($row) {

            return $row->currentAcademic
                ->section
                ->name ?? '-';
        })

        ->addColumn('roll_no', function ($row) {

            return $row->currentAcademic
                ->roll_no ?? '-';
        })

        ->addColumn('action', function ($row) {

            return '
                <button
                    data-id="'.$row->id.'"
                    class="btn btn-sm btn-primary editBtn">

                    <i class="bi bi-pencil"></i>

                </button>

                <button
                    data-id="'.$row->id.'"
                    class="btn btn-sm btn-danger deleteBtn">

                    <i class="bi bi-trash"></i>

                </button>
            ';
        })

        ->rawColumns(['action'])

        ->make(true);
}



    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'first_name' => 'required|max:100',

            'phone' => 'required|digits:10',

            'father_name' => 'required',

            'mother_name' => 'required',

            'gender' => 'required',

            'section_id' => 'required|exists:sections,id',

            'address' => 'required'
        ]);



        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CREATE STUDENT
            |--------------------------------------------------------------------------
            */

            $student = Student::create([

                'admission_no' => 'ADM' . rand(1000, 9999),

                'admission_date' => now(),

                'first_name' => $request->first_name,

                'last_name' => $request->last_name,

                'father_name' => $request->father_name,

                'mother_name' => $request->mother_name,

                'phone' => $request->phone,

                'gender' => $request->gender,

                'address' => $request->address,

                'created_by' => auth()->id()
            ]);



            /*
            |--------------------------------------------------------------------------
            | CREATE ACADEMIC
            |--------------------------------------------------------------------------
            */

            StudentAcademic::create([

                'student_id' => $student->id,

                'section_id' => $request->section_id,

                'academic_year' => date('Y') . '-' . (date('Y') + 1),

                'roll_no' => rand(1, 99),

                'status' => 'active'
            ]);



            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Student Created Successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()
            ]);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $student = Student::with('currentAcademic')
            ->findOrFail($id);

        return response()->json($student);
    }



    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $student = Student::with('currentAcademic')
            ->findOrFail($id);



        $request->validate([

            'first_name' => 'required|max:100',

            'phone' => 'required|digits:10',

            'father_name' => 'required',

            'mother_name' => 'required',

            'gender' => 'required',

            'section_id' => 'required|exists:sections,id',

            'address' => 'required'
        ]);



        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE STUDENT
            |--------------------------------------------------------------------------
            */

            $student->update([

                'first_name' => $request->first_name,

                'last_name' => $request->last_name,

                'father_name' => $request->father_name,

                'mother_name' => $request->mother_name,

                'phone' => $request->phone,

                'gender' => $request->gender,

                'address' => $request->address,

                'updated_by' => auth()->id()
            ]);



            /*
            |--------------------------------------------------------------------------
            | UPDATE ACADEMIC
            |--------------------------------------------------------------------------
            */

            if ($student->currentAcademic) {

                $student->currentAcademic->update([

                    'section_id' => $request->section_id
                ]);
            }



            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Student Updated Successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()
            ]);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        return response()->json([

            'success' => true,

            'message' => 'Student Deleted Successfully'
        ]);
    }
}