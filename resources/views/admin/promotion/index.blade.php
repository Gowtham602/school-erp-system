@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    <div class="row">

        <!-- ===================================================== -->
        <!-- LEFT SIDE : PROMOTION FORM -->
        <!-- ===================================================== -->

        <div class="col-md-5">

            <div class="card shadow border-0">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">
                        <i class="bi bi-mortarboard-fill"></i>
                        Student Promotion
                    </h5>

                </div>

                <div class="card-body">

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    {{-- ERROR MESSAGE --}}
                    @if(session('error'))

                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    @endif


                    {{-- VALIDATION ERRORS --}}
                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif



                    <form
                        method="POST"
                        action="{{ route('promotions.promote') }}"
                    >

                        @csrf


                        <!-- ====================================== -->
                        <!-- CURRENT YEAR -->
                        <!-- ====================================== -->

                        <div class="mb-3">

                            <label class="form-label">
                                Current Academic Year
                            </label>

                            <input
                                type="text"
                                name="academic_year"
                                class="form-control"
                                placeholder="2025-2026"
                                required
                            >

                        </div>



                        <!-- ====================================== -->
                        <!-- NEW YEAR -->
                        <!-- ====================================== -->

                        <div class="mb-3">

                            <label class="form-label">
                                New Academic Year
                            </label>

                            <input
                                type="text"
                                name="new_academic_year"
                                class="form-control"
                                placeholder="2026-2027"
                                required
                            >

                        </div>



                        <!-- ====================================== -->
                        <!-- FROM SECTION -->
                        <!-- ====================================== -->

                        <div class="mb-3">

                            <label class="form-label">

                                <i class="bi bi-arrow-down-circle"></i>

                                From Section

                            </label>

                            <select
                                name="from_section"
                                id="from_section"
                                class="form-select"
                                required
                            >

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



                        <!-- ====================================== -->
                        <!-- TO SECTION -->
                        <!-- ====================================== -->

                        <div class="mb-3">

                            <label class="form-label">

                                <i class="bi bi-arrow-up-circle"></i>

                                To Section

                            </label>

                            <select
                                name="to_section"
                                class="form-select"
                                required
                            >

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



                        <!-- ====================================== -->
                        <!-- FETCH BUTTON -->
                        <!-- ====================================== -->

                        <div class="mb-3">

                            <button
                                type="button"
                                class="btn btn-primary w-100"
                                id="fetch_students"
                            >

                                <i class="bi bi-search"></i>

                                Fetch Students

                            </button>

                        </div>



                        <!-- ====================================== -->
                        <!-- STUDENT TABLE -->
                        <!-- ====================================== -->

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead class="table-light">

                                    <tr>

                                        <th width="10%">

                                            <input
                                                type="checkbox"
                                                id="select_all"
                                            >

                                        </th>

                                        <th>
                                            Admission No
                                        </th>

                                        <th>
                                            Student Name
                                        </th>

                                        <th>
                                            Roll No
                                        </th>

                                    </tr>

                                </thead>

                                <tbody id="student_table">

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="text-center text-muted"
                                        >
                                            No students loaded
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>



                        <!-- ====================================== -->
                        <!-- SUBMIT BUTTON -->
                        <!-- ====================================== -->

                        <button class="btn btn-success w-100">

                            <i class="bi bi-rocket-takeoff"></i>

                            Promote Selected Students

                        </button>

                    </form>

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- RIGHT SIDE : HISTORY -->
        <!-- ===================================================== -->

        <div class="col-md-7">

            <div class="card shadow border-0">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">

                        <i class="bi bi-clock-history"></i>

                        Recent Promotion History

                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0 text-center align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>#</th>

                                    <th>Student</th>

                                    <th>From Section</th>

                                    <th>To Section</th>

                                    <th>Academic Year</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($histories as $key => $history)

                                    <tr>

                                        <td>
                                            {{ $histories->firstItem() + $key }}
                                        </td>

                                        <td class="fw-semibold">

                                            {{ $history->student->first_name ?? '' }}
                                            {{ $history->student->last_name ?? '' }}

                                        </td>

                                        <td>

                                            <span class="badge bg-info">

                                                {{ $history->fromSection->classModel->name ?? '' }}
                                                -
                                                {{ $history->fromSection->name ?? '' }}

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-primary">

                                                {{ $history->toSection->classModel->name ?? '' }}
                                                -
                                                {{ $history->toSection->name ?? '' }}

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-success">

                                                {{ $history->academic_year }}

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center text-muted"
                                        >
                                            No history found
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>



                <!-- ====================================== -->
                <!-- PAGINATION -->
                <!-- ====================================== -->

                <div class="card-footer">

                    {{ $histories->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | FETCH STUDENTS
    |--------------------------------------------------------------------------
    */

    $('#fetch_students').click(function () {

        $.ajax({

            url: "{{ route('promotions.getStudents') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                from_section:
                    $('#from_section').val(),

                academic_year:
                    $('input[name="academic_year"]').val()
            },

            success: function (response) {

                let rows = '';

                if (!response.status) {

                    rows += `

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-danger"
                            >

                                ${response.message}

                            </td>

                        </tr>
                    `;

                    $('#student_table').html(rows);

                    return;
                }


                $.each(response.students, function (index, student) {

                    rows += `

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="students[]"
                                    value="${student.id}"
                                    class="student_checkbox"
                                >

                            </td>

                            <td>

                                ${student.student.admission_no ?? ''}

                            </td>

                            <td>

                                ${student.student.first_name ?? ''}
                                ${student.student.last_name ?? ''}

                            </td>

                            <td>

                                ${student.roll_no ?? ''}

                            </td>

                        </tr>
                    `;
                });

                $('#student_table').html(rows);
            }
        });
    });



    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    $('#select_all').click(function () {

        $('.student_checkbox').prop(
            'checked',
            $(this).prop('checked')
        );
    });

});

</script>

@endpush