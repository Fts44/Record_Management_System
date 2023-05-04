@extends('Layouts.Authentication')


@push('title')
    Login - Health Services Portal
@endpush


@section('content')
    <!-- Form -->
    <form id="form_login">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    
        <!-- Username -->
        <div class="mb-3">
            <label for="login_input_userid" class="form-label">Email/ SR-Code</label>
            <input type="text" id="login_input_userid" class="form-control" name="userid">
            <span class="mt-1 invalid-feedback" id="login_input_userid_error"></span>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="login_input_password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="login_input_password" class="form-control rounded-right password" name="password">
                <button class="input-group-text" type="button" id="login_btn_show_password">
                    <i class="show-password-icon bi bi-eye-slash" id="login_lbl_show_password"></i>
                </button>
                <span class="mt-1 invalid-feedback" id="login_input_password_error"></span>
            </div>
        </div>

        <div>
            <!-- Button -->
            <div class="d-grid">
                <button type="button" class="btn btn-primary" id="login_btn_submit">
                    <label>Login</label>
                </button>
            </div>

            <div class="d-md-flex justify-content-between mt-3">
                <div class="mb-2 mb-md-0">
                    <a href="{{ route('Authentication.Register.Index') }}" class="fs-5">Create An Account</a>
                </div>
                <div>
                    <a href="{{ route('Authentication.Recover.Index') }}" class="text-inherit
                        fs-5">Forgot password</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            @if(session('response'))
                @php 
                    $response = json_decode(session('response'));                      
                @endphp
                
                const modal_body = document.createElement('div');
                modal_body.innerHTML = '{!! $response->message !!}';
                modal_body.setAttribute('class', 'swal-body');
                swal({
                    title: '{{$response->title}}',
                    content: modal_body, 
                    icon: '{{$response->icon}}'
                });
            @endif
        }); 

        $('#login_btn_show_password').click(function(){
            show_password('#login_input_password');
        });

        $('#login_btn_submit').click(function(){
            reset_input_errors();
            load_btn('#login_btn_submit',true);
            var formData = new FormData($('#form_login')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Authentication.Login.Create') }}",
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
                            $('#login_input_'+key+'_error').html(err_values);
                            $('#login_input_'+key).addClass('is-invalid');
                        });
                    }
                    else if(response.status == 302){
                        window.location.href = response.redirect_to;
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#login_btn_submit',false);
            });
        });
    </script>
@endpush