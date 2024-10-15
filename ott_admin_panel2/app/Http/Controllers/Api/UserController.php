<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\TV_Login;
use App\Models\Common;
use App\Models\Device_Sync;
use App\Models\Device_Watching;
use App\Models\Sub_Profile;
use App\Models\Transction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

// Login Type : 1- OTP, 2- Goggle, 3- Apple, 4- Normal
class UserController extends Controller
{
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

    public function register(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'full_name' => 'required|min:2',
                    'email' => 'required|unique:tbl_user|email',
                    'password' => 'required|min:4',
                    'mobile_number' => 'required|numeric|unique:tbl_user,mobile_number',
                ],
                [
                    'full_name.required' => __('label.controller.full_name_is_required'),
                    'email.required' => __('label.controller.email_is_required'),
                    'password.required' => __('label.controller.password_is_required'),
                    'mobile_number.required' => __('label.controller.mobile_number_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $full_name = $request->full_name;
            $email = $request->email;
            $password = Hash::make($request->password);
            $mobile_number = $request->mobile_number;
            $device_type = (int)isset($request->device_type) ? $request->device_type : 0;
            $device_token = isset($request->device_token) ? $request->device_token : '';
            $device_name = isset($request->device_name) ? $request->device_name : '';
            $device_id = isset($request->device_id) ? $request->device_id : '';

            $user_name = explode('@', $email);
            $insert = array(
                'user_name' => $this->common->userName($user_name[0]),
                'full_name' => $full_name,
                'email' => $email,
                'password' => $password,
                'mobile_number' => $mobile_number,
                'image_type' => 1,
                'image' => "",
                'type' => 4,
                'parent_control_status' => 0,
                'parent_control_password' => "",
                'status' => 1,
            );
            $user_id = User::insertGetId($insert);

            if (isset($user_id)) {

                $user = User::where('id', $user_id)->first();
                if (isset($user)) {

                    // Device Sync
                    $insert_sync = array(
                        'user_id' => $user_id,
                        'device_name' => $device_name,
                        'device_id' => $device_id,
                        'device_type' => $device_type,
                        'device_token' => $device_token,
                        'status' => 1,
                    );
                    Device_Sync::insertGetId($insert_sync);

                    if ($user['image_type'] == 1) {
                        $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                    } else if ($user['image_type'] == 2) {
                        $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_user);
                    }

                    $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                    $user['device_id'] = $device_id;
                    $user['device_type'] = $device_type;
                    $user['device_token'] = $device_token;
                    return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_found'));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function login(Request $request)
    {
        try {

            if ($request->type == 1) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'mobile_number' => 'required|numeric',
                    ],
                    [
                        'mobile_number.required' => __('label.controller.mobile_number_is_required'),
                    ]
                );
            } elseif ($request->type == 2 || $request->type == 3) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required',
                    ],
                    [
                        'email.required' => __('label.controller.email_is_required'),
                    ]
                );
            } elseif ($request->type == 4) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email',
                        'password' => 'required|min:4',
                    ],
                    [
                        'email.required' => __('label.controller.email_is_required'),
                        'password.required' => __('label.controller.password_is_required'),
                    ]
                );
            } else {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'type' => 'required|numeric',
                    ],
                    [
                        'type.required' => __('label.controller.type_is_required'),
                    ]
                );
            }
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $type = $request->type;
            $full_name = isset($request->full_name) ? $request->full_name : '';
            $email = isset($request->email) ? $request->email : '';
            $password = isset($request->password) ? Hash::make($request->password) : '';
            $mobile_number = isset($request->mobile_number) ? $request->mobile_number : '';
            $device_type = isset($request->device_type) ? (int)$request->device_type : 0;
            $device_token = isset($request->device_token) ? $request->device_token : '';
            $device_name = isset($request->device_name) ? $request->device_name : '';
            $device_id = isset($request->device_id) ? $request->device_id : '';
            $image_type = isset($request->image_type) ? $request->image_type : 1;
            $image = '';
            if ($image_type == 1 && isset($request['image']) && $request['image'] != null) {

                $file = $request->file('image');
                $image = $this->common->saveImage($file, $this->folder_user, 'user_');
            }

            // OTP
            if ($type == 1) {

                $user = User::where('mobile_number', $mobile_number)->where('type', $type)->latest()->first();
                if (isset($user) && $user != null) {

                    $package_buy = $this->common->is_any_package_buy($user['id']);
                    if ($package_buy == 1) {

                        $package = Transction::where('user_id', $user['id'])->where('status', 1)->with('package')->latest()->first();
                        if ($package['package'] != null) {

                            $no_device_sync = $package['package']['no_of_device_sync'];
                            $device_synce_list = Device_Sync::where('user_id', $user['id'])->latest()->get();

                            if ($no_device_sync > count($device_synce_list)) {

                                $device_exists = false;
                                for ($i = 0; $i < count($device_synce_list); $i++) {
                                    if ($device_id == $device_synce_list[$i]['device_id']) {
                                        $device_exists = true;
                                        break;
                                    }
                                }

                                // If the device_id does not exist, add it to the sync list
                                if (!$device_exists) {
                                    // Device Sync
                                    $add = new Device_Sync();
                                    $add['user_id'] = $user['id'];
                                    $add['device_name'] = $device_name;
                                    $add['device_id'] = $device_id;
                                    $add['device_type'] = $device_type;
                                    $add['device_token'] = $device_token;
                                    $add['status'] = 1;
                                    $add->save();
                                }

                                if ($user['image_type'] == 1) {
                                    $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                                } else if ($user['image_type'] == 2) {
                                    $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                                }
                                $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                                $user['device_id'] = $device_id;
                                $user['device_type'] = $device_type;
                                $user['device_token'] = $device_token;

                                return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                            } else {
                                return $this->common->API_Response(400, __('label.controller.your_device_sync_limit_is_over'));
                            }
                        } else {
                            return $this->common->API_Response(400, __('label.controller.something_is_wrong'));
                        }
                    } else {

                        $device_synce_check = Device_Sync::where('user_id', $user['id'])->where('device_id', $device_id)->first();
                        if (!$device_synce_check) {

                            // Device Sync if not found
                            $add = new Device_Sync();
                            $add['user_id'] = $user['id'];
                            $add['device_name'] = $device_name;
                            $add['device_id'] = $device_id;
                            $add['device_type'] = $device_type;
                            $add['device_token'] = $device_token;
                            $add['status'] = 1;
                            $add->save();

                            $device_synce_check = $add;
                        }

                        if ($user['image_type'] == 1) {
                            $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                        } else if ($user['image_type'] == 2) {
                            $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                        }
                        $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                        $user['device_id'] = $device_synce_check['device_id'];
                        $user['device_type'] = (int)$device_synce_check['device_type'];
                        $user['device_token'] = $device_synce_check['device_token'];

                        return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                    }
                } else {

                    $insert = array(
                        'user_name' => $this->common->userName($mobile_number),
                        'full_name' => $full_name,
                        'email' => $email,
                        'password' => $password,
                        'mobile_number' => $mobile_number,
                        'image_type' => $image_type,
                        'image' => $image,
                        'type' => $type,
                        'parent_control_status' => 0,
                        'parent_control_password' => "",
                        'status' => 1,
                    );
                    $user_id = User::insertGetId($insert);

                    if (isset($user_id)) {

                        $user = User::where('id', $user_id)->first();
                        if (isset($user)) {

                            if ($user['image_type'] == 1) {
                                $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                            } else if ($user['image_type'] == 2) {
                                $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                            }
                            $user['is_buy'] = $this->common->is_any_package_buy($user['id']);

                            // Device Sync
                            $add = new Device_Sync();
                            $add['user_id'] = $user['id'];
                            $add['device_name'] = $device_name;
                            $add['device_id'] = $device_id;
                            $add['device_type'] = $device_type;
                            $add['device_token'] = $device_token;
                            $add['status'] = 1;
                            $add->save();

                            $user['device_id'] = $device_id;
                            $user['device_type'] = $device_type;
                            $user['device_token'] = $device_token;

                            return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                        } else {
                            return $this->common->API_Response(400, __('label.controller.data_not_found'));
                        }
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_save'));
                    }
                }
            }

            // Google || Apple
            if ($type == 2 || $type == 3) {

                $user = User::where('email', $email)->where('type', $type)->latest()->first();
                if (isset($user) && $user != null) {

                    $package_buy = $this->common->is_any_package_buy($user['id']);
                    if ($package_buy == 1) {

                        $package = Transction::where('user_id', $user['id'])->where('status', 1)->with('package')->latest()->first();
                        if ($package['package'] != null) {

                            $no_device_sync = $package['package']['no_of_device_sync'];
                            $device_synce_list = Device_Sync::where('user_id', $user['id'])->latest()->get();

                            if ($no_device_sync > count($device_synce_list)) {

                                $device_exists = false;
                                for ($i = 0; $i < count($device_synce_list); $i++) {
                                    if ($device_id == $device_synce_list[$i]['device_id']) {
                                        $device_exists = true;
                                        break;
                                    }
                                }

                                // If the device_id does not exist, add it to the sync list
                                if (!$device_exists) {
                                    // Device Sync
                                    $add = new Device_Sync();
                                    $add['user_id'] = $user['id'];
                                    $add['device_name'] = $device_name;
                                    $add['device_id'] = $device_id;
                                    $add['device_type'] = $device_type;
                                    $add['device_token'] = $device_token;
                                    $add['status'] = 1;
                                    $add->save();
                                }

                                if ($user['image_type'] == 1) {
                                    $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                                } else if ($user['image_type'] == 2) {
                                    $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                                }
                                $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                                $user['device_id'] = $device_id;
                                $user['device_type'] = $device_type;
                                $user['device_token'] = $device_token;

                                return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                            } else {
                                return $this->common->API_Response(400, __('label.controller.your_device_sync_limit_is_over'));
                            }
                        } else {
                            return $this->common->API_Response(400, __('label.controller.something_is_wrong'));
                        }
                    } else {

                        $device_synce_check = Device_Sync::where('user_id', $user['id'])->where('device_id', $device_id)->first();
                        if (!$device_synce_check) {

                            // Device Sync if not found
                            $add = new Device_Sync();
                            $add['user_id'] = $user['id'];
                            $add['device_name'] = $device_name;
                            $add['device_id'] = $device_id;
                            $add['device_type'] = $device_type;
                            $add['device_token'] = $device_token;
                            $add['status'] = 1;
                            $add->save();

                            $device_synce_check = $add;
                        }

                        if ($user['image_type'] == 1) {
                            $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                        } else if ($user['image_type'] == 2) {
                            $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                        }
                        $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                        $user['device_id'] = $device_synce_check['device_id'];
                        $user['device_type'] = (int)$device_synce_check['device_type'];
                        $user['device_token'] = $device_synce_check['device_token'];

                        return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                    }
                } else {

                    $user_name = explode('@', $email);
                    $insert = array(
                        'user_name' => $this->common->userName($user_name[0]),
                        'full_name' => $full_name,
                        'email' => $email,
                        'password' => $password,
                        'mobile_number' => $mobile_number,
                        'image_type' => $image_type,
                        'image' => $image,
                        'type' => $type,
                        'parent_control_status' => 0,
                        'parent_control_password' => "",
                        'status' => 1,
                    );
                    $user_id = User::insertGetId($insert);

                    if (isset($user_id)) {

                        $user = User::where('id', $user_id)->first();
                        if (isset($user)) {

                            if ($user['image_type'] == 1) {
                                $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                            } else if ($user['image_type'] == 2) {
                                $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                            }
                            $user['is_buy'] = $this->common->is_any_package_buy($user['id']);

                            // Send Mail (Type = 1- Register Mail, 2 Transaction Mail)
                            if ($type == 2) {
                                $this->common->Send_Mail(1, $user->email);
                            }

                            // Device Sync
                            $add = new Device_Sync();
                            $add['user_id'] = $user['id'];
                            $add['device_name'] = $device_name;
                            $add['device_id'] = $device_id;
                            $add['device_type'] = $device_type;
                            $add['device_token'] = $device_token;
                            $add['status'] = 1;
                            $add->save();

                            $user['device_id'] = $device_id;
                            $user['device_type'] = $device_type;
                            $user['device_token'] = $device_token;

                            return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                        } else {
                            return $this->common->API_Response(400, __('label.controller.data_not_found'));
                        }
                    } else {
                        return $this->common->API_Response(400, __('label.controller.data_not_save'));
                    }
                }
            }

            // Normal
            if ($type == 4) {

                $user = User::where('email', $email)->where('type', $type)->latest()->first();
                if (isset($user)) {

                    if (Hash::check($request->password, $user->password)) {

                        $package_buy = $this->common->is_any_package_buy($user['id']);
                        if ($package_buy == 1) {

                            $package = Transction::where('user_id', $user['id'])->where('status', 1)->with('package')->latest()->first();
                            if ($package['package'] != null) {

                                $no_device_sync = $package['package']['no_of_device_sync'];
                                $device_synce_list = Device_Sync::where('user_id', $user['id'])->latest()->get();

                                if ($no_device_sync > count($device_synce_list)) {

                                    $device_exists = false;
                                    for ($i = 0; $i < count($device_synce_list); $i++) {
                                        if ($device_id == $device_synce_list[$i]['device_id']) {
                                            $device_exists = true;
                                            break;
                                        }
                                    }

                                    // If the device_id does not exist, add it to the sync list
                                    if (!$device_exists) {
                                        // Device Sync
                                        $add = new Device_Sync();
                                        $add['user_id'] = $user['id'];
                                        $add['device_name'] = $device_name;
                                        $add['device_id'] = $device_id;
                                        $add['device_type'] = $device_type;
                                        $add['device_token'] = $device_token;
                                        $add['status'] = 1;
                                        $add->save();
                                    }

                                    if ($user['image_type'] == 1) {
                                        $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                                    } else if ($user['image_type'] == 2) {
                                        $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                                    }
                                    $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                                    $user['device_id'] = $device_id;
                                    $user['device_type'] = $device_type;
                                    $user['device_token'] = $device_token;

                                    return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                                } else {
                                    return $this->common->API_Response(400, __('label.controller.your_device_sync_limit_is_over'));
                                }
                            } else {
                                return $this->common->API_Response(400, __('label.controller.something_is_wrong'));
                            }
                        } else {

                            $device_synce_check = Device_Sync::where('user_id', $user['id'])->where('device_id', $device_id)->first();
                            if (!$device_synce_check) {
                                // Device Sync if not found
                                $add = new Device_Sync();
                                $add['user_id'] = $user['id'];
                                $add['device_name'] = $device_name;
                                $add['device_id'] = $device_id;
                                $add['device_type'] = $device_type;
                                $add['device_token'] = $device_token;
                                $add['status'] = 1;
                                $add->save();

                                $device_synce_check = $add;
                            }

                            if ($user['image_type'] == 1) {
                                $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                            } else if ($user['image_type'] == 2) {
                                $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                            }
                            $user['is_buy'] = $this->common->is_any_package_buy($user['id']);
                            $user['device_id'] = $device_synce_check['device_id'];
                            $user['device_type'] = (int)$device_synce_check['device_type'];
                            $user['device_token'] = $device_synce_check['device_token'];

                            return $this->common->API_Response(200, __('label.controller.login_successfully'), array($user));
                        }
                    } else {
                        return $this->common->API_Response(400, __('label.controller.email_pass_worng'));
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.email_pass_worng'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_profile(Request $request)
    {
        try {

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

            $user_data = User::where('id', $user_id)->first();
            if (isset($user_data) && $user_data != null) {

                if ($user_data['image_type'] == 1) {
                    $user_data['image'] = $this->common->getImage($this->folder_user, $user_data['image'], 'profile');
                } else if ($user_data['image_type'] == 2) {
                    $user_data['image'] = $this->common->getAvatarImage($user_data['image'], $this->folder_avatar);
                }
                $user_data['is_buy'] = $this->common->is_any_package_buy($user_data['id']);
                $user_data['package_name'] = $this->common->get_active_package_name($user_data['id']);
                $user_data['expiry_date'] = $this->common->get_active_package_expiry_date($user_data['id']);

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($user_data));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update_profile(Request $request)
    {
        try {

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
            $data = User::where('id', $user_id)->first();

            $array = array();
            if (isset($data) && $data != null) {

                if (isset($request['user_name']) && $request['user_name'] != '') {

                    $check = User::where('user_name', $request['user_name'])->first();
                    if (isset($check) && $check != null) {
                        if ($check->id == $data->id) {
                            $array['user_name'] = $request['user_name'];
                        } else {
                            return $this->common->API_Response(400, __('label.controller.user_name_exists'));
                        }
                    } else {
                        $array['user_name'] = $request['user_name'];
                    }
                }
                if (isset($request['full_name']) && $request['full_name'] != '') {
                    $array['full_name'] = $request->full_name;
                }
                if (isset($request['email']) && $request['email'] != '') {

                    $check = User::where('email', $request['email'])->first();
                    if (isset($check) && $check != null) {
                        if ($check->id == $data->id) {
                            $array['email'] = $request['email'];
                        } else {
                            return $this->common->API_Response(400, __('label.controller.email_exists'));
                        }
                    } else {
                        $array['email'] = $request['email'];
                    }
                }
                if (isset($request['mobile_number']) && $request['mobile_number'] != '') {

                    $check = User::where('mobile_number', $request['mobile_number'])->first();
                    if (isset($check) && $check != null) {
                        if ($check->id == $data->id) {
                            $array['mobile_number'] = $request['mobile_number'];
                        } else {
                            return $this->common->API_Response(400, __('label.controller.mobile_number_exists'));
                        }
                    } else {
                        $array['mobile_number'] = $request['mobile_number'];
                    }
                }
                if (isset($request['image_type']) && $request['image_type'] != '' && $request['image_type'] != 0) {

                    $array['image_type'] = $request['image_type'];
                    if ($request['image_type'] == 1 && isset($request['image']) && $request->file('image') != '') {

                        $image = $request->file('image');
                        $array['image'] = $this->common->saveImage($image, $this->folder_user, 'user_');
                    } else if ($request['image_type'] == 2 && isset($request['image'])) {

                        $array['image'] = $request['image'];
                    }

                    $old_image = $data['image'];
                    $this->common->deleteImageToFolder($this->folder_user, $old_image);
                }
                if (isset($request['parent_control_status']) && $request['parent_control_status'] != '') {
                    $array['parent_control_status'] = $request['parent_control_status'];
                }
                if (isset($request['parent_control_password']) && $request['parent_control_password'] != '') {
                    $array['parent_control_password'] = $request['parent_control_password'];
                }

                User::where('id', $user_id)->update($array);

                $user = User::where('id', $user_id)->first();
                if ($user['image_type'] == 1) {
                    $user['image'] = $this->common->getImage($this->folder_user, $user['image'], 'profile');
                } else if ($user['image_type'] == 2) {
                    $user['image'] = $this->common->getAvatarImage($user['image'], $this->folder_avatar);
                }
                $user['is_buy'] = $this->common->is_any_package_buy($user['id']);

                return $this->common->API_Response(200, __('label.controller.profile_update_successfully'), array($user));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // TV Login
    public function get_tv_login_code(Request $request)
    {
        try {

            $insert = new TV_Login();
            $insert['unique_code'] = $this->common->tv_login_code();
            $insert['user_id'] = 0;
            $insert['status'] = 0;

            if ($insert->save()) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($insert));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function tv_login(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'unique_code' => 'required',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'unique_code.required' => __('label.controller.unique_code_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $check = TV_Login::where('unique_code', $request->unique_code)->where('status', 0)->where('user_id', 0)->first();
            if (isset($check)) {

                $check->status = 1;
                $check->user_id = $request->user_id;
                if ($check->update()) {

                    $data = User::where('id', $check->user_id)->first();
                    if (isset($data)) {

                        $this->common->imageNameToUrl(array($data), 'image', $this->folder_user, 'profile');
                        return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
                    } else {
                        return $this->common->API_Response(400, __('label.controller.user_id_worng'));
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.data_not_save'));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.code_is_wrong'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function check_tv_login(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'unique_code' => 'required',
                ],
                [
                    'unique_code.required' => __('label.controller.unique_code_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $data = TV_Login::where('unique_code', $request->unique_code)->where('status', '!=', 0)->where('user_id', '!=', 0)->first();
            if (isset($data)) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), array($data));
            } else {
                return $this->common->API_Response(400, __('label.controller.code_is_wrong'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Parent Control
    public function parent_control_check_password(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'password' => 'required',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'password.required' => __('label.controller.password_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $password = $request['password'];

            $check = User::where('id', $user_id)->where('parent_control_password', $password)->first();
            if (isset($check) && $check != null) {
                return $this->common->API_Response(200, __('label.controller.password_is_correct'));
            } else {
                return $this->common->API_Response(400, __('label.controller.password_worng'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Device Sync
    public function get_device_sync_list(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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

            $check = Device_Sync::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            if (count($check) > 0) {
                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $check);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function logout_device_sync(Request $request) // Child User id = Id of Device sync list PK
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'child_user_id' => 'required',
                    'device_id' => 'required',
                ],
                [
                    'child_user_id.required' => __('label.controller.child_user_id_is_required'),
                    'device_id.required' => __('label.controller.device_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $child_user_id = $request['child_user_id'];
            $device_id = $request['device_id'];

            Device_Sync::where('id', $child_user_id)->where('device_id', $device_id)->where('status', 1)->delete();
            return $this->common->API_Response(200, __('label.controller.delete_success'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add_remove_device_watching(Request $request) // Type = 1- Add, 2- Remove
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'device_id' => 'required',
                    'type' => 'required',
                ],
                [
                    'user_id.required' => __('label.controller.user_id_is_required'),
                    'device_id.required' => __('label.controller.device_id_is_required'),
                    'type.required' => __('label.controller.type_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $user_id = $request['user_id'];
            $device_id = $request['device_id'];
            $type = $request['type'];

            if ($type == 1) {

                $package_buy = $this->common->is_any_package_buy($user_id);
                if ($package_buy == 1) {

                    $package = Transction::where('user_id', $user_id)->where('status', 1)->with('package')->latest()->first();
                    if ($package && $package['package'] != null) {

                        $no_device_sync = $package['package']['no_of_device_sync'];
                        $device_watching_list = Device_Watching::where('user_id', $user_id)->with('device_sync')->latest()->get();
                        $data = Device_Watching::where('user_id', $user_id)->where('device_id', $device_id)->first();

                        if ($data || $no_device_sync > count($device_watching_list)) {

                            if (!$data) {
                                $add = new Device_Watching();
                                $add['user_id'] = $user_id;
                                $add['device_id'] = $device_id;
                                $add['status'] = 1;
                                $add->save();
                            }
                            return $this->common->API_Response(200, __('label.controller.device_add_successfully'));
                        } else {

                            $return_data = [];
                            for ($i = 0; $i < count($device_watching_list); $i++) {

                                if ($device_watching_list[$i]['device_sync'] != null) {
                                    $return_data[] = $device_watching_list[$i]['device_sync'];
                                }
                            }

                            $return['status'] = 400;
                            $return['message'] = __('label.controller.streaming_limit_reached');
                            $return['result'] = $return_data;
                            return $return;
                        }
                    } else {
                        return $this->common->API_Response(400, __('label.controller.please_get_subscription'));
                    }
                } else {
                    return $this->common->API_Response(400, __('label.controller.please_get_subscription'));
                }
            } elseif ($type == 2) {

                $data = Device_Watching::where('user_id', $user_id)->where('device_id', $device_id)->delete();
                return $this->common->API_Response(200, __('label.controller.device_delete_successfully'));
            } else {
                return $this->common->API_Response(400, __('label.controller.type_is_wrong'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Sub Profile
    public function add_sub_profile(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'image' => 'required|numeric',
                    'parent_user_id' => 'required|numeric',
                ],
                [
                    'name.required' => __('label.controller.name_is_required'),
                    'image.required' => __('label.controller.image_is_required'),
                    'parent_user_id.required' => __('label.controller.parent_user_id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            $data = array(
                'parent_user_id' => $request['parent_user_id'],
                'name' => $request['name'],
                'image' => $request['image'],
                'status' => 1,
            );
            $user_id = Sub_Profile::insertGetId($data);

            if (isset($user_id)) {
                return $this->common->API_Response(200, __('label.controller.add_successfully'));
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function delete_sub_profile(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'id' => 'required|numeric',
                ],
                [
                    'id.required' => __('label.controller.id_is_required'),
                ]
            );
            if ($validation->fails()) {
                $data['status'] = 400;
                $data['message'] = $validation->errors()->first();
                return $data;
            }

            Sub_Profile::where('id', $request['id'])->delete();
            return $this->common->API_Response(200, __('label.controller.profile_delete_successfully'), []);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function get_sub_profile(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'sub_user_id' => 'numeric',
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
            $sub_user_id = isset($request['sub_user_id']) ? $request['sub_user_id'] : 0;

            if ($sub_user_id == 0) {
                $user = Sub_Profile::where('parent_user_id', $user_id)->get();
            } else {
                $user = Sub_Profile::where('parent_user_id', $user_id)->where('id', $sub_user_id)->get();
            }

            if (count($user) > 0) {

                for ($i = 0; $i < count($user); $i++) {

                    $avatar = Avatar::where('id', $user[$i]['image'])->first();
                    if ($avatar != null && isset($avatar)) {
                        $user[$i]['image'] = $this->common->Get_Image($this->folder_avatar, $avatar['image']);
                    } else {
                        $user[$i]['image'] = asset('assets/imgs/no_user.png');
                    }
                }

                return $this->common->API_Response(200, __('label.controller.get_record_successfully'), $user);
            } else {
                return $this->common->API_Response(400, __('label.controller.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update_sub_profile(Request $request)
    {
        try {

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

            $data = array();
            $User_Data = Sub_Profile::where('id', $user_id)->first();
            if (!empty($User_Data)) {

                if (isset($request['name']) && $request['name'] != '') {
                    $data['name'] = $request['name'];
                }
                if (isset($request['image']) && $request['image'] != '') {
                    $data['image'] = $request['image'];
                }
                $User_Data->update($data);

                if (isset($User_Data)) {

                    $avatar = Avatar::where('id', $User_Data['image'])->first();
                    if ($avatar != null && isset($avatar)) {
                        $User_Data['image'] = $this->common->Get_Image($this->folder_avatar, $avatar['image']);
                    } else {
                        $User_Data['image'] = asset('assets/imgs/no_user.png');
                    }

                    return $this->common->API_Response(200, __('label.controller.profile_update_successfully'), array($User_Data));
                }
            } else {
                return $this->common->API_Response(400, __('label.controller.user_id_worng'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
