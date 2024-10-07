<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('code')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.ico">

		<!-- App css -->

		<link href="{{ asset('/') }}assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

		<!-- icons -->
		<link href="{{ asset('/') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">
                            <a href="index.html" class="logo">
                                <img src="{{ asset('/') }}assets/images/logo-login.png" alt="" height="22" class="logo-light mx-auto">
                            </a>
                            <p class="text-muted mt-2 mb-4">Sistem Informasi Magang MBKM Teknik Elektro Politeknik Negeri Pontianak</p>
                        </div>
                        <div class="card">

                            <div class="card-body p-4">

                                <div class="text-center">
                                    <h1 class="text-error"> @yield('code') </h1>
                                    <h3 class="mt-3 mb-2"> @yield('title') </h3>
                                    <p class="text-muted mb-3"> @yield('message') </p>
                                    @yield('button')
                                </div>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <!-- Vendor -->
        <script src="{{ asset('/') }}assets/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/feather-icons/feather.min.js"></script>
        <!-- App js -->
        <script src="{{ asset('/') }}assets/js/app.min.js"></script>

    </body>

</html>
