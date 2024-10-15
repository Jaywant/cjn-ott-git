<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Rent_Price_List;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class RentPriceListController extends Controller
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
            if ($request->ajax()) {

                $input_search = $request['input_search'];
                if ($input_search != null && isset($input_search)) {
                    $data = Rent_Price_List::where('price', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Rent_Price_List::latest()->get();
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $price_delete = __('label.delete_price');

                        $delete = '<form onsubmit="return confirm(\'' . $price_delete . '\');" method="POST" action="' . route('rentpricelist.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn edit_price" title="' . $edit . '" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-price="' . $row->price . '" data-android_product_package="' . $row->android_product_package . '" data-ios_product_package="' . $row->ios_product_package . '" data-web_price_id="' . $row->web_price_id . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->make(true);
            }
            return view('admin.rent_price_list.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $requestData['android_product_package'] = isset($request->android_product_package) ? $request->android_product_package : "";
            $requestData['ios_product_package'] = isset($request->ios_product_package) ? $request->ios_product_package : "";
            $requestData['web_price_id'] = isset($request->web_price_id) ? $request->web_price_id : "";

            $price_data = Rent_Price_List::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($price_data->id)) {
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
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $requestData['android_product_package'] = isset($request->android_product_package) ? $request->android_product_package : "";
            $requestData['ios_product_package'] = isset($request->ios_product_package) ? $request->ios_product_package : "";
            $requestData['web_price_id'] = isset($request->web_price_id) ? $request->web_price_id : "";

            $price_data = Rent_Price_List::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($price_data->id)) {
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

            Rent_Price_List::where('id', $id)->delete();
            return redirect()->route('rentpricelist.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
