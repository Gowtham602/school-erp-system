@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-mortarboard"></i>
                Add Class
            </h5>

            <a href="{{ route('classes.index') }}"
               class="btn btn-light btn-sm">

                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

        <!-- BODY -->
        <div class="card-body p-4">

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

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('classes.store') }}">

                @csrf

                <!-- CLASS NAME -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Class Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Ex: 10th"
                           value="{{ old('name') }}"
                           required>

                </div>

                <!-- BUTTON -->
                <div class="text-end">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-check-circle"></i>
                        Save Class
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection