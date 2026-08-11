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
use Exception;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    function login()
    {
        if (Session::get('user_role') == 1) {
            // $reviewsData = Review::where('is_delete', 0)->orderBy('id', 'DESC')->get();
            // // paginate(20);   
            // $data['reviewsData'] = $reviewsData;
            // return view('admin/reviewslist', compact('data'));
            $data['users'] = User::where('role_id', 2)->orderBy('users.id', 'desc')->get();
            return view('admin.userslistview', compact('data'));
        } else {
            return view('login');
        }
    }

    function dashboard()
    {
        $data[] = "";
        return view('admin/dashboard', compact('data'));
    }

    function reviewsListView()
    {
        $reviewsData = Review::where('is_delete', 0)->orderBy('id', 'DESC')->get();
        // paginate(20);   
        $data['reviewsData'] = $reviewsData;
        return view('admin/reviewslist', compact('data'));
    }

    function reviewsEditView(Request $request)
    {
        $reviewsData = Review::where('id', $request->id)->get();
        $data['reviewDetails'] = $reviewsData;
        // var_dump($reviewsData);
        // die;
        return view('admin/revieweditdetails', compact('data'));
    }

    function reviewUpdate(Request $request)
    {
        // var_dump($request->id);
        try {
            $update = Review::where('id', $request->id)->update(['review_description' => $request->review_description, 'star_ratings' => $request->rating_star]);
            if ($update) {
                // return redirect("admin/reviews")->with('success', 'Review updated successfully');
                return redirect()->route('adminprofiledetailsview', ['id' => $request->profile_id])->with('success', 'Review updated successfully');;
            } else {
                return redirect()->back()->with('error', 'Something went wrong please try again');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    function reviewDelete(Request $request)
    {
        $reviewData = Review::find($request->deleteId);
        $reviewData['is_delete'] = 1;
        if ($reviewData->save() == true) {
            // return redirect()->intended('admin/reviews');
            return redirect()->back()->with('success', 'Review removed.');
        } else {
            return redirect()->back()->with('error', 'Review data not remove.');
        }
    }

    public function autocompleteCategory(Request $request)
    {
        // $data = Category::select("category_title")
        //     ->where("category_title", "LIKE", "%{$request->query}%")
        //     ->where("is_delete", 0)
        //     ->get();
        // return response()->json($data);
        $category = [];
        if ($request->has('q')) {
            $search = $request->q;
            $category = Category::select("id", "category_title")->where('category_title', 'LIKE', "%$search%")->get();
        }
        return response()->json($category);
    }

    public function reviewsListAjax(Request $request)
    {
        $reviewsData = Review::where('category_id', $request->id)->where('is_delete', 0)->orderBy('id', 'DESC')->get();
        // paginate(20);   
        $data['reviewsData'] = $reviewsData;

        return view('admin.reviews_list_ajax', compact('data'))->render();
    }

    public function userLogin(Request $req)
    {
        $email = $req->input('email');
        $pwd = $req->input('password');
        $user = User::where('email', $email)->where('role_id', 1)->first();
        if ($user) {
            if (Hash::check($pwd, $user->password)) {
                // Clear any legacy plaintext "remember me" cookies
                if (isset($_COOKIE['w_user_login'])) {
                    setcookie('w_user_login', '', time() - 3600, '/');
                }
                if (isset($_COOKIE['w_userpassword'])) {
                    setcookie('w_userpassword', '', time() - 3600, '/');
                }
                if (isset($_COOKIE['userpassword'])) {
                    setcookie('userpassword', '', time() - 3600, '/');
                }

                if ($user->role_id == 1) {
                    Session::put('username', $user->name);
                    Session::put('user_id', $user->id);
                    Session::put('user_role', $user->role_id);
                    Session::put('email', $user->email);
                    return redirect('admin/users');
                }
            } else {
                return redirect('admin/login')->with('error', __('messages.Wrong_email'));
            }
        } else {
            return redirect('admin/login')->with('error', __('messages.Wrong_email'));
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('admin/login');
    }

    public function update_user_profile(Request $req)
    {
        $first_password = $req->input('password');
        $second_password = $req->input('cpassword');
        $email = $req->input('email');
        $user_id = Session::get('user_id');
        $role_id = Session::get('user_role');

        $pwd = Hash::make($second_password);
        $users = DB::table('users')->where('id', $user_id)->where('role_id', $role_id)->first();
        if ($users) {
            DB::table('users')->where('id', $user_id)->where('role_id', $role_id)->update(['name' => $req->name, 'email' => $email, 'password' => $pwd]);
            Session::put('username', $req->name);
            Session::put('email', $email);
            return redirect('admin/reviews')->with('success', 'Password updated.');
        }
    }

    public function reviewProfiles()
    {
        $reviewsData = Profile::select("profiles.*", "users.name", "users.id as user_id")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.is_delete', 0)
            ->groupBy('profiles.id')
            ->orderBy('profiles.id', 'desc')
            ->get();
        $categoryData = Category::where('is_delete', 0)->get();
        $data['categories'] = $categoryData;
        $data['reviewsData'] = $reviewsData;
        return view('admin/reviewprofileslist', compact('data'));
    }

    public function reviewProfilesListAjax(Request $request)
    {
        $profilesData = "";
        $allProfiles = "";
        $profilesData = Profile::select("profiles.*", "users.name", "users.id as user_id", "categories.category_title", "sub_categories.sub_category_title")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('categories', 'categories.id', '=', 'profiles.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
            ->where('profiles.is_delete', 0);

        $allProfiles = Profile::where('is_delete', 0);

        if (isset($request->cat_id)) {
            if ($request->cat_id != 'all') {
                $profilesData = $profilesData->where('profiles.category_id', $request->cat_id);
                $allProfiles = $allProfiles->where('profiles.category_id', $request->cat_id);
            }
        }

        if (isset($request->subcat_id)) {
            if ($request->subcat_id != 'all') {
                $profilesData = $profilesData->where('profiles.sub_category_id', $request->subcat_id);
                $allProfiles = $allProfiles->where('profiles.sub_category_id', $request->subcat_id);
            }
        }

        if (isset($request->location_name)) {
            $profilesData = $profilesData->where('profiles.location', 'LIKE', "%{$request->location_name}%");
            $allProfiles = $allProfiles->where('profiles.location', 'LIKE', "%{$request->location_name}%");
        }
        if (isset($request->profile_name)) {
            $profilesData = $profilesData->where('profiles.profile_name', 'LIKE', "%{$request->profile_name}%");
            $allProfiles = $allProfiles->where('profiles.profile_name', 'LIKE', "%{$request->profile_name}%");
        }

        $profilesData =  $profilesData->groupBy('profiles.id')->orderBy('profiles.id', 'desc')->get();

        $allProfiles = $allProfiles->get();


        if ($allProfiles->count() > 0) {
            $data['result'] = $allProfiles->count();
        } else {
            $data['result'] = 0;
        }

        $categoryData = Category::where('is_delete', 0)->get();

        $data['categories'] = $categoryData;

        $data['reviewsData'] = $profilesData;

        return view('admin.reviewprofile_list_ajax', compact('data'))->render();
    }

    function profileDetailsView(Request $request)
    {
        // var_dump($request->id);
        // die;
        $profilesData = Profile::select("profiles.*", "users.name", "users.lname", "users.nickname as nick", "categories.category_title", "sub_categories.sub_category_title")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('categories', 'categories.id', '=', 'profiles.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
            ->where("profiles.id", $request->id)
            ->first();
        $data['profilesData'] = $profilesData;

        $reviewData = Review::select("reviews.*", "users.name", "users.lname", "users.nickname as nick", "users.avatar_pic", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title")
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('categories', 'categories.id', '=', 'reviews.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'reviews.sub_category_id')
            ->where("reviews.profile_id", $request->id)
            ->where('reviews.is_delete', 0)
            ->orderBy('reviews.id', 'desc')
            ->get();
        $data['reviewsData'] = $reviewData;
        $verifiedReviews = Review::where("reviews.self_consent", 1)->where("reviews.profile_id", $request->id)->where('reviews.is_delete', 0)->get();
        $unVerifiedReviews = Review::where("reviews.self_consent", 0)->where("reviews.profile_id", $request->id)->where('reviews.is_delete', 0)->get();
        $data['verified'] = $verifiedReviews;
        $data['unverified'] = $unVerifiedReviews;
        return view('admin.profiledetails', compact('data'));
    }

    function usersList()
    {
        $data['users'] = User::where('role_id', 2)->where('is_delete', 0)->orderBy('users.id', 'desc')->get();
        return view('admin.userslistview', compact('data'));
    }

    public function getSubcategory(Request $request)
    {
        $subCat = SubCategory::where('sub_categories.category_id', $request->category_id)
            ->where('sub_categories.is_delete', 0)
            ->get();

        $result = '';
        if ($subCat) {
            $result .= '<option value="all">Show All</option>';
            foreach ($subCat as $cat) {
                $result .= '<option value="' . e($cat->id) . '">' . e($cat->sub_category_title) . '</option>';
            }
        }
        return $result;
    }

    public function profileReviewFilterAjaxCall(Request $request)
    {
        // var_dump($request->all());
        // die;
        $profilesData = Profile::select("profiles.*", "users.name", "categories.category_title", "sub_categories.sub_category_title")
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('categories', 'categories.id', '=', 'profiles.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'profiles.sub_category_id')
            ->where("profiles.id", $request->profileId)
            ->first();
        $data['profilesData'] = $profilesData;

        $reviewData = "";
        $reviewData = Review::select("reviews.*", "users.name", "users.user_pic", "categories.category_title", "sub_categories.sub_category_title")
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

        $reviewData =  $reviewData->get();
        $data['reviewsData'] = $reviewData;
        $data['profilesData'] = $profilesData;

        return view('admin.allreviewslist', compact('data'))->render();
    }

    public function deleteUser(Request $request)
    {
        $userData = User::find($request->deleteId);
        $userData['is_delete'] = 1;
        if ($userData->save() == true) {
            // return redirect()->intended('admin/reviews');
            return redirect()->back()->with('success', 'User removed.');
        } else {
            return redirect()->back()->with('error', 'User data not remove.');
        }
    }

    function userEditView(Request $request)
    {
        $data['userdetails'] = User::where('id', $request->id)->first();
        // var_dump($reviewsData);
        // die;
        return view('admin/useredit', compact('data'));
    }

    function userUpdate(Request $request)
    {
        // var_dump($request->all());
        // die;

        try {
            $userId = $request->id;

            // $userData = User::where('id', $userId)->first();
            if (User::where('email', '=', $request->email)->where('id', '!=', $userId)->exists()) {
                return redirect()->back()->with('error', 'Email has already been taken');
            }

            $userUpdate = array(
                'name' => $request->name,
                'email' => $request->email,
                'lname' =>  $request->lname,
                'dob' =>  $request->dob,
                'nickname' =>  $request->nickname,
                'gender' =>  $request->gender,
                'country_name' =>  $request->country_name,
            );

            if (isset($request->password) && $request->password != NULL) {
                $pwd = Hash::make($request->password);
                $userUpdate['password'] = $pwd;
            }

            $users = User::where('id', $userId)->update($userUpdate);
            // if ($request->hasFile('udoc')) {

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

            if ($request->file('udoc') != NULL) {
                $pic_user = 'user' . '_pic_' . time() . '.' . $request->file('udoc')->extension();
                $user_Pic_Path = $request->file('udoc')->move($folderName, $pic_user);
                $updateUser = User::where('id', $userId)->update(['user_pic' =>  $user_Pic_Path]);
            }

            if ($request->file('avatar_pic') != NULL) {
                $pic_avatar = 'user_avatar_' . '_' . time() . '.' . $request->file('avatar_pic')->extension();
                $request->file('avatar_pic')->move($folderName, $pic_avatar);
                $user_avatar_Path = $folderName . '/' . $pic_avatar;
                $updateUserd = User::where('id', $userId)->update(['avatar_pic' =>  $user_avatar_Path]);
            }
            // }



            if ($users) {
                return redirect("admin/users")->with('success', 'User updated successfully');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong please try again');
        }
    }

    function profileDelete(Request $request)
    {
        // var_dump($request->all());
        // die;
        $reviewProfileData = Profile::where('id', $request->deleteId)->update(['is_delete' => 1]);
        // var_dump($reviewProfileData);
        // die;
        // $reviewProfileData['is_delete'] = 1;
        if ($reviewProfileData) {
            // return redirect()->intended('admin/reviews');
            return redirect()->back()->with('success', 'Profile removed.');
        } else {
            return redirect()->back()->with('error', 'Profile data not remove.');
        }
    }

    function adsSettings()
    {
        $data['showAds'] = AdSetting::where('id', 1)->first();
        return view('admin.adsettings', compact('data'));
    }

    function adsAdd(Request $request)
    {

        try {

            if (isset($request->sp_heading)) {
                $sp_heading = $request->sp_heading;
            } else {
                $sp_heading = NULL;
            }

            if (isset($request->sp_sub_heading)) {
                $sp_sub_heading = $request->sp_sub_heading;
            } else {
                $sp_sub_heading = NULL;
            }

            $adsData = CustomAd::create([
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
                'sp_heading' => $sp_heading,
                'sp_sub_heading' => $sp_sub_heading,
            ]);

            if ($adsData) {
                // upload file logic
                $path = public_path('custom_ads');
                //create folder for new tutor add
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $folderName =  'custom_ads' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
                // var_dump($folderName);
                if (!File::isDirectory($folderName)) {
                    File::makeDirectory($folderName, 0755, true, true);
                }

                if ($request->file('banner_img') != NULL) {
                    $adsImg = 'custom_ads_' . '_' . time() . '.' . $request->file('banner_img')->extension();
                    $request->file('banner_img')->move($folderName, $adsImg);
                } else {
                    $adsImg = NULL;
                }

                // update uploaded files name to reviews table
                if ($adsImg != NULL) {
                    $ads_img_Path = $folderName . '/' . $adsImg;
                } else {
                    $ads_img_Path = NULL;
                }

                // spanish
                if ($request->file('sp_banner_img') != NULL) {
                    $adsImgSp = 'custom_ads_sp' . '_' . time() . '.' . $request->file('sp_banner_img')->extension();
                    $request->file('sp_banner_img')->move($folderName, $adsImgSp);
                } else {
                    $adsImgSp = NULL;
                }

                // update uploaded files name to reviews table
                if ($adsImgSp != NULL) {
                    $ads_img_PathSp = $folderName . '/' . $adsImgSp;
                } else {
                    $ads_img_PathSp = NULL;
                }

                $updateAds = CustomAd::where('id', $adsData->id)->update(['banner_img' =>  $ads_img_Path, 'sp_banner_img' =>  $ads_img_PathSp]);
                return response()->json(['status' => 1, 'msg' => 'Add Created']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    function hideAdsHome(Request $request)
    {
        // var_dump($request->is_hide);
        $updateAds = AdSetting::where('id', 1)->update(['is_hide' => $request->is_hide]);
        if ($updateAds) {
            return response()->json(['status' => 1, 'is_hide' => $request->is_hide, 'msg' => 'Custom Ads Updated successfully']);
        }
    }

    function adsList()
    {
        // adslistview
        $data['customAds'] = CustomAd::where('is_delete', 0)->get();
        return view('admin.adslistview', compact('data'));
    }

    function deleteAd(Request $request)
    {
        $adsData = CustomAd::find($request->deleteId);
        $adsData['is_delete'] = 1;
        if ($adsData->save() == true) {
            // return redirect()->intended('admin/reviews');
            return redirect()->back()->with('success', 'Ad removed.');
        } else {
            return redirect()->back()->with('error', 'Ad not remove.');
        }
    }

    function getAdUpdateView(Request $request)
    {
        $data['adsData'] = CustomAd::where("id", $request->ad_id)->where('is_delete', 0)->first();
        return response()->json(['status' => 1, 'data' => $data]);
    }

    function updateAd(Request $request)
    {
        try {
            $ad_id = $request->ad_id;
            $adUpdate = array(
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
            );

            if (isset($request->sp_heading)) {
                $adUpdate['sp_heading'] = $request->sp_heading;
            }

            if (isset($request->sp_sub_heading)) {
                $adUpdate['sp_sub_heading'] = $request->sp_sub_heading;
            }

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $folderName =  'users_reviews_docs' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
            // var_dump($folderName);
            if (!File::isDirectory($folderName)) {
                File::makeDirectory($folderName, 0755, true, true);
            }

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $folderName =  'custom_ads' . '/' . substr(str_shuffle($permitted_chars), 0, 10) . time();
            // var_dump($folderName);
            if (!File::isDirectory($folderName)) {
                File::makeDirectory($folderName, 0755, true, true);
            }

            if ($request->file('banner_img') != NULL) {
                $adsImg = 'custom_ads_' . '_' . time() . '.' . $request->file('banner_img')->extension();
                $request->file('banner_img')->move($folderName, $adsImg);
                $filePathProfile = $folderName . '/' . $adsImg;
                $adUpdate['banner_img'] =  $filePathProfile;
            }

            if ($request->file('sp_banner_img') != NULL) {
                $adsImgSp = 'custom_ads_sp' . '_' . time() . '.' . $request->file('sp_banner_img')->extension();
                $request->file('sp_banner_img')->move($folderName, $adsImgSp);
                $filePathProfileSp = $folderName . '/' . $adsImgSp;
                $adUpdate['sp_banner_img'] =  $filePathProfileSp;
            }

            $review = CustomAd::where('id', $ad_id)->update($adUpdate);

            if ($review) {
                return response()->json(['status' => 1, 'msg' => 'Ad Updated Successfully']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    function categoryList()
    {
        $data['categories'] = Category::where('is_delete', 0)->get();
        return view('admin.categorylistview', compact('data'));
    }

    function getCategoryView(Request $request)
    {
        $data['catData'] = Category::where("id", $request->cat_id)->first();
        return response()->json(['status' => 1, 'data' => $data]);
    }

    function updateCategory(Request $request)
    {
        try {
            $cat_id = $request->cat_id;
            $adUpdate = array(
                'category_title' => $request->category_title,
                'es_category_title' => $request->es_category_title,
            );

            $review = Category::where('id', $cat_id)->update($adUpdate);

            if ($review) {
                return response()->json(['status' => 1, 'msg' => __('messages.Category_Successfully')]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    function subcategoryList()
    {
        $data['subcategories'] = SubCategory::select("sub_categories.*", "categories.category_title", "categories.es_category_title")
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->where('sub_categories.is_delete', 0)
            ->where('categories.is_delete', 0)
            ->get();

        // SubCategory::where('is_delete', 0)->get();    

        return view('admin.subcategorylistview', compact('data'));
    }

    function getSubCategoryView(Request $request)
    {
        $data['catData'] = SubCategory::where("id", $request->cat_id)->first();
        return response()->json(['status' => 1, 'data' => $data]);
    }

    function updateSubCategory(Request $request)
    {
        try {
            $cat_id = $request->cat_id;
            $adUpdate = array(
                'sub_category_title' => $request->category_title,
                'es_sub_category_title' => $request->es_category_title,
            );

            $review = SubCategory::where('id', $cat_id)->update($adUpdate);

            if ($review) {
                return response()->json(['status' => 1, 'msg' => __('messages.SubCategory_Successfully')]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    function deleteCategory(Request $request)
    {
        if (Profile::where('category_id', $request->deleteId)->where('is_delete', 0)->exists()) {
            return redirect()->back()->with('error', __('messages.delete_category_err'));
        } else {
            $categoryData = Category::where('id', $request->deleteId)->update(['is_delete' => 1]);
            if ($categoryData) {
                $subcategoryData = SubCategory::where('category_id', $request->deleteId)->update(['is_delete' => 1]);
                return redirect()->back()->with('success',  __('messages.delete_category_msg'));
            }
        }
    }

    function deleteSubcategory(Request $request)
    {
        if (Profile::where('sub_category_id', $request->deleteId)->where('is_delete', 0)->exists()) {
            return redirect()->back()->with('error', __('messages.delete_subcategory_err'));
        } else {
            $subcategoryData = SubCategory::where('id', $request->deleteId)->update(['is_delete' => 1]);
            if ($subcategoryData) {
                return redirect()->back()->with('success',  __('messages.delete_subcategory_msg'));
            }
        }
    }
}
