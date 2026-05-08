<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherDetail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::with('teacherDetail')
            ->where('role', 'teacher')
            ->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:100',

            'email' => 'required|email|unique:users',

            'employee_id' =>
            'required|unique:teacher_details',

            'phone' =>
            'required|digits:10',

            'gender' =>
            'required',

            'qualification' =>
            'required',

            'joining_date' =>
            'required',

            'address' =>
            'required'
        ]);


        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => bcrypt('Teacher@123'),

            'role' => 'teacher'
        ]);


        TeacherDetail::create([

            'user_id' => $user->id,

            'employee_id' => $request->employee_id,

            'phone' => $request->phone,

            'alternate_phone' =>
            $request->alternate_phone,

            'gender' => $request->gender,

            'dob' => $request->dob,

            'qualification' =>
            $request->qualification,

            'experience' =>
            $request->experience,

            'joining_date' =>
            $request->joining_date,

            'salary' =>
            $request->salary,

            'blood_group' =>
            $request->blood_group,

            'aadhaar_no' =>
            $request->aadhaar_no,

            'address' =>
            $request->address,

            'city' =>
            $request->city,

            'state' =>
            $request->state,

            'pincode' =>
            $request->pincode,
        ]);


        return response()->json([

            'success' => true,

            'message' =>
            'Teacher Created Successfully'
        ]);
    }

    // TeacherController.php

   public function edit($id)
{
    $teacher = TeacherDetail::with('user')
        ->findOrFail($id);

    return view(
        'admin.teachers.edit',
        compact('teacher')
    );
}



    public function update(Request $request, $id)
    {
        $teacher = TeacherDetail::with('user')
            ->findOrFail($id);

        $request->validate([

            'name' => 'required',

            'email' =>
            'required|email|unique:users,email,' . $teacher->user->id,

            'phone' =>
            'required|digits:10',
        ]);


        $teacher->user->update([

            'name' => $request->name,

            'email' => $request->email,
        ]);


        $teacher->update([

            'phone' => $request->phone,
        ]);


        return response()->json([

            'message' => 'Teacher Updated Successfully'
        ]);
    }




   public function destroy($id)
{
    $teacher = TeacherDetail::with('user')
        ->findOrFail($id);

    // soft delete user
    if ($teacher->user) {

        $teacher->user->delete();
    }

    // soft delete teacher detail
    $teacher->delete();

    return response()->json([

        'success' => true,

        'message' => 'Teacher Deleted Successfully'
    ]);
}

    // public function data()
    // {
    //     $teachers = User::with('teacherDetail')
    //         ->where('role', 'teacher');

    //     return DataTables::of($teachers)
    //         ->addColumn('phone', function ($row) {
    //             return $row->teacherDetail->phone ?? '';
    //         })
    //         ->addColumn('qualification', function ($row) {
    //             return $row->teacherDetail->qualification ?? '';
    //         })
    //         ->addColumn('action', function ($row) {
    //             return '
    //                 <form method="POST" action="'.route('teachers.delete',$row->id).'">
    //                     '.csrf_field().method_field("DELETE").'
    //                     <button class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i></button>
    //                 </form>
    //             ';
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }


    // public function data()
    // {

    //  $type = $request->type ?? 'active';
    //     $teachers = User::with('teacherDetail')
    //         ->where('role', 'teacher');
    //  if ($type == 'deleted') {
    //         $query = $query->onlyTrashed(); // key line
    //     }
    //     return DataTables::of($teachers)
    //         ->addColumn('phone', function ($row) {
    //             return $row->teacherDetail->phone ?? '';
    //         })
    //         ->addColumn('qualification', function ($row) {
    //             return $row->teacherDetail->qualification ?? '';
    //         })
    //         ->addColumn('action', function ($row) {
    //             return $row->id; 
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }
 // TeacherController.php

public function data(Request $request)
{
    $type = $request->type ?? 'active';

    $query = TeacherDetail::with('user');

    if ($type == 'deleted') {

        $query = $query->onlyTrashed();

    } else {

        $query = $query->whereNull('deleted_at');
    }

    return DataTables::of($query)

        ->addColumn('name', function ($row) {

            return optional($row->user)->name;
        })

        ->addColumn('email', function ($row) {

            return optional($row->user)->email;
        })

        ->addColumn('phone', function ($row) {

            return $row->phone;
        })

        ->addColumn('qualification', function ($row) {

            return $row->qualification;
        })

        ->addColumn('status', function ($row) {

            return $row->status;
        })

        ->addColumn('id', function ($row) {

            // IMPORTANT
            return $row->id;
        })

        ->make(true);
}
   public function restore($id)
{
    $teacher = TeacherDetail::withTrashed()
        ->with('user')
        ->findOrFail($id);

    // restore teacher
    $teacher->restore();

    // restore user
    if ($teacher->user()->withTrashed()->first()) {

        $teacher->user()->withTrashed()->restore();
    }

    return response()->json([

        'success' => true,

        'message' => 'Teacher Restored Successfully'
    ]);
}

    public function mySubjects()
    {
        $teacherId = auth()->id();

        $subjects = Subject::with('class')
            ->whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('users.id', $teacherId);
            })
            ->get();

        return view('teacher.subjects', compact('subjects'));
    }
}
