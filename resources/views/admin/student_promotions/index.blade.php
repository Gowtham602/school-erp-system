@extends('layouts.app')

@section('title', 'Student Promotion')




@section('content')



<div class="container-fluid py-4">

    <!-- ====================================================== -->
    <!-- PAGE HEADER -->
    <!-- ====================================================== -->

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

        <div class="card-body bg-primary bg-gradient text-white py-4 px-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-arrow-repeat me-2"></i>

                        Student Promotion

                    </h3>

                    <small class="opacity-75">

                        Manage student promotions professionally

                    </small>

                </div>

                <span class="badge bg-light text-primary px-3 py-2 rounded-pill">

                    ERP Module

                </span>

            </div>

        </div>

    </div>



    <!-- ====================================================== -->
    <!-- STATS -->
    <!-- ====================================================== -->

    <div class="row mb-4">

        <!-- TOTAL HISTORY -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm rounded-4 stats-card">

                <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted text-uppercase fw-semibold">

                            Total Promotions

                        </small>

                        <h3 class="fw-bold mt-1 mb-0 text-primary">

                            {{ $histories->total() }}

                        </h3>

                    </div>

                    <div class="icon-box bg-primary bg-opacity-10 text-primary">

                        <i class="bi bi-arrow-repeat"></i>

                    </div>

                </div>

            </div>

        </div>



        <!-- TOTAL CLASSES -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm rounded-4 stats-card">

                <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted text-uppercase fw-semibold">

                            Total Classes

                        </small>

                        <h3 class="fw-bold mt-1 mb-0 text-success">

                            {{ $classes->count() }}

                        </h3>

                    </div>

                    <div class="icon-box bg-success bg-opacity-10 text-success">

                        <i class="bi bi-building"></i>

                    </div>

                </div>

            </div>

        </div>



        <!-- ACTIVE YEAR -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm rounded-4 stats-card">

                <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted text-uppercase fw-semibold">

                            Academic Year

                        </small>

                        <h5 class="fw-bold mt-2 mb-0 text-dark">

                            {{ date('Y') }}-{{ date('Y') + 1 }}

                        </h5>

                    </div>

                    <div class="icon-box bg-warning bg-opacity-10 text-warning">

                        <i class="bi bi-calendar-event-fill"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- ====================================================== -->
    <!-- TABS -->
    <!-- ====================================================== -->

    <ul class="nav nav-pills custom-tabs mb-4">

        <li class="nav-item">

            <button
                class="nav-link active rounded-pill px-4"
                data-bs-toggle="pill"
                data-bs-target="#promotion_tab"
                type="button">

                <i class="bi bi-arrow-repeat me-1"></i>

                Promotion

            </button>

        </li>



        <li class="nav-item ms-2">

            <button
                class="nav-link rounded-pill px-4"
                data-bs-toggle="pill"
                data-bs-target="#history_tab"
                type="button">

                <i class="bi bi-clock-history me-1"></i>

                Promotion History

            </button>

        </li>

    </ul>



<div class="tab-content">

    <!-- ============================================= -->
    <!-- PROMOTION TAB -->
    <!-- ============================================= -->

    <div class="tab-pane fade show active" id="promotion_tab">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 py-3 px-4">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>

                    Promotion Panel

                </h5>

            </div>



            <div class="card-body p-4">

                <form
                    action="{{ route('student.promotions.promote') }}"
                    method="POST"
                    id="promotionForm">

                    @csrf



                    <!-- FILTERS -->

                    <div class="row g-3">

                        <!-- CURRENT YEAR -->

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                Current Year

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="academic_year"
                                class="form-select form-control-custom">

                                <option value="">
                                    Select Year
                                </option>

                                <option value="2025-2026">
                                    2025-2026
                                </option>

                                <option value="2026-2027">
                                    2026-2027
                                </option>

                                <option value="2027-2028">
                                    2027-2028
                                </option>

                                <option value="2028-2029">
                                    2028-2029
                                </option>

                            </select>

                        </div>



                        <!-- NEW YEAR -->

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                New Year

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="new_academic_year"
                                class="form-select form-control-custom">

                                <option value="">
                                    Select Year
                                </option>

                                <option value="2026-2027">
                                    2026-2027
                                </option>

                                <option value="2027-2028">
                                    2027-2028
                                </option>
                                 <option value="2028-2029">
                                    2028-2029
                                </option>
                                 <option value="2029-2030">
                                    2029-2030
                                </option>

                            </select>

                        </div>



                        <!-- FROM SECTION -->

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                From Section

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="from_section_id"
                                id="from_section_id"
                                class="form-select form-control-custom">

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



                        <!-- TO SECTION -->

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                To Section

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="to_section_id"
                                id="to_section_id"
                                class="form-select form-control-custom">

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

                    </div>



                    <!-- FETCH BUTTON -->

                    <div class="mt-4">

                        <button
                            type="button"
                            class="btn btn-primary rounded-pill px-4"
                            id="fetch_students">

                            <i class="bi bi-search me-1"></i>

                            Fetch Students

                        </button>

                    </div>



                    <!-- TABLE -->

                    <div class="table-responsive mt-4">

                        <table
                            class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th width="5%">

                                        <input
                                            type="checkbox"
                                            id="select_all">

                                    </th>

                                    <th>
                                        Admission No
                                    </th>

                                    <th>
                                        Student
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
                                        class="text-center py-5 text-muted">

                                        Fetch students to continue

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>



                    <!-- SUBMIT -->

                    <div class="mt-4 text-end">

                        <button
                            type="submit"
                            class="btn btn-success rounded-pill px-4">

                            <i class="bi bi-arrow-repeat me-1"></i>

                            Promote Students

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    <!-- ============================================= -->
    <!-- HISTORY TAB -->
    <!-- ============================================= -->

    <div class="tab-pane fade" id="history_tab">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <div class="card-header bg-dark text-white py-3 px-4">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-clock-history me-2"></i>

                    Promotion History

                </h5>

            </div>



            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

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

                                        <span class="badge bg-info rounded-pill">

                                            {{ $history->fromSection->classModel->name ?? '' }}
                                            -
                                            {{ $history->fromSection->name ?? '' }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-primary rounded-pill">

                                            {{ $history->toSection->classModel->name ?? '' }}
                                            -
                                            {{ $history->toSection->name ?? '' }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-success rounded-pill">

                                            {{ $history->academic_year }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center py-5 text-muted">

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



<style>

.stats-card{
    transition:0.3s;
}

.stats-card:hover{
    transform:translateY(-4px);
}

.icon-box{
    width:55px;
    height:55px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.custom-tabs .nav-link{
    background:#fff;
    color:#0d6efd;
    border:1px solid #dee2e6;
    font-weight:600;
}

.custom-tabs .nav-link.active{
    background:#0d6efd;
    color:#fff;
}

.form-control-custom{
    border-radius:12px;
    min-height:48px;
}

.table{
    border-radius:16px;
    overflow:hidden;
}

.card{
    border-radius:20px;
}

</style>

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
            $('select[name="academic_year"]').val();

        let newAcademicYear =
            $('select[name="new_academic_year"]').val();

        let fromSection =
            $('#from_section_id').val();

        let toSection =
            $('#to_section_id').val();



        /*
        |--------------------------------------------------------------------------
        | VALIDATIONS
        |--------------------------------------------------------------------------
        */

        if (academicYear === '') {

            toastr.warning(
                'Please select current academic year'
            );

            return;
        }


        if (newAcademicYear === '') {

            toastr.warning(
                'Please select new academic year'
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
        | AJAX REQUEST
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

                $('#fetch_students')
                    .prop('disabled', true)
                    .html(`
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading...
                    `);


                $('#student_table').html(`

                    <tr>

                        <td colspan="4"
                            class="text-center py-5">

                            <div class="spinner-border text-primary mb-2"></div>

                            <div>
                                Loading students...
                            </div>

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

                    toastr.warning(response.message);

                    $('#summaryBox').addClass('d-none');

                    $('#student_table').html(`

                        <tr>

                            <td colspan="4"
                                class="text-center py-5 text-muted">

                                <i class="bi bi-people fs-1 d-block mb-2"></i>

                                No students found

                            </td>

                        </tr>
                    `);

                    return;
                }



                /*
                |--------------------------------------------------------------------------
                | SUMMARY
                |--------------------------------------------------------------------------
                */

                $('#summaryBox').removeClass('d-none');

                $('#summaryCurrent').text(academicYear);

                $('#summaryNew').text(newAcademicYear);

                $('#summaryCount').text(
                    response.students.length
                );



                /*
                |--------------------------------------------------------------------------
                | SUCCESS MESSAGE
                |--------------------------------------------------------------------------
                */

                toastr.success(
                    response.students.length +
                    ' Students Loaded'
                );



                /*
                |--------------------------------------------------------------------------
                | TABLE ROWS
                |--------------------------------------------------------------------------
                */

                $.each(response.students, function (index, student) {

                    rows += `

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="academic_ids[]"
                                    value="${student.id}"
                                    class="student_checkbox">

                            </td>

                            <td>

                                <span class="fw-semibold">

                                    ${student.student.admission_no ?? '-'}

                                </span>

                            </td>

                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div
                                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width:35px;height:35px;">

                                        <i class="bi bi-person-fill"></i>

                                    </div>

                                    <div>

                                        ${student.student.first_name ?? ''}

                                        ${student.student.last_name ?? ''}

                                    </div>

                                </div>

                            </td>

                            <td>

                                <span class="badge bg-primary rounded-pill px-3 py-2">

                                    ${student.roll_no ?? '-'}

                                </span>

                            </td>

                        </tr>
                    `;
                });


                $('#student_table').html(rows);
            },



            error: function (xhr) {

                console.log(xhr);

                toastr.error(
                    'Something went wrong'
                );
            },



            complete: function () {

                $('#fetch_students')
                    .prop('disabled', false)
                    .html(`
                        <i class="bi bi-search me-1"></i>
                        Fetch Students
                    `);
            }
        });
    });




    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'change',
        '#select_all',
        function () {

            $('.student_checkbox').prop(

                'checked',

                $(this).prop('checked')
            );
        }
    );




    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

   $('#promotionForm').submit(function (e) {

    e.preventDefault();

    let checkedStudents =
        $('.student_checkbox:checked').length;


    if (checkedStudents === 0) {

        toastr.warning(
            'Please select students'
        );

        return;
    }



    Swal.fire({

        title: 'Promote Students?',

        text: checkedStudents +
            ' students will be promoted.',

        icon: 'question',

        showCancelButton: true,

        confirmButtonColor: '#198754',

        confirmButtonText: 'Yes, Promote'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: $('#promotionForm').attr('action'),

                type: 'POST',

                data: $('#promotionForm').serialize(),

                beforeSend: function () {

                    $('.btn-success')
                        .prop('disabled', true)
                        .html(`

                            <span class="spinner-border spinner-border-sm"></span>

                            Promoting...
                        `);
                },



                success: function (response) {

                    if (response.status) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Success',

                            text: response.message,

                            timer: 2000,

                            showConfirmButton: false
                        });



                        /*
                        |--------------------------------------------------------------------------
                        | RESET TABLE
                        |--------------------------------------------------------------------------
                        */

                        $('#student_table').html(`

                            <tr>

                                <td colspan="4"
                                    class="text-center py-5 text-muted">

                                    <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>

                                    Students promoted successfully

                                </td>

                            </tr>
                        `);



                        /*
                        |--------------------------------------------------------------------------
                        | HIDE SUMMARY
                        |--------------------------------------------------------------------------
                        */

                        $('#summaryBox').addClass('d-none');



                        /*
                        |--------------------------------------------------------------------------
                        | UNCHECK SELECT ALL
                        |--------------------------------------------------------------------------
                        */

                        $('#select_all').prop(
                            'checked',
                            false
                        );



                        /*
                        |--------------------------------------------------------------------------
                        | RELOAD PAGE
                        |--------------------------------------------------------------------------
                        */

                        setTimeout(function () {

                            location.reload();

                        }, 1500);
                    }
                },



                error: function (xhr) {

                    console.log(xhr);

                    toastr.error(
                        'Something went wrong'
                    );
                },



                complete: function () {

                    $('.btn-success')
                        .prop('disabled', false)
                        .html(`

                            <i class="bi bi-arrow-repeat me-1"></i>

                            Promote Students
                        `);
                }
            });
        }
    });

});

});

</script>

@endpush