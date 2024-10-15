<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Panel_Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PanelSettingController extends Controller
{
    private $folder = "admin";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index()
    {
        try {

            $result = Panel_Data();
            if (isset($result)) {

                $result['login_page_img'] = $this->common->getImage($this->folder, $result['login_page_img']);
                $result['profile_no_img'] = $this->common->getImage($this->folder, $result['profile_no_img']);
                $result['normal_no_img'] = $this->common->getImage($this->folder, $result['normal_no_img']);
                $result['portrait_no_img'] = $this->common->getImage($this->folder, $result['portrait_no_img']);
                $result['landscape_no_img'] = $this->common->getImage($this->folder, $result['landscape_no_img']);
                $params['result'] = $result;

                return view('admin.panel_setting.index', $params);
            } else {
                return redirect()->back()->with('error', __('label.controller.page_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function save(Request $request)
    {
        try {

            // $validator = Validator::make($request->all(), [
            //     'primary_color' => 'required',
            //     'asset_color' => 'required',
            //     'background_color' => 'required',
            //     'shadow_color' => 'required',
            //     'breadcrumb_color' => 'required',
            //     'success_status_color' => 'required',
            //     'error_status_color' => 'required',
            //     'dark_text_color' => 'required',
            //     'light_text_color' => 'required',
            //     'counter_card_1_bg' => 'required',
            //     'counter_card_2_bg' => 'required',
            //     'counter_card_3_bg' => 'required',
            //     'counter_card_4_bg' => 'required',
            //     'counter_card_5_bg' => 'required',
            //     'counter_card_6_bg' => 'required',
            //     'counter_card_7_bg' => 'required',
            //     'counter_card_8_bg' => 'required',
            //     'counter_card_9_bg' => 'required',
            //     'counter_card_10_bg' => 'required',
            //     'counter_card_1_text' => 'required',
            //     'counter_card_2_text' => 'required',
            //     'counter_card_3_text' => 'required',
            //     'counter_card_4_text' => 'required',
            //     'counter_card_5_text' => 'required',
            //     'counter_card_6_text' => 'required',
            //     'counter_card_7_text' => 'required',
            //     'counter_card_8_text' => 'required',
            //     'counter_card_9_text' => 'required',
            //     'counter_card_10_text' => 'required',
            //     'chart_color_1' => 'required',
            //     'chart_color_2' => 'required',
            //     'chart_color_3' => 'required',
            //     'chart_color_4' => 'required',
            //     'chart_color_5' => 'required',
            //     'chart_color_6' => 'required',
            //     'chart_color_7' => 'required',
            //     'chart_color_8' => 'required',
            //     'chart_color_9' => 'required',
            //     'chart_color_10' => 'required',
            //     'chart_color_11' => 'required',
            //     'chart_color_12' => 'required',
            // ]);
            // if ($validator->fails()) {
            //     $errs = $validator->errors()->all();
            //     return response()->json(array('status' => 400, 'errors' => $errs));
            // }

            $data = $request->all();

            if (isset($data['login_page_img'])) {

                $files = $data['login_page_img'];
                $data['login_page_img'] = $this->common->saveImage($files, $this->folder, 'panel_set_');
                $this->common->deleteImageToFolder($this->folder, basename($data['old_login_page_img']));
            }
            if (isset($data['profile_no_img'])) {

                $files = $data['profile_no_img'];
                $data['profile_no_img'] = $this->common->saveImage($files, $this->folder, 'panel_set_');
                $this->common->deleteImageToFolder($this->folder, basename($data['old_profile_no_img']));
            }
            if (isset($data['normal_no_img'])) {

                $files = $data['normal_no_img'];
                $data['normal_no_img'] = $this->common->saveImage($files, $this->folder, 'panel_set_');
                $this->common->deleteImageToFolder($this->folder, basename($data['old_normal_no_img']));
            }
            if (isset($data['portrait_no_img'])) {

                $files = $data['portrait_no_img'];
                $data['portrait_no_img'] = $this->common->saveImage($files, $this->folder, 'panel_set_');
                $this->common->deleteImageToFolder($this->folder, basename($data['old_portrait_no_img']));
            }
            if (isset($data['landscape_no_img'])) {

                $files = $data['landscape_no_img'];
                $data['landscape_no_img'] = $this->common->saveImage($files, $this->folder, 'panel_set_');
                $this->common->deleteImageToFolder($this->folder, basename($data['old_landscape_no_img']));
            }

            foreach ($data as $key => $value) {
                $setting = Panel_Setting::where('key', $key)->first();
                if (isset($setting->id)) {
                    $setting->value = $value;
                    $setting->save();
                }
            }
            return response()->json(array('status' => 200, 'success' => __('label.controller.setting_save')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
