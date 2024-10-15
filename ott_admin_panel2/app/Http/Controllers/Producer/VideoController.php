<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Cast;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Common;
use App\Models\Download;
use App\Models\Language;
use App\Models\Rent_Price_List;
use App\Models\Rent_Transction;
use App\Models\Type;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

// Video Type = 1-Video, 2-Show, 3-Language, 4-Category, 5-Upcoming, 6- Channel, 7- Kids
// Video Upload Type = server_video, external, youtube
// Trailer Type = server_video, external, youtube
// Subtitle Type = server_video, external

class VideoController extends Controller
{
    private $folder_content = "content";
    private $folder_cast = "cast";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {

            $producer = Producer_Data();

            $input_search = $request['input_search'];
            $input_type = $request['input_type'];
            $input_rent = $request['input_rent'];
            if ($input_search != null && isset($input_search)) {

                if ($input_type != 0 && $input_rent == 0) {
                    $video_list = Video::where('producer_id', $producer['id'])->where('name', 'LIKE', "%{$input_search}%")->whereNotIn('video_type', [5, 6, 7])->where('type_id', $input_type)
                        ->with('type')->orderBy('id', 'desc')->paginate(15);
                } else if ($input_type != 0 && $input_rent == 1) {
                    $video_list = Video::where('producer_id', $producer['id'])->where('name', 'LIKE', "%{$input_search}%")->whereNotIn('video_type', [5, 6, 7])->where('type_id', $input_type)->where('is_rent', 1)
                        ->with('type')->orderBy('id', 'desc')->paginate(15);
                } else if ($input_type == 0 && $input_rent == 1) {
                    $video_list = Video::where('producer_id', $producer['id'])->where('name', 'LIKE', "%{$input_search}%")->whereNotIn('video_type', [5, 6, 7])->with('type')->where('is_rent', 1)->orderBy('id', 'desc')->paginate(15);
                } else {
                    $video_list = Video::where('producer_id', $producer['id'])->where('name', 'LIKE', "%{$input_search}%")->whereNotIn('video_type', [5, 6, 7])->with('type')->orderBy('id', 'desc')->paginate(15);
                }
            } else {

                if ($input_type != 0 && $input_rent == 0) {
                    $video_list = Video::where('producer_id', $producer['id'])->whereNotIn('video_type', [5, 6, 7])->where('type_id', $input_type)->with('type')->orderBy('id', 'desc')->paginate(15);
                } else if ($input_type != 0 && $input_rent == 1) {
                    $video_list = Video::where('producer_id', $producer['id'])->whereNotIn('video_type', [5, 6, 7])->where('type_id', $input_type)->where('is_rent', 1)->with('type')->orderBy('id', 'desc')->paginate(15);
                } else if ($input_type == 0 && $input_rent == 1) {
                    $video_list = Video::where('producer_id', $producer['id'])->whereNotIn('video_type', [5, 6, 7])->with('type')->where('is_rent', 1)->orderBy('id', 'desc')->paginate(15);
                } else {
                    $video_list = Video::where('producer_id', $producer['id'])->whereNotIn('video_type', [5, 6, 7])->with('type')->orderBy('id', 'desc')->paginate(15);
                }
            }

            $this->common->imageNameToUrl($video_list, 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl($video_list, 'landscape', $this->folder_content, 'landscape');
            $this->common->videoNameToUrl($video_list, 'video_320', $this->folder_content);

            $type = Type::where('type', 1)->get();

            return view('producer.video.index', ['result' => $video_list, 'type' => $type]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create()
    {
        try {

            $params['type'] = Type::where('type', 1)->get();
            $params['category'] = Category::get();
            $params['language'] = Language::get();
            $params['cast'] = Cast::get();
            $params['rent_price_list'] = Rent_Price_List::get();

            return view('producer.video.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'category_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'type_id' => 'required',
                'video_upload_type' => 'required',
                'trailer_type' => 'required',
                'subtitle_type' => 'required',
                'description' => 'required',
                'video_duration' => 'required|after_or_equal:00:00:01',
                'is_premium' => 'required',
                'is_title' => 'required',
                'is_download' => 'required',
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

            $producer = Producer_Data();

            $category_id = implode(',', $request->category_id);
            $language_id = implode(',', $request->language_id);
            $cast_id = implode(',', $request->cast_id);

            $video = new Video();
            $video->type_id = $request->type_id;
            $video->video_type = 1;
            $video->channel_id = 0;
            $video->producer_id = $producer['id'];
            $video->category_id = $category_id;
            $video->language_id = $language_id;
            $video->cast_id = $cast_id;
            $video->name = $request->name;
            $video->video_upload_type = $request->video_upload_type;
            $video->description = $request->description;
            $video->is_premium = $request->is_premium;
            $video->is_title = $request->is_title;
            if ($request->video_upload_type == "server_video") {
                $video->is_download = $request->is_download;
            } else {
                $video->is_download = 0;
            }
            $video->is_like = $request->is_like;
            $video->is_comment = $request->is_comment;
            $video->total_like = 0;
            $video->total_view = 0;
            $video->status = 1;
            $video->video_duration = Time_To_Milliseconds($request->video_duration);
            $video->release_date = "";
            if ($request->release_date) {
                $video->release_date = $request->release_date;
            }

            // Video (320, 480, 720, 1080)
            if ($request->video_upload_type == "server_video") {

                $video->video_320 = isset($request->video_320) ? $request->video_320 : '';
                $video->video_480 = isset($request->video_480) ? $request->video_480 : '';
                $video->video_720 = isset($request->video_720) ? $request->video_720 : '';
                $video->video_1080 = isset($request->video_1080) ? $request->video_1080 : '';

                $array = explode('.', $request->video_320);
                $video->video_extension = end($array);
            } else {

                $video->video_320 = isset($request->video_url_320) ? $request->video_url_320 : '';
                $video->video_480 = isset($request->video_url_480) ? $request->video_url_480 : '';
                $video->video_720 = isset($request->video_url_720) ? $request->video_url_720 : '';
                $video->video_1080 = isset($request->video_url_1080) ? $request->video_url_1080 : '';

                $array = explode('.', $request->video_url_320);
                $array1 = explode('?', end($array));
                if (isset($array1) && $array1 != null) {
                    $video->video_extension = isset($array1) ? reset($array1) : "";
                } else {
                    $video->video_extension = "";
                }
            }

            // Subtitle_1_2_3
            $video->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
            $video->subtitle_lang_1 = isset($request->subtitle_lang_1) ? $request->subtitle_lang_1 : '';
            $video->subtitle_lang_2 = isset($request->subtitle_lang_2) ? $request->subtitle_lang_2 : '';
            $video->subtitle_lang_3 = isset($request->subtitle_lang_3) ? $request->subtitle_lang_3 : '';
            if ($request->subtitle_type == "server_video") {
                $video->subtitle_1 = isset($request->subtitle_1) ? $request->subtitle_1 : '';
                $video->subtitle_2 = isset($request->subtitle_2) ? $request->subtitle_2 : '';
                $video->subtitle_3 = isset($request->subtitle_3) ? $request->subtitle_3 : '';
            } else {
                $video->subtitle_1 = isset($request->subtitle_url_1) ? $request->subtitle_url_1 : '';
                $video->subtitle_2 = isset($request->subtitle_url_2) ? $request->subtitle_url_2 : '';
                $video->subtitle_3 = isset($request->subtitle_url_3) ? $request->subtitle_url_3 : '';
            }

            // Trailer
            $video->trailer_type = isset($request->trailer_type) ? $request->trailer_type : '';
            if ($request->trailer_type == "server_video") {
                $video->trailer_url = isset($request->trailer) ? $request->trailer : '';
            } else {
                $video->trailer_url = isset($request->trailer_url) ? $request->trailer_url : '';
            }

            $org_name = $request->file('thumbnail');
            $org_name1 = $request->file('landscape');
            $video->thumbnail = "";
            $video->landscape = "";
            if ($org_name != null && isset($org_name)) {

                $video->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'vid_');
            } elseif ($request->thumbnail_tmdb) {

                $url = $request->thumbnail_tmdb;
                $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'vid_');
                $video->thumbnail = $S_Name;
            }
            if ($org_name1 != null && isset($org_name1)) {

                $video->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'vid_');
            } elseif ($request->landscape_tmdb) {

                $url = $request->landscape_tmdb;
                $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'vid_');
                $video->landscape = $S_Name;
            }

            // Rent
            $video->is_rent = $request->is_rent;
            $video->price = isset($request->price) ? $request->price : 0;
            $video->rent_day = isset($request->rent_day) ? $request->rent_day : 0;

            if ($video->save()) {

                // Send Notification
                $imageURL = $this->common->getImage($this->folder_content, $video->thumbnail, 'normal');
                $noti_array = array(
                    'id' => $video->id,
                    'name' => $video->name,
                    'image' => $imageURL,
                    'type_id' => $video->type_id,
                    'video_type' => $video->video_type,
                    'upcoming_type' => 0,
                    'description' => String_Cut($video->description, 90),
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
            $params['result'] = Video::where('id', $id)->first();

            $this->common->imageNameToUrl(array($params['result']), 'thumbnail', $this->folder_content, 'portrait');
            $this->common->imageNameToUrl(array($params['result']), 'landscape', $this->folder_content, 'landscape');

            $params['type'] = Type::where('type', 1)->get();
            $params['category'] = Category::get();
            $params['language'] = Language::get();
            $params['cast'] = Cast::get();
            $params['rent_price_list'] = Rent_Price_List::get();

            return view('producer.video.edit', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'category_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'type_id' => 'required',
                'video_upload_type' => 'required',
                'trailer_type' => 'required',
                'subtitle_type' => 'required',
                'description' => 'required',
                'video_duration' => 'required|after_or_equal:00:00:01',
                'is_premium' => 'required',
                'is_title' => 'required',
                'is_download' => 'required',
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

            if ($request->video_upload_type != "server_video") {
                $validator1 = Validator::make($request->all(), [
                    'video_url_320' => 'required',
                ]);
                if ($validator1->fails()) {
                    $errs1 = $validator1->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs1));
                }
            }

            $video = Video::where('id', $request->id)->first();
            if (isset($video->id)) {

                $producer = Producer_Data();

                $category_id = implode(',', $request->category_id);
                $language_id = implode(',', $request->language_id);
                $cast_id = implode(',', $request->cast_id);

                $video->type_id = $request->type_id;
                $video->video_type = 1;
                $video->channel_id = 0;
                $video->producer_id = $producer['id'];
                $video->category_id = $category_id;
                $video->language_id = $language_id;
                $video->cast_id = $cast_id;
                $video->name = $request->name;
                $video->video_upload_type = $request->video_upload_type;
                $video->description = $request->description;
                $video->video_duration = Time_To_Milliseconds($request->video_duration);
                $video->is_premium = $request->is_premium;
                $video->is_title = $request->is_title;
                $video->release_date = "";
                if ($request->release_date) {
                    $video->release_date = $request->release_date;
                }
                if ($request->video_upload_type == "server_video") {
                    $video->is_download = $request->is_download;
                } else {
                    $video->is_download = 0;
                }
                $video->is_like = $request->is_like;
                $video->is_comment = $request->is_comment;

                // Videos (320, 420, 720, 1080)
                if ($request->video_upload_type == "server_video") {

                    if ($request->video_upload_type == $request->old_video_upload_type) {

                        if ($request->video_320) {

                            $array = explode('.', $request->video_320);
                            $video->video_extension = end($array);

                            $video->video_320 = $request->video_320;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_320));
                        }
                        if ($request->video_480) {

                            $video->video_480 = $request->video_480;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_480));
                        }
                        if ($request->video_720) {

                            $video->video_720 = $request->video_720;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_720));
                        }
                        if ($request->video_1080) {

                            $video->video_1080 = $request->video_1080;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_1080));
                        }
                    } else {
                        if ($request->video_320) {

                            $array = explode('.', $request->video_320);
                            $video->video_extension = end($array);

                            $video->video_320 = $request->video_320;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_320));
                        } else {
                            $video->video_320 = "";
                        }
                        if ($request->video_480) {

                            $video->video_480 = $request->video_480;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_480));
                        } else {
                            $video->video_480 = "";
                        }
                        if ($request->video_720) {

                            $video->video_720 = $request->video_720;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_720));
                        } else {
                            $video->video_720 = "";
                        }
                        if ($request->video_1080) {

                            $video->video_1080 = $request->video_1080;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_1080));
                        } else {
                            $video->video_1080 = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_320));
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_480));
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_720));
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_video_1080));

                    $video->video_480 = "";
                    $video->video_720 = "";
                    $video->video_1080 = "";
                    if ($request->video_url_320) {

                        $array = explode('.', $request->video_url_320);
                        $array1 = explode('?', end($array));
                        if (isset($array1) && $array1 != null) {
                            $video->video_extension = isset($array1) ? reset($array1) : "";
                        } else {
                            $video->video_extension = "";
                        }

                        $video->video_320 = $request->video_url_320;
                    }
                    if ($request->video_url_480) {
                        $video->video_480 = $request->video_url_480;
                    }
                    if ($request->video_url_720) {
                        $video->video_720 = $request->video_url_720;
                    }
                    if ($request->video_url_1080) {
                        $video->video_1080 = $request->video_url_1080;
                    }
                }

                // Subtitle
                $video->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                $video->subtitle_lang_1 = isset($request->subtitle_lang_1) ? $request->subtitle_lang_1 : '';
                $video->subtitle_lang_2 = isset($request->subtitle_lang_2) ? $request->subtitle_lang_2 : '';
                $video->subtitle_lang_3 = isset($request->subtitle_lang_3) ? $request->subtitle_lang_3 : '';
                if ($request->subtitle_type == "server_video") {

                    if ($request->subtitle_type == $request->old_subtitle_type) {
                        if ($request->subtitle_1) {
                            $video->subtitle_1 = $request->subtitle_1;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_1));
                        }
                        if ($request->subtitle_2) {
                            $video->subtitle_2 = $request->subtitle_2;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_2));
                        }
                        if ($request->subtitle_3) {
                            $video->subtitle_3 = $request->subtitle_3;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_3));
                        }
                    } else {
                        if ($request->subtitle_1) {
                            $video->subtitle_1 = $request->subtitle_1;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_1));
                        } else {
                            $video->subtitle_1 = "";
                        }
                        if ($request->subtitle_2) {
                            $video->subtitle_2 = $request->subtitle_2;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_2));
                        } else {
                            $video->subtitle_2 = "";
                        }
                        if ($request->subtitle_3) {
                            $video->subtitle_3 = $request->subtitle_3;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_3));
                        } else {
                            $video->subtitle_3 = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_1));
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_2));
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_subtitle_3));

                    $video->subtitle_1 = "";
                    $video->subtitle_2 = "";
                    $video->subtitle_3 = "";
                    if ($request->subtitle_1) {
                        $video->subtitle_1 = $request->subtitle_url_1;
                    }
                    if ($request->subtitle_2) {
                        $video->subtitle_2 = $request->subtitle_url_2;
                    }
                    if ($request->subtitle_3) {
                        $video->subtitle_3 = $request->subtitle_url_3;
                    }
                }

                // Trailer
                $video->trailer_type = isset($request->trailer_type) ? $request->trailer_type : '';
                if ($request->trailer_type == "server_video") {

                    if ($request->trailer_type == $request->old_trailer_type) {

                        if ($request->trailer) {
                            $video->trailer_url = $request->trailer;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_trailer));
                        }
                    } else {
                        if ($request->trailer) {
                            $video->trailer_url = $request->trailer;
                            $this->common->deleteImageToFolder($this->folder_content, basename($request->old_trailer));
                        } else {
                            $video->trailer_url = "";
                        }
                    }
                } else {

                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_trailer));

                    $video->trailer_url = "";
                    if ($request->trailer_url) {
                        $video->trailer_url = $request->trailer_url;
                    }
                }

                $org_name = $request->file('thumbnail');
                $org_name1 = $request->file('landscape');
                if ($org_name != null && isset($org_name)) {

                    $video->thumbnail = $this->common->saveImage($org_name, $this->folder_content, 'vid_');
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_thumbnail));
                } elseif ($request->thumbnail_tmdb) {

                    $url = $request->thumbnail_tmdb;
                    $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'vid_');
                    $video->thumbnail = $S_Name;
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_thumbnail));
                }
                if ($org_name1 != null && isset($org_name1)) {

                    $video->landscape = $this->common->saveImage($org_name1, $this->folder_content, 'vid_');
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_landscape));
                } elseif ($request->landscape_tmdb) {

                    $url = $request->landscape_tmdb;
                    $S_Name = $this->common->URLSaveInImage($url, $this->folder_content, 'vid_');
                    $video->landscape = $S_Name;
                    $this->common->deleteImageToFolder($this->folder_content, basename($request->old_landscape));
                }

                // Rent
                $video->is_rent = $request->is_rent;
                $video->price = isset($request->price) ? $request->price : 0;
                $video->rent_day = isset($request->rent_day) ? $request->rent_day : 0;

                if ($video->save()) {
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
    public function show($id)
    {
        try {

            $video = Video::where('id', $id)->first();
            if ($video->delete()) {

                $this->common->deleteImageToFolder($this->folder_content, $video->thumbnail);
                $this->common->deleteImageToFolder($this->folder_content, $video->landscape);

                $this->common->deleteImageToFolder($this->folder_content, $video->video_320);
                $this->common->deleteImageToFolder($this->folder_content, $video->video_480);
                $this->common->deleteImageToFolder($this->folder_content, $video->video_720);
                $this->common->deleteImageToFolder($this->folder_content, $video->video_1080);

                $this->common->deleteImageToFolder($this->folder_content, $video->trailer_url);

                $this->common->deleteImageToFolder($this->folder_content, $video->subtitle_1);
                $this->common->deleteImageToFolder($this->folder_content, $video->subtitle_2);
                $this->common->deleteImageToFolder($this->folder_content, $video->subtitle_3);

                return redirect()->route('pvideo.index')->with('success', __('label.controller.data_delete_successfully'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function videoDetails($id)
    {
        try {

            $params['video_id'] = $id;
            $params['data'] = Video::where('id', $id)->first();
            $params['total_rent_earning'] = 0;
            if ($params['data']['is_rent'] == 1) {
                $params['total_rent_earning'] = Rent_Transction::where('video_type', $params['data']['video_type'])->where('sub_video_type', 0)->where('video_id', $id)->sum('price');
            }
            $params['total_bookmark'] = Bookmark::where('video_type', $params['data']['video_type'])->where('sub_video_type', 0)->where('video_id', $id)->count();
            $params['total_comment'] = Comment::where('video_type', $params['data']['video_type'])->where('sub_video_type', 0)->where('video_id', $id)->count();
            $params['total_download'] = Download::where('video_type', $params['data']['video_type'])->where('sub_video_type', 0)->where('video_id', $id)->count();

            return view('producer.video.details', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    // TMDb
    public function SerachName($txtVal)
    {
        try {
            $tmdbTitle = $txtVal;
            $tmdb_api_key = TMDB_API_Key();

            if (strlen($tmdbTitle) >= 3 && $tmdb_api_key != "" && isset($tmdb_api_key) && $tmdb_api_key != null) {

                $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $tmdb_api_key . '&language=en-US&page=1&include_adult=false&query=' . $tmdbTitle;
                $response = Http::get($url);
                $Status = $response->getStatusCode();
                $Data = $response->json();

                if ($Status == 200) {
                    return response()->json(array('status' => 200, 'success' => __('label.controller.data_get_successfully'), 'data' => $Data));
                }
            } else {
                return response()->json(array('status' => 400, 'success' => __('label.controller.enter_tmdb_key')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function GetData($tmdbID)
    {
        try {

            $tmdb_api_key = TMDB_API_Key();
            if ($tmdb_api_key != "" && isset($tmdb_api_key) && $tmdb_api_key != null) {

                $url = 'https://api.themoviedb.org/3/movie/' . $tmdbID . '?api_key=' . $tmdb_api_key . '&append_to_response=credits&language=en-US';
                $response = Http::get($url);
                $Status = $response->getStatusCode();
                $movies = $response->json();

                // Category
                $C_Id = [];
                $C_Insert_Data = [];
                if (isset($movies['genres']) && $movies['genres'] != null && count($movies['genres']) > 0) {

                    for ($i = 0; $i < count($movies['genres']); $i++) {

                        $Category = Category::where(DB::raw('lower(name)'), strtolower($movies['genres'][$i]['name']))->first();
                        if (!empty($Category)) {

                            $C_Id[] = $Category['id'];
                        } else {

                            $insert = new Category();
                            $insert['name'] = $movies['genres'][$i]['name'];
                            $insert['image'] = "";
                            $insert['status'] = 1;
                            $insert->save();

                            $C_Id[] = $insert['id'];
                            $C_Insert_Data[] = $insert;
                        }
                    }
                }
                $params['C_Id'] = $C_Id;
                $params['C_Insert_Data'] = $C_Insert_Data;

                // Language
                $L_Id = [];
                $L_Insert_Data = [];
                if (isset($movies['spoken_languages']) && $movies['spoken_languages'] != null && count($movies['spoken_languages']) > 0) {

                    for ($i = 0; $i < count($movies['spoken_languages']); $i++) {

                        $Language = Language::where(DB::raw('lower(name)'), strtolower($movies['spoken_languages'][$i]['english_name']))->first();
                        if (!empty($Language)) {

                            $L_Id[] = $Language['id'];
                        } else {

                            $insert = new Language();
                            $insert['name'] = $movies['spoken_languages'][$i]['english_name'];
                            $insert['image'] = "";
                            $insert['status'] = 1;
                            $insert->save();

                            $L_Id[] = $insert['id'];
                            $L_Insert_Data[] = $insert;
                        }
                    }
                }
                $params['L_Id'] = $L_Id;
                $params['L_Insert_Data'] = $L_Insert_Data;

                // Cast
                $Cast_Id = [];
                $Cast_Insert_Data = [];
                if (isset($movies['credits']['cast']) && $movies['credits']['cast'] != null && count($movies['credits']['cast']) > 0) {

                    for ($i = 0; $i < count($movies['credits']['cast']); $i++) {

                        $CastData = Cast::where(DB::raw('lower(name)'), strtolower($movies['credits']['cast'][$i]['name']))->first();
                        if (!empty($CastData)) {

                            $Cast_Id[] = $CastData['id'];
                        } else {

                            $insert = new Cast();
                            $insert['name'] = $movies['credits']['cast'][$i]['name'];
                            $insert['type'] = "Actor";
                            $insert['personal_info'] = $movies['credits']['cast'][$i]['character'];
                            $castImage = "";
                            if ($movies['credits']['cast'][$i]['profile_path'] != null) {
                                $img_url = 'https://image.tmdb.org/t/p/original' . $movies['credits']['cast'][$i]['profile_path'];
                                $castImage = $this->common->URLSaveInImage($img_url, $this->folder_cast, 'cast_');
                            }
                            $insert['image'] = $castImage;
                            $insert['status'] = 1;
                            $insert->save();

                            $Cast_Id[] = $insert['id'];
                            $Cast_Insert_Data[] = $insert;
                        }
                        if ($i == 9) {
                            break;
                        }
                    }
                }
                $params['Cast_Id'] = $Cast_Id;
                $params['Cast_Insert_Data'] = $Cast_Insert_Data;

                // Poster
                $Thumbnail = "";
                if (isset($movies['poster_path']) && $movies['poster_path'] != null) {
                    $img_url = 'https://image.tmdb.org/t/p/original' . $movies['poster_path'];
                    $Thumbnail = $img_url;
                }
                $params['Thumbnail'] = $Thumbnail;

                // Title
                $Title = "";
                if (isset($movies['title']) && $movies['title'] != null) {
                    $Title = $movies['title'];
                }
                $params['Title'] = $Title;

                // Description
                $Description = "";
                if (isset($movies['overview'])) {
                    $Description = $movies['overview'];
                }
                $params['Description'] = $Description;

                // Release Date
                $Release_Date = date('Y-m-d');
                if (isset($movies['release_date']) && $movies['release_date'] != null) {
                    $Release_Date = $movies['release_date'];
                }
                $params['Release_Date'] = $Release_Date;

                return response()->json(array('status' => 200, 'data' => $params));
            } else {
                return response()->json(array('status' => 400, 'success' => __('label.controller.enter_tmdb_key')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
