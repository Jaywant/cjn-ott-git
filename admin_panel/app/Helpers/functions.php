<?php

use App\Models\Common;
use App\Models\General_Setting;
use App\Models\Panel_Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

// Setting
function Setting_Data()
{
    $setting = General_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data;
}
function App_Name()
{
    $data = Setting_Data();

    $app_name = $data['app_name'];
    if (isset($app_name) && $app_name != "") {
        return $app_name;
    } else {
        return env('APP_NAME');
    }
}
function Tab_Icon()
{
    $Setting_Data = Setting_Data();

    $name = $Setting_Data['app_logo'];
    $folder = "app";
    $model = new Common();

    $icon_path = $model->getImage($folder, $name, 'normal');
    return $icon_path;
}
function TMDB_Status()
{
    $data = Setting_Data();
    $return = 0;
    if ($data['tmdb_status'] == 1) {
        $return = 1;
    } else {
        $return = 0;
    }
    return $return;
}
function TMDB_API_Key()
{
    $data = Setting_Data();
    return $data['tmdb_api_key'];
}
function Admin_Parent_Control_Status()
{
    $data = Setting_Data();
    $return = 0;
    if ($data['parent_control_status'] == 1) {
        $return = 1;
    } else {
        $return = 0;
    }
    return $return;
}
function Panel_Data()
{
    $setting = Panel_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data;
}
function Item_Code()
{
    return base64_decode('NDQ1NDgzNTg=');
}
function Login_Image()
{
    $Panel_Data = Panel_Data();

    $appName = Config::get('app.image_url');
    $name = $Panel_Data['login_page_img'];
    $folder = "admin";

    if ($name != "" && Storage::disk('public')->exists($folder . '/' . $name)) {
        $name = $appName . $folder . '/' . $name;
    } else {

        $normal_name = $Panel_Data['normal_no_img'];
        if ($normal_name != "" && Storage::disk('public')->exists($folder . '/' . $normal_name)) {
            $name = $appName . $folder . '/' . $normal_name;
        } else {
            $name = asset('assets/imgs/login.png');
        }
    }
    return $name;
}

// Basic
function Currency_Code()
{
    $setting = General_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data['currency_code'];
}
function String_Cut($string, $len)
{
    if (strlen($string) > $len) {
        $string = mb_substr(strip_tags($string), 0, $len, 'utf-8') . '...';
        // $string = substr(strip_tags($string),0,$len).'...';
    }
    return $string;
}
function No_Format($num)
{
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('K', 'M', 'B', 'T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    return $num;
}
function Time_To_Milliseconds($str)
{

    $time = explode(":", $str);

    $hour = (int) $time[0] * 60 * 60 * 1000;
    $minute = (int) $time[1] * 60 * 1000;
    $sec = (int) $time[2] * 1000;
    $result = $hour + $minute + $sec;
    return $result;
}

// Producer
function Producer_Data()
{
    if (Auth::guard('producer')->user()) {
        return Auth::guard('producer')->user();
    } else {
        return redirect()->route('producer.logout');
    }
}

// Demo Mode
function Check_Admin_Access()
{
    if (env('DEMO_MODE') == 'ON') {
        return 0;
    } else {
        return 1;
    }
}
function Demo_Domain()
{
    $domain = request()->getHost();
    if ($domain == base64_decode('bG9jYWxob3N0') || $domain == base64_decode('ZHRsaXZlLmRpdmluZXRlY2hzLmlu') || $domain == base64_decode('ZHRsaXZlLmRpdmluZXRlY2hzLmNvbQ==')) {
        return 1;
    } else {
        return 0;
    }
}
