<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Channel;
use App\Models\TVShow;
use App\Models\Video;
use Exception;

class DashboardController extends Controller
{
    private $folder_content = "content";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index()
    {
        try {

            $producer = Producer_Data();

            // First Card
            $params['VideoCount'] = Video::where('producer_id', $producer['id'])->count();
            $params['TVShowCount'] = TVShow::where('producer_id', $producer['id'])->count();
            $params['ChannelCount'] = Channel::count();

            // Most View Video & TVShow
            $params['top_video_view'] = Video::where('producer_id', $producer['id'])->orderBy('total_view', 'desc')->where('total_view', '!=', 0)->where('status', 1)->take(5)->get();
            $params['top_tvshow_view'] = TVShow::where('producer_id', $producer['id'])->orderBy('total_view', 'desc')->where('total_view', '!=', 0)->where('status', 1)->take(5)->get();
            $this->common->imageNameToUrl($params['top_video_view'], 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($params['top_tvshow_view'], 'thumbnail', $this->folder_content, 'portrait');

            // Most Like Video & TVShow
            $params['top_video_like'] = Video::where('producer_id', $producer['id'])->orderBy('total_like', 'desc')->where('total_like', '!=', 0)->where('status', 1)->take(5)->get();
            $params['top_tvshow_like'] = TVShow::where('producer_id', $producer['id'])->orderBy('total_like', 'desc')->where('total_like', '!=', 0)->where('status', 1)->take(5)->get();
            $this->common->imageNameToUrl($params['top_video_like'], 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($params['top_tvshow_like'], 'thumbnail', $this->folder_content, 'portrait');

            return view('producer.dashboard', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
