@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ======================= Start Banner ===================== -->
    {{-- style="background-image:url(https://via.placeholder.com/1280x820);" --}}
    @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
        @if ($data['profilesData']->cover_pic != null)
            {{-- <section class="small-page-title-banner" style="background-image:url({{ url($data['profilesData']->cover_pic) }})"> --}}
            <section class="small-page-title-banner"
                style="background-image:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }});">
            @else
                <section class="small-page-title-banner"
                    style="background-image:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }});">
        @endif
    @endif
    <div class="container">
        <div class="row">
            @php
                $proName = '';
                if ($data['profilesData']->profile_name == null) {
                    $proName = $data['profilesData']->name;
                } else {
                    $proName = $data['profilesData']->profile_name;
                }
            @endphp

            <div class="tr-list-center">
                <h2>{{ __('messages.Commendations_and_Complaints_about') }} {{ $proName }}</h2>
            </div>
        </div>
    </div>
    </section>

    <!-- ======================= End Banner ===================== -->
    <style>
        .aggregate li i {
            float: right !important;
        }

        .ui-widget-header {
            border: 1px solid #329a8f !important;
            background: #329a8f !important;
        }

        .ui-datepicker {
            z-index: 99 !important;
        }

        .swal-overlay {
            z-index: 100000000000 !important;
        }
    </style>
    <!-- ============== Job Detail ====================== -->
    @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
        <section class="overlay-top p-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <input type="hidden" id="pro_id" value="{{ $data['profilesData']->id }}">
                        <!-- Default Style -->
                        <div class="single-job-head head-light style-1 mb-0">
                            <div class="single-job-left">
                                <div class="single-job-thumb">
                                    @if ($data['profilesData']->profile_pic != null)
                                        <img src="{{ asset($data['profilesData']->profile_pic) }}" alt="profile image" />
                                    @else
                                        <img src="{{ asset('frontend/assets/img/avatar.jpg') }}" alt="profile image" />
                                    @endif
                                </div>
                                <div class="single-job-info">
                                    {{-- <span class="job-type full-time"></span> --}}
                                    @if ($data['profilesData']->profile_name == null)
                                        <h4 class="single-job-title">{{ $data['profilesData']->name }}</h4>
                                    @else
                                        <h4 class="single-job-title">{{ $data['profilesData']->profile_name }}</h4>
                                    @endif
                                    @if (Session::get('locale') == 'en')
                                        <span><b>{{ __('messages.category') }}:</b>
                                            {{ $data['profilesData']->category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $data['profilesData']->sub_category_title }}</span><br>
                                        <input type="hidden" class="categoryTitle" value="{{ $data['profilesData']->category_title }}">    
                                        <input type="hidden" class="subcategoryTitle" value="{{ $data['profilesData']->sub_category_title }}">    
                                    @else
                                        <span><b>{{ __('messages.category') }}:</b>
                                            {{ $data['profilesData']->es_category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $data['profilesData']->es_sub_category_title }}</span><br>
                                        <input type="hidden" class="categoryTitle" value="{{ $data['profilesData']->es_category_title }}">    
                                        <input type="hidden" class="subcategoryTitle" value="{{ $data['profilesData']->es_sub_category_title }}">   
                                    @endif
                                    <span class="sj-location"><i
                                            class="ti-location-pin"></i>{{ $data['profilesData']->location }}</span>

                                    <ul class="tags-jobs">
                                        {{-- <li><i class="ti-file"></i> Applications 1</li> --}}
                                        @php
                                            $added_date = date('Y-m-d', strtotime($data['profilesData']->created_at));
                                        @endphp
                                        <li><i class="ti-calendar"></i>{{ __('messages.date_created') }}:
                                            {{ $added_date }}
                                        </li>
                                        <li><i class="fa fa-comment"></i>
                                            @if (isset($data['reviewData']) && $data['reviewData']->count() > 0)
                                                {{ $data['reviewData']->count() }}
                                            @else
                                                0
                                            @endif
                                        </li>
                                        @php
                                            // get current profile all reviews
                                            $totalReview = \App\Models\Review::where('reviews.profile_id', $data['profilesData']->id)
                                                ->where('reviews.is_delete', 0)
                                                ->get();
                                            $reviewCount = $totalReview->count();
                                            $finalStar = 0;
                                            if ($reviewCount > 0) {
                                                $totalStar = 0;
                                                foreach ($totalReview as $tReview) {
                                                    $totalStar = $totalStar + (int) $tReview->star_ratings;
                                                }
                                                $finalStar = round($totalStar / $reviewCount);
                                            }
                                            
                                        @endphp
                                        <li class="aggregate">{{ __('messages.Overall_Rating') }}: {{ $finalStar }}
                                            @if ($finalStar == '-1')
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                            @endif
                                            @if ($finalStar == '-2')
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                            @endif
                                            @if ($finalStar == '-3')
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                            @endif
                                            @if ($finalStar == '-4')
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                            @endif
                                            @if ($finalStar == '-5')
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                                <i class="fa fa-thumbs-down fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #cc0000"></i>
                                            @endif

                                            @if ($finalStar == '1')
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                            @endif
                                            @if ($finalStar == '2')
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                            @endif
                                            @if ($finalStar == '3')
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                            @endif
                                            @if ($finalStar == '4')
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                            @endif
                                            @if ($finalStar == '5')
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                                <i class="fa fa-thumbs-up fa-lg float-right m-1" aria-hidden="true"
                                                    style="color: #F6BE00"></i>
                                            @endif
                                            {{-- @if ($finalStar == '0')
                                                <i class="fa fa-star float-right" aria-hidden="true"></i>
                                                <i class="fa fa-star float-right" aria-hidden="true"></i>
                                                <i class="fa fa-star float-right" aria-hidden="true"></i>
                                                <i class="fa fa-star float-right" aria-hidden="true"></i>
                                                <i class="fa fa-star float-right" aria-hidden="true"></i>
                                            @endif --}}
                                        </li>
                                        @php
                                            
                                            $totalVCount = 0;
                                            $avgVerified = 0;
                                            $totalUnVCount = 0;
                                            $avgUnVerified = 0;
                                            if ($reviewCount > 0) {
                                                if (isset($data['verified']) && $data['verified']->count() > 0) {
                                                    $totalVCount = $data['verified']->count();
                                                    $avgVerified = round($totalVCount / $reviewCount, 1);
                                                }
                                            } else {
                                                $totalVCount = $data['verified']->count();
                                                $avgVerified = 0;
                                            }
                                            if ($reviewCount > 0) {
                                                $totalUnVCount = $data['unverified']->count();
                                                $avgUnVerified = round($totalUnVCount / $reviewCount, 1);
                                            } else {
                                                $totalUnVCount = $data['unverified']->count();
                                                $avgUnVerified = 0;
                                            }
                                        @endphp
                                        <li>
                                            {{ __('messages.Verified_Reviews') }}: {{ $totalVCount }} /
                                            {{ $avgVerified }}
                                        </li>
                                        <li>
                                            {{ __('messages.Unverified_Reviews') }}: {{ $totalUnVCount }} /
                                            {{ $avgUnVerified }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="single-job-apply-wrap">
                                <a href="#" class="btn apply-btn btn-primary"><i class="ti-check-box"></i>Apply job</a>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ============== Job Detail End ====================== -->
    <div class="clearfix"></div>
    <!-- ============================ Search Form Start================================== -->
    <div class="container mt-3 mb-3">
        <h5>{{ __('messages.Search_Reviews_by') }}</h5>
    </div>
    <div class="container mt-3 mb-3">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <select id="order_by" name="orderBy" onchange="loadReviews()" class="js-states form-control">
                        <option value="">&nbsp;</option>
                        <option value="all">{{ __('messages.Show_All') }}</option>
                        <option value="desc">{{ __('messages.From_most') }}</option>
                        <option value="asc">{{ __('messages.From_oldest') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <select id="review_type" name="review_type" onchange="loadReviews()" class="js-states form-control">
                        <option value="">&nbsp;</option>
                        <option value="all">{{ __('messages.Show_All') }}</option>
                        <option value="1">{{ __('messages.Show_Verified_Review') }}</option>
                        <option value="0">{{ __('messages.Show_Unverified_Review') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <select id="by_star" name="by_star" onchange="loadReviews()" class="js-states form-control">
                        <option value="">&nbsp;</option>
                        <option value="all">{{ __('messages.Show_All') }}</option>
                        <option value="1">{{ __('messages.1_Thumb') }}</option>
                        <option value="2">{{ __('messages.2_Thumbs') }}</option>
                        <option value="3">{{ __('messages.3_Thumbs') }}</option>
                        <option value="4">{{ __('messages.4_Thumbs') }}</option>
                        <option value="5">{{ __('messages.5_Thumbs') }}</option>
                        <option value="-1">{{ __('messages.1_Thumb_d') }}</option>
                        <option value="-2">{{ __('messages.2_Thumbs_d') }}</option>
                        <option value="-3">{{ __('messages.3_Thumbs_d') }}</option>
                        <option value="-4">{{ __('messages.4_Thumbs_d') }}</option>
                        <option value="-5">{{ __('messages.5_Thumbs_d') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="from_Date">{{ __('messages.Review_Type') }}</label>
                    <select id="review_by" name="review_by" onchange="loadReviews()" class="js-states form-control">
                        <option value="">&nbsp;</option>
                        <option value="all">{{ __('messages.Show_All') }}</option>
                        <option value="Commendation">{{ __('messages.Commendation') }}</option>
                        <option value="Complaint">{{ __('messages.Complaint') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="from_Date">{{ __('messages.Select_Start_Date') }}</label>
                    <input class="form-control" placeholder="{{ __('messages.from') }}" type="text"
                        onkeydown="return false" id="from_Date" name="from_Date">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="to_Date">{{ __('messages.Select_End_Date') }}</label>
                    <input class="form-control" type="text" placeholder="{{ __('messages.to') }}"
                        onkeydown="return false" id="to_Date" name="to_Date">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <button type="button" title="Clear Search"
                    class="btn btn-sm btn-warning clearFilter float-right">{{ __('messages.clear') }}</button>
            </div>

        </div>
    </div>

    <!-- ============================ Search Form End ================================== -->
    @if (empty(Session::get('login_username')))
        <section class="p-0">
            <div class="container text-center">
                <h5 class="mb-3">{{ __('messages.leave_your_own') }}</h5>
                <button class="btn btn-md btn-outline-info btn-rounded mb-3" data-toggle="modal"
                    data-target="#login">{{ __('messages.Add_Your_Review') }}</button>
            </div>
        </section>
    @endif
    <div class="container mt-3 mb-3">
        <h4>{{ __('messages.Reviews_Left_By') }}</h4>
    </div>

    {{-- main reviews --}}
    <div id="allreviews">
        @include('frontend.reviewsdetails')
    </div>
    {{-- main reviews end --}}

    {{-- review form --}}
    @if (!empty(Session::get('login_username')))
        {{-- Review form --}}
        <div class="container mt-3">
            @include('frontend.reviewform')
        </div>
        {{-- Review form end --}}
    @endif

    {{-- review form end --}}
    {{-- @if (empty(Session::get('login_username')))
        <section>
            <div class="container text-center">
                <button class="btn btn-md btn-outline-info btn-rounded mb-3" data-toggle="modal"
                    data-target="#login">View More</button>
            </div>
        </section>
    @endif --}}

    <!-- Edit review Modal -->
    <div class="modal fade" id="reviewEditModal" tabindex="-1" role="dialog" aria-labelledby="sign-up"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content" id="sign-up">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ti-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">{{ __('messages.Update_My_Review') }}</h4>
                    <div class="login-form">
                        <form id="update_review_form" enctype="multipart/form-data">
                            @csrf
                            <div class="tr-single-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="type">{{ __('messages.Review_Type') }}</label>
                                            <select name="type" id="utype" class="js-states form-control"
                                                required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Upload_Proof_Documents') }}</label>
                                            <div class="custom-file">
                                                <input type="file" name="udoc" onchange="validateDocs(this)"
                                                    class="custom-file-input" id="udocs">
                                                <label class="custom-file-label"
                                                    for="udocs">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="from_date">{{ __('messages.Select_from_date') }}</label>
                                            <input class="date form-control"
                                                oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                onchange="setCustomValidity('')" id="ufrom_date" name="from_date"
                                                onkeydown="return false" placeholder="{{ __('messages.from') }}"
                                                type="text" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="to_date">{{ __('messages.Select_to_date') }}</label>
                                            <input class="todate form-control"
                                                oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                onchange="setCustomValidity('')" id="uto_date" name="to_date"
                                                onkeydown="return false" placeholder="{{ __('messages.to') }}"
                                                type="text">
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nickname">Nickname</label>
                                            <input class="form-control" name="nickname" id="unickname"
                                                placeholder="Please add nickname" type="text">
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="ulocation-input">{{ __('messages.location') }}</label>
                                            <input class="form-control map-input" id="ulocation-input"
                                                oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                oninput="setCustomValidity('')" name="location"
                                                placeholder="{{ __('messages.location') }}" type="text"
                                                autocomplete="off" required>
                                            <input type="hidden" name="address_latitude" id="ulocation-latitude"
                                                value="0" />
                                            <input type="hidden" name="address_longitude" id="ulocation-longitude"
                                                value="0" />
                                            <div class="d-none" id="ulocation-map-container"
                                                style="width:100%;height:1px;">
                                                <div style="width:100%;height:100%;" id="ulocation-map"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.Upload_updated_profile_image') }}<span
                                                    class="text-warning" style="font-size: 12px;">
                                                    ({{ __('messages.Optional') }})</span></label>
                                            <div class="custom-file">
                                                <input type="file" name="updated_img" accept="image/*"
                                                    class="custom-file-input" onchange="validateProfilePics(this)"
                                                    id="uupdated_img">
                                                <label class="custom-file-label"
                                                    for="uupdated_img">{{ __('messages.Choose_file') }}</label>
                                            </div>
                                        </div>
                                        <span class="text-warning float-right"
                                            style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                                    </div>

                                    {{-- show star rating --}}
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="ucon">
                                                <label
                                                    for="vist_date">{{ __('messages.Add_Positive_or_Negative_Ratings') }}</label><br>
                                                <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.5_Thumbs_d') }}" id="ustm5"></i>
                                                <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.4_Thumbs_d') }}" id="ustm4"></i>
                                                <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.3_Thumbs_d') }}" id="ustm3"></i>
                                                <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.2_Thumbs_d') }}" id="ustm2"></i>
                                                <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.1_Thumb_d') }}" id="ustm1"></i>

                                                <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.1_Thumb') }}" id="ust1"></i>
                                                <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.2_Thumbs') }}" id="ust2"></i>
                                                <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.3_Thumbs') }}" id="ust3"></i>
                                                <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.4_Thumbs') }}" id="ust4"></i>
                                                <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                                    title="{{ __('messages.5_Thumbs') }}" id="ust5"></i>
                                            </div>
                                        </div>
                                        {{-- <label class="text-warining ">Note </label> --}}
                                        <span class="text-danger error-text urating_error"></span>
                                    </div>

                                    <input type="hidden" name="rating_star" id="utotal_star" value="0">

                                    <input type="hidden" name="category_id"
                                        value="{{ $data['profilesData']->category_id }}">

                                    <input type="hidden" name="sub_category_id"
                                        value="{{ $data['profilesData']->sub_category_id }}">

                                    <input type="hidden" name="profile_id" value="{{ $data['profilesData']->id }}">

                                    <input type="hidden" name="review_id" id="rev_id">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <span class="text-warning"
                                                style="font-size: 12px;">{{ __('messages.Add_Positive_desc') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('messages.Update_My_Review') }}</label><br>
                                            <div id="usummernotes">
                                                <textarea class="full-width" oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                                    oninput="setCustomValidity('')" pattern="^(?:\b\w+\b[\s\r\n]*){1,200}$" name="review" id="ureview" required
                                                    style="height: 100px"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="agree" id="uagree" value="1">
                                            <label for="remember">I accept terms and condition</label>

                                        </div>
                                    </div> --}}

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="">{{ __('messages.shown_as_verified') }}</label><br>
                                        <input type="radio" id="uyes" name="agree" value="1">
                                        <label for="uyes" class="mr-1">{{ __('messages.yes') }}</label>
                                        <input type="radio" id="uno" name="agree" value="0">
                                        <label for="uno">{{ __('messages.no') }}</label><br>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 d-none urealname">
                                        <label for="">{{ __('messages.real_name_Yes_No') }}</label><br>
                                        <input type="radio" id="ureal_yes" name="real" value="1">
                                        <label for="ureal_yes" class="mr-1">{{ __('messages.yes') }}</label>
                                        <input type="radio" id="ureal_no" name="real" value="0">
                                        <label for="ureal_no">{{ __('messages.no') }}</label><br>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" id="reviewUpdates"
                                                class="btn btn-info btn-md ml-3 float-right">{{ __('messages.Update_My_Review') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
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
@endsection
@section('mainscript')
    @parent
    <script>
        $(document).ready(function() {
            // console.log($('.categoryTitle').val());
            // console.log($('.subcategoryTitle').val());
            // console.log("{{ Session::get('locale') }}");
            var languageVal = "";
            if("{{ Session::get('locale') }}" == 'en'){                
                languageVal = "English";
            }else{               
                languageVal = "Spanish";
            }

            if($('.categoryTitle').val() == "" || $('.subcategoryTitle').val() == ""){
                // alert('empty');
                swal({
                    title: "{{ __('messages.created_language') }} "+ languageVal,
                    type: "warning",
                    text: "",
                    icon: "warning",
                    // showConfirmButton: true
                }).then(function() {
                    // redirect to browse profiles
                    window.location.href = "{{ route('browse_profiles')}}";
                });

            }

        });

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

        function validateDocs(file) {
            var re = /(\.pdf|\.docx|\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_doc') }}");
                $('#udocs').val('');
                $('#udocs').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#udocs').val('');
                $('#udocs').text('Choose file');


                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        function validateProfilePics(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#uupdated_img').val('');
                $('#uupdated_img').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#uupdated_img').val('');
                $('#uupdated_img').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        $(".clearFilter").click(function(ev) {
            $('#order_by').val('').trigger('change');
            $('#review_type').val('').trigger('change');
            $('#review_by').val('').trigger('change');
            $('#by_star').val('').trigger('change');
            $('#from_Date').val('');
            $('#to_Date').val('');
        });

        $('#uyes').on("click", function() {
            // $("#udocs").prop('required', true);
            $("#udocs").attr('required', 'required');
            $(".urealname").addClass('d-none');

            swal({
                title: "{{ __('messages.Terms_and_Conditions') }}",
                text: "{{ __('messages.yes_no') }}",
                icon: "warning",
                showConfirmButton: true
            });
        });

        $('#uno').on("click", function() {
            // $("#udocs").prop('required', false);
            $('#udocs').attr('required', false);
            $(".urealname").removeClass('d-none');
        });

        $("#ureview").change(function() {
            var element = this;
            var maxvalue = 200;
            var q = element.value.split(/[\s]+/).length;
            if (q > maxvalue) {
                var r = q - maxvalue;
                $('#reviewUpdates').prop('disabled', true);
                alert("Sorry, you have input " + q + " words into the " +
                    "Review area box you just completed. It can return no more than " +
                    maxvalue + " words to be processed. Please abbreviate " +
                    "your text by at least " + r + " words");

                return false;
            }
            $('#reviewUpdates').prop('disabled', false);
        });

        $('#order_by').select2({
            placeholder: "{{ __('messages.Search_by_order') }}",
            allowClear: true
        });
        $('#review_type').select2({
            placeholder: "{{ __('messages.Search_by_Verified_Unverified') }}",
            allowClear: true
        });
        $('#review_by').select2({
            placeholder: "{{ __('messages.Select_Review_Type_place') }}",
            allowClear: true
        });
        $('#by_star').select2({
            placeholder: "{{ __('messages.Search_by_Ratings') }}",
            allowClear: true
        });
    </script>
    {{-- update review --}}
    <script>
        var todayDateOne = moment();
        // $('document').ready(function() {
        function removeReview(id) {

            // alert(id);
            swal({
                    title: "{{ __('messages.Are_you_sure') }}",
                    text: "{{ __('messages.review_delete') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ Route('remove_review') }}",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                'review_id': id,
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                // console.log(response);
                                if (response.status == 0) {

                                } else {
                                    swal({
                                        title: response.msg,
                                        text: "",
                                        type: "success",
                                        icon: "success",
                                        // timer: 2000,
                                        showConfirmButton: true
                                    }).then(function() {
                                        // loadTutorList();
                                        location.reload();
                                    });
                                }
                            }
                        });
                    } else {
                        // swal("Your imaginary file is safe!");
                    }
                });
        }

        function editReviewViewLoad(id) {
            $.ajax({
                url: "{{ Route('getreviewsview') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'review_id': id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status == 0) {

                    } else {
                        // type selection option
                        $('#update_review_form').get(0).reset();
                        $('#utype').empty();
                        var optionType = '';
                        var selectedTypeo = '';
                        var selectedTypes = '';
                        if (response.data.reviewData.type == "Commendation") {
                            selectedTypeo = 'selected';
                        }
                        if (response.data.reviewData.type == "Complaint") {
                            selectedTypes = 'selected';
                        }

                        optionType +=
                            '<option value="" selected disabled hidden>{{ __('messages.Choose_the_Review_Type') }}</option>';
                        optionType += '<option value="Commendation" ' + selectedTypeo + '>' +
                            '{{ __('messages.Commendation') }}' +
                            '</option>';
                        optionType += '<option value="Complaint" ' + selectedTypes + '>' +
                            '{{ __('messages.Complaint') }}' +
                            '</option>';
                        $('#utype').append(optionType);

                        //from date
                        $('#ufrom_date').val(response.data.reviewData.from_date);
                        //to date
                        $('#uto_date').val(response.data.reviewData.to_date);
                        //nickname 
                        // $('#unickname').val(response.data.reviewData.nickname);
                        // location
                        $('#ulocation-input').val(response.data.reviewData.user_country);
                        // selected star
                        $('#utotal_star').val(response.data.reviewData.star_ratings)
                        // selected star show
                        if (response.data.reviewData.star_ratings == 0) {
                            $(".ucon .fa-thumbs-up").css("color", "black");
                            $(".ucon .fa-thumbs-down").css("color", "black");
                        }
                        if (response.data.reviewData.star_ratings == 1) {
                            $(".ucon .fa-thumbs-up").css("color", "black");
                            $("#ust1").css("color", "#F6BE00");
                        }
                        if (response.data.reviewData.star_ratings == 2) {
                            $(".ucon .fa-thumbs-up").css("color", "black");
                            $("#ust1, #ust2").css("color", "#F6BE00");
                        }
                        if (response.data.reviewData.star_ratings == 3) {
                            $(".ucon .fa-thumbs-up").css("color", "black")
                            $("#ust1, #ust2, #ust3").css("color", "#F6BE00");
                        }
                        if (response.data.reviewData.star_ratings == 4) {
                            $(".ucon .fa-thumbs-up").css("color", "black");
                            $("#ust1, #ust2, #ust3, #ust4").css("color", "#F6BE00");
                        }
                        if (response.data.reviewData.star_ratings == 5) {
                            $(".ucon .fa-thumbs-up").css("color", "black");
                            $("#ust1, #ust2, #ust3, #ust4, #ust5").css("color", "#F6BE00");
                        }

                        if (response.data.reviewData.star_ratings == -1) {
                            $(".ucon .fa-thumbs-down").css("color", "black");
                            $("#ustm1").css("color", "#cc0000");
                        }

                        if (response.data.reviewData.star_ratings == -2) {
                            $(".ucon .fa-thumbs-down").css("color", "black");
                            $("#ustm1,#ustm2").css("color", "#cc0000");
                        }
                        if (response.data.reviewData.star_ratings == -3) {
                            $(".ucon .fa-thumbs-down").css("color", "black");
                            $("#ustm1,#ustm2,#ustm3").css("color", "#cc0000");
                        }
                        if (response.data.reviewData.star_ratings == -4) {
                            $(".ucon .fa-thumbs-down").css("color", "black");
                            $("#ustm1,#ustm2,#ustm3,#ustm4").css("color", "#cc0000");
                        }
                        if (response.data.reviewData.star_ratings == -5) {
                            $(".ucon .fa-thumbs-down").css("color", "black");
                            $("#ustm1,#ustm2,#ustm3,#ustm4,#ustm5").css("color", "#cc0000");
                        }

                        // show review
                        $('#ureview').val(response.data.reviewData.review_description);

                        // agree check box
                        if (response.data.reviewData.self_consent == 1) {
                            $('#uno').attr("checked", "");
                            $('#uyes').attr("checked", "checked");
                            $(".urealname").addClass('d-none');
                            $("#uyes").prop('checked', true);
                            $("#uno").prop('checked', false);
                        }
                        if (response.data.reviewData.self_consent == 0) {
                            $('#uyes').attr("checked", "");
                            $('#uno').attr("checked", "checked");
                            $(".urealname").removeClass('d-none');
                            $("#uyes").prop('checked', false);
                            $("#uno").prop('checked', true);
                        }

                        if (response.data.reviewData.show_realname == 0) {
                            $('#ureal_yes').attr("checked", "");
                            $('#ureal_no').attr("checked", "checked");
                            $("#ureal_yes").prop('checked', false);
                            $("#ureal_no").prop('checked', true);
                        }

                        if (response.data.reviewData.show_realname == 1) {
                            $('#ureal_yes').attr("checked", "checked");
                            $('#ureal_no').attr("checked", "");
                            $("#ureal_yes").prop('checked', true);
                            $("#ureal_no").prop('checked', false);
                        }

                        // set review id 
                        $('#rev_id').val(id);

                        $('#reviewEditModal').modal('show');

                    }
                }
            });
        }

        $('#reviewEditModal').on('shown.bs.modal', function() {
            $("#ufrom_date").datepicker({
                format: 'yyyy-mm-dd',
                endDate: todayDateOne.toDate(),
                language: langSe,
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#uto_date').datepicker('setStartDate', minDate);
            });
            // });

            // $(function() {
            $("#uto_date").datepicker({
                format: 'yyyy-mm-dd',
                endDate: todayDateOne.toDate(),
                language: langSe,
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#ufrom_date').datepicker('setEndDate', minDate);
            });

            // Places Autocomplete must bind after the modal is visible
            if (typeof bindMapInputs === 'function') {
                bindMapInputs(document.getElementById('reviewEditModal'));
            }
        });

        // updated review data save
        $('#update_review_form').on('submit', function(e) {
            e.preventDefault();
            // let form = $('#update_review_form').val();
            // let formData = new FormData(form);
            if ($("#utotal_star").val() == 0) {
                $(".urating_error").html("{{ __('messages.fill_out') }}");
                $("#utotal_star").focus();
                return false;
            } else {
                $(".urating_error").html("");
            }

            $.ajax({
                url: "{{ Route('updatereview') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                    } else {
                        $('#update_review_form').get(0).reset();
                        $('#reviewEditModal').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            // timer: 2000,
                            showConfirmButton: true
                        }).then(function() {
                            location.reload();
                        });
                    }
                }
            });
        });
        // });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}



    <script>
        var pageNo = "";
        var callFromPagination = 0;
        var langSe = $('#langSelected').val();
        $(document).ready(function() {

            $("#from_Date").datepicker({
                format: 'yyyy-mm-dd',
                endDate: todayDateOne.toDate(),
                language: langSe,
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#to_Date').datepicker('setStartDate', minDate);
            });

            $("#to_Date").datepicker({
                format: 'yyyy-mm-dd',
                endDate: todayDateOne.toDate(),
                language: langSe,
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#from_Date').datepicker('setEndDate', minDate);
            });

            $('#to_Date').change(function() {
                // endDate = $(this).datepicker('getDate');
                // $("#from_Date").datepicker("option", "maxDate", endDate);
                // alert('dasdsa');
                loadReviews();
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                pageNo = $(this).attr('href').split('page=')[1];
                callFromPagination = 1;
                loadReviews();
            });
        });

        function loadReviews() {

            if (callFromPagination == 0) {
                pageNo = 1; // call from other than pagination
            }

            var orderBy = $('#order_by option:selected').val();
            var reviewBy = $('#review_type option:selected').val();
            var ratingBy = $('#by_star option:selected').val();
            var typeselect = $('#review_by option:selected').val();
            var profileId = $('#pro_id').val();
            var from_d = $('#from_Date').val();
            var to_d = $('#to_Date').val();
            $.ajax({
                url: "{{ Route('getreviews') }}",
                data: {
                    'orderBy': orderBy,
                    'reviewBy': reviewBy,
                    'ratingBy': ratingBy,
                    'type': typeselect,
                    'profileId': profileId,
                    'from_date': from_d,
                    'to_date': to_d,
                    'page': pageNo,
                },
                success: function(res) {
                    callFromPagination = 0;
                    $('#allreviews').html(res);
                }
            });
        }
    </script>
    <script>
        {{-- update review --}}
        $(document).ready(function() {
            $("#ust1").click(function() {
                if ($("#ust1").css("color") == "rgb(255, 165, 52)") {
                    $(".ucon .fa-thumbs-up").css("color", "black");
                    $(".ucon .fa-thumbs-down").css("color", "black");
                    $("#utotal_star").val("0");
                } else {
                    $(".ucon .fa-thumbs-up").css("color", "black");
                    $(".ucon .fa-thumbs-down").css("color", "black");
                    $("#ust1").css("color", "#F6BE00");
                    $("#utotal_star").val("1");
                }
            });
            $("#ust2").click(function() {
                $(".ucon .fa-thumbs-up").css("color", "black");
                $(".ucon .fa-thumbs-down").css("color", "black");
                $("#ust1, #ust2").css("color", "#F6BE00");
                $("#utotal_star").val("2");
            });
            $("#ust3").click(function() {
                $(".ucon .fa-thumbs-up").css("color", "black")
                $(".ucon .fa-thumbs-down").css("color", "black");
                $("#ust1, #ust2, #ust3").css("color", "#F6BE00");
                $("#utotal_star").val("3");
            });
            $("#ust4").click(function() {
                $(".ucon .fa-thumbs-up").css("color", "black");
                $(".ucon .fa-thumbs-down").css("color", "black");
                $("#ust1, #ust2, #ust3, #ust4").css("color", "#F6BE00");
                $("#utotal_star").val("4");
            });
            $("#ust5").click(function() {
                $(".ucon .fa-thumbs-up").css("color", "black");
                $(".ucon .fa-thumbs-down").css("color", "black");
                $("#ust1, #ust2, #ust3, #ust4, #ust5").css("color", "#F6BE00");
                $("#utotal_star").val("5");
            });

            // #cc0000 red star color

            $("#ustm1").click(function() {
                if ($("#ustm1").css("color") == "rgb(255, 69, 69)") {
                    $(".ucon .fa-thumbs-down").css("color", "black");
                    $(".ucon .fa-thumbs-up").css("color", "black");
                    $("#utotal_star").val("0");
                } else {
                    $(".ucon .fa-thumbs-down").css("color", "black");
                    $(".ucon .fa-thumbs-up").css("color", "black");
                    $("#ustm1").css("color", "#cc0000");
                    $("#utotal_star").val("-1");
                }
            });

            $("#ustm2").click(function() {
                $(".ucon .fa-thumbs-down").css("color", "black");
                $(".ucon .fa-thumbs-up").css("color", "black");
                $("#ustm1,#ustm2").css("color", "#cc0000");
                $("#utotal_star").val("-2");
            });

            $("#ustm3").click(function() {
                $(".ucon .fa-thumbs-down").css("color", "black");
                $(".ucon .fa-thumbs-up").css("color", "black");
                $("#ustm1,#ustm2,#ustm3").css("color", "#cc0000");
                $("#utotal_star").val("-3");
            });

            $("#ustm4").click(function() {
                $(".ucon .fa-thumbs-down").css("color", "black");
                $(".ucon .fa-thumbs-up").css("color", "black");
                $("#ustm1,#ustm2,#ustm3,#ustm4").css("color", "#cc0000");
                $("#utotal_star").val("-4");
            });

            $("#ustm5").click(function() {
                $(".ucon .fa-thumbs-down").css("color", "black");
                $(".ucon .fa-thumbs-up").css("color", "black");
                $("#ustm1,#ustm2,#ustm3,#ustm4,#ustm5").css("color", "#cc0000");
                $("#utotal_star").val("-5");
            });
        });
    </script>
@endsection
