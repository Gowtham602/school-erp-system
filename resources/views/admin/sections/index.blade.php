@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Section Management

            </h3>

            <p class="text-muted mb-0">

                Manage class sections easily

            </p>

        </div>



        <button
            class="btn btn-primary px-4 py-2 shadow-sm rounded-pill"
            id="addBtn">

            <i class="bi bi-plus-circle me-2"></i>

            Add Section

        </button>

    </div>





    <!-- STATS -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="modern-card bg-primary text-white">

                <div>

                    <small>Total Sections</small>

                    <h2 class="fw-bold mb-0">

                        {{ \App\Models\Section::count() }}

                    </h2>

                </div>

                <i class="bi bi-diagram-3-fill stat-icon"></i>

            </div>

        </div>



        <div class="col-md-4">

            <div class="modern-card bg-success text-white">

                <div>

                    <small>Total Classes</small>

                    <h2 class="fw-bold mb-0">

                        {{ \App\Models\ClassModel::count() }}

                    </h2>

                </div>

                <i class="bi bi-mortarboard-fill stat-icon"></i>

            </div>

        </div>



        <div class="col-md-4">

            <div class="modern-card bg-dark text-white">

                <div>

                    <small>Academic Management</small>

                    <h2 class="fw-bold mb-0">

                        ERP

                    </h2>

                </div>

                <i class="bi bi-building-fill stat-icon"></i>

            </div>

        </div>

    </div>





    <!-- TABLE CARD -->

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-table me-2 text-primary"></i>

                Sections List

            </h5>

        </div>



        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table align-middle modern-table"
                       id="sectionTable">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Class</th>

                            <th>Section</th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>





<!-- MODAL -->

<div class="modal fade" id="sectionModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <form id="sectionForm">

                @csrf

                <input type="hidden" id="section_id">

                <!-- HEADER -->

                <div class="modal-header border-0 bg-primary text-white p-4">

                    <h5 class="modal-title fw-bold">

                        Section Form

                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>

                </div>



                <!-- BODY -->

                <div class="modal-body p-4">

                    <!-- CLASS -->

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Class

                        </label>

                        <select id="class_id"
                                class="form-select modern-input">

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



                    <!-- SECTION -->

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Section Name

                        </label>

                        <input type="text"
                               id="name"
                               class="form-control modern-input"
                               placeholder="Enter Section Name">

                        <small class="text-danger error_name"></small>

                    </div>

                </div>



                <!-- FOOTER -->

                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="submit"
                            class="btn btn-primary px-4 rounded-pill">

                        Save Section

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

    // CSRF

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });




    // DATATABLE

    let table = $('#sectionTable').DataTable({

        processing: true,

        serverSide: true,

        responsive: true,

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

                name: 'name',

                render:function(data){

                    return `

                        <span class="badge bg-primary px-3 py-2 rounded-pill">

                            ${data}

                        </span>

                    `;
                }
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

    $('#addBtn').click(function () {

        $('#sectionForm')[0].reset();

        $('#section_id').val('');

        $('.text-danger').html('');

        $('#sectionModal').modal('show');

    });





    // SAVE / UPDATE

    $('#sectionForm').submit(function (e) {

        e.preventDefault();

        $('.text-danger').html('');

        let id = $('#section_id').val();

        let url = id
            ? "{{ route('sections.update', ':id') }}"
                .replace(':id', id)
            : "{{ route('sections.store') }}";

        let method = id ? 'PUT' : 'POST';

        $.ajax({

            url: url,

            type: method,

            data: {

                class_id: $('#class_id').val(),

                name: $('#name').val()

            },

            success: function (response) {

                $('#sectionModal').modal('hide');

                table.ajax.reload();

            },

            error: function (xhr) {

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(key, value){

                        $('.error_' + key).html(value[0]);

                    });

                }

            }

        });

    });





    // EDIT

    $(document).on('click', '.editBtn', function () {

        let id = $(this).data('id');

        let url = "{{ route('sections.edit', ':id') }}"
            .replace(':id', id);

        $.ajax({

            url: url,

            type: 'GET',

            success: function (response) {

                $('#section_id').val(response.id);

                $('#class_id').val(response.class_id);

                $('#name').val(response.name);

                $('#sectionModal').modal('show');

            }

        });

    });





    // DELETE

    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data('id');

        let url = "{{ route('sections.destroy', ':id') }}"
            .replace(':id', id);

        if(confirm('Delete this section?')){

            $.ajax({

                url: url,

                type: 'DELETE',

                success: function (response) {

                    table.ajax.reload();

                }

            });

        }

    });

});

</script>

@endpush