@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white d-flex justify-content-between">

            <h5 class="mb-0">
                Section Management
            </h5>

            <button class="btn btn-light btn-sm" id="addBtn">
                + Add Section
            </button>

        </div>

        <div class="card-body">

            <table class="table table-bordered" id="sectionTable">

                <thead class="table-dark">

                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th width="180">Action</th>
                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>

{{-- MODAL --}}

<div class="modal fade" id="sectionModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="sectionForm">

                @csrf

                <input type="hidden" id="section_id">

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Section Form
                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    {{-- CLASS --}}

                    <div class="mb-3">

                        <label>Class</label>

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

                    {{-- NAME --}}

                    <div class="mb-3">

                        <label>Section Name</label>

                        <input
                            type="text"
                            id="name"
                            class="form-control">

                        <small class="text-danger error_name"></small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-success"
                        id="saveBtn">

                        Save

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

    // DATATABLE

    let table = $('#sectionTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('sections.index') }}",

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
                data: 'name',
                name: 'name'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

    // MODAL

    let modal = new bootstrap.Modal(
        document.getElementById('sectionModal')
    );

    // ADD

    $('#addBtn').click(function () {

        $('#sectionForm')[0].reset();

        $('#section_id').val('');

        $('.text-danger').text('');

        modal.show();

    });

    // STORE + UPDATE

    $('#sectionForm').submit(function (e) {

        e.preventDefault();

        $('.text-danger').text('');

        let id = $('#section_id').val();

        let url = id
            ? "{{ route('sections.update', ':id') }}"
                .replace(':id', id)
            : "{{ route('sections.store') }}";

        let type = id ? 'PUT' : 'POST';

        $.ajax({

            url: url,

            type: type,

            data: {
                _token: "{{ csrf_token() }}",
                class_id: $('#class_id').val(),
                name: $('#name').val()
            },

            success: function (response) {

                modal.hide();

                $('#sectionForm')[0].reset();

                table.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

            },

            error: function (xhr) {

                let errors = xhr.responseJSON.errors;

                if(errors.class_id){
                    $('.error_class_id').text(errors.class_id[0]);
                }

                if(errors.name){
                    $('.error_name').text(errors.name[0]);
                }

            }

        });

    });

    // EDIT

    $(document).on('click', '.editBtn', function () {

        let id = $(this).data('id');

        $.ajax({

            url: "{{ route('sections.edit', ':id') }}"
                    .replace(':id', id),

            type: 'GET',

            success: function (data) {

                $('#section_id').val(data.id);

                $('#class_id').val(data.class_id);

                $('#name').val(data.name);

                modal.show();

            }

        });

    });

    // DELETE

    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data('id');

        Swal.fire({

            title: 'Are you sure?',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Delete'

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "{{ route('sections.destroy', ':id') }}"
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