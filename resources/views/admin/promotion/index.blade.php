@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    <div class="row">

        <!--  LEFT: PROMOTION FORM -->
        <div class="col-md-5">

            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-mortarboard-fill"></i> Promotion Panel
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('promotion.store') }}">
                        @csrf

                        <!-- FROM -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-arrow-down-circle"></i> From Class
                            </label>
                            <select name="from_class" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->name }} - {{ $class->section }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TO -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-arrow-up-circle"></i> To Class
                            </label>
                            <select name="to_class" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->name }} - {{ $class->section }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-success w-100">
                            <i class="bi bi-rocket-takeoff"></i> Promote Students
                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!--  RIGHT: HISTORY TABLE -->
        <div class="col-md-7">

            <div class="card shadow border-0">

                <div class="card-header bg-dark text-white">
                    <i class="bi bi-clock-history"></i> Recent Promotion History
                </div>

                <div class="card-body p-0">

                    <table class="table table-bordered table-hover mb-0 text-center align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Old Class</th>
                                <th>Section</th>
                                <th>Year</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($histories as $key => $history)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td class="fw-semibold">
                                    {{ $history->student->name ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $history->class->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $history->class->section }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        {{ $history->academic_year }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-muted">
                                    No history found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection