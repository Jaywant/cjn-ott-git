<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Package;
use App\Models\Package_Detail;
use Illuminate\Support\Facades\Validator;
use Exception;

class PackageController extends Controller
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
                    $data = Package::where('name', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Package::latest()->get();
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $package_delete = __('label.delete_package');

                        $delete = ' <form onsubmit="return confirm(\'' . $package_delete . '\');" method="POST"  action="' . route('package.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around" title="' . $edit . '">';
                        $btn .= '<a href="' . route('package.edit', [$row->id]) . '" class="edit-delete-btn">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.package.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function create()
    {
        try {
            $params['data'] = [];
            return view('admin.package.add', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'price' => 'required',
                'type' => 'required',
                'time' => 'required',
                'watch_on_laptop_tv' => 'required',
                'ads_free_content' => 'required',
                'no_of_device_sync' => 'required|numeric|min:1',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $requestData['android_product_package'] = isset($request->android_product_package) ? $request->android_product_package : "";
            $requestData['ios_product_package'] = isset($request->ios_product_package) ? $request->ios_product_package : "";
            $requestData['web_product_package'] = isset($request->web_product_package) ? $request->web_product_package : "";

            $package_data = Package::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($package_data->id)) {

                $this->package_detail($package_data->id);
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
            $params['data'] = Package::where('id', $id)->first();
            if ($params['data'] != null) {
                return view('admin.package.edit', $params);
            } else {
                return redirect()->back()->with('error', __('label.controller.page_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'price' => 'required',
                'type' => 'required',
                'time' => 'required',
                'watch_on_laptop_tv' => 'required',
                'ads_free_content' => 'required',
                'no_of_device_sync' => 'required|numeric|min:1',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $requestData['android_product_package'] = isset($request->android_product_package) ? $request->android_product_package : "";
            $requestData['ios_product_package'] = isset($request->ios_product_package) ? $request->ios_product_package : "";
            $requestData['web_product_package'] = isset($request->web_product_package) ? $request->web_product_package : "";

            $package_data = Package::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($package_data->id)) {

                $this->package_detail($package_data->id);
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

            $data = Package::where('id', $id)->first();
            if (isset($data)) {
                $data->delete();
                Package_Detail::where('package_id', $data->id)->delete();
            }

            return redirect()->route('package.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function package_detail($Pid)
    {
        Package_Detail::where('package_id', $Pid)->delete();

        $Pdata = Package::where('id', $Pid)->first();

        $watch = "Use only on Mobile";
        $ads = "Ads On All Content";
        $devic_sync = "Watch on " . $Pdata['no_of_device_sync'] . " device";
        if ($Pdata['watch_on_laptop_tv'] == 1) {
            $watch = "Watch on Mobile & TV";
        }
        if ($Pdata['ads_free_content'] == 1) {
            $ads = "Ads Free All Content";
        }

        Package_Detail::insert([
            ['package_id' => $Pdata['id'], 'package_key' => $devic_sync, 'package_value' => $Pdata['no_of_device_sync']],
            ['package_id' => $Pdata['id'], 'package_key' => $watch, 'package_value' => $Pdata['watch_on_laptop_tv']],
            ['package_id' => $Pdata['id'], 'package_key' => $ads, 'package_value' => $Pdata['ads_free_content']],
        ]);
        return true;
    }
}
