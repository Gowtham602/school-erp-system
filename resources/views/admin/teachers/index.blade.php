@extends('layouts.app')

@section('content')

<div class="card shadow d-flex flex-column flex-grow-1">

    <!-- HEADER -->
    <!-- <div class="p-3 border-bottom d-flex justify-content-between">
        <h5>Teachers</h5>
        <a href="{{ route('teachers.create') }}" class="btn btn-success">
            Add Teacher
        </a>
    </div> -->
    <div class="p-3 border-bottom">

    <div class="row align-items-center">

        <!-- LEFT (6 columns) -->
        <div class="col-md-6 d-flex gap-2 mb-2 mb-md-0">
            <button class="btn btn-primary btn-sm w-50" onclick="loadType('active')">
                Active Teachers
            </button>

            <button class="btn btn-secondary btn-sm w-50" onclick="loadType('deleted')">
                Deleted History
            </button>
        </div>

        <!-- RIGHT (6 columns) -->
        <div class="col-md-6 text-md-end">
            <a href="{{ route('teachers.create') }}" class="btn btn-success btn-sm">
                Add Teacher
            </a>
        </div>

    </div>

</div>

    <!-- SCROLL ONLY HERE -->
    <div class="flex-grow-1 overflow-auto p-2">
        <table id="teacherTable" class="table table-bordered table-striped w-100 ">
            <!-- <table id="teacherTable" class="table table-striped table-hover align-middle w-100"> -->
            <thead class="table-dark">
                <tr>
                    <th>S No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Qualification</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>
@push('scripts')
<script>
   let type = 'active';
let table;

$(document).ready(function () {

    table = $('#teacherTable').DataTable({
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('teachers.data') }}",
            data: function (d) {
                d.type = type;
            }
        },

        columns: [
            { data: null, orderable: false, searchable: false },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'qualification' },

            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function (data) {

                    //  SWITCH BUTTON BASED ON TYPE
                    if (type === 'deleted') {
                        return `
                            <button onclick="restoreTeacher(${data})" class="btn btn-success btn-sm">
                                Restore
                            </button>
                        `;
                    }

                    return `
                        <button onclick="deleteTeacher(${data})" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    `;
                }
            }
        ],

        drawCallback: function (settings) {
            var api = this.api();
            var start = api.page.info().start;

            api.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = start + i + 1;
            });
        }
    });

});
    function loadType(t) {
        // console.log(t);
    type = t;

    if (table) {
        table.ajax.reload();
    }
}



    // deleted function  
    function deleteTeacher(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Teacher will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/admin/teachers/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $('#teacherTable').DataTable().ajax.reload();
                }
            });

        }
    });
}

function restoreTeacher(id) {
    $.ajax({
        url: '/admin/teachers/restore/' + id,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            Swal.fire('Restored!', res.message, 'success');
            table.ajax.reload();
        }
    });
}
</script>
@endpush
@endsection