@extends('layouts.app')

@section('content')

<div class="card p-4 shadow-sm">

    <h5 class="mb-3">Edit Student</h5>

    <form method="POST" action="{{ route('students.update', $student->id) }}" id="studentForm">
    @csrf
    @method('PUT')

    <!-- Name -->
    <input type="text" name="name" class="form-control mb-3"
           value="{{ $student->name }}" placeholder="Student Name">

    <!-- Father -->
    <input type="text" name="father_name" class="form-control mb-3"
           value="{{ $student->father_name }}" placeholder="Father Name">

    <!-- Mother -->
    <input type="text" name="mother_name" class="form-control mb-3"
           value="{{ $student->mother_name }}" placeholder="Mother Name">

    <!-- Phone -->
    <input type="text" name="phone" class="form-control mb-3"
           value="{{ $student->phone }}" placeholder="Phone">

    <!-- Address -->
    <textarea name="address" class="form-control mb-3"
        placeholder="Address">{{ $student->address }}</textarea>

    <!-- Gender -->
    <select name="gender" class="form-control mb-3">
        <option value="">Select Gender</option>
        <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
        <option value="other" {{ $student->gender == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    <!-- Class -->
    <select id="classSelect" class="form-control mb-3">
        <option value="">Select Class</option>
        @foreach($classes as $className => $group)
            <option value="{{ $className }}"
                {{ $student->class->name == $className ? 'selected' : '' }}>
                {{ $className }}
            </option>
        @endforeach
    </select>

    <!-- Section -->
    <select name="class_id" id="sectionSelect" class="form-control mb-3">
        <option value="">Select Section</option>
    </select>

    <!-- Buttons -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </div>

    </form>

</div>

@endsection