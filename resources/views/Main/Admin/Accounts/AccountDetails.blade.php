@extends('Layouts.Main')

@push('Sidebar')
    @include('Components.Admin.Sidebar')
@endpush

@push('Header')
    @include('Components.Admin.Header')
@endpush

@section('Content')
    <!-- Content -->
    <!-- Container fluid -->
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div class="border-bottom pb-4 mb-4">              
                    <h3 class="mb-0 fw-bold">Account Details</h3>             
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center border-0">
                        <!-- <span class="fs-4">Information</span>
                        <button class="btn btn-secondary btn-sm" id=""><i class="bi bi-arrow-clockwise"></i> Refresh</button> -->
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"
                                    id="personal-tab" 
                                    data-bs-toggle="tab" 
                                    href="#personal" 
                                    role="tab" 
                                    aria-controls="personal" 
                                    aria-selected="true">
                                    Personal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    id="emergency_contact-tab" 
                                    data-bs-toggle="tab" 
                                    href="#emergency_contact" 
                                    role="tab" 
                                    aria-controls="emergency_contact" 
                                    aria-selected="false">
                                    Emergency Contact
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content border border-top-0 rounded-bottom" id="myTabContent">
                            <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                <div class="col-12 px-4">
                                    <div class="row mb-4">

                                        <!-- account details -->
                                        <div class="col-lg-9 mt-4">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Last Update: </label> <br>
                                                    <span>{{ ($acc->acc_info_last_update) ? date_format(date_create($acc->acc_info_last_update), 'F d, Y h:i a') : 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Full Name: </label> <br>
                                                    <span>{{ ($acc->pi_firstname.(' '.$acc->pi_middlename.' ' ?: ' ').$acc->pi_lastname) ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Classification: </label> <br>
                                                    <span>{{ ucwords($acc->pi_classification).' ('.ucwords($acc->pi_position).')' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">SR-Code: </label> <br>
                                                    <span>{{ ($acc->pi_srcode ?: 'Not Set' ) }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Department: </label> <br>
                                                    <span>{{ $acc->dept_name  ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Program: </label> <br>
                                                    <span>{{ $acc->prog_name ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Grade Level: </label> <br>
                                                    <span>{{ $acc->pi_grade_level ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Sex: </label> <br>
                                                    <span>{{ ucwords($acc->pi_sex) ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Birthdate: </label> <br>
                                                    <span>{{ ($acc->pi_birthdate) ? date_format(date_create($acc->pi_birthdate), 'F d, Y') : 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Civil Status: </label> <br>
                                                    <span>{{ ucwords($acc->pi_civil_status) ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Religion: </label> <br>
                                                    <span>{{ ucwords($acc->rlgn_name) ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Address: </label> <br>
                                                    @php 
                                                        $address = ($acc->add_id) ? ($acc->brgy_name.', '.$acc->mun_name.', '.$acc->prov_name) : 'Not Set';
                                                    @endphp
                                                    <span>{{ $address }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Contact No: </label> <br>
                                                    <span>{{ $acc->pi_contact_no }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Gsuite Email: </label> <br>
                                                    <span>{{ $acc->pi_gsuite_email ?: 'Not Set' }}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="fw-bold">Personal Email: </label> <br>
                                                    <span>{{ $acc->pi_personal_email ?: 'Not Set' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- profile picture -->
                                        <div class="col-lg-3 mt-4"> 
                                            <div class="row px-5 d-flex justify-content-center">  
                                                <img src="{{ ($acc->pi_photo) ? asset('storage/photos/'.$acc->pi_photo) : asset('assets/photos/default-profile.jpg')  }}" id="personal_information-profile_picture" class="profile-picture-preview mb-3" alt="Profile-Picture-Preview" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="emergency_contact" role="tabpanel" aria-labelledby="emergency_contact-tab">
                                <div class="col-12 px-4">
                                    <div class="row mb-4">
                                        <!-- account emergency contact details -->
                                        <div class="col-12 mt-4">
                                            <div class="col-12 mb-2">
                                                @php 
                                                    if($acc->ec_firstname && $acc->ec_lastname)
                                                        $name = $acc->ec_firstname.(' '.$acc->ec_middlename.' ' ?: ' ').$acc->ec_lastname;
                                                    else
                                                        $name = null;
                                                @endphp
                                                <label class="fw-bold">Full Name: </label> <br>
                                                <span>{{ $name ?: 'Not Set' }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="fw-bold">Relationship: </label> <br>
                                                <span>{{ $acc->ec_relationship ?: 'Not Set' }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="fw-bold">Contact No: </label> <br>
                                                <span>{{ $acc->ec_contact_no ?: 'Not Set' }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="fw-bold">Telephone No: </label> <br>
                                                <span>{{ $acc->ec_telephone_no ?: 'Not Set' }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="fw-bold">Address: </label> <br>
                                                @php 
                                                    $ec_address = ($acc->ec_prov) ? ($acc->ec_brgy.', '.$acc->ec_mun.', '.$acc->ec_prov) : 'Not Set';
                                                @endphp
                                                
                                                <span>{{ $ec_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-l2 mb-2" id="live-alert">

            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-end border-0 gap-1">
                        <div class="dropdown">
                            <a class="btn btn-secondary btn-sm" href="#" role="button" id="btn_create_new" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-plus-lg"></i> Create New 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="btn_create_new" id="create_new_dropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#er_modal-dental_certificate" id="create_new-dental_certificate">Dental Certificate</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#er_modal-excuse_slip" id="create_new-excuse_slip">Excuse Slip</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#er_modal-medical_certificate" id="create_new-medical_certificate">Medical Certificate</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#er_modal-medical_referral" id="create_new-medical_referral">Medical Referral</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#er_modal-medical_request_slip" id="create_new-medical_request_slip">Medical Request Slip</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-secondary btn-sm" id="table_record_refresh"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
                    </div>
                    <div class="card-body">
                        <table id="table_record" class="table table-responsive" style="width: 100%;">
                            <thead class="table-light">
                                <th scope="col">ID</th>
                                <th scope="col">Type</th>
                                <th scope="col">Physician</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            table = $('#table_record').DataTable({
                ajax: {
                    url: "{{ route('Admin.Accounts.Details.Record', ['acc_id' => request()->acc_id]) }}",
                    async : false,
                    dataSrc: "data",
                },
                order: [[0, 'desc']],
                responsive: true,
                scrollX: true,
                columns: [
                    { data: 'er_id' },
                    { data: 'er_dt_name' },
                    { data: 'er_physician' },
                    { data: 'er_created_date' },
                    { data: 'er_doc_last_update' },
                    { data: 'action' }
                ],
            });

            $('#table_record_refresh').click(function(){
                table.ajax.reload( toast('Success', 'Table data refresh!', 'success'), false);           
            });
        });
    </script>
    
    @php 
        //session variable
        $first_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['first_name']));
        $middle_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['middle_name'])); 
        $last_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['last_name']));

        if($acc->pi_firstname && $acc->pi_lastname){
            $name = $acc->pi_firstname.(($acc->pi_middlename) ? ' '.$acc->pi_middlename[0].'. ' : ' ').$acc->pi_lastname;
        }
        else{
            $name = null;
        }

        $sexes = ['female', 'male']; 
        $civil_status = ['single', 'married', 'separated', 'widowed'];

        // variable in account details blade
        $birthdate = $acc->pi_birthdate; 
        $today = date('Y-m-d');
        $age = ($acc->pi_birthdate) ? date_diff(date_create($birthdate), date_create($today))->format('%y') : '';
        $address = ($acc->add_id) ? ($acc->brgy_name.','.$acc->mun_name.','.$acc->prov_name) : '';
    @endphp 

    @include('Components.Admin.ERModal.MedicalRequestSlip')
    @include('Components.Admin.ERModal.DentalCertificate')
    @include('Components.Admin.ERModal.ExcuseSlip')
    @include('Components.Admin.ERModal.MedicalCertificate')
    @include('Components.Admin.ERModal.MedicalReferral')
    @include('Components.Admin.ERModal.PDFViewer')
@endpush
