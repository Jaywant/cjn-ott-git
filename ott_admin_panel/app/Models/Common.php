<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Exception;

class Common extends Model
{
    public $folder_content = "content";

    // Image Functions
    public function saveImage($org_name, $folder, $prefix = "")
    {
        try {
            $img_ext = $org_name->getClientOriginalExtension();
            $filename = $prefix . date('d_m_Y_') . rand(1111, 9999) . '.' . $img_ext;
            $org_name->move(base_path('storage/app/public/' . $folder), $filename);

            return $filename;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function URLSaveInImage($url, $folder, $prefix = "")
    {
        try {
            $ext = pathinfo($url);
            $image_name = $prefix . date('d_m_Y_') . rand(1111, 9999) . '.' . $ext['extension'];
            $path = storage_path() . '/app/public/' . $folder . '/';

            file_put_contents($path . $image_name, file_get_contents($url));
            return $image_name;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function getImage($folder = "", $name = "", $type = "")
    {
        try {

            $appName = Config::get('app.image_url');

            if ($folder != "" && $name != "") {
                if (Storage::disk('public')->exists($folder . '/' . $name)) {
                    $name = $appName . $folder . '/' . $name;
                } else {
                    $name = $this->byDefaultImg($type);
                }
            } else {
                $name = $this->byDefaultImg($type);
            }
            return $name;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function imageNameToUrl($array, $column, $folder, $type = "")
    {
        try {

            $appName = Config::get('app.image_url');
            foreach ($array as $key => $value) {

                if (isset($value[$column]) && $value[$column] != "") {

                    if (Storage::disk('public')->exists($folder . '/' . $value[$column])) {
                        $value[$column] = $appName . $folder . '/' . $value[$column];
                    } else {
                        $value[$column] = $this->byDefaultImg($type);
                    }
                } else {
                    $value[$column] = $this->byDefaultImg($type);
                }
            }
            return $array;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function byDefaultImg($type = "") // profile, landscape, portrait, normal
    {
        $panel_data = Panel_Data();
        $appName = Config::get('app.image_url');
        $folder = "admin";

        if ($type == "profile") {

            $name = $panel_data['profile_no_img'];
            if (Storage::disk('public')->exists($folder . '/' . $name)) {
                return $appName . $folder . '/' . $name;
            } else {
                return asset('assets/imgs/profile.png');
            }
        } else if ($type == "landscape") {

            $name = $panel_data['landscape_no_img'];
            if (Storage::disk('public')->exists($folder . '/' . $name)) {
                return $appName . $folder . '/' . $name;
            } else {
                return $this->normalImg();
            }
        } else if ($type == "portrait") {

            $name = $panel_data['portrait_no_img'];
            if (Storage::disk('public')->exists($folder . '/' . $name)) {
                return $appName . $folder . '/' . $name;
            } else {
                return $this->normalImg();
            }
        } else {
            return $this->normalImg();
        }
    }
    public function normalImg() // Normal Image
    {
        $panel_data = Panel_Data();
        $appName = Config::get('app.image_url');
        $folder = "admin";

        $name = $panel_data['normal_no_img'];
        if ($name != "") {

            if (Storage::disk('public')->exists($folder . '/' . $name)) {
                return $appName . $folder . '/' . $name;
            } else {
                return asset('assets/imgs/no_img.png');
            }
        } else {
            return asset('assets/imgs/no_img.png');
        }
    }
    public function getVideo($folder = "", $name = "")
    {
        try {

            $appName = Config::get('app.image_url');

            if ($folder != "" && $name != "") {
                if (Storage::disk('public')->exists($folder . '/' . $name)) {
                    $name = $appName . $folder . '/' . $name;
                } else {
                    $name = "";
                }
            } else {
                $name = "";
            }
            return $name;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function videoNameToUrl($array, $column, $folder)
    {
        try {

            foreach ($array as $key => $value) {

                $appName = Config::get('app.image_url');

                if (isset($value[$column]) && $value[$column] != "") {

                    if (Storage::disk('public')->exists($folder . '/' . $value[$column])) {
                        $value[$column] = $appName . $folder . '/' . $value[$column];
                    } else {
                        $value[$column] = "";
                    }
                } else {

                    $value[$column] = "";
                }
            }
            return $array;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function deleteImageToFolder($folder, $name)
    {
        try {

            Storage::disk('public')->delete($folder . '/' . $name);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function getAvatarImage($avatar_id, $folder)
    {
        try {

            $avatar = Avatar::where('id', $avatar_id)->first();
            if (isset($avatar) && $avatar != null) {

                return $this->getImage($folder, $avatar['image'], 'profile');
            } else {
                return $this->byDefaultImg('profile');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // API's Functions
    public function API_Response($status_code, $message, $array = [], $pagination = '')
    {
        try {
            $data['status'] = $status_code;
            $data['message'] = $message;

            if ($status_code == 200) {
                $data['result'] = $array;
            }

            if ($pagination) {
                $data['total_rows'] = $pagination['total_rows'];
                $data['total_page'] = $pagination['total_page'];
                $data['current_page'] = $pagination['current_page'];
                $data['more_page'] = $pagination['more_page'];
            }
            return $data;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function more_page($current_page, $page_size)
    {
        try {
            $more_page = false;
            if ($current_page < $page_size) {
                $more_page = true;
            }
            return $more_page;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function pagination_array($total_rows, $page_size, $current_page, $more_page)
    {
        try {
            $array['total_rows'] = $total_rows;
            $array['total_page'] = $page_size;
            $array['current_page'] = (int) $current_page;
            $array['more_page'] = $more_page;

            return $array;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Common Functions
    public function userName($string)
    {
        $rand_number = rand(0, 1000);
        $user_name = '@user_' . $string . $rand_number;

        $check = User::where('user_name', $user_name)->first();
        if (isset($check) && $check != null) {
            $this->userName($string);
        }
        return $user_name;
    }
    public function SetSmtpConfig()
    {
        $smtp = Smtp_Setting::latest()->first();
        if (isset($smtp) && $smtp != null && $smtp['status'] == 1) {

            if ($smtp) {
                $data = [
                    'driver' => 'smtp',
                    'host' => $smtp->host,
                    'port' => $smtp->port,
                    'encryption' => 'tls',
                    'username' => $smtp->user,
                    'password' => $smtp->pass,
                    'from' => [
                        'address' => $smtp->from_email,
                        'name' => $smtp->from_name
                    ]
                ];
                Config::set('mail', $data);
            }
        }
        return true;
    }
    public function sendNotification($array)
    {
        $notification = Setting_Data();
        $ONESIGNAL_APP_ID = $notification['onesignal_apid'];
        $ONESIGNAL_REST_KEY = $notification['onesignal_rest_key'];

        $array['type'] = 2; // Notification Type : 1- Admin, 2- Add Content, 3- Logout Device Sync

        $fields = array(
            'app_id' => $ONESIGNAL_APP_ID,
            'included_segments' => array('All'),
            'data' => $array,
            'headings' => array("en" => $array['name']),
            'contents' => array("en" => $array['description']),
            'big_picture' => $array['image'],
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $ONESIGNAL_REST_KEY,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        // dd($response);
        curl_close($ch);
    }
    public function package_expiry()
    {
        $all_data = Transction::where('status', 1)->get();
        for ($i = 0; $i < count($all_data); $i++) {

            if ($all_data[$i]['expiry_date'] <= date("Y-m-d")) {
                $all_data[$i]->status = 0;
                $all_data[$i]->save();
            }
        }
        return true;
    }
    public function is_any_package_buy($user_id)
    {
        $this->package_expiry();

        $is_buy = Transction::where('user_id', $user_id)->where('status', 1)->latest()->first();
        if (!empty($is_buy)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function rent_expiry()
    {
        $all_data = Rent_Transction::where('status', 1)->get();
        for ($i = 0; $i < count($all_data); $i++) {
            if ($all_data[$i]['expiry_date'] < date("Y-m-d")) {
                $all_data[$i]->status = 0;
                $all_data[$i]->save();
            }
        }
        return true;
    }
    public function is_rent_buy($user_id, $video_type, $sub_video_type, $video_id)
    {
        $this->rent_expiry();

        $is_buy = Rent_Transction::where('user_id', $user_id)->where('video_type', $video_type)->where('sub_video_type', $sub_video_type)->where('video_id', $video_id)->where('status', 1)->first();
        if (!empty($is_buy)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function Send_Mail($type, $email) // Type = 1- Register Mail, 2 Transaction Mail
    {
        try {

            $this->SetSmtpConfig();

            $smtp = Smtp_Setting::latest()->first();
            if (isset($smtp) && $smtp != false && $smtp['status'] == 1) {

                if ($type == 1) {
                    $title = App_Name() . " - Register";
                    $body = "Welcome to " . App_Name() . " App & Enjoy this app.";
                } else if ($type == 2) {
                    $title = App_Name() . " - Transaction";
                    $body = "Welcome to " . App_Name() . " App & Enjoy this app. You have Successfully Transaction.";
                } else {
                    return true;
                }
                $details = [
                    'title' => $title,
                    'body' => $body
                ];

                // Send Mail
                try {
                    Mail::to($email)->send(new \App\Mail\mail($details));
                    return true;
                } catch (\Swift_TransportException $e) {
                    return true;
                }
            } else {
                return true;
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function tv_login_code()
    {
        $code = rand(1000, 9999);
        $check = TV_Login::where('unique_code', $code)->where('status', 1)->where('user_id', '!=', 0)->first();
        if (isset($check)) {

            $this->tv_login_code();
        } else {
            return  (string) $code;
        }
    }
    public function add_url_to_array($type, $array) // type = 1- Video, 2- TVShow, 3- Episode (TVShow Video)
    {
        try {

            for ($i = 0; $i < count($array); $i++) {

                $array[$i]['thumbnail'] = $this->getImage($this->folder_content, $array[$i]['thumbnail'], 'portrait');
                $array[$i]['landscape'] = $this->getImage($this->folder_content, $array[$i]['landscape'], 'landscape');

                if ($type == 1 || $type == 3) {

                    if ($array[$i]['video_upload_type'] == "server_video") {
                        $array[$i]['video_320'] = $this->getVideo($this->folder_content, $array[$i]['video_320']);
                        $array[$i]['video_480'] = $this->getVideo($this->folder_content, $array[$i]['video_480']);
                        $array[$i]['video_720'] = $this->getVideo($this->folder_content, $array[$i]['video_720']);
                        $array[$i]['video_1080'] = $this->getVideo($this->folder_content, $array[$i]['video_1080']);
                    }
                    if ($array[$i]['subtitle_type'] == "server_video") {
                        $array[$i]['subtitle_1'] = $this->getVideo($this->folder_content, $array[$i]['subtitle_1']);
                        $array[$i]['subtitle_2'] = $this->getVideo($this->folder_content, $array[$i]['subtitle_2']);
                        $array[$i]['subtitle_3'] = $this->getVideo($this->folder_content, $array[$i]['subtitle_3']);
                    }
                }
                if ($type == 1 || $type == 2) {

                    if ($array[$i]['trailer_type'] == "server_video") {
                        $array[$i]['trailer_url'] = $this->getVideo($this->folder_content, $array[$i]['trailer_url']);
                    }
                }
            }
            return $array;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function home_section_query($user_id, $video_type, $sub_video_type, $type_id, $category_id, $language_id, $channel_id, $order_by_upload, $order_by_like, $order_by_view, $premium_video, $rent_video, $no_of_content)
    {
        try {

            $org_video_type = 0;
            if ($video_type == 1) {
                $org_video_type = 1;
            } else if ($video_type == 2) {
                $org_video_type = 2;
            } else if ($video_type == 6) {
                $org_video_type = 5;
            } else if ($video_type == 7) {
                $org_video_type = 6;
            } else if ($video_type == 9) {
                $org_video_type = 7;
            }

            if ($org_video_type == 1) {

                $content = Video::where('video_type', 1)->where('status', 1);
            } else if ($org_video_type == 2) {

                $show_id = $this->get_tv_show_ids_by_episode();
                $content = TVShow::whereIn('id', $show_id)->where('video_type', 2)->where('status', 1);
            } else if ($org_video_type == 5 || $org_video_type == 6 || $org_video_type == 7) {

                if ($sub_video_type == 1) {

                    $content = Video::where('video_type', $org_video_type)->where('status', 1);
                } else if ($sub_video_type == 2) {

                    $show_id = $this->get_tv_show_ids_by_episode();
                    $content = TVShow::whereIn('id', $show_id)->where('video_type', $org_video_type)->where('status', 1);
                }
            }

            if ($type_id != 0) {
                $content->where('type_id', $type_id);
            }
            if ($category_id != 0) {
                $content->whereRaw("FIND_IN_SET('$category_id', category_id)");
            }
            if ($language_id != 0) {
                $content->whereRaw("FIND_IN_SET('$language_id', language_id)");
            }
            if ($channel_id != 0) {
                $content->where('channel_id', $channel_id);
            }
            if ($order_by_upload == 2) {
                $content->orderBy('id', 'desc');
            }
            if ($order_by_like == 2) {
                $content->orderBy('total_like', 'desc');
            }
            if ($order_by_view == 2) {
                $content->orderBy('total_view', 'desc');
            }
            if ($video_type == 1) {

                if ($premium_video == 1) {
                    $content->where('is_premium', 1);
                } else if ($premium_video == 0) {
                    $content->where('is_premium', 0);
                }
            } else if (($video_type == 6 || $video_type == 7 || $video_type == 9) && $sub_video_type == 1) {
                if ($premium_video == 1) {
                    $content->where('is_premium', 1);
                } else if ($premium_video == 0) {
                    $content->where('is_premium', 0);
                }
            }

            if ($rent_video == 1) {
                $content->where('is_rent', 1);
            } else if ($rent_video == 0) {
                $content->where('is_rent', 0);
            }
            $query = $content->take($no_of_content)->get();

            if ($org_video_type == 1) {

                $this->add_url_to_array(1, $query);
                $this->rent_price_list($query);
                for ($i = 0; $i < count($query); $i++) {

                    $query[$i]['is_buy'] = $this->is_any_package_buy($user_id);
                    $query[$i]['rent_buy'] = $this->is_rent_buy($user_id, $query[$i]['video_type'], 0, $query[$i]['id']);
                    $query[$i]['is_bookmark'] = $this->is_bookmark($user_id, $query[$i]['video_type'], 0, $query[$i]['id']);
                    $query[$i]['sub_video_type'] = 0;
                    $query[$i]['stop_time'] = $this->get_stop_time($user_id, $query[$i]['video_type'], 0, $query[$i]['id'], 0);
                    $query[$i]['category_name'] = $this->get_category_name_by_ids($query[$i]['category_id']);
                    $query[$i]['is_user_download'] = $this->is_user_download($user_id, $query[$i]['video_type'], 0, $query[$i]['id'], 0);
                }
            } else if ($org_video_type == 2) {

                $this->add_url_to_array(2, $query);
                $this->rent_price_list($query);
                for ($i = 0; $i < count($query); $i++) {

                    $query[$i]['is_buy'] = $this->is_any_package_buy($user_id);
                    $query[$i]['rent_buy'] = $this->is_rent_buy($user_id, $query[$i]['video_type'], 0, $query[$i]['id']);
                    $query[$i]['is_bookmark'] = $this->is_bookmark($user_id, $query[$i]['video_type'], 0, $query[$i]['id']);
                    $query[$i]['sub_video_type'] = 0;
                    $query[$i]['stop_time'] = $this->get_stop_time($user_id, $query[$i]['video_type'], 0, $query[$i]['id'], 0);
                    $query[$i]['category_name'] = $this->get_category_name_by_ids($query[$i]['category_id']);
                    $query[$i]['is_user_download'] = 0;
                }
            } else if ($org_video_type == 5 || $org_video_type == 6 || $org_video_type == 7) {

                if ($sub_video_type == 1) {

                    $this->add_url_to_array(1, $query);
                    $this->rent_price_list($query);
                    for ($i = 0; $i < count($query); $i++) {

                        $query[$i]['is_buy'] = $this->is_any_package_buy($user_id);
                        $query[$i]['rent_buy'] = $this->is_rent_buy($user_id, $query[$i]['video_type'], 1, $query[$i]['id']);
                        $query[$i]['is_bookmark'] = $this->is_bookmark($user_id, $query[$i]['video_type'], 1, $query[$i]['id']);
                        $query[$i]['sub_video_type'] = 1;
                        $query[$i]['stop_time'] = $this->get_stop_time($user_id, $query[$i]['video_type'], 1, $query[$i]['id'], 0);
                        $query[$i]['category_name'] = $this->get_category_name_by_ids($query[$i]['category_id']);
                        $query[$i]['is_user_download'] = $this->is_user_download($user_id, $query[$i]['video_type'], 1, $query[$i]['id'], 0);
                    }
                } else if ($sub_video_type == 2) {

                    $this->add_url_to_array(2, $query);
                    $this->rent_price_list($query);
                    for ($i = 0; $i < count($query); $i++) {

                        $query[$i]['is_buy'] = $this->is_any_package_buy($user_id);
                        $query[$i]['rent_buy'] = $this->is_rent_buy($user_id, $query[$i]['video_type'], 2, $query[$i]['id']);
                        $query[$i]['is_bookmark'] = $this->is_bookmark($user_id, $query[$i]['video_type'], 2, $query[$i]['id']);
                        $query[$i]['sub_video_type'] = 2;
                        $query[$i]['stop_time'] = $this->get_stop_time($user_id, $query[$i]['video_type'], 2, $query[$i]['id'], 0);
                        $query[$i]['category_name'] = $this->get_category_name_by_ids($query[$i]['category_id']);
                        $query[$i]['is_user_download'] = 0;
                    }
                }
            }

            return $query;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function home_section_query_detail($video_type, $sub_video_type, $type_id, $category_id, $language_id, $channel_id, $order_by_upload, $order_by_like, $order_by_view, $premium_video, $rent_video)
    {
        try {

            $org_video_type = 0;
            if ($video_type == 1) {
                $org_video_type = 1;
            } else if ($video_type == 2) {
                $org_video_type = 2;
            } else if ($video_type == 6) {
                $org_video_type = 5;
            } else if ($video_type == 7) {
                $org_video_type = 6;
            } else if ($video_type == 9) {
                $org_video_type = 7;
            }

            if ($org_video_type == 1) {

                $content = Video::where('video_type', 1)->where('status', 1);
            } else if ($org_video_type == 2) {

                $show_id = $this->get_tv_show_ids_by_episode();
                $content = TVShow::whereIn('id', $show_id)->where('video_type', 2)->where('status', 1);
            } else if ($org_video_type == 5 || $org_video_type == 6 || $org_video_type == 7) {

                if ($sub_video_type == 1) {

                    $content = Video::where('video_type', $org_video_type)->where('status', 1);
                } else if ($sub_video_type == 2) {

                    $show_id = $this->get_tv_show_ids_by_episode();
                    $content = TVShow::whereIn('id', $show_id)->where('video_type', $org_video_type)->where('status', 1);
                }
            }

            if ($type_id != 0) {
                $content->where('type_id', $type_id);
            }
            if ($category_id != 0) {
                $content->whereRaw("FIND_IN_SET('$category_id', category_id)");
            }
            if ($language_id != 0) {
                $content->whereRaw("FIND_IN_SET('$language_id', language_id)");
            }
            if ($channel_id != 0) {
                $content->where('channel_id', $channel_id);
            }
            if ($order_by_upload == 2) {
                $content->orderBy('id', 'desc');
            }
            if ($order_by_like == 2) {
                $content->orderBy('total_like', 'desc');
            }
            if ($order_by_view == 2) {
                $content->orderBy('total_view', 'desc');
            }
            if ($video_type == 1) {

                if ($premium_video == 1) {
                    $content->where('is_premium', 1);
                } else if ($premium_video == 0) {
                    $content->where('is_premium', 0);
                }
            } else if (($video_type == 6 || $video_type == 7 || $video_type == 9) && $sub_video_type == 1) {
                if ($premium_video == 1) {
                    $content->where('is_premium', 1);
                } else if ($premium_video == 0) {
                    $content->where('is_premium', 0);
                }
            }
            if ($rent_video == 1) {
                $content->where('is_rent', 1);
            } else if ($rent_video == 0) {
                $content->where('is_rent', 0);
            }

            $query = $content;
            return $query;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function check_user_parent_control_status($user_id)
    {
        $return = 0;

        $admin_status = Admin_Parent_Control_Status();
        $data = User::where('id', $user_id)->first();
        if (isset($data) && $data != null && $admin_status == 1) {

            $return = $data['parent_control_status'];
        }
        return $return;
    }
    public function is_bookmark($user_id, $video_type, $sub_video_type, $video_id)
    {
        $is_bookmark = Bookmark::where('user_id', $user_id)->where('video_type', $video_type)->where('sub_video_type', $sub_video_type)->where('video_id', $video_id)->where('status', 1)->first();
        if (!empty($is_bookmark)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function get_total_language($language_ids)
    {
        $total_language = 0;
        if ($language_ids != "" && isset($language_ids) && $language_ids != null) {

            $Ids = explode(',', $language_ids);
            $total_language = count($Ids);
        }
        return $total_language;
    }
    public function get_category_name_by_ids($category_ids)
    {
        $Ids = explode(',', $category_ids);

        $data = Category::select('id', 'name')->whereIn('id', $Ids)->latest()->get();
        if (count($data) > 0) {

            foreach ($data as $key => $value) {
                $final_data[] = $value['name'];
            }

            $IDs = implode(", ", $final_data);
            return $IDs;
        } else {
            return "";
        }
    }
    public function get_language_name_by_ids($language_id)
    {
        $Ids = explode(',', $language_id);

        $data = Language::select('id', 'name')->whereIn('id', $Ids)->latest()->get();
        if (count($data) > 0) {

            foreach ($data as $key => $value) {
                $final_data[] = $value['name'];
            }

            $IDs = implode(", ", $final_data);
            return $IDs;
        } else {
            return "";
        }
    }
    public function get_stop_time($user_id, $video_type, $sub_video_type, $video_id, $episode_id)
    {
        $stop_time = Video_Watch::where('user_id', $user_id)->where('video_type', $video_type)->where('sub_video_type', $sub_video_type)->where('video_id', $video_id)->where('episode_id', $episode_id)->where('status', 1)->first();
        if (!empty($stop_time)) {
            return (int) $stop_time['stop_time'];
        } else {
            return 0;
        }
    }
    public function get_tv_show_ids_by_episode()
    {
        $episode = TVShow_Video::select('show_id')->where('status', 1)->groupBy('show_id')->get();
        $show_id = [];
        for ($i = 0; $i < count($episode); $i++) {
            $show_id[$i] = $episode[$i]['show_id'];
        }

        return $show_id;
    }
    public function get_active_package_name($user_id)
    {
        $this->package_expiry();

        $package_name = "";
        $is_buy = Transction::where('user_id', $user_id)->where('status', 1)->with('package')->latest()->first();
        if (isset($is_buy) && $is_buy != null && isset($is_buy['package']) && $is_buy['package'] != null) {

            $package_name = $is_buy['package']['name'];
        }
        return $package_name;
    }
    public function get_active_package_expiry_date($user_id)
    {
        $this->package_expiry();

        $expiry_date = "";
        $is_buy = Transction::where('user_id', $user_id)->where('status', 1)->latest()->first();
        if (isset($is_buy) && $is_buy != null) {
            $expiry_date = $is_buy['expiry_date'];
        }
        return $expiry_date;
    }
    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = env($envKey);

        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }
    public function is_user_download($user_id, $video_type, $sub_video_type, $video_id, $episode_id)
    {
        $is_user_download = Download::where('user_id', $user_id)->where('video_type', $video_type)->where('sub_video_type', $sub_video_type)->where('video_id', $video_id)->where('episode_id', $episode_id)->first();
        if (!empty($is_user_download)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function rent_price_list($array)
    {
        try {

            for ($i = 0; $i < count($array); $i++) {

                $price_list = Rent_Price_List::where('id', $array[$i]['price'])->latest()->first();
                if (isset($price_list) && $price_list != null) {

                    $array[$i]['rent_price_id'] = $price_list['id'];
                    $array[$i]['price'] = $price_list['price'];
                    $array[$i]['android_product_package'] = $price_list['android_product_package'];
                    $array[$i]['ios_product_package'] = $price_list['ios_product_package'];
                    $array[$i]['web_price_id'] = $price_list['web_price_id'];
                } else {

                    $array[$i]['rent_price_id'] = 0;
                    $array[$i]['price'] = 0;
                    $array[$i]['android_product_package'] = "";
                    $array[$i]['ios_product_package'] = "";
                    $array[$i]['web_price_id'] = "";
                }
            }
            return $array;
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
