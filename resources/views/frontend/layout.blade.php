<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('messages.Complaints') }} & {{ __('messages.Commendations') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('frontend/assets/img/site.webmanifest') }}">
    {{-- google ads --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7926120474819549"
        crossorigin="anonymous"></script>
    <!-- All Plugins Css -->
    <link href="{{ asset('frontend/assets/css/plugins.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">

    <!-- Custom Color -->
    <link href="{{ asset('frontend/assets/css/skin/default.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    @yield('mainhead')
</head>
<style>
    /* .goog-logo-link {
        display: none !important;
    } */

    /* .goog-te-gadget {
        color: transparent !important;
    } */

    /* #google_translate_element img {
        display: none !important;
    } */

    /* .skiptranslate span {
        display: none !important;
    } */

    .input-with-gray i {
        z-index: 0 !important;
    }

    /* input,
    input::-webkit-input-placeholder {
        font-size: 14px;
    } */
</style>
@if (Session::get('locale') == 'en')
    <style>
        input,
        input::-webkit-input-placeholder {
            font-size: 14px;
        }

        .custom-file-label::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            display: block;
            height: 3rem;
            padding: .805rem .75rem;
            line-height: 1.5;
            color: #495057;
            content: "Browse";
            background-color: #e9ecef;
            border-left: inherit;
            border-radius: 0 .1rem .1rem 0;
        }
    </style>
@else
    <style>
        input#profile_name::placeholder {
            font-size: 14px;
        }

        .custom-file-label::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            display: block;
            height: 3rem;
            padding: .805rem .75rem;
            line-height: 1.5;
            color: #495057;
            content: "Buscar";
            background-color: #e9ecef;
            border-left: inherit;
            border-radius: 0 .1rem .1rem 0;
        }
    </style>
@endif

<body class="green-skin">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{-- <div class="Loader"></div> --}}

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <input type="hidden" id="langSelected" value="{{ Session::get('locale') }}">
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
        <!-- Start Navigation -->
        <div class="header header-light">
            <div class="container-fluid">
                <nav id="navigation" class="navigation navigation-landscape">
                    <div class="nav-header">
                        <a class="nav-brand" href="{{ Route('home') }}">
                            @if (Session::get('locale') == 'en')
                                <img id="cust_logo_en" src="{{ asset('frontend/assets/img/english_logo.png') }}"
                                    class="logo" alt="" />
                                {{-- @else
                                <img id="selected_en_logo" src="{{ asset('frontend/assets/img/english_logo.png') }}"
                                    class="logo d-none" alt="" /> --}}
                            @endif
                            @if (Session::get('locale') == 'es')
                                <img id="cust_logo_es" src="{{ asset('frontend/assets/img/spanish_logo.png') }}"
                                    class="logo" alt="" />
                                {{-- @else
                                <img id="selected_es_logo" src="{{ asset('frontend/assets/img/spanish_logo.png') }}"
                                    class="logo d-none" alt="" /> --}}
                            @endif
                        </a>
                        <div class="nav-toggle"></div>
                    </div>
                    <div class="nav-menus-wrapper" style="transition-property: none;">
                        <ul class="nav-menu">
                            <li class="{{ Request::segment(1) == '' ? 'active' : '' }}"><a
                                    href="{{ Route('home') }}">{{ __('messages.home_home') }}</a>
                            </li>
                            @if (!empty(Session::get('login_username')))
                                <li
                                    class="{{ Request::segment(1) == 'create' && Request::segment(2) == 'review_profile' ? 'active' : '' }}">
                                    <a
                                        href="{{ Route('review_profile') }}">{{ __('messages.Create_Review_Profile') }}</a>
                                </li>
                            @endif
                            <li
                                class="{{ Request::segment(1) == 'browse' && Request::segment(2) == 'profiles' ? 'active' : '' }}">
                                <a
                                    href="{{ Route('browse_profiles') }}">{{ __('messages.browse_review_profiles') }}</a>
                            </li>

                            <li class="{{ Request::segment(1) == 'contact' ? 'active' : '' }}"><a
                                    href="{{ Route('contact') }}">{{ __('messages.contact_us') }}</a></li>

                        </ul>

                        {{--  nav-menu-social --}}
                        <ul class="nav-menu align-to-right">
                            <li>
                                @if (empty(Session::get('login_username')))
                                    <a href="#" data-toggle="modal" data-target="#login">
                                        <i class="ti-user mr-1"></i><span
                                            class="dn-lg">{{ __('messages.login_register') }}</span>
                                    </a>
                                @else
                                    @php
                                        $userProfileImg = \App\Models\User::where('id', Session::get('login_user_id'))->first();
                                    @endphp
                                    <a class="setting_click" href="#">
                                        @if ($userProfileImg->user_pic == null)
                                            <img class="img-circle img-bordered-sm"src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                width="25" height="25" alt="profile image" />
                                        @else
                                            <img class="img-circle img-bordered-sm"src="{{ asset($userProfileImg->user_pic) }}"
                                                width="25" height="25" alt="profile image" />
                                        @endif
                                        {{ __('messages.settings') }}<span class="submenu-indicator"></span>
                                    </a>

                                    <ul class="nav-dropdown nav-submenu mr-3" style="right: auto; display: none;">
                                        <li class="ml-2"><i class="ti-user mr-1 mb-1"></i>
                                            {{ Session::get('login_username') }}</li>
                                        <li><a></a></li>
                                        <li><a href="#"data-toggle="modal"
                                                data-target="#signupUpdate">{{ __('messages.Update_Profile') }}</a>
                                        </li>
                                        <li><a href="{{ route('user_logout') }}">{{ __('messages.Logout') }}</a></li>
                                    </ul>
                                @endif
                            </li>
                            <li class="ml-3" style="margin-top: 19px;">
                                @if (Session::get('locale') == 'en')
                                    <img class="img-bordered-sm"src="{{ asset('frontend/assets/img/united_states.png') }}"
                                        width="25" height="25" alt="USA" />
                                @endif
                                @if (Session::get('locale') == 'es')
                                    <img class="img-bordered-sm"src="{{ asset('frontend/assets/img/spain.png') }}"
                                        width="25" height="25" alt="Spain" />
                                @endif
                                <select class="changeLang" style="width:105px;height:40px;border-color:white;">
                                    <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>
                                        English
                                    </option>
                                    <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>
                                        Spanish
                                    </option>
                                </select>
                            </li>
                            {{-- <li class="mt-3">
                                <i class="fa fa-info-circle text-warning" title="{{ __('messages.disclaimer') }}"
                                    style="margin-top: 15px; width:48px; height:48px;" aria-hidden="true"></i>
                            </li> --}}
                            <li class="ml-3" style="margin-top: 19px;">
                                <div class="mt-2" id="google_translate_button" style="display: flex;"></div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- End Navigation -->
        <div class="clearfix"></div>
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->


        {{-- main container --}}
        @yield('maincontent')

        <!-- ============================ Footer Start ================================== -->
        <footer class="dark-footer skin-dark-footer">
            <div>
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                @if (Session::get('locale') == 'en')
                                    <img id="w_selected_en_logo" class="img-footer"
                                        src="{{ asset('frontend/assets/img/w_english_logo.png') }}" alt="" />
                                @endif
                                @if (Session::get('locale') == 'es')
                                    <img id="w_selected_es_logo" class="img-footer"
                                        src="{{ asset('frontend/assets/img/w_spanish_logo.png') }}" alt="" />
                                @endif

                                {{-- <img src="{{ asset('frontend/assets/img/english_logo.png') }}" class="img-footer" alt="" /> --}}

                                <div class="footer-add">
                                    <p><b>{{ __('messages.HEAD_OFFICES') }}</b></br>Canada</br> Toronto
                                        Ontario</br>Costa
                                        Rica</br>Alajuela</p>
                                    <p><strong>{{ __('messages.email') }}:</strong></br>
                                        info@quejasyelogios.com</p>
                                    {{-- <p><strong>Call:</strong></br>91 855 742 62548</p> --}}
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4 class="widget-title">{{ __('messages.Navigations') }}</h4>
                                <ul class="footer-menu">
                                    <li><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a></li>
                                    @if (!empty(Session::get('login_username')))
                                        <li><a
                                                href="{{ Route('review_profile') }}">{{ __('messages.Create_Review_Profile') }}</a>
                                        </li>
                                    @endif
                                    <li><a
                                            href="{{ Route('browse_profiles') }}">{{ __('messages.browse_review_profiles') }}</a>
                                    </li>
                                    <li><a href="{{ Route('contact') }}">{{ __('messages.contact_us') }}</a></li>
                                    <li><a href="{{ Route('terms_and_conditions') }}">{{ __('messages.terms_conditions') }}</a></li>
                                    <li><a href="{{ Route('privacy_policy') }}">{{ __('messages.Privacy') }}</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- <div class="col-lg-2 col-md-2">
                            <div class="footer-widget">
                                <h4 class="widget-title">The Highlights</h4>
                                <ul class="footer-menu">
                                    <li><a href="#">Home Page 2</a></li>
                                    <li><a href="#">Home Page 3</a></li>
                                    <li><a href="#">Home Page 4</a></li>
                                    <li><a href="#">Home Page 5</a></li>
                                    <li><a href="#">LogIn</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2">
                            <div class="footer-widget">
                                <h4 class="widget-title">My Account</h4>
                                <ul class="footer-menu">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Applications</a></li>
                                    <li><a href="#">Packages</a></li>
                                    <li><a href="#">resume.html</a></li>
                                    <li><a href="#">SignUp Page</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            <div class="footer-widget">
                                <h4 class="widget-title">Download Apps</h4>
                                <a href="#" class="other-store-link">
                                    <div class="other-store-app">
                                        <div class="os-app-icon">
                                            <i class="ti-android theme-cl"></i>
                                        </div>
                                        <div class="os-app-caps">
                                            Google Play
                                            <span>Get It Now</span>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="other-store-link">
                                    <div class="other-store-app">
                                        <div class="os-app-icon">
                                            <i class="ti-apple theme-cl"></i>
                                        </div>
                                        <div class="os-app-caps">
                                            App Store
                                            <span>Now it Available</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-sm-12 col-12 col-md-12">
			    <p class="mb-0">© <?php echo date('Y');?> {{ __('messages.Complaints') }} &
                                {{ __('messages.Commendations') }}. {{ __('messages.All_Rights_Reserved') }}</p>
                        </div>

                        {{-- <div class="col-lg-6 col-6 col-sm-6 col-md-6 text-right">
                            <ul class="footer-bottom-social">
                                <li><a href="#"><i class="ti-facebook"></i></a></li>
                                <li><a href="#"><i class="ti-twitter"></i></a></li>
                                <li><a href="#"><i class="ti-instagram"></i></a></li>
                                <li><a href="#"><i class="ti-linkedin"></i></a></li>
                            </ul>
                        </div> --}}

                    </div>
                </div>
            </div>
        </footer>
        <!-- ============================ Footer End ================================== -->

        <!-- Log In Modal -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="registermodal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-header-title">{{ __('messages.Sign_In') }}</h4>
                        <!-- <div class="social-login">
                            <ul>
                                <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Login with
                                        Facebook</a></li>
                                <li><a href="#" class="btn connect-gplus"><i class="ti-google"></i>Login with
                                        Gmail</a>
                                </li>
                            </ul>
                        </div>

                        <div class="devide-wrap"><span>OR</span></div> -->

                        <div class="login-form">
                            <form id="loginUserForm" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('messages.email') }}</label>
                                    <div class="input-with-gray">
                                        <input type="email" id="lemail" class="form-control" name="email"
                                            placeholder="{{ __('messages.email') }}" autocomplete="new-email">
                                        <i class="ti-user theme-cl"></i>
                                    </div>
                                    <span class="text-danger error-text lemail_error"></span>
                                </div>

                                <div class="form-group">
                                    {{-- <label>{{ __('messages.Password') }}</label>
                                    <div class="input-with-gray">
                                        <input type="password" id="lpassword" class="form-control"
                                            autocomplete="new-password" name="password"
                                            placeholder="{{ __('messages.Password') }}">
                                        <i class="ti-unlock theme-cl"></i>
                                    </div> --}}

                                    <label>{{ __('messages.Password') }}</label>
                                    <div class="input-group" id="show_hide_spassword">
                                        <input class="form-control" autocomplete="new-password" id="lpassword"
                                            placeholder="{{ __('messages.Password') }}" name="password"
                                            type="password" style="background: #f3f4f5;">
                                        <div class="input-group-addon" style="border: none;background: #f3f4f5;">
                                            <a href=""><i class="fa fa-eye-slash text-success"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <span id='loginmessage'></span>
                                    <span class="text-danger error-text lpassword_error"></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-md full-width pop-login">{{ __('messages.Login') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="mf-link"><i class="ti-user"></i>{{ __('messages.Haven_got_an_account') }}<a
                                href="javascript:void(0)" data-toggle="modal" data-target="#signup"
                                data-dismiss="modal"> {{ __('messages.Sign_Up') }}</a></div>
                        <div class="mf-forget"><a href="#" data-toggle="modal" data-target="#forget_password"
                                id="forget_click">{{ __('messages.Forgot_password') }}<i class="ti-help"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <input type="hidden" name="visitorCountry" id="visitorCountry"
            value="{{ Session::get('visitor_country') }}">

        <!-- Sign Up Modal -->
        <div class="modal fade" id="signup" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="sign-up">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-header-title">{{ __('messages.Sign_Up') }}</h4>
                        <!-- <div class="social-login">
                            <ul>
                                <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Login with
                                        Facebook</a></li>
                                <li><a href="#" class="btn connect-gplus"><i class="ti-google"></i>Login with
                                        Gmail</a>
                                </li>
                            </ul>
                        </div> -->

                        <!-- <div class="devide-wrap"><span>OR</span></div> -->

                        <div class="login-form">
                            <form id="register" enctype="multipart/form-data" lang="{{ Session::get('locale') }}"
                                autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.user_profile_pic') }}</label><br>
                                            <span class="text-warning"
                                                style="font-size: 12px;">{{ __('messages.user_profile_pic_info') }}</span>
                                            <div class="custom-file">
                                                <input type="file" name="userpic" accept="image/*"
                                                    class="custom-file-input" id="userpic"
                                                    onchange="validateProfilePic(this)">
                                                <label
                                                    class="custom-file-label">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                    </div>

                                    <input type="hidden" name="reg_date" id="reg_date">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.user_avatar_pic') }}</label><br>
                                            <span class="text-warning"
                                                style="font-size: 12px;">{{ __('messages.user_avatar_pic_info') }}</span>
                                            <div class="custom-file">
                                                <input type="file" name="avatar_pic" accept="image/*"
                                                    class="custom-file-input" id="avatar_pic"
                                                    onchange="validateProfilePic(this)">
                                                <label
                                                    class="custom-file-label">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                                        <span class="text-warning"
                                            style="font-size: 12px;">{{ __('messages.real_name_info') }}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">

                                        <div class="form-group">
                                            <label>{{ __('messages.User_First_Name') }}</label>
                                            <div class="input-with-gray">
                                                <input type="text"
                                                    placeholder="{{ __('messages.your_First_Name') }}"
                                                    class="form-control first_name" id="name" name="name">
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.User_Last_Name') }}</label>
                                            <div class="input-with-gray">
                                                <input type="text"
                                                    placeholder="{{ __('messages.your_Last_Name') }}"
                                                    class="form-control last_name" id="lname" name="lname">
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text lname_error"></span>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="nickname">{{ __('messages.nickname_u') }}</label><br>
                                            <span class="text-warning"
                                                style="font-size: 12px;">{{ __('messages.nickname_info') }}</span>
                                            <input class="form-control nickname" id="nicknameselected"
                                                name="nickname" maxlength="20"
                                                placeholder="{{ __('messages.Your_Nickname') }}" type="text">
                                        </div>
                                        <span class="text-danger error-text nickname_error"></span>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="from_date">{{ __('messages.dob') }}</label>
                                            <input class="date form-control" id="dob" name="dob"
                                                onkeydown="return false"
                                                placeholder="{{ __('messages.date_of_birth') }}" type="text">
                                        </div>
                                        <span class="text-danger error-text dob_error"></span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gender_dropdown">{{ __('messages.gender') }}</label>
                                            <select name="genderselection" id="gender_dropdown" class="form-control">
                                                <option value="default" disabled selected>
                                                    {{ __('messages.Select_your_option') }}</option>
                                                <option value="Male">{{ __('messages.Male') }}</option>
                                                <option value="Female">{{ __('messages.Female') }}</option>
                                                <option value="Custom">{{ __('messages.Custom') }}</option>
                                            </select>
                                            <input type="hidden" id="gender" name="gender">
                                        </div>
                                        <span class="text-danger error-text gender_error"></span>
                                    </div>
                                    @php
                                        $customGender = \App\Models\CustomGender::get();
                                    @endphp
                                    <div class="col-lg-6 col-md-6 col-sm-12 d-none" id="customGenderView">
                                        <div class="form-group">
                                            <label for="custom_dropdown">{{ __('messages.Custom_Gender') }}</label>
                                            <select name="gendercustom" id="custom_dropdown" class="form-control">
                                                <option value=""disabled selected>
                                                    {{ __('messages.Select_your_option') }}</option>
                                                @if (Session::get('locale') == 'en')
                                                    @foreach ($customGender as $genderdata)
                                                        <option value="{{ $genderdata->gender_title }}">
                                                            {{ $genderdata->gender_title }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($customGender as $genderdata)
                                                        <option value="{{ $genderdata->es_gender_title }}">
                                                            {{ $genderdata->es_gender_title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $country = [
                                        'Afghanistan',
                                        'Albania',
                                        'Algeria',
                                        'American Samoa',
                                        'Angola',
                                        'Anguilla',
                                        'Antartica',
                                        'Antigua and Barbuda',
                                        'Argentina',
                                        'Armenia',
                                        'Aruba',
                                        'Ashmore and Cartier Island',
                                        'Australia',
                                        'Austria',
                                        'Azerbaijan',
                                        'Bahamas',
                                        'Bahrain',
                                        'Bangladesh',
                                        'Barbados',
                                        'Belarus',
                                        'Belgium',
                                        'Belize',
                                        'Benin',
                                        'Bermuda',
                                        'Bhutan',
                                        'Bolivia',
                                        'Bosnia and Herzegovina',
                                        'Botswana',
                                        'Brazil',
                                        'British Virgin Islands',
                                        'Brunei',
                                        'Bulgaria',
                                        'Burkina Faso',
                                        'Burma',
                                        'Burundi',
                                        'Cambodia',
                                        'Cameroon',
                                        'Canada',
                                        'Cape Verde',
                                        'Cayman Islands',
                                        'Central African Republic',
                                        'Chad',
                                        'Chile',
                                        'China',
                                        'Christmas Island',
                                        'Clipperton Island',
                                        'Cocos (Keeling) Islands',
                                        'Colombia',
                                        'Comoros',
                                        'Congo, Democratic Republic of the',
                                        'Congo, Republic of the',
                                        'Cook Islands',
                                        'Costa Rica',
                                        "Cote d'Ivoire",
                                        'Croatia',
                                        'Cuba',
                                        'Cyprus',
                                        'Czeck Republic',
                                        'Denmark',
                                        'Djibouti',
                                        'Dominica',
                                        'Dominican Republic',
                                        'Ecuador',
                                        'Egypt',
                                        'El Salvador',
                                        'Equatorial Guinea',
                                        'Eritrea',
                                        'Estonia',
                                        'Ethiopia',
                                        'Europa Island',
                                        'Falkland Islands (Islas Malvinas)',
                                        'Faroe Islands',
                                        'Fiji',
                                        'Finland',
                                        'France',
                                        'French Guiana',
                                        'French Polynesia',
                                        'French Southern and Antarctic Lands',
                                        'Gabon',
                                        'Gambia, The',
                                        'Gaza Strip',
                                        'Georgia',
                                        'Germany',
                                        'Ghana',
                                        'Gibraltar',
                                        'Glorioso Islands',
                                        'Greece',
                                        'Greenland',
                                        'Grenada',
                                        'Guadeloupe',
                                        'Guam',
                                        'Guatemala',
                                        'Guernsey',
                                        'Guinea',
                                        'Guinea-Bissau',
                                        'Guyana',
                                        'Haiti',
                                        'Heard Island and McDonald Islands',
                                        'Holy See (Vatican City)',
                                        'Honduras',
                                        'Hong Kong',
                                        'Howland Island',
                                        'Hungary',
                                        'Iceland',
                                        'India',
                                        'Indonesia',
                                        'Iran',
                                        'Iraq',
                                        'Ireland',
                                        'Ireland, Northern',
                                        'Israel',
                                        'Italy',
                                        'Jamaica',
                                        'Jan Mayen',
                                        'Japan',
                                        'Jarvis Island',
                                        'Jersey',
                                        'Johnston Atoll',
                                        'Jordan',
                                        'Juan de Nova Island',
                                        'Kazakhstan',
                                        'Kenya',
                                        'Kiribati',
                                        'Korea, North',
                                        'Korea, South',
                                        'Kuwait',
                                        'Kyrgyzstan',
                                        'Laos',
                                        'Latvia',
                                        'Lebanon',
                                        'Lesotho',
                                        'Liberia',
                                        'Libya',
                                        'Liechtenstein',
                                        'Lithuania',
                                        'Luxembourg',
                                        'Macau',
                                        'Macedonia, Former Yugoslav Republic of',
                                        'Madagascar',
                                        'Malawi',
                                        'Malaysia',
                                        'Maldives',
                                        'Mali',
                                        'Malta',
                                        'Man, Isle of',
                                        'Marshall Islands',
                                        'Martinique',
                                        'Mauritania',
                                        'Mauritius',
                                        'Mayotte',
                                        'Mexico',
                                        'Micronesia',
                                        'Midway Islands',
                                        'Moldova',
                                        'Monaco',
                                        'Mongolia',
                                        'Montserrat',
                                        'Morocco',
                                        'Mozambique',
                                        'Namibia',
                                        'Nauru',
                                        'Nepal',
                                        'Netherlands',
                                        'Netherlands Antilles',
                                        'New Caledonia',
                                        'New Zealand',
                                        'Nicaragua',
                                        'Niger',
                                        'Nigeria',
                                        'Niue',
                                        'Norfolk Island',
                                        'Northern Mariana Islands',
                                        'Norway',
                                        'Oman',
                                        'Pakistan',
                                        'Palau',
                                        'Panama',
                                        'Papua New Guinea',
                                        'Paraguay',
                                        'Peru',
                                        'Philippines',
                                        'Pitcaim Islands',
                                        'Poland',
                                        'Portugal',
                                        'Puerto Rico',
                                        'Qatar',
                                        'Reunion',
                                        'Romainia',
                                        'Russia',
                                        'Rwanda',
                                        'Saint Helena',
                                        'Saint Kitts and Nevis',
                                        'Saint Lucia',
                                        'Saint Pierre and Miquelon',
                                        'Saint Vincent and the Grenadines',
                                        'Samoa',
                                        'San Marino',
                                        'Sao Tome and Principe',
                                        'Saudi Arabia',
                                        'Scotland',
                                        'Senegal',
                                        'Seychelles',
                                        'Sierra Leone',
                                        'Singapore',
                                        'Slovakia',
                                        'Slovenia',
                                        'Solomon Islands',
                                        'Somalia',
                                        'South Africa',
                                        'South Georgia and South Sandwich Islands',
                                        'Spain',
                                        'Spratly Islands',
                                        'Sri Lanka',
                                        'Sudan',
                                        'Suriname',
                                        'Svalbard',
                                        'Swaziland',
                                        'Sweden',
                                        'Switzerland',
                                        'Syria',
                                        'Taiwan',
                                        'Tajikistan',
                                        'Tanzania',
                                        'Thailand',
                                        'Tobago',
                                        'Toga',
                                        'Tokelau',
                                        'Tonga',
                                        'Trinidad',
                                        'Tunisia',
                                        'Turkey',
                                        'Turkmenistan',
                                        'Tuvalu',
                                        'Uganda',
                                        'Ukraine',
                                        'United Arab Emirates',
                                        'United Kingdom',
                                        'Uruguay',
                                        'USA',
                                        'Uzbekistan',
                                        'Vanuatu',
                                        'Venezuela',
                                        'Vietnam',
                                        'Virgin Islands',
                                        'Wales',
                                        'Wallis and Futuna',
                                        'West Bank',
                                        'Western Sahara',
                                        'Yemen',
                                        'Yugoslavia',
                                        'Zambia',
                                        'Zimbabwe',
                                    ];
                                    
                                @endphp
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="firstName2">{{ __('messages.Select_a_country') }}</label>
                                            <br>
                                            <span class="text-warning"
                                                style="font-size: 12px;">{{ __('messages.country_live') }}</span>
                                            {{-- <select id="country2" class="form-control form-control-rounded"
                                                name="country_name" autocomplete="off" required></select> --}}
                                            <select id="country2" class="form-control" name="country_name">
                                                <option value="default" disabled selected>
                                                    {{ __('messages.Select_a_country') }}</option>

                                                @foreach ($country as $countyName)
                                                    <option value="{{ $countyName }}">
                                                        {{ $countyName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text country_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.email') }}</label>
                                            <div class="input-with-gray">
                                                <input type="email" placeholder="{{ __('messages.email') }}"
                                                    autocomplete="new-email" class="form-control" id="email"
                                                    name="email">
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Password') }}</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control" autocomplete="new-password"
                                                    id="signpassword" placeholder="*******"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}" name="password"
                                                    type="password" style="background: #f3f4f5;">
                                                <div class="input-group-addon"
                                                    style="border: none;background: #f3f4f5;">
                                                    <a href=""><i class="fa fa-eye-slash text-success"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                            {{-- <label>{{ __('messages.Password') }}</label>
                                            <div class="input-with-gray">
                                                <input type="password" placeholder="*******" class="form-control"
                                                    id="signpassword" autocomplete="new-password"
                                                    onselectstart="return false" onpaste="return false;"
                                                    onCopy="return false" onCut="return false" onDrag="return false"
                                                    onDrop="return false"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}" name="password">
                                                <i class="ti-unlock theme-cl"></i>
                                            </div> --}}
                                            {{-- <i class="fa fa-eye-slash float-right" aria-hidden="true"></i> --}}
                                        </div>
                                        <span class="text-danger error-text spassword_error"></span>

                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Confirmed_Password') }}</label>
                                            <div class="input-group" id="show_hide_cpassword">
                                                <input class="form-control" autocomplete="new-password"
                                                    id="password_confirmation" placeholder="*******"
                                                    name="password_confirmation" type="password"
                                                    style="background: #f3f4f5;">
                                                <div class="input-group-addon"
                                                    style="border: none;background: #f3f4f5;">
                                                    <a href=""><i class="fa fa-eye-slash text-success"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                            {{-- <label>{{ __('messages.Confirmed_Password') }}</label>
                                            <div class="input-with-gray">
                                                <input type="password" placeholder="*******" class="form-control"
                                                    id="password_confirmation" onselectstart="return false"
                                                    onpaste="return false;" onCopy="return false"
                                                    onCut="return false" onDrag="return false" onDrop="return false"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}"
                                                    autocomplete="new-password" name="password_confirmation">
                                                <i class="ti-unlock theme-cl"></i>
                                            </div> --}}
                                            <span id='msgSignError'></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group" style="display:flex;">
                                            <input type="checkbox" name="terms" id="agree"
                                                style="height: 20px; width: 20px;margin-right: 10px;" value="1">
                                            <label for="remember"><a href="{{ route('terms_and_conditions') }}"
                                                    target="_blank">{{ __('messages.accept_terms_condition') }}</a></label>


                                        </div>
                                        <span class="text-danger error-text sterms_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            @if (!empty(config('services.recaptcha.key')))
                                                <strong>ReCaptcha:</strong>
                                                <div class="g-recaptcha"
                                                    data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                            @elseif (app()->environment('local'))
                                                <input type="hidden" name="g-recaptcha-response" value="local-dev">
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-danger error-text g-recaptcha-response_error"></span>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" id="regSubmit"
                                                class="btn btn-primary btn-md full-width pop-login">{{ __('messages.register') }}</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="mf-link"><i class="ti-user"></i>{{ __('messages.Have_Account') }}<a
                                href="#" data-toggle="modal" data-target="#login" data-dismiss="modal">
                                {{ __('messages.sign_in') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Profile Update Modal -->
        <div class="modal fade" id="signupUpdate" role="dialog" aria-labelledby="sign-update" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="sign-update">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="modal-header-title"
                            style="font-size: 28px;">{{ __('messages.Update_Profile_Details') }}</label>

                        <div class="login-form">
                            <form id="updateProfileForm" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.user_profile_pic') }}</label>
                                            <div class="custom-file">
                                                <input type="file" name="userpic" accept="image/*"
                                                    class="custom-file-input" id="uuserpic"
                                                    onchange="validateProfilePic(this)">
                                                <label
                                                    class="custom-file-label">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }} </span>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.user_avatar_pic') }}</label>
                                            <div class="custom-file">
                                                <input type="file" name="avatar_pic" accept="image/*"
                                                    class="custom-file-input" id="uavatar_pic"
                                                    onchange="validateProfilePic(this)">
                                                <label
                                                    class="custom-file-label">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }} </span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.User_First_Name') }}</label>
                                            <div class="input-with-gray">
                                                <input type="text"
                                                    placeholder="{{ __('messages.your_First_Name') }}"
                                                    oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                    oninput="setCustomValidity('')" class="form-control first_name"
                                                    id="uname" value="{{ Session::get('login_fname') }}"
                                                    name="name" required>
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.User_Last_Name') }}</label>
                                            <div class="input-with-gray">
                                                <input type="text"
                                                    placeholder="{{ __('messages.your_Last_Name') }}"
                                                    class="form-control last_name"
                                                    value="{{ Session::get('login_lname') }}" id="ulname"
                                                    name="lname" required>
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text lname_error"></span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nickname">{{ __('messages.nickname_u') }}</label>
                                            <input class="form-control nickname" id="unicknameselected"
                                                name="nickname" maxlength="20"
                                                value="{{ Session::get('login_nickname') }}"
                                                placeholder="{{ __('messages.Your_Nickname') }}" type="text">
                                        </div>
                                        <span class="text-danger error-text unickname_error"></span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="from_date">{{ __('messages.dob') }}</label>
                                            <input class="date form-control" id="udob"
                                                value="{{ Session::get('login_dob') }}" name="dob"
                                                onkeydown="return false"
                                                placeholder="{{ __('messages.date_of_birth') }}" type="text">
                                        </div>
                                        <span class="text-danger error-text udob_error"></span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gender_dropdown">{{ __('messages.gender') }}</label>
                                            <select name="genderselection" id="ugender_dropdown"
                                                class="form-control">
                                                <option value="" disabled selected>
                                                    {{ __('messages.Select_your_option') }}</option>
                                                <option value="Male"
                                                    {{ 'Male' == Session::get('login_gender') ? 'selected' : '' }}>
                                                    {{ __('messages.Male') }}</option>
                                                <option value="Female"
                                                    {{ 'Female' == Session::get('login_gender') ? 'selected' : '' }}>
                                                    {{ __('messages.Female') }}</option>
                                                @php
                                                    $seleGender = '';
                                                    $customeClass = 'd-none';
                                                    if (Session::get('login_gender') == 'Female' || Session::get('login_gender') == 'Male') {
                                                        $seleGender = '';
                                                        $customeClass = 'd-none';
                                                    } else {
                                                        $seleGender = 'selected';
                                                        $customeClass = '';
                                                    }
                                                @endphp
                                                <option value="Custom" {{ $seleGender }}>
                                                    {{ __('messages.Custom') }}</option>
                                            </select>
                                            <input type="hidden" id="ugender" name="gender"
                                                value="{{ Session::get('login_gender') }}">
                                        </div>
                                        <span class="text-danger error-text ugender_error"></span>
                                    </div>
                                    <input type="hidden" name="user_id"
                                        value="{{ Session::get('login_user_id') }}">

                                    @php
                                        $customUGender = \App\Models\CustomGender::get();
                                    @endphp
                                    <div class="col-lg-6 col-md-6 col-sm-12 {{ $customeClass }}"
                                        id="ucustomGenderView">
                                        <div class="form-group">
                                            <label for="custom_dropdown">{{ __('messages.Custom_Gender') }}</label>
                                            <select name="gendercustom" id="ucustom_dropdown" class="form-control">
                                                <option value="" disabled selected>
                                                    {{ __('messages.Select_your_option') }}</option>
                                                @if (Session::get('locale') == 'en')
                                                    @foreach ($customUGender as $genderUdata)
                                                        @php
                                                            $selected = '';
                                                            
                                                            if (Session::get('login_gender') == $genderUdata->gender_title) {
                                                                $selected = 'selected';
                                                            } elseif (Session::get('login_gender') == $genderUdata->es_gender_title) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            
                                                        @endphp

                                                        <option value="{{ $genderUdata->gender_title }}"
                                                            {{ $selected }}>{{ $genderUdata->gender_title }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($customUGender as $genderUdata)
                                                        @php
                                                            $selected = '';
                                                            
                                                            if (Session::get('login_gender') == $genderUdata->es_gender_title) {
                                                                $selected = 'selected';
                                                            } elseif (Session::get('login_gender') == $genderUdata->gender_title) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            
                                                        @endphp

                                                        <option value="{{ $genderUdata->es_gender_title }}"
                                                            {{ $selected }}>{{ $genderUdata->es_gender_title }}
                                                        </option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="firstName2">{{ __('messages.Select_a_country') }}</label>
                                            <select id="ucountry" class="form-control form-control-rounded"
                                                name="country_name" autocomplete="off" required>
                                                <option value="" disabled>{{ __('messages.Select_a_country') }}
                                                </option>

                                                @foreach ($country as $countyName)
                                                    @php
                                                        $selectedCountry = '';
                                                        if (Session::get('login_country') == $countyName) {
                                                            $selectedCountry = 'selected';
                                                        } else {
                                                            $selectedCountry = '';
                                                        }
                                                    @endphp
                                                    <option value="{{ $countyName }}" {{ $selectedCountry }}>
                                                        {{ $countyName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.email') }}</label>
                                            <div class="input-with-gray">
                                                <input type="email" placeholder="{{ __('messages.email') }}"
                                                    autocomplete="new-email" class="form-control" id="uemail"
                                                    value="{{ Session::get('login_email') }}" name="email"
                                                    required>
                                                <i class="ti-user theme-cl">
                                                </i>
                                            </div>
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Password') }}</label>
                                            <div class="input-group" id="show_hide_upassword">
                                                <input class="form-control" autocomplete="new-password"
                                                    id="usignpassword" placeholder="*******"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}" name="password"
                                                    type="password" style="background: #f3f4f5;">
                                                <div class="input-group-addon"
                                                    style="border: none;background: #f3f4f5;">
                                                    <a href=""><i class="fa fa-eye-slash text-success"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                            {{-- <div class="input-with-gray">
                                                <input type="password" placeholder="*******" class="form-control"
                                                    id="usignpassword" autocomplete="new-password"
                                                    onselectstart="return false" onpaste="return false;"
                                                    onCopy="return false" onCut="return false" onDrag="return false"
                                                    onDrop="return false"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}" name="password">
                                                <i class="ti-unlock theme-cl"></i>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Confirmed_Password') }}</label>
                                            <div class="input-group" id="show_hide_ucpassword">
                                                <input class="form-control" autocomplete="new-password"
                                                    id="upassword_confirmation" placeholder="*******"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                                    title="{{ __('messages.password_should') }}"
                                                    name="password_confirmation" type="password"
                                                    style="background: #f3f4f5;">
                                                <div class="input-group-addon"
                                                    style="border: none;background: #f3f4f5;">
                                                    <a href=""><i class="fa fa-eye-slash text-success"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                            {{-- <div class="input-with-gray">
                                                <input type="password" placeholder="*******" class="form-control"
                                                    id="upassword_confirmation" onselectstart="return false"
                                                    onpaste="return false;" onCopy="return false"
                                                    onCut="return false" onDrag="return false" onDrop="return false"
                                                    autocomplete="new-password" name="password_confirmation">
                                                <i class="ti-unlock theme-cl"></i>
                                            </div> --}}

                                            <span id='umsgSignError'></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" id="profileSubmit"
                                                class="btn btn-primary btn-md full-width pop-login">{{ __('messages.update') }}</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        {{-- forget password modal --}}
        <div class="modal fade" id="forget_password" tabindex="-1" role="dialog" aria-labelledby="forget_modal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="forget_modal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-header-title">{{ __('messages.Forgot_password') }}?</h4>
                        <div class="login-form">
                            <form id="forgotPassword" action="">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('messages.email') }}</label>
                                    <div class="input-with-gray">
                                        <input type="email" class="form-control" id="femail" name="email"
                                            placeholder="{{ __('messages.email') }}" required>
                                        <i class="ti-email theme-cl"></i>
                                    </div>
                                    <span id='forgotmessage'></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="fsend"
                                        class="btn btn-primary btn-md full-width pop-login">{{ __('messages.send') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End forget password modal --}}
        <style>
            .swal-title {
                font-size: 16px !important;
            }
        </style>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/summernote.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jQuery.style.switcher.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/countries.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.37/moment-timezone-with-data.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.es.min.js"
        integrity="sha512-5pjEAV8mgR98bRTcqwZ3An0MYSOleV04mwwYj2yw+7PBhFVf/0KcE+NEox0XrFiU5+x5t5qidmo5MgBkDD9hEw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/assets/js/mapInput.js') }}"></script>
    @if (!empty(config('services.maps.key')))
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.maps.key') }}&libraries=places&callback=initialize&loading=async"
        async defer></script>
    @endif
    <style>
        /*
         * Places autocomplete + map layout
         * Do NOT put height/max-height/overflow:hidden on gmp-place-autocomplete —
         * the suggestion list renders inside that host and gets clipped.
         */
        .places-autocomplete-wrap {
            position: relative;
            display: block;
            width: 100%;
            min-height: 56px;
            margin: 8px 0 16px;
            z-index: 40;
            overflow: visible !important;
        }

        .places-autocomplete-wrap .map-input[type="hidden"] {
            display: none !important;
        }

        /* Keep parents from clipping; stack address field above the map */
        .form-group:has(.places-autocomplete-wrap),
        .col-lg-12:has(.places-autocomplete-wrap),
        .row:has(.places-autocomplete-wrap) {
            overflow: visible !important;
            position: relative;
            z-index: 40;
        }

        gmp-place-autocomplete,
        .map-place-autocomplete {
            display: block !important;
            width: 100% !important;
            min-height: 56px !important;
            box-sizing: border-box !important;
            background-color: #fff !important;
            border: 1px solid #e0ecf5 !important;
            border-radius: 0 !important;
            overflow: visible !important;
            position: relative;
            z-index: 50;
            font-size: 15px !important;
            color-scheme: light;
            --gmp-mat-color-surface: #ffffff;
            --gmp-mat-color-on-surface: #343a40;
            --gmp-mat-color-on-surface-variant: #6c757d;
            --gmp-mat-color-primary: #1a73e8;
        }

        /* Size the text field only (not the whole widget / dropdown) */
        gmp-place-autocomplete input,
        .map-place-autocomplete input,
        gmp-place-autocomplete .input-container input,
        gmp-place-autocomplete::part(input) {
            min-height: 54px !important;
            height: 54px !important;
            line-height: 1.5 !important;
            font-size: 15px !important;
            padding: .5rem .75rem !important;
            box-sizing: border-box !important;
        }

        /* Legacy + new prediction panels above the map */
        .pac-container {
            z-index: 100000 !important;
        }

        .address-map-box {
            position: relative;
            z-index: 1;
            clear: both;
            width: 100%;
            height: 400px;
            margin-top: 8px;
            margin-bottom: 16px;
            overflow: hidden;
            border: 1px solid #e0ecf5;
            border-radius: 0;
        }

        .address-map-box #address-map,
        .address-map-box > div {
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateInit"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript">
        let dateCurrent = new Date().toLocaleDateString();
        $('#reg_date').val(dateCurrent);
        console.log(dateCurrent);

        var langDob = $('#langSelected').val();
        // $(document).on('click', '.input-with-gray i', function(e) {
        //     console.log('click');
        // });
        checkCookie();

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            let popup = getCookie("popupshow");
            if (popup != "") {
                // alert("Welcome again ");
            } else {
                // user = prompt("Please enter your name:", "");
                popup = "show";
                if (popup != "" && popup != null) {
                    swal({
                        title: "{{ __('messages.disclaimer') }}",
                        type: "warning",
                        text: "",
                        icon: "warning",
                        // showConfirmButton: true
                    }).then(function() {
                        setCookie("popupshow", popup, 1);
                    });

                }
            }
        }


        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });


        $("#show_hide_spassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_spassword input').attr("type") == "text") {
                $('#show_hide_spassword input').attr('type', 'password');
                $('#show_hide_spassword i').addClass("fa-eye-slash");
                $('#show_hide_spassword i').removeClass("fa-eye");
            } else if ($('#show_hide_spassword input').attr("type") == "password") {
                $('#show_hide_spassword input').attr('type', 'text');
                $('#show_hide_spassword i').removeClass("fa-eye-slash");
                $('#show_hide_spassword i').addClass("fa-eye");
            }
        });

        $("#show_hide_cpassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_cpassword input').attr("type") == "text") {
                $('#show_hide_cpassword input').attr('type', 'password');
                $('#show_hide_cpassword i').addClass("fa-eye-slash");
                $('#show_hide_cpassword i').removeClass("fa-eye");
            } else if ($('#show_hide_cpassword input').attr("type") == "password") {
                $('#show_hide_cpassword input').attr('type', 'text');
                $('#show_hide_cpassword i').removeClass("fa-eye-slash");
                $('#show_hide_cpassword i').addClass("fa-eye");
            }
        });

        $("#show_hide_upassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_upassword input').attr("type") == "text") {
                $('#show_hide_upassword input').attr('type', 'password');
                $('#show_hide_upassword i').addClass("fa-eye-slash");
                $('#show_hide_upassword i').removeClass("fa-eye");
            } else if ($('#show_hide_upassword input').attr("type") == "password") {
                $('#show_hide_upassword input').attr('type', 'text');
                $('#show_hide_upassword i').removeClass("fa-eye-slash");
                $('#show_hide_upassword i').addClass("fa-eye");
            }
        });

        $("#show_hide_ucpassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_ucpassword input').attr("type") == "text") {
                $('#show_hide_ucpassword input').attr('type', 'password');
                $('#show_hide_ucpassword i').addClass("fa-eye-slash");
                $('#show_hide_ucpassword i').removeClass("fa-eye");
            } else if ($('#show_hide_ucpassword input').attr("type") == "password") {
                $('#show_hide_ucpassword input').attr('type', 'text');
                $('#show_hide_ucpassword i').removeClass("fa-eye-slash");
                $('#show_hide_ucpassword i').addClass("fa-eye");
            }
        });

        $('#login').on('shown.bs.modal', function() {
            jQuery(".nav-menus-wrapper-close-button").trigger("click");

        });

        $('#signupUpdate').on('shown.bs.modal', function() {
            jQuery(".nav-menus-wrapper-close-button").trigger("click");
        });

        $('.setting_click').on('click', function() {
            jQuery(".submenu-indicator").trigger("click");
        });
        $("document").ready(function() {
            console.log($('#visitorCountry').val());
            // populateCountries("country2");
            console.log("{{ Session::get('locale') }}");
        });
        var ctodayDate = moment();

        $("#dob").datepicker({
            format: 'yyyy-mm-dd',
            endDate: ctodayDate.toDate(),
            language: langDob,
            autoclose: true
        });

        $("#udob").datepicker({
            format: 'yyyy-mm-dd',
            endDate: ctodayDate.toDate(),
            language: langDob,
            autoclose: true
        });

        $('#ugender_dropdown').on('change', function() {
            var uselectedGender = this.value;

            if (uselectedGender == "Male") {
                $('#ugender').val(uselectedGender);
                $('#ucustomGenderView').addClass('d-none');
                $("#ucustom_dropdown").attr("required", false);
            } else if (uselectedGender == "Female") {
                $('#ugender').val(uselectedGender);
                $('#ucustomGenderView').addClass('d-none');
                $("#ucustom_dropdown").attr("required", false);
            } else {
                $('#ugender').val(uselectedGender);
                $('#ucustomGenderView').removeClass('d-none');
                $("#ucustom_dropdown").attr("required", true);
            }

        });

        $('#ucustom_dropdown').on('change', function() {
            var uselectedCusGender = this.value;
            $('#ugender').val(uselectedCusGender);
        });

        $('#usignpassword').on('keyup change', function() {
            // if ($('#usignpassword').val() == "") {
            //     $('#umsgSignError').html("{{ __('messages.Please_enter_password') }}").css('color', 'red');
            //     $('#profileSubmit').prop('disabled', true);
            // } else if ($('#upassword_confirmation').val() == "") {
            //     $('#umsgSignError').html("{{ __('messages.Please_enter_confirm_password') }}").css('color',
            //         'red');
            //     $('#profileSubmit').prop('disabled', true);
            // } else 
            if ($('#usignpassword').val().length != 0) {
                if ($('#usignpassword').val() == $('#upassword_confirmation').val()) {
                    // $('#umsgSignError').html('Matching').css('color', 'green');
                    $('#umsgSignError').html('');
                    $('#profileSubmit').prop('disabled', false);
                } else {
                    $('#umsgSignError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                    $('#profileSubmit').prop('disabled', true);
                }
            } else {
                $('#umsgSignError').html('');
                $('#profileSubmit').prop('disabled', false);
            }
        });

        $('#upassword_confirmation').on('keyup change', function() {
            if ($('#usignpassword').val() == $('#upassword_confirmation').val()) {
                // $('#umsgSignError').html('Matching').css('color', 'green');
                $('#umsgSignError').html('');
                $('#profileSubmit').prop('disabled', false);
            } else {
                $('#umsgSignError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                $('#profileSubmit').prop('disabled', true);
            }
        });

        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('userprofileupdate') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $.each(data.error, function(prefix, val) {
                            // console.log(val);
                            // console.log(prefix);
                            // $('span.' + prefix + '_error').text(val[0]);

                            if (prefix == 'email') {
                                $('span.' + prefix + '_error').text(
                                    "{{ __('messages.Email_taken') }}");
                                // $('#regSubmit').prop('disabled', true);
                            }
                        });

                        $('#umsgSignError').html(data.msg).css(
                            'color',
                            'red');
                    } else if (data.status == 2) {
                        // email error email_error
                        $('.email_error').text("{{ __('messages.Email_taken') }}");
                    } else {
                        $('#profileSubmit').prop('disabled', false);
                        $('#umsgSignError').html('');
                        $('#usignpassword').val('');
                        $('#upassword_confirmation').val('');
                        $('.email_error').val('');
                        $('#signupUpdate').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                        });
                    }
                }
            });
        });

        // $(".nickname").keypress(function(e) {
        //     var keyCode = e.keyCode || e.which;
        //     $(".nickname_error").html("");
        //     //Regex for Valid Characters i.e. Alphabets.
        //     var regex = /^[A-Za-z]+$/;
        //     //Validate TextBox value against the Regex.
        //     var isValid = regex.test(String.fromCharCode(keyCode));
        //     if (!isValid) {
        //         $(".nickname_error").html("Only Alphabets allowed.");
        //     }
        //     return isValid;
        // });

        $(".first_name").keyup(function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 8 || keyCode == 46) {
                $(".name_error").html("");
            }
        });


        $(".last_name").keyup(function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 8 || keyCode == 46) {
                $(".lname_error").html("");
            }
        });


        $(".first_name").keypress(function(e) {
            var keyCode = e.keyCode || e.which;
            $(".name_error").html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ]+$/
            // /^[A-Za-z]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $(".name_error").html("{{ __('messages.Only_Alphabets') }}");
            }
            return isValid;
        });

        // $(".last_name").keypress(function(e) {
        //     var keyCode = e.keyCode || e.which;
        //     $(".lname_error").html("");
        //     //Regex for Valid Characters i.e. Alphabets.
        //     var regex = /^[A-Za-z]+$/;
        //     //Validate TextBox value against the Regex.
        //     var isValid = regex.test(String.fromCharCode(keyCode));
        //     if (!isValid) {
        //         $(".lname_error").html("{{ __('messages.Only_Alphabets') }}");
        //     }
        //     return isValid;
        // });
        // $('.last_name').on('change', function(e) {
        $(".last_name").keypress(function(e) {
            var charCode = e.keyCode || e.which;
            $(".lname_error").html("");
            var regex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/g;
            // /^[a-zA-Z\s]*$/g;
            // /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*$/
            var isValid = regex.test(String.fromCharCode(charCode));
            if (!isValid) {
                $('.lname_error').html("{{ __('messages.Only_Alphabets') }}");
            }
            return isValid;
        });

        $('#gender_dropdown').on('change', function() {
            var selectedGender = this.value;

            if (selectedGender == "Male") {
                $('#gender').val(selectedGender);
                $('#customGenderView').addClass('d-none');
                $("#custom_dropdown").attr("required", false);
            } else if (selectedGender == "Female") {
                $('#gender').val(selectedGender);
                $('#customGenderView').addClass('d-none');
                $("#custom_dropdown").attr("required", false);
            } else {
                $('#gender').val(selectedGender);
                $('#customGenderView').removeClass('d-none');
                $("#custom_dropdown").attr("required", true);
            }

        });

        $('#custom_dropdown').on('change', function() {
            var selectedCusGender = this.value;
            $('#gender').val(selectedCusGender);
        });

        function validateProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#userpic').val('');
                $('#userpic').text("{{ __('messages.Choose_file') }}");
                $('#avatar_pic').val('');
                $('#avatar_pic').text("{{ __('messages.Choose_file') }}");
                $('#uuserpic').val('');
                $('#uuserpic').text("{{ __('messages.Choose_file') }}");
                $('#uavatar_pic').val('');
                $('#uavatar_pic').text("{{ __('messages.Choose_file') }}");

            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#userpic').val('');
                $('#userpic').text("{{ __('messages.Choose_file') }}");
                $('#avatar_pic').val('');
                $('#avatar_pic').text("{{ __('messages.Choose_file') }}");
                $('#uuserpic').val('');
                $('#uuserpic').text("{{ __('messages.Choose_file') }}");
                $('#uavatar_pic').val('');
                $('#uavatar_pic').text("{{ __('messages.Choose_file') }}");
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        $('#forget_click').on("click", function() {
            $("#login").modal('hide');
        });

        $('#forgotPassword').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('forget_request') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $('#forgotmessage').html(data.msg).css(
                            'color',
                            'red');
                    } else {
                        $('#forgotmessage').html('');
                        $('#forgotPassword').get(0).reset();
                        $('#forget_password').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            location.reload();
                        });
                    }
                }
            });
        });

        $('#loginUserForm').on('submit', function(e) {
            e.preventDefault();

            if ($('#lemail').val() == "") {
                $(".lemail_error").html("{{ __('messages.fill_out') }}");
                $("#lemail").focus();
                return false;
            } else {
                $(".lemail_error").html("");
            }
            if ($('#lpassword').val() == "") {
                $(".lpassword_error").html("{{ __('messages.fill_out') }}");
                $("#lpassword").focus();
                return false;
            } else {
                $(".lpassword_error").html("");
            }

            $.ajax({
                url: "{{ Route('user_Login') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $('#loginmessage').text(data.msg).css(
                            'color',
                            'red');
                    } else {
                        $('#loginmessage').text('');
                        $('#loginUserForm').get(0).reset();
                        $('#login').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                            // location.reload();
                        });
                    }
                }
            });
        });

        $('#register').on('submit', function(e) {
            e.preventDefault();

            if ($('#name').val() == "") {
                $(".name_error").html("{{ __('messages.fill_out') }}");
                $("#name").focus();
                return false;
            } else {
                $(".name_error").html("");
            }

            if ($('#lname').val() == "") {
                $(".lname_error").html("{{ __('messages.fill_out') }}");
                $("#lname").focus();
                return false;
            } else {
                $(".lname_error").html("");
            }

            if ($('#nicknameselected').val() == "") {
                $(".nickname_error").html("{{ __('messages.fill_out') }}");
                $("#nicknameselected").focus();
                return false;
            } else {
                $(".nickname_error").html("");
            }

            if ($('#dob').val() == "") {
                $(".dob_error").html("{{ __('messages.fill_out') }}");
                $("#dob").focus();
                return false;
            } else {
                $(".dob_error").html("");
            }

            if ($('#gender_dropdown option:selected').val() == 'default') {
                $(".gender_error").html("{{ __('messages.fill_out') }}");
                $("#gender_dropdown").focus();
                return false;

            } else {
                $(".gender_error").html("");
            }

            if ($('#country2 option:selected').val() == 'default') {
                $(".country_error").html("{{ __('messages.Select_a_country') }}");
                $("#country2").focus();
                return false;
            } else {
                $(".country_error").html(" ");
            }

            if ($('#email').val() == "") {
                $(".email_error").html("{{ __('messages.fill_out') }}");
                $("#email").focus();
                return false;
            } else {
                $(".email_error").html("");
            }

            if ($('#signpassword').val() == "") {
                $(".spassword_error").html("{{ __('messages.fill_out') }}");
                $("#signpassword").focus();
                return false;
            } else {
                $(".spassword_error").html("");
            }

            if ($('#password_confirmation').val() == "") {
                $(".msgSignError").html("{{ __('messages.fill_out') }}");
                $("#password_confirmation").focus();
                return false;
            } else {
                $(".msgSignError").html("");
            }

            if ($("#agree").is(':checked')) {
                $(".sterms_error").html("");
            } else {
                $(".sterms_error").html("{{ __('messages.fill_out') }}");
                $("#agree").focus();
                return false;
            }


            $.ajax({
                url: "{{ Route('register') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $.each(data.error, function(prefix, val) {
                            // console.log(val);
                            // console.log(prefix);
                            // $('span.' + prefix + '_error').text(val[0]);

                            if (prefix == 'g-recaptcha-response') {
                                $('span.' + prefix + '_error').text(
                                    "{{ __('messages.recaptcha_required') }}");
                            }

                            if (prefix == 'email') {
                                $('span.' + prefix + '_error').text(
                                    "{{ __('messages.Email_taken') }}");

                                grecaptcha.reset();
                                // $('#regSubmit').prop('disabled', true);
                            }
                        });

                        $('#msgSignError').html(data.msg).css(
                            'color',
                            'red');
                    } else {
                        $('#regSubmit').prop('disabled', false);
                        $('#msgSignError').html('');
                        $('#register').get(0).reset();
                        $('#signup').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                        });
                    }
                }
            });
        });

        $('#signpassword').on('keyup change', function() {
            if ($('#signpassword').val() == "") {
                $('#msgSignError').html("{{ __('messages.Please_enter_password') }}").css('color', 'red');
                $('#regSubmit').prop('disabled', true);
            } else if ($('#password_confirmation').val() == "") {
                $('#msgSignError').html("{{ __('messages.Please_enter_confirm_password') }}").css('color', 'red');
                $('#regSubmit').prop('disabled', true);
            } else if ($('#signpassword').val().length != 0) {
                if ($('#signpassword').val() == $('#password_confirmation').val()) {
                    // $('#msgSignError').html('Matching').css('color', 'green');
                    $('#msgSignError').html('');
                    $('#regSubmit').prop('disabled', false);
                } else {
                    $('#msgSignError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                    $('#regSubmit').prop('disabled', true);
                }
            } else {
                $('#msgSignError').html('');
                $('#regSubmit').prop('disabled', false);
            }
        });

        $('#password_confirmation').on('keyup change', function() {
            if ($('#signpassword').val() == $('#password_confirmation').val()) {
                // $('#msgSignError').html('Matching').css('color', 'green');
                $('#msgSignError').html('');
                $(".spassword_error").html("");
                $('#regSubmit').prop('disabled', false);
            } else {
                $('#msgSignError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                $('#regSubmit').prop('disabled', true);
            }
        });

        $('#login').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $("#loginmessage").html('');
        });

        $('#signup').on('hidden.bs.modal', function() {
            $('#regSubmit').prop('disabled', false);
            $(this).find('form').trigger('reset');
            $(".email_error").html('');
            $("#msgSignError").html('');
            $(".name_error").html("");
        });

        $('#forget_password').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $("#forgotmessage").html('');
            $('#fsend').prop('disabled', false);
        });

        $('#signupUpdate').on('hidden.bs.modal', function() {
            location.reload();
        });

        $('#email').on('change', function() {
            var validEmail = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($("#email").val());
            if (!validEmail) {
                $(".email_error").html("{{ __('messages.valid_email') }}");
                $("#email").focus();
                $('#regSubmit').prop('disabled', true);
                return false;
            } else {
                $(".email_error").html("");
                $('#regSubmit').prop('disabled', false);
            }
        });

        $('#lemail').on('change', function() {
            var validEmail = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($("#lemail").val());
            if (!validEmail) {
                $(".lemail_error").html("{{ __('messages.valid_email') }}");
                $("#lemail").focus();
                return false;
            } else {
                $(".lemail_error").html("");
            }
        });



        $('#femail').on('change', function() {
            var validEmail = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($("#femail").val());
            if (!validEmail) {
                $("#forgotmessage").html("{{ __('messages.valid_email') }}").css('color', 'red');
                $("#femail").focus();
                $('#fsend').prop('disabled', true);
                return false;
            } else {
                $("#forgotmessage").html("");
                $('#fsend').prop('disabled', false);
            }
        });

        var changeLang = "{{ route('changeLang') }}";

        $(".changeLang").change(function() {
            window.location.href = changeLang + "?lang=" + $(this).val();
            // setCurrentLang($(this).val());
        });
        // localStorage.setItem("show", "0");

        function googleTranslateInit() {

            // if (localStorage.getItem("show") != "1") {
            //     swal({
            //         title: "{{ __('messages.disclaimer') }}",
            //         type: "warning",
            //         text: "{{ __('messages.yes_no') }}",
            //         icon: "warning",
            //         // showConfirmButton: true
            //     }).then(function() {
            //         if (localStorage.getItem("show") == "0") {
            //             localStorage.setItem("show", "1");
            //         }
            //         console.log(localStorage.getItem("show"));

            //     });
            // }

            // console.log(localStorage.getItem("show"));
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

        function setCurrentLang(lang) {

            $.ajax({
                url: "{{ Route('set_current_lang') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'lang': lang,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    // console.log(response);
                    // location.reload();
                    if (response.status == 0) {} else {}
                }
            });
        }

        $("body").on("change", ".goog-te-combo", function(e) {
            // if ($(".goog-te-combo").val() == "en") {
            //     // alert($(".goog-te-combo").val());
            //     $('#selected_es_logo').addClass("d-none");
            //     $('#selected_en_logo').removeClass("d-none");
            //     $('#w_selected_es_logo').addClass("d-none");
            //     $('#w_selected_en_logo').removeClass("d-none");
            // } else {
            //     // spanish
            //     // alert($(".goog-te-combo").val());
            //     $('#selected_en_logo').addClass("d-none");
            //     $('#selected_es_logo').removeClass("d-none");
            //     $('#w_selected_en_logo').addClass("d-none");
            //     $('#w_selected_es_logo').removeClass("d-none");
            // }
            setCurrentLang($(".goog-te-combo").val());
        });
    </script>
    @yield('mainscript')

</body>

</html>
