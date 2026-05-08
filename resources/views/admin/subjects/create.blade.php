@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">
            <h4>Add Subject</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('subjects.store') }}"  method="POST">
                @csrf
                <!-- CLASS -->
               <div class="mb-3">
                    <label>Class</label>
                    <select name="class_id"  class="form-control @error('class_id') is-invalid @enderror">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">
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
                <!-- SUBJECT -->
                <div class="mb-3">
                    <label>Subject Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!-- BUTTON -->
                <button type="submit" class="btn btn-primary">    Save Subject   </button>

            </form>
        </div>
    </div>
</div>

@endsection