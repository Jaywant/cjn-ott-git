<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ChannelController extends Controller
{
    private $folder = "channel";
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
                    $data = Channel::where('name', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Channel::latest()->get();
                }

                $this->common->imageNameToUrl($data, 'portrait_img', $this->folder, 'portrait');
                $this->common->imageNameToUrl($data, 'landscape_img', $this->folder, 'landscape');

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $channel_delete = __('label.delete_channel');

                        $delete = ' <form onsubmit="return confirm(\'' . $channel_delete . '\');" method="POST"  action="' . route('channel.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn edit_channel" title="' . $edit . '" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-name="' . $row->name . '" data-portrait_img="' . $row->portrait_img . '" data-landscape_img="' . $row->landscape_img . '" data-is_title="' . $row->is_title . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->make(true);
            }
            return view('admin.channel.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'is_title' => 'required',
                'portrait_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'landscape_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            if (isset($requestData['portrait_img'])) {
                $files = $requestData['portrait_img'];
                $requestData['portrait_img'] = $this->common->saveImage($files, $this->folder, 'channel_');
            }
            if (isset($requestData['landscape_img'])) {
                $files = $requestData['landscape_img'];
                $requestData['landscape_img'] = $this->common->saveImage($files, $this->folder, 'channel_');
            }

            $channel_data = Channel::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($channel_data->id)) {
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
                'name' => 'required|min:2',
                'portrait_img' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape_img' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            if (isset($requestData['portrait_img'])) {
                $files = $requestData['portrait_img'];
                $requestData['portrait_img'] = $this->common->saveImage($files, $this->folder, 'channel_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_portrait_img']));
            }
            if (isset($requestData['landscape_img'])) {
                $files1 = $requestData['landscape_img'];
                $requestData['landscape_img'] = $this->common->saveImage($files1, $this->folder, 'channel_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_landscape_img']));
            }
            unset($requestData['old_portrait_img']);
            unset($requestData['old_landscape_img']);

            $channel_data = Channel::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($channel_data->id)) {
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

            $data = Channel::where('id', $id)->first();
            if (isset($data)) {
                $this->common->deleteImageToFolder($this->folder, $data['portrait_img']);
                $this->common->deleteImageToFolder($this->folder, $data['landscape_img']);
                $data->delete();
            }
            return redirect()->route('channel.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
