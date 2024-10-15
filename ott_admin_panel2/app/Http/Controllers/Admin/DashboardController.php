<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Common;
use App\Models\User;
use App\Models\Page;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Language;
use App\Models\Package;
use App\Models\Rent_Transction;
use App\Models\Transction;
use App\Models\TVShow;
use App\Models\Video;
use Exception;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    private $folder_content = "content";
    private $folder_artist = "artist";
    private $folder_user = "user";
    private $folder_category = "category";
    private $folder_channel = "channel";
    private $folder_language = "language";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index()
    {
        try {

            // Package Expiry
            $this->common->package_expiry();

            // First Card
            $params['UserCount'] = User::count();
            $params['VideoCount'] = Video::count();
            $params['TVShowCount'] = TVShow::count();
            $params['ChannelCount'] = Channel::count();
            $params['CastCount'] = Cast::count();
            // Second Card
            $params['CurrentMounthCount'] = Transction::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('price');
            $params['CurrentMounthRentCount'] = Rent_Transction::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('price');
            $params['PackageCount'] = Package::count();
            $params['TransactionCount'] = Transction::sum('price');
            $params['RentTransactionCount'] = Rent_Transction::sum('price');

            // User Statistice
            $user_data = [];
            $user_month = [];
            $d = date('t', mktime(0, 0, 0, date('m'), 1, date('Y')));
            for ($i = 1; $i < 13; $i++) {
                $Sum = User::whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->count();
                $user_data['sum'][] = (int) $Sum;
            }
            for ($i = 1; $i <= $d; $i++) {

                $Sum = User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->whereDay('created_at', $i)->count();
                $user_month['sum'][] = (int) $Sum;
            }
            $params['user_year'] = json_encode($user_data);
            $params['user_month'] = json_encode($user_month);

            // Package Statistice
            $subscription = Package::get();
            $pack_data = [];
            foreach ($subscription as $row) {

                $sum = array();
                for ($i = 1; $i < 13; $i++) {

                    $Sum = Transction::where('package_id', $row->id)->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->sum('price');
                    $sum[] = (int) $Sum;
                }
                $pack_data['label'][] = $row->name;
                $pack_data['sum'][] = $sum;
            }
            $params['package'] = json_encode($pack_data);

            // Rent Earning Statistice
            $rent_data = [];
            for ($i = 1; $i < 13; $i++) {
                $Sum = Rent_Transction::whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->sum('price');
                $rent_data['sum'][] = (int) $Sum;
            }
            $params['rent_earning'] = json_encode($rent_data);

            // Most View Video & TVShow
            $params['top_video_view'] = Video::orderBy('total_view', 'desc')->where('total_view', '!=', 0)->where('status', 1)->take(5)->get();
            $params['top_tvshow_view'] = TVShow::orderBy('total_view', 'desc')->where('total_view', '!=', 0)->where('status', 1)->take(5)->get();
            $this->common->imageNameToUrl($params['top_video_view'], 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($params['top_tvshow_view'], 'thumbnail', $this->folder_content, 'portrait');

            // Most Like Video & TVShow
            $params['top_video_like'] = Video::orderBy('total_like', 'desc')->where('total_like', '!=', 0)->where('status', 1)->take(5)->get();
            $params['top_tvshow_like'] = TVShow::orderBy('total_like', 'desc')->where('total_like', '!=', 0)->where('status', 1)->take(5)->get();
            $this->common->imageNameToUrl($params['top_video_like'], 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($params['top_tvshow_like'], 'thumbnail', $this->folder_content, 'portrait');

            // Best Category
            $params['best_category'] = Category::orderBy('id', 'desc')->take(8)->get();
            $this->common->imageNameToUrl($params['best_category'], 'image', $this->folder_category, 'normal');

            // Best Language
            $params['best_language'] = Language::orderBy('id', 'desc')->take(8)->get();
            $this->common->imageNameToUrl($params['best_language'], 'image', $this->folder_language, 'normal');

            // Best Channel
            $params['best_channel'] = Channel::orderBy('id', 'desc')->take(8)->get();
            $this->common->imageNameToUrl($params['best_channel'], 'portrait_img', $this->folder_channel, 'portrait');

            return view('admin.dashboard', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function Page()
    {
        try {
            $currentURL = URL::current();

            $link_array = explode('/', $currentURL);
            $page = end($link_array);

            $params['result'] = Page::where('page_name', $page)->first();
            if (isset($params['result'])) {

                $params['settings'] = Setting_Data();

                return view('page', $params);
            } else {
                return view('errors.404');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
