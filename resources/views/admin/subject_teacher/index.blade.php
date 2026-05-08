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

    <div class="card">
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
                            {{ $row->section->class->name }}
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

                            <a href="{{ route('subject-teacher.edit',$row->id) }}"
                                class="btn btn-success btn-sm">
                                Edit
                            </a>

                            <button
                                class="btn btn-danger btn-sm deleteBtn"
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

@section('scripts')

<script>

$('.deleteBtn').click(function(){

    let id = $(this).data('id');

    if(confirm('Delete ?')){

        $.ajax({

            url:'/subject-teacher/'+id,

            type:'DELETE',

            data:{
                _token:'{{ csrf_token() }}'
            },

            success:function(res){

                $('#row'+id).remove();

                alert(res.message);

            }

        });

    }

});

</script>

@endsection