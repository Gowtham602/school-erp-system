@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-pencil-square"></i>
                Edit Section

            </h5>

            <a href="{{ route('sections.index') }}"
               class="btn btn-light btn-sm">

                Back

            </a>

        </div>

        <!-- BODY -->
        <div class="card-body p-4">

            <form action="{{ route('sections.update', $section->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- CLASS -->
                <div class="mb-3">

                    <label class="form-label">
                        Class
                    </label>

                    <select name="class_id"
                            class="form-select @error('class_id') is-invalid @enderror"
                            required>

                        <option value="">
                            Select Class
                        </option>

                        @foreach($classes as $class)

                            <option value="{{ $class->id }}"
                                {{ $section->class_id == $class->id ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('class_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- SECTION -->
                <div class="mb-3">

                    <label class="form-label">
                        Section
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $section->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- TEACHER -->
                <div class="mb-3">

                    <label class="form-label">
                        Class Teacher
                    </label>

                    <select name="class_teacher_id"
                            class="form-select @error('class_teacher_id') is-invalid @enderror">

                        <option value="">
                            Select Teacher
                        </option>

                        @foreach($teachers as $teacher)

                            <option value="{{ $teacher->id }}"
                                {{ $section->class_teacher_id == $teacher->id ? 'selected' : '' }}>

                                {{ $teacher->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('class_teacher_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- BUTTON -->
                <div class="text-end">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>
                        Update Section

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection