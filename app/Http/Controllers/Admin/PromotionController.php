<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\StudentAcademic;
use App\Models\StudentHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    // public function index()
    // {
        
    //     $classes = ClassModel::with('sections')->get();

    //    $histories = StudentHistory::with([

    //     'student',
    //     'fromSection.classModel',
    //     'toSection.classModel'

    // ])
    // ->latest()
    // ->paginate(10);

    //     return view(
    //         'admin.promotion.index',
    //         compact('classes', 'histories')
    //     );
    // }


    // /*
    // |--------------------------------------------------------------------------
    // | FETCH STUDENTS
    // |--------------------------------------------------------------------------
    // */

    // public function getStudents(Request $request)
    // {
    //     $request->validate([

    //         'from_section' =>
    //             'required|exists:sections,id',

    //         'academic_year' =>
    //             'required',
    //     ]);


    //     $students = StudentAcademic::with([

    //             'student',
    //             'section'

    //         ])
    //         ->where(
    //             'section_id',
    //             $request->from_section
    //         )
    //         ->where(
    //             'academic_year',
    //             $request->academic_year
    //         )
    //         ->where(
    //             'status',
    //             'studying'
    //         )
    //         ->get();


    //     if ($students->isEmpty()) {

    //         return response()->json([

    //             'status' => false,

    //             'message' =>
    //                 'No students found'
    //         ]);
    //     }


    //     return response()->json([

    //         'status' => true,

    //         'students' => $students
    //     ]);
    // }



    // /*
    // |--------------------------------------------------------------------------
    // | PROMOTE STUDENTS
    // |--------------------------------------------------------------------------
    // */

    // public function promote(Request $request)
    // {
    //     $request->validate([

    //         'from_section' =>
    //             'required|exists:sections,id',

    //         'to_section' =>
    //             'required|exists:sections,id|different:from_section',

    //         'academic_year' =>
    //             'required',

    //         'new_academic_year' =>
    //             'required|different:academic_year',

    //         'students' =>
    //             'required|array',

    //         'students.*' =>
    //             'exists:student_academics,id',
    //     ]);


    //     DB::beginTransaction();

    //     try {

    //         $academics = StudentAcademic::whereIn(
    //                 'id',
    //                 $request->students
    //             )
    //             ->where(
    //                 'status',
    //                 'studying'
    //             )
    //             ->get();


    //         if ($academics->isEmpty()) {

    //             return back()->with(

    //                 'error',
    //                 'No students selected'
    //             );
    //         }


    //         foreach ($academics as $academic) {

    //             /*
    //             |--------------------------------------------------------------------------
    //             | CHECK ALREADY PROMOTED
    //             |--------------------------------------------------------------------------
    //             */

    //             $alreadyPromoted = StudentAcademic::where(

    //                     'student_id',
    //                     $academic->student_id

    //                 )
    //                 ->where(

    //                     'academic_year',
    //                     $request->new_academic_year

    //                 )
    //                 ->exists();


    //             if ($alreadyPromoted) {

    //                 continue;
    //             }


    //             /*
    //             |--------------------------------------------------------------------------
    //             | UPDATE OLD RECORD
    //             |--------------------------------------------------------------------------
    //             */

    //             $academic->update([

    //                 'status' => 'promoted'
    //             ]);


    //             /*
    //             |--------------------------------------------------------------------------
    //             | CREATE NEW ACADEMIC
    //             |--------------------------------------------------------------------------
    //             */

    //             StudentAcademic::create([

    //                 'student_id' =>
    //                     $academic->student_id,

    //                 'section_id' =>
    //                     $request->to_section,

    //                 'academic_year' =>
    //                     $request->new_academic_year,

    //                 'roll_no' => null,

    //                 'status' => 'studying'
    //             ]);


    //             /*
    //             |--------------------------------------------------------------------------
    //             | SAVE HISTORY
    //             |--------------------------------------------------------------------------
    //             */

    //             StudentHistory::create([

    //                 'student_id' =>
    //                     $academic->student_id,

    //                 'from_section_id' =>
    //                     $request->from_section,

    //                 'to_section_id' =>
    //                     $request->to_section,

    //                 'academic_year' =>
    //                     $request->new_academic_year,
    //             ]);
    //         }


    //         DB::commit();

    //         return back()->with(

    //             'success',
    //             'Students promoted successfully'
    //         );

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         Log::error($e);

    //         return back()->with(

    //             'error',
    //             'Something went wrong'
    //         );
    //     }
    // }
}