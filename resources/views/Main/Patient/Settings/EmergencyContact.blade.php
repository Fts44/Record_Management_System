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
                        <h3 class="mb-0 fw-bold">Emergency Contact</h3>      
                    </div>
            </div>
        </div>

        <div class="row mb-8">
            <div class="col-12">
                <div class="mb-4">
                    <h4>Guardian Information</h4>
                    <p class="fs-5 text-muted">Enter your guardian information below.</p>
                </div>
            </div>

            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <form id="guardian_information_form">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                            @method('PUT')
                            
                            <!-- Full name -->
                            <div class="row mt-2">
                                <label class="col-12 mb-1 form-label">Full Name</label>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" placeholder="First name" 
                                        name="first_name" 
                                        id="guardian_information-first_name" 
                                        value="{{ $ec->ec_firstname }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-first_name-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" placeholder="Middle name" 
                                        name="middle_name" 
                                        id="guardian_information-middle_name" 
                                        value="{{ $ec->ec_middlename }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-middle_name-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="text" class="form-control" placeholder="Last name"
                                        name="last_name" 
                                        id="guardian_information-last_name" 
                                        value="{{ $ec->ec_lastname }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-last_name-error"></div>
                                </div>
                            </div>

                            <!-- Religion, Contact No -->
                            <div class="row">

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Contact Number</label>
                                    <input type="tel" class="form-control"
                                        name="contact_number" 
                                        id="guardian_information-contact_number" 
                                        value="{{ $ec->ec_contact_no }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-contact_number-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Telephone Number</label>
                                    <input type="tel" class="form-control"
                                        name="telephone_number" 
                                        id="guardian_information-telephone_number" 
                                        value="{{ $ec->ec_telephone_no }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-telephone_number-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="col-12 mb-1 form-label">Relationship</label>
                                    <input type="text" class="form-control"
                                        name="relationship" 
                                        id="guardian_information-relationship" 
                                        value="{{ $ec->ec_relationship }}">
                                    <div class="invalid-feedback mt-1" id="guardian_information-relationship-error"></div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row">
                                <label class="col-12 mb-1 form-label">Address</label>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" 
                                        name="province" 
                                        id="guardian_information-province">
                                        <option value="">--- Choose Province ---</option>
                                        {!! $provinces !!}
                                    </select>
                                    <div class="invalid-feedback mt-1" id="guardian_information-province-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" 
                                        name="city" 
                                        id="guardian_information-city">
                                        <option value="">--- Choose City ---</option>
                                        {!! $municipalities !!}
                                    </select>
                                    <div class="invalid-feedback mt-1" id="guardian_information-city-error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <select class="form-select" 
                                        name="barangay" 
                                        id="guardian_information-barangay">
                                        <option value="">--- Choose Barangay ---</option>
                                        {!! $barangays !!}
                                    </select>
                                    <div class="invalid-feedback mt-1" id="guardian_information-barangay-error"></div>
                                </div>
                            </div>

                            <!-- Save Changes -->
                            <div class="row mt-2 d-flex justify-content-center">
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button class="btn btn-primary w-75" type="button" id="guardian_information_form_submit">
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
        $('#guardian_information_form_submit').click(function(){
            reset_input_errors();
            load_btn('#guardian_information_form_submit',true);
            var formData = new FormData($('#guardian_information_form')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.EmergencyContact.Update') }}",
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
                            $('#guardian_information-'+key+'-error').html(err_values);
                            $('#guardian_information-'+key).addClass('is-invalid');
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#guardian_information_form_submit',false);
            });
        });

        $('#guardian_information-province').change(function(){
            set_municipalities('#guardian_information-city', $(this).val(), null, '#guardian_information-barangay');
        }); 

        $('#guardian_information-city').change(function(){
            set_barangays('#guardian_information-barangay', $(this).val(), null);
        }); 
    </script>
@endpush