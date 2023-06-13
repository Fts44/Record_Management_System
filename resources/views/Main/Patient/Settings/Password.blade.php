@extends('Layouts.Main')

@push('Sidebar')
    @include('Components.Patient.Sidebar')
@endpush

@push('Header')
    @include('Components.Patient.Header')
@endpush

@section('Content')
<!-- Container fluid -->
<div class="container-fluid py-6 px-3">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page header -->
                    <div class="border-bottom pb-4 mb-4">              
                        <h3 class="mb-0 fw-bold">Change Password</h3>      
                    </div>
            </div>
        </div>

        <div class="row mb-8">
            <div class="col-12">
                <div class="mb-4">
                    <h4>Password</h4>
                    <p class="fs-5 text-muted">Enter your new password below.</p>
                </div>
            </div>

            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <form id="password_form">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                            @method('PUT')
                            
                            <!-- Old Password -->
                            <div class="row mt-2 d-flex justify-content-center">
                                <div class="col-lg-6 mb-3">
                                    <label class="col-12 mb-1 form-label">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-right password"
                                            name="old_password"
                                            id="password-old_password">
                                        <button class="input-group-text btn_show_password" type="button">
                                            <i class="show-password-icon bi bi-eye-slash"></i>
                                        </button>
                                        <span class="mt-1 invalid-feedback" id="password-old_password-error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-6 mb-3">
                                    <label class="col-12 mb-1 form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-right password"
                                            name="new_password"
                                            id="password-new_password">
                                        <button class="input-group-text btn_show_password" type="button">
                                            <i class="show-password-icon bi bi-eye-slash"></i>
                                        </button>
                                        <span class="mt-1 invalid-feedback" id="password-new_password-error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Retype new password -->
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-6 mb-3">
                                    <label class="col-12 mb-1 form-label">Retype New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-right password"
                                            name="retype_new_password"
                                            id="password-retype_new_password">
                                        <button class="input-group-text btn_show_password" type="button">
                                            <i class="show-password-icon bi bi-eye-slash"></i>
                                        </button>
                                        <span class="mt-1 invalid-feedback" id="password-retype_new_password-error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Changes -->
                            <div class="row mt-2 d-flex justify-content-center">
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button class="btn btn-primary w-75" type="button" id="password_form_submit">
                                                <label>Save Changes</label>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>  
    </div>
@endsection

@push('script')
    <script>
        $('.btn_show_password').click(function(){
            show_password('.password');
        });

        $('#password_form_submit').click(function(){
            reset_input_errors();
            load_btn('#password_form_submit',true);
            var formData = new FormData($('#password_form')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Password.Update') }}",
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
                            $('#password-'+key+'-error').html(err_values);
                            $('#password-'+key).addClass('is-invalid');
                        });
                    }
                    else if(response.status == 200){
                        $('#password_form input.form-control').val('');
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#password_form_submit',false);
            });
        });
    </script>
@endpush