@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

        <div class="card-body bg-primary bg-gradient text-white py-4 px-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-book-half me-2"></i>

                        My Subjects

                    </h3>

                    <small class="opacity-75">

                        View assigned subjects professionally

                    </small>

                </div>

                <span class="badge bg-light text-primary rounded-pill px-3 py-2">

                    {{ $subjects->count() }} Subjects

                </span>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- TABLE -->
    <!-- ===================================================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle text-center">

                    <thead class="table-dark">

                        <tr>

                            <th width="80">
                                S.No
                            </th>

                            <th>
                                Subject
                            </th>

                            <th>
                                Class
                            </th>

                            <th>
                                Section
                            </th>

                        </tr>

                    </thead>

                    <tbody>

    @forelse($subjects as $key => $subject)

        <tr>

            <td>

                {{ $key + 1 }}

            </td>



            <td class="fw-semibold">

                {{ $subject->subject->name ?? '-' }}

            </td>



            <td>

                <span class="badge bg-info rounded-pill px-3 py-2">

                    {{ $subject->subject->classModel->name ?? '-' }}

                </span>

            </td>



            <td>

                <span class="badge bg-secondary rounded-pill px-3 py-2">

                    {{ $subject->section->name ?? '-' }}

                </span>

            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="4"
                class="text-center text-muted py-5">

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