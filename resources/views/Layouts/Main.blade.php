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


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <title>
        @stack('title')
    </title>
  </head>

  <body class="bg-light"> 
    <div id="db-wrapper">
      <!-- Sidebar -->
      @stack('Sidebar')
      
      <!-- page content -->
      <div id="page-content">
        @stack('Header')

        @yield('Content')
      </div>
    </div>

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

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- swal -->
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <!-- dataTables -->
    <script src="{{ asset('assets/libs/dataTables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/bootstrap5.min.js') }}"></script>

    <!-- function js -->
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.js') }}"></script>

    <script>

      // redraw the table when the toggle button is click
      $('#nav-toggle').click(function(){ setTimeout(function() { redraw_datatable_class('.table') }, 225);});
      
    </script>
    @stack('script')

  </body>

</html>