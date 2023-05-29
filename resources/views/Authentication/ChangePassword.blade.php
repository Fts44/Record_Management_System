@extends('Layouts.Authentication')


@push('title')
    Login - Health Services Portal
@endpush


@section('content')
    <!-- Form -->
    <form id="form_change_password">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    
        @method('PUT')
        <!-- New Password -->
        <div class="mb-3">
            <label for="change_password_input_new_password" class="form-label">New Password</label>
            <div class="input-group">
                <input type="password" id="change_password_input_new_password" class="form-control rounded-right password" name="new password">
                <button class="input-group-text" type="button" id="change_password_btn_show_password">
                    <i class="show-password-icon bi bi-eye-slash" id="change_password_lbl_show_password"></i>
                </button>
                <span class="mt-1 invalid-feedback" id="change_password_input_new_password_error"></span>
            </div>
        </div>

       <!-- Password -->
       <div class="mb-3">
            <label for="change_password_input_confirm_password" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" id="change_password_input_confirm_password" class="form-control rounded-right password" name="confirm password">
                <button class="input-group-text" type="button" id="change_password_btn_show_password">
                    <i class="show-password-icon bi bi-eye-slash" id="change_password_lbl_show_password"></i>
                </button>
                <span class="mt-1 invalid-feedback" id="change_password_input_confirm_password_error"></span>
            </div>
        </div>

        <div>
            <!-- Button -->
            <div class="d-grid">
                <button type="button" id="change_password_btn_submit" class="btn btn-primary">
                    <label>Get Recovery Link</label>
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
        $('#change_password_btn_show_password').click(function(){
            show_password('#change_password_input_new_password, #change_password_input_confirm_password');
        });

        $('#change_password_btn_submit').click(function(){
            reset_input_errors();
            load_btn('#change_password_btn_submit',true);
            var formData = new FormData($('#form_change_password')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Authentication.Recover.Update', ['acc_id' => Request()->acc_id, 'acc_token' => Request()->acc_token]) }}",
                contentType: false,
                processData: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);

                    if(response.status != 302){
                        swal(response.title, response.message, response.icon);
                    }

                    if(response.status == 400){
                        $.each(response.errors, function(key, err_values){
                            $('#change_password_input_'+key+'_error').html(err_values);
                            $('#change_password_input_'+key).addClass('is-invalid');
                        });
                    }
                    else if(response.status == 302){
                        swal(response.title, response.message, response.icon).then(function(){
                            window.location.href = response.redirect_to;
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#change_password_btn_submit',false);
            });
        });
    </script>
@endpush