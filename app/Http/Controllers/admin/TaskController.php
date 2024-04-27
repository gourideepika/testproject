<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\TaskModel;
use App\Models\User;
use App\Models\ActivityModel;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function task_list()
    {
        if (auth()->user()->user_role == 'admin') {
            $tasks = TaskModel::with('user')->get();
        } else {
            $tasks = TaskModel::where('user_id', auth()->user()->id)->with('user')->get();
        }   
        return view('task_list', compact('tasks'));
    }

    public function task_add()
    {
        $users = User::where('status', '1')->get();
        return view('task_add', compact('users'));
    }

    public function task_save(TaskRequest $request)
    {
        try {
            $insert = new TaskModel;

            $insert->due_date = $request->due_date;
            $insert->title = $request->title;
            $insert->priority_level = $request->priority_level;
            $insert->status = $request->status;
            if($request->has('user_id')) {
                $insert->user_id = $request->user_id;
            }
            else {
                $insert->user_id = auth()->user()->id;
            }
            $insert->description = $request->description;
           
            $run = $insert->save();
            if ($run) {
                $activity = new ActivityModel;
                $activity->user_id = $insert->user_id;
                $activity->task_id = $insert->title;
                $activity->activity = "add";
                $activity->save();

                return response()->json(['status' => 1, 'message' => 'Task added successfully']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Task not added']);
            }
        } catch (\Exception $e) {
            log::error('Error in TaskController/task_save: ' . $e->getMessage() . ' in line ' . $e->getLine());
            return response()->json(['status' => 0, 'message']);
        }
    }

    public function delete_task(Request $request) {
        $rules = [
            'id' => ['required']
        ];
        $id = $request->id;
        $run = TaskModel::where(['id'=>$id])->first();

        $activity = new ActivityModel;
        $activity->user_id = $run->user_id;
        $activity->task_id = $run->title;
        $activity->activity = "Delete";
        $activity->save();
        $run->delete();
        if($run){
            
            return response()->json(['status' => 1, 'message' => 'Task has been deleted Successfully']);
        }else{
            return response()->json(['status' => 0, 'message' => 'Somethimg went wrong']);

        }
    }

    public function task_status(Request $request) {
        $rules = [
            'id' => ['required']
        ];
        $id = $request->id;
        $run = TaskModel::where(['id'=>$id])->first();
        $run->status = $run->status == '0' ? '1' : '0';
        $data = $run->update(); 
        if($data){
            $activity = new ActivityModel;
            $activity->user_id = $run->user_id;
            $activity->task_id = $run->title;
            $activity->activity = "status change";
            $activity->save();
            return response()->json(['status' => 1, 'message' => 'Task status has been updated Successfully']);
        }else{
            return response()->json(['status' => 0, 'message' => 'Somethimg went wrong']);

        }
    }

    public function task_edit($id)
    {
        $task = TaskModel::find($id);
        $users = User::where('status', '1')->get();
        return view('task_edit', compact('task', 'users'));
    }

    public function update_task(TaskRequest $request)
    {
        try {
            $update = TaskModel::where('id',$request->id)->first();

            $update->due_date = $request->due_date;
            $update->title = $request->title;
            $update->priority_level = $request->priority_level;
            if($request->has('user_id')) {
                $update->user_id = $request->user_id;
            }
            else {
                $update->user_id = auth()->user()->id;
            }
            $update->description = $request->description;
           
            $run = $update->save();
            if ($run) {
                $activity = new ActivityModel;
                $activity->user_id = $update->user_id;
                $activity->task_id = $update->title;
                $activity->activity = "update";
                $activity->save();
                return response()->json(['status' => 1, 'message' => 'Task updated successfully']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Task not added']);
            }
        } catch (\Exception $e) {
            log::error('Error in TaskController/update_task: ' . $e->getMessage() . ' in line ' . $e->getLine());
            return response()->json(['status' => 0, 'message']);
        }
    }

    public function activity_list()
    {
        if (auth()->user()->user_role == 'admin') {
            $activity = ActivityModel::with('user')->get();
        } else {
            return response()->json(['status' => 0, 'message']);
        }   
        return view('activity_list', compact('activity'));
    }
}
