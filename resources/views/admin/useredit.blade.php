@extends('layout')
@section('content')
    @parent
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('messages.User_details') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.User_details') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow mt-3">
                    <div class="car-header bg-primary p-3">
                        <div class="card-title font-weight-bold text-white text-center">{{ __('messages.update_user') }}
                        </div>
                    </div>
                    {{-- <div class="col-md-7"> --}}
                    <div class="m-3">
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
                    </div>

                    <form method="post" enctype="multipart/form-data" action="{{ Route('userupdate') }}">
                        <div class="card-body">

                            <input type="hidden" id="id" name="id" class="form-control"
                                value="{{ $data['userdetails']->id }}" />

                            <div class="row mb-2">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="udoc">{{ __('messages.user_profile_pic') }}</label><br>
                                        <input type="file" name="udoc" accept="image/*" onchange="validateDoc(this)"
                                            id="doc_up"><br>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="avatar_pic">{{ __('messages.user_avatar_pic') }}
                                            </label><br>
                                            <input type="file" name="avatar_pic" accept="image/*"
                                                onchange="validateDoc(this)" id="avatar_pic"><br>
                                            <span class="text-warning float-right"
                                                style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_name">{{ __('messages.User_First_Name') }}</label>
                                        <input type="text" name="name" id="user_name" class="form-control"
                                            placeholder="{{ __('messages.User_First_Name') }}"
                                            value="{{ $data['userdetails']->name }}" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_lname">{{ __('messages.User_Last_Name') }}</label>
                                        <input type="text" name="lname" id="user_lname" class="form-control"
                                            placeholder="{{ __('messages.User_Last_Name') }}"
                                            value="{{ $data['userdetails']->lname }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_lname">{{ __('messages.nickname_u') }}</label>
                                        <input type="text" name="nickname" id="nickname" maxlength="20"
                                            class="form-control" placeholder="{{ __('messages.nickname_u') }}"
                                            value="{{ $data['userdetails']->nickname }}" required />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ __('messages.dob') }}</label>
                                        <div class="input-group date" id="dob" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#dob" name="dob" value="{{ $data['userdetails']->dob }}"
                                                required />
                                            <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>

                                        </div>
                                        {{-- <label for="user_lname">Date of birth </label>
                                            <input type="text" name="dob" id="dob" class="form-control" placeholder="date of birth" value="{{ $data['userdetails']->dob }}" required /> --}}
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender_dropdown">{{ __('messages.gender') }}</label>
                                        <select name="genderselection" id="ugender_dropdown" class="form-control"
                                            required>
                                            <option value="" disabled selected>
                                                {{ __('messages.Select_your_option') }}</option>
                                            <option value="Male"
                                                {{ 'Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="Female"
                                                {{ 'Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                Female</option>
                                            @php
                                                $seleGender = '';
                                                $customeClass = 'd-none';
                                                if ($data['userdetails']->gender == 'Female' || $data['userdetails']->gender == 'Male') {
                                                    $seleGender = '';
                                                    $customeClass = 'd-none';
                                                } else {
                                                    $seleGender = 'selected';
                                                    $customeClass = '';
                                                }
                                            @endphp
                                            <option value="Custom" {{ $seleGender }}>Custom</option>
                                        </select>
                                        <input type="hidden" id="ugender" name="gender"
                                            value="{{ $data['userdetails']->gender }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 {{ $customeClass }}" id="ucustomGenderView">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="custom_dropdown">{{ __('messages.Custom_Gender') }}</label>
                                            <select name="gendercustom" id="ucustom_dropdown" class="form-control">
                                                <option value="" disabled selected>
                                                    {{ __('messages.Select_your_option') }}</option>
                                                <option value="Agender"
                                                    {{ 'Agender' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Agender</option>
                                                <option value="Androgyne"
                                                    {{ 'Androgyne' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Androgyne</option>
                                                <option value="Androgynous"
                                                    {{ 'Androgynous' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Androgynous</option>
                                                <option value="Bigender"
                                                    {{ 'Bigender' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Bigender</option>
                                                <option value="Cis"
                                                    {{ 'Cis' == $data['userdetails']->gender ? 'selected' : '' }}>Cis
                                                </option>
                                                <option value="Cisgender"
                                                    {{ 'Cisgender' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cisgender</option>
                                                <option value="Cis Female"
                                                    {{ 'Cis Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cis Female</option>
                                                <option value="Cis Male"
                                                    {{ 'Cis Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cis Male</option>
                                                <option value="Cis Man"
                                                    {{ 'Cis Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cis Man</option>
                                                <option value="Cis Woman"
                                                    {{ 'Cis Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cis Woman</option>
                                                <option value="Cisgender Female"
                                                    {{ 'Cisgender Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cisgender Female</option>
                                                <option value="Cisgender Male"
                                                    {{ 'Cisgender Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cisgender Male</option>
                                                <option value="Cisgender Man"
                                                    {{ 'Cisgender Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cisgender Man</option>
                                                <option value="Cisgender Woman"
                                                    {{ 'Cisgender Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Cisgender Woman</option>
                                                <option value="Female to Male"
                                                    {{ 'Female to Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Female to Male</option>
                                                <option value="FTM"
                                                    {{ 'FTM' == $data['userdetails']->gender ? 'selected' : '' }}>FTM
                                                </option>
                                                <option value="Gender Fluid"
                                                    {{ 'Gender Fluid' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Gender Fluid</option>
                                                <option value="Gender Nonconforming"
                                                    {{ 'Gender Nonconforming' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Gender Nonconforming</option>
                                                <option value="Gender Questioning"
                                                    {{ 'Gender Questioning' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Gender Questioning</option>
                                                <option value="Gender Variant"
                                                    {{ 'Gender Variant' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Gender Variant</option>
                                                <option value="Genderqueer"
                                                    {{ 'Genderqueer' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Genderqueer</option>
                                                <option value="Intersex"
                                                    {{ 'Intersex' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Intersex</option>
                                                <option value="Male to Female"
                                                    {{ 'Male to Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Male to Female</option>
                                                <option value="MTF"
                                                    {{ 'MTF' == $data['userdetails']->gender ? 'selected' : '' }}>MTF
                                                </option>
                                                <option value="Neither"
                                                    {{ 'Neither' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Neither</option>
                                                <option value="Neutrois"
                                                    {{ 'Neutrois' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Neutrois</option>
                                                <option value="Non-binary"
                                                    {{ 'Non-binary' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Non-binary</option>
                                                <option value="Pangender"
                                                    {{ 'Pangender' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Pangender</option>
                                                <option value="Trans"
                                                    {{ 'Trans' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans</option>
                                                <option value="Trans*"
                                                    {{ 'Trans*' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans*</option>
                                                <option value="Trans Female"
                                                    {{ 'Trans Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans Female</option>
                                                <option value="Trans* Female"
                                                    {{ 'Trans* Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans* Female</option>
                                                <option value="Trans Male"
                                                    {{ 'Trans Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans Male</option>
                                                <option value="Trans* Male"
                                                    {{ 'Trans* Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans* Male</option>
                                                <option value="Trans Man"
                                                    {{ 'Trans Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans Man</option>
                                                <option value="Trans* Man"
                                                    {{ 'Trans* Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans* Man</option>
                                                <option value="Trans Person"
                                                    {{ 'Trans Person' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans Person</option>
                                                <option value="Trans* Person"
                                                    {{ 'Trans* Person' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans* Person</option>
                                                <option value="Trans Woman"
                                                    {{ 'Trans Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans Woman</option>
                                                <option value="Trans* Woman"
                                                    {{ 'Trans* Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Trans* Woman</option>
                                                <option value="Transfeminine"
                                                    {{ 'Transfeminine' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transfeminine</option>
                                                <option value="Transgender"
                                                    {{ 'Transgender' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender</option>
                                                <option value="Transgender Female"
                                                    {{ 'Transgender Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender Female</option>
                                                <option value="Transgender Male"
                                                    {{ 'Transgender Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender Male</option>
                                                <option value="Transgender Man"
                                                    {{ 'Transgender Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender Man</option>
                                                <option value="Transgender Person"
                                                    {{ 'Transgender Person' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender Person</option>
                                                <option value="Transgender Woman"
                                                    {{ 'Transgender Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transgender Woman</option>
                                                <option value="Transmasculine"
                                                    {{ 'Transmasculine' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transmasculine</option>
                                                <option value="Transsexual"
                                                    {{ 'Transsexual' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual</option>
                                                <option value="Transsexual Female"
                                                    {{ 'Transsexual Female' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual Female</option>
                                                <option value="Transsexual Male"
                                                    {{ 'Transsexual Male' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual Male</option>
                                                <option value="Transsexual Man"
                                                    {{ 'Transsexual Man' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual Man</option>
                                                <option value="Transsexual Person"
                                                    {{ 'Transsexual Person' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual Person</option>
                                                <option value="Transsexual Woman"
                                                    {{ 'Transsexual Woman' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Transsexual Woman</option>
                                                <option value="Two-Spirit"
                                                    {{ 'Two-Spirit' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Two-Spirit</option>
                                                <option value="Other"
                                                    {{ 'Other' == $data['userdetails']->gender ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                        </div>
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
                            <div class="form-group">
                                <label for="firstName2">{{ __('messages.Select_a_country') }}</label>
                                <select id="ucountry" class="form-control form-control-rounded" name="country_name"
                                    autocomplete="off" required>
                                    <option value="" disabled>{{ __('messages.Select_a_country') }}</option>

                                    @foreach ($country as $countyName)
                                        @php
                                            $selectedCountry = '';
                                            if ($data['userdetails']->country_name == $countyName) {
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

                            <div class="form-group">
                                <label for="email">{{ __('messages.email') }}</label>
                                <input type="{{ __('messages.email') }}" name="email" id="email"
                                    class="form-control" placeholder="Email" value="{{ $data['userdetails']->email }}"
                                    required />
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('messages.Password') }}</label>
                                <input type="password" onselectstart="return false" onpaste="return false;"
                                    onCopy="return false" onCut="return false" onDrag="return false"
                                    onDrop="return false"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                    title="{{ __('messages.password_valid') }}" name="password" id="password"
                                    class="form-control" placeholder="{{ __('messages.Password') }}" value="" />
                            </div>

                            <div class="form-group">
                                <label for="cpassword">{{ __('messages.Confirmed_Password') }}</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control"
                                    placeholder="{{ __('messages.Confirmed_Password') }}" value="" />
                                <span id='message'></span>
                            </div>

                        </div>

                        <div class="card-footer d-inline-block float-right mb-3">
                            <button type="submit" id="submit" class="btn btn-success float-right">
                                {{ __('messages.update') }}</button>
                        </div>
                        {{-- important to add csrf token --}}
                        @csrf

                    </form>
                    {{-- </div> --}}
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    @parent
    <script>
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

        function validateDoc(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#doc_up').val('');
                $('#doc_up').text('Choose file');
                $('#avatar_pic').val('');
                $('#avatar_pic').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#doc_up').val('');
                $('#doc_up').text('Choose file');
                $('#avatar_pic').val('');
                $('#avatar_pic').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }
        $('#password').on('keyup change', function() {
            if ($('#cpassword').val() == "") {
                $('#message').html("{{ __('messages.enter_confirm_password') }}").css('color', 'red');
                $(':input[type="submit"]').prop('disabled', true);
            } else {
                $('#message').html('');
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
        $('#cpassword').on('keyup change', function() {
            if ($('#password').val() == $('#cpassword').val()) {
                // $('#message').html('Matching').css('color', 'green');
                $('#message').html('');
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $('#message').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                $(':input[type="submit"]').prop('disabled', true);
            }
        });
        var ctodayDate = moment();
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD',
            endDate: new Date(),
        });
    </script>
@endsection
