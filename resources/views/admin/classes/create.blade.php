@extends('layouts.app')

@section('content')

<div class="card shadow p-4">

    <h5 class="mb-3">Add Class</h5>

    <form method="POST" action="{{ route('classes.store') }}">
        @csrf

        <!-- Class Name -->
        <div class="mb-3">
            <label>Class Name</label>
            <input type="text" name="name" class="form-control" placeholder="Ex: 10th" required>
        </div>

        <!-- Section -->
        <div class="mb-3">
            <label>Section</label>
            <input type="text" name="section" class="form-control" placeholder="Ex: A" required>
        </div>

        <!-- Teacher -->
        <div class="mb-3">
            <label>Class Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>

@endsection