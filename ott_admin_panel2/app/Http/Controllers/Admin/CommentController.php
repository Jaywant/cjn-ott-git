<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        try {

            $params['data'] = [];
            $params['user'] = User::latest()->get();

            if ($request->ajax()) {

                $input_search = $request['input_search'];
                $input_user = $request['input_user'];
                $input_video_type = $request['input_video_type'];
                if ($input_search != null && isset($input_search)) {

                    if ($input_user != 0 && $input_video_type == 0) {
                        $data = Comment::where('comment', 'LIKE', "%{$input_search}%")->where('user_id', $input_user)->with('user')->latest()->get();
                    } else if ($input_user == 0 && $input_video_type != 0) {
                        $data = Comment::where('comment', 'LIKE', "%{$input_search}%")->where('video_type', $input_video_type)->with('user')->latest()->get();
                    } else if ($input_user != 0 && $input_video_type != 0) {
                        $data = Comment::where('comment', 'LIKE', "%{$input_search}%")->where('user_id', $input_user)->where('video_type', $input_video_type)->with('user')->latest()->get();
                    } else {
                        $data = Comment::where('comment', 'LIKE', "%{$input_search}%")->with('user')->latest()->get();
                    }
                } else {

                    if ($input_user != 0 && $input_video_type == 0) {
                        $data = Comment::where('user_id', $input_user)->with('user')->latest()->get();
                    } else if ($input_user == 0 && $input_video_type != 0) {
                        $data = Comment::where('video_type', $input_video_type)->with('user')->latest()->get();
                    } else if ($input_user != 0 && $input_video_type != 0) {
                        $data = Comment::where('user_id', $input_user)->where('video_type', $input_video_type)->with('user')->latest()->get();
                    } else {
                        $data = Comment::with('user')->latest()->get();
                    }
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        if ($row->status == 1) {
                            $showLabel = __('label.show');
                            return "<button type='button' id='$row->id' onclick='change_status($row->id, $row->status)' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>$showLabel</button>";
                        } else {
                            $hideLabel = __('label.hide');
                            return "<button type='button' id='$row->id' onclick='change_status($row->id, $row->status)' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 20px; outline: none;border-radius: 5px;cursor: pointer;'>$hideLabel</button>";
                        }
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("Y-m-d", strtotime($row->created_at));
                        return $date;
                    })
                    ->addColumn('video_name', function ($row) {
                        return Comment::getVideoName($row->video_id, $row->video_type, $row->sub_video_type);
                    })
                    ->make(true);
            }
            return view('admin.comment.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function show($id)
    {
        try {

            $data = Comment::where('id', $id)->first();
            if ($data->status == 0) {
                $data->status = 1;
            } elseif ($data->status == 1) {
                $data->status = 0;
            } else {
                $data->status = 0;
            }
            $data->save();
            return response()->json(array('status' => 200, 'success' => __('label.controller.status_changed'), 'id' => $data->id, 'Status_Code' => $data->status));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
