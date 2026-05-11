@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h4>Subject Teacher</h4> 
        <a href="{{ route('subject-teacher.create') }}"
           class="btn btn-primary">
            Add
        </a>
    </div>



    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjectTeachers as $key => $row)

                    <tr id="row{{ $row->id }}">

                        <td>{{ ++$key }}</td>

                        <td>
                            {{ $row->section->classModel->name }}
                        </td>

                        <td>
                            {{ $row->section->name }}
                        </td>

                        <td>
                            {{ $row->subject->name }}
                        </td>

                        <td>
                            {{ $row->teacher->name }}
                        </td>

                        <td>
                            <!-- EDIT -->
                            <a href="{{ route('subject-teacher.edit',$row->id) }}"
                               class="btn btn-success btn-sm">
                                Edit
                            </a>
                            <!-- DELETE -->
                            <button
                                class="btn btn-danger btn-sm deleteBtn"
                                data-url="{{ route('subject-teacher.destroy',$row->id) }}"
                                data-id="{{ $row->id }}">

                                Delete

                            </button>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection




@push('scripts')

<script>

$('.deleteBtn').click(function(){

    let url = $(this).data('url');

    let id  = $(this).data('id');

    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#3085d6',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: url, 

                type: 'POST',

                data: {

                    _token: '{{ csrf_token() }}',

                    _method: 'DELETE'

                },

                success:function(res){

                    $('#row'+id).remove();

                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted',

                        text: 'Deleted Successfully',

                        timer: 2000,

                        showConfirmButton: false

                    });

                }

            });

        }

    });

});     

</script>

@endpush