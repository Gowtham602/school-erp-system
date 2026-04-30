@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">My Subjects</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-primary">
                        <tr>
                            <th style="width:80px;">S.No</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Section</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subjects as $key => $subject)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $subject->name }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $subject->class->name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $subject->class->section }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted">
                                No subjects assigned
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection