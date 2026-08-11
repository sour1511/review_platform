@extends('frontend.layout')
@section('mainhead')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" rel="stylesheet" />
@endsection
<style>
    .iti {
        width: 100% !important;
    }
</style>
@section('maincontent')
    @parent

    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.Create_Review_Profile') }}</h1>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Hero Banner End ================================== -->
    <!-- ============================ Breadcrums Start================================== -->
    <div class="container-fluid breadcrumbs breadcrumbs-light">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-12">
                    <a href="{{ Route('home') }}">
                        {{ __('messages.home_home') }}
                    </a>
                    <a href="javascript:void(0)">
                        <span>
                            <i class="ti-arrow-right"></i>
                        </span>
                        {{ __('messages.Create_Review_Profile') }}
                    </a>
                    {{-- <button type="button" id="cat_create" data-toggle="modal" data-target="#createcat"
                        class="btn btn-primary btn-sm float-right">Create New
                        Category</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Breadcrums End ================================== -->

    <section class="tr-single-detail gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                </div>
                <div class="col-md-8 col-sm-12">
                    @if (Session::has('error'))
                        <?php $errors = Session::get('error'); ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!-- My Profile -->
                        <div class="tab-pane active container" id="profile">
                            <form action="{{ route('register_reviewprofile') }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <!-- Basic Info -->
                                <div class="tr-single-box">
                                    <div class="tr-single-header">
                                        <h4><i class="ti-desktop"></i>{{ __('messages.Review_Profile_Info') }}</h4>
                                    </div>

                                    <div class="tr-single-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                <span class="text-warning"
                                                    style="font-size: 12px;">{{ __('messages.Review_Profile_Info_decs') }}</span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('messages.Review_Profile_Name') }}</label>
                                                    <input class="form-control" type="text" minlength="2" maxlength="75"
                                                        autocomplete="off" id="profile_name" name="name"
                                                        value="{{ old('name') }}"
                                                        placeholder="{{ __('messages.Review_Profile_Name') }}"
                                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                        oninput="setCustomValidity('')" required>
                                                    <span class="text-danger error-text" id='profile_name_error'></span>
                                                </div>
                                            </div>

                                            {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Subject </label>
                                                    <input class="form-control" type="text" name="subject_name"
                                                        value="{{ old('subject_name') }}" placeholder="Enter Subject">

                                                </div>
                                            </div> --}}

                                            <div class="col-lg-12 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('messages.category') }}</label>

                                                    <select name="category_id"
                                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                        onchange="setCustomValidity('')" id="Category-dropdown"
                                                        class="js-states form-control" required>
                                                        <option value="">&nbsp;</option>
                                                        @if (Session::get('locale') == 'en')
                                                            @foreach ($Category as $catdata)
                                                                @if ($catdata->category_title != null)
                                                                    <option value="{{ $catdata->id }}">
                                                                        {{ $catdata->category_title }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach ($Category as $catdata)
                                                                @if ($catdata->es_category_title != null)
                                                                    <option value="{{ $catdata->id }}">
                                                                        {{ $catdata->es_category_title }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <option value="other">{{ __('messages.Add_New_Category') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('messages.subcategory') }}</label>
                                                    <select name="sub_category_id"
                                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                        onchange="setCustomValidity('')" id="subCategory-dropdown"
                                                        class="form-control" required>
                                                        <option value="">&nbsp;</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('messages.Profile_Picture') }}</label><br>
                                                    <span class="text-warning mb-3"
                                                        style="font-size: 12px;">{{ __('messages.Review_Profile_Picture_info') }}</span>
                                                    <div class="custom-file">
                                                        <input type="file" onchange="validateProfilePic(this)"
                                                            name="profile_pic" accept="image/*" class="custom-file-input"
                                                            id="ppic" required />
                                                        <label
                                                            class="custom-file-label">{{ __('messages.Choose_file') }}</label>
                                                    </div>
                                                </div>
                                                <span class="text-warning float-right"
                                                    style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                            </div>

                                            {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Cover Profile Picture</label>
                                                    <div class="custom-file">
                                                        <input type="file" onchange="validateCoverProfilePic(this)"
                                                            name="cover_pic" accept="image/*" class="custom-file-input"
                                                            id="cpp" required>
                                                        <label class="custom-file-label" for="ccover">Choose
                                                            file</label>
                                                    </div>

                                                </div>
                                                <span class="text-warning float-right" style="font-size: 12px;">*Only
                                                    2mb
                                                    cover picture image size allow. </span>
                                            </div> --}}

                                        </div>
                                    </div>

                                </div>
                                <!-- /Basic Info -->

                                <!-- Contact Info -->
                                <div class="tr-single-box">
                                    <div class="tr-single-header">
                                        <h4><i class="ti-headphone"></i>{{ __('messages.Contact_Info') }}</h4>
                                        <i class="fa fa-info-circle float-right"
                                            title="{{ __('messages.contact_info_desc') }}" aria-hidden="true"></i>
                                    </div>

                                    <div class="tr-single-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                <span class="text-warning"
                                                    style="font-size: 12px;">{{ __('messages.contact_info_desc') }}</span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="social-nfo">{{ __('messages.Mobile_Number') }}<span
                                                            class="text-warning" style="font-size: 12px;">
                                                            ({{ __('messages.Optional') }})</span></label>
                                                    <input id="phone" class="form-control form-control-rounded phone"
                                                        name="mobile_number"
                                                        onkeypress="javascript:return isNumber(event)" autocomplete="off"
                                                        type="tel">
                                                    {{-- <input class="form-control" placeholder="Enter Mobile Number"
                                                        name="mobile_number" id="mobileNum" type="text" value=""
                                                        required> --}}
                                                </div>
                                                <span id='errorMobile'></span>
                                                <span class="text-danger error-text contact_error"></span>
                                                <span id="valid-msg" class="d-none text-success"></span>
                                                <span id="error-msg" class="d-none text-danger"></span>
                                                <input type="hidden" name="country_code" value="+1"
                                                    id='country_code'>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="social-nfo">{{ __('messages.email') }}<span
                                                            class="text-warning" style="font-size: 12px;">
                                                            ({{ __('messages.Optional') }})</span></label>
                                                    <input class="form-control" name="user_email"
                                                        placeholder="{{ __('messages.email') }}" id="userEmail"
                                                        type="email" value="{{ old('user_email') }}">
                                                </div>
                                                <span class="text-danger error-text" id='tEmail'></span>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="country">{{ __('messages.Select_a_country') }}</label><br>
                                                    <span class="text-warning mb-1"
                                                        style="font-size: 12px;">{{ __('messages.Select_a_country_info') }}</span>
                                                    {{-- <select id="org_country" class="form-control form-control-rounded"
                                                        name="country" autocomplete="off" required></select> --}}

                                                    <select id="org_country"
                                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                        onchange="setCustomValidity('')"
                                                        class="form-control form-control-rounded" name="country"
                                                        autocomplete="off" required>
                                                        <option value="" disabled selected>
                                                            {{ __('messages.Select_a_country') }}</option>
                                                        @foreach ($country as $countyName)
                                                            <option value="{{ $countyName }}">
                                                                {{ $countyName }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="address_address">{{ __('messages.Address') }}</label><br>
                                                    <span class="text-warning mb-1 d-block"
                                                        style="font-size: 12px;">{{ __('messages.address_desc') }}</span>
                                                    <div class="places-autocomplete-wrap">
                                                        <input type="text" id="address-input"
                                                            placeholder="{{ __('messages.enter_location') }}"
                                                            onpaste="return false;"
                                                            oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                            oninput="setCustomValidity('')" name="address_address"
                                                            class="form-control map-input" required>
                                                    </div>
                                                    <input type="hidden" name="address_latitude" id="address-latitude"
                                                        value="0" />
                                                    <input type="hidden" name="address_longitude" id="address-longitude"
                                                        value="0" />
                                                </div>
                                                <span class="text-danger error-text mb-3" id='locationError'></span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div id="address-map-container" class="address-map-box">
                                                    <div id="address-map"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-3 mb-3">
                                        <button type="submit" id="submitProfile"
                                            class="btn btn-primary btn-md pop-login full-width">{{ __('messages.Submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-2 col-sm-12">
                </div>
            </div>
    </section>

    <!-- ============================ custom ads Start ================================== -->
    @php
        $is_show_ads = '';
        
        if (isset($data['custom_ads']) && $data['custom_ads']->count() > 0) {
            if (isset($data['ad_settings']) && $data['ad_settings']->count() > 0) {
                if ($data['ad_settings']->is_hide == 0) {
                    $is_show_ads = '';
                } else {
                    $is_show_ads = 'd-none';
                }
            }
        } else {
            $is_show_ads = 'd-none';
        }
        
    @endphp
    <section class="custom {{ $is_show_ads }}">
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.sponsored') }}</p>
                        {{-- <h2>See Latest Updates</h2> --}}
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="owl-carousel" id="custom_ads">
                        @if (isset($data['custom_ads']) && $data['custom_ads']->count() > 0)
                            @foreach ($data['custom_ads'] as $customAd)
                                @if (Session::get('locale') == 'en')
                                    @if ($customAd->banner_img != '' || $customAd->banner_img != null)
                                        <div class="item">
                                            {{-- <div class="col-lg-4 col-md-4"> --}}
                                            <div class="blog-grid-wrap mb-4">
                                                <div class="blog-grid-thumb">
                                                    <a href="#"><img style="height: 280px;"
                                                            src="{{ asset($customAd->banner_img) }}" class=""
                                                            alt=""></a>
                                                    {{-- <div class="bg-cat-info">
                                        <div class="post-m-info">
                                            <h5 class="pm-date">12</h5>
                                            <h5 class="pm-month">Dec</h5>
                                        </div>
                                    </div>
                                    <h6 class="post-cat">Travel &amp; Tour</h6> --}}
                                                </div>
                                                <div class="blog-grid-content">
                                                    <h4 class="cnt-gb-title"><a
                                                            href="#">{{ $customAd->heading }}</a>
                                                    </h4>
                                                    @if ($customAd->sub_heading != null)
                                                        <p>{{ $customAd->sub_heading }}</p>
                                                    @endif
                                                </div>
                                                {{-- <div class="blog-grid-meta">
                                    <div class="gb-info-author">
                                        <p><strong>By </strong>Javid Akhtar</p>
                                    </div>
                                    <div class="gb-info-cmt">
                                        <ul>
                                            <li><a href="#">110<i class="fa fa-comment text-info"></i></a>
                                            </li>
                                            <li><a href="#">50<i class="fa fa-heart text-info"></i></a></li>
                                        </ul>
                                    </div>
                                </div> --}}
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                    @endif
                                @else
                                    @if ($customAd->sp_banner_img != '' || $customAd->sp_banner_img != null)
                                        <div class="item">
                                            <div class="blog-grid-wrap mb-4">
                                                <div class="blog-grid-thumb">
                                                    <a href="#"><img style="height: 280px;"
                                                            src="{{ asset($customAd->sp_banner_img) }}" class=""
                                                            alt=""></a>
                                                </div>
                                                <div class="blog-grid-content">
                                                    <h4 class="cnt-gb-title"><a
                                                            href="#">{{ $customAd->sp_heading }}</a>
                                                    </h4>
                                                    @if ($customAd->sp_sub_heading != null)
                                                        <p>{{ $customAd->sp_sub_heading }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================ custom ads End ================================== -->

    <div class="modal fade" id="createcat" tabindex="-1" role="dialog" aria-labelledby="categorymodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content" id="categorymodal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ti-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="modal-header-title"
                        style="font-size: 25px;">{{ __('messages.Create_New_Category') }}</label>
                    {{-- <div class="col-12 mb-3">
                        <input type="radio" id="yes" name="categoryCreateLoad" value="1" checked>
                        <label for="yes">Create New Category and Subcategory</label>
                        <input type="radio" id="no" name="categoryCreateLoad" value="0">
                        <label for="no">Create New Subcategory</label><br>
                    </div> --}}

                    <div class="col-12" id="newCat">
                        <div class="login-form">
                            <form id="create_cat_form" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('messages.category_name') }}</label>
                                    <div class="">
                                        <input type="text" maxlength="50"   
                                            oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"    
                                            oninput="setCustomValidity('')"                                                                                
                                            onchange="checkCategory();" class="form-control catName"
                                            name="category_title" placeholder="{{ __('messages.category_name') }}"
                                            required>
                                    </div>
                                    <span id='category_error'></span>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.sub_category_name') }}</label>
                                    <div class="">
                                        <input type="text" class="form-control subName"
                                            oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                            onchange="checkSubCategory();"
                                            oninput="setCustomValidity('')" maxlength="50" name="sub_category_name"
                                            placeholder="{{ __('messages.sub_category_name') }}" required>

                                    </div>
                                    <span id='subcategory_error'></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="categorySubmit" class="btn btn-primary btn-md full-width pop-login">{{ __('messages.Submit') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createsub" tabindex="-1" role="dialog" aria-labelledby="subcategorymodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content" id="subcategorymodal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ti-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="modal-header-title"
                        style="font-size: 25px;">{{ __('messages.Create_New_Subcategory') }}</label>

                    <div class="col-12" id="newsub">
                        <div class="login-form">
                            <form id="create_subcat_form" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('messages.category_name') }}</label>
                                    <input type="text" class="form-control" id="selected_cat_title"
                                        name="catgory_title" value="" readonly>
                                    <input type="hidden" name="category_title_id" id="hidden_cat_id">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.sub_category_name') }}</label>
                                    <div class="">
                                        <input type="text"
                                            oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                            oninput="setCustomValidity('')" maxlength="50" class="form-control sub_cate"
                                            onchange="checkSubCategoryUp();"
                                            name="sub_category_name" placeholder="{{ __('messages.sub_category_name') }}"
                                            required>

                                    </div>
                                    <span id='subcategory_errors'></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="subCateSubmit" class="btn btn-primary btn-md full-width pop-login">{{ __('messages.Submit') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('mainscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>

        $(".sub_cate").keypress(function(e) {
            var keyCode = e.keyCode || e.which;
            $("#subcategory_errors").html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z\s]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#subcategory_errors").html("{{ __('messages.Only_Alphabets') }}").css('color', 'red');
            }
            return isValid;
        });

        function checkSubCategoryUp(){
            $("#subcategory_errors").html("");
            var SubCategoryValue = $('.sub_cate').val();
            if(SubCategoryValue.length <= 1){
                $("#subcategory_errors").html("{{ __('messages.subcategory_length') }}").css('color', 'red');
                $('#subCateSubmit').prop('disabled', true);
            }else{
                $("#subcategory_errors").html("");
                $('#subCateSubmit').prop('disabled', false);
            }
        }

        function checkSubCategory(){
            $("#subcategory_error").html("");
            var SubCategoryVal = $('.subName').val();
            if(SubCategoryVal.length <= 1){
                $("#subcategory_error").html("{{ __('messages.subcategory_length') }}").css('color', 'red');
                $('#categorySubmit').prop('disabled', true);
            }else{

                if($('.catName').val().length != 0){
                    if($('.catName').val().length <= 1){
                        $("#category_error").html("{{ __('messages.category_length') }}").css('color', 'red');
                        $('#categorySubmit').prop('disabled', true);
                    }else{
                        $("#category_error").html("");
                        $('#categorySubmit').prop('disabled', false);
                    }
                }else{
                    $("#subcategory_error").html("");
                    $('#categorySubmit').prop('disabled', false);
                }
            }
        }

        function checkCategory() {
            $("#category_error").html("");
            var CategoryVal = $('.catName').val();
            if(CategoryVal.length <= 1){
                $("#category_error").html("{{ __('messages.category_length') }}").css('color', 'red');
                $('#categorySubmit').prop('disabled', true);
            }else{
                if($('.subName').val().length != 0){
                    if($('.subName').val().length <= 1){
                        $("#subcategory_error").html("{{ __('messages.subcategory_length') }}").css('color', 'red');
                        $('#categorySubmit').prop('disabled', true);
                    }else{
                        $("#subcategory_error").html("");
                        $('#categorySubmit').prop('disabled', false);
                    }
                }else{
                    $("#category_error").html("");
                    $('#categorySubmit').prop('disabled', false);
                }                    
                
            }
            
        }

        $("#custom_ads").owlCarousel({
            loop: true,
            autoplay: true,
            center: true,
            items: 3,
            nav: true,
            dots: true,
            margin: 30,
            responsiveClass: true,
            autoplayHoverPause: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    // nav: false
                },
                600: {
                    items: 1,
                    // nav: false
                },
                1000: {
                    items: 1,
                    // nav: false,
                    loop: true
                }
            }
        });

        $(".catName").keypress(function(e) {
            var keyCode = e.keyCode || e.which;
            $("#category_error").html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z\s]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#category_error").html("{{ __('messages.Only_Alphabets') }}").css('color', 'red');
            }
            return isValid;
        });

        $(".subName").keypress(function(e) {
            var keyCode = e.keyCode || e.which;
            $("#subcategory_error").html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z\s]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#subcategory_error").html("{{ __('messages.Only_Alphabets') }}").css('color', 'red');
            }
            return isValid;
        });

        function validateProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#ppic').val('');
                $('#ppic').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#ppic').val('');
                $('#ppic').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        function validateCoverProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#cpp').val('');
                $('#cpp').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#cpp').val('');
                $('#cpp').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        function isNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('#Category-dropdown').select2({
            placeholder: "{{ __('messages.choose_a_category') }}",
            allowClear: true
        });

        $('#select_cat').select2({
            placeholder: "{{ __('messages.choose_a_category') }}",
            allowClear: true,
            dropdownParent: $("#createcat")
        });

        $('#subCategory-dropdown').select2({
            placeholder: "{{ __('messages.choose_a_subcategory') }}",
            allowClear: true
        });

        $(document).ready(function() {
            // populateCountries("org_country");
            // phone number validation
            var input = document.querySelector("#phone");
            errorMsg = document.querySelector("#error-msg");
            validMsg = document.querySelector("#valid-msg");
            // Error messages based on the code returned from getValidationError
            var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
            // Initialise plugin
            var intl = window.intlTelInput(input, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });
            window.intl = intl;
            $('.iti__flag-container').click(function() {
                var countryCode = $('.iti__selected-flag').attr('title');
                var countryCode = countryCode.replace(/[^0-9]/g, '');
                // alert('+'+countryCode);
                $('#country_code').val('+' + countryCode);
                // $('#phone').val("+"+countryCode+" "+ $('#phone').val());
            });
            var reset = function() {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                errorMsg.classList.add("d-none");
                validMsg.classList.add("d-none");
            };
            // Validate on blur event
            input.addEventListener('blur', function() {
                reset();
                if (input.value.trim()) {
                    if (intl.isValidNumber()) {
                        validMsg.classList.remove("d-none");
                        $('#submitProfile').prop('disabled', false);
                    } else {
                        input.classList.add("error");
                        var errorCode = intl.getValidationError();
                        errorMsg.innerHTML = errorMap[errorCode];
                        errorMsg.classList.remove("d-none");
                        $('#submitProfile').prop('disabled', true);
                    }
                }
            });
            // Reset on keyup/change event
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);
            // end number validation 

            // address validation
            // $('#address-input').on('change', function() {
            //     var addr = document.getElementById("address-input");
            //     // Get geocoder instance
            //     var geocoder = new google.maps.Geocoder();
            //     // Geocode the address
            //     geocoder.geocode({
            //         'address': addr.value
            //     }, function(results, status) {
            //         if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
            //             // addr.value = results[0].formatted_address;
            //         } else {
            //             alert("Invalid address");
            //             $('#address-input').val("");
            //         }
            //     });
            // });

            $('#userEmail').on('change', function() {
                var validEmail = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($("#userEmail").val());
                if (!validEmail) {
                    $("#tEmail").html("{{ __('messages.valid_email') }}");
                    $("#userEmail").focus();
                    $('#submitProfile').prop('disabled', true);
                    return false;
                } else {
                    $("#tEmail").html("");
                    $('#submitProfile').prop('disabled', false);
                }
            });

            $('#Category-dropdown').on('change', function() {
                var idCountry = this.value;

                if (idCountry != "other") {
                    $("#subCategory-dropdown").html('');
                    $.ajax({
                        url: "{{ url('api/fetchSubCategory') }}",
                        type: "POST",
                        data: {
                            categories_id: idCountry,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#subCategory-dropdown').html(
                                '<option value="">&nbsp;</option>');
                            $.each(result.subCategory, function(key, value) {
                                if ("{{ Session::get('locale') }}" == "en") {
                                    if (value.sub_category_title != null){
                                        $("#subCategory-dropdown").append(
                                            '<option value="' +
                                            value.id + '">' + value.sub_category_title +
                                            '</option>');
                                    }    

                                } else {
                                    if (value.es_sub_category_title != null){
                                        $("#subCategory-dropdown").append(
                                            '<option value="' +
                                            value.id + '">' + value
                                            .es_sub_category_title +
                                            '</option>');
                                    }   
                                }
                            });

                            $("#subCategory-dropdown").append(
                                '<option value="other">' +
                                "{{ __('messages.Add_New_Subcategory') }}" + ' </option>');
                        }
                    });
                } else {
                    // alert(idCountry);
                    $('#createcat').modal('show');
                }

            });


            $('#subCategory-dropdown').on('change', function() {
                var idState = this.value;
                if (idState == 'other') {
                    $('#hidden_cat_id').val($('#Category-dropdown option:selected').val());
                    $('#selected_cat_title').val($('#Category-dropdown option:selected').text().trim());
                    $('#createsub').modal('show');
                    // alert(idState);   
                }
            });

            $("input:radio[name=categoryCreateLoad]").on("change", function() {
                if ($(this).val() == 1) {
                    // Create New Category and Subcategory
                } else {
                    // Create New Subcategory
                }
            });

            // for create new category and new subcategory
            $('#create_cat_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ Route('newcategory') }}",
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {

                    },
                    success: function(data) {
                        if (data.status == 0) {

                            $('#category_error').html(data.msg).css(
                                'color',
                                'red');
                        } else if (data.status == 2) {
                            $('#subcategory_error').html(data.msg).css(
                                'color',
                                'red');
                        } else {
                            $('#category_error').html('');
                            $('#subcategory_error').html('');
                            $('#create_cat_form').get(0).reset();
                            $('#createcat').modal('hide');
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

            // only new subcategory
            $('#create_subcat_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ Route('newsubcategory') }}",
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {

                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $('#subcategory_errors').html(data.msg).css(
                                'color',
                                'red');
                        } else {
                            $('#subcategory_errors').html('');
                            $('#create_subcat_form').get(0).reset();
                            $('#createsub').modal('hide');
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

        });

        $('#createcat').on('hidden.bs.modal', function() {
            location.reload();
        });

        $('#createsub').on('hidden.bs.modal', function() {
            location.reload();
        });
    </script>
@endsection
