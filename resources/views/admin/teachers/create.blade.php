@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-person-plus"></i>
                Add Teacher

            </h5>

            <a href="{{ route('teachers.index') }}"
                class="btn btn-light btn-sm">

                Back

            </a>

        </div>


        <!-- BODY -->
        <div class="card-body">

            <form id="teacherForm">

                @csrf

                <div class="row">

                    <!-- NAME -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label"> Name</label>

                        <input type="text" name="name" class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- EMAIL -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label"> Email </label>

                        <input type="email" name="email" class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- EMPLOYEE ID -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">Employee ID</label>

                        <input type="text" name="employee_id" class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- PHONE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">   Phone    </label>

                        <input type="text"    name="phone"   class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- ALTERNATE PHONE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">    Alternate Phone </label>

                        <input type="text" name="alternate_phone"  class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- GENDER -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">   Gender</label>

                        <select name="gender" class="form-select">

                            <option value="">    Select Gender</option>

                            <option value="male">  Male</option>

                            <option value="female">    Female</option>

                            <option value="other">   Other </option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- DOB -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">    DOB
                        </label>

                        <input type="date"
                            name="dob"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- QUALIFICATION -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Qualification
                        </label>

                        <select name="qualification"
                            class="form-select">

                            <option value="">
                                Select Qualification
                            </option>

                            <option value="B.Ed">
                                B.Ed
                            </option>

                            <option value="M.Ed">
                                M.Ed
                            </option>

                            <option value="BA">
                                BA
                            </option>

                            <option value="MA">
                                MA
                            </option>

                            <option value="BSc">
                                BSc
                            </option>

                            <option value="MSc">
                                MSc
                            </option>

                            <option value="PhD">
                                PhD
                            </option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- EXPERIENCE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Experience
                        </label>

                        <input type="text"
                            name="experience"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- JOINING DATE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Joining Date
                        </label>

                        <input type="date"
                            name="joining_date"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- SALARY -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Salary
                        </label>

                        <input type="number"
                            name="salary"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- BLOOD GROUP -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Blood Group
                        </label>

                        <select name="blood_group"
                            class="form-select">

                            <option value="">
                                Select
                            </option>

                            <option>A+</option>
                            <option>A-</option>
                            <option>B+</option>
                            <option>B-</option>
                            <option>AB+</option>
                            <option>AB-</option>
                            <option>O+</option>
                            <option>O-</option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- AADHAAR -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Aadhaar No
                        </label>

                        <input type="text"
                            name="aadhaar_no"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- CITY -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            City
                        </label>

                        <input type="text"
                            name="city"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- STATE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            State
                        </label>

                        <input type="text"
                            name="state"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- PINCODE -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Pincode
                        </label>

                        <input type="text"
                            name="pincode"
                            class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- ADDRESS -->
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Address
                        </label>

                        <textarea name="address"
                            rows="3"
                            class="form-control"></textarea>

                        <div class="invalid-feedback"></div>

                    </div>

                </div>


                <!-- BUTTON -->
                <div class="text-end">

                    <button type="submit"
                        class="btn btn-success">

                        <i class="bi bi-check-circle"></i>
                        Save Teacher

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>
    $(document).ready(function() {

        /*
        |--------------------------------------------------------------------------
        | REMOVE ERROR WHILE TYPING
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'keyup change',
            'input,select,textarea',
            function() {

                $(this)
                    .removeClass('is-invalid');

                $(this)
                    .closest('.mb-3')
                    .find('.invalid-feedback')
                    .html('');
            }
        );



        /*
        |--------------------------------------------------------------------------
        | SAVE TEACHER
        |--------------------------------------------------------------------------
        */

        $('#teacherForm').submit(function(e) {

            e.preventDefault();

            let form = $(this);

            $('.is-invalid')
                .removeClass('is-invalid');

            $('.invalid-feedback')
                .html('');

            $.ajax({

                url: "{{ route('teachers.store') }}",

                type: 'POST',

                data: form.serialize(),

                success: function(response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Success',

                        text: response.message,

                        timer: 1500,

                        showConfirmButton: false
                    });

                    form[0].reset();

                    setTimeout(function() {

                        window.location.href =
                            "{{ route('teachers.index') }}";

                    }, 1500);
                },

                error: function(xhr) {

                    if (xhr.status == 422) {
                        let errors =
                            xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {

                            let input =
                                $('[name="' + field + '"]');

                            input.addClass(
                                'is-invalid'
                            );

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