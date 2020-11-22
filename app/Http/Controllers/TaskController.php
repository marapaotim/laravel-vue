<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
	public function index() {
		return Task::orderBy("id", "desc")->get();
	}

	public function insert(Request $request) {
        return Task::create($request->only(["name", "description"]));
    }

    public function find($id) {
    	return Task::find($id);
    }

    public function delete($id) {
    	return Task::find($id)->delete();
    }

	public function update(Request $request, $id) {
    	$task = Task::find($id);
    	$task->name = $request->name;
    	$task->description = $request->description;
    	$task->save();
        return $task;
    }
}
