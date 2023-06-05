<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon icon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/photos/logo.png') }}">

    <!-- Libs CSS -->
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/dropzone/dist/dropzone.css') }}"  rel="stylesheet">
    <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    <!-- toast CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet"> -->
    
    <title>
        @stack('title')
    </title>
</head>

<body class="bg-light">
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">

            <!-- Card -->
            <div class="card smooth-shadow-md my-5">

                <!-- Card body -->
                <div class="card-body p-6">
                    <div class="mb-4 d-flex flex-column align-items-center">
                        <a href="{{ route('Authentication.Login.Index') }}">
                            <img src="{{ asset('assets/photos/logo_w_text.png') }}" class="mb-2 brand-logo" alt="brand_logo">
                        </a>
                        <p class="mb-2">Please enter your user information.</p>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <button class="btn btn-primary" id="back-to-top" onclick="topFunction()"><i class="bi bi-arrow-up"></i></button>
    
    <!-- Scripts -->
    
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js') }}"></script>

    <!-- toast popup -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script> -->

    <!-- swal -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- function js -->
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    @stack('script')
</body>

</html>