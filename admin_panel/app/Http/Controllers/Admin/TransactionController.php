<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Common;
use App\Models\Package;
use App\Models\Transction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TransactionController extends Controller
{
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {

            // Package Expiry
            $this->common->package_expiry();

            $params['data'] = [];
            $params['package'] = Package::latest()->get();
            if ($request->ajax()) {

                $input_type = $request['input_type'];
                $input_package = $request['input_package'];
                $input_search = $request['input_search'];
                if ($input_package != 0) {
                    if ($input_type == "today") {

                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('package', 'user')->where('package_id', $input_package)
                                ->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->where('package_id', $input_package)->whereDay('created_at', date('d'))
                                ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else if ($input_type == "month") {

                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->where('package_id', $input_package)->with('package', 'user')
                                ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->where('package_id', $input_package)->whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else if ($input_type == "year") {

                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->where('package_id', $input_package)->with('package', 'user')
                                ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->where('package_id', $input_package)
                                ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else {

                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->where('package_id', $input_package)->with('package', 'user')->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->where('package_id', $input_package)->orderBy('status', 'desc')->latest()->get();
                        }
                    }
                } else {
                    if ($input_type == "today") {
                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('package', 'user')->whereDay('created_at', date('d'))
                                ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else if ($input_type == "month") {
                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('package', 'user')->whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else if ($input_type == "year") {
                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('package', 'user')->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->whereYear('created_at', date('Y'))->orderBy('status', 'desc')->latest()->get();
                        }
                    } else {
                        if ($input_search != null && isset($input_search)) {
                            $data = Transction::where('transaction_id', 'LIKE', "%{$input_search}%")->with('package', 'user')->orderBy('status', 'desc')->latest()->get();
                        } else {
                            $data = Transction::with('package', 'user')->orderBy('status', 'desc')->latest()->get();
                        }
                    }
                }

                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['date'] = date("Y-m-d", strtotime($data[$i]['created_at']));
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $delete = __('label.delete');
                        $transaction_delete = __('label.delete_transaction');

                        $delete = '<form onsubmit="return confirm(\'' . $transaction_delete . '\');" method="POST"  action="' . route('transaction.destroy', [$row->id]) . '">
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
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('admin.transaction.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create(Request $request)
    {
        try {
            $params['data'] = [];
            $params['user'] = User::where('id', $request->user_id)->first();
            $params['package'] = Package::get();

            return view('admin.transaction.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function searchUser(Request $request)
    {
        try {
            $name = $request->name;
            $user = User::orWhere('full_name', 'like', '%' . $name . '%')->orWhere('mobile_number', 'like', '%' . $name . '%')->orWhere('email', 'like', '%' . $name . '%')->latest()->get();

            $url = url('admin/transaction/create?user_id');
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
                'package_id' => 'required'
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $package = Package::where('id', $request->package_id)->first();
            $expiry_date = date('Y-m-d', strtotime('+' . $package->time . ' ' . strtolower($package->type)));

            $Transction = new Transction();
            $Transction->unique_id = "";
            $Transction->user_id = $request->user_id;
            $Transction->package_id = $request->package_id;
            $Transction->transaction_id = 'admin';
            $Transction->price = $package->price;
            $Transction->description = 'admin';
            $Transction->expiry_date = $expiry_date;
            $Transction->status = 1;

            if ($Transction->save()) {
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

            Transction::where('id', $id)->delete();
            return redirect()->route('transaction.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
