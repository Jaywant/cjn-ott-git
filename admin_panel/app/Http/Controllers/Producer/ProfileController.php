<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProfileController extends Controller
{
    private $folder = "producer";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {

            $params['data'] = [];
            $producer = Producer_Data();

            $params['data'] = Producer::where('id', $producer['id'])->first();

            // Image Name to URL
            $this->common->imageNameToUrl(array($params['data']), 'image', $this->folder, 'profile');

            return view('producer.profile.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update($id, Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:tbl_producer,user_name,' . $id,
                'full_name' => 'required|min:2',
                'email' => 'required|email|unique:tbl_producer,email,' . $id,
                'mobile_number' => 'required|numeric|unique:tbl_producer,mobile_number,' . $id,
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();

            if (isset($request['image'])) {
                $files = $request['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'produ_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_image']));
            }
            unset($requestData['old_image']);

            $user_data = Producer::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($user_data->id)) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_updated')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
