<?php

namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\StudentHistory;
use DB;

class PromotionController extends Controller
{
    // public function index()
    // {
    //     $classes = ClassModel::all();
    //     return view('admin.promotion.index', compact('classes'));
    // }
    public function index()
{
    $classes = ClassModel::all();

    $histories = StudentHistory::with('student', 'class')
        ->latest()
        ->limit(10) // show recent 10
        ->get();

    return view('admin.promotion.index', compact('classes','histories'));
}

    public function promote(Request $request)
    {
        $request->validate([
            'from_class' => 'required',
            'to_class'   => 'required|different:from_class',
        ]);

        $fromClass = $request->from_class;
        $toClass   = $request->to_class;

        $year = now()->year . '-' . (now()->year + 1);

        DB::transaction(function () use ($fromClass, $toClass, $year) {

            $students = Student::where('class_id', $fromClass)->get();

            foreach ($students as $student) {

                //  Save OLD class
                StudentHistory::create([
                    'student_id' => $student->id,
                    'class_id' => $student->class_id,
                    'academic_year' => $year,
                ]);

                //  Update NEW class
                $student->update([
                    'class_id' => $toClass
                ]);
            }
        });

        return back()->with('success', 'Students promoted successfully with history saved');
    }
}
