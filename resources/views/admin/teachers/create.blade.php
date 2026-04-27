@extends('layouts.app')

@section('content')

<div class="card shadow p-4">
    <h5>Add Teacher</h5>

    <form method="POST" action="{{ route('teachers.store') }}" class="needs-validation" novalidate>
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
                <div class="invalid-feedback">Enter name</div>
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required pattern="[0-9]{10}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Qualification</label>
                <input type="text" name="qualification" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Experience</label>
                <select name="experience_type" class="form-control" required>
                    <option value="">Select</option>
                    <option value="fresher">Fresher</option>
                    <option value="experienced">Experienced</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

        </div>

        <button class="btn btn-primary">Create Teacher</button>
    </form>
</div>

<script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault()
                e.stopPropagation()
            }
            form.classList.add('was-validated')
        })
    })
})();
</script>

@endsection