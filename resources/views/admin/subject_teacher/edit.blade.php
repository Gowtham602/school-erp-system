@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">
            <h4>Edit Subject Teacher</h4>
        </div>

        <div class="card-body">

            <form id="editForm">

                @csrf
                @method('PUT')


                <!-- SUBJECT -->

                <div class="mb-3">

                    <label>Subject</label>

                    <select name="subject_id"
                            class="form-control">

                        @foreach($subjects as $subject)

                        <option
                            value="{{ $subject->id }}"
                            {{ $subjectTeacher->subject_id == $subject->id ? 'selected' : '' }}>

                            {{ $subject->name }}

                        </option>

                        @endforeach

                    </select>

                </div>




                <!-- SECTION -->

                <div class="mb-3">

                    <label>Section</label>

                    <select name="section_id"
                            class="form-control">

                        @foreach($sections as $section)

                        <option
                            value="{{ $section->id }}"
                            {{ $subjectTeacher->section_id == $section->id ? 'selected' : '' }}>

                            {{ $section->classModel->name }}
                            -
                            {{ $section->name }}

                        </option>

                        @endforeach

                    </select>

                </div>




                <!-- TEACHER -->

                <div class="mb-3">

                    <label>Teacher</label>

                    <select name="teacher_id"
                            class="form-control">

                        @foreach($teachers as $teacher)

                        <option
                            value="{{ $teacher->id }}"
                            {{ $subjectTeacher->teacher_id == $teacher->id ? 'selected' : '' }}>

                            {{ $teacher->name }}

                        </option>

                        @endforeach

                    </select>

                </div>




                <button type="submit"
                        class="btn btn-success">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection




@push('scripts')

<script>

$('#editForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('subject-teacher.update',$subjectTeacher->id) }}",

        type: "POST",

        data: $(this).serialize(),

        success:function(res){

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: 'Updated Successfully',

                timer: 2000,

                showConfirmButton: false

            });

            setTimeout(function(){

                window.location.href =
                "{{ route('subject-teacher.index') }}";

            },2000);

        }

    });

});

</script>

@endpush