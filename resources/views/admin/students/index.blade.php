@extends('layouts.app')

@section('content')

<div class="card shadow border-0">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="bi bi-people"></i>
            Students

        </h5>

        <a href="{{ route('students.create') }}"
           class="btn btn-light btn-sm">

            <i class="bi bi-plus-circle"></i>
            Add Student

        </a>

    </div>


    <!-- BODY -->
    <div class="card-body">

        <table class="table table-bordered table-hover align-middle"
               id="studentTable">

            <thead class="table-dark">

                <tr>

                    <th width="70">S No</th>

                    <th>Name</th>

                    <th>Father</th>

                    <th>Phone</th>

                    <th>Class</th>

                    <th>Section</th>

                    <th>Class Teacher</th>

                    <th width="120">Action</th>

                </tr>

            </thead>

        </table>

    </div>

</div>

@endsection



@push('scripts')

<script>

$(document).ready(function(){

    $('#studentTable').DataTable({

        processing:true,

        serverSide:true,

        ajax:"{{ route('students.data') }}",

        columns:[

            {
                data:null,
                orderable:false,
                searchable:false,

                render:function(data,type,row,meta){

                    return meta.row
                        + meta.settings._iDisplayStart
                        + 1;
                }
            },

            {
                data:'first_name',
                name:'first_name'
            },

            {
                data:'father_name',
                name:'father_name'
            },

            {
                data:'phone',
                name:'phone'
            },

            {
                data:'class',
                name:'class'
            },

            {
                data:'section',
                name:'section'
            },

            {
                data:'teacher',
                name:'teacher'
            },

            {
                data:'action',
                orderable:false,
                searchable:false
            }

        ]
    });



    // DELETE
    $(document).on('click','.deleteBtn',function(){

        let id = $(this).data('id');

        if(confirm('Delete this student?')){

            $.ajax({

                url:"{{ url('admin/students') }}/" + id,

                type:'DELETE',

                data:{
                    _token:'{{ csrf_token() }}'
                },

                success:function(){

                    $('#studentTable')
                        .DataTable()
                        .ajax.reload();

                    alert('Student Deleted Successfully');
                }
            });
        }
    });

});

</script>

@endpush