@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">
            <h4>Edit Subject</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('subjects.update',$subject->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                <!-- CLASS -->

                <div class="mb-3">

                    <label>Class</label>

                    <select name="class_id"
                            class="form-control @error('class_id') is-invalid @enderror">

                        @foreach($classes as $class)

                        <option value="{{ $class->id }}"
                            {{ $subject->class_id == $class->id ? 'selected' : '' }}>

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

                    <input type="text"
                           name="name"
                           value="{{ old('name',$subject->name) }}"
                           class="form-control @error('name') is-invalid @enderror">

                    @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>



                <button type="submit"
                        class="btn btn-success">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection