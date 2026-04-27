@extends('layouts.app')

@section('content')

<div class="card shadow p-4">

    <h5 class="mb-3">Edit Class</h5>

    <form method="POST" action="{{ route('classes.update', $class->id) }}">
        @csrf
        @method('PUT')

        <!-- Class Name -->
        <div class="mb-3">
            <label>Class Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $class->name }}" required>
        </div>

        <!-- Section -->
        <div class="mb-3">
            <label>Section</label>
            <input type="text" name="section" class="form-control"
                   value="{{ $class->section }}" required>
        </div>

        <!-- Teacher -->
        <div class="mb-3">
            <label>Class Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button  type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>

@endsection