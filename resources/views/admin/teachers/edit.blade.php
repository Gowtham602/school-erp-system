{{-- resources/views/admin/teachers/edit.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">

            Edit Teacher

        </h5>

    </div>

    <div class="card-body">

        <form id="teacherEditForm">

            @csrf

            @method('PUT')

            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Name

                    </label>

                    <input type="text"
                           name="name"

                           value="{{ optional($teacher->user)->name }}"

                           class="form-control">

                    <div class="invalid-feedback"></div>

                </div>


                <!-- EMAIL -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <input type="email"
                           name="email"

                           value="{{ optional($teacher->user)->email }}"

                           class="form-control">

                    <div class="invalid-feedback"></div>

                </div>


                <!-- PHONE -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Phone

                    </label>

                    <input type="text"
                           name="phone"

                           value="{{ $teacher->phone }}"

                           class="form-control">

                    <div class="invalid-feedback"></div>

                </div>


                <!-- GENDER -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Gender

                    </label>

                    <select name="gender"
                            class="form-select">

                        <option value="">

                            Select Gender

                        </option>

                        <option value="male"
                            {{ $teacher->gender == 'male' ? 'selected' : '' }}>

                            Male

                        </option>

                        <option value="female"
                            {{ $teacher->gender == 'female' ? 'selected' : '' }}>

                            Female

                        </option>

                    </select>

                    <div class="invalid-feedback"></div>

                </div>


                <!-- QUALIFICATION -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Qualification

                    </label>

                    <input type="text"
                           name="qualification"

                           value="{{ $teacher->qualification }}"

                           class="form-control">

                    <div class="invalid-feedback"></div>

                </div>

            </div>


            <button class="btn btn-primary">

                Update Teacher

            </button>

        </form>

    </div>

</div>


@push('scripts')

<script>

$(document).ready(function(){

    /*
    |--------------------------------------------------------------------------
    | REMOVE ERROR WHILE TYPING
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'keyup change',
        'input,select,textarea',
        function(){

            $(this)
                .removeClass('is-invalid');

            $(this)
                .next('.invalid-feedback')
                .html('');
        }
    );


    /*
    |--------------------------------------------------------------------------
    | PHONE VALIDATION
    |--------------------------------------------------------------------------
    */

    $('input[name="phone"]').on('input', function(){

        let value = $(this).val();

        value = value.replace(/\D/g,'');

        $(this).val(value);

        if(value.length != 10)
        {
            $(this)
                .addClass('is-invalid');

            $(this)
                .next('.invalid-feedback')
                .html('Phone must be 10 digits');
        }
    });


    /*
    |--------------------------------------------------------------------------
    | EMAIL VALIDATION
    |--------------------------------------------------------------------------
    */

    $('input[name="email"]').on('input', function(){

        let email = $(this).val();

        let pattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(!pattern.test(email))
        {
            $(this)
                .addClass('is-invalid');

            $(this)
                .next('.invalid-feedback')
                .html('Invalid Email');
        }
    });


    /*
    |--------------------------------------------------------------------------
    | UPDATE AJAX
    |--------------------------------------------------------------------------
    */

    $('#teacherEditForm').submit(function(e){

        e.preventDefault();

        let form = $(this);

        $.ajax({

            url:"{{ route('teachers.update',$teacher->id) }}",

            type:'POST',

            data:form.serialize(),

            success:function(response){

                Swal.fire({

                    icon:'success',

                    title:'Success',

                    text:response.message,

                    timer:1500,

                    showConfirmButton:false
                });

                setTimeout(function(){

                    window.location.href =
                        "{{ route('teachers.index') }}";

                },1500);
            },

            error:function(xhr){

                if(xhr.status == 422)
                {
                    let errors =
                        xhr.responseJSON.errors;

                    $.each(errors,function(field,msg){

                        $('[name="'+field+'"]')
                            .addClass('is-invalid');

                        $('[name="'+field+'"]')
                            .next('.invalid-feedback')
                            .html(msg[0]);
                    });
                }
            }
        });
    });

});

</script>

@endpush

@endsection