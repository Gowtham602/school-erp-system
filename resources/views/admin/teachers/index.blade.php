@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body bg-primary text-white rounded">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-person-workspace"></i>
                        Teacher Management

                    </h3>

                    <p class="mb-0">
                        Manage Active & Deleted Teachers
                    </p>

                </div>

                <div>

                    <a href="{{ route('teachers.create') }}"
                       class="btn btn-light fw-bold">

                        <i class="bi bi-plus-circle-fill"></i>
                        Add Teacher

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- MAIN CARD -->
    <div class="card border-0 shadow-sm">

        <!-- CARD HEADER -->
        <div class="card-header bg-white border-0 py-3">

            <div class="row">

                <div class="col-md-5">

                    <div class="btn-group w-100">

                        <!-- ACTIVE -->
                        <button type="button"
                                id="activeBtn"
                                class="btn btn-primary">

                            <i class="bi bi-people-fill"></i>
                            Active Teachers

                        </button>


                        <!-- DELETED -->
                        <button type="button"
                                id="deletedBtn"
                                class="btn btn-outline-danger">

                            <i class="bi bi-trash3-fill"></i>
                            Deleted History

                        </button>

                    </div>

                </div>

            </div>

        </div>



        <!-- TABLE -->
        <div class="card-body">

            <div class="table-responsive">

                <table id="teacherTable"
                       class="table table-hover align-middle w-100">

                    <thead class="table-dark">

                        <tr>

                            <th width="70">SNo</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Qualification</th>

                            <th>Status</th>

                            <th width="150"
                                class="text-center">

                                Action

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

    body{
        background:#f4f6f9;
    }

    .table th{
        vertical-align:middle;
        font-size:14px;
    }

    .table td{
        vertical-align:middle;
        font-size:14px;
    }

    .table tbody tr:hover{
        background:#f8fbff;
        transition:0.2s;
    }

    .dataTables_wrapper .dataTables_filter input{

        border:1px solid #ccc;

        border-radius:8px;

        padding:5px 10px;
    }

    .dataTables_wrapper .dataTables_length select{

        border-radius:8px;
    }

</style>

@endpush






@push('scripts')

<script>

let typeTable = 'active';

let table;



$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    table = $('#teacherTable').DataTable({

        processing:true,

        serverSide:true,

        responsive:true,

        ajax:{

            url:"{{ route('teachers.data') }}",

            data:function(d){

                d.type = typeTable;
            }
        },



        columns:[

            {
                data:null,

                orderable:false,

                searchable:false,

                render:function(data,type,row,meta){

                    return meta.row +
                        meta.settings._iDisplayStart + 1;
                }
            },



            {
                data:'name',
                name:'name'
            },



            {
                data:'email',
                name:'email'
            },



            {
                data:'phone',
                name:'phone'
            },



            {
                data:'qualification',
                name:'qualification'
            },



            {
                data:'status',

                render:function(data){

                    // DELETED
                    if(typeTable == 'deleted')
                    {
                        return `

                            <span class="badge bg-danger">

                                Deleted

                            </span>

                        `;
                    }

                    // ACTIVE
                    return `

                        <span class="badge bg-success">

                            Active

                        </span>

                    `;
                }
            },



            {
                data:'id',

                orderable:false,

                searchable:false,

                className:'text-center',

                render:function(data,type,row){

                    /*
                    |--------------------------------------------------------------------------
                    | DELETED TABLE
                    |--------------------------------------------------------------------------
                    */

                    if(typeTable == 'deleted')
                    {
                        return `

                            <button
                                onclick="restoreTeacher(${data})"
                                class="btn btn-success btn-sm">

                                <i class="bi bi-arrow-clockwise"></i>

                            </button>

                        `;
                    }



                    /*
                    |--------------------------------------------------------------------------
                    | ACTIVE TABLE
                    |--------------------------------------------------------------------------
                    */

                    let editUrl =
                        "{{ route('teachers.edit', ':id') }}";

                    editUrl =
                        editUrl.replace(':id', data);

                    return `

                        <a href="${editUrl}"
                           class="btn btn-primary btn-sm">

                            <i class="bi bi-pencil-fill"></i>

                        </a>



                        <button
                            onclick="deleteTeacher(${data})"
                            class="btn btn-danger btn-sm">

                            <i class="bi bi-trash-fill"></i>

                        </button>

                    `;
                }
            }

        ]

    });






    /*
    |--------------------------------------------------------------------------
    | ACTIVE BUTTON
    |--------------------------------------------------------------------------
    */

    $('#activeBtn').click(function(){

        typeTable = 'active';



        $('#activeBtn')

            .removeClass('btn-outline-primary')

            .addClass('btn-primary');



        $('#deletedBtn')

            .removeClass('btn-danger')

            .addClass('btn-outline-danger');



        table.ajax.reload();

    });







    /*
    |--------------------------------------------------------------------------
    | DELETED BUTTON
    |--------------------------------------------------------------------------
    */

    $('#deletedBtn').click(function(){

        typeTable = 'deleted';



        $('#deletedBtn')

            .removeClass('btn-outline-danger')

            .addClass('btn-danger');



        $('#activeBtn')

            .removeClass('btn-primary')

            .addClass('btn-outline-primary');



        table.ajax.reload();

    });

});







/*
|--------------------------------------------------------------------------
| DELETE TEACHER
|--------------------------------------------------------------------------
*/

function deleteTeacher(id)
{

    Swal.fire({

        title:'Are you sure?',

        text:'Teacher will move to deleted history',

        icon:'warning',

        showCancelButton:true,

        confirmButtonColor:'#dc3545',

        confirmButtonText:'Yes Delete'

    })

    .then((result)=>{

        if(result.isConfirmed)
        {

            $.ajax({

                url:"{{ url('admin/teachers') }}/" + id,

                type:'DELETE',

                data:{

                    _token:'{{ csrf_token() }}'
                },

                success:function(response){

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








/*
|--------------------------------------------------------------------------
| RESTORE TEACHER
|--------------------------------------------------------------------------
*/

function restoreTeacher(id)
{

    Swal.fire({

        title:'Restore Teacher?',

        icon:'question',

        showCancelButton:true,

        confirmButtonText:'Restore'

    })

    .then((result)=>{

        if(result.isConfirmed)
        {

            $.ajax({

                url:"{{ route('teachers.restore', ':id') }}"
                        .replace(':id', id),

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