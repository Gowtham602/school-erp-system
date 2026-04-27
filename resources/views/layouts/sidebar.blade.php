<div class="bg-primary text-white h-100">

    <div class="p-3">

        <h5 class="text-center mb-4 fw-bold">Menu</h5>

        <!-- ADMIN -->
        @if(auth()->user()->role == 'admin')

        <a href={{ route('admin.dashboard') }} class="sidebar-link">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="{{ route('teachers.index') }}" class="sidebar-link">
            <i class="bi bi-person-badge me-2"></i> Teachers
        </a>
        <a href="{{ route('classes.index') }}" class="sidebar-link">
            <i class="bi bi-mortarboard-fill"></i> Classes 
        </a>

        <a href="{{ route('students.index') }}" class="sidebar-link">
            <i class="bi bi-people me-2"></i> Students
        </a>

        <!-- <a href="#" class="sidebar-link">
            <i class="bi bi-building me-2"></i> Classes
        </a> -->

        @endif

        <!-- TEACHER -->
        @if(auth()->user()->role == 'teacher')

        
<a href="{{ url('/teacher/dashboard') }}" class="sidebar-link">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard
</a>

<a href="{{ route('teacher.students.index') }}" class="sidebar-link">
    <i class="bi bi-people me-2"></i> My Students
</a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-calendar-check me-2"></i> Attendance
        </a>

        @endif

        <!-- STUDENT -->
        @if(auth()->user()->role == 'student')

        <a href="/student/dashboard" class="sidebar-link">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-person-circle me-2"></i> Profile
        </a>

        @endif

    </div>

</div>