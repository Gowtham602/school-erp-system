@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                Student Promotion

            </h4>

        </div>

        <div class="card-body">


            <!-- TOP BUTTONS -->

            <div class="mb-4 d-flex gap-2">

                <button
                    class="btn btn-primary"
                    id="promotion_tab">

                    <i class="bi bi-mortarboard-fill"></i>

                    Student Promotion

                </button>


                <button
                    class="btn btn-dark"
                    id="history_tab">

                    <i class="bi bi-clock-history"></i>

                    Promotion History

                </button>

            </div>




            <!-- PROMOTION SECTION -->

            <div id="promotion_section">


                <!-- FILTERS -->

                <div class="row">

                    <!-- CURRENT YEAR -->

                    <div class="col-md-3 mb-3">

                        <label>
                            Current Academic Year
                        </label>

                        <input
                            type="text"
                            id="academic_year"
                            class="form-control"
                            value="2025-2026">

                    </div>



                    <!-- NEW YEAR -->

                    <div class="col-md-3 mb-3">

                        <label>
                            New Academic Year
                        </label>

                        <input
                            type="text"
                            id="new_academic_year"
                            class="form-control"
                            value="2026-27">

                    </div>



                    <!-- FROM SECTION -->

                    <div class="col-md-3 mb-3">

                        <label>
                            From Class / Section
                        </label>

                        <select
                            id="from_section"
                            class="form-control">

                            <option value="">
                                Select
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

                    <div class="col-md-3 mb-3">

                        <label>
                            To Class / Section
                        </label>

                        <select
                            id="to_section"
                            class="form-control">

                            <option value="">
                                Select
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

                <div class="mb-4">

                    <button
                        class="btn btn-primary"
                        id="fetch_students">

                        Fetch Students

                    </button>

                </div>




                <!-- STUDENT TABLE -->

                <div class="card shadow-sm">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            Student Promotion

                        </h5>

                    </div>

                    <div class="card-body">

                        <table
                            class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th width="50">

                                        <input
                                            type="checkbox"
                                            id="select_all">

                                    </th>

                                    <th>Name</th>

                                    <th>Roll No</th>

                                    <th>Phone</th>

                                    <th>Class</th>

                                    <th>Section</th>

                                </tr>

                            </thead>

                            <tbody id="students_table_body">

                            </tbody>

                        </table>

                    </div>

                </div>




                <!-- PROMOTE BUTTON -->

                <div class="mt-4">

                    <button
                        class="btn btn-success"
                        id="promote_btn">

                        Promote Selected Students

                    </button>

                </div>

            </div>





            <!-- HISTORY SECTION -->

            <div id="history_section" style="display:none;">

                <div class="card shadow-sm">

                    <div class="card-header bg-dark text-white">

                        <h5 class="mb-0">

                            Promotion History

                        </h5>

                    </div>

                    <div class="card-body">

                        <table
                            class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Name</th>

                                    <th>Previous Class</th>

                                    <th>Current Class</th>

                                    <th>Academic Year</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($histories as $history)

                                <tr>

                                    <td>

                                        {{ $history->student->first_name ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $history->fromSection->classModel->name ?? '-' }}
                                        -
                                        {{ $history->fromSection->name ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $history->toSection->classModel->name ?? '-' }}
                                        -
                                        {{ $history->toSection->name ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $history->academic_year ?? '-' }}

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection




@push('scripts')

<script>

    // TAB SWITCHING

    $('#promotion_tab').click(function () {

        $('#promotion_section').show();

        $('#history_section').hide();

        $('#promotion_tab')
            .removeClass('btn-dark')
            .addClass('btn-primary');

        $('#history_tab')
            .removeClass('btn-primary')
            .addClass('btn-dark');

    });



    $('#history_tab').click(function () {

        $('#promotion_section').hide();

        $('#history_section').show();

        $('#history_tab')
            .removeClass('btn-dark')
            .addClass('btn-primary');

        $('#promotion_tab')
            .removeClass('btn-primary')
            .addClass('btn-dark');

    });




    // FETCH STUDENTS

    $('#fetch_students').click(function() {

        $.ajax({

            url: "{{ route('student.promotions.getStudents') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                from_section_id: $('#from_section').val(),

                academic_year: $('#academic_year').val()

            },

            success: function(response) {

                let rows = '';

                response.forEach(item => {

                    rows += `

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="student_checkbox"
                                value="${item.id}">

                        </td>

                        <td>

                            ${item.student.first_name ?? '-'}

                        </td>

                        <td>

                            ${item.roll_no ?? '-'}

                        </td>

                        <td>

                            ${item.student.phone ?? '-'}

                        </td>

                        <td>

                            ${item.section.class_model.name ?? '-'}

                        </td>

                        <td>

                            ${item.section.name ?? '-'}

                        </td>

                    </tr>

                    `;
                });

                $('#students_table_body').html(rows);

            }

        });

    });




    // SELECT ALL

    $('#select_all').click(function() {

        $('.student_checkbox')
            .prop('checked', this.checked);

    });




    // PROMOTE STUDENTS

    $('#promote_btn').click(function() {

        let academic_ids = [];

        $('.student_checkbox:checked').each(function() {

            academic_ids.push($(this).val());

        });

        $.ajax({

            url: "{{ route('student.promotions.promote') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                academic_ids: academic_ids,

                from_section_id: $('#from_section').val(),

                to_section_id: $('#to_section').val(),

                new_academic_year: $('#new_academic_year').val()

            },

            success: function(response) {

                alert(response.message);

                location.reload();

            },

            error: function(xhr) {

                console.log(xhr.responseJSON);

            }

        });

    });

</script>

@endpush