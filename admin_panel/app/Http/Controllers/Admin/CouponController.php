<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        try {
            $params['data'] = [];
            if ($request->ajax()) {

                $input_search = $request['input_search'];
                if ($input_search != null && isset($input_search)) {
                    $data = Coupon::where('name', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Coupon::latest()->get();
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $coupon_delete = __('label.delete_coupon');

                        $delete = '<form onsubmit="return confirm(\'' . $coupon_delete . '\');" method="POST"  action="' . route('coupon.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn edit_coupon" title="' . $edit . '" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-name="' . $row->name . '" data-start_date="' . $row->start_date . '" data-end_date="' . $row->end_date . '" data-amount_type="' . $row->amount_type . '" data-price="' . $row->price . '" data-is_use="' . $row->is_use . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->make(true);
            }
            return view('admin.coupon.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            if ($request['amount_type'] == 1) {
                $validator1 = Validator::make($request->all(), [
                    'price' => 'required',
                ]);
            } elseif ($request['amount_type'] == 2) {
                $validator1 = Validator::make($request->all(), [
                    'price' => 'required|numeric|max:100',
                ]);
            }
            if ($validator1->fails()) {
                $errs1 = $validator1->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs1));
            }

            $requestData = $request->all();
            $requestData['unique_id'] = Str::random(6);

            $coupon_data = Coupon::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($coupon_data->id)) {
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
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }
            if ($request['amount_type'] == 1) {
                $validator1 = Validator::make($request->all(), [
                    'price' => 'required',
                ]);
            } elseif ($request['amount_type'] == 2) {
                $validator1 = Validator::make($request->all(), [
                    'price' => 'required|numeric|max:100',
                ]);
            }
            if ($validator1->fails()) {
                $errs1 = $validator1->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs1));
            }

            $requestData = $request->all();

            $coupon_data = Coupon::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($coupon_data->id)) {
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

            $data = Coupon::where('id', $id)->first();
            if (isset($data)) {
                $data->delete();
            }
            return redirect()->route('coupon.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
