@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4">Dashboard</h4>

    <!-- STATS CARDS -->
    <div class="row g-3">

        <div class="col-md-3 col-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 text-center hover-card">
                    <i class="bi bi-people fs-2 text-primary"></i>
                    <h5 class="mt-2 text-dark">{{ $students }}</h5>
                    <small class="text-muted">Students</small>
                </div>
            </a>
        </div>
        

        <!-- Teachers -->
        <div class="col-md-3 col-6">
            <a href="{{ route('teachers.index') }}" class="text-decoration-none">
        <div class="card shadow-sm p-3 text-center">
                <i class="bi bi-person-badge fs-2 text-success"></i>
                <h5 class="mt-2">{{ $teachers }}</h5>
                <small>Teachers</small>
            </div>
        
        </a>
            
        </div>

        <!-- Classes -->
        <div class="col-md-3 col-6">

        <a href="{{ route('classes.index') }}" class="text-decoration-none">
             <div class="card shadow-sm p-3 text-center">
                <i class="bi bi-building fs-2 text-warning"></i>
                <h5 class="mt-2">{{ $classes }}</h5>
                <small>Classes</small>
            </div>
        </a>
           
        </div>

        <!-- Sections -->
        <div class="col-md-3 col-6">
            <div class="card shadow-sm p-3 text-center">
                <i class="bi bi-diagram-3 fs-2 text-danger"></i>
                <h5 class="mt-2">{{ $sections }}</h5>
                <small>Sections</small>
            </div>
        </div>

    </div>

    <!-- RECENT STUDENTS -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            Recent Students
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentStudents as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->class->name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection