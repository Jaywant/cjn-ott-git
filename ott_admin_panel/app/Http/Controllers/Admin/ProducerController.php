<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Producer;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Hash;

class ProducerController extends Controller
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
            if ($request->ajax()) {

                $input_search = $request['input_search'];
                if ($input_search != null && isset($input_search)) {
                    $data = Producer::orwhere('user_name', 'LIKE', "%{$input_search}%")->orwhere('full_name', 'LIKE', "%{$input_search}%")
                        ->orwhere('email', 'LIKE', "%{$input_search}%")->orwhere('mobile_number', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Producer::latest()->get();
                }

                $this->common->imageNameToUrl($data, 'image', $this->folder, 'profile');

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $producer_delete = __('label.delete_producer');

                        $delete = ' <form onsubmit="return confirm(\'' . $producer_delete . '\');" method="POST"  action="' . route('producer.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn edit_producer" title="' . $edit . '" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-user_name="' . $row->user_name . '" data-full_name="' . $row->full_name . '" data-email="' . $row->email . '" data-mobile_number="' . $row->mobile_number . '" data-image="' . $row->image . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->make(true);
            }
            return view('admin.producer.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|min:2|unique:tbl_producer,user_name',
                'full_name' => 'required|min:2',
                'email' => 'required|unique:tbl_producer,email|email',
                'password' => 'required|min:4',
                'mobile_number' => 'required|numeric|unique:tbl_producer,mobile_number',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $requestData['password'] = Hash::make($requestData['password']);
            if (isset($requestData['image'])) {
                $files = $requestData['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'produ_');
            }

            $producer_data = Producer::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($producer_data->id)) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update($id, Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_name' => 'required|min:2',
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

            if (isset($requestData['password'])) {
                $requestData['password'] = Hash::make($requestData['password']);
            } else {
                unset($requestData['password']);
            }

            if (isset($requestData['image'])) {
                $files = $requestData['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'produ_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_image']));
            }
            unset($requestData['old_image']);

            $producer_data = Producer::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($producer_data->id)) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.data_edit_successfully')));
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

            $data = Producer::where('id', $id)->first();
            if (isset($data)) {
                $this->common->deleteImageToFolder($this->folder, $data['image']);
                $data->delete();
            }
            return redirect()->route('producer.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
