@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">

    <!-- TOP STATS -->

    <div class="row mb-4">

        <!-- TOTAL CLASSES -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm dashboard-card bg-primary text-white">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="mb-1 text-uppercase">
                            Total Classes
                        </h6>

                        <h2 class="fw-bold mb-0">

                            {{ $totalClasses }}

                        </h2>

                    </div>

                    <div class="icon-box">

                        <i class="bi bi-mortarboard-fill"></i>

                    </div>

                </div>

            </div>

        </div>



        <!-- TOTAL SECTIONS -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm dashboard-card bg-success text-white">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="mb-1 text-uppercase">
                            Total Sections
                        </h6>

                        <h2 class="fw-bold mb-0">

                            {{ $totalSections }}

                        </h2>

                    </div>

                    <div class="icon-box">

                        <i class="bi bi-diagram-3-fill"></i>

                    </div>

                </div>

            </div>

        </div>



        <!-- ACTIVE CLASSES -->

        <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm dashboard-card bg-dark text-white">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="mb-1 text-uppercase">
                            Active Classes
                        </h6>

                        <h2 class="fw-bold mb-0">

                            {{ $activeClasses }}

                        </h2>

                    </div>

                    <div class="icon-box">

                        <i class="bi bi-collection-fill"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>





    <!-- MAIN CARD -->

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <!-- HEADER -->

        <div class="card-header custom-header d-flex justify-content-between align-items-center bg-primary text-white">

            <div>

                <h4 class="mb-0 fw-bold text-blue ">

                    <i class="bi bi-mortarboard-fill me-2"></i>

                    Class Management

                </h4>

                <small class="text-light">

                    Manage classes and sections

                </small>

            </div>



            <a href="{{ route('classes.create') }}"
                class="btn btn-light fw-semibold px-4">

                <i class="bi bi-plus-circle"></i>

                Add Class

            </a>

        </div>



        <!-- BODY -->

        <div class="card-body bg-white p-4">

            <div class="table-responsive">

                <table
                    class="table align-middle custom-table"
                    id="classTable">

                    <thead>

                        <tr>

                            <th width="70">

                                #

                            </th>

                            <th>

                                Class

                            </th>

                            <th>

                                Sections

                            </th>

                            <th width="150">

                                Actions

                            </th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection






@push('styles')

<style>
    .dashboard-card {

        border-radius: 20px;

        transition: 0.3s;
    }


    .dashboard-card:hover {

        transform: translateY(-5px);
    }


    .icon-box {

        width: 60px;
        height: 60px;

        border-radius: 15px;

        background: rgba(255, 255, 255, 0.2);

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 28px;
    }


    .custom-header {

        background: linear-gradient(135deg,
                #0d6efd,
                #0056d6);

        padding: 20px 25px;
    }


    .custom-table thead {

        background: #111827;

        color: white;
    }


    .custom-table thead th {

        padding: 16px;

        border: none;

        font-size: 14px;

        text-transform: uppercase;

        letter-spacing: 0.5px;
    }


    .custom-table tbody tr {

        transition: 0.2s;
    }


    .custom-table tbody tr:hover {

        background: #f8fbff;
    }


    .custom-table tbody td {

        padding: 16px;

        vertical-align: middle;
    }


    .class-badge {

        background: #eef4ff;

        color: #0d6efd;

        padding: 8px 14px;

        border-radius: 30px;

        font-weight: 600;

        display: inline-block;
    }


    .section-badge {

        background: #f1f5f9;

        color: #111827;

        padding: 6px 12px;

        border-radius: 20px;

        margin-right: 5px;

        display: inline-block;

        font-size: 13px;

        font-weight: 600;
    }


    .action-btn {

        width: 38px;
        height: 38px;

        border-radius: 10px;

        display: inline-flex;

        align-items: center;
        justify-content: center;
    }


    .dataTables_wrapper .dataTables_filter input {

        border-radius: 10px;
        border: 1px solid #dbe2ea;

        padding: 8px 12px;
    }


    .dataTables_wrapper .dataTables_length select {

        border-radius: 10px;
        border: 1px solid #dbe2ea;
    }
</style>

@endpush






@push('scripts')

<script>
    $(document).ready(function() {

        $('#classTable').DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('classes.data') }}",

            columns: [

                {
                    data: null,

                    orderable: false,

                    searchable: false,

                    render: function(data, type, row, meta) {

                        return `

                        <span class="fw-bold text-primary">

                            ${meta.row + meta.settings._iDisplayStart + 1}

                        </span>

                    `;
                    }
                },



                {
                    data: 'name',

                    name: 'name',

                    render: function(data) {

                        return `

                        <span class="class-badge">

                            Class ${data}

                        </span>

                    `;
                    }
                },



                {
                    data: 'sections',

                    name: 'sections',

                    orderable: false,

                    searchable: false,

                    render: function(data) {

                        if (data == '-' || data == '') {

                            return `

                            <span class="text-muted">

                                No Sections

                            </span>

                        `;
                        }

                        let sections = data.split(',');

                        let badges = '';

                        sections.forEach(function(section) {

                            badges += `

                            <span class="section-badge">

                                ${section.trim()}

                            </span>

                        `;
                        });

                        return badges;
                    }
                },



                {
                    data: 'action',

                    orderable: false,

                    searchable: false,

                    render: function(data, type, row) {

                        let editUrl = "{{ route('classes.edit', ':id') }}"
                            .replace(':id', row.id);

                        let deleteUrl = "{{ route('classes.destroy', ':id') }}"
                            .replace(':id', row.id);

                        return `

                        <div class="d-flex gap-2">

                            <a href="${editUrl}"
                               class="btn btn-primary action-btn">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <button
                                class="btn btn-danger action-btn deleteBtn"
                                data-url="${deleteUrl}"
                                data-id="${row.id}">

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    `;
                    }
                }

            ]

        });





        // DELETE

        $(document).on('click', '.deleteBtn', function() {

            let deleteUrl = $(this).data('url');

            if (confirm('Delete this class?')) {

                $.ajax({

                    url: deleteUrl,

                    type: 'DELETE',

                    data: {
                        _token: '{{ csrf_token() }}'
                    },

                    success: function() {

                        $('#classTable')
                            .DataTable()
                            .ajax.reload();

                    }

                });
            }
        });

    });
</script>

@endpush