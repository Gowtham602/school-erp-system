<?php




namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassModel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index()
{
    $classes = ClassModel::where('teacher_id', auth()->id())->get();

    return view('teacher.students.index', compact('classes'));
}

    //  ONLY teacher's class students
    public function data()
    {
        $teacherId = auth()->id();
        // dd($teacherId,"Teacher id");

        $students = Student::whereHas('class', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->with('class');
        // dd($students,"Query");

        return DataTables::of($students)
            ->addColumn('class', fn($row) => $row->class->name ?? '-')
            ->addColumn('section', fn($row) => $row->class->section ?? '-')

            ->addColumn('action', function ($row) {
                return '
                    <button data-id="'.$row->id.'" class="btn btn-sm btn-primary editBtn">
                        
                          <i class="bi bi-pencil"></i>
                    </button>

                    <button data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteBtn">
                     <i class="bi bi-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $teacherId = auth()->id();

        $class = ClassModel::where('id', $request->class_id)
            ->where('teacher_id', $teacherId)
            ->first();

        if (!$class) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Student::create([
            ...$request->all(),
            'created_by' => $teacherId
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            ...$request->all(),
            'updated_by' => auth()->id()
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete(); //  soft delete

        return response()->json(['success' => true]);
    }
}