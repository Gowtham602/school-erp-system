<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\ClassModel;
use App\Models\User;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index');
    }

    public function data()
    {
        $sections = Section::with(['class', 'teacher']);

        return datatables()->of($sections)

            ->addColumn('class_name', function ($row) {
                return $row->class->name ?? '-';
            })

            ->addColumn('teacher', function ($row) {
                return $row->teacher->name ?? '-';
            })

            ->addColumn('action', function ($row) {

                return '
                    <a href="'.route('sections.edit', $row->id).'"
                        class="btn btn-primary btn-sm">

                        <i class="bi bi-pencil"></i>
                    </a>

                    <button data-id="'.$row->id.'"
                        class="btn btn-danger btn-sm deleteBtn">

                        <i class="bi bi-trash"></i>
                    </button>
                ';
            })

            ->rawColumns(['action'])

            ->make(true);
    }

    public function create()
    {
        $classes = ClassModel::orderBy('name')->get();

        $teachers = User::where('role', 'teacher')
                        ->orderBy('name')
                        ->get();

        return view(
            'admin.sections.create',
            compact('classes', 'teachers')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'class_id' => 'required|exists:classes,id',

            'name' => 'required|max:10',

            'class_teacher_id' => 'nullable|exists:users,id',
        ]);


        // DUPLICATE CHECK
        $exists = Section::where('class_id', $request->class_id)
                    ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                    ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'This section already exists for selected class.'
                ]);
        }


        Section::create([

            'class_id' => $request->class_id,

            'name' => strtoupper($request->name),

            'class_teacher_id' => $request->class_teacher_id
        ]);


        return redirect()
            ->route('sections.index')
            ->with('success', 'Section created successfully');
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);

        $classes = ClassModel::orderBy('name')->get();

        $teachers = User::where('role', 'teacher')
                        ->orderBy('name')
                        ->get();

        return view(
            'admin.sections.edit',
            compact('section', 'classes', 'teachers')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'class_id' => 'required|exists:classes,id',

            'name' => 'required|max:10',

            'class_teacher_id' => 'nullable|exists:users,id',
        ]);


        // DUPLICATE CHECK
        $exists = Section::where('class_id', $request->class_id)
                    ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                    ->where('id', '!=', $id)
                    ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'This section already exists for selected class.'
                ]);
        }


        $section = Section::findOrFail($id);

        $section->update([

            'class_id' => $request->class_id,

            'name' => strtoupper($request->name),

            'class_teacher_id' => $request->class_teacher_id
        ]);


        return redirect()
            ->route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}