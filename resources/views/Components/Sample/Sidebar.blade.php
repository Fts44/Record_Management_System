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
                    <i data-feather="pie-chart" class="nav-icon icon-xs me-2"></i>  Menu
                </a>
            </li>

            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Menu Heading</div>
            </li>  

            <li class="nav-item">
                <a class="nav-link active " href="#">
                    <i data-feather="sidebar" class="nav-icon icon-xs me-2"></i> Single
                </a>
            </li>

            <li class="nav-item">
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
            </li>
        </ul>
    </div>
</nav>