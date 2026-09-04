<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

use Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        Log::info($request->all());
        $selectedProject = null;
        if (isset($request->project_id)) {
            $selectedProject = Project::find($request->project_id);
            $tasks = Task::where('project_id', $request->project_id)->get();
        } else {
            $tasks = Task::all();
        }
        Log::info($tasks);
        $projects = Project::all();
        return view('tasks.index', compact('tasks', 'projects', 'selectedProject'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Request $request)
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        Task::create([
            'name' => $request->name, 
            'project_id' => isset($request->project_id) ? $request->project_id : null
        ]);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        Log::info($request->all());
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $task->update([
            'name' => $request->name, 
            'project_id' => $request->project_id
        ]);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully.');
    }

     /**
     * Save a new order for the tasks
     */
    public function reorder(Request $request)
    {
        Log::info($request->all());

        foreach ($request->ids as $index => $id) {
            Task::where('id', $id)->update(['priority' => $index]);
        }

        return response()->json(['status' => 'success']);
    }


    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully.');
    }
}
