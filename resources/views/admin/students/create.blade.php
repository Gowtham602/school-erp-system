@extends('layouts.app')

@section('content')

<div class="card p-4 shadow-sm">

    <h5 class="mb-3">Add Student</h5>

    <form method="POST" action="{{ route('students.store') }}" id="studentForm">  
    @csrf

    <!-- Name -->
    <input type="text" name="name" class="form-control mb-3" placeholder="Student Name">

    <!-- Father -->
    <input type="text" name="father_name" class="form-control mb-3" placeholder="Father Name">

    <!-- Mother -->
    <input type="text" name="mother_name" class="form-control mb-3" placeholder="Mother Name">

    <!-- Phone -->
    <input type="text" name="phone" class="form-control mb-3" placeholder="Phone">

    <!-- Address -->
    <textarea name="address" class="form-control mb-3" placeholder="Address"></textarea>

    <!-- Gender -->
    <select name="gender" class="form-control mb-3">
        <option value="">Select Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>

    <!-- Class -->
    <select id="classSelect"  name="class_name"  class="form-control mb-3">
        <option value="">Select Class</option>
        @foreach($classes as $className => $group)
            <option value="{{ $className }}">{{ $className }}</option>
        @endforeach
    </select>

    <!-- Section -->
    <select name="class_id" id="sectionSelect" class="form-control mb-3" disabled>
        <option value="">Select Section</option>
    </select>

    <!-- Buttons -->
    <div class="d-flex gap-2">
        <button type="submit"  class="btn btn-success">Save</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </div>

    </form>

</div>
@push('scripts')

<script>
$(document).ready(function () {

    let classData = @json($classes);

    // STOP NORMAL SUBMIT
    $('#studentForm').on('submit', function(e) {
        e.preventDefault();
    });

    // SECTION DROPDOWN
    $('#classSelect').change(function () {

        let selectedClass = $(this).val();
        let sectionDropdown = $('#sectionSelect');

        sectionDropdown.html('<option value="">Select Section</option>');

        if (!selectedClass) {
            sectionDropdown.prop('disabled', true);
            return;
        }

        let sections = classData[selectedClass];

        if (sections) {
            sections.forEach(function (item) {
                sectionDropdown.append(
                    `<option value="${item.id}">${item.section}</option>`
                );
            });
        }

        sectionDropdown.prop('disabled', false);
    });

    // VALIDATION
    $('#studentForm').validate({

        rules: {
            name: "required",
            father_name: "required",
            mother_name: "required",
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            address: "required",
            gender: "required",
            class_id: "required"
        },

        messages: {
            name: "Enter student name",
            father_name: "Enter father name",
            mother_name: "Enter mother name",
            phone: "Enter valid 10 digit number",
            address: "Enter address",
            gender: "Select gender",
            class_id: "Select section"
        },

        errorClass: 'text-danger',

        submitHandler: function(form) {

            let btn = $(form).find('button[type="submit"]');
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('students.store') }}",
                type: "POST",
                data: $(form).serialize(),

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    }).then(() => {
                        window.location.href = "{{ route('students.index') }}";
                    });
                },

                error: function(xhr) {

                    let msg = '';

                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            msg += value[0] + '<br>';
                        });
                    } else {
                        msg = "Something went wrong!";
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: msg
                    });

                    btn.prop('disabled', false).text('Save');
                }
            });

            return false;
        }
    });

});
</script>

@endpush
@endsection
