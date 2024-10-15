<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Cast;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Common;
use App\Models\Download;
use App\Models\Language;
use App\Models\Producer;
use App\Models\Rent_Price_List;
use App\Models\Rent_Transction;
use App\Models\Season;
use App\Models\TVShow;
use App\Models\TVShow_Video;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

// Video Type = 1-Video, 2-Show, 3-Language, 4-Category, 5-Upcoming, 6-Channel, 7-Kids
// Video Upload Type = server_video, external, youtube
// Subtitle Type = server_video, external
// Trailer Type = server_video, external, youtube

class UpcomingTVShowController extends Controller
{
    private $folder_content = "content";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {

            $params['data'] = [];
            $params['type'] = Type::where('type', 5)->get();
            $params['releases_type'] = Type::whereIn('type', [2, 6, 7])->get();
            $params['channel_list'] = Channel::where('status', 1)->latest()->get();
            if ($request->ajax()) {

                $input_search = $request['input_search'];
                $input_type = $request['input_type'];
                $input_rent = $request['input_rent'];
                if ($input_search != null && isset($input_search)) {

                    if ($input_type != 0 && $input_rent == 0) {
                        $data = TVShow::where('name', 'LIKE', "%{$input_search}%")->where('video_type', 5)->where('type_id', $input_type)
                            ->with('type')->orderBy('id', 'desc')->latest()->get();
                    } else if ($input_type != 0 && $input_rent == 1) {
                        $data = TVShow::where('name', 'LIKE', "%{$input_search}%")->where('video_type', 5)->where('type_id', $input_type)->where('is_rent', 1)
                            ->with('type')->orderBy('id', 'desc')->latest()->get();
                    } else if ($input_type == 0 && $input_rent == 1) {
                        $data = TVShow::where('name', 'LIKE', "%{$input_search}%")->where('video_type', 5)->with('type')->where('is_rent', 1)->orderBy('id', 'desc')->latest()->get();
                    } else {
                        $data = TVShow::where('name', 'LIKE', "%{$input_search}%")->where('video_type', 5)->with('type')->orderBy('id', 'desc')->latest()->get();
                    }
                } else {

                    if ($input_type != 0 && $input_rent == 0) {
                        $data = TVShow::where('video_type', 5)->where('type_id', $input_type)->with('type')->orderBy('id', 'desc')->latest()->get();
                    } else if ($input_type != 0 && $input_rent == 1) {
                        $data = TVShow::where('video_type', 5)->where('type_id', $input_type)->where('is_rent', 1)->with('type')->orderBy('id', 'desc')->latest()->get();
                    } else if ($input_type == 0 && $input_rent == 1) {
                        $data = TVShow::where('video_type', 5)->with('type')->where('is_rent', 1)->orderBy('id', 'desc')->latest()->get();
                    } else {
                        $data = TVShow::where('video_type', 5)->with('type')->orderBy('id', 'desc')->latest()->get();
                    }
                }

                $this->common->imageNameToUrl($data, 'thumbnail', $this->folder_content, 'portrait');

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $statistics = __('label.statistics');
                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $tvshow_delete = __('label.delete_tvshow');

                        $delete = '<form onsubmit="return confirm(\'' . $tvshow_delete . '\');" method="POST"  action="' . route('upcomingtvshow.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a href="' . route('upcomingtvshow.details', [$row->id]) . '" class="edit-delete-btn mr-2" title="' . $statistics . '">';
                        $btn .= '<i class="fa-solid fa-chart-line fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= '<a href="' . route('upcomingtvshow.edit', [$row->id]) . '" class="edit-delete-btn mr-2" title="' . $edit . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            $show = __('label.show');
                            return "<button type='button' id='$row->id' onclick='change_status($row->id, $row->status)' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>" . $show . "</button>";
                        } else {
                            $hide = __('label.hide');
                            return "<button type='button' id='$row->id' onclick='change_status($row->id, $row->status)' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 20px; outline: none;border-radius: 5px;cursor: pointer;'>" . $hide . "</button>";
                        }
                    })
                    ->addColumn('episode', function ($row) {
                        $episode_list = __('label.episode_list');
                        $btn = '<a href="' . route("upcomingtvshow.episode.index", $row->id) . '" class="btn text-white p-1 font-weight-bold" style="background:#4e45b8;">' . $episode_list . '</a> ';
                        return $btn;
                    })
                    ->addColumn('releases', function ($row) {

                        $releases = __('label.releases');
                        $releases_now = __('label.releases_now');
                        return "<button class='btn releases_modal' data-toggle='modal' data-target='#ReleasesModal' data-id='$row->id' style='background:#4e45b8; font-weight:bold; border: none; color: white; padding: 5px 20px; outline: none;border-radius: 5px;cursor: pointer;' title='" . $releases_now . "'>" . $releases . "</button>";
                    })
                    ->rawColumns(['action', 'episode', 'status', 'releases'])
                    ->make(true);
            }
            return view('admin.upcoming_tv_show.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create()
    {
        try {

            $params['type'] = Type::where('type', 5)->get();
            $params['category'] = Category::get();
            $params['language'] = Language::get();
            $params['cast'] = Cast::get();
            $params['producer'] = Producer::get();
            $params['rent_price_list'] = Rent_Price_List::get();

            return view('admin.upcoming_tv_show.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'type_id' => 'required',
                'category_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'description' => 'required',
                'is_title' => 'required',
                'is_like' => 'required',
                'is_comment' => 'required',
                'is_rent' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $category_id = implode(',', $request->category_id);
            $language_id = implode(',', $request->language_id);
            $cast_id = implode(',', $request->cast_id);

            $TVShow = new TVShow();
            $TVShow->type_id = $request->type_id;
            $TVShow->video_type = 5;
            $TVShow->channel_id = 0;
            $TVShow->producer_id = isset($request->producer_id) ? $request->producer_id : 0;
            $TVShow->category_id = $category_id;
            $TVShow->language_id = $language_id;
            $TVShow->cast_id = $cast_id;
            $TVShow->name = $request->name;
            $TVShow->description = $request->description;
            $TVShow->is_title = $request->is_title;
            $TVShow->is_like = $request->is_like;
            $TVShow->is_comment = $request->is_comment;
            $TVShow->status = 1;
            $TVShow->total_view = 0;
            $TVShow->total_like = 0;
            $TVShow->release_date = "";
            if ($request->release_date) {
                $TVShow->release_date = $request->release_date;
            }
            // Trailer
            $TVShow->trailer_type = isset($request->trailer_type) ? $request->trailer_type : '';
            if ($request->trailer_type == "server_video") {
                $TVShow->trailer_url = isset($request->trailer) ? $request->trailer : '';
            } else {
                $TVShow->trailer_url = isset($request->trailer_url) ? $request->trailer_url : '';
            }
            $org_name = $request->file('thumbnail');
            $org_name1 = $request->file('landscape');
            $TVShow->thumbnail = "";
            $TVShow->landscape = "";
            if ($org_name != null && isset($org_name)) {

                $TVShow->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'up_show_');
            } elseif ($request->thumbnail_tmdb) {

                $url = $request->thumbnail_tmdb;
                $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'up_show_ep_');
                $TVShow->thumbnail = $S_Name;
            }
            if ($org_name1 != null && isset($org_name1)) {

                $TVShow->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'up_show_');
            } elseif ($request->landscape_tmdb) {

                $url = $request->landscape_tmdb;
                $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'up_show_ep_');
                $TVShow->landscape = $S_Name;
            }
            // Rent
            $TVShow->is_rent = $request->is_rent;
            $TVShow->price = isset($request->price) ? $request->price : 0;
            $TVShow->rent_day = isset($request->rent_day) ? $request->rent_day : 0;

            if ($TVShow->save()) {

                // Send Notification
                $imageURL = $this->common->getImage($this->folder_content, $TVShow->thumbnail, 'normal');
                $noti_array = array(
                    'id' => $TVShow->id,
                    'name' => $TVShow->name,
                    'image' => $imageURL,
                    'type_id' => $TVShow->type_id,
                    'video_type' => $TVShow->video_type,
                    'upcoming_type' => 0,
                    'description' => String_Cut($TVShow->description, 90),
                );
                $this->common->sendNotification($noti_array);

                return response()->json(array('status' => 200, 'success' => __('label.controller.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function edit($id)
    {
        try {
            $params['result'] = TVshow::where('id', $id)->first();

            $this->common->imageNameToUrl(array($params['result']), 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl(array($params['result']), 'landscape', $this->folder_content, 'landscape');

            $params['type'] = Type::where('type', 5)->get();
            $params['category'] = Category::get();
            $params['language'] = Language::get();
            $params['cast'] = Cast::get();
            $params['producer'] = Producer::get();
            $params['rent_price_list'] = Rent_Price_List::get();

            return view('admin.upcoming_tv_show.edit', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'type_id' => 'required',
                'category_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'description' => 'required',
                'is_title' => 'required',
                'is_like' => 'required',
                'is_comment' => 'required',
                'is_rent' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $category_id = implode(',', $request->category_id);
            $language_id = implode(',', $request->language_id);
            $cast_id = implode(',', $request->cast_id);

            $TVShow = TVShow::where('id', $request->id)->first();
            if (isset($TVShow->id)) {
                $TVShow->type_id = $request->type_id;
                $TVShow->video_type = 5;
                $TVShow->channel_id = 0;
                $TVShow->producer_id = isset($request->producer_id) ? $request->producer_id : 0;
                $TVShow->category_id = $category_id;
                $TVShow->language_id = $language_id;
                $TVShow->cast_id = $cast_id;
                $TVShow->name = $request->name;
                $TVShow->description = $request->description;
                $TVShow->is_title = $request->is_title;
                $TVShow->is_like = $request->is_like;
                $TVShow->is_comment = $request->is_comment;
                $TVShow->release_date = "";
                if ($request->release_date) {
                    $TVShow->release_date = $request->release_date;
                }

                // Trailer
                $TVShow->trailer_type = isset($request->trailer_type) ? $request->trailer_type : '';
                if ($request->trailer_type == "server_video") {

                    if ($request->trailer_type == $request->old_trailer_type) {

                        if ($request->trailer) {
                            $TVShow->trailer_url = $request->trailer;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_trailer);
                        }
                    } else {
                        if ($request->trailer) {
                            $TVShow->trailer_url = $request->trailer;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_trailer));
                        } else {
                            $TVShow->trailer_url = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_trailer));

                    $TVShow->trailer_url = "";
                    if ($request->trailer_url) {
                        $TVShow->trailer_url = $request->trailer_url;
                    }
                }

                $org_name = $request->file('thumbnail');
                $org_name1 = $request->file('landscape');
                if ($org_name != null && isset($org_name)) {

                    $TVShow->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'up_show_');
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_thumbnail));
                } elseif ($request->thumbnail_tmdb) {

                    $url = $request->thumbnail_tmdb;
                    $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'up_show_ep_');
                    $TVShow->thumbnail = $S_Name;
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_thumbnail));
                }
                if ($org_name1 != null && isset($org_name1)) {

                    $TVShow->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'up_show_');
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_landscape));
                } elseif ($request->landscape_tmdb) {

                    $url = $request->landscape_tmdb;
                    $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'up_show_ep_');
                    $TVShow->landscape = $S_Name;
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_landscape));
                }

                // Rent
                $TVShow->is_rent = $request->is_rent;
                $TVShow->price = isset($request->price) ? $request->price : 0;
                $TVShow->rent_day = isset($request->rent_day) ? $request->rent_day : 0;

                if ($TVShow->save()) {
                    return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
                }
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function destroy($id)
    {
        try {

            $TVShow = TVShow::where('id', $id)->first();
            if ($TVShow->delete()) {

                $this->common->deleteImageToFolder($this->folder_content, $TVShow->thumbnail);
                $this->common->deleteImageToFolder($this->folder_content, $TVShow->landscape);
                $this->common->deleteImageToFolder($this->folder_content, $TVShow->trailer_url);

                $TVShowVideo = TVShow_Video::where('show_id', $TVShow->id)->get();
                foreach ($TVShowVideo as $key => $value) {

                    $this->common->deleteImageToFolder($this->folder_content, $value->thumbnail);
                    $this->common->deleteImageToFolder($this->folder_content, $value->landscape);
                    $this->common->deleteImageToFolder($this->folder_content, $value->video_320);
                    $this->common->deleteImageToFolder($this->folder_content, $value->video_480);
                    $this->common->deleteImageToFolder($this->folder_content, $value->video_720);
                    $this->common->deleteImageToFolder($this->folder_content, $value->video_1080);
                    $this->common->deleteImageToFolder($this->folder_content, $value->subtitle_1);
                    $this->common->deleteImageToFolder($this->folder_content, $value->subtitle_2);
                    $this->common->deleteImageToFolder($this->folder_content, $value->subtitle_3);
                    $value->delete();
                }
                return redirect()->route('upcomingtvshow.index')->with('success', __('label.controller.data_delete_successfully'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function show($id)
    {
        try {

            $data = TVShow::where('id', $id)->first();
            if ($data->status == 0) {
                $data->status = 1;
            } elseif ($data->status == 1) {
                $data->status = 0;
            } else {
                $data->status = 0;
            }
            $data->save();
            return response()->json(array('status' => 200, 'success' => __('label.controller.status_changed'), 'id' => $data->id, 'Status_Code' => $data->status));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // TVShow Video
    public function TVShowIndex(Request $request, $id)
    {
        try {

            $params['tvshow_id'] = $id;
            $params['season'] = Season::get();

            $input_search = $request['input_search'];
            $input_season = $request['input_season'];
            if ($input_search != null && isset($input_search)) {
                if ($input_season != 0) {
                    $params['data'] = TVShow_Video::where('name', 'LIKE', "%{$input_search}%")->where('show_id', $id)->where('season_id', $input_season)->with('season')->orderBy('sortable', 'asc')->latest()->paginate(15);
                } else {
                    $params['data'] = TVShow_Video::where('name', 'LIKE', "%{$input_search}%")->where('show_id', $id)->with('season')->orderBy('sortable', 'asc')->latest()->paginate(15);
                }
            } else {
                if ($input_season != 0) {
                    $params['data'] = TVShow_Video::where('show_id', $id)->where('season_id', $input_season)->with('season')->orderBy('sortable', 'asc')->latest()->paginate(15);
                } else {
                    $params['data'] = TVShow_Video::where('show_id', $id)->with('season')->orderBy('sortable', 'asc')->latest()->paginate(15);
                }
            }

            $this->common->imageNameToUrl($params['data'], 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($params['data'], 'landscape', $this->folder_content, 'landscape');
            $this->common->videoNameToUrl($params['data'], 'video_320', $this->folder_content);

            return view('admin.upcoming_tv_show.ep_index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowAdd($id)
    {
        try {
            $params['tvshow_id'] = $id;
            $params['season'] = Season::get();

            return view('admin.upcoming_tv_show.ep_add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowSave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'show_id' => 'required',
                'season_id' => 'required',
                'video_upload_type' => 'required',
                'subtitle_type' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'video_duration' => 'required|after_or_equal:00:00:01',
                'description' => 'required',
                'is_premium' => 'required',
                'is_title' => 'required',
                'is_like' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }
            if ($request->video_upload_type == "server_video") {
                $validator1 = Validator::make($request->all(), [
                    'video_320' => 'required',
                ]);
            } else {
                $validator1 = Validator::make($request->all(), [
                    'video_url_320' => 'required',
                ]);
            }
            if ($validator1->fails()) {
                $errs1 = $validator1->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs1));
            }

            $TvShowVideo = new TVShow_Video();
            $TvShowVideo->show_id = $request->show_id;
            $TvShowVideo->season_id = $request->season_id;
            $TvShowVideo->name = $request->name;
            $TvShowVideo->description = $request->description;
            $TvShowVideo->video_upload_type = $request->video_upload_type;
            $TvShowVideo->video_duration = Time_To_Milliseconds($request->video_duration);
            $TvShowVideo->is_premium = $request->is_premium;
            $TvShowVideo->is_title = $request->is_title;
            $TvShowVideo->is_like = $request->is_like;
            if ($request->video_upload_type == "server_video") {
                $TvShowVideo->is_download = $request->is_download;
            } else {
                $TvShowVideo->is_download = 0;
            }
            // Image
            $org_name = $request->file('thumbnail');
            $org_name1 = $request->file('landscape');
            $TvShowVideo->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'up_show_ep_');
            $TvShowVideo->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'up_show_ep_');
            // Video (320, 480, 720, 1080)
            if ($request->video_upload_type == "server_video") {

                $TvShowVideo->video_320 = isset($request->video_320) ? $request->video_320 : '';
                $TvShowVideo->video_480 = isset($request->video_480) ? $request->video_480 : '';
                $TvShowVideo->video_720 = isset($request->video_720) ? $request->video_720 : '';
                $TvShowVideo->video_1080 = isset($request->video_1080) ? $request->video_1080 : '';

                $array = explode('.', $request->video_320);
                $TvShowVideo->video_extension = end($array);
            } else {

                $TvShowVideo->video_320 = isset($request->video_url_320) ? $request->video_url_320 : '';
                $TvShowVideo->video_480 = isset($request->video_url_480) ? $request->video_url_480 : '';
                $TvShowVideo->video_720 = isset($request->video_url_720) ? $request->video_url_720 : '';
                $TvShowVideo->video_1080 = isset($request->video_url_1080) ? $request->video_url_1080 : '';

                $array = explode('.', $request->video_url_320);
                $array1 = explode('?', end($array));
                if (isset($array1) && $array1 != null) {
                    $TvShowVideo->video_extension = isset($array1) ? reset($array1) : "";
                } else {
                    $TvShowVideo->video_extension = "";
                }
            }
            // Subtitle_1_2_3
            $TvShowVideo->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
            $TvShowVideo->subtitle_lang_1 = isset($request->subtitle_lang_1) ? $request->subtitle_lang_1 : '';
            $TvShowVideo->subtitle_lang_2 = isset($request->subtitle_lang_2) ? $request->subtitle_lang_2 : '';
            $TvShowVideo->subtitle_lang_3 = isset($request->subtitle_lang_3) ? $request->subtitle_lang_3 : '';
            if ($request->subtitle_type == "server_video") {
                $TvShowVideo->subtitle_1 = isset($request->subtitle_1) ? $request->subtitle_1 : '';
                $TvShowVideo->subtitle_2 = isset($request->subtitle_2) ? $request->subtitle_2 : '';
                $TvShowVideo->subtitle_3 = isset($request->subtitle_3) ? $request->subtitle_3 : '';
            } else {
                $TvShowVideo->subtitle_1 = isset($request->subtitle_url_1) ? $request->subtitle_url_1 : '';
                $TvShowVideo->subtitle_2 = isset($request->subtitle_url_2) ? $request->subtitle_url_2 : '';
                $TvShowVideo->subtitle_3 = isset($request->subtitle_url_3) ? $request->subtitle_url_3 : '';
            }
            $TvShowVideo->total_like = 0;
            $TvShowVideo->total_view = 0;
            $TvShowVideo->sortable = 1;
            $TvShowVideo->status = 1;

            if ($TvShowVideo->save()) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowedit($show_id, $id)
    {
        try {
            $params['tvshow_id'] = $show_id;
            $params['season'] = Season::get();

            $params['result'] = TVShow_Video::where('id', $id)->first();
            $this->common->imageNameToUrl(array($params['result']), 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl(array($params['result']), 'landscape', $this->folder_content, 'landscape');

            return view('admin.upcoming_tv_show.ep_edit', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'show_id' => 'required',
                'season_id' => 'required',
                'video_upload_type' => 'required',
                'subtitle_type' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                'video_duration' => 'required|after_or_equal:00:00:01',
                'description' => 'required',
                'is_premium' => 'required',
                'is_title' => 'required',
                'is_like' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }
            if ($request->video_upload_type != "server_video") {
                $validator1 = Validator::make($request->all(), [
                    'video_url_320' => 'required',
                ]);
                if ($validator1->fails()) {
                    $errs1 = $validator1->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs1));
                }
            }

            $TVShowVideo = TVShow_Video::where('id', $request->id)->first();
            if (isset($TVShowVideo->id)) {

                $TVShowVideo->name = $request->name;
                $TVShowVideo->show_id = $request->show_id;
                $TVShowVideo->season_id = $request->season_id;
                $TVShowVideo->is_premium = $request->is_premium;
                $TVShowVideo->is_title = $request->is_title;
                $TVShowVideo->is_like = $request->is_like;
                $TVShowVideo->video_duration = Time_To_Milliseconds($request->video_duration);
                $TVShowVideo->description = $request->description;
                $TVShowVideo->video_upload_type = $request->video_upload_type;
                if ($request->video_upload_type == "server_video") {
                    $TVShowVideo->is_download = $request->is_download;
                } else {
                    $TVShowVideo->is_download = 0;
                }
                // Videos
                if ($request->video_upload_type == "server_video") {

                    if ($request->video_upload_type == $request->old_video_upload_type) {
                        if ($request->video_320) {
                            $array = explode('.', $request->video_320);
                            $TVShowVideo->video_extension = end($array);

                            $TVShowVideo->video_320 = $request->video_320;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_320);
                        }
                        if ($request->video_480) {

                            $TVShowVideo->video_480 = $request->video_480;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_480);
                        }
                        if ($request->video_720) {

                            $TVShowVideo->video_720 = $request->video_720;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_720);
                        }
                        if ($request->video_1080) {

                            $TVShowVideo->video_1080 = $request->video_1080;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_1080);
                        }
                    } else {
                        if ($request->video_320) {

                            $array = explode('.', $request->video_320);
                            $TVShowVideo->video_extension = end($array);

                            $TVShowVideo->video_320 = $request->video_320;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_320);
                        } else {
                            $TVShowVideo->video_320 = "";
                        }
                        if ($request->video_480) {

                            $TVShowVideo->video_480 = $request->video_480;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_480);
                        } else {
                            $TVShowVideo->video_480 = "";
                        }
                        if ($request->video_720) {

                            $TVShowVideo->video_720 = $request->video_720;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_720);
                        } else {
                            $TVShowVideo->video_720 = "";
                        }
                        if ($request->video_1080) {

                            $TVShowVideo->video_1080 = $request->video_1080;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_video_1080);
                        } else {
                            $TVShowVideo->video_1080 = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, $request->old_video_320);
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_video_480);
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_video_720);
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_video_1080);

                    $TVShowVideo->video_480 = "";
                    $TVShowVideo->video_720 = "";
                    $TVShowVideo->video_1080 = "";

                    if ($request->video_url_320) {

                        $array = explode('.', $request->video_url_320);
                        $array1 = explode('?', end($array));
                        if (isset($array1) && $array1 != null) {
                            $TVShowVideo->video_extension = isset($array1) ? reset($array1) : "";
                        } else {
                            $TVShowVideo->video_extension = "";
                        }

                        $TVShowVideo->video_320 = $request->video_url_320;
                    }
                    if ($request->video_url_480) {
                        $TVShowVideo->video_480 = $request->video_url_480;
                    }
                    if ($request->video_url_720) {
                        $TVShowVideo->video_720 = $request->video_url_720;
                    }
                    if ($request->video_url_1080) {
                        $TVShowVideo->video_1080 = $request->video_url_1080;
                    }
                }

                // Subtitle
                $TVShowVideo->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                $TVShowVideo->subtitle_lang_1 = isset($request->subtitle_lang_1) ? $request->subtitle_lang_1 : '';
                $TVShowVideo->subtitle_lang_2 = isset($request->subtitle_lang_2) ? $request->subtitle_lang_2 : '';
                $TVShowVideo->subtitle_lang_3 = isset($request->subtitle_lang_3) ? $request->subtitle_lang_3 : '';
                if ($request->subtitle_type == "server_video") {

                    if ($request->subtitle_type == $request->old_subtitle_type) {
                        if ($request->subtitle_1) {
                            $TVShowVideo->subtitle_1 = $request->subtitle_1;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_1);
                        }
                        if ($request->subtitle_2) {
                            $TVShowVideo->subtitle_2 = $request->subtitle_2;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_2);
                        }
                        if ($request->subtitle_3) {
                            $TVShowVideo->subtitle_3 = $request->subtitle_3;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_3);
                        }
                    } else {
                        if ($request->subtitle_1) {
                            $TVShowVideo->subtitle_1 = $request->subtitle_1;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_1);
                        } else {
                            $TVShowVideo->subtitle_1 = "";
                        }
                        if ($request->subtitle_2) {
                            $TVShowVideo->subtitle_2 = $request->subtitle_2;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_2);
                        } else {
                            $TVShowVideo->subtitle_2 = "";
                        }
                        if ($request->subtitle_3) {
                            $TVShowVideo->subtitle_3 = $request->subtitle_3;
                            $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_3);
                        } else {
                            $TVShowVideo->subtitle_3 = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_1);
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_2);
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_subtitle_3);

                    $TVShowVideo->subtitle_1 = "";
                    $TVShowVideo->subtitle_2 = "";
                    $TVShowVideo->subtitle_3 = "";

                    if ($request->subtitle_1) {
                        $TVShowVideo->subtitle_1 = $request->subtitle_url_1;
                    }
                    if ($request->subtitle_2) {
                        $TVShowVideo->subtitle_2 = $request->subtitle_url_2;
                    }
                    if ($request->subtitle_3) {
                        $TVShowVideo->subtitle_3 = $request->subtitle_url_3;
                    }
                }
                // Image
                $org_name = $request->file('thumbnail');
                $org_name1 = $request->file('landscape');
                if ($org_name != null) {
                    $TVShowVideo->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'up_show_ep_');
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_thumbnail);
                }
                if ($org_name1 != null) {
                    $TVShowVideo->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'up_show_ep_');
                    $this->common->deleteImageToFolder($this->folder_content, $request->old_landscape);
                }

                if ($TVShowVideo->save()) {
                    return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
                }
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowDelete($show_id, $id)
    {
        try {

            $TVShowVideo = TVShow_Video::where('id', $id)->first();
            if ($TVShowVideo->delete()) {

                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->thumbnail);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->landscape);

                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->video_320);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->video_480);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->video_720);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->video_1080);

                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->subtitle_1);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->subtitle_2);
                $this->common->deleteImageToFolder($this->folder_content, $TVShowVideo->subtitle_3);

                return redirect()->route('upcomingtvshow.episode.index', ['id' => $show_id])->with('success', __('label.controller.data_delete_successfully'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function TVShowSortable(Request $request)
    {
        try {

            $ids = $request['ids'];
            if (isset($ids) && $ids != null && $ids != "") {

                $id_array = explode(',', $ids);
                for ($i = 0; $i < count($id_array); $i++) {
                    TVShow_Video::where('id', $id_array[$i])->update(['sortable' => $i + 1]);
                }
            }
            return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function upcomingTVShowDetails($id)
    {
        try {

            $params['video_id'] = $id;
            $params['data'] = TVShow::where('id', $id)->first();
            $params['total_rent_earning'] = 0;
            if ($params['data']['is_rent'] == 1) {
                $params['total_rent_earning'] = Rent_Transction::where('video_type', $params['data']['video_type'])->where('sub_video_type', 2)->where('video_id', $id)->sum('price');
            }
            $params['total_bookmark'] = Bookmark::where('video_type', $params['data']['video_type'])->where('sub_video_type', 2)->where('video_id', $id)->count();
            $params['total_comment'] = Comment::where('video_type', $params['data']['video_type'])->where('sub_video_type', 2)->where('video_id', $id)->count();
            $params['total_download'] = Download::where('video_type', $params['data']['video_type'])->where('sub_video_type', 2)->where('video_id', $id)->count();

            return view('admin.upcoming_tv_show.details', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function showReleases(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'type_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $check_type = Type::where('id', $request['type_id'])->first();
            if ($check_type['type'] == 6) {

                $validator1 = Validator::make($request->all(), [
                    'channel_id' => 'required',
                ]);
                if ($validator1->fails()) {
                    $errs1 = $validator1->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs1));
                }
            }

            $TVShow = TVShow::where('id', $request['id'])->first();
            if (isset($TVShow['id'])) {

                $TVShow['type_id'] = $request['type_id'];
                $TVShow['video_type'] = $check_type['type'];

                $TVShow['channel_id'] = 0;
                if ($check_type['type'] == 6) {
                    $TVShow['channel_id'] = $request['channel_id'];
                }

                if ($TVShow->save()) {
                    return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
                }
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
