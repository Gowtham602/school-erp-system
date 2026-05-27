@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

        <div class="card-body bg-primary bg-gradient text-white py-4 px-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-people-fill me-2"></i>

                        My Students

                    </h3>

                    <small class="opacity-75">

                        Manage students professionally

                    </small>

                </div>

                <button
                    class="btn btn-light rounded-pill px-4 shadow-sm"
                    id="addBtn">

                    <i class="bi bi-plus-circle-fill me-1"></i>

                    Add Student

                </button>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- TABLE -->
    <!-- ===================================================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body table-responsive p-4">

            <table
                class="table table-hover align-middle"
                id="studentTable">

                <thead class="table-dark">

                    <tr>

                        <th>#</th>

                        <th>Student</th>

                        <th>Class</th>

                        <th>Section</th>

                        <th>Roll No</th>

                        <th width="120">

                            Action

                        </th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- MODAL -->
<!-- ===================================================== -->

<div class="modal fade" id="studentModal">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <form id="studentForm">

            @csrf

            <input type="hidden" id="student_id">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->

                <div class="modal-header bg-primary text-white border-0">

                    <h5 class="modal-title fw-bold">

                        Student Form

                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">

                    </button>

                </div>



                <!-- BODY -->

                <div class="modal-body p-4">

                    <div class="row g-3">

                        <!-- FIRST NAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                First Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="first_name"
                                class="form-control"
                                required>

                        </div>



                        <!-- LAST NAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Last Name

                            </label>

                            <input
                                type="text"
                                name="last_name"
                                class="form-control">

                        </div>



                        <!-- PHONE -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Phone
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                required>

                        </div>



                        <!-- GENDER -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Gender
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="gender"
                                class="form-select"
                                required>

                                <option value="">
                                    Select
                                </option>

                                <option value="male">
                                    Male
                                </option>

                                <option value="female">
                                    Female
                                </option>

                            </select>

                        </div>



                        <!-- FATHER -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Father Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="father_name"
                                class="form-control"
                                required>

                        </div>



                        <!-- MOTHER -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Mother Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="mother_name"
                                class="form-control"
                                required>

                        </div>



                        <!-- SECTION -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Section
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="section_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Section
                                </option>

                                @foreach($classes as $class)

                                    @foreach($class->sections as $section)

                                        <option value="{{ $section->id }}">

                                            {{ $class->name }}
                                            -
                                            {{ $section->name }}

                                        </option>

                                    @endforeach

                                @endforeach

                            </select>

                        </div>



                        <!-- ADDRESS -->

                        <div class="col-12">

                            <label class="form-label fw-semibold">

                                Address
                                <span class="text-danger">*</span>

                            </label>

                            <textarea
                                name="address"
                                rows="3"
                                class="form-control"
                                required></textarea>

                        </div>

                    </div>

                </div>



                <!-- FOOTER -->

                <div class="modal-footer border-0">

                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-4">

                        Save Student

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>



@push('scripts')

<script>

let table = $('#studentTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: "{{ route('teacher.students.data') }}",

    columns: [

        {data: 'id'},

        {data: 'student_name'},

        {data: 'class'},

        {data: 'section'},

        {data: 'roll_no'},

        {
            data: 'action',
            orderable: false,
            searchable: false
        }
    ]
});



/*
|--------------------------------------------------------------------------
| ADD
|--------------------------------------------------------------------------
*/

$('#addBtn').click(function () {

    $('#studentForm')[0].reset();

    $('#student_id').val('');

    $('#studentModal').modal('show');
});



/*
|--------------------------------------------------------------------------
| SAVE
|--------------------------------------------------------------------------
*/

let updateUrl =
    "{{ route('teacher.students.update', ':id') }}";



$('#studentForm').submit(function (e) {

    e.preventDefault();

    let id = $('#student_id').val();

    let url = id

        ? updateUrl.replace(':id', id)

        : "{{ route('teacher.students.store') }}";



    let type = id ? 'PUT' : 'POST';



    $.ajax({

        url: url,

        type: type,

        data: $(this).serialize(),

        success: function (response) {

            $('#studentModal').modal('hide');

            table.ajax.reload();



            toastr.success(
                response.message
            );
        },

        error: function () {

            toastr.error(
                'Something went wrong'
            );
        }
    });
});



/*
|--------------------------------------------------------------------------
| EDIT
|--------------------------------------------------------------------------
*/

$(document).on('click', '.editBtn', function () {

    let id = $(this).data('id');

    let editUrl =
        "{{ route('teacher.students.edit', ':id') }}";



    $.get(
        editUrl.replace(':id', id),

        function (data) {

            $('#student_id').val(data.id);

            $('[name="first_name"]').val(data.first_name);

            $('[name="last_name"]').val(data.last_name);

            $('[name="father_name"]').val(data.father_name);

            $('[name="mother_name"]').val(data.mother_name);

            $('[name="phone"]').val(data.phone);

            $('[name="address"]').val(data.address);

            $('[name="gender"]').val(data.gender);

            $('[name="section_id"]').val(
                data.current_academic?.section_id
            );

            $('#studentModal').modal('show');
        }
    );
});



/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    let deleteUrl =
        "{{ route('teacher.students.delete', ':id') }}";



    Swal.fire({

        title: 'Delete Student?',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: deleteUrl.replace(':id', id),

                type: 'DELETE',

                data: {

                    _token: '{{ csrf_token() }}'
                },

                success: function (response) {

                    table.ajax.reload();

                    toastr.success(
                        response.message
                    );
                }
            });
        }
    });
});

</script>

@endpush

@endsection