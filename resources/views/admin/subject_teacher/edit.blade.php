@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            <h4>Edit Subject Teacher</h4>
        </div>

        <div class="card-body">

            <form id="editForm">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Subject</label>

                    <select name="subject_id" class="form-control">

                        @foreach($subjects as $subject)

                        <option
                            value="{{ $subject->id }}"
                            {{ $subjectTeacher->subject_id == $subject->id ? 'selected' : '' }}>

                            {{ $subject->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Section</label>

                    <select name="section_id" class="form-control">

                        @foreach($sections as $section)

                        <option
                            value="{{ $section->id }}"
                            {{ $subjectTeacher->section_id == $section->id ? 'selected' : '' }}>

                            {{ $section->class->name }}
                            -
                            {{ $section->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Teacher</label>

                    <select name="teacher_id" class="form-control">

                        @foreach($teachers as $teacher)

                        <option
                            value="{{ $teacher->id }}"
                            {{ $subjectTeacher->teacher_id == $teacher->id ? 'selected' : '' }}>

                            {{ $teacher->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <button class="btn btn-success">
                    Update
                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

$('#editForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url:'/subject-teacher/{{ $subjectTeacher->id }}',

        type:'POST',

        data:$(this).serialize(),

        success:function(res){

            alert(res.message);

            window.location.href='/subject-teacher';

        }

    });

});

</script>

@endsection