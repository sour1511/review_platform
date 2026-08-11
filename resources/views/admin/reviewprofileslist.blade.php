@extends('layout')
@section('head')
    @parent
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css"> --}}
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
                        <h1 class="m-0">{{ __('messages.review_profiles') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.review_profiles') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content-header -->

        <!-- Main content -->

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


        <div class="card mr-1 ml-1">
            <div class="card-header">
                {{-- search filter --}}
                <div class="row">
                    <div class="mt-3 mb-3 col-sm-6 col-md-3 col-lg-3">
                        <label for="sub_cat">{{ __('messages.review_profile_name') }} </label>
                        <input type="text" title="{{ __('messages.review_profile_name') }}" id="profile_name"
                            name="profile_name" placeholder="{{ __('messages.review_profile_name') }}" class="form-control">
                        <i class="ti-search"></i>

                    </div>
                    <div class="mt-3 mb-3 col-sm-6 col-md-3 col-lg-3">
                        <label for="filter">{{ __('messages.select_category') }}</label>
                        {{-- <select class="livesearch form-control" name="livesearch"></select> --}}
                        <select onchange="getSubCategory()" class="livesearch form-control">
                            <option value="">&nbsp;</option>
                            {{-- <option value="All">All Category</option> --}}
                            @if ($data['categories']->count() > 0)
                                <option value="all">{{ __('messages.Show_All') }}</option>
                                @foreach ($data['categories'] as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mt-3 mb-3 col-sm-6 col-md-3 col-lg-3 ">
                        <label for="sub_cat">{{ __('messages.select_subcategory') }} </label>
                        <select class="form-control" id="subcate" name="sub_cat">
                        </select>
                    </div>
                    <div class="mt-3 mb-3 col-sm-6 col-md-3 col-lg-3 ">
                        <label for="location_name">{{ __('messages.location') }}</label>
                        <input type="text" id="address-input" name="address_address" class="form-control b-r map-input"
                            placeholder="{{ __('messages.location') }}">
                        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                    </div>
                    <div class="d-none" id="address-map-container" style="width:100%;height:400px; ">
                        <div style="width: 100%; height: 100%" id="address-map"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 p-0 float-right">
                        {{-- <label for="">{{ __('messages.search') }}</label> --}}
                        <button type="button" id="search_cat" class="btn btn-primary btn-sm form-control"><i
                                class="fa fa-search"></i> {{ __('messages.search') }}</button>
                        <button type="button"
                            class="btn btn-warning mt-1 full-width clearFilter float-right">{{ __('messages.clear') }}</button>
                    </div>
                </div>
                {{-- show list of reviews --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div id="reviewListAjaxView">
                            @include('admin.reviewprofile_list_ajax')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        {{-- end reviews --}}

    </div>

    <!-- delete pop up box -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <form role="form" method='post' action="{{ Route('profiledelete') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.delete_profile') }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">

                        <p>{{ __('messages.remove_profile') }}</p>
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
    <!-- /.modal -->
@endsection

@section('script')
    @parent
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
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
                    "autoWidth": true,
                    "deferRender": true,
                    "destroy": true,
                    "buttons": ["csv", "excel", "pdf"]
                }).buttons().container().appendTo('#reviewsList_wrapper .col-md-6:eq(0)');
            });
        });
    </script>

    <script type="text/javascript">
        $('.livesearch').select2({
            placeholder: "{{ __('messages.choose_a_category') }}"
        });
        $('#subcate').select2({
            placeholder: "{{ __('messages.choose_a_subcategory') }}"
        });

        function getSubCategory() {
            var catgory_id = $('.livesearch option:selected').val();
            if (catgory_id != "") {
                $.ajax({
                    type: "POST",
                    url: "{{ Route('getsubcategoryadmin') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category_id": catgory_id
                    },
                    success: function(data) {
                        $('#subcate').html(data);
                    }
                });
            }
        }

        $(".clearFilter").click(function(ev) {
            location.reload();

            // $(".livesearch").val('').trigger('change');
            // $("#subcate").val('').trigger('change');
            // $("#address-input").val('');
            // $("#profile_name").val('');

            // $.ajax({
            //     url: "{{ Route('getreviewprofileslist') }}",
            //     data: {
            //         'cat_id': '',
            //         'subcat_id': '',
            //         'location_name': '',
            //         'profile_name': '',
            //     },
            //     success: function(data) {
            //         $('#reviewListAjaxView').html(data);
            //     }
            // });


        });

        $(document).ready(function() {
            $("#search_cat").click(function() {
                var cat_id = $('.livesearch option:selected').val();
                var subcat_id = $('#subcate option:selected').val();
                var location_name = $('#address-input').val();
                var profile_name = $('#profile_name').val();
                // if (cat_id != "") {
                $.ajax({
                    url: "{{ Route('getreviewprofileslist') }}",
                    data: {
                        'cat_id': cat_id,
                        'subcat_id': subcat_id,
                        'location_name': location_name,
                        'profile_name': profile_name,
                    },
                    success: function(data) {
                        $('#reviewListAjaxView').html(data);
                    }
                });
                // } else {
                //     location.reload();
                // }
            });

        });

        // $(document.body).on("change", ".livesearch", function() {
        //     // alert(this.value);
        //     // call ajax function and load category data on reviews table view 
        //     var catgory_id = this.value;
        //     if (catgory_id != "") {
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ Route('getsubcategory') }}",
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "category_id": catgory_id
        //             },
        //             success: function(data) {
        //                 $('#subcate').html(data);
        //             }
        //         });
        //     }
        //     $.ajax({
        //         url: "{{ Route('getreviewprofileslist') }}",
        //         data: {
        //             'id': this.value,
        //         },
        //         success: function(data) {
        //             $('#reviewListAjaxView').html(data);
        //         }
        //     });
        // });

        // $(document.body).on("change", "#subcate", function() {
        //     var cat_id = $('.livesearch option:selected').val();
        //     var subcat_id = $('#subcate option:selected').val();
        //     var location_name = $('#location_name').val();
        //     // if (cat_id != "") {
        //     $.ajax({
        //         url: "{{ Route('getprofilesfilter') }}",
        //         data: {
        //             'cat_id': cat_id,
        //             'subcat_id': subcat_id,
        //             'location_name': location_name,
        //         },
        //         success: function(data) {
        //             $('#reviewListAjaxView').html(data);
        //         }
        //     });

        // });
    </script>
@endsection
