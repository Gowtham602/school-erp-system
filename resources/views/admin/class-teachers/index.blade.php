{{-- resources/views/admin/class-teachers/index.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        {{-- HEADER --}}

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Class Teacher Mapping
            </h5>

            <button class="btn btn-light btn-sm" id="addBtn">
                + Add Mapping
            </button>

        </div>

        {{-- BODY --}}

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle" id="classTeacherTable">

                <thead class="table-dark">

                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Teacher</th>
                        <th width="180">Action</th>
                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>


{{-- MODAL --}}

<div class="modal fade" id="classTeacherModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="classTeacherForm">

                @csrf

                <input type="hidden" id="mapping_id">

                {{-- HEADER --}}

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Class Teacher Form
                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                {{-- BODY --}}

                <div class="modal-body">

                    {{-- CLASS --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Class
                        </label>

                        <select id="class_id" class="form-select">

                            <option value="">
                                Select Class
                            </option>

                            @foreach($classes as $class)

                            <option value="{{ $class->id }}">
                                {{ $class->name }}
                            </option>

                            @endforeach

                        </select>

                        <small class="text-danger error_class_id"></small>

                    </div>


                    {{-- SECTION --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Section
                        </label>

                        <select id="section_id" class="form-select">

                            <option value="">
                                Select Section
                            </option>

                        </select>

                        <small class="text-danger error_section_id"></small>

                    </div>


                    {{-- TEACHER --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Teacher
                        </label>

                        <select id="teacher_id"   name="teacher_id" class="form-select">

                            <option value="">
                                Select Teacher
                            </option>

                            @foreach($teachers as $teacher)

                            <option value="{{ $teacher->id }}">
                                {{ $teacher->name }}
                            </option>

                            @endforeach

                        </select>

                        <small class="text-danger error_teacher_id"></small>

                    </div>

                </div>

                {{-- FOOTER --}}

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-success"
                        id="saveBtn">

                        Save

                    </button>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Close

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

    // SELECT2

    $('#teacher_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('#classTeacherModal')
    });


    // MODAL

    let modal = new bootstrap.Modal(
        document.getElementById('classTeacherModal')
    );


    // DATATABLE

    let table = $('#classTeacherTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('class-teachers.index') }}",

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'class_name',
                name: 'class_name'
            },

            {
                data: 'section_name',
                name: 'section_name'
            },

            {
                data: 'teacher_name',
                name: 'teacher_name'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });


    // ADD BUTTON

    $(document).on('click', '#addBtn', function () {

        $('#classTeacherForm')[0].reset();

        $('#mapping_id').val('');

        $('#section_id').html(
            '<option value="">Select Section</option>'
        );

        $('#teacher_id').val('').trigger('change');

        $('.text-danger').text('');

        $('#saveBtn').text('Save');

        modal.show();

    });


    // CLASS CHANGE

    $('#class_id').change(function () {

        let classId = $(this).val();

        if(classId == '') {

            $('#section_id').html(
                '<option value="">Select Section</option>'
            );

            return;
        }

        $.ajax({

            url: "{{ route('get.sections', ':id') }}"
                    .replace(':id', classId),

            type: 'GET',

            success: function (sections) {

                let option =
                    '<option value="">Select Section</option>';

                sections.forEach(function (section) {

                    option += `
                        <option value="${section.id}">
                            ${section.name}
                        </option>
                    `;
                });

                $('#section_id').html(option);

            }

        });

    });


    // STORE + UPDATE

    $('#classTeacherForm').submit(function (e) {

        e.preventDefault();

        $('.text-danger').text('');

        let id = $('#mapping_id').val();

        let url = id
            ? "{{ route('class-teachers.update', ':id') }}"
                    .replace(':id', id)
            : "{{ route('class-teachers.store') }}";

        let type = id ? 'PUT' : 'POST';

        $('#saveBtn').html('Saving...');

        $.ajax({

            url: url,

            type: type,

            data: {
                _token: "{{ csrf_token() }}",
                class_id: $('#class_id').val(),
                section_id: $('#section_id').val(),
                teacher_id: $('#teacher_id').val()
            },

            success: function (response) {

                $('#saveBtn').html('Save');

                modal.hide();

                table.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

            },

            error: function (xhr) {

                $('#saveBtn').html('Save');

                let errors = xhr.responseJSON.errors;

                if(errors.class_id){
                    $('.error_class_id').text(errors.class_id[0]);
                }

                if(errors.section_id){
                    $('.error_section_id').text(errors.section_id[0]);
                }

                if(errors.teacher_id){
                    $('.error_teacher_id').text(errors.teacher_id[0]);
                }

            }

        });

    });


    // EDIT

    $(document).on('click', '.editBtn', function () {

        let id = $(this).data('id');

        $('.text-danger').text('');

        $.ajax({

            url: "{{ route('class-teachers.edit', ':id') }}"
                    .replace(':id', id),

            type: 'GET',

            success: function (response) {

                let data = response.classTeacher;

                let sections = response.sections;

                $('#mapping_id').val(data.id);

                $('#class_id').val(data.class_id);

                let option =
                    '<option value="">Select Section</option>';

                sections.forEach(function (section) {

                    option += `
                        <option value="${section.id}">
                            ${section.name}
                        </option>
                    `;
                });

                $('#section_id').html(option);

                $('#section_id').val(data.section_id);

                $('#teacher_id')
                    .val(data.teacher_id)
                    .trigger('change');

                $('#saveBtn').text('Update');

                modal.show();

            }

        });

    });


    // DELETE

    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data('id');

        Swal.fire({

            title: 'Are you sure?',

            text: 'Deleted data cannot be recovered',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#3085d6',

            confirmButtonText: 'Delete'

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "{{ route('class-teachers.destroy', ':id') }}"
                            .replace(':id', id),

                    type: 'DELETE',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function (response) {

                        table.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                    }

                });

            }

        });

    });

});

</script>

@endpush