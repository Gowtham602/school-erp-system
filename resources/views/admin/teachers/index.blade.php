@extends('layouts.app')

@section('content')

<div class="card shadow border-0 h-100 d-flex flex-column">

    <!-- HEADER -->
    <div class="card-header bg-white">

        <div class="row align-items-center">

            <!-- LEFT -->
            <div class="col-md-6 mb-2 mb-md-0">

                <div class="d-flex gap-2">

                    <button type="button"
                            id="activeBtn"
                            class="btn btn-primary btn-sm w-50">

                        <i class="bi bi-people-fill"></i>
                        Active Teachers

                    </button>


                    <button type="button"
                            id="deletedBtn"
                            class="btn btn-secondary btn-sm w-50">

                        <i class="bi bi-trash"></i>
                        Deleted History

                    </button>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="col-md-6 text-md-end">

                <a href="{{ route('teachers.create') }}"
                   class="btn btn-success btn-sm">

                    <i class="bi bi-plus-circle"></i>
                    Add Teacher

                </a>

            </div>

        </div>

    </div>


    <!-- TABLE -->
    <div class="card-body overflow-auto">

        <table id="teacherTable"
               class="table table-bordered table-hover align-middle w-100">

            <thead class="table-dark">

                <tr>

                    <th width="70">SNo</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Qualification</th>

                    <th>Status</th>

                    <th width="180">Action</th>

                </tr>

            </thead>

        </table>

    </div>

</div>

@endsection



@push('scripts')

<script>

let type = 'active';

let table;



$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    table = $('#teacherTable').DataTable({

        processing: true,

        serverSide: true,

        responsive:true,

        ajax: {

            url: "{{ route('teachers.data') }}",

            data: function (d) {

                d.type = type;
            }
        },

        columns: [

            {
                data: null,

                orderable: false,

                searchable: false,

                render: function (data, type, row, meta) {

                    return meta.row +
                        meta.settings._iDisplayStart + 1;
                }
            },

            {
                data: 'name'
            },

            {
                data: 'email'
            },

            {
                data: 'phone'
            },

            {
                data: 'qualification'
            },

            {
                data: 'status',

                render:function(data){

                    if(data == 'active')
                    {
                        return `
                            <span class="badge bg-success">
                                Active
                            </span>
                        `;
                    }

                    return `
                        <span class="badge bg-danger">
                            Inactive
                        </span>
                    `;
                }
            },

            {
                data: 'id',

                orderable: false,

                searchable: false,

                render: function (data, typeRow, row) {


                    // DELETED HISTORY
                    if (type === 'deleted')
                    {
                        return `

                            <button
                                onclick="restoreTeacher(${data})"
                                class="btn btn-success btn-sm">

                                <i class="bi bi-arrow-clockwise"></i>

                            </button>

                        `;
                    }


                    // ACTIVE
                    return `

                        <a href="/admin/teachers/${data}/edit"
                           class="btn btn-primary btn-sm">

                            <i class="bi bi-pencil-square"></i>

                        </a>


                        <button
                            onclick="deleteTeacher(${data})"
                            class="btn btn-danger btn-sm">

                            <i class="bi bi-trash"></i>

                        </button>

                    `;
                }
            }
        ]
    });




   

    $('#activeBtn').click(function(){

        type = 'active';

        $('#activeBtn')
            .removeClass('btn-secondary')
            .addClass('btn-primary');

        $('#deletedBtn')
            .removeClass('btn-primary')
            .addClass('btn-secondary');

        table.ajax.reload();
    });




    

    $('#deletedBtn').click(function(){

        type = 'deleted';

        $('#deletedBtn')
            .removeClass('btn-secondary')
            .addClass('btn-primary');

        $('#activeBtn')
            .removeClass('btn-primary')
            .addClass('btn-secondary');

        table.ajax.reload();
    });

});





function deleteTeacher(id)
{
    Swal.fire({

        title: 'Are you sure?',

        text: "Teacher will be deleted!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        confirmButtonText: 'Yes, Delete'
    })

    .then((result) => {

        if (result.isConfirmed)
        {
            $.ajax({

                url: '/admin/teachers/' + id,

                type: 'DELETE',

                data: {

                    _token: '{{ csrf_token() }}'
                },

                success: function (response)
                {
                    Swal.fire({

                        icon:'success',

                        title:'Deleted',

                        text:response.message,

                        timer:1500,

                        showConfirmButton:false
                    });

                    table.ajax.reload();
                }
            });
        }
    });
}






function restoreTeacher(id)
{
    Swal.fire({

        title: 'Restore Teacher?',

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Restore'
    })

    .then((result) => {

        if(result.isConfirmed)
        {
            $.ajax({

                url:'/admin/teachers/restore/' + id,

                type:'POST',

                data:{

                    _token:'{{ csrf_token() }}'
                },

                success:function(response){

                    Swal.fire({

                        icon:'success',

                        title:'Restored',

                        text:response.message,

                        timer:1500,

                        showConfirmButton:false
                    });

                    table.ajax.reload();
                }
            });
        }
    });
}

</script>

@endpush