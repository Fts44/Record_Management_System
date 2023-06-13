<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand d-flex">
            <!-- <img src="{{ asset('assets/photos/logo_w_text.png') }}" alt=""/> -->
            <span>Health Portal</span>
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link has-arrow " href="#">
                    <i data-feather="pie-chart" class="nav-icon icon-xs me-2"></i>  Dashboard
                </a>
            </li>

            <!-- Nav Heading -->
            <li class="nav-item">
                <div class="navbar-heading">Accounts</div>
            </li>  

            <li class="nav-item">
            <a class="nav-link {{(str_contains(url()->current(),route('Admin.Accounts.Patient.Index')) ) ? 'active' : ''}}" href="{{ route('Admin.Accounts.Patient.Index') }}">
                    <i class="nav-icon icon-xs me-2 bi bi-person"></i> Patient
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{(str_contains(url()->current(),route('Admin.Accounts.Employee.Index')) ) ? 'active' : ''}}" href="{{ route('Admin.Accounts.Employee.Index') }}">
                    <i class="nav-icon icon-xs me-2 bi bi-people"></i> Employee
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{(str_contains(url()->current(),route('Admin.Accounts.Unverified.Index')) ) ? 'active' : ''}}" href="{{ route('Admin.Accounts.Unverified.Index') }}">
                    <i class="nav-icon icon-xs me-2 bi bi-person-exclamation"></i> Unverified
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{(str_contains(url()->current(),route('Admin.Accounts.Blocked.Index')) ) ? 'active' : ''}}" href="{{ route('Admin.Accounts.Blocked.Index') }}">
                    <i class="nav-icon icon-xs me-2 bi bi-person-x"></i> Blocked
                </a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navMenuLevel" aria-expanded="false" aria-controls="navMenuLevel">
                    <i data-feather="corner-left-down"class="nav-icon icon-xs me-2"></i> Menu
                </a>

                <div id="navMenuLevel" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Nav 1</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="#" data-bs-toggle="collapse" data-bs-target="#navMenuLevelSecond" aria-expanded="false" aria-controls="navMenuLevelSecond">
                            Nav 2
                        </a>

                        <div id="navMenuLevelSecond" class="collapse" data-bs-parent="#navMenuLevel">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="#">Item 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#">Item 2</a>
                            </li>
                        </ul>
                        </div>
                    </li>
                    </ul>
                </div>
            </li> -->

            <!-- Nav Heading -->
            <li class="nav-item">
                <div class="navbar-heading">Records</div>
            </li>  

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-xs me-2 bi bi-file-earmark-text"></i> Dental Certificate
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-xs me-2 bi bi-file-earmark-text"></i> Excuse Slip
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-xs me-2 bi bi-file-earmark-text"></i> Medical Certificate
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-xs me-2 bi bi-file-earmark-text"></i> Medical Referral Form
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-xs me-2 bi bi-file-earmark-text"></i> Medical Request Slip
                </a>
            </li>
        </ul>
    </div>
</nav>