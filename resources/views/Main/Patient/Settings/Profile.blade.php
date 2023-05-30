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
                        <h3 class="mb-0 fw-bold">Profile</h3>      
                    </div>
            </div>
        </div>

        <div class="row mb-8">
            <div class="col-12">
                <div class="mb-4">
                    <h4>Personal Information</h4>
                    <p class="fs-5 text-muted">Enter your information below.</p>
                </div>
            </div>

            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <form id="personal_information_form">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                            @method('PUT')
                            
                            <!-- Profile Picture -->
                            <div class="row my-4 d-flex justify-content-center">
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <div class="row px-5 d-flex justify-content-center">
                                        @php 
                                            $profile_picture = \Crypt::decrypt(Session::get('hsp_user_data')['profile_picture'])
                                        @endphp 
                                        <img src="{{ asset('assets/photos/'.$profile_picture) }}" id="personal_information-profile_picture" class="profile-picture-preview my-form-control" alt="Profile-Picture-Preview">
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12 text-center">
                                            <label class="btn btn-primary w-75 mt-1" for="personal_information-profile_picture_input" 
                                                data-bs-toggle="popover" 
                                                data-bs-trigger="hover" 
                                                data-bs-placement="top" 
                                                data-bs-title="Change Photo"
                                                data-bs-content="Upload your 2x2 photo.">
                                                Change Photo (2x2)
                                            </label>
                                            <button type="button" class="btn btn-danger mt-1" id="remove_profile_picture"
                                                data-bs-toggle="popover" 
                                                data-bs-trigger="hover" 
                                                data-bs-placement="top" 
                                                data-bs-title="Delete Uploaded Photo"
                                                data-bs-content="Remove uploaded photo.">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <input type="file" name="profile_picture" id="personal_information-profile_picture_input" class="form-control mt-1 d-none" accept=".png, .jpg, .jpeg">
                                        </div>
                                        <span class="mt-1 text-center my-invalid-feedback" id="personal_information-profile_picture-error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Full name -->
                            <div class="row">
                                <label class="col-12 mb-1 form-label">Full Name</label>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" placeholder="First name" name="first_name" id="personal_information-first_name" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-first_name-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" placeholder="Middle name" name="middle_name" id="personal_information-middle_name" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-middle_name-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" name="last_name" id="personal_information-last_name" placeholder="Last name" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-last_name-error"></div>
                                </div>
                            </div>

                            <!-- SR-Code, Personal Email, Gsuite Email -->
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">SR-Code</label>
                                    <input type="text" class="form-control" name="sr_code" id="personal_information-sr_code" placeholder="12-34567" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-sr_code-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Personal Email</label>
                                    <input type="email" class="form-control" name="personal_email" id="personal_information-personal_email" placeholder="abc@gmail.com" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-personal_email-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Gsuite Email</label>
                                    <div class="row">
                                        <div class="input-group">
                                            <input type="email" class="form-control" name="gsuite_email" id="personal_information-gsuite_email" placeholder="def@g.batstate-u.edu.ph" required>
                                            <button class="btn btn-primary" type="button"
                                                data-bs-toggle="popover" 
                                                data-bs-trigger="hover" 
                                                data-bs-placement="top" 
                                                data-bs-title="Gsuite Verification"
                                                data-bs-content="Get your email verification link.">
                                                <label>Verify</label>
                                            </button>
                                        </div>
                                        <span class="my-invalid-feedback mt-1" id="personal_information-gsuite_email-error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Grade Level, Department, Program -->
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Grade Level</label>
                                    <select name="grade_level" id="personal_information-grade_level" class="form-select">
                                        <option value="">--- Choose ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-grade_level-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Department</label>
                                    <select name="department" id="personal_information-department" class="form-select">
                                        <option value="">--- Choose ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-department-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Program</label>
                                    <select name="program" id="personal_information-program" class="form-select">
                                        <option value="">--- Choose ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-program-error"></div>
                                </div>
                            </div>
                            
                            <!-- Birthdate, Sex, Civil Status -->
                            <div class="row">

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Birthdate</label>
                                    <input type="date" name="birthdate" id="personal_information-birthdate" class="form-control">
                                    <div class="invalid-feedback mt-1" id="personal_information-birthdate-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Sex</label>
                                    <select name="sex" id="personal_information-sex" class="form-select">
                                        <option value="">--- Choose ---</option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-sex-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Civil Status</label>
                                    <select name="civil_status" id="personal_information-civil_status" class="form-select">
                                        <option value="">--- Choose ---</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="separated">Separated</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-civil_status-error"></div>
                                </div>

                                
                            </div>

                            <!-- Religion, Contact No -->
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Religion</label>
                                    <select name="religion" id="personal_information-religion" class="form-select">
                                        <option value="">--- Choose ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-religion-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number" id="personal_information-contact_number" placeholder="Phone" required>
                                    <div class="invalid-feedback mt-1" id="personal_information-contact_number-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Position</label>
                                    <select name="position" id="personal_information-position" class="form-select">
                                        <option value="">--- Choose ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-position-error"></div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row">
                                <label class="col-12 mb-1 form-label">Address</label>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" name="province" id="personal_information-province">
                                        <option value="">--- Choose Province ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-province-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" name="city" id="personal_information-city">
                                        <option value="">--- Choose City ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-city-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" name="barangay" id="personal_information-barangay">
                                        <option value="">--- Choose Barangay ---</option>
                                    </select>
                                    <div class="invalid-feedback mt-1" id="personal_information-barangay-error"></div>
                                </div>
                            </div>

                            <!-- Save Changes -->
                            <div class="row mt-2 d-flex justify-content-center">
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button class="btn btn-primary w-75" type="button" id="personal_information_form_submit">
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
        $('#personal_information-profile_picture_input').change(function(e){
            let file = $("input[type=file]").get(0).files[0];

            if(file.size > (2 * 1024 * 1024)){
                swal('Failed!', 'The maximum file size is 2mb!', 'error');
            }
            else{
                if(file){
                    var reader = new FileReader();
                    reader.onload = function(){
                        $("#personal_information-profile_picture").attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });

        $('#remove_profile_picture').click(function(){
            $("#personal_information-profile_picture").attr("src", "{{ asset('assets/photos/'.$profile_picture) }}");
            $('#personal_information-profile_picture_input').val('');
        });

        $('#personal_information_form_submit').click(function(){
            reset_input_errors();
            load_btn('#personal_information_form_submit',true);
            var formData = new FormData($('#personal_information_form')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.PersonalInformation.Update') }}",
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
                            $('#personal_information-'+key+'-error').html(err_values);
                            $('#personal_information-'+key).addClass('is-invalid');
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#personal_information_form_submit',false);
            });
        });
    </script>
@endpush