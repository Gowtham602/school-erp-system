@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-header">
            <h4 class="mb-0"> Add Subject Teacher </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('subject-teacher.store') }}"
                method="POST">
                @csrf
                <!-- CLASS -->
                <div class="mb-3">
                    <label class="form-label">    Class   </label>
                    <select name="class_id"    id="class_id" class="form-control @error('class_id') is-invalid @enderror">
                        <option value="">  Select Class </option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('class_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
              
                <!-- SECTION -->
                <div class="mb-3">
                    <label class="form-label">
                        Section
                    </label>
                    <select name="section_id"
                        id="section_id"
                        class="form-control @error('section_id') is-invalid @enderror">

                        <option value="">
                            Select Section
                        </option>
                    </select>
                    @error('section_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                      <!-- SUBJECT -->
                <div class="mb-3">
                    <label class="form-label">    Subject </label>
                    <select name="subject_id"
                        id="subject_id"
                        class="form-control @error('subject_id') is-invalid @enderror">

                        <option value="">
                            Select Subject
                        </option>

                    </select>

                    @error('subject_id')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>



                <!-- TEACHER -->

                <div class="mb-3">

                    <label class="form-label">
                        Teacher
                    </label>

                    <select name="teacher_id"
                        class="form-control @error('teacher_id') is-invalid @enderror">

                        <option value="">
                            Select Teacher
                        </option>

                        @foreach($teachers as $teacher)

                        <option value="{{ $teacher->id }}">

                            {{ $teacher->name }}

                        </option>

                        @endforeach

                    </select>

                    @error('teacher_id')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>




                <!-- BUTTON -->

                <button type="submit"
                    class="btn btn-primary">

                    Save

                </button>

            </form>

        </div>

    </div>

</div>

@endsection




@push('scripts')

<script>
    $(document).ready(function() {

        $('#class_id').change(function() {

            let class_id = $(this).val();




            // LOAD SUBJECTS

            $.ajax({

                url: "{{ route('get-subjects', ':id') }}"
                    .replace(':id', class_id),

                type: 'GET',

                success: function(data) {

                    $('#subject_id').html(
                        '<option value="">Select Subject</option>'
                    );

                    $.each(data, function(key, value) {

                        $('#subject_id').append(

                            `<option value="${value.id}">
                            ${value.name}
                        </option>`

                        );

                    });

                }

            });





            // LOAD SECTIONS

            $.ajax({

                url: "{{ route('get-sections', ':id') }}"
                    .replace(':id', class_id),

                type: 'GET',

                success: function(data) {

                    $('#section_id').html(
                        '<option value="">Select Section</option>'
                    );

                    $.each(data, function(key, value) {

                        $('#section_id').append(

                            `<option value="${value.id}">
                            ${value.name}
                        </option>`

                        );

                    });

                }

            });

        });

    });
</script>

@endpush