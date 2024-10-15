<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use App\Models\Common;
use App\Models\TVShow;
use Illuminate\Http\Request;
use App\Models\Rent_Transction;
use Illuminate\Support\Facades\Validator;
use Exception;

// 1- Video, 2- Show, 3- Category, 4-Language, 5- Upcoming, 6- Channel, 7- Kids
class RentTransactionController extends Controller
{
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {

            // Rent Expiry
            $this->common->rent_expiry();

            $params['data'] = [];
            if ($request->ajax()) {

                $input_type = $request['input_type'];
                $input_search = $request['input_search'];
                if ($input_type == "today") {
                    if ($input_search != null && isset($input_search)) {
                        $data = Rent_Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('user')->whereDay('created_at', date('d'))
                            ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    } else {
                        $data = Rent_Transction::with('user')->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))
                            ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    }
                } else if ($input_type == "month") {
                    if ($input_search != null && isset($input_search)) {
                        $data = Rent_Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('user')->whereMonth('created_at', date('m'))
                            ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    } else {
                        $data = Rent_Transction::with('user')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    }
                } else if ($input_type == "year") {
                    if ($input_search != null && isset($input_search)) {
                        $data = Rent_Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('user')->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    } else {
                        $data = Rent_Transction::with('user')->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                    }
                } else {
                    if ($input_search != null && isset($input_search)) {
                        $data = Rent_Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('user')->orderBy('status', 'desc')->latest()->get();
                    } else {
                        $data = Rent_Transction::with('user')->orderBy('status', 'desc')->latest()->get();
                    }
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $delete = __('label.delete');
                        $transaction_delete = __('label.delete_transaction');

                        $delete = '<form onsubmit="return confirm(\'' . $transaction_delete . '\');" method="POST"  action="' . route('renttransaction.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= $delete;
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            $active = __('label.active');
                            return "<button type='button' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;'>" . $active . "</button>";
                        } else {
                            $expiry = __('label.expiry');
                            return "<button type='button' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;'>" . $expiry . "</button>";
                        }
                    })
                    ->addColumn('video_name', function ($row) {
                        return Rent_Transction::getVideoName($row->video_id, $row->video_type, $row->sub_video_type);
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("Y-m-d", strtotime($row->created_at));
                        return $date;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('admin.rent_transaction.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create(Request $request)
    {
        try {
            $params['data'] = [];
            $params['user'] = User::where('id', $request->user_id)->first();
            $params['rent_video'] = Video::whereIn('video_type', [1, 6])->where('status', 1)->where('is_rent', 1)->latest()->get();

            $ids = $this->common->get_tv_show_ids_by_episode();
            $params['rent_tv_show'] = TVShow::whereIn('id', $ids)->whereIn('video_type', [2, 6])->where('status', 1)->where('is_rent', 1)->latest()->get();

            return view('admin.rent_transaction.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function searchUser(Request $request)
    {
        try {
            $name = $request->name;
            $user = User::orWhere('full_name', 'like', '%' . $name . '%')->orWhere('mobile_number', 'like', '%' . $name . '%')->orWhere('email', 'like', '%' . $name . '%')->latest()->get();

            $url = url('admin/renttransaction/create?user_id');
            $text = '<table width="100%" class="table table-striped category-table text-center table-bordered"><tr style="background: #F9FAFF;"><th>' . __("label.full_name") . '</th><th>' . __("label.mobile_number") . '</th><th>' . __("label.email") . '</th><th>' . __("label.action") . '</th></tr>';
            if ($user->count() > 0) {
                foreach ($user as $row) {

                    $a = '<a class="btn-link" href="' . $url . '=' . $row->id . '">' . __("label.select") . '</a>';
                    $text .= '<tr><td>' . $row->full_name . '</td><td>' . $row->mobile_number . '</td><td>' . $row->email . '</td><td>' . $a . '</td></tr>';
                }
            } else {
                $text .= '<tr><td colspan="4">' . __("label.user_not_found") . '</td></tr>';
            }
            $text .= '</table>';

            return response()->json(array('status' => 200, 'success' => __('label.controller.data_get_successfully'), 'result' => $text));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            if ($request['rent_video_id'] != "") {

                $Video = Video::where('id', $request['rent_video_id'])->first();
                if ($Video != null && isset($Video)) {

                    $rent_day = $Video['rent_day'];
                    $expiry_date = date('Y-m-d', strtotime($rent_day . ' days'));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('label.controller.select_right_video_or_tvshow')));
                }

                $insert = new Rent_Transction();
                $insert->unique_id = "";
                $insert->user_id = $request['user_id'];
                $insert->video_type = $Video['video_type'];
                $insert->sub_video_type = 0;
                if ($Video['video_type'] == 6) {
                    $insert->sub_video_type = 1;
                }
                $insert->video_id = $Video['id'];
                $insert->price = $Video['price'];
                $insert->transaction_id = 'admin';
                $insert->description = 'admin';
                $insert->expiry_date = $expiry_date;
                $insert->status = 1;
            } else if ($request['rent_show_id'] != "") {

                $TVShow = TVShow::where('id', $request['rent_show_id'])->first();
                if ($TVShow != null && isset($TVShow)) {

                    $rent_day = $TVShow['rent_day'];
                    $expiry_date = date('Y-m-d', strtotime($rent_day . ' days'));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('label.controller.select_right_video_or_tvshow')));
                }

                $insert = new Rent_Transction();
                $insert->unique_id = "";
                $insert->user_id = $request['user_id'];
                $insert->video_type = $TVShow['video_type'];
                $insert->sub_video_type = 0;
                if ($TVShow['video_type'] == 6) {
                    $insert->sub_video_type = 2;
                }
                $insert->video_id = $TVShow['id'];
                $insert->price = $TVShow['price'];
                $insert->transaction_id = 'admin';
                $insert->description = 'admin';
                $insert->expiry_date = $expiry_date;
                $insert->status = 1;
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.select_right_video_or_tvshow')));
            }

            if ($insert->save()) {
                return response()->json(array('status' => 200, 'success' => __('label.controller.transction_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('label.controller.transction_not_add')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function destroy($id)
    {
        try {

            Rent_Transction::where('id', $id)->delete();
            return redirect()->route('renttransaction.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
