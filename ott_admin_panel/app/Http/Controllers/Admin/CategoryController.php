<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    private $folder = "category";
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
                    $data = Category::where('name', 'LIKE', "%{$input_search}%")->latest()->get();
                } else {
                    $data = Category::latest()->get();
                }

                $this->common->imageNameToUrl($data, 'image', $this->folder, 'normal');

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $edit = __('label.edit');
                        $delete = __('label.delete');
                        $category_delete = __('label.delete_category');

                        $delete = ' <form onsubmit="return confirm(\'' . $category_delete . '\');" method="POST"  action="' . route('category.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="' . $delete . '"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn edit_category" title="' . $edit . '" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-name="' . $row->name . '" data-image="' . $row->image . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->make(true);
            }
            return view('admin.category.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            if (isset($requestData['image'])) {
                $files = $requestData['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'category_');
            }

            $category_data = Category::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($category_data->id)) {
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
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();

            if (isset($requestData['image'])) {
                $files = $requestData['image'];
                $requestData['image'] = $this->common->saveImage($files, $this->folder, 'category_');

                $this->common->deleteImageToFolder($this->folder, basename($requestData['old_image']));
            }
            unset($requestData['old_image']);

            $Category_data = Category::updateOrCreate(['id' => $requestData['id']], $requestData);
            if (isset($Category_data->id)) {
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

            $data = Category::where('id', $id)->first();
            if (isset($data)) {
                $this->common->deleteImageToFolder($this->folder, $data['image']);
                $data->delete();
            }
            return redirect()->route('category.index')->with('success', __('label.controller.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
