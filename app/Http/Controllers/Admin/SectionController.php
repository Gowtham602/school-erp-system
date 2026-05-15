<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        // DATATABLE AJAX

        if ($request->ajax()) {

            $sections = Section::with('classModel')
                            ->latest();

            return DataTables::of($sections)

                ->addIndexColumn()

                ->addColumn('class_name', function ($row) {

                    return $row->classModel->name ?? '-';
                })

                ->addColumn('action', function ($row) {

                    $editBtn = '
                        <button
                            class="btn btn-warning btn-sm editBtn"
                            
                            data-id="'.$row->id.'">
                            <i class="bi bi-pencil"></i>
                        </button>
                    ';

                    $deleteBtn = '
                        <button
                            class="btn btn-danger btn-sm deleteBtn"

                            data-id="'.$row->id.'">
                             <i class="bi bi-trash"></i>
                        </button>
                    ';

                    return $editBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        $classes = ClassModel::all();

        return view('admin.sections.index', compact('classes'));  
    }

    // STORE  

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required|unique:sections,name,NULL,id,class_id,' . $request->class_id,
        ]);

        Section::create([
            'class_id' => $request->class_id,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Section Added Successfully'
        ]);
    }

    // EDIT

    public function edit($id)
    {
        return response()->json(
            Section::findOrFail($id)
        );
    }

    // UPDATE

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required|unique:sections,name,' . $id . ',id,class_id,' . $request->class_id,
        ]);

        $section = Section::findOrFail($id);

        $section->update([
            'class_id' => $request->class_id,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Section Updated Successfully'
        ]);
    }

    // DELETE

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Section Deleted Successfully'
        ]);
    }
}