@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- PAGE HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            Subjects
        </h4>

        <a href="{{ route('subjects.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>

            Add Subject

        </a>

    </div>



    <!-- TABLE -->

    <div class="card shadow border-0">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="80">S.No</th>

                        <th>Class</th>

                        <th>Subject</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($subjects as $key => $subject)

                    <tr>

                        <td>
                            {{ ++$key }}
                        </td>

                        <td>
                            {{ $subject->classModel->name }}
                        </td>

                        <td>
                            {{ $subject->name }}
                        </td>

                        <td>

                            <!-- EDIT -->

                            <a href="{{ route('subjects.edit',$subject->id) }}"
                               class="btn btn-success btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>



                            <!-- DELETE -->

                            <form action="{{ route('subjects.destroy',$subject->id) }}"
                                  method="POST"
                                  class="d-inline deleteForm">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center text-muted">

                            No Subjects Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<!-- SUCCESS MESSAGE -->

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Success',

    text: '{{ session('success') }}',

    timer: 2000,

    showConfirmButton: false

});

</script>

@endif



<!-- DELETE CONFIRM -->

<script>

$(document).ready(function(){

    $('.deleteForm').submit(function(e){

        e.preventDefault();

        let form = this;

        Swal.fire({

            title: 'Are you sure?',

            text: "You won't be able to revert this!",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });

});

</script>

@endpush