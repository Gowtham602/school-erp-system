<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        return view('admin.classes.index');
    }

    public function data()
    {
        $classes = ClassModel::with('teacher');

        return datatables()->of($classes)
            ->addColumn('teacher', fn($row) => $row->teacher->name ?? '-')
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('classes.edit', $row->id).'" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
                    <button data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteBtn"> <i class="bi bi-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        //  Only admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'section' => 'required',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        ClassModel::create($request->all());

        return redirect()->route('classes.index');
    }

    public function edit($id)
    {
        // dd($id);
        $class = ClassModel::findOrFail($id);
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);

        $class->update($request->all());

        return redirect()->route('classes.index');
    }

    public function destroy($id)
    {
        ClassModel::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}
