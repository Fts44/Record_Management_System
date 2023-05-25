@extends('Layouts.Main')

@push('Sidebar')
    @include('Components.Patient.Sidebar')
@endpush

@push('Header')
    @include('Components.Patient.Header')
@endpush

@section('Content')
    <!-- Container fluid -->
    <div class="container-fluid p-6">
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
                    <p class="fs-5 text-muted">Enter your personal information below.</p>
                </div>
            </div>

            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">

                        <div>
                            <form>
                                 <!-- row -->
                                 <div class="row">
                                    <label class="col-12 mb-1 form-label">Full Name</label>

                                    <div class="col-lg-4">
                                        <input type="text" class="form-control mb-3" placeholder="First name" id="basic_information-first_name" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <input type="text" class="form-control mb-3" placeholder="Middle name" id="basic_information-middle_name" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <input type="text" class="form-control mb-3" placeholder="Last name" id="basic_information-last_name" required>
                                    </div>
                                </div>

                                <!-- row -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">SR-Code</label>
                                        <input type="text" class="form-control mb-3" placeholder="##-#####" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Personal Email</label>
                                        <input type="email" class="form-control mb-3" placeholder="abc@gmail.com" id="email" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Gsuite Email</label>
                                        <div class="input-group mb-3">
                                            <input type="email" class="form-control" placeholder="def@g.batstate-u.edu.ph" id="basic_information-gsuite_email" required>
                                            <button class="btn btn-primary" type="button">
                                                <label>Verify</label>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- row -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Position</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Department</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Program</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- row -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Grade Level</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Year Level</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- row -->
                                <div class="row">

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Birthdate</label>
                                        <input type="date" name="" id="" class="form-control mb-3">
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Sex</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                            <option value="female">Female</option>
                                            <option value="male">Male</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Civil Status</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="separated">Separated</option>
                                        </select>
                                    </div>

                                    
                                </div>

                                <!-- row -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Religion</label>
                                        <select name="" id="" class="form-select mb-3">
                                            <option value="">--- Choose ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-12 mb-1 form-label">Contact Number</label>
                                        <input type="text" class="form-control mb-3" placeholder="Phone" id="phone" required>
                                    </div>
                                </div>

                                <!-- row -->
                                <div class="row">
                                    <label class="col-12 mb-1 form-label">Address</label>

                                    <div class="col-lg-4">
                                        <select class="form-select mb-3">
                                            <option selected>--- Choose Province ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <select class="form-select mb-3">
                                            <option selected>--- Choose City ---</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <select class="form-select mb-3">
                                            <option selected>--- Choose Barangay ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary">
                                            <label>Save Changes</label>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>  

    </div>
@endsection

@push('script')

@endpush