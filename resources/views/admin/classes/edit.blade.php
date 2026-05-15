@extends('layouts.app')

@section('content')

<div class="card shadow p-4">

    <h5 class="mb-3">Edit Class</h5>
        <!-- VALIDATION -->
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

    <form method="POST" action="{{ route('classes.update', $class->id) }}">
        @csrf
        @method('PUT')

        <!-- Class Name -->
        <div class="mb-3">
            <label>Class Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $class->name }}" required>
        </div>

          

        <button  type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>

@endsection