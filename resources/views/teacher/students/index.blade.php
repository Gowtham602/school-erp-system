@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">My Students</h5>

        <button class="btn btn-success" id="addBtn">
            <i class="bi bi-plus"></i> Add Student
        </button>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle" id="studentTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="studentModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <form id="studentForm">
            @csrf
            <input type="hidden" id="student_id">

            <div class="modal-content border-0 shadow">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Student Form</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father Name</label>
                            <input type="text" name="father_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother Name</label>
                            <input type="text" name="mother_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <!-- CLASS -->
                        <div class="col-md-6">
                            <label class="form-label">Class & Section</label>
                            <select name="class_id" class="form-select" required>
                                @foreach($classes as $index => $class)
                                    <option value="{{ $class->id }}" {{ $index == 0 ? 'selected' : '' }}>
                                        {{ $class->name }} - {{ $class->section }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button class="btn btn-primary px-4">Save</button>
                </div>

            </div>
        </form>

    </div>
</div>
@push('scripts')
<script>

let table = $('#studentTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('teacher.students.data') }}",
    columns: [
        {data: 'id'},
        {data: 'name'},
        {data: 'class'},
        {data: 'section'},
        {data: 'action', orderable: false, searchable: false}
    ]
});


// OPEN MODAL (ADD)
$('#addBtn').click(function () {
    $('#studentForm')[0].reset();
    $('#student_id').val('');
    $('#studentModal').modal('show');
});


// SAVE (CREATE + UPDATE)
let updateUrl = "{{ route('teacher.students.update', ':id') }}";
$('#studentForm').submit(function (e) {
    e.preventDefault();

    let id = $('#student_id').val();
    console.log(id,"id for teacher create students ");
       let url = id 
        ? updateUrl.replace(':id', id)
        : "{{ route('teacher.students.store') }}";

    let type = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: type,
        data: $(this).serialize(),
        success: function () {
            $('#studentModal').modal('hide');
            table.ajax.reload();

            Swal.fire('Success', 'Saved Successfully', 'success');
        }
    });
});


// EDIT
$(document).on('click', '.editBtn', function () {

    let id = $(this).data('id');
    let editUrl = "{{ route('teacher.students.edit', ':id') }}";
$.get(editUrl.replace(':id', id), function (data) {

        $('#student_id').val(data.id);

        $('[name="name"]').val(data.name);
        $('[name="father_name"]').val(data.father_name);
        $('[name="mother_name"]').val(data.mother_name);
        $('[name="phone"]').val(data.phone);
        $('[name="address"]').val(data.address);
        $('[name="gender"]').val(data.gender);
        $('[name="class_id"]').val(data.class_id);

        $('#studentModal').modal('show');
    });
});


// DELETE
$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');
    let deleteUrl = "{{ route('teacher.students.delete', ':id') }}";
    Swal.fire({
        title: 'Delete?',
        icon: 'warning',
        showCancelButton: true,
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({                
                url: deleteUrl.replace(':id', id),
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function () {
                    table.ajax.reload();

                    Swal.fire('Deleted!', '', 'success');
                }
            });

        }
    });
});

</script>
@endpush
@endsection