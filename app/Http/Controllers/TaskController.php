<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;
use App\Folder;
use App\Task;

class TaskController extends Controller
{
    public function index(Folder $folder) {
        // $folders = Folder::all();
        $folders = Auth::user() ->folders()->get();
        // $current_folder = Folder::find($id);
        // $tasks = Task::where('folder_id', $id)->get();
        $tasks = $folder->tasks()->get();
        return view("tasks/index", [
            'folders' => $folders,
            'current_folder' => $folder,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(Folder $folder) {
        return view('tasks.create', [
            'folder' => $folder,
        ]);
    }

    public function create(Folder $folder, CreateTask $request) {
        // $current_folder = Folder::find($id);
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);
        return redirect()->route('tasks.index', [
            'folder'=>$folder,
        ]);
    }

    public function showEditForm(Folder $folder, Task $task) {
        // $task = Task::find($task_id);
        return view('tasks.edit', [
            'folder'=>$folder,
            'task'=>$task,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request) {
        // $current_folder = Folder::find($id);
        // $task = Task::find($task_id);
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->save();

        return redirect()->route('tasks.index', [
            'folder' => $folder,
        ]);
    }
}
