<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Banner;
use App\Models\Bookmark;
use App\Models\Cast;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Download;
use App\Models\General_Setting;
use App\Models\Language;
use App\Models\Common;
use App\Models\Home_Section;
use App\Models\Like;
use App\Models\Onboarding_Screen;
use App\Models\Package;
use App\Models\Social_Link;
use App\Models\Package_Detail;
use App\Models\Payment_Option;
use App\Models\Transction;
use App\Models\Page;
use App\Models\Rent_Transction;
use App\Models\Season;
use App\Models\TVShow;
use App\Models\TVShow_Video;
use App\Models\Type;
use App\Models\User;
use App\Models\Video;
use App\Models\Video_Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

// Video Type = 1-Video, 2-Show, 3-Language, 4-Category, 5-Upcoming, 6-Channel, 7-Kids
// Video Upload Type = server_video, external, youtube
// Trailer Type = server_video, external, youtube
// Subtitle Type = server_video, external

class HomeController extends Controller
{

    private $folder_language = "language";
    private $folder_channel = "channel";
    private $folder_cast = "cast";
    private $folder_category = "category";
    private $folder_app = "app";
    private $folder_user = "user";
    private $folder_avatar = "avatar";
    public $common;
    public $page_limit;
    public function __construct()
    {
        try {

            $this->common = new Common();
            $this->page_limit = env('PAGE_LIMIT');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function general_setting()
    {
        try {

            $list = General_Setting::get();
            foreach ($list as $key => $value) {

                if ($value['key'] == 'app_logo') {
                    $value['value'] = $this->common->getImage($this->folder_app, $value['value'], 'normal');
                }
            }

            return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $list);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_payment_option()
    {
        try {

            $return['status'] = 200;
            $return['message'] = __('label.controller.get_record_successfully');
            $return['result'] = [];

            $Option_data = Payment_Option::get();
            foreach ($Option_data as $key => $value) {
                $return['result'][$value['name']] = $value;
            }

            return $return;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_pages()
    {
        try {

            $return['status'] = 200;
            $return['message'] = __('label.controller.get_record_successfully');
            $return['result'] = [];

            $data = Page::get();
            for ($i = 0; $i < count($data); $i++) {
                $return['result'][$i]['page_name'] = $data[$i]['page_name'];
                $return['result'][$i]['title'] = $data[$i]['title'];
                $return['result'][$i]['url'] = env('APP_URL') . '/public/pages/' . $data[$i]['page_name'];
                $return['result'][$i]['icon'] = $this->common->getImage($this->folder_app, $data[$i]['icon'], 'normal');
                $return['result'][$i]['page_subtitle'] = $data[$i]['page_subtitle'];
            }
            return $return;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_social_link()
    {
        try {
            $data = Social_Link::get();
            if (sizeof($data) > 0) {

                $this->common->imageNameToUrl($data, 'image', $this->folder_app, 'normal');
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_onboarding_screen()
    {
        try {
            $data = Onboarding_Screen::get();
            if (sizeof($data) > 0) {

                $this->common->imageNameToUrl($data, 'image', $this->folder_app, 'normal');
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_package(Request $request)
    {
        try {

            $this->common->package_expiry();

            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;

            $data['status'] = 200;
            $data['message'] = __('label.controller.get_record_successfully');
            $data['result'] = [];

            $Package_Data = Package::select('id', 'name', 'price', 'time', 'type', 'android_product_package', 'ios_product_package', 'web_product_package')->get();
            foreach ($Package_Data as $key => $value) {

                $Transction_Data = Transction::where('user_id', $user_id)->where('package_id', $value['id'])->where('status', '1')->first();
                if (!empty($Transction_Data)) {
                    $value['is_buy'] = 1;
                } else {
                    $value['is_buy'] = 0;
                }

                $Data = Package_Detail::where('package_id', $value['id'])->get();
                $value['data'] = $Data;

                $data['result'][] = $value;
            }
            return $data;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_avatar()
    {
        try {
            $Data = Avatar::latest()->get();
            if (sizeof($Data) > 0) {

                $this->common->imageNameToUrl($Data, 'image', $this->folder_avatar, 'profile');

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $Data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_category()
    {
        try {
            $Data = Category::latest()->get();
            if (sizeof($Data) > 0) {

                $this->common->imageNameToUrl($Data, 'image', $this->folder_category, 'normal');

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $Data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_language()
    {
        try {
            $Data = Language::latest()->get();
            if (sizeof($Data) > 0) {

                $this->common->imageNameToUrl($Data, 'image', $this->folder_language, 'normal');

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $Data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_channel()
    {
        try {
            $Data = Channel::latest()->get();
            if (sizeof($Data) > 0) {

                $this->common->imageNameToUrl($Data, 'portrait_img', $this->folder_channel, 'portrait');
                $this->common->imageNameToUrl($Data, 'landscape_img', $this->folder_channel, 'landscape');

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $Data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_type(Request $request)
    {
        try {

            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;

            // Check Parent Control
            $user_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_status == 1) {
                $Data = Type::where('type', 7)->where('status', 1)->get();
            } else {
                $Data = Type::where('status', 1)->get();
            }

            if (sizeof($Data) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $Data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_banner(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'is_home_screen' => 'required|numeric',
                    'type_id' => 'required|numeric',
                ],
                [
                    'is_home_screen.required' => __('label.controller.is_home_screen_is_required'),
                    'type_id.required' => __('label.controller.type_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_home_screen = $request['is_home_screen'];
            $type_id = $request['type_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;

            // Check Parent Control
            $parent_control_status = $this->common->check_user_parent_control_status($user_id);

            if ($is_home_screen == 1) {

                if ($parent_control_status == 1) {
                    $banner_data = Banner::where('is_home_screen', 1)->where('video_type', 7)->latest()->get();
                } else {
                    $banner_data = Banner::where('is_home_screen', 1)->latest()->get();
                }
            } elseif ($is_home_screen == 2) {

                if ($parent_control_status == 1) {
                    $banner_data = Banner::where('is_home_screen', 2)->where('video_type', 7)->where('type_id', $type_id)->latest()->get();
                } else {
                    $banner_data = Banner::where('is_home_screen', 2)->where('type_id', $type_id)->latest()->get();
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }

            if (count($banner_data) > 0) {

                $final_data = [];
                for ($i = 0; $i < count($banner_data); $i++) {

                    if ($banner_data[$i]['video_type'] == 1) {

                        $data = Video::where('video_type', 1)->where('id', $banner_data[$i]['video_id'])->where('status', 1)->first();
                        if ($data != null && isset($data)) {

                            $this->common->add_url_to_array(1, array($data));
                            $this->common->rent_price_list(array($data));

                            $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 0, $data['id']);
                            $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 0, $data['id']);
                            $data['sub_video_type'] = 0;
                            $data['total_language'] = $this->common->get_total_language($data['language_id']);
                            $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                            $data['is_user_download'] = $this->common->is_user_download($user_id, $data['video_type'], 0, $data['id'], 0);

                            $final_data[] = $data;
                        }
                    } else if ($banner_data[$i]['video_type'] == 2) {

                        $data = TVShow::where('video_type', 2)->where('id', $banner_data[$i]['video_id'])->where('status', 1)->first();
                        if ($data != null && isset($data)) {

                            $this->common->add_url_to_array(2, array($data));
                            $this->common->rent_price_list(array($data));

                            $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 0, $data['id']);
                            $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 0, $data['id']);
                            $data['sub_video_type'] = 0;
                            $data['total_language'] = $this->common->get_total_language($data['language_id']);
                            $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                            $data['is_user_download'] = 0;

                            $final_data[] = $data;
                        }
                    } else if ($banner_data[$i]['video_type'] == 5 || $banner_data[$i]['video_type'] == 6 || $banner_data[$i]['video_type'] == 7) {

                        if ($banner_data[$i]['subvideo_type'] == 1) {

                            $data = Video::where('video_type', $banner_data[$i]['video_type'])->where('id', $banner_data[$i]['video_id'])->where('status', 1)->first();
                            if ($data != null && isset($data)) {

                                $this->common->add_url_to_array(1, array($data));
                                $this->common->rent_price_list(array($data));

                                $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 1, $data['id']);
                                $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 1, $data['id']);
                                $data['sub_video_type'] = 1;
                                $data['total_language'] = $this->common->get_total_language($data['language_id']);
                                $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                                $data['is_user_download'] = $this->common->is_user_download($user_id, $data['video_type'], 1, $data['id'], 0);

                                $final_data[] = $data;
                            }
                        } else if ($banner_data[$i]['subvideo_type'] == 2) {

                            $data = TVShow::where('video_type', $banner_data[$i]['video_type'])->where('id', $banner_data[$i]['video_id'])->where('status', 1)->first();
                            if ($data != null && isset($data)) {

                                $this->common->add_url_to_array(2, array($data));
                                $this->common->rent_price_list(array($data));

                                $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 2, $data['id']);
                                $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 2, $data['id']);
                                $data['sub_video_type'] = 2;
                                $data['total_language'] = $this->common->get_total_language($data['language_id']);
                                $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                                $data['is_user_download'] = 0;

                                $final_data[] = $data;
                            }
                        }
                    }
                }
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $final_data);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function section_list(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                [
                    'is_home_screen' => 'required|numeric',
                    'type_id' => 'required|numeric',
                ],
                [
                    'is_home_screen.required' => __('label.controller.is_home_screen_is_required'),
                    'type_id.required' => __('label.controller.type_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_home_screen = $request['is_home_screen'];
            $type_id = $request['type_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $is_parent = isset($request->is_parent) ? $request->is_parent : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);

            if ($is_home_screen == 1) {

                if ($user_parent_control_status == 1) {
                    $data = Home_Section::where('is_home_screen', $is_home_screen)->whereIn('video_type', [8, 9])->where('status', 1)->orderBy('sortable', 'asc')->latest();
                } else {
                    $data = Home_Section::where('is_home_screen', $is_home_screen)->where('status', 1)->orderBy('sortable', 'asc')->latest();
                }
            } else if ($is_home_screen == 2) {

                if ($user_parent_control_status == 1) {
                    $data = Home_Section::where('is_home_screen', $is_home_screen)->whereIn('video_type', [8, 9])->where('type_id', $type_id)->where('status', 1)->orderBy('sortable', 'asc')->latest();
                } else {
                    $data = Home_Section::where('is_home_screen', $is_home_screen)->where('type_id', $type_id)->where('status', 1)->orderBy('sortable', 'asc')->latest();
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                for ($i = 0; $i < count($data); $i++) {

                    $data[$i]['data'] = [];
                    if ($data[$i]['video_type'] == 1 || $data[$i]['video_type'] == 2 || $data[$i]['video_type'] == 6 || $data[$i]['video_type'] == 7 || $data[$i]['video_type'] == 9) {

                        $query = $this->common->home_section_query($user_id, $data[$i]['video_type'], $data[$i]['sub_video_type'], $data[$i]['type_id'], $data[$i]['category_id'], $data[$i]['language_id'], $data[$i]['channel_id'], $data[$i]['order_by_upload'], $data[$i]['order_by_like'], $data[$i]['order_by_view'], $data[$i]['premium_video'], $data[$i]['rent_video'], $data[$i]['no_of_content']);
                        $data[$i]['data'] = $query;
                    } else if ($data[$i]['video_type'] == 3) {

                        $query = Category::orderBy('id', 'desc')->take($data[$i]['no_of_content'])->get();
                        $this->common->imageNameToUrl($query, 'image', $this->folder_category, 'normal');
                        $data[$i]['data'] = $query;
                    } else if ($data[$i]['video_type'] == 4) {

                        $query = Language::orderBy('id', 'desc')->take($data[$i]['no_of_content'])->get();
                        $this->common->imageNameToUrl($query, 'image', $this->folder_language, 'normal');
                        $data[$i]['data'] = $query;
                    } else if ($data[$i]['video_type'] == 5) {

                        $query = Channel::orderBy('id', 'desc')->take($data[$i]['no_of_content'])->get();
                        $this->common->imageNameToUrl($query, 'portrait_img', $this->folder_channel, 'portrait');
                        $this->common->imageNameToUrl($query, 'landscape_img', $this->folder_channel, 'landscape');
                        $data[$i]['data'] = $query;
                    } else if ($data[$i]['video_type'] == 8) {

                        if ($user_parent_control_status == 1) {
                            $watched_data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', 7)->where('status', 1)->latest()->orderBy('id', 'desc')->take(10)->get();
                        } else {
                            $watched_data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('status', 1)->latest()->orderBy('id', 'desc')->take(10)->get();
                        }

                        if (count($watched_data) > 0) {

                            $final_array = [];
                            for ($j = 0; $j < count($watched_data); $j++) {

                                if ($watched_data[$j]['video_type'] == 1) {

                                    $content_data = Video::where('id', $watched_data[$j]['video_id'])->where('status', 1)->where('video_type', 1)->first();
                                    if ($content_data != null && isset($content_data)) {

                                        $this->common->add_url_to_array(1, array($content_data));
                                        $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                        $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                                        $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                                        $content_data['sub_video_type'] = 0;
                                        $content_data['stop_time'] = $watched_data[$j]['stop_time'];
                                        $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                        $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], 0);
                                        $this->common->rent_price_list($content_data);

                                        $final_array[] = $content_data;
                                    }
                                } else if ($watched_data[$j]['video_type'] == 2) {

                                    $content_data = TVShow::where('id', $watched_data[$j]['video_id'])->where('status', 1)->where('video_type', 2)->first();
                                    if ($content_data != null && isset($content_data)) {

                                        $this->common->add_url_to_array(2, array($content_data));
                                        $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                        $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                                        $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                                        $content_data['sub_video_type'] = 0;
                                        $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                        $content_data['is_user_download'] = 0;
                                        $this->common->rent_price_list($content_data);

                                        $episode = [];
                                        $episode_data = TVShow_Video::where('id', $watched_data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                                        if ($episode_data != null && isset($episode_data)) {

                                            $this->common->add_url_to_array(3, array($episode_data));
                                            $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], $episode_data['id']);

                                            $episode = $episode_data->toArray();
                                        }
                                        $content_data['episode'] = $episode;

                                        $content_data['stop_time'] = $watched_data[$j]['stop_time'];
                                        $final_array[] = $content_data;
                                    }
                                } else if ($watched_data[$j]['video_type'] == 6 || $watched_data[$j]['video_type'] == 7) {

                                    if ($watched_data[$j]['sub_video_type'] == 1) {

                                        $content_data = Video::where('id', $watched_data[$j]['video_id'])->where('status', 1)->where('video_type', $watched_data[$j]['video_type'])->first();
                                        if ($content_data != null && isset($content_data)) {

                                            $this->common->add_url_to_array(1, array($content_data));
                                            $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                            $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 1, $content_data['id']);
                                            $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 1, $content_data['id']);
                                            $content_data['sub_video_type'] = 1;
                                            $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                            $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 1, $content_data['id'], 0);
                                            $content_data['stop_time'] = $watched_data[$j]['stop_time'];
                                            $this->common->rent_price_list($content_data);

                                            $final_array[] = $content_data;
                                        }
                                    } else if ($watched_data[$j]['sub_video_type'] == 2) {

                                        $content_data = TVShow::where('id', $watched_data[$j]['video_id'])->where('status', 1)->where('video_type', $watched_data[$j]['video_type'])->first();
                                        if ($content_data != null && isset($content_data)) {

                                            $this->common->add_url_to_array(2, array($content_data));
                                            $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                            $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 2, $content_data['id']);
                                            $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 2, $content_data['id']);
                                            $content_data['sub_video_type'] = 2;
                                            $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                            $content_data['is_user_download'] = 0;
                                            $this->common->rent_price_list($content_data);

                                            $episode = [];
                                            $episode_data = TVShow_Video::where('id', $watched_data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                                            if ($episode_data != null && isset($episode_data)) {

                                                $this->common->add_url_to_array(3, array($episode_data));
                                                $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 2, $content_data['id'], $episode_data['id']);

                                                $episode = $episode_data->toArray();
                                            }
                                            $content_data['episode'] = $episode;

                                            $content_data['stop_time'] = $watched_data[$j]['stop_time'];
                                            $final_array[] = $content_data;
                                        }
                                    }
                                }
                            }
                            $data[$i]['data'] = $final_array;
                        }
                    }
                }
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function section_detail(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'section_id' => 'required|numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'section_id.required' => __('label.controller.section_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $section_id = $request['section_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $is_parent = isset($request->is_parent) ? $request->is_parent : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            $section = Home_Section::where('id', $section_id)->first();
            if ($section != null && isset($section)) {

                if ($section['video_type'] == 1 || $section['video_type'] == 2 || $section['video_type'] == 6 || $section['video_type'] == 7 || $section['video_type'] == 9) {

                    $data = $this->common->home_section_query_detail($section['video_type'], $section['sub_video_type'], $section['type_id'], $section['category_id'], $section['language_id'], $section['channel_id'], $section['order_by_upload'], $section['order_by_like'], $section['order_by_view'], $section['premium_video'], $section['rent_video']);
                } else if ($section['video_type'] == 3) {

                    $data = Category::orderBy('id', 'desc');
                } else if ($section['video_type'] == 4) {

                    $data = Language::orderBy('id', 'desc');
                } else if ($section['video_type'] == 5) {

                    $data = Channel::orderBy('id', 'desc');
                } else if ($section['video_type'] == 8) {

                    $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
                    if ($user_parent_control_status == 1) {
                        $data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', 7)->where('status', 1)->latest()->orderBy('id', 'desc');
                    } else {
                        $data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('status', 1)->latest()->orderBy('id', 'desc');
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->skip($offset);
            $data = $data->get();

            if (count($data) > 0) {

                if ($section['video_type'] == 1) {

                    $this->common->add_url_to_array(1, $data);
                    $this->common->rent_price_list($data);
                    for ($i = 0; $i < count($data); $i++) {

                        $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['sub_video_type'] = 0;
                        $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                        $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                    }
                } else if ($section['video_type'] == 2) {

                    $this->common->add_url_to_array(2, $data);
                    $this->common->rent_price_list($data);
                    for ($i = 0; $i < count($data); $i++) {

                        $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['sub_video_type'] = 0;
                        $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                        $data[$i]['is_user_download'] = 0;
                    }
                } else if ($section['video_type'] == 3) {

                    $this->common->imageNameToUrl($data, 'image', $this->folder_category, 'normal');
                } else if ($section['video_type'] == 4) {

                    $this->common->imageNameToUrl($data, 'image', $this->folder_language, 'normal');
                } else if ($section['video_type'] == 5) {

                    $this->common->imageNameToUrl($data, 'portrait_img', $this->folder_channel, 'portrait');
                    $this->common->imageNameToUrl($data, 'landscape_img', $this->folder_channel, 'landscape');
                } else if ($section['video_type'] == 6 || $section['video_type'] == 7 || $section['video_type'] == 9) {

                    if ($section['sub_video_type'] == 1) {

                        $this->common->add_url_to_array(1, $data);
                        $this->common->rent_price_list($data);
                        for ($i = 0; $i < count($data); $i++) {

                            $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 1, $data[$i]['id']);
                            $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 1, $data[$i]['id']);
                            $data[$i]['sub_video_type'] = 1;
                            $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 1, $data[$i]['id'], 0);
                            $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $data[$i]['video_type'], 1, $data[$i]['id'], 0);
                        }
                    } else if ($section['sub_video_type'] == 2) {

                        $this->common->add_url_to_array(2, $data);
                        $this->common->rent_price_list($data);
                        for ($i = 0; $i < count($data); $i++) {

                            $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 2, $data[$i]['id']);
                            $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 2, $data[$i]['id']);
                            $data[$i]['sub_video_type'] = 2;
                            $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 2, $data[$i]['id'], 0);
                            $data[$i]['is_user_download'] = 0;
                        }
                    }
                } else if ($section['video_type'] == 8) {

                    $final_array = [];
                    for ($j = 0; $j < count($data); $j++) {

                        if ($data[$j]['video_type'] == 1) {

                            $content_data = Video::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', 1)->first();
                            if ($content_data != null && isset($content_data)) {

                                $this->common->add_url_to_array(1, array($content_data));
                                $this->common->rent_price_list(array($content_data));
                                $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                                $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                                $content_data['sub_video_type'] = 0;
                                $content_data['stop_time'] = $data[$j]['stop_time'];
                                $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], 0);
                                $final_array[] = $content_data;
                            }
                        } else if ($data[$j]['video_type'] == 2) {

                            $content_data = TVShow::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', 2)->first();
                            if ($content_data != null && isset($content_data)) {

                                $this->common->add_url_to_array(2, array($content_data));
                                $this->common->rent_price_list(array($content_data));
                                $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                                $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                                $content_data['sub_video_type'] = 0;
                                $content_data['is_user_download'] = 0;

                                $episode = [];
                                $episode_data = TVShow_Video::where('id', $data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                                if ($episode_data != null && isset($episode_data)) {

                                    $this->common->add_url_to_array(3, array($episode_data));
                                    $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], $episode_data['id']);

                                    $episode = $episode_data->toArray();
                                }
                                $content_data['episode'] = $episode;

                                $content_data['stop_time'] = $data[$j]['stop_time'];
                                $final_array[] = $content_data;
                            }
                        } else if ($data[$j]['video_type'] == 6 || $data[$j]['video_type'] == 7) {

                            if ($data[$j]['sub_video_type'] == 1) {

                                $content_data = Video::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', $data[$j]['video_type'])->first();
                                if ($content_data != null && isset($content_data)) {

                                    $this->common->add_url_to_array(1, array($content_data));
                                    $this->common->rent_price_list(array($content_data));
                                    $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                    $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 1, $content_data['id']);
                                    $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 1, $content_data['id']);
                                    $content_data['sub_video_type'] = 1;
                                    $content_data['stop_time'] = $data[$j]['stop_time'];
                                    $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 1, $content_data['id'], 0);
                                    $final_array[] = $content_data;
                                }
                            } else if ($data[$j]['sub_video_type'] == 2) {

                                $content_data = TVShow::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', $data[$j]['video_type'])->first();
                                if ($content_data != null && isset($content_data)) {

                                    $this->common->add_url_to_array(2, array($content_data));
                                    $this->common->rent_price_list(array($content_data));
                                    $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                    $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 2, $content_data['id']);
                                    $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 2, $content_data['id']);
                                    $content_data['sub_video_type'] = 2;
                                    $content_data['is_user_download'] = 0;

                                    $episode = [];
                                    $episode_data = TVShow_Video::where('id', $data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                                    if ($episode_data != null && isset($episode_data)) {

                                        $this->common->add_url_to_array(3, array($episode_data));
                                        $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 2, $content_data['id'], $episode_data['id']);

                                        $episode = $episode_data->toArray();
                                    }
                                    $content_data['episode'] = $episode;

                                    $content_data['stop_time'] = $data[$j]['stop_time'];
                                    $final_array[] = $content_data;
                                }
                            }
                        }
                    }
                    $data = $final_array;
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function content_detail(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'type_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'type_id.required' => __('label.controller.type_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $type_id = $request['type_id'];
            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;

            if ($video_type == 1) {

                $data = Video::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->first();
                if ($data != null && isset($data)) {

                    $this->common->add_url_to_array(1, array($data));
                    $this->common->rent_price_list(array($data));

                    $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 0, $data['id']);
                    $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 0, $data['id']);
                    $data['sub_video_type'] = 0;
                    $data['stop_time'] = $this->common->get_stop_time($user_id, $data['video_type'], 0, $data['id'], 0);
                    $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                    $data['language_name'] = $this->common->get_language_name_by_ids($data['language_id']);
                    $data['is_user_download'] = $this->common->is_user_download($user_id, $data['video_type'], 0, $data['id'], 0);

                    // Cast
                    $data['cast'] = array();
                    $cast_Ids = explode(',', $data['cast_id']);
                    $data['cast'] = Cast::whereIn('id', $cast_Ids)->get();
                    $this->common->imageNameToUrl($data['cast'], 'image', $this->folder_cast, 'profile');

                    // Season
                    $data['season'] = array();

                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } elseif ($video_type == 2) {

                $data = TVShow::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->first();
                if ($data != null && isset($data)) {

                    $this->common->add_url_to_array(2, array($data));
                    $this->common->rent_price_list(array($data));

                    $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 0, $data['id']);
                    $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 0, $data['id']);
                    $data['sub_video_type'] = 0;
                    $data['stop_time'] = $this->common->get_stop_time($user_id, $data['video_type'], 0, $data['id'], 0);
                    $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                    $data['language_name'] = $this->common->get_language_name_by_ids($data['language_id']);
                    $data['is_user_download'] = 0;

                    // Cast
                    $data['cast'] = array();
                    $cast_Ids = explode(',', $data['cast_id']);
                    $data['cast'] = Cast::whereIn('id', $cast_Ids)->get();
                    $this->common->imageNameToUrl($data['cast'], 'image', $this->folder_cast, 'profile');

                    // Season
                    $data['season'] = array();
                    $season_id = TVShow_Video::select('season_id')->where('show_id', $data['id'])->where('status', 1)->groupBy('season_id')->get();
                    if (count($season_id) > 0) {

                        $season_Ids = [];
                        for ($i = 0; $i < count($season_id); $i++) {
                            $season_Ids[] = $season_id[$i]['season_id'];
                        }
                        $data['season'] = Season::whereIn('id', $season_Ids)->get();
                    }

                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } elseif ($video_type == 5 || $video_type == 6 || $video_type == 7) {

                if ($sub_video_type == 1) {

                    $data = Video::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->first();

                    if ($data != null && isset($data)) {

                        $this->common->add_url_to_array(1, array($data));
                        $this->common->rent_price_list(array($data));

                        $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 1, $data['id']);
                        $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 1, $data['id']);
                        $data['sub_video_type'] = 1;
                        $data['stop_time'] = $this->common->get_stop_time($user_id, $data['video_type'], 1, $data['id'], 0);
                        $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                        $data['language_name'] = $this->common->get_language_name_by_ids($data['language_id']);
                        $data['is_user_download'] = $this->common->is_user_download($user_id, $data['video_type'], 1, $data['id'], 0);

                        // Cast
                        $data['cast'] = array();
                        $cast_Ids = explode(',', $data['cast_id']);
                        $data['cast'] = Cast::whereIn('id', $cast_Ids)->get();
                        $this->common->imageNameToUrl($data['cast'], 'image', $this->folder_cast, 'profile');

                        // Season
                        $data['season'] = array();

                        return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                } else if ($sub_video_type == 2) {

                    $data = TVShow::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->first();
                    if ($data != null && isset($data)) {

                        $this->common->add_url_to_array(2, array($data));
                        $this->common->rent_price_list(array($data));

                        $data['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data['rent_buy'] = $this->common->is_rent_buy($user_id, $data['video_type'], 2, $data['id']);
                        $data['is_bookmark'] = $this->common->is_bookmark($user_id, $data['video_type'], 2, $data['id']);
                        $data['sub_video_type'] = 2;
                        $data['stop_time'] = $this->common->get_stop_time($user_id, $data['video_type'], 2, $data['id'], 0);
                        $data['category_name'] = $this->common->get_category_name_by_ids($data['category_id']);
                        $data['language_name'] = $this->common->get_language_name_by_ids($data['language_id']);
                        $data['is_user_download'] = 0;

                        // Cast
                        $data['cast'] = array();
                        $cast_Ids = explode(',', $data['cast_id']);
                        $data['cast'] = Cast::whereIn('id', $cast_Ids)->get();
                        $this->common->imageNameToUrl($data['cast'], 'image', $this->folder_cast, 'profile');

                        // Season
                        $data['season'] = array();
                        $season_id = TVShow_Video::select('season_id')->where('show_id', $data['id'])->where('status', 1)->groupBy('season_id')->get();
                        if (count($season_id) > 0) {

                            $season_Ids = [];
                            for ($i = 0; $i < count($season_id); $i++) {
                                $season_Ids[] = $season_id[$i]['season_id'];
                            }
                            $data['season'] = Season::whereIn('id', $season_Ids)->get();
                        }

                        return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_releted_content(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'type_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'type_id.required' => __('label.controller.type_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $type_id = $request['type_id'];
            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            if ($video_type == 1) {

                $content_data = Video::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->latest()->first();
                if ($content_data != null && isset($content_data)) {

                    $cat_ids = $content_data['category_id'];
                    $C_Ids = explode(',', $cat_ids);

                    $conditions = array_map(function ($value) {
                        return "FIND_IN_SET('$value', category_id)";
                    }, $C_Ids);

                    $data = Video::where(function ($query) use ($conditions) {
                        $query->whereRaw(implode(' OR ', $conditions));
                    })->whereNotIn('id', [$content_data['id']])->where('video_type', $content_data['video_type'])->orderBy('id', 'desc');
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } elseif ($video_type == 2) {

                $show_id = $this->common->get_tv_show_ids_by_episode();
                $content_data = TVShow::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->latest()->first();

                if ($content_data != null && isset($content_data)) {

                    $cat_ids = $content_data['category_id'];
                    $C_Ids = explode(',', $cat_ids);

                    $conditions = array_map(function ($value) {
                        return "FIND_IN_SET('$value', category_id)";
                    }, $C_Ids);

                    $data = TVShow::whereIn('id', $show_id)->where(function ($query) use ($conditions) {
                        $query->whereRaw(implode(' OR ', $conditions));
                    })->whereNotIn('id', [$content_data['id']])->where('video_type', $content_data['video_type']);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } elseif ($video_type == 5 || $video_type == 6 || $video_type == 7) {

                if ($sub_video_type == 1) {

                    $content_data = Video::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->latest()->first();
                    if ($content_data != null && isset($content_data)) {

                        $cat_ids = $content_data['category_id'];
                        $C_Ids = explode(',', $cat_ids);

                        $conditions = array_map(function ($value) {
                            return "FIND_IN_SET('$value', category_id)";
                        }, $C_Ids);

                        $data = Video::where(function ($query) use ($conditions) {
                            $query->whereRaw(implode(' OR ', $conditions));
                        })->whereNotIn('id', [$content_data['id']])->where('video_type', $content_data['video_type']);
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                } else if ($sub_video_type == 2) {

                    $show_id = $this->common->get_tv_show_ids_by_episode();

                    $content_data = TVShow::where('id', $video_id)->where('video_type', $video_type)->where('type_id', $type_id)->where('status', 1)->latest()->first();
                    if ($content_data != null && isset($content_data)) {

                        $cat_ids = $content_data['category_id'];
                        $C_Ids = explode(',', $cat_ids);

                        $conditions = array_map(function ($value) {
                            return "FIND_IN_SET('$value', category_id)";
                        }, $C_Ids);

                        $data = TVShow::whereIn('id', $show_id)->where(function ($query) use ($conditions) {
                            $query->whereRaw(implode(' OR ', $conditions));
                        })->whereNotIn('id', [$content_data['id']])->where('video_type', $content_data['video_type']);
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                if ($video_type == 1) {

                    $this->common->add_url_to_array(1, $data);
                    $this->common->rent_price_list($data);
                    for ($i = 0; $i < count($data); $i++) {

                        $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['sub_video_type'] = 0;
                        $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                        $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                    }
                } else if ($video_type == 2) {

                    $this->common->add_url_to_array(2, $data);
                    $this->common->rent_price_list($data);
                    for ($i = 0; $i < count($data); $i++) {

                        $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 0, $data[$i]['id']);
                        $data[$i]['sub_video_type'] = 0;
                        $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 0, $data[$i]['id'], 0);
                        $data[$i]['is_user_download'] = 0;
                    }
                    $this->common->rent_price_list($data);
                } else if ($video_type == 5 || $video_type == 6 || $video_type == 7) {

                    if ($sub_video_type == 1) {

                        $this->common->add_url_to_array(1, $data);
                        $this->common->rent_price_list($data);
                        for ($i = 0; $i < count($data); $i++) {

                            $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 1, $data[$i]['id']);
                            $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 1, $data[$i]['id']);
                            $data[$i]['sub_video_type'] = 1;
                            $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 1, $data[$i]['id'], 0);
                            $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $data[$i]['video_type'], 1, $data[$i]['id'], 0);
                        }
                    } else if ($sub_video_type == 2) {

                        $this->common->add_url_to_array(2, $data);
                        $this->common->rent_price_list($data);
                        for ($i = 0; $i < count($data); $i++) {

                            $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $data[$i]['video_type'], 2, $data[$i]['id']);
                            $data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $data[$i]['video_type'], 2, $data[$i]['id']);
                            $data[$i]['sub_video_type'] = 2;
                            $data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $data[$i]['video_type'], 2, $data[$i]['id'], 0);
                            $data[$i]['is_user_download'] = 0;
                        }
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function cast_detail(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'cast_id' => 'required|numeric',
                ],
                [
                    'cast_id.required' => __('label.controller.cast_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $data = Cast::where('id', $request['cast_id'])->first();
            if ($data != null && isset($data)) {

                $this->common->imageNameToUrl(array($data), 'image', $this->folder_cast, 'profile');

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function content_by_category(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required|numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'category_id.required' => __('label.controller.category_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $category_id = $request['category_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request->page_no ?? 1;

            $show_id = $this->common->get_tv_show_ids_by_episode();

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_parent_control_status == 1) {

                $video_data = Video::where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$category_id', category_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$category_id', category_id)")->latest()->get();
            } else {

                $video_data = Video::where('status', 1)->whereIn('video_type', [1, 6, 7])->whereRaw("FIND_IN_SET('$category_id', category_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->whereIn('video_type', [2, 6, 7])->whereRaw("FIND_IN_SET('$category_id', category_id)")->latest()->get();
            }

            $this->common->add_url_to_array(1, $video_data);
            $this->common->rent_price_list($video_data);
            for ($i = 0; $i < count($video_data); $i++) {

                $video_sub_type = 0;
                if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                    $video_sub_type = 1;
                }

                $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['sub_video_type'] = $video_sub_type;
                $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
            }

            $this->common->add_url_to_array(2, $tvshow_data);
            $this->common->rent_price_list($tvshow_data);
            for ($i = 0; $i < count($tvshow_data); $i++) {

                $show_sub_type = 0;
                if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                    $show_sub_type = 2;
                }

                $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = 0;
            }

            $video_data = $video_data->toArray();
            $tvshow_data = $tvshow_data->toArray();

            $fin_array = array_merge($video_data, $tvshow_data);

            usort($fin_array, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $paginator->items();

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function content_by_language(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'language_id' => 'required|numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'language_id.required' => __('label.controller.language_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $language_id = $request['language_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request->page_no ?? 1;

            $show_id = $this->common->get_tv_show_ids_by_episode();

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_parent_control_status == 1) {

                $video_data = Video::where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$language_id', language_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$language_id', language_id)")->latest()->get();
            } else {

                $video_data = Video::where('status', 1)->whereIn('video_type', [1, 6, 7])->whereRaw("FIND_IN_SET('$language_id', language_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->whereIn('video_type', [2, 6, 7])->whereRaw("FIND_IN_SET('$language_id', language_id)")->latest()->get();
            }

            $this->common->add_url_to_array(1, $video_data);
            $this->common->rent_price_list($video_data);
            for ($i = 0; $i < count($video_data); $i++) {

                $video_sub_type = 0;
                if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                    $video_sub_type = 1;
                }

                $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['sub_video_type'] = $video_sub_type;
                $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
            }

            $this->common->add_url_to_array(2, $tvshow_data);
            $this->common->rent_price_list($tvshow_data);
            for ($i = 0; $i < count($tvshow_data); $i++) {

                $show_sub_type = 0;
                if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                    $show_sub_type = 2;
                }

                $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = 0;
            }

            $video_data = $video_data->toArray();
            $tvshow_data = $tvshow_data->toArray();

            $fin_array = array_merge($video_data, $tvshow_data);

            usort($fin_array, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $paginator->items();

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function content_by_cast(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'cast_id' => 'required|numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'cast_id.required' => __('label.controller.cast_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $cast_id = $request['cast_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request->page_no ?? 1;

            $show_id = $this->common->get_tv_show_ids_by_episode();

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_parent_control_status == 1) {

                $video_data = Video::where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$cast_id', cast_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->where('video_type', 7)->whereRaw("FIND_IN_SET('$cast_id', cast_id)")->latest()->get();
            } else {

                $video_data = Video::where('status', 1)->whereIn('video_type', [1, 6, 7])->whereRaw("FIND_IN_SET('$cast_id', cast_id)")->latest()->get();
                $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->whereIn('video_type', [2, 6, 7])->whereRaw("FIND_IN_SET('$cast_id', cast_id)")->latest()->get();
            }

            $this->common->add_url_to_array(1, $video_data);
            $this->common->rent_price_list($video_data);
            for ($i = 0; $i < count($video_data); $i++) {

                $video_sub_type = 0;
                if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                    $video_sub_type = 1;
                }

                $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['sub_video_type'] = $video_sub_type;
                $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
            }

            $this->common->add_url_to_array(2, $tvshow_data);
            $this->common->rent_price_list($tvshow_data);
            for ($i = 0; $i < count($tvshow_data); $i++) {

                $show_sub_type = 0;
                if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                    $show_sub_type = 2;
                }

                $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = 0;
            }

            $video_data = $video_data->toArray();
            $tvshow_data = $tvshow_data->toArray();

            $fin_array = array_merge($video_data, $tvshow_data);

            usort($fin_array, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $paginator->items();

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function content_by_channel(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'channel_id' => 'required|numeric',
                    'user_id' => 'numeric',
                ],
                [
                    'channel_id.required' => __('label.controller.channel_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $channel_id = $request['channel_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request->page_no ?? 1;

            $show_id = $this->common->get_tv_show_ids_by_episode();

            $video_data = Video::where('status', 1)->where('video_type', 6)->where('channel_id', $channel_id)->latest()->get();
            $tvshow_data = TVShow::whereIn('id', $show_id)->where('status', 1)->where('video_type', 6)->where('channel_id', $channel_id)->latest()->get();

            $this->common->add_url_to_array(1, $video_data);
            $this->common->rent_price_list($video_data);
            for ($i = 0; $i < count($video_data); $i++) {

                $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], 1, $video_data[$i]['id']);
                $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], 1, $video_data[$i]['id']);
                $video_data[$i]['sub_video_type'] = 1;
                $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], 1, $video_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], 1, $video_data[$i]['id'], 0);
            }

            $this->common->add_url_to_array(2, $tvshow_data);
            $this->common->rent_price_list($tvshow_data);
            for ($i = 0; $i < count($tvshow_data); $i++) {

                $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], 2, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], 2, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['sub_video_type'] = 2;
                $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], 2, $tvshow_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = 0;
            }

            $video_data = $video_data->toArray();
            $tvshow_data = $tvshow_data->toArray();

            $fin_array = array_merge($video_data, $tvshow_data);

            usort($fin_array, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $paginator->items();

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_continue_watching(Request $request) // Video Type :- 1-Video, 2-Show, 6-Channel, 7-Kids
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'is_parent' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'video_id' => 'required|numeric',
                    'episode_id' => 'numeric',
                    'stop_time' => 'required|numeric',
                ],
                [
                    'is_parent.required' => __('label.controller.is_parent_is_required'),
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                    'stop_time.required' => __('label.controller.stop_time_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_parent = $request['is_parent'];
            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $video_id = $request['video_id'];
            $episode_id = isset($request['episode_id']) ? $request['episode_id'] : 0;
            $stop_time = $request['stop_time'];

            $data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', $video_type)->where('video_id', $video_id)->orderBy('id', 'desc')->latest()->first();
            if ($data != null && isset($data)) {

                if ($video_type == 2) {
                    Video_Watch::where('id', $data['id'])->update(['episode_id' => $episode_id, 'stop_time' => $stop_time, 'status' => '1']);
                } else if (($video_type == 6 || $video_type == 7) && $sub_video_type == 2) {
                    Video_Watch::where('id', $data['id'])->update(['episode_id' => $episode_id, 'stop_time' => $stop_time, 'status' => '1']);
                } else {
                    Video_Watch::where('id', $data['id'])->update(['stop_time' => $stop_time, 'status' => '1']);
                }
                return $this->common->API_Response(200, __('label.controller.add_successfully'));
            } else {

                $insert = new Video_Watch();
                $insert['is_parent'] = $is_parent;
                $insert['user_id'] = $user_id;
                $insert['video_type'] = $video_type;
                $insert['sub_video_type'] = $sub_video_type;
                $insert['video_id'] = $video_id;
                $insert['episode_id'] = $episode_id;
                $insert['stop_time'] = $stop_time;
                $insert['status'] = 1;
                if ($insert->save()) {
                    return $this->common->API_Response(200, __('label.controller.add_successfully'));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_save'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function remove_continue_watching(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'is_parent' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                ],
                [
                    'is_parent.required' => __('label.controller.is_parent_is_required'),
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_parent = $request['is_parent'];
            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;

            Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', $video_type)->where('sub_video_type', $sub_video_type)->where('video_id', $video_id)->delete();
            return $this->common->API_Response(200, __('label.controller.remove_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_remove_bookmark(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'is_parent' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'video_id' => 'required|numeric',
                ],
                [
                    'is_parent.required' => __('label.controller.is_parent_is_required'),
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_parent = $request->is_parent;
            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $video_id = $request['video_id'];

            $data = Bookmark::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_id', $video_id)->where('sub_video_type', $sub_video_type)->where('video_type', $video_type)->first();
            if ($data != null && isset($data)) {

                $data->delete();
                return $this->common->API_Response(200, __('label.controller.remove_successfully'));
            } else {

                $insert = new Bookmark();
                $insert['is_parent'] = $is_parent;
                $insert['user_id'] = $user_id;
                $insert['video_type'] = $video_type;
                $insert['sub_video_type'] = $sub_video_type;
                $insert['video_id'] = $video_id;
                $insert['status'] = 1;
                if ($insert->save()) {
                    return $this->common->API_Response(200, __('label.controller.add_successfully'));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_save'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_video_view(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'video_id' => 'required|numeric',
                    'episode_id' => 'numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $episode_id = isset($request['episode_id']) ? $request['episode_id'] : 0;

            if ($video_type == 1) {

                Video::where('id', $video_id)->increment('total_view', 1);
            } else if ($video_type == 2) {

                TVShow::where('id', $video_id)->increment('total_view', 1);
                TVShow_Video::where('show_id', $video_id)->where('id', $episode_id)->increment('total_view', 1);
            } else if ($video_type == 6 || $video_type == 7) {

                if ($sub_video_type == 1) {

                    Video::where('id', $video_id)->increment('total_view', 1);
                } else if ($sub_video_type == 2) {

                    TVShow::where('id', $video_id)->increment('total_view', 1);
                    TVShow_Video::where('show_id', $video_id)->where('id', $episode_id)->increment('total_view', 1);
                }
            }

            return $this->common->API_Response(200, __('label.controller.view_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_transaction(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'package_id' => 'required|numeric',
                    'price' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'package_id.required' => __('label.controller.package_id_is_required'),
                    'price.required' => __('label.controller.price_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $package_id = $request['package_id'];
            $price = $request['price'];
            $unique_id = isset($request->unique_id) ? $request->unique_id : "";
            $transaction_id = isset($request->transaction_id) ? $request->transaction_id : "";
            $description = isset($request->description) ? $request->description : "";

            $Pdata = Package::where('id', $package_id)->where('status', 1)->first();
            if (!empty($Pdata)) {
                $expiry_date = date("Y-m-d", strtotime("$Pdata->time $Pdata->type"));
            } else {
                return $this->common->API_Response(400, __('label.controller.please_enter_right_package_id'));
            }

            $insert = new Transction();
            $insert['unique_id'] = $unique_id;
            $insert['user_id'] = $user_id;
            $insert['package_id'] = $package_id;
            $insert['transaction_id'] = $transaction_id;
            $insert['price'] = $price;
            $insert['description'] = $description;
            $insert['expiry_date'] = $expiry_date;
            $insert['status'] = 1;
            if ($insert->save()) {

                $user_data = User::where('id', $user_id)->first();
                if (isset($user_data) && $user_data != null) {

                    // Send Mail (Type = 1- Register Mail, 2 Transaction Mail)
                    $this->common->Send_Mail(2, $user_data['email']);
                }

                return $this->common->API_Response(200, __('label.controller.add_successfully'), []);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_rent_transaction(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'price' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                    'price.required' => __('label.controller.price_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $price = $request['price'];
            $unique_id = isset($request->unique_id) ? $request->unique_id : "";
            $transaction_id = isset($request->transaction_id) ? $request->transaction_id : "";
            $description = isset($request->description) ? $request->description : "";
            $sub_video_type = isset($request->sub_video_type) ? $request->sub_video_type : 0;

            if ($video_type == 1) {
                $Rent_Video = Video::where('id', $video_id)->where('video_type', 1)->where('status', 1)->where('is_rent', 1)->first();
            } else if ($video_type == 2) {
                $Rent_Video = TVShow::where('id', $video_id)->where('video_type', 2)->where('status', 1)->where('is_rent', 1)->first();
            } else if ($video_type == 5 || $video_type == 6 || $video_type == 7) {
                if ($sub_video_type == 1) {
                    $Rent_Video = Video::where('id', $video_id)->where('video_type', $video_type)->where('status', 1)->where('is_rent', 1)->first();
                } else if ($sub_video_type == 2) {
                    $Rent_Video = TVShow::where('id', $video_id)->where('video_type', $video_type)->where('status', 1)->where('is_rent', 1)->first();
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.please_enter_right_rent_video'));
            }

            if (isset($Rent_Video) && $Rent_Video != null) {
                $expiry_date = date("Y-m-d", strtotime("$Rent_Video->rent_day days"));
            } else {
                return $this->common->API_Response(400, __('label.controller.please_enter_right_rent_video'));
            }

            $insert = new Rent_Transction();
            $insert['unique_id'] = $unique_id;
            $insert['user_id'] = $user_id;
            $insert['video_type'] = $video_type;
            $insert['sub_video_type'] = $sub_video_type;
            $insert['video_id'] = $video_id;
            $insert['price'] = $price;
            $insert['transaction_id'] = $transaction_id;
            $insert['description'] = $description;
            $insert['expiry_date'] = $expiry_date;
            $insert['status'] = 1;

            if ($insert->save()) {

                $user_data = User::where('id', $user_id)->first();
                if (isset($user_data) && $user_data != null) {

                    // Send Mail (Type = 1- Register Mail, 2 Transaction Mail)
                    $this->common->Send_Mail(2, $user_data['email']);
                }
                return $this->common->API_Response(200, __('label.controller.add_successfully'), []);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_remove_download(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'video_id' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $video_id = $request['video_id'];
            $episode_id = isset($request['episode_id']) ? $request['episode_id'] : 0;

            $data = Download::where('user_id', $user_id)->where('video_id', $video_id)->where('sub_video_type', $sub_video_type)->where('video_type', $video_type)->where('episode_id', $episode_id)->first();
            if (isset($data) && $data != null) {

                $data->delete();
                return $this->common->API_Response(200, __('label.controller.delete_success'), []);
            } else {

                $insert = new Download();
                $insert['user_id'] = $user_id;
                $insert['video_type'] = $video_type;
                $insert['sub_video_type'] = $sub_video_type;
                $insert['video_id'] = $video_id;
                $insert['episode_id'] = $episode_id;
                if ($insert->save()) {
                    return $this->common->API_Response(200, __('label.controller.add_successfully'), []);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_save'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_bookmark_video(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'is_parent' => 'required|numeric',
                    'user_id' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_parent = $request['is_parent'];
            $user_id = $request['user_id'];
            $page_no = $request->page_no ?? 1;
            $data = array();

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_parent_control_status == 1) {
                $All_Video = Bookmark::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', 7)->where('status', 1)->latest()->get();
            } else {
                $All_Video = Bookmark::where('is_parent', $is_parent)->where('user_id', $user_id)->where('status', 1)->latest()->get();
            }

            foreach ($All_Video as $key => $value) {

                if ($value['video_type'] == 1) {

                    $Video = Video::where('id', $value['video_id'])->where('video_type', 1)->where('status', 1)->first();
                    if ($Video != null && isset($Video)) {

                        $this->common->add_url_to_array(1, array($Video));
                        $this->common->rent_price_list(array($Video));
                        $Video['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $Video['rent_buy'] = $this->common->is_rent_buy($user_id, $Video['video_type'], 0, $Video['id']);
                        $Video['is_bookmark'] = $this->common->is_bookmark($user_id, $Video['video_type'], 0, $Video['id']);
                        $Video['sub_video_type'] = 0;
                        $Video['stop_time'] = $this->common->get_stop_time($user_id, $Video['video_type'], 0, $Video['id'], 0);
                        $Video['is_user_download'] = $this->common->is_user_download($user_id, $Video['video_type'], 0, $Video['id'], 0);
                        $data[] = $Video;
                    }
                } elseif ($value['video_type'] == 2) {

                    $Video = TVShow::where('id', $value['video_id'])->where('video_type', 2)->where('status', 1)->first();
                    if ($Video != null && isset($Video)) {

                        $this->common->add_url_to_array(2, array($Video));
                        $this->common->rent_price_list(array($Video));
                        $Video['is_buy'] = $this->common->is_any_package_buy($user_id);
                        $Video['rent_buy'] = $this->common->is_rent_buy($user_id, $Video['video_type'], 0, $Video['id']);
                        $Video['is_bookmark'] = $this->common->is_bookmark($user_id, $Video['video_type'], 0, $Video['id']);
                        $Video['sub_video_type'] = 0;
                        $Video['stop_time'] = $this->common->get_stop_time($user_id, $Video['video_type'], 0, $Video['id'], 0);
                        $Video['is_user_download'] = 0;
                        $data[] = $Video;
                    }
                } elseif ($value['video_type'] == 5 || $value['video_type'] == 6 || $value['video_type'] == 7) {

                    if ($value['sub_video_type'] == 1) {

                        $Video = Video::where('id', $value['video_id'])->where('status', 1)->where('video_type', $value['video_type'])->first();
                        if ($Video != null && isset($Video)) {

                            $this->common->add_url_to_array(1, array($Video));
                            $this->common->rent_price_list(array($Video));
                            $Video['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $Video['rent_buy'] = $this->common->is_rent_buy($user_id, $Video['video_type'], 1, $Video['id']);
                            $Video['is_bookmark'] = $this->common->is_bookmark($user_id, $Video['video_type'], 1, $Video['id']);
                            $Video['sub_video_type'] = 1;
                            $Video['stop_time'] = $this->common->get_stop_time($user_id, $Video['video_type'], 1, $Video['id'], 0);
                            $Video['is_user_download'] = $this->common->is_user_download($user_id, $Video['video_type'], 1, $Video['id'], 0);
                            $data[] = $Video;
                        }
                    } else if ($value['sub_video_type'] == 2) {

                        $Video = TVShow::where('id', $value['video_id'])->where('video_type', $value['video_type'])->where('status', 1)->first();
                        if ($Video != null && isset($Video)) {

                            $this->common->add_url_to_array(2, array($Video));
                            $this->common->rent_price_list(array($Video));
                            $Video['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $Video['rent_buy'] = $this->common->is_rent_buy($user_id, $Video['video_type'], 1, $Video['id']);
                            $Video['is_bookmark'] = $this->common->is_bookmark($user_id, $Video['video_type'], 1, $Video['id']);
                            $Video['sub_video_type'] = 1;
                            $Video['stop_time'] = $this->common->get_stop_time($user_id, $Video['video_type'], 1, $Video['id'], 0);
                            $Video['is_user_download'] = 0;
                            $data[] = $Video;
                        }
                    }
                }
            }

            $currentItems = array_slice($data, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($currentItems, count($data), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $paginator->items();

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_video_by_season_id(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'show_id' => 'required|numeric',
                    'season_id' => 'required|numeric',
                ],
                [
                    'show_id.required' => __('label.controller.show_id_is_required'),
                    'season_id.required' => __('label.controller.season_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $show_id = $request['show_id'];
            $season_id = $request['season_id'];
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            $show_data = TVShow::where('id', $show_id)->first();
            $data = TVShow_Video::where('season_id', $season_id)->where('show_id', $show_id)->where('status', 1)->orderBy('sortable', 'asc');

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                $this->common->add_url_to_array(3, $data);

                $sub_video_type = 0;
                if ($show_data['video_type'] != 2) {
                    $sub_video_type = 2;
                }

                for ($i = 0; $i < count($data); $i++) {

                    $data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $data[$i]['is_rent'] = $show_data['is_rent'];
                    $data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $show_data['video_type'], $sub_video_type, $show_id);
                    $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $show_data['video_type'], $sub_video_type, $show_data['id'], $data[$i]['id']);
                }

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_transaction_list(Request $request)
    {
        try {

            $this->common->package_expiry();

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request->user_id;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            $data = Transction::where('user_id', $user_id)->with('package')->orderBy('id', 'desc');

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                foreach ($data as $key => $value) {

                    $value['package_name'] = "";
                    $value['package_price'] = 0;
                    if ($value['package'] != null) {
                        $value['package_name'] = $value['package']['name'];
                        $value['package_price'] = $value['package']['price'];
                    }

                    $value['date'] = $value['created_at']->format('Y-m-d');
                    unset($value['package']);
                }
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function apply_coupon(Request $request) // apply_coupon_type : 1- Package, 2- Rent Video
    {
        try {

            if ($request['apply_coupon_type'] == 1) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'user_id' => 'required|numeric',
                        'package_id' => 'required|numeric',
                        'unique_id' => 'required',
                    ],
                    [
                        'user_id.required' => __('label.controller.user_id_is_required'),
                        'package_id.required' => __('label.controller.package_id_is_required'),
                        'unique_id.required' => __('label.controller.unique_id_is_required'),
                    ]
                );
                if ($validation->fails()) {
                    $data['status'] = 400;
                    $data['message'] = $validation->errors()->first();
                    return $data;
                }
            } elseif ($request['apply_coupon_type'] == 2) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'user_id' => 'required|numeric',
                        'unique_id' => 'required',
                        'video_type' => 'required|numeric',
                        'sub_video_type' => 'numeric',
                        'video_id' => 'required|numeric',
                        'price' => 'required|numeric',
                    ],
                    [
                        'user_id.required' => __('label.controller.user_id_is_required'),
                        'unique_id.required' => __('label.controller.unique_id_is_required'),
                        'video_type.required' => __('label.controller.video_type_is_required'),
                        'video_id.required' => __('label.controller.video_id_is_required'),
                        'price.required' => __('label.controller.price_is_required'),
                    ]
                );
                if ($validation->fails()) {
                    $data['status'] = 400;
                    $data['message'] = $validation->errors()->first();
                    return $data;
                }
            } else {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'apply_coupon_type' => 'required|numeric',
                    ],
                    [
                        'apply_coupon_type.required' => __('label.controller.apply_coupon_type_is_required'),
                    ]
                );
                if ($validation->fails()) {
                    $data['status'] = 400;
                    $data['message'] = $validation->errors()->first();
                    return $data;
                }
            }

            $user_id = $request['user_id'];
            $unique_id = $request['unique_id'];
            $date = date("Y-m-d");
            $array = array();

            $coupon_check = Coupon::where('unique_id', $unique_id)->first();
            if (isset($coupon_check) && $coupon_check != null) {

                if ($coupon_check['start_date'] > $date) {
                    return $this->common->API_Response(400, __('label.controller.coupon_not_start'));
                }
                if ($coupon_check['end_date'] < $date) {
                    return $this->common->API_Response(400, __('label.controller.coupon_expriy'));
                }
                if ($coupon_check['is_use'] == 1) {

                    $use_check = Transction::where('unique_id', $coupon_check['unique_id'])->first();
                    $rent_use_check = Rent_Transction::where('unique_id', $coupon_check['unique_id'])->first();
                    if (isset($use_check) || isset($rent_use_check)) {
                        return $this->common->API_Response(400, __('label.controller.coupon_already_use'));
                    }
                }

                if ($request['apply_coupon_type'] == 1) {

                    $Pdata = Package::where('id', $request['package_id'])->where('status', 1)->first();
                    if (empty($Pdata)) {
                        return $this->common->API_Response(400, __('label.controller.please_enter_right_package_id'));
                    }

                    $discount_amount = 0;
                    if ($coupon_check['amount_type'] == 1) {

                        $discount_amount = $Pdata['price'] - $coupon_check['price'];
                    } elseif ($coupon_check['amount_type'] == 2) {

                        $minus_amount = ($coupon_check['price'] / 100) * $Pdata['price'];
                        $discount_amount = $Pdata['price'] - $minus_amount;

                        if ($discount_amount > $Pdata['price']) {
                            $discount_amount = 0;
                        }
                    }
                    $discount_amount = max($discount_amount, 0);

                    $array = array(
                        'id' => $coupon_check['id'],
                        'unique_id' => $unique_id,
                        'total_amount' => $Pdata['price'],
                        'discount_amount' => $discount_amount,
                    );
                } elseif ($request['apply_coupon_type'] == 2) {

                    if ($request['video_type'] == 1) {
                        $Rent_Video = Video::where('id', $request['video_id'])->where('video_type', 1)->where('status', 1)->where('is_rent', 1)->first();
                    } else if ($request['video_type'] == 2) {
                        $Rent_Video = TVShow::where('id', $request['video_id'])->where('video_type', 2)->where('status', 1)->where('is_rent', 1)->first();
                    } else if ($request['video_type'] == 5 || $request['video_type'] == 6 || $request['video_type'] == 7) {
                        if ($request['sub_video_type'] == 1) {
                            $Rent_Video = Video::where('id', $request['video_id'])->where('video_type', $request['video_type'])->where('status', 1)->where('is_rent', 1)->first();
                        } else if ($request['sub_video_type'] == 2) {
                            $Rent_Video = TVShow::where('id', $request['video_id'])->where('video_type', $request['video_type'])->where('status', 1)->where('is_rent', 1)->first();
                        }
                    } else {
                        return $this->common->API_Response(400, __('label.controller.please_enter_right_rent_video'));
                    }

                    $discount_amount = 0;
                    if ($coupon_check['amount_type'] == 1) {

                        $discount_amount = $Rent_Video['price'] - $coupon_check['price'];
                    } elseif ($coupon_check['amount_type'] == 2) {

                        $minus_amount = ($coupon_check['price'] / 100) * $Rent_Video['price'];
                        $discount_amount = $Rent_Video['price'] - $minus_amount;

                        if ($discount_amount > $Rent_Video['price']) {
                            $discount_amount = 0;
                        }
                    }
                    $discount_amount = max($discount_amount, 0);

                    $array = array(
                        'id' => $coupon_check['id'],
                        'unique_id' => $unique_id,
                        'total_amount' => $Rent_Video['price'],
                        'discount_amount' => $discount_amount,
                    );
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.coupon_id_worng'));
            }

            return $this->common->API_Response(200, __('label.controller.add_successfully'), $array);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function rent_content_list(Request $request) // type : 1- Video, 2- Show
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'numeric',
                ],
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $type = $request['type'];
            $type = isset($request['type']) ? $request['type'] : 0;
            $user_id = isset($request['user_id']) ? $request['user_id'] : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            if (isset($type) && $type != 0) {

                // Check Parent Control
                $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
                if ($user_parent_control_status == 1) {

                    if ($type == 1) {
                        $data = Video::where('is_rent', 1)->where('video_type', 7)->where('status', 1)->orderBy('id', 'desc');
                    } else if ($type == 2) {

                        $show_id = $this->common->get_tv_show_ids_by_episode();
                        $data = TVShow::whereIn('id', $show_id)->where('is_rent', 1)->where('video_type', 7)->where('status', 1)->orderBy('id', 'desc');
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                } else {

                    if ($type == 1) {
                        $data = Video::where('is_rent', 1)->whereIn('video_type', [1, 6, 7])->where('status', 1)->orderBy('id', 'desc');
                    } else if ($type == 2) {

                        $show_id = $this->common->get_tv_show_ids_by_episode();
                        $data = TVShow::whereIn('id', $show_id)->where('is_rent', 1)->whereIn('video_type', [2, 6, 7])->where('status', 1)->orderBy('id', 'desc');
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_found'));
                    }
                }

                $total_rows = $data->count();
                $total_page = $this->page_limit;
                $page_size = ceil($total_rows / $total_page);
                $offset = $page_no * $total_page - $total_page;

                $more_page = $this->common->more_page($page_no, $page_size);
                $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

                $data->take($total_page)->offset($offset);
                $data = $data->latest()->get();

                if (count($data) > 0) {

                    $this->common->add_url_to_array($type, $data);
                    $this->common->rent_price_list($data);

                    for ($i = 0; $i < count($data); $i++) {

                        if ($data[$i]['video_type'] == 1 || $data[$i]['video_type'] == 2) {
                            $data[$i]['sub_video_type'] = 0;
                        } elseif ($data[$i]['video_type'] == 5 || $data[$i]['video_type'] == 6 || $data[$i]['video_type'] == 7) {
                            $data[$i]['sub_video_type'] = $type;
                        } else {
                            $data[$i]['sub_video_type'] = 0;
                        }
                        $data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $data[$i]['video_type'], $data[$i]['sub_video_type'], $data[$i]['id'], 0);
                    }

                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {

                // Check Parent Control
                $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
                $show_id = $this->common->get_tv_show_ids_by_episode();
                if ($user_parent_control_status == 1) {
                    $video_data = Video::where('is_rent', 1)->where('video_type', 7)->where('status', 1)->orderBy('id', 'desc')->get();
                    $tvshow_data = TVShow::whereIn('id', $show_id)->where('is_rent', 1)->where('video_type', 7)->where('status', 1)->orderBy('id', 'desc')->get();
                } else {
                    $video_data = Video::where('is_rent', 1)->whereIn('video_type', [1, 6, 7])->where('status', 1)->orderBy('id', 'desc')->get();
                    $tvshow_data = TVShow::whereIn('id', $show_id)->where('is_rent', 1)->whereIn('video_type', [2, 6, 7])->where('status', 1)->orderBy('id', 'desc')->get();
                }

                $this->common->add_url_to_array(1, $video_data);
                $this->common->rent_price_list($video_data);
                for ($i = 0; $i < count($video_data); $i++) {

                    $video_sub_type = 0;
                    if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                        $video_sub_type = 1;
                    }

                    $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                    $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                    $video_data[$i]['sub_video_type'] = $video_sub_type;
                    $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                    $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                }

                $this->common->add_url_to_array(2, $tvshow_data);
                $this->common->rent_price_list($tvshow_data);
                for ($i = 0; $i < count($tvshow_data); $i++) {

                    $show_sub_type = 0;
                    if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                        $show_sub_type = 2;
                    }

                    $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                    $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                    $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                    $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                    $video_data[$i]['is_user_download'] = 0;
                }

                $video_data = $video_data->toArray();
                $tvshow_data = $tvshow_data->toArray();

                $fin_array = array_merge($video_data, $tvshow_data);

                usort($fin_array, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });

                $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

                $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
                $more_page = $this->common->more_page($page_no, $paginator->lastPage());

                $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
                $response['data'] = $paginator->items();

                if (count($response['data']) > 0) {
                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function user_rent_content_list(Request $request) // type : 1- Video, 2- Show
    {
        try {

            $this->common->rent_expiry();

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $type = isset($request['type']) ? $request['type'] : 0;
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            if (isset($type) && $type != 0) {

                $Rent_Data = Rent_Transction::where('user_id', $user_id)->where('status', 1)->get();
                if ($type == 1) {

                    $video_ids = [];
                    foreach ($Rent_Data as $key => $value) {

                        if ($value['video_type'] == 1) {

                            $Video = Video::where('id', $value['video_id'])->first();
                            if (isset($Video) && $Video != null) {
                                $video_ids[] = $Video['id'];
                            }
                        } elseif ($value['video_type'] == 5 || $value['video_type'] == 6 || $value['video_type'] == 7 && $value['sub_video_type'] == 1) {

                            $Video = Video::where('id', $value['video_id'])->first();
                            if (isset($Video) && $Video != null) {
                                $video_ids[] = $Video['id'];
                            }
                        }
                    }

                    $data = Video::whereIn('id', $video_ids)->where('status', 1)->orderBy('id', 'desc');
                } else if ($type == 2) {

                    $video_ids = [];
                    foreach ($Rent_Data as $key => $value) {

                        if ($value['video_type'] == 1) {

                            $Video = TVShow::where('id', $value['video_id'])->first();
                            if (isset($Video) && $Video != null) {
                                $video_ids[] = $Video['id'];
                            }
                        } elseif ($value['video_type'] == 5 || $value['video_type'] == 6 || $value['video_type'] == 7 && $value['sub_video_type'] == 1) {

                            $Video = TVShow::where('id', $value['video_id'])->first();
                            if (isset($Video) && $Video != null) {
                                $video_ids[] = $Video['id'];
                            }
                        }
                    }

                    $data = TVShow::whereIn('id', $video_ids)->where('status', 1)->orderBy('id', 'desc');
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }

                $total_rows = $data->count();
                $total_page = $this->page_limit;
                $page_size = ceil($total_rows / $total_page);
                $offset = $page_no * $total_page - $total_page;

                $more_page = $this->common->more_page($page_no, $page_size);
                $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

                $data->take($total_page)->offset($offset);
                $data = $data->latest()->get();

                if (count($data) > 0) {

                    $this->common->add_url_to_array($type, $data);
                    $this->common->rent_price_list($data);

                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $data, $pagination);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {

                $Rent_Data = Rent_Transction::where('user_id', $user_id)->where('status', 1)->get();

                $video_ids = [];
                $tvshow_ids = [];
                foreach ($Rent_Data as $key => $value) {

                    if ($value['video_type'] == 1) {
                        $Video = Video::where('id', $value['video_id'])->first();
                        if (isset($Video) && $Video != null) {
                            $video_ids[] = $Video['id'];
                        }
                    } elseif ($value['video_type'] == 5 || $value['video_type'] == 6 || $value['video_type'] == 7 && $value['sub_video_type'] == 1) {
                        $Video = Video::where('id', $value['video_id'])->first();
                        if (isset($Video) && $Video != null) {
                            $video_ids[] = $Video['id'];
                        }
                    } else if ($value['video_type'] == 2) {
                        $Video = TVShow::where('id', $value['video_id'])->first();
                        if (isset($Video) && $Video != null) {
                            $tvshow_ids[] = $Video['id'];
                        }
                    } elseif ($value['video_type'] == 5 || $value['video_type'] == 6 || $value['video_type'] == 7 && $value['sub_video_type'] == 2) {
                        $Video = TVShow::where('id', $value['video_id'])->first();
                        if (isset($Video) && $Video != null) {
                            $tvshow_ids[] = $Video['id'];
                        }
                    }
                }

                $video_data = Video::whereIn('id', $video_ids)->where('status', 1)->orderBy('id', 'desc')->get();
                $tvshow_data = TVShow::whereIn('id', $tvshow_ids)->where('status', 1)->orderBy('id', 'desc')->get();

                $this->common->add_url_to_array(1, $video_data);
                $this->common->rent_price_list($video_data);
                for ($i = 0; $i < count($video_data); $i++) {

                    $video_sub_type = 0;
                    if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                        $video_sub_type = 1;
                    }

                    $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                    $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                    $video_data[$i]['sub_video_type'] = $video_sub_type;
                    $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                    $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                }

                $this->common->add_url_to_array(2, $tvshow_data);
                $this->common->rent_price_list($tvshow_data);
                for ($i = 0; $i < count($tvshow_data); $i++) {

                    $show_sub_type = 0;
                    if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                        $show_sub_type = 2;
                    }

                    $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                    $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                    $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                    $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                    $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                    $video_data[$i]['is_user_download'] = 0;
                }

                $video_data = $video_data->toArray();
                $tvshow_data = $tvshow_data->toArray();

                $fin_array = array_merge($video_data, $tvshow_data);

                usort($fin_array, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });

                $currentItems = array_slice($fin_array, $this->page_limit * ($page_no - 1), $this->page_limit);

                $paginator = new LengthAwarePaginator($currentItems, count($fin_array), $this->page_limit, $page_no);
                $more_page = $this->common->more_page($page_no, $paginator->lastPage());

                $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
                $response['data'] = $paginator->items();

                if (count($response['data']) > 0) {
                    return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function search_content(Request $request)
    {
        try {
            $name = $request->input('name', '');
            $user_id = $request->input('user_id', 0);
            $page_no = $request->input('page_no', 1);

            $show_id = $this->common->get_tv_show_ids_by_episode();

            $user_status = $this->common->check_user_parent_control_status($user_id);
            $video_data = [];
            $tvshow_data = [];

            if ($name != "") {
                $category_data = Category::where('name', $name)->where('status', 1)->latest()->get();
                $language_data = Language::where('name', $name)->where('status', 1)->latest()->get();

                $category_ids = $category_data->pluck('id')->toArray();
                $language_ids = $language_data->pluck('id')->toArray();
            } else {
                $category_ids = [];
                $language_ids = [];
            }

            // Video
            $video_data = Video::whereIn('video_type', $user_status == 1 ? [7] : [1, 6, 7])
                ->where('status', 1)
                ->where(function ($query) use ($name, $category_ids, $language_ids) {
                    $query->where('name', 'LIKE', "%{$name}%")
                        ->orWhere(function ($query) use ($category_ids) {
                            foreach ($category_ids as $category_id) {
                                $query->orWhereRaw("FIND_IN_SET(?, category_id)", [$category_id]);
                            }
                        })
                        ->orWhere(function ($query) use ($language_ids) {
                            foreach ($language_ids as $language_id) {
                                $query->orWhereRaw("FIND_IN_SET(?, language_id)", [$language_id]);
                            }
                        });
                })
                ->orderBy('id', 'DESC')->latest()->get();

            $this->common->add_url_to_array(1, $video_data);
            $this->common->rent_price_list($video_data);
            for ($i = 0; $i < count($video_data); $i++) {

                $video_sub_type = 0;
                if ($video_data[$i]['video_type'] == 6 || $video_data[$i]['video_type'] == 7) {
                    $video_sub_type = 1;
                }

                $video_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $video_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id']);
                $video_data[$i]['sub_video_type'] = $video_sub_type;
                $video_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = $this->common->is_user_download($user_id, $video_data[$i]['video_type'], $video_sub_type, $video_data[$i]['id'], 0);
            }

            // Show
            $tvshow_data = TVShow::whereIn('id', $show_id)
                ->whereIn('video_type', $user_status == 1 ? [7] : [2, 6, 7])
                ->where('status', 1)
                ->where(function ($query) use ($name, $category_ids, $language_ids) {
                    $query->where('name', 'LIKE', "%{$name}%")
                        ->orWhere(function ($query) use ($category_ids) {
                            foreach ($category_ids as $category_id) {
                                $query->orWhereRaw("FIND_IN_SET(?, category_id)", [$category_id]);
                            }
                        })
                        ->orWhere(function ($query) use ($language_ids) {
                            foreach ($language_ids as $language_id) {
                                $query->orWhereRaw("FIND_IN_SET(?, language_id)", [$language_id]);
                            }
                        });
                })
                ->orderBy('id', 'DESC')->latest()->get();

            $this->common->add_url_to_array(2, $tvshow_data);
            $this->common->rent_price_list($tvshow_data);
            for ($i = 0; $i < count($tvshow_data); $i++) {

                $show_sub_type = 0;
                if ($tvshow_data[$i]['video_type'] == 6 || $tvshow_data[$i]['video_type'] == 7) {
                    $show_sub_type = 2;
                }

                $tvshow_data[$i]['is_buy'] = $this->common->is_any_package_buy($user_id);
                $tvshow_data[$i]['rent_buy'] = $this->common->is_rent_buy($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['is_bookmark'] = $this->common->is_bookmark($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id']);
                $tvshow_data[$i]['sub_video_type'] = $show_sub_type;
                $tvshow_data[$i]['stop_time'] = $this->common->get_stop_time($user_id, $tvshow_data[$i]['video_type'], $show_sub_type, $tvshow_data[$i]['id'], 0);
                $video_data[$i]['is_user_download'] = 0;
            }

            $merged_data = array_merge($video_data->toArray(), $tvshow_data->toArray());
            usort($merged_data, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $currentItems = array_slice($merged_data, $this->page_limit * ($page_no - 1), $this->page_limit);

            $paginator = new LengthAwarePaginator($merged_data, count($merged_data), $this->page_limit, $page_no);
            $more_page = $this->common->more_page($page_no, $paginator->lastPage());

            $response['pagination'] = $this->common->pagination_array($paginator->total(), $paginator->lastPage(), $page_no, $more_page);
            $response['data'] = $currentItems;

            if (count($response['data']) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $response['data'], $response['pagination']);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_continue_watching(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'is_parent' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'is_parent.required' => __('label.controller.is_parent_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $is_parent = $request['is_parent'];
            $user_id = $request['user_id'];
            $page_no = $request['page_no'] ?? 1;
            $page_size = 0;
            $more_page = false;

            // Check Parent Control
            $user_parent_control_status = $this->common->check_user_parent_control_status($user_id);
            if ($user_parent_control_status == 1) {
                $data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('video_type', 7)->where('status', 1)->latest()->orderBy('id', 'desc');
            } else {
                $data = Video_Watch::where('is_parent', $is_parent)->where('user_id', $user_id)->where('status', 1)->latest()->orderBy('id', 'desc');
            }

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $offset = $page_no * $total_page - $total_page;

            $more_page = $this->common->more_page($page_no, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $page_no, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                $final_array = [];
                for ($j = 0; $j < count($data); $j++) {

                    if ($data[$j]['video_type'] == 1) {

                        $content_data = Video::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', 1)->first();
                        if ($content_data != null && isset($content_data)) {

                            $this->common->add_url_to_array(1, array($content_data));
                            $this->common->rent_price_list(array($content_data));

                            $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                            $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                            $content_data['sub_video_type'] = 0;
                            $content_data['stop_time'] = $data[$j]['stop_time'];
                            $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                            $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], 0);
                            $final_array[] = $content_data;
                        }
                    } else if ($data[$j]['video_type'] == 2) {

                        $content_data = TVShow::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', 2)->first();
                        if ($content_data != null && isset($content_data)) {

                            $this->common->add_url_to_array(2, array($content_data));
                            $this->common->rent_price_list(array($content_data));

                            $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                            $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 0, $content_data['id']);
                            $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 0, $content_data['id']);
                            $content_data['sub_video_type'] = 0;
                            $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                            $content_data['is_user_download'] = 0;

                            $episode = [];
                            $episode_data = TVShow_Video::where('id', $data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                            if ($episode_data != null && isset($episode_data)) {

                                $this->common->add_url_to_array(3, array($episode_data));
                                $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 0, $content_data['id'], $episode_data['id']);

                                $episode = $episode_data->toArray();
                            }
                            $content_data['stop_time'] = $data[$j]['stop_time'];
                            $content_data['episode'] = $episode;

                            $final_array[] = $content_data;
                        }
                    } else if ($data[$j]['video_type'] == 6 || $data[$j]['video_type'] == 7) {

                        if ($data[$j]['sub_video_type'] == 1) {

                            $content_data = Video::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', $data[$j]['video_type'])->first();
                            if ($content_data != null && isset($content_data)) {

                                $this->common->add_url_to_array(1, array($content_data));
                                $this->common->rent_price_list(array($content_data));

                                $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 1, $content_data['id']);
                                $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 1, $content_data['id']);
                                $content_data['sub_video_type'] = 1;
                                $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                $content_data['stop_time'] = $data[$j]['stop_time'];
                                $content_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 1, $content_data['id'], 0);

                                $final_array[] = $content_data;
                            }
                        } else if ($data[$j]['sub_video_type'] == 2) {

                            $content_data = TVShow::where('id', $data[$j]['video_id'])->where('status', 1)->where('video_type', $data[$j]['video_type'])->first();
                            if ($content_data != null && isset($content_data)) {

                                $this->common->add_url_to_array(2, array($content_data));
                                $this->common->rent_price_list(array($content_data));

                                $content_data['is_buy'] = $this->common->is_any_package_buy($user_id);
                                $content_data['rent_buy'] = $this->common->is_rent_buy($user_id, $content_data['video_type'], 2, $content_data['id']);
                                $content_data['is_bookmark'] = $this->common->is_bookmark($user_id, $content_data['video_type'], 2, $content_data['id']);
                                $content_data['sub_video_type'] = 2;
                                $content_data['category_name'] = $this->common->get_category_name_by_ids($content_data['category_id']);
                                $content_data['is_user_download'] = 0;

                                $episode = [];
                                $episode_data = TVShow_Video::where('id', $data[$j]['episode_id'])->where('show_id', $content_data['id'])->where('status', 1)->first();
                                if ($episode_data != null && isset($episode_data)) {

                                    $this->common->add_url_to_array(3, array($episode_data));
                                    $episode_data['is_user_download'] = $this->common->is_user_download($user_id, $content_data['video_type'], 2, $content_data['id'], $episode_data['id']);

                                    $episode = $episode_data->toArray();
                                }
                                $content_data['stop_time'] = $data[$j]['stop_time'];
                                $content_data['episode'] = $episode;

                                $final_array[] = $content_data;
                            }
                        }
                    }
                }

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $final_array, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function add_remove_like(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                    'video_id' => 'required|numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $video_id = $request['video_id'];

            $data = Like::where('user_id', $user_id)->where('video_id', $video_id)->where('sub_video_type', $sub_video_type)->where('video_type', $video_type)->first();
            if ($data != null && isset($data)) {

                if ($data['video_type'] == 1) {
                    Video::where('id', $data['video_id'])->decrement('total_like', 1);
                } else if ($data['video_type'] == 2) {
                    TVShow::where('id', $data['video_id'])->decrement('total_like', 1);
                } else if ($data['video_type'] == 5 || $data['video_type'] == 6 || $data['video_type'] == 7) {
                    if ($data['sub_video_type'] == 1) {
                        Video::where('id', $data['video_id'])->decrement('total_like', 1);
                    } else if ($data['sub_video_type'] == 2) {
                        TVShow::where('id', $data['video_id'])->decrement('total_like', 1);
                    }
                }

                $data->delete();
                return $this->common->API_Response(200, __('label.controller.dislike_successfully'));
            } else {

                $insert = new Like();
                $insert['user_id'] = $user_id;
                $insert['video_type'] = $video_type;
                $insert['sub_video_type'] = $sub_video_type;
                $insert['video_id'] = $video_id;
                $insert['episode_id'] = 0;
                $insert['status'] = 1;
                if ($insert->save()) {

                    if ($video_type == 1) {
                        Video::where('id', $video_id)->increment('total_like', 1);
                    } else if ($video_type == 2) {
                        TVShow::where('id', $video_id)->increment('total_like', 1);
                    } else if ($video_type == 5 || $video_type == 6 || $video_type == 7) {
                        if ($sub_video_type == 1) {
                            Video::where('id', $video_id)->increment('total_like', 1);
                        } else if ($sub_video_type == 2) {
                            TVShow::where('id', $video_id)->increment('total_like', 1);
                        }
                    }
                    return $this->common->API_Response(200, __('label.controller.like_successfully'));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_save'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_comment(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'comment' => 'required',
                    'comment_id' => 'numeric',
                    'sub_video_type' => 'numeric',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                    'comment.required' => __('label.controller.comment_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $comment_id = isset($request['comment_id']) ? $request['comment_id'] : 0;
            $user_id = $request['user_id'];
            $video_type = $request['video_type'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $video_id = $request['video_id'];
            $episode_id = 0;
            $comment = $request['comment'];

            $insert = new Comment();
            $insert['comment_id'] = $comment_id;
            $insert['user_id'] = $user_id;
            $insert['video_type'] = $video_type;
            $insert['sub_video_type'] = $sub_video_type;
            $insert['video_id'] = $video_id;
            $insert['episode_id'] = $episode_id;
            $insert['comment'] = $comment;
            $insert['status'] = 1;
            if ($insert->save()) {
                return $this->common->API_Response(200, __('label.controller.comment_add_successfully'));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function edit_comment(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'comment_id' => 'required|numeric',
                    'comment' => 'required',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'comment.required' => __('label.controller.comment_is_required'),
                    'comment_id.required' => __('label.controller.comment_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $comment_id = $request['comment_id'];
            $comment = $request['comment'];

            $update = Comment::where('id', $comment_id)->first();
            if (isset($update) && $update != null) {

                $update['user_id'] = $user_id;
                $update['comment_id'] = $comment_id;
                $update['comment'] = $comment;
                $update->save();
                return $this->common->API_Response(200, __('label.controller.comment_edit_successfully'));
            }
            return $this->common->API_Response(200, __('label.controller.comment_not_found'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function delete_comment(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'comment_id' => 'required|numeric',
                ],
                [
                    'comment_id.required' => __('label.controller.comment_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $comment_id = $request['comment_id'];
            Comment::where('id', $comment_id)->delete();
            return $this->common->API_Response(200, __('label.controller.comment_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_comment(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'video_type' => 'required|numeric',
                    'video_id' => 'required|numeric',
                    'sub_video_type' => 'numeric',
                ],
                [
                    'video_type.required' => __('label.controller.video_type_is_required'),
                    'video_id.required' => __('label.controller.video_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $video_type = $request['video_type'];
            $video_id = $request['video_id'];
            $sub_video_type = isset($request['sub_video_type']) ? $request['sub_video_type'] : 0;
            $page_size = 0;
            $current_page = 0;
            $more_page = false;

            $data = Comment::where('comment_id', 0)->where('video_type', $video_type)->where('video_id', $video_id)->where('sub_video_type', $sub_video_type)->where('status', 1)->orderBy('id', 'desc')->with('user');

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $current_page = $request->page_no ?? 1;
            $offset = $current_page * $total_page - $total_page;

            $more_page = $this->common->more_page($current_page, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $current_page, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                for ($i = 0; $i < count($data); $i++) {

                    $data[$i]['user_name'] = "";
                    $data[$i]['full_name'] = "";
                    $data[$i]['email'] = "";
                    $data[$i]['image'] = "";
                    if ($data[$i]['user'] != null) {
                        $data[$i]['user_name'] = $data[$i]['user']['user_name'];
                        $data[$i]['full_name'] = $data[$i]['user']['full_name'];
                        $data[$i]['email'] = $data[$i]['user']['email'];
                        $data[$i]['image'] = $this->common->getImage($this->folder_user, $data[$i]['user']['image'], 'profile');
                    }
                    unset($data[$i]['user']);

                    $data[$i]['is_reply'] = 0;
                    $data[$i]['total_reply'] = 0;
                    $reply = Comment::where('comment_id', $data[$i]['id'])->count();
                    if ($reply != 0) {
                        $data[$i]['is_reply'] = 1;
                        $data[$i]['total_reply'] = $reply;
                    }
                }
                return $this->common->API_Response(200, __('label.controller.comment_get_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_reply_comment(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'comment_id' => 'required|numeric',
                ],
                [
                    'comment_id.required' => __('label.controller.comment_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $comment_id = $request['comment_id'];

            $page_size = 0;
            $current_page = 0;
            $more_page = false;

            $data = Comment::where('comment_id', $comment_id)->where('status', 1)->orderBy('id', 'desc')->with('user');

            $total_rows = $data->count();
            $total_page = $this->page_limit;
            $page_size = ceil($total_rows / $total_page);
            $current_page = $request->page_no ?? 1;
            $offset = $current_page * $total_page - $total_page;

            $more_page = $this->common->more_page($current_page, $page_size);
            $pagination = $this->common->pagination_array($total_rows, $page_size, $current_page, $more_page);

            $data->take($total_page)->offset($offset);
            $data = $data->latest()->get();

            if (count($data) > 0) {

                for ($i = 0; $i < count($data); $i++) {

                    $data[$i]['user_name'] = "";
                    $data[$i]['full_name'] = "";
                    $data[$i]['email'] = "";
                    $data[$i]['image'] = "";
                    if ($data[$i]['user'] != null) {
                        $data[$i]['user_name'] = $data[$i]['user']['user_name'];
                        $data[$i]['full_name'] = $data[$i]['user']['full_name'];
                        $data[$i]['email'] = $data[$i]['user']['email'];
                        $data[$i]['image'] = $this->common->getImage($this->folder_user, $data[$i]['user']['image'], 'profile');
                    }
                    unset($data[$i]['user']);

                    $data[$i]['is_reply'] = 0;
                    $data[$i]['total_reply'] = 0;
                    $reply = Comment::where('comment_id', $data[$i]['id'])->count();
                    if ($reply != 0) {
                        $data[$i]['is_reply'] = 1;
                        $data[$i]['total_reply'] = $reply;
                    }
                }
                return $this->common->API_Response(200, __('label.controller.comment_get_successfully'), $data, $pagination);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
