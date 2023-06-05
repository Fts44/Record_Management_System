@php 
    $first_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['first_name']));
    $middle_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['middle_name']));
    $last_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['last_name']));
    $acc_type = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['acc_type']));
    $position = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['position']));
    $profile_picture = \Crypt::decrypt(Session::get('hsp_user_data')['profile_picture']);

    // check if there is missing data and add to notif
    $notification = [];
    if($profile_picture == 'default-profile.jpg'){
        $notification['incomplete_data']['personal_information'] = true;
    }

    if($profile_picture == 'default-profile.jpg'){
        $notification['incomplete_data']['emergency_contact'] = true;
    }
@endphp

<div class="header @@classList">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#">
            <i data-feather="menu" class="nav-icon me-2 icon-xs"></i>
        </a>

        <!-- Search bar -->
        <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <!-- <form class="d-flex align-items-center">
                <input type="search" class="form-control" placeholder="Search" />
            </form> -->
        </div>
    
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap pt-1">
            <!-- Notification Dropdown -->
            <li class="dropdown stopevent">
                <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-xs" data-feather="bell"></i>
                    @if(count($notification)>0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ (count($notification)>99) ? '99+' : count($notification) }}
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
                    
                    <div>
                        <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
                            <!-- <a href="#" class="text-muted"> -->
                            <!-- <span><i class="me-1 icon-xxs" data-feather="settings"></i></span></a> -->
                        </div>

                        <!-- List group -->
                        <ul class="list-group list-group-flush notification-list-scroll bg-light">
                            <!-- List group item -->

                            @if(isset($notification['incomplete_data']['personal_information']))
                                <li class="list-group-item border-bottom">
                                    <a href="{{ route('Patient.Profile.Index') }}" class="text-muted">
                                        <h5 class="mb-1 fw-">Missing Data in Personal Information</h5>
                                        <p class="mb-0">
                                            Please complete your personal information.
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if(isset($notification['incomplete_data']['emergency_contact']))
                                <li class="list-group-item border-bottom">
                                    <a href="{{ route('Patient.Profile.Index') }}" class="text-muted">
                                        <h5 class="mb-1 fw-">Missing Data in Emergency Contact</h5>
                                        <p class="mb-0">
                                            Please complete your emergency contact information.
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                        
                        <div class="border-top px-3 py-2 text-center">
                            <!-- <a href="#" class="text-inherit fw-semi-bold">
                                View all Notifications
                            </a> -->
                        </div>

                    </div>

                </div>
            </li>

            <!-- Profile Dropdown -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" id="header_avatar" src="{{ ($profile_picture) ? asset('storage/photos/'.$profile_picture) : asset('assets/photos/default-profile.jpg')  }}" class="rounded-circle" />
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">
                        <div class="lh-1">
                            <h5 class="mb-1 display-name" id="header_name">{{ $first_name.' '.$last_name }}</h5>
                            <span class="text-inherit fs-6" id="header_position">{{ ($acc_type=='Standard') ? $position : $acc_type }}</span>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>

                    <ul class="list-unstyled">
                        <!-- <li>
                            <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i> Edit Profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="activity"></i>Activity Log
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item text-primary" href="#">
                            <i class="me-2 icon-xxs text-primary dropdown-item-icon" data-feather="star"></i>Go Pro
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="settings"></i>Account Settings
                            </a>
                        </li> -->

                        <li>
                            <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign Out
                            </a>
                        </li>
                    </ul>

                </div>
            </li>
        </ul>
    </nav>

</div>