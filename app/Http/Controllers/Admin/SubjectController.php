<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classModel')->latest()->get();

        return view('admin.subjects.index', compact('subjects'));
    }


    public function create()
    {
        $classes = ClassModel::latest()->get();

        return view('admin.subjects.create', compact('classes'));
    }


   public function store(Request $request)
{
    $request->validate([

        'class_id' => 'required',

        'name' => [ 'required',

            Rule::unique('subjects') ->where(function ($query) use ($request) {
                    return $query->where(  'class_id',  $request->class_id );
                })
        ]
    ], [  'name.unique' => 'This subject already exists for selected class.' ]);


    Subject::create([
        'name'     => $request->name,
        'class_id' => $request->class_id,
    ]);

    return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject Added Successfully');
}

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        $classes = ClassModel::latest()->get();

        return view('admin.subjects.edit', compact(
            'subject',
            'classes'
        ));
    }


   public function update(Request $request, $id)
{
    $request->validate([

        'class_id' => 'required',

        'name' => [

            'required',

            Rule::unique('subjects')
                ->ignore($id)
                ->where(function ($query) use ($request) {

                    return $query->where(
                        'class_id',
                        $request->class_id
                    );

                })

        ]

    ], [

        'name.unique' => 'This subject already exists for selected class.'

    ]);


    $subject = Subject::findOrFail($id);

    $subject->update([

        'name'     => $request->name,

        'class_id' => $request->class_id,

    ]);


    return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject Updated Successfully');
}


    public function destroy($id)
{
    $subject = Subject::findOrFail($id);

    $subject->delete();

    return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject Deleted Successfully');
}
}