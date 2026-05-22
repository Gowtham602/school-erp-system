@extends('layouts.app')

@section('title', 'Student Promotion')




@section('content')

<div class="container-fluid py-4">

    <!-- ============================================= -->
    <!-- PAGE TITLE -->
    <!-- ============================================= -->

    <div class="mb-4">

        <h2 class="page-title">
            Student Promotion
        </h2>

        <div class="sub-title">
            Manage student promotions and promotion history
        </div>

    </div>



    <!-- ============================================= -->
    <!-- TABS -->
    <!-- ============================================= -->

    <ul class="nav nav-pills mb-4">

        <li class="nav-item">

            <button
                class="nav-link active"
                data-bs-toggle="pill"
                data-bs-target="#promotion_tab"
                type="button"
            >

                <i class="bi bi-arrow-repeat"></i>

                Promotion

            </button>

        </li>



        <li class="nav-item ms-2">

            <button
                class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#history_tab"
                type="button"
            >

                <i class="bi bi-clock-history"></i>

                Promotion History

            </button>

        </li>

    </ul>



    <div class="tab-content">

        <!-- ============================================= -->
        <!-- PROMOTION TAB -->
        <!-- ============================================= -->

        <div
            class="tab-pane fade show active"
            id="promotion_tab"
        >

            <div class="card custom-card">

                <div class="card-header-custom">

                    <h5 class="mb-0">

                        <i class="bi bi-mortarboard-fill"></i>

                        Student Promotion Panel

                    </h5>

                </div>



                <div class="card-body p-4">

                    <form
                        action="{{ route('student.promotions.promote') }}"
                        method="POST"
                        id="promotionForm"
                    >

                        @csrf


                        <!-- ================================= -->
                        <!-- FILTERS -->
                        <!-- ================================= -->

                        <div class="row g-3">

                            <!-- CURRENT YEAR -->

                            <div class="col-md-3">

                                <label class="form-label fw-semibold">

                                    Current Academic Year

                                </label>

                                <input
                                    type="text"
                                    name="academic_year"
                                    class="form-control custom-input"
                                    placeholder="2025-2026"
                                >

                            </div>



                            <!-- NEW YEAR -->

                            <div class="col-md-3">

                                <label class="form-label fw-semibold">

                                    New Academic Year

                                </label>

                                <input
                                    type="text"
                                    name="new_academic_year"
                                    class="form-control custom-input"
                                    placeholder="2026-2027"
                                >

                            </div>



                            <!-- FROM SECTION -->

                            <div class="col-md-3">

                                <label class="form-label fw-semibold">

                                    From Section

                                </label>

                                <select
                                    name="from_section_id"
                                    id="from_section_id"
                                    class="form-select custom-input"
                                >

                                    <option value="">
                                        Select Section
                                    </option>

                                    @foreach($classes as $class)

                                        @foreach($class->sections as $section)

                                            <option
                                                value="{{ $section->id }}"
                                            >

                                                {{ $class->name }}
                                                -
                                                {{ $section->name }}

                                            </option>

                                        @endforeach

                                    @endforeach

                                </select>

                            </div>



                            <!-- TO SECTION -->

                            <div class="col-md-3">

                                <label class="form-label fw-semibold">

                                    To Section

                                </label>

                                <select
                                    name="to_section_id"
                                    id="to_section_id"
                                    class="form-select custom-input"
                                >

                                    <option value="">
                                        Select Section
                                    </option>

                                    @foreach($classes as $class)

                                        @foreach($class->sections as $section)

                                            <option
                                                value="{{ $section->id }}"
                                            >

                                                {{ $class->name }}
                                                -
                                                {{ $section->name }}

                                            </option>

                                        @endforeach

                                    @endforeach

                                </select>

                            </div>

                        </div>



                        <!-- ================================= -->
                        <!-- FETCH BUTTON -->
                        <!-- ================================= -->

                        <div class="mt-4 mb-4">

                            <button
                                type="button"
                                class="btn btn-primary btn-custom"
                                id="fetch_students"
                            >

                                <i class="bi bi-search"></i>

                                Fetch Students

                            </button>

                        </div>



                        <!-- ================================= -->
                        <!-- TABLE -->
                        <!-- ================================= -->

                        <div class="table-responsive">

                            <table
                                class="table table-bordered student-table"
                            >

                                <thead>

                                    <tr>

                                        <th width="5%">

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

                                    <tr id="empty_row">

                                        <td
                                            colspan="4"
                                            class="text-center empty-row"
                                        >

                                            Click "Fetch Students"

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>



                        <!-- ================================= -->
                        <!-- SUBMIT -->
                        <!-- ================================= -->

                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-success btn-custom"
                            >

                                <i class="bi bi-arrow-repeat"></i>

                                Promote Selected Students

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>



        <!-- ============================================= -->
        <!-- HISTORY TAB -->
        <!-- ============================================= -->

        <div
            class="tab-pane fade"
            id="history_tab"
        >

            <div class="card custom-card">

                <div class="card-header bg-dark text-white p-3">

                    <h5 class="mb-0">

                        <i class="bi bi-clock-history"></i>

                        Promotion History

                    </h5>

                </div>



                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered mb-0">

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

                                        <td>

                                            {{ $history->student->first_name ?? '' }}
                                            {{ $history->student->last_name ?? '' }}

                                        </td>

                                        <td>

                                            <span class="badge bg-info badge-custom">

                                                {{ $history->fromSection->classModel->name ?? '' }}
                                                -
                                                {{ $history->fromSection->name ?? '' }}

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-primary badge-custom">

                                                {{ $history->toSection->classModel->name ?? '' }}
                                                -
                                                {{ $history->toSection->name ?? '' }}

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-success badge-custom">

                                                {{ $history->academic_year }}

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center py-4"
                                        >

                                            No promotion history found

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>



                <div class="card-footer bg-white">

                    {{ $histories->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

toastr.options = {

    closeButton: true,

    progressBar: true,

    newestOnTop: true,

    preventDuplicates: true,

    positionClass: "toast-top-right",

    timeOut: "2500"
};



$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | FETCH STUDENTS
    |--------------------------------------------------------------------------
    */

    $('#fetch_students').click(function () {

        let academicYear =
            $.trim(
                $('input[name="academic_year"]').val()
            );

        let newAcademicYear =
            $.trim(
                $('input[name="new_academic_year"]').val()
            );

        let fromSection =
            $.trim(
                $('#from_section_id').val()
            );

        let toSection =
            $.trim(
                $('#to_section_id').val()
            );



        /*
        |--------------------------------------------------------------------------
        | VALIDATIONS
        |--------------------------------------------------------------------------
        */

        if (academicYear === '') {

            toastr.warning(
                'Please enter current academic year'
            );

            return;
        }



        if (newAcademicYear === '') {

            toastr.warning(
                'Please enter new academic year'
            );

            return;
        }



        if (fromSection === '') {

            toastr.warning(
                'Please select from section'
            );

            return;
        }



        if (toSection === '') {

            toastr.warning(
                'Please select to section'
            );

            return;
        }



        if (fromSection === toSection) {

            toastr.warning(
                'From and To section cannot be same'
            );

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        $.ajax({

            url: "{{ route('student.promotions.getStudents') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                from_section_id: fromSection,

                academic_year: academicYear
            },

            beforeSend: function () {

                $('#student_table').html(`

                    <tr>

                        <td
                            colspan="4"
                            class="text-center py-4"
                        >

                            Loading students...

                        </td>

                    </tr>
                `);
            },



            success: function (response) {

                let rows = '';



                /*
                |--------------------------------------------------------------------------
                | NO STUDENTS
                |--------------------------------------------------------------------------
                */

                if (!response.status) {

                    toastr.warning(
                        response.message
                    );

                    $('#student_table').html(`

                        <tr>

                            <td
                                colspan="4"
                                class="text-center empty-row"
                            >

                                No students found

                            </td>

                        </tr>
                    `);

                    return;
                }



                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                toastr.success(
                    'Students loaded successfully'
                );



                $.each(response.students, function (index, student) {

                    rows += `

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="academic_ids[]"
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
            },



           error: function (xhr) {

                console.log(xhr.responseJSON);

                toastr.error(
                    JSON.stringify(xhr.responseJSON)
                );
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




    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT VALIDATION
    |--------------------------------------------------------------------------
    */

    $('#promotionForm').submit(function (e) {

        let checkedStudents =
            $('.student_checkbox:checked').length;


        if (checkedStudents === 0) {

            e.preventDefault();

            toastr.warning(
                'Please select students'
            );
        }
    });

});

</script>

@endpush