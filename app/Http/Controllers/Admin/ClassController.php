<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        return view('admin.classes.index');
    }

    public function data()
    {
        $classes = ClassModel::query();

        return datatables()->of($classes)

            ->addColumn('sections_count', function ($row) {
                return $row->sections()->count();
            })

            ->addColumn('action', function ($row) {

                return '
                    <a href="'.route('classes.edit',$row->id).'"
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
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classes,name'
        ]);

        ClassModel::create([
            'name' => $request->name
        ]);

        return redirect()->route('classes.index');
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);

        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:classes,name,'.$id
        ]);

        $class = ClassModel::findOrFail($id);

        $class->update([
            'name' => $request->name
        ]);

        return redirect()->route('classes.index');
    }

    public function destroy($id)
    {
        ClassModel::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}