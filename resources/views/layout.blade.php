<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.Complaints') }} & {{ __('messages.Commendations') }} | Admin</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('frontend/assets/img/site.webmanifest') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- flag-icons -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/flag-icon-css/css/flag-icons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">

    @yield('head')
</head>
<style>
    .goog-logo-link {
        display: none !important;
    }

    .goog-te-gadget {
        color: transparent !important;
    }

    #google_translate_element img {
        display: none !important;
    }

    .skiptranslate span {
        display: none !important;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <style>
        /* .active {
            color: #00a94f !important;
        } */
    </style>
    <div class="wrapper">
        <input type="hidden" id="langSelected" value="{{ Session::get('locale') }}">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> --}}

                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                {{-- expand --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                        {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><b>{{ __('messages.settings') }}</b></span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#updateProfile">
                            <i class="fas fa-user-edit mr-2"></i> Update Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ Route('logout') }}" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('messages.logout') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        {{-- <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a> --}}
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer"></a>
                    </div>
                </li>

                <!-- Language Dropdown Menu -->
                <li class="mt-1">
                    @if (Session::get('locale') == 'en')
                        <img class="" src="{{ asset('frontend/assets/img/united_states.png') }}" width="25"
                            height="25" alt="USA" />
                    @endif
                    @if (Session::get('locale') == 'es')
                        <img class="" src="{{ asset('frontend/assets/img/spain.png') }}" width="25"
                            height="25" alt="Spain" />
                    @endif
                </li>
                <div class="col-md-4">
                    <select class="form-control changeLang" style="width:100px;border:none;">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English
                        </option>
                        <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Spanish
                        </option>
                    </select>
                </div>
                <div class="col-md-2 mt-1">
                    <div class="" id="google_translate_button" style="display: flex;"></div>
                    {{-- <select class="form-control changeLang" style="width:100px">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English
                        </option>
                        <option value="sp" {{ session()->get('locale') == 'sp' ? 'selected' : '' }}>Spanish
                        </option>
                    </select> --}}
                </div>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="flag-icon flag-icon-us"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-0">
                        <a href="#" class="dropdown-item active">
                            <i class="flag-icon flag-icon-us mr-2"></i> English
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="flag-icon flag-icon-es mr-2"></i> Spanish
                        </a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img style="background-color: white;"
                    src="{{ asset('frontend/assets/img/android-chrome-512x512.png') }}" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light" style="font-size: 14px;">{{ __('messages.Complaints') }} &
                    {{ __('messages.Commendations') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                        {{-- <li class="nav-item">
                            <a href="{{ Route('dashboard') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>{{ __('messages.dashboard') }}</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ Route('userslist') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'users' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.users_list') }}</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ Route('reviews') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'reviews' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.reviews') }}</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ Route('review_profiles') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'review_profiles' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.review_profiles') }}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ Route('adssettingsview') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'ads' && Request::segment(3) == 'settings' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.ads_settings') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('adslist') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'ads' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.custom_ads_list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('categorylists') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'category' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.category_list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Route('subcategorylists') }}"
                                class="nav-link {{ Request::segment(1) == 'admin' && Request::segment(2) == 'subcategory' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>{{ __('messages.subcategory_list') }}</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content main page -->
        {{-- <div class="content-wrapper"> --}}
        @yield('content')
        {{-- </div> --}}
        <!-- /.content-wrapper -->

        <!-- edit pop up box -->
        <div class="modal fade" id="updateProfile" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method='post' action="{{ Route('updateuserprofile') }}"
                    class="col-xs- col-sm-12 col-md-12 col-lg-">
                    <div class="modal-content">
                        <div class="modal-header bg-default">
                            <h5 class="modal-title">Update Profile </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <form action="{{ Route('userLogin') }}" method="post"> --}}
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control"
                                    value="{{ session()->get('username') }}" placeholder="Full name" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email"
                                    value="{{ session()->get('email') }}"class="form-control" placeholder="Email"
                                    required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" id="signpassword"
                                    autocomplete="new-password" onselectstart="return false" onpaste="return false;"
                                    onCopy="return false" onCut="return false" onDrag="return false"
                                    onDrop="return false"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                    title="password should have 1 uppercase, 1 lowercase, 1 number, 1 special character and minimum 6 characters"
                                    name="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" id="password_confirmation" name="cpassword"
                                    class="form-control" placeholder="Confirmed password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="input-group mb-3">
                                <span id='msgSignError'></span>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" id="adminUpdate"
                                        class="btn btn-success btn-block">Update</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            {{-- </form> --}}
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-primary"
                                data-dismiss="modal">{{ __('messages.close') }}</button>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal -->

        {{-- <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="#">Review System</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer> --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.37/moment-timezone-with-data.js"></script>
    <script src="{{ asset('frontend/assets/js/mapInput.js') }}"></script>
    @if (!empty(config('services.maps.key')))
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.maps.key') }}&libraries=places&callback=initialize&loading=async"
        async defer></script>
    @endif
    <style>
        .pac-container,
        gmp-place-autocomplete {
            z-index: 100000 !important;
        }
        .map-place-autocomplete {
            width: 100%;
            display: block;
        }
    </style>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script> --}}
    <script type="text/javascript">
        var url = "{{ route('changeLang') }}";

        $(".changeLang").change(function() {
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateInit"></script>
    <script type="text/javascript">
        function googleTranslateInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'es',
                includedLanguages: 'en,es'
            }, 'google_translate_button');
            var $googleDiv = $("#google_translate_element .skiptranslate");
            var $googleDivChild = $("#google_translate_element .skiptranslate div");
            $googleDivChild.next().remove();

            $googleDiv.contents().filter(function() {
                return this.nodeType === 3 && $.trim(this.nodeValue) !== '';
            }).remove();
        }
    </script>
    <script>
        $('#signpassword').on('keyup change', function() {
            if ($('#signpassword').val() == "") {
                $('#msgSignError').html('Please enter password').css('color', 'red');
                $('#adminUpdate').prop('disabled', true);
            } else if ($('#password_confirmation').val() == "") {
                $('#msgSignError').html('Please enter confirm password').css('color', 'red');
                $('#adminUpdate').prop('disabled', true);
            } else if ($('#signpassword').val().length != 0) {
                if ($('#signpassword').val() == $('#password_confirmation').val()) {
                    // $('#msgSignError').html('Matching').css('color', 'green');
                    $('#msgSignError').html('');
                    $('#adminUpdate').prop('disabled', false);
                } else {
                    $('#msgSignError').html('Password and Confirm password must match.').css('color', 'red');
                    $('#adminUpdate').prop('disabled', true);
                }
            } else {
                $('#msgSignError').html('');
                $('#adminUpdate').prop('disabled', false);
            }
        });

        $('#password_confirmation').on('keyup change', function() {
            if ($('#signpassword').val() == $('#password_confirmation').val()) {
                // $('#msgSignError').html('Matching').css('color', 'green');
                $('#msgSignError').html('');
                $('#adminUpdate').prop('disabled', false);
            } else {
                $('#msgSignError').html('Password and Confirm password must match.').css('color', 'red');
                $('#adminUpdate').prop('disabled', true);
            }
        });
    </script>
    @yield('script')
</body>

</html>
