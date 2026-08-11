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
use Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class CustomAdsController extends Controller
{
    // rk

}
