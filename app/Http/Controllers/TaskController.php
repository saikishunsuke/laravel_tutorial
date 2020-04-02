<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Task;

class TaskController extends Controller
{
    public function index(int $id) {
        $folders = Folder::all();
        $current_folder = Folder::find($id);
        // $tasks = Task::where('folder_id', $id)->get();
        $tasks = $current_folder->tasks()->get();
        return view("tasks/index", [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }
}
