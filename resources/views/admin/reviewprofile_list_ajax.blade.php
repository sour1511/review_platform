<table id="reviewsList" class="table table-bordered table-striped mb-3">
    @if (isset($data['reviewsData']) && count($data['reviewsData']) > 0)
        <thead>
            <tr>
                {{-- <th>{{ __('messages.date') }}</th> --}}
                <th>{{ __('messages.Review_Profile_Name') }}</th>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.sub_category_name') }}</th>
                <th>{{ __('messages.users_name') }}</th>
                <th>{{ __('messages.location') }}</th>
                <th style="width: 150px !important;">{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['reviewsData'] as $review)
                <tr>
                    @php
                        if ($review->category_id != null) {
                            $catData = \App\Models\Category::where('id', $review->category_id)->first();
                            $categoryName = $catData->category_title;
                        } else {
                            $categoryName = 'NULL';
                        }
                        
                        if ($review->sub_category_id != null) {
                            $subcatData = \App\Models\SubCategory::where('id', $review->sub_category_id)->first();
                            $subcategoryName = $subcatData->sub_category_title;
                        } else {
                            $subcategoryName = 'NULL';
                        }
                        
                        if ($review->profile_name != null) {
                            $profileName = $review->profile_name;
                        } else {
                            $profileName = $review->name;
                        }
                        
                    @endphp
                    <td>{{ $profileName }}</td>
                    <td>{{ $categoryName }}</td>
                    <td>{{ $subcategoryName }}</td>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->location }}</td>
                    <td>
                        <div class="col-xs-
                    col-sm-12 col-md-12 col-lg-">
                            <div class="row">
                                <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                    <a class="btn btn-primary btn-xs m-1" title="Profile Details"
                                        href="{{ Route('adminprofiledetailsview', ['id' => $review->id]) }}"><i
                                            class="fa fa-eye"></i> </a>
                                </div>
                                <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                    <button type="button" class="btn btn-danger btn-xs scrap m-1"
                                        data-id="<?php echo $review->id; ?>" data-toggle="modal" data-target="#myModal"
                                        data-toggle="modal" data-target="#myModal" title="{{ __('messages.delete') }}"
                                        style=""><i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @else
        <div class="col-lg-12 col-xl-12 mb-3 text-center">
            <h4>No profiles found</h4>
        </div>
    @endif
</table>
