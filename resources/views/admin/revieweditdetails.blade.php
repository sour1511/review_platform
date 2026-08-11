@extends('layout')
@section('content')
    @parent
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('messages.review_details') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.review_details') }}</li>
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
                        <div class="card-title font-weight-bold text-white text-center"> {{ __('messages.update_review') }}
                        </div>
                    </div>
                    {{-- <div class="col-md-7"> --}}
                    <form method="post" action="{{ Route('reviewupdate') }}">
                        <div class="card-body">
                            <input type="hidden" id="id" name="id" class="form-control"
                                value="<?php echo $data['reviewDetails'][0]['id']; ?>" />
                            <input class="form-control" type="hidden" name="profile_id"
                                value="{{ $data['reviewDetails'][0]['profile_id'] }}" />
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type"> {{ __('messages.Review_Type') }} </label>
                                        <input type="text" name="type" id="type" class="form-control"
                                            placeholder="{{ __('messages.Review_Type') }}" value="<?php echo isset($data['reviewDetails'][0]['type']) ? $data['reviewDetails'][0]['type'] : ''; ?>"
                                            required readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="post_date"> {{ __('messages.post_date') }} </label>
                                        <input type="text" name="post_date" id="post_date" class="form-control"
                                            placeholder="Post date" value="<?php echo isset($data['reviewDetails'][0]['post_date']) ? $data['reviewDetails'][0]['post_date'] : ''; ?>" required readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="category"> {{ __('messages.category_name') }} </label>
                                        @php
                                            if ($data['reviewDetails'][0]['category_id'] != null) {
                                                $catData = \App\Models\Category::where('id', $data['reviewDetails'][0]['category_id'])->first();
                                                $categoryName = $catData->category_title;
                                            } else {
                                                $categoryName = 'NULL';
                                            }
                                            
                                        @endphp
                                        <input type="text" name="category" id="category" class="form-control"
                                            placeholder="Category Name" value="{{ $categoryName }}" required readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subcategory_name"> {{ __('messages.sub_category_name') }}</label>
                                        @php
                                            if ($data['reviewDetails'][0]['sub_category_id'] != null) {
                                                $subCatData = \App\Models\SubCategory::where('id', $data['reviewDetails'][0]['sub_category_id'])->first();
                                                $subCategoryName = $subCatData->sub_category_title;
                                            } else {
                                                $subCategoryName = 'NULL';
                                            }
                                            
                                        @endphp
                                        <input type="text" name="subcategory_name" id="subcategory_name"
                                            class="form-control" placeholder="Sub-category Name" value="{{ $subCategoryName }}"
                                            required readonly />

                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="from_date">{{ __('messages.Select_from_date') }}</label>
                                        <input type="text" name="from_date" id="from_date" class="form-control"
                                            placeholder="{{ __('messages.from') }}" value="<?php echo isset($data['reviewDetails'][0]['from_date']) ? $data['reviewDetails'][0]['from_date'] : ''; ?>" required
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="to_date">{{ __('messages.Select_to_date') }}</label>
                                        <input type="text" name="to_date" id="to_date" class="form-control"
                                            placeholder="{{ __('messages.to') }}" value="<?php echo isset($data['reviewDetails'][0]['to_date']) ? $data['reviewDetails'][0]['to_date'] : ''; ?>" required
                                            readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nickname"> Nickname</label>
                                        <input type="text" name="nickname" id="nickname" class="form-control"
                                            placeholder="Nickname" value="<?php echo isset($data['reviewDetails'][0]['nickname']) ? $data['reviewDetails'][0]['nickname'] : ''; ?>" required readonly />
                                    </div>
                                </div> --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_country">{{ __('messages.location') }}</label>
                                        <input type="text" name="user_country" id="user_country" class="form-control"
                                            placeholder="{{ __('messages.location') }}" value="{{ $data['reviewDetails'][0]['user_country'] ?? '' }}"
                                            required readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="ucon">
                                        <label
                                            for="vist_date">{{ __('messages.Add_Positive_or_Negative_Ratings') }}</label><br>

                                        {{-- <i class="fa fa-star" aria-hidden="true" title="-5 Stars" id="ustm5"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="-4 Stars" id="ustm4"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="-3 Stars" id="ustm3"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="-2 Stars" id="ustm2"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="-1 Star" id="ustm1"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="1 Star" id="ust1"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="2 Stars" id="ust2"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="3 Stars"id="ust3"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="4 Stars" id="ust4"></i>
                                        <i class="fa fa-star" aria-hidden="true" title="5 Stars"id="ust5"></i> --}}

                                        @if ($data['reviewDetails'][0]['star_ratings'] == 0)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == -1)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-1 Star" id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == -2)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-2 Stars" id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-1 Star" id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == -3)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-3 Stars" id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-2 Stars" id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-1 Star" id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == -4)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-4 Stars" id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-3 Stars" id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-2 Stars" id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-1 Star" id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == -5)
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-5 Stars" id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-4 Stars" id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-3 Stars" id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-2 Stars" id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" style="color: #cc0000;" aria-hidden="true"
                                                title="-1 Star" id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="1 Star"
                                                id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == 1)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="1 Star" id="ust1"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="2 Stars"
                                                id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == 2)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="1 Star" id="ust1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="2 Stars" id="ust2"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == 3)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="1 Star" id="ust1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="2 Stars" id="ust2"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true" title="4 Stars"
                                                id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == 4)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="1 Star" id="ust1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="2 Stars" id="ust2"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="4 Stars" id="ust4"></i>
                                            <i class="fa fa-thumbs-up" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                        @if ($data['reviewDetails'][0]['star_ratings'] == 5)
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-5 Stars"
                                                id="ustm5"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-4 Stars"
                                                id="ustm4"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-3 Stars"
                                                id="ustm3"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-2 Stars"
                                                id="ustm2"></i>
                                            <i class="fa fa-thumbs-down" aria-hidden="true" title="-1 Star"
                                                id="ustm1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="1 Star" id="ust1"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="2 Stars" id="ust2"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="3 Stars"id="ust3"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="4 Stars" id="ust4"></i>
                                            <i class="fa fa-thumbs-up" style="color: #F6BE00;" aria-hidden="true"
                                                title="5 Stars"id="ust5"></i>
                                        @endif
                                    </div>
                                </div>
                                {{-- <label class="text-warining ">Note </label> --}}
                            </div>
                            <input type="hidden" name="rating_star" id="utotal_star"
                                value="{{ $data['reviewDetails'][0]['star_ratings'] }}">

                            <div class="form-group">
                                <label for="review_description"> {{ __('messages.Add_a_Review') }} </label><br>
                                <textarea id="review_description" class="form-control" name="review_description" rows="4" cols="50"
                                    placeholder="Enter review description" required>{{ $data['reviewDetails'][0]['review_description'] ?? '' }}</textarea>
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
