<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Common;
use App\Models\Device_Sync;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

// Login Type : 1= OTP, 2= Goggle, 3= Apple, 4= Normal
class UserController extends Controller
{
    private $folder = "user";
    private $folder_avatar = "avatar";
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
                $input_type = $request['input_type'];
                $input_login_type = $request['input_login_type'];
                if ($input_search != null && isset($input_search)) {

                    if ($input_login_type == "all") {

                        if ($input_type == "today") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "month") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "year") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->whereYear('created_at', date('Y'))->latest()->get();
                        } else {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->latest()->get();
                        }
                    } else {

                        if ($input_type == "today") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->where('type', $input_login_type)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "month") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->where('type', $input_login_type)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "year") {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->where('type', $input_login_type)->whereYear('created_at', date('Y'))->latest()->get();
                        } else {
                            $data = User::where(function ($query) use ($input_search) {
                                $query->where('full_name', 'LIKE', "%{$input_search}%")->orWhere('email', 'LIKE', "%{$input_search}%")->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                                ->where('type', $input_login_type)->latest()->get();
                        }
                    }
                } else {

                    if ($input_login_type == "all") {

                        if ($input_type == "today") {
                            $data = User::whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "month") {
                            $data = User::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "year") {
                            $data = User::whereYear('created_at', date('Y'))->latest()->get();
                        } else {
                            $data = User::latest()->get();
                        }
                    } else {

                        if ($input_type == "today") {
                            $data = User::where('type', $input_login_type)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "month") {
                            $data = User::where('type', $input_login_type)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                        } else if ($input_type == "year") {
                            $data = User::where('type', $input_login_type)->whereYear('created_at', date('Y'))->latest()->get();
                        } else {
                            $data = User::where('type', $input_login_type)->latest()->get();
                        }
                    }
                }

                for ($i = 0; $i < count($data); $i++) {

                    if ($data[$i]['image_type'] == 1) {
                        $data[$i]['image'] = $this->common->getImage($this->folder, $data[$i]['image'], 'profile');
                    } else if ($data[$i]['image_type'] == 2) {
                        $data[$i]['image'] = $this->common->getAvatarImage($data[$i]['image'], $this->folder_avatar);
                    }
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $user_delete = __('label.delete_user');

                        $delete = '<form onsubmit="return confirm(\'' . $user_delete . '\');" method="POST"  action="' . route('user.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around" title="' . $edit . '">';
                        $btn .= '<a href="' . route('user.edit', [$row->id]) . '" class="edit-delete-btn mr-2">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("Y-m-d", strtotime($row->created_at));
                        return $date;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.user.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create()
    {
        try {
            $params['data'] = [];
            return view('admin.user.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|min:2',
                'email' => 'required|unique:tbl_user|email',
                'password' => 'required|min:4',
                'mobile_number' => 'required|numeric|unique:tbl_user,mobile_number',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();

            $emailArray = explode('@', $requestData['email']);
            $requestData['user_name'] = $this->common->userName($emailArray[0]);
            $requestData['password'] = Hash::make($requestData['password']);
            $requestData['image_type'] = 1;
            $files = $requestData['image'];
            $requestData['image'] = $this->common->saveImage($files, $this->folder, 'user_');
            $requestData['type'] = 4;
            $requestData['parent_control_status'] = 0;
            $requestData['parent_control_password'] = "";
            $requestData['status'] = 1;

            $user_data = User::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($user_data->id)) {
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

            $params['data'] = User::where('id', $id)->first();
            if ($params['data'] != null) {

                if ($params['data']['image_type'] == 1) {
                    $params['data']['image'] = $this->common->getImage($this->folder, $params['data']['image'], 'profile');
                } else if ($params['data']['image_type'] == 2) {
                    $params['data']['image'] = $this->common->getAvatarImage($params['data']['image'], $this->folder_avatar);
                }
                return view('admin.user.edit', $params);
            } else {
                return redirect()->back()->with('error', __('label.controller.page_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|min:2',
                'email' => 'required|email|unique:tbl_user,email,' . $id,
                'mobile_number' => 'required|numeric|unique:tbl_user,mobile_number,' . $id,
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();

            if (isset($request['image'])) {
                $requestData['image_type'] = 1;

                $files = $request['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'user_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_image']));
            }
            unset($requestData['old_image']);

            $User_data = User::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($User_data->id)) {
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

            $data = User::where('id', $id)->first();
            if (isset($data)) {
                $this->common->deleteImageToFolder($this->folder, $data['image']);
                $data->delete();

                Device_Sync::where('user_id', $id)->delete();
                Bookmark::where('user_id', $id)->delete();
                Like::where('user_id', $id)->delete();
            }
            return redirect()->route('user.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
