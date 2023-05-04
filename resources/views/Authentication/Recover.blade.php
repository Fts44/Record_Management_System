@extends('Layouts.Authentication')


@push('title')
    Login - Health Services Portal
@endpush


@section('content')
    <!-- Form -->
    <form id="form_recover">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    
        <!-- Email -->
        <div class="mb-3">
            <label for="recover_input_email" class="form-label">Email</label>
            <input type="email" id="recover_input_email" class="form-control" name="email" required="">
            <span class="mt-1 invalid-feedback" id="recover_input_email_error"></span>
        </div>

        <div>
            <!-- Button -->
            <div class="d-grid">
                <button type="button" id="recover_btn_submit" class="btn btn-primary">
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
        $('#login_btn_show_password').click(function(){
            show_password('#login_input_password');
        });

        $('#recover_btn_submit').click(function(){
            reset_input_errors();
            load_btn('#recover_btn_submit',true);
            var formData = new FormData($('#form_recover')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Authentication.Recover.Create') }}",
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
                            $('#recover_input_'+key+'_error').html(err_values);
                            $('#recover_input_'+key).addClass('is-invalid');
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#recover_btn_submit',false);
            });
        });
    </script>
@endpush