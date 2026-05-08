@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-diagram-3"></i>
                Sections
            </h5>

            <a href="{{ route('sections.create') }}"
               class="btn btn-light btn-sm">

                <i class="bi bi-plus-circle"></i>
                Add Section
            </a>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle"
                   id="sectionTable">

                <thead class="table-dark">

                    <tr>

                        <th width="80">SNo</th>

                        <th>Class</th>

                        <th>Section</th>

                        <th>Class Teacher</th>

                        <th width="120">Action</th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

$(document).ready(function(){

    $('#sectionTable').DataTable({

        processing:true,
        serverSide:true,

        ajax:"{{ route('sections.data') }}",

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
                data:'class_name',
                name:'class_name'
            },

            {
                data:'name',
                name:'name'
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

        if(confirm('Delete this section?')){

            $.ajax({

                url:"{{ url('admin/sections') }}/" + id,

                type:'DELETE',

                data:{
                    _token:'{{ csrf_token() }}'
                },

                success:function(){

                    $('#sectionTable')
                        .DataTable()
                        .ajax.reload();
                }
            });
        }
    });

});

</script>

@endpush