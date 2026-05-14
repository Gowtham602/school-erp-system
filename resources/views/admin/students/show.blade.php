@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">

            <h4 class="mb-0 fw-bold">

                <i class="bi bi-person-vcard me-2"></i>
                Student Details

            </h4>

            <a href="{{ route('students.index') }}"
               class="btn btn-light btn-sm rounded-pill px-3">

                <i class="bi bi-arrow-left"></i>
                Back

            </a>

        </div>


        <!-- BODY -->
        <div class="card-body bg-light p-4">

            <div class="row g-4">

                <!-- LEFT SIDE -->
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <div class="card-body text-center">

                            <!-- PHOTO -->
                            <div class="mb-3">

                                @if($student->photo)

                                    <img src="{{ asset('storage/'.$student->photo) }}"
                                         class="rounded-circle shadow"
                                         width="140"
                                         height="140"
                                         style="object-fit:cover;">

                                @else

                                    <img src="https://ui-avatars.com/api/?name={{ $student->first_name }}"
                                         class="rounded-circle shadow"
                                         width="140"
                                         height="140">

                                @endif

                            </div>

                            <h4 class="fw-bold mb-1">

                                {{ $student->first_name }}
                                {{ $student->last_name }}

                            </h4>

                            <p class="text-muted mb-2">

                                Admission No :
                                <strong>{{ $student->admission_no }}</strong>

                            </p>

                            <span class="badge bg-success px-3 py-2">

                                {{ ucfirst($student->status) }}

                            </span>

                        </div>

                    </div>

                </div>


                <!-- RIGHT SIDE -->
                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body">

                            <div class="row">

                                <!-- PHONE -->
                                <div class="col-md-6 mb-4">

                                    <label class="text-muted small">
                                        Phone
                                    </label>

                                    <h6 class="fw-bold">
                                        {{ $student->phone }}
                                    </h6>

                                </div>


                                <!-- GENDER -->
                                <div class="col-md-6 mb-4">

                                    <label class="text-muted small">
                                        Gender
                                    </label>

                                    <h6 class="fw-bold">
                                        {{ ucfirst($student->gender) }}
                                    </h6>

                                </div>


                                <!-- FATHER -->
                                <div class="col-md-6 mb-4">

                                    <label class="text-muted small">
                                        Father Name
                                    </label>

                                    <h6 class="fw-bold">
                                        {{ $student->father_name }}
                                    </h6>

                                </div>


                                <!-- MOTHER -->
                                <div class="col-md-6 mb-4">

                                    <label class="text-muted small">
                                        Mother Name
                                    </label>

                                    <h6 class="fw-bold">
                                        {{ $student->mother_name }}
                                    </h6>

                                </div>


                                <!-- CLASS -->
                                <div class="col-md-4 mb-4">

                                    <label class="text-muted small">
                                        Class
                                    </label>

                                    <h6 class="fw-bold">

                                        {{ $student->currentAcademic->section->class->name ?? '-' }}

                                    </h6>

                                </div>


                                <!-- SECTION -->
                                <div class="col-md-4 mb-4">

                                    <label class="text-muted small">
                                        Section
                                    </label>

                                    <h6 class="fw-bold">

                                        {{ $student->currentAcademic->section->name ?? '-' }}

                                    </h6>

                                </div>


                                <!-- TEACHER -->
                                <div class="col-md-4 mb-4">

                                    <label class="text-muted small">
                                        Class Teacher
                                    </label>

                                    <h6 class="fw-bold">

                                        {{ $student->currentAcademic->section->classTeacher->teacher->name ?? '-' }}

                                    </h6>

                                </div>


                                <!-- ADDRESS -->
                                <div class="col-md-12 mb-2">

                                    <label class="text-muted small">
                                        Address
                                    </label>

                                    <div class="bg-white border rounded-3 p-3">

                                        {{ $student->address }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection