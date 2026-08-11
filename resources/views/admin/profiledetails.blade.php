@extends('layout')
@section('head')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<style>
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
</style>
@section('content')
    @parent
    <div class="content-wrapper mb-3">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                        <h1 class="m-0">
                            @if ($data['profilesData']->profile_name == null)
                                {{ __('messages.Commendations_and_Complaints_about') }} {{ $data['profilesData']->name }}
                            @else
                                {{ __('messages.Commendations_and_Complaints_about') }}
                                {{ $data['profilesData']->profile_name }}
                            @endif
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.review_profile') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content-header -->
        <section class="content mb-3">

            <!-- Default box -->
            <div class="card m-3">
                <div class="card-header">
                    {{-- <h3 class="card-title">Projects Detail</h3> --}}

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                            @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
                                <input type="hidden" id="pro_id" value="{{ $data['profilesData']->id }}">
                                <div class="row">
                                    <div class="col-12">
                                        {{-- <h4>Recent Activity</h4> --}}
                                        <div class="post">
                                            <div class="user-block">
                                                @if ($data['profilesData']->profile_pic != null)
                                                    <img class="img-circle img-bordered-sm"
                                                        src="{{ asset($data['profilesData']->profile_pic) }}"
                                                        alt="profile image" />
                                                @else
                                                    <img class="img-circle img-bordered-sm"
                                                        src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                        alt="profile image" />
                                                @endif
                                                <span class="username">
                                                    @if ($data['profilesData']->profile_name == null)
                                                        <a href="#">{{ $data['profilesData']->name }}</a>
                                                    @else
                                                        <a href="#">{{ $data['profilesData']->profile_name }}</a>
                                                    @endif
                                                </span>
                                                <span class="description"><b>{{ __('messages.category') }}:</b>
                                                    {{ $data['profilesData']->category_title }},
                                                    <b>{{ __('messages.subcategory') }}:</b>
                                                    {{ $data['profilesData']->sub_category_title }}</span>
                                                <span class="description"><i
                                                        class="fas fa-map-marker-alt mr-1"></i>{{ $data['profilesData']->location }}</span>
                                            </div>
                                            @php
                                                $added_date = date('Y-m-d', strtotime($data['profilesData']->created_at));
                                            @endphp
                                            <p>
                                                <a href="#" class="link-black text-sm m-1"><i
                                                        class="fas fa-calendar-alt mr-1"></i>{{ __('messages.date_created') }}:
                                                    {{ $added_date }}</a>
                                                <a href="#" class="link-black text-sm m-1">
                                                    {{-- <i class="fas fa-link mr-1"></i> --}}
                                                    <i class="fas fa-comment text-sm m-1"></i>
                                                    @if (isset($data['reviewsData']) && $data['reviewsData']->count() > 0)
                                                        {{ $data['reviewsData']->count() }}
                                                    @else
                                                        0
                                                    @endif
                                                </a>
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
                                                <a href="#" class="link-black text-sm m-1">
                                                    {{-- <i class="fas fa-link mr-1"></i> --}}
                                                    {{ __('messages.Overall_Rating') }}: {{ $finalStar }}
                                                    @if ($finalStar == '-1')
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                    @endif
                                                    @if ($finalStar == '-2')
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                    @endif
                                                    @if ($finalStar == '-3')
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                    @endif
                                                    @if ($finalStar == '-4')
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                    @endif
                                                    @if ($finalStar == '-5')
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                        <i class="fa fa-thumbs-down fa-lg  m-1" aria-hidden="true"
                                                            style="color: #cc0000"></i>
                                                    @endif

                                                    @if ($finalStar == '1')
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                    @endif
                                                    @if ($finalStar == '2')
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                    @endif
                                                    @if ($finalStar == '3')
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                    @endif
                                                    @if ($finalStar == '4')
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                    @endif
                                                    @if ($finalStar == '5')
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                        <i class="fa fa-thumbs-up fa-lg  m-1" aria-hidden="true"
                                                            style="color: #F6BE00"></i>
                                                    @endif

                                                </a>
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
                                                        if (isset($data['unverified']) && $data['unverified']->count() > 0) {
                                                            $totalUnVCount = $data['unverified']->count();
                                                            $avgUnVerified = round($totalUnVCount / $reviewCount, 1);
                                                        }
                                                    } else {
                                                        $totalUnVCount = $data['unverified']->count();
                                                        $avgUnVerified = 0;
                                                    }
                                                @endphp
                                                <a href="#" class="link-black text-sm m-1">
                                                    {{ __('messages.Verified_Reviews') }}: {{ $totalVCount }} /
                                                    {{ $avgVerified }}
                                                </a>
                                                <a href="#" class="link-black text-sm m-1">
                                                    {{ __('messages.Unverified_Reviews') }}: {{ $totalUnVCount }} /
                                                    {{ $avgUnVerified }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            {{-- show list of reviews --}}
            <div class="card m-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">{{ __('messages.Search_Reviews_by') }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <select id="order_by" name="orderBy" onchange="loadReviews()"
                                    class="js-states form-control">
                                    <option value="">&nbsp;</option>
                                    <option value="all">{{ __('messages.Show_All') }}</option>
                                    <option value="desc">{{ __('messages.From_most') }}</option>
                                    <option value="asc">{{ __('messages.From_oldest') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <select id="review_type" name="review_type" onchange="loadReviews()"
                                    class="js-states form-control">
                                    <option value="">&nbsp;</option>
                                    <option value="all">{{ __('messages.Show_All') }}</option>
                                    <option value="1">{{ __('messages.Show_Verified_Review') }}</option>
                                    <option value="0">{{ __('messages.Show_Unverified_Review') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <select id="by_star" name="by_star" onchange="loadReviews()"
                                    class="js-states form-control">
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
                                <select id="review_by" name="review_by" onchange="loadReviews()"
                                    class="js-states form-control">
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
                <div class="card-body mb-3">
                    <div class="row">
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
                        <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                            <div id="allreviews">
                                @include('admin.allreviewslist')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            {{-- end reviews --}}

        </section>
    </div>
    <div class="modal fade" id="deleteReview" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form role="form" method='post' action="{{ Route('reviewdelete') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.remove_review') }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">
                        <p>{{ __('messages.delete_msg') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ __('messages.remove') }}</button>
                        <button type="button" class="btn btn-primary"
                            data-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                    @csrf
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
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

        $(".clearFilter").click(function(ev) {
            $('#order_by').val('').trigger('change');
            $('#review_type').val('').trigger('change');
            $('#review_by').val('').trigger('change');
            $('#by_star').val('').trigger('change');
            $('#from_Date').val('');
            $('#to_Date').val('');
        });

        function loadReviews() {
            var orderBy = $('#order_by option:selected').val();
            var reviewBy = $('#review_type option:selected').val();
            var ratingBy = $('#by_star option:selected').val();
            var profileId = $('#pro_id').val();
            var from_d = $('#from_Date').val();
            var to_d = $('#to_Date').val();
            var typeselect = $('#review_by option:selected').val();
            $.ajax({
                url: "{{ Route('getreviewsadmin') }}",
                data: {
                    'orderBy': orderBy,
                    'reviewBy': reviewBy,
                    'ratingBy': ratingBy,
                    'profileId': profileId,
                    'from_date': from_d,
                    'to_date': to_d,
                    'type': typeselect,
                },
                success: function(res) {
                    $('#allreviews').html(res);
                }
            });
        }
        $(document).on('click', '.scrap', function(e) {
            scrapId = $(this).attr('data-id');
            $('#deleteId').val(scrapId);
        });
        $(document).ready(function() {
            $(function() {
                $("#reviewsList").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "searching": false,
                    "autoWidth": false,
                    "deferRender": true,
                    "destroy": true,
                    "buttons": ["csv", "excel", "pdf"]
                }).buttons().container().appendTo('#reviewsList_wrapper .col-md-6:eq(0)');
            });
        });
    </script>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var todayDateOne = moment();
        var langSe = $('#langSelected').val();
        $(document).ready(function() {
            $(function() {
                $("#from_Date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    endDate: todayDateOne.toDate(),
                    language: langSe,
                    autoclose: true
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#to_Date').datepicker('setStartDate', minDate);
                });
            });

            $(function() {
                $("#to_Date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    endDate: todayDateOne.toDate(),
                    language: langSe,
                    autoclose: true
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#from_Date').datepicker('setEndDate', minDate);
                });
            });

            $('#from_Date').change(function() {
                startDate = $(this).datepicker('getDate');
                $("#to_Date").datepicker("option", "minDate", startDate);
            });

            $('#to_Date').change(function() {
                endDate = $(this).datepicker('getDate');
                $("#from_Date").datepicker("option", "maxDate", endDate);
                loadReviews();
            });
        });
    </script>
@endsection
