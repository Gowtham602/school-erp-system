@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-pencil-square"></i>
                Edit Student

            </h5>

            <a href="{{ route('students.index') }}"
               class="btn btn-light btn-sm">

                Back

            </a>

        </div>


        <!-- BODY -->
        <div class="card-body">

            <form id="studentForm"
                  action="{{ route('students.update',$student->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Admission No -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Admission No <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="admission_no"
                               class="form-control"
                               value="{{ $student->admission_no }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Roll No -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Roll No <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="roll_no"
                               class="form-control"
                              value="{{ $student->currentAcademic->roll_no ?? '' }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Section -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Section <span class="text-danger">*</span>
                        </label>

                        <select name="section_id"
                                class="form-select">

                            <option value="">
                                Select Section
                            </option>

                            @foreach($sections as $section)

                                <option value="{{ $section->id }}"
                                   {{ ($student->currentAcademic->section_id ?? '') == $section->id ? 'selected' : '' }}>

                                    {{ $section->class->name }}
                                    -
                                    {{ $section->name }}

                                </option>

                            @endforeach

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- First Name -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="first_name"
                               class="form-control"
                               value="{{ $student->first_name }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Last Name -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Last Name 
                        </label>

                        <input type="text"
                               name="last_name"
                               class="form-control"
                               value="{{ $student->last_name }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Gender -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Gender <span class="text-danger">*</span>
                        </label>

                        <select name="gender"
                                class="form-select">

                            <option value="">
                                Select Gender
                            </option>

                            <option value="male"
                                {{ $student->gender == 'male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ $student->gender == 'female' ? 'selected' : '' }}>
                                Female
                            </option>

                            <option value="other"
                                {{ $student->gender == 'other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Phone -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Phone <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ $student->phone }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Email -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $student->email }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- DOB -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            DOB
                        </label>

                        <input type="date"
                               name="dob"
                               class="form-control"
                               value="{{ $student->dob }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Father -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Father Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="father_name"
                               class="form-control"
                               value="{{ $student->father_name }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Mother -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mother Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="mother_name"
                               class="form-control"
                               value="{{ $student->mother_name }}">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- Address -->
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Address  <span class="text-danger">*</span>
                        </label>

                        <textarea name="address"
                                  rows="3"
                                  class="form-control">{{ $student->address }}</textarea>

                        <div class="invalid-feedback"></div>

                    </div>

                </div>


                <!-- BUTTON -->
                <div class="text-end">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>
                        Update Student

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | REMOVE ERROR WHILE TYPING
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'keyup change',
        'input, select, textarea',
        function () {

            $(this).removeClass('is-invalid');

            $(this)
                .closest('.mb-3')
                .find('.invalid-feedback')
                .html('');
        }
    );



    /*
    |--------------------------------------------------------------------------
    | UPDATE FORM AJAX
    |--------------------------------------------------------------------------
    */

    $('#studentForm').submit(function (e) {

        e.preventDefault();

        let form = $(this);

        $('.is-invalid').removeClass('is-invalid');

        $('.invalid-feedback').html('');

        $.ajax({

            url: form.attr('action'),

            type: 'POST',

            data: form.serialize(),

            success: function (response) {

                Swal.fire({

                    icon:'success',

                    title:'Success',

                    text:response.message,

                    timer:1500,

                    showConfirmButton:false
                });

                setTimeout(function(){

                    window.location.href =
                        "{{ route('students.index') }}";

                },1500);
            },

            error: function (xhr) {

                if(xhr.status === 422)
                {
                    let errors =
                        xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {

                        let input =
                            $('[name="' + field + '"]');

                        input.addClass('is-invalid');

                        input
                            .closest('.mb-3')
                            .find('.invalid-feedback')
                            .html(messages[0]);
                    });
                }
            }
        });

    });

});

</script>

@endpush