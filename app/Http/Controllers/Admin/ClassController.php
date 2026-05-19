<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{

    // INDEX

   public function index()
{
    $totalClasses = ClassModel::count();

    $totalSections = Section::count();

    $activeClasses = ClassModel::count();



    // CLASS ORDER
    $classes = ClassModel::orderByRaw("

        CASE

            WHEN name = 'LKG' THEN -1

            WHEN name = 'UKG' THEN 0

            ELSE CAST(name AS UNSIGNED)

        END ASC

    ")->get();



    return view(
        'admin.classes.index',

        compact(

            'classes',

            'totalClasses',

            'totalSections',

            'activeClasses'
        )
    );
}




    // DATATABLE

    // public function data()
    // {
    //     $classes = ClassModel::with('sections')->get();

    //     return datatables()->of($classes)

    //         ->addColumn('sections', function ($row) {

    //             if ($row->sections->count() > 0) {

    //                 return $row->sections
    //                     ->pluck('name')
    //                     ->implode(', ');
    //             }

    //             return '-';
    //         })

    //         ->addColumn('action', function ($row) {

    //             $editUrl = route(
    //                 'classes.edit',
    //                 $row->id
    //             );

    //             $deleteUrl = route(
    //                 'classes.destroy',
    //                 $row->id
    //             );

    //             return '

    //                 <div class="d-flex gap-2">

    //                     <a href="' . $editUrl . '"
    //                         class="btn btn-primary action-btn">

    //                         <i class="bi bi-pencil"></i>

    //                     </a>

    //                     <button
    //                         class="btn btn-danger action-btn deleteBtn"
    //                         data-url="' . $deleteUrl . '"
    //                         data-id="' . $row->id . '">

    //                         <i class="bi bi-trash"></i>

    //                     </button>

    //                 </div>

    //             ';
    //         })

    //         ->rawColumns([
    //             'action'
    //         ])

    //         ->make(true);
    // }

    public function data()
{
    $classes = ClassModel::with('sections')

        ->orderByRaw("

            CASE

                WHEN name = 'LKG' THEN -1

                WHEN name = 'UKG' THEN 0

                ELSE CAST(name AS UNSIGNED)

            END ASC

        ");

    return datatables()->of($classes)

        ->addColumn('sections', function ($row) {

            if ($row->sections->count() > 0) {

                return $row->sections
                    ->pluck('name')
                    ->implode(', ');
            }

            return '-';
        })

        ->addColumn('action', function ($row) {

            $editUrl = route(
                'classes.edit',
                $row->id
            );

            $deleteUrl = route(
                'classes.destroy',
                $row->id
            );

            return '

                <div class="d-flex gap-2">

                    <a href="' . $editUrl . '"
                        class="btn btn-primary action-btn">

                        <i class="bi bi-pencil"></i>

                    </a>

                    <button
                        class="btn btn-danger action-btn deleteBtn"
                        data-url="' . $deleteUrl . '"
                        data-id="' . $row->id . '">

                        <i class="bi bi-trash"></i>

                    </button>

                </div>

            ';
        })

        ->rawColumns(['action'])

        ->make(true);
}


    // CREATE

    public function create()
    {
        return view('admin.classes.create');
    }




    // STORE

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:classes,name'

        ], [

            'name.required' => 'Class name is required.',

            'name.unique' => 'Class name already exists.'

        ]);


        ClassModel::create([

            'name' => $request->name

        ]);


        return redirect()
            ->route('classes.index')
            ->with('success', 'Class Added Successfully');
    }




    // EDIT

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);

        return view(
            'admin.classes.edit',
            compact('class')
        );
    }




    // UPDATE

    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => [

                'required',

                Rule::unique('classes')
                    ->ignore($id)

            ]

        ], [

            'name.required' => 'Class name is required.',

            'name.unique' => 'This class already exists.'

        ]);


        $class = ClassModel::findOrFail($id);

        $class->update([

            'name' => $request->name

        ]);


        return redirect()
            ->route('classes.index')
            ->with('success', 'Class Updated Successfully');
    }




    // DELETE

    public function destroy($id)
    {
        ClassModel::findOrFail($id)->delete();

        return response()->json([

            'success' => true

        ]);
    }
}