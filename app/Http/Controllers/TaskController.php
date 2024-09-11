<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $this->taskService->createTask($request->all());
        return redirect()->route('tasks.index');
    }

    public function show($id)
    {
        $task = $this->taskService->getTask($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = $this->taskService->getTask($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $this->taskService->updateTask($id, $request->all());
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return redirect()->route('tasks.index');
    }
}
