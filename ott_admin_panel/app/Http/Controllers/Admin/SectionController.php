<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Common;
use App\Models\Home_Section;
use App\Models\Language;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class SectionController extends Controller
{
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {
            $params['data'] = [];
            $params['type'] = Type::where('status', 1)->get();
            $params['category'] = Category::latest()->get();
            $params['language'] = Language::latest()->get();
            $params['channel'] = Channel::latest()->get();

            return view('admin.section.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'is_home_screen' => 'required',
                'top_type_id' => 'required',
                'title' => 'required',
                'screen_layout' => 'required',
                'top_type_type' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }
            if ($request['is_home_screen'] == 1) {
                $validator1 = Validator::make($request->all(), [
                    'video_type' => 'required',
                ]);
                if ($validator1->fails()) {
                    $errs1 = $validator1->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs1));
                }
            }

            $requestData = $request->all();
            $requestData['short_title'] = isset($request->short_title) ? $request->short_title : '';
            $requestData['sortable'] = 1;
            $requestData['status'] = 1;
            if ($requestData['is_home_screen'] == 1) {
                $requestData['video_type'] = $requestData['video_type'];
            } else {

                if ($requestData['top_type_type'] == 5) {
                    $requestData['video_type'] = 6;
                } else if ($requestData['top_type_type'] == 6) {
                    $requestData['video_type'] = 7;
                } else if ($requestData['top_type_type'] == 7) {
                    $requestData['video_type'] = 9;
                } else {
                    $requestData['video_type'] = $requestData['top_type_type'];
                }
            }
            if ($requestData['video_type'] == 6 || $requestData['video_type'] == 7 || $requestData['video_type'] == 9) {
                $validator2 = Validator::make($request->all(), [
                    'sub_video_type' => 'required',
                ]);
                if ($validator2->fails()) {
                    $errs2 = $validator2->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs2));
                }
                $requestData['sub_video_type'] = $requestData['sub_video_type'];
            } else {
                $requestData['sub_video_type'] = 0;
            }
            if ($requestData['is_home_screen'] == 1) {
                if ($requestData['video_type'] == 1 || $requestData['video_type'] == 2 || $requestData['video_type'] == 6 || $requestData['video_type'] == 7 || $requestData['video_type'] == 9) {

                    $validator3 = Validator::make($request->all(), [
                        'type_id' => 'required',
                    ]);
                    if ($validator3->fails()) {
                        $errs3 = $validator3->errors()->all();
                        return response()->json(array('status' => 400, 'errors' => $errs3));
                    }
                    $requestData['type_id'] = $requestData['type_id'];
                } else {
                    $requestData['type_id'] = 0;
                }
            } else if ($requestData['is_home_screen'] == 2) {
                $requestData['type_id'] = $requestData['top_type_id'];
            } else {
                $requestData['type_id'] = 0;
            }

            $requestData['category_id'] = 0;
            $requestData['language_id'] = 0;
            $requestData['channel_id'] = 0;
            $requestData['order_by_upload'] = 0;
            $requestData['order_by_like'] = 0;
            $requestData['order_by_view'] = 0;
            $requestData['premium_video'] = 0;
            $requestData['rent_video'] = 0;
            $requestData['no_of_content'] = 0;
            $requestData['view_all'] = 0;
            if ($requestData['video_type'] == 1 || $requestData['video_type'] == 2 || $requestData['video_type'] == 6 || $requestData['video_type'] == 9) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['category_id'] = isset($request['category_id']) ? $request['category_id'] : 0;
                $requestData['language_id'] = isset($request['language_id']) ? $request['language_id'] : 0;
                $requestData['order_by_upload'] = isset($request['order_by_upload']) ? $request['order_by_upload'] : 0;
                $requestData['order_by_like'] = isset($request['order_by_like']) ? $request['order_by_like'] : 0;
                $requestData['order_by_view'] = isset($request['order_by_view']) ? $request['order_by_view'] : 0;
                $requestData['premium_video'] = isset($request['premium_video']) ? $request['premium_video'] : 0;
                $requestData['rent_video'] = isset($request['rent_video']) ? $request['rent_video'] : 0;
                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 1;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            } else if ($requestData['video_type'] == 3 || $requestData['video_type'] == 4 || $requestData['video_type'] == 5) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 1;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            } else if ($requestData['video_type'] == 7) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['category_id'] = isset($request['category_id']) ? $request['category_id'] : 0;
                $requestData['language_id'] = isset($request['language_id']) ? $request['language_id'] : 0;
                $requestData['channel_id'] = isset($request['channel_id']) ? $request['channel_id'] : 0;;
                $requestData['order_by_upload'] = isset($request['order_by_upload']) ? $request['order_by_upload'] : 0;
                $requestData['order_by_like'] = isset($request['order_by_like']) ? $request['order_by_like'] : 0;
                $requestData['order_by_view'] = isset($request['order_by_view']) ? $request['order_by_view'] : 0;
                $requestData['premium_video'] = isset($request['premium_video']) ? $request['premium_video'] : 0;
                $requestData['rent_video'] = isset($request['rent_video']) ? $request['rent_video'] : 0;
                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 1;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            }

            unset($requestData['top_type_id'], $requestData['top_type_type']);

            $section_data = Home_Section::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($section_data->id)) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function GetSectionData(Request $request)
    {
        try {

            if ($request['is_home_screen'] == 1) {
                $data = Home_Section::where('is_home_screen', 1)->orderBy('sortable', 'asc')->latest()->get();
            } else {
                $data = Home_Section::where('is_home_screen', $request['is_home_screen'])->where('type_id', $request['top_type_id'])
                    ->orderBy('sortable', 'asc')->latest()->get();
            }
            return response()->json(array('status' => 200, 'success' => __('label.controller.data_get_successfully'), 'result' => $data));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function SectionDataEdit(Request $request)
    {
        try {

            $data = Home_Section::where('id', $request['id'])->first();
            return response()->json(array('status' => 200, 'success' => __('label.controller.data_get_successfully'), 'result' => $data));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update($id, Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'is_home_screen' => 'required',
                'title' => 'required',
                'screen_layout' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }
            if ($request['is_home_screen'] == 1) {
                $validator1 = Validator::make($request->all(), [
                    'video_type' => 'required',
                ]);
                if ($validator1->fails()) {
                    $errs1 = $validator1->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs1));
                }
            }

            $requestData = $request->all();
            $requestData['short_title'] = isset($request->short_title) ? $request->short_title : '';
            $requestData['video_type'] = $requestData['video_type'];
            if ($requestData['video_type'] == 6 || $requestData['video_type'] == 7 || $requestData['video_type'] == 9) {
                $validator2 = Validator::make($request->all(), [
                    'sub_video_type' => 'required',
                ]);
                if ($validator2->fails()) {
                    $errs2 = $validator2->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs2));
                }
                $requestData['sub_video_type'] = $requestData['sub_video_type'];
            } else {
                $requestData['sub_video_type'] = 0;
            }
            if ($requestData['is_home_screen'] == 1) {
                if ($requestData['video_type'] == 1 || $requestData['video_type'] == 2 || $requestData['video_type'] == 6 || $requestData['video_type'] == 7 || $requestData['video_type'] == 9) {

                    $validator3 = Validator::make($request->all(), [
                        'type_id' => 'required',
                    ]);
                    if ($validator3->fails()) {
                        $errs3 = $validator3->errors()->all();
                        return response()->json(array('status' => 400, 'errors' => $errs3));
                    }
                    $requestData['type_id'] = $requestData['type_id'];
                } else {
                    $requestData['type_id'] = 0;
                }
            } else if ($requestData['is_home_screen'] == 2) {
                $requestData['type_id'] = $requestData['type_id'];
            } else {
                $requestData['type_id'] = 0;
            }

            $requestData['category_id'] = 0;
            $requestData['language_id'] = 0;
            $requestData['channel_id'] = 0;
            $requestData['order_by_upload'] = 0;
            $requestData['order_by_like'] = 0;
            $requestData['order_by_view'] = 0;
            $requestData['premium_video'] = 0;
            $requestData['rent_video'] = 0;
            $requestData['no_of_content'] = 0;
            $requestData['view_all'] = 0;
            if ($requestData['video_type'] == 1 || $requestData['video_type'] == 2 || $requestData['video_type'] == 6 || $requestData['video_type'] == 9) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['category_id'] = isset($request['category_id']) ? $request['category_id'] : 0;
                $requestData['language_id'] = isset($request['language_id']) ? $request['language_id'] : 0;
                $requestData['order_by_upload'] = isset($request['order_by_upload']) ? $request['order_by_upload'] : 0;
                $requestData['order_by_like'] = isset($request['order_by_like']) ? $request['order_by_like'] : 0;
                $requestData['order_by_view'] = isset($request['order_by_view']) ? $request['order_by_view'] : 0;
                $requestData['premium_video'] = isset($request['premium_video']) ? $request['premium_video'] : 0;
                $requestData['rent_video'] = isset($request['rent_video']) ? $request['rent_video'] : 0;
                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 0;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            } else if ($requestData['video_type'] == 3 || $requestData['video_type'] == 4 || $requestData['video_type'] == 5) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 0;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            } else if ($requestData['video_type'] == 7) {

                $request['no_of_content'] = $request['no_of_content'] == 0 ? 1 : $request['no_of_content'];

                $requestData['category_id'] = isset($request['category_id']) ? $request['category_id'] : 0;
                $requestData['language_id'] = isset($request['language_id']) ? $request['language_id'] : 0;
                $requestData['channel_id'] = isset($request['channel_id']) ? $request['channel_id'] : 0;;
                $requestData['order_by_upload'] = isset($request['order_by_upload']) ? $request['order_by_upload'] : 0;
                $requestData['order_by_like'] = isset($request['order_by_like']) ? $request['order_by_like'] : 0;
                $requestData['order_by_view'] = isset($request['order_by_view']) ? $request['order_by_view'] : 0;
                $requestData['premium_video'] = isset($request['premium_video']) ? $request['premium_video'] : 0;
                $requestData['rent_video'] = isset($request['rent_video']) ? $request['rent_video'] : 0;
                $requestData['no_of_content'] = isset($request['no_of_content']) ? $request['no_of_content'] : 0;
                $requestData['view_all'] = isset($request['view_all']) ? $request['view_all'] : 0;
            }

            $section_data = Home_Section::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($section_data->id)) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function show($id)
    {
        try {

            Home_Section::where('id', $id)->delete();
            return response()->json(array('status' => 200, 'success' => __('label.controller.data_delete_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function changeStatus(Request $request)
    {
        try {

            $data = Home_Section::where('id', $request->id)->first();
            if ($data->status == 0) {
                $data->status = 1;
            } elseif ($data->status == 1) {
                $data->status = 0;
            } else {
                $data->status = 0;
            }
            $data->save();
            return response()->json(array('status' => 200, 'success' => __('label.controller.status_changed'), 'id' => $data->id, 'Status' => $data->status));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    // Sortable
    public function SectionSortable(Request $request)
    {
        try {

            if ($request['is_home_screen'] == 1) {
                $data = Home_Section::select('id', 'title')->where('is_home_screen', 1)->orderBy('sortable', 'asc')->latest()->get();
            } else {
                $data = Home_Section::select('id', 'title')->where('is_home_screen', $request['is_home_screen'])->where('type_id', $request['top_type_id'])->orderBy('sortable', 'asc')->latest()->get();
            }
            return response()->json(array('status' => 200, 'success' => __('label.controller.data_get_successfully'), 'result' => $data));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function SectionSortableSave(Request $request)
    {
        try {

            $ids = $request['ids'];
            if (isset($ids) && $ids != null && $ids != "") {

                $id_array = explode(',', $ids);
                for ($i = 0; $i < count($id_array); $i++) {
                    Home_Section::where('id', $id_array[$i])->update(['sortable' => $i + 1]);
                }
            }

            return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
