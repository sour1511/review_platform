<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\Review;
use App\Models\User;
use App\Models\Category;
use App\Models\Profile;
use App\Models\SubCategory;
use App\Models\CustomAd;
use App\Models\AdSetting;
use App\Models\CustomGender;
use Exception;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\File;
use Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Rules\ReCaptcha;
use App;
use App\Models\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    protected $lastMailError = null;

    // rk
    public function home()
    {
        $this->getCountryName();

        // var_dump(Session::get('visitor_country'));
        // die;
        if (empty(Session::get('login_username'))) {
            // visitor           
            $visitor_country = Session::get('visitor_country');
            $data['profilesData'] = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where('profiles.is_delete', 0)
                // ->groupBy('profiles.id')
                // ->orderBy('profiles.id', 'desc')
                // ->get();                
                ->where('profiles.country', 'LIKE', "%{$visitor_country}%")
                ->inRandomOrder()
                ->paginate(20);

            $profiles = Profile::select("profiles.*")
                ->where('profiles.country', 'LIKE', "%{$visitor_country}%")
                ->where('is_delete', 0)
                ->pluck('profiles.id')->toArray();
            //var_dump($profiles);

            // TOP REVIEWED PROFILES - 10
            $reviewCounts = Review::select("reviews.profile_id", DB::raw("COUNT(reviews.profile_id) as count"))->groupBy('reviews.profile_id')->orderBy('count', 'desc')->whereIn('reviews.profile_id', $profiles)->limit(10)->pluck('reviews.profile_id')->toArray();

            $data['reviewsData'] = Review::select("reviews.*", "profiles.profile_name", "profiles.location", "users.name", "users.lname", "users.nickname as nick", "users.user_pic", "users.avatar_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('profiles', 'profiles.id', '=', 'reviews.profile_id')
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('categories', 'categories.id', '=', 'reviews.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
                ->where('reviews.is_delete', 0)
                ->whereIn('reviews.profile_id', $reviewCounts)
                // ->where('profiles.country', 'LIKE', "%{$visitor_country}%")
                // ->orderBy('reviews.id', 'desc')
                ->inRandomOrder()
                ->paginate(10);
        } else {
            // login user
            $login_user_country = Session::get('login_country');
            // $profilesData->where('profiles.location', 'LIKE', "%{$request->location_name}%");
            $data['profilesData'] = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where('profiles.is_delete', 0)
                // ->groupBy('profiles.id')
                // ->orderBy('profiles.id', 'desc')
                // ->get();
                ->where('profiles.country', 'LIKE', "%{$login_user_country}%")
                ->inRandomOrder()
                ->paginate(20);

            $profiles = Profile::select("profiles.*")
                ->where('profiles.country', 'LIKE', "%{$login_user_country}%")
                ->where('is_delete', 0)
                ->pluck('profiles.id')->where('is_delete', 0)->toArray();
            //var_dump($profiles);

            // TOP REVIEWED PROFILES - 10
            $reviewCounts = Review::select("reviews.profile_id", DB::raw("COUNT(reviews.profile_id) as count"))->groupBy('reviews.profile_id')->orderBy('count', 'desc')->whereIn('reviews.profile_id', $profiles)->limit(10)->pluck('reviews.profile_id')->toArray();
            //,DB::raw("COUNT(reviews.profile_id) as count")
            //var_dump($reviewCounts);
            //die;

            $data['reviewsData'] = Review::select("reviews.*", "profiles.profile_name", "profiles.location", "users.name", "users.lname", "users.nickname as nick", "users.user_pic", "users.avatar_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('profiles', 'profiles.id', '=', 'reviews.profile_id')
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('categories', 'categories.id', '=', 'reviews.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
                ->where('reviews.is_delete', 0)
                ->whereIn('reviews.profile_id', $reviewCounts)
                //->where('profiles.country', 'LIKE', "%{$login_user_country}%")
                // ->orderBy('reviews.id', 'desc')
                ->inRandomOrder()
                ->paginate(10);
        }

        $data['profilesDataCount'] = Profile::where('is_delete', 0)->get();

        $data['reviewsDataCount'] = Review::select("reviews.*", "profiles.profile_name", "profiles.location", "users.name", "users.lname", "users.nickname as nick", "users.nickname as nick", "users.user_pic", "users.avatar_pic", "categories.category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
            ->join('profiles', 'profiles.id', '=', 'reviews.profile_id')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('categories', 'categories.id', '=', 'reviews.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
            ->where('reviews.is_delete', 0)
            ->get();

        $data['reviewsDataTestimonial'] = Review::select("reviews.*", "profiles.profile_name", "profiles.location", "users.name", "users.lname", "users.nickname as nick", "users.user_pic", "users.avatar_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
            ->join('profiles', 'profiles.id', '=', 'reviews.profile_id')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('categories', 'categories.id', '=', 'reviews.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
            ->where('reviews.is_delete', 0)
            ->inRandomOrder()
            ->take(8)->get();

        $data['users'] = User::where('role_id', 2)->orderBy('users.id', 'desc')->get();

        $data['categories'] = Category::where('is_delete', 0)->get();

        $data['ad_settings'] = AdSetting::where('id', 1)->first();
        $data['custom_ads'] = CustomAd::where('is_delete', 0)->get();

        $data['mostCategories'] = Category::where('is_delete', 0)->whereIn('id', [1, 2, 4, 11, 12, 15, 9, 16])->get();

        return view('frontend.home', compact('data'));
    }

    function getMostPopularProfiles(Request $request)
    {
        $profilesData = "";
        $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('categories', 'categories.id', '=', 'profiles.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id');

        if (isset($request->cat_id)) {
            $profilesData = $profilesData->where('profiles.category_id', $request->cat_id);
        }

        if (isset($request->subcat_id)) {
            $profilesData = $profilesData->where('profiles.sub_category_id', $request->subcat_id);
        }

        if (isset($request->location_name)) {
            $profilesData = $profilesData->where('profiles.location', 'LIKE', "%{$request->location_name}%");
        }
        $profilesData = $profilesData->where('is_delete', 0);
        $profilesData =  $profilesData->groupBy('profiles.id')->orderBy('profiles.id', 'desc')->paginate(20);
        $data['profilesData'] = $profilesData;
        return view('frontend.popularprofiles', compact('data'))->render();
    }

    public function contactUs()
    {
        $data['ad_settings'] = AdSetting::where('id', 1)->first();
        $data['custom_ads'] = CustomAd::where('is_delete', 0)->get();
        return view('frontend.contact', compact('data'));
    }

    public function browseProfiles()
    {
        if (empty(Session::get('login_username'))) {
            $visitor_country = Session::get('visitor_country');
            $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where('profiles.is_delete', 0)
                ->groupBy('profiles.id')
                ->orderBy('profiles.id', 'desc')
                ->where('profiles.country', 'LIKE', "%{$visitor_country}%")
                // ->get();
                ->paginate(5);
        } else {
            $login_user_country = Session::get('login_country');
            $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where('profiles.is_delete', 0)
                ->groupBy('profiles.id')
                ->orderBy('profiles.id', 'desc')
                // ->get();
                ->where('profiles.country', 'LIKE', "%{$login_user_country}%")
                ->paginate(10);
        }
        $allProfiles = Profile::where('is_delete', 0)->get();
        if ($allProfiles->count() > 0) {
            $data['result'] = $allProfiles->count();
        } else {
            $data['result'] = 0;
        }
        $categoryData = Category::where('is_delete', 0)->get();
        $data['categories'] = $categoryData;
        $data['profilesData'] = $profilesData;
        $data['ad_settings'] = AdSetting::where('id', 1)->first();
        $data['custom_ads'] = CustomAd::where('is_delete', 0)->get();
        return view('frontend.browseprofiles', compact('data'));
    }

    public function browseProfileFilterAjaxCall(Request $request)
    {
        // var_dump($request->all());
        if ($request->ajax()) {
            $profilesData = "";
            $allProfiles = "";
            $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where('profiles.is_delete', 0);

            $allProfiles = Profile::where('is_delete', 0)->where('is_delete', 0);

            if (isset($request->cat_id)) {
                $profilesData = $profilesData->where('profiles.category_id', $request->cat_id);
                $allProfiles = $allProfiles->where('profiles.category_id', $request->cat_id);
            }

            if (isset($request->subcat_id)) {
                $profilesData = $profilesData->where('profiles.sub_category_id', $request->subcat_id);
                $allProfiles = $allProfiles->where('profiles.sub_category_id', $request->subcat_id);
            }

            if (isset($request->location_name)) {
                $profilesData = $profilesData->where('profiles.location', 'LIKE', "%{$request->location_name}%");
                $allProfiles = $allProfiles->where('profiles.location', 'LIKE', "%{$request->location_name}%");
            }

            if (isset($request->profile_name)) {
                $profilesData = $profilesData->where('profiles.profile_name', 'LIKE', "%{$request->profile_name}%");
                $allProfiles = $allProfiles->where('profiles.profile_name', 'LIKE', "%{$request->profile_name}%");
            }

            if (empty(Session::get('login_username'))) {
                $profilesData =  $profilesData->groupBy('profiles.id')->orderBy('profiles.id', 'desc')->paginate(5);
            } else {
                $profilesData =  $profilesData->groupBy('profiles.id')->orderBy('profiles.id', 'desc')->paginate(10);
            }
            $allProfiles = $allProfiles->get();


            if ($allProfiles->count() > 0) {
                $data['result'] = $allProfiles->count();
            } else {
                $data['result'] = 0;
            }

            $categoryData = Category::where('is_delete', 0)->get();

            $data['categories'] = $categoryData;

            $data['profilesData'] = $profilesData;

            return view('frontend.profile_ajax_list', compact('data'))->render();
        }
    }

    public function profileDetails(Request $request)
    {
        $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('categories', 'categories.id', '=', 'profiles.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
            ->where("profiles.id", $request->id)
            ->first();
        $data['profilesData'] = $profilesData;

        $verifiedReviews = Review::where("reviews.self_consent", 1)->where('reviews.is_delete', 0)->where("reviews.profile_id", $request->id)->get();
        $unVerifiedReviews = Review::where("reviews.self_consent", 0)->where('reviews.is_delete', 0)->where("reviews.profile_id", $request->id)->get();

        if (empty(Session::get('login_username'))) {
            $reviewData = Review::select("reviews.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('categories', 'categories.id', '=', 'reviews.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
                ->where("reviews.profile_id", $request->id)
                ->where('reviews.is_delete', 0)
                ->orderBy('reviews.id', 'desc')
                ->paginate(5);
        } else {
            $reviewData = Review::select("reviews.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('categories', 'categories.id', '=', 'reviews.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
                ->where("reviews.profile_id", $request->id)
                ->where('reviews.is_delete', 0)
                ->orderBy('reviews.id', 'desc')
                ->paginate(20);
        }
        $data['reviewData'] = $reviewData;
        $data['verified'] = $verifiedReviews;
        $data['unverified'] = $unVerifiedReviews;
        $data['ad_settings'] = AdSetting::where('id', 1)->first();
        $data['custom_ads'] = CustomAd::where('is_delete', 0)->get();
        // echo "<pre>";
        // var_dump($data['reviewData']);
        // // var_dump($reviewData->count());
        // foreach ($data['reviewData'] as $dat) {
        //     var_dump($dat->id);
        //     var_dump($dat->name);
        // }
        // var_dump($date['verified']->count());
        // die;
        return view('frontend.profiledetails', compact('data'));
    }

    public function profileReviewFilterAjaxCall(Request $request)
    {
        // var_dump($request->all());
        // die;
        if ($request->ajax()) {
            $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'profiles.user_id')
                ->join('categories', 'categories.id', '=', 'profiles.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
                ->where("profiles.id", $request->profileId)
                ->first();
            $data['profilesData'] = $profilesData;
            $verifiedReviews = Review::where("reviews.self_consent", 1)->where('reviews.is_delete', 0)->where("reviews.profile_id", $request->profileId)->get();
            $unVerifiedReviews = Review::where("reviews.self_consent", 0)->where('reviews.is_delete', 0)->where("reviews.profile_id", $request->profileId)->get();

            $reviewData = "";
            $reviewData = Review::select("reviews.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('categories', 'categories.id', '=', 'reviews.category_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
                ->where('reviews.profile_id', $request->profileId)
                ->where('reviews.is_delete', 0);

            if (isset($request->reviewBy)) {
                if ($request->reviewBy != "all") {
                    $reviewData = $reviewData->where('self_consent', $request->reviewBy);
                }
            }

            if (isset($request->ratingBy)) {
                if ($request->ratingBy != "all") {
                    $reviewData = $reviewData->where('star_ratings', $request->ratingBy);
                }
            }

            if (isset($request->type)) {
                if ($request->type != "all") {
                    $reviewData = $reviewData->where('type', $request->type);
                }
            }

            if (isset($request->orderBy)) {
                if ($request->orderBy != "all") {
                    $reviewData = $reviewData->orderBy('reviews.id', $request->orderBy);
                }
            }

            if (isset($request->from_date) && isset($request->to_date)) {
                $reviewData = $reviewData->whereBetween('reviews.post_date', [$request->from_date, $request->to_date]);
            }
            if (empty(Session::get('login_username'))) {
                $reviewData =  $reviewData->paginate(5);
            } else {
                $reviewData =  $reviewData->paginate(20);
            }

            $data['reviewData'] = $reviewData;
            $data['profilesData'] = $profilesData;
            $date['verified'] = $verifiedReviews;
            $date['unverified'] = $unVerifiedReviews;

            return view('frontend.reviewsdetails', compact('data'))->render();
        }
    }

    public function submitReview(Request $request)
    {
        try {
            if (empty(Session::get('login_user_id'))) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
            }

            $request->validate([
                'profile_id' => 'required|integer',
                'category_id' => 'required|integer',
                'review' => 'required|string|max:10000',
                'doc' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
                'updated_img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            ]);

            $reviewData = new Review;

            if (isset($request->sub_category_id)) {
                $reviewData->sub_category_id = $request->sub_category_id;
            }

            if (isset($request->rating_star)) {
                $reviewData->star_ratings = $request->rating_star;
            }

            if (isset($request->user_mobile)) {
                $reviewData->user_mobile = $request->user_mobile;
            }

            if (isset($request->user_address)) {
                $reviewData->user_address = $request->user_address;
            }

            if (isset($request->user_state)) {
                $reviewData->user_state = $request->user_state;
            }

            if (isset($request->agree)) {
                $reviewData->self_consent = $request->agree;
            }

            if (isset($request->nickname)) {
                $reviewData->nickname = $request->nickname;
            }

            if (isset($request->post_date)) {
                $reviewData->post_date = $request->post_date;
            }

            if (isset($request->post_time)) {
                $reviewData->post_time = $request->post_time;
            }

            if (isset($request->location)) {
                $reviewData->user_country = $request->location;
            }

            if (isset($request->real)) {
                $reviewData->show_realname = $request->real;
            }

            $reviewData->profile_id = $request->profile_id;
            $reviewData->category_id = $request->category_id;
            $reviewData->review_description = $request->review;
            $reviewData->type = $request->type;
            $reviewData->user_name = Session::get('login_username');
            $reviewData->user_id = Session::get('login_user_id');
            $reviewData->user_email = Session::get('login_email');
            $reviewData->from_date = $request->from_date;
            $reviewData->to_date = $request->to_date;

            if ($reviewData->save()) {
                $path = public_path('users_reviews_docs');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $folderName =  'users_reviews_docs' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
                if (!File::isDirectory($folderName)) {
                    File::makeDirectory($folderName, 0755, true, true);
                }

                if ($request->file('doc') != NULL) {
                    $ext = strtolower($request->file('doc')->getClientOriginalExtension());
                    $reviewDoc = 'review_' . Session::get('login_user_id') . '_' . time() . '.' . $ext;
                    $request->file('doc')->move($folderName, $reviewDoc);
                    $filePath = $folderName . '/' . $reviewDoc;
                    Review::where('id', $reviewData->id)->update(['doc_name' =>  $filePath]);
                }

                if ($request->file('updated_img') != NULL) {
                    $ext = strtolower($request->file('updated_img')->getClientOriginalExtension());
                    $reviewUpdated = 'review_profile_' . Session::get('login_user_id') . '_' . time() . '.' . $ext;
                    $request->file('updated_img')->move($folderName, $reviewUpdated);
                    $filePath = $folderName . '/' . $reviewUpdated;
                    Review::where('id', $reviewData->id)->update(['updated_img' =>  $filePath]);
                }
                return response()->json(['status' => 1, 'msg' => __('messages.Review_added')]);
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
            }
        } catch (Exception $e) {
            \Log::error('submitReview failed: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')], 500);
        }
    }

    function removeReview(Request $request)
    {
        $userId = Session::get('login_user_id');
        if (empty($userId)) {
            return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
        }

        $update = Review::where('id', $request->review_id)
            ->where('user_id', $userId)
            ->update(['is_delete' => 1]);
        if ($update) {
            return response()->json(['status' => 1, 'msg' => __('messages.Review_deleted')]);
        } else {
            return response()->json(['status' => 0, 'error' => __('messages.Someting_went_wrong')]);
        }
    }

    public function getReviewUpdateView(Request $request)
    {
        $userId = Session::get('login_user_id');
        if (empty($userId)) {
            return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
        }

        $data['reviewData'] = Review::select("reviews.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title", "categories.es_category_title", "sub_categories.es_sub_category_title")
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('categories', 'categories.id', '=', 'reviews.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
            ->where("reviews.id", $request->review_id)
            ->where('reviews.user_id', $userId)
            ->where('reviews.is_delete', 0)
            ->first();

        if (!$data['reviewData']) {
            return response()->json(['status' => 0, 'msg' => 'Not found'], 404);
        }

        return response()->json(['status' => 1, 'data' => $data]);
    }

    function updateReview(Request $request)
    {
        try {
            $userId = Session::get('login_user_id');
            if (empty($userId)) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
            }

            $request->validate([
                'review_id' => 'required|integer',
                'udoc' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
                'updated_img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            ]);

            $owned = Review::where('id', $request->review_id)->where('user_id', $userId)->where('is_delete', 0)->first();
            if (!$owned) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 403);
            }

            $review_id = $request->review_id;
            $reviewUpdate = array(
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'review_description' => $request->review,
                'type' => $request->type,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'star_ratings' => $request->rating_star,
                'user_country' => $request->location,
            );

            if (isset($request->agree)) {
                $reviewUpdate['self_consent'] = $request->agree;
            } else {
                $reviewUpdate['self_consent'] = 0;
            }

            if (isset($request->real)) {
                $reviewUpdate['show_realname'] = $request->real;
            } else {
                $reviewUpdate['show_realname'] = 0;
            }

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $folderName =  'users_reviews_docs' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
            if (!File::isDirectory($folderName)) {
                File::makeDirectory($folderName, 0755, true, true);
            }

            if ($request->file('udoc') != NULL) {
                $ext = strtolower($request->file('udoc')->getClientOriginalExtension());
                $reviewDoc = 'review_' . $userId . '_' . time() . '.' . $ext;
                $request->file('udoc')->move($folderName, $reviewDoc);
                $filePath = $folderName . '/' . $reviewDoc;
                $reviewUpdate['doc_name'] =  $filePath;
            }

            if ($request->file('updated_img') != NULL) {
                $ext = strtolower($request->file('updated_img')->getClientOriginalExtension());
                $reviewProfileDoc = 'review_profile_' . $userId . '_' . time() . '.' . $ext;
                $request->file('updated_img')->move($folderName, $reviewProfileDoc);
                $filePathProfile = $folderName . '/' . $reviewProfileDoc;
                $reviewUpdate['updated_img'] =  $filePathProfile;
            }

            $review = Review::where('id', $review_id)->where('user_id', $userId)->update($reviewUpdate);

            if ($review) {
                return response()->json(['status' => 1, 'msg' => __('messages.Review_Updated')]);
            }
            return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
        } catch (\Exception $e) {
            \Log::error('updateReview failed: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')], 500);
        }
    }

    function setCurrentTimeSession(Request $request)
    {
        // var_dump($request->all());
        Session::put('currentTime', $request->current_time);
    }

    public function getSubcategory(Request $request)
    {
        $subCat = SubCategory::where('sub_categories.category_id', $request->category_id)
            ->where('sub_categories.is_delete', 0)
            ->get();

        $result = '';
        if ($subCat) {
            $result .= '<option value="">&nbsp;</option>';
            if (Session::get('locale') == 'en') {
                foreach ($subCat as $cat) {
                    if ($cat->sub_category_title != null) {
                        $result .= '<option value="' . e($cat->id) . '">' . e($cat->sub_category_title) . '</option>';
                    }
                }
            } else {
                foreach ($subCat as $cat) {
                    if ($cat->es_sub_category_title != null) {
                        $result .= '<option value="' . e($cat->id) . '">' . e($cat->es_sub_category_title) . '</option>';
                    }
                }
            }
        }
        return $result;
    }

    function mapLoad()
    {
        return view('googleAutocomplete');
    }
    // rk
    public function review_profile()
    {
        if (Session::get('login_user_id') != '') {

            $data['Category'] = Category::where('is_delete', 0)->get(["category_title", "es_category_title", "id"]);
            $data['ad_settings'] = AdSetting::where('id', 1)->first();
            $data['custom_ads'] = CustomAd::where('is_delete', 0)->get();

            return view('frontend.review_profile', $data, compact('data'));
        } else {
            return redirect()->route('user_login_page');
        }
    }

    public function userLoginPage()
    {
        if (!empty(Session::get('login_user_id'))) {
            return redirect()->route('home');
        }

        return view('frontend.user_login');
    }

    public function user_Login(Request $req)
    {
        // var_dump($req->all());
        // die;
        $email = $req->input('email');
        $pwd = $req->input('password');
        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->is_delete == 1) {
                return response()->json(['status' => 0, 'msg' => __('messages.account_removed')]);
            }
            if (Hash::check($pwd, $user->password)) {
                if ($user->role_id == 2) {
                    // user                   
                    Session::put('login_username', $user->name . ' ' . $user->lname);
                    Session::put('login_user_id', $user->id);
                    Session::put('login_user_role', $user->role_id);
                    Session::put('login_email', $user->email);
                    Session::put('login_fname', $user->name);
                    Session::put('login_lname', $user->lname);
                    Session::put('login_gender', $user->gender);
                    Session::put('login_nickname', $user->nickname);
                    Session::put('login_dob', $user->dob);
                    Session::put('login_country', $user->country_name);

                    if (Session::get('locale') == 'en') {

                        return response()->json(['status' => 1, 'msg' => 'Welcome' . ' ' . $user->name . ' ' . $user->lname]);
                    } else {

                        return response()->json(['status' => 1, 'msg' => 'Bienvenid@' . ' ' . $user->name . ' ' . $user->lname]);
                    }


                    // return response()->json(['status' => 1, 'msg' => $welcome . ' ' . $user->name . ' ' . $user->lname]);
                    // return redirect('/');
                } else {
                    return redirect('/');
                }
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.Wrong_email')]);
            }
        } else {
            // not register user 
            return response()->json(['status' => 0, 'msg' => __('messages.Wrong_email')]);
        }
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:250',
                'lname' => 'required|string|max:250',
                'dob' => 'required',
                'nickname' => 'required',
                'gender' => 'required',
                'terms' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ];

            // Require reCAPTCHA when configured (and always outside local if missing → fail closed via rule)
            if (!empty(config('services.recaptcha.secret')) || !app()->environment('local')) {
                $rules['g-recaptcha-response'] = ['required', new ReCaptcha];
            }

            $validator = Validator::make($request->all(), $rules);

            if (!$validator->passes()) {
                return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
            } else {

                $userData = new User();
                $userData->name = $request->name;
                $userData->lname = $request->lname;
                $userData->dob = $request->dob;
                $userData->nickname = $request->nickname;
                $userData->gender = $request->gender;
                $userData->email = $request->email;
                $userData->terms = $request->terms;
                $userData->country_name = $request->country_name;
                $userData->password = Hash::make($request->password);
                $userData->role_id = 2;
                $userData->save();

                if ($userData) {
                    // upload file logic
                    $path = public_path('users_pics');
                    //create folder for new tutor add
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0755, true, true);
                    }

                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $folderName =  'users_pics' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
                    // var_dump($folderName);
                    if (!File::isDirectory($folderName)) {
                        File::makeDirectory($folderName, 0755, true, true);
                    }

                    if ($request->file('userpic') != NULL) {
                        $pic_user = 'user_' . '_' . time() . '.' . $request->file('userpic')->extension();
                        $request->file('userpic')->move($folderName, $pic_user);
                    } else {
                        $pic_user = NULL;
                    }

                    if ($request->file('avatar_pic') != NULL) {
                        $pic_avatar = 'user_avatar_' . '_' . time() . '.' . $request->file('avatar_pic')->extension();
                        $request->file('avatar_pic')->move($folderName, $pic_avatar);
                    } else {
                        $pic_avatar = NULL;
                    }

                    // update uploaded files name to reviews table
                    if ($pic_user != NULL) {
                        $user_Pic_Path = $folderName . '/' . $pic_user;
                    } else {
                        $user_Pic_Path = NULL;
                    }

                    //avatar pic 
                    if ($pic_avatar != NULL) {
                        $avatar_Pic_Path = $folderName . '/' . $pic_avatar;
                    } else {
                        $avatar_Pic_Path = NULL;
                    }

                    $updateUser = User::where('id', $userData->id)->update(['user_pic' =>  $user_Pic_Path, 'avatar_pic' =>  $avatar_Pic_Path]);

                    // send email to user as per language selection
                    $toemail = $request->email;
                    $toname = $request->name . ' ' . $request->lname;
                    $joinDate = $request->reg_date;
                    $this->activationMailSend([
                        'to' => [['email' => $toemail, 'name' => $toname]],
                        'templateId' => Session::get('locale') == 'en' ? 5 : 6,
                        'params' => [
                            'name' => $toname,
                            'user_email' => $toemail,
                            'join_date' => $joinDate,
                        ],
                    ]);

                    return response()->json(['status' => 1, 'msg' => __('messages.successfully_registered')]);
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function fetchCategory(Request $request)
    {
        $data['Category'] = Category::where('is_delete', 0)->where("id", $request->categories_id)
            ->get(["category_title", "es_category_title", "id"]);

        return response()->json($data);
    }

    public function fetchSubCategory(Request $request)
    {
        $data['subCategory'] = SubCategory::where('is_delete', 0)->where("category_id", $request->categories_id)
            ->get(["sub_category_title", "es_sub_category_title", "id"]);

        return response()->json($data);
    }

    // create profile 
    public function register_reviewprofile(Request $request)
    {
        if (Profile::where('profile_name', '=', $request->name)->where('category_id', $request->category_id)->where('sub_category_id', $request->sub_category_id)->where('location', $request->address_address)->where('country', $request->country)->where('is_delete', 0)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error',  __('messages.Profile_Name_taken'));
            // ->with('error', 'Profile name already taken');
        } else if ($request->name == "") {
            return redirect()->back()->withInput($request->input())->with('error',  __('messages.fill_out_all'));
        } else {

            $profileData = new Profile;
            if (isset($request->mobile_number)) {
                $profileData->mobile_number = $request->country_code . $request->mobile_number;
            }

            if (isset($request->user_email)) {
                $profileData->user_email = $request->user_email;
            }
            $profileData->profile_name = $request->name;
            $profileData->category_id = $request->category_id;
            $profileData->sub_category_id = $request->sub_category_id;
            $profileData->location = $request->address_address;
            $profileData->user_id = Session::get('login_user_id');
            $profileData->address_latitude = $request->address_latitude;
            $profileData->address_longitude = $request->address_longitude;

            // $array_country = explode(',', $request->address_address);
            $profileData->country = $request->country;

            $save = $profileData->save();

            // $profiles_save = Profile::create([
            //     'profile_name' => $request->name,
            //     'mobile_number' => $request->country_code . $request->mobile_number,
            //     'category_id' => $request->category_id,
            //     'sub_category_id' => $request->sub_category_id,
            //     'location' => $request->address_address,
            //     'user_email' => $request->user_email,
            //     'user_id' => Session::get('login_user_id'),
            //     'address_latitude' => $request->address_latitude,
            //     'address_longitude' => $request->address_longitude,

            // ]);

            if ($profileData->save()) {
                $path = public_path('users_profile');
                //create folder for new tutor add
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $folderName = 'users_profile' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
                // var_dump($folderName);
                if (!File::isDirectory($folderName)) {
                    File::makeDirectory($folderName, 0755, true, true);
                }

                if ($request->file('profile_pic') != NULL) {
                    $profilePic = 'profile_' . Session::get('login_user_id') . '_' . time() . '.' . $request->file('profile_pic')->extension();
                    $request->file('profile_pic')->move($folderName, $profilePic);
                } else {
                    $profilePic = NULL;
                }

                if ($request->file('cover_pic') != NULL) {
                    $ProfileCoverpic = 'cover_' . Session::get('login_user_id') . '_' . time() . '.' . $request->file('cover_pic')->extension();
                    $request->file('cover_pic')->move($folderName, $ProfileCoverpic);
                } else {
                    $ProfileCoverpic = NULL;
                }
                // update uploaded files name to reviews table
                if ($profilePic == NULL) {
                    $profilePath = $profilePic;
                } else {
                    $profilePath = $folderName . '/' . $profilePic;
                }

                if ($ProfileCoverpic == NULL) {
                    $coverpicPath = $ProfileCoverpic;
                } else {
                    $coverpicPath = $folderName . '/' . $ProfileCoverpic;
                }
                // $coverpicPath = $folderName . '/' . $ProfileCoverpic;

                // $profilePath = $folderName . '/' . $profilePic;

                $updateProfile = Profile::where('id', $profileData->id)->update(['profile_pic' =>  $profilePath, 'cover_pic' => NULL]);
                return redirect()->route('profiledetails', ['id' => $profileData->id]);
            }
        }
        return redirect('/');
    }

    // email send    
    public function activationMailSend($requestBody)
    {
        $this->lastMailError = null;
        $payload = is_array($requestBody) ? $requestBody : json_decode($requestBody, true);
        if (!is_array($payload)) {
            $this->lastMailError = 'Invalid email payload.';
            Log::error('Brevo email payload is invalid JSON.');
            return false;
        }

        $apiKey = trim((string) config('services.brevo.key'));
        if ($apiKey === '') {
            $this->lastMailError = 'BREVO_API_KEY is not configured on this server.';
            Log::warning($this->lastMailError);
            return false;
        }

        // Always build local HTML so we do not depend on Brevo template IDs existing.
        $composed = $this->composeMailContent($payload);
        if ($composed === null) {
            return false;
        }

        // Prefer REST API key (xkeysib-...) — not blocked by SMTP authorized IPs.
        if (str_starts_with($apiKey, 'xkeysib-')) {
            return $this->sendBrevoApiHtml($composed['to'], $composed['toName'], $composed['subject'], $composed['html'], $apiKey);
        }

        // SMTP keys work with Brevo SMTP relay (subject to authorized IP list).
        if (str_starts_with($apiKey, 'xsmtpsib-')) {
            return $this->sendBrevoSmtpHtml($composed['to'], $composed['toName'], $composed['subject'], $composed['html'], $apiKey);
        }

        $this->lastMailError = 'BREVO_API_KEY must start with xkeysib- (API) or xsmtpsib- (SMTP).';
        Log::error($this->lastMailError);
        return false;
    }

    protected function composeMailContent(array $payload): ?array
    {
        $to = $payload['to'][0]['email'] ?? null;
        $toName = $payload['to'][0]['name'] ?? $to;
        $params = $payload['params'] ?? [];
        $templateId = (int) ($payload['templateId'] ?? 0);

        if (empty($to)) {
            $this->lastMailError = 'Missing email recipient.';
            Log::error($this->lastMailError);
            return null;
        }

        $view = 'emails.welcome';
        $subject = config('app.name');
        switch ($templateId) {
            case 3:
                $view = 'emails.password_reset';
                $subject = __('messages.reset_password');
                break;
            case 4:
                $view = 'emails.contact';
                $subject = 'Contact: ' . ($params['subject'] ?? config('app.name'));
                break;
            case 5:
            case 6:
                $view = 'emails.welcome';
                $subject = 'Welcome to ' . config('app.name');
                break;
        }

        try {
            $html = view($view, $params)->render();
        } catch (\Throwable $e) {
            $this->lastMailError = 'Email template render failed: ' . $e->getMessage();
            Log::error($this->lastMailError);
            return null;
        }

        return [
            'to' => $to,
            'toName' => $toName,
            'subject' => $subject,
            'html' => $html,
        ];
    }

    protected function sendBrevoApiHtml(string $to, string $toName, string $subject, string $html, string $apiKey)
    {
        $fromEmail = config('services.brevo.from_address');
        $fromName = config('services.brevo.from_name');
        if (empty($fromEmail)) {
            $this->lastMailError = 'MAIL_FROM_ADDRESS is not configured.';
            Log::error($this->lastMailError);
            return false;
        }

        $requestBody = json_encode([
            'sender' => [
                'name' => $fromName,
                'email' => $fromEmail,
            ],
            'to' => [[
                'email' => $to,
                'name' => $toName,
            ]],
            'subject' => $subject,
            'htmlContent' => $html,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'api-key: ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $this->lastMailError = 'Brevo curl error: ' . curl_error($ch);
            Log::error($this->lastMailError);
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            $this->lastMailError = 'Brevo API error HTTP ' . $httpCode . ': ' . $result;
            Log::error('Brevo API error', [
                'http_code' => $httpCode,
                'response' => $result,
            ]);
            return false;
        }

        Log::info('Brevo email sent', ['to' => $to, 'subject' => $subject, 'response' => $result]);
        return true;
    }

    protected function sendBrevoSmtpHtml(string $to, string $toName, string $subject, string $html, string $smtpKey)
    {
        $smtpUser = config('services.brevo.smtp_user');
        if (empty($smtpUser)) {
            $this->lastMailError = 'BREVO_SMTP_USER / MAIL_USERNAME is required when using a Brevo SMTP key.';
            Log::error($this->lastMailError);
            return false;
        }

        try {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => config('services.brevo.smtp_host', 'smtp-relay.brevo.com'),
                'mail.mailers.smtp.port' => (int) config('services.brevo.smtp_port', 587),
                'mail.mailers.smtp.encryption' => 'tls',
                'mail.mailers.smtp.username' => $smtpUser,
                'mail.mailers.smtp.password' => $smtpKey,
                'mail.from.address' => config('services.brevo.from_address'),
                'mail.from.name' => config('services.brevo.from_name'),
            ]);

            app()->forgetInstance('mail.manager');
            Mail::clearResolvedInstances();

            Mail::html($html, function ($message) use ($to, $toName, $subject) {
                $message->to($to, $toName)->subject($subject);
            });

            Log::info('Brevo SMTP email sent', ['to' => $to, 'subject' => $subject]);
            return true;
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'Unauthorized IP address')) {
                $this->lastMailError = 'Brevo blocked this server IP (Unauthorized IP). Authorize the server IP in Brevo → SMTP & API → Authorized IPs, or set BREVO_API_KEY to an API key starting with xkeysib-.';
            } else {
                $this->lastMailError = 'Brevo SMTP send failed: ' . $msg;
            }
            Log::error($this->lastMailError);
            return false;
        }
    }

    function setPasswordView($token)
    {
        $requestData = PasswordRequest::where('token', $token)
            ->where('is_expired', 0)
            ->first();

        if (!$requestData) {
            return redirect()->route('home')->with('message', __('messages.link_expired'));
        }

        if (!empty($requestData->expires_at) && now()->greaterThan($requestData->expires_at)) {
            $requestData->is_expired = 1;
            $requestData->save();
            return redirect()->route('home')->with('message', __('messages.link_expired'));
        }

        $data['User'] = DB::table('users')->where('role_id', 2)->where('id', $requestData->user_id)->first();
        if (!$data['User']) {
            return redirect()->route('home')->with('message', __('messages.link_expired'));
        }
        $data['request_id'] = $requestData->id;
        $data['token'] = $token;
        return view('frontend.setpassword', compact('data'));
    }

    function forgetPasswordRequest(Request $request)
    {
        $email = $request->input('email');
        $results = DB::table('users')->where('role_id', 2)->where('email', $email)->where('is_delete', 0)->first();

        // Always return the same message to avoid user enumeration
        $genericOk = ['status' => 1, 'msg' => __('messages.Please_login')];

        if (!$results) {
            return response()->json($genericOk);
        }

        $token = bin2hex(random_bytes(32));
        $PasswordResetData = PasswordRequest::create([
            'user_id' => $results->id,
            'email_id' => $email,
            'token' => $token,
            'is_expired' => 0,
            'expires_at' => now()->addHour(),
        ]);
        if ($PasswordResetData) {
            $msg1 = __('messages.received_request');
            $link = url('/user/set_password/' . $token);
            $name = ucwords($results->name . ' ' . $results->lname);
            $requestBody = [
                'to' => [['email' => $email, 'name' => $name]],
                'templateId' => 3,
                'params' => [
                    'name' => $name,
                    'link' => $link,
                    'sub_msg1' => $msg1,
                ],
            ];
            $sent = $this->activationMailSend($requestBody);
            if (!$sent) {
                Log::error('Password reset email failed to send', [
                    'email' => $email,
                    'error' => $this->lastMailError,
                ]);
                return response()->json([
                    'status' => 0,
                    'msg' => config('app.debug')
                        ? ($this->lastMailError ?: __('messages.Someting_went_wrong'))
                        : __('messages.Someting_went_wrong'),
                ]);
            }
            return response()->json($genericOk);
        }

        return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
    }

    function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'newpassword' => 'required|string|min:6',
        ]);

        $reset = PasswordRequest::where('token', $request->token)
            ->where('is_expired', 0)
            ->first();

        if (!$reset) {
            return response()->json(['status' => 0, 'msg' => __('messages.link_expired')]);
        }

        if (!empty($reset->expires_at) && now()->greaterThan($reset->expires_at)) {
            $reset->is_expired = 1;
            $reset->save();
            return response()->json(['status' => 0, 'msg' => __('messages.link_expired')]);
        }

        // Ensure hidden form user_id matches the token's user
        if (!empty($request->user_id) && (int) $request->user_id !== (int) $reset->user_id) {
            return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
        }

        $pwd = Hash::make($request->newpassword);
        $user = User::where('id', $reset->user_id)->update(['password' => $pwd]);
        if ($user) {
            PasswordRequest::where('id', $reset->id)->update(['is_expired' => 1]);
            return response()->json(['status' => 1, 'msg' => __('messages.Password_Updated')]);
        }

        return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
    }

    function sendContactEmail(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250',
                'subject' => 'required|string|max:250',
                'message' => 'required|string|max:5000',
            ];

            // Same reCAPTCHA policy as registration: required when configured / fail closed outside local
            if (!empty(config('services.recaptcha.secret')) || !app()->environment('local')) {
                $rules['g-recaptcha-response'] = ['required', new ReCaptcha];
            }

            $validator = Validator::make($request->all(), $rules, [
                'g-recaptcha-response.required' => __('messages.recaptcha_required'),
            ]);

            if ($validator->fails()) {
                return redirect(route('contact') . '/#contact_us')
                    ->withErrors($validator)
                    ->withInput();
            }

            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $message = $request->message;
            $toemail = "info@quejasyelogios.com";
            $toname = "Admin";
            $sent = $this->activationMailSend([
                'to' => [['email' => $toemail, 'name' => $toname]],
                'templateId' => 4,
                'params' => [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                ],
            ]);
            if (!$sent) {
                Log::error('Contact email failed to send', ['error' => $this->lastMailError]);
                return redirect(route('contact') . '/#contact_us')
                    ->with('error', __('messages.Someting_went_wrong'))
                    ->withInput();
            }

            return redirect(route('contact') . '/#contact_us')->with('success', __('messages.Thank_You'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('messages.Someting_went_wrong'));
        }
    }

    function createNewCatgoryAndSubcategory(Request $request)
    {
        try {
            if (Session::get('locale') == 'en') {
                if ($request->category_title == "") {
                    return response()->json(['status' => 0, 'msg' => __('messages.fill_out')]);
                } else if (Category::where('category_title', '=', trim($request->category_title))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 0, 'msg' => __('messages.Category_taken')]);
                }

                if ($request->sub_category_name == "") {
                    return response()->json(['status' => 2, 'msg' => __('messages.fill_out')]);
                } else if (SubCategory::where('sub_category_title', '=', trim($request->sub_category_name))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 2, 'msg' => __('messages.Subcategory_taken')]);
                }
            } else {
                if ($request->category_title == "") {
                    return response()->json(['status' => 0, 'msg' => __('messages.fill_out')]);
                } else if (Category::where('es_category_title', '=', trim($request->category_title))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 0, 'msg' => __('messages.Category_taken')]);
                }
                if ($request->sub_category_name == "") {
                    return response()->json(['status' => 2, 'msg' => __('messages.fill_out')]);
                } else if (SubCategory::where('es_sub_category_title', '=', trim($request->sub_category_name))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 2, 'msg' => __('messages.Subcategory_taken')]);
                }
            }

            $catData = new Category;
            if (Session::get('locale') == 'en') {
                $catData->category_title = trim($request->category_title);
            } else {
                $catData->es_category_title = trim($request->category_title);
            }
            if ($catData->save()) {
                $subCatData = new SubCategory;
                if (Session::get('locale') == 'en') {
                    $subCatData->sub_category_title = trim($request->sub_category_name);
                } else {
                    $subCatData->es_sub_category_title = trim($request->sub_category_name);
                }
                $subCatData->category_id = $catData->id;

                if ($subCatData->save()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.Category_Subcategory_Successfully')]);
                }
            }
        } catch (Exception $e) {
            // return $this->sendError($e->getMessage());
            dd($e->getMessage());
        }
    }

    function createNewSubcategory(Request $request)
    {
        try {
            if (Session::get('locale') == 'en') {

                if ($request->sub_category_name == "") {
                    return response()->json(['status' => 0, 'msg' => __('messages.fill_out')]);
                } else if (SubCategory::where('sub_category_title', '=', trim($request->sub_category_name))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 0, 'msg' => __('messages.Subcategory_taken')]);
                }
            } else {
                if ($request->sub_category_name == "") {
                    return response()->json(['status' => 0, 'msg' => __('messages.fill_out')]);
                } else if (SubCategory::where('es_sub_category_title', '=', trim($request->sub_category_name))->where('is_delete', 0)->exists()) {
                    return response()->json(['status' => 0, 'msg' => __('messages.Subcategory_taken')]);
                }
            }

            $subCatData = new SubCategory;
            if (Session::get('locale') == 'en') {
                $subCatData->sub_category_title = trim($request->sub_category_name);
            } else {
                $subCatData->es_sub_category_title = trim($request->sub_category_name);
            }

            $subCatData->category_id = $request->category_title_id;

            if ($subCatData->save()) {
                return response()->json(['status' => 1, 'msg' => __('messages.Subcategory_Successfully')]);
            }
        } catch (Exception $e) {
            // return $this->sendError($e->getMessage());
            dd($e->getMessage());
        }
    }

    public function getUserUpdateView(Request $request)
    {
        // var_dump($request->user_id);
        $data['userDetails'] = User::where('id', $request->user_id)->first();
        return response()->json(['status' => 1, 'data' => $data]);
    }

    function userProfileUpdate(Request $request)
    {
        try {
            $sessionUserId = Session::get('login_user_id');
            if (empty($sessionUserId) || (int) $sessionUserId !== (int) $request->user_id) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
            }

            $request->validate([
                'userpic' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
                'avatar_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            ]);

            $userData = User::where('id', $sessionUserId)->first();
            if (!$userData) {
                return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')]);
            }

            if (User::where('email', '=', $request->email)->where('id', '!=', $sessionUserId)->exists()) {
                return response()->json(['status' => 2, 'msg' => __('messages.Email_taken')]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'lname' => 'required',
                    'dob' => 'required',
                    'nickname' => 'required',
                    'gender' => 'required',
                    'country_name' => 'required',
                ]);
                if (!$validator->passes()) {
                    return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
                } else {

                    $profileUpdate = array(
                        'name' =>  $request->name,
                        'lname' =>  $request->lname,
                        'dob' =>  $request->dob,
                        'nickname' =>  $request->nickname,
                        'gender' =>  $request->gender,
                        'country_name' =>  $request->country_name,
                        'email' =>  $request->email,
                    );

                    if (!empty($request->password)) {
                        $profileUpdate['password'] = Hash::make($request->password);
                    }

                    $profile = User::where('id', $sessionUserId)->update($profileUpdate);

                    if ($profile) {
                        $path = public_path('users_pics');
                        if (!File::isDirectory($path)) {
                            File::makeDirectory($path, 0755, true, true);
                        }

                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $folderName =  'users_pics' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
                        if (!File::isDirectory($folderName)) {
                            File::makeDirectory($folderName, 0755, true, true);
                        }

                        if ($request->file('userpic') != NULL) {
                            $ext = strtolower($request->file('userpic')->getClientOriginalExtension());
                            $pic_user = 'user_' . '_' . time() . '.' . $ext;
                            $request->file('userpic')->move($folderName, $pic_user);
                            $user_Pic_Path = $folderName . '/' . $pic_user;
                            User::where('id', $sessionUserId)->update(['user_pic' =>  $user_Pic_Path]);
                        }

                        if ($request->file('avatar_pic') != NULL) {
                            $ext = strtolower($request->file('avatar_pic')->getClientOriginalExtension());
                            $pic_avatar = 'user_avatar_' . '_' . time() . '.' . $ext;
                            $request->file('avatar_pic')->move($folderName, $pic_avatar);
                            $user_avatar_Path = $folderName . '/' . $pic_avatar;
                            User::where('id', $sessionUserId)->update(['avatar_pic' =>  $user_avatar_Path]);
                        }

                        Session::put('login_username', $request->name . ' ' . $request->lname);
                        Session::put('login_email', $request->email);
                        Session::put('login_fname', $request->name);
                        Session::put('login_lname', $request->lname);
                        Session::put('login_gender', $request->gender);
                        Session::put('login_nickname', $request->nickname);
                        Session::put('login_dob', $request->dob);
                        Session::put('login_country', $request->country_name);
                        return response()->json(['status' => 1, 'msg' => __('messages.updated_profile')]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('userProfileUpdate failed: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => __('messages.Someting_went_wrong')], 500);
        }
    }

    function termsAndConditions()
    {
        return view('frontend.terms');
    }

    function getVisIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    // function getCountryName()
    // {
    //     $vis_ip = $this->getVisIPAddr();

    //     $ipdat = @json_decode(file_get_contents(
    //         "http://www.geoplugin.net/json.gp?ip=" . $vis_ip
    //     ));
    //     Session::put('visitor_country', $ipdat->geoplugin_countryName);
    // }

    function getCountryName()
    {
        $vis_ip = $this->getVisIPAddr();

        $response = @file_get_contents("http://ip-api.com/json/{$vis_ip}");

        if ($response !== false) {
            $ipdat = json_decode($response, true);

            if (isset($ipdat['country'])) {
                Session::put('visitor_country', $ipdat['country']);
                return;
            }
        }

        Session::put('visitor_country', 'Unknown');
    }

    // function getCountry()
    // {
    //     $vis_ip = $this->getVisIPAddr();

    //     $ipdat = @json_decode(file_get_contents(
    //         "http://www.geoplugin.net/json.gp?ip=" . $vis_ip
    //     ));

    //     Session::put('visitor_country', $ipdat->geoplugin_countryName);

    //     echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n";
    //     echo 'City Name: ' . $ipdat->geoplugin_city . "\n";
    //     echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n";
    //     echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n";
    //     echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n";
    //     echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n";
    //     echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n";
    //     echo 'Timezone: ' . $ipdat->geoplugin_timezone;

    //     $clientIP = \Request::ip();
    //     echo $clientIP;
    // }

    function getCountry()
    {
        $vis_ip = $this->getVisIPAddr(); // your method to get visitor IP

        $response = @file_get_contents("http://ip-api.com/json/{$vis_ip}?fields=status,country,city,continent,lat,lon,currency,timezone,query");

        if ($response === false) {
            echo "Could not fetch location data.";
            return;
        }

        $ipdat = json_decode($response);

        if ($ipdat && $ipdat->status === "success") {
            Session::put('visitor_country', $ipdat->country);

            echo 'Country Name: ' . $ipdat->country . "\n";
            echo 'City Name: ' . ($ipdat->city ?? 'N/A') . "\n";
            echo 'Continent: ' . ($ipdat->continent ?? 'N/A') . "\n";
            echo 'Latitude: ' . $ipdat->lat . "\n";
            echo 'Longitude: ' . $ipdat->lon . "\n";
            echo 'Currency: ' . ($ipdat->currency ?? 'N/A') . "\n";
            echo 'Timezone: ' . $ipdat->timezone . "\n";

            $clientIP = request()->ip(); // Laravel helper
            echo 'Client IP: ' . $clientIP . "\n";
            echo $vis_ip;
        } else {
            echo "Unable to detect location.";
        }
    }

    function setCurrentLanguage(Request $request)
    {
        // var_dump($request->all());
        // die;
        App::setLocale($request->lang);
        Session::put('locale', $request->lang);
    }

    function privacyPolicy()
    {
        return view('frontend.privacy');
    }
}
