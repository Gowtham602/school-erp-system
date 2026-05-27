@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="row g-4 mb-4">

        <!-- WELCOME CARD -->

        <div class="col-md-8">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div
                        class="d-flex justify-content-between
                               align-items-center flex-wrap">

                        <div>

                            <h2 class="fw-bold mb-2">

                                Teacher Dashboard

                            </h2>

                            <p class="text-muted mb-0">

                                Welcome back,

                                <span class="fw-semibold text-dark">

                                    {{ auth()->user()->name }}

                                </span>

                            </p>

                        </div>



                        <!-- LIVE IST CLOCK -->

                        <div class="text-end mt-3 mt-md-0">

                            <h3
                                class="fw-bold text-primary mb-1"
                                id="istClock">

                            </h3>

                            <small class="text-muted">

                                {{ now()->format('l, d M Y') }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- CLASS TEACHER CARD -->

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div
                        class="d-flex justify-content-between
                               align-items-center mb-3">

                        <h5 class="fw-bold mb-0">

                            My Classes

                        </h5>

                        <span
                            class="badge bg-primary rounded-pill px-3 py-2">

                            {{ $classTeachers->count() }}

                        </span>

                    </div>



                    @forelse($classTeachers as $classTeacher)

                    <div
                        class="border rounded-4 p-3 mb-3 bg-light">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-primary text-white
                                       rounded-circle d-flex
                                       align-items-center
                                       justify-content-center me-3"
                                style="width:45px;height:45px;">

                                <i class="bi bi-mortarboard"></i>

                            </div>



                            <div>

                                <h6 class="fw-bold mb-1">

                                    {{ $classTeacher->classModel->name ?? '-' }}

                                </h6>

                                <small class="text-muted">

                                    Section :
                                    {{ $classTeacher->section->name ?? '-' }}

                                </small>

                            </div>

                        </div>

                    </div>

                    @empty

                    <div
                        class="alert alert-warning rounded-4 mb-0">

                        No Class Assigned

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- STATISTICS -->
    <!-- ===================================================== -->

    <div class="row g-4">

        <!-- STUDENTS -->

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Students

                            </small>

                            <h2 class="fw-bold mt-2">

                                {{ $studentsCount }}

                            </h2>

                        </div>

                        <div
                            class="bg-primary bg-opacity-10
                                   text-primary rounded-circle
                                   d-flex align-items-center
                                   justify-content-center"
                            style="width:60px;height:60px;">

                            <i class="bi bi-people-fill fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- SUBJECTS -->

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Subjects

                            </small>

                            <h2 class="fw-bold mt-2">

                                {{ $subjectsCount }}

                            </h2>

                        </div>

                        <div
                            class="bg-success bg-opacity-10
                                   text-success rounded-circle
                                   d-flex align-items-center
                                   justify-content-center"
                            style="width:60px;height:60px;">

                            <i class="bi bi-book-half fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- SECTIONS -->

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Assigned Sections

                            </small>

                            <h2 class="fw-bold mt-2">

                                {{ $sectionsCount }}

                            </h2>

                        </div>

                        <div
                            class="bg-warning bg-opacity-10
                                   text-warning rounded-circle
                                   d-flex align-items-center
                                   justify-content-center"
                            style="width:60px;height:60px;">

                            <i class="bi bi-diagram-3 fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- QUICK ACTIONS -->
    <!-- ===================================================== -->

    <div class="card border-0 shadow-sm rounded-4 mt-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">

                Quick Actions

            </h5>

            <div class="row g-3">

                <div class="col-md-3">

                    <a href="{{ route('teacher.students.index') }}"
                       class="btn btn-primary w-100 py-3 rounded-4">

                        <i class="bi bi-people-fill me-2"></i>

                        Manage Students

                    </a>

                </div>



                <div class="col-md-3">

                    <a href="{{ route('teacher.subjects') }}"
                       class="btn btn-success w-100 py-3 rounded-4">

                        <i class="bi bi-book-half me-2"></i>

                        My Subjects

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

function updateISTClock()
{
    const now = new Date();

    const options = {

        timeZone: 'Asia/Kolkata',

        hour: '2-digit',

        minute: '2-digit',

        second: '2-digit',

        hour12: true
    };

    const time = now.toLocaleTimeString(
        'en-IN',
        options
    );

    document.getElementById('istClock')
        .innerHTML = time;
}

setInterval(updateISTClock, 1000);

updateISTClock();

</script>

@endpush