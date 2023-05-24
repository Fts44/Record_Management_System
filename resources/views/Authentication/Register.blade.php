@extends('Layouts.Authentication')


@push('title')
    Registration - Health Services Portal
@endpush


@section('content')
    <!-- Form -->
    <form id="form_registration">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

        <!-- email -->
        <div class="mb-3">
            <label for="register_input_email" class="form-label">Email</label>
            <input name="email" id="register_input_email" type="email" class="form-control">
            <span class="mt-1 invalid-feedback" id="register_input_email_error"></span>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="register_input_password" class="form-label">Password</label>
            <div class="input-group">
                <input name="password" id="register_input_password" type="password" class="form-control rounded-right register-password">
                <button class="input-group-text register_btn_show_password" type="button">
                    <i class="show-password-icon bi bi-eye-slash" id="login_lbl_show_password"></i>
                </button>
                <span class="mt-1 invalid-feedback" id="register_input_password_error"></span>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="register_input_confirm_password" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input name="confirm_password" id="register_input_confirm_password" type="password" class="form-control rounded-right register-password">
                <button class="input-group-text register_btn_show_password" type="button">
                    <i class="show-password-icon bi bi-eye-slash" id="login_lbl_show_password"></i>
                </button>
                <span class="mt-1 invalid-feedback" id="register_input_confirm_password_error"></span>
            </div>
           
        </div>

         <!-- classification -->
         <div class="mb-3">
            <label for="register_input_classification" class="form-label">Classification</label>
            <select name="classification" id="register_input_classification" class="form-select">
                <option value="">--- choose ---</option>
                <option value="patient">Patient</option>
                <option value="infirmary personnel">Infirmary Personnel</option>
            </select>
            <span class="mt-1 invalid-feedback" id="register_input_classification_error"></span>
        </div>

        <!-- position -->
        <div class="mb-3">
            <label for="register_input_position" class="form-label">Position</label>
            <select name="position" id="register_input_position" class="form-select">
                <option value="">--- choose ---</option>
            </select>
            <span class="mt-1 invalid-feedback" id="register_input_position_error"></span>
        </div>

        <div>
            <!-- Button -->
            <div class="d-grid">
                <button type="button" class="btn btn-primary" id="register_btn_submit">
                    <label>Register</label>
                </button>
            </div>

            <div class="d-md-flex justify-content-between mt-3">
                <div class="mb-2 mb-md-0">
                    <a href="{{ route('Authentication.Login.Index') }}" class="fs-5">
                        Already have an Account?
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $('.register_btn_show_password').click(function(){
            show_password('.register-password');
        });

        $('#register_input_classification').change(function(){
            $('#register_input_position').empty();
            if($(this).val()=='infirmary personnel'){
                var option = "<option value=''>--- Choose ---</option><option value='nurse'>Nurse</option><option value='doctor'>Doctor</option><option value='dentist'>Dentist</option>";         
            }
            else{
                var option = "<option value=''>--- Choose ---</option><option value='student'>Student</option><option value='teacher'>Teacher</option><option value='school personnel'>School Personnel</option>";         
            }
            $('#register_input_position').html(option);
        });

        $('#register_btn_submit').click(function(){
            reset_input_errors();
            load_btn('#register_btn_submit',true);
            var formData = new FormData($('#form_registration')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Authentication.Register.Create') }}",
                contentType: false,
                processData: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);
                    swal(response.title, response.message, response.icon);
                    if(response.status == 400){
                        $.each(response.errors, function(key, err_values){
                            $('#register_input_'+key+'_error').html(err_values);
                            $('#register_input_'+key).addClass('is-invalid');
                        });
                    }
                    else{
                        $('#form_registration input.form-control, #form_registration select.form-select').val('');
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#register_btn_submit',false);
            });
        });
    </script>
@endpush